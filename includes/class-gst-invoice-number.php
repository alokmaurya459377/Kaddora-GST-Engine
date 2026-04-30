<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Invoice_Number')) {

  class GST_Invoice_Number
  {
    /**
     * generate
     */
    public static function generate()
    {

      $prefix = get_option('gst_invoice_prefix', 'GST');
      $year   = date('Y');

      $last = get_option('gst_last_invoice_number', 0);
      $next = intval($last) + 1;

      update_option('gst_last_invoice_number', $next);

      $number = sprintf('%s-%s-%04d', $prefix, $year, $next);

      return apply_filters('gst_invoice_number', $number, $next);
    }
  }
}
