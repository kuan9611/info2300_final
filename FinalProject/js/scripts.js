$(function(){
  var $searchlink = $('#searchtoggl i');
  var $searchbar  = $('#searchbar');
  
  $('#topnav a').on('click', function(e){
    e.preventDefault();
    
    if($(this).attr('id') == 'searchtoggl') {
      if(!$searchbar.is(":visible")) { 
        // if invisible we switch the icon to appear collapsable
        $searchlink.removeClass('fa-search').addClass('fa-search-minus');
      } else {
        // if visible we switch the icon to appear as a toggle
        $searchlink.removeClass('fa-search-minus').addClass('fa-search');
      }
      
      $searchbar.slideToggle(300, function(){
        // callback after search bar animation
      });
    }
  });
  
  $('#searchform').submit(function(e){
    e.preventDefault(); // stop form submission
  });
});


$(document).ready(function () {
    $('#maptoggle').on('click', function(e){
      e.preventDefault();
      // create menu variables
      var screenWidth = $(window).width();
      var slideoutMap = $('#mapcontainer');
      var slideoutMapWidth = $('#mapcontainer').width();
      var slideoutCom = $('#leaveComment');
      // toggle open class
      slideoutMap.toggleClass("open");
      slideoutCom.toggleClass("open");

      if (slideoutCom.hasClass("open")) {
        slideoutCom.animate({
          left: 0
        }); 
      } else {
        slideoutCom.animate({
          left: -slideoutMapWidth*.4
        }, 250)
      }
      // slide menu
      if (slideoutMap.hasClass("open")) {
        $('#maptoggle').css("background-color","black")
        $('#maptoggle').css("opacity",".7")
        slideoutMap.animate({
          right: 0
        }); 
      } else {
        $('#maptoggle').css("background-color","#b00d10")
        $('#maptoggle').css("opacity","1")
        slideoutMap.animate({
          right: -slideoutMapWidth*2
        }, 250)
      }
    });
    $(window).resize(function(){
    });
});