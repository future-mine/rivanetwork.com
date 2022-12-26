var DropImage = (function() {
  var $dropimage = $('[data-toggle="dropimage"]');
  
  if ($dropimage.length) {
    $dropimage.each(function() {
      $(this).dropImage();
    });
  }
})();

var TagsInput = (function() {
  var $tags = $('[data-toggle="tagsinput"]');
  
  if ($tags.length) {
    $tags.each(function() {
      $tags = $(this);
      var $options = {
        tagClass: 'tag-box',
        focusClass: 'tag-input-focus'
      }
      $tags.tagsinput($options);
    });
  }
})();

var TableItems = (function() {
  var $tableitems = $("#tableitems");

  if ($tableitems.length) {
    $tableitems.each(function() {
      $(this).tableitems();
    });
  }
})();

var ReturnConfirm = (function() {
  var $button = $('[confirm-element="confirm"]');
  
  if ($button.length) {
    $button.each(function() {
      var $button = $(this);
      var $href = $button.attr("direct-href");
      var $text = $button.attr("confirm-text");
      
      $button.on("click", function () {
        if (confirm($text)) {
          window.location = $href;
        }
      });
      
    });
  }
})();

var DirectHref = (function () {
  var $direct = $('[direct-element="direct"]');
  
  if ($direct.length) {
    $direct.each(function() {
      var $direct = $(this);
      var $type = $direct.attr("direct-type");
      var $href = $direct.attr("direct-href");
      
      $direct.on("click", function () {
        if ($type == "normal") {
          window.location = $href;
        } else if ($type == "blank") {
          window.open($href, "_blank");
        } else {
          window.location = $href;
        }
      });
      
    });
  }
})();

var Lists = (function () {
  var $tableLists = $('[data-toggle="lists"]');
  var $tableListSort = $("[data-sort]");
  
  if ($tableLists.length) {
    $tableLists.each(function() { 
        var tableLists, tableListSort;
        (tableLists = $(this)),
        new List(tableLists.get(0), {
          valueNames: (tableListSort = tableLists).data("lists-values"),
          listClass: tableListSort.data("lists-class") ? tableListSort.data("lists-class") : "list"
        });
    });
    $tableListSort.on("click", function () {
      return !1;
    });
  }
})();

var CodeMirror = (function() {
  var $input = $('[data-toggle="codeMirror"]');
  
  if ($input.length) {
    $input.each(function() {
      var $options = {
        mode: "css",
        theme: "default",
        lineNumbers: true
      };
      var $codeMirror = CodeMirror.fromTextArea($(this).get(0), $options);
    });
  }
})();

var FroalaEditor = (function() {
  var $editorClass = $(".ckeditor");
  var $placeholder = $editorClass.attr("placeholder");

  var $options = {
    theme: $theme,
    language: $language,
    placeholderText: $placeholder,
    imageUploadURL: '/admin/libs/includes/packages/ajax/froalaimage.php?action=imageUpload',
    toolbarSticky: false,
    toolbarButtons: ['fontFamily', 'fontSize', 'color',  '|', 'bold', 'italic', 'underline', 'strikeThrough', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'quote',  '|', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertTable', '|', 'emoticons', 'insertHR', 'clearFormatting', 'spellChecker', 'html', '|', 'help', '|', 'undo', 'redo'],
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
  var $input = $('[data-toggle="searchAccount"]');
  
  if ($input.length) {
    $input.each(function() {
      $(this).on("keypress", function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
          var $searchAccount = $(this).val();
          window.location.href = $links["admin_player"] + "/" + $searchAccount;
        }
        e.stopPropagation();
      });
    });
  }
  
  $('[language="change"]').on("change", function() {
    window.location = "/admin/index.php?language=" + $(this).val() + "&ref=" + window.location.pathname;
  });
});

var IconPicker = (function() {
  var $iconpicker = $('[data-toggle="iconpicker"]');
  var $inputIcon = $("#iconInput");

  // Select //
  $iconpicker.on("change", function(event) {
    $inputIcon.val(event.icon);
  });

  if ($iconpicker.length) {
    $iconpicker.each(function() {
      var $options = {
        cols: 5,
        rows: 5,
        align: 'center',
        placement: 'bottom',
        icon: 'fa-500px',
        iconset: 'fontawesome4',
        iconsetVersion: "4.7.0",
        arrowClass: 'btn-primary',
        arrowPrevIconClass: 'fa fa-angle-left',
        arrowNextIconClass: 'fa fa-angle-right',
        header: true,
        labelHeader: '{0}/{1}',
        search: true,
        searchText: $languages["search"],
        selectedClass: 'btn-success',
        unselectedClass: '',
        footer: false
      }
      $(this).iconpicker($options);
    });
  }
})();
var ColorPicker = (function() {
  var $colorPicker = $('[data-toggle="colorPicker"]');

  if ($colorPicker.length) {
    $colorPicker.each(function() {
      var $options = {
        customClass: 'colorpicker-2x',
        sliders: {
          saturation: {
            maxLeft: 200,
            maxTop: 200
          },
          hue: {
            maxTop: 200
          },
          alpha: {
            maxTop: 200
          }
        },
        colorSelectors: {
          'black': '#000000',
          'white': '#ffffff',
          'default': '#172b4d',
          'primary': '#5e72e4',
          'success': '#2dce89',
          'info': '#11cdef',
          'warning': '#fb6340',
          'danger': '#f5365c'
        }
      };
      $(this).colorpicker($options);
    });
  }
})();

var OnChangeSelect = (function() {
  var $select = $('[select-change="change"]');

  if ($select.length) {
    $select.each(function() {
      $(this).on("change", function() {
        var $status = $(this).val();
        var $input = $('[select-id="' + $(this).attr("select-input") + '"]');
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