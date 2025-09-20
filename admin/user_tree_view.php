<?php
include('session.php');


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
												
						<ul id="myUL" class="pt-2">
							<?php
							
							

							$query = $conn->query("SELECT * FROM appuser_login WHERE user_unique_id ='".$_REQUEST['id']."' ORDER BY fullname ASC");

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
							function categoryTree($level_1, $sub_mark = '',$count = '')
							{
								global $conn;
								$count++;
								$query = $conn->query("SELECT * FROM appuser_login WHERE level_1 = '".$level_1."'  ORDER BY fullname ASC");

								if ($query->num_rows > 0 ) { 
								
									while ($row = $query->fetch_assoc()) {
										
										$query1 = $conn->query("SELECT user_unique_id FROM appuser_login WHERE level_1 = '" . $row['user_unique_id'] . "' ");
										//	print_r($query1);
										if ($query1->num_rows > 0 && $count < 3) {
											echo '<li><span class="expand" onClick=\'expand("' . $row['user_unique_id'] . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList">' . $row['fullname'] . '</label></li>
												 
												<ul id="ul' . $row['user_unique_id'] . '" class="subList" style="display:block;">';
											echo categoryTree($row['user_unique_id'], $sub_mark . "&nbsp;&nbsp;&nbsp;",$count);
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
      </div>
    </div>
  </div>
</div>
<!--footer-->
<?php include("footernew.php"); ?>
<script src="js/admin/brand.js"></script>
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
</script>
<!--//footer-->
