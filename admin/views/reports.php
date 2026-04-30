<?php
if (!defined('ABSPATH')) exit;

$month = isset($_GET['month']) ? sanitize_text_field($_GET['month']) : date('Y-m');

$data = GST_Reports::get_summary($month);
?>

<div class="gst-wrap">

  <div class="gst-page-head">
    <div>
      <h1>GST Reports</h1>
      <p class="gst-page-subtitle">Monitor orders, sales, and collected GST with a cleaner analytics-style workspace.</p>
    </div>
  </div>

  <?php if (!gst_is_pro_active()) : ?>
    <div class="gst-inline-notice">
      <strong>Pro Feature</strong>
      <p>Upgrade to PRO to unlock full GST compliance tools, including GSTR-1 export and bulk invoice downloads.</p>
      <a href="<?php echo esc_url(gst_get_upgrade_url()); ?>" class="button button-primary">Upgrade Now</a>
    </div>
  <?php endif; ?>

  <div class="gst-report-actions">
    <form method="get" class="gst-action-card">
      <input type="hidden" name="page" value="gst-reports">
      <div class="gst-section-head gst-section-head-stack">
        <div>
          <h2>Filter Report</h2>
          <p class="gst-section-subtitle">Choose a month to refresh your GST summary.</p>
        </div>
      </div>
      <div class="gst-action-row">
        <input type="month" name="month" value="<?php echo esc_attr($month); ?>" class="gst-input gst-input-small">
        <button class="button button-primary gst-button-pro">Filter</button>
      </div>
    </form>

    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" class="gst-action-card">
      <input type="hidden" name="action" value="gst_bulk_download">
      <?php wp_nonce_field('gst_bulk_download'); ?>
      <div class="gst-section-head gst-section-head-stack">
        <div>
          <h2>Bulk Download</h2>
          <p class="gst-section-subtitle">Download all invoice PDFs for a selected month in one ZIP file.</p>
        </div>
      </div>
      <div class="gst-action-row">
        <input type="month" name="month" required class="gst-input gst-input-small">
        <button class="button button-primary gst-button-pro" <?php disabled(!gst_is_pro_active()); ?>>Download All Invoices (ZIP)</button>
      </div>
    </form>

    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" class="gst-action-card">
      <input type="hidden" name="action" value="gst_export_gstr1">
      <?php wp_nonce_field('gst_export_gstr1'); ?>
      <div class="gst-section-head gst-section-head-stack">
        <div>
          <h2>GSTR-1 Export</h2>
          <p class="gst-section-subtitle">Export monthly GST data for accountant-friendly CSV workflows.</p>
        </div>
      </div>
      <div class="gst-action-row">
        <input type="month" name="month" required class="gst-input gst-input-small">
        <button class="button gst-button-ghost" <?php disabled(!gst_is_pro_active()); ?>>Export GSTR-1 CSV</button>
      </div>
    </form>
  </div>

  <div class="gst-cards gst-report-kpis">
    <div class="gst-card gst-kpi-card gst-kpi-card-invoices">
      <span>Total Orders</span>
      <h2 class="gst-kpi-value"><?php echo esc_html($data['orders']); ?></h2>
    </div>

    <div class="gst-card gst-kpi-card gst-kpi-card-orders">
      <span>Total Sales</span>
      <h2 class="gst-kpi-value"><?php echo wc_price($data['sales']); ?></h2>
    </div>

    <div class="gst-card gst-kpi-card gst-kpi-card-tax">
      <span>Total GST Collected</span>
      <h2 class="gst-kpi-value"><?php echo wc_price($data['tax']); ?></h2>
    </div>
  </div>

</div>
