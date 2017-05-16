$(document).ready(function () {

  // to draw a different webmap, just append its id instead
  // webmap.html?id=13750b8b548d48bfa99a9731f2a93ba0

  //var webmapId = '8449792b21af48659aeb77c95dd14858'; // Default WebMap ID
  var webmap = L.esri.webMap(webmapId, { map: L.map("map") });
  var map = webmap._map;
  var urlParams = location.search.substring(1).split('&');
  for(var i=0; urlParams[i]; i++) {
      var param = urlParams[i].split('=');
      if(param[0] === 'webmap') {
          webmapId = param[1]
      }
  }

  webmap.on('metadataLoad', function() {
      var MapTitleControl = L.Control.extend({
          options: {
              position: 'topright'
          },
          onAdd: function (map) {
              var container = L.DomUtil.create('div', 'map-title-control');
              container.innerHTML = '<a target="_brank" href="http://www.arcgis.com/home/webmap/viewer.html?webmap=' + webmapId + '">' + webmap.title + '</a>'; // Add link to a webmap.
              return container;
          }
      });
      webmap._map.addControl(new MapTitleControl());
  });
  webmap.on('load', function() {
      console.log('webmap loaded', webmap.layers);
      var overlayMaps = {};
      webmap.layers.map(function(l) {
          console.log(l);
          overlayMaps[l.title] = l.layer;
      });
      L.control.layers({}, overlayMaps, {
          position: 'bottomright'
      }).addTo(webmap._map);
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
    var content = $("#commentText").val();

    var request = $.ajax({
      url: "includes/add_comment.php",
      type: "POST",
      data: { 'cmt_content': content,
              'cmt_lat': marker.getLatLng().lat,
              'cmt_lng': marker.getLatLng().lng,
              'cmt_article': articleId }
    });
    request.done(function(resp) {
      var resp = $.parseJSON(resp);
      if (resp.success) {
        var popup = marker.bindPopup(resp.content);
        id2marker.set(resp.id, marker);
        $("#commentBox").hide();
        markers.push(marker);
        map.removeLayer(marker);
        map.removeLayer(commentLayer);
        commentLayer = L.layerGroup(markers);
        commentLayer.addTo(map);
        popup.openPopup();
        marker = null;
      }
    });
  });

  $("#mapcontainer").on("click", ".comment-delete", function() {
    var id = parseInt($(this).attr('id'));
    
    var request = $.ajax({
      url: "includes/del_comment.php",
      type: "POST",
      data: { 'cmt_id': id }
    });
    request.done(function(resp) {
      var resp = $.parseJSON(resp);
      if (resp.success) {
        var msg = '<i>(comment removed)</i>';
        $('#'+id+'d').empty();
        $('#'+id+'d').append($(msg));
        id2marker.get(Number(resp.id)).on("click", function() {
          $('#'+id+'d').remove();
        });
      }
    });
  });

  $("#mapcontainer").on("click", ".comment-reply", function() {
    var id = parseInt($(this).attr('id'));
    $('<div class="replyPanel" id="'+id+
      't"><textarea class="replyText" placeholder="enter reply">'+
      '</textarea><br><a class="reply-post" id="'+id+
      's">post</a></div>')
      .insertAfter($(this));
    $(this).remove();
  });

  $("#mapcontainer").on("click", ".reply-post", function() {
    var id = parseInt($(this).attr('id'));
    var content = $('#'+id+'t textarea').val();

    var request = $.ajax({
      url: "includes/add_reply.php",
      type: "POST",
      data: { 'rpl_content': content,
              'thr_id': id }
    });
    request.done(function(resp) {
      var resp = $.parseJSON(resp);
      if (resp.success) {
        $(resp.content).insertBefore('#'+resp.id+'t');
        $('#'+resp.id+'t').remove();
        id2marker.get(Number(resp.id)).on("click", function() {
          $(resp.content).insertBefore('#'+resp.id+'r');
        });
      }
    });
  });

  map.on('move', function () {
    if (marker !== null) {
      marker.setLatLng(map.getCenter());
    }
  });

  $("#showComment").on("click", function() {
    $(this).hide();
    $("#hideComment").show();
    $("#leaveComment").show();
    commentLayer = L.layerGroup(markers);
    commentLayer.addTo(map);
  });
  $("#hideComment").hide();
  $("#leaveComment").hide();
  $("#hideComment").on("click", function() {
    if (marker === null) {
      $(this).hide();
      $("#leaveComment").hide();
      $("#showComment").show();
      map.removeLayer(commentLayer);
    }
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
        right: 0
      }); 
    } else {
      slideoutCom.animate({
        right: -slideoutMapWidth*.4
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
