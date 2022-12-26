<?php
  define("__DR__", $_SERVER["DOCUMENT_ROOT"]);
  require_once(__DR__."/admin/libs/includes/php/settings.php");

  AccountLoginControl(false);
  
  if (AccountPermControl($readAccount["id"], "panel_login") == "AUTHORİZATİON_APPROVED") {
    if (get("action") == "control") {
      if (post("webhooksType") !== "" && post("webhooksAPI") !== "" && post("webhooksName") !== "" && post("webhooksTitle") !== "" && post("webhooksContent") !== "") {
        if (post("webhooksType") == "credit") {
          $username = str_replace("[username]", "demo", post("webhooksName"));
          $description = str_replace(array("[username]", "[credit]"), array("demo", "10"), $_POST["webhooksContent"]);
        } else if (post("webhooksType") == "store") {
          $username = str_replace("[username]", "demo", post("webhooksName"));
          $description = str_replace(array("[username]", "[server]", "[product]"), array("demo", "SkyBlock", "VIP"), $_POST["webhooksContent"]);
        } else if (post("webhooksType") == "news") {
          $username = str_replace("[username]", "demo", post("webhooksName"));
          $description = str_replace(array("[username]", "[title]", "[url]"), array("demo", "MineXON ile fark yaratmaya hazır mısın?", $siteURL."haber/minelab-ile-fark-yaratmaya-hazir-misin/1"), $_POST["webhooksContent"]);
        } else if (post("webhooksType") == "comment") {
          $username = str_replace("[username]", "demo", post("webhooksName"));
          $description = str_replace(array("[username]", "[url]"), array("demo", $siteURL."haber/minexonile-fark-yaratmaya-hazir-misin/1"), $_POST["webhooksContent"]);
        } else if (post("webhooksType") == "support") {
          $username = str_replace("[username]", "demo", post("webhooksName"));
          $description = str_replace(array("[username]", "[title]", "[url]"), array("demo", "Oyunda hileler ile karşılaşıyorum", $siteURL."admin/destek/goruntule/1"), $_POST["webhooksContent"]);
        }
        $hookObject = json_encode([
          "username" => $username,
          "avatar_url" => "https://minotar.net/avatar/minexon",
          "tts" => false,
          "embeds" => [
              [
                  "title" => post("webhooksTitle"),
                  "type" => "rich",
                  "image" => [
                    "url" => "https://www.minexon.net/main/theme/assets/images/brand/favicon.png"
                  ],
                  "description" => $description,
                  "color" => hexdec(rand_color()),
                  "footer" => (post("webhooksSignature") == "1") ? [
                      "text" => "Powered by MineXON",
                      "icon_url" => "https://www.minexon.net/main/theme/assets/images/brand/favicon.png"
                  ] : []
              ]
          ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        $sendWebhook = webhooks(post("webhooksAPI"), $hookObject);
        if ($sendWebhook == true) {
          exit('{"code": "__SUCCESSYFULL__"}');
        } else {
          exit('{"code": "__UNSUCCESSYFULL__"}');
        }
      } else {
        exit('{"code": "__UNSUCCESSYFULL__"}');
      }
    } else {
      exit('{"code": "__UNSUCCESSYFULL__"}');
    }
  } else {
    exit('{"code": "__UNSUCCESSYFULL__"}');
  } 
?>