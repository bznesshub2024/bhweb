<html>
<head>
  <title>Multiplication Table</title>
<script>

$(document).ready(function() {
    console.log( "ready!" );

get_category();
        
    

});

</script>



<script>
        function get_category(){
          
          //  alert( "sdfs" );
            var count =1;
            $.ajax({
              method: 'POST',
              url: 'https://www.a2zshop.in/API/index.php/app/getCategory',
              data: {
                code: "123",
                parentid: parentvalue
              },
              success: function(response){
                          alert(response); // display response from the PHP script, if any
                           // var data = $.parseJSON(response);

                              /* $("#cat_list").empty();
                             var parsedJSON = JSON.parse(response);
                             
                              $("#bredcrum").text(parsedJSON.parentv); 
                            //  alert(" parent "+parsedJSON.parentv);
                             var data = parsedJSON.subcat; 
                             //   alert("data size "+data.length);
                            var order = data.length;    
                            $(data).each(function() {
                                    //alert(this.rollno);
                                    var optionsAsString = "";
                                    for(var i = 0; i < data.length; i++) {
                                        if(this.orderno == i){
                                             optionsAsString += "<option value='" + i + "' selected >" + i + "</option>";
                                            
                                        }else{
                                            optionsAsString += "<option value='" + i + "' >" + i + "</option>";
                                            
                                        }
                                    }
                                //  $("#cat_list").append('<li><input type="checkbox" name="chkbox"  value="'+this.id+'"/><lable>'+this.name+'</label> </li>');
                                    $("#cat_list").append('<li> <div class="checkbox-inline1"><input  type="checkbox" class="chkboxx" name="chkbox" value="'+this.id+'"><select name="catorderlist" class="catorderlist" style="margin-left:10px; margin-right:10px;">'+optionsAsString+'</select><label class = "cat-name"> '+this.name+'</label> <img src='+this.img+' style="width: 72px; height: 72px;  border-radius: 50%;">'+
                                                           '</div></li>');
                                
                                count = count+1;    
                            });
                            
                            $(".cat-name").click(function() {
                                 var $row = $(this).closest("li");    // Find the row
                                 var text = $row.find(".chkboxx").val(); 
                                 parentvalue = text;
                                // alert("cat ID "+text); 
                                 getCategory()
                          
                            });
                            
                            $('select[name="catorderlist"]').on('change', function(){   
                                   var $row = $(this).closest("li");    // Find the row
                                 var text = $row.find(".chkboxx").val(); 
                              
                               // alert("catid "+text+"---"+$(this).val());   
                                editCatOrder(text,$(this).val() );
                            });
                            */
                          
                    }

            }); 
        }
</script>
</head>
<body>
</body>
</html>