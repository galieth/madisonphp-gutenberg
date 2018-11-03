<?php
/**
* Plugin Name: Madisonphp - Gutenberg 
* Plugin URI: https://earthilnginteractive.com/madisonphp
* Description: A plugin that adjusts how gutenberg acts on our site.
* Version: 1.2
* Author: Earthling Interactive
* Author URI: https://earthlinginteractive.com
* License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
* Text Domain: madisonphp-gutenberg
* Domain Path: /languages
*/
//no direct running of this php file
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function madison_gutenberg_disable_custom_colors() {
	add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'madison_gutenberg_disable_custom_colors' );

function madison_gutenberg_color_palette() {
    $colors = get_option('madisonphp_gutenberg_options');
    $palette_colors = array();
    foreach($colors as $key => $color)
    {
    	if(!empty($color))
    	{
    		switch($key)
    		{
    			case 'madisonphp_gutenberg_field_primary_color':
    				$color_name = "Primary Color";
    				$color_slug = "primary-color";
    				break;
    			case 'madisonphp_gutenberg_field_secondary_color':
    				$color_name = "Secondary Color";
    				$color_slug = "secondary-color";
    				break;
    			case 'madisonphp_gutenberg_field_accent_1_color':
    				$color_name = "Accent 1 Color";
    				$color_slug = "accent-1-color";
    				break;
    			case 'madisonphp_gutenberg_field_accent_2_color':
    				$color_name = "Accent 2 Color";
    				$color_slug = "accent-2-color";
    				break;
				default:
    				$color_name = "";
    				$color_slug = "";
    				break;
    		}
    		if(!empty($color_name))
    		{
    			$palette_colors[] = array(
					'name'  => esc_html__( $color_name, 'madisonphp-gutenberg'),
					'slug' => $color_slug,
					'color' => $color,
				);
    		}
		}
	}
	if(!empty($palette_colors))
	{
		add_theme_support( 'editor-color-palette', $palette_colors );
	}

}
add_action( 'after_setup_theme', 'madison_gutenberg_color_palette' );

/* 
 * Options pages and related functions
 */
function madisonphp_gutenberg_options_page()
{
    add_submenu_page(
        'options-general.php',
        'Madisonphp Gutenberg Options',
        'Madisonphp Options',
        'manage_options',
        'madisonphp-gutenberg',
        'madisonphp_gutenberg_options_page_html'
    );
    add_submenu_page(
        'options-general.php',
        'Madisonphp Gutenberg Widgets',
        'Madisonphp Widgets',
        'manage_options',
        'madisonphp-gutenberg-widgets',
        'madisonphp_gutenberg_options_widgets_page_html'
    );

}
add_action('admin_menu', 'madisonphp_gutenberg_options_page');


function madisonphp_gutenberg_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('madisonphp_gutenberg');
            do_settings_sections('madisonphp_gutenberg');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

//Setup a configuration page
function madisonphp_gutenberg_settings_init() {
 // register a new setting for "madisonphp_gutenberg" page
 register_setting( 'madisonphp_gutenberg', 'madisonphp_gutenberg_options', array('sanitize_callback' => 'madison_gutenberg_validate_color_options') );
 
 
 // register a new section in the "madisonphp_gutenberg" page for Colors
 
 add_settings_section(
 'madisonphp_gutenberg_section_color',
 __( 'Color Settings.', 'madisonphp_gutenberg' ),
 'madisonphp_gutenberg_section_color_cb',
 'madisonphp_gutenberg'
 ); 
 
 // register a new field in the "madisonphp_gutenberg_section_color" section, inside the "madisonphp_gutenberg" page
 add_settings_field(
	 'madisonphp_gutenberg_field_primary_color', // as of WP 4.6 this value is used only internally
	 // use $args' label_for to populate the id inside the callback
	 __( 'Primary Color', 'madisonphp_gutenberg' ),
	 'madisonphp_gutenberg_field_color_cb',
	 'madisonphp_gutenberg',
	 'madisonphp_gutenberg_section_color',
	 [
		 'label_for' => 'madisonphp_gutenberg_field_primary_color',
		 'class' => 'madisonphp_gutenberg_row',
	 ]
 );
  
 //Secondary Color
 add_settings_field(
	 'madisonphp_gutenberg_field_secondary_color', 
	 __( 'Secondary Color', 'madisonphp_gutenberg' ),
	 'madisonphp_gutenberg_field_color_cb',
	 'madisonphp_gutenberg',
	 'madisonphp_gutenberg_section_color',
	 [
		 'label_for' => 'madisonphp_gutenberg_field_secondary_color',
		 'class' => 'madisonphp_gutenberg_row',
	 ]
 );

 //Accent Color 1
 add_settings_field(
	 'madisonphp_gutenberg_field_accent_1_color', 
	 __( 'Accent Color 1', 'madisonphp_gutenberg' ),
	 'madisonphp_gutenberg_field_color_cb',
	 'madisonphp_gutenberg',
	 'madisonphp_gutenberg_section_color',
	 [
		 'label_for' => 'madisonphp_gutenberg_field_accent_1_color',
		 'class' => 'madisonphp_gutenberg_row',
	 ]
 );
 //Accent Color 2
 add_settings_field(
	 'madisonphp_gutenberg_field_accent_2_color', 
	 __( 'Accent Color 2', 'madisonphp_gutenberg' ),
	 'madisonphp_gutenberg_field_color_cb',
	 'madisonphp_gutenberg',
	 'madisonphp_gutenberg_section_color',
	 [
		 'label_for' => 'madisonphp_gutenberg_field_accent_2_color',
		 'class' => 'madisonphp_gutenberg_row',
	 ]
 );

 register_setting( 'madisonphp_gutenberg_widgets', 'madisonphp_gutenberg_widgets_options', array('sanitize_callback' => 'madisonphp_gutenberg_validate_widgets_options'));

 add_settings_section(
 'madisonphp_gutenberg_section_widgets',
 __( 'Usable Widgets', 'madisonphp_gutenberg' ),
 'madisonphp_gutenberg_section_widgets_cb',
 'madisonphp_gutenberg_widgets'
 ); 
 
 add_settings_field(
	 'madisonphp_gutenberg_field_widgets', 
	 __( 'Pick Widgets', 'madisonphp_gutenberg' ),
	 'madisonphp_gutenberg_field_widgets_cb',
	 'madisonphp_gutenberg_widgets',
	 'madisonphp_gutenberg_section_widgets',
	 [
		 'label_for' => 'madisonphp_gutenberg_field_widgets',
		 'class' => 'madisonphp_gutenberg_row',
	 ]
 );

 
}
add_action( 'admin_init', 'madisonphp_gutenberg_settings_init' );



