
<table class="table table-hover" id="tblname">
    <thead class="thead-light">
      <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>User ID</th>
        <th>Refer Code</th>
        <th>No. of installations</th>
        <th>Total Refer Bonus</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sno = 1;
     
      $result = $conn->query("
          SELECT 
              w.wallet_id,
              s.user_id,
              SUM(w.amount) AS total_amount,
              u.fullname,
              u.referral_code,
              COUNT(CASE WHEN w.payment_type = 1 THEN 1 END) AS referral_count
          FROM 
              wallet_transaction_history AS w
          INNER JOIN 
              wallet_summery AS s 
              ON w.wallet_id = s.wallet_id
          INNER JOIN 
            appuser_login AS u 
            ON s.user_id = u.user_unique_id
          WHERE 
              DATE(w.created_at) = '$daily_prize_date'
              AND w.payment_type = 1
          GROUP BY 
              s.user_id, w.wallet_id
          ORDER BY 
              total_amount DESC
      ");

if ($result->num_rows > 0) {
$data = $result->fetch_all(MYSQLI_ASSOC);
// echo '<pre>';print_r($data);die;
$i=0;
foreach ($data as $this_data) {
$i++;
?>
  <tr <?php if($i <= $daily_prize_winners){ ?> class="winner_color" <?php }?>>
  <td><?php echo $i;?></td>
  <td><?php echo $this_data['fullname'];?></td>
  <td><?php echo $this_data['user_id'];?></td>
  <td><?php echo $this_data['referral_code'];?></td>
  <td><?php echo $this_data['referral_count'];?></td>
  <td><?php echo $this_data['total_amount'];?></td>
  <td><?php echo $daily_prize_date;?></td>
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