<?php
	//---------- Retweet Code -------------
	ini_set('display_errors', 1);
	require_once('TwitterAPIExchange.php');
	require_once('tokens.php');
	 $tweetID =  $_POST['tweetID']; 
	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	$settings = array(
		    'oauth_access_token' => $oauth_access_token,
		    'oauth_access_token_secret' => $oauth_access_token_secret,
		    'consumer_key' => $consumer_key,
		    'consumer_secret' => $consumer_secret
		);
	$twitter = new TwitterAPIExchange($settings);
	$url = 'https://api.twitter.com/1.1/statuses/retweet/'.$tweetID.'.json'; 
	$requestMethod = 'POST';
	$postfields = array(
	    'status' => 'test Retweet' ); 
	$response = $twitter->buildOauth($url, $requestMethod)
	             ->setPostfields($postfields)
	             ->performRequest();
	$response = json_decode($response, true);
	if(isset($response['errors'])){
		echo $response['errors'][0]['message'];
	}
	else{
		echo "Retweeted Successfully";
		
	}
             
?>