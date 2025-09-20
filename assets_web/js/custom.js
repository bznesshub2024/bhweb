$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  if (scroll > 120) {
    $("#btn-mb").addClass("active");
  }
  else {
    $("#btn-mb").removeClass("active");
  }
});


$("#sliderModal").on('hidden.bs.modal', function (e) {
  $("#sliderModal iframe").attr("src", $("#sliderModal iframe").attr("src"));
});


$(document).ready(function () {
  $('.minus').click(function () {
    var $input = $(this).parent().find('input');
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    return false;
  });
  $('.plus').click(function () {
    var $input = $(this).parent().find('input');
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
  });
});

/*--------------------------------------*/

/*4. Multistep Form */
/*--------------------------------------*/
$(document).ready(function () {
  var current_fs, next_fs, previous_fs; //fieldsets
  var opacity;
  var current = 1;
  var steps = $("fieldset").length;

  setProgressBar(current);
	var  gst_div = $('#gst_div').val();

	$("#seller_type").change(function(){
		  var seller_type = $('#seller_type').val();
		if(seller_type == 'Street Merchant')
		{
			$('#plan_div').show();
			$('#gst_div').hide();
			$('#plan_all_div').hide();
			
		}
		else
		{
			$('#plan_div').hide();
			$('#plan_all_div').show();
			$('#gst_div').show();
		}
		
		
	});
	
	

 
  $(".seller_form").click(function () {
    if (validateSellerForm()) {
      current_fs = $(this).parent();
      next_fs = $(this).parent().next();

      //Add Class Active
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      //show the next fieldset
      next_fs.show();
      //hide the current fieldset with style
      current_fs.animate(
        { opacity: 0 },
        {
          step: function (now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
              display: "none",
              position: "relative"
            });
            next_fs.css({ opacity: opacity });
          },
          duration: 500
        }
      );
      setProgressBar(++current);
    }
  });

  $(".seller_desc").click(function () {
    if (validateSellerDescriptionForm()) {
      current_fs = $(this).parent();
      next_fs = $(this).parent().next();

      //Add Class Active
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      //show the next fieldset
      next_fs.show();
      //hide the current fieldset with style
      current_fs.animate(
        { opacity: 0 },
        {
          step: function (now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
              display: "none",
              position: "relative"
            });
            next_fs.css({ opacity: opacity });
          },
          duration: 500
        }
      );
      setProgressBar(++current);
    }
  });

  $(".seller_info").click(function () {
	if (validateSellerInfoForm()) {  	 
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();

		//Add Class Active
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

		//show the next fieldset
		next_fs.show();
		//hide the current fieldset with style
		current_fs.animate(
		  { opacity: 0 },
		  {
			step: function (now) {
			  // for making fielset appear animation
			  opacity = 1 - now;

			  current_fs.css({
				display: "none",
				position: "relative"
			  });
			  next_fs.css({ opacity: opacity });
			},
			duration: 500
		  }
		);
		setProgressBar(++current);
	}
  });
  
  $(".seller_doc").click(function () {
	if (validateSellerDocForm()) {  	 
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();

		//Add Class Active
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

		//show the next fieldset
		next_fs.show();
		//hide the current fieldset with style
		current_fs.animate(
		  { opacity: 0 },
		  {
			step: function (now) {
			  // for making fielset appear animation
			  opacity = 1 - now;

			  current_fs.css({
				display: "none",
				position: "relative"
			  });
			  next_fs.css({ opacity: opacity });
			},
			duration: 500
		  }
		);
		setProgressBar(++current);
	}
  });

  $(".previous").click(function () {
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //Remove class active
    $("#progressbar li")
      .eq($("fieldset").index(current_fs))
      .removeClass("active");

    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate(
      { opacity: 0 },
      {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            display: "none",
            position: "relative"
          });
          previous_fs.css({ opacity: opacity });
        },
        duration: 500
      }
    );
    setProgressBar(--current);
  });

  function setProgressBar(curStep) {
    var percent = parseFloat(100 / steps) * curStep;
    percent = percent.toFixed();
    $(".progress-bar").css("width", percent + "%");
  }

  $(".submit").click(function () {
    return false;
  });
});

/*--------------------------------------*/

