<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Invoice_Preview')) {

  class GST_Invoice_Preview
  {

    public function __construct()
    {
      add_action('add_meta_boxes', [$this, 'add_box']);
    }

    /**
     * add_box
     */
    public function add_box()
    {
      add_meta_box(
        'gst_invoice_preview',
        'GST Invoice',
        [$this, 'render'],
        'shop_order',
        'side',
        'high'
      );
    }

    /**
     * render
     */
    public function render($post)
    {

      $order_id = $post->ID;

      $file = get_post_meta($order_id, '_gst_invoice_file', true);

      if ($file && file_exists($file)) {

        $url = str_replace(wp_upload_dir()['basedir'], wp_upload_dir()['baseurl'], $file);

        echo '<a href="' . esc_url($url) . '" target="_blank" class="button button-primary">View Invoice</a>';

        echo '<p style="margin-top:10px;">';
        echo '<a href="' . esc_url($url) . '" download class="button">Download</a>';
        echo '</p>';
      } else {
        echo '<p>No invoice generated yet.</p>';
      }
    }
  }
}
