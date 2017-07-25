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
if ( ! class_exists( 'CampaignMonitorAPI' ) ) {
	/**
	 * CampaignMonitorAPI class.
	 */
	class CampaignMonitorAPI {
		/**
		 * Api_key
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
		 * param mixed $api_key
		 * @access protected
		 */
		protected $base_uri = 'https://api.createsend.com/api/v3.1';

		/**
		 * Return format. XML or JSON.
		 *
		 * @var [string
		 */
		static private $format;

		/**
		 * Password
		 *
		 * @var [string
		 */
		static private $password;


		/**
		 * __construct function.
		 *
		 * @access public
		 * @param mixed $api_key
		 * @return void
		 */
		public function __construct( $api_key, $password, $format = 'json' ) {

			static::$api_key = $api_key;
			static::$password = $password;
			static::$format  = $format;

			$this->args['headers'] = array(
				'Content-Type' => 'application/json',
				'Authorization' => 'Basic ' . base64_encode($api_key.':'.$password),
			);
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

			$code = wp_remote_retrieve_response_code( $response );
			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'wp-campaignmonitor-api' ), $code ) );
			}
			$body = wp_remote_retrieve_body( $response );
			return json_decode( $body );
		}
		/** OAUTH. */

		/** ACCOUNT. */
		/**
		 * Get_clients function.
		 *
		 * @access public
		 * return void
		 */
		public function get_clients() {

			$request = $this->base_uri . '/clients.' . static::$format . '?pretty=true';
			return $this->fetch( $request );

		}
		/**
		 * Get_billing_details function.
		 *
		 * @access public
		 * return void
		 */
		public function get_billing_details() {

		}
		/**
		 * Get_valid_countries function.
		 *
		 * @access public
		 * return void
		 */
		public function get_valid_countries() {

		}
		/**
		 * Get_valid_timezones function.
		 *
		 * @access public
		 * return void
		 */
		public function get_valid_timezones() {

		}
		/**
		 * Get_systemdate function.
		 *
		 * @access public
		 * return void
		 */
		public function get_systemdate() {

		}

		/**
		 * Add_administrator function.
		 *
		 * @access public
		 * return void
		 */
		public function add_administrator() {

		}
		/**
		* Set_administrator
		 * @param email $email
		 */
		public function set_administrator( $email ) {

		}
		/**
		 * Get_administrators function.
		 *
		 * @access public
		 * return void
		 */
		public function get_administrators() {

		}
		/**
		 * Get_admin_details function.
		 *
		 * @access public
		 * @param email $email
		 * return void
		 */
		public function get_admin_details( $email ) {

		}
		/**
		 * Delete_admin function.
		 *
		 * @access public
		 * @param email $email
		 * return void
		 */
		public function delete_admin( $email ) {

		}
		/**
		 * Set_primary_account.
		 *
		 * @access public
		 * @param email $email
		 * return void
		 */
		public function set_primary_account( $email ) {

		}
		/**
		 * Get_primary_account function.
		 *
		 * @access public
		 * return void
		 */
		public function get_primary_account() {

		}
		/**
		 * Single_sign_on function.
		 *
		 * @access public
		 * return void
		 */
		public function single_sign_on() {

		}
		/** CAMPAIGNS. */
		/**
		 * Add_draft_campaign function.
		 *
		 * @access public
		 * @param clientid $client_id
		 * return void
		 */
		public function add_draft_campaign( $client_id ) {

		}
		/**
		 * Add_campaign_from_template function.
		 *
		 * @access public
		 * @param clientid $client_id
		 * return void
		 */
		public function add_campaign_from_template( $client_id ) {

		}
		/**
		 * Send_draft_campaign function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function send_draft_campaign( $campaign_id ) {

		}
		/**
		 * Send_campaign_draft function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function send_campaign_draft( $campaign_id ) {

		}
		/**
		 * Send_campaign_preview function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function send_campaign_preview( $campaign_id ) {

		}
		/**
		 * Get_campaign_summary function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function get_campaign_summary( $campaign_id ) {

		}
		/**
		 * Get_list_campaign_clients_emails function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function get_list_campaign_client_emails( $campaign_id ) {

		}
		/**
		 * Get_list_and_segments_campaign function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function get_lists_and_segments_campaign( $campaign_id ) {

		}
		/**
		 * Get_campaign_recipients function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * @param int $page_number
		 * @param int $page_size
		 * @param string $order_field
		 * @param string $order_direction
		 * return void
		 */
		public function get_campaign_recipients( $campaign_id, $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}
		/**
		 * Get_campaign_bounces function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_bounces( $campaign_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}
		/**
		 * Get_campaign_opens function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_opens( $campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}
		/**
		 * Get_campaign_clicks function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_clicks( $campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}
		/**
		 * Get_campaign_unsubscribes function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_unsubscribes( $campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}
		/**
		 * Get_campaign_spam_complaints function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_spam_complaints( $campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}
		/**
		 * Delete_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function delete_campaign( $campaign_id ) {

		}
		/**
		 * Unschedule_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function unschedule_campaign( $campaign_id ) {

		}
		/** CLIENTS. */
		/**
		 * Add_client function.
		 *
		 * @access public
		 * return void
		 */
		public function add_client() {

		}
		/**
		 * Get_client_details function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_client_details( $client_id ) {

		}
		/**
		 * Get_sent_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_sent_campaign( $client_id ) {

		}
		/**
		 * Get_schedule_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_schedule_campaign( $client_id ) {

		}
		/**
		 * Get_draft_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_draft_campaign( $client_id ) {

		}
		/**
		 * Get_subscriber_lists function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_subscriber_lists( $client_id ) {

		}
		/**
		 * Get_lists_email_address function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_lists_email_address( $client_id, $email ) {

		}
		/**
		 * Get_segments function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_segments( $client_id ) {

		}
		/**
		 * Get_suppression_list function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_suppression_list( $client_id, $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}
		/**
		 * Add_suppress_email_address function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function add_suppress_email_address( $client_id ) {

		}
		/**
		 * Delete_supress_email_address function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function delete_supress_email_address( $client_id, $email ) {

		}
		/**
		 * Get_templates function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_templates( $client_id ) {

		}
		/**
		 * Set_setting_basic_details function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function set_setting_basic_details( $client_id ) {

		}
		/**
		 * Set_payg_billing function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function set_payg_billing( $client_id ) {

		}
		/**
		 * Set_monthly_billing function
		 * @access public
		 * @param
		 */
		public function set_monthly_billing( $client_id ) {

		}
		public function transfer_credits( $client_id ) {

		}
		public function delete_client( $client_id ) {

		}
		public function add_person( $client_id ) {

		}
		public function set_person( $client_id, $email ) {

		}
		public function get_people( $client_id ) {

		}
		public function get_person_details( $client_id, $email ) {

		}
		public function delete_person( $client_id, $email ) {

		}
		public function set_primary_contact( $client_id, $email ) {

		}
		public function get_primary_contact( $client_id ) {

		}
		/** LISTS. */
		public function add_list( $client_id ) {

		}
		public function get_list_details( $list_id ) {

			$request = $this->base_uri . '/lists/' . $list_id . static::$format;
			return $this->fetch( $request );

		}
		public function get_list_stats( $list_id ) {

		}
		public function get_list_custom_fields( $list_id ) {

		}
		public function get_list_segments( $list_id ) {

		}
		public function get_active_list_subscribers( $list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'date', $order_direction = 'asc' ) {

		}
		public function get_unconfirmed_subscribers( $list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'date', $order_direction = 'asc' ) {

		}
		public function get_bounced_subscriber( $list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}
		public function get_deleted_subscribers( $list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}
		public function set_list( $list_id ) {

		}
		public function add_custom_field( $list_id ) {

		}
		public function set_custom_field( $list_id, $custom_field_key ) {

		}
		public function set_custom_field_options( $list_id, $custom_field_key ) {

		}
		public function delete_custom_field( $list_id, $custom_field_key ) {

		}
		public function delete_list( $list_id ) {

		}
		public function get_list_webhooks( $list_id ) {

		}
		public function add_webhook( $list_id ) {

		}
		public function get_test_webhook( $list_id, $webhook_id ) {

		}
		public function delete_webhook( $list_id, $webhook_id ) {

		}
		public function add_active_webhook( $list_id, $webhook_id ) {

		}
		public function delete_active_webhook( $list_id, $webhook_id ) {

		}
		/** SEGMENTS. */
		public function add_segment( $list_id ) {

		}
		public function set_segment( $segment_id ) {

		}
		public function add_segment_rulegroup( $segment_id ) {

		}
		public function get_segment_details( $segment_id ) {

		}
		public function get_active_segment_subscribers( $segment_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'date', $order_direction = 'asc' ) {

		}
		public function delete_segment( $segment_id ) {

		}
		public function delete_segment_rule( $segment_id ) {

		}
		/** SUBSCRIBERS. */
		public function add_subscriber( $list_id ) {

		}
		public function set_subscriber( $list_id, $email ) {

		}
		public function add_subscribers( $list_id ) {

		}
		public function get_subscriber_details( $list_id, $email ) {

		}
		public function get_subscriber_history( $list_id, $email ) {

		}
		public function delete_active_subscriber( $list_id ) {

		}
		public function delete_subscriber( $list_id, $email ) {

		}
		/** TEMPLATES. */
		public function get_template( $template_id ) {

		}
		public function add_template( $template_id ) {

		}
		public function set_template( $template_id ) {

		}
		public function delete_template( $template_id ) {

		}
		/** TRANSACTIONAL. */
		public function get_smart_transactional_email_list( $status = 'all', $client_id ) {

		}
		public function get_smart_transactional_email_details( $smart_email_id ) {

		}
		public function send_smart_email( $smart_email_id ) {

		}
		public function send_classic_email( $client_id ) {

		}
		public function get_classic_email_list( $client_id ) {

		}
		public function get_email_statistics( $group = '', $from = '2017-06-13', $to = '2017-07-12', $time_zone = 'PCT', $client_id ) {

		}
		public function get_list_message_timeline( $group = '', $sent_before_id = null, $sent_after_id = null, $count = 50, $status = 'all', $client_id ) {

		}
		public function get_message_details( $message_id, $statistics = false ) {

		}
		public function resend_message( $message_id ) {

		}
		/** WEBHOOKS. */
	}
}
