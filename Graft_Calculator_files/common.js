/*NAROLA INFOTECH 2016*/
     $(function() {
      $( "#slider-range-max" ).slider({
          range: "max",
          min: 0,
          max: 45,
          value: 0,
          slide: function( event, ui ) {
            // 1
            $( "#graft1" ).text( (ui.value)*11 ),
            $( "#hair1" ).text( (ui.value)*14 );
            // 2
            $( "#graft2" ).text( (ui.value)*22 ),
            $( "#hair2" ).text( (ui.value)*40 );
            // 3
            $( "#graft3" ).text( (ui.value)*35 ),
            $( "#hair3" ).text( (ui.value)*92 );
            // 4
            $( "#graft4" ).text( (ui.value)*26 ),
            $( "#hair4" ).text( (ui.value)*69 );
            // 5
            $( "#graft5" ).text( (ui.value)*31 ),
            $( "#hair5" ).text( (ui.value)*80 );
            // 6
            $( "#graft6" ).text( (ui.value)*26 ),
            $( "#hair6" ).text( (ui.value)*64 );
            // 7
            $( "#graft7" ).text( (ui.value)*24 ),
            $( "#hair7" ).text( (ui.value)*61 );
          }
        });
        // 1
        // $( "#graft1" ).text( $( "#slider-range-max" ).slider( "value" )*5 );
        // $( "#hair1" ).text( $( "#slider-range-max" ).slider( "value" )*4 );
        // 3
        // $( "#graft3" ).text( $( "#slider-range-max" ).slider( "value" )*2.028571428571429 );
        // $( "#hair3" ).text( $( "#slider-range-max" ).slider( "value" )*2 );
      }); 

      // area1
      $('.area1').hover(function(){
        $('.area1').children('path').css('fill','#cc6600');
        }, function(){
        $('.area1').children('path').css('fill','transparent');
      });
      $('.area1').click(function(e){     
        e.preventDefault(); 
        if($('.area1').attr('class')=='area1 activearea'){
          $('.area1').attr("class", "area1");
          $('.selected-area ul li:first-child').removeClass('active');
        }  
        else{
          $('.area1').attr("class", "area1 activearea");
          $('.selected-area ul li:first-child').addClass('active');
        }        
      });
      // area2
      $('.area2').hover(function(){
        $('.area2').children('path').css('fill','#cc6600');
        }, function(){
        $('.area2').children('path').css('fill','transparent');
      });
      $('.area2').click(function(e){
        e.preventDefault(); 
        if($('.area2').attr('class')=='area2 activearea'){
          $('.area2').attr("class", "area2");
          $('.selected-area ul li:nth-child(2)').removeClass('active');
        }  
        else{
          $('.area2').attr("class", "area2 activearea");
          $('.selected-area ul li:nth-child(2)').addClass('active');
        }        
      });
      // area3
      $('.area3').hover(function(){
        $('.area3').children('path').css('fill','#cc6600');
        }, function(){
        $('.area3').children('path').css('fill','transparent');
      });
      $('.area3').click(function(e){     
        e.preventDefault(); 
        if($('.area3').attr('class')=='area3 activearea'){
          $('.area3').attr("class", "area3");
          $('.selected-area ul li:nth-child(3)').removeClass('active');
        }  
        else{
          $('.area3').attr("class", "area3 activearea");
          $('.selected-area ul li:nth-child(3)').addClass('active');
        }           
      });
      // area4
      $('.area4').hover(function(){
        $('.area4').children('path').css('fill','#cc6600');
        }, function(){
        $('.area4').children('path').css('fill','transparent');
      });
      $('.area4').click(function(e){     
        e.preventDefault(); 
        if($('.area4').attr('class')=='area4 activearea'){
          $('.area4').attr("class", "area4");
          $('.selected-area ul li:nth-child(4)').removeClass('active');
        }  
        else{
          $('.area4').attr("class", "area4 activearea");
          $('.selected-area ul li:nth-child(4)').addClass('active');
        }         
      });
      // area5
      $('.area5').hover(function(){
        $('.area5').children('path').css('fill','#cc6600');
        }, function(){
        $('.area5').children('path').css('fill','transparent');
      });
      $('.area5').click(function(e){     
        e.preventDefault(); 
        if($('.area5').attr('class')=='area5 activearea'){
          $('.area5').attr("class", "area5");
          $('.selected-area ul li:nth-child(5)').removeClass('active');
        }  
        else{
          $('.area5').attr("class", "area5 activearea");
          $('.selected-area ul li:nth-child(5)').addClass('active');
        }         
      });
      // area6
      $('.area6').hover(function(){
        $('.area6').children('path').css('fill','#cc6600');
        }, function(){
        $('.area6').children('path').css('fill','transparent');
      });
      $('.area6').click(function(e){     
        e.preventDefault(); 
        if($('.area6').attr('class')=='area6 activearea'){
          $('.area6').attr("class", "area6");
          $('.selected-area ul li:nth-child(6)').removeClass('active');
        }  
        else{
          $('.area6').attr("class", "area6 activearea");
          $('.selected-area ul li:nth-child(6)').addClass('active');
        }         
      });
      // area7
      $('.area7').hover(function(){
        $('.area7').children('path').css('fill','#cc6600');
        }, function(){
        $('.area7').children('path').css('fill','transparent');
      });
      $('.area7').click(function(e){     
        e.preventDefault(); 
        if($('.area7').attr('class')=='area7 activearea'){
          $('.area7').attr("class", "area7");
          $('.selected-area ul li:nth-child(7)').removeClass('active');
        }  
        else{
          $('.area7').attr("class", "area7 activearea");
          $('.selected-area ul li:nth-child(7)').addClass('active');
        }        
      });

      $('.area1, .area2, .area3, .area4, .area5, .area6, .area7').click(function(){
        if($('.selected-area ul').children('li.active').length > 0) {
          $('#calc').addClass('btn-blinking');
          $('#show2').show();
          $('#show1').hide();
        }else{
          $('#calc').removeClass('btn-blinking');
        }
      });

      $('#calc').click(function(){
        var totalhair = 0;
        var totalgraft = 0;
        $( ".selected-area ul>li" ).each(function(){
          if($(this).attr('class')=='active'){
            totalhair = totalhair + parseInt($(this).children('span:first-child').text());
            totalgraft = totalgraft + parseInt($(this).children('span:last-child').text());
          }
          $('.tot-hairs').val(totalhair);
          $('.tot-grafts').val(totalgraft);
        });
      });

       $('#reset').click(function(){
          $('.area1').attr("class", "area1");
          $('.area2').attr("class", "area2");
          $('.area3').attr("class", "area3");
          $('.area4').attr("class", "area4");
          $('.area5').attr("class", "area5");
          $('.area6').attr("class", "area6");
          $('.area7').attr("class", "area7");
          $('.selected-area ul>li').attr("class","");
          $('.tot-grafts').val("");
          $('.tot-hairs').val("");
          $('.ui-slider-horizontal .ui-slider-handle').css('left','0%');
       });

