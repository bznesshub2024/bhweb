<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Daily Prize Money";
    include("include/headTag.php") ?>
</head>

<body>

	<?php
    include("include/loader.php")
    ?>
	<?php
        include("include/topbar.php")
        ?>
        <?php
        include("include/navbar.php")
        ?>
	
	
<main class="cart-page">

	
	<section id="privacy">

        <div class="container">
		
			<h2 class="title">Daily Prize Money</h2><br>
			

<div style="      background-color: #fff;
    padding: 0.75rem !important;
    border-radius: var(--mr-border-radius) !important;
    box-shadow: 0 0.125rem 0.25rem #d8632b40 !important;">

        <table class="table table-hover" id="tblname">
    <thead class="thead-light">
      <tr>
        <th>Sno</th>
        <th>Reward Type</th>
        <th>Title</th>
        <th>Type</th>
        <th>Value (Price)</th>
        <th>Winners</th>
        <th>Schedule Date</th>
        <th>Status</th>
        <?php if(!isset($_GET['daily_prize_view'])){?>
        <th>Action</th>
        <?php }?>

      </tr>
    </thead>
    <tbody>
      <?php
      $sno = 1;
          foreach ($data as $row) {
              $reward_name ='';
              if($row['reward_type'] == 1){
                $reward_name ='Referral Winner';
              }elseif($row['reward_type'] == 2){
                $reward_name ='Daily Prize Money Winner';
              }elseif($row['reward_type'] == 3){
                $reward_name ='Festival Winner';
              }elseif($row['reward_type'] == 4){
                $reward_name ='Virtual Partner';
              }

              $type_name='';
              if($row['type'] == 1){
                $type_name ='Cash';
              }

              
              $status_text = $row['status'] == 1 ? "✅ Completed" : "⏳ In Progress";

              echo "<tr>
            <td>{$sno}</td>
            <td>{$reward_name}</td>
            <td>{$row['title']}</td>
            <td>{$type_name}</td>
            <td>₹" . number_format($row['value'], 2) . "</td>
            <td>{$row['winners']}</td>
            <td>{$row['schedule_date']}</td>
            <td>{$status_text}</td>";?>
<?php if(!isset($_GET['daily_prize_view'])){?>
         <td>
         <a href='?daily_prize_view=<?php echo $row['id'];?>' class='btn btn-info btn-sm'>View</a>
         </td>


 <?php }
        echo "</tr>";

              $sno++;
          }
      
      ?>
    </tbody>
  </table>



</div>
        

<?php if(isset($_GET['daily_prize_view'])){?>
<hr/>

<style>
  .winner_color{
    background: #f77832;
    color: #fff;
  }

</style>
<div style="background-color: #fff;
padding: 0.75rem !important;
border-radius: var(--mr-border-radius) !important;
box-shadow: 0 0.125rem 0.25rem #d8632b40 !important;">
<?php
$daily_prize_date=$data[0]['schedule_date'];

$daily_prize_winners=$data[0]['winners'];
$reward_type=$data[0]['reward_type'];
$status=$data[0]['status'];


if($reward_type == 1){
  include("daily_price/referral_winner.php");
}elseif($reward_type == 2){
  include("daily_price/daily_prize_winner.php");
}elseif($reward_type == 3){
  include("daily_price/daily_prize_winner.php");
}elseif($reward_type == 4){
  include("daily_price/virtual.php");
}

?>

</div>
 <?php }?>
        


        </div>

    </section>

</main>

 <?php
    include("include/footer.php")
    ?>

    <?php
    include("include/script.php")
    ?>
	
</body>
	
</html>
