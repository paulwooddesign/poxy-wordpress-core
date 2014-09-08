<?php
/*
Plugin Name: POXY Core Master
Plugin URI: http://paulwood.me
Description: POXY Core Functions
Version: 1.0
Author: Paul Wood
Author URI: http://paulwood.me
Author Email: paul@paulwood.me
License: GPL2
*/



//////////////////////////////////////////////////////////////
// Placeholder Text
/////////////////////////////////////////////////////////////
function limit_words($placholder_text, $limit, $append = '&hellip;') {
       // Add 1 to the specified limit becuase arrays start at 0
       $limit = $limit+1;
       // Store each individual word as an array element
       // Up to the limit
       $placholder_text = explode(' ', $placholder_text, $limit);
       // Shorten the array by 1 because that final element will be the sum of all the words after the limit
       array_pop($placholder_text);
       // Implode the array for output, and append an ellipse
       $placholder_text = implode(' ', $placholder_text) . $append;
       // Return the result
       return $placholder_text;
}

function poxy_content($limit = 30){
  if(get_the_content() == ''){
    $placholder_text = of_get_option('poxy_placeholder_text');
    echo '<p>'.limit_words($placholder_text, $limit).'...'.$limit.' x</p>';
  }else{
    echo '<p>'. get_the_content() .'</p>';
  }
}

function poxy_text($words, $limit = 10){
  if($words == ''){
    $placholder_text = of_get_option('poxy_placeholder_text');
    echo '<span>'.limit_words($placholder_text, $limit).''.$limit.'x</span>';
  }else{
    echo $words;
  }
}


function poxy_value($words, $limit = 1){
  if($words == ''){
    //$placholder_text = of_get_option('poxy_placeholder_text');
    //echo '<span class="dev placeholder-text"><span class="star">*</span>'.limit_words($placholder_text, $limit).' <span style="font-size:80%;">'.$limit.'</span><span style="font-size:70%;">x</span>';
  }else{
    echo $words;
  }
}

function poxy_meta_value($meta_value){
  global $post;
  $meta_value = get_post_meta($post->ID, $meta_value, true);
  if($meta_value != ''){
    echo $meta_value;
  }else{
    echo "-";
  }
}

// function poxy_header($words, $limit = 3){
//   if($words == ''){
//     $placholder_text = of_get_option('poxy_placeholder_text');
//     echo '<span class="dev placeholder-text"><span class="star">*</span>'.limit_words($placholder_text, $limit).' <span style="font-size:80%;">'.$limit.'</span><span style="font-size:70%;">x</span>';
//   }else{
//     echo $words;
//   }
// }


/**
 * poxy_excerpt function.
 *
 * @access public
 * @param ID.
 * @return void
 */
function poxy_excerpt($word_count = 10) {
  global $post;

    $id = $post->ID;
    $text = get_the_excerpt();
    //poxy_text($text, $word_count);

    if ($text)  {
       echo limit_words($text, $word_count);
    } else {
      poxy_text(0, $word_count);
    }


    //if (has_excerpt($id)) return the_excerpt();

    //else echo poxy_text(0, );
}


//////////////////////////////////////////////////////////////
// Placeholder Iamge
/////////////////////////////////////////////////////////////
function poxy_tax_image($id, $x = 350, $y = 350, $size = 'full'){
//global $post;
//$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ));
$taxonomy = 'p_type';
$queried_term = get_query_var($taxonomy);
//$terms = get_the_terms($post->ID, $taxonomy);
if(is_int($id)){
$terms = get_terms($taxonomy, 'include='.$id  );
}else{
$terms = get_terms($taxonomy, 'slug='.$id  );
}
foreach ($terms as $term) {
//echo $skill->slug;
  $image = poxy_get_taxonomy_image_src( $term, $size );
  if ( ! $image ) return poxy_placeholder($x, $y);
  return poxy_get_taxonomy_image_url($term, 'full');
}
  // $image = poxy_get_taxonomy_image_src( $term, $size );
  // if ( ! $image ) return poxy_placeholder($x, $y);


}

//////////////////////////////////////////////////////////////
// Auto Set First Image as Featured
/////////////////////////////////////////////////////////////
function poxy_catch_first_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if (isset($matches[1][0])){
      $first_img = $matches[1][0];
      if(empty($first_img)) {
        return false;
      } else {
      return $first_img;
    }
  }
}

