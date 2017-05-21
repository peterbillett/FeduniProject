<?php
	// Connects to the database
	include("config.php");
   
	// Starts the session
	session_start();

	if(isset($_SESSION['userID']))
	{
		$stmt = $db -> prepare ('UPDATE client SET FKgroup=? WHERE clientID=?');
		$stmt -> execute (array($_POST['groupID'], $_SESSION['userID']));
		
		if($stmt -> rowCount() == 0)
		{
			// Notify the user of the failure and redirect them to the Join a Volunteer Group page
			echo ("<SCRIPT LANGUAGE='JavaScript'>
					window.alert('Failed to link user with selected volunteer group')
					window.location.href='../joinVolOrg.html';
					</SCRIPT>");
		}
		else
		{
			// Notify the user of the success and redicts them to the Home page
			echo ("<SCRIPT LANGUAGE='JavaScript'>
					window.alert('You have successfully joined a volunteer group')
					window.location.href='../index.html';
					</SCRIPT>");
		}
	}
	else
	{
		// Notify the user of the success and redicts them to the Create Account page
		echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('You must be logged in to join a Volunteer Group')
				window.location.href='../createAccountLogin.html';
				</SCRIPT>");
	}
?>
