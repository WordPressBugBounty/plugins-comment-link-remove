<?php
defined('ABSPATH') or die("No direct script access!");


wp_register_style( 'qc-clr-admin-style-email', QCCLR_ASSETS_URL . '/css/qc-clr-email_subscription.css', array(), QCCLR_VERSION );
wp_enqueue_style( 'qc-clr-admin-style-email' );
wp_register_style( 'qc-clr-admin-font-awesome', QCCLR_ASSETS_URL . '/css/font-awesome.min.css', array(), '4.7.0' );
wp_enqueue_style( 'qc-clr-admin-font-awesome' );

wp_register_script( 'qc-clr-email-subscription-js', QCCLR_ASSETS_URL . '/js/qc-clr-email_subscription.js', array( 'jquery' ), QCCLR_VERSION, true );
wp_enqueue_script( 'qc-clr-email-subscription-js' );

global $wpdb;
if(!function_exists('wp_get_current_user')) {
	include(ABSPATH . "wp-includes/pluggable.php"); 
}

$table        = $wpdb->prefix.'qc_clr_subscription';
$current_user = wp_get_current_user();
$url          = admin_url('admin.php?page=email-subscriptions');
$customPagHTML = '';

$items_per_page = 50;

// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$page   = isset( $_GET['cpage'] ) ? absint( wp_unslash( $_GET['cpage'] ) ) : 1;
$offset = ( $page * $items_per_page ) - $items_per_page;

$total = (int) $wpdb->get_var(
	$wpdb->prepare(
		"SELECT count(*) FROM `{$wpdb->prefix}qc_clr_subscription` WHERE %d = %d",
		1,
		1
	)
);

$rows = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM `{$wpdb->prefix}qc_clr_subscription` WHERE 1 ORDER BY id DESC LIMIT %d, %d",
		$offset,
		$items_per_page
	)
);
$totalPage = ceil( $total / $items_per_page );

if($totalPage > 1){
	$customPagHTML = '<div class="qc-clr-pagination"><span class="qc-clr-page-info">Page ' . esc_html($page) . ' of ' . esc_html($totalPage) . '</span>' . paginate_links( array(
		'base'      => add_query_arg( 'cpage', '%#%' ),
		'format'    => '',
		'prev_text' => esc_html__('&laquo; Prev', 'comment-link-remove'),
		'next_text' => esc_html__('Next &raquo;', 'comment-link-remove'),
		'total'     => esc_html($totalPage),
		'current'   => esc_html($page)
	)) . '</div>';
}
$mainurl = admin_url( 'admin.php?page=email-subscriptions');

?>	
<div class="wrap">
	<h1><?php echo esc_html__('Email Subscription List', 'comment-link-remove'); ?></h1>
