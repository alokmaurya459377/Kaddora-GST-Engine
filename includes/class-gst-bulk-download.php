<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Bulk_Download')) {

  class GST_Bulk_Download
  {
    public function __construct()
    {
      add_action('admin_post_gst_bulk_download', [$this, 'handle_download']);
    }

    /**
     * handle_download
     */
    public function handle_download()
    {
      if (!gst_is_pro_active()) {
        wp_die(esc_html(gst_get_upgrade_message()));
      }

      if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
      }

      if (
        !isset($_POST['_wpnonce']) ||
        !wp_verify_nonce($_POST['_wpnonce'], 'gst_bulk_download')
      ) {
        wp_die('Invalid request');
      }

      $month = sanitize_text_field($_POST['month']);

      $orders = wc_get_orders([
        'limit' => -1,
        'status' => ['completed', 'processing'],
        'date_created' => $month . '-01...' . date('Y-m-t', strtotime($month))
      ]);

      if (empty($orders)) {
        wp_die('No invoices found');
      }

      $upload = wp_upload_dir();
      $zip_path = $upload['basedir'] . '/gst-invoices-' . $month . '.zip';

      $zip = new ZipArchive();

      if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        wp_die('Cannot create ZIP');
      }

      foreach ($orders as $order) {

        $file = get_post_meta($order->get_id(), '_gst_invoice_file', true);

        if ($file && file_exists($file)) {
          $zip->addFile($file, basename($file));
        }
      }

      $zip->close();

      header('Content-Type: application/zip');
      header('Content-Disposition: attachment; filename="gst-invoices-' . $month . '.zip"');
      readfile($zip_path);
      exit;
    }
  }
}
