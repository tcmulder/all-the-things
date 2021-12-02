<?php
/*
Plugin Name: Pattern Library
Description: Adds a basic pattern library to your WordPress site.
Version:     1.0.1
Author:      Tomas Mulder
Author URI:  https://www.thinkaquamarine.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: aqua-pattern-library
Domain Path: /languages
*/

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define constants
 */
define( 'AQUA_PATTERNS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AQUA_PATTERNS_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
define( 'AQUA_PATTERNS_EXCLUDED_MODS', array( 'ani', 'ani_advanced', 'ani_stagger' ) );
define( 'AQUA_PATTERNS_ALLOWED_SERVERS', array( 'test.thinkaquamarine.com' ) );

/**
 * Check if localhost or other authorized server (will always show on localhost)
 */
function aqua_patterns_is_allowed_server() {
    if(
        in_array( $_SERVER['SERVER_NAME'], AQUA_PATTERNS_ALLOWED_SERVERS )
        || $_SERVER['SERVER_NAME'] === 'localhost'
        || $_SERVER['REMOTE_ADDR'] === '127.0.0.1'
    ) {
        return true;
    }
    return false;
}

/**
 * Create All the Things CPT
 */
add_action('init', 'aqua_patterns_create_all_the_things');
function aqua_patterns_create_all_the_things() {
    register_post_type('all-the-things',
        array(
            'labels'                            => array(
                'name'                          => _x('All The Things', 'Taxonomy General Name', 'aqua-pattern-library'),
                'singular_name'                 => _x('All The Things', 'Taxonomy Singular Name', 'aqua-pattern-library'),
                'menu_name'                     => __('Patterns', 'aqua-pattern-library'),
                'all_items'                     => __('All Patterns', 'aqua-pattern-library'),
                'parent_item'                   => __('Parent Pattern', 'aqua-pattern-library'),
                'parent_item_colon'             => __('Parent Pattern:', 'aqua-pattern-library'),
                'new_item_name'                 => __('New Pattern Name', 'aqua-pattern-library'),
                'add_new_item'                  => __('Add New Pattern', 'aqua-pattern-library'),
                'edit_item'                     => __('Edit Pattern', 'aqua-pattern-library'),
                'update_item'                   => __('Update Pattern', 'aqua-pattern-library'),
                'separate_items_with_commas'    => __('Separate patterns with commas', 'aqua-pattern-library'),
                'search_items'                  => __('Search Patterns', 'aqua-pattern-library'),
                'add_or_remove_items'           => __('Add or remove patterns', 'aqua-pattern-library'),
                'choose_from_most_used'         => __('Choose from the most used patterns', 'aqua-pattern-library'),
                'not_found'                     => __('Not Found', 'aqua-pattern-library'),
            ),
            'menu_icon'         => 'dashicons-analytics',
            'has_archive'       => true,
            'public'            => true,
            'hierarchical'      => true,
            'menu_position'     => 100, // bottom-ish
            'show_in_rest'      => true,
            'supports'          => array(
                'editor',
                'custom-fields',
                'title',
                'page-attributes'
            ),
        )
    );
}

/**
 * Redirect non-logged-in users to login page
 */
add_action('template_redirect', 'aqua_patterns_redirect_to_specific_page');
function aqua_patterns_redirect_to_specific_page() {
    if(
        // if this is one of all the things and the user isn't logged in
        ('all-the-things' == get_post_type() && !is_user_logged_in())
        // and if we're not on a server that should always show all the things
        && ! aqua_patterns_is_allowed_server()
    ) {
        // make the user log in to see this post
        auth_redirect();
    }

}

/*------------------------------------*\
    ::Create Custom Templates
\*------------------------------------*/

// create the single page
add_filter('single_template', 'aqua_patterns_custom_single_template');
function aqua_patterns_custom_single_template($single_template) {
    global $post;
    if ($post->post_type === 'all-the-things') {
        return AQUA_PATTERNS_PLUGIN_DIR . '/templates/single.php';
    }
    return $single_template;
}
// create the archive page
add_filter('archive_template', 'aqua_patterns_custom_archive_template') ;
function aqua_patterns_custom_archive_template($archive_template) {
     global $post;
     if (is_post_type_archive('all-the-things')) {
          $archive_template = AQUA_PATTERNS_PLUGIN_DIR . '/templates/archive.php';
     }
     return $archive_template;
}

/*------------------------------------*\
    ::Show Sub Page Nav for All the Things

    Basic usage:                [pagelist]
    Fixed usage:                [pagelist fixed="x-y"]

    Fixed examples:
    right top:                  [pagelist fixed="right-top"]
    bottom left:                [pagelist fixed="left-bottom"]
    note: x comes before y always

    Show mods (by group ID): [pagelist mod="42"]
//
\*------------------------------------*/
add_shortcode('pagelist', 'aqua_patterns_page_list_shortcode');
function aqua_patterns_page_list_shortcode($attr) {
    
    // get attributes
    extract(shortcode_atts(array(
        'fixed' => '',
        'mods_id'  => false,
    ), $attr));
    $args = array(
        'post_type'         => 'all-the-things',
        'posts_per_page'    => '-1',
        'orderby'           => 'title',
        'order'             => 'ASC',
    );
    
    // essentially create random number to disambiguate
    $r = filemtime( __FILE__ );
    
    // loop through all the things
    $page_id = get_the_id();
    $the_query = new WP_Query($args);
    $list = '';
    if ($the_query->have_posts()) {
        
        // add all the things to a list with links
        $list .= '<ul>';
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $list .= '<li>';
                $list .= '<a href="'.get_the_permalink().'"'.(get_the_id() === $page_id ? ' aria-current="page"' : '').'>';
                    $list .= get_the_title();
                $list .= '</a>';
            $list .= '</li>';

        }
    }
    wp_reset_postdata();

    // add edit link for page then close list
    $list .= '<li><a href="'.strrev(admin_url('/post.php?post='.get_the_id().'&action=edit')).'" id="things-link-'.$r.'" target="_blank">✎ '.get_the_title().'</li></a>';
    $list .= '</ul>';

    // create optional mods selector
    global $wpdb;
    $mods_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title =  'Settings - Global' ");
    $mods = '';
    $form_style = '';
    if($mods_id){
        
        // get the mods
        $group = acf_get_fields_by_id($mods_id);
        
        // start creating the list if we have items
        if($group){
        
            // create styling
            $form_style = '
                <style scoped>
                    #things-list-'.$r.' form {
                        display: none;
                        padding: 5px;
                    }
                    /* * #things-list-'.$r.' form, /* DEBUG */
                    #things-list-'.$r.':hover form {
                        display: block;
                    }
                    #things-list-'.$r.' input[type="checkbox"] {
                        display: none;
                    }
                    #things-list-'.$r.' label,
                    #clear-all-'.$r.' {
                        -webkit-appearance: none;
                        display: inline-block;
                        margin: 0 2px 2px 0;
                        padding: 0 5px;
                        opacity: .5;
                        background-color: #000;
                        color: #fff;
                        white-space: nowrap;
                        border-radius: 3px;
                        cursor: pointer;
                    }
                    #things-list-'.$r.' input:checked + label {
                        opacity: 1;
                    }
                </style>
            ';
            
            // create behavior
            $script = '
                <script>
                    jQuery(function($){
                        // apply mods to all modules
                        var $groups = $(".page-content > *");
                        var $inputs = $("#things-list-'.$r.'").find("input");
                        $inputs.on("change", function(){
                            var $this = $(this);
                            if($this.is(":checked")){
                                $groups.addClass($this.val());
                            } else {
                                var classes = [];
                                $groups.each(function(){
                                    classes.push.apply(classes, $(this).attr("class").split(" "));
                                });
                                $.each(classes, function(i, c) {
                                    if(c.indexOf($this.val()) !== -1) {
                                        $groups.removeClass(c);
                                    }
                                });
                            }
                        });
                        // uncheck all mods
                        $("#clear-all-'.$r.'").on("click", function(){
                            $inputs.prop("checked", "").change();
                        });
                        // bypass proxy url replacement
                        $("#things-link-'.$r.'").each(function(e){
                            var $this = $(this);
                            $this.attr("href", $this.attr("href").split("").reverse().join(""));
                        });
                    });
                </script>
            ';
            $mods .= '<form action="">';
                $mods .= '<input type="button" id="clear-all-'.$r.'" value="clear all">';
                if($group){
                    foreach($group as $set){
                        if(isset($set['choices']) && !in_array($set[ 'name' ], AQUA_PATTERNS_EXCLUDED_MODS)){
                            foreach($set['choices'] as $choice=>$value){
                                $mods .= '<input type="checkbox" id="'.$choice.'-'.$r.'" value="'.$choice.'">';
                                $mods .= '<label for="'.$choice.'-'.$r.'">'.$choice.'</label>';
                            }
                        }
                    }
                }
                $mods .= $script;
            $mods .= '</form>';
        }
    }

    // if we got a list of all the things
    if($list) {
        
        // establish optional fixed position styling
        if($fixed != ''){
            $fixed_arr = explode('-', $fixed);
            $fixed = '
                #things-list-'.$r.' {
                    position: fixed;
                    overflow: auto;
                    max-height: 100vh;
                    '.$fixed_arr[0].': 0;
                    '.$fixed_arr[1].': 0;
                    opacity: .4;
                    transition: opacity 300ms;
                }
                #things-list-'.$r.':hover ul:before {
                    content: "";
                    position: absolute;
                    background-color: black;

                    '.$fixed_arr[0].': 0;
                    '.$fixed_arr[1].': 0;
                    z-index: -1;
                    opacity: 0;
                }
                #things-list-'.$r.':hover {
                    opacity: 1;
                }
                #things-list-'.$r.':hover:before {
                    display: none;
                }
            ';
        }
        
        // establish normal styling
        $list_style = '
        <style scoped>
                #things-list-'.$r.' {
                    position: relative;
                    z-index: 9999;
                }
                #things-list-'.$r.' * {
                    font-size: 10px !important;
                    font-weight: normal !important;
                    font-family: sans-serif !important;
                    text-transform: none !important;
                }
                #things-list-'.$r.' li {
                    list-style: none !important;
                    margin-bottom: 0;
                }
                #things-list-'.$r.' li:before,
                #things-list-'.$r.' li:after {
                    display: none;
                }
                #things-list-'.$r.', #things-list-'.$r.' ul {
                    margin: 0;
                    padding: 0;
                    width: 150px;
                    background-color: rgba(50,50,50,.6);
                }
                #things-list-'.$r.' > li > ul > li:last-child {
                    background-color: rgba(50,50,50,.7);
                }
                #things-list-'.$r.' a {
                    display: block;
                    width: 100%;
                    padding: 2px 5px;
                    color: #fff;
                    text-decoration: none;
                    transition: color 300ms;
                }
                #things-list-'.$r.' [aria-current="page"],
                #things-list-'.$r.' a:hover {
                    background-color: #000;
                    color: white;
                }
                #things-list-'.$r.' li ul {
                    display: none;
                    position: relative;
                }
                /* * #things-list-'.$r.' li ul, /* DEBUG */
                #things-list-'.$r.':hover ul {
                    display: block;
                }
                '.$fixed.'
        </style>';

        // create the list
        $str =  '
            <ul id="things-list-'.$r.'">
            '.$list_style.'
            '.$form_style.'
                <li>
                    '.$mods.'
                    '.$list.'
                    <a href="'.get_post_type_archive_link('all-the-things').'">All the Things</a>
                </li>
            </ul>
        ';
        return $str;
    }
}

// show the page list
add_action( 'wp_footer', 'aqua_patterns_page_list_in_footer', 50 );
function aqua_patterns_page_list_in_footer(){
    if(aqua_patterns_is_allowed_server()) {
        echo do_shortcode('[pagelist fixed="right-bottom" mods_id="7"]');
    }
}
