<?php
	session_start();
	echo '<div class="modal-dialog">
		<div class="modal-content">

      		<div class="modal-header background-color-blue">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
        		<span class="modalTitle">Update Password</span>
      		</div>

	      	<div class="modal-body testing">';
			if (isset($_SESSION['userID'])){
				echo '<label>Password</label>
					<br><input type="password" class="form-control" id="updatePassword" required placeholder="Enter password">
					<span id="passwordUpdateMessage"></span>
				</div>
		      	<div class="modal-footer testing">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        	<button class="btn btn-primary" onclick="updatePassword()">Update password</button>
		      	</div>';
			} else {
				echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
	                <p>YOU MUST BE LOGGED IN TO UPDATE YOUR PASSWORD</p>
	            </div>
	            </div>
		      	<div class="modal-footer testing">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      	</div>';
			}
		echo '</div>
	</div>';
?>