<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Reports')) {

  class GST_Reports
  {
    /**
     * get_summary
     */
    public static function get_summary($month = null)
    {

      global $wpdb;

      $month = $month ?: date('Y-m');

      $orders = wc_get_orders([
        'limit' => -1,
        'status' => ['completed', 'processing'],
        'date_created' => $month . '-01...' . date('Y-m-t', strtotime($month))
      ]);

      $total_sales = 0;
      $total_tax   = 0;

      foreach ($orders as $order) {

        $total_sales += $order->get_total();

        $items = get_post_meta($order->get_id(), '_gst_invoice_data', true);

        if (!$items) continue;

        foreach ($items as $item) {

          $total_tax += $item['tax']['cgst'] ?? 0;
          $total_tax += $item['tax']['sgst'] ?? 0;
          $total_tax += $item['tax']['igst'] ?? 0;
        }
      }

      return [
        'sales' => $total_sales,
        'tax'   => $total_tax,
        'orders' => count($orders)
      ];
    }
  }
}
