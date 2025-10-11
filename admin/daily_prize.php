<?php

include('session.php');



if (!$Common_Function->user_module_premission($_SESSION, $ProductAttributes)) {

  echo "<script>location.href='no-premission.php'</script>";

  die();

}



if (!isset($_SESSION['admin'])) {

  header("Location: index.php");

}




?>

<?php include("header.php"); ?>



<!-- main content start-->

<div class="content-page">

  <!-- Start content -->

  <div class="content">

    <div class="container-fluid">

      <!-- start page title -->



<?php
if(isset($_GET['daily_prize_view'])){
include("daily_prize/view.php");
}elseif(isset($_GET['daily_prize_confrim_result'])){
include("daily_prize/daily_prize_confrim_result.php");
}else{
include("daily_prize/list.php");
}
?>







    </div>

  </div>

</div>

<!--footer-->

<?php include("footernew.php"); ?>








<!-- Modal -->

<!-- Modal -->



<!-- Modal -->

