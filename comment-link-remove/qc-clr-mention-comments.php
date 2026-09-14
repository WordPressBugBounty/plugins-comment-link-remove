<?php
defined('ABSPATH') or die("No direct script access!");


function qcclr_comment_mention_admin_settings(){

    $qcclr_settings = get_option( 'qcclr_settings' );

    // Get status.
    $qcclr_enable_comment_mention = ! empty( $qcclr_settings['qcclr_enable_comment_mention'] ) ? $qcclr_settings['qcclr_enable_comment_mention'] : false;
    $qcclr_enable_comment_mention_comment = ! empty( $qcclr_settings['qcclr_enable_comment_mention_comment'] ) ? $qcclr_settings['qcclr_enable_comment_mention_comment'] : false;

    $qcclr_email_enable = ! empty( $qcclr_settings['qcclr_email_enable'] ) ? $qcclr_settings['qcclr_email_enable'] : false;
    // Get subject.
    $qcclr_subject = ! empty( $qcclr_settings['qcclr_email_subject'] ) ? $qcclr_settings['qcclr_email_subject'] : '';
    // Get content.
    $qcclr_mail_content = ! empty( $qcclr_settings['qcclr_mail_content'] ) ? $qcclr_settings['qcclr_mail_content'] : '';
    // Get Selected.
    $qcclr_enabled_user_roles = ! empty( $qcclr_settings['qcclr_enabled_user_roles'] ) ? $qcclr_settings['qcclr_enabled_user_roles'] : array();

    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Comment Mention Settings', 'comment-link-remove'); ?></h1>
    <div class="qc-clr-mention-page-wrap">
        <div class="qc-clr-mention-card">
            <!-- Header Area -->
            <div class="qc-clr-mention-header">
                <div class="qc-clr-mention-title-area">
                    <h2 class="qc-clr-mention-title"><?php esc_html_e( 'Comment Mention Settings', 'comment-link-remove'); ?></h2>
                    <span class="qc-clr-pro-badge"><?php esc_html_e( 'Pro Feature', 'comment-link-remove'); ?></span>
                </div>
                <p class="qc-clr-mention-subtitle"><?php esc_html_e('Allow users to mention each other in comments with autocomplete tagging (@username) and instant email notifications.', 'comment-link-remove'); ?></p>

                <!-- Pro Notice Banner -->
                <div class="qc-clr-pro-banner">
                    <div class="qc-clr-pro-banner-content">
                        <span class="dashicons dashicons-at qc-clr-at-icon"></span>
                        <div class="qc-clr-pro-banner-text">
                            <strong><?php esc_html_e( 'User @Mention Tagging & Email Notifications', 'comment-link-remove'); ?></strong>
                            <p><?php esc_html_e( 'Comment Mention is a Pro Version Feature. Enable users to tag other commenters with @username and automatically notify them via personalized email templates.', 'comment-link-remove'); ?></p>
                        </div>
                    </div>
                    <a class="qc-clr-pro-upgrade-btn" href="<?php echo esc_url( 'https://www.quantumcloud.net/products/comment-tools/'); ?>" target="_blank">
                        <?php esc_html_e( 'Upgrade to Pro', 'comment-link-remove'); ?> &rarr;
                    </a>
                </div>
            </div>

            <form method="post" action="" class="qc-clr-mention-form">
                <?php wp_nonce_field( 'qcclr_save_data_action', 'qcclr_save_data_field' ); ?>
                <table class="form-table qc-clr-mention-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="qcclr_enable_comment_mention"><?php esc_html_e( 'Enable Comment Mention', 'comment-link-remove'); ?></label>
                            </th>
                            <td>
                                <label class="qc-clr-checkbox-toggle">
                                    <input type="checkbox" id="qcclr_enable_comment_mention" name="qcclr_enable_comment_mention" value="1" <?php checked( $qcclr_enable_comment_mention, '1' ); ?> />
                                    <span><?php esc_html_e( 'Enable @username auto-complete tagging for commenters.', 'comment-link-remove'); ?></span>
                                </label>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="qcclr_enable_comment_mention_comment"><?php esc_html_e( 'Enable Content Mention', 'comment-link-remove'); ?></label>
                            </th>
                            <td>
                                <label class="qc-clr-checkbox-toggle">
                                    <input type="checkbox" id="qcclr_enable_comment_mention_comment" name="qcclr_enable_comment_mention_comment" value="1" <?php checked( $qcclr_enable_comment_mention_comment, '1' ); ?> />
                                    <span><?php esc_html_e( 'Parse and format user mentions inside comment body text.', 'comment-link-remove'); ?></span>
                                </label>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="qcclr_email_enable"><?php esc_html_e( 'Enable Email Alerts', 'comment-link-remove'); ?></label>
                            </th>
                            <td>
                                <label class="qc-clr-checkbox-toggle">
                                    <input type="checkbox" id="qcclr_email_enable" name="qcclr_email_enable" value="1" <?php checked( $qcclr_email_enable, '1' ); ?> />
                                    <span><?php esc_html_e( 'Send automatic email notification to users when they are mentioned.', 'comment-link-remove'); ?></span>
                                </label>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="qcclr_email_subject"><?php esc_html_e( 'Email Subject', 'comment-link-remove'); ?></label>
                            </th>
                            <td>
                                <input type="text" id="qcclr_email_subject" name="qcclr_email_subject" class="qcclr-email-subject-input regular-text" value="<?php echo esc_attr( $qcclr_subject ); ?>" placeholder="<?php esc_attr_e('You were mentioned in a comment!', 'comment-link-remove'); ?>" />
                                <p class="description"><?php esc_html_e( 'Subject line for email notifications sent to mentioned users.', 'comment-link-remove'); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="qcclr_mail_content"><?php esc_html_e( 'Email Content Template', 'comment-link-remove'); ?></label>
                            </th>
                            <td>
                                <div class="qc-clr-editor-wrap">
                                    <?php
                                    $editor_id = 'qcclr_mail_content';
                                    $settings  = array(
                                        'media_buttons' => false,
                                        'textarea_rows' => 7,
                                    );

                                    wp_editor( wp_kses_post( $qcclr_mail_content ), $editor_id, $settings );
                                    ?>
                                </div>
                                <div class="qc-clr-shortcodes-container">
                                    <div class="qc-clr-shortcodes-header">
                                        <span class="dashicons dashicons-shortcode"></span>
                                        <strong><?php esc_html_e( 'Available Dynamic Shortcodes:', 'comment-link-remove'); ?></strong>
                                    </div>
                                    <div class="qc-clr-shortcodes-grid">
                                        <div class="qc-clr-shortcode-item">
                                            <code class="qc-clr-shortcode-tag">#comment_link#</code>
                                            <span><?php esc_html_e( 'Direct link to comment anchor', 'comment-link-remove'); ?></span>
                                        </div>
                                        <div class="qc-clr-shortcode-item">
                                            <code class="qc-clr-shortcode-tag">#post_name#</code>
                                            <span><?php esc_html_e( 'Post / article title', 'comment-link-remove'); ?></span>
                                        </div>
                                        <div class="qc-clr-shortcode-item">
                                            <code class="qc-clr-shortcode-tag">#user_name#</code>
                                            <span><?php esc_html_e( 'Username of mentioned person', 'comment-link-remove'); ?></span>
                                        </div>
                                        <div class="qc-clr-shortcode-item">
                                            <code class="qc-clr-shortcode-tag">#commenter_name#</code>
                                            <span><?php esc_html_e( 'Name of person who commented', 'comment-link-remove'); ?></span>
                                        </div>
                                        <div class="qc-clr-shortcode-item">
                                            <code class="qc-clr-shortcode-tag">#comment_content#</code>
                                            <span><?php esc_html_e( 'Full body of the comment', 'comment-link-remove'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <?php do_action( 'qcclr_more_options' ); ?>
                    </tbody>
                </table>

                <div class="qc-clr-submit-bar">
                    <button type="submit" class="button button-primary qc-clr-save-btn" disabled=""><?php esc_html_e('Save Changes', 'comment-link-remove'); ?></button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <?php
}