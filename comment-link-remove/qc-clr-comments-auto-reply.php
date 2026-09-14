<?php
defined('ABSPATH') or die("No direct script access!");

if ( ! function_exists( 'qcclr_comment_autoreply_admin_settings' ) ) {
    function qcclr_comment_autoreply_admin_settings(){

        $qcclr_autoreply_settings = get_option( 'qcclr_autoreply_settings' );

        // Get status.
        $qcclr_enable_comment_autoreply = ! empty( $qcclr_autoreply_settings['qcclr_enable_comment_autoreply'] ) ? $qcclr_autoreply_settings['qcclr_enable_comment_autoreply'] : false;
        $qcclr_enable_comment_autoreply_child = ! empty( $qcclr_autoreply_settings['qcclr_enable_comment_autoreply_child'] ) ? $qcclr_autoreply_settings['qcclr_enable_comment_autoreply_child'] : false;
        $qcld_seohelp_ai_engines = ! empty( $qcclr_autoreply_settings['qcld_seohelp_ai_engines'] ) ? $qcclr_autoreply_settings['qcld_seohelp_ai_engines'] : 'gpt-3.5-turbo';

        $qcld_seohelp_api_key = ! empty( $qcclr_autoreply_settings['qcld_seohelp_api_key'] ) ? $qcclr_autoreply_settings['qcld_seohelp_api_key'] : '';
        // Get subject.
        $qcld_seohelp_max_token = ! empty( $qcclr_autoreply_settings['qcld_seohelp_max_token'] ) ? $qcclr_autoreply_settings['qcld_seohelp_max_token'] : '500';
        // Get content.
        $qcld_seohelp_ai_temperature = ! empty( $qcclr_autoreply_settings['qcld_seohelp_ai_temperature'] ) ? $qcclr_autoreply_settings['qcld_seohelp_ai_temperature'] : '0.7';
        // Get Selected.
        $qcld_seohelp_ai_ppenalty = ! empty( $qcclr_autoreply_settings['qcld_seohelp_ai_ppenalty'] ) ? $qcclr_autoreply_settings['qcld_seohelp_ai_ppenalty'] : '0';
        $qcld_seohelp_ai_fpenalty = ! empty( $qcclr_autoreply_settings['qcld_seohelp_ai_fpenalty'] ) ? $qcclr_autoreply_settings['qcld_seohelp_ai_fpenalty'] : '0';

        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Comment AI Auto Reply Settings', 'comment-link-remove'); ?></h1>
        <div class="qc-clr-autoreply-page-wrap">
            <div class="qc-clr-autoreply-card">
                <!-- Header Area -->
                <div class="qc-clr-autoreply-header">
                    <div class="qc-clr-autoreply-title-area">
                        <h2 class="qc-clr-autoreply-title"><?php esc_html_e( 'Comment AI Auto Reply Settings', 'comment-link-remove'); ?></h2>
                        <span class="qc-clr-pro-badge"><?php esc_html_e( 'Pro Feature', 'comment-link-remove'); ?></span>
                    </div>
                    <p class="qc-clr-autoreply-subtitle"><?php esc_html_e('Automatically generate intelligent, context-aware AI replies to approved visitor comments using OpenAI GPT models.', 'comment-link-remove'); ?></p>

                    <!-- Pro Notice Banner -->
                    <div class="qc-clr-pro-banner">
                        <div class="qc-clr-pro-banner-content">
                            <span class="dashicons dashicons-format-chat qc-clr-ai-icon"></span>
                            <div class="qc-clr-pro-banner-text">
                                <strong><?php esc_html_e( 'AI Automated Comment Replies (ChatGPT / OpenAI)', 'comment-link-remove'); ?></strong>
                                <p><?php esc_html_e( 'Comment AI Auto Reply is a Pro Version Feature. Automatically reply to approved comments and nested child comments to dramatically boost user engagement.', 'comment-link-remove'); ?></p>
                            </div>
                        </div>
                        <a class="qc-clr-pro-upgrade-btn" href="<?php echo esc_url( 'https://www.quantumcloud.net/products/comment-tools/'); ?>" target="_blank">
                            <?php esc_html_e( 'Upgrade to Pro', 'comment-link-remove'); ?> &rarr;
                        </a>
                    </div>
                </div>

                <form method="post" action="" class="qc-clr-autoreply-form">
                    <?php wp_nonce_field( 'qcclr_autoreply_data_action', 'qcclr_autoreply_save_data_field' ); ?>
                    <table class="form-table qc-clr-autoreply-table">
                        <tbody>
                            <tr valign="top">
                                <th scope="row">
                                    <label for="qcclr_enable_comment_autoreply"><?php esc_html_e( 'Enable Comment Auto Reply', 'comment-link-remove'); ?></label>
                                </th>
                                <td>
                                    <label class="qc-clr-checkbox-toggle">
                                        <input type="checkbox" id="qcclr_enable_comment_autoreply" name="qcclr_enable_comment_autoreply" value="1" <?php checked( $qcclr_enable_comment_autoreply, '1' ); ?> />
                                        <span><?php esc_html_e( 'Automatically generate and post AI replies to newly approved comments.', 'comment-link-remove'); ?></span>
                                    </label>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="qcclr_enable_comment_autoreply_child"><?php esc_html_e( 'Child Comment Auto Reply', 'comment-link-remove'); ?></label>
                                </th>
                                <td>
                                    <label class="qc-clr-checkbox-toggle">
                                        <input type="checkbox" id="qcclr_enable_comment_autoreply_child" name="qcclr_enable_comment_autoreply_child" value="1" <?php checked( $qcclr_enable_comment_autoreply_child, '1' ); ?> />
                                        <span><?php esc_html_e( 'Also generate AI auto replies for threaded / child reply comments.', 'comment-link-remove'); ?></span>
                                    </label>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="qcld_seohelp_api_key"><?php esc_html_e('OpenAI API Key', 'comment-link-remove'); ?></label>
                                </th>
                                <td>
                                    <div class="qc-clr-api-input-wrap">
                                        <input type="password" id="qcld_seohelp_api_key" class="regular-text qc-clr-input-field" name="qcld_seohelp_api_key" placeholder="<?php esc_attr_e('sk-...', 'comment-link-remove'); ?>" value="<?php echo esc_attr( $qcld_seohelp_api_key ); ?>">
                                        <a class="qc-clr-api-key-link" href="<?php echo esc_url('https://platform.openai.com/api-keys'); ?>" target="_blank">
                                            <span class="dashicons dashicons-external"></span>
                                            <?php esc_html_e('Get Your OpenAI API Key', 'comment-link-remove'); ?>
                                        </a>
                                    </div>
                                    <p class="description"><?php esc_html_e('Your private secret API key from OpenAI Platform dashboard.', 'comment-link-remove'); ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="qcld_seohelp_ai_engines"><?php esc_html_e('AI Model / Engine', 'comment-link-remove'); ?></label>
                                </th>
                                <td>
                                    <select class="qc-clr-select-input" id="qcld_seohelp_ai_engines" name="qcld_seohelp_ai_engines">
                                        <option value="gpt-4o" <?php selected( $qcld_seohelp_ai_engines, 'gpt-4o' ); ?>><?php esc_html_e( 'GPT-4o (Latest / Fastest)', 'comment-link-remove');?></option>
                                        <option value="gpt-4-turbo" <?php selected( $qcld_seohelp_ai_engines, 'gpt-4-turbo' ); ?>><?php esc_html_e( 'GPT-4 Turbo', 'comment-link-remove');?></option>
                                        <option value="gpt-4" <?php selected( $qcld_seohelp_ai_engines, 'gpt-4' ); ?>><?php esc_html_e( 'GPT-4', 'comment-link-remove');?></option>
                                        <option value="gpt-3.5-turbo" <?php selected( $qcld_seohelp_ai_engines, 'gpt-3.5-turbo' ); ?>><?php esc_html_e( 'GPT-3.5 Turbo', 'comment-link-remove'); ?></option>
                                        <option value="text-davinci-003" <?php selected( $qcld_seohelp_ai_engines, 'text-davinci-003' ); ?>><?php esc_html_e('Davinci (Legacy)', 'comment-link-remove'); ?></option>
                                    </select>
                                    <p class="description"><?php esc_html_e('Select the language model used to compose comments.', 'comment-link-remove'); ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="qcld_seohelp_max_token"><?php esc_html_e('Max Tokens (0 – 4000)', 'comment-link-remove'); ?></label>
                                </th>
                                <td>
                                    <div class="qc-clr-inline-field">
                                        <input type="number" class="qc-clr-number-input" id="qcld_seohelp_max_token" name="qcld_seohelp_max_token" min="50" max="4000" placeholder="500" value="<?php echo esc_attr( $qcld_seohelp_max_token ); ?>">
                                        <span class="qc-clr-input-unit"><?php esc_html_e('Tokens', 'comment-link-remove'); ?></span>
                                        <span class="qc-clr-hint-chip"><?php esc_html_e('Recommended: 300 to 800 tokens', 'comment-link-remove'); ?></span>
                                    </div>
                                    <p class="description"><?php esc_html_e('Limits maximum response length (1 token ≈ 4 characters of English text).', 'comment-link-remove'); ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="qcld_seohelp_ai_temperature"><?php esc_html_e('Temperature (Creativity)', 'comment-link-remove'); ?></label>
                                </th>
                                <td>
                                    <div class="qc-clr-range-control">
                                        <input id="qcld_seohelp_ai_temperature" class="qc-clr-range-input" name="qcld_seohelp_ai_temperature" type="range" min="0" max="1.0" step="0.1" value="<?php echo esc_attr( $qcld_seohelp_ai_temperature ? $qcld_seohelp_ai_temperature : '0.7' ); ?>" oninput="document.getElementById('temperatureVal').innerText = this.value" />
                                        <span class="qc-clr-param-badge" id="temperatureSliderValLabel"><span id="temperatureVal"><?php echo esc_html( $qcld_seohelp_ai_temperature ? $qcld_seohelp_ai_temperature : '0.7' ); ?></span></span>
                                    </div>
                                    <p class="description"><?php esc_html_e('Controls response creativity. Lower values (e.g. 0.2) are more deterministic; higher values (e.g. 0.8) are more creative.', 'comment-link-remove'); ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="qcld_seohelp_ai_ppenalty"><?php esc_html_e('Presence Penalty', 'comment-link-remove'); ?></label>
                                </th>
                                <td>
                                    <div class="qc-clr-range-control">
                                        <input type="range" id="qcld_seohelp_ai_ppenalty" class="qc-clr-range-input" name="qcld_seohelp_ai_ppenalty" min="-2.0" max="2.0" step="0.1" value="<?php echo esc_attr( $qcld_seohelp_ai_ppenalty ? $qcld_seohelp_ai_ppenalty : '0' ); ?>" oninput="document.getElementById('presence_penaltyVal').innerText = this.value" />
                                        <span class="qc-clr-param-badge" id="presence_penaltySliderValLabel"><span id="presence_penaltyVal"><?php echo esc_html( $qcld_seohelp_ai_ppenalty ? $qcld_seohelp_ai_ppenalty : '0' ); ?></span></span>
                                    </div>
                                    <p class="description"><?php esc_html_e('Number between -2.0 and 2.0. Positive values encourage the model to introduce new topics in the response.', 'comment-link-remove'); ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="qcld_seohelp_ai_fpenalty"><?php esc_html_e('Frequency Penalty', 'comment-link-remove'); ?></label>
                                </th>
                                <td>
                                    <div class="qc-clr-range-control">
                                        <input type="range" id="qcld_seohelp_ai_fpenalty" class="qc-clr-range-input" name="qcld_seohelp_ai_fpenalty" min="-2.0" max="2.0" step="0.1" value="<?php echo esc_attr( $qcld_seohelp_ai_fpenalty ? $qcld_seohelp_ai_fpenalty : '0' ); ?>" oninput="document.getElementById('frequency_penaltyVal').innerText = this.value" />
                                        <span class="qc-clr-param-badge" id="frequency_penaltySliderValLabel"><span id="frequency_penaltyVal"><?php echo esc_html( $qcld_seohelp_ai_fpenalty ? $qcld_seohelp_ai_fpenalty : '0' ); ?></span></span>
                                    </div>
                                    <p class="description"><?php esc_html_e('Number between -2.0 and 2.0. Positive values reduce verbatim repetition of words and phrases.', 'comment-link-remove'); ?></p>
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
}