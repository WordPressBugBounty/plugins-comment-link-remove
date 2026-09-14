<?php
defined('ABSPATH') or die("No direct script access!");

/**
 * Options Page - CLR
 */

class CommentLinkRemove {

    private $comment_link_remove_options;

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'comment_link_remove_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'comment_link_remove_page_init' ) );
        add_action( 'admin_init', array( $this, 'comment_link_remove_page_init_9' ) );
        add_action( 'admin_init', array( $this, 'comment_link_remove_page_init_10' ) );
        add_action( 'admin_init', array( $this, 'comment_link_remove_page_init_8' ) );
        add_action( 'admin_init', array( $this, 'comment_link_remove_page_init_6' ) );
        add_action( 'admin_init', array( $this, 'comment_link_remove_page_init_2' ) );
        add_action( 'admin_init', array( $this, 'comment_link_remove_page_init_3' ) );
        add_action( 'admin_init', array( $this, 'comment_link_remove_page_init_4' ) );
        add_action( 'admin_init', array( $this, 'comment_link_remove_page_init_5' ) );
    }

    public function comment_link_remove_add_plugin_page() {

        include_once 'class-qcld-free-plugin-upgrade-notice.php';
        
        add_menu_page(
            __('Comment Link Remove & Comment Tools', 'comment-link-remove'), // page_title
            __('Comment Tools', 'comment-link-remove'), // menu_title
            'manage_options', // capability
            'comment-link-remove', // menu_slug
            array( $this, 'comment_link_remove_create_admin_page' ), // function
            $icon_url = '',
            25
        );


      /*  add_menu_page(
            __('Comment Tools Pro'), // page_title
            __('Comment Tools Pro Settings'), // menu_title
            'manage_options', // capability
            'comment-link-remove', // menu_slug
            array( $this, 'comment_link_remove_create_admin_page' ), // function
            $icon_url = '',
            25
        );*/

        add_submenu_page( 'comment-link-remove', __('Commenter Emails', 'comment-link-remove'), __('Commenter Emails', 'comment-link-remove'), 'manage_options', 'commenter-emails', 'comment_link_remove_commenter_email_pro_feature');

    }

    public function comment_link_remove_create_admin_page() {
        
        $this->comment_link_remove_options = get_option( 'comment_link_remove_option_name' ); 		

        ?>

        <div class="wrap">
            <h1><?php  esc_html_e( 'Comment Link Remove & Comment Tools', 'comment-link-remove'); ?></h1>
        <div class="wrap-content">
          <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
              <div id="post-body-content" >
                <h2 class="clr_titles"><?php  esc_html_e( 'Comment Link Remove & Comment Tools', 'comment-link-remove'); ?></h2>
                <p> <?php  esc_html_e( 'Here you can manage custom settings for the Comment Link Remove plugin.', 'comment-link-remove'); ?></p>
                <?php 

                global $wpdb;
                
                if ( current_user_can( 'manage_options' ) ) {
                    if ( isset( $_POST['delAllCmts'] ) && 'delAllCmts' === sanitize_text_field( wp_unslash( $_POST['delAllCmts'] ) ) ) {

                        if ( ! isset( $_POST['qc_clr_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qc_clr_nonce'] ) ), 'comment-link-remove' ) ) {

                            echo "<strong>" . esc_html__( 'You didn\'t send any credentials.', 'comment-link-remove' ) . "</strong><br>";
                            
                        } else {

                            $wpdb->query( $wpdb->prepare( "UPDATE `{$wpdb->prefix}posts` SET comment_count = %d", 0 ) );

                            $wpdb->query( "DELETE FROM `{$wpdb->prefix}comments`" ); 

                            echo "<strong>" . esc_html__( 'All Comments deleted successfully!', 'comment-link-remove' ) . "</strong><br>"; 

                        }
                        
                    }

                    if ( isset( $_POST['delPendingCmts'] ) && 'delPendingCmts' === sanitize_text_field( wp_unslash( $_POST['delPendingCmts'] ) ) ) {

                        if ( ! isset( $_POST['qc_clr_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qc_clr_nonce'] ) ), 'comment-link-remove' ) ) {

                            echo "<strong>" . esc_html__( 'You didn\'t send any credentials.', 'comment-link-remove' ) . "</strong><br>";
                            
                        } else {

                            $response = $wpdb->query( $wpdb->prepare( "DELETE FROM `{$wpdb->prefix}comments` WHERE `comment_approved` = %s", '0' ) );  

                            if ( $response ) {

                                echo "<strong>" . esc_html__( 'All Pending Comments deleted successfully!', 'comment-link-remove' ) . "</strong><br>"; 

                            }

                        }
                        
                    }

                    if ( isset( $_POST['delSpamCmts'] ) && 'delSpamCmts' === sanitize_text_field( wp_unslash( $_POST['delSpamCmts'] ) ) ) {

                        if ( ! isset( $_POST['qc_clr_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qc_clr_nonce'] ) ), 'comment-link-remove' ) ) {

                            echo "<strong>" . esc_html__( 'You didn\'t send any credentials.', 'comment-link-remove' ) . "</strong><br>";
                            
                        } else {

                            $response = $wpdb->query( $wpdb->prepare( "DELETE FROM `{$wpdb->prefix}comments` WHERE `comment_approved` = %s", 'spam' ) );  
                            
                            if ( $response ) {

                                echo "<strong>" . esc_html__( 'All Spam Comments deleted successfully!', 'comment-link-remove' ) . "</strong><br>"; 

                            }

                        }
                        
                    }
                }

                ?>

                
                <div class="clr_warapper">
                    <h2><?php  esc_html_e( 'Free Features', 'comment-link-remove'); ?></h2>
                    <div class="clr_dele-cmts">
                        <p><strong> <?php  esc_html_e( 'Delete comments easily:', 'comment-link-remove'); ?></strong></p>
                        <p></p>
                        <form class="qc-clr-inline-form" action="" method="POST">
                            <input name="qc_clr_nonce" type="hidden" value="<?php echo esc_attr( wp_create_nonce('comment-link-remove') ); ?>" />
                            <button class="commentDelete button button-primary" type="submit" name="delAllCmts" value="delAllCmts"> <?php  esc_html_e( 'Delete All Comments', 'comment-link-remove'); ?></button>
                        </form>
                        <form class="qc-clr-inline-form" action="" method="POST">
                            <input name="qc_clr_nonce" type="hidden" value="<?php echo esc_attr( wp_create_nonce('comment-link-remove') ); ?>" />
                            <button class="commentDelete button button-primary" type="submit" name="delPendingCmts" value="delPendingCmts"> <?php  esc_html_e( 'Delete Pending Comments', 'comment-link-remove'); ?></button>
                        </form>
                        <form class="qc-clr-inline-form" action="" method="POST">
                            <input name="qc_clr_nonce" type="hidden" value="<?php echo esc_attr( wp_create_nonce('comment-link-remove') ); ?>" />
                            <button class="commentDelete button button-primary" type="submit" name="delSpamCmts" value="delSpamCmts"> <?php esc_html_e( 'Delete Spam Comments', 'comment-link-remove'); ?></button>
                        </form>
                    </div>
                    <form method="post" action="options.php">
                        <?php settings_fields( 'comment_link_remove_option_group' ); ?>
                        <!-- CUSTOM STYLABLE SECTION #1 -->
                        <div class="clr_head">
                            <h2><?php  esc_html_e( 'General Settings', 'comment-link-remove'); ?></h2>
                            <?php do_settings_sections( 'comment-link-remove-admin' ,'comment_link_remove_setting_section' ); ?>
                        </div>
                        <?php submit_button(); ?>
                    </form>
                </div>
                <div class="clr_warapper clr_warapper_box">
                    <h4><?php  esc_html_e( 'Try our FREE ChatBot for WordPress with AI - WPBot.', 'comment-link-remove'); ?></h4>
                    <p><?php esc_html_e( 'It is an easy to use, Native, No coding required, AI ChatBot to provide Automated Live Chat Support. Use ChatBot to', 'comment-link-remove'); ?> <strong> <?php esc_html_e( 'answer user questions', 'comment-link-remove'); ?></strong> <?php esc_html_e( 'and also', 'comment-link-remove'); ?> <strong><?php esc_html_e( 'collect information', 'comment-link-remove'); ?></strong> <?php esc_html_e( 'from the users using', 'comment-link-remove'); ?> <strong><?php esc_html_e( 'conversational forms', 'comment-link-remove'); ?></strong>. <?php esc_html_e( 'It can be also be powered by DialogFlow, Tavily or OpenAI ChatGPT or simply use the built-in features to provide Live support and collect data.', 'comment-link-remove'); ?></p>
                    <?php include_once QCCLR_PLUGIN_DIR_PATH . '/qc-clr-recommendbot-plugin.php'; ?>
                    <p class="qcld_live_link_wrap"><a class="qcld_live_link" href="<?php echo esc_url('https://www.wpbot.pro/'); ?>" target="_blank" ><?php esc_html_e( 'Check the Live Demo', 'comment-link-remove'); ?></a></p>
                </div>
                <div class="clr_warapper">

                    <h2 class="clr_pro_feature_taggle"> <?php esc_html_e( 'View Advanced Pro Features', 'comment-link-remove'); ?> <span class="clr_pro_feature_toggle_btn"><?php esc_html_e('Show', 'comment-link-remove') ?></span> </h2>

                    <div class="clr_warapper_content">
                        <p class="qc_clr_upgrade_pro"> <a href="<?php  echo esc_url( 'https://www.quantumcloud.net/products/comment-tools/'); ?>" target="_blank"><span class="qc_clr_pro_feature" > <?php  esc_html_e( 'Upgrade to the Pro Version ', 'comment-link-remove'); ?></span> </a> <?php  esc_html_e( ' to enable these advanced features', 'comment-link-remove'); ?> </p>
                        
                        <div class="clr_warapper">
                            <div class="clr_head">
                                <h2><?php  esc_html_e( 'Voice Message', 'comment-link-remove'); ?>  </h2>
                                <?php do_settings_sections( 'comment-link-remove-admin-9' ,'comment_link_remove_setting_section_9' ); ?>

                            </div>
                        </div>
                        <div class="clr_warapper">
                            <div class="clr_head">
                                <h2><?php  esc_html_e( 'Comment Moderation', 'comment-link-remove'); ?>  </h2>
                                <?php do_settings_sections( 'comment-link-remove-admin-10' ,'comment_link_remove_setting_section_10' ); ?>

                            </div>
                        </div>
                        <div class="clr_head">
                            <h2  class="clr_head_titles"><?php  esc_html_e( 'Email Subscription', 'comment-link-remove'); ?>  </h2>
                            <?php do_settings_sections( 'comment-link-remove-admin-8' ,'comment_link_remove_setting_section_8' ); ?>

                        </div>
                        <div class="clr_head">
                            <h2 class="clr_head_titles"> <?php  esc_html_e( 'Comment Sentiment Settings', 'comment-link-remove'); ?> <span class="clr-language-note"> <?php  esc_html_e( '( Works with English language only )', 'comment-link-remove'); ?></span></h2>
                            <?php do_settings_sections( 'comment-link-remove-admin-6', 'comment_link_remove_setting_section_5'); ?>
                        </div>
                        <div class="clr_head">
                            <h2><?php  esc_html_e( 'Set Time Interval & Message Length Requirement', 'comment-link-remove'); ?></h2>
                            <?php do_settings_sections( 'comment-link-remove-admin-2', 'comment_link_remove_setting_section_1'); ?>
                        </div>

                        <div class="clr_head">
                            <h2><?php  esc_html_e( 'User Notification', 'comment-link-remove'); ?></h2>
                            <?php do_settings_sections( 'comment-link-remove-admin-4', 'comment_link_remove_setting_section_3'); ?>
                        </div>
                        <div class="clr_head">
                            <h2><?php  esc_html_e( 'SEO Settings', 'comment-link-remove'); ?></h2>
                            <?php do_settings_sections( 'comment-link-remove-admin-3', 'comment_link_remove_setting_section_2'); ?>
                        </div>
                        <div class="clr_head">
                            <h2><?php  esc_html_e( 'Other Settings', 'comment-link-remove'); ?></h2>
                            <?php do_settings_sections( 'comment-link-remove-admin-5', 'comment_link_remove_setting_section_4'); ?>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <!-- /post-body-content -->
            
            <hr>
            
            <!-- Right Sidebar -->
            <div id="postbox-container-1" class="postbox-container">

              <!-- Plugin Logo -->
              <div class="qc-promo-title"><?php  esc_html_e( 'QC Comment Link Remove', 'comment-link-remove'); ?></div>
              
              <!-- Promo Block 1 -->
              <div class="qc-promo-content"> 
                <div class="qc-promo-plugins">

                    <img src="<?php echo esc_url(QCCLR_ASSETS_URL) ?>/img/qc-logo-full.png" alt="QuantumCloud Logo">
                    <br><br><hr><br>
                    <a href="<?php echo esc_url( 'http://www.quantumcloud.net'); ?>" target="_blank"><?php  esc_html_e( 'QuantumCloud', 'comment-link-remove'); ?></a>
                </div>
            </div>
            <!-- Promo Plugin -->
            <div class="qc-promo-plugins-info">
                <h4><?php  esc_html_e( 'Try our other free plugins!', 'comment-link-remove'); ?></h4>
                <ul>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/simple-link-directory/'); ?>" target="_blank"> <?php  esc_html_e( 'Simple', 'comment-link-remove'); ?> <div class="qc-promo-bold">  <?php  esc_html_e( 'Link  Directory', 'comment-link-remove'); ?> </div> <?php  esc_html_e( 'plugin', 'comment-link-remove'); ?></a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/phone-directory/'); ?>" target="_blank"> <?php  esc_html_e( 'Simple', 'comment-link-remove'); ?> <div class="qc-promo-bold"> <?php  esc_html_e( 'Business Directory', 'comment-link-remove'); ?> </div> <?php  esc_html_e( 'plugin with maps', 'comment-link-remove'); ?></a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/simple-media-directory/'); ?>" target="_blank"> <?php  esc_html_e( 'Simple', 'comment-link-remove'); ?> <div class="qc-promo-bold"> <?php  esc_html_e( 'Video Directory', 'comment-link-remove'); ?> </div> <?php  esc_html_e( 'plugin', 'comment-link-remove'); ?> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/chatbot/'); ?>" target="_blank"> <div class="qc-promo-bold"><?php  esc_html_e( 'ChatBot', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'for WordPress', 'comment-link-remove'); ?> <div class="qc-promo-bold"><?php  esc_html_e( 'WPBot', 'comment-link-remove'); ?></div> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/woowbot-woocommerce-chatbot/'); ?>" target="_blank"> <div class="qc-promo-bold"><?php  esc_html_e( 'ChatBot', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'for WooCommerce', 'comment-link-remove'); ?> <div class="qc-promo-bold"><?php  esc_html_e( 'WoowBot', 'comment-link-remove'); ?></div> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/slider-hero'); ?>" target="_blank"> <div class="qc-promo-bold"><?php  esc_html_e( 'Slider Hero', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'WordPress Slider Plugin', 'comment-link-remove'); ?> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/portfolio-x/'); ?>" target="_blank"> <?php  esc_html_e( 'WordPress', 'comment-link-remove'); ?> <div class="qc-promo-bold"><?php  esc_html_e( 'Portfolio', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'plugin', 'comment-link-remove'); ?> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/express-shop/'); ?>" target="_blank"> <?php  esc_html_e( 'WooCommerce', 'comment-link-remove'); ?> <div class="qc-promo-bold"><?php  esc_html_e( 'One Page Store', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'Express Shop', 'comment-link-remove'); ?> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/increase-sales/'); ?>" target="_blank"> <div class="qc-promo-bold"><?php  esc_html_e( 'Increase Sales', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'on Your Stores', 'comment-link-remove'); ?> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/shop-assistant-for-woocommerce-jarvis/'); ?>" target="_blank"> <?php  esc_html_e( 'WooCommerce', 'comment-link-remove'); ?> <div class="qc-promo-bold"><?php  esc_html_e( 'Shop Assistant', 'comment-link-remove'); ?></div> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/woo-tabbed-category-product-listing/'); ?>" target="_blank"> <?php  esc_html_e( 'Woo Tabbed Category', 'comment-link-remove'); ?> <div class="qc-promo-bold"><?php  esc_html_e( 'Product Listing', 'comment-link-remove'); ?></div> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/ichart/'); ?>" target="_blank"> <?php  esc_html_e( 'Easy', 'comment-link-remove'); ?> <div class="qc-promo-bold"><?php  esc_html_e( 'Charts', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'and', 'comment-link-remove'); ?> <div class="qc-promo-bold"><?php  esc_html_e( 'Graphs', 'comment-link-remove'); ?></div>  <?php  esc_html_e( 'plugin - iChart', 'comment-link-remove'); ?></a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/infographic-and-list-builder-ilist/'); ?>" target="_blank"> <div class="qc-promo-bold"><?php  esc_html_e( 'Infographic', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'Maker plugin - iList', 'comment-link-remove'); ?> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/knowledgebase-helpdesk/'); ?>" target="_blank"> <div class="qc-promo-bold"><?php  esc_html_e( 'KnowledgeBase Helpdesk', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'Plugin with ChatBot', 'comment-link-remove'); ?> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/floating-action-buttons/'); ?>" target="_blank"> <div class="qc-promo-bold"><?php  esc_html_e( 'Floating Action', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'Buttons plugin', 'comment-link-remove'); ?> </a></li>
                    <li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/seo-help/'); ?>" target="_blank"> <div class="qc-promo-bold"><?php  esc_html_e( 'SEO', 'comment-link-remove'); ?></div> <?php  esc_html_e( 'Help', 'comment-link-remove'); ?> </a></li>
                </ul>
            </div>
        </div>
        <!-- /Right Sidebar -->
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <!-- /post-body --> 
</div>
<!-- /poststuff -->

