<?php

defined('ABSPATH') or die("No direct script access!");

if ( ! function_exists( 'qcclr_comment_autoreply_admin_settings' ) ) {
    function qcclr_comment_autoreply_admin_settings(){

        ob_start();

        $qcclr_autoreply_settings = get_option( 'qcclr_autoreply_settings' );

        // Get status.
        $qcclr_enable_comment_autoreply = ! empty( $qcclr_autoreply_settings['qcclr_enable_comment_autoreply'] ) ? $qcclr_autoreply_settings['qcclr_enable_comment_autoreply'] : false;
        $qcclr_enable_comment_autoreply_child = ! empty( $qcclr_autoreply_settings['qcclr_enable_comment_autoreply_child'] ) ? $qcclr_autoreply_settings['qcclr_enable_comment_autoreply_child'] : false;
        $qcld_seohelp_ai_engines = ! empty( $qcclr_autoreply_settings['qcld_seohelp_ai_engines'] ) ? $qcclr_autoreply_settings['qcld_seohelp_ai_engines'] : false;

        $qcld_seohelp_api_key = ! empty( $qcclr_autoreply_settings['qcld_seohelp_api_key'] ) ? $qcclr_autoreply_settings['qcld_seohelp_api_key'] : '';
        // Get subject.
        $qcld_seohelp_max_token = ! empty( $qcclr_autoreply_settings['qcld_seohelp_max_token'] ) ? $qcclr_autoreply_settings['qcld_seohelp_max_token'] : '';
        // Get content.
        $qcld_seohelp_ai_temperature = ! empty( $qcclr_autoreply_settings['qcld_seohelp_ai_temperature'] ) ? $qcclr_autoreply_settings['qcld_seohelp_ai_temperature'] : '';
        // Get Selected.
        $qcld_seohelp_ai_ppenalty = ! empty( $qcclr_autoreply_settings['qcld_seohelp_ai_ppenalty'] ) ? $qcclr_autoreply_settings['qcld_seohelp_ai_ppenalty'] : '';
        $qcld_seohelp_ai_fpenalty = ! empty( $qcclr_autoreply_settings['qcld_seohelp_ai_fpenalty'] ) ? $qcclr_autoreply_settings['qcld_seohelp_ai_fpenalty'] : '';

        ?>
        <style>
            .form-table td p.description {
                display: inline;
            }
        </style>
            <div class="wrap  qcld_autoreply">
            <h2><?php esc_html_e( 'Comment AI Auto Reply Settings', 'qc-clr' ); ?></h2>
            

            <p class="qc_clr_upgrade_pro"><?php  esc_html_e( 'Comment AI Auto Reply is a Pro Version Feature ', 'qc-clr' ); ?> <a href="<?php  echo esc_url( 'https://www.quantumcloud.com/products/comment-tools/', 'qc-clr' ); ?>" target="_blank"><span class="qc_clr_pro_feature" > <?php  esc_html_e( 'Upgrade to the Pro Version ', 'qc-clr' ); ?></span> </a> <?php  esc_html_e( 'to activate this feature.', 'qc-clr' ); ?></p>

            <form method="post" action="">
                <?php wp_nonce_field( 'qcclr_autoreply_data_action', 'qcclr_autoreply_save_data_field' ); ?>
                <table class="form-table">
                    <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'Enabled Comment Auto Reply', 'qc-clr' ); ?></th>
                    <td>
                        <input type="checkbox" name="qcclr_enable_comment_autoreply" value="1" <?php checked( $qcclr_enable_comment_autoreply, '1' ); ?> />
                        <p class="description"><?php esc_html_e( 'Auto Reply to approved comment', 'qc-clr' ); ?><br/>
                    </td>
                    </tr>
                    <tr valign="top">
                    <th scope="row"><?php esc_html_e( 'Child Comment Auto Reply', 'qc-clr' ); ?></th>
                    <td>
                        <input type="checkbox" name="qcclr_enable_comment_autoreply_child" value="1" <?php checked( $qcclr_enable_comment_autoreply_child, '1' ); ?> />
                        <p class="description"><?php esc_html_e( 'Auto Reply to child comments also', 'qc-clr' ); ?><br/>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row"><?php esc_html_e('API KEY', 'seo-help'); ?></th>
                    <td>

                        <input type="text" class="form-control" name="qcld_seohelp_api_key" placeholder="<?php esc_html_e('API KEY', 'seo-help'); ?>" value="<?php echo $qcld_seohelp_api_key; ?>">
                        <p><a class="qcld_help_link" href="<?php echo esc_url('https://beta.openai.com/account/api-keys'); ?>" target="_blank"><?php esc_html_e('Get Your Api Key'); ?></a></p>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row"><?php esc_html_e('Engines', 'seo-help'); ?></th>
                    <td>
                        <select class="custom-select" name="qcld_seohelp_ai_engines" placeholder="<?php esc_html_e('1234 Main St', 'seo-help'); ?>" >
                            <option selected=""><?php esc_html_e('Please select Engines', 'seo-help'); ?></option>

                            <option value="<?php esc_attr_e( 'gpt-4','seo-help'); ?>" <?php echo (( $qcld_seohelp_ai_engines == 'gpt-4') ? esc_attr('selected') : '') ; ?>><?php esc_html_e( 'GPT-4','seo-help');?></option>
                            <option value="<?php esc_attr_e( 'gpt-3.5-turbo','seo-help'); ?>" <?php echo (( $qcld_seohelp_ai_engines == 'gpt-3.5-turbo') ? esc_attr('selected') : '') ; ?>><?php esc_html_e( 'GPT-3 turbo','seo-help'); ?></option>
                            <option value="text-davinci-003" <?php echo (( $qcld_seohelp_ai_engines == 'text-davinci-003') ? ' selected' : ' ') ;?>><?php esc_html_e('Davinci ( GPT-3 )', 'seo-help'); ?></option>
                            <option value="<?php esc_attr_e('text-davinci-001', 'seo-help'); ?>" <?php echo (( $qcld_seohelp_ai_engines == 'text-davinci-001')? ' selected' : ' ') ;?>><?php esc_html_e('Davinci', 'seo-help'); ?></option>
                            <option value="<?php esc_attr_e('text-ada-001', 'seo-help'); ?>" <?php echo (( $qcld_seohelp_ai_engines == 'text-ada-001')? ' selected' : ' ') ;?>><?php esc_html_e('Ada', 'seo-help'); ?></option>
                            <option value="<?php esc_attr_e('text-curie-001', 'seo-help'); ?>" <?php echo (( $qcld_seohelp_ai_engines == 'text-curie-001')? ' selected' : ' ') ;?>><?php esc_html_e('Curie', 'seo-help'); ?></option>
                            <option value="<?php esc_attr_e('text-babbage-001', 'seo-help'); ?>" <?php echo (( $qcld_seohelp_ai_engines == 'text-babbage-001')? ' selected' : ' ') ;?>><?php esc_html_e('Babbag', 'seo-help'); ?></option>
                        </select>
                    </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Max token ( Min: 0, Max:4000 )', 'seo-help'); ?></th>
                        <td>
                            <input type="text" class="max_token" id="qcld_seohelp_max_token" name="qcld_seohelp_max_token" placeholder="Max token"  value="<?php echo $qcld_seohelp_max_token;?>">
                            <p class="qcld_seohelp_p"><?php esc_html_e('Depending on the model', 'seo-help'); ?></p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Temperature', 'seo-help'); ?></th>
                        <td>
                            <input id="qcld_seohelp_ai_temperature" name="qcld_seohelp_ai_temperature" type="text" data-slider-min="0" data-slider-max="1.0" data-slider-step="0.1" data-slider-value="<?php echo $qcld_seohelp_ai_temperature ? $qcld_seohelp_ai_temperature : '0.5' ;?>"  value="<?php echo $qcld_seohelp_ai_temperature; ?>"/>
                            <span id="temperatureSliderValLabel"> <span id="temperatureVal"><?php echo $qcld_seohelp_ai_temperature ? $qcld_seohelp_ai_temperature : '0.5' ;?></span></span>
                            <p class="qcld_seohelp_p"><?php esc_html_e('Temperature is a value between 0 and 1 that essentially lets you control how confident the model should be when making these predictions', 'seo-help'); ?></p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Presence Penalty', 'seo-help'); ?></th>
                        <td>
                            <input type="text" id="qcld_seohelp_ai_ppenalty" name="qcld_seohelp_ai_ppenalty" data-slider-min="-2" data-slider-max="2" data-slider-step="0.1" data-slider-value="<?php echo $qcld_seohelp_ai_ppenalty ? $qcld_seohelp_ai_ppenalty : '0' ;?>"  value="<?php echo $qcld_seohelp_ai_ppenalty;?>"/>
                            <span id="presence_penaltySliderValLabel"> <span id="presence_penaltyVal"><?php echo $qcld_seohelp_ai_ppenalty ? $qcld_seohelp_ai_ppenalty : '0' ;?></span></span>
                            <p class="qcld_seohelp_p"><?php esc_html_e('Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model’s likelihood to talk about new topics.', 'seo-help'); ?></p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Frequency Penalty', 'seo-help'); ?></th>
                        <td>
                           <input type="text" id="qcld_seohelp_ai_fpenalty" name="qcld_seohelp_ai_fpenalty" data-slider-min="-2" data-slider-max="2" data-slider-step="0.1" data-slider-value="<?php echo $qcld_seohelp_ai_fpenalty ? $qcld_seohelp_ai_fpenalty : '0' ;?>"  value="<?php echo $qcld_seohelp_ai_fpenalty;?>" />
                            <span id="frequency_penaltySliderValLabel"> <span id="frequency_penaltyVal"><?php echo $qcld_seohelp_ai_fpenalty ? $qcld_seohelp_ai_fpenalty : '0' ;?> </span></span>
                            <p class="qcld_seohelp_p"><?php esc_html_e('Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model’s likelihood to repeat the same line verbatim.', 'seo-help'); ?></p>
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

}