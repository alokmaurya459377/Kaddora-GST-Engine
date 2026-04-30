<?php

if (!defined("ABSPATH")) exit;

if (!class_exists('GST_Admin_Menu')) {

  class GST_Admin_Menu
  {
    public function __construct()
    {
      add_action('admin_menu', array($this, 'menu'));
      add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    /**
     * menu
     */
    public function menu()
    {
      add_submenu_page(
        'woocommerce',
        'GST Engine',
        'GST Dashboard',
        'manage_options',
        'gst-dashboard',
        [$this, 'dashboard']
      );

      add_submenu_page(
        'woocommerce',
        'GST Invoices',
        'GST Invoices',
        'manage_options',
        'gst-invoices',
        [$this, 'invoices_page']
      );

      add_submenu_page(
        'woocommerce',
        'GST Reports',
        'GST Reports',
        'manage_options',
        'gst-reports',
        array($this, 'reports_page')
      );

      add_submenu_page(
        'woocommerce',
        'GST Settings',
        'GST Settings',
        'manage_options',
        'gst-settings',
        array($this, 'settings_page')
      );

      add_submenu_page(
        'woocommerce',
        'GST Upgrade to Pro',
        'GST Upgrade to Pro',
        'manage_options',
        'gst-upgrade',
        [$this, 'upgrade_page']
      );
    }

    /**
     * upgrade_page
     */
    public function upgrade_page()
    {
      $this->get_file('upgrade');
    }

    /**
     * invoices_page
     */
    public function invoices_page()
    {
      $this->get_file('invoices');
    }

    /**
     * reports_page
     */
    public function reports_page()
    {
      $this->get_file('reports');
    }

    /**
     * settings_page
     */
    public function settings_page()
    {
      $this->get_file('settings');
    }

    /**
     * dashboard
     */
    public function dashboard()
    {
      $this->get_file('dashboard');
    }

    /**
     * get_file
     */
    public function get_file($file)
    {
      $path = KADDORA_GST_PATH . 'admin/views/' . $file . '.php';

      if (file_exists($path)) {
        include $path;
      } else {
        error_log($path . ' Not exists');
      }
    }

    /**
     * enqueue
     */
    public function enqueue()
    {
      wp_enqueue_style(
        'gst-admin',
        KADDORA_GST_URL . 'admin/assets/css/admin.css',
        [],
        KADDORA_GST_PATH
      );
    }
  }
}
