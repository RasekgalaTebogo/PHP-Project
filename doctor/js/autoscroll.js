
    var scrollY = 0;
    var distance = 40;
    var speed = 24;
    
                
    function setFocus() {
                     
         document.getElementById("name").blur();
    }
                
   function scrollFocus(el) {
       //code
          var currentY = window.pageYOffset;
          var target = document.getElementById(el).offsetTop;
          var bodyHeight = document.body.offsetHeight;
          var yPos = currentY + window.innerHeight;
          
          var animation = setTimeout('scrollFocus(\''+el+'\')', 24);
          
          if (yPos > bodyHeight) {
            //code
            clearTimeout(animation);
           
            
          }else if (yPos > bodyHeight) {
            //code
             if (currentY < target) {
                //code
                scrollY =  currentY - distance;
                window.scroll(0,scrollY);
               }else{
                    clearTimeout(animation);
               }
          }
          else{
               if (currentY < target-distance) {
                //code
                scrollY =  currentY + distance;
                window.scroll(0,scrollY);
               }else{
                    clearTimeout(animation);
               }
          }
    }
    function contact() {
        //code
               
        document.getElementById("test").scrollIntoView();
    }