<?php
	include("config.php");

	foreach($db->query('SELECT emailqueue.*, item.name, item.description, item.FKTagID, item.itemID FROM emailqueue LEFT JOIN item ON item.itemID = emailqueue.itemNumber') as $notification) {
		if ($notification['emailType'] == "1") {
			$stmt = $db->prepare("SELECT client.clientFirstName, client.clientLastName, client.email FROM client LEFT JOIN notification ON notification.FKClient = client.clientID WHERE notification.FKTag = ?");
			$stmt->execute(array($notification['FKTagID']));
		} elseif ($notification['emailType'] == "2") {

		} elseif ($notification['emailType'] == "3") {

		}
		
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $email) {
			$headers  = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		    $to = $email['email'];
		    $subject = "New Connect Me Ballarat Notification: ".$notification['name'];
		    $message = "<p>Hi ".$email['clientFirstName']." ".$email['clientLastName'].", you've got a new notification from ".'<a href="https://peterbillett.com">Connect Me Ballarat</a>!</p><h1>'.$notification['name']."</h1>";
		    if ($notification['emailType'] == "1") {
		    	$message .= "<p>".$notification['description'].'</p><p><a href="https://peterbillett.com?item='.$notification['itemID'].'">View item on the website</a></p><br>To unsubscribe from these notifications please <a href="https://peterbillett.com">click here</a> to go to your profile and turn them off.';
		    } elseif ($notification['emailType'] == "2") {

			} elseif ($notification['emailType'] == "3") {

			}
		    mail($to,$subject,$message,$headers);
		}

		$stmt = $db->prepare("DELETE FROM emailqueue WHERE emailID=:id");
        $stmt->bindValue(':id', $notification['emailID'], PDO::PARAM_STR);
        $stmt->execute();
	}
?>