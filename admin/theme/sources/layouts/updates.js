$(document).ready(function() {
    $.ajax({
      type: "POST",
      url: "/admin/libs/includes/packages/ajax/update.php?action=updateVersionListBox",
      data: {transaction: "updateListBox"},
      success: function(result) {
        if (result == "not_found") {
          $('[data-toggle="update-lists"]').html('<div class="alert alert-icon-danger" role="alert"><i data-feather="x-circle"></i>' + $languages["updatesAlertNot"] + '</div>');
        } else {
          $('[data-toggle="update-lists"]').html(result);
          // TABLELISTS INIT
          var tableLists = $('[data-toggle="lists"]');
          var tableListSort = $("[data-sort]");
          tableLists.length && tableLists.each(function () {
            var tableLists, tableListSort;
            (tableLists = $(this)),
            new List(tableLists.get(0), {
              valueNames: (tableListSort = tableLists).data("lists-values"),
              listClass: tableListSort.data("lists-class") ? tableListSort.data("lists-class") : "list"
            });
          }),
          tableListSort.on("click", function () {
            return !1;
          });
          // UPDATE BUTTON INIT 
          var $updateButtons = $('[updates="button"]');
          if ($updateButtons.length) {
            $updateButtons.each(function() {
              $(this).on("click", function () {
                var version = $(this).attr("version");
                var token = $(this).attr("token");
                Swal.fire({
                  title: $languages["warning"],
                  text: $languages["updatesApproveText"].replace("&version", version),
                  icon: "warning",
                  background: $sweetAlertBackgroundColor,
                  showCancelButton: true,
                  confirmButtonColor: "#02b875",
                  cancelButtonColor: "#f5365c",
                  cancelButtonText: $languages["giveUp"],
                  confirmButtonText: $languages["approve"],
                  reverseButtons: true
                }).then(function(isAccepted) {
                  if (isAccepted.value) {
                    swal.fire({
                      title: $languages["warning"],
                      html: $languages["updatesUpdateLoading"],
                      icon: "warning",
                      background: $sweetAlertBackgroundColor,
                      allowOutsideClick: false,
                      showConfirmButton: false
                    });
                    $.ajax({
                      type: "POST",
                      url: "/admin/libs/includes/packages/ajax/update.php?action=update",
                      data: {transaction: "update", version: version, token: token},
                      success: function(result) {
                        var ajaxResult = JSON.parse(result);
                        if (ajaxResult.status == "successfull") {
                          swal.fire({
                            title: $languages["success"],
                            text: $languages["updatesAlertSuccess"].replace("&version", version),
                            icon: "success",
                            background: $sweetAlertBackgroundColor,
                            confirmButtonColor: "#02b875",
                            confirmButtonText: $languages["okey"]
                          }).then(function() { 
                            location.reload();
                          });
                        } else {
                          swal.fire({
                            title: $languages["error"],
                            text: ajaxResult.reason,
                            icon: "warning",
                            background: $sweetAlertBackgroundColor,
                            confirmButtonColor: "#02b875",
                            confirmButtonText: $languages["okey"]
                          }).then(function() { 
                            location.reload();
                          });
                        }
                      }
                    });
                  }
                });
              });
            });
          }
        }
      }
    });
});