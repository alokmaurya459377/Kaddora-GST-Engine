<?php
/**
 * Plugin Name: Kaddora GST Engine
 * Plugin URL: https://themekaddora.com/
 * Description: GST Invoice & Compliance Engine for WooCommerce
 * Version: 1.0.0
 * Author: Kaddora
 * Author URL: https://kaddora.com/
 */

if (!defined('ABSPATH')) exit;


if (defined('KADDORA_GST_VERSION')) return;

define('KADDORA_GST_VERSION', '1.0.0');
define('KADDORA_GST_PATH', plugin_dir_path(__FILE__));
define('KADDORA_GST_URL', plugin_dir_url(__FILE__));

// Load Composer Autoload (Dompdf)
if (file_exists(KADDORA_GST_PATH . 'vendor/autoload.php')) {
  require_once KADDORA_GST_PATH . 'vendor/autoload.php';
}

/**
 * Safe require helper
 */
function gst_require_file($file)
{
  if (file_exists($file)) {
    require_once $file;
  }
}

/**
 * Check Pro status
 */
function gst_is_pro_active()
{
  return (bool) get_option('gst_pro_active', 0);
}

/**
 * Shared upgrade message
 */
function gst_get_upgrade_message()
{
  return 'Upgrade to Pro to unlock E-Invoice, GSTR Reports, Bulk Downloads and Compliance Automation.';
}

/**
 * Upgrade URL
 */
function gst_get_upgrade_url()
{
  return admin_url('admin.php?page=gst-upgrade');
}

/**
 * Load Core Files Safely
 */
gst_require_file(KADDORA_GST_PATH . 'includes/class-gst-core.php');
gst_require_file(KADDORA_GST_PATH . 'includes/class-activator.php');
gst_require_file(KADDORA_GST_PATH . 'includes/class-deactivator.php');
gst_require_file(KADDORA_GST_PATH . 'includes/class-loader.php');

/**
 * Plugin activation
 */
function gst_activate_plugin()
{
  if (class_exists('GST_Activator')) {
    GST_Activator::activate();
  }
}
register_activation_hook(__FILE__, 'gst_activate_plugin');

/**
 * Plugin deactivation
 */
function gst_deactivate_plugin()
{
  if (class_exists('GST_Deactivator')) {
    GST_Deactivator::deactivate();
  }
}
register_deactivation_hook(__FILE__, 'gst_deactivate_plugin');

/**
 * Run Plugin
 */
function gst_run_plugin()
{
  if (class_exists('GST_Loader')) {
    return GST_Loader::instance()->run();
  }
}
add_action('plugins_loaded', 'gst_run_plugin');
