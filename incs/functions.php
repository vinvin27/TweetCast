<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

include_once(dirname(__FILE__).'/TwitterOAuth/TwitterOAuth.php');
include_once(dirname(__FILE__).'/tw-api.php');



/**
*
* Traitement de la fonction ajax POST :
* 
*   @param : action
*   @param : hastag
* 
*/



if(isValidParam($_POST['action'])){
	
	$_action = $_POST['action'];
	switch($_action){
		
		case 'getUrlByHashtag' :
		
			$count = (isset($_POST['count']) && !empty($_POST['count'])?$_POST['count']:5);
			error_log('count > ' . $count);
			$response = getInfoByHashtag($_POST['hashtag'],$count, 'getUrl');
			error_log(json_encode(array('result'=>$response)));
			ajaxResponse(array('result'=>$response));
			
			break;
			
			
		case 'getPixByHashtag' :
		
			$count = (isset($_POST['count']) && !empty($_POST['count'])?$_POST['count']:5);
			error_log('count > ' . $count);
			$response = getInfoByHashtag($_POST['hashtag'],$count, 'getPix');
			error_log(json_encode(array('result'=>$response)));
			ajaxResponse(array('result'=>$response));
			
			break;
		
	}	
		
	
}
// No action
else{
	ajaxResponse('No action - ajax request -');
}








// Function traitement du hashtag :
function getInfoByHashtag($hashtag,$count, $type="getUrl", $response = array(), $first=-1){
	
	$stop = -1;
	if($first==-1){
			$first = $count;
	}
	
	$size_response = count($response);
	if($size_response == $first){
		return $response;
	}else{
		
		$twParam = array(
			'hashtags' => $hashtag,
			'count' => $count
		);
		
		$arr = getTwByHash($twParam,$type);
		$merge_array = array_merge($response,$arr);
		$_count = ($count-count($arr));
		return getInfoByHashtag($hashtag,$_count,$type,$merge_array,$first);
		
	}
}


function ajaxResponse($msg){
	echo json_encode(($msg));
	exit(0);
}

// Valid GET/POST param
function isValidParam($p){
	if(isset($p) && !empty($p)){ return true; }
	return false;
}