</div>
</div>
<?php }

public function comment_link_remove_page_init() {
    register_setting(
            'comment_link_remove_option_group', // option_group
            'comment_link_remove_option_name', // option_name
            array( $this, 'comment_link_remove_sanitize' ) // sanitize_callback
        );

    add_settings_section(
            'comment_link_remove_setting_section', // id
            '', // title
            array( $this, 'comment_link_remove_section_info' ), // callback
            'comment-link-remove-admin' // page
        );

    add_settings_field(
            'remove_author_uri_field_0', // id
            __('Remove WEBSITE Field from Comment Form', 'comment-link-remove'), // title
            array( $this, 'remove_author_uri_field_0_callback' ), // callback
            'comment-link-remove-admin', // page
            'comment_link_remove_setting_section' // section
        );

    add_settings_field(
            'remove_any_link_from_author_field_1', // id
            __('Remove hyper-link from comment AUTHOR Bio', 'comment-link-remove'), // title
            array( $this, 'remove_any_link_from_author_field_1_callback' ), // callback
            'comment-link-remove-admin', // page
            'comment_link_remove_setting_section' // section
        );

    add_settings_field(
            'remove_links_from_comments_field_3', // id
            __('Disable turning URLs into hyper-links in comments', 'comment-link-remove'), // title
            array( $this, 'remove_links_from_comments_field_3_callback' ), // callback
            'comment-link-remove-admin', // page
            'comment_link_remove_setting_section' // section
        );

    add_settings_field(
            'remove_links_from_comments_field_2', // id
            __('Remove HTML Link Tags in comments', 'comment-link-remove'), // title
            array( $this, 'remove_links_from_comments_field_2_callback' ), // callback
            'comment-link-remove-admin', // page
            'comment_link_remove_setting_section' // section
        );

    add_settings_field(
            'disable_comments_totally', // id
            __('Disable Comments Globally', 'comment-link-remove'), // title
            array( $this, 'disable_comments_totally_callback' ), // callback
            'comment-link-remove-admin', // page
            'comment_link_remove_setting_section' // section
        );

    add_settings_field(
            'hide_existing_cmts', // id
            __('Hide Existing Comments', 'comment-link-remove'), // title
            array( $this, 'hide_existing_cmts_callback' ), // callback
            'comment-link-remove-admin', // page
            'comment_link_remove_setting_section' // section
        );

    add_settings_field(
            'open_link_innewtab', // id
            __('Open Comment Links in New Tab', 'comment-link-remove'), // title
            array( $this, 'open_link_innewtab_callback' ), // callback
            'comment-link-remove-admin', // page
            'comment_link_remove_setting_section' // section
        );
}

    // section 2
