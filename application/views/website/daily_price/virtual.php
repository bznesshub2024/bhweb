<table class="table table-hover" id="tblname">
  <thead class="thead-light">
    <tr>
     <th>S.No</th>
      <th>Company Name</th>
      <th>Name</th>
      <th>User ID</th>
      <th>Plan Detail</th>
      <th>Winning Counts</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($reward_type_detail)) { 
      $i = 0;
      foreach ($reward_type_detail as $row) { 
        $i++; ?>
        <tr <?php if($row['is_winner'] == 1){ ?> class="winner_color" <?php }?>>
          <td><?= $i; ?></td>
          <td><?php echo mask_name($row['companyname']);?></td>
          <td><?php echo mask_name($row['fullname']);?></td>
          <td><?= htmlspecialchars($row['user_id']); ?></td>
          <td>₹<?php echo $row['plan_value']; ?></td>
          <td><?php echo $row['winner_count']; ?></td>
          <td><?php echo date('Y-m-d',strtotime($row['create_by'])); ?></td>
        </tr>
      <?php } 
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