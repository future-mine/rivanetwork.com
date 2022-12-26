<?php
	define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
	require_once(__DR__."/main/includes/php/settings.php");

	require_once(__DR__."/main/includes/packages/class/froalaeditor/lib/FroalaEditor.php");

    if (get("action") == "imageUpload") {
	  try {
	    $imageUpload = FroalaEditor_Image::upload('/assets/uploads/images/upload/');
        if (isset($imageUpload->link)) {
          $imageUpload->link = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http")."://".$_SERVER["SERVER_NAME"].$imageUpload->link;
        }
	    echo stripslashes(json_encode($imageUpload));
	  } catch (Exception $e) {
	    echo $e->getMessage();
	  }
	} else {
		die(false);
	}
?>
