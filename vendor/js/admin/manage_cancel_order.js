var code_ajax = $("#code_ajax").val();

var pageno = 1;

var rowno = 0;

var status = 0;





function getReview(pagenov, rownov) {

    $.busyLoadFull("show");

    var perpage = $('#perpage').val();

    // successmsg( "sdfs" );

    var count = 1;

    $.ajax({

        method: 'POST',

        url: 'get_pendind_cancel_order_data.php',

        data: {

            code: code_ajax,

            page: pagenov,

            rowno: rownov,

            perpage: perpage,


        },

        success: function (response) {

            $.busyLoadFull("hide");

            var parsedJSON = $.parseJSON(response);

            $("#cat_list").empty();



            $("#totalrowvalue").html(parsedJSON["totalrowvalue"]);

            $(".page_div").html(parsedJSON["page_html"]);



            var data = parsedJSON.data;

            $(data).each(function () {



                var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td>' + this.order_id + '</td><td > ' + this.seller_reason + '</td><td > ' + this.seller_status + '</td><td > ' + this.created_at + '</td>';

				if(this.seller_status == 0)
				{
					html += '<td> <button type="submit" class= "btn btn-dark waves-effect waves-light btn-sm pull-left" name="View" onclick="viewReview(' + this.id + ');">Add Reason</button></td></tr>';
				}
				else
				{
					html += '<td></td></tr>';
				}

                $("#cat_list").append(html);



                count = count + 1;

            });







        }

    });

}





function product_review(pagenov) {

    $.busyLoadFull("show");

    var perpage = $('#perpage').val();

    // successmsg( "sdfs" );

    var count = 1;

    $.ajax({

        method: 'POST',

        url: 'get_pendind_cancel_order_data.php',

        data: {

            code: code_ajax,

            page: pagenov,

            rowno: 0,

            perpage: perpage,

        },

        success: function (response) {

            $.busyLoadFull("hide");

            var parsedJSON = $.parseJSON(response);

            $("#cat_list").empty();



            $("#totalrowvalue").html(parsedJSON["totalrowvalue"]);

            $(".page_div").html(parsedJSON["page_html"]);



            var data = parsedJSON.data;

            $(data).each(function () {


				var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td>' + this.order_id + '</td><td > ' + this.seller_reason + '</td><td > ' + this.seller_status + '</td><td > ' + this.created_at + '</td>';

				if(this.seller_status == 0)
				{
					html += '<td> <button type="submit" class= "btn btn-dark waves-effect waves-light btn-sm pull-left" name="View" onclick="viewReview(' + this.id + ');">Add Reason</button></td></tr>';
				}
				else
				{
					html += '<td></td></tr>';
				}


                $("#cat_list").append(html);



                count = count + 1;

            });







        }

    });

}





$(document).ready(function () {

    getReview(pageno, rowno);

	$("#update_order_btn0").click(function (event) {
		event.preventDefault();
		alert('ddd');
		var order_id_update = $("#order_id_update").val();
		var seller_status = $('#seller_status').val();
		var seller_reason = $('#seller_reason').val();

		if (!seller_reason) {
			successmsg("Please Add Reason");
		} else if (!seller_status) {
			successmsg("Please select status");
		} else {
			$.busyLoadFull("show");
			var form_data = new FormData();
			form_data.append('seller_status', seller_status);
			form_data.append('seller_reason', seller_reason);
			form_data.append('order_id_update', order_id_update);
			form_data.append('code', code_ajax);

			$.ajax({
				method: 'POST',
				url: 'edit_category_process.php',
				data: form_data,
				contentType: false,
				processData: false,
				success: function (response) {
					$.busyLoadFull("hide");
					successmsg(response);
					$("#myModalupdate").modal('hide');
					var parentvalue = $("#last_cat").val();
					getCategoryclick(parentvalue);
					$('#cat_image_update').val('');
					$('#web_banner_update').val('');
					$('#app_banner_update').val('');
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

        url: 'get_pendind_cancel_order_data.php',

        data: {

            code: code_ajax,

            page: 1,

            rowno: 0,

            perpage: perpage,

        },

        success: function (response) {

            $.busyLoadFull("hide");

            var parsedJSON = $.parseJSON(response);

            $("#cat_list").empty();





            $("#totalrowvalue").html(parsedJSON["totalrowvalue"]);

            $(".page_div").html(parsedJSON["page_html"]);



            var data = parsedJSON.data;

            $(data).each(function () {

                var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td>' + this.order_id + '</td><td > ' + this.seller_reason + '</td><td > ' + this.seller_status + '</td><td > ' + this.created_at + '</td>';

				if(this.seller_status == 0)
				{
					html += '<td> <button type="submit" class= "btn btn-dark waves-effect waves-light btn-sm pull-left" name="View" onclick="viewReview(' + this.id + ');">Add Reason</button></td></tr>';
				}
				else
				{
					html += '<td></td></tr>';
				}

                $("#cat_list").append(html);



                count = count + 1;

            });

        }

    });

}



function viewReview(id) {
	$("#order_id_update").val(id);
	$("#myModal").modal('show');
}