public function comment_link_remove_page_init_2() {
    add_settings_section(
            'comment_link_remove_setting_section_1', // id
            '', // title
            array( $this, 'comment_link_remove_section_info_2' ), // callback
            'comment-link-remove-admin-2' // page
        );

    add_settings_field(
            'comment_time_minimum', // id
            __('Minimum Time (In Seconds) <br> <span class="qcld_msg">( Set Time Interval Required Between Comments to Avoid Spamming )</span>', 'comment-link-remove'), // title
            array( $this, 'comment_time_minimum_callback' ), // callback
            'comment-link-remove-admin-2', // page
            'comment_link_remove_setting_section_1' // section
        );

    add_settings_field(
            'comment_quick_mgs', // id
            __('Custom Message for Quick comments', 'comment-link-remove'), // title
            array( $this, 'comment_quick_mgs_callback' ), // callback
            'comment-link-remove-admin-2', // page
            'comment_link_remove_setting_section_1' // section
        );

    add_settings_field(
            'comment_minimum_length', // id
            __('Minimum Length of Character in Comments <br> <span class="qcld_msg">( Avoid Low Value Comments )</span>', 'comment-link-remove'), // title
            array( $this, 'comment_minimum_length_callback' ), // callback
            'comment-link-remove-admin-2', // page
            'comment_link_remove_setting_section_1' // section
        );

    add_settings_field(
            'comment_minimum_length_mgs', // id
            __('Alert Message for Minimum Comments Length ', 'comment-link-remove'), // title
            array( $this, 'comment_minimum_length_mgs_callback' ), // callback
            'comment-link-remove-admin-2', // page
            'comment_link_remove_setting_section_1' // section
        );

    add_settings_field(
            'comment_maximum_length', // id
            __('Maximum of Character in Comments <br> <span class="qcld_msg">( Helps Avoid Spamming )</span>', 'comment-link-remove'), // title
            array( $this, 'comment_maximum_length_callback' ), // callback
            'comment-link-remove-admin-2', // page
            'comment_link_remove_setting_section_1' // section
        );

    add_settings_field(
            'comment_maximum_length_mgs', // id
            __('Alert Message for Maximum Comments Length ', 'comment-link-remove'), // title
            array( $this, 'comment_maximum_length_mgs_callback' ), // callback
            'comment-link-remove-admin-2', // page
            'comment_link_remove_setting_section_1' // section
        );

}

    // section 3
public function comment_link_remove_page_init_3() {
    add_settings_section(
            'comment_link_remove_setting_section_2', // id
            '', // title
            array( $this, 'comment_link_remove_section_info_3' ), // callback
            'comment-link-remove-admin-3' // page
        );

    

    add_settings_field(
            'comment_link_follow', // id
            __('Set “follow” or “nofollow” to Comments Link ', 'comment-link-remove'), // title
            array( $this, 'comment_link_follow_callback' ), // callback
            'comment-link-remove-admin-3', // page
            'comment_link_remove_setting_section_2' // section
        );

    add_settings_field(
            'comment_link_noreffer', // id
            __('Add “noreferrer” to “rel” attribute if  Comments Link Open in New Tab  ', 'comment-link-remove'), // title
            array( $this, 'comment_link_noreffer_callback' ), // callback
            'comment-link-remove-admin-3', // page
            'comment_link_remove_setting_section_2' // section
        );

    add_settings_field(
            'comment_link_noopener', // id
            __('Add “noopener” to “rel” attribute if  Comments Link Open in New Tab  ', 'comment-link-remove'), // title
            array( $this, 'comment_link_noopener_callback' ), // callback
            'comment-link-remove-admin-3', // page
            'comment_link_remove_setting_section_2' // section
        );


}

    // section 4
