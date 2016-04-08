<?php

function makeFileNameForUpload($filename='',$removeArr=array('@','~','!','#','$','%','^','&','(',')','+','{','}','[',']','<','>','?','/')){
	$filename	=	str_replace("\\","",trim($filename));
	for($i=0;$i<count($removeArr);$i++) {
		$filename	=	str_replace($removeArr[$i],"",trim($filename));	
	}		
	$filename	=	str_replace("","_",trim($filename));
	$filename	=	str_replace(" ","_",trim($filename));	
	return 	$filename;	
}

function frontpath($filename='') {
	if($filename!='') {
		return ROOT_PATH.$filename;
	}
}

function getImage($imgNameWithPath,$height=80,$width=80) {

    if(trim($imgNameWithPath)!='') {
	    // if(file_exists($imgNameWithPath)) {			  
	 	   return frontpath('frontend_include/classes/timthumb.php'.'?src='.frontpath($imgNameWithPath).'&h='.$height.'&w='.$width.'&zc=1');
	    // } else {
	 	    // return frontpath(CLASSES_DIRECTORY.FILENAME_TIMTHUMB.'?src='.frontpath(IMAGES_DIRECTORY.'userSampleImage.png').'&h='.$height.'&w='.$width.'&zc=1');
	    // }	   	
    }
}

function get_current_date() {
	return gmdate('Y-m-d H:i:s');
}

?>