//////////////////////////////////////////////////////////////
// Placeholder Iamge
/////////////////////////////////////////////////////////////
function poxy_placeholder($x = 350, $y = 350, $bg = '', $color = ''){

  if ($bg == '') {
    $bg = of_get_option('poxy_placeholder_background_color');
    $bg= ltrim ($bg,'#');
  }
  if ($color == '') {
    $color = of_get_option('poxy_placeholder_text_color');
    $color= ltrim ($color,'#');
  }

  $placeholder_image = "http://placehold.it/". $x ."x".$y."/".$bg."/".$color;

  return $placeholder_image;

}

function poxy_placeholder_url(){
$placholder_image_url = get_bloginfo( 'template_directory' ) . '/assets/images/core/placeholder.png';
return $placholder_image_url;
}

function poxy_placeholder_bio_url(){
$placholder_image_url = get_bloginfo( 'template_directory' ) . '/assets/images/core/bio_placeholder.png';
return $placholder_image_url;
}

function poxy_thumb_url($pid){
$image_id = get_post_thumbnail_id($pid);
$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', false);
$image_url = $image_url[0];
return $image_url;
}

function poxy_thumb($x = 350, $y = 350){
global $post;
$image_id = get_post_thumbnail_id();
    if($image_id){
        $image_url = wp_get_attachment_image_src($image_id, 'full', false);
        $image_url = $image_url[0];
    } elseif (poxy_catch_first_image()) {
        $image_url = poxy_catch_first_image();
    } else {
        $image_url = poxy_placeholder();
    }
echo $image_url;
}

// function poxy_350_thumb_url(){
// global $post;
// $image_id = get_post_thumbnail_id($pid);
// $image_url = wp_get_attachment_image_src($image_id, 'poxy_square_thumb_350', false);
// $image_url = $image_url[0];
// return $image_url;
// }

function poxy_350_thumb_url($x = 350, $y = 350){
global $post;
$image_id = get_post_thumbnail_id();
    if($image_id){
        $image_url = wp_get_attachment_image_src($image_id, 'poxy_square_thumb_350', false);
        $image_url = $image_url[0];
    } elseif (poxy_catch_first_image()) {
        $image_url = poxy_catch_first_image();
    } else {
        $image_url = poxy_placeholder();
    }
echo $image_url;
}

function poxy_thumb_600x400($x = 600, $y = 400){
global $post;
$image_id = get_post_thumbnail_id();
    if($image_id){
        $image_url = wp_get_attachment_image_src($image_id, 'poxy_thumb_600x400', false);
        $image_url = $image_url[0];
    } elseif (poxy_catch_first_image()) {
        $image_url = poxy_catch_first_image();
    } else {
        $image_url = poxy_placeholder();
    }
echo $image_url;
}


function poxy_bgi_1x1($x = 400, $y = 400){
global $post;
$image_id = get_post_thumbnail_id();
    if($image_id){
        $image_url = wp_get_attachment_image_src($image_id, 'poxy_thumb_600x400', false);
        $image_url = $image_url[0];
    } elseif (poxy_catch_first_image()) {
        $image_url = poxy_catch_first_image();
    } else {
        $image_url = poxy_placeholder($x, $y);
    }
    echo 'style="background-image: url('.$image_url.');"';
}


function get_single_custom_background() {
  global $wp_query;
  global $post;
  $post_type = get_post_type($post->ID);
  $is_tiled_bkg = get_post_meta($post->ID, "_poxy_background_tile_value", true);
  $custom_background_img = MultiPostThumbnails::get_post_thumbnail_url($post_type, "background_image", $post->ID, "poxy_background_image_full");
  return $custom_background_img;
}


function poxy_banner_image($x = 1900, $y = 600){

  if(get_single_custom_background()){
      $image_url = get_single_custom_background();
  } else {
      $image_url = poxy_placeholder($x, $y);
  }
  echo 'style="background-image: url('.$image_url.');"';

}


function poxy_thumb_900x500($x = 900, $y = 500){
global $post;
$image_id = get_post_thumbnail_id();
    if($image_id){
        $image_url = wp_get_attachment_image_src($image_id, 'poxy_thumb_900x500', false);
        $image_url = $image_url[0];
    } elseif (poxy_catch_first_image()) {
        $image_url = poxy_catch_first_image();
    } else {
        $image_url = poxy_placeholder();
    }
echo $image_url;
}


