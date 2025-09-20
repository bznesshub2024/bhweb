var code_ajax = $("#code_ajax").val();


var imagejson = [];
var attrjson = [];
var notiimage = "";
var categorylistvisible = false;
$(document).ready(function () {
	// successmsg("ready call");

	var id = 1;
	var high = "5";
	$("#moreImg").click(function () {
		var showId = ++id;
		if (showId <= high) {
			$(".input-files").append('<div id="more_img' + showId + '"><br><input type="file" id="prod_img' + showId + '" onchange=uploadFile1(\"prod_img' + showId + '\")  name="product_image[]" style="float:left; display: inline-block; margin-right:20px;"> </input> ' +
				'<a class="btn btn-sm btn-danger text-light" onclick=removeImage("more_img' + showId + '"); return false;" style="float:left; display: inline-block; margin-right:20px;">Remove</a> <br></div>');
		}
	});

 
	$('#selectrelatedprod').multiselect({
		columns: 3,
		search: true,
		selectAll: false,
		texts: {
			placeholder: 'Select Product (Max 10)',
			search: 'Search Product'
		},
		onOptionClick: function (element, option) {
			var maxSelect = 10;
			if ($(element).val()) {
				// too many selected, deselect this option
				if ($(element).val().length > maxSelect) {
					if ($(option).is(':checked')) {
						var thisVals = $(element).val();

						thisVals.splice(
							thisVals.indexOf($(option).val()), 1
						);

						$(element).val(thisVals);

						$(option).prop('checked', false).closest('li')
							.toggleClass('selected');
					}
				}
				// max select reached, disable non-checked checkboxes
				else if ($(element).val().length == maxSelect) {
					$(element).next('.ms-options-wrap')
						.find('li:not(.selected)').addClass('disabled')
						.find('input[type="checkbox"]')
						.attr('disabled', 'disabled');
				}
				// max select not reached, make sure any disabled
				// checkboxes are available
				else {
					$(element).next('.ms-options-wrap')
						.find('li.disabled').removeClass('disabled')
						.find('input[type="checkbox"]')
						.removeAttr('disabled');
				}
			}
		}

	});




	$('#selectupsell').multiselect({
		columns: 3,
		search: true,
		selectAll: false,
		texts: {
			placeholder: 'Select Product (Max 10)',
			search: 'Search Product'
		},
		onOptionClick: function (element, option) {
			var maxSelect = 10;
			if ($(element).val()) {
				// too many selected, deselect this option
				if ($(element).val().length > maxSelect) {
					if ($(option).is(':checked')) {
						var thisVals = $(element).val();

						thisVals.splice(
							thisVals.indexOf($(option).val()), 1
						);

						$(element).val(thisVals);

						$(option).prop('checked', false).closest('li')
							.toggleClass('selected');
					}
				}
				// max select reached, disable non-checked checkboxes
				else if ($(element).val().length == maxSelect) {
					$(element).next('.ms-options-wrap')
						.find('li:not(.selected)').addClass('disabled')
						.find('input[type="checkbox"]')
						.attr('disabled', 'disabled');
				}
				// max select not reached, make sure any disabled
				// checkboxes are available
				else {
					$(element).next('.ms-options-wrap')
						.find('li.disabled').removeClass('disabled')
						.find('input[type="checkbox"]')
						.removeAttr('disabled');
				}
			}
		}

	});



	// multi select with checkbox close

});