<div class="qc-clr-email-sub-page-wrap">
	<div class="qc-clr-email-sub-card">
		<!-- Page Header -->
		<div class="qc-clr-email-sub-header">
			<div class="qc-clr-email-sub-title-area">
				<h2><?php echo esc_html__('Email Subscription List', 'comment-link-remove'); ?></h2>
				<span class="qc-clr-pro-badge"><?php esc_html_e( 'Pro Feature', 'comment-link-remove'); ?></span>
			</div>

			<!-- Pro Notice Banner -->
			<div class="qc-clr-pro-banner">
				<div class="qc-clr-pro-banner-content">
					<span class="dashicons dashicons-lock qc-clr-lock-icon"></span>
					<div class="qc-clr-pro-banner-text">
						<strong><?php esc_html_e( 'Email Subscription List & Auto-Notifications', 'comment-link-remove'); ?></strong>
						<p><?php esc_html_e( 'Email Subscription List is a Pro Version Feature. Collect subscribers directly from comments, send automatic notifications on new comments, and export subscriber lists seamlessly.', 'comment-link-remove'); ?></p>
					</div>
				</div>
				<a class="qc-clr-pro-upgrade-btn" href="<?php echo esc_url( 'https://www.quantumcloud.net/products/comment-tools/'); ?>" target="_blank">
					<?php esc_html_e( 'Upgrade to Pro', 'comment-link-remove'); ?> &rarr;
				</a>
			</div>
		</div>
		
		<?php 
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['msg'] ) && 'success' === sanitize_text_field( wp_unslash( $_GET['msg'] ) ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Record has been Deleted Successfully!', 'comment-link-remove' ) . '</p></div>';
		}
		?>
		
		<!-- Toolbar / Action Bar -->
		<div class="qc-clr-sub-toolbar">
			<div class="qc-clr-toolbar-left">
				<?php if ( ! empty( $customPagHTML ) ) : ?>
					<?php echo wp_kses_post( $customPagHTML ); ?>
				<?php endif; ?>
				<div class="qc-clr-total-chip">
					<span class="dashicons dashicons-groups"></span>
					<span><?php esc_html_e( 'Total Subscribers:', 'comment-link-remove' ); ?> <strong><?php echo esc_html($total); ?></strong></span>
				</div>
			</div>
			<div class="qc-clr-toolbar-right">
				<a class="button button-primary qc-clr-export-btn" href="#">
					<span class="dashicons dashicons-download"></span>
					<?php esc_html_e( 'Export All Contacts', 'comment-link-remove' ); ?>
				</a>
			</div>
		</div>
		
		<form id="qc_clr_form_sessions" action="<?php echo esc_url( $mainurl ); ?>" method="POST">
			<input type="hidden" name="qc_clr_email_subscription_remove" />
			
			<div class="qc-clr-table-responsive">
				<table class="qc-clr-sub-table">
					<thead>
						<tr>
							<th class="qc-clr-col-check">
								<input type="checkbox" id="qc_clr_checked_all" title="<?php esc_attr_e('Select All', 'comment-link-remove'); ?>" />
							</th>
							<th class="qc-clr-col-date"><?php echo esc_html__( 'Date', 'comment-link-remove'); ?></th>
							<th class="qc-clr-col-name"><?php echo esc_html__( 'Name', 'comment-link-remove'); ?></th>
							<th class="qc-clr-col-email"><?php echo esc_html__( 'Email', 'comment-link-remove'); ?></th>
							<th class="qc-clr-col-action"><?php echo esc_html__( 'Action', 'comment-link-remove'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ( ! empty( $rows ) ) : ?>
							<?php foreach($rows as $row) : ?>
								<tr>
									<td class="qc-clr-col-check">
										<input type="checkbox" name="emails[]" class="qc_clr_email_checkbox" value="<?php echo esc_attr( $row->id ); ?>" />
									</td>
									<td data-label="<?php esc_attr_e('Date', 'comment-link-remove'); ?>">
										<span class="qc-clr-date-badge"><?php echo esc_html( gmdate( 'M d, Y', strtotime( $row->date ) ) ); ?></span>
									</td>
									<td data-label="<?php esc_attr_e('Name', 'comment-link-remove'); ?>">
										<span class="qc-clr-sub-name"><?php echo esc_html($row->name ? $row->name : __('Anonymous', 'comment-link-remove')); ?></span>
									</td>
									<td data-label="<?php esc_attr_e('Email', 'comment-link-remove'); ?>">
										<span class="qc-clr-sub-email"><?php echo esc_html($row->email); ?></span>
									</td>
									<td data-label="<?php esc_attr_e('Action', 'comment-link-remove'); ?>" class="qc-clr-col-action">
										<a href="#" class="qc-clr-email-del" data-id="<?php echo esc_attr($row->id); ?>" title="<?php esc_attr_e('Delete Subscription', 'comment-link-remove'); ?>">
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<!-- Sample Preview Rows -->
							<tr>
								<td class="qc-clr-col-check">
									<input type="checkbox" name="emails[]" class="qc_clr_email_checkbox" value="1" />
								</td>
								<td data-label="<?php esc_attr_e('Date', 'comment-link-remove'); ?>">
									<span class="qc-clr-date-badge"><?php echo esc_html( gmdate('M d, Y') ); ?></span>
								</td>
								<td data-label="<?php esc_attr_e('Name', 'comment-link-remove'); ?>">
									<span class="qc-clr-sub-name">Sarah Jenkins</span>
								</td>
								<td data-label="<?php esc_attr_e('Email', 'comment-link-remove'); ?>">
									<span class="qc-clr-sub-email">sarah.jenkins@example.com</span>
								</td>
								<td data-label="<?php esc_attr_e('Action', 'comment-link-remove'); ?>" class="qc-clr-col-action">
									<a href="#" class="qc-clr-email-del" data-id="1" title="<?php esc_attr_e('Delete Subscription', 'comment-link-remove'); ?>">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
							<tr>
								<td class="qc-clr-col-check">
									<input type="checkbox" name="emails[]" class="qc_clr_email_checkbox" value="2" />
								</td>
								<td data-label="<?php esc_attr_e('Date', 'comment-link-remove'); ?>">
									<span class="qc-clr-date-badge"><?php echo esc_html( gmdate('M d, Y', strtotime('-2 days')) ); ?></span>
								</td>
								<td data-label="<?php esc_attr_e('Name', 'comment-link-remove'); ?>">
									<span class="qc-clr-sub-name">Robert Chang</span>
								</td>
								<td data-label="<?php esc_attr_e('Email', 'comment-link-remove'); ?>">
									<span class="qc-clr-sub-email">robert.chang@example.com</span>
								</td>
								<td data-label="<?php esc_attr_e('Action', 'comment-link-remove'); ?>" class="qc-clr-col-action">
									<a href="#" class="qc-clr-email-del" data-id="2" title="<?php esc_attr_e('Delete Subscription', 'comment-link-remove'); ?>">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
							<tr>
								<td class="qc-clr-col-check">
									<input type="checkbox" name="emails[]" class="qc_clr_email_checkbox" value="3" />
								</td>
								<td data-label="<?php esc_attr_e('Date', 'comment-link-remove'); ?>">
									<span class="qc-clr-date-badge"><?php echo esc_html( gmdate('M d, Y', strtotime('-5 days')) ); ?></span>
								</td>
								<td data-label="<?php esc_attr_e('Name', 'comment-link-remove'); ?>">
									<span class="qc-clr-sub-name">Elena Rostova</span>
								</td>
								<td data-label="<?php esc_attr_e('Email', 'comment-link-remove'); ?>">
									<span class="qc-clr-sub-email">elena.rostova@example.com</span>
								</td>
								<td data-label="<?php esc_attr_e('Action', 'comment-link-remove'); ?>" class="qc-clr-col-action">
									<a href="#" class="qc-clr-email-del" data-id="3" title="<?php esc_attr_e('Delete Subscription', 'comment-link-remove'); ?>">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

			<!-- Table Bottom Actions -->
			<div class="qc-clr-table-bottom-bar">
				<button class="button button-secondary qc-clr-delete-btn" id="qc_clr_submit_email_form">
					<i class="fa fa-trash-o"></i>
					<?php esc_html_e( 'Delete Selected', 'comment-link-remove' ); ?>
				</button>
				<div class="qc-clr-sample-note">
					<span><?php esc_html_e( 'Previewing subscriber records. Full management active in Pro.', 'comment-link-remove' ); ?></span>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
