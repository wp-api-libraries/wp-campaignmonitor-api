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

// Include base api class.
include_once( 'wp-api-libraries-base.php' );

/* Check if class exists. */
if ( ! class_exists( 'CampaignMonitorAPI' ) ) {
	/**
	 * CampaignMonitorAPI class.
	 */
	class CampaignMonitorAPI extends WpLibrariesBase {
		/**
		 * Api_key
		 *
		 * @var mixed
		 * @access private
		 */
		private $api_key;
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
		private $format;

		/**
		 * Whether to return it pretty printed or not.
		 */
		private $pretty_print;

		/**
		 * __construct function.
		 *
		 * @access public
		 * @param mixed $api_key
		 * @return void
		 */
		public function __construct( $api_key, $format = 'json', $pretty_print = false ) {
			$this->api_key = $api_key;
			$this->format  = $format;
			$this->pretty_print = $pretty_print;
		}

		protected function set_headers(){
			$this->args['headers'] = array(
				'Content-Type' => 'application/json',
				'Authorization' => 'Basic ' . base64_encode( $this->api_key . ':nopass'),
			);
		}

		protected function clear(){
			$this->args = array();
		}

		protected function run( $request, $args = array(), $method = 'GET', $use_other = false ){
			return $this->build_request( $request, $args, $method, $use_other )->fetch();
		}

		protected function build_request( $request, $args = array(), $method = 'GET', $use_other = false ){
			if( $this->pretty_print && $method === 'GET' ) {
				$args += array('pretty' => true );
			}

			if( $use_other === true ){
				return parent::build_request( $request, $args, $method );
			}

			$request .= '.' . $this->format;

			return parent::build_request( $request, $args, $method );
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
			return $this->run( '/clients' );
		}

		/**
		 * Get_billing_details function.
		 *
		 * @access public
		 * return void
		 */
		public function get_billing_details() {
			return $this->run( '/billingdetails' );
		}

		/**
		 * Get_valid_countries function.
		 *
		 * @access public
		 * return void
		 */
		public function get_valid_countries() {
			return $this->run( '/countries' );
		}

		/**
		 * Get_valid_timezones function.
		 *
		 * @access public
		 * return void
		 */
		public function get_valid_timezones() {
			return $this->run( '/timezones' );
		}

		/**
		 * Get current date function.
		 *
		 * @access public
		 * return void
		 */
		public function get_systemdate() {
			return $this->run( '/systemdate' );
		}

		/**
		 * Add_administrator function.
		 *
		 * @access public
		 * return void
		 */
		public function add_administrator( $email, $name ) {

			$args = array(
				'EmailAddress' => $email,
				'Name' => $name,
			);
			return $this->run( '/admins', $args, 'POST' );

		}

		/**
		 * Update an administrator
		 * @param email $email
		 */
		public function update_administrator( $email, $new_email, $new_name ) {

			$request = '/admins.' . $this->format . '?email=' . $email;
			$args = array(
				'EmailAddress' => $email,
				'Name' => $name,
			);
			return $this->run( $request, $args, 'PUT', true );

		}

		/**
		 * Get_administrators function.
		 *
		 * @access public
		 * return void
		 */
		public function get_administrators() {

			return $this->run( '/admins' );

		}

		/**
		 * Get_admin_details function.
		 *
		 * @access public
		 * @param email $email
		 * return void
		 */
		public function get_admin_details( $email ) {

			$args = array(
				'email' => $email,
			);
			return $this->run( '/admins', $args );

		}

		/**
		 * Delete_admin function.
		 *
		 * @access public
		 * @param email $email
		 * return void
		 */
		public function delete_admin( $email ) {

			$request = '/admins' . $this->format . '?email=' . $email;
			return $this->run( $request, array(), 'DELETE', true );

		}

		/**
		 * Set_primary_account.
		 *
		 * @access public
		 * @param email $email
		 * return void
		 */
		public function set_primary_account( $email ) {

			$request = '/primarycontact' . $this->format . '?email=' . $email;

			return $this->run( $request, array(), 'PUT', true );

		}

		/**
		 * Get_primary_account function.
		 *
		 * @access public
		 * return void
		 */
		public function get_primary_account() {
			return $this->run( '/primarycontact' );
		}

		/**
		 * Single_sign_on function.
		 *
		 * @access public
		 * return void
		 */
		public function single_sign_on( $email, $url, $integrator_id, $client_id, $chrome = 'None') {

			$args = array(
				'Email' => $email,
				'Chrome' => $chrome,
				'Url' => $url,
				'IntegratorID' => $integrator_id,
				'ClientID' => $client_id,
			);
			return $this->run( '/externalsession', $args, 'PUT' );

		}

		/** CAMPAIGNS. */

		/**
		 * Add Draft Campaign.
		 * @param string $client_id   [description]
		 * @param string $name        [description]
		 * @param string $subject     [description]
		 * @param string $from_name   [description]
		 * @param string $from_email  [description]
		 * @param string $html_url    [description]
		 * @param array  $list_ids    [description]
		 * @param array  $segment_ids [description]
		 * @param string $reply_to    [description]
		 * @param string $text_url    [description]
		 */
		public function add_draft_campaign( $client_id, $name, $subject, $from_name, $from_email, $html_url, $list_ids, $segment_ids, $reply_to = '', $text_url = '' ) {

			$args = array(
				'Name' => $name,
				'Subject' => $subject,
				'FromName' => $from_name,
				'FromEmail' => $from_email,
				'ReplyTo' => $reply_to,
				'HtmlUrl' => $html_url,
				'ListIDs' => $list_ids,
				'SegmentIDs' => $segment_ids,
			);

			if( $text_url !== '' ){
				$args['TextUrl'] = $text_url;
			}
			return $this->run( '/campaigns/' . $client_d, $args, 'POST' );

		}

		/**
		 * Add_campaign_from_template function.
		 * https://www.campaignmonitor.com/api/campaigns/#creating-campaign-template
		 *
		 * @access public
		 * @param clientid $client_id
		 * return void
		 */
		public function add_campaign_from_template( $client_id, $campaign ) {
			return $this->run( "/campaigns/$client_id/fromtemplate", $campaign, 'POST' );
		}

		/**
		 * Send_draft_campaign function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function send_draft_campaign( $campaign_id, $confirmation_email, $send_date ) {

			$args = array(
				'ConfirmationEmail' => $confirmation_email,
				'SendDate' => $send_date,
			);
			return $this->run( "/campaigns/$campaign_id/send", $args, 'POST' );

		}

		/**
		 * Send_campaign_preview function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function send_campaign_preview( $campaign_id, $preview_recipients, $personalize ) {

			$args = array(
				'PreviewRecipients' => $preview_recipients,
				'Personalize' => $personalize,
			);
			return $this->run( "/campaigns/$campaign_id/sendpreview", $args, 'POST' );

		}

		/**
		 * Get_campaign_summary function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function get_campaign_summary( $campaign_id ) {
			return $this->run( "/campaigns/$campaign_id/summary" );
		}

		/**
		 * Get_list_campaign_clients_emails function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function get_list_campaign_client_emails( $campaign_id ) {
			return $this->run( "/campaigns/$campaign_id/emailclientusage" );
		}

		/**
		 * Get_list_and_segments_campaign function.
		 *
		 * @access public
		 * @param campaignid $campaign_id
		 * return void
		 */
		public function get_lists_and_segments_campaign( $campaign_id ) {
			return $this->run( "/campaigns/$campaign_id/listsandsegments" );
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

			$args = array(
				'page' => $page_number,
				'pagesize' => $paze_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/campaigns/$campaign_id/recipients", $args );

		}

		/**
		 * Get_campaign_bounces function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_bounces( $campaign_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/campaigns/$campaign_id/bounces", $args );

		}

		/**
		 * Get_campaign_opens function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_opens( $campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page_number,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/campaigns/$campaign_id/opens", $args );

		}

		/**
		 * Get_campaign_clicks function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_clicks( $campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page_number,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/campaigns/$campaign_id/clicks", $args );

		}

		/**
		 * Get_campaign_unsubscribes function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_unsubscribes( $campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page_number,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/campaigns/$campaign_id/unsubscribes", $args );

		}

		/**
		 * Get_campaign_spam_complaints function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_campaign_spam_complaints( $campaign_id, $date = '', $page_number = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page_number,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/campaigns/$campaign_id/spam", $args );
		}

		/**
		 * Delete_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function delete_campaign( $campaign_id ) {
			return $this->run( '/campaigns/' . $campaign_id, array(), 'DELETE' );
		}

		/**
		 * Unschedule_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function unschedule_campaign( $campaign_id ) {
			return $this->run( "/campaigns/$campaign_id/unschedule", array(), 'POST' );
		}

		/** CLIENTS. */
		/**
		 * Add_client function.
		 *
		 * @access public
		 * return void
		 */
		public function add_client( $company_name, $country, $timezone ) {

			$args = array(
				'CompanyName' => $company_name,
				'Country' => $country,
				'TimeZone' => $timezone,
			);
			return $this->run( '/clients', $args, 'POST' );
		}

		/**
		 * Get_client_details function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_client_details( $client_id ) {
			return $this->run( '/clients/' . $client_id );
		}

		/**
		 * Get_sent_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_sent_campaign( $client_id ) {
			return $this->run( "/clients/$client_id/campaigns" );
		}

		/**
		 * Get_schedule_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_schedule_campaign( $client_id ) {
			return $this->run( "/clients/$client_id/scheduled" );
		}

		/**
		 * Get_draft_campaign function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_draft_campaign( $client_id ) {
			return $this->run( "/clients/$client_id/drafts" );
		}

		/**
		 * Get_subscriber_lists function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_subscriber_lists( $client_id ) {
			return $this->run( "/clients/$client_id/lists" );
		}

		/**
		 * Get_lists_email_address function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_lists_email_address( $client_id, $email ) {
			return $this->run( "/clients/$client_id/listsforemail", array('email' => $email ) );
		}

		/**
		 * Get_segments function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_segments( $client_id ) {
			return $this->run( "/clients/$client_id/segments" );
		}

		/**
		 * Get_suppression_list function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_suppression_list( $client_id, $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

			$args = array(
				'page' => $page,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/clients/$client_id/suppressionlist", $args );

		}

		/**
		 * Add_suppress_email_address function.
		 * $email_addresses should be an array of emails
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function add_suppress_email_address( $client_id, $email_addresses ) {
			return $this->run( "/clients/$client_id/suppress", array( 'EmailAddresses' => $email_addresses) );
		}

		/**
		 * Delete_supress_email_address function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function delete_supress_email_address( $client_id, $email ) {
			$request = "/clients/$client_id/unsuppress.$this->format?email=$email";
			return $this->run( $request, array(), 'PUT', true );
		}

		/**
		 * Get_templates function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function get_templates( $client_id ) {
			return $this->run( "/clients/$client_id/templates/" );
		}

		/**
		 * Set_setting_basic_details function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function set_setting_basic_details( $client_id, $company_name, $country, $timezone ) {

			$args = array(
				'CompanyName' => $company_name,
				'Country' => $country,
				'TimeZone' => $timezone,
			);
			return $this->run( "/clients/$client_id/setbasics", $args, 'PUT' );

		}

		/**
		 * Set_payg_billing function.
		 *
		 * @access public
		 * @param
		 * return void
		 */
		public function set_payg_billing( $client_id, $currency, $can_purchase_credits, $client_pays, $markup_percentage, $markup_on_delivery, $markup_per_recipient, $markup_on_design_spam_test ) {

			$args = array(
				'Currency' => $currency,
				'CanPurchaseCredits' => $can_purchase_credits,
				'ClientPays' => $client_pays,
				'MarkupPercentage' => $markup_percentage,
				'MarkupOnDelivery' => $markup_on_delivery,
				'MarkupPerRecipient' => $markup_per_recipient,
				'MarkupOnDesignSpamTest' => $markup_on_design_spam_test,
			);
			return $this->run( "/clients/$client_id/setpaygbilling", $args, 'PUT' );

		}

		/**
		 * Setting monthly billing function
		 *
		 * Set if a client can pay for their own campaigns and design and spam tests
		 * using our monthly billing. Set the currency they should pay in plus mark-up
		 * percentage that will apply to the base prices at each pricing tier.
		 *
		 * @access public
		 * @param string $client_id
		 * @param string $currency
		 * @param bool   $client_pays
		 * @param string $monthly_scheme
		 */
		public function set_monthly_billing( $client_id, $currency, $client_pays, $markup_percentage, $monthly_scheme ) {

			$args = array(
				'Currency' => $currency,
				'ClientPays' => $client_pays,
				'MarkupPercentage' => $markup_percentage,
				'MonthlyScheme' => $monthly_scheme,
			);
			return $this->run("/clients/$client_id/setmonthlybilling", $args, 'PUT' );

		}

		/**
		 * Transfer credits function.
		 *
		 * Transfer credits from your account to a client, or transfer credits from
		 * a client to your account. The Credits field should contain either a positive
		 * integer if you wish to allocate credits from your account to a client, or a
		 * negative integer if you wish to deduct credits from a client back into your
		 * account.
		 *
		 * For example, to deduct 200 credits from a client (and transfer those credits
		 * back to your account) you would provide a value of -200 for the Credits field.
		 * And to allocate 200 credits from your account to a client, you would provide
		 * a value of 200 for the Credits field.
		 *
		 * If the CanUseMyCreditsWhenTheyRunOut field is set to true, the client will
		 * be able to continue sending using your credits or payment details once they
		 * run out of credits. If the CanUseMyCreditsWhenTheyRunOut field is set to
		 * false, the client will not be able to continue sending until you allocate
		 * more credits to them.
		 *
		 * @param  string $client_id
		 * @param  int    $credits
		 * @param  bool   $can_use_my_credits
		 * @return object Body containing number of credits belonging to account and client.
		 */
		public function transfer_credits( $client_id, $credits, $can_use_my_credits ) {

			$args = array(
				'Credits' => $credits,
				'CanUseMyCreditsWhenTheyRunOut' => $can_use_my_credits,
			);
			return $this->run( "/clients/$client_id/credits", $args, 'POST' );

		}

		/**
		 * Deleting a client function.
		 *
		 * Delete an existing client from your account.
		 *
		 * @param  string $client_id
		 * @return Object
		 */
		public function delete_client( $client_id ) {
			return $this->run( "/clients/$client_id", array(), 'DELETE' );
		}

		/**
		 * Adding a person.
		 *
		 * https://www.campaignmonitor.com/api/clients/#adding-a-person
		 *
		 * Adds a new person to the client. You can use the permissions helper above
		 * for selecting an appropriate $access.
		 * @param  string $client_id
		 * @param  string $email
		 * @param  string $name
		 * @param  int  	 $access
		 * @param  string $pass
		 */
		public function add_person( $client_id, $email, $name, $access, $pass ) {

			$args = array(
				'EmailAddress' => $email,
				'Name' => $name,
				'AccessLevel' => $access,
				'Password' => $pass,
			);
			return $this->run( "/clients/$client_id/people", $args, 'POST' );

		}

		/**
		 * Update a person.
		 *
		 * https://www.campaignmonitor.com/api/clients/#adding-a-person
		 *
		 * Adds a new person to the client. You can use the permissions helper above
		 * for selecting an appropriate $access.
		 *
		 * @param  string $client_id
		 * @param  string $email
		 * @param  string $name
		 * @param  int  	 $access
		 * @param  string $pass
		 */
		public function update_person( $client_id, $email, $name, $access, $pass ) {

			$args = array(
				'EmailAddress' => $email,
				'Name' => $name,
				'AccessLevel' => $access,
				'Password' => $pass,
			);
			return $this->run( "/clients/$client_id/people", $args, 'PUT' );

		}

		/**
		 * Getting people
		 *
		 * Contains a list of all (active or invited) people associated with a particular
		 * client. This will not include account administrators.
		 *
		 * @param  string $client_id
		 * @return Object            list of all (active or invited) people associated with a particular
		 * client
		 */
		public function get_people( $client_id ) {
			return $this->run( "/clients/$client_id/people" );
		}

		/**
		 * Person details
		 *
		 * Returns the details of a single person associated with a client.
		 *
		 * @param  string $client_id
		 * @param  string $email
		 * @return Object            The details of a single person associated with a client.
		 */
		public function get_person_details( $client_id, $email ) {
			return $this->run( "/clients/$client_id/people", array( 'email' => $email ) );
		}

		/**
		 * Deleting a Person
		 *
		 * Changes the status of an active person to a deleted person. They will no
		 * longer be able to log into this client.
		 *
		 * @param  string $client_id
		 * @param  string $email
		 * @return Object 						OK response
		 */
		public function delete_person( $client_id, $email ) {
			return $this->run( "/clients/$client_id/people.$this->format?email=$email", array(), "DELETE", true );
		}

		/**
		 * Setting primary contact
		 *
		 * Sets the primary contact for the client to be the person with the specified
		 * email address.
		 *
		 * @param  string $client_id
		 * @param  string $email
		 * @return object 					 Email address as a confirmation.
		 */
		public function set_primary_contact( $client_id, $email ) {
			return $this->run( "/clients/$client_id/primarycontact.$this->format?email=$email", array(), "PUT", true );
		}

		/**
		 * Getting primary contact
		 *
		 * Returns the email address of the person who is selected as the primary
		 * contact for this client.
		 *
		 * @param  string $client_id
		 * @return object            Email address of primary contact.
		 */
		public function get_primary_contact( $client_id ) {
			return $this->run( "/clients/$client_id/primarycontact" );
		}

		/** LISTS. */
		/**
		 * Creating a list
 		 *
 		 * Creates a new list into which subscribers can be added or imported. Set the
 		 * list title, landing pages, confirmation setting, and unsubscribe setting.
 		 * Unsubscribe setting must be either AllClientLists or OnlyThisList. If unsubscribe
 		 * setting is set to AllClientLists, when someone unsubscribes from this list
 		 * they will also be unsubscribed from all the client’s lists (recommended).
 		 * If unsubscribe setting is set to OnlyThisList, when someone unsubscribes
 		 * from this list they will only be unsubscribed from this list.
 		 *
		 * @param  string $client_id
		 * @param  string $title
		 * @param  string $unsub_page
		 * @param  string $unsub_setting
		 * @param  string $confirmed_opt_in
		 * @param  string $confirmation_page
		 * @return string 									 ID of new list.
		 */
		public function add_list( $client_id, $title, $unsub_page, $unsub_setting, $confirmed_opt_in, $confirmation_page ) {

			$args = array(
				'Title' => $title,
				'UnsubscribePage' => $unsub_page,
				'UnsubscribeSetting' => $unsub_setting,
				'ConfirmedOptIn' => $confirmed_opt_in,
				'ConfirmationSuccessPage' => $confirmation_page,
			);
			return $this->run( "/lists/$client_id", $args, 'POST' );

		}

		/**
		 * List details
		 *
		 * A basic summary for each list in your account including the name, ID, type
		 * of list (single or confirmed opt-in), any custom unsubscribe and confirmation
		 * URLs you’ve specified, as well as the list’s unsubscribe setting.
		 *
		 * @param  string $list_id
		 * @return object          Details for a single list.
		 */
		public function get_list_details( $list_id ) {
			return $this->run( '/lists/' . $list_id );
		}

		/**
		 * List stats
		 *
		 * Comprehensive summary statistics for each list in your account including
		 * subscriber counts across active, unsubscribed, deleted and bounced as well
		 * as time-based data like new subscribers today, yesterday, this week, month
		 * and year. Here is how we calculate those times:
		 *
		 * @param  string $list_id
		 * @return object          Stats for a list.
		 */
		public function get_list_stats( $list_id ) {
			return $this->run( "/lists/$list_id/stats" );
		}

		/**
		 * List custom fields
		 *
		 * Returns all the custom fields for a given list in your account, including
		 * the type of field, any additional field options you’ve specified, as well
		 * as whether the field is visible in the subscriber preference center.
		 *
		 * @param  string $list_id
		 * @return object          Custom fields for a list.
		 */
		public function get_list_custom_fields( $list_id ) {
			return $this->run( "/lists/$list_id/customfields" );
		}

		/**
		 * List segments
		 *
		 * Returns all the segments you have created for this list including the name,
		 * segment and list ID. You can also create your own segments and manage your
		 * own segment rules via the API.
		 *
		 * @param  string $list_id
		 * @return object          Segments for a list.
		 */
		public function get_list_segments( $list_id ) {
			return $this->run( "/lists/$list_id/segments" );
		}

		/**
		 * Active subscribers
		 *
		 * Contains a paged result representing all the active subscribers for a given
		 * list. This includes their email address, name, date subscribed (in the client’s
		 * timezone), and any custom field data. You have complete control over how
		 * results should be returned including page sizes, sort order and sort direction.
		 *
		 * @param  string  $list_id
		 * @param  string  $date
		 * @param  integer $page
		 * @param  integer $page_size
		 * @param  string  $order_field
		 * @param  string  $order_direction
		 * @return object                   List of current subscribers
		 */
		public function get_active_list_subscribers( $list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'date', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/lists/$list_id/active", $args );

		}

		/**
		 * Unconfirmed subscribers
		 *
		 * Contains a paged result representing all the unconfirmed subscribers (those
		 * who have subscribed to a confirmed-opt-in list, but have not confirmed their
		 * subscription) for a given list. This includes their email address, name,
		 * date subscribed (in the client’s timezone), and any custom field data. You
		 * have complete control over how results should be returned including page
		 * sizes, sort order and sort direction.
		 *
		 * @param  string  $list_id
		 * @param  string  $date
		 * @param  integer $page
		 * @param  integer $page_size
		 * @param  string  $order_field
		 * @param  string  $order_direction
		 * @return object                   List of uncomfirmed subscribers
		 */
		public function get_unconfirmed_subscribers( $list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'date', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/lists/$list_id/uncomfirmed", $args );

		}

		/**
		 * Bounced subscribers
		 *
		 * Contains a paged result representing all the bounced subscribers for a given
		 * list. This includes their email address, name, date bounced (in the client’s
		 * timezone), and any custom field data. You have complete control over how
		 * results should be returned including page sizes, sort order and sort direction.
		 *
		 * @param  string  $list_id
		 * @param  string  $date
		 * @param  integer $page
		 * @param  integer $page_size
		 * @param  string  $order_field
		 * @param  string  $order_direction
		 * @return object                   List of bounced subscribers
		 */
		public function get_bounced_subscriber( $list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/lists/$list_id/bounced", $args );

		}

		/**
		 * Unsubscribed subscribers
		 *
		 * Contains a paged result representing all the unsubscribed subscribers for
		 * a given list. This includes their email address, name, date unsubscribed
		 * (in the client’s timezone), and any custom field data. You have complete
		 * control over how results should be returned including page sizes, sort order
		 * and sort direction.
		 *
		 * @param  string  $list_id
		 * @param  string  $date
		 * @param  integer $page
		 * @param  integer $page_size
		 * @param  string  $order_field
		 * @param  string  $order_direction
		 * @return object                   List of unsubscribed subscribers
		 */
		public function get_deleted_subscribers( $list_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'email', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/lists/$list_id/deleted", $args );

		}

		/**
		 * Updating a list
		 *
		 * Update the basic settings for any list in your account including the name,
		 * type, any subscribe and unsubscribe confirmation pages, as well as the
		 * unsubscribe setting.
		 *
		 * UnsubscribeSetting must be either AllClientLists or OnlyThisList. If set
		 * to AllClientLists, when someone unsubscribes from this list they will also
		 * be unsubscribed from all the client’s lists (recommended). If set to OnlyThisList,
		 * when someone unsubscribes from this list they will only be unsubscribed from
		 * this list. Setting OnlyThisList will result in this list not using the suppression
		 * list, meaning that if a subscriber on this list is added to the suppression list
		 * they will not be unsubscribed from this list.
		 *
		 * If you are updating a list using an UnsubscribeSetting of AllClientLists,
		 * you should also specify AddUnsubscribesToSuppList and ScrubActiveWithSuppList.
		 * If AddUnsubscribesToSuppList is set totrue, anyone who previously unsubscribed
		 * from this list will be added to the suppression list. If ScrubActiveWithSuppList
		 * is set to true, this will scrub all of the active subscribers in this list against
		 * the suppression list.
		 *
		 * @param  string $list_id
		 * @return object          Response confirming
		 */
		public function update_list( $list_id, $title, $unsub_page, $unsub_setting, $confirmed_opt_in, $confirmation_page, $add_unsubs_to_supp_list, $scrub_active_with_supp_list ) {

			$args = array(
				'Title' => $title,
				'UnsubscribePage' => $unsub_page,
				'UnsubscribeSetting' => $unsub_setting,
				'ConfirmedOptIn' => $confirmed_opt_in,
				'ConfirmationSuccessPage' => $confirmation_page,
				'AddUnsubscribesToSuppList' => $add_unsubs_to_supp_list,
				'ScrubActiveWithSuppList' => $scrub_active_with_supp_list,
			);
			return $this->run( "/lists/$list_id", $args, 'PUT' );

		}

		/**
		 * Creating a custom field
		 *
		 * Creates a new custom field for the provided list into which subscriber data
		 * can be added. Set the Custom Field name (from which the Key will be generated),
		 * Data Type, and whether the field should be visible in the subscriber preference
		 * center.
		 *
		 * Available Data Types are Text, Number, MultiSelectOne, MultiSelectMany, Date,
		 * Country and USState. For Multi-Valued fields (MultiSelectOne and MultiSelectMany)
		 * the possible options must also be provided. In the case of Country and USState
		 * fields, the options will be automatically generated and made available when
		 * getting the list’s custom fields.
		 *
		 * @param  string $list_id
		 * @param  string $field_name
		 * @param  string $data_type
		 * @param  array  $options
		 * @param  string $visible_in_center
		 * @return object 									 Confirmation codes.
		 */
		public function add_custom_field( $list_id, $field_name, $data_type, $options, $visible_in_center ) {

			$args = array(
				'FieldName' => $field_name,
				'DataType' => $data_type,
				'Options' => $options,
				'VisibleInPreferenceCenter' => $visible_in_center,
			);
			return $this->run( "/lists/$list_id/customfields", $args, 'POST' );

		}

		/**
		 * Updating a custom field.
		 *
		 * Allows you to update a custom field’s name, as well as whether the field
		 * should be visible in the subscriber preference center. It is important to
		 * note that if you change the name of a custom field, the custom field key
		 * will also be changed. The new key will be returned in the response.
		 *
		 * @param  string $list_id
		 * @param  string $custom_field_key
		 * @return object 								  Confirmation code.
		 */
		public function update_custom_field( $list_id, $custom_field_key, $field_name, $visible_in_center ) {

			$args = array(
				'FieldName' => $field_name,
				'VisibleInPreferenceCenter' => $visible_in_center,
			);
			return $this->run( "/lists/$list_id/customfields/$custom_field_key", $args, 'PUT' );

		}

		/**
		 * Updating custom field options
		 *
		 * Updates the available options for an existing Multi-Valued custom field (MultiSelectOne
		 * or MultiSelectMany). Existing options may be maintained or discarded based on
		 * the value of the KeepExistingOptions property. This will also remove any segment
		 * rules based on the field.
		 *
		 * @param  string $list_id
		 * @param  string $custom_field_key
		 * @param  string $keep_options
		 * @param  array  $options
		 * @return object 								  Confirmation code.
		 */
		public function set_custom_field_options( $list_id, $custom_field_key, $keep_options, $options ) {

			$args = array(
				'KeepExistingOptions' => $keep_options,
				'Options' => $options,
			);
			return $this->run( "/lists/$list_id/customfields/$custom_field_key", $args, 'PUT' );

		}

		/**
		 * Deleting a custom field.
		 *
		 * Deletes a specific custom field from a list. This will also remove any segment rules based on the field.
		 *
		 * @param  string $list_id
		 * @param  string $custom_field_key
		 * @return object                   Confirmation code.
		 */
		public function delete_custom_field( $list_id, $custom_field_key ) {
			return $this->run( "/lists/$list_id/customfields/$custom_field_key", array(), 'DELETE' );
		}

		/**
		 * Deleting a list
		 *
		 * Deletes a subscriber list from your account.
		 *
		 * @param  string $list_id
		 * @return object          Confirmation code.
		 */
		public function delete_list( $list_id ) {
			return $this->run( "/lists/$list_id", array(), 'DELETE' );
		}

		/**
		 * List webhooks
		 *
		 * Returns all the webhooks you have created for this list. For each webhook,
		 * the response includes its ID, URL, status, payload format and the events on
		 * which the webhook will be invoked.
		 *
		 * @param  string $list_id
		 * @return object          Webhooks
		 */
		public function get_list_webhooks( $list_id ) {
			return $this->run( "/lists/$list_id" );
		}

		/**
		 * Creating a webhook
		 *
		 * Creates a new webhook for the provided list. Valid events are Subscribe,
		 * Deactivate, and Update. Valid payload formats are json, and xml.
		 *
		 * @param  string $list_id
		 * @param  array  $events
		 * @param  string $url
		 * @param  string $payload_format
		 * @return object 				        Confirmation object and ID
		 */
		public function add_webhook( $list_id, $events, $url, $payload_format ) {

			$args = array(
				'Events' => $events,
				'Url' => $url,
				'PayloadFormat' => $payload_format,
			);
			return $this->run( "/lists/$list_id/webhooks", $args, 'POST' );

		}

		/**
		 * Testing a webhook
		 *
		 * Attempts to post a webhook payload to the endpoint specified for that webhook.
		 * If multiple events are subscribed to for that webhook, the payload will contain
		 * an example for each event as part of a batch response. Valid payload formats
		 * are json, and xml.
		 *
		 * @param  string $list_id
		 * @param  string $webhook_id
		 * @return object             Response of whether it works or not.
		 */
		public function get_test_webhook( $list_id, $webhook_id ) {
			return $this->run( "/lists/$list_id/webhooks/$webhook_id/test" );
		}

		/**
		 * Deleting a webhook
		 *
		 * Deletes a specific webhook associated with a list.
		 *
		 * @param  string $list_id
		 * @param  string $webhook_id
		 * @return object             Confirmation code.
		 */
		public function delete_webhook( $list_id, $webhook_id ) {
			return $this->run ("/lists/$list_id/webhooks/$webhook_id", array(), 'DELETE' );
		}

		/**
		 * Activating a webhook
		 *
		 * Activate a webhook associated with a list. Note that despite the fact that
		 * this is a PUT request, the body of the request should just be empty.
		 *
		 * @param  string $list_id
		 * @param  string $webhook_id
		 * @return object 				    Confirmation code.
		 */
		public function add_active_webhook( $list_id, $webhook_id ) {
			return $this->run( "/lists/$list_id/webhooks/$webhook_id/activate", array(), 'PUT' );
		}

		/**
		 * Deactivating a webhook
		 *
		 * Deactivate a webhook associated with a list. Note that despite the fact that
		 * this is a PUT request, the body of the request should just be empty.
		 *
		 * @param  string $list_id
		 * @param  string $webhook_id
		 * @return object             Confirmation code.
		 */
		public function delete_active_webhook( $list_id, $webhook_id ) {
			return $this->run( "/lists/$list_id/webhooks/$webhook_id/deactivate", array(), 'PUT' );
		}

		/** SEGMENTS. */
		/**
		 * Creating a segment
		 *
		 * Creates a new segment for a specific list. Please keep in mind that:
		 * 		The RuleGroups collection is optional. Individual RuleGroups can also be
		 * 		added incrementally.
		 *
		 * 	 	RuleGroups can be complicated. The full range of segment rules is available
		 * 	 	through the API, so we have provided more in-depth detail on segment rule
		 * 	 	construction. The example below creates a segment of any subscribers from
		 * 	 	‘domain.com’ who subscribed at any point during the year 2009.
		 *
		 * @param  string $list_id
		 * @param  string $title
		 * @param  array  $rule_groups
		 * @return object 						 Confirmation code and ID.
		 */
		public function add_segment( $list_id, $title, $rule_groups ) {

			$args = array(
				'Title' => $title,
				'RuleGroups' => $rule_groups,
			);
			return $this->run( "/segments/$list_id", $args, 'POST' );

		}

		/**
		 * Updating a segment
		 *
		 * Updates the name of an existing segment and optionally overwrite any existing
		 * segment rules with new rules.
		 *
		 * Updating a segment will always attempt to change the Title, which is compulsory.
		 *
		 * The Rules collection is optional when updating. If it is present, all existing
		 * rules will be deleted before parsing the new ones. If it is not present,
		 * existing rules will remain unchanged.
		 *
		 * @param  string $segment_id
		 * @param  string $title
		 * @param  array  $rule_groups
		 * @return object              Confirmation code.
		 */
		public function update_segment( $segment_id, $title, $rule_groups = '' ) {

			$args = array( 'Title' => $title );

			if( $rule_groups !== '' ){
				$args['RuleGroups'] = $rule_groups;
			}

			return $this->run( "/segments/$segment_id", $args, 'PUT' );

		}

		/**
		 * Adding a segment rulegroup
		 *
		 * Adds a new rulegroup to an existing segment. Adding a RuleGroup will not
		 * remove any existing rulegroups on the segment, but simply add an additional
		 * requirement for membership.
		 *
		 * https://www.campaignmonitor.com/api/segments/#adding-segment-rulegroup
		 *
		 * @param  string $segment_id
		 * @param  array  $rules
		 * @return 										Confirmation code.
		 */
		public function add_segment_rulegroup( $segment_id, $rules ) {
			return $this->run( "/segments/$segment_id/rules", array( 'Rules' => $rules ), 'POST' );
		}

		/**
		 * Getting a segment's details
		 *
		 * Returns the name, list ID, segment ID and number of active subscribers within
		 * an existing segment as well as the current rules for that segment.
		 *
		 * @param  string $segment_id
		 * @return object             Segment's details.
		 */
		public function get_segment_details( $segment_id ) {
			return $this->run( "/segments/$segment_id" );
		}

		/**
		 * Getting active subscribers
		 *
		 * Returns all of the active subscribers that match the rules for a specific
		 * segment. This includes their name, email address, any custom fields and the
		 * date they subscribed. You have complete control over how results should be
		 * returned including page sizes, sort order and sort direction.
		 *
		 * @param  string  $segment_id
		 * @param  string  $date
		 * @param  integer $page
		 * @param  integer $page_size
		 * @param  string  $order_field
		 * @param  string  $order_direction
		 * @return object                   Active subscribers
		 */
		public function get_active_segment_subscribers( $segment_id, $date = '', $page = 1, $page_size = 1000, $order_field = 'date', $order_direction = 'asc' ) {

			$args = array(
				'date' => $date,
				'page' => $page,
				'pagesize' => $page_size,
				'orderfield' => $order_field,
				'orderdirection' => $order_direction,
			);
			return $this->run( "/segments/$segment_id/active", $args );

		}

		/**
		 * Deleting a segment.
		 *
		 * Deletes an existing segment from a subscriber list.
		 * @param  string $segment_id
		 * @return object             Confirmation code.
		 */
		public function delete_segment( $segment_id ) {
			return $this->run( "/segments/$segment_id", array(), 'DELETE' );
		}

		/**
		 * Deleting a segment's rules
		 *
		 * Clears out any existing rules (and parent rulegroups) for a current segment,
		 * basically creating a blank slate where new rules can be added.
		 *
		 * @param  string $segment_id
		 * @return object             Confirmation code.
		 */
		public function delete_segment_rule( $segment_id ) {
			return $this->run( "/segments/$segment_id/rules", array(), 'DELETE' );
		}

		/** SUBSCRIBERS. */

		/**
		 * Adding a subscriber
		 *
		 * This method is built for use in websites and integrations that need to add
		 * subscribers on a instance-by-instance basis, and adds a subscriber to an existing
		 * subscriber list, including custom field data if supplied. If the subscriber
		 * (email address) already exists, their name and any custom field values are
		 * updated with whatever is passed in. The subscriber data is then passed into
		 * a processing queue in Campaign Monitor to be added. For instantaneous adding
		 * or to add subscribers in bulk, please use the Importing Many Subscribers method.
		 *
		 * When specifying a value for a date custom field, avoid the ambiguous date
		 * formats dd/mm/yyyy and mm/dd/yyyy. Instead use an explicit format like yyyy/mm/dd.
		 *
		 * Please note that each custom field value has a data limit of 250 characters.
		 *
		 * Existing custom field data is not cleared if new custom field values are not
		 * provided. Multi-Valued Select Many custom fields are set by providing multiple
		 * Custom Field array items with the same key. Date type custom fields may be
		 * cleared by passing in a value of “0000-00-00”.
		 *
		 * New subscribers only will be sent the follow-up email as configured in the
		 * list settings. If the list has been set as double opt-in, they will be sent
		 * the verification email, otherwise they will be sent the confirmation email
		 * you have set up for the list being subscribed to.
		 *
		 * Please note: If the subscriber is in an inactive state or has previously been
		 * unsubscribed or added to the suppression list and you specify the Resubscribe
		 * input value as true, they will be re-added to the list. Therefore, this method
		 * should be used with caution and only where suitable. If Resubscribe is specified
		 * as false, the subscriber will not be re-added to the active list.
		 *
		 * By default, resubscribed subscribers will not restart any automated workflows,
		 * but they will receive any remaining emails. However, if you specify the
		 * RestartSubscriptionBasedAutoresponders input value as true, any sequences
		 * will be restarted. RestartSubscriptionBasedAutoresponders only affects resubscribing
		 * subscribers, and will default to false if omitted.
		 *
		 * @param  string $list_id
		 * @param  string $email
		 * @param  string $name
		 * @param  array  $custom_fields
		 * @param  bool   $resub
		 * @param  bool   $restart_sub_based_autos
		 * @return object 												 Email for confirmation.
		 */
		public function add_subscriber( $list_id, $email, $name, $custom_fields, $resub, $restart_sub_based_autos ) {

			$args = array(
				'EmailAddress' => $email,
				'Name' => $name,
				'CustomFields' => $custom_fields,
				'Resubscribe' => $resub,
				'RestartSubscriptionBasedAutoresponders' => $restart_sub_based_autos,
			);
			return $this->run( "/subscribers/$list_id", $args, 'POST' );

		}

		/**
		 * Updating a subscriber
		 *
		 * Updates any aspect of an existing subscriber, including email address, name,
		 * and custom field data if supplied.
		 *
		 * When specifying a value for a date custom field, avoid the ambiguous date
		 * formats dd/mm/yyyy and mm/dd/yyyy. Instead use an explicit format like yyyy/mm/dd.
		 *
		 * Please note that each custom field value has a data limit of 250 characters.
		 *
		 * For all custom fields besides Multi-Valued Select Many fields, any missing
		 * values will remain unchanged. When updating Multi-Valued Select Many custom
		 * fields, all options that are selected for that customer need to be passed
		 * through each time an update is made. If you do not pass through all the options
		 * that you wish to have selected for that customer, all historically selected
		 * options will be replaced with what’s included in your most recent call.
		 * Multi-Valued Select Many custom fields are set by providing multiple custom
		 * field array items with the same key.
		 *
		 * To clear the value of a custom field, pass a parameter of Clear with a value
		 * of true along with the custom field name/value. To remove a specific Multi-Valued
		 * Select Many option, pass the option name in the Value field along with the
		 * Clear: true parameter. To clear all values of a Multi-Valued Select Many field,
		 * pass an empty Value along with the Clear: true parameter. Alternatively, Date
		 * type custom fields may be still cleared by passing in a value of “0000-00-00”.
		 *
		 * Note: the email value in the query string is the old email address. Use the
		 * EmailAddress property in the request body to change the email address.
		 *
		 * The update will apply whether the subscriber is active or inactive, although
		 * if the subscriber does not exist, a new one will not be added.
		 *
		 * Inactive subscribers will not be resubscribed unless Resubscribe is set to
		 * true. Operation of the Resubscribe value and associated welcome and confirmation
		 * emails are identical to adding a subscriber, and should therefore be treated
		 * with the same caution.
		 *
		 * By default, resubscribed subscribers will not restart any automated workflows,
		 * but they will receive any remaining emails. However, if you specify the
		 * RestartSubscriptionBasedAutoresponders input value as true, any sequences
		 * will be restarted. RestartSubscriptionBasedAutoresponders only affects
		 * resubscribing subscribers, and will default to false if omitted.
		 *
		 * Any registered Update webhooks will be triggered, whether the subscriber
		 * is inactive or not.
		 *
		 * @param  string $list_id
		 * @param  string $email
		 * @param  string $name
		 * @param  string $custom_fields
		 * @param  bool   $resub
		 * @param  bool   $restart_sub_based_autos
		 * @return object                          Confirmation code.
		 */
		public function update_subscriber( $list_id, $email, $name, $custom_fields, $resub, $restart_sub_based_autos ) {

			$args = array(
				'EmailAddress' => $email,
				'Name' => $name,
				'CustomFields' => $custom_fields,
				'Resubscribe' => $resub,
				'RestartSubscriptionBasedAutoresponders' => $restart_sub_based_autos,
			);
			return $this->run( "/subscribers/$list_id", $args, 'PUT' );

		}

		/**
		 * Importing many subscribers
		 *
		 * Allows you to add many subscribers to a subscriber list in one API request,
		 * including custom field data if supplied. If a subscriber (email address)
		 * already exists, their name and any custom field values are updated with
		 * whatever is passed in. Subscribers will be added instantaneously. The call
		 * will only return back once all subscribers have been added.
		 *
		 * When specifying a value for a date custom field, avoid the ambiguous date
		 * formats dd/mm/yyyy and mm/dd/yyyy. Instead use an explicit format like
		 * yyyy/mm/dd.
		 *
		 * Please note that each custom field value has a data limit of 250 characters.
		 *
		 * Any missing custom field values will remain unchanged. Multi-Valued Select
		 * Many custom fields are set by providing multiple Custom Field array items
		 * with the same key.
		 *
		 * To clear the value of a custom field, pass a parameter of Clear with a value
		 * of true along with the custom field name/value. To remove a specific
		 * Multi-Valued Select Many option, pass the option name in the Value field
		 * along with the Clear: true parameter. To clear all values of a Multi-Valued
		 * Select Many field, pass an empty Value along with the Clear: true parameter.
		 * Alternatively, Date type custom fields may be still cleared by passing in
		 * a value of “0000-00-00”
		 *
		 * New subscribers only will be sent the follow-up email as configured in the
		 * list settings. If the list has been set as double opt-in, they will be sent
		 * the verification email, otherwise they will be sent the confirmation email
		 * you have set up for the list being subscribed to. Also, any registered
		 * Subscribe webhooks will be triggered. If the subscriber is not new, any
		 * registered Update webhooks will be triggered.
		 *
		 * By default, automated workflow emails that are based on the subscription
		 * date will not be sent for subscribers imported with this method. This can
		 * be overridden by setting the QueueSubscriptionBasedAutoResponders parameter
		 * to true.
		 *
		 * Please note: If any subscribers are in an inactive state or have previously
		 * been unsubscribed or added to the suppression list and you specify the Resubscribe
		 * input value as true, they will be re-added to the active list. Therefore,
		 * this method should be used with caution and only where suitable. If Resubscribe
		 * is specified as false, subscribers will not be re-added to the active list.
		 *
		 * By default, resubscribed subscribers will not restart any automated workflow
		 * sequences, but they will receive any remaining emails. However, if you specify
		 * theRestartSubscriptionBasedAutoresponders input value as true, any sequences
		 * will be restarted.RestartSubscriptionBasedAutoresponders only affects
		 * resubscribing subscribers, and will default tofalse if omitted.
		 *
		 * LISTID The ID of the subscriber list to which the subscribers should be added.
		 *
		 * @param  string $list_id
		 * @param  array  $subs
		 * @param  bool   $resub
		 * @param  bool   $queue_sub_based_autos
		 * @param  bool   $restart_sub_based_autos
		 * @return object 												 Confirmation code.
		 */
		public function add_subscribers( $list_id, $subs, $resub, $queue_sub_based_autos, $restart_sub_based_autos ) {

			$args = array(
				'Subscribers' => $subs,
				'Resubscribe' => $resub,
				'QueueSubscriptionBasedAutoResponders' => $queue_sub_based_autos,
				'RestartSubscriptionBasedAutoresponders' => $restart_sub_based_autos,
			);
			return $this->run( "/subscribers/$list_id/import", $args, 'POST' );

		}

		/**
		 * Getting a subscriber's details
		 *
		 * Retrieves a subscriber’s details including their email address, name,
		 * active/inactive state, and any custom field data.
		 *
		 * @param  string $list_id
		 * @param  string $email
		 * @return object          Sub's details
		 */
		public function get_subscriber_details( $list_id, $email ) {
			return $this->run( "/subscribers/$list_id", array( 'email' => $email ) );
		}

		/**
		 * Getting a subscriber's history
		 *
		 * Retrieves a historical record of campaigns and automated workflow emails
		 * received by a subscriber. For each campaign or automated workflow email,
		 * all the subscriber’s actions are recorded, including the event type, the
		 * date, and the IP address from which the event occurred.
		 *
		 * @param  string $list_id
		 * @param  string $email
		 * @return object
		 */
		public function get_subscriber_history( $list_id, $email ) {
			return $this->run( "/subscribers/$list_id", array( 'email' => $email ) );
		}

		/**
		 * Unsubscribing a subscriber
		 *
		 * Changes the status of an Active Subscriber to an Unsubscribed Subscriber
		 * who will no longer receive campaigns sent to the subscriber list to which
		 * they belong.
		 *
		 * If the list is set to add unsubscribing subscribers to the suppression list,
		 * then the subscriber’s email address will also be added to the suppression
		 * list.
		 *
		 * @param  string $list_id
		 * @param  string $email
		 * @return object          Confirmation code.
		 */
		public function unsubscribe_subscriber( $list_id, $email ) {
			return $this->run( "/subscribers/$list_id/unsubscribe", array( '/EmailAddress' => $email ), 'POST' );
		}

		/**
		 * Deleting a subscriber
		 *
		 * Changes the status of an Active Subscriber to a Deleted Subscriber who will
		 * no longer receive campaigns sent to the subscriber list to which they belong.
		 *
		 * This will not result in the subscriber’s email address being added to the
		 * suppression list.
		 *
		 * @param  string $list_id
		 * @param  string $email
		 * @return object          Confirmation code.
		 */
		public function delete_subscriber( $list_id, $email ) {
			return $this->run( "/subscribers/$list_id.$this->format?email=$email", array(), 'DELETE' );
		}

		/** TEMPLATES. */
		/**
		 * Getting a template
		 *
		 * Returns all the basic details for a specific template including the name,
		 * ID, preview URL and screenshot URL.
		 *
		 * @param  string $template_id
		 * @return object              Template
		 */
		public function get_template( $template_id ) {
			return $this->run( "/templates/$template_id" );
		}

		/**
		 * Creating a template.
		 *
		 * Adds a new template for an existing client by providing the name of the
		 * template and URLs for the HTML file and a zip of all other files.
		 *
		 * @param  string $template_id
		 * @param  string $name
		 * @param  string $html_url
		 * @param  string $zip_url
		 * @return 										 Confirmation code and ID.
		 */
		public function add_template( $client_id, $name, $html_url, $zip_url ) {

			$args = array(
				'Name' => $name,
				'HtmlPageURL' => $html_url,
				'ZipFileURL' => $zip_url,
			);
			return $this->run( "/templates/$client_id", $args, 'POST' );

		}

		/**
		 * Updating a template
		 *
		 * Updates an existing template for a client. You can update the name of the
		 * template and URLs for the HTML file and zip file.
		 *
		 * @param  string $template_id
		 * @param  string $name
		 * @param  string $html_url
		 * @param  string $zip_url
		 * @return object              Confirmation code.
		 */
		public function update_template( $template_id, $name, $html_url, $zip_url ) {

			$args = array(
				'Name' => $name,
				'HtmlPageURL' => $html_url,
				'ZipFileURL' => $zip_url,
			);
			return $this->run( "/templates/$template_id", $args, 'PUT' );

		}

		/**
		 * Deleting a template
		 *
		 * Deletes an existing template based on the template ID.
		 *
		 * @param  string $template_id
		 * @return object              Confirmation code.
		 */
		public function delete_template( $template_id ) {
			return $this->run( "/templates/$template_id", array(), 'DELETE' );
		}

		/** TRANSACTIONAL. */

		/**
		 * Smart email listing.
		 *
		 * To get a list of smart transactional emails, filtered by status:
		 *
		 * @param  string $status
		 * @param  string $client_id
		 * @return object            List of responses.
		 */
		public function get_smart_transactional_email_list( $status = 'all', $client_id ) {

			$args = array(
				'status' => $status,
				'clientID' => $client_id
			);
			return $this->run( "/transactiona/smartEmail", $args, 'GET', true );

		}

		/**
		 * Smart email details
		 *
		 * To get the details for a smart transactional email.
		 *
		 * @param  string $smart_email_id
		 * @return object                 Smart email details.
		 */
		public function get_smart_transactional_email_details( $smart_email_id ) {
			return $this->run( "/transactional/smartEmail/$smart_email_id", array(), 'GET', true );
		}

		/**
		 * Send a smart email
		 *
		 * To deliver a smart email.
		 *
		 * @param  string $smart_email_id
		 * @param  string $to
		 * @param  string $cc
		 * @param  string $bcc
		 * @param  array  $attachments
		 * @param  array  $data
		 * @param  bool   $add_recips_to_list
		 * @return Object                     Confirmation code and message.
		 */
		public function send_smart_email( $smart_email_id, $to, $cc, $bcc, $attachments, $data, $add_recips_to_list ) {

			$args = array(
				'To' => $to,
				'CC' => $cc,
				'BCC' => $bcc,
				'Attachments' => $attachments,
				'Data' => $data,
				'AddRecipientsToList' => $add_recips_to_list,
			);
			return $this->run( "/transactional/smartEmail/$smart_email_id", $args, 'POST', true );

		}

		/**
		 * Send classic email
		 *
		 * To send an email providing your own content:
		 *
		 * @param  string $client_id					Optional if you are using a client API key. Otherwise required.
		 * @param  string $subject
		 * @param  string $from
		 * @param  string $reply_to
		 * @param  string $to
		 * @param  string $cc
		 * @param  string $bcc
		 * @param  string $html
		 * @param  string $text								(Default: false) Optional. Text component of the email. If not provided, will be auto-generated.
		 * @param  array  $attachments        (Default: array()) Specifies attachments to include with transactional email. Must include Base64 encoded content, a file name, and file type. All file types accepted.
		 * @param  bool   $track_opens        (Default: true) Whether to track email opens.
		 * @param  bool   $track_clicks				(Default: true) Whether to track link clicks.
		 * @param  bool   $inline_css					(Default: true) Moves any CSS inline to improve compatibility with email clients. True by default.
		 * @param  string $group 							(Default: false) Optional. A name to use for grouping email for reporting.
		 * @param  bool   $add_recips_to_list (Default: false) Optional. The ID of a subscriber list to add all recipients to, including CC/BCC. You must have permission from your recipients before adding them to a subscriber list to send them marketing email.
		 * @return Object                     Body detailing successful email acceptances.
		 */
		public function send_classic_email( $client_id, $subject, $from, $reply_to, $to, $cc, $bcc, $html, $text = false, $attachments = array(), $track_opens = true, $track_clicks = true, $inline_css = true, $group = false, $add_recips_to_list = false ) {

			$args = array(
				'Subject' => $subject,
				'From' => $from,
				'ReplyTo' => $reply_to,
				'To' => $to,
				'CC' => $cc,
				'BCC' => $bcc,
				'Html' => $html,
				'Attachments' => $attachments,
				'TrackOpens' => $track_opens,
				'TrackClicks' => $track_clicks,
				'InlineCSS' => $inline_css,
			);

			if( $text !== false ){
				$args['Text'] = $text;
			}
			if( $group !== false ){
				$args['Group'] = $group;
			}
			if( $add_recips_to_list !== false ){
				$args['AddRecipientsToListID'] = $add_recips_to_list;
			}

			return $this->run( "/transactional/classicEmail/send?clientID=$client_id", $args, 'POST', true );

		}

		/**
		 * Classic email group listing
		 *
		 * To get a list of classic email groups.
		 *
		 * @param  string $client_id [description]
		 * @return [type]            [description]
		 */
		public function get_classic_email_list( $client_id ) {
			return $this->run( "/transactional/classicEmail/groups", array( 'clientID' => $client_id ), 'GET', true );
		}

		/**
		 * Statistics
		 *
		 * To get delivery and engagement statistics, optionally filter by smart email
		 * or classic group.
		 *
		 * @param  string $group     (Default: '') Filter results by Group by supplying
		 *                           a URL-encoded classic group name.
		 * @param  string $from      (Default: 29 days ago) Iso-8601 date in the format
		 *                           YYYY-MM-DD, optional. Default: 29 days ago.
		 * @param  string $to        (Default: today) Iso-8601 date in the format YYYY-MM-DD,
		 *                           optional. Default: Today.
		 * @param  string $time_zone (Default: client's timezone) Values can be utc or
		 *                           client. Default: client’s time zone. When requesting
		 *                           statistics for a specific period of time, you can
		 *                           choose to define that period using either your local
		 *                           time zone or UTC.
		 * @param  string $client_id (Default: '') Optional. Note to agencies: if you
		 *                           are using an account API key or OAuth, this is
		 *                           required as you need to specify the client. This
		 *                           is not necessary if you use a client-specific API key.
		 * @return object            Statistics
		 */
		public function get_email_statistics( $group = '', $from = '', $to = '', $time_zone = '', $client_id = '' ) {

			$args = array(
				'group' => $group,
				'from' => $from,
				'to' => $to,
				'timezone' => $timezone,
				'clientID' => $clientID,
			);
			return $this->run( "/transactional/statistics", $args, 'GET', true );

		}

		/**
		 * Message timeline
		 *
		 * To get a list of sent messages (classic or smart) filtered by group, email
		 * date, and more, do the following.
		 *
		 * @param  string  $group					 (Default: '')
		 * @param  string  $sent_before_id (Default: null) A messageID used for pagination,
		 *                                 returns emails sent before the specified message.
		 * @param  string  $sent_after_id	 (Default: null) A messageID used for pagination,
		 *                                 returns emails sent before the specified message.
		 * @param  integer $count					 (Default: 50)Maximum number of results to
		 *                             		 return in a single request. Maximum: 200.
		 * @param  string  $status         (Default: 'all') Filter messages by status.
		 *                                 Possible values: 'delivered', 'bounced',
		 *                                 'spam', and 'all'.
		 * @param  string  $client_id			 Note to agencies: if you are using an account
		 *                               	 API key or OAuth, this is required as you need
		 *                               	 to specify the client. This is not necessary
		 *                               	 if you use a client-specific API key.
		 * @return object									 List of sent messages following the given filters.
		 */
		public function get_list_message_timeline( $group = '', $sent_before_id = null, $sent_after_id = null, $count = 50, $status = 'all', $client_id = '' ) {

			$args = array(
				'group' => $group,
				'count' => $count,
				'status' => $status,
				'clientID' => $client_id,
			);

			if( $sent_before_id !== null ){
				$args['sentBeforeID'] = $sent_before_id;
			}
			if( $sent_after_id !== null ){
				$args['sentAfterID'] = $sent_after_id;
			}
			return $this->run( "/transactional/messages", $args, 'GET', true );

		}

		/**
		 * Message details
		 *
		 * To get the message details, no matter how it was sent, including status.
		 *
		 * @param  string  $message_id ID of the message.
		 * @param  boolean $statistics (Default: false) Whether to include details opens/clicks.
		 * @return object 						 Message details.
		 */
		public function get_message_details( $message_id, $statistics = false ) {
			return $this->run( "/transactional/messages/$message_id", array( 'statistics' => $statistics ), 'GET', true );
		}

		/**
		 * Resend message
		 *
		 * To resend a message.
		 *
		 * @param  string $message_id ID of the message.
		 * @return object             Confirmation response (or failure).
		 */
		public function resend_message( $message_id ) {
			return $this->run( "/transactional/messages/$message_id/resent", array(), 'POST', true );
		}

		/** WEBHOOKS. */
		// https://www.campaignmonitor.com/api/webhooks/
	}
}
