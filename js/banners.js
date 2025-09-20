
    $(document).ready(function(){
        getMasterBanner();
    });
    
    function getMasterBanner(){
        $.ajax({
           // url: 'https://a2zshop.in/API/index.php/app/getCategory',
            url: 'https://a2zshop.in/API/index.php/app/getCustomBanners',
            type: 'POST',
            dataType: 'JSON',
            data: {language:"default",devicetype:"1"},
            secure: true,
            cors: true ,
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Credentials': 'true',
                'Access-Control-Allow-Methods': 'OPTIONS, GET, POST',
                'Access-Control-Allow-Headers': 'Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control'
            },
            beforeSend: function(request) {
                request.setRequestHeader("X-API-KEY", "ysh2zka3fhcn4hsdkcn");
            },
            success: function (result) {
              // console.log(result);
//               console.log(result.Information);
               $.each(result.Information,function(index,data){
                   console.log(data.layout);
                   if(data.layout=="8"){
                       var html='<div class="a_main1"><div id="demo" class="carousel slide" data-ride="carousel" data-interval="2000"> <div class="carousel-inner" id="master_banner_list">';
                       html+='</div><a class="carousel-control-prev a_ccontrol" href="#demo" data-slide="prev"><i class="fa fa-chevron-left"></i></a>';
                           html+='<a class="carousel-control-next a_ccontrol" href="#demo" data-slide="next">';
					html+='<i class="fa fa-chevron-right"></i></a></div></div>';
					$("#banner_section").append(html);
                       $.each(data.banners_result,function(index1,data1){
                          // console.log(data1.imgurl);
                           
                           if(index1 == 1){
                               var html='<div class="carousel-item item active"><a href="#">';
                           html+='<img width="1350" height="278" src="https://www.a2zshop.in/media/'+data1.imgurl+'" alt="Los Angeles"></a></div>';
                           }else{
                            var html='<div class="carousel-item"><a href="#">';
                           html+='<img width="1350" height="278" src="https://www.a2zshop.in/media/'+data1.imgurl+'" alt="Los Angeles"></a></div>';   
                           }
					
                           
                           $("#master_banner_list").append(html);
                           });
                           
                           
                   }else if(data.layout=="6"){
                      var html='<div class="a_main3">';
				html+='<div class="row" id="second_banner">';
				html+='</div>';
				html+='</div>';
				$("#banner_section").append(html);
                       $.each(data.banners_result,function(index1,data1){
                           var html='<div class="col-md-4"><a href="#"><img class="img-fluid" src="https://www.a2zshop.in/media/'+data1.imgurl+'"></a></div>';
                           $("#second_banner").append(html);
                           });
                   }
                   else if(data.layout=="2"){
                       var html='<div class="a_main3">';
				html+='<div class="row" id="first_banner">';
				html+='</div>';
				html+='</div>';
				$("#banner_section").append(html);
                       $.each(data.banners_result,function(index1,data1){
                           var html='<div class="col-md-4"><a href="#"><img class="img-fluid" src="https://www.a2zshop.in/media/'+data1.imgurl+'"></a></div>';
                           $("#first_banner").append(html);
                           });
                           
			//	$("#banner_section").append(html);
                   }
                   
                   
                   else if(data.title=="load3"){
                       $.each(data.banners_result,function(index1,data1){
                           var html='<div class="col-md-4"><a href="#"><img class="img-fluid" src="https://www.a2zshop.in/media/'+data1.imgurl+'"></a></div>';
                           $("#third_banner").append(html);
                           });
                   }
                  // console.log(data.banners_result);
                    /*var html='<li class="nav-item have_chevron_mouseover" >';
                    html+='<a class="nav-link" href="#">'+data.cat_name+' <i class="fa fa-chevron-down"></i></a></li>';
                    
                    $("#cat_list").append(html);*/
                    
               });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }