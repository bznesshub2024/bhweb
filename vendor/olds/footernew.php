<!--footer-->
<div class="footer">
	<p>&copy; <?php echo date('Y'); ?> Marurang. All Rights Reserved | Design by <a href="https://www.blueappsoftware.com/" target="_blank">BlueApp Software</a></p>
</div>
<!--//footer-->
</div>
<script src="<?php echo BASEURL; ?>assets/js/classie.js"></script>
<script>
	function edit_orders(order_id, prod_id) {
		location.href = "edit_order.php?orderid=" + order_id + "&product_id=" + prod_id;
	}

	window.onload = function() {
		// Get the screen width
		var screenWidth = window.innerWidth;
		document.getElementsByClassName('navbar-toggle')[0].style.display = "none";

		// Load different JavaScript files based on screen width
		if (screenWidth < 1600) {
			console.log('a')
			document.getElementsByTagName('body')[0].classList.add('cbp-spmenu-push-toright');
			document.getElementById('cbp-spmenu-s1').classList.add('cbp-spmenu-open');
			document.getElementById('showLeftPush').classList.add('active');
			// document.getElementsByClassName('sidebar-left')[0].style.display = "none";
		}
		if (screenWidth < 600) {
			console.log('a')
			document.getElementsByTagName('body')[0].classList.remove('cbp-spmenu-push-toright');
			document.getElementById('cbp-spmenu-s1').classList.remove('cbp-spmenu-open');
			document.getElementById('showLeftPush').classList.remove('active');
		}
		if (showLeftPush.className === 'active') {
			document.getElementsByClassName('header-left')[0].style.setProperty('margin-left', '2.5%', 'important');
		}

	};



	var menuLeft = document.getElementById('cbp-spmenu-s1'),
		showLeftPush = document.getElementById('showLeftPush'),
		body = document.body;

	showLeftPush.onclick = function() {
		classie.toggle(this, 'active');
		classie.toggle(body, 'cbp-spmenu-push-toright');
		classie.toggle(menuLeft, 'cbp-spmenu-open');
		disableOther('showLeftPush');
		if (window.innerWidth > 600) {
			if (showLeftPush.className === 'active') {
				document.getElementsByClassName('header-left')[0].style.setProperty('margin-left', '2.5%', 'important');
			} else {
				document.getElementsByClassName('header-left')[0].style.transition = 'margin-left 0.3s ease-out';
				document.getElementsByClassName('header-left')[0].style.setProperty('margin-left', '16.5%', 'important');
			}
		} else {
			document.getElementsByClassName('navbar-collapse')[0].classList.add('in');
		}
	};


	function disableOther(button) {
		if (button !== 'showLeftPush') {
			classie.toggle(showLeftPush, 'disabled');
		}
	}
</script>
<!-- //Classie --><!-- //for toggle left push menu script -->
<!--scrolling js-->
<script src="<?php echo BASEURL; ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo BASEURL; ?>assets/js/scripts.js"></script>
<!--//scrolling js-->
<!-- side nav js -->
<script src='<?php echo BASEURL; ?>assets/js/SidebarNav.min.js' type='text/javascript'></script>
<script>
	$('.sidebar-menu').SidebarNav()
</script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo BASEURL; ?>assets/js/bootstrap.js"> </script>
<!-- //Bootstrap Core JavaScript -->
</body>

</html>