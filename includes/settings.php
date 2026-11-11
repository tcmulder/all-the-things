<?php
/**
 * Plugin settings.
 *
 * @package Aqua_Pattern_Library
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the current site host for domain-scoped options.
 *
 * @return string
 */
function aqua_patterns_get_current_host() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	return is_string( $host ) ? $host : '';
}

/**
 * Add settings page under Settings.
 */
function aqua_patterns_add_settings_page() {
	add_options_page(
		__( 'Pattern Library', 'aqua-pattern-library' ),
		__( 'Pattern Library', 'aqua-pattern-library' ),
		'manage_options',
		'all-the-things',
		'aqua_patterns_render_settings_page'
	);
}
add_action( 'admin_menu', 'aqua_patterns_add_settings_page' );

/**
 * Register settings.
 */
function aqua_patterns_register_settings() {
	register_setting(
		'all_the_things_settings',
		'all_the_things_for_domain',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'aqua_patterns_sanitize_for_domain',
			'default'           => array(),
		)
	);
}
add_action( 'admin_init', 'aqua_patterns_register_settings' );

/**
 * Sanitize and merge the per-domain public access flag.
 *
 * @param mixed $input Raw submitted value (unused; checkbox is a separate field).
 * @return array
 */
function aqua_patterns_sanitize_for_domain( $input ) {
	unset( $input );

	$host     = aqua_patterns_get_current_host();
	$existing = get_option( 'all_the_things_for_domain', false );
	$enabled  = isset( $_POST['all_the_things_public_access'] )
		&& '1' === sanitize_text_field( wp_unslash( $_POST['all_the_things_public_access'] ) );

	if ( '' === $host ) {
		return is_array( $existing ) ? $existing : array();
	}

	// No option yet and still disabled: skip writing to the database.
	if ( false === $existing && ! $enabled ) {
		add_filter( 'pre_update_option_all_the_things_for_domain', 'aqua_patterns_skip_option_update', 10, 2 );
		return array();
	}

	$domains          = is_array( $existing ) ? $existing : array();
	$domains[ $host ] = $enabled;

	return $domains;
}

/**
 * Prevent creating all_the_things_for_domain when still at default (disabled).
 *
 * @param mixed $value     New value.
 * @param mixed $old_value Old value.
 * @return mixed
 */
function aqua_patterns_skip_option_update( $value, $old_value ) {
	unset( $value );
	remove_filter( 'pre_update_option_all_the_things_for_domain', 'aqua_patterns_skip_option_update', 10 );
	return $old_value;
}

/**
 * Render the settings page.
 */
function aqua_patterns_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$host    = aqua_patterns_get_current_host();
	$domains = get_option( 'all_the_things_for_domain', array() );
	$enabled = is_array( $domains ) && $host && ! empty( $domains[ $host ] );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php settings_fields( 'all_the_things_settings' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<?php esc_html_e( 'Public access', 'aqua-pattern-library' ); ?>
					</th>
					<td>
						<label for="all_the_things_public_access">
							<input
								type="checkbox"
								id="all_the_things_public_access"
								name="all_the_things_public_access"
								value="1"
								<?php checked( $enabled ); ?>
							/>
							<?php esc_html_e( 'Enable public access to patterns for this domain', 'aqua-pattern-library' ); ?>
						</label>
					</td>
				</tr>
			</table>
			<input type="hidden" name="all_the_things_for_domain" value="1" />
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
