<?php if (AccountPermControl($readAccount["id"], "forum") == "PERMISSION_NOT_FOUND") { go(urlConverter("admin_perm_error", $languageType)); } ?>
<?php if (get("action") == "topics") { ?>
  <?php if (get("target") == "update") { ?>
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
      $pageItemCount = pageItemCount("forumTopic", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchForumTopic = $db->query("SELECT * FROM forumTopic ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("forum", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_forum_topics", $languageType); ?>"><?php echo languageVariables("topics", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_topics_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_topics_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_topics_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchForumTopic) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["topicID", "topicTitle", "topicAuthor", "category", "subCategory", "status", "views", "messages", "date"]'>
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
              
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="topicID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicAuthor"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="category"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="subCategory"><?php echo languageVariables("subCategory", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="status"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="views"><?php echo languageVariables("views", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="messages"><?php echo languageVariables("comments", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="date"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchForumTopic as $readForumTopic) { ?>
                <?php $searchForumTopicSubCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?"); ?>
                <?php $searchForumTopicSubCategory->execute(array($readForumTopic["categoryID"])); ?>
                <?php $readForumTopicSubCategory = $searchForumTopicSubCategory->fetch(); ?>
                <?php $searchForumTopicCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?"); ?>
                <?php $searchForumTopicCategory->execute(array($readForumTopicSubCategory["categoryID"])); ?>
                <?php $readForumTopicCategory = $searchForumTopicCategory->fetch(); ?>
                <?php $searchForumTopicMessages = $db->prepare("SELECT id FROM forumMessage WHERE topicID = ?"); ?>
                <?php $searchForumTopicMessages->execute(array($readForumTopic["id"])); ?>
                <tr>
                  <td class="topicID text-center" style="width: 40px;"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>">#<?php echo $readForumTopic["id"]; ?></a></td>
                  <td class="topicTitle text-center"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>"><?php echo $readForumTopic["title"]; ?></a></td>
                  <td class="topicAuthor text-center"><?php echo $readForumTopic["author"]; ?></td>
                  <td class="category text-center"><?php echo $readForumTopicCategory["title"]; ?></td>
                  <td class="subCategory text-center"><?php echo $readForumTopicSubCategory["title"]; ?></td>
                  <td class="status text-center"><?php echo (($readForumTopic["status"] == "0") ? languageVariables("topicStatus0", "words", $languageType) : (($readForumTopic["status"] == "1") ? languageVariables("topicStatus1", "words", $languageType) : (($readForumTopic["status"] == "2") ? languageVariables("topicStatus2", "words", $languageType) : languageVariables("topicStatus3", "words", $languageType)))); ?></td>
                  <td class="views text-center"><?php echo $readForumTopic["views"]; ?></td>
                  <td class="messages text-center"><?php echo $searchForumTopicMessages->rowCount(); ?></td>
                  <td class="date text-center"><?php echo checkTime($readForumTopic["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-info btn-icon" direct-element="direct" direct-href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
                    <?php if ($readForumTopic["pinned"] == "0") { ?>
                    <button type="button" class="btn btn-primary btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicPinnedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/7/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("pinned", "words", $languageType); ?>"><i data-feather="plus"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemovePinnedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/8/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removePinned", "words", $languageType); ?>"><i data-feather="minus"></i></button>
                    <?php } ?>
                    <?php if ($readForumTopic["commentStatus"] == "0") { ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("commentsHiddenAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/9/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("commentsHidden", "words", $languageType); ?>"><i data-feather="slash"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("commentsUnHiddenAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/10/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("commentsUnHidden", "words", $languageType); ?>"><i data-feather="disc"></i></button>
                    <?php } ?>
                    <?php if ($readForumTopic["status"] == "0") { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicCheckAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/1/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("check", "words", $languageType); ?>"><i data-feather="check"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemoveAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/5/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removeTopic", "words", $languageType); ?>"><i data-feather="shield-off"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/0/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } else if ($readForumTopic["status"] == "1") { ?>
                    <button type="button" class="btn btn-warning btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicUnCheckAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/2/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("uncheck", "words", $languageType); ?>"><i data-feather="x"></i></button>
                    <button type="button" class="btn btn-dark btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicLockAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/3/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("lock", "words", $languageType); ?>"><i data-feather="lock"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemoveAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/5/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removeTopic", "words", $languageType); ?>"><i data-feather="shield-off"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/0/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } else if ($readForumTopic["status"] == "2") { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemoveLockAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/4/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removeLock", "words", $languageType); ?>"><i data-feather="unlock"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemoveAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/5/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removeTopic", "words", $languageType); ?>"><i data-feather="shield-off"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/0/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicReleasedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/6/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("releaseTopic", "words", $languageType); ?>"><i data-feather="shield"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/0/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "forum", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "proccess") { ?>
    <?php
      if (get("proccess") == "0") {
        $removeTopic = $db->prepare("DELETE FROM forumTopic WHERE id = ?");
        $removeTopic->execute(array(get("id")));
        $removeTopicMessage = $db->prepare("DELETE FROM forumMessage WHERE topicID = ?");
        $removeTopicMessage->execute(array(get("id")));
      } else if (get("proccess") == "1") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET status = ? WHERE id = ?");
        $removeTopic->execute(array(1, get("id")));
      } else if (get("proccess") == "2") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET status = ? WHERE id = ?");
        $removeTopic->execute(array(0, get("id")));
      } else if (get("proccess") == "3") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET status = ? WHERE id = ?");
        $removeTopic->execute(array(2, get("id")));
      } else if (get("proccess") == "4") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET status = ? WHERE id = ?");
        $removeTopic->execute(array(1, get("id")));
      } else if (get("proccess") == "5") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET status = ? WHERE id = ?");
        $removeTopic->execute(array(3, get("id")));
      } else if (get("proccess") == "6") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET status = ? WHERE id = ?");
        $removeTopic->execute(array(1, get("id")));
      } else if (get("proccess") == "7") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET pinned = ? WHERE id = ?");
        $removeTopic->execute(array(1, get("id")));
      } else if (get("proccess") == "8") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET pinned = ? WHERE id = ?");
        $removeTopic->execute(array(0, get("id")));
      } else if (get("proccess") == "9") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET commentStatus = ? WHERE id = ?");
        $removeTopic->execute(array(1, get("id")));
      } else if (get("proccess") == "10") {
        $removeTopic = $db->prepare("UPDATE forumTopic SET commentStatus = ? WHERE id = ?");
        $removeTopic->execute(array(0, get("id")));
      }
      go(urlConverter("admin_forum_topics", $languageType));
    ?>
  <?php } ?>
