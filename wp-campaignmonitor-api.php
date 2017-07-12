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

		public function set_administrator($email) {

		}

		public function get_administrators() {

		}

		public function get_admin_details($email) {

		}

		public function delete_admin($email) {

		}

		public function set_primary_account($email) {

		}

		public function get_primary_account() {

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

		public function send_campaign_draft($campaign_id){

		}

		public function send_campaign_preview($campaign_id){

		}

		public function get_campaign_summary($campaign_id){

		}

		public function get_list_campaign_client_emails($campaign_id){

		}

		public function get_lists_and_segments_campaign($campaign_id){

		}
		public function get_campaign_recipients($campaign_id, $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc'){

		}

		public function get_campaign_bounces( $campaign_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

		}

		public function get_campaign_opens($campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc'){

		}

		public function get_campaign_clicks($campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc'){

		}

		public function get_campaign_unsubscribes($campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc'){

		}

		public function get_campaign_spam_complaints($campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc'){

		}

		public function delete_campaign($campaign_id){

		}

		public function unschedule_campaign($campaign_id){

		}
		/* CLIENTS. */
		public function add_client(){

		}
		public function get_client_details($client_id){

		}
		public function get_sent_campaign($client_id){

		}

		public function get_sschedule_campaign($client_id){

		}

		public function get_draft_campaign($client_id){

		}

		public function get_subscriber_lists($client_id){

		}

		public function get_lists_email_address($client_id, $email){

		}

		public function get_segments($client_id){

		}

		public function get_suppression_list($client_id, $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc'){

		}

		public function add_suppress_email_address($client_id){

		}

		public function delete_supress_email_address($client_id, $email){

		}

		public function get_templates($client_id){

		}

		public function set_setting_basic_details($client_id){

		}

		public function set_PAYG_billing($client_id){

		}

		public function set_monthly_billing($client_id){

		}

		public function transfer_credits($client_id){

		}

		public function delete_client($client_id){

		}

		public function add_person($client_id){

		}

		public function set_person($client_id, $email){

		}

		public function get_people($client_id){

		}

		public function get_person_details($client_id, $email){

		}

		public function delete_person($client_id, $email){

		}

		public function set_primary_contact($client_id, $email){

		}

		public function get_primary_contact($client_id){

		}

		/* LISTS. */

		public function add_list($client_id){

		}

		public function get_list_details($list_id){

		}

		public function get_list_stats($list_id){

		}

		public function get_list_custom_fields($list_id){

		}

		public function get_list_segments($list_id){

		}

		public function get_active_list_subscribers($list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'date', $order_direction = 'asc'){

		}

		public function get_unconfirmed_subscribers($list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'date', $order_direction = 'asc'){

		}

		public function get_bounced_subscriber($list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc'){

		}

		public function get_deleted_subscribers($list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc'){

		}

		public function set_list($list_id){

		}

		public function add_custom_field($list_id){

		}

		public function set_custom_field($list_id, $custom_field_key){

		}

		public function set_custom_field_options($list_id, $custom_field_key){

		}

		public function delete_custom_field($list_id, $custom_field_key){

		}

		public function delete_list($list_id){

		}

		public function get_list_webhooks($list_id){

		}

		public function add_webhook($list_id){

		}

		public function get_test_webhook($list_id, $webhook_id){

		}

		public function delete_webhook($list_id, $webhook_id){

		}

		public function add_active_webhook($list_id, $webhook_id){

		}

		public function delete_active_webhook($list_id, $webhook_id){

		}

		/* SEGMENTS. */
		public function add_segment($list_id){

		}

		public function set_segment($segment_id){

		}

		public function add_segment_rulegroup($segment_id){

		}

		public function get_segment_details($segment_id){

		}

		public function get_active_segment_subscribers($segment_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'date', $order_direction = 'asc'){

		}

		public function delete_segment($segment_id){

		}

		public function delete_segment_rule($segment_id){

		}

		/* SUBSCRIBERS. */

		public function add_subscriber($list_id){

		}

		public function set_subscriber($list_id, $email){

		}

		public function add_subscribers($list_id){

		}

		public function get_subscriber_details($list_id, $email){

		}

		public function get_subscriber_history($list_id, $email){

		}

		public function delete_active_subscriber($list_id){

		}

		public function delete_subscriber($list_id, $email){

		}

		/* TEMPLATES. */
		public function get_template($template_id){

		}

		public function add_template($template_id){

		}

		public function set_template($template_id){

		}

		public function delete_template($template_id){

		}

		/* TRANSACTIONAL. */
		public function get_smart_transactional_email_list($status = 'all', $client_id){

		}

		public function get_smart_transactional_email_details($smart_email_id){

		}

		public function send_smart_email($smart_email_id){

		}

		public function send_classic_email($client_id){

		}

		public function get_classic_email_list($client_id){

		}

		public function get_email_statistics($group = '', $from = '2017-06-13', $to = '2017-07-12', $time_zone = 'PCT', $client_id){

		}

		public function get_list_message_timeline($group = '', $sent_before_id = null, $sent_after_id = null, $count = 50, $status = 'all', $client_id){

		}

		public function get_message_details($message_id, $statistics = false){

		}

		public function resend_message($message_id){

		}

		/* WEBHOOKS. */

	}

}
