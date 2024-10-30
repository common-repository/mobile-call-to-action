<?php
/*
Plugin Name: Mobile Call to Action
Plugin URI: https://galibweb.com/plugins/mobile-call-to-action/
Description: This plugin will add custom call to action button in the bottom area of your webiste.
Version: 1.0
Author: GalibWeb
Author URI: https://galibweb.com/
License: GPLv2 or later
Text Domain: mobile-call-to-action
Domain Path: /languages/
*/

// Exit if accessed directly
if ( !function_exists( 'add_action' ) ) {
	exit;
}

// Define Constants
define( 'MCTA_PLUGIN_DIR', plugin_dir_url(__FILE__) );

// Global Variables
$mcta_options = get_option( 'mcta_settings', array(
	'mobile_enable' => 1,
	'mobile_number' => '123456789',
	'email_enable' => 1,
	'email_address' => 'example@example.com',
	'enable_footer_space' => 1,
	'font_size' => '30',
	'icon_color' => '#f91212',
	'icon_bg_color' => '#000000'
) );

/**
 * Load plugin textdomain
 */
function mcta_load_plugin_textdomain() {
	load_plugin_textdomain( 'mobile-call-to-action', false, dirname(__FILE__)."languages/" );
}
add_action( 'plugins_loaded', 'mcta_load_plugin_textdomain' );

/**
 * Add content to footer
 * @return [html] [echo the output of our call to action buttons]
 */
function mcta_add_content_to_site_footer() {
	global $mcta_options;
	if( !$mcta_options['mobile_enable'] && !$mcta_options['email_enable'] ) {
		return;
	}
	?>
	<div class="mcta-wrapper">
		<div class="mcta-relative">
			<?php if( $mcta_options['mobile_enable'] ) : ?>
				<a href="tel:<?php echo $mcta_options['mobile_number']; ?>" class="mcta-icons"><span class="dashicons dashicons-phone"></span></a>
			<?php endif; ?>
			<?php if( $mcta_options['email_enable'] ) : ?>
				<a href="mailto:<?php echo $mcta_options['email_address']; ?>" class="mcta-icons"><span class="dashicons 
dashicons-email-alt"></span></a>
			<?php endif; ?>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'mcta_add_content_to_site_footer' );


/**
 * Add options page for MCTA plugin
 */
function mcta_add_options_page() {
	add_options_page(
		__( 'Mobile CTA Options', 'mobile-call-to-action' ),
		__( 'Mobile CTA Icons', 'mobile-call-to-action' ),
		'manage_options',
		'mcta-options',
		'mcta_options_content'
	 );
}
add_action( 'admin_menu', 'mcta_add_options_page' );

/**
 * Add options page content/form
 */
