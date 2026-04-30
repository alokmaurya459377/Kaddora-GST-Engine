<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_MyAccount')) {

  class GST_MyAccount
  {

    public function __construct()
    {

      add_filter('woocommerce_my_account_my_orders_actions', [$this, 'add_download_button'], 10, 2);

      add_action('init', [$this, 'handle_download']);
    }

    /**
     * add_download_button
     */
    public function add_download_button($actions, $order)
    {

      $order_id = $order->get_id();
      $file = get_post_meta($order_id, '_gst_invoice_file', true);

      if ($file && file_exists($file)) {

        $url = add_query_arg([
          'gst_download_invoice' => $order_id,
          '_wpnonce' => wp_create_nonce('gst_download_' . $order_id)
        ], home_url('/'));

        $actions['gst_invoice'] = [
          'url'  => esc_url($url),
          'name' => 'Invoice',
        ];
      }

      return $actions;
    }

    /**
     * handle_download
     */
    public function handle_download()
    {

      if (!isset($_GET['gst_download_invoice'])) return;

      $order_id = intval($_GET['gst_download_invoice']);

      if (
        !isset($_GET['_wpnonce']) ||
        !wp_verify_nonce($_GET['_wpnonce'], 'gst_download_' . $order_id)
      ) {
        return;
      }

      $order = wc_get_order($order_id);
      if (!$order) return;

      $current_user_id = get_current_user_id();
      $can_access = current_user_can('manage_woocommerce') || intval($order->get_user_id()) === $current_user_id;

      if (!$can_access) {
        return;
      }

      $file = get_post_meta($order_id, '_gst_invoice_file', true);

      if ($file && file_exists($file)) {

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="invoice-' . $order_id . '.pdf"');
        readfile($file);
        exit;
      }
    }
  }
}
