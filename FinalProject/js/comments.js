$(document).ready(function () {

  $("#postScomment").on("click", function() {
    var content = $("#scommentText").val();

    var request = $.ajax({
      url: "includes/add_scomment.php",
      type: "POST",
      data: { 'cmt_content': content,
              'cmt_article': articleId }
    });
    request.done(function(resp) {
      var resp = $.parseJSON(resp);
      if (resp.success) {
        $("#discussion-section").append($(resp.content));
      }
    });
  });

  $("#discussion-section").on("click", ".scomment-delete", function() {
    var id = parseInt($(this).attr('id'));
    
    var request = $.ajax({
      url: "includes/del_comment.php",
      type: "POST",
      data: { 'cmt_id': id }
    });
    request.done(function(resp) {
      var resp = $.parseJSON(resp);
      if (resp.success) {
        $('#'+id+'sc').empty();
        $('#'+id+'sc').append($('<i>(comment removed)</i>'));
      }
    });
  });

  $("#discussion-section").on("click", ".scomment-reply", function() {
    var id = parseInt($(this).attr('id'));
    $('<div id="'+id+'srt"><textarea class="sreplyText" placeholder="enter reply">'+
      '</textarea><br><a class="sreply-post" id="'+id+'srp">post</a></div>')
      .insertAfter($(this));
    $(this).remove();
  });

  $("#discussion-section").on("click", ".sreply-post", function() {
    var id = parseInt($(this).attr('id'));
    var content = $('#'+id+'srt textarea').val();

    var request = $.ajax({
      url: "includes/add_sreply.php",
      type: "POST",
      data: { 'rpl_content': content,
              'thr_id': id }
    });
    request.done(function(resp) {
      var resp = $.parseJSON(resp);
      if (resp.success) {
        $(resp.content).insertBefore('#'+resp.id+'srt');
        $('#'+resp.id+'srt').remove();
      }
    });
  });

});