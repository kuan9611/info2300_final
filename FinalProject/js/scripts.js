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
  $('#menu').slicknav({appendTo: '#mobilemenu'});
});

$(document).ready(function () {

  // to draw a different webmap, just append its id instead
  // webmap.html?id=13750b8b548d48bfa99a9731f2a93ba0

  var webmapId = '22c504d229f14c789c5b49ebff38b941'; // Default WebMap ID
  var webmap = L.esri.webMap(webmapId, { map: L.map("map") });
  var map = webmap._map;
  
  webmap.on('load', function() {
      var overlayMaps = {};
      webmap.layers.map(function(l) {
          overlayMaps[l.title] = l.layer;
      });
      L.control.layers({}, overlayMaps, {
          position: 'bottomright'
      }).addTo(map);
  });

  L.control.mousePosition().addTo(map);

  function getIdfromUrl() {
    var urlParams = location.search.substring(1).split('&');
    for (var i=0; urlParams[i]; i++) {
        var param = urlParams[i].split('=');
        if(param[0] === 'id') {
            webmapId = param[1];
        }
    }
  }

  var marker = null;
  var markers = [];
  var commentLayer;

  $("#leaveComment").on("click", function() {
    if (marker === null) {
      marker = L.marker(map.getCenter()).addTo(map);
      $("#commentBox").show();
    }
  });
  $("#cancelComment").on("click", function() {
    map.removeLayer(marker);
    marker = null;
    $("#commentBox").hide();
  });
  $("#postComment").on("click", function() {
    var popup = marker.bindPopup($("#commentText").val());
    $("#commentBox").hide();
    markers.push(marker);
    map.removeLayer(marker);
    if ($("#hideComment").is(":visible")) {
      map.removeLayer(commentLayer);
      commentLayer = L.layerGroup(markers);
      commentLayer.addTo(map);
      popup.openPopup();
    }
    marker = null;
  });
  map.on('move', function () {
    if (marker !== null) {
      marker.setLatLng(map.getCenter());
    }
  });

  $("#showComment").on("click", function() {
    $(this).hide();
    $("#hideComment").show();
    commentLayer = L.layerGroup(markers);
    commentLayer.addTo(map);
  });
  $("#hideComment").hide();
  $("#hideComment").on("click", function() {
    $(this).hide();
    $("#showComment").show();
    map.removeLayer(commentLayer);
  });

  $('#maptoggle').on('click', function(e){
    e.preventDefault();
    // create menu variables
    var screenWidth = $(window).width();
    var slideoutMap = $('#mapcontainer');
    var slideoutMapWidth = $('#mapcontainer').width();
    var slideoutCom = $('#leaveComment, #showComment, #hideComment');
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
      if (marker !== null) {
        $("#commentBox").delay(400).show(0);
      }
    } else {
      $('#maptoggle').css("background-color","#b00d10")
      $('#maptoggle').css("opacity","1")
      slideoutMap.animate({
        right: -slideoutMapWidth*2
      }, 250);
      $("#commentBox").hide();
    }
  });
  $(window).resize(function(){
  });
});
