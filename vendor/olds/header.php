<?php

header('Cache-Control: no cache');
//echo "<pre>";print_r($_SESSION);


?>
<!--
Author: kamal bunkar
Author URL: http://www.blueappsoftware.com
-->
<!DOCTYPE HTML>
<html>

<head>
  <title>Dashboard, Admin panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="Multi Vendor eCommerce app Admin panel, www.blueappsoftware.com" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
  <script type="application/x-javascript">
    addEventListener("load", function() {
      setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script>

  <!-- Bootstrap Core CSS -->
  <link href="<?php echo BASEURL; ?>assets/css/bootstrap.css" rel='stylesheet' type='text/css' />

  <!-- Custom CSS -->
  <link href="css/style.css" rel='stylesheet' type='text/css' />

  <!-- font-awesome icons CSS -->
  <link href="<?php echo BASEURL; ?>assets/css/font-awesome.css" rel="stylesheet">
  <!-- //font-awesome icons CSS-->

  <!-- side nav css file -->
  <link href='<?php echo BASEURL; ?>assets/css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css' />
  <!-- //side nav css file -->

  <!-- js-->
  <script src="<?php echo BASEURL; ?>assets/js/jquery-1.11.1.min.js"></script>
  <script src="<?php echo BASEURL; ?>assets/js/modernizr.custom.js"></script>



  <!--webfonts-->
  <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
  <!--//webfonts-->

  <!-- Metis Menu -->
  <script src="<?php echo BASEURL; ?>assets/js/metisMenu.min.js"></script>
  <script src="<?php echo BASEURL; ?>assets/js/custom.js"></script>
  <link href="<?php echo BASEURL; ?>assets/css/custom.css" rel="stylesheet">
  <!--//Metis Menu -->

  <style>
    #chartdiv {
      width: 100%;
      height: 295px;
    }

    .fa {
      font-size: 15px;
    }

    .checked {
      color: orange;
    }

    .txt-center {
      text-align: center;
    }

    .hide {
      display: none;
    }

    .clear {
      float: none;
      clear: both;
    }

    .rating {
      width: 90px;
      unicode-bidi: bidi-override;
      direction: rtl;
      text-align: center;
      position: relative;
    }

    .rating>label {
      float: right;
      display: inline;
      padding: 0;
      margin: 0;
      position: relative;
      width: 1.1em;
      cursor: pointer;
      color: #000;
    }

    .rating>label:hover,
    .rating>label:hover~label,
    .rating>input.radio-btn:checked~label {
      color: transparent;
    }

    .rating>label:hover:before,
    .rating>label:hover~label:before,
    .rating>input.radio-btn:checked~label:before,
    .rating>input.radio-btn:checked~label:before {
      content: "\2605";
      position: absolute;
      left: 0;
      color: #FFD700;
    }

    .top-bar {
      background-color: red;
      position: fixed;
      top: 0;
      height: 24px;
      padding: 2px 0;
      z-index: 100;
      width: 100%;
    }
  </style>
  <style type="text/css" media="print">
    @media print {
      @page {
        margin-top: 0;
        margin-bottom: 0;
      }

      body {
        padding-top: 72px;
        padding-bottom: 72px;
      }
    }

    .dontprint {
      display: none;
    }
  </style>
  <style>
    select {
      -webkit-appearance: none;
      -moz-appearance: none;

      /* Some browsers will not display the caret when using calc, so we put the fallback first */
      background: url("http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png") white no-repeat 98.5% !important;
      /* !important used for overriding all other customisations */
      background: url("http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png") white no-repeat calc(100% - 10px) !important;
      /* Better placement regardless of input width */
    }

    /*For IE*/
    select::-ms-expand {
      display: none;
    }

    @media only screen and (max-width: 767px) {
      #app-logo {
        width: 75px;
      }
    }
  </style>




  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

  <script src="https://rawgit.com/someatoms/jsPDF-AutoTable/master/dist/jspdf.plugin.autotable.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.0.16/jspdf.plugin.autotable.js"></script>

  <!--   multi select github link is working correctly  https://github.com/nobleclem/jQuery-MultiSelect -->
  <link href="<?php echo BASEURL; ?>assets/css/jquery.multiselect.css" rel="stylesheet" />

  <script src="<?php echo BASEURL; ?>assets/js/jquery.multiselect.js"></script>
  <script src="js/admin/common.js"></script>
  <!--   multi select github link close-->


