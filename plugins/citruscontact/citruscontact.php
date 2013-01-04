<?php
/*
Plugin Name: Citrus Contact
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: HTML Contact Form in the Footer
Version: 0.3
Author: Milos Soskic (Citrus Mist Ltd)
Author URI: http://citrus-mist.com
License: GPL2
*/

/*  
Copyright 2012  Citrus Mist  (email : info@citrus-mist.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Citrus_Validator{
    function __construct() {


    }
}

class Citrus_Contact{

  public $errors = array();

  private $response = array();

  private $hasError = false;

  private $emailTo = "artificermil@gmail.com";

  private $emailParams = array(
      'userName'  => '',
      'name'      => '',
      'email'     => '',
      'body'      => '',
    );

  function __construct() {
      register_activation_hook( __FILE__, array( &$this, 'activate' ) );
      register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );

      if(is_admin()) {
        add_action('wp_ajax_nopriv_contactprocess', array( &$this, 'process' ));
        add_action('wp_ajax_contactprocess', array( &$this, 'process' ));
        // Load "admin-only" scripts here
      } else {
        add_action('wp_enqueue_scripts',array( &$this, 'enqueue_front_js' ));
        // global $wp_query;
      }
  }
  
  function activate() {
    add_option( 'citrus_contact_enabled', true);
  }

  function deactivate() {
    delete_option( 'citrus_contact_enabled' );
  } // end deactivate

  public function has_errors(){
    return $hasErrors;
  }

  function enqueue_front_js(){
    log_me("Citrus Constructor");
    if(is_author()){
      //Loading 'front-end; scripts
      // embed the javascript file that makes the AJAX request
      wp_enqueue_script( 'citruscontact', 
                          plugin_dir_url( __FILE__ ) . 'js/citruscontact.js', 
                          array('jquery','jquery-ui-core','jquery-ui-widget'), 
                          false, 
                          true
                        );
       
       // declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
      wp_localize_script( 'citruscontact', 'CiCo', array( 
        'ajaxurl'       => admin_url( 'admin-ajax.php' ),
        'formSelector'  => '#frmContact',
        'action'        => 'contactprocess'  
      ));
    }
  }

  function process(){
    $this->emailParams = array(
        'userName'  => trim($_POST['userName']),
        'name'      => trim($_POST['contactName']),
        'email'     => trim($_POST['email']),
        'body'      => stripslashes(trim($_POST['comments'])),
      );
    // response output
    header( "Content-Type: application/json" );
    echo $this->validate();

    if(!$this->hasError) {
      $this->send_email();
    } 
    
    $this->render();
    // IMPORTANT: don't forget to "exit"
    exit;
  }

  function validate(){
    //Check to see if the honeypot captcha field was filled in
    if(trim($_POST['checking']) !== '') {
      $this->add_error('capthcaError', true);
      return;
    } 

    if(!isset($_POST["cico_nonce"]) || 
        !wp_verify_nonce( $_POST["cico_nonce"], wp_get_theme()->Name)){
          $this->add_error('nonceError', true);
          return;
    }

    //Check to make sure that the name field is not empty
    if($this->emailParams['userName'] === '') {
      //TODO: check if the clinician even exists
      $this->add_error('userError', 'You didn\'t specify a clinician.');
    }

    if($this->emailParams['name'] === '') {
      $this->add_error('nameError', 'You forgot to enter your name.');
    }
    
    //Check to make sure sure that a valid email address is submitted
    if($this->emailParams['email'] === '')  {
      $this->add_error('emailError', 'You forgot to enter your email address.');
    } else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+.[A-Z]{2,4}$", $this->emailParams['email'])) {
      $this->add_error('emailError', 'You entered an invalid email address.');
    }
     
    //Check to make sure comments were entered 
    if($this->emailParams['body'] === '') {
      $this->add_error('commentError', 'You forgot to enter your comments.');
    }  
  }

  function send_email(){
    if($this->hasError)
      return false;

    $subject = 'HMG website enquiry';
    $body = "Clinician: {$this->emailParams['userName']} \n\nCustomer Name: {$this->emailParams['name']} \n\nCustomer Email: {$this->emailParams['email']} \n\nEnquiry: {$this->emailParams['body']}";
    $headers = 'From: ' .$this->emailParams['name']. '<'.$this->emailParams['email'].'>' . "\r\n" .
      'Reply-To:' .$this->emailParams['email']. '' . "\r\n" .
      "Return-Path:".$this->emailParams['name']."<".$this->emailParams['email'].">\r\n" .
      "Message-ID: <" . date("YdmHis") . ".TheSystem@".$_SERVER['SERVER_NAME'].">" . "\r\n".
      'X-Mailer: PHP/' . phpversion();
     
    mail($this->emailTo, $subject, $body, $headers);
  } 
  
  public function add_error($key, $val){
    $this->hasError = true;
    $this->errors[$key] = $val;
  }

  public function render(){
    if(!$this->hasError){
      echo json_encode(array(
        'success' => true,
      ));
      return;
    }

    echo json_encode(array( 
      'success' => false ,
      'errors'  => $this->errors 
    ));
  }
}
new Citrus_Contact();
?>
