<?php
	include("config.php");
	$defaultLocation = "../img/default.png";

	$stmtItem = $db->prepare("SELECT item.image FROM item WHERE item.itemID = ?");
    $stmtItem->execute(array(intval($_GET['id'])));
    $DBimage = $stmtItem->fetch(PDO::FETCH_ASSOC);
    if ($DBimage['image'] == NULL){
    	$imageLocation = $defaultLocation;
    } else {
    	$imageLocation = "../uploads/".$DBimage['image'];
    	if (!file_exists($imageLocation)) {
    		$imageLocation = $defaultLocation;
    		$stmt = $db->prepare("UPDATE item SET image = ? WHERE itemID = ?");
			$stmt->execute(array(NULL, $_GET['id']));
    	}
    }
	header('Content-Type: image/png');

	function setTransparency($new_image,$image_source) { 
        $transparencyIndex = imagecolortransparent($image_source); 
        $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255); 
         
        if ($transparencyIndex >= 0) { 
            $transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);    
        } 
        
        $transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']); 
        imagefill($new_image, 0, 0, $transparencyIndex); 
        imagecolortransparent($new_image, $transparencyIndex); 
    }

	$resizedWidth = 120;
	$resizedHeight = 110;
	$image_source = imagecreatefrompng($imageLocation); 
	$resizedImage = imagecreatetruecolor($resizedWidth, $resizedHeight); 
	setTransparency($resizedImage,$image_source); 
	list($old_width, $old_height) = array(imagesx($image_source), imagesy($image_source));
	imagecopyresampled($resizedImage, $image_source, 0, 0, 0, 0, $resizedWidth, $resizedHeight, $old_width, $old_height);
	imagepng($resizedImage);
	imagedestroy($resizedImage);
?>