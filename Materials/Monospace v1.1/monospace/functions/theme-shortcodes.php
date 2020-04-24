<?php

/*-----------------------------------------------------------------------------------

	Theme Shortcodes

-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Buttons Shortcodes
/*-----------------------------------------------------------------------------------*/

function mnm_button_brown( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_brown " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-brown', 'mnm_button_brown');

function mnm_button_blue( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_blue " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-blue', 'mnm_button_blue');

function mnm_button_green( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_green " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-green', 'mnm_button_green');

function mnm_button_red( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_red " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-red', 'mnm_button_red');

function mnm_button_white( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_white " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-white', 'mnm_button_white');

function mnm_button_yellow( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_yellow " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-yellow', 'mnm_button_yellow');


/*-----------------------------------------------------------------------------------*/
/*	Alert Shortcodes
/*-----------------------------------------------------------------------------------*/

function mnm_alert_note( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'note'
    ), $atts));
	$out = "<div class=\"message_box note\"><p>".do_shortcode($content)."</p></div>";
    return $out;
}
add_shortcode('alert-note', 'mnm_alert_note');

function mnm_alert_announce( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'announce'
    ), $atts));
	$out = "<div class=\"message_box announce\"><p>".do_shortcode($content)."</p></div>";
    return $out;
}
add_shortcode('alert-announce', 'mnm_alert_announce');

function mnm_alert_success( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'success'
    ), $atts));
	$out = "<div class=\"message_box success\"><p>".do_shortcode($content)."</p></div>";
    return $out;
}
add_shortcode('alert-success', 'mnm_alert_success');

function mnm_alert_warning( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'warning'
    ), $atts));
	$out = "<div class=\"message_box warning\"><p>".do_shortcode($content)."</p></div>";
    return $out;
}
add_shortcode('alert-warning', 'mnm_alert_warning');

/*-----------------------------------------------------------------------------------*/
/*	Column Shortcodes
/*-----------------------------------------------------------------------------------*/

function mnm_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'mnm_one_third');

function mnm_one_third_last( $atts, $content = null ) {
   return '<div class="one_third column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_third_last', 'mnm_one_third_last');

function mnm_two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'mnm_two_third');

function mnm_two_third_last( $atts, $content = null ) {
   return '<div class="two_third column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('two_third_last', 'mnm_two_third_last');

function mnm_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'mnm_one_half');

function mnm_one_half_last( $atts, $content = null ) {
   return '<div class="one_half column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_half_last', 'mnm_one_half_last');

function mnm_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'mnm_one_fourth');

function mnm_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_fourth_last', 'mnm_one_fourth_last');

function mnm_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'mnm_three_fourth');

function mnm_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('three_fourth_last', 'mnm_three_fourth_last');

function mnm_one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'mnm_one_fifth');

function mnm_one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_fifth_last', 'mnm_one_fifth_last');

function mnm_two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'mnm_two_fifth');

function mnm_two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('two_fifth_last', 'mnm_two_fifth_last');

function mnm_three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'mnm_three_fifth');

function mnm_three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('three_fifth_last', 'mnm_three_fifth_last');

function mnm_four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'mnm_four_fifth');

function mnm_four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('four_fifth_last', 'mnm_four_fifth_last');

function mnm_one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'mnm_one_sixth');

function mnm_one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_sixth_last', 'mnm_one_sixth_last');

function mnm_five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'mnm_five_sixth');

function mnm_five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('five_sixth_last', 'mnm_five_sixth_last');

/*-----------------------------------------------------------------------------------*/
/*	Video Shortcodes
/*-----------------------------------------------------------------------------------*/
function mnm_youtube_video( $atts, $content = null ) {  
    extract(shortcode_atts( array(  
        'id' => '',  
        'width' => '600',  
        'height' => '340',
    ), $atts));  
    $out = "<div class=\"youtube-video\"><iframe width=\"" .$width . "\" height=\"" .$height ."\" src=\"http://www.youtube.com/embed/" . $id . "?rel=0\" frameborder=\"0\" allowfullscreen></iframe></div>";
	return $out;
}  
add_shortcode('youtube', 'mnm_youtube_video'); 

