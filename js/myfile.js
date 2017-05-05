$(document).ready(function () {
                         $('body').on('click','button[data-target="#myModal2"]', function () {
                             var Sell_ID = $(this).data('id');       
                            $(".modal-body #sellID").val(Sell_ID);

                   });
                   
                   
                         $('body').on('click','button[data-target="#myModal3"]', function () {
                             var update_ID = $(this).data('id');  
                            $(".modal-body #updateID").val(update_ID);
                          
                          $('.disabled').click(function(e){
     e.preventDefault();
  })  
                          

                   });
                   
    });
    
