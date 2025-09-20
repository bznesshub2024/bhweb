<?php
include('session.php');


if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}

?>
<?php include("header.php"); ?>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">	
   $( function() {
    $( "#fromdate" ).datepicker({dateFormat:"yy-mm-dd"});
    $( "#todate" ).datepicker({dateFormat:"yy-mm-dd"});
  } );
var code_ajax = $("#code_ajax").val();
var pageno = 1;
var rowno = 0;


function getBanners(pagenov, rownov) {
	 showloader();
    var perpage = $('#perpage').val();
    // successmsg( "sdfs" );
    var count = 1;
    $.ajax({
        method: 'POST',
        url: 'get_coupancode_data.php',
        data: {
            code: code_ajax,
            page: pagenov,
            rowno: rownov,
            perpage: perpage
            
        },
        success: function(response) {
            hideloader();
            var parsedJSON = $.parseJSON(response);
            $("#cat_list").empty();           
	
			var total_records = parsedJSON["totalrowvalue"];
            $("#totalrowvalue").html(total_records);
			$(".page_div").html(parsedJSON["page_html"]);
			var data = parsedJSON.data;
            $(data).each(function() {
				
                var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.name + '</td><td> ' +this.value + '</td> <td> ' +this.cap_value + '</td><td> ' +this.minorder + '</td><td> ' +this.fromdate + '</td><td> ' +this.todate + '</td><td> ' +this.user_apply + '</td><td  id="statustd' + this.id + '"> ' +this.activate + '</td> ';
				
				if(this.activate =='active'){
					var deactive = 'deactive';
					html += '<td> <button type="submit" class= "btn btn-warning btn-sm pull-left" id="editbtn'+this.id+'" name="edit" onclick="editBanners(' + this.id + ',\'' +deactive+'\');">Deactive</button>';
                }else{
					var active = 'active';
					html += '<td> <button type="submit" class= "btn btn-warning btn-sm pull-left" id="editbtn'+this.id+'" name="edit" onclick="editBanners(' + this.id + ',\'' +active+'\');">Active</button>';
				}
				html += '<button style=" margin-left: 10px;" type="submit" class= "btn btn-danger btn-sm pull-left" name="delete"  id="deletebtn' + this.id + '" onclick="deleteBanners(' + this.id + ');">DELETE</button>';

                html += '</td></tr>';
                $("#cat_list").append(html);

                count = count + 1;
            });



        }
    });
}
       
function perpage_filter() {
	 showloader();
    var perpage = $('#perpage').val();
    // successmsg( "sdfs" );
    var count = 1;
    $.ajax({
        method: 'POST',
        url: 'get_coupancode_data.php',
        data: {
            code: code_ajax,
            page: 1,
            rowno: 0,
            perpage: perpage
            
        },
        success: function(response) {
            hideloader();
            var parsedJSON = $.parseJSON(response);
            $("#cat_list").empty();           
	
			var total_records = parsedJSON["totalrowvalue"];
            $("#totalrowvalue").html(total_records);
			$(".page_div").html(parsedJSON["page_html"]);
			var data = parsedJSON.data;
            $(data).each(function() {
				
                var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.name + '</td><td> ' +this.value + '</td> <td> ' +this.cap_value + '</td><td> ' +this.minorder + '</td><td> ' +this.fromdate + '</td><td> ' +this.todate + '</td><td> ' +this.user_apply + '</td><td id="statustd' + this.id + '"> ' +this.activate + '</td> ';
              if(this.activate =='active'){
					var deactive = 'deactive';
					html += '<td> <button type="submit" class= "btn btn-warning btn-sm pull-left" id="editbtn'+this.id+'" name="edit" onclick="editBanners(' + this.id + ',\'' +deactive+'\');">Deactive</button>';
                }else{
					var active = 'active';
					html += '<td> <button type="submit" class= "btn btn-warning btn-sm pull-left" id="editbtn'+this.id+'" name="edit" onclick="editBanners(' + this.id + ',\'' +active+'\');">Active</button>';
				} 
				html += '<button style=" margin-left: 10px;" type="submit" class= "btn btn-danger btn-sm pull-left" name="delete"  id="deletebtn' + this.id + '" onclick="deleteBanners(' + this.id + ');">DELETE</button>';

                html += '</td></tr>';
                $("#cat_list").append(html);

                count = count + 1;
            });



        }
    });
}