<?php } else if (get("action") == "category") { ?>
  <?php if (get("target") == "add") { ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("forum", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/0"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("add", "words", $languageType); ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("add", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["addCategory"])) {
            if ($safeCsrfToken->validate('addCategoryToken')) {
              if (post("categoryTitle") !== "" && post("categoryText") !== "") {
                if ($_FILES["categoryImage"]["size"] !== null) {
                  if (post("categoryType") == "0") {
                    $imageUpload = imageUpload($_FILES["categoryImage"], "/assets/uploads/images/forum/");
                    if ($imageUpload !== false) {
                      $insertCategory = $db->prepare("INSERT INTO forumCategory (`title`, `text`, `image`, `author`, `date`) VALUES (?, ?, ?, ?, ?)");
                      $insertCategory->execute(array(post("categoryTitle"), post("categoryText"), "/assets/uploads/images/forum/".$imageUpload["name"], $readAccount["username"], date("d.m.Y H:i:s")));
                      echo alert(languageVariables("alertTopCategoryAddSuccess", "forum", $languageType), "success", "3", urlConverter("admin_forum_category", $languageType)."/0");
                    } else {
                      echo alert(languageVariables("alertImageUpload", "forum", $languageType), "danger", "0", "/");
                    }
                  } else {
                    $searchForumCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?");
                    $searchForumCategory->execute(array(post("categoryID")));
                    if ($searchForumCategory->rowCount() > 0) {
                      $readForumCategory = $searchForumCategory->fetch();
                      $imageUpload = imageUpload($_FILES["categoryImage"], "/assets/uploads/images/forum/");
                      if ($imageUpload !== false) {
                        $insertCategory = $db->prepare("INSERT INTO forumSubCategory (`categoryID`, `topicStatus`, `title`, `text`, `image`, `author`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $insertCategory->execute(array($readForumCategory["id"], post("topicType"), post("categoryTitle"), post("categoryText"), "/assets/uploads/images/forum/".$imageUpload["name"], $readAccount["username"], date("d.m.Y H:i:s")));
                        echo alert(languageVariables("alertSubCategoryAddSuccess", "forum", $languageType), "success", "3", urlConverter("admin_forum_category", $languageType)."/1");
                      } else {
                        echo alert(languageVariables("alertImageUpload", "forum", $languageType), "danger", "0", "/");
                      }
                    } else {
                      echo alert(languageVariables("alertSelectTopCategory", "forum", $languageType), "warning", "0", "/");
                    }
                  }
                } else {
                  echo alert(languageVariables("alertImage", "forum", $languageType), "warning", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "forum", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "forum", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="support-forum-title" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryTitle", "forum", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="forum-category-title" name="categoryTitle" placeholder="<?php echo languageVariables("pleaseEnterTitle", "forum", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="support-forum-text" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryDesc", "forum", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="forum-category-text" name="categoryText" placeholder="<?php echo languageVariables("pleaseEnterDesc", "forum", $languageType); ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="support-forum-text" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryType", "forum", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" data-toggle="categoryType" name="categoryType">
                  <option value="0" selected><?php echo languageVariables("topCategory", "words", $languageType); ?></option>
                  <option value="1" ><?php echo languageVariables("subCategory", "words", $languageType); ?></option>
                </select>
              </div>
            </div>
            <div style="display: none;" data-toggle="categoryTypeSelect">
              <div class="form-group row">
                <label for="support-forum-text" class="col-sm-3 col-form-label"><?php echo languageVariables("topCategory", "forum", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" name="categoryID">
                    <?php $searchXCategory = $db->query("SELECT * FROM forumCategory ORDER BY id ASC"); ?>
                    <?php if ($searchXCategory->rowCount() > 0) { ?>
                    <?php foreach ($searchXCategory as $readXCategory) { ?>
                    <option value="<?php echo $readXCategory["id"]; ?>" selected><?php echo $readXCategory["title"]; ?></option>
                    <?php } ?>
                    <?php } else { ?>
                    <option value="0" selected><?php echo languageVariables("topCategorySelect", "forum", $languageType); ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="support-forum-text" class="col-sm-3 col-form-label"><?php echo languageVariables("topicType", "forum", $languageType); ?></label>
                <div class="col-sm-9">
                  <select class="form-control" name="topicType">
                    <option value="0" selected><?php echo languageVariables("topicTypeOption0", "forum", $languageType); ?></option>
                    <option value="1" ><?php echo languageVariables("topicTypeOption1", "forum", $languageType); ?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="forum-category-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "words", $languageType); ?>:</label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage">
                  <div class="di-thumbnail">
                    <img src="" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="forum-category-image"><?php echo languageVariables("imagePlaceholder", "words", $languageType); ?></label>
                    <input type="file" id="forum-category-image" name="categoryImage" accept="image/*">
                  </div>
                </div>
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
        if (get("categoryType") == "0") {
          $searchXForumCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?");
          $searchXForumCategory->execute(array(get("categoryID")));
        } else {
          $searchXForumCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?");
          $searchXForumCategory->execute(array(get("categoryID")));
        }
        if ($searchXForumCategory->rowCount() == 0) {
          go(urlConverter("admin_forum_category", $languageType));
        }
        $readXForumCategory = $searchXForumCategory->fetch();
      ?>
<div class="page-content">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("forum", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/<?php echo get("categoryType"); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $readXForumCategory["id"]."#".$readXForumCategory["title"]; ?></li>
    </ol>
  </nav>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo languageVariables("edit", "words", $languageType); ?></h6>
          <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["editCategory"])) {
            if ($safeCsrfToken->validate('editCategoryToken')) {
              if (post("categoryTitle") !== "" && post("categoryText") !== "") {
                if (get("categoryType") == "0") {
                  $imageUploadStatus = "__SUCCESS__";
                  if ($_FILES["categoryImage"]["name"] != null) {
                    $imageUpload = imageUpload($_FILES["categoryImage"], "/assets/uploads/images/forum/");
                    if ($imageUpload !== false) {
                      $updateCategoryImage = $db->prepare("UPDATE forumCategory SET image = ? WHERE id = ?");
                      $updateCategoryImage->execute(array("/assets/uploads/images/forum/".$imageUpload["name"], $readXForumCategory["id"]));
                    } else {
                      $imageUploadStatus = "__UNSUCCESS__";
                    }
                  }
                  if ($imageUploadStatus == "__SUCCESS__") {
                    $updatexCategory = $db->prepare("UPDATE forumCategory SET title = ?, text = ? WHERE id = ?");
                    $updatexCategory->execute(array(post("categoryTitle"), post("categoryText"), $readXForumCategory["id"]));
                    echo alert(languageVariables("alertCategoryEditSuccess", "forum", $languageType), "success", "3", "");
                  } else {
                    echo alert(languageVariables("alertImageUpload", "forum", $languageType), "danger", "0", "/");
                  }
                } else {
                  $imageUploadStatus = "__SUCCESS__";
                  if ($_FILES["categoryImage"]["name"] != null) {
                    $imageUpload = imageUpload($_FILES["categoryImage"], "/assets/uploads/images/forum/");
                    if ($imageUpload !== false) {
                      $updateCategoryImage = $db->prepare("UPDATE forumCategory SET image = ? WHERE id = ?");
                      $updateCategoryImage->execute(array("/assets/uploads/images/forum/".$imageUpload["name"], $readXForumCategory["id"]));
                    } else {
                      $imageUploadStatus = "__UNSUCCESS__";
                    }
                  }
                  if ($imageUploadStatus == "__SUCCESS__") {
                    $searchForumCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?");
                    $searchForumCategory->execute(array(post("categoryID")));
                    if ($searchForumCategory->rowCount() > 0) {
                      $readForumCategory = $searchForumCategory->fetch();
                      $updatexCategory = $db->prepare("UPDATE forumSubCategory SET title = ?, text = ?, topicStatus = ?, categoryID = ? WHERE id = ?");
                      $updatexCategory->execute(array(post("categoryTitle"), post("categoryText"), post("categoryType"), $readForumCategory["id"], $readXForumCategory["id"]));
                      echo alert(languageVariables("alertCategoryEditSuccess", "forum", $languageType), "success", "3", "");
                    } else {
                      echo alert(languageVariables("alertSelectTopCategory", "forum", $languageType), "warning", "0", "/");
                    }
                  } else {
                    echo alert(languageVariables("alertImageUpload", "forum", $languageType), "danger", "0", "/");
                  }
                }
              } else {
                echo alert(languageVariables("alertNone", "forum", $languageType), "warning", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "forum", $languageType), "danger", "0", "/");
            }
          }
          ?>
          <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="support-forum-title" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryTitle", "forum", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="forum-category-title" name="categoryTitle" placeholder="<?php echo languageVariables("pleaseEnterTitle", "forum", $languageType); ?>" value="<?php echo $readXForumCategory["title"]; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="support-forum-text" class="col-sm-3 col-form-label"><?php echo languageVariables("categoryDesc", "forum", $languageType); ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="forum-category-text" name="categoryText" placeholder="<?php echo languageVariables("pleaseEnterDesc", "forum", $languageType); ?>" value="<?php echo $readXForumCategory["text"]; ?>">
              </div>
            </div>
            <?php if (get("categoryType") == "1") { ?>
            <div class="form-group row">
              <label for="support-forum-text" class="col-sm-3 col-form-label"><?php echo languageVariables("topCategory", "forum", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" name="categoryID">
                  <?php $searchXCategory = $db->query("SELECT * FROM forumCategory ORDER BY id ASC"); ?>
                  <?php if ($searchXCategory->rowCount() > 0) { ?>
                  <?php foreach ($searchXCategory as $readXCategory) { ?>
                  <option value="<?php echo $readXCategory["id"]; ?>" <?php echo (($readXForumCategory["categoryID"] == $readXCategory["id"]) ? "selected" : ""); ?>><?php echo $readXCategory["title"]; ?></option>
                  <?php } ?>
                  <?php } else { ?>
                  <option value="0" selected><?php echo languageVariables("topCategorySelect", "forum", $languageType); ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="support-forum-text" class="col-sm-3 col-form-label"><?php echo languageVariables("topicType", "forum", $languageType); ?></label>
              <div class="col-sm-9">
                <select class="form-control" name="topicType">
                  <option value="0" <?php echo (($readXForumCategory["topicStatus"] == "0") ? "selected" : ""); ?>><?php echo languageVariables("topicTypeOption0", "forum", $languageType); ?></option>
                  <option value="1" <?php echo (($readXForumCategory["topicStatus"] == "1") ? "selected" : ""); ?>><?php echo languageVariables("topicTypeOption1", "forum", $languageType); ?></option>
                </select>
              </div>
            </div>
            <?php } ?>
            <div class="form-group row">
              <label for="forum-category-image" class="col-sm-3 col-form-label"><?php echo languageVariables("image", "words", $languageType); ?>:</label>
              <div class="col-sm-9">
                <div data-toggle="dropimage" class="dropimage active">
                  <div class="di-thumbnail">
                    <img src="<?php echo $readXForumCategory["image"]; ?>" alt="<?php echo languageVariables("preview", "words", $languageType); ?>">
                  </div>
                  <div class="di-select">
                    <label for="forum-category-image"><?php echo languageVariables("imagePlaceholder", "words", $languageType); ?></label>
                    <input type="file" id="forum-category-image" name="categoryImage" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div style="float: right;">
              <?php echo $safeCsrfToken->input("editCategoryToken"); ?>
              <button type="submit" class="btn btn-success mr-2" name="editCategory"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
    <?php } else { ?>
      <?php 
      if (get("categoryType") == "0") {
        $tableName = "forumCategory";
      } else {
        $tableName = "forumSubCategory";
      }
      if (isset($_GET["pageNumber"])) {
        if (!is_numeric(get("pageNumber"))) {
          $_GET["pageNumber"] = 1;
        }
        $pageNumber = intval(get("pageNumber"));
      } else {
        $pageNumber = 1;
      }

      $pageSubCount = 50;
      $pageItemCount = pageItemCount($tableName, $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchCategories = $db->query("SELECT * FROM $tableName ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("forum", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/<?php echo get("categoryType"); ?>"><?php echo languageVariables("category", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("edit", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_category_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_category_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_category_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchCategories) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["categoriesID", "categoriesTitle", <?php echo ((get("categoryType") == "1") ? "\"topCategory\", " : ""); ?>"author", "date"]'>
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
              <a class="btn btn-sm btn-primary" href="<?php echo urlConverter("admin_forum_category_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <?php if (get("categoryType") == "0") { ?>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="categoriesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="categoriesTitle"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="author"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="date"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCategories as $readCategory) { ?>
                <tr>
                  <td class="categoriesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/0/<?php echo $readCategory["id"]; ?>">#<?php echo $readCategory["id"]; ?></a></td>
                  <td class="categoriesTitle text-center"><a href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/0/<?php echo $readCategory["id"]; ?>"><?php echo $readCategory["title"]; ?></a></td>
                  <td class="author text-center"><?php echo $readCategory["author"]; ?></td>
                  <td class="date text-center"><?php echo checkTime($readCategory["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/0/<?php echo $readCategory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_category_delete", $languageType); ?>/0/<?php echo $readCategory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
          <?php } else { ?>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="categoriesID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="categoriesTitle"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topCategory">Üst Kategori</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="author"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="date"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchCategories as $readCategory) { ?>
                <?php $searchTopCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?"); ?>
                <?php $searchTopCategory->execute(array($readCategory["categoryID"])); ?>
                <?php $readTopCategory = $searchTopCategory->fetch(); ?>
                <tr>
                  <td class="categoriesID text-center" style="width: 40px;"><a href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/1/<?php echo $readCategory["id"]; ?>">#<?php echo $readCategory["id"]; ?></a></td>
                  <td class="categoriesTitle text-center"><a href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/1/<?php echo $readCategory["id"]; ?>"><?php echo $readCategory["title"]; ?></a></td>
                  <td class="topCategory text-center"><?php echo $readTopCategory["title"]; ?></td>
                  <td class="author text-center"><?php echo $readCategory["author"]; ?></td>
                  <td class="date text-center"><?php echo checkTime($readCategory["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-success btn-icon" direct-element="direct" direct-href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/1/<?php echo $readCategory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("edit", "words", $languageType); ?>"><i data-feather="edit-2"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_category_delete", $languageType); ?>/1/<?php echo $readCategory["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
          <?php } ?>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "forum", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
    <?php } ?>
  <?php } else if (get("target") == "remove") { ?>
    <?php if (isset($_GET["categoryID"])) { ?>
      <?php
        if (get("categoryType") == "0") {
          $removeCategory = $db->prepare("DELETE FROM forumCategory WHERE id = ?");
          $removeCategory->execute(array(get("categoryID")));
          go(urlConverter("admin_forum_category", $languageType)."/0");
        } else {
          $removeCategory = $db->prepare("DELETE FROM forumSubCategory WHERE id = ?");
          $removeCategory->execute(array(get("categoryID")));
          go(urlConverter("admin_forum_category", $languageType)."/1");
        }
      ?>
    <?php } else { ?>
      <?php go(urlConverter("admin_forum_category", $languageType)); ?>
    <?php } ?>
  <?php } ?>
<?php } else if (get("action") == "reports") { ?>
  <?php if (get("target") == "message") { ?>
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
      $pageItemCount = pageItemCount("forumReport WHERE reportType = 'message'", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchForumReport = $db->query("SELECT * FROM forumReport WHERE reportType = 'message' ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("forum", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_forum_reports_topic", $languageType); ?>"><?php echo languageVariables("reports", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("message", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_reports_topic_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_reports_topic_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_reports_topic_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchForumReport) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["topicID", "topicTitle", "topicAuthor", "category", "subCategory", "message", "reason", "status", "date"]'>
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
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="topicID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicAuthor"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="category"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="subCategory"><?php echo languageVariables("subCategory", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="message"><?php echo languageVariables("message", "words", $languageType); ?> ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="reason"><?php echo languageVariables("reason", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="status"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="date"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchForumReport as $readForumReport) { ?>
                <?php $saerchForumMessage = $db->prepare("SELECT * FROM forumMessage WHERE id = ?"); ?>
                <?php $saerchForumMessage->execute(array($readForumReport["messageID"])); ?>
                <?php $readForumMessage = $saerchForumMessage->fetch(); ?>
                <?php $saerchForumTopic = $db->prepare("SELECT * FROM forumTopic WHERE id = ?"); ?>
                <?php $saerchForumTopic->execute(array($readForumMessage["topicID"])); ?>
                <?php $readForumTopic = $saerchForumTopic->fetch(); ?>
                <?php $searchForumTopicSubCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?"); ?>
                <?php $searchForumTopicSubCategory->execute(array($readForumTopic["categoryID"])); ?>
                <?php $readForumTopicSubCategory = $searchForumTopicSubCategory->fetch(); ?>
                <?php $searchForumTopicCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?"); ?>
                <?php $searchForumTopicCategory->execute(array($readForumTopicSubCategory["categoryID"])); ?>
                <?php $readForumTopicCategory = $searchForumTopicCategory->fetch(); ?>
                <tr>
                  <td class="topicID text-center" style="width: 40px;"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" target="_blank">#<?php echo $readForumTopic["id"]; ?></a></td>
                  <td class="topicTitle text-center"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" target="_blank"><?php echo $readForumTopic["title"]; ?></a></td>
                  <td class="topicAuthor text-center"><?php echo $readForumTopic["author"]; ?></td>
                  <td class="category text-center"><?php echo $readForumTopicCategory["title"]; ?></td>
                  <td class="subCategory text-center"><?php echo $readForumTopicSubCategory["title"]; ?></td>
                  <td class="message text-center"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]."#".$readForumMessage["id"]; ?>" target="_blank"><?php echo "#".$readForumMessage["id"]; ?></a></td>
                  <td class="reason text-center"><?php echo $readForumReport["message"]; ?></td>
                  <td class="status text-center"><?php echo (($readForumReport["status"] == "0") ? languageVariables("notSolved", "words", $languageType) : languageVariables("solved", "words", $languageType)); ?></td>
                  <td class="date text-center"><?php echo checkTime($readForumTopic["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-info btn-icon" direct-element="direct" direct-href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]."#".$readForumMessage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
                    <?php if ($readForumReport["status"] == "0") { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("reportSolvedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_reports_proccess", $languageType); ?>/3/<?php echo $readForumReport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("check", "words", $languageType); ?>"><i data-feather="check"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_reports_proccess", $languageType); ?>/2/<?php echo $readForumReport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_reports_proccess", $languageType); ?>/2/<?php echo $readForumReport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "forum", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "topic") { ?>
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
      $pageItemCount = pageItemCount("forumReport WHERE reportType = 'topic'", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchForumReport = $db->query("SELECT * FROM forumReport WHERE reportType = 'topic' ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("forum", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_forum_reports_topic", $languageType); ?>"><?php echo languageVariables("reports", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("topics", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_reports_topic_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_reports_topic_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_reports_topic_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchForumReport) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["topicID", "topicTitle", "topicAuthor", "category", "subCategory", "reason", "status", "date"]'>
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
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="topicID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicAuthor"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="category"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="subCategory"><?php echo languageVariables("subCategory", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="reason"><?php echo languageVariables("reason", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="status"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="date"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchForumReport as $readForumReport) { ?>
                <?php $saerchForumTopic = $db->prepare("SELECT * FROM forumTopic WHERE id = ?"); ?>
                <?php $saerchForumTopic->execute(array($readForumReport["messageID"])); ?>
                <?php $readForumTopic = $saerchForumTopic->fetch(); ?>
                <?php $searchForumTopicSubCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?"); ?>
                <?php $searchForumTopicSubCategory->execute(array($readForumTopic["categoryID"])); ?>
                <?php $readForumTopicSubCategory = $searchForumTopicSubCategory->fetch(); ?>
                <?php $searchForumTopicCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?"); ?>
                <?php $searchForumTopicCategory->execute(array($readForumTopicSubCategory["categoryID"])); ?>
                <?php $readForumTopicCategory = $searchForumTopicCategory->fetch(); ?>
                <tr>
                  <td class="topicID text-center" style="width: 40px;"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>">#<?php echo $readForumTopic["id"]; ?></a></td>
                  <td class="topicTitle text-center"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>"><?php echo $readForumTopic["title"]; ?></a></td>
                  <td class="topicAuthor text-center"><?php echo $readForumTopic["author"]; ?></td>
                  <td class="category text-center"><?php echo $readForumTopicCategory["title"]; ?></td>
                  <td class="subCategory text-center"><?php echo $readForumTopicSubCategory["title"]; ?></td>
                  <td class="reason text-center"><?php echo $readForumReport["message"]; ?></td>
                  <td class="status text-center"><?php echo (($readForumReport["status"] == "0") ? languageVariables("notSolved", "words", $languageType) : languageVariables("solved", "words", $languageType)); ?></td>
                  <td class="date text-center"><?php echo checkTime($readForumTopic["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-info btn-icon" direct-element="direct" direct-href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
                    <?php if ($readForumReport["status"] == "0") { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("reportSolvedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_reports_proccess", $languageType); ?>/1/<?php echo $readForumReport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("check", "words", $languageType); ?>"><i data-feather="check"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_reports_proccess", $languageType); ?>/0/<?php echo $readForumReport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_reports_proccess", $languageType); ?>/0/<?php echo $readForumReport["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "forum", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "proccess") { ?>
    <?php
      if (get("proccess") == "0") {
        $removeTopic = $db->prepare("DELETE FROM forumReport WHERE id = ?");
        $removeTopic->execute(array(get("id")));
        go(urlConverter("admin_forum_reports_topic", $languageType));
      } else if (get("proccess") == "1") {
        $removeTopic = $db->prepare("UPDATE forumReport SET status = ? WHERE id = ?");
        $removeTopic->execute(array(1, get("id")));
        go(urlConverter("admin_forum_reports_topic", $languageType));
      } else if (get("proccess") == "2") {
        $removeTopic = $db->prepare("DELETE FROM forumReport WHERE id = ?");
        $removeTopic->execute(array(get("id")));
        go(urlConverter("admin_forum_reports_message", $languageType));
      } else if (get("proccess") == "3") {
        $removeTopic = $db->prepare("UPDATE forumReport SET status = ? WHERE id = ?");
        $removeTopic->execute(array(1, get("id")));
        go(urlConverter("admin_forum_reports_message", $languageType));
      }
    ?>
  <?php } ?>
<?php } else if (get("action") == "logs") { ?>
  <?php if (get("target") == "message") { ?>
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
      $pageItemCount = pageItemCount("forumMessage WHERE status = 3", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchForumMessage = $db->query("SELECT * FROM forumMessage WHERE status = 3 ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("forum", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_forum_topics", $languageType); ?>"><?php echo languageVariables("logs", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("message", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_logs_message_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_logs_message_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_logs_message_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchForumMessage) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["topicID", "topicTitle", "topicAuthor", "category", "subCategory", "message", "views", "date"]'>
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
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="topicID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicAuthor"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="category"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="subCategory"><?php echo languageVariables("subCategory", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="message"><?php echo languageVariables("message", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="views"><?php echo languageVariables("views", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="date"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchForumMessage as $readForumMessage) { ?>
                <?php $saerchForumTopic = $db->prepare("SELECT * FROM forumTopic WHERE id = ?"); ?>
                <?php $saerchForumTopic->execute(array($readForumMessage["topicID"])); ?>
                <?php $readForumTopic = $saerchForumTopic->fetch(); ?>
                <?php $searchForumTopicSubCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?"); ?>
                <?php $searchForumTopicSubCategory->execute(array($readForumTopic["categoryID"])); ?>
                <?php $readForumTopicSubCategory = $searchForumTopicSubCategory->fetch(); ?>
                <?php $searchForumTopicCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?"); ?>
                <?php $searchForumTopicCategory->execute(array($readForumTopicSubCategory["categoryID"])); ?>
                <?php $readForumTopicCategory = $searchForumTopicCategory->fetch(); ?>
                <tr>
                  <td class="topicID text-center" style="width: 40px;"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>">#<?php echo $readForumTopic["id"]; ?></a></td>
                  <td class="topicTitle text-center"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>"><?php echo $readForumTopic["title"]; ?></a></td>
                  <td class="topicAuthor text-center"><?php echo $readForumTopic["author"]; ?></td>
                  <td class="category text-center"><?php echo $readForumTopicCategory["title"]; ?></td>
                  <td class="subCategory text-center"><?php echo $readForumTopicSubCategory["title"]; ?></td>
                  <td class="views text-center"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]."#".$readForumMessage["id"]; ?>" target="_blank"><?php echo "#".$readForumMessage["id"]; ?></a></td>
                  <td class="views text-center"><?php echo $readForumTopic["views"]; ?></td>
                  <td class="date text-center"><?php echo checkTime($readForumTopic["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-info btn-icon" direct-element="direct" direct-href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
                    <?php if ($readForumTopic["status"] == "0") { ?>
                    <button type="button" class="btn btn-warning btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("messageRemoveAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_logs_proccess", $languageType); ?>/1/<?php echo $readForumMessage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="Mesajı Kaldır"><i data-feather="shield-off"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_logs_proccess", $languageType); ?>/0/<?php echo $readForumMessage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("messageReleaseAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_logs_proccess", $languageType); ?>/2/<?php echo $readForumMessage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("releaseTopic", "words", $languageType); ?>"><i data-feather="shield"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_logs_proccess", $languageType); ?>/0/<?php echo $readForumMessage["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "forum", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "topic") { ?>
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
      $pageItemCount = pageItemCount("forumTopic WHERE status = 3", $pageSubCount);

      if ($pageNumber > $pageItemCount) {
        $pageNumber = 1;
      }

      $queryPageItemCount = $pageNumber * $pageSubCount - $pageSubCount;
      $maxPageItemCount = 5;
    ?>
      <?php $searchForumTopic = $db->query("SELECT * FROM forumTopic WHERE status = 3 ORDER BY id DESC LIMIT $queryPageItemCount, $pageSubCount"); ?>
<div class="page-content">
  <div class="row">
    <div class="col">
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_home", $languageType); ?>"><?php echo languageVariables("dashboard", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="#"><?php echo languageVariables("forum", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo urlConverter("admin_forum_topics", $languageType); ?>"><?php echo languageVariables("logs", "words", $languageType); ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo languageVariables("topics", "words", $languageType); ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-auto">
      <nav aria-label="Page navigation example" style="floatt: right;">
        <ul class="pagination">
          <li class="page-item <?php echo (($pageNumber == "1") ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_logs_topic_p", $languageType)."/".($pageNumber-1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
          <?php 
            for ($i = $pageNumber - $maxPageItemCount; $i < $pageNumber + $maxPageItemCount + 1; $i++) {
					    if ($i > 0 && $i <= $pageItemCount) {
          ?>
          <li class="page-item <?php echo (($pageNumber == $i) ? "active" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_logs_topic_p", $languageType)."/".$i; ?>"><?php echo $i; ?></a></li>
          <?php } } ?>
          <li class="page-item <?php echo (($pageItemCount == $pageNumber) ? "disabled" : ""); ?>"><a class="page-link" href="<?php echo urlConverter("admin_forum_logs_topic_p", $languageType)."/".($pageNumber+1); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if (mysqlCount($searchForumTopic) > 0) { ?>
      <div class="card" data-toggle="lists" data-lists-values='["topicID", "topicTitle", "topicAuthor", "category", "subCategory", "status", "views", "messages", "date"]'>
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
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" style="width: 40px;"><a href="#" class="text-muted sort" data-sort="topicID">#ID</a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicTitle"><?php echo languageVariables("title", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="topicAuthor"><?php echo languageVariables("author", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="category"><?php echo languageVariables("category", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="subCategory"><?php echo languageVariables("subCategory", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="status"><?php echo languageVariables("status", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="views"><?php echo languageVariables("views", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="messages"><?php echo languageVariables("comments", "words", $languageType); ?></a></th>
                  <th class="text-center"><a href="#" class="text-muted sort" data-sort="date"><?php echo languageVariables("createDate", "words", $languageType); ?></a></th>
                  <th class="text-right">&nbsp;</th>
                </tr>
              </thead>
              <tbody class="list">
               <?php foreach ($searchForumTopic as $readForumTopic) { ?>
                <?php $searchForumTopicSubCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?"); ?>
                <?php $searchForumTopicSubCategory->execute(array($readForumTopic["categoryID"])); ?>
                <?php $readForumTopicSubCategory = $searchForumTopicSubCategory->fetch(); ?>
                <?php $searchForumTopicCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?"); ?>
                <?php $searchForumTopicCategory->execute(array($readForumTopicSubCategory["categoryID"])); ?>
                <?php $readForumTopicCategory = $searchForumTopicCategory->fetch(); ?>
                <?php $searchForumTopicMessages = $db->prepare("SELECT id FROM forumMessage WHERE topicID = ?"); ?>
                <?php $searchForumTopicMessages->execute(array($readForumTopic["id"])); ?>
                <tr>
                  <td class="topicID text-center" style="width: 40px;"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>">#<?php echo $readForumTopic["id"]; ?></a></td>
                  <td class="topicTitle text-center"><a href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>"><?php echo $readForumTopic["title"]; ?></a></td>
                  <td class="topicAuthor text-center"><?php echo $readForumTopic["author"]; ?></td>
                  <td class="category text-center"><?php echo $readForumTopicCategory["title"]; ?></td>
                  <td class="subCategory text-center"><?php echo $readForumTopicSubCategory["title"]; ?></td>
                  <td class="status text-center"><?php echo (($readForumTopic["status"] == "0") ? languageVariables("topicStatus0", "words", $languageType) : (($readForumTopic["status"] == "1") ? languageVariables("topicStatus1", "words", $languageType) : (($readForumTopic["status"] == "2") ? languageVariables("topicStatus2", "words", $languageType) : languageVariables("topicStatus3", "words", $languageType)))); ?></td>
                  <td class="views text-center"><?php echo $readForumTopic["views"]; ?></td>
                  <td class="messages text-center"><?php echo $searchForumTopicMessages->rowCount(); ?></td>
                  <td class="date text-center"><?php echo checkTime($readForumTopic["date"], 2, true); ?></td>
                  <td class="text-right">
                    <button type="button" class="btn btn-info btn-icon" direct-element="direct" direct-href="/forum/<?php echo createSlug($readForumTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("view", "words", $languageType); ?>"><i data-feather="eye"></i></button>
                    <?php if ($readForumTopic["pinned"] == "0") { ?>
                    <button type="button" class="btn btn-primary btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicPinnedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/7/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("pinned", "words", $languageType); ?>"><i data-feather="plus"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemovePinnedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/8/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removePinned", "words", $languageType); ?>"><i data-feather="minus"></i></button>
                    <?php } ?>
                    <?php if ($readForumTopic["status"] == "0") { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicCheckAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/1/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("check", "words", $languageType); ?>"><i data-feather="check"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemoveAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/5/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removeTopic", "words", $languageType); ?>"><i data-feather="shield-off"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/0/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } else if ($readForumTopic["status"] == "1") { ?>
                    <button type="button" class="btn btn-warning btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicUnCheckAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/2/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("uncheck", "words", $languageType); ?>"><i data-feather="x"></i></button>
                    <button type="button" class="btn btn-dark btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicLockAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/3/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("lock", "words", $languageType); ?>"><i data-feather="lock"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemoveAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/5/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removeTopic", "words", $languageType); ?>"><i data-feather="shield-off"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/0/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } else if ($readForumTopic["status"] == "2") { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemoveLockAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/4/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removeLock", "words", $languageType); ?>"><i data-feather="unlock"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicRemoveAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/5/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("removeTopic", "words", $languageType); ?>"><i data-feather="shield-off"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/0/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-success btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("topicReleasedAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/6/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("releaseTopic", "words", $languageType); ?>"><i data-feather="shield"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" confirm-element="confirm" confirm-text="<?php echo languageVariables("deleteAlert", "words", $languageType); ?>" direct-href="<?php echo urlConverter("admin_forum_topics_proccess", $languageType); ?>/0/<?php echo $readForumTopic["id"]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo languageVariables("remove", "words", $languageType); ?>"><i data-feather="trash-2"></i></button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php } else { echo alert(languageVariables("alertPageNone", "forum", $languageType), "danger", "0", "/"); } ?>
    </div>
  </div>
</div>
  <?php } else if (get("target") == "proccess") { ?>
    <?php
      if (get("proccess") == "0") {
        $removeTopic = $db->prepare("DELETE FROM forumMessage WHERE id = ?");
        $removeTopic->execute(array(get("id")));
      } else if (get("proccess") == "1") {
        $removeTopic = $db->prepare("UPDATE forumMessage SET status = ? WHERE id = ?");
        $removeTopic->execute(array(3, get("id")));
      } else if (get("proccess") == "2") {
        $removeTopic = $db->prepare("UPDATE forumMessage SET status = ? WHERE id = ?");
        $removeTopic->execute(array(0, get("id")));
      }
      go(urlConverter("admin_forum_logs_message", $languageType));
    ?>
  <?php } ?>
<?php } ?>