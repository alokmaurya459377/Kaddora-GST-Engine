<?php
if (!defined('ABSPATH')) exit;

$summary = class_exists('GST_Reports') ? GST_Reports::get_summary() : [
  'orders' => 0,
  'sales' => 0,
  'tax' => 0,
];

$compliance_ready = !empty(get_option('gst_gstin')) && !empty(get_option('gst_store_state'));
$status_text = $compliance_ready ? 'Compliant' : 'Needs Setup';
?>

<div class="gst-container">
  <div class="gst-header">
    <h1>GST Engine</h1>
    <p>Automate invoices, avoid GST compliance mistakes, and remove manual invoice work.</p>
  </div>

  <div class="gst-grid">
    <div class="gst-card gst-kpi-card gst-kpi-card-invoices">
      <span>Total Invoices</span>
      <h2 class="gst-kpi-value"><?php echo esc_html(get_option('gst_last_invoice_number', 0)); ?></h2>
    </div>

    <div class="gst-card gst-kpi-card gst-kpi-card-tax">
      <span>Total GST Collected</span>
      <h2 class="gst-kpi-value"><?php echo function_exists('wc_price') ? wc_price($summary['tax']) : 'Rs ' . esc_html(number_format((float) $summary['tax'], 2)); ?></h2>
    </div>

    <div class="gst-card gst-kpi-card gst-kpi-card-orders">
      <span>Orders Processed</span>
      <h2 class="gst-kpi-value"><?php echo esc_html($summary['orders']); ?></h2>
    </div>

    <div class="gst-card highlight gst-status-card">
      <span>Status</span>
      <?php if ($compliance_ready) : ?>
        <div class="gst-status-chip gst-status-chip-large">Compliant Ok</div>
      <?php else : ?>
        <h2 class="gst-status-title">Setup Required</h2>
      <?php endif; ?>
    </div>
  </div>

  <div class="gst-panel-grid">
    <div class="gst-panel">
      <h3>Business Snapshot</h3>
      <div class="gst-meta-list">
        <div class="gst-meta-row">
          <span class="gst-meta-label">GSTIN</span>
          <span class="gst-meta-value"><?php echo esc_html(get_option('gst_gstin', 'Not set')); ?></span>
        </div>
        <div class="gst-meta-row">
          <span class="gst-meta-label">Store State</span>
          <span class="gst-meta-value"><?php echo esc_html(get_option('gst_store_state', 'Not set')); ?></span>
        </div>
        <div class="gst-meta-row">
          <span class="gst-meta-label">Invoice Prefix</span>
          <span class="gst-meta-value"><?php echo esc_html(get_option('gst_invoice_prefix', 'GST')); ?></span>
        </div>
        <div class="gst-meta-row">
          <span class="gst-meta-label">Auto Invoice</span>
          <span class="gst-meta-value"><?php echo get_option('gst_enable_auto_invoice', 1) ? 'Enabled' : 'Disabled'; ?></span>
        </div>
      </div>
    </div>

    <div class="gst-panel gst-panel-soft">
      <h3>Why Merchants Buy</h3>
      <ul class="gst-list">
        <li>Generate GST invoices in seconds</li>
        <li>Avoid GST compliance mistakes</li>
        <li>No manual invoice creation required</li>
      </ul>
    </div>
  </div>

  <div class="gst-upgrade">
    <h3>Upgrade to PRO</h3>
    <p>Unlock GSTR reports, bulk downloads, credit notes and advanced compliance workflows.</p>
    <a href="<?php echo esc_url(gst_get_upgrade_url()); ?>" class="button button-primary">Upgrade Now</a>
  </div>
</div>