public function comment_link_remove_page_init_4() {
    add_settings_section(
            'comment_link_remove_setting_section_3', // id
            '', // title
            array( $this, 'comment_link_remove_section_info_4' ), // callback
            'comment-link-remove-admin-4' // page
        );

    add_settings_field(
            'comment_notify_user_comment_approved', // id
            __('Notify a user when their comment is approved', 'comment-link-remove'), // title
            array( $this, 'comment_notify_user_comment_approved_callback' ), // callback
            'comment-link-remove-admin-4', // page
            'comment_link_remove_setting_section_3' // section
        );
    add_settings_field(
            'notify_user_comment_subject', // id
            __('Notify Subject', 'comment-link-remove'), // title
            array( $this, 'notify_user_comment_subject_callback' ), // callback
            'comment-link-remove-admin-4', // page
            'comment_link_remove_setting_section_3' // section
        );

    add_settings_field(
            'notify_user_comment_messsage', // id
            __('Notify Message ', 'comment-link-remove'), // title
            array( $this, 'notify_user_comment_messsage_callback' ), // callback
            'comment-link-remove-admin-4', // page
            'comment_link_remove_setting_section_3' // section
        );

}

    // section 4
public function comment_link_remove_page_init_5() {
    add_settings_section(
            'comment_link_remove_setting_section_4', // id
            '', // title
            array( $this, 'comment_link_remove_section_info_5' ), // callback
            'comment-link-remove-admin-5' // page
        );

    add_settings_field(
            'comment_redirect', // id
            __('Redirect Page after Comments', 'comment-link-remove'), // title
            array( $this, 'comment_redirect_callback' ), // callback
            'comment-link-remove-admin-5', // page
            'comment_link_remove_setting_section_4' // section
        );


    add_settings_field(
            'comment_readmore', // id
            __('Enable Comments Read More option', 'comment-link-remove'), // title
            array( $this, 'comment_readmore_callback' ), // callback
            'comment-link-remove-admin-5', // page
            'comment_link_remove_setting_section_4' // section
        );

    add_settings_field(
            'comment_readmore_length', // id
            __('Show Read More after (in Words)', 'comment-link-remove'), // title
            array( $this, 'comment_readmore_length_callback' ), // callback
            'comment-link-remove-admin-5', // page
            'comment_link_remove_setting_section_4' // section
        );

    add_settings_field(
            'comment_admin_section_email_individual_comenters', // id
            __('Links in the admin comments section to email individual commenters', 'comment-link-remove'), // title
            array( $this, 'comment_admin_section_email_individual_comenters_callback' ), // callback
            'comment-link-remove-admin-5', // page
            'comment_link_remove_setting_section_4' // section
        );

    add_settings_field(
            'comment_button_wp_toolbar_email_commenters_post', // id
            __('Enable a button in the WP toolbar to email all the commenters on a post', 'comment-link-remove'), // title
            array( $this, 'comment_button_wp_toolbar_email_commenters_post_callback' ), // callback
            'comment-link-remove-admin-5', // page
            'comment_link_remove_setting_section_4' // section
        );

    add_settings_field(
            'comment_add_sidebar_widget_show_top_commentators', // id
            __('Adds a sidebar widget to show the top commentators in your WP site', 'comment-link-remove'), // title
            array( $this, 'comment_add_sidebar_widget_show_top_commentators_callback' ), // callback
            'comment-link-remove-admin-5', // page
            'comment_link_remove_setting_section_4' // section
        );

    add_settings_field(
            'comment_show_all_comments', // id
            __('Show All Comments', 'comment-link-remove'), // title
            array( $this, 'comment_show_all_comments_callback' ), // callback
            'comment-link-remove-admin-5', // page
            'comment_link_remove_setting_section_4' // section
        );

    add_settings_field(
            'comment_vertical_scroll_recent_widget_comments', // id
            __('Vertical scroll in recent comments widget', 'comment-link-remove'), // title
            array( $this, 'comment_vertical_scroll_recent_widget_comments_callback' ), // callback
            'comment-link-remove-admin-5', // page
            'comment_link_remove_setting_section_4' // section
        );

}




public function comment_link_remove_page_init_6() {
    add_settings_section(
            'comment_link_remove_setting_section_5', // id
            '', // title
            array( $this, 'comment_link_remove_section_info_6' ), // callback
            'comment-link-remove-admin-6' // page
        );

    add_settings_field(
            'like_dislike', // id
            __('Enable Like/Dislike', 'comment-link-remove'), // title
            array( $this, 'like_dislike' ), // callback
            'comment-link-remove-admin-6', // page
            'comment_link_remove_setting_section_5' // section
        );
    add_settings_field(
            'enable_emotions', // id
            __('Show Emotions in Comment', 'comment-link-remove'), // title
            array( $this, 'enable_emotions' ), // callback
            'comment-link-remove-admin-6', // page
            'comment_link_remove_setting_section_5' // section
        );
    add_settings_field(
            'enable_comment_filter', // id
            __('Allow Comments Filtering by Sentiment (Frontend)', 'comment-link-remove'), // title
            array( $this, 'enable_comment_filter' ), // callback
            'comment-link-remove-admin-6', // page
            'comment_link_remove_setting_section_5' // section
        );
    
    add_settings_field(
            'enable_comment_threshold', // id
            __('Allow Comments Threshold by Negative Score', 'comment-link-remove'), // title
            array( $this, 'enable_comment_threshold' ), // callback
            'comment-link-remove-admin-6', // page
            'comment_link_remove_setting_section_5' // section
        );
    
    add_settings_field(
            'treshold_score', // id
            __('Threshold by Negative Score (EX: 0.5)', 'comment-link-remove'), // title
            array( $this, 'treshold_score' ), // callback
            'comment-link-remove-admin-6', // page
            'comment_link_remove_setting_section_5' // section
        );
    
    add_settings_field(
            'treshold_msg', // id
            __('Threshold Message', 'comment-link-remove'), // title
            array( $this, 'treshold_msg' ), // callback
            'comment-link-remove-admin-6', // page
            'comment_link_remove_setting_section_5' // section
        );

}


public function comment_link_remove_page_init_8() {
    add_settings_section(
            'comment_link_remove_setting_section_8', // id
            '', // title
            array( $this, 'comment_link_remove_section_info_8' ), // callback
            'comment-link-remove-admin-8' // page
        );

    add_settings_field(
            'qc_clr_email_subscription_enalbe_disable', // id
            __('Enable Email Subscription', 'comment-link-remove'), // title
            array( $this, 'qc_clr_email_subscription_enalbe_disable_callback' ), // callback
            'comment-link-remove-admin-8', // page
            'comment_link_remove_setting_section_8' // section
        );
    add_settings_field(
            'qc_clr_email_subscription_lang_text', // id
            __('Language ( Subscribe to our newsletter ) ', 'comment-link-remove'), // title
            array( $this, 'qc_clr_email_subscription_lang_text_callback' ), // callback
            'comment-link-remove-admin-8', // page
            'comment_link_remove_setting_section_8' // section
        );
    add_settings_field(
            'qc_clr_email_subscription_mailchamp_enalbe_disable', // id
            __('Enable Mailchimp :', 'comment-link-remove'), // title
            array( $this, 'qc_clr_email_subscription_mailchamp_enalbe_disable_callback' ), // callback
            'comment-link-remove-admin-8', // page
            'comment_link_remove_setting_section_8' // section
        );
    add_settings_field(
            'qc_clr_email_subscription_zapier_enalbe_disable', // id
            __('Enable Zapier', 'comment-link-remove'), // title
            array( $this, 'qc_clr_email_subscription_zapier_enalbe_disable_callback' ), // callback
            'comment-link-remove-admin-8', // page
            'comment_link_remove_setting_section_8' // section
        );

}

