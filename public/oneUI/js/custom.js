$(document).ready(function(){

    $('.nav-main-link-submenu').click(function(){
        console.log('hai')
    })

    let subItem = '';
    
    $(".nav-sub").click(function(){            
       subItem = $(this).attr("data-name");   
       $(this).parent().parent().addClass('non');     
       $(".nav-subItems-"+subItem).addClass('active');              
    })
    

    
    $(document).on("click",".sub-item-show",function(){
        $('.main-nav').addClass('active')
        $('.main-nav').removeClass('non')
        console.log(subItem)
        $(".nav-subItems-"+subItem).addClass('non');              
        $(".nav-subItems-"+subItem).removeClass('active');              
    })        

})