<?php
		error_reporting(E_ERROR | E_PARSE);
		require_once('TwitterAPIExchange.php');
		require_once('tokens.php');
		/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
		$settings = array(
		    'oauth_access_token' => $oauth_access_token,
		    'oauth_access_token_secret' => $oauth_access_token_secret,
		    'consumer_key' => $consumer_key,
		    'consumer_secret' => $consumer_secret
		);
		$twitter = new TwitterAPIExchange($settings);
		//"--------------------- Time Line tweets ---------------------";
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield = '?screen_name=AnkitGoyal1410';
		$requestMethod = 'GET';
		$response_timeLine = $twitter->setGetfield($getfield)
		    ->buildOauth($url, $requestMethod)
		    ->performRequest();
		    $response_timeLine = json_decode($response_timeLine, true);
		   
	   //"\n ---------------searching followings list-------------------";
		$url = 'https://api.twitter.com/1.1/friends/list.json';
		$getfield = '?screen_name=AnkitGoyal1410';
		$requestMethod = 'GET';
		$response_Freinds_Count = $twitter->setGetfield($getfield)
		    ->buildOauth($url, $requestMethod)
		    ->performRequest();
		 $response_Freinds_Count = json_decode($response_Freinds_Count, true);  
		
		//--------- Tweets from those whom you are following -------------- 
		$getfield = '?screen_name=';
		foreach($response_Freinds_Count["users"] as $user){
			$getfield = $getfield.",".$user['screen_name'];
		}  
		$url = 'https://api.twitter.com/1.1/users/lookup.json';
		$requestMethod = 'GET';
		$response_Freinds_Tweet = $twitter->setGetfield($getfield)
		    ->buildOauth($url, $requestMethod)
		    ->performRequest();
		 $response_Freinds_Tweet = json_decode($response_Freinds_Tweet, true);
		
		// ---------------- User Information ------------------------
		$url = 'https://api.twitter.com/1.1/users/show.json';
		$getfield = '?screen_name=AnkitGoyal1410';
		$requestMethod = 'GET';
		$userInformation = $twitter->setGetfield($getfield)
		    ->buildOauth($url, $requestMethod)
		    ->performRequest();
		 $userInformation = json_decode($userInformation, true);
?>
<!DOCTYPE HTML>

	<head>
		<title>Twitter Bot</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
		<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
		<!-- light-box -->
			<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
			<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>	
			<script type="text/javascript" src="js/jquery.fancybox.js"></script>
			<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
		     <script type="text/javascript">
				$(document).ready(function() {

					$('.fancybox').fancybox();

				});
			</script>