function mnm_vimeo_video( $atts, $content = null ) {  
    extract(shortcode_atts( array(  
        'id' => '',  
        'width' => '600',  
        'height' => '340'
    ), $atts));  
    $out = "<div class=\"vimeo-video\"><iframe width=\"" .$width . "\" height=\"" .$height ."\" src=\"http://player.vimeo.com/video/" . $id . "?title=0&amp;byline=0&amp;portrait=0\" frameborder=\"0\" allowfullscreen></iframe></div>";
	return $out;
}  
add_shortcode('vimeo', 'mnm_vimeo_video'); 

/*-----------------------------------------------------------------------------------*/
/*	GoogleMaps Shortcode
/*-----------------------------------------------------------------------------------*/
function mnm_googleMaps($atts, $content = null) {
   extract(shortcode_atts(array(
      'width' => '640',
      'height' => '480',
      "src" => '',
	  'position' => 'left'
   ), $atts));
   $out = "<div class=\"googlemaps " .$position . "\"><iframe width=\"".$width."\" height=\"".$height."\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"".$src."&amp;output=embed\"></iframe></div>";
   return $out;
}
add_shortcode("googlemap", "mnm_googleMaps");

/*-----------------------------------------------------------------------------------*/
/*	Tabs
/*-----------------------------------------------------------------------------------*/
function mnm_tabs( $atts, $content = null ) {
	
	if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
			$tabid[$i] = 'tab-'.mt_rand(10, 100000).'-'.strtolower(str_replace(array("!","@","#","$","%","^","&","*",")","(","+","=","[","]","/","\\",";","{","}","|",'"',":","<",">","?","~","`"," "),"",$matches[3][$i]['title']));
		}
		$tabnav = '<ul class="tabs">';
		
		for($i = 0; $i < count($matches[0]); $i++) {
			$tabnav .= '<li><a href="#'.$tabid[$i].'">' . $matches[3][$i]['title'] . '</a></li>';
		}
		$tabnav .= '</ul>';
		
		$tabcontent = '<div class="tab_container">';
		for($i = 0; $i < count($matches[0]); $i++) {
			$tabcontent .= '<div id="'.$tabid[$i].'" class="tab_content clearfix">' . do_shortcode(trim($matches[5][$i])) . '</div>';
		}
		$tabcontent .= '</div>';
        
        $tabwidgetid = 'tabwidget-'.mt_rand(10, 100000);
        
        $script = '<script type="text/javascript">
        $("#' . $tabwidgetid . ' .tab_content").hide();
    	$("#' . $tabwidgetid . ' ul.tabs li:first").addClass("active").show();
    	$("#' . $tabwidgetid . ' .tab_content:first").show();
    	$("#' . $tabwidgetid . ' ul.tabs li").click(function() {    
    		$("#' . $tabwidgetid . ' ul.tabs li").removeClass("active");
    		$(this).addClass("active");
    		$("#' . $tabwidgetid . ' .tab_content").hide();    
    		var activeTab = $(this).find("a").attr("href");
    		$(activeTab).fadeIn(600);
    		return false;
    	});</script>';
		
		return '<div class="tab_widget" id="' . $tabwidgetid . '">' . $tabnav . $tabcontent . '</div><div class="clear"></div>'.$script;
	}
    
}

add_shortcode('tabs', 'mnm_tabs');

/*--------------------------------------------------------
    Toggles
--------------------------------------------------------*/


function mnm_toggle( $atts, $content = null ) {
	
    extract(shortcode_atts(array(
		'title' => 'Toggle Title'
	), $atts));
    
	return '<div class="toggle clearfix"><div class="togglet"><span>' . $title . '</span></div><div class="togglec clearfix">' . do_shortcode(trim($content)) . '</div></div><div class="clear"></div>';
    
}

add_shortcode('toggle', 'mnm_toggle');

/*-----------------------------------------------------------------------------------*/
/*	Divider with an anchor link to top of page.
/*-----------------------------------------------------------------------------------*/
// simple divider
function mnm_divider( $atts ) {
    return '<div class="divider"></div>';
}
add_shortcode('divider', 'mnm_divider');

// Divider with an anchor link to top of page.
function mnm_divider_top( $atts ) {
    return '<div class="top-of-page"><a href="#top">Back to Top</a></div>';
}
add_shortcode('divider_top', 'mnm_divider_top');

// Used to clear an element of its neighbors, no floating elements are allowed on the left or the right side.
function mnm_clear( $atts ) {
    return '<div class="clear"></div>';
}
add_shortcode('clear', 'mnm_clear');

?>