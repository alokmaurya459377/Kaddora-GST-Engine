<?php
if (!defined('ABSPATH')) exit;
?>

<div class="gst-wrap">
  <h1>Upgrade to Pro</h1>

  <div class="gst-card">
    <h2>Kaddora GST Engine Pro</h2>
    <p>Built for Indian WooCommerce businesses that need faster invoicing, stronger compliance, and accountant-friendly workflows.</p>
    <p>Generate GST invoices in seconds, avoid GST compliance mistakes, and remove manual invoice creation from your daily workflow.</p>

    <div class="gst-feature-grid">
      <div class="gst-feature-box">
        <h3>Free</h3>
        <ul class="gst-list">
          <li>Basic GST invoice generation</li>
          <li>GST calculation</li>
          <li>Single GSTIN setup</li>
          <li>Simple reports</li>
        </ul>
      </div>

      <div class="gst-feature-box gst-feature-box-pro">
        <h3>Pro</h3>
        <ul class="gst-list">
          <li>Bulk invoice download</li>
          <li>GSTR export</li>
          <li>Credit notes for refunds</li>
          <li>Advanced compliance tools</li>
          <li>Priority support</li>
        </ul>
      </div>
    </div>

    <div class="gst-upsell">
      <strong>Upgrade to Pro</strong>
      <p><?php echo esc_html(gst_get_upgrade_message()); ?></p>
      <a href="https://kaddora.com/" target="_blank" rel="noopener noreferrer" class="button button-primary">Upgrade Now</a>
    </div>
  </div>
</div>
