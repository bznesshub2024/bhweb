<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Notifications";
    include("include/headTag.php") ?>
</head>
<style>
#myUL,
	.subList {
		list-style-type: none;
		padding :  0 10px;
		margin : 0 20px;
	}

	.mainList {
		font-weight: 400;
	}
</style>
<body>

	<?php
        include("include/topbar.php")
        ?>
        <?php
        include("include/navbar.php")
        ?>
	
<main class="notification-page my-order-page cart-page">
	
	<!--Start: Notifications Section -->
	<section>
		<div class="container" style="max-width:1344px;">
			<div class="row">
				<?php
				include("include/sidebar.php");
				?>
				
				<div class="col-lg-8">
					<div class="left-block box-shadow" id="MyProfile">
						<h5 class="title">Tree View <span class="d-lg-none"><a class="accordion-button collapsed" id="heading1" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">My Profile</a></span> </h5>
						
						<?php
						include("include/mobile_sidebar.php");
						?>
						

						<div class="notifications">
						
						<ul id="myUL" class="pt-2">
							<?php 
								$this->db->select('*');
								$this->db->join('wallet_summery ws', 'ws.user_id = al.user_unique_id','INNER');
								$this->db->where(array('al.user_unique_id' => $this->session->userdata('user_id')));
								$this->db->order_by('al.fullname','ASC');
								$this->db->limit(1, 0);
								$query = $this->db->get('appuser_login al');

				
								$this->db->limit(1, 0);
								
								if($query->num_rows() >0){
								   $category_array = $query->result_object();
								   foreach($category_array as $cat_details){
									   
									   $this->db->select('user_unique_id');
										$this->db->where(array('level_1' => $cat_details->user_unique_id));
										$this->db->order_by('fullname','ASC');
										$query_1 = $this->db->get('appuser_login');
										
										if($query_1->num_rows() >0){
											
											$category_array1 = $query_1->result_object();
											foreach($category_array1 as $cat_details_1){
												
												
												echo '<li><span class="expand" onClick=\'expand("' . $cat_details->user_unique_id . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList ml-1" onClick=\'user_transection("'.$cat_details->wallet_id.'")\'>&nbsp;' . $cat_details->fullname .'&nbsp;('.date('d-m-Y',strtotime($cat_details->create_by)).' : Revenue - Rs.'.$cat_details->amount.')'. '</label></li>
												 
														<ul id="ul' . $cat_details->user_unique_id . '" class="subList" style="display:block;">';
												//echo categoryTree($cat_details->user_unique_id, $sub_mark . "&nbsp;&nbsp;&nbsp;");
												
															$this->db->select('*');
															$this->db->join('wallet_summery ws', 'ws.user_id = al.user_unique_id','INNER');
															$this->db->where(array('al.level_1' => $cat_details->user_unique_id));
															$this->db->order_by('al.fullname','ASC');
															$query00 = $this->db->get('appuser_login al');
															$this->db->limit(1, 0);
															
															
															
															if($query00->num_rows() >0){
															   $category_array00 = $query00->result_object();
															   foreach($category_array00 as $cat_details00){
																   																   
																   $this->db->select('user_unique_id');
																	$this->db->where(array('level_1' => $cat_details00->user_unique_id));
																	$this->db->order_by('fullname','ASC');
																	$this->db->limit(1, 0);
																	$query_11 = $this->db->get('appuser_login');
																	
																	if($query_11->num_rows() >0){
																		
																		$category_array11 = $query_11->result_object();
																		foreach($category_array11 as $cat_details_11){
																			
																			echo '<li><span class="expand" onClick=\'expand("' . $cat_details00->user_unique_id . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList ml-1" onClick=\'user_transection("'.$cat_details00->wallet_id.'")\'>&nbsp;' . $cat_details00->fullname .'&nbsp;('.date('d-m-Y',strtotime($cat_details00->create_by)).' :  Revenue - Rs.'.$cat_details00->amount.')'.'</label></li>
																			 
																					<ul id="ul' . $cat_details00->user_unique_id . '" class="subList" style="display:block;">';
																			//echo categoryTree($cat_details00->user_unique_id, $sub_mark . "&nbsp;&nbsp;&nbsp;");
																							$this->db->select('*');
																							$this->db->join('wallet_summery ws', 'ws.user_id = al.user_unique_id','INNER');
																							$this->db->where(array('al.level_1' => $cat_details00->user_unique_id));
																							$this->db->group_by("al.user_unique_id");
																							$this->db->order_by('al.fullname','ASC');
																							$query01 = $this->db->get('appuser_login al');
																							
																							if($query01->num_rows() >0){
																							   $category_array01 = $query01->result_object();
																							   foreach($category_array01 as $cat_details01){
																								   
																								   $this->db->select('user_unique_id');
																									$this->db->where(array('level_1' => $cat_details01->user_unique_id));
																									$this->db->group_by("user_unique_id");
																									$this->db->order_by('fullname','ASC');
																									$this->db->limit(1, 0);
																									$query_22 = $this->db->get('appuser_login');
																									
																									if($query_22->num_rows() >0){
																										
																										$category_array22 = $query_22->result_object();
																										foreach($category_array22 as $cat_details_22){
																											
																											echo '<li><span class="expand" onClick=\'expand("' . $cat_details01->user_unique_id . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList ml-1" onClick=\'user_transection("'.$cat_details01->wallet_id.'")\'>&nbsp;' . $cat_details01->fullname .'&nbsp;('.date('d-m-Y',strtotime($cat_details01->create_by)).' : Revenue - Rs.'.$cat_details01->amount.')'.'</label></li>
																											 
																													<ul id="ul' . $cat_details01->user_unique_id . '" class="subList" style="display:block;">';
																											//echo categoryTree($cat_details01->user_unique_id, $sub_mark . "&nbsp;&nbsp;&nbsp;");
																														$this->db->select('*');
																														$this->db->join('wallet_summery ws', 'ws.user_id = al.user_unique_id','INNER');
																														$this->db->where(array('al.level_1' => $cat_details01->user_unique_id));
																														$this->db->group_by("al.user_unique_id");
																														$this->db->order_by('al.fullname','ASC');
																														$query02 = $this->db->get('appuser_login al');
																														if($query02->num_rows() >0){
																														   $category_array02 = $query02->result_object();
																														   foreach($category_array02 as $cat_details02){
																															   
																															   $this->db->select('user_unique_id');
																																$this->db->where(array('level_1' => $cat_details02->user_unique_id));
																																$this->db->group_by("user_unique_id");
																																$this->db->order_by('fullname','ASC');
																																$this->db->limit(1, 0);
																																$query_33 = $this->db->get('appuser_login');
																																
																																if($query_33->num_rows() >0){
																																	
																																	$category_array33 = $query_33->result_object();
																																	foreach($category_array33 as $cat_details_33){
																																		
																																		echo '<li><span class="expand" onClick=\'expand("' . $cat_details02->user_unique_id . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList ml-1" onClick=\'user_transection("'.$cat_details02->wallet_id.'")\'>&nbsp;' . $cat_details02->fullname .'&nbsp;('.date('d-m-Y',strtotime($cat_details02->create_by)).' : Revenue - Rs.'.$cat_details02->amount.')'.'</label></li>
																																		 
																																				<ul id="ul' . $cat_details02->user_unique_id . '" class="subList" style="display:block;">';
																																		//echo categoryTree($cat_details02->user_unique_id, $sub_mark . "&nbsp;&nbsp;&nbsp;");
																																		echo	'</ul>';
																																	}
																																	
																																	
																																} else {
																																echo '<li><span class="expand"><input type="checkbox" name="category[]" value="' . $cat_details02->user_unique_id  . '" class="check_category_limit"></span><label class="mainList ml-1" onClick=\'user_transection("'.$cat_details02->wallet_id.'")\'>&nbsp; ' . $cat_details02->fullname .'&nbsp;('.date('d-m-Y',strtotime($cat_details02->create_by)).' : Revenue - Rs.'.$cat_details02->amount.')'. '</label></li>
																																		';
																																}
																															   
																														   }
																												
																														}
																											
																											echo	'</ul>';
																										}
																										
																										
																									} else {
																									echo '<li><span class="expand"><input type="checkbox" name="category[]" value="' . $cat_details01->user_unique_id  . '" class="check_category_limit"></span><label class="mainList ml-1" onClick=\'user_transection("'.$cat_details01->wallet_id.'")\'>&nbsp; ' . $cat_details01->fullname .'&nbsp;('.date('d-m-Y',strtotime($cat_details01->create_by)).' : Revenue - Rs.'.$cat_details01->amount.')'. '</label></li>
																											';
																									}
																								   
																							   }
																					
																							}
																			
																			
																			
																			echo	'</ul>';
																		}
																		
																		
																	} else {
																	echo '<li><span class="expand"><input type="checkbox" name="category[]" value="' . $cat_details00->user_unique_id  . '" class="check_category_limit"></span><label class="mainList ml-1" onClick=\'user_transection("'.$cat_details00->wallet_id.'")\'>&nbsp; ' . $cat_details00->fullname .'&nbsp;('.date('d-m-Y',strtotime($cat_details00->create_by)).' : Revenue - Rs.'.$cat_details00->amount.')'. '</label></li>
																			';
																	}
																   
															   }
													
															}
												
												
												
												
												echo	'</ul>';
											}
											
											
										} else {
										echo '<li><span class="expand"><input type="checkbox" name="category[]" value="' . $cat_details->user_unique_id  . '" class="check_category_limit"></span><label class="mainList ml-1" onClick=\'user_transection("'.$cat_details->wallet_id.'")\'> ' . $cat_details->fullname .'&nbsp;('.date('d-m-Y',strtotime($cat_details->create_by)).' : Revenue - Rs.'.$cat_details->amount.')'. '</label></li>
												';
										}
									   
								   }
								}
								
								function categoryTree0($level_1, $sub_mark = '',$count = '')
								{
									$count++;
									
									
									$this->db->select('*');
								$this->db->where(array('level_1' => $level_1));
								$this->db->order_by('fullname','ASC');
								$query = $this->db->get('appuser_login');
								
								if($query->num_rows() >0){
								   $category_array = $query->result_object();
								   foreach($category_array as $cat_details){
									   
									   $this->db->select('user_unique_id');
										$this->db->where(array('level_1' => $cat_details->user_unique_id));
										$this->db->order_by('fullname','ASC');
										$query_1 = $this->db->get('appuser_login');
										
										if($query_1->num_rows() >0 && $count < 3){
											
											$category_array1 = $query_1->result_object();
											foreach($category_array1 as $cat_details_1){
												
												echo '<li><span class="expand" onClick=\'expand("' . $cat_details->user_unique_id . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList ml-1">' . $cat_details->fullname . '</label></li>
												 
														<ul id="ul' . $cat_details->user_unique_id . '" class="subList" style="display:block;">';
												echo categoryTree($cat_details->user_unique_id, $sub_mark . "&nbsp;&nbsp;&nbsp;");
												echo	'</ul>';
											}
											
											
										} else {
										echo '<li><span class="expand"><input type="checkbox" name="category[]" value="' . $cat_details->user_unique_id  . '" class="check_category_limit"></span><label class="mainList ml-1"> ' . $cat_details->fullname . '</label></li>
												';
										}
									   
								   }
								}
									
									
									
								}		
									

							?>
							</ul>
						</div>

					</div>
				</div>

			</div>
		</div>
	</section>
	<!--End: Notifications Section -->

</main>

 <?php
    include("include/footer.php")
    ?>

    <?php
    include("include/script.php")
    ?>
	<script>
	function expand(list, view) {
		var listElement = document.getElementById('ul' + list);
		var defaultView = '[+]';

		if (view.innerHTML == defaultView) {
			listElement.style.display = "block";
			view.innerHTML = '[-]';
		} else {
			listElement.style.display = "none";
			view.innerHTML = '[+]';
		}
	}
	
	function user_transection(wallet_id)
	{
		window.location.href = site_url + 'user_wallet_transactions/' + wallet_id;
	}
	</script>
	
</body>
	
</html>
