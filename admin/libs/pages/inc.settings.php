<?php if (AccountPermControl($readAccount["id"], "settings") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php if (get("action") == "general") { ?>
<?php if (AccountPermControl($readAccount["id"], "settings_public") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php
  $settingsVariables = array(
    "1" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "serverName",
      "type" => 0,
      "ID" => "settings-general-server-name",
      "name" => "settingsServerName",
      "title" => languageVariables("serverName", "settings", $languageType),
      "placeholder" => languageVariables("serverNamePlaceholder", "settings", $languageType),
      "value" => $rSettings["serverName"]
    ),
    
    "2" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "IPAdres",
      "type" => 0,
      "ID" => "settings-general-server-ip",
      "name" => "settingsServerIP",
      "title" => languageVariables("serverIP", "settings", $languageType),
      "placeholder" => languageVariables("serverIPPlaceholder", "settings", $languageType),
      "value" => $rSettings["IPAdres"]
    ),
    
    "3" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "metaTitle",
      "type" => 0,
      "ID" => "settings-general-seo-title",
      "name" => "settingsSeoTitle",
      "title" => languageVariables("metaTitle", "settings", $languageType),
      "placeholder" => languageVariables("metaTitlePlaceholder", "settings", $languageType),
      "value" => $rSettings["metaTitle"]
    ),
    
    "4" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "metaKeyword",
      "type" => 0,
      "ID" => "settings-general-seo-keyword",
      "name" => "settingsSeoKeyword",
      "title" => languageVariables("metaKeywords", "settings", $languageType),
      "placeholder" => languageVariables("metaKeywordsPlaceholder", "settings", $languageType),
      "value" => $rSettings["metaKeyword"]
    ),
    
    "5" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "metaDescription",
      "type" => 1,
      "ID" => "settings-general-seo-description",
      "name" => "settingsSeoDescription",
      "title" => languageVariables("metaDescription", "settings", $languageType),
      "placeholder" => languageVariables("metaDescriptionPlaceholder", "settings", $languageType),
      "value" => $rSettings["metaDescription"]
    ),
    
    "6" => array(
      "MySQLTable" => "media",
      "MySQLName" => "twitter",
      "type" => 0,
      "ID" => "settings-general-twitter",
      "name" => "settingsTwitter",
      "title" => "Twitter:",
      "placeholder" => languageVariables("twitterPlaceholder", "settings", $languageType),
      "value" => $rMedia["twitter"]
    ),
    
    "7" => array(
      "MySQLTable" => "media",
      "MySQLName" => "facebook",
      "type" => 0,
      "ID" => "settings-general-facebook",
      "name" => "settingsFacebook",
      "title" => "Facebook:",
      "placeholder" => languageVariables("facebookPlaceholder", "settings", $languageType),
      "value" => $rMedia["facebook"]
    ),
    
    "8" => array(
      "MySQLTable" => "media",
      "MySQLName" => "instagram",
      "type" => 0,
      "ID" => "settings-general-instagram",
      "name" => "settingsInstagram",
      "title" => "Instagram:",
      "placeholder" => languageVariables("instagramPlaceholder", "settings", $languageType),
      "value" => $rMedia["instagram"]
    ),
    
    "9" => array(
      "MySQLTable" => "media",
      "MySQLName" => "youtube",
      "type" => 0,
      "ID" => "settings-general-youtube",
      "name" => "settingsYoutube",
      "title" => "Youtube:",
      "placeholder" => languageVariables("youtubePlaceholder", "settings", $languageType),
      "value" => $rMedia["youtube"]
    ),
    
    "10" => array(
      "MySQLTable" => "media",
      "MySQLName" => "discord",
      "type" => 0,
      "ID" => "settings-general-discord",
      "name" => "settingsDiscord",
      "title" => "Discord:",
      "placeholder" => languageVariables("discordPlaceholder", "settings", $languageType),
      "value" => $rMedia["discord"]
    ),
    
    "11" => array(
      "MySQLTable" => "media",
      "MySQLName" => "widget",
      "type" => 0,
      "ID" => "settings-general-discord-widget",
      "name" => "settingsDiscordWidget",
      "title" => languageVariables("discordServerID", "settings", $languageType),
      "placeholder" => languageVariables("discordServerIDPlaceholder", "settings", $languageType),
      "value" => $rMedia["widget"]
    ),
    
    "12" => array(
      "MySQLTable" => "media",
      "MySQLName" => "email",
      "type" => 0,
      "ID" => "settings-general-email",
      "name" => "settingsEmail",
      "title" => languageVariables("email", "settings", $languageType),
      "placeholder" => languageVariables("emailPlaceholder", "settings", $languageType),
      "value" => $rMedia["email"]
    ),
    
    "13" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "pageAbouts",
      "type" => 2,
      "ID" => "settings-general-abouts",
      "name" => "settingsAbouts",
      "title" => languageVariables("abouts", "settings", $languageType),
      "placeholder" => languageVariables("aboutsPlaceholder", "settings", $languageType),
      "html" => '<small class="form-text text-muted"><strong>'.languageVariables("serverName", "words", $languageType).':</strong> [serverName]</small>',
      "value" => $rSettings["pageAbouts"]
    ),
    
    "14" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "pageRules",
      "type" => 2,
      "ID" => "settings-general-rules",
      "name" => "settingsRules",
      "title" => languageVariables("rules", "settings", $languageType),
      "placeholder" => languageVariables("rulesPlaceholder", "settings", $languageType),
      "html" => '<small class="form-text text-muted"><strong>'.languageVariables("serverName", "words", $languageType).':</strong> [serverName]</small>',
      "value" => $rSettings["pageRules"]
    ),
    
    "15" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "pagePrivacy",
      "type" => 2,
      "ID" => "settings-general-privacy",
      "name" => "settingsPrivacy",
      "title" => languageVariables("privacy", "settings", $languageType),
      "placeholder" => languageVariables("privacyPlaceholder", "settings", $languageType),
      "html" => '<small class="form-text text-muted"><strong>'.languageVariables("serverName", "words", $languageType).':</strong> [serverName]</small>',
      "value" => $rSettings["pagePrivacy"]
    ),
    
    "16" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "supportMessageTemplate",
      "type" => 2,
      "ID" => "settings-general-support-message-template",
      "name" => "settingsSupportMessageTemplate",
      "title" => languageVariables("supportMessageTemplate", "settings", $languageType),
      "placeholder" => languageVariables("supportMessageTemplatePlaceholder", "settings", $languageType),
      "html" => languageVariables("supportMessageTemplateDescription", "settings", $languageType),
      "value" => $rSettings["supportMessageTemplate"]
    ),
    
    "17" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "serverLogo",
      "type" => 3,
      "ID" => "settings-general-server-logo",
      "name" => "settingsServerLogo",
      "title" => languageVariables("serverLogo", "settings", $languageType),
      "placeholder" => languageVariables("serverLogoPlaceholder", "settings", $languageType),
      "value" => $rSettings["serverLogo"]
    )
  );
?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_settings_general", $languageType); ?>"><?php echo languageVariables("settings", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("general", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("generalSettings", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token'); 
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              if (post("settingsServerName") !== "" && post("settingsServerIP") !== "" && post("settingsSeoTitle") !== "") {
                $serverLogoUploadStatus = true;
                $footerImageUploadStatus = true;
                $headerLogoUploadStatus = true;
                if ($_FILES["settingsServerLogo"]["name"] != null) {
                  $serverLogoUpload = imageUpload($_FILES["settingsServerLogo"], "/assets/uploads/images/landing/logo/");
                  if ($serverLogoUpload !== false) {
                    $updateServerLogo = $db->prepare("UPDATE settings SET serverLogo = ? WHERE id = ?");
                    $updateServerLogo->execute(array("/assets/uploads/images/landing/logo/".$serverLogoUpload["name"], $rSettings["id"]));
                  } else {
                    $serverLogoUploadStatus = false;
                  }
                }
                if ($serverLogoUploadStatus = true && $footerImageUploadStatus = true && $headerLogoUploadStatus = true) {
                  foreach ($settingsVariables as $readSettingsVariables) {
                    if ($readSettingsVariables["type"] !== 3) {
                      $MySQLTableName = $readSettingsVariables["MySQLTable"];
                      $InputName = $readSettingsVariables["name"];
                      $ValueName = $readSettingsVariables["MySQLName"];
                      if ($readSettingsVariables["type"] == 2) {
                        $UpdateValue = $_POST[$InputName];
                      } else {
                        $UpdateValue = post($InputName);
                      }
                      if ($readSettingsVariables["value"] !== $UpdateValue) {
                        $saveChanges = $db->prepare("UPDATE $MySQLTableName SET $ValueName = ? WHERE id = ?");
                        $saveChanges->execute(array($UpdateValue, 0));
                      }
                    }
                  }
                  echo alert(languageVariables("alertSaveChanges", "settings", $languageType), "success", "2", "");
                } else {
                  echo alert(languageVariables("alertImageUpload", "settings", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "settings", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <?php foreach ($settingsVariables as $readSettingsVariables) { ?>
            <div class="form-group row">
              <label for="<?php echo $readSettingsVariables["ID"]; ?>" class="col-sm-3 col-form-label"><?php echo $readSettingsVariables["title"]; ?></label>
              <div class="col-sm-9">
                <?php if ($readSettingsVariables["type"] == "1") { ?>
                <textarea class="form-control" id="<?php echo $readSettingsVariables["ID"]; ?>" name="<?php echo $readSettingsVariables["name"]; ?>" placeholder="<?php echo $readSettingsVariables["placeholder"]; ?>" rows="6"><?php echo $readSettingsVariables["value"]; ?></textarea>
                <?php } else if ($readSettingsVariables["type"] == "2") { ?>
                <textarea class="form-control ckeditor" id="<?php echo $readSettingsVariables["ID"]; ?>" name="<?php echo $readSettingsVariables["name"]; ?>" placeholder="<?php echo $readSettingsVariables["placeholder"]; ?>"><?php echo $readSettingsVariables["value"]; ?></textarea>
                <?php echo $readSettingsVariables["html"]; ?>
                <?php } else if ($readSettingsVariables["type"] == "3") { ?>
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readSettingsVariables["value"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="<?php echo $readSettingsVariables["ID"]; ?>"><?php echo $readSettingsVariables["placeholder"]; ?></label>
                    <input type="file" id="<?php echo $readSettingsVariables["ID"]; ?>" name="<?php echo $readSettingsVariables["name"]; ?>" accept="image/*">
                  </div>
                </div>
                <?php } else { ?>
                <input type="text" class="form-control" id="<?php echo $readSettingsVariables["ID"]; ?>" name="<?php echo $readSettingsVariables["name"]; ?>" placeholder="<?php echo $readSettingsVariables["placeholder"]; ?>" value="<?php echo $readSettingsVariables["value"]; ?>">
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else if (get("action") == "system") { ?>
<?php if (AccountPermControl($readAccount["id"], "settings_system") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php
  $settingsVariables = array(
    "1" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "maintanceStatus",
      "name" => "settingsMaintanceStatus",
      "value" => $rSettings["maintanceStatus"]
    ),
    
    "2" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "debugModeStatus",
      "name" => "settingsDebugMode",
      "value" => $rSettings["debugModeStatus"]
    ),
    
    "3" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "SSLModeStatus",
      "name" => "settingsSSLMode",
      "value" => $rSettings["SSLModeStatus"]
    ),
    
    "4" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "serverOnlineStatusAPI",
      "name" => "settingsServerOnlineAPI",
      "value" => $rSettings["serverOnlineStatusAPI"]
    ),
    
    "5" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "avatarAPI",
      "name" => "settingsAvatarAPI",
      "value" => $rSettings["avatarAPI"]
    ),
    
    "6" => array(
      "MySQLTable" => "module",
      "MySQLName" => "creditTransferStatus",
      "name" => "settingsCreditTransfer",
      "value" => $readModule["creditTransferStatus"]
    ),
    
    "7" => array(
      "MySQLTable" => "module",
      "MySQLName" => "giftTransferStatus",
      "name" => "settingsGiftTransfer",
      "value" => $readModule["giftTransferStatus"]
    ),
    
    "8" => array(
      "MySQLTable" => "module",
      "MySQLName" => "storeExProductStatus",
      "name" => "settingsStoreExProduct",
      "value" => $readModule["storeExProductStatus"]
    ),
    
    "9" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "commentsStatus",
      "name" => "settingsComments",
      "value" => $rSettings["commentsStatus"]
    ),
    
    "10" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "recaptchaPrivateKey",
      "name" => "settingsRecaptchaPrivateKey",
      "value" => $rSettings["recaptchaPrivateKey"]
    ),
    
    "11" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "recaptchaPublicKey",
      "name" => "settingsRecaptchaPublicKey",
      "value" => $rSettings["recaptchaPublicKey"]
    ),
    
    "12" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "recaptchaStatus",
      "name" => "settingsRecaptchaStatus",
      "value" => $rSettings["recaptchaStatus"]
    ),
    
    "13" => array(
      "MySQLTable" => "media",
      "MySQLName" => "liveSupportStatus",
      "name" => "settingsLiveChat",
      "value" => $rMedia["liveSupportStatus"]
    ),
    
    "14" => array(
      "MySQLTable" => "media",
      "MySQLName" => "liveSupportEmbed",
      "name" => "settingsLiveChatEmbed",
      "value" => $rMedia["liveSupportEmbed"]
    ),
    
    "15" => array(
      "MySQLTable" => "module",
      "MySQLName" => "broadcastStatus",
      "name" => "settingsBroadcastStatus",
      "value" => $readModule["broadcastStatus"]
    ),
    
    "16" => array(
      "MySQLTable" => "module",
      "MySQLName" => "sidebarStatus",
      "name" => "settingsSidebarStatus",
      "value" => $readModule["sidebarStatus"]
    ),
    
    "17" => array(
      "MySQLTable" => "module",
      "MySQLName" => "preloaderStatus",
      "name" => "settingsPreloaderStatus",
      "value" => $readModule["preloaderStatus"]
    ),
    
    "21" => array(
      "MySQLTable" => "module",
      "MySQLName" => "KDVStatus",
      "name" => "settingsKDVStatus",
      "value" => $readModule["KDVStatus"]
    ),
    
    "22" => array(
      "MySQLTable" => "module",
      "MySQLName" => "KDVValue",
      "name" => "settingsKDVValue",
      "value" => $readModule["KDVValue"]
    ),
    
    "23" => array(
      "MySQLTable" => "module",
      "MySQLName" => "maxSupportLimit",
      "name" => "settingsSupportLimitValue",
      "value" => $readModule["maxSupportLimit"]
    ),
    
    "25" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "passwordHash",
      "name" => "settingsPasswordHash",
      "value" => $rSettings["passwordHash"]
    ),
    
    "26" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "bannedType",
      "name" => "settingsBannedType",
      "value" => $rSettings["bannedType"]
    ),
    
    "27" => array(
      "MySQLTable" => "module",
      "MySQLName" => "snowModeStatus",
      "name" => "settingsSnowModeStatus",
      "value" => $readModule["snowModeStatus"]
    ),

    "29" => array(
      "MySQLTable" => "module",
      "MySQLName" => "voteSystemStatus",
      "name" => "settingsVoteSystemStatus",
      "value" => $readModule["voteSystemStatus"]
    ),

    "30" => array(
      "MySQLTable" => "module",
      "MySQLName" => "voteSystemServerKey",
      "name" => "settingsVoteSystemServerKey",
      "value" => $readModule["voteSystemServerKey"]
    ),

    "31" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "defaultLanguage",
      "name" => "settingsDefaultLanguage",
      "value" => $rSettings["defaultLanguage"]
    ),

    "32" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "currency",
      "name" => "settingsCurrency",
      "value" => $rSettings["currency"]
    ),

    "33" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "apiKey",
      "name" => "settingsAPIKey",
      "value" => $rSettings["apiKey"]
    ),

    "34" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "googleAI",
      "name" => "settingsGoogleAI",
      "value" => $rSettings["googleAI"]
    ),

    "35" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "defaultTimezone",
      "name" => "settingsTimezone",
      "value" => $rSettings["defaultTimezone"]
    ),

    "39" => array(
      "MySQLTable" => "module",
      "MySQLName" => "forumStatus",
      "name" => "settingsForumStatus",
      "value" => $rSettings["forumStatus"]
    )
  );
