
<table class="table table-hover" id="tblname">
    <thead class="thead-light">
      <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>User ID</th>
        <th>Refer Code</th>
        <th>No. of installations</th>
        <th>Total Refer Bonus</th>
        <!-- <th>Date</th> -->
      </tr>
    </thead>
    <tbody>
      <?php
      //  echo '<pre>';print_r($reward_type_detail);

$i=0;
foreach ($reward_type_detail as $this_data) {
$i++;
?>
  <tr <?php if(($i <= $daily_prize_winners) && (1 == $status)){ ?> class="winner_color" <?php }?>>
  <td><?php echo $i;?></td>
  <td><?php echo mask_name($this_data['fullname']);?></td>
  <td><?php echo $this_data['user_id'];?></td>
  <td><?php echo $this_data['referral_code'];?></td>
  <td><?php echo $this_data['referral_count'];?></td>
  <td><?php echo $this_data['total_amount'];?></td>
  <!-- <td><?php echo $daily_prize_date;?></td> -->
  </tr>
<?php
}



function mask_name($name) {
    $length = strlen($name);

    if ($length <= 2) {
        return $name; // too short to mask
    }

    $firstChar = $name[0];
    $lastChar = $name[$length - 1];

    $masked = $firstChar . str_repeat('*', $length - 2) . $lastChar;

    return $masked;
}


?>
    </tbody>
  </table>