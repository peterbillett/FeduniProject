<?php
	include("config.php");
	session_start();
	if(isset($_SESSION['userID'])){
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
			$stmt = $db->prepare("SELECT itemID FROM item WHERE FKclient=? AND itemID=?");
		   	$stmt->execute(array($_SESSION['userID'], $_GET['id']));
		   	if($stmt->rowCount() == 0) {
		   		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
			        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			        	<span aria-hidden="true">×</span>
			        </button>
			        <p>You cannot upload files for someone elses item.</p>
			        <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
			    </div>';
		   	} else {
			   	$fileType = pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
				$fileName = $_GET['id'].".png";
				$saveToHere = "../uploads/".$fileName;

			    if (($img_info = getimagesize($_FILES["fileToUpload"]["tmp_name"])) === false) {
		        	echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
				        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				        	<span aria-hidden="true">×</span>
				        </button>
				        <p>File is not an image.</p>
				        <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
				    </div>';
				} else {
					switch ($img_info[2]) {
					  	case IMAGETYPE_JPEG :
					  		if (ImagePNG(imagecreatefromstring(file_get_contents($_FILES["fileToUpload"]["tmp_name"])),$saveToHere, 9)){
								$stmt = $db->prepare("UPDATE item SET image = ? WHERE itemID = ?");
					      		$stmt->execute(array($fileName, $_GET['id']));
							    echo "SUCCESS";
							} else {
								echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
					         		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					            		<span aria-hidden="true">×</span>
					         		</button>
					            	<p>Sorry, there was an error uploading your file.</p>
					            	<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
					      		</div>';
							}
							break;
					  	case IMAGETYPE_PNG : 
					  		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $saveToHere)){
								$stmt = $db->prepare("UPDATE item SET image = ? WHERE itemID = ?");
					      		$stmt->execute(array($fileName, $_GET['id']));
							    echo "SUCCESS";
							} else {
								echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
					         		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					            		<span aria-hidden="true">×</span>
					         		</button>
					            	<p>Sorry, there was an error uploading your file.</p>
					            	<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
					      		</div>';
							}
							break;
					  	default : 
					  		exit ('<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
				         		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				            		<span aria-hidden="true">×</span>
				         		</button>
				            	<p>Sorry, only JPG, JPEG & PNG files are allowed.</p>
				            	<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
				      		</div>');
					}
				}
		   	}
		} else {
			echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
	     		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	        		<span aria-hidden="true">×</span>
	     		</button>
	        	<p>No file was received.</p>
	        	<p>Please select the file again then resubmit</p>
	        	<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
	  		</div>';
		}
	} else {
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
     		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        		<span aria-hidden="true">×</span>
     		</button>
        	<p>You must be logged in to upload files.</p>
        	<p>Please refresh the page</p>
        	<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
  		</div>';
	}
?>