<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Email')) {

  class GST_Email
  {

    public function __construct()
    {
      add_filter('woocommerce_email_attachments', [$this, 'attach_invoice'], 10, 3);
    }

    /**
     * attach_invoice
     */
    public function attach_invoice($attachments, $email_id, $order)
    {

      if (!$order) return $attachments;

      $file = get_post_meta($order->get_id(), '_gst_invoice_file', true);

      if ($file && file_exists($file)) {
        $attachments[] = $file;
      }

      return $attachments;
    }
  }
}
