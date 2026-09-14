<?php
defined('ABSPATH') or die("No direct script access!");
/*
* QuantumCloud Promo + Ai Chatbot Page
* Revised On: 05-05-2026
*/

if ( ! defined( 'qc_clr_free_ai_support_path' ) ) {
    define('qc_clr_free_ai_support_path', plugin_dir_path(__FILE__));
}

if ( ! defined( 'qc_clr_free_ai_support_url' ) )
    define('qc_clr_free_ai_support_url', plugin_dir_url( __FILE__ ) );

if ( ! defined( 'qc_clr_free_ai_img_url' ) )
    define('qc_clr_free_ai_img_url', qc_clr_free_ai_support_url . "/images" );


/*Callback function to add the menu */
if ( ! function_exists( 'qc_clr_free_ai_show_promo_page_callback_func' ) ) {
    function qc_clr_free_ai_show_promo_page_callback_func(){

        add_submenu_page(
            "comment-link-remove",
            esc_html__('Try our Free AI ChatBot - WPBot', 'comment-link-remove'),
            esc_html__('Try our Free AI ChatBot - WPBot', 'comment-link-remove'),
            'manage_options',
            "qc_clr_free_ai",
            'qc_clr_free_ai_promo_support_page_callback_func'
        );
        
    }
}
add_action( 'admin_menu', 'qc_clr_free_ai_show_promo_page_callback_func', 1000 );



/*******************************
 * Main Class to Display Support
 * form and the promo pages
 *******************************/

if ( ! function_exists( 'qc_clr_free_ai_include_promo_page_scripts' ) ) {	
	function qc_clr_free_ai_include_promo_page_scripts( ) {   


        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( isset( $_GET['page'] ) && 'qc_clr_free_ai' === sanitize_text_field( wp_unslash( $_GET['page'] ) ) ) {
                             
            wp_enqueue_style( 'qc_clr_free_ai_css', qc_clr_free_ai_support_url . 'css/qc-ai-free-style.css', array(), QCCLR_VERSION );

            wp_enqueue_script( 'jquery' );

            wp_enqueue_script( 'qc_clr_free_ai_js', qc_clr_free_ai_support_url . 'js/qc-ai-free-script.js', array('jquery'), QCCLR_VERSION, true );

            wp_add_inline_script( 'qc_clr_free_ai_js', 
                                    'var qc_clr_free_ai_ajaxurl    = "' . admin_url('admin-ajax.php') . '";
                                    var qc_clr_free_ai_ajax_nonce  = "'. wp_create_nonce( 'comment-link-remove' ).'";   
                                ', 'before');
            
        }
	   
	}
	add_action('admin_enqueue_scripts', 'qc_clr_free_ai_include_promo_page_scripts');
	
}
		
/*******************************
 * Callback function to show the HTML
 *******************************/

include_once qc_clr_free_ai_support_path . '/qc-ai-free-plugin.php';

if ( ! function_exists( 'qc_clr_free_ai_promo_support_page_callback_func' ) ) {

	function qc_clr_free_ai_promo_support_page_callback_func() {
		
?>

        <div class="wrap">
            <div class="qc_clr_free_ai-wrapper">
                <header class="qc_clr_free_ai-header">
                    <h3><?php esc_html_e('Get the Best ChatBot for WordPress – WPBot', 'comment-link-remove'); ?></h3>
                    <p><?php esc_html_e('Do more than just chat with your ChatBot!', 'comment-link-remove'); ?></p>
                    
                                        
                </header>

                <div class="qc_clr_free_ai-grid">
                    <!-- Section: Getting Started -->
                 
                    <div class="qc_clr_free_ai-card">
                        <div class="qc_clr_free_ai-content">
                            <p><b><?php esc_html_e('Do more than just chat with your ChatBot', 'comment-link-remove'); ?></b>! <?php esc_html_e('More Leads, Conversions', 'comment-link-remove'); ?> &amp; <?php esc_html_e('Satisfied customers while', 'comment-link-remove'); ?> <strong><?php esc_html_e('saving time', 'comment-link-remove'); ?></strong> &amp; <?php esc_html_e('increasing your', 'comment-link-remove'); ?> <strong><?php esc_html_e('business opportunities', 'comment-link-remove'); ?></strong>. <?php esc_html_e('WPBot is the best ChatBot for WordPress to improve user engagement,', 'comment-link-remove'); ?> <b><?php esc_html_e('Generate Leads,', 'comment-link-remove'); ?></b> &amp; <?php esc_html_e('provide', 'comment-link-remove'); ?> <b><?php esc_html_e('Automated Live', 'comment-link-remove'); ?>&nbsp;</b><?php esc_html_e('customer', 'comment-link-remove'); ?> <strong><?php esc_html_e('support', 'comment-link-remove'); ?></strong> <?php esc_html_e('across your website', 'comment-link-remove'); ?> &amp; <?php esc_html_e('social platforms.', 'comment-link-remove'); ?>&nbsp;<?php esc_html_e('The', 'comment-link-remove'); ?> <strong><?php esc_html_e('AI Insight', 'comment-link-remove'); ?></strong> <?php esc_html_e('feature analyzes chat histories', 'comment-link-remove'); ?> &amp; <?php esc_html_e('reveals what your users want.', 'comment-link-remove'); ?></p> <p> <?php esc_html_e('Deliver AI-powered ChatBot services from your websites with LLMs like', 'comment-link-remove'); ?> <b><?php esc_html_e('OpenAI', 'comment-link-remove'); ?> </b> <?php esc_html_e('(ChatGPT), Gemini etc. along with many built-in, powerful features like', 'comment-link-remove'); ?> <b><?php esc_html_e('Live', 'comment-link-remove'); ?></b>&nbsp;<?php esc_html_e('Chat, Chat', 'comment-link-remove'); ?> <b><?php esc_html_e('Histories', 'comment-link-remove'); ?></b>, <b><?php esc_html_e('Conversational forms', 'comment-link-remove'); ?></b>, <strong><?php esc_html_e('Webhooks', 'comment-link-remove'); ?></strong> &amp; <?php esc_html_e('more!', 'comment-link-remove'); ?>&nbsp;</p> 
                        </div>        
                        
                        <div class="qc_clr_free_ai_loading">
                            <img src="<?php echo esc_url(qc_clr_free_ai_img_url); ?>/loading.gif" alt="loading">
                        </div>
                    </div>

                </div>

                <div class="qc_clr_free_ai-footer">
                    <h3><?php esc_html_e('Need More Assistance?', 'comment-link-remove'); ?></h3>
                    <p><?php esc_html_e('Our support team is ready to help you with any issues or custom requests.', 'comment-link-remove'); ?></p>
                    <div class="qc_clr_free_ai_btn-group">
                        <a href="<?php echo esc_url('https://www.wpbot.pro/docs/'); ?>" target="_blank" class="qc_clr_free_ai_btn-docs"><?php esc_html_e('Knowledge Base', 'comment-link-remove'); ?></a>
                        <a href="<?php echo esc_url('https://www.wpbot.pro/free-support/'); ?>" target="_blank" class="qc_clr_free_ai_btn-support"><?php esc_html_e('Get Direct Support', 'comment-link-remove'); ?></a>
                    </div>
                    <div class="qc-free-ai-note">
                        <p><small>&copy; QuantumCloud. <?php esc_html_e('Handcrafted for productivity.', 'comment-link-remove'); ?></small></p>
                    </div>
                </div>

            </div>
        </div>
			

<?php
            
       
    }
}
