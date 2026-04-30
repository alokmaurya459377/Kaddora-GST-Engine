<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Activator')) {

  class GST_Activator
  {
    public static function activate()
    {
      add_option('gst_invoice_prefix', 'GST');
      add_option('gst_enable_auto_invoice', 1);
      add_option('gst_pro_active', 0);

      $upload = wp_upload_dir();
      $dir = trailingslashit($upload['basedir']) . 'gst-invoices';

      if (!file_exists($dir)) {
        wp_mkdir_p($dir);
      }
    }
  }
}
