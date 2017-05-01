$(function(){
  var $searchlink = $('#searchtoggl i');
  var $searchbar  = $('#searchbar');
  
  $('#searchtoggl').on('click', function(e){
      e.preventDefault();

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

  });
  
  $('#searchform').submit(function(e){
    e.preventDefault(); // stop form submission
  });
});

$(function(){
  $('#logout').on('click', function(e) {
    e.preventDefault();
    $.get('includes/killsession.php', function() {
      window.location = window.location;
    });
  });
});

$(function(){
  $('#menu').slicknav({appendTo: '#mobilemenu'});
});