public function comment_link_remove_page_init_9() {
    add_settings_section(
            'comment_link_remove_setting_section_9', // id
            '', // title
            array( $this, 'comment_link_remove_section_info_9' ), // callback
            'comment-link-remove-admin-9' // page
        );

    add_settings_field(
            'comment_show_voice_message_enable', // id
            __('Enable Voice Message on User Comments', 'comment-link-remove'), // title
            array( $this, 'comment_show_voice_message_comments_callback' ), // callback
            'comment-link-remove-admin-9', // page
            'comment_link_remove_setting_section_9' // section
        );

    add_settings_field(
            'comment_show_voice_message_enable_for_woocommerce', // id
            __('Enable Voice Message on woocommerce', 'comment-link-remove'), // title
            array( $this, 'comment_show_voice_message_enable_for_woocommerce_callback' ), // callback
            'comment-link-remove-admin-9', // page
            'comment_link_remove_setting_section_9' // section
        );
    

}


public function comment_link_remove_page_init_10() {
    add_settings_section(
            'comment_link_remove_setting_section_10', // id
            '', // title
            array( $this, 'comment_link_remove_section_info_10' ), // callback
            'comment-link-remove-admin-10' // page
        );

    add_settings_field(
            'comment_button_delete_commenters_comment', // id
            __('Enable Delete and Move To Spam Buttons on the Frontend', 'comment-link-remove'), // title
            array( $this, 'comment_button_delete_commenters_comment_callback' ), // callback
            'comment-link-remove-admin-10', // page
            'comment_link_remove_setting_section_10' // section
        );

    add_settings_field(
            'comment_exclude_text_comments', // id
            __('Auto Moderate Comments by Keywords or Phrase', 'comment-link-remove'), // title
            array( $this, 'comment_exclude_comments_callback' ), // callback
            'comment-link-remove-admin-10', // page
            'comment_link_remove_setting_section_10' // section
        );

    add_settings_field(
            'comment_exclude_action', // id
            __('Auto Moderate Comments Action', 'comment-link-remove'), // title
            array( $this, 'comment_exclude_action_callback' ), // callback
            'comment-link-remove-admin-10', // page
            'comment_link_remove_setting_section_10' // section
        );
    

}


public function comment_link_remove_sanitize($input) {
    $sanitary_values = array();
    if ( isset( $input['remove_author_uri_field_0'] ) ) {
        $sanitary_values['remove_author_uri_field_0'] = $input['remove_author_uri_field_0'];
    }

    if ( isset( $input['remove_any_link_from_author_field_1'] ) ) {
        $sanitary_values['remove_any_link_from_author_field_1'] = $input['remove_any_link_from_author_field_1'];
    }

    if ( isset( $input['remove_links_from_comments_field_3'] ) ) {
        $sanitary_values['remove_links_from_comments_field_3'] = $input['remove_links_from_comments_field_3'];
    }

    if ( isset( $input['remove_links_from_comments_field_2'] ) ) {
        $sanitary_values['remove_links_from_comments_field_2'] = $input['remove_links_from_comments_field_2'];
    }

    if ( isset( $input['disable_comments_totally'] ) ) {
        $sanitary_values['disable_comments_totally'] = $input['disable_comments_totally'];
    }

    if ( isset( $input['hide_existing_cmts'] ) ) {
        $sanitary_values['hide_existing_cmts'] = $input['hide_existing_cmts'];
    }

    if ( isset( $input['open_link_innewtab'] ) ) {
        $sanitary_values['open_link_innewtab'] = $input['open_link_innewtab'];
    }

    return $sanitary_values;
}

public function comment_link_remove_section_info() {
    
}

public function comment_link_remove_section_info_2() {
    
}

public function comment_link_remove_section_info_3() {
    
}

public function comment_link_remove_section_info_4() {
    
}

public function comment_link_remove_section_info_5() {
    
}

public function comment_link_remove_section_info_6() {
    
}

public function comment_link_remove_section_info_8() {
    
}

public function comment_link_remove_section_info_9() {
    
}

public function comment_link_remove_section_info_10() {
    
}


public function remove_author_uri_field_0_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[remove_author_uri_field_0]" id="remove_author_uri_field_0" value="1" %s>',
        ( isset( $this->comment_link_remove_options['remove_author_uri_field_0'] ) && $this->comment_link_remove_options['remove_author_uri_field_0'] === '1' ) ? 'checked' : ''
    );
}

public function remove_any_link_from_author_field_1_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[remove_any_link_from_author_field_1]" id="remove_any_link_from_author_field_1" value="1" %s>',
        ( isset( $this->comment_link_remove_options['remove_any_link_from_author_field_1'] ) && $this->comment_link_remove_options['remove_any_link_from_author_field_1'] === '1' ) ? 'checked' : ''
    );
}

public function remove_links_from_comments_field_3_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[remove_links_from_comments_field_3]" id="remove_links_from_comments_field_3" value="1" %s>',
        ( isset( $this->comment_link_remove_options['remove_links_from_comments_field_3'] ) && $this->comment_link_remove_options['remove_links_from_comments_field_3'] === '1' ) ? 'checked' : ''
    );
}

public function remove_links_from_comments_field_2_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[remove_links_from_comments_field_2]" id="remove_links_from_comments_field_2" value="1" %s>',
        ( isset( $this->comment_link_remove_options['remove_links_from_comments_field_2'] ) && $this->comment_link_remove_options['remove_links_from_comments_field_2'] === '1' ) ? 'checked' : ''
    );
}

public function disable_comments_totally_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[disable_comments_totally]" id="disable_comments_totally" value="1" %s>',
        ( isset( $this->comment_link_remove_options['disable_comments_totally'] ) && $this->comment_link_remove_options['disable_comments_totally'] === '1' ) ? 'checked' : ''
    );
}

public function hide_existing_cmts_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[hide_existing_cmts]" id="hide_existing_cmts" value="1" %s>',
        ( isset( $this->comment_link_remove_options['hide_existing_cmts'] ) && $this->comment_link_remove_options['hide_existing_cmts'] === '1' ) ? 'checked' : ''
    );
}

public function open_link_innewtab_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[open_link_innewtab]" id="open_link_innewtab" value="1" %s>',
        ( isset( $this->comment_link_remove_options['open_link_innewtab'] ) && $this->comment_link_remove_options['open_link_innewtab'] === '1' ) ? 'checked' : ''
    );
}
public function like_dislike() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[like_dislike]" id="like_dislike" value="1" %s>',
        ( isset( $this->comment_link_remove_options['like_dislike'] ) && $this->comment_link_remove_options['like_dislike'] === '1' ) ? 'checked' : ''
    );
}
public function enable_emotions() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[enable_emotions]" id="enable_emotions" value="1" %s>',
        ( isset( $this->comment_link_remove_options['enable_emotions'] ) && $this->comment_link_remove_options['enable_emotions'] === '1' ) ? 'checked' : ''
    );
}

