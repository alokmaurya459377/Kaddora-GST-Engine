<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Credit_Note')) {

  class GST_Credit_Note
  {
    public function __construct()
    {

      add_action('woocommerce_order_refunded', [$this, 'create_credit_note'], 10, 2);
    }

    /**
     * create_credit_note
     */
    public function create_credit_note($order_id, $refund_id)
    {
      if (!gst_is_pro_active()) return;

      $order  = wc_get_order($order_id);
      $refund = wc_get_order($refund_id);

      if (!$order || !$refund) return;

      $items = get_post_meta($order_id, '_gst_invoice_data', true);

      if (!$items) return;

      $credit_data = [];

      foreach ($items as $item) {

        $credit_data[] = [
          'name' => $item['name'],
          'price' => -abs($item['price']),
          'tax' => [
            'cgst' => -abs($item['tax']['cgst']),
            'sgst' => -abs($item['tax']['sgst']),
            'igst' => -abs($item['tax']['igst']),
          ]
        ];
      }

      // Save credit note
      update_post_meta($order_id, '_gst_credit_note', $credit_data);

      // Optional: generate PDF
      do_action('gst_generate_credit_note_pdf', $order_id, $credit_data);

      $credit_number = GST_Credit_Number::generate();
      update_post_meta($order_id, '_gst_credit_number', $credit_number);
    }
  }
}
