	var code_ajax = $("#code_ajax").val();	
	
	
	var imagejson = [];
	var attrjson = [];
	var notiimage ="";
	var categorylistvisible = false;
		$(document).ready(function(){ 
		   // successmsg("ready call");
		
		 var id = 1;
            var high= "21"; 
			$("#moreImg").click(function(){
				var showId = ++id;
				if(showId <=high)
				{
					$(".input-files").append('<div id="more_img'+showId+'"><br><input type="file" id="prod_img'+showId+'" onchange=uploadFile1(\"prod_img'+showId+'\")  name="product_image[]" style="float:left; display: inline-block; margin-right:20px;"> </input> '+
					'<a class="btn btn-sm btn-danger" onclick=removeImage("more_img'+showId+'"); return false;" style="float:left; display: inline-block; margin-right:20px;">Remove</a> <br></div>');
				}
			});
		
			
		});
	
	
	
	function removeImage(element) {
		$("#"+element).remove();   
	}
	
	
	
	
	
	
	function expand(list, view){
        var listElement = document.getElementById('ul'+list);
        var defaultView = '[+]';
        
        if(view.innerHTML == defaultView){
            listElement.style.display = "block";
            view.innerHTML = '[-]';    
        } else {
            listElement.style.display = "none";
            view.innerHTML = '[+]';
        }
    }
	
	function check_category_limit(view){
		if($('.check_category_limit:checkbox:checked').length > 5){					
			view.checked = false;
			successmsg("Category Selection Limit 5");
			//$('.check_category_limit').attr('disabled','disabled');
		}
	}
	
	function delete_images(prod_id,index){
		xdialog.confirm('Are you sure want to delete?', function() {
			$.ajax({
				method: 'POST',
				url: 'delete_product_data.php',
				data: {img_prod_id:prod_id,image_index:index,code:code_ajax},
				success: function(response){
                    var data = $.parseJSON(response);
                    if(data['status'] == '1'){
						$("#prod_img_urltxt").val(data['prod_image']);
						$("#imgs_div"+index).remove();
					}
                    
               }
            });
		}, {
        style: 'width:420px;font-size:0.8rem;',
        buttons: {
            ok: 'yes ',
              cancel: 'no '
         },
        oncancel: function() {
             // console.warn('Cancelled!');
         }
 });
	}
	
	$(document).ready(function(){
		$("#editProduct_btn").click(function(event){
			event.preventDefault();
			var toggleChecked = document.getElementById("togglebtn").checked;
			var productStatus = false;
			if(toggleChecked){
					productStatus = true;
			} else {
					productStatus = false;
			}
			var prod_namevalue = $('#prod_name').val();
			var prod_shortvalue = tinyMCE.get('prod_short').getContent();
			var prod_detailsvalue =  tinyMCE.get('editor').getContent();
			
			var prod_brand = $('#selectbrand').val();
			var featured_img = $('#featured_img').val();
			var selectattrset = $('#selectattrset').val();
          	var prod_name_ar = $('#prod_name_ar').val();
			var prod_short_ar = tinyMCE.get('prod_short').getContent();
			var editor_ar = tinyMCE.get('editor').getContent();
			
			var valid =1;
          
			if(!selectattrset){		
				successmsg("Please Select Attribute Set.");
				valid =0;
			}else if($('.check_category_limit:checkbox:checked').length ==0 ){		
				successmsg("Please Select atleast one Category.");
				valid =0;
			}else if(!prod_namevalue){
				successmsg("Please enter Product Name.");
				valid =0;
			}else if(!prod_shortvalue){
				successmsg("Please enter Product Short details.");
				valid =0;
			}else if(!prod_detailsvalue){
				successmsg("Please enter Product Full Details.");
				valid =0;
			
			}else if(prod_brand ==""){               
               successmsg("Please Select Brand");
			   valid =0;
           } else{
              $.busyLoadFull("hide");
            $.ajax({
				method: 'POST',
				url: 'check_product_process.php',
				data: $('#myform').serialize(),
				success: function(response){
					$.busyLoadFull("hide");
                    var data = $.parseJSON(response);
                    if(data["data"]['status'] == 'exist'){
						$("#prod_url").val(data["data"]['prod_url']);
						$("#prod_sku").val(data["data"]['prod_sku']);
						successmsg(data["data"]['message']);
					}else if(data["data"]['status'] == 'done'){
						$("#prod_url").val(data["data"]['prod_url']);
						$("#prod_sku").val(data["data"]['prod_sku']);
						$("#myform").submit();
					}
                    
               }
            });
            
           
               
           }
		});
		
		$("#skip_sale_price").click(function(event){
			
			if($("#skip_sale_price").prop('checked') == true){
				var prod_mrp = $("#prod_mrp").val();
				var prod_price = $("#prod_price").val();
				
				$(".sale_prices").val(prod_mrp);
				$(".mrp_price").val(prod_price);
				$(".sale_prices").attr('readonly','readonly');
				$(".mrp_price").attr('readonly','readonly');
			}else{
				$(".sale_prices").removeAttr('readonly','readonly');
				$(".mrp_price").removeAttr('readonly','readonly');
			}
	
		});
		
		if ($("#editor").length > 0) {
            tinymce.init({
                selector: "textarea#editor",
                theme: "modern",
                height: 300,
                plugins: [
					"advlist lists print",
				//  "wordcount code fullscreen",
					"save table directionality emoticons paste textcolor"
				],
				toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            });
        }
		if ($("#prod_short").length > 0) {
            tinymce.init({
                selector: "textarea#prod_short",
                theme: "modern",
                height: 300,
                plugins: [
					"advlist lists print",
				//  "wordcount code fullscreen",
					"save table directionality emoticons paste textcolor"
				],
				toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
		if ($("#prod_short_ar").length > 0) {
            tinymce.init({
                selector: "textarea#prod_short_ar",
                theme: "modern",
                height: 300,
                plugins: [
					"advlist lists print",
				//  "wordcount code fullscreen",
					"save table directionality emoticons paste textcolor"
				],
				toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
		
		if ($("#editor_ar").length > 0) {
            tinymce.init({
                selector: "textarea#editor_ar",
                theme: "modern",
                height: 300,
                plugins: [
					"advlist lists print",
				//  "wordcount code fullscreen",
					"save table directionality emoticons paste textcolor"
				],
				toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
	});
	
	