function brand_product(pagenov) {
	 showloader();
    var perpage = $('#perpage').val();
    // successmsg( "sdfs" );
    var count = 1;
    $.ajax({
        method: 'POST',
        url: 'get_coupancode_data.php',
        data: {
            code: code_ajax,
            page: pagenov,
            rowno: 0,
            perpage: perpage
            
        },
        success: function(response) {
            hideloader();
            var parsedJSON = $.parseJSON(response);
            $("#cat_list").empty();           
	
			var total_records = parsedJSON["totalrowvalue"];
            $("#totalrowvalue").html(total_records);
			$(".page_div").html(parsedJSON["page_html"]);
			var data = parsedJSON.data;
            $(data).each(function() {
				
                var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.name + '</td><td> ' +this.value + '</td> <td> ' +this.cap_value + '</td><td> ' +this.minorder + '</td><td> ' +this.fromdate + '</td><td> ' +this.todate + '</td><td> ' +this.user_apply + '</td><td> ' +this.activate + '</td> ';
                html += '<td> <button type="submit" class= "btn btn-warning btn-sm pull-left" id="editbtn'+this.id+'" name="edit" onclick="editBanners(' + this.id + ', ' +this.cat_order + ', ' +total_records + ');">Deactive</button>';
                html += '<button style=" margin-left: 10px;" type="submit" class= "btn btn-danger btn-sm pull-left" name="delete"  id="deletebtn' + this.id + '" onclick="deleteBanners(' + this.id + ');">DELETE</button>';

                html += '</td></tr>';
                $("#cat_list").append(html);

                count = count + 1;
            });



        }
    });
}


function deleteBanners(id) {

	 xdialog.confirm('Are you sure want to delete?', function() {
		showloader();
		$.ajax({
			method: 'POST',
			url: 'get_coupancode_data.php',
			data: { deletearray: id, code:code_ajax },
			success: function(response) {
				hideloader();
				if(response =='Failed to Delete.'){
					successmsg("Failed to Delete.");
				}else if(response =='Deleted'){
					$("#tr"+id).remove();
					successmsg("Coupon Deleted Successfully.");
				}
			}
		});
}, {
        style: 'width:420px;font-size:0.8rem;',
        buttons: {
            ok: 'yes ',
              cancel: 'no '
         },
        oncancel: function() {
             // console.warn('Cancelled!');
         }
 });
}

function editBanners(id,status) {

	 xdialog.confirm('Are you sure want to '+status+'?', function() {
		showloader();
		$.ajax({
			method: 'POST',
			url: 'get_coupancode_data.php',
			data: { deactiveid: id, code:code_ajax,status:status },
			success: function(response) {
				hideloader();
				if(response =='Failed to Delete.'){
					successmsg("Failed to Delete.");
				}else if(response =='done'){
					successmsg("Coupon Status changed Successfully.");
					var page = $(".pagination .active .current").text();
					getBanners(page, 0);
				}
			}
		});
}, {
        style: 'width:420px;font-size:0.8rem;',
        buttons: {
            ok: 'yes ',
              cancel: 'no '
         },
        oncancel: function() {
             // console.warn('Cancelled!');
         }
 });
}

    $(document).ready(function(){	
		 getBanners(pageno, rowno);	
		
		$("#addCoupan").click(function(event){
			event.preventDefault();
			var code_ajax = $("#code_ajax").val();
			var name_value = $('#cname').val();
			var cdesc_value = $('#cdesc').val();
			var value_value = $('#cvalue').val();
			var capvalue_value = $('#capvalue').val();
			var minorder_value = $('#minorder').val();     
			var fromdate_value = $('#fromdate').val();
			var todate_value = $('#todate').val();
			var counapm_type = $('#counapm_type').val();
			var user_apply = $('#user_apply').val();
            
			if(name_value =="" || name_value == null){
				successmsg("Coupan Code is empty"); 
			}else if(value_value =="" || value_value == null){
               successmsg("Coupan Discount in empty"); 
			}else if(value_value =="" || value_value == null){
               successmsg("Coupan Discount in empty"); 
			}else if(user_apply =="" || user_apply == null){
               successmsg("Please enter No. of times user apply"); 
			}else if(fromdate_value =="" || fromdate_value == null){
               successmsg("Please select Start Date"); 
			}else if(todate_value =="" || todate_value == null){
               successmsg("Please select End Date"); 
			}else{
				showloader();
				$.ajax({
					method: 'POST',
					url: 'add_coupan_process.php',
					data: {
						coupancode: name_value,
						coupandesc: cdesc_value,
						cvalue: value_value,
						capvalue: capvalue_value,
						minorder: minorder_value,
						fromdate: fromdate_value,
						todate: todate_value ,
						coupon_type: counapm_type ,
						user_apply: user_apply ,
						code: code_ajax
					},
					success: function(response){
						hideloader();
						$("#myModal").modal('hide');
						getBanners(1, 0);
						successmsg(response);	
						$('#add_brand_form')[0].reset();
						
					}
				});
			}
		});
	});
	
	function counapm_type1(){
		var counapm_type = $("#counapm_type").val();
		
		if(counapm_type ==1){
			$("#cvaluelbl").text('Value(%)');
			$("#cvalue").attr('placeholder','Coupan Value in %');
		}else if(counapm_type ==2){
			$("#cvaluelbl").text('Value(<?php echo $currency; ?>)');
			$("#cvalue").attr('placeholder','Coupan Value in <?php echo $currency; ?>');
		}
	}
