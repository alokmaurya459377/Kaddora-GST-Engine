<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Invoice_Generator')) {

  class GST_Invoice_Generator
  {
    /**
     * create_invoice
     */
    public function create_invoice($order_id)
    {

      $order = wc_get_order($order_id);
      if (!$order) return;

      if (get_post_meta($order_id, '_gst_invoice_done', true)) return;

      $store_state    = get_option('gst_store_state');
      $customer_state = $order->get_shipping_state();

      $type = ($store_state === $customer_state) ? 'intra' : 'inter';

      $items = [];

      foreach ($order->get_items() as $item) {

        $product = $item->get_product();
        if (!$product) continue;

        $price = $item->get_total();
        $rate  = get_post_meta($product->get_id(), '_gst_rate', true) ?: 18;

        $tax = GST_Calculator::calculate($price, $rate, $type);

        $items[] = [
          'name'  => $item->get_name(),
          'price' => $price,
          'rate'  => $rate,
          'hsn'   => get_post_meta($product->get_id(), '_gst_hsn', true),
          'tax'   => $tax
        ];
      }

      update_post_meta($order_id, '_gst_invoice_data', $items);

      if (!get_post_meta($order_id, '_gst_invoice_number', true) && class_exists('GST_Invoice_Number')) {
        $invoice_number = GST_Invoice_Number::generate();
        update_post_meta($order_id, '_gst_invoice_number', $invoice_number);
      }

      if (class_exists('GST_PDF_Generator')) {
        GST_PDF_Generator::generate($order_id, $items);
      }

      update_post_meta($order_id, '_gst_invoice_done', 1);
    }
  }
}
