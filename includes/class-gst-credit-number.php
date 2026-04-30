<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Credit_Number')) {

  class GST_Credit_Number
  {

    /**
     * generate
     */
    public static function generate()
    {

      $prefix = 'CN';
      $year   = date('Y');

      $last = get_option('gst_last_credit_number', 0);
      $next = $last + 1;

      update_option('gst_last_credit_number', $next);

      return sprintf('%s-%s-%04d', $prefix, $year, $next);
    }
  }
}
