<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('GST_Deactivator')) {

  class GST_Deactivator
  {
    public static function deactivate()
    {
      flush_rewrite_rules();
    }
  }
}
