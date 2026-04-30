<?php
if (!defined("ABSPATH")) exit;

if (!class_exists('GST_Calculator')) {

  class GST_Calculator
  {
    /**
     * calculate
     */
    public static function calculate($amount, $rate, $type)
    {
      $data = [
        'cgst' => 0,
        'sgst' => 0,
        'igst' => 0,
      ];

      if ($type === 'intra') {

        $half = ($amount * $rate / 100) / 2;

        $data['cgst'] = $half;
        $data['sgst'] = $half;
      } else {

        $data['igst'] = ($amount * $rate / 100);
      }

      return apply_filters('gst_calculated_tax', $data, $amount, $rate, $type);
    }
  }
}
