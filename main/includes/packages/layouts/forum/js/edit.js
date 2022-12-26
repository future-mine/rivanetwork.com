var FroalaEditor = (function() {
    var $editorClass = $(".forum-editor");
    var $placeholder = $editorClass.attr("placeholder");
  
    var $options = {
      theme: $themeMode,
      language: $language,
      placeholderText: $placeholder,
      imageUploadURL: '/main/includes/packages/ajax/froalaimage.php?action=imageUpload',
      toolbarSticky: false,
      toolbarButtons: ['fontFamily', 'fontSize', 'color',  '|', 'bold', 'italic', 'underline', 'strikeThrough', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'quote',  '|', 'insertLink', 'insertImage', 'embedly', 'insertTable', '|', 'emoticons', 'insertHR', 'clearFormatting', 'spellChecker', 'html', '|', 'help', '|', 'undo', 'redo'],
      heightMin: 150,
      heightMax: 300
    };
  
    if ($editorClass.length) {
      $editorClass.each(function() {
        $(this).froalaEditor($options);
      });
    }
})();
  
$(document).ready(function() {
  if ($('[forum="topicRemove"]').length) {
    $('[forum="topicRemove"]').each(function() {
      $(this).on("click", function() {
        var $topicID = $(this).attr("topic-id");
        var $ajaxUrl = "/main/includes/packages/layouts/forum/php/proccess.php?action=topicRemove";
        swal.fire({
          title: $languages["areYouSure"],
          text: $languages["forumRemoveTopicAreYouSure"],
          showCancelButton: true,
          confirmButtonColor: "#02b875",
          cancelButtonColor: "#f5365c",
          confirmButtonText: $languages["approve"],
          cancelButtonText: $languages["giveUp"],
          reverseButtons: true
        }).then(function(isAccepted) {
          if (isAccepted.value) {
            $.ajax({
              type: "POST",
              url: $ajaxUrl,
              data: {topicID: $topicID},
              success: function(result) {
                var ajaxData = JSON.parse(result);
                if (ajaxData.code == "successyfull") {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["forumRemoveTopicSuccess"],
                    icon: "success",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  }).then(function() {
                    location.reload();
                  });
                } else if (ajaxData.code == "notLogin") {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["forumNotLogin"],
                    icon: "warning",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  });
                } else if (ajaxData.code == "notIsTopic") {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["forumNotYouTopic"],
                    icon: "warning",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  });
                } else if (ajaxData.code == "alreadyTopicRemove") {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["forumIsRemoveTopic"],
                    icon: "warning",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  });
                } else {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["systemError"],
                    icon: "warning",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  });
                }
              }
              });
          }
        });
      });
    });
  }
  if ($('[forum="messageRemove"]').length) {
    $('[forum="messageRemove"]').each(function() {
      $(this).on("click", function() {
        var $messageID = $(this).attr("message-id");
        var $ajaxUrl = "/main/includes/packages/layouts/forum/php/proccess.php?action=messageRemove";
        swal.fire({
          title: $languages["areYouSure"],
          text: $languages["forumRemoveMessageAreYouSure"],
          showCancelButton: true,
          confirmButtonColor: "#02b875",
          cancelButtonColor: "#f5365c",
          confirmButtonText: $languages["approve"],
          cancelButtonText: $languages["giveUp"],
          reverseButtons: true
        }).then(function(isAccepted) {
          if (isAccepted.value) {
            $.ajax({
              type: "POST",
              url: $ajaxUrl,
              data: {messageID: $messageID},
              success: function(result) {
                var ajaxData = JSON.parse(result);
                if (ajaxData.code == "successyfull") {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["forumRemoveMessageSuccess"],
                    icon: "success",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  }).then(function() {
                    location.reload();
                  });
                } else if (ajaxData.code == "notLogin") {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["forumNotLogin"],
                    icon: "warning",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  });
                } else if (ajaxData.code == "notIsTopic") {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["forumYouNotMessage"],
                    icon: "warning",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  });
                } else if (ajaxData.code == "alreadyMessageRemove") {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["forumIsRemoveMessage"],
                    icon: "warning",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  });
                } else {
                  swal.fire({
                    title: $languages["info"],
                    text: $languages["systemError"],
                    icon: "warning",
                    confirmButtonColor: "#02b875",
                    confirmButtonText: $languages["okey"]
                  });
                }
              }
              });
          }
        });
      });
    });
  }
  if ($('[forum="report"]').length) {
    $('[forum="report"]').each(function() {
      $(this).on("click", function() {
        var $type = $(this).attr("type");
        var $reportID = $(this).attr("report-id");
        var $ajaxUrl = "/main/includes/packages/layouts/forum/php/proccess.php?action=report";
        swal.fire({
          title: $languages["forumMessageReportTitle"],
          html: '<br><div class="form-row"><div class="form-item"><div class="form-input small active"><label for="reportMessageVal">' + $languages["message"] + '</label><input type="text" id="reportMessageVal" reportMessage="val" name="reportMessageVal"></div></div></div>',
          showCancelButton: true,
          confirmButtonColor: "#02b875",
          cancelButtonColor: "#f5365c",
          confirmButtonText: $languages["approve"],
          cancelButtonText: $languages["giveUp"],
          reverseButtons: true
        }).then(function(isAccepted) {
          if (isAccepted.value) {
            var $reportText = $('[reportMessage="val"]').val();
            if ($reportText !== "") {
              $.ajax({
                type: "POST",
                url: $ajaxUrl,
                data: {type: $type, reportID: $reportID, message: $reportText},
                success: function(result) {
                  var ajaxData = JSON.parse(result);
                  if (ajaxData.code == "successyfull") {
                    swal.fire({
                      title: $languages["info"],
                      text: $languages["forumMessageReportSuccess"],
                      icon: "success",
                      confirmButtonColor: "#02b875",
                      confirmButtonText: $languages["okey"]
                    }).then(function() {
                      location.reload();
                    });
                  } else if (ajaxData.code == "notLogin") {
                    swal.fire({
                      title: $languages["info"],
                      text: $languages["forumNotLogin"],
                      icon: "warning",
                      confirmButtonColor: "#02b875",
                      confirmButtonText: $languages["okey"]
                    });
                  } else if (ajaxData.code == "alreadyReport") {
                    swal.fire({
                      title: $languages["info"],
                      text: $languages["forumAlreadyReport"],
                      icon: "warning",
                      confirmButtonColor: "#02b875",
                      confirmButtonText: $languages["okey"]
                    });
                  } else if (ajaxData.code == "notReportMessage") {
                    swal.fire({
                      title: $languages["info"],
                      text: $languages["forumMessageNotfound"],
                      icon: "warning",
                      confirmButtonColor: "#02b875",
                      confirmButtonText: $languages["okey"]
                    });
                  } else {
                    swal.fire({
                      title: $languages["info"],
                      text: $languages["systemError"],
                      icon: "warning",
                      confirmButtonColor: "#02b875",
                      confirmButtonText: $languages["okey"]
                    });
                  }
                }
                });
            } else {
              swal.fire({
                title: $languages["info"],
                text: $languages["forumPleaseEnterMessage"],
                icon: "warning",
                confirmButtonColor: "#02b875",
                confirmButtonText: $languages["okey"]
              });
            }
          }
        });
      });
    });
  }

  var $activeUsers = $('[data-toggle="activeUsers"]');
  if ($activeUsers.length) {
    $activeUsers.each(function() {
      $.ajax({
        type: "POST",
        url: "/main/includes/packages/layouts/forum/php/proccess.php?action=activeUsers",
        data: {action: "activeUsers"},
        success: function(result) {
          $('[data-toggle="activeUsers"]').html(result);
        }
      });
    });
  }
});