function removeImage(element) {
	$("#" + element).remove();
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

function check_category_limit(view) {
	if ($('.check_category_limit:checkbox:checked').length > 5) {
		view.checked = false;
		successmsg("Category Selection Limit 5");
		//$('.check_category_limit').attr('disabled','disabled');
	}
}

function delete_images(prod_id, index) {
	xdialog.confirm('Are you sure want to delete?', function () {
		$.ajax({
			method: 'POST',
			url: 'delete_product_data.php',
			data: { img_prod_id: prod_id, image_index: index, code: code_ajax },
			success: function (response) {
				var data = $.parseJSON(response);
				if (data['status'] == '1') {
					$("#prod_img_urltxt").val(data['prod_image']);
					$("#imgs_div" + index).remove();
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

$(document).ready(function () {
	$("#editProduct_btn").click(function (event) {
		event.preventDefault();
		var toggleChecked = document.getElementById("togglebtn").checked;
		var productStatus = false;
		if (toggleChecked) {
			productStatus = true;
		} else {
			productStatus = false;
		}
		var prod_namevalue = $('#prod_name').val();

		var prod_mrpvalue = $('#prod_mrp').val();
		var prod_pricevalue = $('#prod_price').val();

		var prod_brand = $('#selectbrand').val();
		var featured_img = $('#featured_img').val();
		var selectattrset = $('#selectattrset').val();

		var valid = 1;

		if (!prod_namevalue) {
			successmsg("Please enter Product Name.");
			valid = 0;
		} else if (!prod_mrpvalue) {
			successmsg("Please enter MRP");
			valid = 0;
		} else if (!prod_pricevalue) {
			successmsg("Price is empty");
			valid = 0;
		} else if (parseFloat(prod_mrpvalue) < parseFloat(prod_pricevalue)) {
			successmsg("Please enter product Price less or equal to MRP");
			valid = 0;
		} else {
			$.busyLoadFull("show");
			$("#myform").submit();

		}
	});

	$("#skip_sale_price").click(function (event) {

		if ($("#skip_sale_price").prop('checked') == true) {
			var prod_mrp = $("#prod_mrp").val();
			var prod_price = $("#prod_price").val();

			$(".sale_prices").val(prod_price);
			$(".mrp_price").val(prod_mrp);
			$(".sale_prices").attr('readonly', 'readonly');
			$(".mrp_price").attr('readonly', 'readonly'); 
		} else {
			$(".sale_prices").removeAttr('readonly', 'readonly');
			$(".mrp_price").removeAttr('readonly', 'readonly');
		}

	});

	if ($("#editor").length > 0) {
		tinymce.init({
			selector: "textarea#editor",
			theme: "modern",
			height: 300,
			plugins: [
				"advlist lists print",
				//  "wordcount code fullscreen",
				"save table directionality emoticons paste textcolor"
			],
			toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
		});
	}
	if ($("#prod_short").length > 0) {
		tinymce.init({
			selector: "textarea#prod_short",
			theme: "modern",
			height: 300,
			plugins: [
				"advlist lists print",
				//  "wordcount code fullscreen",
				"save table directionality emoticons paste textcolor"
			],
			toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

		});
	}
	if ($("#prod_short_ar").length > 0) {
		tinymce.init({
			selector: "textarea#prod_short_ar",
			theme: "modern",
			height: 300,
			plugins: [
				"advlist lists print",
				//  "wordcount code fullscreen",
				"save table directionality emoticons paste textcolor"
			],
			toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
		});
	}
	if ($("#editor_ar").length > 0) {
		tinymce.init({
			selector: "textarea#editor_ar",
			theme: "modern",
			height: 300,
			plugins: [
				"advlist lists print",
				//  "wordcount code fullscreen",
				"save table directionality emoticons paste textcolor"
			],
			toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
		});
	}
});

function check_product() {
	var prod_name = $("#prod_name").val();
	if (!prod_name) {
		successmsg("Please enter Product Name first");
		return false;
	} else {
		$("#myModal").modal();

		var html = '<div class="form-group" id="selectattrs_div">  	<label for="focusedinput" class="col-sm-2 control-label">Select Attributes</label> <div class="col-sm-9"> ';
		html += '<div class="input-files">  <div style="vertical-align: middle; margin-top:5px;">';
		html += '<select class="form-control1 attr-select" id="selectattrs" name="selectattrs[]" onchange=select_attr_val("selectattrs"); required style="float:left; display: inline-block; margin-right:20px;width:150px;">';
		html += '</select> <div id="cselectattrs"></div></div><br>  </div> </div>   </div>';
// 		$('#myform_attr').html(html);
		getproduct_attr();
		$("#manage_configurations_btn").attr('onclick', 'manage_configurations();');
// 		$("#add_more_attr_btndiv").html('<a class="fa fa-plus fa-4 btn btn-primary" aria-hidden="true"  onclick="add_more_attrs();">Add More Attributes</a>');
	}
}

function getproduct_attr(counts = '') {
	var selected_attr = '';
	jQuery("#myform_attr").find('select').each(function () {
		var vau = jQuery(this).val();
		if (vau) {
		    selected_attr = '';
// 			selected_attr += vau + ',';
		}
	});

	$.ajax({
		method: 'POST',
		url: 'get_attributes.php',
		data: {
			code: code_ajax, selected_attr: selected_attr
		},
		success: function (response) {

			var data = $.parseJSON(response);
			/* $('#selectattrs' + counts).empty();
			var o = new Option("Select", "");
			$("#selectattrs" + counts).append(o);
			if (data["status"] == "1") {
				$(data["data"]).each(function () {
					var o = new Option(this.attribute, this.id, this.attribute_value);
					$("#selectattrs" + counts).append('<option value="' + this.id + '" attrs="' + this.attribute_value + '">' + this.attribute + '</option>');
				});

			} else {
				$("#selectattrs_div" + counts).remove();
				successmsg(data["msg"]);
			} */
			if (data["status"] == "1") {
				$("#selectattrs_div").html('')
				$(data["data"]).each(function () {
					var o = new Option(this.attribute, this.id, this.attribute_value);
					// $("#selectattrs" + counts).append('<option value="' + this.id + '" attrs="' + this.attribute_value + '">' + this.attribute + '</option>');
					var html =
						`<tr>
                            <td>
                                <select class="form-control" id="selectattrs" name="selectattrs[]" required style="float:left; display:inline-block; margin-right:20px; width:140px; appearance:none; -webkit-appearance:none; -moz-appearance:none; pointer-events:none;" readonly>
                                    <option value="${this.id}" attrs="${this.attribute_value}">${this.attribute}</option>
                                </select>
                            </td>
                            <td>
                                <div id="cselectattrs" class="d-flex flex-wrap">
                                    ${select_attr_val(this.id, this.attribute_value, this.attribute)}
                                </div>
                            </td>
                        </tr>`;
					$("#selectattrs_div").append(html)
				});

			} else {
				$("#selectattrs_div").remove();
				successmsg(data["msg"]);
			}
		}
	});

}

/* function select_attr_val(id) {
	var element = $("#" + id).find('option:selected');
	var myTag = element.attr("attrs");
	var tag_arr = myTag.split(',');
	var tag_html = '';
	for (var j = 0; j < tag_arr.length; j++) {
		tag_html += '<input type="checkbox" name="attr' + element.val() + '[]" value="' + tag_arr[j] + '" class="attr' + element.val() + '"><span style="padding: 9px;">' + tag_arr[j] + '</span>';
	}
	$("#c" + id).html(tag_html);
} */

function select_attr_val(element_id, myTag, element_name) {

	var tag_arr = myTag.split(',');
	var tag_html = '';
	for (var j = 0; j < tag_arr.length; j++) {
		let firstChar = tag_arr[j].charAt(0);
		if (firstChar == '#') {
			var rgb = hexToRgb(tag_arr[j]);
			var darkerColor = `rgb(${rgb.r * 0.8}, ${rgb.g * 0.8}, ${rgb.b * 0.8})`;
			tag_html += '<div class="d-flex align-items-center mb-1"><input type="checkbox" name="attr' + element_id + '[]" value="' + tag_arr[j] + '" class="attr' + element_id + '"><span style="padding: 13px;background-color:' + tag_arr[j] + ';margin:0px 6px;font-size:1px;border-radius:30px;border:1px solid ' + darkerColor + ';"></span></div>';
		} else {
			tag_html += '<input type="checkbox" name="attr' + element_id + '[]" value="' + tag_arr[j] + '" class="attr' + element_id + '"><span style="padding: 9px;">' + tag_arr[j] + '</span>';
		}
	}

	return tag_html;
}

// function to convert hex color to RGB
function hexToRgb(hex) {
    // remove the "#" symbol
    hex = hex.replace("#", "");

    // convert to RGB
    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);

    return { r, g, b };
}



function manage_configurations(prod_id) { //
	var prod_name = $("#prod_name").val();

	if (!prod_name) {
		successmsg("Please enter Product Name first");
	}
	var sel_attr = '0';
	var sel_attr_val = '0';
	/* jQuery("#myform_attr").find('select').each(function () {
		var vau = jQuery(this).val();
		if (!vau) {
			successmsg("Please select Attribute");
			sel_attr = '1';

		} else {
			if ($('.attr' + vau + ':checkbox:checked').length == 0) {
				sel_attr_val = '1';
				successmsg("Please select Attribute value");
			}
		}

	}); */


	if (prod_name && sel_attr == '0' && sel_attr_val == '0') {
		$.busyLoadFull("show");
		$('#myform_attr').append('<input type="hidden" name="product_name" value="' + prod_name + '" /> ');
		$('#myform_attr').append('<input type="hidden" name="code" value="' + code_ajax + '" /> ');
		var formData = $('#myform_attr').serialize();

		$.ajax({
			method: 'POST',
			url: 'get_attributes_conf_data.php',
			data: formData,
			success: function (response) {
				$.busyLoadFull("hide");
				var data = response;
				$("#myModal").modal('hide');
				$("#skip_pric").show();
				$('#configurations_div_html').html(data);

			}
		});
	}
}


var i = 0;
function add_more_attrs() {
	sel_attr = '0';
	jQuery("#myform_attr").find('select').each(function () {
		var vau = jQuery(this).val();
		if (!vau) {
			successmsg("Please select Attribute");
			sel_attr = '1';

		}

	});
	if (sel_attr != '1') {
		i++;
		var attr_html = '<div class="form-group" id="selectattrs_div' + i + '">	<label for="focusedinput" class="col-sm-2 control-label">Select Attributes</label> <div class="col-sm-9"> ';
		attr_html += '<div class="input-files"> <div style="vertical-align: middle; margin-top:5px;"><select class="form-control1 attr-select" id="selectattrs' + i + '" name="selectattrs[]" onchange=select_attr_val("selectattrs' + i + '") required style="float:left; display: inline-block; margin-right:20px;width:150px;"></select> ';
		attr_html += '<div id="cselectattrs' + i + '"></div><button type="submit" class="btn btn-sm btn-danger" onclick=removeattrs("selectattrs_div' + i + '"); return false;" style="float:left; display: inline-block; margin-right:20px;">Remove</button>';
		attr_html += '</div><br>    </div>     </div>        </div>';


		$("#myform_attr").append(attr_html);
		getproduct_attr(i);
	}
}

function removeattrs(id) {
	$("#" + id).remove();
}

function remove_attr_tr(id) {
	$("#" + id).remove();
}
