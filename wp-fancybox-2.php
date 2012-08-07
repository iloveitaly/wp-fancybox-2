<?php
/*
   Plugin Name: WP fancybox 2
   Plugin URI: 
   Version: 0.1
   Author: 
   Description: A plug & play responsive Lightbox for WordPress based on the FancyBox2 lightbox
   Text Domain: wp-fancybox-2
   License: GPL3
  */

/*
   
/**
 * Initialize internationalization (i18n) for this plugin.
 */
function WpFancybox2_i18n_init() {
    $pluginDir = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('wp-fancybox-2', false, $pluginDir . '/languages/');
}


//////////////////////////////////
// Run initialization
/////////////////////////////////

// First initialize i18n
WpFancybox2_i18n_init();

/*** Adding the class "fancybox" to images previously added ****/
function filter_fancy_content($content){
    $linkptrn = "/<a[^>]*>/";
    $found = preg_match($linkptrn, $content, $a_elem);   
    // If no link, do nothing
    if($found <= 0) return $content;
    $a_elem = $a_elem[0];
    // Check to see if the link is to an uploaded image
    $is_attachment_link = strstr($a_elem, "wp-content/uploads/");
    // If link is to external resource, do nothing
    if($is_attachment_link === FALSE) return $content;
    if(strstr($a_elem, "class=\"") !== FALSE){ 
    // If link already has class defined inject it to attribute
        $a_elem_new = str_replace("class=\"", "class=\"fancybox ", $a_elem);
        $content = str_replace($a_elem, $a_elem_new, $content);
    }else{ 
    // If no class defined, just add class attribute
        $content = str_replace("<a ", "<a class=\"fancybox\" ", $content);
    }
   return $content;
}

add_filter('the_content', 'filter_fancy_content');


/*** script ****/
add_action('wp_enqueue_scripts', 'fancy_scripts_method');
function fancy_scripts_method() {
    wp_register_script( 'jquery-fancybox', plugins_url('js/jquery.fancybox.js', __FILE__), array( 'jquery' ), 0.1, true );
    wp_enqueue_script( 'jquery-fancybox' );

 /*    wp_register_script( 'jquery-mousewheel', plugins_url('js/jquery.mousewheel-3.0.6.pack.js', __FILE__), array( 'jquery' ), 0.1, true );
    wp_enqueue_script( 'jquery-mousewheel' ); */


}    

add_action( 'wp_print_footer_scripts', 'fancy_print_footer_scripts' );

function fancy_print_footer_scripts() { ?>
<script type="text/javascript">
  jQuery(document).ready(function($) {    
    $(".fancybox").attr('data-fancybox-group', 'gallery').fancybox();
  });
</script> 
<?php
}

/** stylesheet **/
add_action( 'wp_enqueue_scripts', 'fancy_add_my_stylesheet' );
    function fancy_add_my_stylesheet() {
        wp_register_style( 'jquery-fancybox', plugins_url('css/jquery.fancybox.css', __FILE__) );
        wp_enqueue_style( 'jquery-fancybox' );
} 


