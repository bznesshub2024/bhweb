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
        url: 'get_tree_view_data.php',
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

                var ttype = "";
                if (this.transaction_type == "credit") {
                    ttype = '<span class = "Active">credit</span>';
                } else if (this.transaction_type == "debit") {
                    ttype = '<spanclass = "Deactive">debit</span>';
                } 
                var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.user_unique_id + '</td><td > ' + this.fullname + '</td><td > ' + this.referral_code + '</td><td > ' + this.phone + '</td><td ><a  href="user_tree_view.php?id='+ this.user_unique_id +'" class="btn btn-danger waves-effect waves-light btn-sm pull-left text-light" >View Tree</a><a  href="wallet_summery.php?id='+ this.user_unique_id +'" style=" margin-left: 10px;" class="btn btn-dark waves-effect waves-light btn-sm pull-left text-light">Wallet Summary</a> </td>';
                html += '</tr>';
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
        url: 'get_tree_view_data.php',
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
				
				var total_c = (pagenov - 1) * perpage + count;

                var ttype = "";
                if (this.transaction_type == "credit") {
                    ttype = '<span class = "Active">credit</span>';
                } else if (this.transaction_type == "debit") {
                    ttype = '<spanclass = "Deactive">debit</span>';
                } 
               var html = '<tr id="tr' + this.id + '"> <td>' + total_c + '</td><td > ' + this.user_unique_id + '</td><td > ' + this.fullname + '</td><td > ' + this.referral_code + '</td><td > ' + this.phone + '</td><td ><a  href="user_tree_view.php?id='+ this.user_unique_id +'" class="btn btn-danger waves-effect waves-light btn-sm pull-left text-light" >View Tree</a><a  href="wallet_summery.php?id='+ this.user_unique_id +'" style=" margin-left: 10px;" class="btn btn-dark waves-effect waves-light btn-sm pull-left text-light">Wallet Summary</a> </td>';
                html += '</tr>';
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

        if (!namevalue) {
            successmsg("Please enter Brand Name");
        }

        if (namevalue) {
            $.busyLoadFull("show");
            var form_data = new FormData();
            form_data.append('namevalue', namevalue);
            form_data.append('code', code_ajax);

            $.ajax({
                method: 'POST',
                url: 'add_attribute_set_process.php',
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
        url: 'get_tree_view_data.php',
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
				
				var total_c = (1 - 1) * perpage + count;

                var ttype = "";
                if (this.transaction_type == "credit") {
                    ttype = '<span class = "Active">credit</span>';
                } else if (this.transaction_type == "debit") {
                    ttype = '<spanclass = "Deactive">debit</span>';
                } 
               var html = '<tr id="tr' + this.id + '"> <td>' + total_c + '</td><td > ' + this.user_unique_id + '</td><td > ' + this.fullname + '</td><td > ' + this.referral_code + '</td><td > ' + this.phone + '</td><td ><a  href="user_tree_view.php?id='+ this.user_unique_id +'" class="btn btn-danger waves-effect waves-light btn-sm pull-left text-light" >View Tree</a><a  href="wallet_summery.php?id='+ this.user_unique_id +'" style=" margin-left: 10px;" class="btn btn-dark waves-effect waves-light btn-sm pull-left text-light">Wallet Summary</a> </td>';
                html += '</tr>';
                $("#cat_list").append(html);

                count = count + 1;
            });




        }
    });
}

