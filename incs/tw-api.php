<?php

require_once __DIR__ . '/TwitterOAuth/TwitterOAuth.php';
require_once __DIR__ . '/TwitterOAuth/Exception/TwitterException.php';


use TwitterOAuth\TwitterOAuth;

date_default_timezone_set('UTC');

/**
	 * Array with the OAuth tokens provided by Twitter when you create application
	 *
	 * output_format - Optional - Values: text|json|array|object - Default: object
	 */
	$config = array(
		'consumer_key' => 'QuIHodZgcJ5cWmbXTk9zw',
		'consumer_secret' => 'qeVB8Q08cgoKa06SQma1rhWoMC3bgJ91wFkPXxTyGg',
		'oauth_token' => '224993836-pL0dbXUMSw8PCGWmLt8IEvQ1tnc1JjBESIgNofPK',
		'oauth_token_secret' => 'u5evTQniS91zijRomeT5B1X3KZx6uCZP6PSG9DH0KuE',
		'output_format' => 'array'
	);


/**
 * Instantiate TwitterOAuth class with set tokens
 */
 
function getTwByHash(array $twReq, $type="getUrl"){
	
	global $config;
	
	$tw = new TwitterOAuth($config);
	
	$hash = $twReq['hashtag'];
	$count = $twReq['count'];
	$isGeol = $twReq['isGeoloc'];
	
	$params = array(
		'q' => $hash,
		'count' => $count
	);

	/**
	 * Send a GET call with set parameters
	 */
	$response = $tw->get('search/tweets', $params);

	$filtered = filter_tweets($response['statuses'], $type);

	//debug($filtered,true);
//	error_log(count($fil
	return $filtered;

}
function debug($debug, $hidden=false){
	echo '<pre '.($hidden?'style="display:none":':'').'>';
	print_r($debug);
	echo '</pre>'	;
}
function filter_tweets($array, $type="getUrl"){

	$txt_tweets = array();
	$i=0;

	if ( $type=="getUrl" )
	{
		foreach($array as $element){
		//debug($element);
			if(!empty($element['entities']['urls'])){
				$txt_tweets[$i]['txt'] = $element['text'];
				$txt_tweets[$i]['favoris'] = $element['favorite_count'];
				$txt_tweets[$i]['retweet'] = $element['retweet_count'];
				$txt_tweets[$i]['urls'] = $element['entities']['urls'];
				++$i;
			}
		}
	}
	else if ( $type=="getPix" )
	{
		foreach($array as $element){
		//debug($element);
			if( !empty($element['entities']['urls'])){
				if(strpos($element['entities']['urls'][0]["url"], addcslashes('pic.twitter.com')) !== FALSE)
				{	
					$txt_tweets[$i]['txt'] = $element['text'];
					$txt_tweets[$i]['favoris'] = $element['favorite_count'];
					$txt_tweets[$i]['retweet'] = $element['retweet_count'];	
					$txt_tweets[$i]['urls'] = $element['entities']['urls'];
				}
			}
			
			++$i;
		
		}
	}
	
	return $txt_tweets;
}
function filter_tweets_pix($array){

	$txt_tweets = array();
	$i=0;
	foreach($array as $element){
		//debug($element);
			$txt_tweets[$i]['txt'] = $element['text'];
			$txt_tweets[$i]['favoris'] = $element['favorite_count'];
			$txt_tweets[$i]['retweet'] = $element['retweet_count'];
			$txt_tweets[$i]['urls'] = $element['entities']['urls'];
			++$i;
		
	}
	return $txt_tweets;
}
