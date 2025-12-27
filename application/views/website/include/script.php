<script src="<?php echo base_url; ?>assets_web/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url; ?>assets_web/js/spotlight.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets_web/js/sweetalert2.min.js"></script>
<script src="<?php echo base_url; ?>assets_web/js/jquery.min.js"></script>
<script src="<?php echo base_url; ?>assets_web/js/slick.min.js"></script>
<script src="<?php echo base_url; ?>assets_web/js/global.js"></script>
<script src="<?php echo base_url(); ?>assets_web/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets_web/js/toastify.js"></script>


<script>
  setTimeout(function() {
    $('.loaderScreen').css('display', 'none');
  }, 1000);

  document.querySelectorAll('img').forEach(image => {
    image.src = image.src.replace('-430-590', '')
  });
  document.querySelectorAll('img').forEach(image => {
    image.src = image.src.replace('-1930-150', '')
  });
  document.querySelectorAll('img').forEach(image => {
    image.src = image.src.replace('-1900-320', '')
  });

  var csrfName = $(".txt_csrfname").attr("name"); //
  var csrfHash = $(".txt_csrfname").val(); // CSRF hash
  var site_url = $(".site_url").val(); // CSRF hash

  $("main").attr("id", "common-class");


  function redirect_to_link(link) {
    location.href = link;
  }

  $(document).on('keyup', '#search', function() {

    $("#search_div").html('');
    $("#search_div_mob").html('');
    var search = $(this).val();
    $.ajax({
      method: "get",
      url: site_url + "get_search_products",
      data: {
        search: search,
        [csrfName]: csrfHash
      },
    }).done(function(response) {

      var parsedJSON = JSON.parse(response);
      var product_html = "";
      var counter = 1;

      $(parsedJSON).each(function() {




        product_html += '<li><a class="dropdown-item" href="' +
          site_url + 
		  "product/" +
          this.web_url +
          '"><div class="card search-card"><div class="d-flex "><div class="d-flex-center search-card_image" style="background-image: url(' + site_url + '/media/' + this.imgurl + ');"></div><div class="w-100"><div class="card-body py-2 h-100 d-flex flex-column justify-content-evenly"><div class="w-100 d-flex justify-content-between"><h6 class="card-title">' + this.name + '</h6></div><p class="card-text"><small class="text-muted">' + this.price + '</small></p></div></div></div></div></a></li>';

        if (counter == 5) {
          return false;
        } else {
          counter++;
        }

      });
      product_html += '<li><a class="dropdown-item text-primary fw-bold text-center" href="' + site_url + '/search/s?search=' + search + '">See All</a></li>';
      $("#search_div").html(product_html);
      $("#search_div_mob").html(product_html);



    }).fail(function() {
      console.log('Failed');
    });

  });

  wishlist_count();
  wishlist_count();

  wishlist_count();

  function wishlist_count()

  {

    var csrfName = $('.txt_csrfname').attr('name'); // 

    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

    var site_url = $('.site_url').val(); // CSRF hash



    $.ajax({

      method: 'get',

      url: site_url + 'wishlist_count',

      data: {



        [csrfName]: csrfHash

      },

      success: function(response) {

        $('#wishlist_count').html(response);



      }

    });



  }


  addto_cart_count();
  addto_cart_count();

  addto_cart_count();

  function addto_cart_count()

  {

    var csrfName = $('.txt_csrfname').attr('name'); // 

    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

    var site_url = $('.site_url').val(); // CSRF hash



    $.ajax({

      method: 'get',

      url: site_url + 'cart_count',

      data: {



        [csrfName]: csrfHash

      },

      success: function(response) {

        //hideloader();

        $('#cart_count').html(response);
        // if (response >= 10) {
          // $('#badge-cart-count').css('padding', '2.5px 5px');
        // } else {
          // $('#badge-cart-count').css('padding', '0.5px 5px');
        // }
        $('#badge-cart-count').html(response);

        //alert(response);

        //$('#cart_msg').html(response.msg);

        // $('#id01').show();

        //alert(response.msg);

      }

    });





  }



  function add_to_cart_product(event, pid, sku, vendor_id, user_id, qty, referid, devicetype, qouteid) {

    event.preventDefault();

    var csrfName = $('.txt_csrfname').attr('name'); // 

    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

    var site_url = $('.site_url').val(); // CSRF hash

    if (user_id == '')

    {
	$("#loginModal").modal("show")
      //alert('Please login to add product into Cart');

     /* Swal.fire({

        position: "center",

        //icon: "success",

        title: 'Please login to add product into Cart',

        showConfirmButton: false,

        confirmButtonColor: '#f42525',

        timer: 3000

      })

      setTimeout(function() {

        window.location.href = site_url + 'login';

      }, 2000);*/





    } else

    {

      $.ajax({

        method: 'post',

        url: site_url + 'addProductCart',

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

        success: function(response) {

          //hideloader();

          addto_cart_count();

          //alert(response.msg);

          if (response.msg == 'Please select color / size')

          {

            location.href =

				  site_url +

				  "product/" +

				  sku 

				;
			
			

          }

          Swal.fire({

            position: "center",

            // icon: "success",

            title: response.msg,

            showConfirmButton: true,

            confirmButtonColor: '#f42525',

            confirmButtonText: 'View Cart',

            timer: 3000

          }).then((result) => {

            if (result.isConfirmed) {

              window.location = site_url + "cart";

            }

          })

          //location.href = site_url + "cart";

          //$('#cart_msg').html(response.msg);

          // $('#id01').show();

          //alert(response.msg);

        }

      });

    }

  }

  function delete_cart_before_buy(user_id, qouteid) {
    $.ajax({
      method: "post",
      url: site_url + "deleteProductCart_buynow",
      data: {
        language: default_language,
        devicetype: 2,
        user_id: user_id,
        qouteid: qouteid,
        [csrfName]: csrfHash,
      },
      success: function(response) {

        //alert(response);

      },
    })
  }

  function view_subcat(cat_id) {
    let ids = document.getElementById(`link_underline${cat_id}`);
    let contents = document.querySelectorAll(".menu-item-top");
    // console.log(contents[2]);
    if (contents.length > 0) {
      for (const content of contents) {
        content.classList.remove('link_underline');
      }
    }
    $.ajax({
      method: "get",
      url: site_url + "getsubcatdata",
      data: {
        language: default_language,
        devicetype: 2,
        cat_id: cat_id,
        [csrfName]: csrfHash,
      },
      success: function(response) {

        var parsedJSON = JSON.parse(response);
        var subcat_html = "";
        let div_count = 0;
        $(parsedJSON).each(function() {
          // ids.classList.remove('link_underline');
          subcat_html += '<li class="menu-li"><a href="' + site_url + this.cat_slug + '" class="menu-item py-3">' + this.cat_name + ' <svg id="down_arrow_navbar" class="bob-down-arrow-svg" xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 13.088 7.731" fill="#162b75"><path d="M12.879,101.344l-.429-.432a.718.718,0,0,0-1.013,0L6.547,105.8l-4.9-4.9a.718.718,0,0,0-1.013,0l-.429.429a.717.717,0,0,0,0,1.012l5.83,5.851a.732.732,0,0,0,.508.23h0a.732.732,0,0,0,.506-.23l5.824-5.835a.727.727,0,0,0,0-1.02Z" transform="translate(0 -100.698)"></path></svg></a>';

          subcat_html += '<div class="mega-menu" style="width: 100vw;"><div class="content box-shadow-0"><div class="d-flex w-100 p-10 row_container_nav_items">';
          if (this.subcat_1.length > 0) {
            $(this.subcat_1).each(function() {
              subcat_html += '<div class="bg-white w-100" style="padding: 20px;"><div class="col px-2 py-4"><section><a ';
			  if(this.subsubcat_2 == 0)
			  {
				subcat_html += 'href="' + site_url + 'sub-category/' + this.cat_slug + '"';
			  }
			  else
			  {
				 subcat_html += 'href="' + site_url + this.cat_slug + '"';
			  }
			  subcat_html += '>' + this.cat_name + '</a><ul class="mega-links px-0">';
              $(this.subsubcat_2).each(function() {
                subcat_html += '<li><a href="' + site_url + 'sub-category/' + this.cat_slug + '">' + this.cat_name + '</a></li>';
              });
              subcat_html += '</ul></section></div></div>';
            });

          }
          subcat_html += '</div></div></div></li>';
          div_count = "link_underline" + cat_id;

          localStorage.setItem("curr_underline_link", div_count)
          localStorage.setItem("cat_id",cat_id)
        });

        if (subcat_html == '') {
          subcat_html += '<li class="menu-li">  </li>';
        }
        $("#subcats").html(subcat_html);
        
        if (localStorage.getItem("curr_underline_link")) {
          ids.classList.add('link_underline');
          console.log("TRUE");
        } else {
          console.log("FALSE")
        }
      },
    });
  }

  window.addEventListener("load", function() {
    let current_link = localStorage.getItem("curr_underline_link");
    if (current_link) {
      document.getElementById(current_link).classList.add("link_underline");
    } else {
      localStorage.setItem("curr_underline_link", "link_underline1")
      localStorage.setItem("cat_id",1)
    }
    view_subcat(localStorage.getItem("cat_id"))
  });

  function add_to_cart_product_buy(event, pid, sku, vendor_id, user_id, qty, referid, devicetype, qouteid) {

    event.preventDefault();

    var csrfName = $('.txt_csrfname').attr('name'); // 

    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

    var site_url = $('.site_url').val(); // CSRF hash

    /*delete_cart_before_buy(user_id, qouteid);*/



    var qty = 1;

    if (user_id == '')

    {

      //alert('Please login to add product into Cart');

      Swal.fire({

        position: "center",

        //icon: "success",

        title: 'Please login to add product into Cart',

        showConfirmButton: false,

        confirmButtonColor: '#f42525',

        timer: 3000

      });
    } else if (qty == '')

    {

      Swal.fire({

        position: "center",

        //icon: "success",

        title: "Please Select Qty",

        showConfirmButton: true,

        confirmButtonText: "ok",

        confirmButtonColor: "#f42525",

        timer: 3000,

      });

    } else

    {

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

        success: function(response) {

          //hideloader();

          /*alert(response.msg)*/

          addto_cart_count();

          if (response.msg == 'Please select color / size' || response.msg == 'Product is out of stock')

          {

            location.href = site_url + sku + "?pid=" + pid + "&sku=" + sku + "&sid=" + vendor_id;
            /*Swal.fire({

              position: "center",

              //icon: "success",

              title: 'Please Select Color/Size',

              showConfirmButton: false,

              confirmButtonColor: '#f42525',

              timer: 3000

            });*/

          } else {

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

  function AllowOnlyNumbers(e) {

    e = (e) ? e : window.event;
    var clipboardData = e.clipboardData ? e.clipboardData : window.clipboardData;
    var key = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
    var str = (e.type && e.type == "paste") ? clipboardData.getData('Text') : String.fromCharCode(key);

    return (/^\d+$/.test(str));
  }

  function call_register() {

 

$("#reg_ver").hide();
    // alert("call");
    var phonev = $("#mobileno").val();
    var fullname = $("#fullname").val();
    var refer_code = $("#refer_code").val();
    //  alert("phone  "+phonev+"---"+namev+ "===="+phonev.length);

    if (fullname == "" || fullname == null) {

      $("#fullname_error").text("Full Name is Empty");

    } else {

      $("#fullname_error").text("");

    }

    if (phonev == "" || phonev == null) {

      $("#phonev_error").text("Phone Number is Empty");

    } else {

      $("#phonev_error").text("");

    }
    if (phonev.length != 10) {

      $("#phonev_error").text("Invalid Phone Number");

    } else {

      $("#phonev_error").text("");

    }

    /*alert('out');*/
    if (fullname != "" && phonev != "") {
      /* alert('in');*/


      $.ajax({
        method: 'POST',
        url: site_url + 'signup',
        //url: 'https://fleekmart.com/API/index.php/auth/signup',
        headers: {
          'X-API-KEY': 'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: default_language,
          devicetype: "1",
          phone: phonev,
          user_name: fullname,
          refer_code: refer_code,
          [csrfName]: csrfHash,

        },
        success: function(response) {
         // console.log(response);
          //$('#otp').val(response.Information.otp);
          //alert("response is "+response);
          var abc = response;
          ////alert("status is " + abc.msg);
          if (abc.status == 1) {
            // show otp verify div
            $("#reg_ver").show();
            $('.aa-myaccount-login').hide();
            $('.aa-myaccount-otp').show();

          } else {
            //$('.aa-myaccount-otp').show();
            alert(abc.msg);
          }

        },
        error: function(data) {
          //debugger;
          //alert("Error");
        }
      });

    }
  }

  function call_register_mob() {
    // alert("call");
    var phonev = $("#mobileno1").val();
    var fullname = $("#fullname1").val();
    var refer_code = $("#refer_code1").val();
    //  alert("phone  "+phonev+"---"+namev+ "===="+phonev.length);

    if (fullname == "" || fullname == null) {

      $("#fullname1_error").text("Full Name is Empty");

    } else {

      $("#fullname1_error").text("");

    }

    if (phonev == "" || phonev == null) {

      $("#phonev1_error").text("Phone Number is Empty");

    } else {

      $("#phonev1_error").text("");

    }
    if (phonev.length != 10) {

      $("#phonev1_error").text("Invalid Phone Number");

    } else {

      $("#phonev1_error").text("");

    }

    /*alert('out');*/
    if (fullname != "" && phonev != "") {
      /* alert('in');*/


      $.ajax({
        method: 'POST',
        url: site_url + 'signup',
        //url: 'https://fleekmart.com/API/index.php/auth/signup',
        headers: {
          'X-API-KEY': 'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: default_language,
          devicetype: "1",
          phone: phonev,
          user_name: fullname,
          refer_code: refer_code,
          [csrfName]: csrfHash,

        },
        success: function(response) {
          console.log(response);
          $('#otp1').val(response.Information.otp);
          //alert("response is "+response);
          var abc = response;
          ////alert("status is " + abc.msg);
          if (abc.status == 1) {
            // show otp verify div
            $('.aa-myaccount-login').hide();
            $('.aa-myaccount-otp').show();

          } else {
            //$('.aa-myaccount-otp').show();
            alert(abc.msg);
          }

        },
        error: function(data) {
          //debugger;
          //alert("Error");
        }
      });

    }
  }


  function verify_otp() {


    var phonev = $("#mobileno").val();
    var fullname = $("#fullname").val();
    var refer_code = $("#refer_code").val();
    //var otpv = $("#otp").val();

    const inputs = document.querySelectorAll('.si_otp');


var otpv = '';
inputs.forEach(input => {
    otpv += input.value;
});

    var qouteidv = "";
    //alert("phone  "+phonev+"---"+namev+ "===="+phonev.length);
    if (fullname == "" || fullname == null) {

      $("#fullname_error").text("Full Name is Empty");
    } else if (phonev == "" || phonev == null) {

      $("#phonev_error").text("Phone Number is Empty");

    } else if (phonev.length != 10) {

      $("#phonev_error").text("Invalid Phone Number");
    } else {
      $.ajax({
        method: 'POST',
        url: site_url + 'verify_otp',
        // url: 'https://fleekmart.com/API/index.php/auth/verify_otp',
        headers: {
          'X-API-KEY': 'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype: "1",
          phone: phonev,
          otp: otpv,
          fullname: fullname,
          qouteid: qouteidv,
          user_name: fullname,
          refer_code: refer_code,
          [csrfName]: csrfHash,
        },
        success: function(response) {
          console.log(response);
          if (response.msg == 'Login successfully') {
            //alert(response.msg);
            location.href = site_url;
          } else {
            $("#error_msg_reg").html(response.msg);
            /*alert(response.msg);*/
          }
          //location.href=site_url+'login';
          //alert("response is " + response);
          // var parsedJSON = jQuery.parseJSON(response ); //JSON.parse(response);
          //   alert("status is" +parsedJSON );

        },
      });

    }
  }

  function verify_otp_mob() {

    var phonev = $("#mobileno1").val();
    var fullname = $("#fullname1").val();
    var refer_code = $("#refer_code1").val();
    var otpv = $("#otp1").val();
    var qouteidv = "";
    //alert("phone  "+phonev+"---"+namev+ "===="+phonev.length);
    if (fullname == "" || fullname == null) {

      $("#fullname1_error").text("Full Name is Empty");
    } else if (phonev == "" || phonev == null) {

      $("#phonev1_error").text("Phone Number is Empty");

    } else if (phonev.length != 10) {
      $("#phonev1_error").text("Invalid Phone Number");
    } else {
      $.ajax({
        method: 'POST',
        url: site_url + 'verify_otp',
        // url: 'https://fleekmart.com/API/index.php/auth/verify_otp',
        headers: {
          'X-API-KEY': 'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype: "1",
          phone: phonev,
          otp: otpv,
          fullname: fullname,
          qouteid: qouteidv,
          user_name: fullname,
          refer_code: refer_code,
          [csrfName]: csrfHash,
        },
        success: function(response) {
          console.log(response);
          if (response.msg == 'Login successfully') {
            //alert(response.msg);
            location.href = site_url;
          } else {
            $("#error_msg_reg1").html(response.msg);
            /*alert(response.msg);*/
          }
          //location.href=site_url+'login';
          //alert("response is " + response);
          // var parsedJSON = jQuery.parseJSON(response ); //JSON.parse(response);
          //   alert("status is" +parsedJSON );

        },
      });

    }
  }



  function call_login_otp() {
    var phonev = $("#log_mobileno").val();
    var otp_login = $("#otp_login").val();
    var pass = $("#password").val();

    var qouteid = '';

    if (phonev == "" || phonev == null) {

      $("#phonev_errors0").text("Pnone No is Empty");

    } else {
      $("#phonev_errors0").text("");
    }

    if (phonev != "") {

      $.ajax({
        method: 'POST',
        url: site_url + 'user_login',
        headers: {
          'X-API-KEY': 'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype: "1",
          phone: phonev,
          otp_login: otp_login,
          qouteid: qouteid,
          [csrfName]: csrfHash

        },
        success: function(response) {


          if (response.msg == 'Login successfully') {
            window.location.href = site_url;
          } else {
            $("#error_msg").html(response.msg);

          }

        },


      });

    }

  }


const inputs = document.querySelectorAll('.otp-box');
inputs.forEach((input, index) => {
  input.addEventListener('input', () => {
    if (input.value.length === 1 && index < inputs.length - 1) {
      inputs[index + 1].focus();
    }
  });

  input.addEventListener('keydown', (e) => {
    if (e.key === 'Backspace' && !input.value && index > 0) {
      inputs[index - 1].focus();
    }
  });
});

// function submitOTP() {
//   let otp = '';
//   inputs.forEach(input => otp += input.value);
//   alert("OTP Entered: " + otp);
// }

  function call_login_otp_mob() {
  const inputs = document.querySelectorAll('.otp-box');

    var phonev = $("#log_mobileno1").val();

    var otp_login = '';
    inputs.forEach(input => {
        otp_login += input.value;
    });
    var pass = $("#password").val();
// console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>',otp_login)
    var qouteid = '';

    if (phonev == "" || phonev == null) {

      $("#phonevl_errors").text("Pnone No is Empty");

    } else {
      $("#phonevl_errors").text("");
    }

    if (phonev != "") {

      $.ajax({
        method: 'POST',
        url: site_url + 'user_login',
        headers: {
          'X-API-KEY': 'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype: "1",
          phone: phonev,
          otp_login: otp_login,
          qouteid: qouteid,
          [csrfName]: csrfHash

        },
        success: function(response) {


          if (response.msg == 'Login successfully') {
            window.location.href = site_url;
          } else {
            $("#error_msg1").html(response.msg);

          }

        },


      });

    }

  }


  function call_login() {
    var phonev = $("#log_mobileno").val();
    var pass = $("#password").val();

    var qouteid = '';

    if (phonev == "" || phonev == null) {

      $("#phonev_errors0").text("Pnone No is Empty");

    } else {
      $("#phonev_errors0").text("");
    }

    if (phonev != "") {

      $.ajax({
        method: 'POST',
        url: site_url + 'login_otp',
        headers: {
          'X-API-KEY': 'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype: "1",
          phone: phonev,
          qouteid: qouteid,
          [csrfName]: csrfHash

        },
        success: function(response) {

          if (response.msg == 'User not exist') {
            $("#phonev_errors0").html('Please Signup');
          } else {
            /*$("#enterNumberLogin").removeClass("d-flex");
              $("#enterNumberLogin").addClass("d-none");
              $("#enterOtpLogin").removeClass("d-none");
              $("#enterOtpLogin").addClass("d-flex");*/
            $('#otp_login').val(response.Information.otp);

          }
          if (response.msg == 'Login successfully') {
            window.location.href = site_url;
          } else {
            $("#error_msg").html(response.msg);

          }

        },


      });

    }

  }

  function call_login_mob() {
    var phonev = $("#log_mobileno1").val();
    var pass = $("#password").val();

    $("#login_ver").hide();

    var qouteid = '';

    if (phonev == "" || phonev == null) {

      $("#phonevl_errors").text("Pnone No is Empty");

    } else {
      $("#phonevl_errors").text("");
    }

    if (phonev != "") {

      $.ajax({
        method: 'POST',
        url: site_url + 'login_otp',
        headers: {
          'X-API-KEY': 'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype: "1",
          phone: phonev,
          qouteid: qouteid,
          [csrfName]: csrfHash

        },
        success: function(response) {

          if (response.msg == 'User not exist') {
            $("#phonevl_errors").html('Please Signup');
          } else {
            $("#login_ver").show();
            /*$("#enterNumberLogin").removeClass("d-flex");
              $("#enterNumberLogin").addClass("d-none");
              $("#enterOtpLogin").removeClass("d-none");
              $("#enterOtpLogin").addClass("d-flex");*/
           // $('#otp_login1').val(response.Information.otp);

          }
          if (response.msg == 'Login successfully') {
            window.location.href = site_url;
          } else {
            $("#error_msg").html(response.msg);

          }

        },


      });

    }

  }


  function add_to_wishlist(event, pid, sku, vendor_id, user_id, qty, referid, devicetype) {

    event.preventDefault();

    if (user_id == '')

    {

      //alert('please login to add product into wishlist');

      Swal.fire({

        position: "center",

        //icon: "success",

        title: 'Please login to add product into wishlist',

        showConfirmButton: false,

        confirmButtonColor: '#f42525',

        timer: 300000

      })

    }

    var csrfName = $('.txt_csrfname').attr('name'); // 

    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

    var site_url = $('.site_url').val(); // CSRF hash

    $.ajax({

      method: 'post',

      url: site_url + 'addProductWishlist',

      data: {

        language: 1,

        pid: pid,

        sku: sku,

        sid: vendor_id,

        user_id: user_id,

        qty: qty,

        referid: referid,

        devicetype: 2,

        [csrfName]: csrfHash

      },

      success: function(response) {

        wishlist_count();
		
		if(response.status == 1)
		{
			Toastify({
				text: response.msg,
				duration: 1500,
				newWindow: false,
				close: false,
				gravity: "bottom",
				position: "center",
				stopOnFocus: true,
				style: {
					background: "linear-gradient(to right, #ff6600, #ff6600)",
				},
				onClick: function() {}
			}).showToast();
		}

     location.reload();

	
      }

    });

  }



  function subscriber_form()

  {

    event.preventDefault();

    var csrfName = $('.txt_csrfname').attr('name'); // 

    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

    var site_url = $('.site_url').val(); // CSRF hash



    var sub_email = $('#sub_email').val();



    if (sub_email != '')

    {

      $.ajax({

        method: 'post',

        url: site_url + 'send_subscriber',

        data: {
          sub_email: sub_email,
          [csrfName]: csrfHash
        },

        success: function(response) {

          //hideloader();

          alert(response);

          location.reload();



        }

      });

    } else

    {

      alert('Please Add Emails Address ?');

    }

  }
</script>