public function enable_comment_filter() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[enable_comment_filter]" id="enable_comment_filter" value="1" %s>',
        ( isset( $this->comment_link_remove_options['enable_comment_filter'] ) && $this->comment_link_remove_options['enable_comment_filter'] === '1' ) ? 'checked' : ''
    );
}
public function enable_comment_threshold() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[enable_comment_threshold]" id="enable_comment_threshold" value="1" %s>',
        ( isset( $this->comment_link_remove_options['enable_comment_threshold'] ) && $this->comment_link_remove_options['enable_comment_threshold'] === '1' ) ? 'checked' : ''
    );
}
public function treshold_score() {
    $val = ( isset( $this->comment_link_remove_options['treshold_score'] ) && $this->comment_link_remove_options['treshold_score'] != '' ) ? $this->comment_link_remove_options['treshold_score'] : '0.5';
    printf(
        '<input type="text" name="comment_link_remove_option_name[treshold_score]" id="treshold_score" value="%s" placeholder="Ex: 0.5">',
        esc_attr( $val )
    );
    echo '<span class="clr-sentiment-desc">' . esc_html__( 'This will display alert for Comments that contain negative words. Adjust the Threshold Score to accommodate your user base.', 'comment-link-remove' ) . '</span>';
}
public function treshold_msg() {
    $val = ( isset( $this->comment_link_remove_options['treshold_msg'] ) && $this->comment_link_remove_options['treshold_msg'] != '' ) ? $this->comment_link_remove_options['treshold_msg'] : 'Your comment is too negative! Please be polite and professional while writing!';
    printf(
        '<input type="text" name="comment_link_remove_option_name[treshold_msg]" id="treshold_msg" value="%s" placeholder="">',
        esc_attr( $val )
    );
}
public function comment_time_minimum_callback() {
    $val = ( isset( $this->comment_link_remove_options['comment_time_minimum'] ) && $this->comment_link_remove_options['comment_time_minimum'] !='' ) ? (int) $this->comment_link_remove_options['comment_time_minimum'] : 10;
    printf(
        '<input type="text" name="comment_link_remove_option_name[comment_time_minimum]" id="comment_time_minimum" value="%d" >',
        esc_attr( $val )
    );
}
public function comment_quick_mgs_callback() {
    $val = ( isset( $this->comment_link_remove_options['comment_quick_mgs'] ) && $this->comment_link_remove_options['comment_quick_mgs'] !='' ) ? $this->comment_link_remove_options['comment_quick_mgs'] : 'You are posting comments too quickly';
    printf(
        '<input type="text" name="comment_link_remove_option_name[comment_quick_mgs]" id="comment_quick_mgs" value="%s" >',
        esc_attr( $val )
    );
}
public function comment_minimum_length_callback() {
    $val = ( isset( $this->comment_link_remove_options['comment_minimum_length'] ) && $this->comment_link_remove_options['comment_minimum_length'] !='' ) ? (int) $this->comment_link_remove_options['comment_minimum_length'] : 15;
    printf(
        '<input type="number" name="comment_link_remove_option_name[comment_minimum_length]" id="comment_minimum_length" value="%d" >',
        esc_attr( $val )
    );
}
public function comment_minimum_length_mgs_callback() {
    $val = ( isset( $this->comment_link_remove_options['comment_minimum_length_mgs'] ) && $this->comment_link_remove_options['comment_minimum_length_mgs'] !='' ) ? $this->comment_link_remove_options['comment_minimum_length_mgs'] : 'Your comments is too short, try to say some more useful messages.';
    printf(
        '<input type="text" name="comment_link_remove_option_name[comment_minimum_length_mgs]" id="comment_minimum_length_mgs" value="%s" >',
        esc_attr( $val )
    );
}
public function comment_maximum_length_callback() {
    $val = ( isset( $this->comment_link_remove_options['comment_maximum_length'] ) && $this->comment_link_remove_options['comment_maximum_length'] !='' ) ? (int) $this->comment_link_remove_options['comment_maximum_length'] : 1500;
    printf(
        '<input type="number" name="comment_link_remove_option_name[comment_maximum_length]" id="comment_maximum_length" value="%d" >',
        esc_attr( $val )
    );
}
public function comment_maximum_length_mgs_callback() {
    $val = ( isset( $this->comment_link_remove_options['comment_maximum_length_mgs'] ) && $this->comment_link_remove_options['comment_maximum_length_mgs'] !='' ) ? $this->comment_link_remove_options['comment_maximum_length_mgs'] : 'Your Comments is too long, try to minimize useful message.';
    printf(
        '<input type="text" name="comment_link_remove_option_name[comment_maximum_length_mgs]" id="comment_maximum_length_mgs" value="%s" >',
        esc_attr( $val )
    );
}

public function comment_redirect_callback() {
    $clr_options = get_option( 'comment_link_remove_option_name' );

    $comment_redirect = isset( $clr_options['comment_redirect'] ) ? absint( $clr_options['comment_redirect'] ) : 0;
    $dropdown         = wp_dropdown_pages( array(
        'name'              => 'comment_link_remove_option_name[comment_redirect]',
        'id'                => 'comment_redirect',
        'depth'             => 0,
        'echo'              => 0,
        'option_none_value' => 0,
        'selected'          => absint( $comment_redirect ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        'show_option_none'  => esc_html__( 'Don\'t redirect first time commenters', 'comment-link-remove' ),
    ) );

    if ( ! empty( $dropdown ) ) {
        echo wp_kses(
            $dropdown,
            array(
                'select' => array(
                    'name'  => array(),
                    'id'    => array(),
                    'class' => array(),
                ),
                'option' => array(
                    'value'    => array(),
                    'selected' => array(),
                    'class'    => array(),
                ),
            )
        );
    }

    if ( 0 !== $comment_redirect ) {
        echo '<br><br><a target="_blank" href="' . esc_url( get_permalink( $comment_redirect ) ) . '">' . esc_html__( 'Current redirect page', 'comment-link-remove' ) . '</a>';
    }
}

public function comment_readmore_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_readmore]" id="comment_readmore" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_readmore'] ) && $this->comment_link_remove_options['comment_readmore'] =='1' ) ? 'checked' : ''
    );
}

public function comment_readmore_length_callback() {
    $val = ( isset( $this->comment_link_remove_options['comment_readmore_length'] ) && $this->comment_link_remove_options['comment_readmore_length'] != 0 ) ? (int) $this->comment_link_remove_options['comment_readmore_length'] : 10;
    printf(
        '<input type="text" class="clr-readmore-input" name="comment_link_remove_option_name[comment_readmore_length]" id="comment_readmore_length" value="%d" >',
        esc_attr( $val )
    );
}

public function comment_link_follow_callback() {

    $clr_options = get_option( 'comment_link_remove_option_name' );
    $comment_link_follow = isset($clr_options['comment_link_follow']) ? $clr_options['comment_link_follow'] : "";
    ?>
    <select name="comment_link_remove_option_name[comment_link_follow]" id="comment_link_follows">
        <option value=""><?php esc_html_e( 'Choice an option', 'comment-link-remove' ); ?></option>
        <option value="follow" <?php selected( $comment_link_follow, 'follow' ); ?>><?php esc_html_e( 'Add "follow"', 'comment-link-remove' ); ?></option>
        <option value="nofollow" <?php selected( $comment_link_follow, 'nofollow' ); ?>><?php esc_html_e( 'Add "nofollow"', 'comment-link-remove' ); ?></option>
    </select>
    <?php
}

public function comment_link_noreffer_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_link_noreffer]" id="comment_link_noreffer" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_link_noreffer'] ) && $this->comment_link_remove_options['comment_link_noreffer'] =='1' ) ? 'checked' : ''
    );
}

public function comment_link_noopener_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_link_noopener]" id="comment_link_noopener" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_link_noopener'] ) && $this->comment_link_remove_options['comment_link_noopener'] =='1' ) ? 'checked' : ''
    );
}

    // Admin section email individual commenters
public function comment_admin_section_email_individual_comenters_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_admin_section_email_individual_comenters]" id="comment_admin_section_email_individual_comenters" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_admin_section_email_individual_comenters'] ) && $this->comment_link_remove_options['comment_admin_section_email_individual_comenters'] =='1' ) ? 'checked' : ''
    );
}

    // A button in the WP toolbar to email all the commenters on a post
public function comment_button_wp_toolbar_email_commenters_post_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_button_wp_toolbar_email_commenters_post]" id="comment_button_wp_toolbar_email_commenters_post" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_button_wp_toolbar_email_commenters_post'] ) && $this->comment_link_remove_options['comment_button_wp_toolbar_email_commenters_post'] =='1' ) ? 'checked' : ''
    );
}

    // A button in the WP toolbar to email all the commenters on a post
public function comment_button_delete_commenters_comment_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_button_delete_commenters_comment]" id="comment_button_delete_commenters_comment" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_button_delete_commenters_comment'] ) && $this->comment_link_remove_options['comment_button_delete_commenters_comment'] =='1' ) ? 'checked' : ''
    );
}

