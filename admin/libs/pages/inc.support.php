<?php if (AccountPermControl($readAccount["id"], "support") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php if (get("action") == "help-center") { ?>
<?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_support_help_center", $languageType); ?>"><?php echo languageVariables("helpCenter", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("helpCenterAddTitle", "support", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addTopic"])) {
            if ($safeCsrfToken->validate('addTopicToken')) {
              if (post("helpTopicName") !== "" && post("helpTopicTitle") !== "" && post("helpTopicDescription") !== "" && post("helpTopicIcon") !== "" && post("helpTopicIconColor") !== "" && post("helpTopicIconBackgroundColor") !== "" && $_POST["contentsTitle"] !== "") {
                $contents = array();
                foreach($_POST['contentsTitle'] as $key => $value){
                  $contentAdd = array(
                    "title" => $_POST['contentsTitle'][$key],
                    "content" => $_POST['contentsText'][$key]
                  );
                  array_push($contents, $contentAdd);
                }
                $insertHelpCenter = $db->prepare("INSERT INTO helpCenter (`name`, `title`, `description`, `categoryIcon`, `iconColor`, `iconBackgroundColor`, `contents`, `author`, `views`, `useful`, `useless`, `date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                $insertHelpCenter->execute(array(post("helpTopicName"), post("helpTopicTitle"), post("helpTopicDescription"), post("helpTopicIcon"), post("helpTopicIconColor"), post("helpTopicIconBackgroundColor"), json_encode($contents), $readAccount["username"], 0, 0, 0, date("d.m.Y H:i:s")));
                echo alert(languageVariables("helpCenterAddSuccess", "support", $languageType), "success", "2", urlConverter("admin_support_help_center", $languageType));
              } else {
                echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="help-center-name" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryName", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="help-center-name" name="helpTopicName" placeholder="<?php echo languageVariables("helpCenterCategoryNamePlaceholder", "support", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-title" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryTitle", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="help-center-title" name="helpTopicTitle" placeholder="<?php echo languageVariables("helpCenterCategoryTitlePlaceholder", "support", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-desc" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryDesc", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="help-center-desc" name="helpTopicDescription" placeholder="<?php echo languageVariables("helpCenterCategoryDescPlaceholder", "support", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="iconInput" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryIcon", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="input-group input-group-merge">
                  <input type="text" class="form-control" id="iconInput" name="helpTopicIcon" placeholder="<?php echo languageVariables("helpCenterCategoryIconPlaceholder", "support", $languageType); ?>">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-success" data-toggle="iconpicker"></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-color" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryIconColor", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="help-center-color" name="helpTopicIconColor" placeholder="<?php echo languageVariables("helpCenterCategoryIconClrPlaceholder", "support", $languageType); ?>" value="#10b759">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-bg-color" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryIconBGColor", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="help-center-bg-color" name="helpTopicIconBackgroundColor" placeholder="<?php echo languageVariables("helpCenterCategoryIconClrPlaceholder", "support", $languageType); ?>" value="#10b759">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-contents" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterContent", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="table-responsive">
                  <table id="tableitems" class="table table-sm table-hover table-nowrap array-table">
                    <thead>
                      <tr>
                        <th class="text-center align-middle w-90"><?php echo languageVariables("title", "words", $languageType); ?> - <?php echo languageVariables("content", "words", $languageType); ?></th>
                        <th class="text-center align-middle w-10">
                          <button type="button" class="btn btn-success btn-icon" add-item="topic">
                            <i data-feather="plus"></i>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody data-toggle="itemTable">
                      <tr id="removeID-s9238">
                        <td class="ml-2 w-90" style="display: grid;">
                          <div class="input-group">
                            <input type="text" class="form-control form-control-prepended" name="contentsTitle[]" placeholder="<?php echo languageVariables("title", "words", $languageType); ?>">
                          </div>
						              <div class="input-group mt-3">
                            <textarea type="text" class="form-control form-control-prepended ckeditor" name="contentsText[]" placeholder="<?php echo languageVariables("content", "words", $languageType); ?>" rows="5"></textarea>
                          </div>
                        </td>
                        <td class="text-center align-middle w-10">
                          <button type="button" remove-item="button" remove-id="s9238" class="btn btn-danger btn-icon">
                            <span class="far fa-trash-alt"></span>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("addTopicToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="addTopic"><?php echo languageVariables("add", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["topicID"])) { ?>
      <?php
      $searchHelpCenter = $db->prepare("SELECT * FROM helpCenter WHERE id = ?");
      $searchHelpCenter->execute(array(get("topicID")));
      if (mysqlCount($searchHelpCenter) > 0) {
        $readHelpCenter = fetch($searchHelpCenter);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_support_help_center", $languageType); ?>"><?php echo languageVariables("helpCenter", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readHelpCenter["name"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("helpCenterEditTitle", "support", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editTopic"])) {
            if ($safeCsrfToken->validate('editTopicToken')) {
              if (post("helpTopicName") !== "" && post("helpTopicTitle") !== "" && post("helpTopicDescription") !== "" && post("helpTopicIcon") !== "" && post("helpTopicIconColor") !== "" && post("helpTopicIconBackgroundColor") !== "" && $_POST["contentsTitle"] !== "") {
                $contents = array();
                foreach($_POST['contentsTitle'] as $key => $value){
                  if ($_POST['contentsTitle'][$key] !== "" && $_POST['contentsText'][$key] !== "") {
                    $contentAdd = array(
                      "title" => $_POST['contentsTitle'][$key],
                      "content" => $_POST['contentsText'][$key]
                    );
                    array_push($contents, $contentAdd);
                  }
                }
                $insertHelpCenter = $db->prepare("UPDATE helpCenter SET name = ?, title = ?, description = ?, categoryIcon = ?, iconColor = ?, iconBackgroundColor = ?, contents = ? WHERE id = ?");
                $insertHelpCenter->execute(array(post("helpTopicName"), post("helpTopicTitle"), post("helpTopicDescription"), post("helpTopicIcon"), post("helpTopicIconColor"), post("helpTopicIconBackgroundColor"), json_encode($contents), $readHelpCenter["id"]));
                echo alert(languageVariables("helpCenterEditSuccess", "support", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="help-center-name" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryName", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="help-center-name" name="helpTopicName" placeholder="<?php echo languageVariables("helpCenterCategoryNamePlaceholder", "support", $languageType); ?>" value="<?php echo $readHelpCenter["name"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-title" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryTitle", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="help-center-title" name="helpTopicTitle" placeholder="<?php echo languageVariables("helpCenterCategoryTitlePlaceholder", "support", $languageType); ?>" value="<?php echo $readHelpCenter["title"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-desc" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryDesc", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="help-center-desc" name="helpTopicDescription" placeholder="<?php echo languageVariables("helpCenterCategoryDescPlaceholder", "support", $languageType); ?>" value="<?php echo $readHelpCenter["description"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="iconInput" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryIcon", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="input-group input-group-merge">
                  <input type="text" class="form-control" id="iconInput" name="helpTopicIcon" placeholder="<?php echo languageVariables("helpCenterCategoryIconPlaceholder", "support", $languageType); ?>" value="<?php echo $readHelpCenter["categoryIcon"]; ?>">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-success" data-toggle="iconpicker"></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-color" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryIconColor", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="help-center-color" name="helpTopicIconColor" placeholder="<?php echo languageVariables("helpCenterCategoryIconClrPlaceholder", "support", $languageType); ?>" value="<?php echo $readHelpCenter["iconColor"]; ?>">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-bg-color" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterCategoryIconBGColor", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <div id="colorPicker" class="colorpicker-component input-group input-group-merge mb-3" data-toggle="colorPicker">
                  <input type="text" class="form-control form-control-appended" id="help-center-bg-color" name="helpTopicIconBackgroundColor" placeholder="<?php echo languageVariables("helpCenterCategoryIconClrPlaceholder", "support", $languageType); ?>" value="<?php echo $readHelpCenter["iconBackgroundColor"]; ?>">
                  <div class="input-group-append">
                    <div class="input-group-text input-group-addon">
                      <i></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="help-center-contents" class="col-sm-3 col-form-label"><?php echo languageVariables("helpCenterContent", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <div class="table-responsive">
                  <table id="tableitems" class="table table-sm table-hover table-nowrap array-table">
                    <thead>
                      <tr>
                        <th class="text-center align-middle w-90"><?php echo languageVariables("title", "words", $languageType); ?> - <?php echo languageVariables("content", "words", $languageType); ?></th>
                        <th class="text-center align-middle w-10">
                          <button type="button" class="btn btn-success btn-icon" add-item="topic">
                            <i data-feather="plus"></i>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody data-toggle="itemTable">
                      <?php $helpCenterContents = json_decode($readHelpCenter["contents"], true); ?>
                      <?php foreach ($helpCenterContents as $readHelpCenterContents) { ?>
                      <tr id="removeID-<?php echo createSlug($readHelpCenterContents["title"]); ?>">
                        <td class="ml-2 w-90" style="display: grid;">
                          <div class="input-group">
                            <input type="text" class="form-control form-control-prepended" name="contentsTitle[]" placeholder="<?php echo languageVariables("title", "words", $languageType); ?>" value="<?php echo $readHelpCenterContents["title"]; ?>">
                          </div>
						              <div class="input-group mt-3">
                            <textarea type="text" class="form-control form-control-prepended ckeditor" name="contentsText[]" placeholder="<?php echo languageVariables("content", "words", $languageType); ?>" rows="5"><?php echo $readHelpCenterContents["content"]; ?></textarea>
                          </div>
                        </td>
                        <td class="text-center align-middle w-10">
                        <button type="button" remove-item="button" remove-id="<?php echo createSlug($readHelpCenterContents["title"]); ?>" class="btn btn-danger btn-icon">
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
              <?php echo $safeCsrfToken->input("editTopicToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editTopic"><?php echo languageVariables("update", "words", $languageType); ?></button>
              <button type="button" class="btn btn-danger mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_help_center_delete", $languageType); ?>/<?php echo $readHelpCenter["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
    <?php } else { go(urlConverter("admin_support_help_center", $languageType)); } ?>
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
      $pageItemCount = pageItemCount("helpCenter", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchHelpCenter = $db->query("SELECT * FROM helpCenter ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_support_help_center", $languageType); ?>"><?php echo languageVariables("helpCenter", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_category_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_category_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_category_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchHelpCenter) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["helpID", "helpName", "helpAuthor", "helpViews", "helpHelpFull", "helpDate"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_support_help_center_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="helpID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="helpName"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="helpAuthor"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="helpViews"><?php echo languageVariables("views", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="helpHelpFull"><?php echo languageVariables("helpful", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="helpDate"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchHelpCenter as $readHelpCenter) { ?>
                <tr>
                  <td class="helpID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_support_help_center", $languageType); ?>/<?php echo $readHelpCenter["id"]; ?>">#<?php echo $readHelpCenter["id"]; ?></a></td>
                  <td class="helpName text-center"><a href="<?php echo urlConverter("admin_support_help_center", $languageType); ?>/<?php echo $readHelpCenter["id"]; ?>"><?php echo $readHelpCenter["name"]; ?></a></td>
                  <td class="helpAuthor text-center"><?php echo $readHelpCenter["author"]; ?></td>
                  <td class="helpViews text-center"><?php echo $readHelpCenter["views"]; ?></td>
                  <td class="helpHelpFull text-center"><?php echo $readHelpCenter["useful"]."/".$readHelpCenter["useless"]; ?></td>
                  <td class="helpDate text-center"><?php echo checkTime($readHelpCenter["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_support_help_center", $languageType); ?>/<?php echo $readHelpCenter["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_help_center_delete", $languageType); ?>/<?php echo $readHelpCenter["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
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
  <?php } else if (get("target") == "remove") { ?>
    <?php
    $removeHelpCenter = $db->prepare("DELETE FROM helpCenter WHERE id = ?");
    $removeHelpCenter->execute(array(get("topicID")));
    go(urlConverter("admin_support_help_center", $languageType));
    ?>
  <?php } ?>
<?php } else if (get("action") == "category") { ?>
<?php if (AccountPermControl($readAccount["id"], "support_category") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_support_category", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("categoryAddCardTitle", "support", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addCategory"])) {
            if ($safeCsrfToken->validate('addCategoryToken')) {
              if (post("categoryAddTitle") !== "") {
                $insertAnswer = $db->prepare("INSERT INTO supportCategory SET title = ?, date = ?");
                $insertAnswer->execute(array(post("categoryAddTitle"), date("d.m.Y H:i:s")));
                echo alert(languageVariables("alertCategoryAddSuccess", "support", $languageType), "success", "3", urlConverter("admin_support_category", $languageType));
              } else {
                echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="support-category-add-title" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryTitle", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="support-category-add-title" name="categoryAddTitle" placeholder="<?php echo languageVariables("categoryTitlePlaceholder", "support", $languageType); ?>">
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
      $searchCategory = $db->prepare("SELECT * FROM supportCategory WHERE id = ?");
      $searchCategory->execute(array(get("categoryID")));
      if (mysqlCount($searchCategory) > 0) {
        $readCategory = fetch($searchCategory);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_support_category", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readCategory["id"]."# ".$readCategory["title"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("categoryEditCardTitle", "support", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editCategory"])) {
            if ($safeCsrfToken->validate('editCategoryToken')) {
              if (post("categoryEditTitle") !== "") {
                $updateAnswer = $db->prepare("UPDATE supportCategory SET title = ? WHERE id = ?");
                $updateAnswer->execute(array(post("categoryEditTitle"), $readCategory["id"]));
                echo alert(languageVariables("alertCategoryEditSuccess", "support", $languageType), "success", "3", "");
              } else {
                echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="support-category-edit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryTitle", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="support-category-edit-title" name="categoryEditTitle" placeholder="<?php echo languageVariables("categoryTitlePlaceholder", "support", $languageType); ?>" value="<?php echo $readCategory["title"]; ?>">
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("editCategoryToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editCategory"><?php echo languageVariables("edit", "words", $languageType); ?></button>
              <button type="button" class="btn btn-danger mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_category_delete", $languageType); ?>/<?php echo $readCategory["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_support_category", $languageType)); } ?>
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
      $pageItemCount = pageItemCount("supportCategory", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCategories = $db->query("SELECT * FROM supportCategory ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_support_category", $languageType); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_category_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_category_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_category_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_support_category_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="categoriesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="categoriesTitle"><?php echo languageVariables("categoryTitle", "support", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="categoriesDate"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCategories as $readCategory) { ?>
                <tr>
                  <td class="categoriesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_support_category", $languageType); ?>/<?php echo $readCategory["id"]; ?>">#<?php echo $readCategory["id"]; ?></a></td>
                  <td class="categoriesTitle text-center"><a href="<?php echo urlConverter("admin_support_category", $languageType); ?>/<?php echo $readCategory["id"]; ?>"><?php echo $readCategory["title"]; ?></a></td>
                  <td class="categoriesDate text-center"><?php echo checkTime($readCategory["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_support_category", $languageType); ?>/<?php echo $readCategory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_category_delete", $languageType); ?>/<?php echo $readCategory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
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
  <?php } else if (get("target") == "remove" && isset($_GET["categoryID"])) { ?>
    <?php
    $removeAnswer = $db->prepare("DELETE FROM supportCategory WHERE id = ?");
    $removeAnswer->execute(array(get("categoryID")));
    go(urlConverter("admin_support_category", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_support_category", $languageType)); } ?>
<?php } else if (get("action") == "repartee") { ?>
<?php if (AccountPermControl($readAccount["id"], "support_answer") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_support_ready_answer", $languageType); ?>"><?php echo languageVariables("readyAnswer", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("readyAnswerAddCardTitle", "support", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addAnswer"])) {
            if ($safeCsrfToken->validate('addAnswerToken')) {
              if (post("answerAddTitle") !== "" && post("answerAddContent") !== "") {
                $insertAnswer = $db->prepare("INSERT INTO supportReadyAnswers SET title = ?, content = ?, date = ?");
                $insertAnswer->execute(array(post("answerAddTitle"), $_POST["answerAddContent"], date("d.m.Y H:i:s")));
                echo alert(languageVariables("alertReadyAnswerAddSuccess", "support", $languageType), "success", "3", urlConverter("admin_support_ready_answer", $languageType));
              } else {
                echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="support-answer-add-title" class="col-sm-3 col-form-label"><?php echo languageVariables("readyAnswerReplyTitle", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="support-answer-add-title" name="answerAddTitle" placeholder="<?php echo languageVariables("readyAnswerReplyTitlePlaceholder", "support", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="support-answer-add-content" class="col-sm-3 col-form-label"><?php echo languageVariables("readyAnswerMessageContent", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <textarea class="form-control ckeditor" id="support-answer-add-content" name="answerAddContent" placeholder="<?php echo languageVariables("readyAnswerMessageContentPlaceholder", "support", $languageType); ?>"></textarea>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("addAnswerToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="addAnswer"><?php echo languageVariables("add", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "update") { ?>
    <?php if (isset($_GET["replyID"])) { ?>
      <?php
      $searchAnswer = $db->prepare("SELECT * FROM supportReadyAnswers WHERE id = ?");
      $searchAnswer->execute(array(get("replyID")));
      if (mysqlCount($searchAnswer) > 0) {
        $readAnswer = fetch($searchAnswer);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_support_ready_answer", $languageType); ?>"><?php echo languageVariables("readyAnswer", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readAnswer["id"]."# ".$readAnswer["title"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("readyAnswerEditCardTitle", "support", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editAnswer"])) {
            if ($safeCsrfToken->validate('editAnswerToken')) {
              if (post("answerEditTitle") !== "" && post("answerEditContent") !== "") {
                $updateAnswer = $db->prepare("UPDATE supportReadyAnswers SET title = ?, content = ? WHERE id = ?");
                $updateAnswer->execute(array(post("answerEditTitle"), $_POST["answerEditContent"], $readAnswer["id"]));
                echo alert(languageVariables("alertReadyAnswerEditSuccess", "support", $languageType), "success", "3", "");
              } else {
                echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="support-answer-edit-title" class="col-sm-3 col-form-label"><?php echo languageVariables("readyAnswerReplyTitle", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="support-answer-edit-title" name="answerEditTitle" placeholder="<?php echo languageVariables("readyAnswerReplyTitlePlaceholder", "support", $languageType); ?>" value="<?php echo $readAnswer["title"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="support-answer-edit-content" class="col-sm-3 col-form-label"><?php echo languageVariables("readyAnswerMessageContent", "support", $languageType); ?></label>
              <div class="col-sm-9">
                <textarea class="form-control ckeditor" id="support-answer-edit-content" name="answerEditContent" placeholder="<?php echo languageVariables("readyAnswerMessageContentPlaceholder", "support", $languageType); ?>"><?php echo $readAnswer["content"]; ?></textarea>
              </div>
            </div>
            <div style="float: right;">
                <?php echo $safeCsrfToken->input("editAnswerToken"); ?>
              <button type="submit" class="btn btn-primary mr-2" name="editAnswer"><?php echo languageVariables("edit", "words", $languageType); ?></button>
              <button type="button" class="btn btn-danger mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_ready_answer_delete", $languageType); ?>/<?php echo $readAnswer["id"]; ?>"><?php echo languageVariables("remove", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_support_ready_answer", $languageType)); } ?>
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
      $pageItemCount = pageItemCount("supportReadyAnswers", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchAnswers = $db->query("SELECT * FROM supportReadyAnswers ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_support_ready_answer", $languageType); ?>"><?php echo languageVariables("readyAnswer", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_ready_answer_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_ready_answer_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_ready_answer_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchAnswers) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["answersID", "answersTitle", "answersDate"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_support_ready_answer_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="answersID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="answersTitle"><?php echo languageVariables("readyAnswerReplyTitle", "support", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="answersDate"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchAnswers as $readAnswers) { ?>
                <tr>
                  <td class="answersID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_support_ready_answer", $languageType); ?>/<?php echo $readAnswers["id"]; ?>">#<?php echo $readAnswers["id"]; ?></a></td>
                  <td class="answersTitle text-center"><a href="<?php echo urlConverter("admin_support_ready_answer", $languageType); ?>/<?php echo $readAnswers["id"]; ?>"><?php echo $readAnswers["title"]; ?></a></td>
                  <td class="answersDate text-center"><?php echo checkTime($readAnswers["date"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_support_ready_answer", $languageType); ?>/<?php echo $readAnswers["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_ready_answer_delete", $languageType); ?>/<?php echo $readAnswers["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
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
  <?php } else if (get("target") == "remove" && isset($_GET["replyID"])) { ?>
    <?php
    $removeAnswer = $db->prepare("DELETE FROM supportReadyAnswers WHERE id = ?");
    $removeAnswer->execute(array(get("replyID")));
    go(urlConverter("admin_support_ready_answer", $languageType));
    ?>
  <?php } else { go(urlConverter("admin_support_ready_answer", $languageType)); } ?>
<?php } else if (get("action") == "general") { ?>
<?php if (AccountPermControl($readAccount["id"], "support_public") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "all") { ?>
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
      $pageItemCount = pageItemCount("supportList", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchSupport = $db->query("SELECT * FROM supportList ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("all", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_all_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_all_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_all_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchSupport) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["supportID", "supportTitle", "supportUserName", "supportCategory", "supportServer", "supportStatus", "supportUpdate"]'>
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
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="supportID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportCategory"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportServer"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportStatus"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportUpdate"><?php echo languageVariables("lastUpdate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchSupport as $readSupport) { ?>
                <tr>
                  <td class="supportID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>">#<?php echo $readSupport["id"]; ?></a></td>
                  <td class="supportTitle text-center"><a href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>"><?php echo $readSupport["title"]; ?></a></td>
                  <td class="supportUserName text-center"><?php echo $readSupport["username"]; ?></td>
                  <td class="supportCategory text-center"><?php echo $readSupport["category"]; ?></td>
                  <td class="supportServer text-center"><?php echo $readSupport["serverName"]; ?></td>
                  <td class="supportStatus text-center"><?php if ($readSupport["status"] == 0) { echo "<span class=\"badge badge-pill badge-danger\">".languageVariables("supportStatus0", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 1) { echo "<span class=\"badge badge-pill badge-success\">".languageVariables("supportStatus1", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 2) { echo "<span class=\"badge badge-pill badge-primary\">".languageVariables("supportStatus2", "support", $languageType)."</span>"; } ?></td>
                  <td class="supportUpdate text-center"><?php echo checkTime($readSupport["lastUpdate"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-secondary btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("closedAreYouSure", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_close", $languageType); ?>/<?php echo $readSupport["id"]; ?>/0" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("close", "words", $languageType); ?>"><i class="fas fa-times"></i></button>
                    <?php if ($readSupport["lockStatus"] == "0") { ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("lockedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_lock", $languageType); ?>/<?php echo $readSupport["id"]; ?>/1/0" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("locked", "words", $languageType); ?>"><i class="fas fa-shield"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("unLockedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_lock", $languageType); ?>/<?php echo $readSupport["id"]; ?>/2/0" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("unLocked", "words", $languageType); ?>"><i class="fas fa-shield-off"></i></button>
                    <?php } ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_delete", $languageType); ?>/<?php echo $readSupport["id"]; ?>/0" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
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
  <?php } else if (get("target") == "open") { ?>
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
      $pageItemCount = pageItemCount("supportList", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchSupport = $db->prepare("SELECT * FROM supportList WHERE status = ? ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
      <?php $searchSupport->execute(array(0)); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("notReplys", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_not_replys_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_not_replys_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_not_replys_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchSupport) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["supportID", "supportTitle", "supportUserName", "supportCategory", "supportServer", "supportStatus", "supportUpdate"]'>
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
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="supportID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportCategory"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportServer"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportStatus"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportUpdate"><?php echo languageVariables("lastUpdate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchSupport as $readSupport) { ?>
                <tr>
                  <td class="supportID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>">#<?php echo $readSupport["id"]; ?></a></td>
                  <td class="supportTitle text-center"><a href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>"><?php echo $readSupport["title"]; ?></a></td>
                  <td class="supportUserName text-center"><?php echo $readSupport["username"]; ?></td>
                  <td class="supportCategory text-center"><?php echo $readSupport["category"]; ?></td>
                  <td class="supportServer text-center"><?php echo $readSupport["serverName"]; ?></td>
                  <td class="supportStatus text-center"><?php if ($readSupport["status"] == 0) { echo "<span class=\"badge badge-pill badge-danger\">".languageVariables("supportStatus0", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 1) { echo "<span class=\"badge badge-pill badge-success\">".languageVariables("supportStatus1", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 2) { echo "<span class=\"badge badge-pill badge-primary\">".languageVariables("supportStatus2", "support", $languageType)."</span>"; } ?></td>
                  <td class="supportUpdate text-center"><?php echo checkTime($readSupport["lastUpdate"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-secondary btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("closedAreYouSure", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_close", $languageType); ?>/<?php echo $readSupport["id"]; ?>/1" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("close", "words", $languageType); ?>"><i class="fas fa-times"></i></button>
                    <?php if ($readSupport["lockStatus"] == "0") { ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("lockedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_lock", $languageType); ?>/<?php echo $readSupport["id"]; ?>/1/1" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("locked", "words", $languageType); ?>"><i class="fas fa-shield"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("unLockedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_lock", $languageType); ?>/<?php echo $readSupport["id"]; ?>/2/1" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("unLocked", "words", $languageType); ?>"><i class="fas fa-shield-off"></i></button>
                    <?php } ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_delete", $languageType); ?>/<?php echo $readSupport["id"]; ?>/1" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
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
  <?php } else if (get("target") == "answered") { ?>
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
      $pageItemCount = pageItemCount("supportList", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchSupport = $db->prepare("SELECT * FROM supportList WHERE status = ? ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
      <?php $searchSupport->execute(array(1)); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("replys", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_replys_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_replys_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_replys_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchSupport) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["supportID", "supportTitle", "supportUserName", "supportCategory", "supportServer", "supportStatus", "supportUpdate"]'>
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
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="supportID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportCategory"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportServer"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportStatus"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportUpdate"><?php echo languageVariables("lastUpdate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchSupport as $readSupport) { ?>
                <tr>
                  <td class="supportID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>">#<?php echo $readSupport["id"]; ?></a></td>
                  <td class="supportTitle text-center"><a href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>"><?php echo $readSupport["title"]; ?></a></td>
                  <td class="supportUserName text-center"><?php echo $readSupport["username"]; ?></td>
                  <td class="supportCategory text-center"><?php echo $readSupport["category"]; ?></td>
                  <td class="supportServer text-center"><?php echo $readSupport["serverName"]; ?></td>
                  <td class="supportStatus text-center"><?php if ($readSupport["status"] == 0) { echo "<span class=\"badge badge-pill badge-danger\">".languageVariables("supportStatus0", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 1) { echo "<span class=\"badge badge-pill badge-success\">".languageVariables("supportStatus1", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 2) { echo "<span class=\"badge badge-pill badge-primary\">".languageVariables("supportStatus2", "support", $languageType)."</span>"; } ?></td>
                  <td class="supportUpdate text-center"><?php echo checkTime($readSupport["lastUpdate"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-secondary btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("closedAreYouSure", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_close", $languageType); ?>/<?php echo $readSupport["id"]; ?>/2" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("close", "words", $languageType); ?>"><i class="fas fa-times"></i></button>
                    <?php if ($readSupport["lockStatus"] == "0") { ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("lockedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_lock", $languageType); ?>/<?php echo $readSupport["id"]; ?>/1/2" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("locked", "words", $languageType); ?>"><i class="fas fa-shield"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("unLockedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_lock", $languageType); ?>/<?php echo $readSupport["id"]; ?>/2/2" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("unLocked", "words", $languageType); ?>"><i class="fas fa-shield-off"></i></button>
                    <?php } ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_delete", $languageType); ?>/<?php echo $readSupport["id"]; ?>/2" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
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
  <?php } else if (get("target") == "disabled") { ?>
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
      $pageItemCount = pageItemCount("supportList", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchSupport = $db->prepare("SELECT * FROM supportList WHERE status = ? ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
      <?php $searchSupport->execute(array(2)); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("closeds", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_closed_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_closed_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_support_closed_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchSupport) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["supportID", "supportTitle", "supportUserName", "supportCategory", "supportServer", "supportStatus", "supportUpdate"]'>
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
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="supportID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportUserName"><?php echo languageVariables("username", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportCategory"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportServer"><?php echo languageVariables("server", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportStatus"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="supportUpdate"><?php echo languageVariables("lastUpdate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchSupport as $readSupport) { ?>
                <tr>
                  <td class="supportID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>">#<?php echo $readSupport["id"]; ?></a></td>
                  <td class="supportTitle text-center"><a href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>"><?php echo $readSupport["title"]; ?></a></td>
                  <td class="supportUserName text-center"><?php echo $readSupport["username"]; ?></td>
                  <td class="supportCategory text-center"><?php echo $readSupport["category"]; ?></td>
                  <td class="supportServer text-center"><?php echo $readSupport["serverName"]; ?></td>
                  <td class="supportStatus text-center"><?php if ($readSupport["status"] == 0) { echo "<span class=\"badge badge-pill badge-danger\">".languageVariables("supportStatus0", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 1) { echo "<span class=\"badge badge-pill badge-success\">".languageVariables("supportStatus1", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 2) { echo "<span class=\"badge badge-pill badge-primary\">".languageVariables("supportStatus2", "support", $languageType)."</span>"; } ?></td>
                  <td class="supportUpdate text-center"><?php echo checkTime($readSupport["lastUpdate"]); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_support_view", $languageType); ?>/<?php echo $readSupport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-secondary btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("closedAreYouSure", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_close", $languageType); ?>/<?php echo $readSupport["id"]; ?>/3" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("close", "words", $languageType); ?>"><i class="fas fa-times"></i></button>
                    <?php if ($readSupport["lockStatus"] == "0") { ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("lockedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_lock", $languageType); ?>/<?php echo $readSupport["id"]; ?>/1/3" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("locked", "words", $languageType); ?>"><i class="fas fa-shield"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("unLockedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_lock", $languageType); ?>/<?php echo $readSupport["id"]; ?>/2/3" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("unLocked", "words", $languageType); ?>"><i class="fas fa-shield-off"></i></button>
                    <?php } ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_delete", $languageType); ?>/<?php echo $readSupport["id"]; ?>/3" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i class="fas fa-trash-alt"></i></button>
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
  <?php } else if (get("target") == "lock") { ?>
    <?php 
      if (get("type") == "1") {
        $supportLocked = $db->prepare("SELECT * FROM accountsLicense SET status = ?, lockStatus = ? WHERE id = ?");
        $supportLocked->execute(array(2, 1, get("id")));
      } else {
        $supportLocked = $db->prepare("SELECT * FROM accountsLicense SET status = ?, lockStatus = ? WHERE id = ?");
        $supportLocked->execute(array(1, 0, get("id")));
      }
      if (get("returnUrl") == 0) {
        go(urlConverter("admin_support_all", $languageType));
      } else if (get("returnUrl") == 1) {
        go(urlConverter("admin_support_not_replys", $languageType));
      } else if (get("returnUrl") == 2) {
        go(urlConverter("admin_support_replys", $languageType));
      } else if (get("returnUrl") == 3) {
        go(urlConverter("admin_support_closed", $languageType));
      } else {
        go(urlConverter("admin_support_all", $languageType));
      }
    ?>
  <?php } ?>
<?php } else if (get("action") == "view") { ?>
<?php if (AccountPermControl($readAccount["id"], "support_public") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
  <?php if (get("target") == "update") { ?>
      <?php
      $searchSupport = $db->prepare("SELECT * FROM supportList WHERE id = ?");
      $searchSupport->execute(array(get("supportID")));
      if (mysqlCount($searchSupport) > 0) {
        $readSupport = fetch($searchSupport);
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readSupport["id"]."# ".$readSupport["title"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col">
              <h4 class="card-header-title"><?php echo $readSupport["title"]; ?></h4>
            </div>
            <div class="col-auto">
              <span class="badge badge-pill badge-info text-white mr-2" data-toggle="tooltip" title="Sunucu"><?php echo $readSupport["serverName"]; ?></span>
              <span class="badge badge-pill badge-info text-white mr-2" data-toggle="tooltip" title="Kategori"><?php echo $readSupport["category"]; ?></span>
              <?php if ($readSupport["status"] == 0) { echo "<span class=\"badge badge-pill badge-danger mr-2\" data-toggle=\"tooltip\" title=\"".languageVariables("status", "words", $languageType)."\">".languageVariables("supportStatus0", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 1) { echo "<span class=\"badge badge-pill badge-success mr-2\" data-toggle=\"tooltip\" title=\"".languageVariables("status", "words", $languageType)."\">".languageVariables("supportStatus1", "support", $languageType)."</span>"; } else if ($readSupport["status"] == 2) { echo "<span class=\"badge badge-pill badge-primary mr-2\" data-toggle=\"tooltip\" title=\"".languageVariables("status", "words", $languageType)."\">".languageVariables("supportStatus2", "support", $languageType)."</span>"; } ?>
              <span class="badge badge-pill badge-info text-white mr-2" data-toggle="tooltip" title="Son Güncelleme"><?php echo checkTime($readSupport["lastUpdate"]); ?></span>
            </div>
          </div>
        </div>
        <div class="card-body" data-toggle="messageContent" style="overflow: auto; max-height: 500px;">
          <ul class="messages">
          <li class="message-item friend">
            <img src="<?php echo avatarAPI($readSupport["username"], 80); ?>" class="img-xs rounded-circle" alt="avatar">
            <div class="content">
              <div class="message">
                <div class="bubble">
                  <p><?php echo $readSupport["message"]; ?></p>
                </div>
                <span><?php echo checkTime($readSupport["date"]); ?> <?php echo str_replace("&username", "<a href=\"".urlConverter("admin_player", $languageType)."/".$readSupport["username"]."\" target=\"_blank\">".$readSupport["username"]."</a> ", languageVariables("supportMessageFooter", "support", $languageType)); ?></span>
              </div>
            </div>
          </li>
          <?php $searchSupportMessage = $db->prepare("SELECT * FROM supportReply WHERE supportID = ? ORDER BY id ASC"); ?>
          <?php $searchSupportMessage->execute(array($readSupport["id"])); ?>
          <?php foreach($searchSupportMessage as $readSupportMessage) { ?>
          <?php
          if ($readSupportMessage["type"] == 0) {
            $readSupportMessage["message"] = $readSupportMessage["message"];
          } else {
            $values = array($readAccount["username"], $readSupportMessage["message"], $rSettings["serverName"], $readSupportMessage["username"], $rSettings["IPAdres"]);
            $textvalues = array("[username]", "[message]", "[serverName]", "[admin]", "[serverIP]");
            $readSupportMessage["message"] = str_replace($textvalues, $values, $rSettings['supportMessageTemplate']);
          }
          ?>
          <li class="message-item <?php if ($readSupportMessage["type"] == 0) { echo "friend"; } else { echo "me"; } ?>">
            <img src="<?php echo avatarAPI($readSupport["username"], 80); ?>" class="img-xs rounded-circle" alt="avatar">
            <div class="content">
              <div class="message">
                <div class="bubble">
                  <?php echo $readSupportMessage["message"]; ?>
                </div>
                <span><?php echo checkTime($readSupportMessage["date"]); ?> <?php echo str_replace("&username", "<a href=\"".urlConverter("admin_player", $languageType)."/".$readSupportMessage["username"]."\" target=\"_blank\">".$readSupportMessage["username"]."</a> ", languageVariables("supportMessageFooter", "support", $languageType)); ?></span>
              </div>
            </div>
          </li>
          <?php } ?>
          </ul>
        </div>
        <div class="card-footer">
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["sendMessage"])) {
            if ($safeCsrfToken->validate('sendMessageToken')) {
              if (post("message") !== "") {
                $insertMessage = $db->prepare("INSERT INTO supportReply SET message = ?, username = ?, supportID = ?, type = ?, date = ?");
                $insertMessage->execute(array($_POST["message"], $readAccount["username"], $readSupport["id"], 1, date("d.m.Y H:i:s")));
                $updateSupport = $db->prepare("UPDATE supportList SET status = ? WHERE id = ?");
                $updateSupport->execute(array(1, $readSupport["id"]));
                echo alert(languageVariables("alertMessageSendSuccess", "support", $languageType), "success", "3", "");
              } else {
                echo alert(languageVariables("alertNone", "support", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "support", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form action="" method="POST">
            <div class="mb-3">
              <select class="form-control" data-toggle="answerSelect" data-minimum-results-for-search="-1">
                <option value="" selected><?php echo languageVariables("supportReadyAnswerSelect", "support", $languageType); ?></option>
                <?php $searchAnswer = $db->query("SELECT * FROM supportReadyAnswers ORDER BY id DESC"); ?>
                <?php foreach($searchAnswer as $readAnswer) { ?>
                <option value="<?php echo str_replace('"', "'", $readAnswer["content"]); ?>"><?php echo $readAnswer["title"]; ?></option>
                <?php } ?>
              </select>
            </div>
            <textarea message-id="textareaAnswer" id="messageTextarea" class="form-control ckeditor" name="message" placeholder="<?php echo languageVariables("supportMessagePlaceholder", "support", $languageType); ?>"></textarea>
            <br>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("sendMessageToken"); ?>
              <button type="submit" class="btn btn-primary btn-icon mr-2" name="sendMessage" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("send", "words", $languageType); ?>"><i data-feather="send"></i></button>
              <button type="button" class="btn btn-secondary btn-icon mr-2" confirm-element="confirm" confirm-text="<?php echo languageVariables("closedAreYouSure", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_close", $languageType); ?>/<?php echo $readSupport["id"]; ?>/5" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("close", "words", $languageType); ?>"><i data-feather="x"></i></button>
              <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_support_delete", $languageType); ?>/<?php echo $readSupport["id"]; ?>/5" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php } else { go(urlConverter("admin_support_all", $languageType)); } ?>
  <?php } else if (get("target") == "close" && isset($_GET["supportID"]) && isset($_GET["returnUrl"])) { ?>
  <?php
  $searchSupport = $db->prepare("SELECT * FROM supportList WHERE id = ? AND (status = ? OR status = ?)");
  $searchSupport->execute(array(get("supportID"), 0, 1));
  if (mysqlCount($searchSupport) > 0) {
    $readSupport = fetch($searchSupport);
    $updateSupport = $db->prepare("UPDATE supportList SET status = ? WHERE id = ?");
    $updateSupport->execute(array(2, $readSupport["id"]));
    $closeStatus = true;
  } else {
    $closeStatus = false;
  }
  if (get("returnUrl") == 0) {
    go(urlConverter("admin_support_all", $languageType));
  } else if (get("returnUrl") == 1) {
    go(urlConverter("admin_support_not_replys", $languageType));
  } else if (get("returnUrl") == 2) {
    go(urlConverter("admin_support_replys", $languageType));
  } else if (get("returnUrl") == 3) {
    go(urlConverter("admin_support_closed", $languageType));
  } else if ($closeStatus == true) {
    go(urlConverter("admin_support_view", $languageType)."/".$readSupport["id"]);
  } else {
    go(urlConverter("admin_support_all", $languageType));
  }
  ?>
  <?php } else if (get("target") == "remove" && isset($_GET["supportID"]) && isset($_GET["returnUrl"])) { ?>
  <?php
  $searchSupport = $db->prepare("SELECT * FROM supportList WHERE id = ?");
  $searchSupport->execute(array(get("supportID")));
  if (mysqlCount($searchSupport) > 0) {
    $readSupport = fetch($searchSupport);
    $deleteSupport = $db->prepare("DELETE FROM supportList WHERE id = ?");
    $deleteSupport->execute(array($readSupport["id"]));
  }
  if (get("returnUrl") == 0) {
    go(urlConverter("admin_support_all", $languageType));
  } else if (get("returnUrl") == 1) {
    go(urlConverter("admin_support_not_replys", $languageType));
  } else if (get("returnUrl") == 2) {
    go(urlConverter("admin_support_replys", $languageType));
  } else if (get("returnUrl") == 3) {
    go(urlConverter("admin_support_closed", $languageType));
  } else {
    go(urlConverter("admin_support_all", $languageType));
  }
  ?>
  <?php } ?>
<?php } ?>