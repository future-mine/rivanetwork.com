var SupportSettings = (function() {
  var $select = $('[data-toggle="answerSelect"]');
  var $textarea = $('[message-id="textareaAnswer"]');
  var $messageContent = $('[data-toggle="messageContent"]');
  
  $select.on("change", function() {
    var $message = $(this).val();
    $('#messageTextarea').froalaEditor("html.set", $message);
  });
  
  $messageContent.scrollTop($messageContent.prop("scrollHeight"));
})();

function dec2hex (dec)
{
  return dec.toString(16).padStart(2, "0")
}

function generateID (len)
{
  var number = new Uint8Array((len || 40) / 2)
  window.crypto.getRandomValues(number)
  return Array.from(number, dec2hex).join('')
}

var RemoveTableItem = (function() {
  var $button = $('[remove-item="button"]');
  
  if ($button.length) {
    $button.each(function() {
      $(this).on("click", function() {
        var $removeID = $(this).attr("remove-id");
        $("#removeID-" + $removeID).html("");
      });
    });
  }
})();

var AddItemTopic = (function() {
  var $button = $('[add-item="topic"]');
  var $table = $('[data-toggle="itemTable"]');
  
  if ($button.length) {
    $button.each(function() {
      $(this).on("click", function() {
        var $elementID = generateID();
        
        $table.append('<tr id=\"removeID-'+$elementID+'\"><td class=\"ml-2 w-90\" style=\"display: grid;\"><div class=\"input-group\"><input type=\"text\" class=\"form-control form-control-prepended\" name=\"contentsTitle[]\" placeholder=\"'+$languages["title"]+'\"><\/div><div class=\"input-group mt-3\"><textarea type=\"text\" class=\"form-control form-control-prepended ckeditor\" name=\"contentsText[]\" placeholder=\"'+$languages["content"]+'\" rows=\"5\"><\/textarea><\/div><\/td><td class=\"text-center align-middle w-10\"><button type=\"button\" remove-item=\"button\" remove-id=\"'+$elementID+'\" class=\"btn btn-danger btn-icon\"><span class=\"far fa-trash-alt\"><\/span><\/button><\/td><\/tr>');
        
        var $removeButton = $('[remove-item="button"]');
        
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

        if ($removeButton.length) {
          $removeButton.each(function() {
            $(this).on("click", function() {
              var $removeID = $(this).attr("remove-id");
              $("#removeID-" + $removeID).remove();
            });
          });
        }
      });
    });
  }
})();