</head>

<body class="cbp-spmenu-push">
  <div class="main-content">
    <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
      <!--left-fixed -navigation-->
      <aside class="sidebar-left">
        <nav class="navbar navbar-inverse">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <h1><a class="navbar-brand" href="dashboard.php"><span class="fa fa-area-chart"></span> Seller<span class="dashboard_text">Dashboard</span></a></h1>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="sidebar-menu">
              <li class="header">MAIN NAVIGATION</li>
              <li class="treeview">
                <a href="dashboard.php">
                  <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
              </li>


              <li class="treeview <?php if (strpos($_SERVER['PHP_SELF'], 'category.php') !== false) {
                                    echo "active";
                                  } ?>">
                <a href="category.php">
                  <i class="fa fa-dashboard"></i> <span>Category</span>
                </a>
              </li>
              <li class="treeview <?php if (strpos($_SERVER['PHP_SELF'], 'brand.php') !== false) {
                                    echo "active";
                                  } ?>">
                <a href="brand.php">
                  <i class="fa fa-dashboard"></i> <span>Brand</span>
                </a>
              </li>

			<li class="treeview <?php if (strpos($_SERVER['PHP_SELF'], 'payment.php') !== false) {
									echo " active ";
								} ?>">
				<a href="payment.php"> <i class="fa fa-dashboard"></i> <span>Payment</span> </a>
			</li>
			  
			  <li class="treeview <?php if (strpos($_SERVER['PHP_SELF'], 'manage_seller_wise_transaction.php') !== false) {
                                    echo "active";
                                  } ?>">
                <a href="manage_seller_wise_transaction.php">
                  <i class="fa fa-dashboard"></i> <span>Forward Sales Report</span>
                </a>
              </li>
			  
			  <li class="treeview <?php if (strpos($_SERVER['PHP_SELF'], 'manage_reverse_seller_transaction.php') !== false) {
                                    echo "active";
                                  } ?>">
                <a href="manage_reverse_seller_transaction.php">
                  <i class="fa fa-dashboard"></i> <span>Reverse Sales Report</span>
                </a>
              </li>

             <!-- <li class="treeview <?php // if (strpos($_SERVER['PHP_SELF'], 'price_calculator.php') !== false) { echo " active "; } ?>">
                <a href="price_calculator.php"> <i class="fa fa-dashboard"></i> <span>Price Calculator</span> </a>
              </li>-->

              <li class="treeview <?php if (strpos($_SERVER['PHP_SELF'], 'manage_attribute_set.php') !== false || strpos($_SERVER['PHP_SELF'], 'manage_tax_class.php') !== false || strpos($_SERVER['PHP_SELF'], 'manage_return_policy.php') !== false || strpos($_SERVER['PHP_SELF'], 'manage_conf_attributes.php') !== false) {
                                    echo "active";
                                  } ?>">
                <a href="#">
                  <i class="fa fa-laptop"></i>
                  <span>Products Attributes</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'manage_attribute_set.php') !== false) {
                                echo "active";
                              } ?>"><a href="manage_attribute_set.php"><i class="fa fa-angle-right"></i> Manage Attribute Set</a></li>
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'manage_tax_class.php') !== false) {
                                echo "active";
                              } ?>"><a href="manage_tax_class.php"><i class="fa fa-angle-right"></i> Manage TAX Class</a></li>
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'manage_return_policy.php') !== false) {
                                echo "active";
                              } ?>"><a href="manage_return_policy.php"><i class="fa fa-angle-right"></i> Manage Return Policy</a></li>
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'manage_conf_attributes.php') !== false) {
                                echo "active";
                              } ?>"><a href="manage_conf_attributes.php"><i class="fa fa-angle-right"></i>Manage Configurations Attributes</a></li>

                </ul>
              </li>
              <li class="treeview  <?php if (strpos($_SERVER['PHP_SELF'], 'inventory.php') !== false || strpos($_SERVER['PHP_SELF'], 'add_product.php') !== false || strpos($_SERVER['PHP_SELF'], 'manage_product.php') !== false || strpos($_SERVER['PHP_SELF'], 'import_product.php') !== false) {
                                      echo "active";
                                    } ?>">
                <a href="#">
                  <i class="fa fa-laptop"></i>
                  <span>Products</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'import_product.php') !== false) {
                                echo "active";
                              } ?>"><a href="import_product.php"><i class="fa fa-angle-right"></i> Import Product</a></li>
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'inventory.php') !== false) {
                                echo "active";
                              } ?>"><a href="inventory.php"><i class="fa fa-angle-right"></i> Update Inventory</a></li>
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'add_product.php') !== false) {
                                echo "active";
                              } ?>"><a href="add_product.php"><i class="fa fa-angle-right"></i> Add Product</a></li>
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'add_search_product.php') !== false) {
                                echo "active";
                              } ?>"><a href="add_search_product.php"><i class="fa fa-angle-right"></i> Add Existing Product</a></li>
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'manage_product.php') !== false) {
                                echo "active";
                              } ?>"><a href="manage_product.php"><i class="fa fa-angle-right"></i> Manage Product</a></li>

                </ul>
              </li>
              <li class="treeview  <?php if (strpos($_SERVER['PHP_SELF'], 'manage_orders.php') !== false) {
                                      echo "active";
                                    } ?>">
                <a href="#">
                  <i class="fa fa-laptop"></i>
                  <span>Orders</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="<?php if (strpos($_SERVER['PHP_SELF'], 'manage_orders.php') !== false) {
                                echo "active";
                              } ?>"><a href="manage_orders.php"><i class="fa fa-angle-right"></i> Manage Orders</a></li>

                </ul>
              </li>
              <li class="treeview <?php if (strpos($_SERVER['PHP_SELF'], 'coupancode.php') !== false) {
                                    echo " active ";
                                  } ?>"> <a href="coupancode.php"> <i class="fa fa-dashboard"></i> <span>Coupan Code</span> </a> </li>
              <li class="treeview class=" <?php if (strpos($_SERVER['PHP_SELF'], 'reports.php') !== false) {
                                            echo "active";
                                          } ?>"">
                <a href="reports.php">
                  <i class="fa fa-dashboard"></i> <span>Sale Account</span>
                </a>
              </li>
              <li class="treeview class=" <?php if (strpos($_SERVER['PHP_SELF'], 'review.php') !== false) {
                                            echo "active";
                                          } ?>"">
                <a href="manage_review.php">
                  <i class="fa fa-dashboard"></i> <span>User Reviews</span>
                </a>
              </li>
              <li class="treeview class=" <?php if (strpos($_SERVER['PHP_SELF'], 'support_chat.php') !== false) {
                                            echo "active";
                                          } ?>"">
                <a href="support_chat.php">
                  <i class="fa fa-dashboard"></i> <span>Chat with Admin <i class="fa fa-bell" aria-hidden="true"></i> <span id="support_noti_count">0</span></span>
                </a>
              </li>


            </ul>
          </div>
          <!-- /.navbar-collapse -->
        </nav>
      </aside>
    </div>
    <!--left-fixed -navigation-->

    <section class="top-bar">

      <div class="row" style="margin-top: 0px; display:flex; justify-content:space-between;">
        <div class="col-6" style="background-color: red; margin-left: -35%">
          <p class="mb-0 text-white" style="display: flex; align-items: center; height:100%;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
              <path fill="currentColor" d="M4 20q-.825 0-1.412-.587Q2 18.825 2 18V6q0-.825.588-1.412Q3.175 4 4 4h10.1q-.1.5-.1 1t.1 1H4v12h16V9.9q.575-.125 1.075-.35q.5-.225.925-.55v9q0 .825-.587 1.413Q20.825 20 20 20ZM4 6v12V6Zm15 2q-1.25 0-2.125-.875T16 5q0-1.25.875-2.125T19 2q1.25 0 2.125.875T22 5q0 1.25-.875 2.125T19 8Zm-7 3l3.65-2.275q.35.325.763.562q.412.238.862.413l-4.75 2.975q-.25.15-.525.15t-.525-.15L4 8V6Z"></path>
            </svg>
            <span class="">&nbsp;support@marurang.in</span>
            <!--<i class='bx bxs-phone bx-xs'></i>
                    <span class="ms-1">&nbsp;
                        <a class="text-white text-decoration-none" href=""></a>
                    </span>-->
          </p>
        </div>
        <div class="col-6" style="background-color: red; margin-right: -35%">
          <p class="mb-0 text-white fw-bold float-end">
            ENG
          </p>
        </div>
      </div>
    </section>

    <!-- header-starts -->
    <div class="sticky-header header-section ">
      <div class="header-left">
        <!--toggle button start-->
        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
        <img src="images/logo-appbar.png" alt="" width="150" id="app-logo" style="margin-left: 10px;">
        <!--toggle button end-->
        <!--notification menu end -->
        <div class="clearfix"> </div>
      </div>
      <div class="header-right headerlist">
        <ul class="head-ul">
          <li class="bell-area">
            <a id="notf_conv" class="dropdown-toggle-1" target="_blank" href="<?php echo BASEURL; ?>">
              <i class="fa fa-globe"></i>
            </a>
          </li>
          <li class="bell-area">
            <a id="notf_conv" class="dropdown-toggle-1" href="javascript:;">
              <i class="fa fa-envelope"></i>
              <span id="conv-notf-count">0</span>
            </a>
            <div class="dropdown-menu1">
              <div class="dropdownmenu-wrapper" data-href="https://www.webinovers.com/ecom/admin/conv/notf/show" id="conv-notf-show">
              </div>
            </div>
          </li>
          <li class="bell-area">

            <div class="dropdown">
              <a id="notf_conv" class="dropdown-togg notificationLink" href="javascript:;">
                <i class="fa fa-bell" aria-hidden="true"></i>
                <span id="new_noti_count">0</span>
              </a>

              <div id="notificationContainer">
                <div id="notificationTitle">Notifications <a href="javascript:void(0);" onclick="remove_notification();" style="float: right;">Remove All</a></div>
                <div id="notificationsBody" class="notifications">
                  <ul id="new_noti_html">

                  </ul>
                </div>
                <div id="notificationFooter"><a href="#"></a></div>
              </div>
            </div>
          </li>

          <li class="bell-area">
            <div class="profile_details">
              <ul>
                <li class="dropdown profile_details_drop">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <div class="profile_img">
                      <span class="prfil-img"><img src="images/2.jpg" alt=""> </span>
                      <div class="user-name">
                        <span><?php echo $_SESSION['seller_name']; ?></span>
                      </div>
                      <i class="fa fa-angle-down lnr"></i>
                      <i class="fa fa-angle-up lnr"></i>
                      <div class="clearfix"></div>
                    </div>
                  </a>
                  <ul class="dropdown-menu drp-mnu">
                    <li> <a href="profile.php"><i class="fa fa-user"></i> Profile</a> </li>
                    <li> <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
                  </ul>
                </li>
              </ul>
            </div>
          </li>
        </ul>

        <div class="clearfix"> </div>
      </div>
      <div class="clearfix"> </div>
    </div>
    <!-- //header-ends -->
    <div class="loading" style="display:none;">Loading&#8230;</div>
    <input type="hidden" name="code_ajax" id="code_ajax" value="<?php echo $_SESSION['_token']; ?>">
    <?php
    global $publickey_server;
    $encruptfun = new encryptfun();
    $encryptedpassword = $encruptfun->encrypt($publickey_server, $_SESSION['admin']);
    ?>
    <input type="hidden" id="selleer_id" value="<?php echo $encryptedpassword; ?>">
    <link href="<?php echo BASEURL; ?>assets/css/xdialog.min.css" rel="stylesheet" />
    <script src="<?php echo BASEURL; ?>assets/js/xdialog.min.js"></script>