public function comment_exclude_action_callback() {
    $clr_options = get_option( 'comment_link_remove_option_name' );

    $comment_exclude_action = isset($clr_options['comment_exclude_action']) ? $clr_options['comment_exclude_action'] : 0;
    ?>
    <select name="comment_link_remove_option_name[comment_exclude_action]" id="comment_exclude_action">
        <option value=""><?php esc_html_e( 'Choose an option', 'comment-link-remove' ); ?></option>
        <option value="spam" <?php selected( $comment_exclude_action, 'spam' ); ?>><?php esc_html_e( 'Spam', 'comment-link-remove' ); ?></option>
        <option value="pending" <?php selected( $comment_exclude_action, 'pending' ); ?>><?php esc_html_e( 'Pending', 'comment-link-remove' ); ?></option>
        <option value="delete" <?php selected( $comment_exclude_action, 'delete' ); ?>><?php esc_html_e( 'Delete', 'comment-link-remove' ); ?></option>
    </select>
    <?php


}

    // A comment_exclude_comments_callback
public function comment_exclude_comments_callback() {
    $val = ( isset( $this->comment_link_remove_options['comment_exclude_text_comments'] ) && $this->comment_link_remove_options['comment_exclude_text_comments'] !='' ) ? $this->comment_link_remove_options['comment_exclude_text_comments'] : 'cialis, 20mg, zithromax, viagra, strep';
    printf(
        '<textarea name="comment_link_remove_option_name[comment_exclude_text_comments]" id="comment_exclude_text_comments" >%s</textarea><p><i>' . esc_html__( 'You can add multiple keywords or phrases as coma(,) seperated values. Comments that include these keywords will be automatically deleted or marked as Spam or Pending as you select from the dropdown below.', 'comment-link-remove' ) . '</i></p>',
        esc_textarea( $val )
    );



}

    // Notify a user when their comment is approved.
public function comment_notify_user_comment_approved_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_notify_user_comment_approved]" id="comment_notify_user_comment_approved" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_notify_user_comment_approved'] ) && $this->comment_link_remove_options['comment_notify_user_comment_approved'] =='1' ) ? 'checked' : ''
    );
}

    // Notify a user when their comment is approved. notify_user_comment_subject / notify_user_comment_messsage
public function notify_user_comment_subject_callback() {
    $val = ( isset( $this->comment_link_remove_options['notify_user_comment_subject'] ) && $this->comment_link_remove_options['notify_user_comment_subject'] !='' ) ? $this->comment_link_remove_options['notify_user_comment_subject'] : 'Your comment has been approved';
    printf(
        '<input type="text" name="comment_link_remove_option_name[notify_user_comment_subject]" id="notify_user_comment_subject" value="%s" >',
        esc_attr( $val )
    );
}

    // Notify a user when their comment is approved.
public function notify_user_comment_messsage_callback() {
    $val = ( isset( $this->comment_link_remove_options['notify_user_comment_messsage'] ) && $this->comment_link_remove_options['notify_user_comment_messsage'] !='' ) ? $this->comment_link_remove_options['notify_user_comment_messsage'] : 'Thanks for your comment! It has been approved. To view the post, look at the link be';
    printf(
        '<textarea name="comment_link_remove_option_name[notify_user_comment_messsage]" id="notify_user_comment_messsage">%s</textarea>',
        esc_textarea( $val )
    );


}

    // Adds a sidebar widget to show the top commentators in your WP site
public function comment_add_sidebar_widget_show_top_commentators_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_add_sidebar_widget_show_top_commentators]" id="comment_add_sidebar_widget_show_top_commentators" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_add_sidebar_widget_show_top_commentators'] ) && $this->comment_link_remove_options['comment_add_sidebar_widget_show_top_commentators'] =='1' ) ? 'checked' : ''
    );
}

    // Show All Comments
public function comment_show_all_comments_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_show_all_comments]" id="comment_show_all_comments" value="1" %s ><code>[clr_all_comments][/clr_all_comments]</code> (' . esc_html__( 'Add this shortcode your expected page', 'comment-link-remove' ) . ')',
        ( isset( $this->comment_link_remove_options['comment_show_all_comments'] ) && $this->comment_link_remove_options['comment_show_all_comments'] =='1' ) ? 'checked' : ''
    );
}

    // Vertical scroll recent comments widget
public function comment_vertical_scroll_recent_widget_comments_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_vertical_scroll_recent_widget_comments]" id="comment_vertical_scroll_recent_widget_comments" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_vertical_scroll_recent_widget_comments'] ) && $this->comment_link_remove_options['comment_vertical_scroll_recent_widget_comments'] =='1' ) ? 'checked' : ''
    );
}

    // Allows to export the names and email addresses of users, who have left comments on the blog
public function comment_allows_export_the_names_and_email_addresses_comments_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_allows_export_the_names_and_email_addresses_comments]" id="comment_allows_export_the_names_and_email_addresses_comments" value="1" %s >',
        ( isset( $this->comment_link_remove_options['comment_allows_export_the_names_and_email_addresses_comments'] ) && $this->comment_link_remove_options['comment_allows_export_the_names_and_email_addresses_comments'] =='1' ) ? 'checked' : ''
    );
}


    // qc_clr_email_subscription_enalbe_disable
public function qc_clr_email_subscription_enalbe_disable_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[qc_clr_email_subscription_enalbe_disable]" id="qc_clr_email_subscription_enalbe_disable" value="1" %s >',
        ( isset( $this->comment_link_remove_options['qc_clr_email_subscription_enalbe_disable'] ) && $this->comment_link_remove_options['qc_clr_email_subscription_enalbe_disable'] =='1' ) ? 'checked' : ''
    );
}

    // qc_clr_email_subscription_lang_text
public function qc_clr_email_subscription_lang_text_callback() {
    $val = ( isset( $this->comment_link_remove_options['qc_clr_email_subscription_lang_text'] ) && $this->comment_link_remove_options['qc_clr_email_subscription_lang_text'] !='' ) ? $this->comment_link_remove_options['qc_clr_email_subscription_lang_text'] : 'Subscribe to our newsletter';
    printf(
        '<input type="text" name="comment_link_remove_option_name[qc_clr_email_subscription_lang_text]" id="qc_clr_email_subscription_lang_text" value="%s" >',
        esc_attr( $val )
    );
}

    // qc_clr_email_subscription_zapier_enalbe_disable
public function qc_clr_email_subscription_zapier_enalbe_disable_callback() {
    $checked = ( isset( $this->comment_link_remove_options['qc_clr_email_subscription_zapier_enalbe_disable'] ) && $this->comment_link_remove_options['qc_clr_email_subscription_zapier_enalbe_disable'] =='1' ) ? 'checked' : '';
    $link = ( isset( $this->comment_link_remove_options['qc_clr_email_subscription_zapier_enalbe_disable'] ) && $this->comment_link_remove_options['qc_clr_email_subscription_zapier_enalbe_disable'] =='1' ) ? '<a href="' . esc_url( admin_url( 'edit.php?post_type=qc_clr_zapier' ) ) . '"> ' . esc_html__( 'Manage Settings', 'comment-link-remove' ) . '</a>' : '';
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[qc_clr_email_subscription_zapier_enalbe_disable]" id="qc_clr_email_subscription_zapier_enalbe_disable" value="1" %s > %s',
        esc_attr( $checked ),
        wp_kses_post( $link )
    );
}
public function comment_show_voice_message_comments_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_show_voice_message_enable]" id="comment_show_voice_message_enable" value="1" %s >    ',
        ( isset( $this->comment_link_remove_options['comment_show_voice_message_enable'] ) && $this->comment_link_remove_options['comment_show_voice_message_enable'] =='1' ) ? 'checked' : ''
    );
}

public function comment_show_voice_message_enable_for_woocommerce_callback() {
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[comment_show_voice_message_enable_for_woocommerce]" id="comment_show_voice_message_enable_for_woocommerce" value="1" %s >    ',
        ( isset( $this->comment_link_remove_options['comment_show_voice_message_enable_for_woocommerce'] ) && $this->comment_link_remove_options['comment_show_voice_message_enable_for_woocommerce'] =='1' ) ? 'checked' : ''
    );
}

    // qc_clr_email_subscription_mailchamp_enalbe_disable
