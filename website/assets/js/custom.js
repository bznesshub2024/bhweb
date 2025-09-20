/*--------------------------------------*/

/*1. Window scroll  */
/*--------------------------------------*/
$(window).scroll(function() {     
	var scroll = $(window).scrollTop();
	if (scroll > 120) {
		$("#btn-mb").addClass("active");
	}
	else {
		$("#btn-mb").removeClass("active");
	}
});
/*--------------------------------------*/

/*2. Close modal when hide  */
/*--------------------------------------*/
$("#sliderModal").on('hidden.bs.modal', function (e) {
	$("#sliderModal iframe").attr("src", $("#sliderModal iframe").attr("src"));
});
/*--------------------------------------*/

/*3. Minus Plus */
/*--------------------------------------*/
$(document).ready(function() {
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

  $(".next").click(function () {
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


