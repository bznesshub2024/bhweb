var code_ajax = $("#code_ajax").val();

var pageno = 1;

var rowno = 0;





function getAttribute(pagenov, rownov) {

	$.busyLoadFull("show");

	var perpage = $('#perpage').val();

	// successmsg( "sdfs" );

	var count = 1;

	$.ajax({

		method: 'POST',

		url: 'get_plans_data.php',

		data: {

			code: code_ajax,

			page: pagenov,

			rowno: rownov,

			perpage: perpage

		},

		success: function (response) {

			$.busyLoadFull("hide");

			var parsedJSON = $.parseJSON(response);

			$("#cat_list").empty();



			$("#totalrowvalue").html(parsedJSON["totalrowvalue"]);

			$(".page_div").html(parsedJSON["page_html"]);



			var data = parsedJSON.data;

			$(data).each(function () {

				var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.plan_name + '</td><td > ' + this.duration + '</td><td > ' + this.plan_value + '</td>';

				html += '<td> <button type="submit" class= "btn btn-danger waves-effect waves-light btn-sm pull-left" name="delete" onclick="deletebrand(' + this.id + ');">DELETE</button>';



				html += '<button  style=" margin-left: 10px;" type="submit" class="btn btn-dark waves-effect waves-light btn-sm pull-left" name="edit" onclick=\'editbrand("' + this.id + '","' + this.plan_name + '","' + this.plan_value+ '","' + this.duration + '")\';>EDIT</button></td></tr>';

				$("#cat_list").append(html);



				count = count + 1;

			});







		}

	});

}





function attribute_set_product(pagenov) {

	$.busyLoadFull("show");

	var perpage = $('#perpage').val();

	// successmsg( "sdfs" );

	var count = 1;

	$.ajax({

		method: 'POST',

		url: 'get_plans_data.php',

		data: {

			code: code_ajax,

			page: pagenov,

			rowno: 0,

			perpage: perpage

		},

		success: function (response) {

			$.busyLoadFull("hide");

			var parsedJSON = $.parseJSON(response);

			$("#cat_list").empty();



			$("#totalrowvalue").html(parsedJSON["totalrowvalue"]);

			$(".page_div").html(parsedJSON["page_html"]);



			var data = parsedJSON.data;

			$(data).each(function () {

				var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.plan_name + '</td><td > ' + this.plan_value + '</td>';

				html += '<td> <button type="submit" class= "btn btn-danger waves-effect waves-light btn-sm pull-left" name="delete" onclick="deletebrand(' + this.id + ');">DELETE</button>';



				html += '<button  style=" margin-left: 10px;" type="submit" class="btn btn-dark waves-effect waves-light btn-sm pull-left" name="edit" onclick=\'editbrand("' + this.id + '","' + this.plan_name + '","' + this.plan_value + '")\';>EDIT</button></td></tr>';

				$("#cat_list").append(html);



				count = count + 1;

			});

		}

	});

}





$(document).ready(function () {

	getAttribute(pageno, rowno);





	$("#add_attribute_btn").click(function (event) {

		event.preventDefault();



		var namevalue = $('#name').val();
		var plan_value = $('#plan_value').val();



		if (!namevalue) {

			successmsg("Please enter Plans Name");

		}
		
		if (!plan_value) {

			successmsg("Please enter Plans Value");

		}



		if (namevalue && plan_value) {

			$.busyLoadFull("show");

			var form_data = new FormData();

			form_data.append('namevalue', namevalue);
			form_data.append('plan_value', plan_value);
			let duration = document.getElementById("duration").value;
			form_data.append('duration', duration);
			form_data.append('code', code_ajax);



			$.ajax({

				method: 'POST',

				url: 'add_plans.php',

				data: form_data,

				contentType: false,

				processData: false,

				success: function (response) {

					$.busyLoadFull("hide");

					$("#myModal").modal('hide');

					$('#name').val('');

					getAttribute(1, 0)

					successmsg(response);

					$('#name').val('');
					$('#plan_value').val('');

				}

			});

		}



	});



	$("#update_attribute_btn").click(function (event) {

		event.preventDefault();


		
		var namevalue = $('#update_name').val();
		
		var plan_value = $('#update_plan_value').val();

		var plan_id = $('#plan_id').val();

		
		if (!namevalue) {

			successmsg("Please enter Plan Name");

		}

		if (!plan_value) {

			successmsg("Please enter Plan Value");

		}



		if (namevalue && plan_value) {
			

			$.busyLoadFull("show");

			var form_data = new FormData();

			form_data.append('namevalue', namevalue);

			form_data.append('plan_id', plan_id);
			let duration = document.getElementById("update_duration").value;
			form_data.append('duration', duration);

			form_data.append('plan_value', plan_value);

			form_data.append('code', code_ajax);



			$.ajax({

				method: 'POST',

				url: 'edit_plans.php',

				data: form_data,

				contentType: false,

				processData: false,

				success: function (response) {
					
					$.busyLoadFull("hide");

					$("#myModalupdate").modal('hide');

					$('#update_name').val('');
					
					$('#update_plan_value').val('');

					$('#plan_id').val('');

					var page = $(".pagination .active .current").text();

					getAttribute(page, 0)

					successmsg(response);



				}

			});

		}



	});







});







