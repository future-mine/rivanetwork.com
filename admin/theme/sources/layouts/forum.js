var ForumCategoryType = (function() {
  var $select = $('[data-toggle="categoryType"]');
  var $input = $('[data-toggle="categoryTypeSelect"]');
  
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