function poxy_thumb_650x650($x = 650, $y = 650){
global $post;
$image_id = get_post_thumbnail_id();
    if($image_id){
        $image_url = wp_get_attachment_image_src($image_id, 'poxy_thumb_650x650', false);
        $image_url = $image_url[0];
    } elseif (poxy_catch_first_image()) {
        $image_url = poxy_catch_first_image();
    } else {
        $image_url = poxy_placeholder();
    }
echo $image_url;
}



function poxy_banner_bg($x = 2000, $y = 1440){
global $post;
$image_id = get_post_thumbnail_id();
    if($image_id){
        $image_url = wp_get_attachment_image_src($image_id, 'poxy_banner_bg', false);
        $image_url = $image_url[0];
    } elseif (poxy_catch_first_image()) {
        $image_url = poxy_catch_first_image();
    } else {
        $image_url = poxy_placeholder();
    }
echo $image_url;
}


function poxy_banner_bg_crop($x = 2000, $y = 1440){
global $post;
$image_id = get_post_thumbnail_id();
    if($image_id){
        $image_url = wp_get_attachment_image_src($image_id, 'poxy_banner_bg_crop', false);
        $image_url = $image_url[0];
    } elseif (poxy_catch_first_image()) {
        $image_url = poxy_catch_first_image();
    } else {
        $image_url = poxy_placeholder();
    }
echo $image_url;
}



function poxy_post_thumb($pid){
$image_id = get_post_thumbnail_id($pid);
$image_url = wp_get_attachment_image_src($image_id, 'poxy_post_thumb', false);
$image_url = $image_url[0];
return $image_url;
}


function poxy_full_image_url($pid){
$image_id = get_post_thumbnail_id($pid);
$image_url = wp_get_attachment_image_src($image_id, 'full', false);
$image_url = $image_url[0];
return $image_url;
}


function poxy_custom_image($pid){
$image_id = get_post_thumbnail_id($pid);
$image_url = wp_get_attachment_image_src($image_id, 'poxy_custom_image', false);
$image_url = $image_url[0];
return $image_url;
}



function poxy_get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}
//echo get_avatar_url(get_avatar( $curauth->ID, 150 ));


// Load Different Image size depending on divice
function poxy_device_responsive_image($image_id){
    global $post;
    if ( wp_is_mobile() ) {
            $image = wp_get_attachment_image_src(get_post_meta($post->ID, $image_id, true), 'poxy_mobile_banner');
            $image = $image[0];
        } else {
            $image = wp_get_attachment_image_src(get_post_meta($post->ID, $image_id, true), 'full');
            $image = $image[0];
        }

        if ($image) {
            return $image;
        }
    }
//////////////////////////////////////////////////////////////
// Get First Last Post
/////////////////////////////////////////////////////////////


function poxy_get_last_post_url($post_type){
    $args = array('post_type'=>$post_type, 'posts_per_page' => -1);
    $posts = get_posts($args);
    $last_id = end($posts);
    $last_post = get_permalink($last_id);

return $last_post;
}

function poxy_get_first_post_url($post_type){
    $args = array('post_type'=>$post_type, 'posts_per_page' => -1);
    $posts = get_posts($args);
    $first_id = $posts[0]->ID; // To get ID of first post in custom post type
    $first_post = get_permalink($first_id);

return $first_post;

}



//////////////////////////////////////////////////////////////
// Custom More Link
/////////////////////////////////////////////////////////////

function poxy_more_link($title) {
  global $post;
  $more_link = '<p class="more-link"><a href="'.get_permalink().'" title="'.get_the_title().'">';
  $more_link .= '<span>'.__($title, 'poxy').'</span>';
  $more_link .= '</a></p>';
  echo $more_link;
}

//////////////////////////////////////////////////////////////
// Slugs
/////////////////////////////////////////////////////////////
function poxy_slug(){
global $post;
$slug = get_post( $post )->post_name;
return $slug;
}

function poxy_id(){
global $post;
$id = get_post( $post )->ID;
return $id;
}

function poxy_get_slug($echo=true){
  $slug = basename(get_permalink());
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  if( $echo ) echo $slug;
  do_action('after_slug', $slug);
  return $slug;
}


function poxy_get_id_by_slug($page_slug) {
  $page = get_page_by_path($page_slug);
  if ($page) {
    return $page->ID;
  } else {
    return null;
  }
}
//////////////////////////////////////////////////////////////
// Check if Current page is subpage or parent
//////////////////////////////////////////////////////////////
function poxy_is_tree($pid) {    // $pid = The ID of the page we're looking for pages underneath
  global $post;         // load details about this page
  if(is_page()&&($post->post_parent==$pid||is_page($pid)))
               return true;   // we're at the page or at a sub page
  else
               return false;  // we're elsewhere
};




