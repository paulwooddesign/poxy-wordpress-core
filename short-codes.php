<?php
///////////////////////////////////////////////////////////////////////////////////////////////
// Shortcodes
//////////////////////////////////////////////////////////////////////////////////////////////

//button
function poxy_button($a) {
	extract(shortcode_atts(array(
		'label' 	=> 'Button Text',
		'id' 	=> '1',
		'url'	=> '',
		'target' => '_parent',
		'size'	=> '',
		'ptag'	=> false
	), $a));

	$link = $url ? $url : get_permalink($id);

	if($ptag) :
		return  wpautop('<a href="'.$link.'" target="'.$target.'" class="button '.$size.'">'.$label.'</a>');
	else :
		return '<a href="'.$link.'" target="'.$target.'" class="button '.$size.'">'.$label.'</a>';
	endif;

}

add_shortcode('button', 'poxy_button');

//Thumbs
function poxy_shortcode_thumb($a) {
	extract(shortcode_atts(array(

		'url'	=> ''

	), $a));

	return  '<figure class="contain grey-scale" style="background-image: url('.$url.');"></figure>';
}

add_shortcode('thumb', 'poxy_shortcode_thumb');



//////////////////////////////////////////////////////////////
// Spacers
/////////////////////////////////////////////////////////////
function poxy_shortcode_s1($a) {
	extract(shortcode_atts(array(
		'url'	=> ''
	), $a));
	return  '<span class="s1"></span>';
}

add_shortcode('s1', 'poxy_shortcode_s1');



function poxy_shortcode_s2($a) {
	extract(shortcode_atts(array(
		'url'	=> ''
	), $a));
	return  '<span class="s2"></span>';
}

add_shortcode('s2', 'poxy_shortcode_s2');

function poxy_shortcode_s3($a) {
	extract(shortcode_atts(array(
		'url'	=> ''
	), $a));
	return  '<span class="s3"></span>';
}

add_shortcode('s3', 'poxy_shortcode_s3');



function poxy_shortcode_s4($a) {
	extract(shortcode_atts(array(
		'url'	=> ''
	), $a));
	return  '<span class="s4"></span>';
}

add_shortcode('s4', 'poxy_shortcode_s4');



//////////////////////////////////////////////////////////////
// Toggle Panel
/////////////////////////////////////////////////////////////


// function poxy_toggle_panel( $atts, $content = null ) {
// 	extract(shortcode_atts(array(
// 		'title' 	=> 'Toggle Title',
// 	), $atts));
//    return '<article class="toggle-panel minimal title-arrow-icon"><h1>'.$title.'</h1>' . do_shortcode(wpautop($content)) . '</article>';
// }

// add_shortcode('toggle_panel', 'poxy_toggle_panel');






function poxy_toggle_panel( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' 	=> 'Toggle Title',
	), $atts));
	return '<ul class="accordion accordion-a" role="tablist"><li aria-expanded="false"><h3 class="trigger" role="tab" tabindex="0">'.$title.'</h3><div class="inside" role="tabpanel">' . do_shortcode(wpautop($content)) . '</div></li></ul>';

}

add_shortcode('toggle_panel', 'poxy_toggle_panel');







//////////////////////////////////////////////////////////////
// Tabs
/////////////////////////////////////////////////////////////

function poxy_tab_panel( $atts, $content = null ) {
   return '<div class="tabs hide-title cross-fade underlined_tabs">' . do_shortcode(wpautop($content)) . '</div>';
}
add_shortcode('tab_panel', 'poxy_tab_panel');



function poxy_tab( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' 	=> 'Button Text',
	), $atts));
   return '<section><h1>'.$title.'</h1>' . do_shortcode(wpautop($content)) . '</section>';
}

add_shortcode('tab', 'poxy_tab');



function poxy_shortcode_placeholder( $atts, $content = null ) {
	$bg = of_get_option('poxy_placeholder_background_color');
    $bg= ltrim ($bg,'#');
	$color = of_get_option('poxy_placeholder_text_color');
    $color= ltrim ($color,'#');
	extract(shortcode_atts(array(
		'size' 	=> '800x600',
	), $atts));
   return '<img src="http://placehold.it/'.$size.'/'.$bg.'/'.$color.'" />';
}

add_shortcode('placeholder', 'poxy_shortcode_placeholder');




//////////////////////////////////////////////////////////////
// Column Shortcodes
/////////////////////////////////////////////////////////////

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

//one Fourth
function poxy_one_fourth( $atts, $content = null ) {
   return '<div class="pox a_14a14 b_14b14 c_12c12 d_12d12 e_11e11">' . do_shortcode(wpautop($content)) . '</div>';
}
add_shortcode('one_fourth', 'poxy_one_fourth');



