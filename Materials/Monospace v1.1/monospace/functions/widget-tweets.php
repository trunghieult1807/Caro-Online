<?php
/* -----------------------------------------------------------------------

	Plugin Name: MyThemeShop Latest Tweets Widget
	Description: A widget for showing latest tweets in sidebar
	Version: 2.0
------------------------------------------------------------------------*/
class mts_widget_recent_tweets extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'mts_widget_recent_tweets', // Base ID
			'MyThemeShop: Latest Tweets', // Name
			array( 'description' => __( 'A widget for showing latest tweets in sidebar', 'mythemeshop' ), ) // Args
		);
	}
	public function widget($args, $instance) {
		extract($args);
		if(!empty($instance['title'])){ $title = apply_filters( 'widget_title', $instance['title'] ); }
		echo $before_widget;				
		if ( ! empty( $title ) ){ echo $before_title . $title . $after_title; }
		//check settings and die if not set
		if(empty($instance['consumerkey']) || empty($instance['consumersecret']) || empty($instance['accesstoken']) || empty($instance['accesstokensecret']) || empty($instance['cachetime']) || empty($instance['username'])){
			echo '<strong>Please fill all widget settings!</strong>' . $after_widget; return; }
		//check if cache needs update
		$mts_twitter_plugin_last_cache_time = get_option('mts_twitter_plugin_last_cache_time');
		$diff = time() - $mts_twitter_plugin_last_cache_time;
		$crt = $instance['cachetime'] * 3600;						
		//	yes, it needs update			
		//require_once('twitteroauth.php');
		if($diff >= $crt || empty($mts_twitter_plugin_last_cache_time)){							
		if(!require_once('twitteroauth.php')){ echo '<strong>Couldn\'t find twitteroauth.php!</strong>' . $after_widget; return; }														
		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
			$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
			return $connection;
		} 
		$connection = getConnectionWithAccessToken($instance['consumerkey'], $instance['consumersecret'], $instance['accesstoken'], $instance['accesstokensecret']);
		$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$instance['username']."&count=10") or die('Couldn\'t retrieve tweets! Wrong username?');
		if(!empty($tweets->errors)){
			if($tweets->errors[0]->message == 'Invalid or expired token'){
				echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!' . $after_widget;
			}else{ echo '<strong>'.$tweets->errors[0]->message.'</strong>' . $after_widget; }
			return;
		}
		for($i = 0;$i <= count($tweets); $i++){
			if(!empty($tweets[$i])){
				$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
				$tweets_array[$i]['text'] = $tweets[$i]->text;			
				$tweets_array[$i]['status_id'] = $tweets[$i]->id_str;			
			}
		}			
		//save tweets to wp option 		
		update_option('mts_twitter_plugin_tweets',serialize($tweets_array));							
		update_option('mts_twitter_plugin_last_cache_time',time());		
		echo '<!-- twitter cache has been updated! -->';
		}
		//convert links to clickable format
		function convert_links($status,$targetBlank=true,$linkMaxLen=250){
			$target=$targetBlank ? " target=\"_blank\" " : ""; // the target
			$status = preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status); // convert link to url
			$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status); // convert @ to follow
			$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status); // convert # to search
			return $status; // return the status
		}					
					
		//convert dates to readable format	
		function relative_time($a) {			
			$b = strtotime("now");  //get current timestampt
			$c = strtotime($a); //get timestamp when tweet created
			$d = $b - $c; //get difference
			$minute = 60; //calculate different time values
			$hour = $minute * 60;
			$day = $hour * 24;
			$week = $day * 7;				
			if(is_numeric($d) && $d > 0) {				
				if($d < 3) return "right now"; //if less then 3 seconds
				if($d < $minute) return floor($d) . " seconds ago"; //if less then minute
				if($d < $minute * 2) return "about 1 minute ago"; //if less then 2 minutes
				if($d < $hour) return floor($d / $minute) . " minutes ago"; //if less then hour
				if($d < $hour * 2) return "about 1 hour ago"; //if less then 2 hours
				if($d < $day) return floor($d / $hour) . " hours ago"; //if less then day
				if($d > $day && $d < $day * 2) return "yesterday"; //if more then day, but less then 2 days
				if($d < $day * 365) return floor($d / $day) . " days ago"; //if less then year
				return "over a year ago"; //else return more than a year
			}
		}
		$mts_twitter_plugin_tweets = maybe_unserialize(get_option('mts_twitter_plugin_tweets'));
		if(!empty($mts_twitter_plugin_tweets)){
			print '<div class="mts_recent_tweets tweets"><ul>';
				$fctr = '1';
				foreach($mts_twitter_plugin_tweets as $tweet){								
					print '<li><i class="icon-twitter"></i><div><span>'.convert_links($tweet['text']).'</span><br /><a class="twitter_time" target="_blank" href="http://twitter.com/'.$instance['username'].'/statuses/'.$tweet['status_id'].'">'.relative_time($tweet['created_at']).'</a></div></li>';
					if($fctr == $instance['tweetstoshow']){ break; }
					$fctr++;
				}
			print '</ul></div>';
		}
		echo $after_widget;
	}					
	//save widget settings 
	public function update($new_instance, $old_instance) {				
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['consumerkey'] = strip_tags( $new_instance['consumerkey'] );
		$instance['consumersecret'] = strip_tags( $new_instance['consumersecret'] );
		$instance['accesstoken'] = strip_tags( $new_instance['accesstoken'] );
		$instance['accesstokensecret'] = strip_tags( $new_instance['accesstokensecret'] );
		$instance['cachetime'] = strip_tags( $new_instance['cachetime'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['tweetstoshow'] = strip_tags( $new_instance['tweetstoshow'] );
		if($old_instance['username'] != $new_instance['username']){ delete_option('mts_twitter_plugin_last_cache_time'); }
		return $instance;
	}
			
			
	//widget settings form	
	public function form($instance){
		$defaults = array( 'title' => '', 'consumerkey' => '', 'consumersecret' => '', 'accesstoken' => '', 'accesstokensecret' => '', 'cachetime' => '', 'username' => '', 'tweetstoshow' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
	echo '<p><label>Title:</label><input type="text" name="'.$this->get_field_name( 'title' ).'" id="'.$this->get_field_id( 'title' ).'" value="'.esc_attr($instance['title']).'" class="widefat" /></p><p><label>'.__('Consumer Key','mythemeshop').':</label><input type="text" name="'.$this->get_field_name( 'consumerkey' ).'" id="'.$this->get_field_id( 'consumerkey' ).'" value="'.esc_attr($instance['consumerkey']).'" class="widefat" /></p><p><label>'.__('Consumer Secret','mythemeshop').':</label><input type="text" name="'.$this->get_field_name( 'consumersecret' ).'" id="'.$this->get_field_id( 'consumersecret' ).'" value="'.esc_attr($instance['consumersecret']).'" class="widefat" /></p><p><label>'.__('Access Token','mythemeshop').':</label><input type="text" name="'.$this->get_field_name( 'accesstoken' ).'" id="'.$this->get_field_id( 'accesstoken' ).'" value="'.esc_attr($instance['accesstoken']).'" class="widefat" /></p>									
	<p><label>'.__('Access Token Secret','mythemeshop').':</label><input type="text" name="'.$this->get_field_name( 'accesstokensecret' ).'" id="'.$this->get_field_id( 'accesstokensecret' ).'" value="'.esc_attr($instance['accesstokensecret']).'" class="widefat" /></p><p><label>'.__('Cache Tweets in every','mythemeshop').':</label><input type="text" name="'.$this->get_field_name( 'cachetime' ).'" id="'.$this->get_field_id( 'cachetime' ).'" value="'.esc_attr($instance['cachetime']).'" class="small-text" /> hours</p><p><label>'.__('Twitter Username','mythemeshop').'</label>
	<input type="text" name="'.$this->get_field_name( 'username' ).'" id="'.$this->get_field_id( 'username' ).'" value="'.esc_attr($instance['username']).'" class="widefat" /></p><p><label>'.__('Number of tweets (max 20)','mythemeshop').'</label><select type="text" name="'.$this->get_field_name( 'tweetstoshow' ).'" id="'.$this->get_field_id( 'tweetstoshow' ).'">';
	$i = 1;
	for(i; $i <= 20; $i++){ echo '<option value="'.$i.'"'; if($instance['tweetstoshow'] == $i){ echo ' selected="selected"'; } echo '>'.$i.'</option>'; }
	echo '</select></p><p>Visit <a href="https://dev.twitter.com/apps/" target="_blank">this link</a> in a new tab, sign in with your account, click on Create a new application and create your own keys in case you don\'t have already</p>'; }
}	
// register	widget
function register_mts_twitter_widget(){
	register_widget('mts_widget_recent_tweets');
}
add_action('widgets_init', 'register_mts_twitter_widget', 1);
?>