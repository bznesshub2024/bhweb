<style>
.order_table{
padding: 0 !important;
    border: 0 !important;
    border-bottom: 1px solid #ccc !important;
}
.orde_div {
  max-height: 100px;        /* Maximum height */
  min-height: auto;         /* Adjusts automatically based on content */
  overflow-y: hidden;       /* Hide scrollbar by default */
  transition: all 0.2s ease; /* Smooth transition on hover */
}

/* When hovered, show scrollbar */
.orde_div:hover {
  overflow-y: auto;
}

/* Optional: style scrollbar (for WebKit browsers like Chrome) */
.orde_div::-webkit-scrollbar {
  width: 6px;
}

.orde_div::-webkit-scrollbar-thumb {
  background-color: rgba(0, 0, 0, 0.3);
  border-radius: 10px;
}

.orde_div::-webkit-scrollbar-thumb:hover {
  background-color: rgba(0, 0, 0, 0.5);
}

</style>
<table class="table table-hover" id="tblname">
  <thead class="thead-light">
    <tr>
      <th>S.No</th>
      <th>Name</th>
      <th>User ID</th>
      <th>No. of Orders</th>
      <th>Each Order Amount & Total</th>
      <th>Orders Total</th> 
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sno = 1;

    // Main summary query
    $result = $conn->query("
      SELECT 
          o.user_id,
          u.fullname,
          COUNT(o.sno) AS order_count,
          SUM(o.total_price) AS total_amount
      FROM 
          orders AS o
      INNER JOIN 
          appuser_login AS u 
          ON o.user_id = u.user_unique_id
      WHERE 
          DATE(o.create_date) = '$daily_prize_date'
      GROUP BY 
          o.user_id, u.fullname
      ORDER BY 
          total_amount DESC
    ");

    if ($result->num_rows > 0) {
      $data = $result->fetch_all(MYSQLI_ASSOC);
      $i = 0;
      foreach ($data as $this_data) {
        $i++;

        // Fetch each user's order details
        $user_id = $this_data['user_id'];
        $orders_query = $conn->query("
          SELECT order_id, total_price, create_date 
          FROM orders 
          WHERE user_id = '$user_id' 
          AND DATE(create_date) = '$daily_prize_date'
        ");

        // Prepare list of orders
        $orders_html = "<div class='orde_div'><table class='table' style='    margin: 0;'><tbody><tr><td class='order_table'><b>Order Id</b></rd><td class='order_table'><b>Amount</b></td></tr>";
        //$order_ids = [];
        while ($order = $orders_query->fetch_assoc()) {
          //$order_ids[] = $order['sno'];
          $orders_html .= "
          <tr><td class='order_table'>{$order['order_id']}</td><td class='order_table'>₹". number_format($order['total_price'], 2) ."</td></tr>";
        }
        $orders_html .= "
        <tr><td class='order_table'><b>Total</b></td><td class='order_table'><b>₹". number_format($this_data['total_amount'], 2) ."</b></td></tr>
        </tbody></table></div>";
        //$order_ids_str = implode(', ', $order_ids);
        ?>
        <tr <?php if ($i <= $daily_prize_winners) { ?> class="winner_color" <?php } ?>>
          <td><?php echo $i; ?></td>
          <td><?php echo htmlspecialchars($this_data['fullname']); ?></td>
          <td><?php echo htmlspecialchars($this_data['user_id']); ?></td>
          <td><?php echo $this_data['order_count']; ?></td>
          <td>
            <?php echo $orders_html; ?>
          </td>
          <td>₹<?php echo number_format($this_data['total_amount'], 2); ?></td>
          <td><?php echo htmlspecialchars($daily_prize_date); ?></td>
        </tr>
        <?php
      }
    }
    ?>
  </tbody>
</table>



<script>
  <?php if(count($data) > 0){?>
$('#showconfirmButton').show();
  <?php }?>
</script>