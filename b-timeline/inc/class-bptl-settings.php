<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'BPTLSettings' ) ) {

	/**
	 * Dashboard settings store + AJAX bridge for the "Settings" tab.
	 *
	 * Mirrors TLGBOptions in the Timeline Block plugin so both dashboards
	 * behave identically.
	 */
	class BPTLSettings {

		public function __construct() {
			add_action( 'wp_ajax_bptlSaveUninstallOption', [ $this, 'save_uninstall_option' ] );
		}

		public static function get_options() {
			$defaults = [
				'delete_data_on_uninstall' => false,
			];

			$options = get_option( 'bptl_options', [] );

			return wp_parse_args( is_array( $options ) ? $options : [], $defaults );
		}

		public static function update_options( $new_options ) {
			$options = self::get_options();
			$updated_options = array_merge( $options, $new_options );
			return update_option( 'bptl_options', $updated_options );
		}

		public function save_uninstall_option() {
			check_ajax_referer( 'bptlSaveUninstallOption', 'nonce' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( __( 'Permission denied.', 'b-timeline' ) );
			}

			$enabled = isset( $_POST['enabled'] ) && 'true' === sanitize_text_field( wp_unslash( $_POST['enabled'] ) );

			self::update_options( [ 'delete_data_on_uninstall' => $enabled ] );

			wp_send_json_success( [
				'enabled' => $enabled,
				'message' => $enabled
					? __( 'All plugin data will be deleted when uninstalled.', 'b-timeline' )
					: __( 'Plugin data will be preserved when uninstalled.', 'b-timeline' )
			] );
		}
	}

	new BPTLSettings();
}
