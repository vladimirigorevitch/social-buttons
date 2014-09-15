<?php

/*	argument is an array of pairs '<social network>' => <boolean> ; where <social network> is vkontakte, facebook, googleplus */
/*  return string with html block of likes buttons  */

	class LikesBlock 
	{
		private $attributes = array( 'vkontakte' => array(false, 0), 'facebook' => array(false, 0), 'google' => array(false, 0), 'tweeter' => array(false, 0));
		private $url;

		function __construct( $userAttrs ) // <- 1st arg is an array ('facebook' => true, ...)
		{
			$this->url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			foreach ( $this->attributes as $key => &$value )  
			{
				if ( array_key_exists( $key, $userAttrs ))
				{
					$value[0] = $userAttrs[$key];	// true|false (add button or not; false by default)

					// set the likes count 		//TODO: make it switch
					if ( strnatcasecmp($key, 'facebook'))
					{						
						$value[1] = $this->get_fb_likes ();
		                // $json_string = file_get_contents( 'http://graph.facebook.com/?ids='.$this->url );	//http://eu.battle.net/hearthstone/ru/');
		                // $json = json_decode( $json_string, true );
		                // $value[1] = intval( $json[$this->url]['shares'] );
					} 
				//	if ( strnatcasecmp($key, 'vkontakte'))	//TODO
					// {
					// 	$value[1] = $this->get_fb_likes ();						
					// }
					if ( strnatcasecmp($key, 'google'))
					{
						$value[1] = $this->get_gp_likes ();						
					}
					if ( strnatcasecmp($key, 'tweeter'))
					{
						$value[1] = $this->get_tw_likes ();						
					}
				}
			}
		}

		//	return html code with a buttons block // 0 as default likes-counter
		public function like_buttons_block () 
		{
			$wrapper = '<div class="likes-wrapper">';	
			$result = '';

			foreach ( $this->attributes as $key => $value)
			{
				if ( $value[0] )
				{
					$result .= '<div class="social-button social-icons" id="social-'.$key.'">
								    <span class="social-icon-'.$key.'"></span>
								    <span class="social-title-'.$key.'"></span>
								    <span class="social-counter">'.$value[1].'</span>
	 						    </div>';	
				}
			}

			if ( $result ) 
			{
				return $wrapper.$result.'</div>';	
			} 
			else 
			{
				return null;
			}
		}	//	end of shortcode_buttons_like

		//	get facebook likes count
		private function get_fb_likes ()
		{
		    $curl = curl_init();
		    $FBurl = 'http://api.facebook.com/restserver.php?method=links.getStats&amp;format=json&amp;urls='.$this->url;
		    curl_setopt($curl, CURLOPT_URL, $FBurl);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    $curl_results = curl_exec ($curl);
		    curl_close($curl);
 
		    // разбор в json
		    $res = json_decode($curl_results);
		 
		    return $res[0]->like_count;
		}	//	end of get_fb_likes

		//	get vkontakte likes count 		//TODO: get the id for web-site from vkontakte; change YOUR_ID with vkontakte's id for this website
		// private function get_vk_likes ( $id )
		// {
		//     $curl = curl_init();
		//     $url = 'https://api.vkontakte.ru/method/likes.getList?type=sitepage&amp;owner_id=YOUR_ID&amp;format=json&amp;item_id='.$id;
		//     curl_setopt($curl, CURLOPT_URL, $url);
		//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		//     $curl_results = curl_exec ($curl);
		//     curl_close($curl);
		 
		//     // разбор в json
		//     $res = json_decode($curl_results);
		 
		//     return intval($res->response->count);
		// }

		//	get tweeter likes count
		private function get_tw_likes ()
		{
		    $curl = curl_init();
		    $TWurl = 'http://urls.api.twitter.com/1/urls/count.json?url=' . $this->url;
		    curl_setopt($curl, CURLOPT_URL, $TWurl);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    $curl_results = curl_exec ($curl);
		    curl_close($curl);
		 
		    // разбор в json
		    $res = json_decode($curl_results);
		 
		    return intval( $res->count );	
		}
		//	get google+ likes count
		private function get_gp_likes ()
		{
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
		    curl_setopt($curl, CURLOPT_POST, 1);
		    curl_setopt($curl, CURLOPT_POSTFIELDS, '[{
		        "method":"pos.plusones.get",
		        "id":"p",
		        "params":{
		            "nolog":true,
		            "id":"' . $this->url . '"
		            ,"source":"widget",
		            "userId":"@viewer",
		            "groupId":"@self"
		        },
		        "jsonrpc":"2.0",
		        "key":"p",
		        "apiVersion":"v1"
		    }]');
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		    $curl_results = curl_exec ($curl);
		    curl_close ($curl);
		 
		    $json = json_decode($curl_results, true);
		 
		    return intval( $json[0]['result']['metadata']['globalCounts']['count'] );	
		}

	} 	//	end of LikesBlock

// 		test
//$like_block = new LikesBlock( array( 'facebook' => true, 'vkontakte' => true, 'tweeter' => false, 'google' => true ));
//$like_block = $like_block->like_buttons_block ();
//print_r($like_block);
?>