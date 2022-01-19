$(document).ready(function(){
     $.noConflict();
     $('#table9')
     .DataTable(
        {
            responsive: true,
            autoWidth: false
        });
})

$(function(){
  $(".accordion-titulo").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content");

        if(contenido.css("display")=="none"){ //open        
          contenido.slideDown(250);         
          $(this).addClass("open");
          $("#contenido-3").hide();
          $("#titulo-3").removeClass("open");
          $("#contenido-2").hide();
          $("#titulo-2").removeClass("open"); 
        }
        else{ //close       
          contenido.slideUp(250);
          $(this).removeClass("open");  
        }

      });
  $(".accordion-titulo-2").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content-2");

        if(contenido.css("display")=="none"){ //open        
          contenido.slideDown(250);         
          $(this).addClass("open");
          $("#contenido-1").hide();
          $("#titulo-1").removeClass("open");
          $("#contenido-3").hide();
          $("#titulo-3").removeClass("open"); 
        }
        else{ //close       
          contenido.slideUp(250);
          $(this).removeClass("open");  
        }

      });
  $(".accordion-titulo-3").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content-3");
 

        if(contenido.css("display")=="none"){ //open        
          contenido.slideDown(250);         
          $(this).addClass("open");
          $("#contenido-1").hide();
          $("#titulo-1").removeClass("open");
          $("#contenido-2").hide();
          $("#titulo-2").removeClass("open"); 
        }
        else{ //close

          contenido.slideUp(250);
          $(this).removeClass("open");
          
            
        }

      });
});
