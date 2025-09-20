<?php
include('session.php');

if(!$Common_Function->user_module_premission($_SESSION,$Brand)){
	echo "<script>location.href='no-premission.php'</script>";die();
}

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}

?>
<?php include("header.php"); ?>

<style>
 <!--ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}-->

#myUL,
	.subList {
		list-style-type: none;
		padding :  0 10px;
		margin : 0 20px;
	}

	.mainList {
		font-weight: 400;
	}

 .caret {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
  font-size:16px;
}

.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.table th {
    color: #162b75;
}

.nested {
  display: none;
}

.active {
  display: block;
}

#treeSelect
{
	height : auto;
}
.tree {
            list-style: none;
            padding-left: 20px;
        }

        .tree li {
            margin: 10px 0;
            position: relative;
            padding-left: 20px;
        }

        .tree li:before {
            content: '';
            position: absolute;
            top: 0;
            left: 5px;
            border-left: 1px solid #ccc;
            height: 100%;
        }
</style>
<?php 
/*$mlmTree = array(
    array('id' => 1, 'name' => 'Root', 'parent_id' => null),
    array('id' => 2, 'name' => 'Level 1 Child 1', 'parent_id' => 1),
    array('id' => 3, 'name' => 'Level 1 Child 2', 'parent_id' => 1),
    array('id' => 4, 'name' => 'Level 2 Child 1', 'parent_id' => 2),
    array('id' => 5, 'name' => 'Level 2 Child 2', 'parent_id' => 2),
    // Add more members as needed
);


function generateMlmTree($parentId, $treeArray) {
    echo '<li>';
    echo $treeArray[$parentId - 1]['name']; // Display member name (assuming the array index is ID - 1)

    // Find children of the current member
    $children = array_filter($treeArray, function ($item) use ($parentId) {
        return $item['parent_id'] == $parentId;
    });

    if (!empty($children)) {
        echo '<ul>';
        foreach ($children as $child) {
            generateMlmTree($child['id'], $treeArray);
        }
        echo '</ul>';
    }

    echo '</li>';
}


function getDownline($memberId, $level, $conn)
{
    $sql = "SELECT * FROM appuser_login WHERE sponsor_id = $memberId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<ul>';
        while ($row = $result->fetch_assoc()) {
            echo '<li>' . $row['name'] . '</li>';
            getDownline($row['id'], $level + 1, $conn);
        }
        echo '</ul>';
    }
} 

// Main code to fetch and display the downline tree
function displayDownlineTree($userId, $conn)
{
    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        echo '<ul>';
        echo '<li>' . $row['name'] . '</li>';
        getDownline($userId, 1, $conn);
        echo '</ul>';
    } else {
        echo 'Member not found.';
    }
}

// Usage example:
$rootMemberId = 1; // Replace with the ID of the root member (top-level MLM member)
displayDownlineTree($rootMemberId, $conn);

*/




?>

