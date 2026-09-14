<?php
defined('ABSPATH') or die("No direct script access!");

function get_qcld_clr_key() {
	if( function_exists( 'get_site_option' ) ) {
		$qcld_clr_key = get_site_option( 'qcld_clr_key' );
	} else {
		$qcld_clr_key = get_option( 'qcld_clr_key' );
	}
	if( !$qcld_clr_key ) {
		if( current_user_can('edit_plugins') ) {
			$qcld_clr_key = md5( time() );
			if( function_exists( 'add_site_option' ) ) {
				$qcld_clr_key = add_site_option( 'qcld_clr_key', $qcld_clr_key );
			} else {
				$qcld_clr_key = add_option( 'qcld_clr_key', $qcld_clr_key );
			}
		} else {
			return;
		}
	}
	return $qcld_clr_key;
}

function qcld_clr_conf() {
	
	?>
<div class="wrap">
	<h1><?php esc_html_e('Comment Spam Protection', 'comment-link-remove'); ?></h1>
<div class="qc-clr-config-page-wrap">
	<div class="qc-clr-config-card">
		<!-- Page Header -->
		<div class="qc-clr-config-header">
			<div class="qc-clr-config-title-area">
				<h2 class="qc-clr-config-title"><?php esc_html_e('Comment Spam Protection', 'comment-link-remove'); ?></h2>
				<span class="qc-clr-pro-badge"><?php esc_html_e( 'Pro Feature', 'comment-link-remove'); ?></span>
			</div>
			<p class="qc-clr-config-subtitle"><?php esc_html_e('Configure advanced cookie-based spam defense, bot payload delivery, and speed spammer detection.', 'comment-link-remove'); ?></p>

			<!-- Pro Notice Banner -->
			<div class="qc-clr-pro-banner">
				<div class="qc-clr-pro-banner-content">
					<span class="dashicons dashicons-shield qc-clr-shield-icon"></span>
					<div class="qc-clr-pro-banner-text">
						<strong><?php esc_html_e( 'Comment Spam Protection & Anti-Bot Defense', 'comment-link-remove'); ?></strong>
						<p><?php esc_html_e( 'Comment Spam Protection is a Pro Version Feature. Automatically block automated spambots and speed-commenters before spam reaches your database.', 'comment-link-remove'); ?></p>
					</div>
				</div>
				<a class="qc-clr-pro-upgrade-btn" href="<?php echo esc_url( 'https://www.quantumcloud.net/products/comment-tools/'); ?>" target="_blank">
					<?php esc_html_e( 'Upgrade to Pro', 'comment-link-remove'); ?> &rarr;
				</a>
			</div>
		</div>

		<form action="" method="post" id="qcld_clr_conf" class="qc-clr-config-form">
			<?php wp_nonce_field('qcld_clr'); ?>

			<!-- 1. Enable Spam Protection -->
			<div class="qc-clr-form-group-card">
				<div class="qc-clr-form-group-header">
					<span class="dashicons dashicons-shield-alt"></span>
					<h3><?php esc_html_e( 'Spam Protection Status', 'comment-link-remove'); ?></h3>
				</div>
				<div class="qc-clr-form-group-body">
					<label class="qc-clr-toggle-control">
						<input type='checkbox' name='qcld_clr_spam_protection' value='enable' <?php checked( get_option( 'qcld_clr_spam_protection' ), 'enable' ); ?> />
						<span class="qc-clr-toggle-label"><b><?php esc_html_e( 'Enable Cookie-Based Spam Protection', 'comment-link-remove'); ?></b></span>
					</label>
					<p class="qc-clr-field-desc"><?php esc_html_e('Validates genuine human visitor cookies before accepting comment submissions.', 'comment-link-remove'); ?></p>
				</div>
			</div>

			<!-- 2. Action for Caught Comments -->
			<div class="qc-clr-form-group-card">
				<div class="qc-clr-form-group-header">
					<span class="dashicons dashicons-trash"></span>
					<h3><?php esc_html_e( 'Action on Detected Spam', 'comment-link-remove'); ?></h3>
				</div>
				<div class="qc-clr-form-group-body">
					<label class="qc-clr-select-label" for="qcld_clr_spam">
						<span><?php esc_html_e( 'What should happen to comments flagged as spam?', 'comment-link-remove'); ?></span>
						<select name='qcld_clr_spam' id='qcld_clr_spam' class="qc-clr-select-input">
							<option value='delete' <?php selected( get_option( 'qcld_clr_spam' ), 'delete' ); ?>><?php esc_html_e( 'Delete Permanently', 'comment-link-remove'); ?></option>
							<option value='spam' <?php selected( get_option( 'qcld_clr_spam' ), 'spam' ); ?>><?php esc_html_e( 'Move to Spam Folder', 'comment-link-remove'); ?></option>
						</select>
					</label>
				</div>
			</div>

			<!-- 3. Payload Delivery Mechanism -->
			<div class="qc-clr-form-group-card">
				<div class="qc-clr-form-group-header">
					<span class="dashicons dashicons-rest-api"></span>
					<h3><?php esc_html_e( 'Payload Delivery Mechanism', 'comment-link-remove'); ?></h3>
				</div>
				<div class="qc-clr-form-group-body">
					<div class="qc-clr-radio-options">
						<label class="qc-clr-radio-card <?php echo ( get_option( 'qcld_clr_delivery' ) === 'img' || ! get_option( 'qcld_clr_delivery' ) ) ? 'is-recommended' : ''; ?>">
							<input type='radio' name='qcld_clr_delivery' value='img' <?php checked( get_option( 'qcld_clr_delivery', 'img' ), 'img' ); ?> />
							<div class="qc-clr-radio-info">
								<strong><?php esc_html_e( 'Image File', 'comment-link-remove'); ?> <span class="qc-clr-recommended-badge"><?php esc_html_e('Recommended', 'comment-link-remove'); ?></span></strong>
								<p><?php esc_html_e( 'Delivers cookie payload via lightweight 1x1 image at the bottom of the page without blocking page render speed.', 'comment-link-remove'); ?></p>
							</div>
						</label>
						<label class="qc-clr-radio-card">
							<input type='radio' name='qcld_clr_delivery' value='css' <?php checked( get_option( 'qcld_clr_delivery' ), 'css' ); ?> />
							<div class="qc-clr-radio-info">
								<strong><?php esc_html_e( 'CSS File', 'comment-link-remove'); ?></strong>
								<p><?php esc_html_e( 'Loads cookie payload in stylesheet at top of page. Reliable for all bots, but may slightly impact page render start.', 'comment-link-remove'); ?></p>
							</div>
						</label>
					</div>
				</div>
			</div>

			<!-- 4. Speed Spammers -->
			<div class="qc-clr-form-group-card">
				<div class="qc-clr-form-group-header">
					<span class="dashicons dashicons-clock"></span>
					<h3><?php esc_html_e( 'Speed Spammer Detection', 'comment-link-remove'); ?></h3>
				</div>
				<div class="qc-clr-form-group-body">
					<p class="qc-clr-field-desc"><?php esc_html_e( 'Automated spambots post instantly upon loading the page. Set minimum seconds a commenter must spend on page before submitting.', 'comment-link-remove'); ?></p>
					<div class="qc-clr-speed-input-wrap">
						<input type='number' name='qcld_clr_speed' min="0" max="60" class="qc-clr-number-input" value='<?php echo esc_attr( (int) get_option( 'qcld_clr_speed', 4 ) ); ?>' />
						<span class="qc-clr-input-unit"><?php esc_html_e( 'Seconds', 'comment-link-remove'); ?></span>
						<span class="qc-clr-hint-chip"><?php esc_html_e('Recommended: 3 to 6 seconds', 'comment-link-remove'); ?></span>
					</div>
				</div>
			</div>

			<!-- 5. Rejection Message -->
			<div class="qc-clr-form-group-card">
				<div class="qc-clr-form-group-header">
					<span class="dashicons dashicons-editor-help"></span>
					<h3><?php esc_html_e( 'Custom Rejection Notice', 'comment-link-remove'); ?></h3>
				</div>
				<div class="qc-clr-form-group-body">
					<p class="qc-clr-field-desc"><?php esc_html_e( 'Message displayed if a user submission fails verification. The original comment text is retained below.', 'comment-link-remove'); ?></p>
					<textarea class="qc-clr-textarea" rows="4" name='qcld_clr_spam_message' placeholder="<?php esc_attr_e( 'Sorry, your comment submission failed verification. Please try again.', 'comment-link-remove'); ?>"><?php echo esc_textarea( get_option( 'qcld_clr_spam_message' ) ); ?></textarea>
				</div>
			</div>

			<!-- Submit Bar -->
			<div class="qc-clr-submit-bar">
				<input type='submit' name='submit' class="button button-primary qc-clr-save-btn" value='<?php esc_attr_e( 'Save Options', 'comment-link-remove' ); ?>' />
			</div>
		</form>

		<?php
		$qcld_clr_key = get_qcld_clr_key();
		if( $qcld_clr_key ) : ?>
			<!-- .htaccess Advanced Rules -->
			<div class="qc-clr-htaccess-card">
				<div class="qc-clr-htaccess-header">
					<span class="dashicons dashicons-media-code"></span>
					<h4><?php esc_html_e( 'Advanced Firewall Rule (.htaccess)', 'comment-link-remove'); ?></h4>
					<span class="qc-clr-optional-badge"><?php esc_html_e('Optional / Advanced', 'comment-link-remove'); ?></span>
				</div>
				<p class="qc-clr-htaccess-desc"><?php esc_html_e( 'To reject spambots before PHP or MySQL executes, add these rewrite rules before WordPress mod_rewrite in your .htaccess file:', 'comment-link-remove'); ?></p>
				<div class="qc-clr-code-block">
					<div class="qc-clr-code-bar">
						<span class="qc-clr-code-lang">Apache .htaccess</span>
					</div>
					<pre class="qc-clr-code">RewriteCond %{HTTP_COOKIE} !^.*<?php echo esc_html( $qcld_clr_key ); ?>.*$
RewriteRule ^wp-comments-post.php - [F,L]</pre>
				</div>
			</div>
		<?php endif; ?>

		<?php
		global $wpmu_version;
		if ( isset( $wpmu_version ) && $wpmu_version != '' && $qcld_clr_key ) : ?>
			<div class="qc-clr-htaccess-card">
				<div class="qc-clr-htaccess-header">
					<span class="dashicons dashicons-admin-multisite"></span>
					<h4><?php esc_html_e( 'WordPress Multisite (MU) Rules', 'comment-link-remove'); ?></h4>
				</div>
				<p class="qc-clr-htaccess-desc"><?php esc_html_e( 'For WordPress Multisite signups, add this rule to protect your signup form:', 'comment-link-remove'); ?></p>
				<div class="qc-clr-code-block">
					<pre class="qc-clr-code">RewriteCond %{HTTP_COOKIE} !^.*<?php echo esc_html( $qcld_clr_key ); ?>.*$
RewriteRule ^wp-signup.php - [F,L]</pre>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
</div>
<?php
}


function qcld_clr_add_referrer_to_notification( $text, $comment_id ) {
	$qcld_clr_key = get_qcld_clr_key();
	if( !$qcld_clr_key )
		return $text;
	if ( is_user_logged_in() )
		return $text;

	if ( isset( $_COOKIE[ $qcld_clr_key ] ) && is_numeric( $_COOKIE[ $qcld_clr_key ] ) && $_COOKIE[ $qcld_clr_key ] > 1 ) {
		$ttp = ( time() - (int) $_COOKIE[ $qcld_clr_key ] );

		$format = "seconds";
		if ( $ttp > 60 ) {
			$ttp = $ttp / 60;
			$format = "minutes";
		}
		if ( $ttp > 60 ) {
			$ttp = $ttp / 60;
			$format = "hours";
		}

		$text .= "\r\nTime to post comment: " . number_format( $ttp, 2 ) . " $format\r\n";
	}
	return $text;
}
add_filter( 'comment_notification_text', 'qcld_clr_add_referrer_to_notification', 10, 2 );
add_filter( 'comment_moderation_text', 'qcld_clr_add_referrer_to_notification', 10, 2 );
