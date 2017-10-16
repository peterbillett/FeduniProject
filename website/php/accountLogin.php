<?php
   include("config.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST['email'];
      $password = $_POST['password'];

      //Get the users information with the matching email. If there is no matching email report that either the email or password was incorrect
      $stmt = $db->prepare("SELECT clientID, accountType, clientPassword FROM client WHERE email=?");
      $stmt->execute(array($email));
      if($stmt->rowCount() == 1) {
         //Check if the account type has been unlocked (verified upon creation via the account confirmation email)
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         if (substr($result['accountType'], 0,1) == "A") {
            echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">×</span>
                  </button>
                     <p>This account has not yet been confirmed.</p>
                     <h4>Please check your email for the confirmation email.</h4>
                     <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
               </div>';
         } else if (substr($result['accountType'], 0,1) == "L") {
            echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">×</span>
                  </button>
                     <h4>This account has been locked by the system admin.</h4>
                     <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
               </div>';
         } else { //If the account is not locked then check if the password matches
            if (password_verify($password, $result['clientPassword'])) {
               //If it matches then set the sessions, update the last seen and return success
               $_SESSION['userID'] = $result['clientID'];
               $_SESSION['accountType'] = $result['accountType'];
               $stmt = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
               $stmt->execute(array($result['clientID']));
               echo "success";
            } else {
               echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">×</span>
                  </button>
                     <p>Opps! The email or password was incorrect.</p>
                     <h4>Please check your details then try again.</h4>
                     <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
               </div>';
            }
         }
      }else {
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>Opps! The email or password was incorrect.</p>
               <h4>Please check your details then try again.</h4>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      }
   }
   
?>