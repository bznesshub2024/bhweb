  <?php
      $catid = "87";// $_POST['catid'];
     $MEDIA_URL ='https://fleekmart.com/media/';
	if($catid=="" || empty($catid) ){
		header('Location: index.html');
			exit;
	}	 
  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Fleek Mart</title>
    
    <!-- Font awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="css/jquery.simpleLens.css">    
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="css/theme-color/default-theme.css" rel="stylesheet">
    <!-- Top Slider CSS -->
    <link href="css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="css/style.css" rel="stylesheet">    

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.js"></script>  
  <!-- SmartMenus jQuery plugin -->
  <script type="text/javascript" src="js/jquery.smartmenus.js"></script>
  <!-- SmartMenus jQuery Bootstrap Addon -->
  <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>  
  <!-- To Slider JS -->
  <script src="js/sequence.js"></script>
  <script src="js/sequence-theme.modern-slide-in.js"></script>  
  <!-- Product view slider -->
  <script type="text/javascript" src="js/jquery.simpleGallery.js"></script>
  <script type="text/javascript" src="js/jquery.simpleLens.js"></script>
  <!-- slick slider -->
  <script type="text/javascript" src="js/slick.js"></script>
  <!-- Price picker slider -->
  <script type="text/javascript" src="js/nouislider.js"></script>
  <!-- Custom js -->
  <script src="js/custom.js"></script> 

  </head>
<?php 
  include('header.html');
?>

 

  
  <body>
     <!-- Start header section -->
    <div id="header_wrap"></div>
    <div id="footer_wrap"></div>
  <!-- product category -->
	    <input type="hidden" class="form-control" id="catid" class ="catid" value="<?php echo $catid ; ?>"> 
	 </input>