<!-- main content start-->
<div class="content-page">
  <!-- Start content -->
  <div class="content">
    <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
        <div class="col-12">
          <div class="page-title-box">
            <h4 class="page-title">Tree View</h4>
          </div>
        </div>
      </div>
      <!-- end page title -->
	  
	  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div data-example-id="simple-form-inline">
                <div class="row align-items-center">
                  <div class="col-md-12 mb-2">
						<ul class="tree">
							<?php // generateMlmTree(1, $mlmTree); // Starting with the root node (id: 1) ?>
						</ul>
						<div id="example1" class="col-sm-12">
												<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">

												<div id="treeSelect">
						<ul id="myUL" class="pt-2" style="height :300px;">
							<?php

							$query = $conn->query("SELECT * FROM appuser_login WHERE level_1 !='admin_0001' ORDER BY fullname ASC");

							if ($query->num_rows > 0) {
								while ($row = $query->fetch_assoc()) {
									//echo "SELECT cat_id FROM category WHERE parent_id = '".$row['cat_id']."' ";
									$query1 = $conn->query("SELECT user_unique_id FROM appuser_login WHERE level_1 = '" . $row['user_unique_id'] . "' ");
									//	print_r($query1);
									if ($query1->num_rows > 0) {
										echo '<li><span class="expand" onClick=\'expand("' . $row['user_unique_id'] . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList ml-1">' . $row['fullname'] . '</label></li>
												 
												<ul id="ul' . $row['user_unique_id'] . '" class="subList" style="display:block;">';
										echo categoryTree($row['user_unique_id'], $sub_mark . "&nbsp;&nbsp;&nbsp;");
										echo	'</ul>';
									} else {
										echo '<li><span class="expand"><input type="checkbox" name="category[]" value="' . $row['user_unique_id'] . '" class="check_category_limit" onclick="check_category_limit(this);"></span><label class="mainList ml-1"> ' . $row['fullname'] . '</label></li>
												';
									}
								}
							}

							function categoryTree($level_1, $sub_mark = '')
							{
								global $conn;
								$query = $conn->query("SELECT * FROM appuser_login WHERE level_1 = '".$level_1."'  ORDER BY fullname ASC");

								if ($query->num_rows > 0) { 
									while ($row = $query->fetch_assoc()) {

										$query1 = $conn->query("SELECT user_unique_id FROM appuser_login WHERE level_1 = '" . $row['user_unique_id'] . "' ");
										//	print_r($query1);
										if ($query1->num_rows > 0) {
											echo '<li><span class="expand" onClick=\'expand("' . $row['user_unique_id'] . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList">' . $row['fullname'] . '</label></li>
												 
												<ul id="ul' . $row['user_unique_id'] . '" class="subList" style="display:block;">';
											echo categoryTree($row['user_unique_id'], $sub_mark . "&nbsp;&nbsp;&nbsp;");
											echo '</ul>';
										} else {
											echo '<li><input type="checkbox" name="category[]" value="' . $row['user_unique_id'] . '" class="check_category_limit" onclick="check_category_limit(this);"> <label class="mainList"> ' . $row['fullname'] . '</label></li>';
										}
									}
								}
							}

							?>
						</ul>
						</div>
											</div>
										</div>
						<!--<ul id="myUL">
						  <li><span class="caret">Beverages</span>
							<ul class="nested">
							  <li>Water</li>
							  <li>Coffee</li>
							  <li><span class="caret">Tea</span>
								<ul class="nested">
								  <li>Black Tea</li>
								  <li>White Tea</li>
								  <li><span class="caret">Green Tea</span>
									<ul class="nested">
									  <li>Sencha</li>
									  <li>Gyokuro</li>
									  <li>Matcha</li>
									  <li>Pi Lo Chun</li>
									</ul>
								  </li>
								</ul>
							  </li>  
							</ul>
						  </li>
						</ul>-->
						
						 <div class="table-responsive" style="display:none">
						  <table class="table table-hover table-centered" id="tblname">
							<thead class="thead-light">
							  <tr>
								<th>ID</th>
								<th>Name</th>
								<th>Tree</th>
								<th>mobile</th>
							  </tr>
							</thead>
							<tbody>
								<?php $stmt_users = $conn->query("SELECT fullname,phone,user_unique_id,level_1,level_2 FROM `appuser_login` where user_unique_id != 'admin_0001'");
							while ($rows_datas = $stmt_users->fetch_assoc()) {  ?>
								<tr id="tr2"> 
									<td><?php echo $rows_datas['user_unique_id']; ?></td>
									<td><?php echo $rows_datas['fullname']; ?></td>
									<td><ul><?php

							$query = $conn->query("SELECT * FROM appuser_login WHERE user_unique_id ='".$rows_datas['user_unique_id']."' ORDER BY fullname ASC");

							if ($query->num_rows > 0) {
								while ($row = $query->fetch_assoc()) {
									$query1 = $conn->query("SELECT user_unique_id FROM appuser_login WHERE level_1 = '" . $row['user_unique_id'] . "' ");
									if ($query1->num_rows > 0) {
										echo '<li><span class="expand1" onClick=\'expand1("' . $row['user_unique_id'] . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList ml-1">' . $row['fullname'] .' (Refer Code : '.$row['referral_code'].')'. '</label></li>
												 
												<ul id="ul_' . $row['user_unique_id'] . '" class="subList" style="display:block;">';
										echo categoryTree1($row['user_unique_id'], $sub_mark . "&nbsp;&nbsp;&nbsp;");
										echo	'</ul>';
									} else {
										echo '<li><span class="expand1"><input type="checkbox" name="category[]" value="' . $row['user_unique_id'] . '" class="check_category_limit" onclick="check_category_limit(this);"></span><label class="mainList ml-1"> ' . $row['fullname'] .' (Refer Code : '.$row['referral_code'].')'. '</label></li>
												';
									}
								}
							}
							?>
							</ul>
							</td>
									<td><?php echo $rows_datas['phone']; ?></td>
								
								</tr>
							<?php } ?>
							</tbody>
						  </table>
						</div>
						
						<ul id="myUL" style="display:none;">
						 <?php

							$stmt_user = $conn->query("SELECT fullname,level_1,level_2 FROM `appuser_login` where user_unique_id != 'admin_0001'");
							while ($rows_data = $stmt_user->fetch_assoc()) {  ?>
								
						  <li><span class="caret"><?php echo $rows_data['fullname']; ?></span>
							<ul class="nested">
							<?php
								$stmt_user1 = $conn->query("SELECT fullname FROM `appuser_login` where user_unique_id = '".$rows_data['level_2']."'");
								if($stmt_user1->num_rows > 0) {
								while ($rows_level_1 = $stmt_user1->fetch_assoc()) { ?>
							  <li><span class="caret"><?php echo $rows_level_1['fullname']; ?></span>
								<ul class="nested">
								 <?php
								$stmt_user2 = $conn->query("SELECT fullname FROM `appuser_login` where user_unique_id = '".$rows_data['level_1']."'");
								if($stmt_user2->num_rows > 0) {
								while ($rows_level_2 = $stmt_user2->fetch_assoc()) { ?> 
								  <li><?php echo $rows_level_2['fullname']; ?></li>
								<?php } } ?>
								</ul>
							  </li> 
							<?php } } ?>
							</ul>
						  </li>
							<?php } ?>
						</ul>
                  </div>
                  
                </div>
              </div>
              </br>
              

              <div class="col_1">


                <div class="clearfix"> </div>

              </div>
            </div>
          </div>
        </div>
	  
	  <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
                     <div data-example-id="simple-form-inline">

                        <div class="row align-items-center">
                           <div class="col-md-6 mb-2">
                           </div>
                           <div class="col-md-6 mb-2">
                              <div class="d-flex align-items-center">
                                 <div class="ml-md-auto">
                                    <div class="d-flex align-items-center">
                                       <span>Show</span>
                                       <select class="form-control mx-1" id="perpage" name="perpage" onchange="perpage_filter()" style="float:left;">

                                          <option value="10">10</option>

                                          <option value="25">25</option>

                                          <option value="50">50</option>

                                       </select>
                                       <span class="pull-right per-pag">entries</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </div>

                     <div class="work-progres">
                        <div class="table-responsive">
                           <table class="table table-hover" id="tblname">
                              <thead>
                                 <tr>
                                    <th>Sno</th>
                                    <th>UserID</th>
                                    <th>Name</th>
                                    <th>Referral Code </th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                   
                                 </tr>
                              </thead>
                              <tbody id="cat_list">
                              </tbody>
                           </table>
                        </div>
                        <div class="clearfix"> </div>

                     </div>

                     <div class="col_1">

                        <div class="clearfix"> </div>

                     </div>

                     <div class="row align-items-center">
                        <div class="col-md-6">
                           <div class="pull-right" style="float:left;">
                              Total Row : <a id="totalrowvalue" class="totalrowvalue"></a>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="pull-right page_div ml-auto" style="float:right;"> </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
	  
	  
      
      </div>
    </div>
  </div>