function poxy_has_children($slug) {
  global $post;
  $pid = poxy_get_id_by_slug($slug);
  $pages = get_pages('child_of=' . $pid);

  return count($pages);
}






function poxy_get_last_post_slug($post_type){
    $args = array('post_type'=>$post_type, 'posts_per_page' => -1);
    $posts = get_posts($args);
    $last_id = end($posts);
    $slug = basename(get_permalink($last_id));
    do_action('before_slug', $slug);
    $slug = apply_filters('slug_filter', $slug);
    //if( $echo ) echo $slug;
    do_action('after_slug', $slug);
    return $slug;
}

function poxy_get_first_post_slug($post_type){
    $args = array('post_type'=>$post_type, 'posts_per_page' => -1);
    $posts = get_posts($args);
    $first_id = $posts[0]->ID; // To get ID of first post in custom post type
    $slug = basename(get_permalink($first_id));
    do_action('before_slug', $slug);
    $slug = apply_filters('slug_filter', $slug);
    //if( $echo ) echo $slug;
    do_action('after_slug', $slug);
    return $slug;

}









//////////////////////////////////////////////////////////////
// Options Functions
/////////////////////////////////////////////////////////////
function poxy_get_post_types_array(){
$post_types = array();
$args = array('public' => true);
$output = 'names'; // names or objects
$operator = 'and'; // 'and' or 'or'
$post_types_obj = get_post_types($args, $output, $operator);
$post_types[''] = 'Select a page:';
    foreach ($post_types_obj  as $post_type ) {
    $post_types[$post_type] = $post_type;
    }
  return $post_types;
}






/**
 * poxy_excerpt function.
 *
 * @access public
 * @param ID.
 * @return void
 */
if ( !function_exists( 'poxy_mobile_toggle' ) ) :
function poxy_mobile_toggle($title) {
    if (wp_is_mobile()) {
    $a = '<ul class="accordion accordion-a mobile-accordion">';
    $a .= '<li>';
    $a .= '<div class="trigger copy-width" style="outline:none;">';
    $a .= '<span class="title beta">';
    $a .= $title;
    $a .= '</span>';
    $a .= '</div><div class="line_spacer"></div><div class="clearboth"></div><div class="inside">';
    echo $a;
    echo "\n";
    }
}
endif;


/**
 * poxy_excerpt function.
 *
 * @access public
 * @param ID.
 * @return void
 */
if ( !function_exists( 'poxy_mobile_toggle_last' ) ) :
function poxy_mobile_toggle_last() {
    if (wp_is_mobile()) {
    $a = '</div></li></ul>';
    echo $a;
    echo "\n";
    }
}
endif;


//////////////////////////////////////////////////////////////
// ODD EVEN Post Classes
/////////////////////////////////////////////////////////////
function poxy_oddeven_post_class ( $classes ) {
   global $current_class;
   $classes[] = $current_class;
   $current_class = ($current_class == 'odd') ? 'even' : 'odd';
   return $classes;
}
add_filter ( 'post_class' , 'poxy_oddeven_post_class' );
global $current_class;
$current_class = 'odd';

function poxy_odd_even_post() {
  global $post_num;

  if ( ++$post_num % 2 )
    $class = 'even';
  else
    $class = 'odd';

  return $class;
}


// function w45_last_class ( $classes ) {
//    global $last_class;
//    global $page_last;
//    $thumb_class = of_get_option('w45_home_page_thumbs_per_row');
//    //$thumb_class = "one_fourth";

//    $thumbs_per_row = $thumb_class;
//   switch ($thumbs_per_row)
//   {
//   case "one_half":
//     $thumbs_per_row = 2;
//     break;
//   case "one_third":
//     $thumbs_per_row = 3;
//     break;
//   case "one_fourth":
//     $thumbs_per_row = 4;
//     break;
//   case "one_fifth":
//     $thumbs_per_row = 5;
//     break;
//   case "one_sixth":
//     $thumbs_per_row = 6;
//     break;
//   default:
//     $thumbs_per_row = 3;
//   }

//   $page_last++;

//   if ($page_last == $thumbs_per_row ){
//     $last_class = "last " . $thumb_class;
//     $page_last = 0;
//   } else{
//     $last_class = $thumb_class;
//   }
//   $classes[] = $last_class;
//    return $classes;
// }
// //add_filter ( 'post_class' , 'w45_last_class' );
// global $last_class;
// //$last_class = 'one_fourth';
// // global $page_last;
// //$page_last = 0;