public function qc_clr_email_subscription_mailchamp_enalbe_disable_callback() {
    $checked = ( isset( $this->comment_link_remove_options['qc_clr_email_subscription_mailchamp_enalbe_disable'] ) && $this->comment_link_remove_options['qc_clr_email_subscription_mailchamp_enalbe_disable'] =='1' ) ? 'checked' : '';
    $link = ( isset( $this->comment_link_remove_options['qc_clr_email_subscription_mailchamp_enalbe_disable'] ) && $this->comment_link_remove_options['qc_clr_email_subscription_mailchamp_enalbe_disable'] =='1' ) ? '<a href="' . esc_url( admin_url( 'edit.php?post_type=qc_clr_mailchamp' ) ) . '"> ' . esc_html__( 'Manage Settings', 'comment-link-remove' ) . '</a>' : '';
    printf(
        '<input type="checkbox" name="comment_link_remove_option_name[qc_clr_email_subscription_mailchamp_enalbe_disable]" id="qc_clr_email_subscription_mailchamp_enalbe_disable" value="1" %s > %s',
        esc_attr( $checked ),
        wp_kses_post( $link )
    );
}




}


function comment_link_remove_commenter_email_pro_feature(){

    ?>

    <div class="wrap">
        <h1><?php  esc_html_e( 'List of All Commenter Email IDs', 'comment-link-remove'); ?></h1>
    <div class="qc-clr-emails-page-wrap">
        <div class="qc-clr-emails-card">
            <div class="qc-clr-emails-header">
                <div class="qc-clr-emails-title-area">
                    <h2 class="qc-clr-emails-title"><?php  esc_html_e( 'List of All Commenter Email IDs', 'comment-link-remove'); ?></h2>
                    <span class="qc-clr-pro-badge"><?php  esc_html_e( 'Pro Feature', 'comment-link-remove'); ?></span>
                </div>
                
                <div class="qc-clr-pro-banner">
                    <div class="qc-clr-pro-banner-content">
                        <span class="dashicons dashicons-lock qc-clr-lock-icon"></span>
                        <div class="qc-clr-pro-banner-text">
                            <strong><?php  esc_html_e( 'Commenter Email Export & List', 'comment-link-remove'); ?></strong>
                            <p><?php  esc_html_e( 'List of All Commenter Email IDs is a Pro Version Feature. Unlock the ability to view, manage, and export all commenter emails to grow your audience and email marketing lists.', 'comment-link-remove'); ?></p>
                        </div>
                    </div>
                    <a class="qc-clr-pro-upgrade-btn" href="<?php  echo esc_url( 'https://www.quantumcloud.net/products/comment-tools/'); ?>" target="_blank">
                        <?php  esc_html_e( 'Upgrade to Pro', 'comment-link-remove'); ?> &rarr;
                    </a>
                </div>

                <div class="qc-clr-emails-stats">
                    <span class="dashicons dashicons-email-alt"></span>
                    <span><?php  esc_html_e( 'There are 5 unique and approved commenter email addresses for this site (Sample Preview).', 'comment-link-remove'); ?></span>
                </div>
            </div>

            <div class="qc-clr-emails-table-container">
                <table class="qc-clr-commenter-emails-table">
                    <thead>
                        <tr>
                            <th><?php  esc_html_e( 'Email Address', 'comment-link-remove'); ?></th>
                            <th><?php  esc_html_e( 'Commenter Name', 'comment-link-remove'); ?></th>
                            <th><?php  esc_html_e( 'Website URL', 'comment-link-remove'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="<?php esc_attr_e( 'Email', 'comment-link-remove'); ?>"><span class="qc-clr-email-tag">sample1@gmail.com</span></td>
                            <td data-label="<?php esc_attr_e( 'Name', 'comment-link-remove'); ?>"><span class="qc-clr-name-tag">Alex Gould</span></td>
                            <td data-label="<?php esc_attr_e( 'URL', 'comment-link-remove'); ?>"><a class="qc-clr-table-url" href="<?php  echo esc_url( 'https://sample.com'); ?>" target="_blank"><?php  echo esc_html( 'https://sample.com'); ?></a></td>
                        </tr>
                        <tr>
                            <td data-label="<?php esc_attr_e( 'Email', 'comment-link-remove'); ?>"><span class="qc-clr-email-tag">sample2@gmail.com</span></td>
                            <td data-label="<?php esc_attr_e( 'Name', 'comment-link-remove'); ?>"><span class="qc-clr-name-tag">D.R. Allisonin</span></td>
                            <td data-label="<?php esc_attr_e( 'URL', 'comment-link-remove'); ?>"><a class="qc-clr-table-url" href="<?php  echo esc_url( 'https://sample2.com'); ?>" target="_blank"><?php  echo esc_html( 'https://sample2.com'); ?></a></td>
                        </tr>
                        <tr>
                            <td data-label="<?php esc_attr_e( 'Email', 'comment-link-remove'); ?>"><span class="qc-clr-email-tag">sample3@gmail.com</span></td>
                            <td data-label="<?php esc_attr_e( 'Name', 'comment-link-remove'); ?>"><span class="qc-clr-name-tag">Anonymous</span></td>
                            <td data-label="<?php esc_attr_e( 'URL', 'comment-link-remove'); ?>"><span class="qc-clr-empty-val">&mdash;</span></td>
                        </tr>
                        <tr>
                            <td data-label="<?php esc_attr_e( 'Email', 'comment-link-remove'); ?>"><span class="qc-clr-email-tag">sample4@gmail.com</span></td>
                            <td data-label="<?php esc_attr_e( 'Name', 'comment-link-remove'); ?>"><span class="qc-clr-name-tag">Dave Arnold</span></td>
                            <td data-label="<?php esc_attr_e( 'URL', 'comment-link-remove'); ?>"><span class="qc-clr-empty-val">&mdash;</span></td>
                        </tr>
                        <tr>
                            <td data-label="<?php esc_attr_e( 'Email', 'comment-link-remove'); ?>"><span class="qc-clr-email-tag">sample5@gmail.com</span></td>
                            <td data-label="<?php esc_attr_e( 'Name', 'comment-link-remove'); ?>"><span class="qc-clr-name-tag">Manuel Castillo</span></td>
                            <td data-label="<?php esc_attr_e( 'URL', 'comment-link-remove'); ?>"><span class="qc-clr-empty-val">&mdash;</span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="qc-clr-table-footer">
                    <span><?php  esc_html_e( 'Showing 5 sample commenter emails.', 'comment-link-remove'); ?></span>
                </div>
            </div>

            <div class="qc-clr-export-card">
                <div class="qc-clr-export-header">
                    <span class="dashicons dashicons-media-spreadsheet qc-clr-export-icon"></span>
                    <div>
                        <h4 class="qc-clr-export-title"><?php  esc_html_e( 'Export Commenter Emails', 'comment-link-remove'); ?></h4>
                        <p class="qc-clr-export-desc"><?php  esc_html_e( 'Download the full list of verified email addresses in standard CSV format for Mailchimp, Newsletter, or CRM tools.', 'comment-link-remove'); ?></p>
                    </div>
                </div>
                <form class="qc-clr-export-form" action="" method="get" onsubmit="return false;">
                    <div class="qc-clr-export-options">
                        <label class="qc-clr-checkbox-label" for="include_urls">
                            <input type="checkbox" name="include_url" id="include_urls" value="1" disabled>
                            <span><?php  esc_html_e( 'Include commenter website URL in CSV', 'comment-link-remove'); ?></span>
                        </label>
                    </div>
                    <div class="qc-clr-export-actions">
                        <button type="button" class="button qc-clr-btn-disabled" disabled>
                            <span class="dashicons dashicons-download"></span>
                            <?php  esc_html_e( 'Download CSV (Pro Only)', 'comment-link-remove'); ?>
                        </button>
                        <a href="<?php  echo esc_url( 'https://www.quantumcloud.net/products/comment-tools/'); ?>" target="_blank" class="qc-clr-upgrade-text-link">
                            <?php  esc_html_e( 'Upgrade to Pro to Export', 'comment-link-remove'); ?> &rarr;
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

<?php

}


if ( is_admin() )
    $comment_link_remove = new CommentLinkRemove();