var $statusClick = true;
function addFooterGenaralChat() {
  var $message = $("#footer-message-input").val();
  if ($message !== "") {
    if ($statusClick == true && $message != null) {
      $.ajax({
        type: "POST",
        url: "/main/themes/south/libs/includes/packages/ajax/message.php?action=messageSend",
        data: {message: $message},
        success: function(result) {
          $statusClick = true;
          $("#footer-message-input").val("");
          $("#footer-message-box").append('<div class="chat-widget-speaker right"><p class="chat-widget-speaker-message">' + result + '</p><p class="chat-widget-speaker-timestamp">' + $languages["justNow"] + '</p></div>');
          updateFooterMessageBoxScroll();
        }
      });
    }
  } else {
    swal.fire({
      title: $languages["error"],
      text: $languages["alertMessageNone"],
      type: "error",
      confirmButtonColor: "#02b875",
      confirmButtonText: $languages["okey"]
    });
  }
}

$("#footer-message-input").on("keypress", function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) {
    addFooterGenaralChat();
    $statusClick = false;
  }
  e.stopPropagation();
});

var alertDanger = '<div class="mt-alert mt-alert-danger"><span class="mt-alert-text">'+$languages["alertNotMessage"]+'</span></div>';

function updateFooterMessageBox() {
  $.ajax({
    type: "GET",
    url: "/main/themes/south/libs/includes/packages/ajax/message.php?action=messageBoxUpdate",
    success: function(result) {
      if (result == "false") {
        $("#footer-message-box").html(alertDanger);
      } else {
        $("#footer-message-box").html(result);
        updateFooterMessageBoxScroll();
      }
    }
  });
}

var scrollElement = $("#footer-message-box");
var scrollHeight = scrollElement.prop("scrollHeight");

function updateFooterMessageBoxScroll() {
  if (scrollHeight < scrollElement.prop("scrollHeight")) {
    scrollElement.scrollTop(scrollElement.prop("scrollHeight"));
    scrollHeight = scrollElement.prop("scrollHeight");
  }
}

$("#footer-message-box-refresh").on("click", function() {
  var boxInfo = document.getElementById('footer-message-box-info');
  var boxLoader = document.getElementById('footer-message-box-loader');
  boxInfo.style.display = "none";
  boxLoader.style.display = "block";
  $.ajax({
    type: "GET",
    url: "/main/themes/south/libs/includes/packages/ajax/message.php?action=info",
    success: function(result) {
      if (result == "true") {
        boxInfo.style.display = "block";
        boxLoader.style.display = "none";
        updateFooterMessageBox();
      } else if (result == "false") {
        swal.fire({
          title: $languages["error"],
          text: $languages["alertMessageSpam"],
          type: "error",
          confirmButtonColor: "#02b875",
          confirmButtonText: $languages["okey"]
        });
        boxInfo.style.display = "block";
        boxLoader.style.display = "none";
      }
    }
  });
});

$(document).ready(function() {
  updateFooterMessageBox(true);
});