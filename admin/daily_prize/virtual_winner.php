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
      <th>Company Name</th>
      <th>Name</th>
      <th>User ID</th>
      <th>Plan Detail</th>
      <th>Date</th>
      <th>Winning Counts</th>
      <th>Action</th>
      <th>History</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sno = 1;

    // Main summary query
    $result = $conn->query("
      SELECT 
          *
      FROM 
          sellerlogin
    WHERE 
          plan_value > '1'
      ORDER BY 
          plan_value DESC
    ");

    if ($result->num_rows > 0) {
      $data = $result->fetch_all(MYSQLI_ASSOC);
      $i = 0;
      foreach ($data as $this_data) {
        $seller_id = $this_data['seller_unique_id'];
         $i++;
        ?>
        <tr >
          <td><?php echo $i; ?></td>
          <td><?php echo htmlspecialchars($this_data['companyname']); ?></td>
          <td><?php echo htmlspecialchars($this_data['fullname']); ?></td>
          <td><?php echo htmlspecialchars($this_data['user_id']); ?></td>
          
          <td>₹<?php echo $this_data['plan_value']; ?></td>
          <td><?php echo date('Y-m-d',strtotime($this_data['create_by'])); ?></td>
<td>
<?php
$check_win = $conn->query("SELECT * FROM prize_money_contests_winner WHERE sellers_id = '$seller_id'");
echo $total_records = $check_win->num_rows;
?>
</td>

          <td> 
<?php
// Use proper variable for seller ID

// Query the table using $conn->query
$check_win = $conn->query("SELECT * FROM prize_money_contests_winner WHERE prize_money_contests_id = '$daily_prize_id' AND sellers_id = '$seller_id'");

$row_check_win = $check_win->fetch_all(MYSQLI_ASSOC);

if (count($row_check_win) == 0) {

if($daily_prize_date >= date('Y-m-d')){



    ?>
    <a href='?daily_prize_confrim_result=<?php echo $daily_prize_id; ?>&seller_id=<?php echo $seller_id; ?>&user_id=<?php echo $this_data['user_id']; ?>&plan_price=<?php echo $this_data['plan_value']; ?>' 
       class='btn btn-danger btn-sm' 
       onclick="return confirm('Are you sure you want to Confirm this Winner?');">
       Winner
    </a>
<?php }
} else { ?>

<a href='#' class='btn btn-success btn-sm'>
     Already  Winner
    </a>

<?php } ?>

          </td>

<td>
<?php
$check_win = $conn->query("SELECT * FROM prize_money_contests_winner WHERE sellers_id = '$seller_id'");

// Check if any records exist
if ($check_win->num_rows > 0) {
    echo "<div class='orde_div'>
            <table class='table table-hover' border='1'  style='margin: 0;'>
                <thead class='thead-light'>
                    <tr>
                        <td class='order_table'><b>Daily Prize ID</b></td>
                        <td class='order_table'><b>Winning Price</b></td>
                    </tr>
</thead>
<tbody >

                    ";

    while ($this_win = $check_win->fetch_assoc()) {
        echo "
                    <tr>
                        <td class='order_table'><a  target='_blank' href='?daily_prize_view={$this_win['prize_money_contests_id']}'>{$this_win['prize_money_contests_id']}</a></td>
                        <td class='order_table'>₹" . number_format($this_win['winning_price'], 2) . "</td>
                    </tr>";
    }

    echo "      </tbody>
            </table>
          </div>";
}
?>

</td>



        </tr>
        <?php

      } 
    }
    ?>
  </tbody>
</table>


