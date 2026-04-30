<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Product_Fields')) {

  class GST_Product_Fields
  {
    public function __construct()
    {

      add_action('woocommerce_product_options_general_product_data', [$this, 'add_fields']);
      add_action('woocommerce_process_product_meta', [$this, 'save_fields']);
    }

    /**
     * add_fields
     */
    public function add_fields()
    {

      echo '<div class="options_group">';

      woocommerce_wp_text_input([
        'id' => '_gst_hsn',
        'label' => 'HSN Code',
        'desc_tip' => true,
        'description' => 'Enter HSN/SAC code',
      ]);

      woocommerce_wp_text_input([
        'id' => '_gst_rate',
        'label' => 'GST Rate (%)',
        'type' => 'number',
        'custom_attributes' => [
          'step' => '0.01',
          'min'  => '0'
        ],
      ]);

      echo '</div>';
    }

    /**
     * save_fields
     */
    public function save_fields($post_id)
    {

      if (isset($_POST['_gst_hsn'])) {
        update_post_meta($post_id, '_gst_hsn', sanitize_text_field($_POST['_gst_hsn']));
      }

      if (isset($_POST['_gst_rate'])) {
        update_post_meta($post_id, '_gst_rate', floatval($_POST['_gst_rate']));
      }
    }
  }
}
