<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_GSTR1')) {

  class GST_GSTR1
  {
    public function __construct()
    {
      add_action('admin_post_gst_export_gstr1', [$this, 'export']);
    }

    /**
     * export
     */
    public function export()
    {
      if (!gst_is_pro_active()) {
        wp_die(esc_html(gst_get_upgrade_message()));
      }

      if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
      }

      if (
        !isset($_POST['_wpnonce']) ||
        !wp_verify_nonce($_POST['_wpnonce'], 'gst_export_gstr1')
      ) {
        wp_die('Invalid request');
      }

      $month = sanitize_text_field($_POST['month']);

      $orders = wc_get_orders([
        'limit' => -1,
        'status' => ['completed', 'processing'],
        'date_created' => $month . '-01...' . date('Y-m-t', strtotime($month))
      ]);

      header('Content-Type: text/csv');
      header('Content-Disposition: attachment; filename="gstr1-' . $month . '.csv"');

      $output = fopen('php://output', 'w');

      // Header row
      fputcsv($output, [
        'Invoice No',
        'Date',
        'Customer',
        'GSTIN',
        'Total',
        'CGST',
        'SGST',
        'IGST'
      ]);

      foreach ($orders as $order) {

        $order_id = $order->get_id();

        $invoice_no = get_post_meta($order_id, '_gst_invoice_number', true);
        $gstin = get_option('gst_gstin');
        $date = $order->get_date_created()->date('Y-m-d');

        $items = get_post_meta($order_id, '_gst_invoice_data', true);

        $cgst = $sgst = $igst = 0;

        if ($items) {
          foreach ($items as $item) {
            $cgst += $item['tax']['cgst'] ?? 0;
            $sgst += $item['tax']['sgst'] ?? 0;
            $igst += $item['tax']['igst'] ?? 0;
          }
        }

        fputcsv($output, [
          $invoice_no,
          $date,
          $order->get_billing_first_name(),
          $gstin,
          $order->get_total(),
          $cgst,
          $sgst,
          $igst
        ]);
      }

      fclose($output);
      exit;
    }
  }
}
