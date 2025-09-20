
    $(document).ready(function(){
        $.ajax({
           // url: 'https://a2zshop.in/API/index.php/app/getCategory',
            url: 'https://a2zshop.in/API/index.php/app/getHomeCategory',
            type: 'POST',
            dataType: 'json',
            data: {language:"default",devicetype:"1"},
            secure: true,
            cors: true ,
            headers: {
                'Access-Control-Allow-Origin': '*',
            },
            beforeSend: function(request) {
                request.setRequestHeader("X-API-KEY", "ysh2zka3fhcn4hsdkcn");
            },
            success: function (result) {
               //console.log(result);
//               console.log(result.Information);
               $.each(result.Information,function(index,data){
                 //  console.log(data.cat_name);
                    var html='<li class="nav-item have_chevron_mouseover" >';
                    html+='<a class="nav-link" href="#">'+data.cat_name+' <i class="fa fa-chevron-down"></i></a></li>';
                    
                    $("#cat_list").append(html);
                    
               });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });