<?php
defined('ABSPATH') or die("No direct script access!");
/*
* QuantumCloud Promo + Support Page
* Revised On: 18-10-2023
*/

if ( ! defined( 'qc_clr_comments_support_path' ) ) {
    define('qc_clr_comments_support_path', plugin_dir_path(__FILE__));
}

if ( ! defined( 'qc_clr_comments_support_url' ) )
    define('qc_clr_comments_support_url', plugin_dir_url( __FILE__ ) );

if ( ! defined( 'qcld_support_img_url' ) )
    define('qcld_support_img_url', qc_clr_comments_support_url . "/images" );


/*Callback function to add the menu */
function qc_clr_comments_show_promo_page_callback_func(){

    add_submenu_page(
        "comment-link-remove",
        esc_html__('More WordPress Goodies for You!', 'comment-link-remove'),
        esc_html__('Support', 'comment-link-remove'),
        'manage_options',
        "qcclr_comment_supports",
        'qc_clr_comments_promo_support_page_callback_func'
    );
    
} //show_promo_page_callback_func

add_action( 'admin_menu', 'qc_clr_comments_show_promo_page_callback_func', 110 );


/*******************************
 * Main Class to Display Support
 * form and the promo pages
 *******************************/

if ( ! function_exists( 'qc_clr_comments_include_promo_page_scripts' ) ) {	
	function qc_clr_comments_include_promo_page_scripts( ) {   


        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( isset( $_GET['page'] ) && 'qcclr_comment_supports' === sanitize_text_field( wp_unslash( $_GET['page'] ) ) ) {

            wp_enqueue_style( 'qcld-support-fontawesome-css', qc_clr_comments_support_url . "css/font-awesome.min.css", array(), '4.7.0' );                              
            wp_enqueue_style( 'qcld-support-style-css', qc_clr_comments_support_url . "css/style.css", array(), QCCLR_VERSION );

            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'jquery-custom-form-processor', qc_clr_comments_support_url . 'js/support-form-script.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs' ), QCCLR_VERSION, true );

            wp_add_inline_script( 'jquery-custom-form-processor', 
                                    'var qc_clr_comments_ajaxurl    = "' . admin_url('admin-ajax.php') . '";
                                    var qc_clr_comments_ajax_nonce  = "'. wp_create_nonce( 'comment-link-remove' ).'";   
                                ', 'before');
            
        }
	   
	}
	add_action('admin_enqueue_scripts', 'qc_clr_comments_include_promo_page_scripts');
	
}
		
/*******************************
 * Callback function to show the HTML
 *******************************/

include_once qc_clr_comments_support_path . '/qc-clr-recommendbot-support-plugin.php';

if ( ! function_exists( 'qc_clr_comments_promo_support_page_callback_func' ) ) {

	function qc_clr_comments_promo_support_page_callback_func() {
		
?>


        <div class="qc-clr-comments-support qcld-support-new-page">
            <div class="support-btn-main justify-content-center">
                <div class="col text-center">
                    <h2 class="py-3"><?php esc_html_e('Check Out Some of Our Other Works that Might Make Your Website Better', 'comment-link-remove'); ?></h2>
                    <h5><?php esc_html_e('All our Pro Version users get Premium, Guaranteed Quick, One on One Priority Support.', 'comment-link-remove'); ?></h5>
                    <div class="support-btn">
                        <a class="premium-support" href="<?php echo esc_url('https://qc.ticksy.com/'); ?>" target="_blank"><?php esc_html_e('Get Priority Support ', 'comment-link-remove'); ?></a>
                        <a class="premium-support premium-support-kb" href="<?php echo esc_url('https://www.quantumcloud.net/resources/kb-sections/comment-tools/'); ?>" target="_blank"><?php esc_html_e('Online KnowledgeBase', 'comment-link-remove'); ?></a>
                    </div>
                </div>
            
                <div class="qc-column-12" >
                    <div class="support-btn">
                        
                        <a class="premium-support premium-support-free" href="<?php echo esc_url('https://www.quantumcloud.net/resources/free-support/') ?>" target="_blank"><?php esc_html_e('Get Support for Free Version', 'comment-link-remove') ?></a>
                    </div>
                </div>
            </div>
            
            <div class="qcld-plugins-lists">
                <div class="qcld-plugins-loading">
                    <img src="<?php echo esc_url(qcld_support_img_url); ?>/loading.gif" alt="loading">
                </div>
            </div>
        </div>
			
		
<?php
            
       
    }
}