</script>

		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				
         <div class="pull-right page_div" style="float:left;">  </div>
        
		  <div class="perpage">
			<div class="pull-right col-sm-2"> 
				<select class="form-control" id="perpage" name="perpage" onchange="perpage_filter()" style="float:left;">
					<option value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
				</select> 
			</div><span class="pull-right per-pag">Per Page:</span>
		</div>
         <div style=" display: inline-block;  vertical-align: middle">
         </div>
   
	   </br>
			
			
			
			    <div>
                
		           
				
				<div class="clearfix"> </div>
			</br>
                <div class="work-progres">
					<header class="widget-header">
						<div class="pull-right" style="float:left;">
							Total Row :	<a id="totalrowvalue" class="totalrowvalue"></a>
						</div>
						<h4 class="widget-title"><b>All Coupan Code </b> <button type="button" class="btn btn-primary" id="" data-toggle="modal" data-target="#myModal">Add Coupan Code</button>
						</h4>
			
					</header>   
							<hr class="widget-separator">
                            <div class="table-responsive">
                        	<table class="table table-hover"  id="tblname" > 
            			          <thead>
                                    <tr>
                                      <th>ID</th>
                                      <th>Coupan Code</th>
                                      <th>Value(%)</th>
                                      <th>Cap Value(<?php echo $currency; ?>)</th>
                                      <th>Min. Order(<?php echo $currency; ?>)</th>
                                      <th>From Date</th>                     
                                      <th>To Date</th> 
                                      <th>Apply Times</th> 
                                      <th>Status</th>
                                      <th>Action</th>
                                    
                                  </tr>
                              </thead>
                           	<tbody id="cat_list"> 
            			
                          </tbody>
                      </table>
                  </div>
             </div>
			
		</div>
			    
	
	
	
		<div class="col_1">
			
			
			<div class="clearfix"> </div>
			
		</div>
				
			</div>
		</div>
	<!--footer-->
	
    <!--//footer-->
	</div>
	</div>
	<!--footer-->
        <?php include("footernew.php"); ?>
    <!--//footer-->
	
	<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:50%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Coupan Code</h4>
      </div>
      <div class="modal-body"> 
		<form class="form" id="add_brand_form"  enctype="multipart/form-data">
			
			 <div class="form-group"> 
				<label for="name">Coupan Code</label> 
					 <input type="text" class="form-control" id="cname" placeholder="Coupan Code"> 
				</div>
				
				<div class="form-group"> 

				<label for="name">Coupan Description</label> 

					 <input type="text" class="form-control" id="cdesc" placeholder="Coupan Description"> 

				</div>
				
				<div class="form-group"> 
					<label for="name">Coupan Type</label> 
					<select class="form-control1" id="counapm_type" onchange="counapm_type1()" >
						
						<option value="1" >Percentage</option>
						<option value="2" ><?php echo $currency; ?></option>
						
					</select>
				</div>
				<div class="form-group"> 
					<label for="name" id="cvaluelbl">Value(%)</label> 
					 <input type="number" class="form-control" id="cvalue" min= "0" placeholder="Coupan Value in %"> 
				</div>
							    
				 <div class="form-group"> 
				    <label for="name">Cap Value(<?php echo $currency; ?>)</label> 
				       <input type="number" class="form-control" id="capvalue" min= "0" placeholder="Max Discount value in <?php echo $currency; ?>"> 
				 </div>
							     
				<div class="form-group"> 
					<label for="name">Min Order(<?php echo $currency; ?>)</label> 
						<input type="number" class="form-control" id="minorder" min= "0" placeholder="Min Order value in <?php echo $currency; ?>"> 
				</div>
				<div class="form-group"> 
					<label for="name">No. of times user apply</label> 
						<input type="number" class="form-control" id="user_apply" min= "0" placeholder="No. of times single user can apply the same coupon"> 
				</div>
							    
				<div class="form-group"> 
				<label for="name">Start Date</label> 
					<input type="text" class="form-control" id="fromdate" readonly placeholder="YYYY-MM-DD"> 
				</div>
				 <div class="form-group"> 
				   <label for="name">End Date</label> 
				      <input type="text" class="form-control" id="todate" readonly placeholder="YYYY-MM-DD"> 
				</div>
				<button type="submit" class="btn btn-success" value="Upload" href="javascript:void(0)" id="addCoupan">Add</button>           
           
		</form> 
      </div>
      
    </div>

  </div>
</div>		

	