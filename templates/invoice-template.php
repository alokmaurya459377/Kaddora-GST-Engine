<?php
if (!defined('ABSPATH')) exit;

$order_id = isset($order_id) ? $order_id : '';
$items = isset($items) && is_array($items) ? $items : [];
?>

<style>
  body {
    font-family: DejaVu Sans;
    font-size: 12px;
  }

  h1 {
    text-align: center;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
  }

  th,
  td {
    border: 1px solid #ddd;
    padding: 8px;
  }

  th {
    background: #f5f5f5;
  }
</style>

<h1>GST Invoice</h1>

<p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
<p><strong>Date:</strong> <?php echo date('d M Y'); ?></p>

<table>
  <tr>
    <th>Product</th>
    <th>HSN</th>
    <th>Rate</th>
    <th>Price</th>
    <th>Tax</th>
  </tr>

  <?php foreach ($items as $item): ?>
    <tr>
      <td><?php echo esc_html($item['name']); ?></td>
      <td><?php echo esc_html($item['hsn']); ?></td>
      <td><?php echo esc_html($item['rate']); ?>%</td>
      <td><?php echo wc_price($item['price']); ?></td>
      <td>
        CGST: <?php echo wc_price($item['tax']['cgst']); ?><br>
        SGST: <?php echo wc_price($item['tax']['sgst']); ?><br>
        IGST: <?php echo wc_price($item['tax']['igst']); ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
