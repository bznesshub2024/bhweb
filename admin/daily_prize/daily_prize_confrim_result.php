<?php
$daily_prize_id=$_GET['daily_prize_confrim_result'];
$stmt = $conn->prepare("SELECT * FROM prize_money_contests WHERE id = ?");
$stmt->bind_param("i", $daily_prize_id);
$stmt->execute();
$result = $stmt->get_result();
$contest = $result->fetch_assoc();

$daily_prize_id=$contest['id'];
$reward_type=$contest['reward_type'];
$daily_prize_date=$contest['schedule_date'];
$status=$contest['status'];
$daily_prize_winners=$contest['winners'];
$price_value=$contest['value'];
$type=$contest['type'];

if($reward_type == 1){



$type1 = $conn->query("
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
          LIMIT $daily_prize_winners
      ");
$type1_data = $type1->fetch_all(MYSQLI_ASSOC);
foreach($type1_data as $this_data){
$user_id=$this_data['user_id'];
addmoney_wallet($conn,$user_id,$price_value,$type);
}


$stmt = $conn->prepare("UPDATE prize_money_contests SET status = 1 WHERE id = ?");
$stmt->bind_param("i", $daily_prize_id);
$stmt->execute();


echo "<script>alert('Contest Winner successfully'); window.location='daily_prize.php?daily_prize_view=".$daily_prize_id."';</script>";
exit;

//echo '<pre>';print_r($type1_data);die;


}







function addmoney_wallet($conn,$user_id,$amount,$type){
$sql_wallet = "SELECT * FROM wallet_summery WHERE user_id = '$user_id' LIMIT 1";
$result_wallet = $conn->query($sql_wallet);
$get_wallet = $result_wallet->fetch_assoc();

$old_amount = $get_wallet['amount'];
$wallet_id = $get_wallet['wallet_id'];

$new_amount = $old_amount + $amount;
$sql_update_wallet = "UPDATE wallet_summery SET amount = '$new_amount' WHERE user_id = '$user_id'";
$conn->query($sql_update_wallet);

$transaction_id = 'txt' . rand(100, 999) . date('dmYHi');

$sql_last_txn = "SELECT * FROM wallet_transaction_history 
                 WHERE wallet_id = '$wallet_id' 
                 ORDER BY id DESC LIMIT 1";
$result_txn = $conn->query($sql_last_txn);

$old_balance = 0;
if ($result_txn->num_rows > 0) {
    $last_txn = $result_txn->fetch_assoc();
    $old_balance = $last_txn['balance'];
}

$new_balance = $old_balance + $amount;
$created_at = date('Y-m-d H:i:s');

$payment_type='';
if($type == 1){
$payment_type='5';
}elseif($type == 2){
$payment_type='1';
}

$sql_insert_txn = "
    INSERT INTO wallet_transaction_history 
        (wallet_id, payment_type, transaction_id, transaction_type, amount, balance, product_id, order_id, user_id, remark, created_at)
    VALUES 
        ('$wallet_id', '$payment_type', '$transaction_id', 'credit', '$amount', '$new_balance', '', '', '$user_id', 'Daily Prize Money', '$created_at')
";
$conn->query($sql_insert_txn);
if ($conn->affected_rows > 0) {
    //echo "1";
} else {
    //echo "Something went wrong!";
}


}

//echo '<pre>';print_r($type1_data);die;

?>