?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_settings_general", $languageType); ?>"><?php echo languageVariables("settings", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("system", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("systemSettings", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token'); 
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              if ((post("settingsLiveChat") == "0" || post("settingsLiveChatEmbed") !== "") && (post("settingsRecaptchaStatus") == "0" || post("settingsRecaptchaPrivateKey") !== "" && post("settingsRecaptchaPublicKey") !== "") && (post("settingsRegisterLimitStatus") == "0" || post("settingsRegisterLimitValue") !== "")) {
                if (post("settingsRegisterLimitStatus") == "0") {
                  $registerLimit = 0;
                } else {
                  $registerLimit = post("settingsRegisterLimitValue");
                }
                $updateRegisterLimit = $db->prepare("UPDATE settings SET registerLimit = ? WHERE id = ?");
                $updateRegisterLimit->execute(array($registerLimit, $rSettings["id"]));
                foreach ($settingsVariables as $readSettingsVariables) {
                    $MySQLTableName = $readSettingsVariables["MySQLTable"];
                    $InputName = $readSettingsVariables["name"];
                    $ValueName = $readSettingsVariables["MySQLName"];
                    $UpdateValue = post($InputName);
                    if ($readSettingsVariables["value"] !== $UpdateValue) {
                      $saveChanges = $db->prepare("UPDATE $MySQLTableName SET $ValueName = ? WHERE id = ?");
                      $saveChanges->execute(array($UpdateValue, 0));
                    }
                }
                echo alert(languageVariables("alertSaveChanges", "settings", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "settings", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="settings-system-default-timezone" class="col-sm-3 col-form-label">Timezone:</label>
              <div class="col-sm-9">
                <select class="js-example-basic-single form-control" id="settings-system-default-timezone" name="settingsTimezone">
                  <option value="Africa/Abidjan" <?php echo (($rSettings["defaultTimezone"]=="Africa/Abidjan") ? "selected" : ""); ?>>(GMT +00:00) Africa/Abidjan</option> <option value="Africa/Accra" <?php echo (($rSettings["defaultTimezone"]=="Africa/Accra") ? "selected" : ""); ?>>(GMT +00:00) Africa/Accra</option> <option value="Africa/Addis_Ababa" <?php echo (($rSettings["defaultTimezone"]=="Africa/Addis_Ababa") ? "selected" : ""); ?>>(GMT +03:00) Africa/Addis Ababa</option> <option value="Africa/Algiers" <?php echo (($rSettings["defaultTimezone"]=="Africa/Algiers") ? "selected" : ""); ?>>(GMT +01:00) Africa/Algiers</option> <option value="Africa/Asmara" <?php echo (($rSettings["defaultTimezone"]=="Africa/Asmara") ? "selected" : ""); ?>>(GMT +03:00) Africa/Asmara</option> <option value="Africa/Bamako" <?php echo (($rSettings["defaultTimezone"]=="Africa/Bamako") ? "selected" : ""); ?>>(GMT +00:00) Africa/Bamako</option> <option value="Africa/Bangui" <?php echo (($rSettings["defaultTimezone"]=="Africa/Bangui") ? "selected" : ""); ?>>(GMT +01:00) Africa/Bangui</option> <option value="Africa/Banjul" <?php echo (($rSettings["defaultTimezone"]=="Africa/Banjul") ? "selected" : ""); ?>>(GMT +00:00) Africa/Banjul</option> <option value="Africa/Bissau" <?php echo (($rSettings["defaultTimezone"]=="Africa/Bissau") ? "selected" : ""); ?>>(GMT +00:00) Africa/Bissau</option> <option value="Africa/Blantyre" <?php echo (($rSettings["defaultTimezone"]=="Africa/Blantyre") ? "selected" : ""); ?>>(GMT +02:00) Africa/Blantyre</option> <option value="Africa/Brazzaville" <?php echo (($rSettings["defaultTimezone"]=="Africa/Brazzaville") ? "selected" : ""); ?>>(GMT +01:00) Africa/Brazzaville</option> <option value="Africa/Bujumbura" <?php echo (($rSettings["defaultTimezone"]=="Africa/Bujumbura") ? "selected" : ""); ?>>(GMT +02:00) Africa/Bujumbura</option> <option value="Africa/Cairo" <?php echo (($rSettings["defaultTimezone"]=="Africa/Cairo") ? "selected" : ""); ?>>(GMT +02:00) Africa/Cairo</option> <option value="Africa/Casablanca" <?php echo (($rSettings["defaultTimezone"]=="Africa/Casablanca") ? "selected" : ""); ?>>(GMT +01:00) Africa/Casablanca</option> <option value="Africa/Ceuta" <?php echo (($rSettings["defaultTimezone"]=="Africa/Ceuta") ? "selected" : ""); ?>>(GMT +02:00) Africa/Ceuta</option> <option value="Africa/Conakry" <?php echo (($rSettings["defaultTimezone"]=="Africa/Conakry") ? "selected" : ""); ?>>(GMT +00:00) Africa/Conakry</option> <option value="Africa/Dakar" <?php echo (($rSettings["defaultTimezone"]=="Africa/Dakar") ? "selected" : ""); ?>>(GMT +00:00) Africa/Dakar</option> <option value="Africa/Dar_es_Salaam" <?php echo (($rSettings["defaultTimezone"]=="Africa/Dar_es_Salaam") ? "selected" : ""); ?>>(GMT +03:00) Africa/Dar es Salaam</option> <option value="Africa/Djibouti" <?php echo (($rSettings["defaultTimezone"]=="Africa/Djibouti") ? "selected" : ""); ?>>(GMT +03:00) Africa/Djibouti</option> <option value="Africa/Douala" <?php echo (($rSettings["defaultTimezone"]=="Africa/Douala") ? "selected" : ""); ?>>(GMT +01:00) Africa/Douala</option> <option value="Africa/El_Aaiun" <?php echo (($rSettings["defaultTimezone"]=="Africa/El_Aaiun") ? "selected" : ""); ?>>(GMT +01:00) Africa/El Aaiun</option> <option value="Africa/Freetown" <?php echo (($rSettings["defaultTimezone"]=="Africa/Freetown") ? "selected" : ""); ?>>(GMT +00:00) Africa/Freetown</option> <option value="Africa/Gaborone" <?php echo (($rSettings["defaultTimezone"]=="Africa/Gaborone") ? "selected" : ""); ?>>(GMT +02:00) Africa/Gaborone</option> <option value="Africa/Harare" <?php echo (($rSettings["defaultTimezone"]=="Africa/Harare") ? "selected" : ""); ?>>(GMT +02:00) Africa/Harare</option> <option value="Africa/Johannesburg" <?php echo (($rSettings["defaultTimezone"]=="Africa/Johannesburg") ? "selected" : ""); ?>>(GMT +02:00) Africa/Johannesburg</option> <option value="Africa/Juba" <?php echo (($rSettings["defaultTimezone"]=="Africa/Juba") ? "selected" : ""); ?>>(GMT +02:00) Africa/Juba</option> <option value="Africa/Kampala" <?php echo (($rSettings["defaultTimezone"]=="Africa/Kampala") ? "selected" : ""); ?>>(GMT +03:00) Africa/Kampala</option> <option value="Africa/Khartoum" <?php echo (($rSettings["defaultTimezone"]=="Africa/Khartoum") ? "selected" : ""); ?>>(GMT +02:00) Africa/Khartoum</option> <option value="Africa/Kigali" <?php echo (($rSettings["defaultTimezone"]=="Africa/Kigali") ? "selected" : ""); ?>>(GMT +02:00) Africa/Kigali</option> <option value="Africa/Kinshasa" <?php echo (($rSettings["defaultTimezone"]=="Africa/Kinshasa") ? "selected" : ""); ?>>(GMT +01:00) Africa/Kinshasa</option> <option value="Africa/Lagos" <?php echo (($rSettings["defaultTimezone"]=="Africa/Lagos") ? "selected" : ""); ?>>(GMT +01:00) Africa/Lagos</option> <option value="Africa/Libreville" <?php echo (($rSettings["defaultTimezone"]=="Africa/Libreville") ? "selected" : ""); ?>>(GMT +01:00) Africa/Libreville</option> <option value="Africa/Lome" <?php echo (($rSettings["defaultTimezone"]=="Africa/Lome") ? "selected" : ""); ?>>(GMT +00:00) Africa/Lome</option> <option value="Africa/Luanda" <?php echo (($rSettings["defaultTimezone"]=="Africa/Luanda") ? "selected" : ""); ?>>(GMT +01:00) Africa/Luanda</option> <option value="Africa/Lubumbashi" <?php echo (($rSettings["defaultTimezone"]=="Africa/Lubumbashi") ? "selected" : ""); ?>>(GMT +02:00) Africa/Lubumbashi</option> <option value="Africa/Lusaka" <?php echo (($rSettings["defaultTimezone"]=="Africa/Lusaka") ? "selected" : ""); ?>>(GMT +02:00) Africa/Lusaka</option> <option value="Africa/Malabo" <?php echo (($rSettings["defaultTimezone"]=="Africa/Malabo") ? "selected" : ""); ?>>(GMT +01:00) Africa/Malabo</option> <option value="Africa/Maputo" <?php echo (($rSettings["defaultTimezone"]=="Africa/Maputo") ? "selected" : ""); ?>>(GMT +02:00) Africa/Maputo</option> <option value="Africa/Maseru" <?php echo (($rSettings["defaultTimezone"]=="Africa/Maseru") ? "selected" : ""); ?>>(GMT +02:00) Africa/Maseru</option> <option value="Africa/Mbabane" <?php echo (($rSettings["defaultTimezone"]=="Africa/Mbabane") ? "selected" : ""); ?>>(GMT +02:00) Africa/Mbabane</option> <option value="Africa/Mogadishu" <?php echo (($rSettings["defaultTimezone"]=="Africa/Mogadishu") ? "selected" : ""); ?>>(GMT +03:00) Africa/Mogadishu</option> <option value="Africa/Monrovia" <?php echo (($rSettings["defaultTimezone"]=="Africa/Monrovia") ? "selected" : ""); ?>>(GMT +00:00) Africa/Monrovia</option> <option value="Africa/Nairobi" <?php echo (($rSettings["defaultTimezone"]=="Africa/Nairobi") ? "selected" : ""); ?>>(GMT +03:00) Africa/Nairobi</option> <option value="Africa/Ndjamena" <?php echo (($rSettings["defaultTimezone"]=="Africa/Ndjamena") ? "selected" : ""); ?>>(GMT +01:00) Africa/Ndjamena</option> <option value="Africa/Niamey" <?php echo (($rSettings["defaultTimezone"]=="Africa/Niamey") ? "selected" : ""); ?>>(GMT +01:00) Africa/Niamey</option> <option value="Africa/Nouakchott" <?php echo (($rSettings["defaultTimezone"]=="Africa/Nouakchott") ? "selected" : ""); ?>>(GMT +00:00) Africa/Nouakchott</option> <option value="Africa/Ouagadougou" <?php echo (($rSettings["defaultTimezone"]=="Africa/Ouagadougou") ? "selected" : ""); ?>>(GMT +00:00) Africa/Ouagadougou</option> <option value="Africa/Porto-Novo" <?php echo (($rSettings["defaultTimezone"]=="Africa/Porto-Novo") ? "selected" : ""); ?>>(GMT +01:00) Africa/Porto-Novo</option> <option value="Africa/Sao_Tome" <?php echo (($rSettings["defaultTimezone"]=="Africa/Sao_Tome") ? "selected" : ""); ?>>(GMT +00:00) Africa/Sao Tome</option> <option value="Africa/Tripoli" <?php echo (($rSettings["defaultTimezone"]=="Africa/Tripoli") ? "selected" : ""); ?>>(GMT +02:00) Africa/Tripoli</option> <option value="Africa/Tunis" <?php echo (($rSettings["defaultTimezone"]=="Africa/Tunis") ? "selected" : ""); ?>>(GMT +01:00) Africa/Tunis</option> <option value="Africa/Windhoek" <?php echo (($rSettings["defaultTimezone"]=="Africa/Windhoek") ? "selected" : ""); ?>>(GMT +02:00) Africa/Windhoek</option> <option value="America/Adak" <?php echo (($rSettings["defaultTimezone"]=="America/Adak") ? "selected" : ""); ?>>(GMT -09:00) America/Adak</option> <option value="America/Anchorage" <?php echo (($rSettings["defaultTimezone"]=="America/Anchorage") ? "selected" : ""); ?>>(GMT -08:00) America/Anchorage</option> <option value="America/Anguilla" <?php echo (($rSettings["defaultTimezone"]=="America/Anguilla") ? "selected" : ""); ?>>(GMT -04:00) America/Anguilla</option> <option value="America/Antigua" <?php echo (($rSettings["defaultTimezone"]=="America/Antigua") ? "selected" : ""); ?>>(GMT -04:00) America/Antigua</option> <option value="America/Araguaina" <?php echo (($rSettings["defaultTimezone"]=="America/Araguaina") ? "selected" : ""); ?>>(GMT -03:00) America/Araguaina</option> <option value="America/Argentina/Buenos_Aires" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/Buenos_Aires") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (Buenos Aires)</option> <option value="America/Argentina/Catamarca" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/Catamarca") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (Catamarca)</option> <option value="America/Argentina/Cordoba" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/Cordoba") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (Cordoba)</option> <option value="America/Argentina/Jujuy" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/Jujuy") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (Jujuy)</option> <option value="America/Argentina/La_Rioja" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/La_Rioja") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (La Rioja)</option> <option value="America/Argentina/Mendoza" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/Mendoza") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (Mendoza)</option> <option value="America/Argentina/Rio_Gallegos" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/Rio_Gallegos") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (Rio Gallegos)</option> <option value="America/Argentina/Salta" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/Salta") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (Salta)</option> <option value="America/Argentina/San_Juan" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/San_Juan") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (San Juan)</option> <option value="America/Argentina/San_Luis" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/San_Luis") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (San Luis)</option> <option value="America/Argentina/Tucuman" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/Tucuman") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (Tucuman)</option> <option value="America/Argentina/Ushuaia" <?php echo (($rSettings["defaultTimezone"]=="America/Argentina/Ushuaia") ? "selected" : ""); ?>>(GMT -03:00) America/Argentina (Ushuaia)</option> <option value="America/Aruba" <?php echo (($rSettings["defaultTimezone"]=="America/Aruba") ? "selected" : ""); ?>>(GMT -04:00) America/Aruba</option> <option value="America/Asuncion" <?php echo (($rSettings["defaultTimezone"]=="America/Asuncion") ? "selected" : ""); ?>>(GMT -04:00) America/Asuncion</option> <option value="America/Atikokan" <?php echo (($rSettings["defaultTimezone"]=="America/Atikokan") ? "selected" : ""); ?>>(GMT -05:00) America/Atikokan</option> <option value="America/Bahia" <?php echo (($rSettings["defaultTimezone"]=="America/Bahia") ? "selected" : ""); ?>>(GMT -03:00) America/Bahia</option> <option value="America/Bahia_Banderas" <?php echo (($rSettings["defaultTimezone"]=="America/Bahia_Banderas") ? "selected" : ""); ?>>(GMT -05:00) America/Bahia Banderas</option> <option value="America/Barbados" <?php echo (($rSettings["defaultTimezone"]=="America/Barbados") ? "selected" : ""); ?>>(GMT -04:00) America/Barbados</option> <option value="America/Belem" <?php echo (($rSettings["defaultTimezone"]=="America/Belem") ? "selected" : ""); ?>>(GMT -03:00) America/Belem</option> <option value="America/Belize" <?php echo (($rSettings["defaultTimezone"]=="America/Belize") ? "selected" : ""); ?>>(GMT -06:00) America/Belize</option> <option value="America/Blanc-Sablon" <?php echo (($rSettings["defaultTimezone"]=="America/Blanc-Sablon") ? "selected" : ""); ?>>(GMT -04:00) America/Blanc-Sablon</option> <option value="America/Boa_Vista" <?php echo (($rSettings["defaultTimezone"]=="America/Boa_Vista") ? "selected" : ""); ?>>(GMT -04:00) America/Boa Vista</option> <option value="America/Bogota" <?php echo (($rSettings["defaultTimezone"]=="America/Bogota") ? "selected" : ""); ?>>(GMT -05:00) America/Bogota</option> <option value="America/Boise" <?php echo (($rSettings["defaultTimezone"]=="America/Boise") ? "selected" : ""); ?>>(GMT -06:00) America/Boise</option> <option value="America/Cambridge_Bay" <?php echo (($rSettings["defaultTimezone"]=="America/Cambridge_Bay") ? "selected" : ""); ?>>(GMT -06:00) America/Cambridge Bay</option> <option value="America/Campo_Grande" <?php echo (($rSettings["defaultTimezone"]=="America/Campo_Grande") ? "selected" : ""); ?>>(GMT -04:00) America/Campo Grande</option> <option value="America/Cancun" <?php echo (($rSettings["defaultTimezone"]=="America/Cancun") ? "selected" : ""); ?>>(GMT -05:00) America/Cancun</option> <option value="America/Caracas" <?php echo (($rSettings["defaultTimezone"]=="America/Caracas") ? "selected" : ""); ?>>(GMT -04:00) America/Caracas</option> <option value="America/Cayenne" <?php echo (($rSettings["defaultTimezone"]=="America/Cayenne") ? "selected" : ""); ?>>(GMT -03:00) America/Cayenne</option> <option value="America/Cayman" <?php echo (($rSettings["defaultTimezone"]=="America/Cayman") ? "selected" : ""); ?>>(GMT -05:00) America/Cayman</option> <option value="America/Chicago" <?php echo (($rSettings["defaultTimezone"]=="America/Chicago") ? "selected" : ""); ?>>(GMT -05:00) America/Chicago</option> <option value="America/Chihuahua" <?php echo (($rSettings["defaultTimezone"]=="America/Chihuahua") ? "selected" : ""); ?>>(GMT -06:00) America/Chihuahua</option> <option value="America/Costa_Rica" <?php echo (($rSettings["defaultTimezone"]=="America/Costa_Rica") ? "selected" : ""); ?>>(GMT -06:00) America/Costa Rica</option> <option value="America/Creston" <?php echo (($rSettings["defaultTimezone"]=="America/Creston") ? "selected" : ""); ?>>(GMT -07:00) America/Creston</option> <option value="America/Cuiaba" <?php echo (($rSettings["defaultTimezone"]=="America/Cuiaba") ? "selected" : ""); ?>>(GMT -04:00) America/Cuiaba</option> <option value="America/Curacao" <?php echo (($rSettings["defaultTimezone"]=="America/Curacao") ? "selected" : ""); ?>>(GMT -04:00) America/Curacao</option> <option value="America/Danmarkshavn" <?php echo (($rSettings["defaultTimezone"]=="America/Danmarkshavn") ? "selected" : ""); ?>>(GMT +00:00) America/Danmarkshavn</option> <option value="America/Dawson" <?php echo (($rSettings["defaultTimezone"]=="America/Dawson") ? "selected" : ""); ?>>(GMT -07:00) America/Dawson</option> <option value="America/Dawson_Creek" <?php echo (($rSettings["defaultTimezone"]=="America/Dawson_Creek") ? "selected" : ""); ?>>(GMT -07:00) America/Dawson Creek</option> <option value="America/Denver" <?php echo (($rSettings["defaultTimezone"]=="America/Denver") ? "selected" : ""); ?>>(GMT -06:00) America/Denver</option> <option value="America/Detroit" <?php echo (($rSettings["defaultTimezone"]=="America/Detroit") ? "selected" : ""); ?>>(GMT -04:00) America/Detroit</option> <option value="America/Dominica" <?php echo (($rSettings["defaultTimezone"]=="America/Dominica") ? "selected" : ""); ?>>(GMT -04:00) America/Dominica</option> <option value="America/Edmonton" <?php echo (($rSettings["defaultTimezone"]=="America/Edmonton") ? "selected" : ""); ?>>(GMT -06:00) America/Edmonton</option> <option value="America/Eirunepe" <?php echo (($rSettings["defaultTimezone"]=="America/Eirunepe") ? "selected" : ""); ?>>(GMT -05:00) America/Eirunepe</option> <option value="America/El_Salvador" <?php echo (($rSettings["defaultTimezone"]=="America/El_Salvador") ? "selected" : ""); ?>>(GMT -06:00) America/El Salvador</option> <option value="America/Fort_Nelson" <?php echo (($rSettings["defaultTimezone"]=="America/Fort_Nelson") ? "selected" : ""); ?>>(GMT -07:00) America/Fort Nelson</option> <option value="America/Fortaleza" <?php echo (($rSettings["defaultTimezone"]=="America/Fortaleza") ? "selected" : ""); ?>>(GMT -03:00) America/Fortaleza</option> <option value="America/Glace_Bay" <?php echo (($rSettings["defaultTimezone"]=="America/Glace_Bay") ? "selected" : ""); ?>>(GMT -03:00) America/Glace Bay</option> <option value="America/Goose_Bay" <?php echo (($rSettings["defaultTimezone"]=="America/Goose_Bay") ? "selected" : ""); ?>>(GMT -03:00) America/Goose Bay</option> <option value="America/Grand_Turk" <?php echo (($rSettings["defaultTimezone"]=="America/Grand_Turk") ? "selected" : ""); ?>>(GMT -04:00) America/Grand Turk</option> <option value="America/Grenada" <?php echo (($rSettings["defaultTimezone"]=="America/Grenada") ? "selected" : ""); ?>>(GMT -04:00) America/Grenada</option> <option value="America/Guadeloupe" <?php echo (($rSettings["defaultTimezone"]=="America/Guadeloupe") ? "selected" : ""); ?>>(GMT -04:00) America/Guadeloupe</option> <option value="America/Guatemala" <?php echo (($rSettings["defaultTimezone"]=="America/Guatemala") ? "selected" : ""); ?>>(GMT -06:00) America/Guatemala</option> <option value="America/Guayaquil" <?php echo (($rSettings["defaultTimezone"]=="America/Guayaquil") ? "selected" : ""); ?>>(GMT -05:00) America/Guayaquil</option> <option value="America/Guyana" <?php echo (($rSettings["defaultTimezone"]=="America/Guyana") ? "selected" : ""); ?>>(GMT -04:00) America/Guyana</option> <option value="America/Halifax" <?php echo (($rSettings["defaultTimezone"]=="America/Halifax") ? "selected" : ""); ?>>(GMT -03:00) America/Halifax</option> <option value="America/Havana" <?php echo (($rSettings["defaultTimezone"]=="America/Havana") ? "selected" : ""); ?>>(GMT -04:00) America/Havana</option> <option value="America/Hermosillo" <?php echo (($rSettings["defaultTimezone"]=="America/Hermosillo") ? "selected" : ""); ?>>(GMT -07:00) America/Hermosillo</option> <option value="America/Indiana/Indianapolis" <?php echo (($rSettings["defaultTimezone"]=="America/Indiana/Indianapolis") ? "selected" : ""); ?>>(GMT -04:00) America/Indiana (Indianapolis)</option> <option value="America/Indiana/Knox" <?php echo (($rSettings["defaultTimezone"]=="America/Indiana/Knox") ? "selected" : ""); ?>>(GMT -05:00) America/Indiana (Knox)</option> <option value="America/Indiana/Marengo" <?php echo (($rSettings["defaultTimezone"]=="America/Indiana/Marengo") ? "selected" : ""); ?>>(GMT -04:00) America/Indiana (Marengo)</option> <option value="America/Indiana/Petersburg" <?php echo (($rSettings["defaultTimezone"]=="America/Indiana/Petersburg") ? "selected" : ""); ?>>(GMT -04:00) America/Indiana (Petersburg)</option> <option value="America/Indiana/Tell_City" <?php echo (($rSettings["defaultTimezone"]=="America/Indiana/Tell_City") ? "selected" : ""); ?>>(GMT -05:00) America/Indiana (Tell City)</option> <option value="America/Indiana/Vevay" <?php echo (($rSettings["defaultTimezone"]=="America/Indiana/Vevay") ? "selected" : ""); ?>>(GMT -04:00) America/Indiana (Vevay)</option> <option value="America/Indiana/Vincennes" <?php echo (($rSettings["defaultTimezone"]=="America/Indiana/Vincennes") ? "selected" : ""); ?>>(GMT -04:00) America/Indiana (Vincennes)</option> <option value="America/Indiana/Winamac" <?php echo (($rSettings["defaultTimezone"]=="America/Indiana/Winamac") ? "selected" : ""); ?>>(GMT -04:00) America/Indiana (Winamac)</option> <option value="America/Inuvik" <?php echo (($rSettings["defaultTimezone"]=="America/Inuvik") ? "selected" : ""); ?>>(GMT -06:00) America/Inuvik</option> <option value="America/Iqaluit" <?php echo (($rSettings["defaultTimezone"]=="America/Iqaluit") ? "selected" : ""); ?>>(GMT -04:00) America/Iqaluit</option> <option value="America/Jamaica" <?php echo (($rSettings["defaultTimezone"]=="America/Jamaica") ? "selected" : ""); ?>>(GMT -05:00) America/Jamaica</option> <option value="America/Juneau" <?php echo (($rSettings["defaultTimezone"]=="America/Juneau") ? "selected" : ""); ?>>(GMT -08:00) America/Juneau</option> <option value="America/Kentucky/Louisville" <?php echo (($rSettings["defaultTimezone"]=="America/Kentucky/Louisville") ? "selected" : ""); ?>>(GMT -04:00) America/Kentucky (Louisville)</option> <option value="America/Kentucky/Monticello" <?php echo (($rSettings["defaultTimezone"]=="America/Kentucky/Monticello") ? "selected" : ""); ?>>(GMT -04:00) America/Kentucky (Monticello)</option> <option value="America/Kralendijk" <?php echo (($rSettings["defaultTimezone"]=="America/Kralendijk") ? "selected" : ""); ?>>(GMT -04:00) America/Kralendijk</option> <option value="America/La_Paz" <?php echo (($rSettings["defaultTimezone"]=="America/La_Paz") ? "selected" : ""); ?>>(GMT -04:00) America/La Paz</option> <option value="America/Lima" <?php echo (($rSettings["defaultTimezone"]=="America/Lima") ? "selected" : ""); ?>>(GMT -05:00) America/Lima</option> <option value="America/Los_Angeles" <?php echo (($rSettings["defaultTimezone"]=="America/Los_Angeles") ? "selected" : ""); ?>>(GMT -07:00) America/Los Angeles</option> <option value="America/Lower_Princes" <?php echo (($rSettings["defaultTimezone"]=="America/Lower_Princes") ? "selected" : ""); ?>>(GMT -04:00) America/Lower Princes</option> <option value="America/Maceio" <?php echo (($rSettings["defaultTimezone"]=="America/Maceio") ? "selected" : ""); ?>>(GMT -03:00) America/Maceio</option> <option value="America/Managua" <?php echo (($rSettings["defaultTimezone"]=="America/Managua") ? "selected" : ""); ?>>(GMT -06:00) America/Managua</option> <option value="America/Manaus" <?php echo (($rSettings["defaultTimezone"]=="America/Manaus") ? "selected" : ""); ?>>(GMT -04:00) America/Manaus</option> <option value="America/Marigot" <?php echo (($rSettings["defaultTimezone"]=="America/Marigot") ? "selected" : ""); ?>>(GMT -04:00) America/Marigot</option> <option value="America/Martinique" <?php echo (($rSettings["defaultTimezone"]=="America/Martinique") ? "selected" : ""); ?>>(GMT -04:00) America/Martinique</option> <option value="America/Matamoros" <?php echo (($rSettings["defaultTimezone"]=="America/Matamoros") ? "selected" : ""); ?>>(GMT -05:00) America/Matamoros</option> <option value="America/Mazatlan" <?php echo (($rSettings["defaultTimezone"]=="America/Mazatlan") ? "selected" : ""); ?>>(GMT -06:00) America/Mazatlan</option> <option value="America/Menominee" <?php echo (($rSettings["defaultTimezone"]=="America/Menominee") ? "selected" : ""); ?>>(GMT -05:00) America/Menominee</option> <option value="America/Merida" <?php echo (($rSettings["defaultTimezone"]=="America/Merida") ? "selected" : ""); ?>>(GMT -05:00) America/Merida</option> <option value="America/Metlakatla" <?php echo (($rSettings["defaultTimezone"]=="America/Metlakatla") ? "selected" : ""); ?>>(GMT -08:00) America/Metlakatla</option> <option value="America/Mexico_City" <?php echo (($rSettings["defaultTimezone"]=="America/Mexico_City") ? "selected" : ""); ?>>(GMT -05:00) America/Mexico City</option> <option value="America/Miquelon" <?php echo (($rSettings["defaultTimezone"]=="America/Miquelon") ? "selected" : ""); ?>>(GMT -02:00) America/Miquelon</option> <option value="America/Moncton" <?php echo (($rSettings["defaultTimezone"]=="America/Moncton") ? "selected" : ""); ?>>(GMT -03:00) America/Moncton</option> <option value="America/Monterrey" <?php echo (($rSettings["defaultTimezone"]=="America/Monterrey") ? "selected" : ""); ?>>(GMT -05:00) America/Monterrey</option> <option value="America/Montevideo" <?php echo (($rSettings["defaultTimezone"]=="America/Montevideo") ? "selected" : ""); ?>>(GMT -03:00) America/Montevideo</option> <option value="America/Montserrat" <?php echo (($rSettings["defaultTimezone"]=="America/Montserrat") ? "selected" : ""); ?>>(GMT -04:00) America/Montserrat</option> <option value="America/Nassau" <?php echo (($rSettings["defaultTimezone"]=="America/Nassau") ? "selected" : ""); ?>>(GMT -04:00) America/Nassau</option> <option value="America/New_York" <?php echo (($rSettings["defaultTimezone"]=="America/New_York") ? "selected" : ""); ?>>(GMT -04:00) America/New York</option> <option value="America/Nipigon" <?php echo (($rSettings["defaultTimezone"]=="America/Nipigon") ? "selected" : ""); ?>>(GMT -04:00) America/Nipigon</option> <option value="America/Nome" <?php echo (($rSettings["defaultTimezone"]=="America/Nome") ? "selected" : ""); ?>>(GMT -08:00) America/Nome</option> <option value="America/Noronha" <?php echo (($rSettings["defaultTimezone"]=="America/Noronha") ? "selected" : ""); ?>>(GMT -02:00) America/Noronha</option> <option value="America/North_Dakota/Beulah" <?php echo (($rSettings["defaultTimezone"]=="America/North_Dakota/Beulah") ? "selected" : ""); ?>>(GMT -05:00) America/North Dakota (Beulah)</option> <option value="America/North_Dakota/Center" <?php echo (($rSettings["defaultTimezone"]=="America/North_Dakota/Center") ? "selected" : ""); ?>>(GMT -05:00) America/North Dakota (Center)</option> <option value="America/North_Dakota/New_Salem" <?php echo (($rSettings["defaultTimezone"]=="America/North_Dakota/New_Salem") ? "selected" : ""); ?>>(GMT -05:00) America/North Dakota (New Salem)</option> <option value="America/Nuuk" <?php echo (($rSettings["defaultTimezone"]=="America/Nuuk") ? "selected" : ""); ?>>(GMT -02:00) America/Nuuk</option> <option value="America/Ojinaga" <?php echo (($rSettings["defaultTimezone"]=="America/Ojinaga") ? "selected" : ""); ?>>(GMT -06:00) America/Ojinaga</option> <option value="America/Panama" <?php echo (($rSettings["defaultTimezone"]=="America/Panama") ? "selected" : ""); ?>>(GMT -05:00) America/Panama</option> <option value="America/Pangnirtung" <?php echo (($rSettings["defaultTimezone"]=="America/Pangnirtung") ? "selected" : ""); ?>>(GMT -04:00) America/Pangnirtung</option> <option value="America/Paramaribo" <?php echo (($rSettings["defaultTimezone"]=="America/Paramaribo") ? "selected" : ""); ?>>(GMT -03:00) America/Paramaribo</option> <option value="America/Phoenix" <?php echo (($rSettings["defaultTimezone"]=="America/Phoenix") ? "selected" : ""); ?>>(GMT -07:00) America/Phoenix</option> <option value="America/Port-au-Prince" <?php echo (($rSettings["defaultTimezone"]=="America/Port-au-Prince") ? "selected" : ""); ?>>(GMT -04:00) America/Port-au-Prince</option> <option value="America/Port_of_Spain" <?php echo (($rSettings["defaultTimezone"]=="America/Port_of_Spain") ? "selected" : ""); ?>>(GMT -04:00) America/Port of Spain</option> <option value="America/Porto_Velho" <?php echo (($rSettings["defaultTimezone"]=="America/Porto_Velho") ? "selected" : ""); ?>>(GMT -04:00) America/Porto Velho</option> <option value="America/Puerto_Rico" <?php echo (($rSettings["defaultTimezone"]=="America/Puerto_Rico") ? "selected" : ""); ?>>(GMT -04:00) America/Puerto Rico</option> <option value="America/Punta_Arenas" <?php echo (($rSettings["defaultTimezone"]=="America/Punta_Arenas") ? "selected" : ""); ?>>(GMT -03:00) America/Punta Arenas</option> <option value="America/Rainy_River" <?php echo (($rSettings["defaultTimezone"]=="America/Rainy_River") ? "selected" : ""); ?>>(GMT -05:00) America/Rainy River</option> <option value="America/Rankin_Inlet" <?php echo (($rSettings["defaultTimezone"]=="America/Rankin_Inlet") ? "selected" : ""); ?>>(GMT -05:00) America/Rankin Inlet</option> <option value="America/Recife" <?php echo (($rSettings["defaultTimezone"]=="America/Recife") ? "selected" : ""); ?>>(GMT -03:00) America/Recife</option> <option value="America/Regina" <?php echo (($rSettings["defaultTimezone"]=="America/Regina") ? "selected" : ""); ?>>(GMT -06:00) America/Regina</option> <option value="America/Resolute" <?php echo (($rSettings["defaultTimezone"]=="America/Resolute") ? "selected" : ""); ?>>(GMT -05:00) America/Resolute</option> <option value="America/Rio_Branco" <?php echo (($rSettings["defaultTimezone"]=="America/Rio_Branco") ? "selected" : ""); ?>>(GMT -05:00) America/Rio Branco</option> <option value="America/Santarem" <?php echo (($rSettings["defaultTimezone"]=="America/Santarem") ? "selected" : ""); ?>>(GMT -03:00) America/Santarem</option> <option value="America/Santiago" <?php echo (($rSettings["defaultTimezone"]=="America/Santiago") ? "selected" : ""); ?>>(GMT -04:00) America/Santiago</option> <option value="America/Santo_Domingo" <?php echo (($rSettings["defaultTimezone"]=="America/Santo_Domingo") ? "selected" : ""); ?>>(GMT -04:00) America/Santo Domingo</option> <option value="America/Sao_Paulo" <?php echo (($rSettings["defaultTimezone"]=="America/Sao_Paulo") ? "selected" : ""); ?>>(GMT -03:00) America/Sao Paulo</option> <option value="America/Scoresbysund" <?php echo (($rSettings["defaultTimezone"]=="America/Scoresbysund") ? "selected" : ""); ?>>(GMT +00:00) America/Scoresbysund</option> <option value="America/Sitka" <?php echo (($rSettings["defaultTimezone"]=="America/Sitka") ? "selected" : ""); ?>>(GMT -08:00) America/Sitka</option> <option value="America/St_Barthelemy" <?php echo (($rSettings["defaultTimezone"]=="America/St_Barthelemy") ? "selected" : ""); ?>>(GMT -04:00) America/St Barthelemy</option> <option value="America/St_Johns" <?php echo (($rSettings["defaultTimezone"]=="America/St_Johns") ? "selected" : ""); ?>>(GMT -02:30) America/St Johns</option> <option value="America/St_Kitts" <?php echo (($rSettings["defaultTimezone"]=="America/St_Kitts") ? "selected" : ""); ?>>(GMT -04:00) America/St Kitts</option> <option value="America/St_Lucia" <?php echo (($rSettings["defaultTimezone"]=="America/St_Lucia") ? "selected" : ""); ?>>(GMT -04:00) America/St Lucia</option> <option value="America/St_Thomas" <?php echo (($rSettings["defaultTimezone"]=="America/St_Thomas") ? "selected" : ""); ?>>(GMT -04:00) America/St Thomas</option> <option value="America/St_Vincent" <?php echo (($rSettings["defaultTimezone"]=="America/St_Vincent") ? "selected" : ""); ?>>(GMT -04:00) America/St Vincent</option> <option value="America/Swift_Current" <?php echo (($rSettings["defaultTimezone"]=="America/Swift_Current") ? "selected" : ""); ?>>(GMT -06:00) America/Swift Current</option> <option value="America/Tegucigalpa" <?php echo (($rSettings["defaultTimezone"]=="America/Tegucigalpa") ? "selected" : ""); ?>>(GMT -06:00) America/Tegucigalpa</option> <option value="America/Thule" <?php echo (($rSettings["defaultTimezone"]=="America/Thule") ? "selected" : ""); ?>>(GMT -03:00) America/Thule</option> <option value="America/Thunder_Bay" <?php echo (($rSettings["defaultTimezone"]=="America/Thunder_Bay") ? "selected" : ""); ?>>(GMT -04:00) America/Thunder Bay</option> <option value="America/Tijuana" <?php echo (($rSettings["defaultTimezone"]=="America/Tijuana") ? "selected" : ""); ?>>(GMT -07:00) America/Tijuana</option> <option value="America/Toronto" <?php echo (($rSettings["defaultTimezone"]=="America/Toronto") ? "selected" : ""); ?>>(GMT -04:00) America/Toronto</option> <option value="America/Tortola" <?php echo (($rSettings["defaultTimezone"]=="America/Tortola") ? "selected" : ""); ?>>(GMT -04:00) America/Tortola</option> <option value="America/Vancouver" <?php echo (($rSettings["defaultTimezone"]=="America/Vancouver") ? "selected" : ""); ?>>(GMT -07:00) America/Vancouver</option> <option value="America/Whitehorse" <?php echo (($rSettings["defaultTimezone"]=="America/Whitehorse") ? "selected" : ""); ?>>(GMT -07:00) America/Whitehorse</option> <option value="America/Winnipeg" <?php echo (($rSettings["defaultTimezone"]=="America/Winnipeg") ? "selected" : ""); ?>>(GMT -05:00) America/Winnipeg</option> <option value="America/Yakutat" <?php echo (($rSettings["defaultTimezone"]=="America/Yakutat") ? "selected" : ""); ?>>(GMT -08:00) America/Yakutat</option> <option value="America/Yellowknife" <?php echo (($rSettings["defaultTimezone"]=="America/Yellowknife") ? "selected" : ""); ?>>(GMT -06:00) America/Yellowknife</option> <option value="Antarctica/Casey" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/Casey") ? "selected" : ""); ?>>(GMT +11:00) Antarctica/Casey</option> <option value="Antarctica/Davis" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/Davis") ? "selected" : ""); ?>>(GMT +07:00) Antarctica/Davis</option> <option value="Antarctica/DumontDUrville" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/DumontDUrville") ? "selected" : ""); ?>>(GMT +10:00) Antarctica/DumontDUrville</option> <option value="Antarctica/Macquarie" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/Macquarie") ? "selected" : ""); ?>>(GMT +10:00) Antarctica/Macquarie</option> <option value="Antarctica/Mawson" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/Mawson") ? "selected" : ""); ?>>(GMT +05:00) Antarctica/Mawson</option> <option value="Antarctica/McMurdo" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/McMurdo") ? "selected" : ""); ?>>(GMT +12:00) Antarctica/McMurdo</option> <option value="Antarctica/Palmer" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/Palmer") ? "selected" : ""); ?>>(GMT -03:00) Antarctica/Palmer</option> <option value="Antarctica/Rothera" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/Rothera") ? "selected" : ""); ?>>(GMT -03:00) Antarctica/Rothera</option> <option value="Antarctica/Syowa" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/Syowa") ? "selected" : ""); ?>>(GMT +03:00) Antarctica/Syowa</option> <option value="Antarctica/Troll" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/Troll") ? "selected" : ""); ?>>(GMT +02:00) Antarctica/Troll</option> <option value="Antarctica/Vostok" <?php echo (($rSettings["defaultTimezone"]=="Antarctica/Vostok") ? "selected" : ""); ?>>(GMT +06:00) Antarctica/Vostok</option> <option value="Arctic/Longyearbyen" <?php echo (($rSettings["defaultTimezone"]=="Arctic/Longyearbyen") ? "selected" : ""); ?>>(GMT +02:00) Arctic/Longyearbyen</option> <option value="Asia/Aden" <?php echo (($rSettings["defaultTimezone"]=="Asia/Aden") ? "selected" : ""); ?>>(GMT +03:00) Asia/Aden</option> <option value="Asia/Almaty" <?php echo (($rSettings["defaultTimezone"]=="Asia/Almaty") ? "selected" : ""); ?>>(GMT +06:00) Asia/Almaty</option> <option value="Asia/Amman" <?php echo (($rSettings["defaultTimezone"]=="Asia/Amman") ? "selected" : ""); ?>>(GMT +03:00) Asia/Amman</option> <option value="Asia/Anadyr" <?php echo (($rSettings["defaultTimezone"]=="Asia/Anadyr") ? "selected" : ""); ?>>(GMT +12:00) Asia/Anadyr</option> <option value="Asia/Aqtau" <?php echo (($rSettings["defaultTimezone"]=="Asia/Aqtau") ? "selected" : ""); ?>>(GMT +05:00) Asia/Aqtau</option> <option value="Asia/Aqtobe" <?php echo (($rSettings["defaultTimezone"]=="Asia/Aqtobe") ? "selected" : ""); ?>>(GMT +05:00) Asia/Aqtobe</option> <option value="Asia/Ashgabat" <?php echo (($rSettings["defaultTimezone"]=="Asia/Ashgabat") ? "selected" : ""); ?>>(GMT +05:00) Asia/Ashgabat</option> <option value="Asia/Atyrau" <?php echo (($rSettings["defaultTimezone"]=="Asia/Atyrau") ? "selected" : ""); ?>>(GMT +05:00) Asia/Atyrau</option> <option value="Asia/Baghdad" <?php echo (($rSettings["defaultTimezone"]=="Asia/Baghdad") ? "selected" : ""); ?>>(GMT +03:00) Asia/Baghdad</option> <option value="Asia/Bahrain" <?php echo (($rSettings["defaultTimezone"]=="Asia/Bahrain") ? "selected" : ""); ?>>(GMT +03:00) Asia/Bahrain</option> <option value="Asia/Baku" <?php echo (($rSettings["defaultTimezone"]=="Asia/Baku") ? "selected" : ""); ?>>(GMT +04:00) Asia/Baku</option> <option value="Asia/Bangkok" <?php echo (($rSettings["defaultTimezone"]=="Asia/Bangkok") ? "selected" : ""); ?>>(GMT +07:00) Asia/Bangkok</option> <option value="Asia/Barnaul" <?php echo (($rSettings["defaultTimezone"]=="Asia/Barnaul") ? "selected" : ""); ?>>(GMT +07:00) Asia/Barnaul</option> <option value="Asia/Beirut" <?php echo (($rSettings["defaultTimezone"]=="Asia/Beirut") ? "selected" : ""); ?>>(GMT +03:00) Asia/Beirut</option> <option value="Asia/Bishkek" <?php echo (($rSettings["defaultTimezone"]=="Asia/Bishkek") ? "selected" : ""); ?>>(GMT +06:00) Asia/Bishkek</option> <option value="Asia/Brunei" <?php echo (($rSettings["defaultTimezone"]=="Asia/Brunei") ? "selected" : ""); ?>>(GMT +08:00) Asia/Brunei</option> <option value="Asia/Chita" <?php echo (($rSettings["defaultTimezone"]=="Asia/Chita") ? "selected" : ""); ?>>(GMT +09:00) Asia/Chita</option> <option value="Asia/Choibalsan" <?php echo (($rSettings["defaultTimezone"]=="Asia/Choibalsan") ? "selected" : ""); ?>>(GMT +08:00) Asia/Choibalsan</option> <option value="Asia/Colombo" <?php echo (($rSettings["defaultTimezone"]=="Asia/Colombo") ? "selected" : ""); ?>>(GMT +05:30) Asia/Colombo</option> <option value="Asia/Damascus" <?php echo (($rSettings["defaultTimezone"]=="Asia/Damascus") ? "selected" : ""); ?>>(GMT +03:00) Asia/Damascus</option> <option value="Asia/Dhaka" <?php echo (($rSettings["defaultTimezone"]=="Asia/Dhaka") ? "selected" : ""); ?>>(GMT +06:00) Asia/Dhaka</option> <option value="Asia/Dili" <?php echo (($rSettings["defaultTimezone"]=="Asia/Dili") ? "selected" : ""); ?>>(GMT +09:00) Asia/Dili</option> <option value="Asia/Dubai" <?php echo (($rSettings["defaultTimezone"]=="Asia/Dubai") ? "selected" : ""); ?>>(GMT +04:00) Asia/Dubai</option> <option value="Asia/Dushanbe" <?php echo (($rSettings["defaultTimezone"]=="Asia/Dushanbe") ? "selected" : ""); ?>>(GMT +05:00) Asia/Dushanbe</option> <option value="Asia/Famagusta" <?php echo (($rSettings["defaultTimezone"]=="Asia/Famagusta") ? "selected" : ""); ?>>(GMT +03:00) Asia/Famagusta</option> <option value="Asia/Gaza" <?php echo (($rSettings["defaultTimezone"]=="Asia/Gaza") ? "selected" : ""); ?>>(GMT +03:00) Asia/Gaza</option> <option value="Asia/Hebron" <?php echo (($rSettings["defaultTimezone"]=="Asia/Hebron") ? "selected" : ""); ?>>(GMT +03:00) Asia/Hebron</option> <option value="Asia/Ho_Chi_Minh" <?php echo (($rSettings["defaultTimezone"]=="Asia/Ho_Chi_Minh") ? "selected" : ""); ?>>(GMT +07:00) Asia/Ho Chi Minh</option> <option value="Asia/Hong_Kong" <?php echo (($rSettings["defaultTimezone"]=="Asia/Hong_Kong") ? "selected" : ""); ?>>(GMT +08:00) Asia/Hong Kong</option> <option value="Asia/Hovd" <?php echo (($rSettings["defaultTimezone"]=="Asia/Hovd") ? "selected" : ""); ?>>(GMT +07:00) Asia/Hovd</option> <option value="Asia/Irkutsk" <?php echo (($rSettings["defaultTimezone"]=="Asia/Irkutsk") ? "selected" : ""); ?>>(GMT +08:00) Asia/Irkutsk</option> <option value="Asia/Jakarta" <?php echo (($rSettings["defaultTimezone"]=="Asia/Jakarta") ? "selected" : ""); ?>>(GMT +07:00) Asia/Jakarta</option> <option value="Asia/Jayapura" <?php echo (($rSettings["defaultTimezone"]=="Asia/Jayapura") ? "selected" : ""); ?>>(GMT +09:00) Asia/Jayapura</option> <option value="Asia/Jerusalem" <?php echo (($rSettings["defaultTimezone"]=="Asia/Jerusalem") ? "selected" : ""); ?>>(GMT +03:00) Asia/Jerusalem</option> <option value="Asia/Kabul" <?php echo (($rSettings["defaultTimezone"]=="Asia/Kabul") ? "selected" : ""); ?>>(GMT +04:30) Asia/Kabul</option> <option value="Asia/Kamchatka" <?php echo (($rSettings["defaultTimezone"]=="Asia/Kamchatka") ? "selected" : ""); ?>>(GMT +12:00) Asia/Kamchatka</option> <option value="Asia/Karachi" <?php echo (($rSettings["defaultTimezone"]=="Asia/Karachi") ? "selected" : ""); ?>>(GMT +05:00) Asia/Karachi</option> <option value="Asia/Kathmandu" <?php echo (($rSettings["defaultTimezone"]=="Asia/Kathmandu") ? "selected" : ""); ?>>(GMT +05:45) Asia/Kathmandu</option> <option value="Asia/Khandyga" <?php echo (($rSettings["defaultTimezone"]=="Asia/Khandyga") ? "selected" : ""); ?>>(GMT +09:00) Asia/Khandyga</option> <option value="Asia/Kolkata" <?php echo (($rSettings["defaultTimezone"]=="Asia/Kolkata") ? "selected" : ""); ?>>(GMT +05:30) Asia/Kolkata</option> <option value="Asia/Krasnoyarsk" <?php echo (($rSettings["defaultTimezone"]=="Asia/Krasnoyarsk") ? "selected" : ""); ?>>(GMT +07:00) Asia/Krasnoyarsk</option> <option value="Asia/Kuala_Lumpur" <?php echo (($rSettings["defaultTimezone"]=="Asia/Kuala_Lumpur") ? "selected" : ""); ?>>(GMT +08:00) Asia/Kuala Lumpur</option> <option value="Asia/Kuching" <?php echo (($rSettings["defaultTimezone"]=="Asia/Kuching") ? "selected" : ""); ?>>(GMT +08:00) Asia/Kuching</option> <option value="Asia/Kuwait" <?php echo (($rSettings["defaultTimezone"]=="Asia/Kuwait") ? "selected" : ""); ?>>(GMT +03:00) Asia/Kuwait</option> <option value="Asia/Macau" <?php echo (($rSettings["defaultTimezone"]=="Asia/Macau") ? "selected" : ""); ?>>(GMT +08:00) Asia/Macau</option> <option value="Asia/Magadan" <?php echo (($rSettings["defaultTimezone"]=="Asia/Magadan") ? "selected" : ""); ?>>(GMT +11:00) Asia/Magadan</option> <option value="Asia/Makassar" <?php echo (($rSettings["defaultTimezone"]=="Asia/Makassar") ? "selected" : ""); ?>>(GMT +08:00) Asia/Makassar</option> <option value="Asia/Manila" <?php echo (($rSettings["defaultTimezone"]=="Asia/Manila") ? "selected" : ""); ?>>(GMT +08:00) Asia/Manila</option> <option value="Asia/Muscat" <?php echo (($rSettings["defaultTimezone"]=="Asia/Muscat") ? "selected" : ""); ?>>(GMT +04:00) Asia/Muscat</option> <option value="Asia/Nicosia" <?php echo (($rSettings["defaultTimezone"]=="Asia/Nicosia") ? "selected" : ""); ?>>(GMT +03:00) Asia/Nicosia</option> <option value="Asia/Novokuznetsk" <?php echo (($rSettings["defaultTimezone"]=="Asia/Novokuznetsk") ? "selected" : ""); ?>>(GMT +07:00) Asia/Novokuznetsk</option> <option value="Asia/Novosibirsk" <?php echo (($rSettings["defaultTimezone"]=="Asia/Novosibirsk") ? "selected" : ""); ?>>(GMT +07:00) Asia/Novosibirsk</option> <option value="Asia/Omsk" <?php echo (($rSettings["defaultTimezone"]=="Asia/Omsk") ? "selected" : ""); ?>>(GMT +06:00) Asia/Omsk</option> <option value="Asia/Oral" <?php echo (($rSettings["defaultTimezone"]=="Asia/Oral") ? "selected" : ""); ?>>(GMT +05:00) Asia/Oral</option> <option value="Asia/Phnom_Penh" <?php echo (($rSettings["defaultTimezone"]=="Asia/Phnom_Penh") ? "selected" : ""); ?>>(GMT +07:00) Asia/Phnom Penh</option> <option value="Asia/Pontianak" <?php echo (($rSettings["defaultTimezone"]=="Asia/Pontianak") ? "selected" : ""); ?>>(GMT +07:00) Asia/Pontianak</option> <option value="Asia/Pyongyang" <?php echo (($rSettings["defaultTimezone"]=="Asia/Pyongyang") ? "selected" : ""); ?>>(GMT +09:00) Asia/Pyongyang</option> <option value="Asia/Qatar" <?php echo (($rSettings["defaultTimezone"]=="Asia/Qatar") ? "selected" : ""); ?>>(GMT +03:00) Asia/Qatar</option> <option value="Asia/Qostanay" <?php echo (($rSettings["defaultTimezone"]=="Asia/Qostanay") ? "selected" : ""); ?>>(GMT +06:00) Asia/Qostanay</option> <option value="Asia/Qyzylorda" <?php echo (($rSettings["defaultTimezone"]=="Asia/Qyzylorda") ? "selected" : ""); ?>>(GMT +05:00) Asia/Qyzylorda</option> <option value="Asia/Riyadh" <?php echo (($rSettings["defaultTimezone"]=="Asia/Riyadh") ? "selected" : ""); ?>>(GMT +03:00) Asia/Riyadh</option> <option value="Asia/Sakhalin" <?php echo (($rSettings["defaultTimezone"]=="Asia/Sakhalin") ? "selected" : ""); ?>>(GMT +11:00) Asia/Sakhalin</option> <option value="Asia/Samarkand" <?php echo (($rSettings["defaultTimezone"]=="Asia/Samarkand") ? "selected" : ""); ?>>(GMT +05:00) Asia/Samarkand</option> <option value="Asia/Seoul" <?php echo (($rSettings["defaultTimezone"]=="Asia/Seoul") ? "selected" : ""); ?>>(GMT +09:00) Asia/Seoul</option> <option value="Asia/Shanghai" <?php echo (($rSettings["defaultTimezone"]=="Asia/Shanghai") ? "selected" : ""); ?>>(GMT +08:00) Asia/Shanghai</option> <option value="Asia/Singapore" <?php echo (($rSettings["defaultTimezone"]=="Asia/Singapore") ? "selected" : ""); ?>>(GMT +08:00) Asia/Singapore</option> <option value="Asia/Srednekolymsk" <?php echo (($rSettings["defaultTimezone"]=="Asia/Srednekolymsk") ? "selected" : ""); ?>>(GMT +11:00) Asia/Srednekolymsk</option> <option value="Asia/Taipei" <?php echo (($rSettings["defaultTimezone"]=="Asia/Taipei") ? "selected" : ""); ?>>(GMT +08:00) Asia/Taipei</option> <option value="Asia/Tashkent" <?php echo (($rSettings["defaultTimezone"]=="Asia/Tashkent") ? "selected" : ""); ?>>(GMT +05:00) Asia/Tashkent</option> <option value="Asia/Tbilisi" <?php echo (($rSettings["defaultTimezone"]=="Asia/Tbilisi") ? "selected" : ""); ?>>(GMT +04:00) Asia/Tbilisi</option> <option value="Asia/Tehran" <?php echo (($rSettings["defaultTimezone"]=="Asia/Tehran") ? "selected" : ""); ?>>(GMT +04:30) Asia/Tehran</option> <option value="Asia/Thimphu" <?php echo (($rSettings["defaultTimezone"]=="Asia/Thimphu") ? "selected" : ""); ?>>(GMT +06:00) Asia/Thimphu</option> <option value="Asia/Tokyo" <?php echo (($rSettings["defaultTimezone"]=="Asia/Tokyo") ? "selected" : ""); ?>>(GMT +09:00) Asia/Tokyo</option> <option value="Asia/Tomsk" <?php echo (($rSettings["defaultTimezone"]=="Asia/Tomsk") ? "selected" : ""); ?>>(GMT +07:00) Asia/Tomsk</option> <option value="Asia/Ulaanbaatar" <?php echo (($rSettings["defaultTimezone"]=="Asia/Ulaanbaatar") ? "selected" : ""); ?>>(GMT +08:00) Asia/Ulaanbaatar</option> <option value="Asia/Urumqi" <?php echo (($rSettings["defaultTimezone"]=="Asia/Urumqi") ? "selected" : ""); ?>>(GMT +06:00) Asia/Urumqi</option> <option value="Asia/Ust-Nera" <?php echo (($rSettings["defaultTimezone"]=="Asia/Ust-Nera") ? "selected" : ""); ?>>(GMT +10:00) Asia/Ust-Nera</option> <option value="Asia/Vientiane" <?php echo (($rSettings["defaultTimezone"]=="Asia/Vientiane") ? "selected" : ""); ?>>(GMT +07:00) Asia/Vientiane</option> <option value="Asia/Vladivostok" <?php echo (($rSettings["defaultTimezone"]=="Asia/Vladivostok") ? "selected" : ""); ?>>(GMT +10:00) Asia/Vladivostok</option> <option value="Asia/Yakutsk" <?php echo (($rSettings["defaultTimezone"]=="Asia/Yakutsk") ? "selected" : ""); ?>>(GMT +09:00) Asia/Yakutsk</option> <option value="Asia/Yangon" <?php echo (($rSettings["defaultTimezone"]=="Asia/Yangon") ? "selected" : ""); ?>>(GMT +06:30) Asia/Yangon</option> <option value="Asia/Yekaterinburg" <?php echo (($rSettings["defaultTimezone"]=="Asia/Yekaterinburg") ? "selected" : ""); ?>>(GMT +05:00) Asia/Yekaterinburg</option> <option value="Asia/Yerevan" <?php echo (($rSettings["defaultTimezone"]=="Asia/Yerevan") ? "selected" : ""); ?>>(GMT +04:00) Asia/Yerevan</option> <option value="Atlantic/Azores" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/Azores") ? "selected" : ""); ?>>(GMT +00:00) Atlantic/Azores</option> <option value="Atlantic/Bermuda" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/Bermuda") ? "selected" : ""); ?>>(GMT -03:00) Atlantic/Bermuda</option> <option value="Atlantic/Canary" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/Canary") ? "selected" : ""); ?>>(GMT +01:00) Atlantic/Canary</option> <option value="Atlantic/Cape_Verde" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/Cape_Verde") ? "selected" : ""); ?>>(GMT -01:00) Atlantic/Cape Verde</option> <option value="Atlantic/Faroe" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/Faroe") ? "selected" : ""); ?>>(GMT +01:00) Atlantic/Faroe</option> <option value="Atlantic/Madeira" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/Madeira") ? "selected" : ""); ?>>(GMT +01:00) Atlantic/Madeira</option> <option value="Atlantic/Reykjavik" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/Reykjavik") ? "selected" : ""); ?>>(GMT +00:00) Atlantic/Reykjavik</option> <option value="Atlantic/South_Georgia" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/South_Georgia") ? "selected" : ""); ?>>(GMT -02:00) Atlantic/South Georgia</option> <option value="Atlantic/St_Helena" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/St_Helena") ? "selected" : ""); ?>>(GMT +00:00) Atlantic/St Helena</option> <option value="Atlantic/Stanley" <?php echo (($rSettings["defaultTimezone"]=="Atlantic/Stanley") ? "selected" : ""); ?>>(GMT -03:00) Atlantic/Stanley</option> <option value="Australia/Adelaide" <?php echo (($rSettings["defaultTimezone"]=="Australia/Adelaide") ? "selected" : ""); ?>>(GMT +09:30) Australia/Adelaide</option> <option value="Australia/Brisbane" <?php echo (($rSettings["defaultTimezone"]=="Australia/Brisbane") ? "selected" : ""); ?>>(GMT +10:00) Australia/Brisbane</option> <option value="Australia/Broken_Hill" <?php echo (($rSettings["defaultTimezone"]=="Australia/Broken_Hill") ? "selected" : ""); ?>>(GMT +09:30) Australia/Broken Hill</option> <option value="Australia/Darwin" <?php echo (($rSettings["defaultTimezone"]=="Australia/Darwin") ? "selected" : ""); ?>>(GMT +09:30) Australia/Darwin</option> <option value="Australia/Eucla" <?php echo (($rSettings["defaultTimezone"]=="Australia/Eucla") ? "selected" : ""); ?>>(GMT +08:45) Australia/Eucla</option> <option value="Australia/Hobart" <?php echo (($rSettings["defaultTimezone"]=="Australia/Hobart") ? "selected" : ""); ?>>(GMT +10:00) Australia/Hobart</option> <option value="Australia/Lindeman" <?php echo (($rSettings["defaultTimezone"]=="Australia/Lindeman") ? "selected" : ""); ?>>(GMT +10:00) Australia/Lindeman</option> <option value="Australia/Lord_Howe" <?php echo (($rSettings["defaultTimezone"]=="Australia/Lord_Howe") ? "selected" : ""); ?>>(GMT +10:30) Australia/Lord Howe</option> <option value="Australia/Melbourne" <?php echo (($rSettings["defaultTimezone"]=="Australia/Melbourne") ? "selected" : ""); ?>>(GMT +10:00) Australia/Melbourne</option> <option value="Australia/Perth" <?php echo (($rSettings["defaultTimezone"]=="Australia/Perth") ? "selected" : ""); ?>>(GMT +08:00) Australia/Perth</option> <option value="Australia/Sydney" <?php echo (($rSettings["defaultTimezone"]=="Australia/Sydney") ? "selected" : ""); ?>>(GMT +10:00) Australia/Sydney</option> <option value="Europe/Amsterdam" <?php echo (($rSettings["defaultTimezone"]=="Europe/Amsterdam") ? "selected" : ""); ?>>(GMT +02:00) Europe/Amsterdam</option> <option value="Europe/Andorra" <?php echo (($rSettings["defaultTimezone"]=="Europe/Andorra") ? "selected" : ""); ?>>(GMT +02:00) Europe/Andorra</option> <option value="Europe/Astrakhan" <?php echo (($rSettings["defaultTimezone"]=="Europe/Astrakhan") ? "selected" : ""); ?>>(GMT +04:00) Europe/Astrakhan</option> <option value="Europe/Athens" <?php echo (($rSettings["defaultTimezone"]=="Europe/Athens") ? "selected" : ""); ?>>(GMT +03:00) Europe/Athens</option> <option value="Europe/Belgrade" <?php echo (($rSettings["defaultTimezone"]=="Europe/Belgrade") ? "selected" : ""); ?>>(GMT +02:00) Europe/Belgrade</option> <option value="Europe/Berlin" <?php echo (($rSettings["defaultTimezone"]=="Europe/Berlin") ? "selected" : ""); ?>>(GMT +02:00) Europe/Berlin</option> <option value="Europe/Bratislava" <?php echo (($rSettings["defaultTimezone"]=="Europe/Bratislava") ? "selected" : ""); ?>>(GMT +02:00) Europe/Bratislava</option> <option value="Europe/Brussels" <?php echo (($rSettings["defaultTimezone"]=="Europe/Brussels") ? "selected" : ""); ?>>(GMT +02:00) Europe/Brussels</option> <option value="Europe/Bucharest" <?php echo (($rSettings["defaultTimezone"]=="Europe/Bucharest") ? "selected" : ""); ?>>(GMT +03:00) Europe/Bucharest</option> <option value="Europe/Budapest" <?php echo (($rSettings["defaultTimezone"]=="Europe/Budapest") ? "selected" : ""); ?>>(GMT +02:00) Europe/Budapest</option> <option value="Europe/Busingen" <?php echo (($rSettings["defaultTimezone"]=="Europe/Busingen") ? "selected" : ""); ?>>(GMT +02:00) Europe/Busingen</option> <option value="Europe/Chisinau" <?php echo (($rSettings["defaultTimezone"]=="Europe/Chisinau") ? "selected" : ""); ?>>(GMT +03:00) Europe/Chisinau</option> <option value="Europe/Copenhagen" <?php echo (($rSettings["defaultTimezone"]=="Europe/Copenhagen") ? "selected" : ""); ?>>(GMT +02:00) Europe/Copenhagen</option> <option value="Europe/Dublin" <?php echo (($rSettings["defaultTimezone"]=="Europe/Dublin") ? "selected" : ""); ?>>(GMT +01:00) Europe/Dublin</option> <option value="Europe/Gibraltar" <?php echo (($rSettings["defaultTimezone"]=="Europe/Gibraltar") ? "selected" : ""); ?>>(GMT +02:00) Europe/Gibraltar</option> <option value="Europe/Guernsey" <?php echo (($rSettings["defaultTimezone"]=="Europe/Guernsey") ? "selected" : ""); ?>>(GMT +01:00) Europe/Guernsey</option> <option value="Europe/Helsinki" <?php echo (($rSettings["defaultTimezone"]=="Europe/Helsinki") ? "selected" : ""); ?>>(GMT +03:00) Europe/Helsinki</option> <option value="Europe/Isle_of_Man" <?php echo (($rSettings["defaultTimezone"]=="Europe/Isle_of_Man") ? "selected" : ""); ?>>(GMT +01:00) Europe/Isle of Man</option> <option value="Europe/Istanbul" <?php echo (($rSettings["defaultTimezone"]=="Europe/Istanbul") ? "selected" : ""); ?>>(GMT +03:00) Europe/Istanbul</option> <option value="Europe/Jersey" <?php echo (($rSettings["defaultTimezone"]=="Europe/Jersey") ? "selected" : ""); ?>>(GMT +01:00) Europe/Jersey</option> <option value="Europe/Kaliningrad" <?php echo (($rSettings["defaultTimezone"]=="Europe/Kaliningrad") ? "selected" : ""); ?>>(GMT +02:00) Europe/Kaliningrad</option> <option value="Europe/Kiev" <?php echo (($rSettings["defaultTimezone"]=="Europe/Kiev") ? "selected" : ""); ?>>(GMT +03:00) Europe/Kiev</option> <option value="Europe/Kirov" <?php echo (($rSettings["defaultTimezone"]=="Europe/Kirov") ? "selected" : ""); ?>>(GMT +03:00) Europe/Kirov</option> <option value="Europe/Lisbon" <?php echo (($rSettings["defaultTimezone"]=="Europe/Lisbon") ? "selected" : ""); ?>>(GMT +01:00) Europe/Lisbon</option> <option value="Europe/Ljubljana" <?php echo (($rSettings["defaultTimezone"]=="Europe/Ljubljana") ? "selected" : ""); ?>>(GMT +02:00) Europe/Ljubljana</option> <option value="Europe/London" <?php echo (($rSettings["defaultTimezone"]=="Europe/London") ? "selected" : ""); ?>>(GMT +01:00) Europe/London</option> <option value="Europe/Luxembourg" <?php echo (($rSettings["defaultTimezone"]=="Europe/Luxembourg") ? "selected" : ""); ?>>(GMT +02:00) Europe/Luxembourg</option> <option value="Europe/Madrid" <?php echo (($rSettings["defaultTimezone"]=="Europe/Madrid") ? "selected" : ""); ?>>(GMT +02:00) Europe/Madrid</option> <option value="Europe/Malta" <?php echo (($rSettings["defaultTimezone"]=="Europe/Malta") ? "selected" : ""); ?>>(GMT +02:00) Europe/Malta</option> <option value="Europe/Mariehamn" <?php echo (($rSettings["defaultTimezone"]=="Europe/Mariehamn") ? "selected" : ""); ?>>(GMT +03:00) Europe/Mariehamn</option> <option value="Europe/Minsk" <?php echo (($rSettings["defaultTimezone"]=="Europe/Minsk") ? "selected" : ""); ?>>(GMT +03:00) Europe/Minsk</option> <option value="Europe/Monaco" <?php echo (($rSettings["defaultTimezone"]=="Europe/Monaco") ? "selected" : ""); ?>>(GMT +02:00) Europe/Monaco</option> <option value="Europe/Moscow" <?php echo (($rSettings["defaultTimezone"]=="Europe/Moscow") ? "selected" : ""); ?>>(GMT +03:00) Europe/Moscow</option> <option value="Europe/Oslo" <?php echo (($rSettings["defaultTimezone"]=="Europe/Oslo") ? "selected" : ""); ?>>(GMT +02:00) Europe/Oslo</option> <option value="Europe/Paris" <?php echo (($rSettings["defaultTimezone"]=="Europe/Paris") ? "selected" : ""); ?>>(GMT +02:00) Europe/Paris</option> <option value="Europe/Podgorica" <?php echo (($rSettings["defaultTimezone"]=="Europe/Podgorica") ? "selected" : ""); ?>>(GMT +02:00) Europe/Podgorica</option> <option value="Europe/Prague" <?php echo (($rSettings["defaultTimezone"]=="Europe/Prague") ? "selected" : ""); ?>>(GMT +02:00) Europe/Prague</option> <option value="Europe/Riga" <?php echo (($rSettings["defaultTimezone"]=="Europe/Riga") ? "selected" : ""); ?>>(GMT +03:00) Europe/Riga</option> <option value="Europe/Rome" <?php echo (($rSettings["defaultTimezone"]=="Europe/Rome") ? "selected" : ""); ?>>(GMT +02:00) Europe/Rome</option> <option value="Europe/Samara" <?php echo (($rSettings["defaultTimezone"]=="Europe/Samara") ? "selected" : ""); ?>>(GMT +04:00) Europe/Samara</option> <option value="Europe/San_Marino" <?php echo (($rSettings["defaultTimezone"]=="Europe/San_Marino") ? "selected" : ""); ?>>(GMT +02:00) Europe/San Marino</option> <option value="Europe/Sarajevo" <?php echo (($rSettings["defaultTimezone"]=="Europe/Sarajevo") ? "selected" : ""); ?>>(GMT +02:00) Europe/Sarajevo</option> <option value="Europe/Saratov" <?php echo (($rSettings["defaultTimezone"]=="Europe/Saratov") ? "selected" : ""); ?>>(GMT +04:00) Europe/Saratov</option> <option value="Europe/Simferopol" <?php echo (($rSettings["defaultTimezone"]=="Europe/Simferopol") ? "selected" : ""); ?>>(GMT +03:00) Europe/Simferopol</option> <option value="Europe/Skopje" <?php echo (($rSettings["defaultTimezone"]=="Europe/Skopje") ? "selected" : ""); ?>>(GMT +02:00) Europe/Skopje</option> <option value="Europe/Sofia" <?php echo (($rSettings["defaultTimezone"]=="Europe/Sofia") ? "selected" : ""); ?>>(GMT +03:00) Europe/Sofia</option> <option value="Europe/Stockholm" <?php echo (($rSettings["defaultTimezone"]=="Europe/Stockholm") ? "selected" : ""); ?>>(GMT +02:00) Europe/Stockholm</option> <option value="Europe/Tallinn" <?php echo (($rSettings["defaultTimezone"]=="Europe/Tallinn") ? "selected" : ""); ?>>(GMT +03:00) Europe/Tallinn</option> <option value="Europe/Tirane" <?php echo (($rSettings["defaultTimezone"]=="Europe/Tirane") ? "selected" : ""); ?>>(GMT +02:00) Europe/Tirane</option> <option value="Europe/Ulyanovsk" <?php echo (($rSettings["defaultTimezone"]=="Europe/Ulyanovsk") ? "selected" : ""); ?>>(GMT +04:00) Europe/Ulyanovsk</option> <option value="Europe/Uzhgorod" <?php echo (($rSettings["defaultTimezone"]=="Europe/Uzhgorod") ? "selected" : ""); ?>>(GMT +03:00) Europe/Uzhgorod</option> <option value="Europe/Vaduz" <?php echo (($rSettings["defaultTimezone"]=="Europe/Vaduz") ? "selected" : ""); ?>>(GMT +02:00) Europe/Vaduz</option> <option value="Europe/Vatican" <?php echo (($rSettings["defaultTimezone"]=="Europe/Vatican") ? "selected" : ""); ?>>(GMT +02:00) Europe/Vatican</option> <option value="Europe/Vienna" <?php echo (($rSettings["defaultTimezone"]=="Europe/Vienna") ? "selected" : ""); ?>>(GMT +02:00) Europe/Vienna</option> <option value="Europe/Vilnius" <?php echo (($rSettings["defaultTimezone"]=="Europe/Vilnius") ? "selected" : ""); ?>>(GMT +03:00) Europe/Vilnius</option> <option value="Europe/Volgograd" <?php echo (($rSettings["defaultTimezone"]=="Europe/Volgograd") ? "selected" : ""); ?>>(GMT +03:00) Europe/Volgograd</option> <option value="Europe/Warsaw" <?php echo (($rSettings["defaultTimezone"]=="Europe/Warsaw") ? "selected" : ""); ?>>(GMT +02:00) Europe/Warsaw</option> <option value="Europe/Zagreb" <?php echo (($rSettings["defaultTimezone"]=="Europe/Zagreb") ? "selected" : ""); ?>>(GMT +02:00) Europe/Zagreb</option> <option value="Europe/Zaporozhye" <?php echo (($rSettings["defaultTimezone"]=="Europe/Zaporozhye") ? "selected" : ""); ?>>(GMT +03:00) Europe/Zaporozhye</option> <option value="Europe/Zurich" <?php echo (($rSettings["defaultTimezone"]=="Europe/Zurich") ? "selected" : ""); ?>>(GMT +02:00) Europe/Zurich</option> <option value="Indian/Antananarivo" <?php echo (($rSettings["defaultTimezone"]=="Indian/Antananarivo") ? "selected" : ""); ?>>(GMT +03:00) Indian/Antananarivo</option> <option value="Indian/Chagos" <?php echo (($rSettings["defaultTimezone"]=="Indian/Chagos") ? "selected" : ""); ?>>(GMT +06:00) Indian/Chagos</option> <option value="Indian/Christmas" <?php echo (($rSettings["defaultTimezone"]=="Indian/Christmas") ? "selected" : ""); ?>>(GMT +07:00) Indian/Christmas</option> <option value="Indian/Cocos" <?php echo (($rSettings["defaultTimezone"]=="Indian/Cocos") ? "selected" : ""); ?>>(GMT +06:30) Indian/Cocos</option> <option value="Indian/Comoro" <?php echo (($rSettings["defaultTimezone"]=="Indian/Comoro") ? "selected" : ""); ?>>(GMT +03:00) Indian/Comoro</option> <option value="Indian/Kerguelen" <?php echo (($rSettings["defaultTimezone"]=="Indian/Kerguelen") ? "selected" : ""); ?>>(GMT +05:00) Indian/Kerguelen</option> <option value="Indian/Mahe" <?php echo (($rSettings["defaultTimezone"]=="Indian/Mahe") ? "selected" : ""); ?>>(GMT +04:00) Indian/Mahe</option> <option value="Indian/Maldives" <?php echo (($rSettings["defaultTimezone"]=="Indian/Maldives") ? "selected" : ""); ?>>(GMT +05:00) Indian/Maldives</option> <option value="Indian/Mauritius" <?php echo (($rSettings["defaultTimezone"]=="Indian/Mauritius") ? "selected" : ""); ?>>(GMT +04:00) Indian/Mauritius</option> <option value="Indian/Mayotte" <?php echo (($rSettings["defaultTimezone"]=="Indian/Mayotte") ? "selected" : ""); ?>>(GMT +03:00) Indian/Mayotte</option> <option value="Indian/Reunion" <?php echo (($rSettings["defaultTimezone"]=="Indian/Reunion") ? "selected" : ""); ?>>(GMT +04:00) Indian/Reunion</option> <option value="Pacific/Apia" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Apia") ? "selected" : ""); ?>>(GMT +13:00) Pacific/Apia</option> <option value="Pacific/Auckland" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Auckland") ? "selected" : ""); ?>>(GMT +12:00) Pacific/Auckland</option> <option value="Pacific/Bougainville" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Bougainville") ? "selected" : ""); ?>>(GMT +11:00) Pacific/Bougainville</option> <option value="Pacific/Chatham" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Chatham") ? "selected" : ""); ?>>(GMT +12:45) Pacific/Chatham</option> <option value="Pacific/Chuuk" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Chuuk") ? "selected" : ""); ?>>(GMT +10:00) Pacific/Chuuk</option> <option value="Pacific/Easter" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Easter") ? "selected" : ""); ?>>(GMT -06:00) Pacific/Easter</option> <option value="Pacific/Efate" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Efate") ? "selected" : ""); ?>>(GMT +11:00) Pacific/Efate</option> <option value="Pacific/Fakaofo" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Fakaofo") ? "selected" : ""); ?>>(GMT +13:00) Pacific/Fakaofo</option> <option value="Pacific/Fiji" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Fiji") ? "selected" : ""); ?>>(GMT +12:00) Pacific/Fiji</option> <option value="Pacific/Funafuti" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Funafuti") ? "selected" : ""); ?>>(GMT +12:00) Pacific/Funafuti</option> <option value="Pacific/Galapagos" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Galapagos") ? "selected" : ""); ?>>(GMT -06:00) Pacific/Galapagos</option> <option value="Pacific/Gambier" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Gambier") ? "selected" : ""); ?>>(GMT -09:00) Pacific/Gambier</option> <option value="Pacific/Guadalcanal" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Guadalcanal") ? "selected" : ""); ?>>(GMT +11:00) Pacific/Guadalcanal</option> <option value="Pacific/Guam" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Guam") ? "selected" : ""); ?>>(GMT +10:00) Pacific/Guam</option> <option value="Pacific/Honolulu" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Honolulu") ? "selected" : ""); ?>>(GMT -10:00) Pacific/Honolulu</option> <option value="Pacific/Kanton" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Kanton") ? "selected" : ""); ?>>(GMT +13:00) Pacific/Kanton</option> <option value="Pacific/Kiritimati" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Kiritimati") ? "selected" : ""); ?>>(GMT +14:00) Pacific/Kiritimati</option> <option value="Pacific/Kosrae" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Kosrae") ? "selected" : ""); ?>>(GMT +11:00) Pacific/Kosrae</option> <option value="Pacific/Kwajalein" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Kwajalein") ? "selected" : ""); ?>>(GMT +12:00) Pacific/Kwajalein</option> <option value="Pacific/Majuro" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Majuro") ? "selected" : ""); ?>>(GMT +12:00) Pacific/Majuro</option> <option value="Pacific/Marquesas" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Marquesas") ? "selected" : ""); ?>>(GMT -09:30) Pacific/Marquesas</option> <option value="Pacific/Midway" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Midway") ? "selected" : ""); ?>>(GMT -11:00) Pacific/Midway</option> <option value="Pacific/Nauru" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Nauru") ? "selected" : ""); ?>>(GMT +12:00) Pacific/Nauru</option> <option value="Pacific/Niue" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Niue") ? "selected" : ""); ?>>(GMT -11:00) Pacific/Niue</option> <option value="Pacific/Norfolk" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Norfolk") ? "selected" : ""); ?>>(GMT +11:00) Pacific/Norfolk</option> <option value="Pacific/Noumea" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Noumea") ? "selected" : ""); ?>>(GMT +11:00) Pacific/Noumea</option> <option value="Pacific/Pago_Pago" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Pago_Pago") ? "selected" : ""); ?>>(GMT -11:00) Pacific/Pago Pago</option> <option value="Pacific/Palau" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Palau") ? "selected" : ""); ?>>(GMT +09:00) Pacific/Palau</option> <option value="Pacific/Pitcairn" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Pitcairn") ? "selected" : ""); ?>>(GMT -08:00) Pacific/Pitcairn</option> <option value="Pacific/Pohnpei" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Pohnpei") ? "selected" : ""); ?>>(GMT +11:00) Pacific/Pohnpei</option> <option value="Pacific/Port_Moresby" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Port_Moresby") ? "selected" : ""); ?>>(GMT +10:00) Pacific/Port Moresby</option> <option value="Pacific/Rarotonga" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Rarotonga") ? "selected" : ""); ?>>(GMT -10:00) Pacific/Rarotonga</option> <option value="Pacific/Saipan" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Saipan") ? "selected" : ""); ?>>(GMT +10:00) Pacific/Saipan</option> <option value="Pacific/Tahiti" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Tahiti") ? "selected" : ""); ?>>(GMT -10:00) Pacific/Tahiti</option> <option value="Pacific/Tarawa" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Tarawa") ? "selected" : ""); ?>>(GMT +12:00) Pacific/Tarawa</option> <option value="Pacific/Tongatapu" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Tongatapu") ? "selected" : ""); ?>>(GMT +13:00) Pacific/Tongatapu</option> <option value="Pacific/Wake" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Wake") ? "selected" : ""); ?>>(GMT +12:00) Pacific/Wake</option> <option value="Pacific/Wallis" <?php echo (($rSettings["defaultTimezone"]=="Pacific/Wallis") ? "selected" : ""); ?>>(GMT +12:00) Pacific/Wallis</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-default-language" class="col-sm-3 col-form-label"><?php echo languageVariables("systemDefaultLanguageTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <?php $languageList = $db->query("SELECT * FROM languages ORDER BY id ASC"); ?>
                <select class="form-control" id="settings-system-default-language" name="settingsDefaultLanguage">
                  <?php foreach ($languageList as $readLanguage) { ?>
                  <option value="<?php echo $readLanguage["code"]; ?>" <?php echo (($rSettings["defaultLanguage"] == $readLanguage["code"]) ? "selected" : ""); ?>><?php echo $readLanguage["title"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-default-currency" class="col-sm-3 col-form-label"><?php echo languageVariables("systemCurrencyTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-default-currency" name="settingsCurrency">
                  <option value="TRY" <?php echo (($rSettings["currency"] == "TRY") ? "selected" : ""); ?>>TRY (₺)</option>
                  <option value="USD" <?php echo (($rSettings["currency"] == "USD") ? "selected" : ""); ?>>USD ($)</option>
                  <option value="EUR" <?php echo (($rSettings["currency"] == "EUR") ? "selected" : ""); ?>>EUR (Є)</option>
                  <option value="GBP" <?php echo (($rSettings["currency"] == "GBP") ? "selected" : ""); ?>>GBP (£)</option>
                  <option value="AUD" <?php echo (($rSettings["currency"] == "AUD") ? "selected" : ""); ?>>AUD (AU$)</option>
                  <option value="NZD" <?php echo (($rSettings["currency"] == "NZD") ? "selected" : ""); ?>>NZD (NZ$)</option>
                  <option value="CAD" <?php echo (($rSettings["currency"] == "CAD") ? "selected" : ""); ?>>CAD (CA$)</option>
                  <option value="MXN" <?php echo (($rSettings["currency"] == "MXN") ? "selected" : ""); ?>>RON (MX$)</option>
                  <option value="RUB" <?php echo (($rSettings["currency"] == "RUB") ? "selected" : ""); ?>>RUB (₽)</option>
                  <option value="RON" <?php echo (($rSettings["currency"] == "RON") ? "selected" : ""); ?>>RON (L)</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-maintance-status" class="col-sm-3 col-form-label"><?php echo languageVariables("systemMaintanceMode", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-maintance-status" name="settingsMaintanceStatus">
                  <option value="0" <?php if ($rSettings["maintanceStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($rSettings["maintanceStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-password-hash" class="col-sm-3 col-form-label"><?php echo languageVariables("systemPasswordHash", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                
                <select class="form-control" id="settings-system-password-hash" name="settingsPasswordHash">
                  <option value="0" <?php if ($rSettings["passwordHash"] == "0") { echo "selected"; } ?>>SHA256</option>
                  <option value="1" <?php if ($rSettings["passwordHash"] == "1") { echo "selected"; } ?>>MD5</option>
                  <option value="2" <?php if ($rSettings["passwordHash"] == "2") { echo "selected"; } ?>>BCRYPT</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-debug-mode" class="col-sm-3 col-form-label"><?php echo languageVariables("systemDebugMode", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-debug-mode" name="settingsDebugMode">
                  <option value="0" <?php if ($rSettings["debugModeStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($rSettings["debugModeStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-ssl-mode" class="col-sm-3 col-form-label"><?php echo languageVariables("systemSSLMode", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-ssl-mode" name="settingsSSLMode">
                  <option value="0" <?php if ($rSettings["SSLModeStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($rSettings["SSLModeStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
                <small class="form-text text-muted">
                  <?php echo languageVariables("systemSSLModeNote", "settings", $languageType); ?>
                </small>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-server-online-api" class="col-sm-3 col-form-label"><?php echo languageVariables("systemOnlineAPI", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-server-online-api" name="settingsServerOnlineAPI">
                  <option value="1" <?php if ($rSettings["serverOnlineStatusAPI"] == "1") { echo "selected"; } ?>>mcapi.us (Java Edition)</option>
                  <option value="2" <?php if ($rSettings["serverOnlineStatusAPI"] == "2") { echo "selected"; } ?>>mcapi.tc (Java Edition)</option>
                  <option value="3" <?php if ($rSettings["serverOnlineStatusAPI"] == "3") { echo "selected"; } ?>>mc-api.net (Java Edition)</option>
                  <option value="4" <?php if ($rSettings["serverOnlineStatusAPI"] == "4") { echo "selected"; } ?>>mcsrvstat.us (Java Edition)</option>
                  <option value="5" <?php if ($rSettings["serverOnlineStatusAPI"] == "5") { echo "selected"; } ?>>mcsrvstat.us (Pocket Edition)</option>
                  <option value="6" <?php if ($rSettings["serverOnlineStatusAPI"] == "6") { echo "selected"; } ?>>keyubu.net (Java Edition)</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-server-avatar-api" class="col-sm-3 col-form-label"><?php echo languageVariables("systemAvatarAPI", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-server-avatar-api" name="settingsAvatarAPI">
                  <option value="1" <?php if ($rSettings["avatarAPI"] == "1") { echo "selected"; } ?>>minotar.net (<?php echo languageVariables("suggested", "words", $languageType); ?>)</option>
                  <option value="2" <?php if ($rSettings["avatarAPI"] == "2") { echo "selected"; } ?>>cravatar.eu</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-forum-mode" class="col-sm-3 col-form-label"><?php echo languageVariables("forum", "words", $languageType); ?>:</label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-forum-mode" name="settingsForumStatus">
                  <option value="0" <?php if ($readModule["forumStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["forumStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-module-vote-status" class="col-sm-3 col-form-label"><?php echo languageVariables("systemVoteTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-module-vote-status" name="settingsVoteSystemStatus" data-toggle="VoteSystemStatusSelect">
                  <option value="0" <?php if ($readModule["voteSystemStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["voteSystemStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div <?php if ($readModule["voteSystemStatus"] == "0") { echo "style=\"display: none;\""; } ?> data-toggle="VoteSystemStatusInput">
              <div class="form-group row">
                <label for="settings-system-module-vote-server-key" class="col-sm-3 col-form-label">Server Key:*</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="settings-system-module-vote-server-key" name="settingsVoteSystemServerKey" placeholder="<?php echo languageVariables("systemVotePlaceholder", "settings", $languageType); ?>" value="<?php echo $readModule["voteSystemServerKey"]; ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-module-kdv-status" class="col-sm-3 col-form-label"><?php echo languageVariables("systemKDVStatus", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-module-kdv-status" name="settingsKDVStatus" data-toggle="KDVStatusSelect">
                  <option value="0" <?php if ($readModule["KDVStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["KDVStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div <?php if ($readModule["KDVStatus"] == "0") { echo "style=\"display: none;\""; } ?> data-toggle="KDVValueInput">
              <div class="form-group row">
                <label for="settings-system-module-kdv-value" class="col-sm-3 col-form-label"><?php echo languageVariables("systemKDVValue", "settings", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="settings-system-module-kdv-value" name="settingsKDVValue" placeholder="<?php echo languageVariables("systemKDVValuePlaceholder", "settings", $languageType); ?>" value="<?php echo $readModule["KDVValue"]; ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-api-key" class="col-sm-3 col-form-label">API Key:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="settings-system-api-key" name="settingsAPIKey" placeholder="Web REST API password key." value="<?php echo $rSettings["apiKey"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-banned-type" class="col-sm-3 col-form-label"><?php echo languageVariables("systemBans", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-banned-type" name="settingsBannedType">
                  <option value="0" <?php if ($rSettings["bannedType"] == "0") { echo "selected"; } ?>><?php echo languageVariables("systemBansOptionSite", "settings", $languageType); ?></option>
                  <option value="1" <?php if ($rSettings["bannedType"] == "1") { echo "selected"; } ?>><?php echo languageVariables("systemBansOptionPlugin", "settings", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-snow-mode" class="col-sm-3 col-form-label"><?php echo languageVariables("systemSnowMode", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-snow-mode" name="settingsSnowModeStatus">
                  <option value="0" <?php if ($readModule["snowModeStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["snowModeStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-credit-transfer-mode" class="col-sm-3 col-form-label"><?php echo languageVariables("systemCreditTransferStatus", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-credit-transfer-mode" name="settingsCreditTransfer">
                  <option value="0" <?php if ($readModule["creditTransferStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["creditTransferStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-gift-transfer-mode" class="col-sm-3 col-form-label"><?php echo languageVariables("systemGiftSenderStatus", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-gift-transfer-mode" name="settingsGiftTransfer">
                  <option value="0" <?php if ($readModule["giftTransferStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["giftTransferStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-store-ex-product" class="col-sm-3 col-form-label"><?php echo languageVariables("systemStoreAltBarStatus", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-store-ex-product" name="settingsStoreExProduct">
                  <option value="0" <?php if ($readModule["storeExProductStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["storeExProductStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-broadcast-status" class="col-sm-3 col-form-label"><?php echo languageVariables("systemNoticeHome", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-broadcast-status" name="settingsBroadcastStatus">
                  <option value="0" <?php if ($readModule["broadcastStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["broadcastStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-sidebar-status" class="col-sm-3 col-form-label"><?php echo languageVariables("systemSidebarHome", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-sidebar-status" name="settingsSidebarStatus">
                  <option value="0" <?php if ($readModule["sidebarStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["sidebarStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-preloader-status" class="col-sm-3 col-form-label"><?php echo languageVariables("systemPreloaderStatus", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-preloader-status" name="settingsPreloaderStatus">
                  <option value="0" <?php if ($readModule["preloaderStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($readModule["preloaderStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?> (<?php echo languageVariables("suggested", "words", $languageType); ?>)</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-comments" class="col-sm-3 col-form-label"><?php echo languageVariables("systemComments", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-comments" name="settingsComments">
                  <option value="0" <?php if ($rSettings["commentsStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($rSettings["commentsStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-live-chat" class="col-sm-3 col-form-label"><?php echo languageVariables("systemTawkTO", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-live-chat" name="settingsLiveChat" data-toggle="LiveChatStatus">
                  <option value="0" <?php if ($rMedia["liveSupportStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($rMedia["liveSupportStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div <?php if ($rMedia["liveSupportStatus"] == "0") { echo "style=\"display: none;\""; } ?> data-toggle="LiveChatValue">
              <div class="form-group row">
                <label for="settings-system-live-chat-embed" class="col-sm-3 col-form-label">Tawk.to ID:*</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="settings-system-live-chat-embed" name="settingsLiveChatEmbed" placeholder="<?php echo languageVariables("systemTawkTOTitle", "settings", $languageType); ?>" value="<?php echo $rMedia["liveSupportEmbed"]; ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-google-analytics" class="col-sm-3 col-form-label"><?php echo languageVariables("systemGoogleAnalytics", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="settings-system-google-analytics" name="settingsGoogleAI" placeholder="<?php echo languageVariables("systemGoogleAnalyticsPlaceholder", "settings", $languageType); ?>" value="<?php echo $rSettings["googleAI"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-recaptcha" class="col-sm-3 col-form-label">Google reCAPTCHA:</label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-recaptcha" name="settingsRecaptchaStatus" data-toggle="reCAPTCHAStatus">
                  <option value="0" <?php if ($rSettings["recaptchaStatus"] == "0") { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php if ($rSettings["recaptchaStatus"] == "1") { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div <?php if ($rSettings["recaptchaStatus"] == "0") { echo "style=\"display: none;\""; } ?> data-toggle="reCAPTCHAValue">
              <div class="form-group row">
                <label for="settings-system-recaptcha-public-key" class="col-sm-3 col-form-label"><?php echo languageVariables("systemRecaptchaSiteKey", "settings", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="settings-system-recaptcha-public-key" name="settingsRecaptchaPublicKey" placeholder="<?php echo languageVariables("systemRecaptchaSiteKeyPlaceholder", "settings", $languageType); ?>" value="<?php echo $rSettings["recaptchaPublicKey"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="settings-system-recaptcha-private-key" class="col-sm-3 col-form-label"><?php echo languageVariables("systemRecaptchaSecretKey", "settings", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="settings-system-recaptcha-private-key" name="settingsRecaptchaPrivateKey" placeholder="<?php echo languageVariables("systemRecaptchaSecretKeyPlaceholder", "settings", $languageType); ?>" value="<?php echo $rSettings["recaptchaPrivateKey"]; ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-register-limit-status" class="col-sm-3 col-form-label"><?php echo languageVariables("systemRegisterLimit", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-system-register-limit-status" name="settingsRegisterLimitStatus" data-toggle="registerLimitStatus">
                  <option value="0" <?php if ($rSettings["registerLimit"] == "0") { echo "selected"; } ?>><?php echo languageVariables("unlimited", "words", $languageType); ?></option>
                  <option value="1" <?php if ($rSettings["registerLimit"] !== "0") { echo "selected"; } ?>><?php echo languageVariables("customized", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div <?php if ($rSettings["registerLimit"] == "0") { echo "style=\"display: none;\""; } ?> data-toggle="registerLimitValue">
              <div class="form-group row">
                <label for="settings-system-register-limit" class="col-sm-3 col-form-label"><?php echo languageVariables("systemRegisterLimitValueTitle", "settings", $languageType); ?></label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="settings-system-register-limit" name="settingsRegisterLimitValue" placeholder="<?php echo languageVariables("systemRegisterLimitValuePlaceholder", "settings", $languageType); ?>" value="<?php echo $rSettings["registerLimit"]; ?>">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-support-limit" class="col-sm-3 col-form-label"><?php echo languageVariables("systemSupportLimitTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="settings-system-support-limit" name="settingsSupportLimitValue" placeholder="<?php echo languageVariables("systemSupportLimitPlaceholder", "settings", $languageType); ?>" value="<?php echo $readModule["maxSupportLimit"]; ?>">
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else if (get("action") == "smtp") { ?>
<?php if (AccountPermControl($readAccount["id"], "settings_smtp") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<style type="text/css">
.col-form-label {
  word-break: break-all;
}
</style>
<?php
  $settingsVariables = array(
    "1" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "smtpServer",
      "type" => "text",
      "ID" => "settings-smtp-server",
      "name" => "settingsServer",
      "title" => languageVariables("smtpServerTitle", "settings", $languageType),
      "placeholder" => languageVariables("smtpServerPlaceholder", "settings", $languageType),
      "value" => $rSettings["smtpServer"]
    ),
    
    "2" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "smtpPort",
      "type" => "number",
      "ID" => "settings-smtp-port",
      "name" => "settingsSMTPPort",
      "title" => languageVariables("smtpPortTitle", "settings", $languageType),
      "placeholder" => languageVariables("smtpPortPlaceholder", "settings", $languageType),
      "value" => $rSettings["smtpPort"]
    ),
    
    "3" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "smtpSecure",
      "type" => "1",
      "ID" => "settings-smtp-security",
      "name" => "settingsSecurity",
      "title" => languageVariables("smtpSecurityTitle", "settings", $languageType),
      "value" => $rSettings["smtpSecure"]
    ),
    
    "4" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "smtpUsername",
      "type" => "text",
      "ID" => "settings-smtp-email",
      "name" => "settingsSMTPEmail",
      "title" => languageVariables("smtpUsernameTitle", "settings", $languageType),
      "placeholder" => languageVariables("smtpUsernamePlaceholder", "settings", $languageType),
      "value" => $rSettings["smtpUsername"]
    ),
    
    "5" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "smtpPassword",
      "type" => "text",
      "ID" => "settings-smtp-password",
      "name" => "settingsPassword",
      "title" => languageVariables("smtpPasswordTitle", "settings", $languageType),
      "placeholder" => languageVariables("smtpPasswordPlaceholder", "settings", $languageType),
      "value" => $rSettings["smtpPassword"]
    ),
    
    "12" => array(
      "MySQLTable" => "settings",
      "MySQLName" => "smtpTemplate",
      "type" => 2,
      "ID" => "settings-smtp-template",
      "name" => "settingsTemplate",
      "title" => languageVariables("smtpRecoveryTemplateTitle", "settings", $languageType),
      "placeholder" => languageVariables("smtpRecoveryTemplatePlaceholder", "settings", $languageType),
      "html" => languageVariables("smtpRecoveryTemplateNote", "settings", $languageType),
      "value" => $rSettings["smtpTemplate"]
    )
  );
?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_settings_general", $languageType); ?>"><?php echo languageVariables("settings", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page">SMTP</li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("smtpSettings", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token'); 
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              if (post("settingsServer") !== "" && post("settingsSMTPPort") !== "" && post("settingsSecurity") !== "" && post("settingsSMTPEmail") !== "" && post("settingsPassword") !== "") {
                foreach ($settingsVariables as $readSettingsVariables) {
                  $MySQLTableName = $readSettingsVariables["MySQLTable"];
                  $InputName = $readSettingsVariables["name"];
                  $ValueName = $readSettingsVariables["MySQLName"];
                  if ($readSettingsVariables["type"] == 2) {
                    $UpdateValue = $_POST[$InputName];
                  } else {
                    $UpdateValue = post($InputName);
                  }
                  if ($readSettingsVariables["value"] !== $UpdateValue) {
                    $saveChanges = $db->prepare("UPDATE $MySQLTableName SET $ValueName = ?");
                    $saveChanges->execute(array($UpdateValue));
                  }
                }
                echo alert(languageVariables("alertSaveChanges", "settings", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "settings", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <?php foreach ($settingsVariables as $readSettingsVariables) { ?>
            <div class="form-group row">
              <div class="col-sm-3">
                <label for="<?php echo $readSettingsVariables["ID"]; ?>" class="col-form-label"><?php echo $readSettingsVariables["title"]; ?></label>
              </div>
              <div class="col-sm-9">
                <?php if ($readSettingsVariables["type"] == "1") { ?>
                <select id="<?php echo $readSettingsVariables["ID"]; ?>" class="form-control" name="<?php echo $readSettingsVariables["name"]; ?>">
                  <option value="1" <?php if($readSettingsVariables['value'] == "1"){ echo 'selected'; } ?>>SSL</option>
                  <option value="2" <?php if($readSettingsVariables['value'] == "2"){ echo 'selected'; } ?>>TLS</option>
                </select>
                <?php } else if ($readSettingsVariables["type"] == "2") { ?>
                <textarea class="form-control ckeditor" id="<?php echo $readSettingsVariables["ID"]; ?>" name="<?php echo $readSettingsVariables["name"]; ?>" placeholder="<?php echo $readSettingsVariables["placeholder"]; ?>"><?php echo $readSettingsVariables["value"]; ?></textarea>
                <?php echo $readSettingsVariables["html"]; ?>
                <?php } else { ?>
                <input type="<?php echo $readSettingsVariables["type"]; ?>" class="form-control" id="<?php echo $readSettingsVariables["ID"]; ?>" name="<?php echo $readSettingsVariables["name"]; ?>" placeholder="<?php echo $readSettingsVariables["placeholder"]; ?>" value="<?php echo $readSettingsVariables["value"]; ?>">
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else if (get("action") == "payment") { ?>
<?php if (AccountPermControl($readAccount["id"], "settings_payment") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php
  $searchPayments = $db->query("SELECT * FROM payments ORDER BY id ASC");
  $readPayments = fetch($searchPayments);
  $readPaymentVariables = json_decode($readPayments["variables"], true);
  $settingsVariables = array(
    "1" => array(
      "ID" => "settings-payment-paytr-id",
      "paymentType" => "paytr",
      "name" => "paytrID",
      "title" => languageVariables("paymentPaytrID", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaytrIDPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["paytrID"]
    ),
    
    "2" => array(
      "ID" => "settings-payment-paytr-password",
      "paymentType" => "paytr",
      "name" => "paytrAPIKey",
      "title" => languageVariables("paymentPaytrKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaytrKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["paytrAPIKey"]
    ),
    
    "3" => array(
      "ID" => "settings-payment-paytr-secret",
      "paymentType" => "paytr",
      "name" => "paytrAPISecretKey",
      "title" => languageVariables("paymentPaytrSecretKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaytrSecretKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["paytrAPISecretKey"]
    ),
    
    "4" => array(
      "ID" => "settings-payment-paywant-key",
      "paymentType" => "paywant",
      "name" => "paywantAPIKey",
      "title" => languageVariables("paymentPaywantKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaywantKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["paywantAPIKey"]
    ),
    
    "5" => array(
      "ID" => "settings-payment-paywant-secret-key",
      "paymentType" => "paywant",
      "name" => "paywantAPISecretKey",
      "title" => languageVariables("paymentPaywantSecretKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaywantSecretKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["paywantAPISecretKey"]
    ),
    
    "6" => array(
      "ID" => "settings-payment-paywant-commission",
      "paymentType" => "paywant",
      "name" => "paywantCommissionType",
      "title" => languageVariables("paymentPaywantComission", "settings", $languageType),
      "value" => $readPaymentVariables["paywantCommissionType"]
    ),
    
    "7" => array(
      "ID" => "settings-payment-shipy-key",
      "paymentType" => "shipy",
      "name" => "shipyAPIKey",
      "title" => languageVariables("paymentShipyKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentShipyKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["shipyAPIKey"]
    ),
    
    "8" => array(
      "ID" => "settings-payment-paylith-key",
      "paymentType" => "paylith",
      "name" => "paylithAPIKey",
      "title" => languageVariables("paymentPaylithKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaylithKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["paylithAPIKey"]
    ),
    
    "9" => array(
      "ID" => "settings-payment-paylith-secret-key",
      "paymentType" => "paylith",
      "name" => "paylithAPISecretKey",
      "title" => languageVariables("paymentPaylithSecretKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaylithSecretKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["paylithAPISecretKey"]
    ),
    
    "10" => array(
      "ID" => "settings-payment-shopier-key",
      "paymentType" => "shopier",
      "name" => "shopierAPIKey",
      "title" => languageVariables("paymentShopierKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentShopierKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["shopierAPIKey"]
    ),
    
    "11" => array(
      "ID" => "settings-payment-shopier-secret-key",
      "paymentType" => "shopier",
      "name" => "shopierAPISecretKey",
      "title" => languageVariables("paymentShopierSecretKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentShopierSecretKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["shopierAPISecretKey"]
    ),
    
    "12" => array(
      "ID" => "settings-payment-batihost-id",
      "paymentType" => "batihost",
      "name" => "batihostID",
      "title" => languageVariables("paymentBatihostID", "settings", $languageType),
      "placeholder" => languageVariables("paymentBatihostIDPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["batihostID"]
    ),
    
    "13" => array(
      "ID" => "settings-payment-batihost-token",
      "paymentType" => "batihost",
      "name" => "batihostToken",
      "title" => languageVariables("paymentBatihostToken", "settings", $languageType),
      "placeholder" => languageVariables("paymentBatihostTokenPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["batihostToken"]
    ),
    
    "14" => array(
      "ID" => "settings-payment-batihost-email",
      "paymentType" => "batihost",
      "name" => "batihostEmail",
      "title" => languageVariables("paymentBatihostEmail", "settings", $languageType),
      "placeholder" => languageVariables("paymentBatihostEmailPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["batihostEmail"]
    ),
    
    "15" => array(
      "ID" => "settings-payment-keyubu-id",
      "paymentType" => "keyubu",
      "name" => "keyubuID",
      "title" => languageVariables("paymentKeyubuID", "settings", $languageType),
      "placeholder" => languageVariables("paymentKeyubuIDPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["keyubuID"]
    ),
    
    "16" => array(
      "ID" => "settings-payment-keyubu-token",
      "paymentType" => "keyubu",
      "name" => "keyubuToken",
      "title" => languageVariables("paymentKeyubuToken", "settings", $languageType),
      "placeholder" => languageVariables("paymentKeyubuTokenPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["keyubuToken"]
    ),
    
    "17" => array(
      "ID" => "settings-payment-rabisu-id",
      "paymentType" => "rabisu",
      "name" => "rabisuID",
      "title" => languageVariables("paymentRabisuID", "settings", $languageType),
      "placeholder" => languageVariables("paymentRabisuIDPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["rabisuID"]
    ),
    
    "18" => array(
      "ID" => "settings-payment-rabisu-token",
      "paymentType" => "rabisu",
      "name" => "rabisuToken",
      "title" => languageVariables("paymentRabisuToken", "settings", $languageType),
      "placeholder" => languageVariables("paymentRabisuTokenPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["rabisuToken"]
    ),
    
    "19" => array(
      "ID" => "settings-payment-stripe-mode",
      "paymentType" => "stripe",
      "name" => "stripeMode",
      "title" => languageVariables("paymentStripeMode", "settings", $languageType),
      "value" => $readPaymentVariables["stripeMode"]
    ),
    
    "20" => array(
      "ID" => "settings-payment-stripe-publish-key",
      "paymentType" => "stripe",
      "name" => "stripePublishKey",
      "title" => languageVariables("paymentStripePublishKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentStripePublishKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["stripePublishKey"]
    ),
    
    "21" => array(
      "ID" => "settings-payment-stripe-secret-key",
      "paymentType" => "stripe",
      "name" => "stripeSecretKey",
      "title" => languageVariables("paymentStripeSecretKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentStripeSecretKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["stripeSecretKey"]
    ),
    
    "22" => array(
      "ID" => "settings-payment-paypal-mode",
      "paymentType" => "paypal",
      "name" => "paypalMode",
      "title" => languageVariables("paymentPaypalMode", "settings", $languageType),
      "value" => $readPaymentVariables["paypalMode"]
    ),
    
    "23" => array(
      "ID" => "settings-payment-paypal-client-key",
      "paymentType" => "paypal",
      "name" => "paypalClientID",
      "title" => languageVariables("paymentPaypalClientID", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaypalClientIDPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["paypalClientID"]
    ),
    
    "24" => array(
      "ID" => "settings-payment-paypal-secret-key",
      "paymentType" => "paypal",
      "name" => "paypalClientSecret",
      "title" => languageVariables("paymentPaypalClientSecret", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaypalClientSecretPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["paypalClientSecret"]
    ),
    
    "25" => array(
      "ID" => "settings-payment-anksoft-merchant-key",
      "paymentType" => "anksoft",
      "name" => "anksoftMerchantKey",
      "title" => languageVariables("paymentAnksoftKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentAnksoftKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["anksoftMerchantKey"]
    ),
    
    "26" => array(
      "ID" => "settings-payment-anksoft-merchant-secret-key",
      "paymentType" => "anksoft",
      "name" => "anksoftMerchantSecretKey",
      "title" => languageVariables("paymentAnksoftSecretKey", "settings", $languageType),
      "placeholder" => languageVariables("paymentAnksoftSecretKeyPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["anksoftMerchantSecretKey"]
    ),

    "27" => array(
      "ID" => "settings-payment-tranfser",
      "paymentType" => "transfer",
      "name" => "transfer",
      "title" => languageVariables("paymentTransfer", "settings", $languageType),
      "placeholder" => languageVariables("paymentTransferPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["transfer"]
    ),
    
    "28" => array(
      "ID" => "settings-payment-ininal",
      "paymentType" => "ininal",
      "name" => "ininal",
      "title" => languageVariables("paymentIninal", "settings", $languageType),
      "placeholder" => languageVariables("paymentIninalPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["ininal"]
    ),
    
    "29" => array(
      "ID" => "settings-payment-papara",
      "paymentType" => "papara",
      "name" => "papara",
      "title" => languageVariables("paymentPapara", "settings", $languageType),
      "placeholder" => languageVariables("paymentPaparaPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["papara"]
    ),
    
    "30" => array(
      "ID" => "settings-payment-tosla",
      "paymentType" => "tosla",
      "name" => "tosla",
      "title" => languageVariables("paymentTosla", "settings", $languageType),
      "placeholder" => languageVariables("paymentToslaPlaceholder", "settings", $languageType),
      "value" => $readPaymentVariables["tosla"]
    ),
    
    "31" => array(
      "ID" => "settings-payment-paymax-user-id",
      "paymentType" => "paymax",
      "name" => "paymaxUserID",
      "title" => "Paymax User ID:",
      "placeholder" => "Paymax user id",
      "value" => $readPaymentVariables["paymaxUserID"]
    ),
    
    "32" => array(
      "ID" => "settings-payment-paymax-api-key",
      "paymentType" => "paymax",
      "name" => "paymaxAPIKey",
      "title" => "Paymax API Key:",
      "placeholder" => "Paymax api key",
      "value" => $readPaymentVariables["paymaxAPIKey"]
    ),
    
    "33" => array(
      "ID" => "settings-payment-paymax-merchant-code",
      "paymentType" => "paymax",
      "name" => "paymaxMerchantCode",
      "title" => "Paymax Merchant Code:",
      "placeholder" => "Paymax merchant code",
      "value" => $readPaymentVariables["paymaxMerchantCode"]
    ),
    
    "34" => array(
      "ID" => "settings-payment-paymax-hash",
      "paymentType" => "paymax",
      "name" => "paymaxHash",
      "title" => "Paymax Hash:",
      "placeholder" => "Paymax hash",
      "value" => $readPaymentVariables["paymaxHash"]
    ),

    "35" => array(
      "ID" => "settings-payment-paypal-ipn-mode",
      "paymentType" => "paypalipn",
      "name" => "paypalIPNType",
      "title" => "PayPal:",
      "value" => $readPaymentVariables["paypalIPNType"]
    ),
    
    "36" => array(
      "ID" => "settings-payment-paypal-ipn-email",
      "paymentType" => "paypalipn",
      "name" => "paypalEmail",
      "title" => "PayPal Email:",
      "placeholder" => "PayPal account email.",
      "value" => $readPaymentVariables["paypalEmail"]
    )
  );
?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_settings_general", $languageType); ?>"><?php echo languageVariables("settings", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("payment", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("paymentWidgets", "words", $languageType); ?></h6>
          <?php 
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token'); 
            
            if (isset($_POST["saveChangesOne"])) {
              if ($safeCsrfToken->validate('saveChangesTokenOne')) {
                $paymentToolVariables = array();
                $paymentToolStatus = false;
                foreach ($_POST["paymentAPIsType"] as $key => $value) {
                  if ($_POST["paymentAPIsType"][$key] !== "") {
                    if ($_POST["paymentAPIsMethod"][$key] == "0") {
                      $paymentToolStatus = true;
                      array_push($paymentToolVariables, array(
                        "title" => $_POST["paymentAPIsTitle"][$key],
                        "api" => $_POST["paymentAPIsType"][$key],
                        "method" => 0
                      ));
                    } else if ($_POST["paymentAPIsMethod"][$key] == "1") {
                      $paymentToolStatus = true;
                      array_push($paymentToolVariables, array(
                        "title" => $_POST["paymentAPIsTitle"][$key],
                        "api" => $_POST["paymentAPIsType"][$key],
                        "method" => 1
                      ));
                    } else if ($_POST["paymentAPIsMethod"][$key] == "2") {
                      $paymentToolStatus = true;
                      array_push($paymentToolVariables, array(
                        "title" => $_POST["paymentAPIsTitle"][$key],
                        "api" => $_POST["paymentAPIsType"][$key],
                        "method" => 2
                      ));
                    }
                  }
                }
                $paymentsToolVariables = (($paymentToolStatus == true) ? json_encode($paymentToolVariables) : "disabled");
                $saveChanges = $db->prepare("UPDATE payments SET payments = ? WHERE id = ?");
                $saveChanges->execute(array($paymentsToolVariables, $readPayments["id"]));
                echo alert(languageVariables("alertSaveChanges", "settings", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
              }
            }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table id="tableitems" class="table table-sm table-hover table-nowrap array-table">
                    <thead>
                      <tr>
                        <th class="text-center align-middle"><?php echo languageVariables("title", "words", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("paymentAPIType", "words", $languageType); ?></th>
                        <th class="text-center align-middle"><?php echo languageVariables("method", "words", $languageType); ?></th>
                        <th class="text-center align-middle">
                          <button type="button" class="btn btn-success btn-icon addTableItemOne">
                            <i data-feather="plus"></i>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if ($readPayments["payments"] !== "disabled" && $readPayments["payments"] !== "" && $readPayments["payments"] !== "[]") { ?>
                    <?php 
                      $searchToolPayments = json_decode($readPayments["payments"], 2);
                      foreach ($searchToolPayments as $readToolPayments) {
                        $transactionID = createSalt(12).createSlug($readToolPayments["title"]);
                    ?>
                      <tr data-toggle="paymentTool">
                        <td class="ml-2">
                          <div class="input-group">
                            <input type="text" class="form-control form-control-prepended" name="paymentAPIsTitle[]" placeholder="<?php echo languageVariables("title", "words", $languageType); ?>" value="<?php echo $readToolPayments["title"]; ?>">
                          </div>
                        </td>
                        <td class="ml-2">
                          <select class="form-control payment-types" id="settings-payment-api-type" method-id="<?php echo $transactionID; ?>" name="paymentAPIsType[]">
                            <option value="paypal" <?php echo (($readToolPayments["api"] == "paypal") ? "selected" : ""); ?>>PayPal</option>
                            <option value="paypalipn" <?php echo (($readToolPayments["api"] == "paypalipn") ? "selected" : ""); ?>>PayPal (IPN)</option>
                            <option value="stripe" <?php echo (($readToolPayments["api"] == "stripe") ? "selected" : ""); ?>>Stripe</option>
                            <option value="paytr" <?php echo (($readToolPayments["api"] == "paytr") ? "selected" : ""); ?>>PayTR</option>
                            <option value="paymax" <?php echo (($readToolPayments["api"] == "paymax") ? "selected" : ""); ?>>Paymax</option>
                            <option value="shopier" <?php echo (($readToolPayments["api"] == "shopier") ? "selected" : ""); ?>>Shopier</option>
                            <option value="paywant" <?php echo (($readToolPayments["api"] == "paywant") ? "selected" : ""); ?>>Paywant</option>
                            <option value="shipy" <?php echo (($readToolPayments["api"] == "shipy") ? "selected" : ""); ?>>Shipy</option>
                            <option value="batihost" <?php echo (($readToolPayments["api"] == "batihost") ? "selected" : ""); ?>>Batihost</option>
                            <option value="rabisu" <?php echo (($readToolPayments["api"] == "rabisu") ? "selected" : ""); ?>>Rabisu</option>
                            <option value="keyubu" <?php echo (($readToolPayments["api"] == "keyubu") ? "selected" : ""); ?>>Keyubu</option>
                            <option value="anksoft" <?php echo (($readToolPayments["api"] == "anksoft") ? "selected" : ""); ?>>AnkSOFT</option>
                            <option value="transfer" <?php echo (($readToolPayments["api"] == "transfer") ? "selected" : ""); ?>>Transfer</option>
                            <option value="ininal" <?php echo (($readToolPayments["api"] == "ininal") ? "selected" : ""); ?>>Ininal</option>
                            <option value="papara" <?php echo (($readToolPayments["api"] == "papara") ? "selected" : ""); ?>>Papara</option>
                            <option value="tosla" <?php echo (($readToolPayments["api"] == "tosla") ? "selected" : ""); ?>>Tosla</option>
                          </select>
                        </td>
                        <td class="ml-2">
                          <select class="form-control payment-method" methods="<?php echo $transactionID; ?>" id="settings-payment-method" name="paymentAPIsMethod[]">
                            <option value="0" <?php echo (($readToolPayments["method"] == "0") ? "selected" : ""); ?> <?php echo (($readToolPayments["api"] == "transfer" || $readToolPayments["api"] == "ininal" || $readToolPayments["api"] == "papara" || $readToolPayments["api"] == "tosla" || $readToolPayments["api"] == "paypal" || $readToolPayments["api"] == "paypal-ipn" || $readToolPayments["api"] == "stripe" || $readToolPayments["api"] == "paytr" || $readToolPayments["api"] == "shopier" || $readToolPayments["api"] == "anksoft") ? "disabled" : ""); ?>><?php echo languageVariables("paymentMobileType", "settings", $languageType); ?></option>
                            <option value="1" <?php echo (($readToolPayments["method"] == "1") ? "selected" : ""); ?> <?php echo (($readToolPayments["api"] == "transfer" || $readToolPayments["api"] == "ininal" || $readToolPayments["api"] == "papara" || $readToolPayments["api"] == "tosla") ? "disabled" : ""); ?>><?php echo languageVariables("paymentDebitType", "settings", $languageType); ?></option>
                            <option value="2" <?php echo (($readToolPayments["method"] == "2") ? "selected" : ""); ?> <?php echo (($readToolPayments["api"] == "transfer" || $readToolPayments["api"] == "ininal" || $readToolPayments["api"] == "papara" || $readToolPayments["api"] == "tosla") ? "" : "disabled"); ?>><?php echo languageVariables("transfer", "words", $languageType); ?></option>
                          </select>
                        </td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-danger btn-icon deleteTableItem">
                            <span class="far fa-trash-alt"></span>
                          </button>
                        </td>
                      </tr>
                    <?php } ?>
                    <?php } else { ?>
                      <tr data-toggle="paymentTool">
                        <td class="ml-2">
                          <div class="input-group">
                            <input type="text" class="form-control form-control-prepended" name="paymentAPIsTitle[]" placeholder="<?php echo languageVariables("title", "words", $languageType); ?>">
                          </div>
                        </td>
                        <td class="ml-2">
                          <select class="form-control payment-types" id="settings-payment-api-type" method-id="MX0" name="paymentAPIsType[]">
                            <option value="paypal" selected>PayPal</option>
                            <option value="paypalipn">PayPal (IPN)</option>
                            <option value="stripe">Stripe</option>
                            <option value="paytr">PayTR</option>
                            <option value="paymax">Paymax</option>
                            <option value="shopier">Shopier</option>
                            <option value="paywant">Paywant</option>
                            <option value="shipy">Shipy</option>
                            <option value="batihost">Batihost</option>
                            <option value="rabisu">Rabisu</option>
                            <option value="keyubu">Keyubu</option>
                            <option value="anksoft">AnkSOFT</option>
                            <option value="transfer">Transfer</option>
                            <option value="ininal">Ininal</option>
                            <option value="papara">Papara</option>
                            <option value="tosla">Tosla</option>
                          </select>
                        </td>
                        <td class="ml-2">
                          <select class="form-control payment-method" methods="MX0" id="settings-payment-method" name="paymentAPIsMethod[]">
                            <option value="0" disabled="disabled"><?php echo languageVariables("paymentMobileType", "settings", $languageType); ?></option>
                            <option value="1" selected><?php echo languageVariables("paymentDebitType", "settings", $languageType); ?></option>
                            <option value="2" disabled="disabled"><?php echo languageVariables("transfer", "words", $languageType); ?></option>
                          </select>
                        </td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-danger btn-icon deleteTableItem">
                            <span class="far fa-trash-alt"></span>
                          </button>
                        </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("saveChangesTokenOne"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="saveChangesOne"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 grid-margin">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("paymentSettings", "words", $languageType); ?></h6>
          <?php
          if (isset($_POST["saveChanges"])) {
            if ($safeCsrfToken->validate('saveChangesToken')) {
              $paymentVariables = array();
              foreach ($settingsVariables as $readSettingsVariables) {
                $VariablesName = $readSettingsVariables["name"];
                array_push($paymentVariables, array(
                  $VariablesName => post($readSettingsVariables["name"])
                ));
              }
              $paymentVariables = json_encode($paymentVariables);
              $paymentVariables = str_replace('{', '', $paymentVariables);
              $paymentVariables = str_replace('}', '', $paymentVariables);
              $paymentVariables = str_replace('[', '{', $paymentVariables);
              $paymentVariables = str_replace(']', '}', $paymentVariables);
              $saveChanges = $db->prepare("UPDATE payments SET variables = ? WHERE id = ?");
              $saveChanges->execute(array($paymentVariables, $readPayments["id"]));
              echo alert(languageVariables("alertSaveChanges", "settings", $languageType), "success", "2", "");
            } else {
              echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="settings-payment-paymentapi" class="col-sm-3 col-form-label"><?php echo languageVariables("paymentAPIType", "words", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-payment-paymentapi" name="settingsPaymentTool" data-toggle="PaymentSettings">
                  <option value="paypal">PayPal</option>
                  <option value="paypalipn">PayPal (IPN)</option>
                  <option value="stripe">Stripe</option>
                  <option value="paytr">PayTR</option>
                  <option value="paymax">Paymax</option>
                  <option value="paywant">Paywant</option>
                  <option value="shipy">Shipy</option>
                  <option value="shopier">Shopier</option>
                  <option value="batihost">Batihost</option>
                  <option value="keyubu">Keyubu</option>
                  <option value="rabisu">Rabisu</option>
                  <option value="anksoft">AnkSOFT</option>
                  <option value="transfer">Transfer</option>
                  <option value="ininal">Ininal</option>
                  <option value="papara">Papara</option>
                  <option value="tosla">Tosla</option>
                </select>
              </div>
            </div>
            <?php foreach ($settingsVariables as $readSettingsVariables) { ?>
            <?php if (isset($readSettingsVariables["paymentType"])) { ?>
            <?php $paymentType = $readSettingsVariables["paymentType"]; ?>
            <div <?php echo (($paymentType !== "paypal") ? "style=\"display: none;\"" : ""); ?> data-toggle="<?php echo $paymentType; ?>">
            <?php } ?>
              <div class="form-group row">
                <label for="<?php echo $readSettingsVariables["ID"]; ?>" class="col-sm-3 col-form-label"><?php echo $readSettingsVariables["title"]; ?></label>
                <div class="col-sm-9">
                  <?php if ($readSettingsVariables["name"] == "paywantCommissionType") { ?>
                  <select id="<?php echo $readSettingsVariables["ID"]; ?>" class="form-control" name="<?php echo $readSettingsVariables["name"]; ?>">
                    <option value="1" <?php if ($readSettingsVariables["value"] == "1") { echo "selected"; } ?>><?php echo languageVariables("paymentPaywantComissionOption0", "settings", $languageType); ?></option>
                    <option value="2" <?php if ($readSettingsVariables["value"] == "2") { echo "selected"; } ?>><?php echo languageVariables("paymentPaywantComissionOption1", "settings", $languageType); ?></option>
                  </select>
                  <?php } else if ($readSettingsVariables["name"] == "paypalMode" || $readSettingsVariables["name"] == "paypalIPNType" || $readSettingsVariables["name"] == "stripeMode") { ?>
                    <select id="<?php echo $readSettingsVariables["ID"]; ?>" class="form-control" name="<?php echo $readSettingsVariables["name"]; ?>">
                    <option value="0" <?php if ($readSettingsVariables["value"] == "0") { echo "selected"; } ?>>Sandbox</option>
                    <option value="1" <?php if ($readSettingsVariables["value"] == "1") { echo "selected"; } ?>>Live</option>
                  </select>
                  <?php } else { ?>
                  <input type="text" class="form-control" id="<?php echo $readSettingsVariables["ID"]; ?>" name="<?php echo $readSettingsVariables["name"]; ?>" placeholder="<?php echo $readSettingsVariables["placeholder"]; ?>" value="<?php echo $readSettingsVariables["value"]; ?>">
                  <?php } ?>
                </div>
              </div>
            <?php if (isset($readSettingsVariables["paymentType"])) { ?>
            </div>
            <?php } ?>
            <?php } ?>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("saveChangesToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="saveChanges"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("links", "words", $languageType); ?></h6>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label"><?php echo languageVariables("successUrl", "words", $languageType); ?>: </label>
            <span class="col-sm-7"><?php echo $siteURL."credit/upload/success"; ?></span>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label"><?php echo languageVariables("failUrl", "words", $languageType); ?>: </label>
            <span class="col-sm-7"><?php echo $siteURL."credit/upload/fail"; ?></span>
          </div>
          <div style="display: block;" data-toggle="paypal">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/paypal"; ?></span>
            </div>
          </div>
          <div style="display: block;" data-toggle="paypalipn">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/paypalipn"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="stripe">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/stripe"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="paytr">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/paytr"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="paymax">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/paymax"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="paywant">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/paywant"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="shipy">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/shipy"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="shopier">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/shopier"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="batihost">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/batihost"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="keyubu">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/keyubu"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="rabisu">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/rabisu"; ?></span>
            </div>
          </div>
          <div style="display: none;" data-toggle="anksoft">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label"><?php echo languageVariables("callbackUrl", "words", $languageType); ?>: </label>
              <span class="col-sm-7"><?php echo $siteURL."payment/callback/anksoft"; ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var $paymentToolStatus = "TRUE";
</script>
<?php } else if (get("action") == "languages") { ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("settings", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_settings_languages", $languageType); ?>"><?php echo languageVariables("languages", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("languageCardAddTitle", "settings", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addLanguage"])) {
            if ($safeCsrfToken->validate('addLanguageToken')) {
              if (post("languageCode") !== "" && post("languageTitle") !== "") {
                $searchLanguageCode = $db->prepare("SELECT * FROM languages WHERE code = ?");
                $searchLanguageCode->execute(array(post("languageCode")));
                if ($searchLanguageCode->rowCount() == 0) {
                  $insertLanguage = $db->prepare("INSERT INTO languages (`code`, `title`, `author`) VALUES (?, ?, ?)");
                  $insertLanguage->execute(array(post("languageCode"), post("languageTitle"), $readAccount["username"]));
                  if ($insertLanguage) {
                    fopen(__DR__."/main/language/messages/".post("languageCode").".json", "w");
                    fopen(__DR__."/admin/language/messages/".post("languageCode").".json", "w");
                    $dashboardDefault = file_get_contents(__DR__."/admin/language/messages/default.json");
                    $mainDefault = file_get_contents(__DR__."/main/language/messages/default.json");
                    file_put_contents(__DR__."/admin/language/messages/".post("languageCode").".json", $dashboardDefault);
                    file_put_contents(__DR__."/main/language/messages/".post("languageCode").".json", $mainDefault);
                    echo alert(languageVariables("alertLanguageAddSuccess", "settings", $languageType), "success", "0", "/");
                    echo alert(str_replace(array("&url", "&dashUrl"), array("/main/language/messages/".post("languageCode").".json", "/admin/language/messages/".post("languageCode").".json"), languageVariables("alertLanguageCustomize", "settings", $languageType)), "warning", "0", "/");
                  } else {
                    echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertLanguageAlreadyCode", "settings", $languageType), "danger", "0", "/");
                }
              } else {
              echo alert(languageVariables("alertNone", "settings", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="settings-language-title" class="col-sm-3 col-form-label"><?php echo languageVariables("languageCode", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="settings-language-code" name="languageCode" placeholder="<?php echo languageVariables("languageCodePlaceholder", "settings", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-language-title" class="col-sm-3 col-form-label"><?php echo languageVariables("languageTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="settings-language-title" name="languageTitle" placeholder="<?php echo languageVariables("languageTitlePlaceholder", "settings", $languageType); ?>">
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("addLanguageToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="addLanguage"><?php echo languageVariables("add", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "remove") { ?>
    <?php
      if (isset($_GET["id"])) {
        $removeLanguage = $db->prepare("DELETE FROM languages WHERE id = ?");
        $removeLanguage->execute(array(get("id")));
        go(urlConverter("admin_settings_languages", $languageType));
      } else {
        go(urlConverter("admin_settings_languages", $languageType));
      }
    ?>
  <?php } else if (get("target") == "default") { ?>
    <?php
      if (isset($_GET["code"])) {
        $updateSettings = $db->prepare("UPDATE settings SET defaultLanguage = ? WHERE id = ?");
        $updateSettings->execute(array(get("code"), 0));
        go(urlConverter("admin_settings_languages", $languageType));
      } else {
        go(urlConverter("admin_settings_languages", $languageType));
      }
    ?>
  <?php } else { ?>
    <?php if (isset($_GET["id"])) { ?>
      <?php 
        $searchLanguage = $db->prepare("SELECT * FROM languages WHERE id = ?");
        $searchLanguage->execute(array(get("id")));
        if ($searchLanguage->rowCount() == 0) {
          go(urlConverter("admin_settings_languages", $languageType));
        }
        $readLanguage = $searchLanguage->fetch();
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("settings", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_settings_languages", $languageType); ?>"><?php echo languageVariables("languages", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readLanguage["title"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("languageCardAddTitle", "settings", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editLanguage"])) {
            if ($safeCsrfToken->validate('editLanguageToken')) {
              if (post("languageCode") !== "" && post("languageTitle") !== "") {
                $searchLanguageCode = $db->prepare("SELECT * FROM languages WHERE code = ?");
                $searchLanguageCode->execute(array(post("languageCode")));
                if ($searchLanguageCode->rowCount() == 0 || $readLanguage["code"] == post("languageCode")) {
                  $updateLanguage = $db->prepare("UPDATE languages SET code = ?, title = ? WHERE id = ?");
                  $updateLanguage->execute(array(post("languageCode"), post("languageTitle"), $readLanguage["id"]));
                  if ($updateLanguage) {
                    rename(__DR__."/main/language/messages/".$readLanguage["code"].".json", __DR__."/main/language/messages/".post("languageCode").".json");
                    rename(__DR__."/admin/language/messages/".$readLanguage["code"].".json", __DR__."/admin/language/messages/".post("languageCode").".json");
                    echo alert(languageVariables("alertLanguageEditSuccess", "settings", $languageType), "success", "0", "/");
                    echo alert(str_replace(array("&url", "&dashUrl"), array("/main/language/messages/".post("languageCode").".json", "/admin/language/messages/".post("languageCode").".json"), languageVariables("alertLanguageCustomize", "settings", $languageType)), "warning", "0", "/");
                    $mainFileContent = str_replace("¤cy", "&currency", $_POST["languageFileMain"]);
                    $mainLangFile = fopen(__DR__."/main/language/messages/".$readLanguage["code"].".json", 'w');
                    fwrite($mainLangFile, $mainFileContent);
                    fclose($mainLangFile);
                    $dashboardFileContent = str_replace("¤cy", "&currency", $_POST["languageFileDashboard"]);
                    $dashboardLangFile = fopen(__DR__."/admin/language/messages/".$readLanguage["code"].".json", 'w');
                    fwrite($dashboardLangFile, $dashboardFileContent);
                    fclose($dashboardLangFile);
                  } else {
                    echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertLanguageAlreadyCode", "settings", $languageType), "danger", "0", "/");
                }
              } else {
              echo alert(languageVariables("alertNone", "settings", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
            }
          } else {
            echo alert(str_replace(array("&url", "&dashUrl"), array("/main/language/messages/".$readLanguage["code"].".json", "/admin/language/messages/".$readLanguage["code"].".json"), languageVariables("alertLanguageCustomize", "settings", $languageType)), "warning", "0", "/");
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="settings-language-title" class="col-sm-3 col-form-label"><?php echo languageVariables("languageCode", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="settings-language-code" name="languageCode" placeholder="<?php echo languageVariables("languageCodePlaceholder", "settings", $languageType); ?>" value="<?php echo $readLanguage["code"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-language-title" class="col-sm-3 col-form-label"><?php echo languageVariables("languageTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="settings-language-title" name="languageTitle" placeholder="<?php echo languageVariables("languageTitlePlaceholder", "settings", $languageType); ?>" value="<?php echo $readLanguage["title"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-language-title" class="col-sm-3 col-form-label">Main:</label>
              <div class="col-sm-9">
                <textarea name="languageFileMain" id="languageFileMain" rows="50" class="form-control" data-toggle="codeMirror"><?php echo file_get_contents(__DR__."/main/language/messages/".$readLanguage["code"].".json");?></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-language-title" class="col-sm-3 col-form-label">Dashboard:</label>
              <div class="col-sm-9">
                <textarea name="languageFileDashboard" id="languageFileDashboard" rows="50" class="form-control" data-toggle="codeMirror"><?php echo file_get_contents(__DR__."/admin/language/messages/".$readLanguage["code"].".json");?></textarea>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("editLanguageToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editLanguage"><?php echo languageVariables("edit", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
    <?php } else { ?>
    <?php $searchLanguages = $db->query("SELECT * FROM languages ORDER BY id ASC"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("settings", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_settings_languages", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchLanguages) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["langID", "langTitle", "langCode", "langAuthor"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("search", "words", $languageType); ?>">
                </div>
              </div>
            </div>
            <div class="col-auto">
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_settings_languages_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="langID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="langTitle"><?php echo languageVariables("languageTitle", "settings", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="langCode"><?php echo languageVariables("languageCode", "settings", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="langAuthor"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchLanguages as $readLanguage) { ?>
                <tr>
                  <td class="langID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_settings_languages", $languageType); ?>/<?php echo $readLanguage["id"]; ?>">#<?php echo $readLanguage["id"]; ?></a></td>
                  <td class="langTitle text-center"><?php echo $readLanguage["title"]; ?> <?php echo (($rSettings["defaultLanguage"] == $readLanguage["code"]) ? "(".languageVariables("default", "words", $languageType).")" : "(<a href=\"".urlConverter("admin_settings_languages", $languageType)."/default/".$readLanguage["code"]."\">".languageVariables("default", "words", $languageType)."</a>)"); ?></td>
                  <td class="langCode text-center"><?php echo $readLanguage["code"]; ?></td>
                  <td class="langCode text-center"><?php echo $readLanguage["author"]; ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_settings_languages", $languageType); ?>/<?php echo $readLanguage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_settings_languages_delete", $languageType); ?>/<?php echo $readLanguage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "support", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } ?>
<?php } else if (get("action") == "creditPackets") { ?>
<?php
$searchPayments = $db->query("SELECT * FROM payments ORDER BY id ASC");
$readPayments = fetch($searchPayments);
?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_settings_general", $languageType); ?>"><?php echo languageVariables("settings", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("creditSettings", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("creditSettings", "words", $languageType); ?></h6>
          <?php 
            require_once(__DR__."/main/includes/packages/class/csrf/class.php");
            $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
            
            if (isset($_POST["saveChangesOne"])) {
              if ($safeCsrfToken->validate('saveChangesTokenOne')) {
                if (post("settingsCreditName") !== "" && post("settingsCreditIcon") !== "") {
                  $creditPacketVariables = array();
                  foreach ($_POST["creditPacketTitle"] as $key => $value) {
                    if ($_POST["creditPacketTitle"][$key] !== "") {
                      array_push($creditPacketVariables, array(
                        "title" => $_POST["creditPacketTitle"][$key],
                        "price" => $_POST["creditPacketPrice"][$key],
                        "amount" => $_POST["creditPacketAmount"][$key]
                      ));
                    }
                  }
                  $saveChangesPayment = $db->prepare("UPDATE payments SET creditPackets = ?, creditType = ? WHERE id = ?");
                  $saveChangesPayment->execute(array(json_encode($creditPacketVariables), post("settingsCreditPacketType"), $readPayments["id"]));
                  $saveChangesSettings = $db->prepare("UPDATE settings SET creditName = ?, creditIcon = ?, minimumLoadCredit = ?, salesAgreementType = ?, salesAgreement = ? WHERE id = ?");
                  $saveChangesSettings->execute(array(post("settingsCreditName"), $_POST["settingsCreditIcon"], post("settingsMinimumLoadCredit"), post("settingsPurchaseTermsStatus"), $_POST["settingsPurchaseTerms"], $rSettings["id"]));
                  $saveChangesModule = $db->prepare("UPDATE module SET creditMultiplier = ? WHERE id = ?");
                  $saveChangesModule->execute(array(post("settingsCreditMultiplier"), $readModule["id"]));
                  echo alert(languageVariables("alertSaveChanges", "settings", $languageType), "success", "2", "");
                } else {
                  echo alert(languageVariables("alertNone", "settings", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertSystem", "settings", $languageType), "danger", "0", "/");
              }
            }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="settings-system-load-credit-name" class="col-sm-3 col-form-label"><?php echo languageVariables("systemCreditNameTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="settings-system-load-credit-name" name="settingsCreditName" placeholder="<?php echo languageVariables("systemCreditNameTitlePlaceholder", "settings", $languageType); ?>" value="<?php echo $rSettings["creditName"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-load-credit-icon" class="col-sm-3 col-form-label"><?php echo languageVariables("systemCreditIconTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="settings-system-load-credit-icon" name="settingsCreditIcon" placeholder="<?php echo languageVariables("systemCreditIconPlaceholder", "settings", $languageType); ?>" value="<?php echo $rSettings["creditIcon"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-load-credit-limit" class="col-sm-3 col-form-label"><?php echo languageVariables("systemMinCreditLimitTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="settings-system-load-credit-limit" name="settingsMinimumLoadCredit" placeholder="<?php echo languageVariables("systemMinCreditLimitPlaceholder", "settings", $languageType); ?>" value="<?php echo $rSettings["minimumLoadCredit"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-system-load-credit-multiplier" class="col-sm-3 col-form-label"><?php echo languageVariables("systemCreditMultiplierTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="settings-system-load-credit-multiplier" name="settingsCreditMultiplier" placeholder="<?php echo languageVariables("systemCreditMultiplierPlaceholder", "settings", $languageType); ?>" value="<?php echo $readModule["creditMultiplier"]; ?>">
                <small class="form-text text-muted">
                  <?php echo languageVariables("systemCreditMultiplierSmall", "settings", $languageType); ?>
                </small>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-credit-packet-type" class="col-sm-3 col-form-label"><?php echo languageVariables("creditSettingsTypeTitle", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-credit-packet-type" name="settingsCreditPacketType" select-change="change" select-input="CreditPacketInput">
                  <option value="0" <?php echo (($readPayments["creditType"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("creditSettingsTypeOption0", "settings", $languageType); ?></option>
                  <option value="1" <?php echo (($readPayments["creditType"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("creditSettingsTypeOption1", "settings", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div style="display: <?php echo (($readPayments["creditType"] == "1") ? "block" : "none"); ?>;" select-id="CreditPacketInput">
              <div class="form-group row">
                <div class="col-sm-12">
                  <div class="table-responsive">
                    <table id="tableitems" class="table table-sm table-hover table-nowrap array-table">
                      <thead>
                        <tr>
                          <th class="text-center align-middle"><?php echo languageVariables("title", "words", $languageType); ?></th>
                          <th class="text-center align-middle"><?php echo languageVariables("paymentAmount", "words", $languageType); ?></th>
                          <th class="text-center align-middle"><?php echo $rSettings["creditName"]; ?></th>
                          <th class="text-center align-middle">
                            <button type="button" class="btn btn-success btn-icon addTableItemOne">
                              <i data-feather="plus"></i>
                            </button>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach (json_decode($readPayments["creditPackets"], true) as $readCreditPackets) { ?>
                        <tr>
                          <td class="ml-2">
                            <div class="input-group">
                              <input type="text" class="form-control form-control-prepended" name="creditPacketTitle[]" placeholder="<?php echo languageVariables("creditSettingsTypeCustomTitlePlaceHolder", "settings", $languageType); ?>" value="<?php echo $readCreditPackets["title"]; ?>">
                            </div>
                          </td>
                          <td class="ml-2">
                            <div class="input-group input-group-merge">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <span class="fa fa-dollar-sign"></span>
                                </div>
                              </div>
                              <input type="number" class="form-control" name="creditPacketPrice[]" placeholder="<?php echo languageVariables("creditSettingsTypeCustomPricePlaceHolder", "settings", $languageType); ?>" value="<?php echo $readCreditPackets["price"]; ?>">
                            </div>
                          </td>
                          <td class="ml-2">
                            <div class="input-group input-group-merge">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <span><?php echo $rSettings["creditIcon"]; ?></span>
                                </div>
                              </div>
                              <input type="number" class="form-control" name="creditPacketAmount[]" placeholder="<?php echo languageVariables("creditSettingsTypeCustomAmountPlaceHolder", "settings", $languageType); ?>" value="<?php echo $readCreditPackets["amount"]; ?>">
                            </div>
                          </td>
                          <td class="text-center align-middle">
                            <button type="button" class="btn btn-danger btn-icon deleteTableItem">
                              <span class="far fa-trash-alt"></span>
                            </button>
                          </td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td class="ml-2">
                            <div class="input-group">
                              <input type="text" class="form-control form-control-prepended" name="creditPacketTitle[]" placeholder="<?php echo languageVariables("creditSettingsTypeCustomTitlePlaceHolder", "settings", $languageType); ?>">
                            </div>
                          </td>
                          <td class="ml-2">
                            <div class="input-group input-group-merge">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <span class="fa fa-dollar-sign"></span>
                                </div>
                              </div>
                              <input type="number" class="form-control" name="creditPacketPrice[]" placeholder="<?php echo languageVariables("creditSettingsTypeCustomPricePlaceHolder", "settings", $languageType); ?>">
                            </div>
                          </td>
                          <td class="ml-2">
                            <div class="input-group input-group-merge">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <span><?php echo $rSettings["creditIcon"]; ?></span>
                                </div>
                              </div>
                              <input type="number" class="form-control" name="creditPacketAmount[]" placeholder="<?php echo languageVariables("creditSettingsTypeCustomAmountPlaceHolder", "settings", $languageType); ?>">
                            </div>
                          </td>
                          <td class="text-center align-middle">
                            <button type="button" class="btn btn-danger btn-icon deleteTableItem">
                              <span class="far fa-trash-alt"></span>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="settings-credit-packet-type" class="col-sm-3 col-form-label"><?php echo languageVariables("creditSettingsSalesAgreement", "settings", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" id="settings-credit-packet-type" name="settingsPurchaseTermsStatus" select-change="change" select-input="CreditTermsSelect">
                  <option value="0" <?php echo (($rSettings["salesAgreementType"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                  <option value="1" <?php echo (($rSettings["salesAgreementType"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div style="display: <?php echo (($rSettings["salesAgreementType"] == "1") ? "block" : "none"); ?>;" select-id="CreditTermsSelect">
              <div class="form-group row">
                <label for="settings-system-load-credit-multiplier" class="col-sm-3 col-form-label"><?php echo languageVariables("creditSettingsAgreement", "settings", $languageType); ?></label>
                <div class="col-sm-9">
                  <textarea class="form-control ckeditor" id="settings-system-load-credit-multiplier" name="settingsPurchaseTerms" placeholder="<?php echo languageVariables("creditSettingsAgreementPlaceholder", "settings", $languageType); ?>"><?php echo $rSettings["salesAgreement"]; ?></textarea>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("saveChangesTokenOne"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="saveChangesOne"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>