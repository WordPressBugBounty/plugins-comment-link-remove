<?php

defined('ABSPATH') or die("No direct script access!");


function qcclr_comment_mention_admin_settings(){

    ob_start();

    $qcclr_settings = get_option( 'qcclr_settings' );

    // Get status.
    $qcclr_enable_comment_mention = ! empty( $qcclr_settings['qcclr_enable_comment_mention'] ) ? $qcclr_settings['qcclr_enable_comment_mention'] : false;
    $qcclr_enable_comment_mention_comment = ! empty( $qcclr_settings['qcclr_enable_comment_mention_comment'] ) ? $qcclr_settings['qcclr_enable_comment_mention_comment'] : false;

    $qcclr_email_enable = ! empty( $qcclr_settings['qcclr_email_enable'] ) ? $qcclr_settings['qcclr_email_enable'] : false;
    // Get subject.
    $qcclr_subject = ! empty( $qcclr_settings['qcclr_email_subject'] ) ? $qcclr_settings['qcclr_email_subject'] : qcclr_mail_subject();
    // Get content.
    $qcclr_mail_content = ! empty( $qcclr_settings['qcclr_mail_content'] ) ? $qcclr_settings['qcclr_mail_content'] : qcclr_default_mail_content();
    // Get Selected.
    $qcclr_enabled_user_roles = ! empty( $qcclr_settings['qcclr_enabled_user_roles'] ) ? $qcclr_settings['qcclr_enabled_user_roles'] : array();

    ?>
    <style>
        .form-table td p.description {
            display: inline;
        }
    </style>
        <div class="wrap">
        <h2><?php esc_html_e( 'Comment Mention Settings', 'qc-clr' ); ?></h2>

        <p class="qc_clr_upgrade_pro"><?php  esc_html_e( 'Comment Mention is a Pro Version Feature ', 'qc-clr' ); ?> <a href="<?php  echo esc_url( 'https://www.quantumcloud.com/products/comment-tools/', 'qc-clr' ); ?>" target="_blank"><span class="qc_clr_pro_feature" > <?php  esc_html_e( 'Upgrade to the Pro Version ', 'qc-clr' ); ?></span> </a> <?php  esc_html_e( 'to activate this feature.', 'qc-clr' ); ?></p>

        <form method="post" action="">
            <?php wp_nonce_field( 'qcclr_save_data_action', 'qcclr_save_data_field' ); ?>
            <table class="form-table">

                <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Enabled Comment Mention', 'qc-clr' ); ?></th>
                <td>
                    <input type="checkbox" name="qcclr_enable_comment_mention" value="1" <?php checked( $qcclr_enable_comment_mention, '1' ); ?> />
                    <p class="description"><?php esc_html_e( 'Enable comment mention for Mention Users.', 'qc-clr' ); ?><br/>
                </td>
                </tr>

                <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Enabled Content Mention', 'qc-clr' ); ?></th>
                <td>
                    <input type="checkbox" name="qcclr_enable_comment_mention_comment" value="1" <?php checked( $qcclr_enable_comment_mention_comment, '1' ); ?> />
                    <p class="description"><?php esc_html_e( 'Enable comment Mention for comment content.', 'qc-clr' ); ?><br/>
                </td>
                </tr>

                <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Enable Emails', 'qc-clr' ); ?></th>
                <td>
                    <input type="checkbox" name="qcclr_email_enable" value="1" <?php checked( $qcclr_email_enable, '1' ); ?> />
                    <p class="description"><?php esc_html_e( 'Whether to send email to mentioned user or not.', 'qc-clr' ); ?><br/>
                </td>
                </tr>

                <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Email Subject', 'qc-clr' ); ?></th>
                <td>
                    <input type="text" name="qcclr_email_subject" value="<?php echo esc_attr( $qcclr_subject ); ?>" style="min-width: 350px;" />
                    <p class="description"><?php esc_html_e( 'Subject for mentioned user email.', 'qc-clr' ); ?><br/>
                </td>
                </tr>

                <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Email Content', 'qc-clr' ); ?></th>
                <td>
                    <?php

                        $editor_id = 'qcclr_mail_content';
                        $settings  = array(
                            'media_buttons' => false,
                        );

                        wp_editor( wp_kses_post( $qcclr_mail_content ), $editor_id, $settings );
                    ?>
                    <p class="description"><?php esc_html_e( 'Mail content for mentioned user email. Available shortcodes:', 'qc-clr' ); ?><br/>
                    <strong>#comment_link#</strong>&nbsp;-&nbsp;<?php esc_html_e( 'Link where user is mentioned.', 'qc-clr' ); ?><br/>
                    <strong>#post_name#</strong>&nbsp;-&nbsp;<?php esc_html_e( 'Post title where user is mentioned.', 'qc-clr' ); ?><br/>
                    <strong>#user_name#</strong>&nbsp;-&nbsp;<?php esc_html_e( 'Username who is mentioned.', 'qc-clr' ); ?><br/>
                    <strong>#commenter_name#</strong>&nbsp;-&nbsp;<?php esc_html_e( 'Commenter name.', 'qc-clr' ); ?><br/>
                    <strong>#comment_content#</strong>&nbsp;-&nbsp;<?php esc_html_e( 'Comment content.', 'qc-clr' ); ?><br/>
                    </p>
                </td>
                </tr>

                <?php do_action( 'qcclr_more_options' ); ?>

            </table>

            <button type="submit" class="button button-primary" disabled=""><?php esc_html_e('Save Changes'); ?></button>

        </form>
        </div>
    <?php
    echo ob_get_clean();
    
    
}