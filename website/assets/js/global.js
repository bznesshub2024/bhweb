window.addEventListener("load", () => {
  $("#loader").fadeOut("slow");
});

// Hero Slider
$("#heroHomeSlider").slick({
  speed: 500,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 3500,
  infinite: true,
  arrows: false,
  dots: false,
});

// Mobile top slider
$(".homeTopCategoryMobileContainer").slick({
  speed: 500,
  slidesToShow: 4.5,
  slidesToScroll: 1,
  swipeToSlide: true,
  infinite: false,
  centerMode: false,
  arrows: false,
  dots: false,
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
$("#sendOtpLogInBtn").click(function (e) {
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

$("#applyFilterBtn").click(function () {
  $("#filtersContainer").toggleClass("d-none");
});
