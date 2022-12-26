<?php if (AccountPermControl($readAccount["id"], "public") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php if (get("action") == "news") { ?>
<?php if (AccountPermControl($readAccount["id"], "public_news") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("newsAddCardTitle", "general", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addNews"])) {
            if ($safeCsrfToken->validate('addNewsToken')) {
              if (post("newsAddTitle") !== "" && post("newsAddContent") !== "" && $_FILES["newsAddImage"] !== "") {
                if ($_FILES["newsAddImage"]["size"] !== null) {
                  $imageUpload = imageUpload($_FILES["newsAddImage"], "/assets/uploads/images/news/");
                  if ($imageUpload !== false) {
                    $insertNews = $db->prepare("INSERT INTO newsList SET title = ?, image = ?, text = ?, newsAuthor = ?, date = ?, categoryName = ?, newsHearts = ?, newsDisplay = ?, commentStatus = ?");
                    $insertNews->execute(array(post("newsAddTitle"), "/assets/uploads/images/news/".$imageUpload["name"], $_POST["newsAddContent"], $readAccount["username"], date("d.m.Y H:i:s"), post("newsAddCategory"), 0, 0, post("newsAddComments")));
                    $searchNewsID = $db->query("SELECT * FROM newsList ORDER BY id DESC LIMIT 1");
                    $readNewsID = fetch($searchNewsID);
                    $newsUrl = $siteURL."haber/".createSlug($readNewsID["title"])."/".$readNewsID["id"];
                    $webhookDescription = str_replace(array("[username]", "[title]", "[url]"), array($readAccount["username"], $readNewsID["title"], $newsUrl), $readWebhooks["webhookNewsDescription"]);
                    $hookObject = json_encode([
                      "username" => str_replace(array("[username]"), array($readAccount["username"]), $readWebhooks["webhookNewsName"]),
                      "avatar_url" => avatarAPI($readAccount["username"], 100),
                      "tts" => false,
                      "embeds" => [
                         [
                              "title" => $readWebhooks["webhookNewsTitle"],
                              "type" => "rich",
                              "image" => ($readWebhooks["webhookNewsImage"] !== "0") ? [
                                "url" => $readWebhooks["webhookNewsImage"]
                              ] : [],
                              "description" => $webhookDescription,
                              "color" => hexdec(rand_color()),
                              "footer" => ($readWebhooks["webhookNewsSignature"] == "1") ? [
                                  "text" => "Powered by MINEXON",
                                  "icon_url" => "https://www.minexon.net/main/theme/assets/images/brand/favicon.png"
                              ] : []
                          ]
                      ]
                    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
                    $sendWebhook = (($readWebhooks["webhookNewsStatus"] == "1") ? webhooks($readWebhooks["webhookNewsAPI"], $hookObject) : "OK");
                    if (post("newsAddTags") !== "") {
                      $newsTags = explode(',', trim(post("newsAddTags"), ','));
                      foreach ($newsTags as $readNewsTags) {
                        $insertNewsTags = $db->prepare("INSERT INTO newsTags SET name = ?, newsID = ?, url = ?");
                        $insertNewsTags->execute(array($readNewsTags, $readNewsID["id"], createSlug($newsTags)));
                      }
                    }
                    echo alert(languageVariables("alertNewsAddSuccess", "general", $languageType), "success", "3", urlConverter("admin_general_news", $languageType));
                  } else {
                    echo alert(languageVariables("alertImageUpload", "general", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertImage", "general", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "general", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="general-news-add-title" class="col-sm-3 col-form-label"><?php echo languageVariables("newsTitle", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="general-news-add-title" name="newsAddTitle" placeholder="<?php echo languageVariables("newsTitlePlaceholder", "general", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-news-add-category" class="col-sm-3 col-form-label"><?php echo languageVariables("newsCategory", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <select class="form-control" id="general-news-add-category" name="newsAddCategory">
                    <?php $searchNewsCategory = $db->query("SELECT * FROM newsCategory ORDER BY id DESC"); ?>
                    <?php if (mysqlCount($searchNewsCategory) > 0) { ?>
                      <?php foreach($searchNewsCategory as $readNewsCategory) { ?>
                        <option value="<?php echo $readNewsCategory["name"]; ?>"><?php echo $readNewsCategory["name"]; ?></option>
                      <?php } ?>
                    <?php } else { ?>
                    <option value="<?php echo languageVariables("newsCategoryAnnouncement", "general", $languageType); ?>"><?php echo languageVariables("newsCategoryAnnouncement", "general", $languageType); ?></option>
                    <option value="<?php echo languageVariables("newsCategoryInfo", "general", $languageType); ?>"><?php echo languageVariables("newsCategoryInfo", "general", $languageType); ?></option>
                    <option value="<?php echo languageVariables("newsCategoryUpdate", "general", $languageType); ?>"><?php echo languageVariables("newsCategoryUpdate", "general", $languageType); ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="general-news-add-content" class="col-sm-3 col-form-label"><?php echo languageVariables("newsDescription", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <textarea class="form-control ckeditor" id="general-news-add-content" name="newsAddContent" placeholder="<?php echo languageVariables("newsDescriptionPlaceholder", "general", $languageType); ?>"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="general-news-add-tags" class="col-sm-3 col-form-label"><?php echo languageVariables("newsTags", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" id="general-news-add-tags" class="form-control" data-toggle="tagsinput" name="newsAddTags" placeholder="<?php echo languageVariables("newsTag", "general", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-news-add-comments" class="col-sm-3 col-form-label"><?php echo languageVariables("newsComments", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <select class="form-control" id="general-news-add-comments" name="newsAddComments">
                    <option value="0"><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" selected><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="general-news-add-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "words", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage">
                    <div class="di-thumbnail">
                      <img src="" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="general-news-add-image"><?php echo languageVariables("imagePlaceholder", "words", $languageType); ?></label>
                      <input type="file" id="general-news-add-image" name="newsAddImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("addNewsToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="addNews"><?php echo languageVariables("add", "words", $languageType); ?></button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["newsID"])) { ?>
      <?php
      $searchNews = $db->prepare("SELECT * FROM newsList WHERE id = ?");
      $searchNews->execute(array(get("newsID")));
      if (mysqlCount($searchNews) > 0) {
        $readNews = fetch($searchNews);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readNews["id"]."# ".$readNews["title"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("newsEditCardTitle", "general", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editNews"])) {
            if ($safeCsrfToken->validate('editNewsToken')) {
              if (post("newsEditTitle") !== "" && post("newsEditContent") !== "" && $_FILES["newsEditImage"] !== "") {
                $imageUploadStatus = "__SUCCESS__";
                if ($_FILES["newsEditImage"]["name"] != null) {
                  $imageUpload = imageUpload($_FILES["newsEditImage"], "/assets/uploads/images/news/");
                  if ($imageUpload !== false) {
                    $updateNews = $db->prepare("UPDATE newsList SET image = ? WHERE id = ?");
                    $updateNews->execute(array("/assets/uploads/images/news/".$imageUpload["name"], $readNews["id"]));
                  } else {
                    $imageUploadStatus = "__UNSUCCESS__";
                  }
                }
                if ($imageUploadStatus == "__SUCCESS__") {
                  $deleteTags = $db->prepare("DELETE FROM newsTags WHERE newsID = ?");
                  $deleteTags->execute(array($readNews["id"]));
                  $updateNews = $db->prepare("UPDATE newsList SET title = ?, text = ?, categoryName = ?, commentStatus = ? WHERE id = ?");
                  $updateNews->execute(array(post("newsEditTitle"), $_POST["newsEditContent"], post("newsEditCategory"), post("newsEditComments"), $readNews["id"]));
                  if (post("newsEditTags") !== "") {
                    $newsTags = explode(',', trim(post("newsEditTags"), ','));
                    foreach ($newsTags as $readNewsTags) {
                      $insertNewsTags = $db->prepare("INSERT INTO newsTags SET name = ?, newsID = ?, url = ?");
                      $insertNewsTags->execute(array($readNewsTags, $readNews["id"], createSlug($newsTags)));
                    }
                  }
                  echo alert(languageVariables("alertNewsEditSuccess", "general", $languageType), "success", "3", "");
                } else {
                  echo alert(languageVariables("alertImageUpload", "general", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "general", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="general-news-edit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("newsTitle", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="general-news-edit-title" name="newsEditTitle" placeholder="<?php echo languageVariables("newsTitlePlaceholder", "general", $languageType); ?>" value="<?php echo $readNews["title"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-news-edit-category" class="col-sm-3 col-form-label"><?php echo languageVariables("newsCategory", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <select class="form-control" id="general-news-edit-category" name="newsEditCategory">
                    <?php $searchNewsCategory = $db->query("SELECT * FROM newsCategory ORDER BY id DESC"); ?>
                    <?php if (mysqlCount($searchNewsCategory) > 0) { ?>
                      <?php foreach($searchNewsCategory as $readNewsCategory) { ?>
                        <option value="<?php echo $readNewsCategory["name"]; ?>" <?php if ($readNews["categoryName"] == $readNewsCategory["name"]) { echo "selected"; } ?>><?php echo $readNewsCategory["name"]; ?></option>
                      <?php } ?>
                    <?php } else { ?>
                    <option value="<?php echo languageVariables("newsCategoryAnnouncement", "general", $languageType); ?>" <?php if ($readNews["categoryName"] == languageVariables("newsCategoryAnnouncement", "general", $languageType)) { echo "selected"; } ?>><?php echo languageVariables("newsCategoryAnnouncement", "general", $languageType); ?></option>
                    <option value="<?php echo languageVariables("newsCategoryInfo", "general", $languageType); ?>" <?php if ($readNews["categoryName"] == languageVariables("newsCategoryInfo", "general", $languageType)) { echo "selected"; } ?>><?php echo languageVariables("newsCategoryInfo", "general", $languageType); ?></option>
                    <option value="<?php echo languageVariables("newsCategoryUpdate", "general", $languageType); ?>" <?php if ($readNews["categoryName"] == languageVariables("newsCategoryUpdate", "general", $languageType)) { echo "selected"; } ?>><?php echo languageVariables("newsCategoryUpdate", "general", $languageType); ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="general-news-edit-content" class="col-sm-3 col-form-label"><?php echo languageVariables("newsDescription", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <textarea class="form-control ckeditor" id="general-news-edit-content" name="newsEditContent" placeholder="<?php echo languageVariables("newsDescriptionPlaceholder", "general", $languageType); ?>"><?php echo $readNews["text"]; ?></textarea>
                </div>
              </div>
              <?php
                $searchNewsTags = $db->prepare("SELECT * FROM newsTags WHERE newsID = ? ORDER BY id ASC");
                $searchNewsTags->execute(array($readNews["id"]));
              ?>
              <div class="form-group row">
                <label for="general-news-edit-tags" class="col-sm-3 col-form-label"><?php echo languageVariables("newsTags", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" id="general-news-edit-tags" class="form-control" data-toggle="tagsinput" name="newsEditTags" placeholder="<?php echo languageVariables("newsTag", "general", $languageType); ?>" value="
                  <?php
                  if (mysqlCount($searchNewsTags) > 0) {
                    foreach ($searchNewsTags as $readNewsTags) {
                      echo $readNewsTags["name"].',';
                    }
                  }
                  ?>
                  ">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-news-edit-comments" class="col-sm-3 col-form-label"><?php echo languageVariables("newsComments", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <select class="form-control" id="general-news-edit-comments" name="newsEditComments">
                    <option value="0" <?php if ($readNews["commentStatus"] == 0) { echo "selected"; } ?>><?php echo languageVariables("disable", "words", $languageType); ?></option>
                    <option value="1" <?php if ($readNews["commentStatus"] == 1) { echo "selected"; } ?>><?php echo languageVariables("active", "words", $languageType); ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="general-news-edit-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "words", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage active">
                    <div class="di-thumbnail">
                      <img src="<?php echo $readNews["image"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="general-news-edit-image"><?php echo languageVariables("imagePlaceholder", "words", $languageType); ?></label>
                      <input type="file" id="general-news-edit-image" name="newsEditImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("editNewsToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="editNews"><?php echo languageVariables("edit", "words", $languageType); ?></button>
                <button type="button" class="btn btn-danger mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_news_delete", $languageType); ?>/<?php echo $readNews["id"]; ?>"><?php echo languageVariables("remove", "general", $languageType); ?></button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_general_news", $languageType)); } ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("newsList", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchNews = $db->query("SELECT * FROM newsList ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_news_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_news_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_news_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchNews) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["newsID", "newsTitle", "newsCategory", "newsAuthor", "newsLike", "newsViews", "newsComments", "newsDate"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_general_news_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="newsID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="newsTitle"><?php echo languageVariables("newsTitle", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="newsCategory"><?php echo languageVariables("newsCategory", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="newsAuthor"><?php echo languageVariables("newsAuthor", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="newsLike"><?php echo languageVariables("newsLike", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="newsViews"><?php echo languageVariables("newsViews", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="newsComments"><?php echo languageVariables("newsComments", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="newsDate"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchNews as $readNews) { ?>
               <?php $searchNewsComments = $db->prepare("SELECT * FROM comments WHERE newsID = ?"); ?>
               <?php $searchNewsComments->execute(array($readNews["id"])); ?>
                <tr>
                  <td class="newsID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>/<?php echo $readNews["id"]; ?>">#<?php echo $readNews["id"]; ?></a></td>
                  <td class="newsTitle text-center"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>/<?php echo $readNews["id"]; ?>"><?php echo $readNews["title"]; ?></a></td>
                  <td class="newsCategory text-center"><?php echo $readNews["categoryName"]; ?></td>
                  <td class="newsAuthor text-center"><?php echo $readNews["newsAuthor"]; ?></td>
                  <td class="newsLike text-center"><?php echo $readNews["newsHearts"]; ?></td>
                  <td class="newsViews text-center"><?php echo $readNews["newsDisplay"]; ?></td>
                  <td class="newsComments text-center"><?php echo mysqlCount($searchNewsComments); ?></td>
                  <td class="newsDate text-center"><?php echo checkTime($readNews["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" style="border-radius: 250px;" direct-element="direct" direct-href="<?php echo urlConverter("admin_general_news", $languageType); ?>/<?php echo $readNews["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_news_delete", $languageType); ?>/<?php echo $readNews["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "general", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["newsID"])) { ?>
    <?php
    $removeNews = $db->prepare("DELETE FROM newsList WHERE id = ?");
    $removeNews->execute(array(get("newsID")));
    go(urlConverter("admin_general_news", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_general_news", $languageType)); } ?>
<?php } else if (get("action") == "comments") { ?>
  <?php if (get("target") == "update") { ?>
    <?php if (isset($_GET["commentID"])) { ?>
      <?php
        $searchComments = $db->prepare("SELECT * FROM comments WHERE id = ?");
        $searchComments->execute(array(get("commentID")));
        if (mysqlCount($searchComments) > 0) {
          $readComment = fetch($searchComments);
          $searchNews = $db->prepare("SELECT * FROM newsList WHERE id = ?");
          $searchNews->execute(array($readComment["newsID"]));
          if (mysqlCount($searchNews) > 0) {
            $readNews = fetch($searchNews);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news_comment", $languageType); ?>"><?php echo languageVariables("newsComments", "general", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readComment["id"]."# ".$readComment["message"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <h4 class="card-header-title"><?php echo $readComment["username"]." - ".$readComment["message"]; ?></h4>
            </div>
            <div class="col-auto">
              <?php if ($readComment["status"] == 0) { echo "<span class=\"badge badge-pill badge-danger mr-2\" data-toggle=\"tooltip\" title=\"".languageVariables("status", "words", $languageType)."\">".languageVariables("notApproved", "words", $languageType)."</span>"; } else { echo "<span class=\"badge badge-pill badge-success mr-2\" data-toggle=\"tooltip\" title=\"".languageVariables("status", "words", $languageType)."\">".languageVariables("approved", "words", $languageType)."</span>"; } ?>
              <span class="badge badge-pill badge-info text-white mr-2" data-toggle="tooltip" title="Tarih"><?php echo checkTime($readComment["date"]); ?></span>
            </div>
          </div>
        </div>
        <div class="card-body" data-toggle="messageContent" style="overflow: auto; max-height: 500px;">
          <ul class="messages">
            <li class="message-item friend">
              <img src="<?php echo avatarAPI($readComment["username"], 80); ?>" class="img-xs rounded-circle" alt="avatar">
              <div class="content">
                <div class="message">
                  <div class="bubble">
                    <p><?php echo $readComment["message"]; ?></p>
                  </div>
                  <span><?php echo checkTime($readComment["date"]); ?> <?php echo str_replace("&username", $readComment["username"], languageVariables("newsCommentsBy", "general", $languageType)); ?></span>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="card-footer">
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["commentApprove"])) {
            if ($safeCsrfToken->validate('commentToken')) {
              $updateComment = $db->prepare("UPDATE comments SET status = ? WHERE id = ?");
              $updateComment->execute(array(1, $readComment["id"]));
              echo alert(languageVariables("alertNewsCommentsApproved", "general", $languageType), "success", "3", "");
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          } else if (isset($_POST["commentRemoveCheck"])) {
            if ($safeCsrfToken->validate('commentToken')) {
              $updateComment = $db->prepare("UPDATE comments SET status = ? WHERE id = ?");
              $updateComment->execute(array(0, $readComment["id"]));
              echo alert(languageVariables("alertNewsCommentsNotApproved", "general", $languageType), "success", "3", "");
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form action="" method="POST">
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("commentToken"); ?>
              <?php if ($readComment["status"] == 0) { ?>
              <button type="submit" class="btn btn-success btn-icon mr-2" name="commentApprove" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("check", "words", $languageType); ?>"><i data-feather="check"></i></button>
              <?php } else { ?>
              <button type="submit" class="btn btn-secondary btn-icon mr-2" name="commentRemoveCheck" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("uncheck", "general", $languageType); ?>"><i data-feather="x"></i></button>
              <?php } ?>
              <button type="button" class="btn btn-primary btn-icon mr-2" direct-element="direct" direct-type="blank" direct-href="<?php echo urlConverter("news", $languageType); ?>/<?php echo createSlug($readNews["title"])."/".$readNews["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
              <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_news_comment_delete", $languageType); ?>/<?php echo $readComment["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_general_news_comment", $languageType)); } ?>
      <?php } else { go(urlConverter("admin_general_news_comment", $languageType)); } ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("comments", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchComments = $db->query("SELECT * FROM comments ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news_comment", $languageType); ?>"><?php echo languageVariables("newsComments", "general", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_news_comment_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_news_comment_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_news_comment_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchComments) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["commentsID", "commentsMessage", "commentsUserName", "commentsNews", "commentsStatus", "commentsDate"]'>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <div class="row align-items-center">
                <div class="col-auto pr-0">
                  <span data-feather="search"></span>
                </div>
                <div class="col">
                  <input type="search" class="form-control search" style="border: 0; background: none;" name="search" placeholder="<?php echo languageVariables("searc", "words", $languageType); ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="commentsID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="commentsMessage"><?php echo languageVariables("message", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="commentsUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="commentsNews"><?php echo languageVariables("newsTitle", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="commentsStatus"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="commentsDate"><?php echo languageVariables("date", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchComments as $readComment) { ?>
                 <?php
                   $searchNews = $db->prepare("SELECT * FROM newsList WHERE id = ?");
                   $searchNews->execute(array($readComment["newsID"]));
                   if (mysqlCount($searchNews) > 0) {
                     $readNews = fetch($searchNews);
                 ?>
                <tr>
                  <td class="commentsID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_general_news_comment", $languageType); ?>/<?php echo $readComment["id"]; ?>">#<?php echo $readComment["id"]; ?></a></td>
                  <td class="commentsMessage text-center"><a href="<?php echo urlConverter("admin_general_news_comment", $languageType); ?>/<?php echo $readComment["id"]; ?>"><?php echo $readComment["message"]; ?></a></td>
                  <td class="commentsUserName text-center"><?php echo $readComment["username"]; ?></td>
                  <td class="commentsNews text-center"><a href="<?php echo urlConverter("news", $languageType); ?>/<?php echo createSlug($readNews["title"])."/".$readNews["id"]; ?>"><?php echo $readNews["title"]; ?></a></td>
                  <td class="commentsStatus text-center"><?php if ($readComment["status"] == 0) { echo "<span class=\"badge badge-pill badge-danger mr-2\" data-toggle=\"tooltip\" title=\"".languageVariables("status", "words", $languageType)."\">".languageVariables("notApproved", "words", $languageType)."</span>"; } else { echo "<span class=\"badge badge-pill badge-success mr-2\" data-toggle=\"tooltip\" title=\"".languageVariables("status", "words", $languageType)."\">".languageVariables("approved", "words", $languageType)."</span>"; } ?></td>
                  <td class="commentsDate text-center"><?php echo checkTime($readComment["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_general_news_comment", $languageType); ?>/<?php echo $readComment["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-primary btn-icon" direct-element="direct" direct-type="blank" direct-href="<?php echo urlConverter("news", $languageType); ?>/<?php echo createSlug($readNews["title"])."/".$readNews["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_news_comment_delete", $languageType); ?>/<?php echo $readComment["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "general", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["commentID"])) { ?>
    <?php
    $removeComment = $db->prepare("DELETE FROM comments WHERE id = ?");
    $removeComment->execute(array(get("commentID")));
    go(urlConverter("admin_general_news_comment", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_general_news_comment", $languageType)); } ?>
<?php } else if (get("action") == "category") { ?>
<?php if (AccountPermControl($readAccount["id"], "public_news_category") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news_category", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("categoryAddCardTitle", "general", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addCategory"])) {
            if ($safeCsrfToken->validate('addCategoryToken')) {
              if (post("categoryAddTitle") !== "") {
                $insertCategory = $db->prepare("INSERT INTO newsCategory SET name = ?, date = ?");
                $insertCategory->execute(array(post("categoryAddTitle"), date("d.m.Y H:i:s")));
                echo alert(languageVariables("alertCategoryAddSuccess", "general", $languageType), "success", "3", urlConverter("admin_general_news_category", $languageType));
              } else {
                echo alert(languageVariables("alertNone", "general", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="support-category-add-title" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryTitle", "general", $languageType); ?>:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="support-category-add-title" name="categoryAddTitle" placeholder="<?php echo languageVariables("categoryTitlePlaceholder", "general", $languageType); ?>">
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("addCategoryToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="addCategory"><?php echo languageVariables("add", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["categoryID"])) { ?>
      <?php
      $searchCategory = $db->prepare("SELECT * FROM newsCategory WHERE id = ?");
      $searchCategory->execute(array(get("categoryID")));
      if (mysqlCount($searchCategory) > 0) {
        $readCategory = fetch($searchCategory);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news_category", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readCategory["id"]."# ".$readCategory["title"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("categoryEditCardTitle", "general", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editCategory"])) {
            if ($safeCsrfToken->validate('editCategoryToken')) {
              if (post("categoryEditTitle") !== "") {
                $updateCategory = $db->prepare("UPDATE newsCategory SET name = ? WHERE id = ?");
                $updateCategory->execute(array(post("categoryEditTitle"), $readCategory["id"]));
                echo alert(languageVariables("alertCategoryEditSuccess", "general", $languageType), "success", "3", "");
              } else {
                echo alert(languageVariables("alertNone", "general", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="support-category-edit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryTitle", "general", $languageType); ?>:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="support-category-edit-title" name="categoryEditTitle" placeholder="<?php echo languageVariables("categoryTitlePlaceholder", "general", $languageType); ?>" value="<?php echo $readCategory["name"]; ?>">
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("editCategoryToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editCategory"><?php echo languageVariables("edit", "words", $languageType); ?></button>
              <button type="button" class="btn btn-danger mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_news_category_delete", $languageType); ?>/<?php echo $readCategory["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_general_news_category", $languageType)); } ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("newsCategory", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCategories = $db->query("SELECT * FROM newsCategory ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_news_category", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_news_category_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_news_category_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_news_category_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchCategories) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["categoriesID", "categoriesTitle", "categoriesDate"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_general_news_category_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="categoriesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="categoriesTitle"><?php echo languageVariables("categoryTitle", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="categoriesDate"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCategories as $readCategory) { ?>
                <tr>
                  <td class="categoriesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_general_news_category", $languageType); ?>/<?php echo $readCategory["id"]; ?>">#<?php echo $readCategory["id"]; ?></a></td>
                  <td class="categoriesTitle text-center"><a href="<?php echo urlConverter("admin_general_news_category", $languageType); ?>/<?php echo $readCategory["id"]; ?>"><?php echo $readCategory["name"]; ?></a></td>
                  <td class="categoriesDate text-center"><?php echo checkTime($readCategory["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_general_news_category", $languageType); ?>/<?php echo $readCategory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_news_category_delete", $languageType); ?>/<?php echo $readCategory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "general", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["categoryID"])) { ?>
    <?php
    $removeCategory = $db->prepare("DELETE FROM newsCategory WHERE id = ?");
    $removeCategory->execute(array(get("categoryID")));
    go(urlConverter("admin_general_news_category", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_general_news_category", $languageType)); } ?>
<?php } else if (get("action") == "broadcast") { ?>
<?php if (AccountPermControl($readAccount["id"], "public_broadcast") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_announcement", $languageType); ?>"><?php echo languageVariables("announcement", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("announcementAddCardTitle", "general", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addBroadcast"])) {
            if ($safeCsrfToken->validate('addBroadcastToken')) {
              if (post("broadcastAddTitle") !== "" && post("broadcastAddDesc") !== "" && post("broadcastAddUrl") !== "" && $_FILES["broadcastAddImage"] !== "") {
                if ($_FILES["broadcastAddImage"]["size"] !== null) {
                  $imageUpload = imageUpload($_FILES["broadcastAddImage"], "/assets/uploads/images/broadcast/");
                  if ($imageUpload !== false) {
                    $insertBroadcast = $db->prepare("INSERT INTO broadcast SET title = ?, text = ?, image = ?, url = ?, hits = ?, date = ?");
                    $insertBroadcast->execute(array(post("broadcastAddTitle"), post("broadcastAddDesc"), "/assets/uploads/images/broadcast/".$imageUpload["name"], post("broadcastAddUrl"), 0, date("d.m.Y H:i:s")));
                    echo alert(languageVariables("alertAnnouncementAddSuccess", "general", $languageType), "success", "3", urlConverter("admin_general_announcement", $languageType));
                  } else {
                    echo alert(languageVariables("alertImageUpload", "general", $languageType), "danger", "0", "/");
                  }
                } else {
                  echo alert(languageVariables("alertImage", "general", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "general", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="general-broadcast-add-title" class="col-sm-3 col-form-label"><?php echo languageVariables("announcementTitle", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="general-broadcast-add-title" name="broadcastAddTitle" placeholder="<?php echo languageVariables("announcementTitlePlaceholder", "general", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-broadcast-add-desc" class="col-sm-3 col-form-label"><?php echo languageVariables("announcementDesc", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="general-broadcast-add-desc" name="broadcastAddDesc" placeholder="<?php echo languageVariables("announcementDescPlaceholder", "general", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-broadcast-add-url" class="col-sm-3 col-form-label"><?php echo languageVariables("announcementConnect", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="general-broadcast-add-url" name="broadcastAddUrl" placeholder="<?php echo languageVariables("announcementConnectPlaceholder", "general", $languageType); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-broadcast-add-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "words", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage">
                    <div class="di-thumbnail">
                      <img src="" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="general-broadcast-add-image"><?php echo languageVariables("imagePlaceholder", "words", $languageType); ?></label>
                      <input type="file" id="general-broadcast-add-image" name="broadcastAddImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("addBroadcastToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="addBroadcast"><?php echo languageVariables("add", "words", $languageType); ?></button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["broadcastID"])) { ?>
      <?php
      $searchBroadcast = $db->prepare("SELECT * FROM broadcast WHERE id = ?");
      $searchBroadcast->execute(array(get("broadcastID")));
      if (mysqlCount($searchBroadcast) > 0) {
        $readBroadcast = fetch($searchBroadcast);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_announcement", $languageType); ?>"><?php echo languageVariables("announcement", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readBroadcast["id"]."# ".$readBroadcast["title"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("announcementEditCardTitle", "general", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editBroadcast"])) {
            if ($safeCsrfToken->validate('editBroadcastToken')) {
              if (post("broadcastEditTitle") !== "" && post("broadcastEditDesc") !== "" && post("broadcastEditUrl") !== "" && $_FILES["broadcastEditImage"] !== "") {
                $imageUploadStatus = "__SUCCESS__";
                if ($_FILES["broadcastAddImage"]["size"] !== null) {
                  $imageUpload = imageUpload($_FILES["broadcastEditImage"], "/assets/uploads/images/broadcast/");
                  if ($imageUpload !== false) {
                    $updateBroadcast = $db->prepare("UPDATE broadcast SET image = ? WHERE id = ?");
                    $updateBroadcast->execute(array("/assets/uploads/images/broadcast/".$imageUpload["name"], $readBroadcast["id"]));
                  } else {
                    $imageUploadStatus = "__UNSUCCESS__";
                  }
                }
                $updateBroadcast = $db->prepare("UPDATE broadcast SET title = ?, text = ?, url = ? WHERE id = ?");
                $updateBroadcast->execute(array(post("broadcastEditTitle"), post("broadcastEditDesc"), post("broadcastEditUrl"), $readBroadcast["id"]));
                echo alert(languageVariables("alertAnnouncementEditSuccess", "general", $languageType), "success", "3", "");
              } else {
                echo alert(languageVariables("alertNone", "general", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          }
          ?>
            <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="general-broadcast-edit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("announcementTitle", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="general-broadcast-edit-title" name="broadcastEditTitle" placeholder="<?php echo languageVariables("announcementTitlePlaceholder", "general", $languageType); ?>" value="<?php echo $readBroadcast["title"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-broadcast-edit-desc" class="col-sm-3 col-form-label"><?php echo languageVariables("announcementDesc", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="general-broadcast-edit-desc" name="broadcastEditDesc" placeholder="<?php echo languageVariables("announcementDescPlaceholder", "general", $languageType); ?>" value="<?php echo $readBroadcast["text"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-broadcast-edit-url" class="col-sm-3 col-form-label"><?php echo languageVariables("announcementConnect", "general", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="general-broadcast-edit-url" name="broadcastEditUrl" placeholder="<?php echo languageVariables("announcementConnectPlaceholder", "general", $languageType); ?>" value="<?php echo $readBroadcast["url"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="general-broadcast-edit-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "words", $languageType); ?>:</label>
                <div class="col-sm-9">
                  <div data-toggle="dropimage" class="dropimage active">
                    <div class="di-thumbnail">
                      <img src="<?php echo $readBroadcast["image"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                    </div>
                    <div class="di-select">
                      <label for="general-broadcast-edit-image"><?php echo languageVariables("imagePlaceholder", "words", $languageType); ?></label>
                      <input type="file" id="general-broadcast-edit-image" name="broadcastAddImage" accept="image/*">
                    </div>
                  </div>
                </div>
              </div>
              <div style="float: right;">
                <?php echo $safeCsrfToken->input("editBroadcastToken"); ?>
                <button type="submit" class="btn btn-primary mr-2" name="editBroadcast"><?php echo languageVariables("edit", "words", $languageType); ?></button>
                <button type="button" class="btn btn-danger mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_announcement_delete", $languageType); ?>/<?php echo $readBroadcast["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_general_announcement", $languageType)); } ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("broadcast", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchBroadcast = $db->query("SELECT * FROM broadcast ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_announcement", $languageType); ?>"><?php echo languageVariables("announcement", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_announcement_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_announcement_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_announcement_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchBroadcast) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["broadcastID", "broadcastTitle", "broadcastUrl", "broadcastHits", "broadcastDate"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_general_announcement_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="broadcastID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="broadcastTitle"><?php echo languageVariables("announcementTitle", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="broadcastUrl"><?php echo languageVariables("announcementConnect", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="broadcastHits"><?php echo languageVariables("announcementClick", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="broadcastDate"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchBroadcast as $readBroadcast) { ?>
                <tr>
                  <td class="broadcastID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_general_announcement", $languageType); ?>/<?php echo $readBroadcast["id"]; ?>">#<?php echo $readBroadcast["id"]; ?></a></td>
                  <td class="broadcastTitle text-center"><a href="<?php echo urlConverter("admin_general_announcement", $languageType); ?>/<?php echo $readBroadcast["id"]; ?>"><?php echo $readBroadcast["title"]; ?></a></td>
                  <td class="broadcastUrl text-center"><?php echo $readBroadcast["url"]; ?></td>
                  <td class="broadcastHits text-center"><?php echo $readBroadcast["hits"]; ?></td>
                  <td class="broadcastDate text-center"><?php echo checkTime($readBroadcast["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" style="border-radius: 250px;" direct-element="direct" direct-href="<?php echo urlConverter("admin_general_announcement", $languageType); ?>/<?php echo $readBroadcast["id"]; ?>" data-toggle="tooltip" data-placement="top" title="Düzenle"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" style="border-radius: 250px;" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_announcement_delete", $languageType); ?>/<?php echo $readBroadcast["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "general", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["broadcastID"])) { ?>
    <?php
    $removeBroadcast = $db->prepare("DELETE FROM broadcast WHERE id = ?");
    $removeBroadcast->execute(array(get("broadcastID")));
    go(urlConverter("admin_general_announcement", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_general_announcement", $languageType)); } ?>
<?php } else if (get("action") == "pages") { ?>
<?php if (AccountPermControl($readAccount["id"], "public_page") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_page", $languageType); ?>"><?php echo languageVariables("page", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("pageAddCardTitle", "general", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addPage"])) {
            if ($safeCsrfToken->validate('addPageToken')) {
              if (post("pageAddTitle") !== "" && post("pageAddContent") !== "") {
                $insertPage = $db->prepare("INSERT INTO page SET title = ?, description = ?, username = ?, date = ?");
                $insertPage->execute(array(post("pageAddTitle"), $_POST["pageAddContent"], $readAccount["username"], date("d.m.Y H:i:s")));
                echo alert(languageVariables("alertPageAddSuccess", "general", $languageType), "success", "3", urlConverter("admin_general_page", $languageType));
              } else {
                echo alert(languageVariables("alertNone", "general", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="general-page-add-title" class="col-sm-3 col-form-label"><?php echo languageVariables("pageTitle", "general", $languageType); ?>:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="general-page-add-title" name="pageAddTitle" placeholder="<?php echo languageVariables("pageTitlePlaceholder", "general", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="general-page-add-content" class="col-sm-3 col-form-label"><?php echo languageVariables("pageContent", "general", $languageType); ?>:</label>
              <div class="col-sm-9">
                <textarea class="form-control ckeditor" id="general-page-add-content" name="pageAddContent" placeholder="<?php echo languageVariables("pageContentPlaceholder", "general", $languageType); ?>"></textarea>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("addPageToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="addPage"><?php echo languageVariables("add", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["pageID"])) { ?>
      <?php
      $searchPage = $db->prepare("SELECT * FROM page WHERE id = ?");
      $searchPage->execute(array(get("pageID")));
      if (mysqlCount($searchPage) > 0) {
        $readPage = fetch($searchPage);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_page", $languageType); ?>"><?php echo languageVariables("page", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readPage["id"]."# ".$readPage["title"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("pageEditCardTitle", "general", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editPage"])) {
            if ($safeCsrfToken->validate('editPageToken')) {
              if (post("pageEditTitle") !== "" && post("pageEditContent") !== "") {
                $updatePage = $db->prepare("UPDATE page SET title = ?, description = ? WHERE id = ?");
                $updatePage->execute(array(post("pageEditTitle"), $_POST["pageEditContent"], $readPage["id"]));
                echo alert(languageVariables("alertPageEditSuccess", "general", $languageType), "success", "3", "");
              } else {
                echo alert(languageVariables("alertNone", "general", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "general", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="general-page-edit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("pageTitle", "general", $languageType); ?>:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="general-page-edit-title" name="pageEditTitle" placeholder="<?php echo languageVariables("pageTitlePlaceholder", "general", $languageType); ?>" value="<?php echo $readPage["title"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="general-page-edit-content" class="col-sm-3 col-form-label"><?php echo languageVariables("pageContent", "general", $languageType); ?>:</label>
              <div class="col-sm-9">
                <textarea class="form-control ckeditor" id="general-page-edit-content" name="pageEditContent" placeholder="<?php echo languageVariables("pageContentPlaceholder", "general", $languageType); ?>"><?php echo $readPage["description"]; ?></textarea>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("editPageToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editPage"><?php echo languageVariables("edit", "words", $languageType); ?></button>
              <button type="button" class="btn btn-danger mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_page_delete", $languageType); ?>/<?php echo $readPage["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
              <button type="button" class="btn btn-secondary btn-icon" direct-element="direct" direct-type="blank" direct-href="/<?php echo createSlug($readPage["title"])."/".$readPage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_general_news_category", $languageType)); } ?>
    <?php } else { ?>
      <?php 
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount("page", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchPages = $db->query("SELECT * FROM page ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_general_page", $languageType); ?>"><?php echo languageVariables("page", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_page_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_page_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_general_page_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchPages) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["pagesID", "pagesTitle", "pagesAuthor", "pagesDate"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_general_page_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="pagesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="pagesTitle"><?php echo languageVariables("pageTitle", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="pagesAuthor"><?php echo languageVariables("pageAuthor", "general", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="pagesDate"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchPages as $readPage) { ?>
                <tr>
                  <td class="pagesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_general_page", $languageType); ?>/<?php echo $readPage["id"]; ?>">#<?php echo $readPage["id"]; ?></a></td>
                  <td class="pagesTitle text-center"><a href="<?php echo urlConverter("admin_general_page", $languageType); ?>/<?php echo $readPage["id"]; ?>"><?php echo $readPage["title"]; ?></a></td>
                  <td class="pagesAuthor text-center"><?php echo $readPage["username"]; ?></td>
                  <td class="pagesDate text-center"><?php echo checkTime($readPage["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_general_page", $languageType); ?>/<?php echo $readPage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-primary btn-icon" direct-element="direct" direct-type="blank" direct-href="/<?php echo createSlug($readPage["title"])."/".$readPage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_general_page_delete", $languageType); ?>/<?php echo $readPage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "general", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove" && isset($_GET["pageID"])) { ?>
    <?php
    $removePage = $db->prepare("DELETE FROM page WHERE id = ?");
    $removePage->execute(array(get("pageID")));
    go(urlConverter("admin_general_page", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_general_page", $languageType)); } ?>
<?php } ?>