function addVideoControlsOnResize() {
	var screenWidth = window.innerWidth;
	if (screenWidth < 768) {
		// Add the controls
		var video = document.getElementById("product-video");
		var playIcon = video.nextElementSibling;
		if (video) {
			video.controls = false;
			// playIcon.style.display = "none";
		}
		playIcon.addEventListener("click", function () {
			if (video.paused) {
				video.play();
				playIcon.style.display = "none";
			} else {
				video.pause();
				playIcon.style.display = "flex";
			}
		});
		video.addEventListener("click", function () {
			if (video.paused) {
				video.play();
				playIcon.style.display = "none";
			} else {
				video.pause();
				playIcon.style.display = "flex";
			}
		});
	} else {
		// Remove the controls
		var video = document.getElementById("product-video");
		var playIcon = video.nextElementSibling;
		if (video) {
			video.controls = false;
			playIcon.style.display = "flex";
			playIcon.setAttribute("data-bs-toggle", "modal")
			playIcon.setAttribute("data-bs-target", "#staticBackdrop")
		}
	}
}

window.onload = addVideoControlsOnResize;
window.onresize = addVideoControlsOnResize;

var csrfName = $(".txt_csrfname").attr("name"); //
var csrfHash = $(".txt_csrfname").val(); // CSRF hash
var site_url = $(".site_url").val(); // CSRF hash
var user_id = $("#user_id").val(); // CSRF hash
var recent_id = $("#recent_id").val(); // CSRF hash
var user_pincode = $("#user_pincode").val();
var website_name = $("#website_name").val();

$(function () {
	window.onload = related_product();
	window.onload = upsell_product();
	if (user_pincode != '0') {
		$('#check_pincode').val(user_pincode);
		window.onload = submit_user_pincode(user_pincode);
	}
});


function submit_user_pincode(user_pincode) {

	var csrfName = $('.txt_csrfname').attr('name');

	var csrfHash = $('.txt_csrfname').val();

	var site_url = $('.site_url').val();


	var spinner = '<div  role="status"><span class="se-only"></span></div> Wait..';
	$('.pincodeBtn').html(spinner);

	$.ajax({

		method: 'get',

		url: site_url + 'checkpincode',

		data: {

			language: 1,

			pincode: user_pincode,

			devicetype: 2,

			[csrfName]: csrfHash

		},

		success: function (response) {
			$('.pincodeBtn').text('Check');


			$('#pincode_msg').html(response);


		}

	});


}

function submit_pincode(event) {
	event.preventDefault();

	var csrfName = $('.txt_csrfname').attr('name');

	var csrfHash = $('.txt_csrfname').val();

	var site_url = $('.site_url').val();

	var check_pincode = $('#check_pincode').val();

	if (check_pincode.length < 6) {
		$('#pincode_msg').html('Invalid Pincode');
	}
	else {
		var spinner = '<div  role="status"><span class="se-only"></span></div> Wait..';
		$('.pincodeBtn').html(spinner);

		$.ajax({

			method: 'get',

			url: site_url + 'checkpincode',

			data: {

				language: 1,

				pincode: check_pincode,

				devicetype: 2,

				[csrfName]: csrfHash

			},

			success: function (response) {
				$('.pincodeBtn').text('Check');


				$('#pincode_msg').html(response);


			}

		});

	}
}