function mcta_options_content() {
	global $mcta_options;
	//wp_die(MCTA_PLUGIN_DIR);
?>
<div class="wrap">
	<h1><?php _e( 'Mobile Call To Action Settings', 'mcta_options_content' ); ?></h1>
	<form action="options.php" method="post">
		<?php settings_fields( 'mcta_settings_group' ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="mcta_settings[mobile_enable]"><?php _e( 'Enable Phone number', 'mcta_options_content' ); ?></label></th>
					<td><input type="checkbox" id="mcta_settings[mobile_enable]" name="mcta_settings[mobile_enable]" value="1" <?php echo !isset( $mcta_options['mobile_enable'] ) ? 'checked=checked' : checked( $mcta_options['mobile_enable'], 1 ); ?>></td>
				</tr>
				<tr>
					<th scope="row"><label for="mcta_settings[mobile_number]"><?php _e( 'Phone number', 'mcta_options_content' ); ?></label></th>
					<td><input type="text" class="regular-text" id="mcta_settings[mobile_number]" name="mcta_settings[mobile_number]" value="<?php echo isset( $mcta_options['mobile_number'] ) ? $mcta_options['mobile_number'] : "123456789"; ?>"></td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<th scope="row"><label for="mcta_settings[email_enable]"><?php _e( 'Enable Email Address', 'mcta_options_content' ); ?></label></th>
					<td><input type="checkbox" id="mcta_settings[email_enable]" name="mcta_settings[email_enable]" value="1" <?php echo !isset( $mcta_options['email_enable'] ) ? 'checked=checked' : checked( $mcta_options['email_enable'], 1 ); ?>></td>
				</tr>
				<tr>
					<th scope="row"><label for="mcta_settings[email_address]"><?php _e( 'Email Address', 'mcta_options_content' ); ?></label></th>
					<td><input type="email" class="regular-text" id="mcta_settings[email_address]" name="mcta_settings[email_address]" value="<?php echo isset( $mcta_options['email_address'] ) ? $mcta_options['email_address'] : "example@example.com"; ?>"></td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<th scope="row"><label for="mcta_settings[enable_footer_space]"><?php _e( 'Enable Footer Space', 'mcta_options_content' ); ?></label></th>
					<td><input type="checkbox" id="mcta_settings[enable_footer_space]" name="mcta_settings[enable_footer_space]" value="1" <?php echo !isset( $mcta_options['enable_footer_space'] ) ? 'checked=checked' : checked( $mcta_options['enable_footer_space'], 1 ); ?>></td>
				</tr>
				<tr>
					<th scope="row"><label for="mcta_settings[font_size]"><?php _e( 'Icon Font Size', 'mcta_options_content' ); ?></label></th>
					<td><input type="number" id="mcta_settings[font_size]" name="mcta_settings[font_size]" value="<?php echo isset( $mcta_options['font_size'] ) ? $mcta_options['font_size'] : '30'; ?>">
					<p class="description"><?php _e( "Default font size is 30px. Don't use px in the field.", "mobile-call-to-action" ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="mcta_settings[icon_color]"><?php _e( 'Icon Color', 'mcta_options_content' ); ?></label></th>
					<td><input type="text" class="color-field" id="mcta_settings[icon_color]" name="mcta_settings[icon_color]" value="<?php echo isset( $mcta_options['icon_color'] ) ? $mcta_options['icon_color'] : '#f91212'; ?>" data-default-color="#f91212"></td>
				</tr>
				<tr>
					<th scope="row"><label for="mcta_settings[icon_bg_color]"><?php _e( 'Icon Background Color', 'mcta_options_content' ); ?></label></th>
					<td><input type="text" class="color-field" id="mcta_settings[icon_bg_color]" name="mcta_settings[icon_bg_color]" value="<?php echo isset( $mcta_options['icon_bg_color'] ) ? $mcta_options['icon_bg_color'] : '#000000'; ?>" data-default-color="#000000"></td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" class="button button-primary" id="submit" name="submit" value="<?php _e( 'Save Changes', 'mobile-call-to-action' ); ?>"></p>
	</form>
</div>
<?php
}

/**
 * Register Settings to options table
 */
function mcta_save_settings_optoins() {
	register_setting( 'mcta_settings_group', 'mcta_settings' );
}
add_action( 'admin_init', 'mcta_save_settings_optoins' );

/**
 * Dynamic stylesheet from the plugin settings
 */
function mcta_dynamic_stylesheet() {
	global $mcta_options;
	wp_enqueue_style( 'mcta-main-css', MCTA_PLUGIN_DIR."/assets/public/css/mcta-style.css" );

	$body_padding = $mcta_options['enable_footer_space'] == '1' ? "50px" : "0";

	$custom_css = "
		@media (max-width: 767px) {
			.mcta-wrapper .mcta-icons {
				color: {$mcta_options['icon_color']};
				background: {$mcta_options['icon_bg_color']};
			}
			.mcta-wrapper .dashicons {
				font-size: {$mcta_options['font_size']}px;
				line-height: {$mcta_options['font_size']}px;
			}
			body {
				padding-bottom: {$body_padding};
			}
		}
	";

	wp_add_inline_style( 'mcta-main-css', $custom_css );
	wp_enqueue_script( 'mcta-main-js', MCTA_PLUGIN_DIR."/assets/public/js/mcta-main.js", array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'mcta_dynamic_stylesheet' );

/**
 * WP color picker
 */
function mcta_admin_scripts_load( $hook ) {
	if( $hook != 'settings_page_mcta-options' ) {
		return;
	}
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'mcta-admin-js', MCTA_PLUGIN_DIR."/assets/admin/js/mcta-admin.js", array( 'wp-color-picker' ), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'mcta_admin_scripts_load' );

/**
 * Plugin Action Link
 */
function mcta_add_action_links( $links ) {

	$settings = __( 'Settings', 'mobile-call-to-action' );

	$mylinks = array( '<a href="' . admin_url( 'options-general.php?page=mcta-options' ) . '">'.$settings.'</a>' );
	return array_merge( $links, $mylinks );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'mcta_add_action_links' );