<section id="aa-product-category" style="margin-top: 6em;">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-md-push-3">
          <div class="aa-product-catg-content">
            <div class="aa-product-catg-head">
              <div class="select-filter">Apply Filter </div>
              <div class="aa-product-catg-head-left">
                     <div class="aa-product-catg-pagination">
              <nav>
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous" style="background-color: #000;">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  
                  <li>
                    <a href="#" aria-label="Next" style="background-color: #000;">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                  <li><button>Sort By</button> </li>

                </ul>

              </nav>

            </div>


              </div>
       
            </div>
            <div class="aa-product-catg-body">
              <ul class="aa-product-catg">
                <!-- start single product item -->
                <li>
                  <figure>
                    <a class="aa-product-img" href="#"><img src="img/women/girl-1.png" alt="polo shirt img"></a>
                   <!--  <a class="aa-add-card-btn"href="#"><span class="fa fa-shopping-cart"></span>Add To Cart</a> -->
                    <figcaption>
                      <h3 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h3>
                      <p class="product-pr"> <small>Price</small></p>
                      <span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span><br>
                      <p class="aa-product-descrip">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam accusamus facere iusto, autem soluta amet sapiente ratione inventore nesciunt a, maxime quasi consectetur, rerum illum.</p>
                    </figcaption>
                  </figure>                         
       
                  
                </li>
              <!-- quick view modal -->                  
              <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">                      
                    <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <div class="row">
                        <!-- Modal view slider -->
                        <div class="col-md-6 col-sm-6 col-xs-12">                              
                          <div class="aa-product-view-slider">                                
                            <div class="simpleLens-gallery-container" id="demo-1">
                              <div class="simpleLens-container">
                                  <div class="simpleLens-big-image-container">
                                      <a class="simpleLens-lens-image" data-lens-image="img/view-slider/large/polo-shirt-1.png">
                                          <img src="img/view-slider/medium/polo-shirt-1.png" class="simpleLens-big-image">
                                      </a>
                                  </div>
                              </div>
                              <div class="simpleLens-thumbnails-container">
                                  <a href="#" class="simpleLens-thumbnail-wrapper"
                                     data-lens-image="img/view-slider/large/polo-shirt-1.png"
                                     data-big-image="img/view-slider/medium/polo-shirt-1.png">
                                      <img src="img/view-slider/thumbnail/polo-shirt-1.png">
                                  </a>                                    
                                  <a href="#" class="simpleLens-thumbnail-wrapper"
                                     data-lens-image="img/view-slider/large/polo-shirt-3.png"
                                     data-big-image="img/view-slider/medium/polo-shirt-3.png">
                                      <img src="img/view-slider/thumbnail/polo-shirt-3.png">
                                  </a>

                                  <a href="#" class="simpleLens-thumbnail-wrapper"
                                     data-lens-image="img/view-slider/large/polo-shirt-4.png"
                                     data-big-image="img/view-slider/medium/polo-shirt-4.png">
                                      <img src="img/view-slider/thumbnail/polo-shirt-4.png">
                                  </a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Modal view content -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="aa-product-view-content">
                            <h3>T-Shirt</h3>
                            <div class="aa-price-block">
                              <span class="aa-product-view-price">$34.99</span>
                              <p class="aa-product-avilability">Avilability: <span>In stock</span></p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis animi, veritatis quae repudiandae quod nulla porro quidem, itaque quis quaerat!</p>
                            <h3>Size</h4>
                            <div class="aa-prod-view-size">
                              <a href="#">S</a>
                              <a href="#">M</a>
                              <a href="#">L</a>
                              <a href="#">XL</a>
                            </div>
                            <div class="aa-prod-quantity">
                              <form action="">
                                <select name="" id="">
                                  <option value="0" selected="1">1</option>
                                  <option value="1">2</option>
                                  <option value="2">3</option>
                                  <option value="3">4</option>
                                  <option value="4">5</option>
                                  <option value="5">6</option>
                                </select>
                              </form>
                              <p class="aa-prod-category">
                                Category: <a href="#">Polo T-Shirt</a>
                              </p>
                            </div>
                            <div class="aa-prod-view-bottom">
                              <a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                              <a href="#" class="aa-add-to-cart-btn">View Details</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>                        
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div>
              <!-- / quick view modal -->   
            </div>
            <div class="aa-product-catg-pagination">
              <nav>
                <ul class="pagination">
                  <li>
                    <a href="#" aria-label="Previous" style="background-color: #000;">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li>
                    <a href="#" aria-label="Next" style="background-color: #000;">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
            <div class="aa-product-catg-head">
              <div class="aa-product-catg-head-center">
              <h3><b>APPLY FILTER</b></h3>
              </div>
          <aside class="aa-sidebar">
            <!-- single sidebar -->
            <div class="aa-sidebar-widget">
              <h3>Filter One</h3>
              <ul class="aa-catg-nav">
                  <li>
                    <span>
                      <input type="checkbox" checked="checked" id="option1">
                      <label for="option1">Option 1</label>
                    </span>
                  </li>
                   <li><a href="#"> <input class="w3-check" type="checkbox">  <label>Option 1 </label></a></li>
                   <li><a href="#"> <input class="w3-check" type="checkbox">  <label>Option 1 </label></a></li>
                   <li><a href="#"> <input class="w3-check" type="checkbox">  <label>Option 1 </label></a></li>
                   <li><a href="#"> <input class="w3-check" type="checkbox">  <label>Option 1 </label></a></li>
                   <li><a href="#"> <input class="w3-check" type="checkbox">  <label>Option 1 </label></a></li>
                   <li><a href="#"> <input class="w3-check" type="checkbox">  <label>Option 1 </label></a></li>
                  <li><a href="#"> <input class="w3-check" type="checkbox">  <label>Option 1 </label></a></li>
              
              </ul>
            </div>
            <div class="aa-sidebar-widget">
              <h3>Price</h3>              
              <!-- price range -->
              <div class="aa-sidebar-price-range">
               <form action="">
                  <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                  </div>
                  <span id="skip-value-lower" class="example-val">30.00</span>
                 <span id="skip-value-upper" class="example-val">100.00</span>
                 <button class="aa-filter-btn" type="submit">Filter</button>
               </form>
              </div>              

            </div>
          </aside>
        </div>
       
      </div>
    </div>
  </section>
  <!-- / product category -->



  <!-- Login Modal -->  
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">                      
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4>Login or Register</h4>
          <form class="aa-login-form" action="">
            <label for="">Username or Email address<span>*</span></label>
            <input type="text" placeholder="Username or email">
            <label for="">Password<span>*</span></label>
            <input type="password" placeholder="Password">
            <button class="aa-browse-btn" type="submit">Login</button>
            <label for="rememberme" class="rememberme"><input type="checkbox" id="rememberme"> Remember me </label>
            <p class="aa-lost-password"><a href="#">Lost your password?</a></p>
            <div class="aa-register-now">
              Don't have an account?<a href="account.html">Register now!</a>
            </div>
          </form>
        </div>                        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>


  <!-- / footer -->
  <!-- Login Modal -->  
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">                      
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4>Login or Register</h4>
          <form class="aa-login-form" action="">
            <label for="">Username or Email address<span>*</span></label>
            <input type="text" placeholder="Username or email">
            <label for="">Password<span>*</span></label>
            <input type="password" placeholder="Password">
            <button class="aa-browse-btn" type="submit">Login</button>
            <label for="rememberme" class="rememberme"><input type="checkbox" id="rememberme"> Remember me </label>
            <p class="aa-lost-password"><a href="#">Lost your password?</a></p>
            <div class="aa-register-now">
              Don't have an account?<a href="account.html">Register now!</a>
            </div>
          </form>
        </div>                        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>


    


  <?php   include('footer.php');?>

   <script>
  function gotoproductpage(pid,sid,sku){
     // alert("productID productSKU productSID"+pid+"  "+sku+"  "+sid+"  ");
                var mapForm = document.createElement("form");
                mapForm.target = "_self";
                mapForm.method = "POST"; // or "post" if appropriate
                mapForm.action = "productdetail.php";
            
                var mapInput = document.createElement("input");
                mapInput.type = "text";
                mapInput.name = "pid";
                mapInput.value = pid;
                mapForm.appendChild(mapInput);
            
                 var mapInput = document.createElement("input");
                mapInput.type = "text";
                mapInput.name = "sid";
                mapInput.value = sid;
                mapForm.appendChild(mapInput);

                var mapInput = document.createElement("input");
                mapInput.type = "text";
                mapInput.name = "sku";
                mapInput.value = sku;
                mapForm.appendChild(mapInput);


                document.body.appendChild(mapForm);
            
                map = window.open("", "_self" );
            
                if (map) {
                    mapForm.submit();
                } else {
                    alert('You must allow popups for this map to work.');
                }
  }
