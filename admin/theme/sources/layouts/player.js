var PlayerBannedDuration = (function() {
  var $select = $('[data-toggle="bannedDurationStatus"]');
  var $input = $('[data-toggle="bannedDuration"]');
  
  $select.on("change", function() {
    var $status = $select.val();
    if ($status == 0) {
      $input.css("display", "none");
    } else if ($status == 1) {
      $input.css("display", "block");
    } else {
      $input.css("display", "none");
    }
  });
})();

var PermissionView = (function() {
  var $select = $('[view-command="permissionView"]');
  if ($select.length) {
    $select.each(function() {
      var $slt = $(this);
      $slt.on("change", function() {
        var $status = $slt.val();
        var $divID = $slt.attr("view-code");
        var $input = $("#" + $divID);
        if ($status == 0) {
          $input.css("display", "none");
        } else if ($status == 1) {
          $input.css("display", "block");
        } else {
          $input.css("display", "none");
        }
      });
    });
  }
})();