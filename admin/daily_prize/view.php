 <?php

$daily_prize_id=$_GET['daily_prize_view'];

$stmt = $conn->prepare("SELECT * FROM prize_money_contests WHERE id = ?");
$stmt->bind_param("i", $daily_prize_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  die("Contest not found.");
}
$contest = $result->fetch_assoc();
$reward_name ='';
if($contest['reward_type'] == 1){
  $reward_name ='Referral Winner';
}elseif($contest['reward_type'] == 2){
  $reward_name ='Daily Prize Money Winner';
}elseif($contest['reward_type'] == 3){
  $reward_name ='Festival Winner';
}elseif($contest['reward_type'] == 4){
  $reward_name ='Virtual Partner';
}

$type_name='';
if($contest['type'] == 1){
  $type_name ='Cash';
}

$status_text = $contest['status'] == 1 ? "✅ Completed" : "⏳ Pending";
$daily_prize_id=$contest['id'];
$daily_prize_date=$contest['schedule_date'];
$status=$contest['status'];
$daily_prize_winners=$contest['winners'];
 ?>
<style>
  .winner_color{
    background: #f77832;
    color: #fff;
  }

</style>
 <div class="row">

        <div class="col-12">

          <div class="page-title-box">

            <h4 class="page-title">View</h4>

          </div>

        </div>

      </div>



<div class="row">



        <div class="col-12">

          <div class="card">

            <div class="card-body">

     



              <div class="work-progres">

                <div class="table-responsive">

 <table class="table table-bordered">
        <tr>
          <td><b>Reward Type :</b> <?= htmlspecialchars($reward_name) ?></td>
          <td><b>Title:</b> <?= htmlspecialchars($contest['title']) ?></td>
          <td><b>Type:</b> <?= htmlspecialchars($type_name) ?></td>
          <td><b>Value (Price):</b> <?= htmlspecialchars($contest['value']) ?></td>
        </tr>
        <tr>
          <td><b>No. of Winners :</b> <?= htmlspecialchars($contest['winners']) ?></td>
          <td><b>Schedule Date:</b> <?= htmlspecialchars($daily_prize_date) ?></td>
          <td><b>Status:</b> <?= htmlspecialchars($status_text) ?></td>
          <td></td>
        </tr>
      </table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php 

if($status == 0){?>
<div style="display: none;" id="showconfirmButton">
<hr/>
<center>
<a href="?daily_prize_confrim_result=<?php echo $daily_prize_id;?>" class='btn btn-primary'  onclick="return confirm('Are you sure you want to Confirm Result?');">
  Confirm Result

</a>
</center>
<hr/>
</div>
<?php }?>


<?php
if($contest['reward_type'] == 1){
  include("referral_winner.php");
}elseif($contest['reward_type'] == 2){
  include("daily_prize_winner.php");
}elseif($contest['reward_type'] == 3){
  include("daily_prize_winner.php");
}elseif($contest['reward_type'] == 4){
  include("virtual_winner.php");
}
?>







                </div>

             

             

              </div>



            </div>

          </div>

        </div>

      </div>



<!-- Modal -->

