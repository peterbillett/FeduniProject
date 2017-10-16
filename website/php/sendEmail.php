<?php
	ini_set('max_execution_time', 0); //Make sure there is enought time to send all emails
	include("config.php");
	session_start();

	//The select and delete statements must be executed at the same time to prevent possible duplication
	$db->beginTransaction();
	//Get all emails to send then remove them from the database
	$emailNotidications = $db->query('SELECT * FROM emailqueue');
	$db->exec('DELETE FROM emailqueue');
	$db->commit();
	//For each email
	foreach($emailNotidications as $notification) {
		//If it is an item notification email then
		if ($notification['emailType'] == "1") {

			//Get the name, descruotuib and tag for the item
			$stmt = $db->prepare('SELECT name, description, FKTagID FROm item WHERE itemID = ?');
			$stmt->execute(array($notification['referenceNum']));
			$itemInfo = $stmt->fetch(PDO::FETCH_ASSOC);

			//Get all the clients (ids and emails) that have notifications set for that items tag
			$stmt = $db->prepare("SELECT email, clientID FROM client LEFT JOIN notification ON notification.FKClient = client.clientID WHERE notification.FKTag = ?");
			$stmt->execute(array($itemInfo['FKTagID']));
			$emailInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

			//Add each client to the email list (will be used to bcc them all on one email)
			$emailList = "";
			foreach ($emailInfo as $emailAddress) {
				if ($_SESSION['userID'] != $emailAddress['clientID']) {
					$emailList = $emailList.$emailAddress['email'].',';
				}
			}

			//If there is at least one person to send the email to
			if ($emailList != ""){
				$headers  = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				//Bcc the clients so they don't see each others emails
			    $headers .= "Bcc: ".$emailList."\r\n";
			    //Set the sender name to appear in the email
			    $headers .= "From: Connect Me Ballarat\r\n";
			    //Set the subject
			    $subject = "New Connect Me Ballarat Notification: ".$itemInfo['name'];
			    //Set the message (link and details for item)
			    $message = "<p>Hi, you've got a new notification from ".'<a href="https://peterbillett.com">Connect Me Ballarat</a>!</p><h1>'.$itemInfo['name']."</h1>";
			    $message .= "<p>".$itemInfo['description'].'</p><p><a href="https://peterbillett.com?item='.$notification['referenceNum'].'">View item on the website</a></p><br>To unsubscribe from these notifications please <a href="https://peterbillett.com">click here</a> to go to your profile and turn them off.';
			    //Send email
			    mail(null,$subject,$message,$headers);
			}
		} elseif ($notification['emailType'] == "2") { //If the email is an account unlock email
			//Select the email and account unlock key for the client
			$stmt = $db->prepare("SELECT email, accountType FROM client WHERE clientID = ?");
			$stmt->execute(array($notification['referenceNum']));
			$accoutnInfo = $stmt->fetch(PDO::FETCH_ASSOC);
			//Create the email
			$headers  = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			//Set the sender name to appear in the email
		    $headers .= "From: Connect Me Ballarat\r\n";
		    //Set the subject
		    $subject = "Confirm your Connect Me Ballarat Account";
		    //Set the message (message and link to unlock account)
		    $message = '<p>Hi, an account has been created for <a href="https://peterbillett.com">Connect Me Ballarat</a> using this email address.';
		    $message .= '<p>If this was you then please <a href="https://peterbillett.com?confirm='.$accoutnInfo['accountType'].'">click this</a> to confirm your email.</p><p>Otherwise ignore this email.</p><br>Thank you.<br>Connect Me Ballarat.';
		    //Send email
		    mail($accoutnInfo['email'],$subject,$message,$headers);
		}
	}
?>