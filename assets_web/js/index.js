var csrfName = $(".txt_csrfname").attr("name");
var csrfHash = $(".txt_csrfname").val();
var site_url = $(".site_url").val();
var user_id = $("#user_id").val();
var qoute_id = $("#qoute_id").val();
var website_name = $("#website_name").val();

$(function () {
	window.onload = get_home_products("New");
	window.onload = get_home_products("Popular");
	window.onload = get_home_products("Recommended");
	window.onload = get_home_products("Offers");
	window.onload = get_home_products("Most");
	window.onload = get_home_products("Custom");
	window.onload = get_home_bottom_banner();
	window.onload = get_home_small_banner('section4', '1930-150');
	window.onload = get_home_small_banner('section10', '1900-320');
	window.onload = get_home_small_banner('section11', '1900-320');
	window.onload = get_home_small_banner('section12', '1900-320');


});

function get_home_products(type) {
	$.ajax({
		method: "get",
		url: site_url + "get_home_products",
		data: { type: type, [csrfName]: csrfHash },
		success: function (response) {
			//hideloader();
			var parsedJSON = JSON.parse(response);
			var order = parsedJSON.length;
			var product_html = "";
			var product_html0 = "";
			var count = 1;
			var add_class = "";
			var whatsapp_number = $("#whatsapp_number").val();

			if (order != 0) {
				$("#" + type + "_products").empty();
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
					
					var wishlist_html = '';
					if(this.product_wishlist == 0)
					{
						wishlist_html += `<span class="d-flex justify-content-between align-items-right whishlist_all" onclick="add_to_wishlist(event,'${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}',1,'',2)"><i class="fa-regular fa-heart" style="color: #162b75;"></i></span>`;
					}
					else
					{
						wishlist_html += `<span class="d-flex justify-content-between align-items-right whishlist_all" onclick="add_to_wishlist(event,'${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}',1,'',2)"><i class="fa-regular fa-heart"></i></span>`;
					}
					
					

					product_html += `<div class="col-lg-3 col-sm-3 col-6 p-3">
									<a href="${site_url}product/${this.web_url}" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
										<div>
											<div class="d-flex justify-content-between align-items-center">
												<span class="ribbon3"><span class="text-white">${this.offpercent}</span></span>
												 ${wishlist_html}
											</div>
											<div class="image-container mt-5 zoom-img">
												<img src="${this.imgurl}" class="rounded zoom-img thumbnail-image">
											</div>
											<div class="product-detail-container p-2 mb-3">
												<div class="justify-content-between align-items-center">
													<p class="dress-name mb-0">${this.name}</p>	
													<div class="d-flex justify-content-start flex-row price_div_cont" style="width: 100%;">
														<span class="new-price" style="color: #ff6600;">${this.price}</span>
														<small class="old-price text-right mx-2" style="color: #ff6600;">${this.mrp}</small>
													</div>
												</div>
												<div class="d-flex justify-content-between align-items-center pt-1">
													<div>
														${ratingHTML}
													</div>
													<button class="text-center card_buy_btn btn-radious" type="button" onclick="add_to_cart_product(event, '${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}', '1', '0', '2', '${qoute_id}')">Add To Cart</button>
												</div>
											</div>
										</div>
									</a>
								</div>`;

					/*product_html0 += '<div class="card"><div class="card-img zoom-img"><a href="' +
										site_url +
										this.web_url +
										"?pid=" +
										this.id +
										"&sku=" +
										this.sku +
										"&sid=" +
										this.vendor_id +
										'" ><img src="' +
										this.imgurl +
										'" class="card-img-top" alt="'+this.name +'" /></a><div class="favorite"><a onclick="add_to_wishlist(event,' +
										"'" +
										this.id +
										"','" +
										this.sku +
										"','" +
										this.vendor_id +
										"','" +
										user_id +
										"','1','0','2'," +
										"'" +
										qoute_id +
										"'" + ')" href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div></div><div class="card-body"><a href="' +
										site_url +
										this.web_url +
										"?pid=" +
										this.id +
										"&sku=" +
										this.sku +
										"&sid=" +
										this.vendor_id +
										'" ><h6 class="pd-title">' +
										this.name +
										'</h6></a><div class="row"><div class="col-6"><h6 class="old-price">' + this.mrp + '</h6><h5 class="new-price">' + this.price + '</h5></div><div class="col-6">';
		
		
										if(type == 'Custom')
										{
										
											product_html += '<div class="btn-by-now text-end" style="margin-left:-5px;"><a target="_blank" href="https://api.whatsapp.com/send?phone=%2B91' + whatsapp_number + '&text=hi"  class="btn btn-success text-light">Whatsapp</a></div>';
		
										}
										else
										{
		
		
											product_html +='<div class="btn-by-now text-end"><a href="#" onclick="add_to_cart_product_buy(event,' +
											"'" +
											this.id +
											"','" +
											this.sku +
											"','" +
											this.vendor_id +
											"','" +
											user_id +
											"','1','0','2'," +
											"'" +
											qoute_id +
											"'" +
											')" class="btn btn-default">Buy Now</a></div>';
						
										}
		
										
										product_html +='</div></div></div></div>';*/

				});
			} else {
			}
			$("#" + type + "_products").html(product_html);
			$('.slider-trending_' + type).slick({
				slidesToShow: 17,
				slidesToScroll: 1,
				arrows: true,
				infinite: false,
				autoplay: false,
				responsive: [{
					breakpoint: 4499,
					settings: {
						slidesToShow: 12,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 2999,
					settings: {
						slidesToShow: 10,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 2499,
					settings: {
						slidesToShow: 8,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 2299,
					settings: {
						slidesToShow: 7,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 1999,
					settings: {
						slidesToShow: 6,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 1799,
					settings: {
						slidesToShow: 5,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 1499,
					settings: {
						slidesToShow: 5,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 1199,
					settings: {
						slidesToShow: 4,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 767,
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
					// You can unslick at a given breakpoint now by adding:
					// settings: "unslick"
					// instead of a settings object
				]
			});
		},
	});
}

function get_home_bottom_banner() {
	$.ajax({
		method: "get",
		url: site_url + "get_home_bottom_banner",
		data: { [csrfName]: csrfHash },
		success: function (response) {
			var parsedJSON = JSON.parse(response);
			var order = parsedJSON.length;
			var product_html = "";
			var count = 1;
			if (order != 0) {
				$("#home_bottom_banner").empty();
				$(parsedJSON).each(function () {
					product_html +=
						`<div onclick="redirect_to_link('${this.link}')" class="a-Masonry-${count}"><img src="${this.image}" alt="${website_name}" /></div>`;
					count++;
				});
			} else {
				// product_html = "No Record Found.";
			}
			$("#home_bottom_banner").html(product_html);
			document.querySelectorAll('img').forEach(image => { image.src = image.src.replace('-610-400', '') });
		},
	});
}

function get_home_small_banner(type, size) {
	$.ajax({
		method: "get",
		url: site_url + "get_home_small_banner",
		data: { [csrfName]: csrfHash, type: type, size: size },
		success: function (response) {
			var parsedJSON = JSON.parse(response);
			var order = parsedJSON.length;
			var product_html = "";
			var count = 1;
			if (order != 0) {
				$("#" + type + "_banner").empty();
				$(parsedJSON).each(function () {
					if (this.image == 'https://www.mbznesshub.com/media/') {
						product_html += '';
					}
					else {
						product_html += '<div onclick="redirect_to_link(' + this.link + ')" class="a-homeOffers mb-5" style=""><img src="' + this.image + '" class="img-fluid" alt="' + website_name + '" srcset="" 	style="object-fit: fill; width: 100%; border-radius: 8px;"></div>';
						count++;
					}

				});
			} else {
			}
			$("#" + type + "_banner").html(product_html);
			document.querySelectorAll('img').forEach(image => { image.src = image.src.replace('-1930-150', '') });
			document.querySelectorAll('img').forEach(image => { image.src = image.src.replace('-1900-320', '') });
		},
	});
}