function perpage_filter() {

	$.busyLoadFull("show");

	var perpage = $('#perpage').val();

	// successmsg( "sdfs" );

	var count = 1;

	$.ajax({

		method: 'POST',

		url: 'get_plans_data.php',

		data: {

			code: code_ajax,

			page: 1,

			rowno: 0,

			perpage: perpage

		},

		success: function (response) {

			$.busyLoadFull("hide");

			var parsedJSON = $.parseJSON(response);

			$("#cat_list").empty();



			$("#totalrowvalue").html(parsedJSON["totalrowvalue"]);

			$(".page_div").html(parsedJSON["page_html"]);



			var data = parsedJSON.data;
			
			
			$(data).each(function () {

				var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.plan_name + '</td><td > ' + this.plan_value + '</td>';

				html += '<td> <button type="submit" class= "btn btn-danger waves-effect waves-light btn-sm pull-left" name="delete" onclick="deletebrand(' + this.id + ');">DELETE</button>';



				html += '<button  style=" margin-left: 10px;" type="submit" class="btn btn-dark waves-effect waves-light btn-sm pull-left" name="edit" onclick=\'editbrand("' + this.id + '","' + this.plan_name + '","' + this.plan_value + '")\';>EDIT</button></td></tr>';

				$("#cat_list").append(html);



				count = count + 1;

			});

		}

	});

}



function editbrand(id, name, plan_value, duration='') {

	$("#myModalupdate").modal('show');

	$("#plan_id").val(id);

	$("#update_name").val(name);
	$("#update_duration").val(duration).change(); 
	//$("#update_duration").val(duration);

	$("#update_plan_value").val(plan_value);

}



function deletebrand(id) {

	xdialog.confirm('Are you sure want to delete?', function () {

		$.busyLoadFull("show");

		$.ajax({

			method: 'POST',

			url: 'delete_plans.php',

			data: { deletearray: id, code: code_ajax },

			success: function (response) {

				$.busyLoadFull("hide");

				if (response == 'Failed to Delete.') {

					successmsg("Failed to Delete.");

				} else if (response == 'Deleted') {

					$("#tr" + id).remove();

					successmsg("Plan Deleted Successfully.");

				} else {

					$("#myModalbrandassign").modal('show');

					$("#myModalbrandassigndivy").html(response);

				}

			}

		});

	}, {

		style: 'width:420px;font-size:0.8rem;',

		buttons: {

			ok: 'yes ',

			cancel: 'no '

		},

		oncancel: function () {

			// console.warn('Cancelled!');

		}

	});

}



function assign_attribute_btn() {

	var delete_attribute_id = $('#delete_attribute_id').val();

	var attribute_assign_id = $('#attribute_assign_id').val();



	if (delete_attribute_id && attribute_assign_id) {

		$.busyLoadFull("show");

		var form_data = new FormData();

		form_data.append('delete_attribute_id', delete_attribute_id);

		form_data.append('attribute_assign_id', attribute_assign_id);

		form_data.append('code', code_ajax);



		$.ajax({

			method: 'POST',

			url: 'delete_attribute_set.php',

			data: form_data,

			contentType: false,

			processData: false,

			success: function (response) {

				$.busyLoadFull("hide");

				$("#tr" + delete_attribute_id).remove();

				successmsg("Attribute Set Deleted Successfully.");

				$("#myModalbrandassign").modal('hide');

			}

		});

	} else {

		successmsg("Please select Attribute Set");

	}



}