</div>
<?php 
function categoryTree1($level_1, $sub_mark = '',$count = '')
							{
								global $conn;
								$count++;
								$query00 = $conn->query("SELECT * FROM appuser_login WHERE level_1 = '".$level_1."'  ORDER BY fullname ASC");

								if ($query00->num_rows > 0 ) { 
								
									while ($row = $query00->fetch_assoc()) {
										
										$query1 = $conn->query("SELECT user_unique_id FROM appuser_login WHERE level_1 = '" . $row['user_unique_id'] . "' ");
										if ($query1->num_rows > 0 && $count < 3) {
											echo '<li><span class="expand1" onClick=\'expand1("' . $row['user_unique_id'] . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList">' . $row['fullname'] .' (Refer Code : '.$row['referral_code'].')'. '</label></li>
												 
												<ul id="ul_'. $row['user_unique_id'] . '" class="subList" style="display:block;">';
											echo categoryTree1($row['user_unique_id'], $sub_mark . "&nbsp;&nbsp;&nbsp;",$count);
											echo '</ul>';
											
										} else {
											echo '<li><input type="checkbox" name="category[]" value="' . $row['user_unique_id'] . '" class="check_category_limit" onclick="check_category_limit(this);"> <label class="mainList"> ' . $row['fullname'] .' (Refer Code : '.$row['referral_code'].')'. '</label></li>';
										}
									
									}
									
								}
							}
							?>
<!--footer-->
<?php include("footernew.php"); ?>
<script src="js/admin/tree_view.js"></script>
<script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}

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

function expand1(list, view) {
    var listElement = document.getElementById('ul_' + list);
    var defaultView = '[+]';

    if (view.innerHTML == defaultView) {
        listElement.style.display = "block";
        view.innerHTML = '[-]';
    } else {
        listElement.style.display = "none";
        view.innerHTML = '[+]';
    }
}
</script>
<!--//footer-->