const validateSellerForm = () => {
  const seller_form = document.getElementById('seller_form');
  const seller_name = seller_form.querySelector('#seller_name');
  const business_name = seller_form.querySelector('#business_name');
  const business_address = seller_form.querySelector('#business_address');
  const business_details = seller_form.querySelector('#business_details');
  const tax_number = seller_form.querySelector('#tax_number');
  const seller_type = seller_form.querySelector('#seller_type');
  const selectplan = seller_form.querySelector('#selectplan');

  var flag_seller_name = false;
  var flag_business_name = false;
  var flag_business_address = false;
  var flag_business_details = false;
  var flag_tax_number = false;


if (seller_type.value == 'Street Merchant') {
        flag_tax_number = true;
		
	 } else {
		flag_tax_number = false;
		if(tax_number.value == '')
		{
			flag_tax_number = false;
			setErrorMsg(tax_number, '<i class="fa-solid fa-circle-xmark"></i> GST Number is required.');
		}
		else
		{
			setSuccessMsg(tax_number);
			flag_tax_number = true;
		}
			
	}


  if (seller_name.value === '') {
    flag_seller_name = false;
    setErrorMsg(seller_name, '<i class="fa-solid fa-circle-xmark"></i> Seller name is required.');
  } else {
    flag_seller_name = true;
    setSuccessMsg(seller_name);
  }

  if (business_name.value === '') {
    flag_business_name = false;
    setErrorMsg(business_name, '<i class="fa-solid fa-circle-xmark"></i> Shop name is required.');
  } else {
    flag_business_name = true;
    setSuccessMsg(business_name);
  }

  if (business_address.value === '') {
    flag_business_address = false;
    setErrorMsg(business_address, '<i class="fa-solid fa-circle-xmark"></i> Shop address is required.');
  } else {
    flag_business_address = true;
    setSuccessMsg(business_address);
  }

  if (business_details.value === '') {
    flag_business_details = false;
    setErrorMsg(business_details, '<i class="fa-solid fa-circle-xmark"></i> Shop details is required.');
  } else {
    flag_business_details = true;
    setSuccessMsg(business_details);
  }

  if (flag_seller_name == true && flag_business_name == true && flag_business_address == true && flag_business_details == true && flag_tax_number == true) {
    return true;
  } else {
    return false;
  }
}

const validateSellerDescriptionForm = () => {
  const seller_desc = document.getElementById('seller_desc');
  const selectstate = seller_desc.querySelector('#selectstate');
  const selectcity = seller_desc.querySelector('#selectcity');
  const pincode = seller_desc.querySelector('#pincode');

  var flag_selectstate = false;
  var flag_selectcity = false;
  var flag_pincode = false;

  if (selectstate.value == '') {
    flag_selectstate = false;
    setErrorMsg(selectstate, '<i class="fa-solid fa-circle-xmark"></i> State is required.');
  } else {
    flag_selectstate = true;
    setSuccessMsg(selectstate);
  }

  if (selectcity.value == '') {
    flag_selectcity = false;
    setErrorMsg(selectcity, '<i class="fa-solid fa-circle-xmark"></i> City is required.');
  } else {
    flag_selectcity = true;
    setSuccessMsg(selectcity);
  }

  if (pincode.value == '') {
    flag_pincode = false;
    setErrorMsg(pincode, '<i class="fa-solid fa-circle-xmark"></i> Pincode is required.');
  } else if (pincode.value.length < 6) {
    flag_pincode = false;
    setErrorMsg(pincode, '<i class="fa-solid fa-circle-xmark"></i> Add Valid Pincode.');
  } else {
    flag_pincode = true;
    console.log(pincode.value);
    setSuccessMsg(pincode);
  }
  
  
  if (flag_selectstate == true && flag_selectcity == true && flag_pincode == true) {
    return true;
  } else {
    return false;
  }
}

const validateSellerInfoForm = () => {
  const seller_info = document.getElementById('seller_info');
  const email = seller_info.querySelector('#emails');
  const phone = seller_info.querySelector('#phone');

  var flag_email = false;
  var flag_phone = false;

 
  
  if (email.value == '') {
    flag_email = false;
    setErrorMsg(email, '<i class="fa-solid fa-circle-xmark"></i> Email is required.');
  } else {
		if (IsEmail(email.value) === false) {
			flag_email = false;
			setErrorMsg(email, '<i class="fa-solid fa-circle-xmark"></i> Add Valid Email.');		
		}
		else
		{
		   flag_email = true;
		   setSuccessMsg(email);
		}
  } 
  
  if (phone.value == '') {
    flag_phone = false;
    setErrorMsg(phone, '<i class="fa-solid fa-circle-xmark"></i> Phone is required.');
  } else {
    flag_phone = true;
    setSuccessMsg(phone);
  }
  

  if (flag_email == true && flag_phone == true) {
    return true;
  } else {
    return false;
  }
}

const validateSellerDocForm = () => {
  const seller_doc = document.getElementById('seller_doc');
  const myCheckbox = seller_info.querySelector('#myCheckbox');

  var flag_myCheckbox = false;

 
  
  if (myCheckbox.value == '') {
    flag_myCheckbox = false;
    setErrorMsg(myCheckboxmyCheckbox, '<i class="fa-solid fa-circle-xmark"></i> Select Term & Conditions is required.');
  } else {
    flag_myCheckbox = true;
    setSuccessMsg(myCheckbox);
  }
  

  if (flag_myCheckbox == true) {
    return true;
  } else {
    return false;
  }
}

function IsEmail(email) {
		const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regex.test(email)) {
			return false;
		}
		else {
			return true;
		}
}


function setErrorMsg(ele, errormsgs) {
  const formGroup = ele.parentElement;
  const formInput = formGroup.querySelector('.form-control');
  console.log(formInput);
  const span = formGroup.querySelector('#error');
  span.innerHTML = errormsgs;
  formInput.className = "form-control is-invalid";
  span.className = "invalid-feedback text-start fw-bolder";
}

function setSuccessMsg(ele) {
  const formGroup = ele.parentElement;
  const formInput = formGroup.querySelector('.form-control');
  formInput.className = "form-control success";
}




