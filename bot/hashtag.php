<?php
   //---------------- Hashtag Search COde
	require_once('TwitterAPIExchange.php');
	require_once('tokens.php');
	$textHashTag =  $_POST['textHashTag']; 
	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	$settings = array(
		    'oauth_access_token' => $oauth_access_token,
		    'oauth_access_token_secret' => $oauth_access_token_secret,
		    'consumer_key' => $consumer_key,
		    'consumer_secret' => $consumer_secret
		);

	$twitter = new TwitterAPIExchange($settings);
	$url = 'https://api.twitter.com/1.1/search/tweets.json';
	$requestMethod = 'GET';
	$getfield = '?q='.$textHashTag.'&result_type=recent';
	$response = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
	if(isset($response['errors'])){
		echo $response['errors'][0]['message'];
	}
	else{
		$output=""; 
		$response = json_decode($response, true);
    foreach($response["statuses"] as $user){
    	$created_at = $user['created_at'];
	    $thumb = $user["user"]['profile_image_url'];
        $id_str = $user["user"]['id_str'];   
        $text = $user['text'];
        $hashtags ="b";// $user['entities']['hashtags'];
        $User_screen_name = $user["user"]['screen_name'];
        $User_name =$user["user"]['name'];
    	$output =$output. 
    				"<div class='box1'>
   				 <h3>".$User_screen_name."</h3>
    				<span  >".$User_name."-". $created_at. 
			   "<div class='view'>
					<img src='".$thumb."'>
				</div>
				<div class='data'>
				    <h1>.$text.</h1>
				    <br/>
				    
				</div>
			<div class='clear'></div>
		</div>";
		}
		echo $output;
    }         
?>