//////////////////////////////////////////////////////////////
// List custom post type taxonomies
//////////////////////////////////////////////////////////////

function poxy_get_terms( $id = '' ) {
  global $post;

  if ( empty( $id ) )
    $id = $post->ID;

  if ( !empty( $id ) ) {
    $post_taxonomies = array();
    $post_type = get_post_type( $id );
    $taxonomies = get_object_taxonomies( $post_type , 'names' );

    foreach ( $taxonomies as $taxonomy ) {
      $term_links = array();
      $terms = get_the_terms( $id, $taxonomy );

      if ( is_wp_error( $terms ) )
        return $terms;

      if ( $terms ) {
        foreach ( $terms as $term ) {
          $link = get_term_link( $term, $taxonomy );
          if ( is_wp_error( $link ) )
            return $link;
          $term_links[] = '<li><span><a href="'.$link.'">' . $term->name . '</a></span></li>';
        }
      }

      $term_links = apply_filters( "term_links-$taxonomy" , $term_links );
      $post_terms[$taxonomy] = $term_links;
    }
    return $post_terms;
  } else {
    return false;
  }
}

function poxy_get_terms_list( $id = '' , $echo = true ) {
  global $post;

  if ( empty( $id ) )
    $id = $post->ID;

  if ( !empty( $id ) ) {
    $my_terms = poxy_get_terms( $id );
    if ( $my_terms ) {
      $my_taxonomies = array();
      foreach ( $my_terms as $taxonomy => $terms ) {
        $my_taxonomy = get_taxonomy( $taxonomy );
        if ( !empty( $terms ) ) $my_taxonomies[] = implode( $terms);
      }

      if ( !empty( $my_taxonomies ) ) {
      $output = "";
        foreach ( $my_taxonomies as $my_taxonomy ) {
          $output .= $my_taxonomy . "\n";
        }
      }

      if ( $echo )
        if(isset($output)) echo $output;
      else
        if(isset($output)) return $output;
    } else {
      return;
    }
  } else {
    return false;
  }
}




//////////////////////////////////////////////////////////////
// Admin
/////////////////////////////////////////////////////////////
add_filter( 'edit_post_link', 'poxy_edit_post_link' );
function poxy_edit_post_link( $link ) {
    $matches = array();
    if ( !preg_match( '/\>.*?\<\/a\>/i', $link, $matches ) ) {
        return $link;
    }
    return str_replace( $matches[0], '></a>', $link );
}



// Admin Edit menu Button
function poxy_edit_post($x="", $y="") {
    $a = '<div class="relative">';
    $b = '</div>';
    echo $a;
    edit_post_link();
    echo $b;
    echo "\n";
}

// Admin Edit menu Button
function poxy_edit($x="", $y="") {
    $a = '<div class="relative">';
    $b = '</div>';
    echo $a;
    edit_post_link();
    echo $b;
    echo "\n";
}


// Admin Edit menu Button
function poxy_edit_menu($x="", $y="") {
    global $user_ID;
    if( $user_ID ) {
        if( current_user_can('level_10') ) {
        $a = '<div title="Edit Main Menu" class="relative"><a class="pox post-edit-link right top" href="';
        $b = '/wp-admin/nav-menus.php"></a></div>';
        echo $a;
        echo bloginfo('wpurl');
        echo $b;
        echo "\n";
        }
    }
}



// Admin Edit menu Button
function poxy_edit_logo($x="", $y="") {
    global $user_ID;
    if( $user_ID ) {
        if( current_user_can('level_10') ) {
        $a = '<div class="relative"><a title="Edit Logo" class="pox post-edit-link" href="';
        $b = '/wp-admin/themes.php?page=options-framework"></a></div>';
        echo $a;
        echo bloginfo('wpurl');
        echo $b;
        echo "\n";
        }
    }
}





////////////////////////////////////////////
// FOOTER - Load Dev UI
////////////////////////////////////////////
add_action('wp_footer','poxy_dev_ui');
function poxy_dev_ui() {
    $poxy_dev_styles = of_get_option('poxy_dev_styles');
    if($poxy_dev_styles == false) {
        global $user_ID;
        if( $user_ID ) {
            if( current_user_can('level_10') ) {
                get_template_part('bower_components/poxy-wordpress-core/dev');
            }
        }
    }
}
