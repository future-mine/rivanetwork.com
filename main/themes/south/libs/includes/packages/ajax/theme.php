<?php
define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
require_once(__DR__."/main/includes/php/settings.php");

if (get("action") == "mode") {
  if (isset($_GET["theme_mode_type"])) {
    if (get("theme_mode_type") == 0) {
      $_SESSION["themeModeType"] = "dark";
    } else if (get("theme_mode_type") == 1) {
      $_SESSION["themeModeType"] = "light";
    } else {
      $_SESSION["themeModeType"] = "dark";
    }
    $returnURL = get("theme_mode_return_url");
    go($returnURL);
  } else {
    go("/404");
  }
} else {
  go("/404");
}
?>