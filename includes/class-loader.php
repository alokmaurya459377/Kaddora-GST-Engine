<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Loader')) {

  class GST_Loader
  {

    private static $instance = null;

    /**
     * instance
     */
    public static function instance()
    {
      if (self::$instance === null) {
        self::$instance = new self();
      }
      return self::$instance;
    }

    /**
     * run
     */
    public function run()
    {
      if (!$this->is_woocommerce_active()) {
        add_action('admin_notices', [$this, 'wc_notice']);
        return;
      }

      if (is_admin() && !class_exists('\Dompdf\Dompdf')) {
        add_action('admin_notices', [$this, 'dompdf_notice']);
      }

      $this->load_files();
      $this->init_hooks();
    }

    /**
     * is_woocommerce_active
     */
    private function is_woocommerce_active()
    {
      return class_exists('WooCommerce');
    }

    /**
     * wc_notice
     */
    public function wc_notice()
    {
      echo '<div class="notice notice-error"><p>';
      echo 'GST Engine requires WooCommerce.';
      echo '</p></div>';
    }

    /**
     * load_files
     */
    private function load_files()
    {

      $files = [
        'class-gst-core.php',
        'class-gst-calculator.php',
        'class-invoice-generator.php',
        'class-pdf-generator.php',
        'class-gst-reports.php',
        'class-gst-invoice-number.php',
        'class-gst-credit-number.php',
        'class-gst-credit-note.php',
        'class-gst-product-fields.php',
        'class-gst-email.php',
        'class-gst-myaccount.php',
        'class-gst-bulk-download.php',
        'class-gst-invoice-preview.php',
        'class-gst-gstr1.php',
      ];

      foreach ($files as $file) {

        $path = KADDORA_GST_PATH . 'includes/' . $file;

        if (file_exists($path)) {
          require_once $path;
        }
      }

      // Admin
      if (is_admin()) {

        $admin = KADDORA_GST_PATH . 'admin/class-admin-menu.php';

        if (file_exists($admin)) {
          require_once $admin;

          if (class_exists('GST_Admin_Menu')) {
            new GST_Admin_Menu();
          }
        }

        $settings = KADDORA_GST_PATH . 'admin/class-settings.php';

        if (file_exists($settings)) {
          require_once $settings;

          if (class_exists('GST_Settings')) {
            new GST_Settings();
          }
        }
      }

      if (class_exists('GST_Product_Fields')) {
        new GST_Product_Fields();
      }

      if (class_exists('GST_Email')) {
        new GST_Email();
      }

      if (class_exists('GST_MyAccount')) {
        new GST_MyAccount();
      }

      if (class_exists('GST_Bulk_Download')) {
        new GST_Bulk_Download();
      }

      if (class_exists('GST_Invoice_Preview')) {
        new GST_Invoice_Preview();
      }

      if (class_exists('GST_GSTR1')) {
        new GST_GSTR1();
      }

      if (class_exists('GST_Credit_Note')) {
        new GST_Credit_Note();
      }
    }

    /**
     * init_hooks
     */
    private function init_hooks()
    {
      add_action('woocommerce_order_status_processing', [$this, 'generate_invoice']);
      add_action('woocommerce_order_status_completed', [$this, 'generate_invoice']);
    }

    /**
     * generate_invoice
     */
    public function generate_invoice($order_id)
    {
      if (!get_option('gst_enable_auto_invoice', 1)) return;

      if (!class_exists('GST_Invoice_Generator')) return;

      $invoice = new GST_Invoice_Generator();
      $invoice->create_invoice($order_id);
    }

    /**
     * dompdf_notice
     */
    public function dompdf_notice()
    {
      if (class_exists('\Dompdf\Dompdf')) return;

      echo '<div class="notice notice-warning"><p>';
      echo 'GST Engine could not find Dompdf. Invoice PDF generation is currently disabled.';
      echo '</p></div>';
    }
  }
}