function related_product() {
	var pid = $("#pid").val();
	var sid = $("#sid").val();

	$.ajax({
		method: "post",
		url: site_url + "get_related_products",
		data: {
			language: default_language,
			devicetype: 2,
			pid: pid,
			sid: sid,
			[csrfName]: csrfHash,
		},
		success: function (response) {
			var parsedJSON = response.Information;
			var order = parsedJSON.length;
			var product_html = "";
			if (order != 0) {
				$("#related_product").empty();
				$(parsedJSON).each(function () {
					
					var ratingHTML = '';
					if (this.product_total_rating > 0) {
						var rating = Math.round(this.product_total_rating * 2) / 2;
						const wholeNumber = Math.floor(rating);
						const fractionalPart = rating - wholeNumber;
						for (let i = 0; i < wholeNumber; i++) {
							ratingHTML += '<i class="fa-solid fa-star fa-lg" style="color: #162b75;"></i>';
						}
						if (fractionalPart >= 0.5) {
							emptyStars = 5 - wholeNumber - 1;
							ratingHTML += '<i class="fa-solid fa-star-half-stroke fa-lg" style="color: #162b75;"></i>';
						} else {
							emptyStars = 5 - wholeNumber;
						}
						
						for (let i = 0; i < emptyStars; i++) {
							ratingHTML += '<i class="fa-solid fa-star fa-lg"></i>';
						}
						
					}
					
					product_html += `<div class="mx-2 py-2 mb-2">
									<a href="${site_url}product/${this.web_url}" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
										<div>
											<div class="d-flex justify-content-between align-items-center" style="margin-top:-25px;">
												<span class="ribbon3"><span class="text-white">${this.offpercent}</span></span>
												<span class="wishlist"><i class="fa fa-heart-o"></i></span>
											</div>
											<div class="image-container mt-3 me-5 zoom-img">
												<img src="${site_url}media/${this.imgurl}" class="rounded zoom-img thumbnail-image">
											</div>
											<div class="product-detail-container p-2 mb-3">
												<div class="justify-content-between align-items-center">
													<p class="dress-name fs-5 mb-0 fs-5">${this.name}</p>	
													<div class="d-flex justify-content-start flex-row mt-2" style="width: 100%;">
														<span class="new-price mx-1" style="color: #ff6600;">${this.price}</span>
														<small class="old-price text-right mx-1" style="color: #ff6600;">${this.mrp}</small>
													</div>
												</div>
												<div class="d-flex justify-content-between align-items-center pt-1">
													<div>
														${ratingHTML}
													</div>
													<button class="text-center card_buy_btn btn-radious" type="button" onclick="add_to_cart_product_buy(event, '${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}', '1', '0', '2', '${qoute_id}')">BUY</button>
												</div>
											</div>
										</div>
									</a>
								</div>`; 
					
				});
			} else {
				$('#sameProd').hide();
			}
			$("#related_product").html(product_html);
			$('.slider-trending').slick({
				slidesToShow: 5,
				slidesToScroll: 1,
				arrows: true,
				infinite: false,
				autoplay: false,
				responsive: [{
					breakpoint: 1199,
					settings: {
						slidesToShow: 5,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 575,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
				}

				]
			});

		},
	});
}


function upsell_product() {
	var pid = $("#pid").val();
	var sid = $("#sid").val();

	$.ajax({
		method: "post",
		url: site_url + "get_upsell_products",
		data: {
			language: default_language,
			devicetype: 2,
			pid: pid,
			sid: sid,
			[csrfName]: csrfHash,
		},
		success: function (response) {
			//hideloader();
			var parsedJSON = response.Information;
			var order = parsedJSON.length;
			var product_html = "";
			if (order != 0) {
				$("#upsell_product").empty();
				$(parsedJSON).each(function () {
					
					var ratingHTML = '';
					if (this.product_total_rating > 0) {
						var rating = Math.round(this.product_total_rating * 2) / 2;
						const wholeNumber = Math.floor(rating);
						const fractionalPart = rating - wholeNumber;
						for (let i = 0; i < wholeNumber; i++) {
							ratingHTML += '<i class="fa-solid fa-star fa-lg" style="color: #162b75;"></i>';
						}
						if (fractionalPart >= 0.5) {
							emptyStars = 5 - wholeNumber - 1;
							ratingHTML += '<i class="fa-solid fa-star-half-stroke fa-lg" style="color: #162b75;"></i>';
						} else {
							emptyStars = 5 - wholeNumber;
						}
						
						for (let i = 0; i < emptyStars; i++) {
							ratingHTML += '<i class="fa-solid fa-star fa-lg"></i>';
						}
						
					}
					
					product_html += `<div class="mx-2 py-2 mb-2"> 
									<a href="${site_url}product/${this.web_url}" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
										<div>
											<div class="d-flex justify-content-between align-items-center" style="margin-top:-25px;">
												<span class="ribbon3"><span class="text-white">${this.offpercent}</span></span>
												<span class="wishlist"><i class="fa fa-heart-o"></i></span>
											</div>
											<div class="image-container mt-3 me-5 zoom-img">
												<img src="${site_url}media/${this.imgurl}" class="rounded zoom-img thumbnail-image">
											</div>
											<div class="product-detail-container p-2 mb-3">
												<div class="justify-content-between align-items-center">
													<p class="dress-name fs-5 mb-0 fs-5">${this.name}</p>	
													<div class="d-flex justify-content-start flex-row mt-2" style="width: 100%;">
														<span class="new-price mx-1" style="color: #ff6600;">${this.price}</span>
														<small class="old-price text-right mx-1" style="color: #ff6600;">${this.mrp}</small>
													</div>
												</div>
												<div class="d-flex justify-content-between align-items-center pt-1">
													<div>
														${ratingHTML}
													</div>
													<button class="text-center card_buy_btn btn-radious" type="button" onclick="add_to_cart_product_buy(event, '${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}', '1', '0', '2', '${qoute_id}')">BUY</button>
												</div>
											</div>
										</div>
									</a>
								</div>`; 
				});
			} else {
			}
			$("#upsell_product").html(product_html);
			$('.slider-trending1').slick({
				slidesToShow: 5,
				slidesToScroll: 1,
				arrows: true,
				infinite: false,
				autoplay: false,
				responsive: [{
					breakpoint: 1199,
					settings: {
						slidesToShow: 5,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 575,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
				}

				]
			});
		},
	});
}



function add_to_cart_product_buynow(event, pid, sku, vendor_id, user_id, qty, referid, devicetype, qouteid) {

	event.preventDefault();

	var csrfName = $('.txt_csrfname').attr('name'); // 

	var csrfHash = $('.txt_csrfname').val(); // CSRF hash

	var site_url = $('.site_url').val(); // CSRF hash



	var qty = 1;

	if (qty == '') {

		Swal.fire({

			position: "center",

			//icon: "success",

			title: "Please Select Qty",

			showConfirmButton: true,

			confirmButtonText: "ok",

			confirmButtonColor: "#f42525",

			timer: 3000,

		});

	} else if (user_id == '') {

		Swal.fire({

			position: "center",

			//icon: "success",

			title: "Please login to add product into Cart",

			showConfirmButton: true,

			confirmButtonText: "ok",

			confirmButtonColor: "#f42525",

			timer: 3000,

		});

	} else {

		$.ajax({

			method: 'post',

			url: site_url + 'buynowProductCart',

			data: {

				language: 1,

				pid: pid,

				sku: sku,

				sid: vendor_id,

				user_id: user_id,

				qty: qty,

				referid: referid,

				devicetype: 2,

				qouteid: qouteid,

				[csrfName]: csrfHash

			},

			success: function (response) {

				//hideloader();

				/*alert(response.msg)*/

				addto_cart_count();

				if (response.msg == 'Please select color / size' || response.msg == 'Product is out of stock') {

					Swal.fire({

						position: "center",

						//icon: "success",

						title: response.msg,

						showConfirmButton: false,

						confirmButtonColor: '#f42525',

						timer: 3000

					});

				}
				else {

					location.href = site_url + "checkout";

				}



				//location.href = site_url + "checkout";

				//$('#cart_msg').html(response.msg);

				// $('#id01').show();

				//alert(response.msg);

			}

		});

	}

}


function add_to_cart_products(
	event,
	pid,
	sku,
	vendor_id,
	user_id,
	qty,
	referid,
	devicetype,
	qouteid
) {
	event.preventDefault();

	var qty = 1;

	if (user_id == '') {

		Swal.fire({

			position: "center",

			//icon: "success",

			title: "Please login to add product into Cart",

			showConfirmButton: true,

			confirmButtonText: "ok",

			confirmButtonColor: "#f42525",

			timer: 3000,

		});

	} else {
		document.querySelector('#offcanvasRight').querySelector('.offcanvas-body').querySelector('.row').innerHTML = '';
		document.querySelector('#offcanvasRight').querySelector('.offcanvas-footer').innerHTML = '';
		document.querySelector('#offcanvas-loader').className = "";
		var qty = 1;
		$.ajax({
			method: "post",
			url: site_url + "addProductCart",
			data: {
				language: default_language,
				pid: pid,
				sku: sku,
				sid: vendor_id,
				user_id: user_id,
				qty: qty,
				referid: referid,
				devicetype: 2,
				qouteid: qouteid,
				[csrfName]: csrfHash,
			},
			success: function (response) {
				//hideloader();
				// alert('dd');
				//$("#id01").show();
				addto_cart_count();

				if (response.msg == "Product attribute mandotary") {
					Swal.fire({
						position: "center",
						//icon: "success",
						title: "Please Select Color/Size",
						showConfirmButton: true,
						confirmButtonText: "ok",
						confirmButtonColor: "#f42525",
						timer: 3000,
					});
				} else {
					var offcanvasElement = document.getElementById("offcanvasRight");
					var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
					offcanvas.show();
					setTimeout(() => {
						document.querySelector('#offcanvasRight').querySelector('.offcanvas-body').querySelector('.row').innerHTML = '';
						document.querySelector('#offcanvas-loader').classList.add('d-none');
						response.Information.forEach(cartItem => {
							document.querySelector('#offcanvasRight').querySelector('.offcanvas-body').querySelector('.row').innerHTML +=
								`<div class="col-12 mb-3 px-0">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col-3">
													<a href="${site_url}${cartItem.web_url}?pid=${cartItem.prodid}&sku=${cartItem.sku}&sid=${cartItem.vendor_id}">
														<img src="${site_url + 'media/' + cartItem.imgurl}" alt="">
													</a>
												</div>
												<div class="col-9">
													<div class="d-flex flex-column">
														<div class="cart-prod-title mb-2">
															<a href="${site_url}${cartItem.web_url}?pid=${cartItem.prodid}&sku=${cartItem.sku}&sid=${cartItem.vendor_id}" class="offcanvas_prod_name">
																${cartItem.name}
															</a>
														</div>
														<div class="rate mb-2">
															<h5>${cartItem.price}</h5>
															<div class="old-price offcanvas_mrp">${cartItem.mrp}</div>
															<div class="off-price offcanvas_off_price">${cartItem.offpercent}</div>
														</div>
														<div class="quantity mb-2">
															<div class="input-group">
																<button type="button" class="btn btn-primary offcanvas_qty_btn" type="button" id="" onclick="add_product_qty2(this, '${cartItem.prodid}','${cartItem.sku}','${cartItem.vendor_id}','${user_id}',${parseInt(cartItem.qty) - 1},'',2,'${qouteid}')"><i class="fa-solid fa-minus offcanvas_qty_icon"></i></button>
																<input type="number" class="form-control mx-3 offcanvas_qty" placeholder="" value="${cartItem.qty}" readonly>
																<button type="button" class="btn btn-primary offcanvas_qty_btn" type="button" id="" onclick="add_product_qty2(this, '${cartItem.prodid}','${cartItem.sku}','${cartItem.vendor_id}','${user_id}',${parseInt(cartItem.qty) + 1},'',2,'${qouteid}')"><i class="fa-solid fa-plus offcanvas_qty_icon"></i></button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>`;
						});
						document.querySelector('#offcanvasRight').querySelector('.offcanvas-footer').innerHTML =
							`<div class="d-flex align-items-center justify-content-between p-2">
								<div class="cart-count">${response.Information.length} Item</div>
								<div class="cart-total d-flex align-items-center">
									<div class="cart-total-text">Subtotal:</div>
									<div class="cart-total-value">&nbsp;${response.total_price}</div>
								</div>
							</div>
							<hr class="m-0 px-2">
							<div class="btn-wrap btn-oc d-flex py-2 justify-content-evenly btn_container_offcanvas">
								<a href="${site_url}cart" class="btn btn-lg btn-secondary waves-effect waves-light add_to_cart_offcanvas">
									<div class="d-flex justify-content-center align-items-center h-100">
										<i class="fa-solid fa-sm fa-cart-shopping"></i>
										<div class="mx-2 fw-bolder text-uppercase product_cart_bottom_btns">Continue to Cart</div>
									</div>
								</a>
								<button class="btn btn-lg btn-light waves-effect waves-light border buy_now_offcanvas">
									<div class="d-flex justify-content-center align-items-center h-100">
										<div class="mx-2 fw-bolder text-dark text-uppercase product_cart_bottom_btns" data-bs-dismiss="offcanvas">Continue Shopping</div>
									</div>
								</button>
							</div>`;
					}, 500);
				}
				//location.href = site_url + "cart";
				/*if (confirm('Add to Cart Product Successfully?')) {
		  // Save it!
		   location.href=site_url+'cart';
		  console.log('View Cart');
		} else {
		  // Do nothing!
		  console.log('Continue Shopping');
		}*/
			},
		});

	}
}

function add_product_qty2(
	ele,
	prod_id,
	sku,
	vendor_id,
	user_id,
	qty,
	referid,
	devicetype,
	qouteid
) {
	$.ajax({
		method: "post",
		url: site_url + "addProductCart",
		data: {
			language: default_language,
			pid: prod_id,
			sku: sku,
			sid: vendor_id,
			user_id: user_id,
			qty: qty,
			referid: referid,
			devicetype: 2,
			qouteid: qouteid,
			[csrfName]: csrfHash,
		},
		success: function (response) {
			//hideloader();
			//$(".table").load(location.href + " .table");
			//alert(response.msg);
			// alert(response.status);
			//location.reload();
			if (response.status == 1) {
				document.querySelector('#offcanvasRight').querySelector('.offcanvas-body').querySelector('.row').innerHTML = '';
				document.querySelector('#offcanvas-loader').classList.add('d-none');
				response.Information.forEach(cartItem => {
					document.querySelector('#offcanvasRight').querySelector('.offcanvas-body').querySelector('.row').innerHTML +=
						`<div class="col-12 mb-3 px-0">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-3">
											<a href="${site_url}${cartItem.web_url}?pid=${cartItem.prodid}&sku=${cartItem.sku}&sid=${cartItem.vendor_id}">
												<img src="${site_url + 'media/' + cartItem.imgurl}" alt="">
											</a>
										</div>
										<div class="col-9">
											<div class="d-flex flex-column">
												<div class="cart-prod-title mb-2">
													<a href="${site_url}${cartItem.web_url}?pid=${cartItem.prodid}&sku=${cartItem.sku}&sid=${cartItem.vendor_id}" class="offcanvas_prod_name">
														${cartItem.name}
													</a>
												</div>
												<div class="rate mb-2">
													<h5>${cartItem.price}</h5>
													<div class="old-price offcanvas_mrp">${cartItem.mrp}</div>
													<div class="off-price offcanvas_off_price">${cartItem.offpercent}</div>
												</div>
												<div class="quantity mb-2">
													<div class="input-group">
														<button type="button" class="btn btn-primary offcanvas_qty_btn" type="button" id="${prod_id}" onclick="add_product_qty2(this, '${cartItem.prodid}','${cartItem.sku}','${cartItem.vendor_id}','${user_id}',${parseInt(cartItem.qty) - 1},'',2,'${qouteid}')"><i class="fa-solid fa-minus offcanvas_qty_icon"></i></button>
														<input type="number" class="form-control offcanvas_qty mx-3" placeholder="" value="${cartItem.qty}" readonly>
														<button type="button" class="btn btn-primary offcanvas_qty_btn" type="button" id="${prod_id}" onclick="add_product_qty2(this, '${cartItem.prodid}','${cartItem.sku}','${cartItem.vendor_id}','${user_id}',${parseInt(cartItem.qty) + 1},'',2,'${qouteid}')"><i class="fa-solid fa-plus offcanvas_qty_icon"></i></button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>`;
				});
				document.querySelector('#offcanvasRight').querySelector('.offcanvas-footer').innerHTML =
					`<div class="d-flex align-items-center justify-content-between p-2">
						<div class="cart-count">${response.Information.length} Item</div>
							<div class="cart-total d-flex align-items-center">
								<div class="cart-total-text">Subtotal:</div>
								<div class="cart-total-value">&nbsp;${response.total_price}</div>
							</div>
						</div>
						<hr class="m-0 px-2">
						<div class="btn-wrap btn-oc d-flex py-2 justify-content-evenly btn_container_offcanvas">
							<a href="${site_url}cart" class="btn btn-lg btn-secondary waves-effect waves-light add_to_cart_offcanvas">
								<div class="d-flex justify-content-center align-items-center h-100">
									<i class="fa-solid fa-sm fa-cart-shopping"></i>
									<div class="mx-2 fw-bolder text-uppercase product_cart_bottom_btns">Continue to Cart</div>
								</div>
							</a>
							<button class="btn btn-lg btn-light waves-effect waves-light border buy_now_offcanvas">
								<div class="d-flex justify-content-center align-items-center h-100">
									<div class="mx-2 fw-bolder text-dark text-uppercase product_cart_bottom_btns" data-bs-dismiss="offcanvas">Continue Shopping</div>
								</div>
							</button>
						</div>`;
			} else {
				if (response.msg !== 'Cart invalid request') {
					Swal.fire({
						title: response.msg,
						type: 'error',
						confirmButtonColor: '#FF6600',
						confirmButtonText: 'OK',
						timer: 1000
					});
				}
			}

		},
	});
}

function get_product_attributes(tag) {
	//var attr_name = $(tag).attr("attribute-label");
	//alert($("#"+attr_name+"_attr_id").val());
	$("#" + tag.replace(/[^a-zA-Z0-9]/g, '_') + "_attr_id").attr("checked", true);

	var numberOfChecked = $(".product_attributes:checkbox:checked").length;
	var totalCheckboxes = $(".product_attributes:checkbox").length;

	if (totalCheckboxes == numberOfChecked) {
		var attribute_array = [];

		$.each($(".attribute-values:checked"), function () {
			var attributes_id = $(this).attr("attribute-label");

			attribute_array.push({
				attr_id: $("#" + attributes_id + "_attr_id").val(),
				attr_name: attributes_id,
				attr_value: $(this).val(),
			});
		});
		var pid = $("#pid").val();
		var sku = $("#sku").val();
		var sid = $("#sid").val();
		var user_id = $("#user_id").val();
		var qoute_id = $("#qoute_id").val();
		var whats_btn = $("#whats_btn").val();
		var whatsapp_number = $("#whatsapp_number").val();
		var jsons = JSON.stringify(attribute_array);
		var buy_now = '';
		var add_to_cart = '';
		if (default_language == '1') {
			buy_now = 'اشتري الآن';
			add_to_cart = 'أضف إلى السلة';
		} else {
			buy_now = 'Buy Now';
			add_to_cart = 'Add to Cart';
		}
		$.ajax({
			method: "post",
			url: site_url + "getProductPrice",
			data: {
				pid: pid,
				sku: sku,
				sid: sid,
				contentType: "application/json",
				config_attr: jsons,
				language: default_language,
				[csrfName]: csrfHash,
			},
			success: function (response) {
				//hideloader();
				// alert(response);
				var parsedJSON = response.Information;
				var product_html = "";
				$(".pBtns").empty();
				$("#btn-mb").empty();

				$(parsedJSON).each(function () {
					// alert();

					$('#prod_stock').html(this.product_stock +' In stock');
					$('#prod_stock').text(this.product_stock +' In stock');
					if (this.product_price == '' || this.product_stock == 0) {
						$('.pBtns').hide();
						$('.pBtns1').hide();
						//$('.pBtns0').show();
						$('#cart_btns').html('<button class="btn btn-default fs-4">Out of Stock</button>');
						$('#cart_btns1').html('<button class="btn btn-default fs-4">Out of Stock</button>');
					} else {

						
						if (this.imgurl != '') {
							console.log(this.imgurl);
							const gallery_view = document.getElementById('gallery_view');
							var slick_track = gallery_view.querySelector('.slick-track');
							var product_images = slick_track.querySelectorAll('a:not(.attribute_image)');

							gallery_view.innerHTML = '';
							gallery_view.classList.remove('slick-initialized', 'slick-slider');
							product_images_count = product_images.length;
							product_images.forEach(image => {
								console.log(image.href);
								gallery_view.innerHTML +=
									`<a class="spotlight zoom-img" id="gallarry_img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="${image.href}">
												<div>
													<img class="img-fluid" alt="${website_name}" src="${image.href}">
												</div>
											</a>`;
							});
							gallery_view.innerHTML +=
								`<a class="spotlight zoom-img attribute_image" id="gallarry_img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="${site_url.concat('media/', this.imgurl)}">
											<div>
												<img class="img-fluid" alt="${website_name}" src="${site_url.concat('media/', this.imgurl)}">
											</div>
										</a>`;

							$(".slider-single").slick({
								slidesToShow: 1,
								slidesToScroll: 1,
								arrows: false,
								fade: true,
								adaptiveHeight: true,
								infinite: true,
								useTransform: true,
								speed: 400,
								initialSlide: 2,
								cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
								responsive: [{
									breakpoint: 767,
									settings: {
										dots: true,
									},
								},],
							});

							$('.slider-single').slick('slickGoTo', product_images_count);




							/*$("#product-config_img").html('<div><img class="img-fluid" src="'+site_url+'media/'+this.imgurl+'"></div>'); 
							$("#product-config_img").attr("href", site_url+'media/'+this.imgurl);
							$("#product-config_img").addClass('slick-active slick-current');
							
							$("#gallarry_img").attr("aria-hidden", true);
							$("#gallarry_img").attr("tabindex", 0);
							$("#gallarry_img").css({width: 448px; position: relative; left: 0px; top: 0px; z-index: 998; opacity: 0; transition: opacity 400ms cubic-bezier(0.77, 0, 0.18, 1) 0s;});
							

							$("#product-config_img").attr("aria-hidden", false);
							$("#product-config_img").attr("tabindex", -1);
							$("#product-config_img").css({width: 448px; position: relative; left: -448px; top: 0px; z-index: 999; opacity: 1;});*/





							$("#product_small_config_img").html('<img  class="img-fluid" alt="' + website_name + '" src="' + site_url + 'media/' + this.imgurl + '">');
						}
						$("#product-price").html(this.product_price);
						$("#mrp").html(this.product_mrp);
						var discount = (this.product_mrp.replace(/\D/g, '')) - (this.product_price.replace(/\D/g, ''));
						$("#total_saving").html('JD' + discount);
						$('.pBtns').show();
					}

					if (whats_btn != 10) {
						product_html += '<a href="#" onclick="add_to_cart_product_buynow(event,' +
							"'" +
							pid +
							"','" +
							this.product_attr_sku +
							"','" +
							sid +
							"','" +
							user_id +
							"','1','0','2'," +
							"'" +
							qoute_id +
							"'" +
							')"  class="btn btn-default"> Buy Now</a>';
					}
					if (whats_btn == 10) {
						product_html += '&nbsp;<a target="_blank" href="https://api.whatsapp.com/send?phone=%2B91' + whatsapp_number + '&text=hi"  class="btn btn-success"><svg width="35" height="35" viewBox="2 1 24 24" version="1.1" id="svg8" inkscape:version="0.92.4 (5da689c313, 2019-01-14)" sodipodi:docname="1881161.svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  xml:space="preserve"><path id="path4" inkscape:connector-curvature="0" d="M16.6,14c-0.2-0.1-1.5-0.7-1.7-0.8c-0.2-0.1-0.4-0.1-0.6,0.1c-0.2,0.2-0.6,0.8-0.8,1c-0.1,0.2-0.3,0.2-0.5,0.1c-0.7-0.3-1.4-0.7-2-1.2c-0.5-0.5-1-1.1-1.4-1.7c-0.1-0.2,0-0.4,0.1-0.5c0.1-0.1,0.2-0.3,0.4-0.4c0.1-0.1,0.2-0.3,0.2-0.4c0.1-0.1,0.1-0.3,0-0.4c-0.1-0.1-0.6-1.3-0.8-1.8C9.4,7.3,9.2,7.3,9,7.3c-0.1,0-0.3,0-0.5,0C8.3,7.3,8,7.5,7.9,7.6C7.3,8.2,7,8.9,7,9.7c0.1,0.9,0.4,1.8,1,2.6c1.1,1.6,2.5,2.9,4.2,3.7c0.5,0.2,0.9,0.4,1.4,0.5c0.5,0.2,1,0.2,1.6,0.1c0.7-0.1,1.3-0.6,1.7-1.2c0.2-0.4,0.2-0.8,0.1-1.2C17,14.2,16.8,14.1,16.6,14 M19.1,4.9C15.2,1,8.9,1,5,4.9c-3.2,3.2-3.8,8.1-1.6,12L2,22l5.3-1.4c1.5,0.8,3.1,1.2,4.7,1.2h0c5.5,0,9.9-4.4,9.9-9.9C22,9.3,20.9,6.8,19.1,4.9 M16.4,18.9c-1.3,0.8-2.8,1.3-4.4,1.3h0c-1.5,0-2.9-0.4-4.2-1.1l-0.3-0.2l-3.1,0.8l0.8-3l-0.2-0.3C2.6,12.4,3.8,7.4,7.7,4.9S16.6,3.7,19,7.5C21.4,11.4,20.3,16.5,16.4,18.9"/></svg>WhatsApp</a>';

					} else {

						product_html += '<a href="#" onclick="add_to_cart_products(event,' +
							"'" +
							pid +
							"','" +
							this.product_attr_sku +
							"','" +
							sid +
							"','" +
							user_id +
							"','1','0','2'," +
							"'" +
							qoute_id +
							"'" +
							')" class="btn btn-secondary"> Add to Cart</a>';
					}

				});
				$(".pBtns").html(product_html);
				$("#btn-mb").html(product_html);
			},
		});
	}
}


$('#myInput').hide();
$('#coupon_name').hide();

const spL = document.getElementById("spotlight");
if (spL) {
	const copyLink = document.querySelector(".spl-autofit");
	const url = window.location.href;

	if (copyLink) {

		copyLink.addEventListener("click", () => {
			navigator.clipboard.writeText(url);
			alert("URL Copied");
		})
	} else {
		console.log("not")
	}
} else {
	console.log("not fnd")
}

function copy_link() {
	event.preventDefault();

	var copyText = document.getElementById("myInput");
	copyText.select();
	copyText.setSelectionRange(0, 99999); /* For mobile devices */

	navigator.clipboard.writeText(copyText.value);

	Toastify({
		text: "Copied Links !",
		duration: 1500,
		newWindow: false,
		close: false,
		gravity: "bottom", // `top` or `bottom`
		position: "center", // `left`, `center` or `right`
		stopOnFocus: true, // Prevents dismissing of toast on hover
		style: {
			background: "linear-gradient(to right, #f42525, #f42525)",
		},
		onClick: function () { } // Callback after click
	}).showToast();



}

function copy_vendor_coupon() {

	var copyText = document.getElementById("coupon_name");
	copyText.select();
	copyText.setSelectionRange(0, 99999); /* For mobile devices */

	navigator.clipboard.writeText(copyText.value);


	Toastify({
		text: "Coupon Copied!",
		duration: 1500,
		newWindow: false,
		close: false,
		gravity: "bottom", // `top` or `bottom`
		position: "center", // `left`, `center` or `right`
		stopOnFocus: true, // Prevents dismissing of toast on hover
		style: {
			background: "linear-gradient(to right, #f42525, #f42525)",
		},
		onClick: function () { } // Callback after click
	}).showToast();



}


$(".slider-single").slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	fade: true,
	adaptiveHeight: true,
	infinite: true,
	useTransform: true,
	speed: 400,
	cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
	responsive: [{
		breakpoint: 767,
		settings: {
			dots: true,
		},
	},],
});

