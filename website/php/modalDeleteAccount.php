<?php
	session_start();
	echo '<div class="modal-dialog">
		<div class="modal-content">

      		<div class="modal-header background-color-blue">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
        		<span class="modalTitle">Delete Account</span>
      		</div>

	      	<div id="deleteAccountMessage" class="modal-body testing">';
			if (isset($_SESSION['userID'])){
				echo '<p><b>WARNING: Are you sure you want to delete your account?</b></p>
				<p>Your account and all of your listings will be removed.</p>
				This can not be undone.<br>
				</div>
		      	<div class="modal-footer testing">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		        	<button class="btn btn-primary" onclick="deleteAccount()">Yes delete my account</button>
		      	</div>';
			} else {
				echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
	                <p>YOU MUST BE LOGGED IN TO DELETE YOUR ACCOUNT</p>
	            </div>
				</div>
		      	<div class="modal-footer testing">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      	</div>';
			}
		echo '</div>
	</div>';
?>