<?php
/**
 * WP Campaign Monitor API (https://www.campaignmonitor.com/api/)
 *
 * @package WP-CampaignMonitor-API
 */

/*
* Plugin Name: WP Campaign Monitor API
* Plugin URI: https://github.com/wp-api-libraries/wp-campaignmonitor-api
* Description: Perform API requests to Campaign Monitor in WordPress.
* Author: WP API Libraries
* Version: 1.0.0
* Author URI: https://wp-api-libraries.com
* GitHub Plugin URI:https://github.com/wp-api-libraries/wp-campaignmonitor-api
* GitHub Branch: master
*/

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Check if class exists. */
if ( ! class_exists( 'BasecampAPI' ) ) {


	/**
	 * CampaignMonitorAPI class.
	 */
	class CampaignMonitorAPI {

		/**
		 * api_key
		 *
		 * @var mixed
		 * @access private
		 * @static
		 */
		static private $api_key;

		/**
		 * BaseAPI Endpoint
		 *
		 * @var string
		 * @access protected
		 */
		protected $base_uri = 'https://api.createsend.com/api/v3.1';


		/**
		 * __construct function.
		 *
		 * @access public
		 * @param mixed $api_key
		 * @return void
		 */
		public function __construct( $api_key ){

			static::$api_key = $api_key;

		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_request( $request, $this->args );

			var_dump($response);

			$code = wp_remote_retrieve_response_code($response );
			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'text-domain' ), $code ) );
			}
			$body = wp_remote_retrieve_body( $response );
			return json_decode( $body );
		}

		/* OAUTH. */

		/* ACCOUNT. */


		/**
		 * get_clients function.
		 *
		 * @access public
		 * @return void
		 */
		public function get_clients() {

			$request = $this->base_uri . '/clients' . $ouput;
			return $this->fetch( $request );

		}

		public function get_billing_details() {

		}

		public function get_valid_countries() {

		}

		public function get_valid_timezones() {

		}

		public function get_systemdate() {

		}

		public function add_administrator() {

		}

		public function update_administrator() {

		}

		public function get_administrators() {

		}

		public function get_admin_details() {

		}

		public function delete_admin() {

		}

		public function set_primary_contact() {

		}

		public function get_primary_contact() {

		}

		public function single_sign_on() {

		}


		/* CAMPAIGNS. */

		public function add_draft_campaign( $client_id ) {

		}

		public function add_campaign_from_template( $client_id ) {

		}

		public function send_draft_campaign( $campaign_id ) {

		}

		/* CLIENTS. */

		/* LISTS. */

		/* SEGMENTS. */

		/* SUBSCRIBERS. */

		/* TEMPLATES. */

		/* TRANSACTIONAL. */

		/* WEBHOOKS. */

	}

}
