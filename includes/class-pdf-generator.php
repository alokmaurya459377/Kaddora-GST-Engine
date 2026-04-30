<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_PDF_Generator')) {

  class GST_PDF_Generator
  {
    /**
     * generate
     */
    public static function generate($order_id, $items)
    {
      if (!class_exists('\Dompdf\Dompdf')) {
        return;
      }

      $order = wc_get_order($order_id);
      if (!$order) return;

      // Load template
      ob_start();

      $template = KADDORA_GST_PATH . 'templates/invoice-template.php';

      if (file_exists($template)) {
        include $template;
      } else {
        echo '<h2>Invoice template missing</h2>';
      }

      $html = ob_get_clean();

      // Init DOMPDF
      $dompdf = new \Dompdf\Dompdf([
        'isRemoteEnabled' => true
      ]);

      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      // Save file
      $upload = wp_upload_dir();
      $dir = $upload['basedir'] . '/gst-invoices/';

      if (!file_exists($dir)) {
        wp_mkdir_p($dir);
      }

      $file = $dir . 'invoice-' . $order_id . '.pdf';

      file_put_contents($file, $dompdf->output());

      update_post_meta($order_id, '_gst_invoice_file', $file);

      return $file;
    }
  }
}