function poxy_one_fourth_last( $atts, $content = null ) {
   return '<div class="pox a_14a14 b_14b14 c_12c12 d_12d12 e_11e11 mr0">' . do_shortcode(wpautop($content)) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fourth_last', 'poxy_one_fourth_last');


//one_sixth
function poxy_one_sixth( $atts, $content = null ) {
   return '<div class="pox a_16a16 b_16b16 c_13c13 d_12d12 e_12e12">' . do_shortcode(wpautop($content)) . '</div>';
}
add_shortcode('one_sixth', 'poxy_one_sixth');

function poxy_one_sixth_last( $atts, $content = null ) {
   return '<div class="pox a_16a16 b_16b16 c_13c13 d_12d12 e_12e12 mr0">' . do_shortcode(wpautop($content)) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_sixth_last', 'poxy_one_sixth_last');





//one_third
function poxy_one_third( $atts, $content = null ) {
   return '<div class="pox a_13a13 B_13-13 G_11-11 _D_11-11 _E_11-11">' . do_shortcode(wpautop($content)) . '</div>';
}
add_shortcode('one_third', 'poxy_one_third');

function poxy_one_third_last( $atts, $content = null ) {
   return '<div class="pox a_13a13 b_13b13 c_13c13 d_11d11 e_11e11 mr0">' . do_shortcode(wpautop($content)) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'poxy_one_third_last');


//two_third
function poxy_two_third( $atts, $content = null ) {
   return '<div class="pox A_23-23 B_23-11 _G_11-11 _D_11-11 _E_11-11"><div class="inside">' . do_shortcode(wpautop($content)) . '</div></div>';
}
add_shortcode('two_third', 'poxy_two_third');

function poxy_two_third_last( $atts, $content = null ) {
   return '<div class="pox _A_23-11 _B_23-11 _G_11-11 _D_11-11 _E_11-11"">' . do_shortcode(wpautop($content)) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'poxy_two_third_last');


//three_fourth
function poxy_three_fourth( $atts, $content = null ) {
   return '<div class="pox A_34-11 B_34-11 G_11-11 _D_11-11 _E_11-11">' . do_shortcode(wpautop($content)) . '</div>';
}
add_shortcode('three_fourth', 'poxy_three_fourth');

function poxy_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth last">' . do_shortcode(wpautop($content)) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fourth_last', 'poxy_three_fourth_last');


//one_half
function poxy_one_half( $atts, $content = null ) {
   return '<div class="pox a_12a12 b_12b12 c_11c11 d_11d11 e_11e11 mb0">' . do_shortcode(wpautop($content)) . '</div>';
}
add_shortcode('one_half', 'poxy_one_half');

function poxy_one_half_last( $atts, $content = null ) {
   return '<div class="pox a_12a12 b_12b12 c_11c11 d_11d11 e_11e11 mb0 mr0">' . do_shortcode(wpautop($content)) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'poxy_one_half_last');


//one_half
function poxy_one_half_np( $atts, $content = null ) {
   return '<div class="pox A_12-12 B_12-12 G_11-11 _D_11-11 _E_11-11 mb0">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half_np', 'poxy_one_half_np');

function poxy_one_half_last_np( $atts, $content = null ) {
   return '<div class="pox _A_12-12 _B_12-12 G_11-11 _D_11-11 _E_11-11 mb0">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last_np', 'poxy_one_half_last_np');




//////////////////////////////////////////////////////////////
// Reformat Short codes
/////////////////////////////////////////////////////////////
function poxy_reformat($content) {
	$new_content = '';

	/* Matches the contents and the open and closing tags */
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';

	/* Matches just the contents */
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';

	/* Divide content into pieces */
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	/* Loop over pieces */
	foreach ($pieces as $piece) {
		/* Look for presence of the shortcode */
		if (preg_match($pattern_contents, $piece, $matches)) {

			/* Append to content (no formatting) */
			$new_content .= $matches[1];
		} else {

			/* Format and append to content */
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

// Before displaying for viewing, apply this function
add_filter('the_content', 'poxy_reformat', 99);
add_filter('widget_text', 'poxy_reformat', 99);



//////////////////////////////////////////////////////////////
// Slideshow Shortcode
/////////////////////////////////////////////////////////////

function poxy_slideshow( $atts, $content = null ) {
    $content = str_replace('<br />', '', $content);
	$content = str_replace('<img', '<li><img', $content);
	$content = str_replace('/>', '/></li>', $content);
	return '<div class="flexslider clearfix"><ul class="slides">' . $content . '</ul></div>';
}
add_shortcode('slideshow', 'poxy_slideshow');

//////////////////////////////////////////////////////////////
// Elastic Video
/////////////////////////////////////////////////////////////

function poxy_elasticVideo( $atts, $content = null ) {
	return '<div class="video-container">' . $content . '</div>';
}
add_shortcode('elastic-video', 'poxy_elasticVideo');

//////////////////////////////////////////////////////////////
// Add conainers to all videos
/////////////////////////////////////////////////////////////

function add_video_containers($content) {
	$content = str_replace('<object', '<div class="video-container"><object', $content);
	$content = str_replace('</object>', '</object></div>', $content);

	$content = str_replace('<embed', '<div class="video-container"><embed', $content);
	$content = str_replace('</embed>', '</embed></div>', $content);

	$content = str_replace('<iframe', '<div class="video-container"><iframe', $content);
	$content = str_replace('</iframe>', '</iframe></div>', $content);

	return $content;
}

add_action('the_content', 'add_video_containers');





?>