$(".slider-nav")
	.on("init", function (event, slick) {
		$(".slider-nav .slick-slide.slick-current").addClass("is-active");
	})
	.slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		dots: false,
		focusOnSelect: false,
		arrows: true,
		infinite: false,
		responsive: [{
			breakpoint: 1024,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 1,
				infinite: true,
			},
		},
		{
			breakpoint: 640,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 1,
				infinite: true,
			},
		},
		{
			breakpoint: 420,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 1,
				infinite: true,
			},
		},
		],
	});



$(".slider-nav").on("click", ".slick-slide", function (event) {
	event.preventDefault();
	var goToSingleSlide = $(this).data("slick-index");

	$(".slider-single").slick("slickGoTo", goToSingleSlide);
});

$("#review_form").submit(function (event) {
	event.preventDefault();

	var ProductReview = $("#ProductReview").val();
	var reviewtitle = $("#reviewtitle").val();
	var pid = $("#pid").val();
	var user_id = $("#user_id").val();
	var rating = $("input[name='rating1']:checked").val();
	if (rating == undefined) {
		//alert('dddd'+rating);
		$("#error_msg").html('Please Select Rating Stars.');
	}

	$.ajax({
		method: "post",
		url: site_url + "addProductReview",
		data: {
			language: default_language,
			pid: pid,
			user_id: user_id,
			review_title: reviewtitle,
			review_comment: ProductReview,
			review_rating: rating,
			[csrfName]: csrfHash,
		},
		success: function (response) {

			$("#error_msg").html(response.msg);
			//hideloader();
			//alert(response.msg);
			//location.reload();
			Swal.fire({
				position: "center",
				//icon: "success",
				title: response.msg,
				showConfirmButton: false,
				confirmButtonColor: "#f42525",
				timer: 3000,
			});
			setTimeout(function () {
				location.reload();
			}, 2000);
		},
	});
});




$(window).scroll(function () {
	var scrollTop = $(this).scrollTop();
	$('.nav_inner').css({
		opacity: function () {
			var elementHeight = $('.slick-slide').height() - 120,
				opacity = ((1 - (elementHeight - scrollTop) / elementHeight) * 0.8) + 0;
			return opacity;
		}
	});
	if (scrollTop >= $('.slick-slide').height() - 48) {
		document.getElementsByClassName("responsive_nav")[0].style["boxShadow"] = "0 0 5px #999999";
	} else {
		document.getElementsByClassName("responsive_nav")[0].style["boxShadow"] = "";
	}
});