</script>

<script>
	
	function getFilerOption(){
		var catidv = $('#catid').val();
		//alert("hjhhhj j");
	   $.ajax({
        method: 'POST',
        url: 'https://fleekmart.com/API/index.php/app/getProductFilter',
        headers: {
          'X-API-KEY':'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype:"1",
          catid: catidv 
        },
        success: function(response){
			console.log(response);
		  var resJSON  = response;
          var totalprod = resJSON.Information.length; 
         // console.log("info lenght is" + totalprod );   
          var infoarray = resJSON.Information;
          var filter_list ="", filterdiv="";
			
	      for(var i =0 ; i<totalprod; i++){
            var infoobj = infoarray[i];
            var filtername = infoobj.name;
           // alert( "filter is "+ filtername);
			var valuelist = infoobj.value;
			//  alert("name "+valuelist.length);
			filterdiv += ' <div class="aa-sidebar-widget"><h3>'+filtername+'</h3>';  
			var valuenamediv =' <ul class="aa-catg-nav">'; 
			var valuenamelist =""; 
			  for(var j =0 ; j<valuelist.length; j++){
			  // alert( "name  "+ valuelist[j]);
				valuenamelist += '<li> <span> <input type="checkbox" id="'+valuelist[j]+'">  <label for="'+valuelist[j]+'">'+valuelist[j]+'</label></span></li>';
			}
    		  valuenamediv +=  valuenamelist + '</ul></div>';
			  filterdiv += valuenamediv+ '</div>';
          }// name for loop close
			
         $(".aa-sidebar").html(filterdiv);
        
		}
		   
	   });
	
	}
</script>



  <script>
    function get_categoryproduct(){
    	var catidv = $('#catid').val();
		var pagenov = "0";// $('#pagenov').val();
		var sortv = ""; // $('#pagenov').val();
		//alert(" get cat "+catidv);
      $.ajax({
        method: 'POST',
        url: 'https://fleekmart.com/API/index.php/app/getCategoryProduct',
        headers: {
          'X-API-KEY':'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype:"2",
          catid: catidv,
          pageno: pagenov,
          sortby: sortv  
        },
        success: function(response){
          console.log(response);
          //alert("response is "+response);
          var resJSON  = response;
          var totalprod = resJSON.Information.length; 
         // console.log("info lenght is" + totalprod );   
          var infoarray = resJSON.Information;
          var category_product_list ="";
          for(var i =0 ; i<totalprod; i++){
            var infoobj = infoarray[i];
            var prodname = infoobj.name;
            var prodImg = infoobj.imgurl;
            var prodPrice = infoobj.price;
            // var prodLink = infoobj.web_url;
            //alert( "prod name is "+ prodname);
            // <input type="hidden">
            var pid = infoobj.id;
            var sku = infoobj.sku;
            var sid = infoobj.vendor_id;


            category_product_list += '<li class="sinle_product"><input class="productID" type="hidden" value="'+pid+'"></input><input class="productSKU" type="hidden" value="'+sku+'"></input><input class="productSID" type="hidden" value="'+sid+'"></input><a class="aa-product-img" href="#"><img src="https://www.fleekmart.com/media/'+prodImg+'" alt="'+prodname+'"></a><h3 class="aa-product-title"><a href="#"><b>'+prodname+'</b></a></h3><p class="product-pr"><small>Price</small></p><span class="aa-product-price-right fa fa-shopping-cart"></span><span class="aa-product-price-left">'+prodPrice+'</span><p class="aa-product-descrip"></p></li>';

          }        
          // alert(category_product_list);
          $(".aa-product-catg").html(category_product_list);
          $(".sinle_product").click(function() {
             var $row = $(this).closest("li");    // Find the row
             var pid = $row.find(".productID").val(); 
             var sku = $row.find(".productSKU").val(); 
             var sid = $row.find(".productSID").val(); 
             // parentvalue = text;
            // alert("productID productSKU productSID"+pid+"  "+sku+"  "+sid+"  "); 
             gotoproductpage(pid,sid,sku);
        });
        }
      });
    }
    $(document).ready(function() {
      $(".aa-product-catg").html(get_categoryproduct());
	     getFilerOption();

      $('.select-filter').click(function(event) {
        
        $('.aa-sidebar').toggle();   

      })

    });
  </script>



  </body>
</html>