<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Settings')) {

  class GST_Settings
  {
    public function __construct()
    {
      add_action('admin_init', [$this, 'register']);
    }

    /**
     * register
     */
    public function register()
    {

      register_setting('gst_settings_group', 'gst_store_state');
      register_setting('gst_settings_group', 'gst_gstin');
      register_setting('gst_settings_group', 'gst_invoice_prefix');
      register_setting('gst_settings_group', 'gst_enable_auto_invoice');
      register_setting('gst_settings_group', 'gst_pro_active');
    }
  }
}