/*******************************
 * Handle Ajex Request for Form Processing
 *******************************/
add_action( 'wp_ajax_qc_clr_comments_process_qc_promo_form', 'qc_clr_comments_process_qc_promo_form' );

if( !function_exists('qc_clr_comments_process_qc_promo_form') ){

    function qc_clr_comments_process_qc_promo_form(){

        check_ajax_referer( 'comment-link-remove', 'security');
        
        $data['status']   = 'failed';
        $data['message']  = esc_html__('Problem in processing your form submission request! Apologies for the inconveniences.<br> 
Please email to <span class="qc-support-email-highlight"> quantumcloud@gmail.com </span> with any feedback. We will get back to you right away!', 'comment-link-remove');

        $name        = isset( $_POST['post_name'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['post_name'] ) ) ) : '';
        $email       = isset( $_POST['post_email'] ) ? trim( sanitize_email( wp_unslash( $_POST['post_email'] ) ) ) : '';
        $subject     = isset( $_POST['post_subject'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['post_subject'] ) ) ) : '';
        $message     = isset( $_POST['post_message'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['post_message'] ) ) ) : '';
        $plugin_name = isset( $_POST['post_plugin_name'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['post_plugin_name'] ) ) ) : '';

        if( $name == "" || $email == "" || $subject == "" || $message == "" )
        {
            $data['message'] = esc_html__('Please fill up all the requried form fields.', 'comment-link-remove');
        }
        else if ( filter_var($email, FILTER_VALIDATE_EMAIL) === false ) 
        {
            $data['message'] = esc_html__('Invalid email address.', 'comment-link-remove');
        }
        else
        {

            //build email body

            $bodyContent = "";
                
            $bodyContent .= "<p><strong>".esc_html__('Support Request Details:', 'comment-link-remove')."</strong></p><hr>";

            $bodyContent .= "<p>".esc_html__('Name', 'comment-link-remove')." : ".$name."</p>";
            $bodyContent .= "<p>".esc_html__('Email', 'comment-link-remove')." : ".$email."</p>";
            $bodyContent .= "<p>".esc_html__('Subject', 'comment-link-remove')." : ".$subject."</p>";
            $bodyContent .= "<p>".esc_html__('Message', 'comment-link-remove')." : ".$message."</p>";

            $bodyContent .= "<p>".esc_html__('Sent Via the Plugin', 'comment-link-remove')." : ".$plugin_name."</p>";

            $bodyContent .="<p></p><p>".esc_html__('Mail sent from:', 'comment-link-remove')." <strong>".get_bloginfo('name')."</strong>, ".esc_html__('URL:', 'comment-link-remove')." [".get_bloginfo('url')."].</p>";
            $bodyContent .="<p>".esc_html__('Mail Generated on:', 'comment-link-remove')." " . gmdate("F j, Y, g:i a") . "</p>";           
            
            $toEmail = "quantumcloud@gmail.com"; //Receivers email address
            //$toEmail = "qc.kadir@gmail.com"; //Receivers email address

            //Extract Domain
            $url = get_site_url();
            $url_parts = wp_parse_url($url);
            $domain = isset($url_parts['host']) ? $url_parts['host'] : '';
            

            $fakeFromEmailAddress = "wordpress@" . $domain;
            
            $to = $toEmail;
            $body = $bodyContent;
            $headers = array();
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: '.esc_attr($name).' <'.esc_attr($fakeFromEmailAddress).'>';
            $headers[] = 'Reply-To: '.esc_attr($name).' <'.esc_attr($email).'>';

            $finalSubject = esc_html__('From Plugin Support Page:', 'comment-link-remove')." " . esc_attr($subject);
            
            $result = wp_mail( $to, $finalSubject, $body, $headers );

            if( $result )
            {
                $data['status'] = 'success';
                $data['message'] = esc_html__('Your email was sent successfully. Thanks!', 'comment-link-remove');
            }

        }

        ob_clean();

        
        wp_send_json( $data );
    }
}