//Call back function for the Colors settings section:
function madisonphp_gutenberg_section_color_cb( $args ) {
	//Not outputting anything at this time
	return;
}

function madisonphp_gutenberg_field_color_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
    $settings = get_option('madisonphp_gutenberg_options');
    $labelFor = esc_attr( $args['label_for']);
    // output the field
    ?>
    <input type="text" name="madisonphp_gutenberg_options[<?php echo $labelFor; ?>]" value="<?php echo isset( $settings[$labelFor] ) ? $settings[$labelFor] : ''; ?>">
    <?php
	return;
}

function madison_gutenberg_validate_color_options($args)
{
	foreach($args as $key => $color)
	{
		$args[$key] = madison_gutenberg_validate_color($color,$key);
	}
	return $args;
}

function madison_gutenberg_validate_color($color,$key)
{
	if(!empty($color))
	{
		if(preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/',$color))
		{
			return $color;
		}else
		{
			//No match found, or error occured. Return empty string and place an error message
			$message = __('Color must be a valid hex color value','madisonphp-gutenberg');
			add_settings_error( 'validator_' . $key, esc_attr( 'settings_updated' ), $message );
			return '';
		}
	}
}

function madisonphp_gutenberg_add_custom_colors()
{
	wp_enqueue_style( 'madisonphp-gutenberg', plugins_url( '/css/madisonphp-gutenberg.css', __FILE__ ),array(), '1.2');
    $colors = get_option('madisonphp_gutenberg_options');
    ob_start();
    foreach($colors as $key => $color)
    {
    	if(!empty($color))
    	{
    		switch($key)
    		{
    			case 'madisonphp_gutenberg_field_primary_color':
    				$color_name = "primary-color";
    				break;
    			case 'madisonphp_gutenberg_field_secondary_color':
    				$color_name = "secondary-color";
    				break;
    			case 'madisonphp_gutenberg_field_accent_1_color':
    				$color_name = "accent-1-color";
    				break;
    			case 'madisonphp_gutenberg_field_accent_2_color':
    				$color_name = "accent-2-color";
    				break;

    		}
			echo '.has-' . $color_name . '-color { color: '. $color . '; }';
			echo '.has-' . $color_name . '-background-color { background-color: '. $color . '; }';
    	}
    }
    $custom_css = ob_get_contents();
    ob_end_clean();
    wp_add_inline_style( 'madisonphp-gutenberg', $custom_css );	
}
add_action( 'wp_enqueue_scripts', 'madisonphp_gutenberg_add_custom_colors' );


// Widgets options page
function madisonphp_gutenberg_options_widgets_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('madisonphp_gutenberg_widgets');
            do_settings_sections('madisonphp_gutenberg_widgets');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}


//Call back function for the widgets settings section:
function madisonphp_gutenberg_section_widgets_cb( $args ) {
	//Not outputting anything at this time
	echo "<div>Select which elements you would like to include in the gutenberg editor</div>";
	return;
}
function madisonphp_gutenberg_field_widgets_cb( $args ) {
    $settings = get_option('madisonphp_gutenberg_widgets_options'); ?>
	<label><input type="checkbox" name="madisonphp_gutenberg_widgets_options[core/paragraph]" value="1"<?php checked( 1 == $settings['core/paragraph'] ); ?> />core/paragraph</label>
	<label><input type="checkbox" name="madisonphp_gutenberg_widgets_options[core/image]" value="1"<?php checked( 1 == $settings['core/image'] ); ?> />core/image</label>
	<label><input type="checkbox" name="madisonphp_gutenberg_widgets_options[core/gallery]" value="1"<?php checked( 1 == $settings['core/gallery'] ); ?> />core/gallery</label>
	<label><input type="checkbox" name="madisonphp_gutenberg_widgets_options[core/table]" value="1"<?php checked( 1 == $settings['core/table'] ); ?> />core/table</label>
    <?php
	return;
}

function madisonphp_gutenberg_validate_widgets_options($args) {
   return $args;
}

//Add the News CPT
require_once plugin_dir_path(__FILE__) .'news.php';


?>