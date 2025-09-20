window.addEventListener("load", () => {
  $("#loader").fadeOut("slow");
});


function copy_code_link() {
	event.preventDefault();

	var copyText = document.getElementById("myCodes");
	copyText.select();
	copyText.setSelectionRange(0, 99999);

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


/* var offcanvasMarurang = document.getElementById('offcanvasMarurang')
offcanvasMarurang.addEventListener('shown.bs.offcanvas', function () {
  document.getElementsByClassName('top-bar')[0].style.cssText = "opacity: 0.4;";
  document.getElementsByClassName('navbar')[0].style.cssText = "opacity: 0.4;";
  document.getElementById('common-class').style.cssText = "opacity: 0.4;";
  document.getElementsByClassName('a-mobileNav')[0].style.cssText = "background-color : #f1f1f1 !important;";
})
offcanvasMarurang.addEventListener('hidden.bs.offcanvas', function () {
  document.getElementsByClassName('top-bar')[0].style.cssText = "";
  document.getElementsByClassName('navbar')[0].style.cssText = "";
  document.getElementById('common-class').style.cssText = "";
  document.getElementsByClassName('a-mobileNav')[0].style.cssText = "";
})

$(window).resize(function () {
  if ($(window).width() > 998) {
    document.getElementsByClassName('top-bar')[0].style.cssText = "";
    document.getElementsByClassName('navbar')[0].style.cssText = "";
    document.getElementById('common-class').style.cssText = "";
    document.getElementsByClassName('a-mobileNav')[0].style.cssText = "";
  }
}); */

/*$('.explore')[0].onmouseover = function () {
  // $('.dropdown-toggle', this).trigger('click');
};*/

// Hero Slider
$("#heroHomeSlider").slick({
  speed: 500,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 3000,
  infinite: true,
  centerMode: true,
  centerPadding: '360px',
  arrows: false,
  dots: false,
  responsive: [
    {
      breakpoint: 1092,
      settings: {
        centerMode: false,
      },
    },
  ]
});

// Mobile top slider
$(".homeTopCategoryMobileContainer").slick({
  speed: 500,
  slidesToShow: 4,
  slidesToScroll: 1,
  swipeToSlide: false,
  infinite: false,
  centerMode: false,
  arrows: false,
  dots: false,
});


$(".homeShopCategoryMobileContainer").slick({
		  speed: 500,
		  slidesToShow: 9,
		  slidesToScroll: 1,
		  swipeToSlide: false,
		  infinite: false,
		  centerMode: false,
		  arrows: true,
		  dots: false,
		  responsive: [
			{
			  breakpoint: 992,
			  settings: {
				slidesToShow: 5,
				slidesToScroll: 1,
			  },
			},
			{
			  breakpoint: 768,
			  settings: {
				slidesToShow: 4,
				slidesToScroll: 1,
				centerMode: false,
				arrows: false,
			  },
			},
			{
			  breakpoint: 576,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				centerMode: false,
				arrows: false,
			  },
			},
		  ],
		});

// Sign Up hide unhide
$("#sendOtpSignUpBtn").click(function (e) {
  e.preventDefault();
  $("#enterNumberSignUp").removeClass("d-flex");
  $("#enterNumberSignUp").addClass("d-none");
  $("#enterOTPSignUp").removeClass("d-none");
  $("#enterOTPSignUp").addClass("d-flex");
});
// Log In hide unhide
$("#sendOtpLogInBtn0").click(function (e) {
  e.preventDefault();
  $("#enterNumberLogin").removeClass("d-flex");
  $("#enterNumberLogin").addClass("d-none");
  $("#enterOtpLogin").removeClass("d-none");
  $("#enterOtpLogin").addClass("d-flex");
});

$(".a-homeCategoryPill").slick({
  speed: 500,
  slidesToShow: 15,
  slidesToScroll: 1,
  swipeToSlide: true,
  infinite: true,
  centerMode: false,
  arrows: false,
  dots: false,
  responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
      },
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 3.5,
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
      },
    },
    {
      breakpoint: 375,
      settings: {
        slidesToShow: 3.5,
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
      },
    },
  ],
});

$(".a-homeTopCategoriesSlider").slick({
  speed: 500,
  slidesToShow: 4,
  slidesToScroll: 1,
  swipeToSlide: true,
  infinite: true,
  centerMode: false,
  arrows: false,
  dots: false,
  responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
      },
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
      },
    },
  ],
});

$(".a-homeTopSellingContainer").slick({
  speed: 500,
  slidesToShow: 4,
  slidesToScroll: 1,
  swipeToSlide: true,
  infinite: true,
  centerMode: false,
  arrows: true,
  prevArrow:
    "<button class='btn btn-primary text-light a-slider-previous-arrow p-0'><i class='bx bx-chevron-left bx-sm'></i></button>",
  nextArrow:
    "<button class='btn btn-primary text-light a-slider-next-arrow p-0'><i class='bx bx-chevron-right bx-sm'></i></button>",
  dots: false,
  responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
      },
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
      },
    },
  ],
});

$(".a-homeFeaturedItemContainer").slick({
  speed: 500,
  slidesToShow: 4,
  slidesToScroll: 1,
  swipeToSlide: true,
  infinite: true,
  centerMode: false,
  arrows: true,
  prevArrow:
    "<button class='btn btn-primary text-light a-slider-previous-arrow p-0'><i class='bx bx-chevron-left bx-sm'></i></button>",
  nextArrow:
    "<button class='btn btn-primary text-light a-slider-next-arrow p-0'><i class='bx bx-chevron-right bx-sm'></i></button>",
  dots: false,
  responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
      },
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
      },
    },
  ],
});
