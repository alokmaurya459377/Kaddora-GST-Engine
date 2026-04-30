<?php
if (!defined('ABSPATH')) exit;

$orders = wc_get_orders([
  'limit' => 20,
  'status' => ['completed', 'processing'],
]);
?>

<div class="gst-wrap">
  <h1>GST Invoices</h1>

  <div class="gst-card gst-invoice-card">
    <div class="gst-section-head">
      <div>
        <h2>Recent Invoices</h2>
        <p class="gst-section-subtitle">Track generated invoices, pending orders, and customer billing status in one place.</p>
      </div>
    </div>

    <table class="widefat striped gst-table">
      <thead>
        <tr>
          <th>Order</th>
          <th>Invoice No</th>
          <th>Customer</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($orders)) : ?>
          <?php foreach ($orders as $order) : ?>
            <?php
            $order_id = $order->get_id();
            $invoice_number = get_post_meta($order_id, '_gst_invoice_number', true);
            $invoice_file = get_post_meta($order_id, '_gst_invoice_file', true);
            ?>
            <tr class="gst-table-row">
              <td>#<?php echo esc_html($order_id); ?></td>
              <td><?php echo esc_html($invoice_number ? $invoice_number : 'Not generated'); ?></td>
              <td><?php echo esc_html(trim($order->get_formatted_billing_full_name())); ?></td>
              <td><?php echo wc_price($order->get_total()); ?></td>
              <td>
                <span class="gst-badge <?php echo $invoice_file ? 'gst-badge-success' : 'gst-badge-warn'; ?>">
                  <?php echo esc_html($invoice_file ? 'Ready' : 'Pending'); ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="5">No orders found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="gst-upsell">
    <strong>Upgrade to Pro</strong>
    <p>Unlock invoice automation extras, bulk download, GSTR export and advanced compliance tools.</p>
    <a href="<?php echo esc_url(admin_url('admin.php?page=gst-upgrade')); ?>" class="button button-primary">Upgrade Now</a>
  </div>
</div>