<!---- End Light-box ------>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
			<script>
		  	 $(document).ready(function(){
			    $(".btnRetweet").click(function(){
			    	var val1 = $(this).val();
			        $.ajax({
			                    type: "POST",
			                    url: "Retweet.php",
			                    data: {
			                        tweetID:  val1
			                    }
			                })
			                .done(function (msg) {
			                    $('#div'+val1).html(msg);
			                });
			    });
			    
			    $(".btnReply").click(function(){
			    	var val1 = $(this).val();
			    	var textTweet = $('#textReplyTweet'+val1).val();
			    	var textReplyUsernameTweet = $('#textReplyUsernameTweet'+val1).val();
			    	if(textTweet=="" || textTweet==null){
						alert("Enter Message!");
						return(false);
					}
			        $.ajax({
			                    type: "POST",
			                    url: "Reply.php",
			                    data: {
			                        tweetID:  val1,
			                        textTweet:  textTweet,
			                        textReplyUsernameTweet: textReplyUsernameTweet
			                    }
			                })
			                .done(function (msg) {
			                    $('#div'+val1).html(msg);
			                });
			    });
			    
			    $("#Tweet").click(function(){
			    	var textTweet = $('#textTweet').val();
			        $.ajax({
			                    type: "POST",
			                    url: "PostTweet.php",
			                    data: {
			                        textTweet:  textTweet
			                    }
			                })
			                .done(function (msg) {
			                    $('#TweetPostResult').html(msg);
			                });
			    });
			    
			        $("#send").click(function(){
			    	var textDirectMessage = $('#textDirectMessage').val();
			    	var ReceiverDirectMessage=$('#ReceiverDirectMessage').val();
			        $.ajax({
			                    type: "POST",
			                    url: "DirectMessage.php",
			                    data: {
			                        textDirectMessage:  textDirectMessage,
			                        ReceiverDirectMessage: ReceiverDirectMessage
			                    }
			                })
			                .done(function (msg) {
			                    $('#DirectMessageResult').html(msg);
			                });
			    });
			    
			    $("#Search").click(function(){
			    	var textHashTag = $('#textHashTag').val();
			    	if(textHashTag=="" || textHashTag==null){
						alert("Enter Hashtag!");
						return(false);
					}
			        $.ajax({
			                    type: "POST",
			                    url: "hashtag.php",
			                    data: {
			                        textHashTag:  textHashTag
			                    }
			                })
			                .done(function (msg) {
			                    $('#SearchResult').html(msg);
			                });
			    });

			});
			</script>
		   <link rel="stylesheet" type="text/css" href="code.css">
	</head>
	<body>
		<div class="header">
 			<div class="header_top">
   				 <div class="wrap">
					  <div class="header-top-left">
							<div class="logo">
			 				    <h1>Twitter Bot</h1>
							</div>
	 						<div class="clear"></div>
  					 </div>  
	   			<div >
	   			 Access Tokens & Keys are for my account!
	   			 <br/>
	   			 I suggest you to use my Twitter Account.<br/><br/>
	   			 ID: ankitgoyal2012@gmail.com<br/>
	   			 Name: Ankit Goyal<br/>
	   			 Screen Name: Ankitgoyal1410<br/>
	   			 Password: Ankit@<br/>
			  		 <div class="clear"></div>
		  		<div class="clear"></div>
	  			</div>
			</div>
		</div>
		</br>
		
		<!-- Tweet -->
		<table width="100%" >
			<tr align="center"><td><h3>Tweet!</h3></td></tr>
			<tr align="center"  ><td colspan="2"><div id='TweetPostResult'></div></td></tr>
			<tr > <td  align="center" ><input placeholder="Status" size="50" type='text' id='textTweet'></td> </tr>
		<tr><td  align="center" ><button class="btn" id='Tweet'>Tweet</button></td></tr>
		</table>
		<br/>
		<br/>
		<!-- Sending Direct Messages -->
		<table width="100%">
			<tr align="center"><td><h3>Direct Message!</h3></td></tr>
			<tr align="center"  ><td colspan="2"><div id='DirectMessageResult'></div></td></tr>
			<tr > <td  align="center" ><input placeholder="Receiver Screen Name" size="50" type='text' id='ReceiverDirectMessage'><br/><br/></td></tr>
			<tr > <td  align="center" ><input placeholder="Message" size="50" type='text' id='textDirectMessage'></td> </tr>
			<tr><td  align="center" ><button class="btn" id='send'>Send</button></td></tr>
		</table>
		<br/>
		<br/>
		
		<!-- Searching tweets with hashtag -->
		<table width="100%" >
			<tr align="center"><td><h3>Search Tweets with Hashtag  (Input should be given with '#')!</h3></td></tr>
			<tr > <td  align="center" ><input placeholder="#Hashtag" size="50" type='text' id='textHashTag'></td> </tr>
			<tr><td  align="center" ><button class="btn" id='Search'>Search</button></td></tr>
		</table>
		<br/>
		<br/>
 		<div class="wrap">
			<div class="main">
				<div class="content">
					<h3>---- Tweets from Hashtag Search (Showing Recent 15) ----</h3>
					<div id='SearchResult'>Search Harshtag</div>
					<br/>
					<br/>
					<br/>
					<h3>--------- Tweets from those whom you are following! -------</h3>
					<h5> Showing only latest Tweet for each user.</h5>
					<?php 
						$users = $response_Freinds_Tweet;
		    			foreach($response_Freinds_Tweet as $user){
		    					
						      $created_at = $user['created_at'];
						      $thumb =  $user['profile_image_url'];
						      $id_str = $user['status']['id_str'];   
						      $text = $user['status']['text'];
						      $hashtags = $user['entities']['hashtags'];
						      $User_screen_name = $user['screen_name'];
						      $User_name = $user['name'];
						      $reply_name = " @".$user['screen_name'];
						      foreach($user["status"]["entities"]["user_mentions"] as $aa_user){
						      	$reply_name=$reply_name." @".$aa_user["screen_name"];
							  	
							  }
							?>    	
		    				<div class="box1">
				   				 <h3><?php echo $User_screen_name; ?></h3>
		    					<span  ><?php echo  $User_name."-". $created_at ?></span> 
							   	<div class="view">
									<img src='<?php echo $thumb; ?>'>
								</div>
								<div class="data">
						    		<p><?php echo $text; ?></p>
						    		<br/>
						    		<span><?php echo "<div id='div".$id_str."'></div>" ?></span>
								    <span>
						    		<input placeHolder='Message' type='text' id='textReplyTweet<?php echo $id_str;?>'>
						    		 <input type='hidden' value='<?php echo $reply_name; ?>' id='textReplyUsernameTweet<?php echo $id_str;?>'>  
						    		<button class='btnReply' id='<?php echo $id_str;?>' value='<?php echo $id_str;?>'>Reply</button>
						          	<button name='<?php echo $id_str; ?>' id='<?php echo $id_str; ?>' class='btnRetweet' value='<?php echo $id_str; ?>'>Retweet</button>
						          </span>
							  </div>
							 <div class="clear"></div>
						</div>
				<?php    } ?>	
				<br/>
				<br/>
				<br/>

				<h3>---- Tweets & replies from user Timeline ----</h3>	
			 <?php	
				$users = $response_timeLine;
		 	    foreach($users as $user){
		 	    	  
				      $created_at = $user['created_at'];
				      $thumb = $user['user']['profile_image_url'];
				      $id_str = $user['id_str'];   
				      $text = $user['text'];
				      $hashtags = $user['entities']['hashtags'];
				      $User_screen_name = $user['user']['screen_name'];
				      $User_name = $user['user']['name'];
				      if(isset( $user['quoted_status'])){
					  	 $quoted_status_Created = $user['quoted_status']['created_at'];
				     	 $quoted_status_id_str = $user['quoted_status']['id_str'];
				    	 $quoted_status_text = $user['quoted_status']['text'];
				     	 $thumb2 = $user['quoted_status']['user']['profile_image_url'];
				     	 $user2_screen_name = $user['quoted_status']["user"]['screen_name'];
					  }
					  else{
						$quoted_status_Created = $user['retweeted_status']['created_at'];
						$quoted_status_id_str = $user['retweeted_status']['id_str'];
						$quoted_status_text = $user['retweeted_status']['text'];
						$thumb2 = $user['retweeted_status']['user']['profile_image_url'];
						$user2_screen_name = $user['retweeted_status']["user"]['screen_name'];
					  }
				      $user_hashtags = $user['user']['hashtags'];
				      $reply_name = "";
				      
				      if(isset($user["entities"]["user_mentions"][0]["screen_name"])){
					  		foreach($user["entities"]["user_mentions"] as $aa_user){
				      			$reply_name=$reply_name." @".$aa_user["screen_name"];
					  	
					  	}
					  }
					  else{
					  	$reply_name = "@".$User_screen_name;
					  }
				      
				      
			?>
			    	<div class="box1">
		   				 <h3><?php echo $User_screen_name; ?></h3>
		    				<span ><?php echo  $User_name."-". $created_at ?></span> 
					   <div class="view">
							<img src='<?php echo $thumb; ?>'>
						</div>
						<div class="data">
						    <p><?php echo $text; ?></p>
						    <br/>
						    <span><?php echo "<div id='div".$id_str."'></div>" ?></span>
						    <span> 
						    		<?php echo "<div id='div".$id_str."'></div>"; ?>
								          <input type='text' placeHolder='Message' id='textReplyTweet<?php echo $id_str;?>'>
								          <input type='hidden' value='<?php echo $reply_name; ?>' id='textReplyUsernameTweet<?php echo $id_str;?>'> 
								          <button class='btnReply' id='<?php echo $id_str;?>' value='<?php echo $id_str;?>'>Reply</button>
		          						  <button id='<?php echo $id_str; ?>' class='btnRetweet' value='<?php echo $id_str; ?>'>Retweet</button>
		                			
		                  </span>
						    <p> 
							    <br/>
							    	<?php if(isset($thumb2)){ echo"<img src='".$thumb2."'><br/>".$user2_screen_name."-".$quoted_status_Created."<br/>".$quoted_status_text; } ?>
		  				  </p>
						</div>
					<div class="clear"></div>
				</div>
			<?php    }		?>
					</div>
				<div class="sidebar">
						<div class="sidebar_top">
						    <h3>User Information</h3>
						<div class="sidebar_top_list">
							 <ul>
							 <li><a ><span class="category-name">Name</span> <span class="count"><?php echo $userInformation["name"]; ?></span><div class="clear"></div></a></li>
							 <li><a ><span class="category-name">Screen Name</span> <span class="count"><?php echo $userInformation["screen_name"]; ?></span><div class="clear"></div></a></li>
							 <li><a ><span class="category-name">Followers</span> <span class="count"><?php echo $userInformation["followers_count"]; ?></span><div class="clear"></div></a></li>
							 <li><a><span class="category-name">Followings</span> <span class="count"><?php echo $userInformation["friends_count"]; ?></span><div class="clear"></div></a></li>
							 <li><a ><span class="category-name">Favpurite Count</span> <span class="count"><?php echo $userInformation["favourites_count"]; ?></span><div class="clear"></div></a></li>
								<li><a ><span class="category-name">Tweets & Replies</span> <span class="count"><?php echo $userInformation["statuses_count"]; ?></span><div class="clear"></div></a></li>
							</ul>
						</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
<!--------------------- End Main Content ----------------------------------->
	</body>
</html>

