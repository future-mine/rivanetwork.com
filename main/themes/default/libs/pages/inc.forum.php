<?php if ($readModule["forumStatus"] == "0") { go("/"); } ?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/css/froala_editor.pkgd.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/css/froala_style.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/css/themes/dark.min.css">
<link rel="stylesheet" href="/main/themes/default/theme/assets/css/forum.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
<style type="text/css">
.forum-category-image {
  width: 90px !important;
}
</style>
<?php if (get("action") == "topic") { ?>
<?php if (isset($_GET["topicID"])) { ?>
<!-- FORUM TOPIC -->
<?php
      $searchForumTopic = $db->prepare("SELECT * FROM forumTopic WHERE id = ?");
      $searchForumTopic->execute(array(get("topicID")));
      if ($searchForumTopic->rowCount() > 0) {
        require_once(__DR__."/main/includes/packages/class/csrf/class.php");
        $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
        $readForumTopic = $searchForumTopic->fetch();
        if ($readAccount["username"] !== $readForumTopic["author"] && ($readForumTopic["status"] == "0" || $readForumTopic["status"] == "3") && AccountPermControl($readAccount["id"], "forum") == "PERMISSION_NOT_FOUND") {
          go(urlConverter("forum", $languageType));
        }
        $searchTopicSubCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?");
        $searchTopicSubCategory->execute(array($readForumTopic["categoryID"]));
        $readTopicSubCategory = $searchTopicSubCategory->fetch();
        $searchTopicCategory = $db->prepare("SELECT * FROM forumCategory WHERE id = ?");
        $searchTopicCategory->execute(array($readTopicSubCategory["categoryID"]));
        $readTopicCategory = $searchTopicCategory->fetch();
        $searchTopicAuthor = $db->prepare("SELECT * FROM accounts WHERE username = ?");
        $searchTopicAuthor->execute(array($readForumTopic["author"]));
        $readTopicAuthor = $searchTopicAuthor->fetch();
        $searchTopicAuthorPermission = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?");
        $searchTopicAuthorPermission->execute(array($readTopicAuthor["permission"]));
        $readTopicAuthorPermission = $searchTopicAuthorPermission->fetch();
        $searchTopicMessage = $db->prepare("SELECT * FROM forumMessage WHERE topicID = ?");
        $searchTopicMessage->execute(array($readForumTopic["id"]));
        if (!isset($_COOKIE["topic-".$readForumTopic["id"]])) {
          $updateTopicViews = $db->prepare("UPDATE forumTopic SET views = ? WHERE id = ?");
          $updateTopicViews->execute(array($readForumTopic["views"]+1, $readForumTopic["id"]));
          setcookie("topic-".$readForumTopic["id"], "view");
        }
    ?>
<div class="row md:p-10 mt-5 mb-10">
  <div class="col-md-12">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("forum", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum", $languageType); ?>/<?php echo createSlug($readTopicSubCategory["title"])."/".$readTopicSubCategory["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readTopicCategory["title"]; ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum", $languageType); ?>/<?php echo createSlug($readTopicSubCategory["title"])."/".$readTopicSubCategory["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readTopicSubCategory["title"]; ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum", $languageType); ?>/<?php echo createSlug($readTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readForumTopic["title"]; ?></a>
          </div>
        </li>
      </ol>
    </nav>
    <div class="forum-content mt-10">
      <div class="forum-post-list">
        <div class="forum-post">
          <div class="forum-post-meta">
            <p class="forum-post-timestamp"><?php echo "#".$readForumTopic["id"]; ?>  <i class="fas fa-clock mr-3 ml-3"></i><?php echo checkTime($readForumTopic["date"], 2, true); ?> <i class="fas fa-eye ml-3 mr-3"></i><?php echo $readForumTopic["views"]; ?><?php echo (($readForumTopic["status"] == "0") ? "<i class=\"fas fa-safe mr-3 ml-3\"></i>".languageVariables("topicStatus0", "forum", $languageType) : (($readForumTopic["status"] == "1") ? "<i class=\"fas fa-plus mr-3 ml-3\"></i>".languageVariables("topicStatus1", "forum", $languageType) : (($readForumTopic["status"] == "2") ? "<i class=\"fas fa-lock mr-3 ml-3\"></i>".languageVariables("topicStatus2", "forum", $languageType) : "<i class=\"fas fa-trash mr-3 ml-3\"></i>".languageVariables("topicStatus3", "forum", $languageType)))); ?></p>
            <div class="forum-post-actions">
              <?php if (isset($_SESSION["incAccountLogin"])) { ?>
              <p forum="report" type="topic" report-id="<?php echo $readForumTopic["id"]; ?>" class="forum-post-action light"><?php echo languageVariables("report", "words", $languageType); ?></p>
              <?php if ($readAccount["username"] == $readForumTopic["author"] || AccountPermControl($readAccount["id"], "forum") !== "PERMISSION_NOT_FOUND") { ?>
              <a href="<?php echo urlConverter("forum_topic_edit", $languageType)."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" class="forum-post-action"><?php echo languageVariables("edit", "words", $languageType); ?></a>
              <p forum="topicRemove" topic-id="<?php echo $readForumTopic["id"]; ?>" class="forum-post-action"><?php echo languageVariables("remove", "words", $languageType); ?></p>
              <?php } } ?>
            </div>
          </div>

          <div class="forum-post-content">
            <div class="forum-post-user">
              <a class="user-avatar no-outline" href="<?php echo urlConverter("player", $languageType)."/".$readTopicAuthor["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readTopicAuthor["username"]; ?>/100.png" width="100" alt="Avatar">
              </a>
              <p class="forum-post-user-title"><a href="<?php echo urlConverter("player", $languageType)."/".$readTopicAuthor["username"]; ?>"><?php echo $readTopicAuthor["username"]; ?></a></p>
              <p class="forum-post-user-tag" style="background-color: <?php echo $readTopicAuthorPermission["permColorBG"]; ?> !important; color: <?php echo $readTopicAuthorPermission["permColorText"]; ?> !important;"><?php echo $readTopicAuthorPermission["permName"]; ?></p>
              <div class="flex justify-end">
                <div class="flex gap-4 my-auto mx-auto md:mx-0 mt-5">
                <a class="icon bg-blue-500 bg-opacity-25 text-blue-500" target="_blank" href="<?php echo $readTopicAuthor["discord"]; ?>">
                    <i class="fab fa-discord"></i>
                  </a>
                  <a class="icon bg-teal-400 bg-opacity-25 text-teal-500" target="_blank" href="<?php echo $readTopicAuthor["skype"]; ?>">
                    <i class="fab fa-skype"></i>
                  </a>
                  <a class="icon bg-pink-400 bg-opacity-25 text-pink-500" target="_blank" href="<?php echo $readTopicAuthor["instagram"]; ?>">
                    <i class="fab fa-instagram"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="forum-post-info">
              <p class="forum-post-paragraph"><?php echo $readForumTopic["content"]; ?></p>
            </div>
          </div>
        </div>
        <?php if ($searchTopicMessage->rowCount() > 0) { ?>
        <?php foreach ($searchTopicMessage as $readTopicMessage) { ?>
        <?php $searchMessageAuthor = $db->prepare("SELECT * FROM accounts WHERE username = ?"); ?>
        <?php $searchMessageAuthor->execute(array($readTopicMessage["author"])); ?>
        <?php if ($searchMessageAuthor->rowCount() > 0) { ?>
        <?php $readMessageAuthor = $searchMessageAuthor->fetch(); ?>
        <?php $searchMessageAuthorPermission = $db->prepare("SELECT * FROM accountsPermission WHERE id = ?"); ?>
        <?php $searchMessageAuthorPermission->execute(array($readMessageAuthor["permission"])); ?>
        <?php $readMessageAuthorPermission = $searchMessageAuthorPermission->fetch(); ?>
        <?php if ($readTopicMessage["status"] == "0" || AccountPermControl($readAccount["id"], "forum") !== "PERMISSION_NOT_FOUND") { ?>
        <?php if ($readForumTopic["commentStatus"] == "0" || AccountPermControl($readAccount["id"], "forum") !== "PERMISSION_NOT_FOUND" || $readTopicMessage["author"] == $readAccount["username"]) { ?>
        <div class="forum-post" id="<?php echo $readTopicMessage["id"]; ?>">
          <div class="forum-post-meta">
            <p class="forum-post-timestamp"><?php echo "#".$readTopicMessage["id"]; ?>  <i class="fas fa-clock mr-3 ml-3"></i><?php echo checkTime($readTopicMessage["date"], 2, true); ?><?php echo (($readTopicMessage["status"] == "3") ? "<i class=\"fas fa-trash mr-3 ml-3\"></i>".languageVariables("topicStatus3", "forum", $languageType) : ""); ?></p>

            <div class="forum-post-actions">
              <?php if (isset($_SESSION["incAccountLogin"])) { ?>
              <p forum="report" type="message" report-id="<?php echo $readTopicMessage["id"]; ?>" class="forum-post-action light"><?php echo languageVariables("report", "words", $languageType); ?></p>
              <?php if ($readAccount["username"] == $readMessageAuthor["username"] || AccountPermControl($readAccount["id"], "forum") !== "PERMISSION_NOT_FOUND") { ?>
              <a href="<?php echo urlConverter("forum_message_edit", $languageType)."/".$readTopicMessage["id"]; ?>" class="forum-post-action"><?php echo languageVariables("edit", "words", $languageType); ?></a>
              <p forum="messageRemove" message-id="<?php echo $readTopicMessage["id"]; ?>" class="forum-post-action"><?php echo languageVariables("remove", "words", $languageType); ?></p>
              <?php } } ?>
            </div>
          </div>

          <div class="forum-post-content">
            <div class="forum-post-user">
              <a class="user-avatar no-outline" href="<?php echo urlConverter("player", $languageType)."/".$readMessageAuthor["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readMessageAuthor["username"]; ?>/100.png" width="100" alt="Avatar">
              </a>
              <p class="forum-post-user-title"><a href="<?php echo urlConverter("player", $languageType)."/".$readMessageAuthor["username"]; ?>"><?php echo $readMessageAuthor["username"]; ?></a></p>
              <p class="forum-post-user-tag" style="background-color: <?php echo $readMessageAuthorPermission["permColorBG"]; ?> !important; color: <?php echo $readMessageAuthorPermission["permColorText"]; ?> !important;"><?php echo $readMessageAuthorPermission["permName"]; ?></p>
              <div class="flex justify-end">
                <div class="flex gap-4 my-auto mx-auto md:mx-0 mt-5">
                  <a class="icon bg-blue-500 bg-opacity-25 text-blue-500" target="_blank" href="<?php echo $readMessageAuthor["discord"]; ?>">
                    <i class="fab fa-discord"></i>
                  </a>
                  <a class="icon bg-teal-400 bg-opacity-25 text-teal-500" target="_blank" href="<?php echo $readMessageAuthor["skype"]; ?>">
                    <i class="fab fa-skype"></i>
                  </a>
                  <a class="icon bg-pink-400 bg-opacity-25 text-pink-500" target="_blank" href="<?php echo $readMessageAuthor["instagram"]; ?>">
                    <i class="fab fa-instagram"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="forum-post-info">
              <p class="forum-post-paragraph"><?php echo $readTopicMessage["message"]; ?></p>
            </div>
          </div>
        </div>
        <?php } } } } } ?>
        <div class="forum-post">
          <div class="forum-post-meta">
            <p class="forum-post-timestamp"><?php echo languageVariables("makeComment", "forum", $languageType); ?></p>
          </div>
          <?php if (isset($_SESSION["incAccountLogin"]) && ($readForumTopic["status"] == "1" || AccountPermControl($readAccount["id"], "forum") !== "PERMISSION_NOT_FOUND")) { ?>
          <?php
            if (isset($_POST["messageAdd"])) {
              if ($safeCsrfToken->validate('messageAddToken')) {
                if (post("content") !== "") {
                  $insertTopicMessage = $db->prepare("INSERT INTO forumMessage (`topicID`, `status`, `author`, `message`, `date`) VALUES (?, ?, ?, ?, ?)");
                  $insertTopicMessage->execute(array($readForumTopic["id"], 0, $readAccount["username"], $_POST["content"], date("d.m.Y H:i:s")));
                  $updateTopicPriority = $db->prepare("UPDATE forumTopic SET topicPriority = ? WHERE id = ?");
                  $updateTopicPriority->execute(array(date("Y-m-d H:i:s"), $readForumTopic["id"]));
                  echo alert(languageVariables("alertCommentSendSuccess", "forum", $languageType), "success", "2", "");
                } else {
                  echo alert(languageVariables("alertNone", "forum", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertSystem", "forum", $languageType), "danger", "0", "/");
              }
            }
          ?>
          <div class="forum-post-content">
            <div class="forum-post-user" style="margin-bottom: 2rem;">
              <a class="user-avatar no-outline" href="<?php echo urlConverter("player", $languageType)."/".$readAccount["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="100" alt="Avatar">
              </a>
              <p class="forum-post-user-title"><a href="<?php echo urlConverter("player", $languageType)."/".$readAccount["username"]; ?>"><?php echo $readAccount["username"]; ?></a></p>
              <p class="forum-post-user-tag" style="background-color: <?php echo $readAccountPermission["permColorBG"]; ?> !important; color: <?php echo $readAccountPermission["permColorText"]; ?> !important;"><?php echo $readAccountPermission["permName"]; ?></p>
            </div>
            <div class="forum-post-info">
              <form action="" method="POST">
                <?php echo $safeCsrfToken->input("messageAddToken"); ?>
                <textarea name="content" class="forum-editor" rows="30" placeholder="<?php echo languageVariables("pleaseMessageEnter", "words", $languageType); ?>"></textarea>
                <button type="submit" name="messageAdd" class="btn btn-primary mt-3" style="float: right;"><?php echo languageVariables("send", "words", $languageType); ?></button>
              </form>
            </div>
          </div>
          <?php } else { echo alert(((isset($_SESSION["incAccountLogin"])) ? languageVariables("alertNotIsComment", "forum", $languageType) : languageVariables("alertNotLoginCommment", "forum", $languageType)), "danger", "0", "/"); } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("forum", $languageType)); } ?>
<?php } else if (isset($_GET["categoryID"])) { ?>
<!-- FORUM CATEGORY -->
<?php $searchForumCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?"); ?>
<?php $searchForumCategory->execute(array(get("categoryID"))); ?>
<?php if ($searchForumCategory->rowCount() > 0) { ?>
<?php $readForumCategory = $searchForumCategory->fetch(); ?>
<?php $searchForumCategoryTopicP = $db->prepare("SELECT * FROM forumTopic WHERE categoryID = ? AND status != ? AND status != ? AND pinned = ? ORDER BY topicPriority DESC"); ?>
<?php $searchForumCategoryTopicP->execute(array($readForumCategory["id"], 0, 3, 1)); ?>
<?php $searchForumCategoryTopic = $db->prepare("SELECT * FROM forumTopic WHERE categoryID = ? AND status != ? AND status != ? AND pinned = ? ORDER BY topicPriority DESC"); ?>
<?php $searchForumCategoryTopic->execute(array($readForumCategory["id"], 0, 3, 0)); ?>
<!-- FORUM MAIN -->
<div class="row md:p-10 mt-5 mb-10">
  <div class="col-md-8 mb-10">
    <div class="card py-6 px-8 flex justify-between items-center">
      <div>
        <h5 class="h4 text-dark"><?php echo $readForumCategory["title"]; ?></h5>
        <p class="max-w-xl text-gray-400 mt-2"><?php echo $readForumCategory["text"]; ?></p>
      </div>
      <img src="<?php echo $readForumCategory["image"]; ?>" width="90" alt="forums-icon">
    </div>
    <?php if ($searchForumCategoryTopic->rowCount() > 0 || $searchForumCategoryTopicP->rowCount() > 0) { ?>
    <div class="table table-forum-category">
      <div class="table-header">
        <div class="table-header-column">
          <p class="table-header-title"><?php echo languageVariables("title", "words", $languageType); ?></p>
        </div>
        <div class="table-header-column centered padded-medium">
          <p class="table-header-title"><?php echo languageVariables("views", "words", $languageType); ?></p>
        </div>
        <div class="table-header-column centered padded-medium">
          <p class="table-header-title"><?php echo languageVariables("comments", "words", $languageType); ?></p>
        </div>
        <div class="table-header-column centered padded-medium">
          <p class="table-header-title"><?php echo languageVariables("author", "words", $languageType); ?></p>
        </div>
      </div>
      <div class="table-body">
        <?php if ($searchForumCategoryTopicP->rowCount() > 0) { ?>
        <?php foreach ($searchForumCategoryTopicP as $readForumCategoryTopicP) { ?>
        <?php $searchForumTopicMessageP = $db->prepare("SELECT id FROM forumMessage WHERE topicID = ? AND status = ? ORDER BY id"); ?>
        <?php $searchForumTopicMessageP->execute(array($readForumCategoryTopicP["id"], 0)); ?>
        <?php $forumTopicMessageCountP = $searchForumTopicMessageP->rowCount(); ?>
        <?php
          $searchTopicAccountsP = $db->prepare("SELECT id,username,permission FROM accounts WHERE username = ?");
          $searchTopicAccountsP->execute(array($readForumCategoryTopicP["author"]));
          if ($searchTopicAccountsP->rowCount() > 0) {
            $readTopicAccountsP = $searchTopicAccountsP->fetch();
            $searchTPlayerPermissionP = $db->prepare("SELECT id,permColorBG FROM accountsPermission WHERE id = ?");
            $searchTPlayerPermissionP->execute(array($readTopicAccountsP["permission"]));
            $readTPlayerPermissionP = $searchTPlayerPermissionP->fetch();
        ?>
		    <div class="activeTagContainer"><div class="activeTag"><?php echo languageVariables("pinned", "words", $languageType); ?><div class="tagOptions" style="display: none;"></div></div></div>
        <div class="table-row big">
          <div class="table-column">
            <div class="discussion-preview">
              <a class="discussion-preview-title" href="<?php echo urlConverter("forum", $languageType)."/".createSlug($readForumCategory["title"])."/".createSlug($readForumCategoryTopicP["title"])."/".$readForumCategoryTopicP["id"]; ?>"><?php echo $readForumCategoryTopicP["title"]; ?></a>
            </div>
          </div>
          <div class="table-column centered padded-medium">
            <p class="table-title"><i class="fas fa-eye mr-2" style="color: #adafce;"></i><?php echo $readForumCategoryTopicP["views"]; ?></p>
          </div>
          <div class="table-column centered padded-medium">
            <p class="table-title"><i class="fas fa-message mr-2" style="color: #adafce;"></i><?php echo $forumTopicMessageCountP; ?></p>
          </div>
          <div class="table-column padded-big-left">
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType)."/".$readForumCategoryTopicP["author"]; ?>">
                <img width="40" src="https://minotar.net/bust/<?php echo $readForumCategoryTopicP["author"]; ?>/100.png" alt="category-01">
              </a>
              <p class="user-status-title"><a class="bold" href="<?php echo urlConverter("player", $languageType)."/".$readForumCategoryTopicP["author"]; ?>" style="color: <?php echo $readTPlayerPermissionP["permColorBG"]; ?>"><?php echo $readForumCategoryTopicP["author"]; ?></a></p>
              <p class="user-status-text small"><?php echo checkTime($readForumCategoryTopicP["date"]); ?></p>
            </div>
          </div>
        </div>
        <?php } } } ?>
        <?php if ($searchForumCategoryTopic->rowCount() > 0) { ?>
        <?php foreach ($searchForumCategoryTopic as $readForumCategoryTopic) { ?>
        <?php $searchForumTopicMessage = $db->prepare("SELECT id FROM forumMessage WHERE topicID = ? AND status = ? ORDER BY id"); ?>
        <?php $searchForumTopicMessage->execute(array($readForumCategoryTopic["id"], 0)); ?>
        <?php $forumTopicMessageCount = $searchForumTopicMessage->rowCount(); ?>
        <?php
          $searchTopicAccounts = $db->prepare("SELECT id,username,permission FROM accounts WHERE username = ?");
          $searchTopicAccounts->execute(array($readForumCategoryTopic["author"]));
          if ($searchTopicAccounts->rowCount() > 0) {
            $readTopicAccounts = $searchTopicAccounts->fetch();
            $searchTPlayerPermission = $db->prepare("SELECT id,permColorBG FROM accountsPermission WHERE id = ?");
            $searchTPlayerPermission->execute(array($readTopicAccounts["permission"]));
            $readTPlayerPermission = $searchTPlayerPermission->fetch();
        ?>
        <div class="table-row big">
          <div class="table-column">
            <div class="discussion-preview">
              <a class="discussion-preview-title" href="<?php echo urlConverter("forum", $languageType)."/".createSlug($readForumCategory["title"])."/".createSlug($readForumCategoryTopic["title"])."/".$readForumCategoryTopic["id"]; ?>"><?php echo $readForumCategoryTopic["title"]; ?></a>
            </div>
          </div>
          <div class="table-column centered padded-medium">
            <p class="table-title"><i class="fas fa-eye mr-2" style="color: #adafce;"></i><?php echo $readForumCategoryTopic["views"]; ?></p>
          </div>
          <div class="table-column centered padded-medium">
            <p class="table-title"><i class="fas fa-message mr-2" style="color: #adafce;"></i><?php echo $forumTopicMessageCount; ?></p>
          </div>
          <div class="table-column padded-big-left">
            <div class="user-status">
              <a class="user-status-avatar" href="<?php echo urlConverter("player", $languageType)."/".$readForumCategoryTopic["author"]; ?>">
                <img width="40" src="https://minotar.net/bust/<?php echo $readForumCategoryTopic["author"]; ?>/100.png" alt="category-01">
              </a>
              <p class="user-status-title"><a class="bold" href="<?php echo urlConverter("player", $languageType)."/".$readForumCategoryTopic["author"]; ?>" style="color: <?php echo $readTPlayerPermission["permColorBG"]; ?>"><?php echo $readForumCategoryTopic["author"]; ?></a></p>
              <p class="user-status-text small"><?php echo checkTime($readForumCategoryTopic["date"]); ?></p>
            </div>
          </div>
        </div>
        <?php } } } ?>
      </div>
    </div>
    <?php } else { alert(languageVariables("alertNotCategoryTopic", "forum", $languageType), "danger", "0", "/"); } ?>
  </div>
  <div class="col-md-4">
    <div class="h-fit">
      <a href="<?php echo urlConverter("forum_topic_create", $languageType); ?><?php echo "/".createSlug($readForumCategory["title"])."/".$readForumCategory["id"]; ?>" class="btn btn-light btn-lg !flex gap-3 items-center justify-center group">
        <span><?php echo languageVariables("createTopic", "words", $languageType); ?></span>
        <i class="fas fa-arrow-right group-hover:ml-3 transition-all"></i>
      </a>
    </div>
    <div class="mt-10">
      <?php $searchForumLastMessage = $db->prepare("SELECT M.* FROM forumTopic T INNER JOIN forumMessage M ON M.topicID = T.id WHERE T.categoryID = ? ORDER BY M.id DESC LIMIT 5"); ?>
      <?php $searchForumLastMessage->execute(array($readForumCategory["id"])); ?>
      <?php if ($searchForumLastMessage->rowCount() > 0) { ?>
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-message !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("lastMessage", "forum", $languageType); ?></p>
          </div>
          <div class="overflow-hdn relative rounded-b-2xl">
            <table class="table table-hover">
              <tbody>
              <?php foreach ($searchForumLastMessage as $readForumLastMessage) { ?>
              <?php
                $searchForumLastMessageTopic = $db->prepare("SELECT id,title FROM forumTopic WHERE id = ?");
                $searchForumLastMessageTopic->execute(array($readForumLastMessage["topicID"]));
                if ($searchForumLastMessageTopic->rowCount() > 0) {
                  $readForumLastMessageTopic = $searchForumLastMessageTopic->fetch();
              ?>
                <tr>
                  <td class="text-center"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readForumLastMessage["author"]; ?>/28" alt="<?php echo languageVariables("player", "words", $languageType); ?> - <?php echo $readForumLastMessage["author"]; ?>"></td>
                  <td><a href="<?php echo urlConverter("forum", $languageType)."/".createSlug("category")."/".createSlug($readForumLastMessageTopic["title"])."/".$readForumLastMessageTopic["id"]; ?>"><?php echo $readForumLastMessageTopic["title"]; ?></a></td>
                  <td class="text-center"><?php echo $readForumLastMessage["author"]; ?></td>
                  <td class="text-center text-gray-400"><?php echo checkTime($readForumLastMessage["date"]); ?></td>
                </tr>
              <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("alertNotPublishedMessage", "forum", $languageType), "danger", "0", ""); } ?>
    </div>
    <div class="mt-10">
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-users !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("activeUsers", "forum", $languageType); ?></p>
          </div>
          <div style="padding: 1.5rem;" data-toggle="activeUsers">
            <div style="text-align: center;">
              <i class="fas fa-spinner"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      $searchTopics = $db->query("SELECT id FROM forumTopic ORDER BY id");
      $topicCounts = number_format($searchTopics->rowCount(), 0, "", ",");
      $searchMessages = $db->query("SELECT id FROM forumMessage ORDER BY id");
      $messagesCounts = number_format($searchMessages->rowCount(), 0, "", ",");
      $searchForumUsers = $db->query("SELECT id FROM accounts ORDER BY id");
      $usersCounts = number_format($searchForumUsers->rowCount(), 0, "", ",");
    ?>
    <div class="card py-6 px-8 mt-10">
      <div class="relative flex gap-5 border-b-2 border-gray-200/50 py-4">
        <div class="absolute top-0 right-0 h-full text-gray-200 fs-1 fw-medium flex items-center"><?php echo $topicCounts; ?></div>
        <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-20 h-20">
          <i class="fas fa-newspaper fs-4 text-primary"></i>
        </div>
        <div class="flex justify-center flex-col">
          <dt class="fw-medium text-gray-500"><?php echo languageVariables("topics", "words", $languageType); ?></dt>
          <dd class="text-primary fs-3 fw-bold"><?php echo $topicCounts; ?></dd>
        </div>
      </div>
      <div class="relative flex gap-5 justify-end py-4">
        <div class="absolute top-0 left-0 h-full text-gray-200 fs-1 fw-medium flex items-center"><?php echo $messagesCounts; ?></div>
        <div class="text-right flex justify-center flex-col">
          <dt class="fw-medium text-gray-500"><?php echo languageVariables("comments", "words", $languageType); ?></dt>
          <dd class="text-danger fw-bold fs-3"><?php echo $messagesCounts; ?></dd>
        </div>
        <div class="rounded-2xl flex items-center justify-center bg-red-400/25 w-20 h-20">
          <i class="fas fa-message fs-4 text-danger"></i>
        </div>
      </div>
      <div class="relative flex gap-5 border-b-2 border-gray-200/50 py-4">
        <div class="absolute top-0 right-0 h-full text-gray-200 fs-1 fw-medium flex items-center"><?php echo $usersCounts; ?></div>
        <div class="rounded-2xl flex items-center justify-center bg-emerald-400/25 w-20 h-20">
          <i class="fas fa-users fs-4 text-success"></i>
        </div>
        <div class="flex justify-center flex-col">
          <dt class="fw-medium text-gray-500"><?php echo languageVariables("users", "words", $languageType); ?></dt>
          <dd class="text-success fs-3 fw-bold"><?php echo $usersCounts; ?></dd>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("forum", $languageType)); } ?>
<?php } else { ?>
<!-- FORUM MAIN -->
<div class="row md:p-10 mt-5 mb-10">
  <div class="col-md-8 mb-10">
    <?php $categoryNumber = 0; ?>
    <?php $searchTopForumCategory = $db->query("SELECT * FROM forumCategory ORDER BY id ASC"); ?>
    <?php if ($searchTopForumCategory->rowCount() > 0) { ?>
    <?php foreach ($searchTopForumCategory as $readTopForumCategory) { ?>
    <?php $categoryNumber += 1; ?>
    <div class="card py-6 px-8 flex justify-between items-center <?php echo (($categoryNumber == 1) ? "" : "mt-10"); ?>">
      <div>
        <h5 class="h4 text-dark"><?php echo $readTopForumCategory["title"]; ?></h5>
        <p class="max-w-xl text-gray-400 mt-2"><?php echo $readTopForumCategory["text"]; ?></p>
      </div>
      <img src="<?php echo $readTopForumCategory["image"]; ?>" width="90" alt="forums-icon">
    </div>
    <?php $searchSubForumCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE categoryID = ? ORDER BY id ASC"); ?>
    <?php $searchSubForumCategory->execute(array($readTopForumCategory["id"])); ?>
    <?php if ($searchSubForumCategory->rowCount() > 0) { ?>
    <div class="table table-forum-category">
      <div class="table-header">
        <div class="table-header-column">
          <p class="table-header-title"><?php echo languageVariables("category", "words", $languageType); ?></p>
        </div>
        <div class="table-header-column centered padded-medium">
          <p class="table-header-title"><?php echo languageVariables("topics", "words", $languageType); ?></p>
        </div>
        <div class="table-header-column centered padded-medium">
          <p class="table-header-title"><?php echo languageVariables("comments", "words", $languageType); ?></p>
        </div>
      </div>
      <div class="table-body">
        <?php foreach ($searchSubForumCategory as $readSubForumCategory) { ?>
        <?php $searchForumCategoryTopic = $db->prepare("SELECT id FROM forumTopic WHERE categoryID = ? AND (status = ? OR status = ? OR status = ?) ORDER BY id"); ?>
        <?php $searchForumCategoryTopic->execute(array($readSubForumCategory["id"], 0, 1, 2)); ?>
        <?php $forumCategoryTopicCount = $searchForumCategoryTopic->rowCount(); ?>
        <?php $searchForumCategoryMessage = $db->prepare("SELECT M.id FROM forumMessage M INNER JOIN forumTopic T ON M.topicID = T.id WHERE T.categoryID = ? ORDER BY M.id"); ?>
        <?php $searchForumCategoryMessage->execute(array($readSubForumCategory["id"])); ?>
        <?php $forumCategoryMessageCount = $searchForumCategoryMessage->rowCount(); ?>
        <?php $searchForumCategoryLastTopic = $db->prepare("SELECT * FROM forumTopic WHERE categoryID = ? AND (status = ? OR status = ? OR status = ?) ORDER BY id DESC LIMIT 1"); ?>
        <?php $searchForumCategoryLastTopic->execute(array($readSubForumCategory["id"], 0, 1, 2)); ?>
        <?php $statusLastTopic[$readSubForumCategory["id"]] = "FALSE"; ?>
        <?php if ($searchForumCategoryLastTopic->rowCount() > 0) { ?>
        <?php $statusLastTopic[$readSubForumCategory["id"]] = "TRUE"; ?>
        <?php $readForumCategoryLastTopic = $searchForumCategoryLastTopic->fetch(); ?>
        <?php } ?>
        <div class="table-row big">
          <div class="table-column">
            <div class="forum-category">
              <a href="<?php echo urlConverter("forum", $languageType); ?>/<?php echo createSlug($readSubForumCategory["title"])."/".$readSubForumCategory["id"]; ?>">
                <img class="forum-category-image" src="<?php echo $readSubForumCategory["image"]; ?>" alt="category-01">
              </a>
              <div class="forum-category-info">
                <p class="forum-category-title"><a href="<?php echo urlConverter("forum", $languageType); ?>/<?php echo createSlug($readSubForumCategory["title"])."/".$readSubForumCategory["id"]; ?>"><?php echo $readSubForumCategory["title"]; ?></a></p>
                <p class="forum-category-text"><?php echo $readSubForumCategory["text"]; ?></p>
              </div>
            </div>
          </div>
          <div class="table-column centered padded-medium">
            <p class="table-title"><?php echo $forumCategoryTopicCount; ?></p>
          </div>
          <div class="table-column centered padded-medium">
            <p class="table-title"><?php echo $forumCategoryMessageCount; ?></p>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php } else { echo alert(languageVariables("alertNotPublishedCategory", "forum", $languageType), "danger", "0", "/"); } } ?>
    <?php } else { echo alert(languageVariables("alertNotPublishedCategory", "forum", $languageType), "danger", "0", "/"); } ?>
  </div>
  <div class="col-md-4">
    <div class="h-fit">
      <a href="<?php echo urlConverter("forum_topic_create", $languageType); ?>" class="btn btn-light btn-lg !flex gap-3 items-center justify-center group">
        <span><?php echo languageVariables("createTopic", "words", $languageType); ?></span>
        <i class="fas fa-arrow-right group-hover:ml-3 transition-all"></i>
      </a>
    </div>
    <div class="mt-10">
      <?php $searchForumLastTopic = $db->prepare("SELECT * FROM forumTopic WHERE status = ? ORDER BY id DESC LIMIT 5"); ?>
      <?php $searchForumLastTopic->execute(array(1)); ?>
      <?php if ($searchForumLastTopic->rowCount() > 0) { ?>
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-newspaper !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("lastTopics", "forum", $languageType); ?></p>
          </div>
          <div class="overflow-hdn relative rounded-b-2xl">
            <table class="table table-hover">
              <tbody>
              <?php foreach ($searchForumLastTopic as $readForumLastTopic) { ?>
                <tr>
                  <td class="text-center"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readForumLastTopic["author"]; ?>/28" alt="<?php echo languageVariables("player", "words", $languageType); ?> - <?php echo $readForumLastTopic["author"]; ?>"></td>
                  <td><a href="<?php echo urlConverter("forum", $languageType)."/".createSlug("category")."/".createSlug($readForumLastTopic["title"])."/".$readForumLastTopic["id"]; ?>"><?php echo $readForumLastTopic["title"]; ?></a></td>
                  <td class="text-center"><?php echo $readForumLastTopic["author"]; ?></td>
                  <td class="text-center text-gray-400"><?php echo checkTime($readForumLastTopic["date"]); ?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("alertNotPublishedTopic", "forum", $languageType), "danger", "0", ""); } ?>
    </div>
    <div class="mt-10">
      <?php $searchForumLastMessage = $db->prepare("SELECT * FROM forumMessage WHERE status = ? ORDER BY id DESC LIMIT 5"); ?>
      <?php $searchForumLastMessage->execute(array(0)); ?>
      <?php if ($searchForumLastMessage->rowCount() > 0) { ?>
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-message !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("lastMessage", "forum", $languageType); ?></p>
          </div>
          <div class="overflow-hdn relative rounded-b-2xl">
            <table class="table table-hover">
              <tbody>
              <?php foreach ($searchForumLastMessage as $readForumLastMessage) { ?>
              <?php
                $searchForumLastMessageTopic = $db->prepare("SELECT id,title FROM forumTopic WHERE id = ?");
                $searchForumLastMessageTopic->execute(array($readForumLastMessage["topicID"]));
                if ($searchForumLastMessageTopic->rowCount() > 0) {
                  $readForumLastMessageTopic = $searchForumLastMessageTopic->fetch();
              ?>
                <tr>
                  <td class="text-center"><img class="rounded-xl" src="https://minotar.net/avatar/<?php echo $readForumLastMessage["author"]; ?>/28" alt="<?php echo languageVariables("player", "words", $languageType); ?> - <?php echo $readForumLastMessage["author"]; ?>"></td>
                  <td><a href="<?php echo urlConverter("forum", $languageType)."/".createSlug("category")."/".createSlug($readForumLastMessageTopic["title"])."/".$readForumLastMessageTopic["id"]; ?>"><?php echo $readForumLastMessageTopic["title"]; ?></a></td>
                  <td class="text-center"><?php echo $readForumLastMessage["author"]; ?></td>
                  <td class="text-center text-gray-400"><?php echo checkTime($readForumLastMessage["date"]); ?></td>
                </tr>
              <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php } else { echo alert(languageVariables("alertNotPublishedMessage", "forum", $languageType), "danger", "0", ""); } ?>
    </div>
    <div class="mt-10">
      <div>
        <div class="card">
          <div class="border-b-2 border-gray-200/50 py-4 px-6">
            <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-14 h-14 absolute -top-5 -right-5">
              <i class="fas fa-users !text-indigo-700 fs-5"></i>
            </div>
            <p class="text-gray-500 fw-medium"><?php echo languageVariables("activeUsers", "forum", $languageType); ?></p>
          </div>
          <div style="padding: 1.5rem;" data-toggle="activeUsers">
            <div style="text-align: center;">
              <i class="fas fa-spinner"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      $searchTopics = $db->query("SELECT id FROM forumTopic ORDER BY id");
      $topicCounts = number_format($searchTopics->rowCount(), 0, "", ",");
      $searchMessages = $db->query("SELECT id FROM forumMessage ORDER BY id");
      $messagesCounts = number_format($searchMessages->rowCount(), 0, "", ",");
      $searchForumUsers = $db->query("SELECT id FROM accounts ORDER BY id");
      $usersCounts = number_format($searchForumUsers->rowCount(), 0, "", ",");
    ?>
    <div class="card py-6 px-8 mt-10">
      <div class="relative flex gap-5 border-b-2 border-gray-200/50 py-4">
        <div class="absolute top-0 right-0 h-full text-gray-200 fs-1 fw-medium flex items-center"><?php echo $topicCounts; ?></div>
        <div class="rounded-2xl flex items-center justify-center bg-indigo-400/25 w-20 h-20">
          <i class="fas fa-newspaper fs-4 text-primary"></i>
        </div>
        <div class="flex justify-center flex-col">
          <dt class="fw-medium text-gray-500"><?php echo languageVariables("topics", "words", $languageType); ?></dt>
          <dd class="text-primary fs-3 fw-bold"><?php echo $topicCounts; ?></dd>
        </div>
      </div>
      <div class="relative flex gap-5 justify-end py-4">
        <div class="absolute top-0 left-0 h-full text-gray-200 fs-1 fw-medium flex items-center"><?php echo $messagesCounts; ?></div>
        <div class="text-right flex justify-center flex-col">
          <dt class="fw-medium text-gray-500"><?php echo languageVariables("comments", "words", $languageType); ?></dt>
          <dd class="text-danger fw-bold fs-3"><?php echo $messagesCounts; ?></dd>
        </div>
        <div class="rounded-2xl flex items-center justify-center bg-red-400/25 w-20 h-20">
          <i class="fas fa-message fs-4 text-danger"></i>
        </div>
      </div>
      <div class="relative flex gap-5 border-b-2 border-gray-200/50 py-4">
        <div class="absolute top-0 right-0 h-full text-gray-200 fs-1 fw-medium flex items-center"><?php echo $usersCounts; ?></div>
        <div class="rounded-2xl flex items-center justify-center bg-emerald-400/25 w-20 h-20">
          <i class="fas fa-users fs-4 text-success"></i>
        </div>
        <div class="flex justify-center flex-col">
          <dt class="fw-medium text-gray-500"><?php echo languageVariables("users", "words", $languageType); ?></dt>
          <dd class="text-success fs-3 fw-bold"><?php echo $usersCounts; ?></dd>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php } else if (get("action") == "proccess") { ?>
<?php AccountLoginControl(false); ?>
<?php if (get("proccess") == "create") { ?>
<!-- TOPIC ADD -->
<?php $categoryStatus = false; ?>
<?php if (isset($_GET["categoryID"])) { ?>
<?php $searchSForumCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?"); ?>
<?php $searchSForumCategory->execute(array(get("categoryID"))); ?>
<?php if ($searchSForumCategory->rowCount() > 0) { ?>
<?php $readSForumCategory = $searchSForumCategory->fetch(); ?>
<?php $categoryStatus = true; ?>
<?php } } ?>
<div class="row md:p-10 mt-5 mb-10">
  <div class="col-md-12">
    <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("forum", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum_topic_create", $languageType); ?><?php echo (($categoryStatus == true) ? "/".createSlug($readSForumCategory["title"])."/".$readSForumCategory["id"] : ""); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Konu Oluştur</a>
          </div>
        </li>
      </ol>
    </nav>
    <div class="forum-content mt-10">
      <div class="forum-post-list">
        <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["topicCreate"])) {
            if ($safeCsrfToken->validate('topicCreateToken')) {
              if (post("title") !== "" && post("content") !== "") {
                $searchCategoryControl = $db->prepare("SELECT * FROM forumSubCategory WHERE id = ?");
                $searchCategoryControl->execute(array(post("category")));
                if ($searchCategoryControl->rowCount() > 0) {
                  $readCategoryControl = $searchCategoryControl->fetch();
                  $topicStatus = (($readCategoryControl["topicStatus"] == "0") ? "1" : "0");
                  $insertTopic = $db->prepare("INSERT INTO forumTopic (`categoryID`, `topicPriority`, `pinned`, `title`, `content`, `status`,  `author`,  `views`,  `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                  $insertTopic->execute(array(post("category"), date("Y-m-d H:i:s"), 0, post("title"), $_POST["content"], $topicStatus, $readAccount["username"], 0, date("d.m.Y H:i:s")));
                  echo alert(languageVariables("alertCreateTopicSuccess", "forum", $languageType), "success", "0", "/");
                } else {
                  echo alert(languageVariables("alertSystem", "forum", $languageType), "danger", "0", "/");
                }
              } else {
                echo alert(languageVariables("alertNone", "forum", $languageType), "danger", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "forum", $languageType), "danger", "0", "/");
            }
          }
        ?>
        <div class="forum-post">
          <div class="forum-post-meta">
            <p class="forum-post-timestamp"><?php echo languageVariables("createTopic", "words", $languageType); ?></p>
          </div>
          <div class="forum-post-content">
            <div class="forum-post-user" style="margin-bottom: 2rem;">
              <a class="user-avatar no-outline" href="<?php echo urlConverter("player", $languageType)."/".$readAccount["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="100" alt="Avatar">
              </a>
              <p class="forum-post-user-title"><a href="<?php echo urlConverter("player", $languageType)."/".$readAccount["username"]; ?>"><?php echo $readAccount["username"]; ?></a></p>
              <p class="forum-post-user-tag" style="background-color: <?php echo $readAccountPermission["permColorBG"]; ?> !important; color: <?php echo $readAccountPermission["permColorText"]; ?> !important;"><?php echo $readAccountPermission["permName"]; ?></p>
            </div>
            <div class="forum-post-info">
              <form action="" method="POST">
                <?php echo $safeCsrfToken->input("topicCreateToken"); ?>
                <div class="grid mt-4 relative z-30">
                  <label for="category" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("category", "words", $languageType); ?></label>
                  <select id="category" name="category" class="form-control mt-2">
                    <?php $searchForumCategory = $db->query("SELECT * FROM forumCategory ORDER BY id ASC"); ?>
                    <?php foreach ($searchForumCategory as $readCategory) { ?>
                    <?php $searchForumSubCategory = $db->prepare("SELECT * FROM forumSubCategory WHERE categoryID = ? ORDER BY id ASC"); ?>
                    <?php $searchForumSubCategory->execute(array($readCategory["id"])); ?>
                    <?php if ($searchForumSubCategory->rowCount() > 0) { ?>
                    <?php echo "<optgroup label=\"".$readCategory["title"]."\">"; ?>
                    <?php foreach ($searchForumSubCategory as $readSubCategory) { ?>
                    <option value="<?php echo $readSubCategory["id"]; ?>" <?php echo (($categoryStatus == true && $readSubCategory["id"] == $readSForumCategory["id"]) ? "selected" : ""); ?>><?php echo $readSubCategory["title"]; ?></option>
                    <?php } ?>
                    <?php echo "</optgroup>"; ?>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="grid mt-3">
                  <label for="title" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("title", "words", $languageType); ?></label>
                  <input id="title" type="text" name="title" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("title", "words", $languageType); ?>">
                </div>
                <div style="margin-top: 2rem;">
                  <textarea name="content" class="forum-editor" rows="30" placeholder="<?php echo languageVariables("pleaseMessageEnter", "forum", $languageType); ?>"></textarea>
                </div>
                <button type="submit" name="topicCreate" class="btn btn-primary mt-3" style="float: right;"><?php echo languageVariables("create", "words", $languageType); ?></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else if (get("proccess") == "edit") { ?>
<?php if (get("target") == "topic") { ?>
<!-- TOPIC EDIT -->
<?php if (isset($_GET["topicID"])) { ?>
<?php $searchForumTopic = $db->prepare("SELECT * FROM forumTopic WHERE id = ? AND (status = ? OR status = ?)"); ?>
<?php $searchForumTopic->execute(array(get("topicID"), 0, 1)); ?>
<?php if ($searchForumTopic->rowCount() > 0) { ?>
<?php $readForumTopic = $searchForumTopic->fetch(); ?>
<?php if ($readForumTopic["author"] == $readAccount["username"] || AccountPermControl($readAccount["id"], "forum") !== "PERMISSION_NOT_FOUND") { ?>
<div class="row md:p-10 mt-5 mb-10">
  <div class="col-md-12">
  <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Forum</a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum", $languageType); ?>/<?php echo createSlug($readTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readForumTopic["title"]; ?></a>
          </div>
        </li>
      </ol>
    </nav>
    <div class="forum-content mt-10">
      <div class="forum-post-list">
        <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["topicUpdate"])) {
            if ($safeCsrfToken->validate('topicUpdateToken')) {
              if (post("title") !== "" && post("content") !== "") {
                $updateTopic = $db->prepare("UPDATE forumTopic SET title = ?, content = ? WHERE id = ?");
                $updateTopic->execute(array(post("title"), $_POST["content"], $readForumTopic["id"]));
                echo alert(languageVariables("alertEditTopicSuccess", "forum", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "forum", $languageType), "danger", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "forum", $languageType), "danger", "0", "/");
            }
          }
        ?>
        <div class="forum-post">
          <div class="forum-post-meta">
            <p class="forum-post-timestamp"><?php echo languageVariables("editTopic", "words", $languageType); ?></p>
          </div>
          <div class="forum-post-content">
            <div class="forum-post-user" style="margin-bottom: 2rem;">
              <a class="user-avatar no-outline" href="<?php echo urlConverter("player", $languageType)."/".$readAccount["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="100" alt="Avatar">
              </a>
              <p class="forum-post-user-title"><a href="<?php echo urlConverter("player", $languageType)."/".$readAccount["username"]; ?>"><?php echo $readAccount["username"]; ?></a></p>
              <p class="forum-post-user-tag" style="background-color: <?php echo $readAccountPermission["permColorBG"]; ?> !important; color: <?php echo $readAccountPermission["permColorText"]; ?> !important;"><?php echo $readAccountPermission["permName"]; ?></p>
            </div>
            <div class="forum-post-info">
              <form action="" method="POST">
                <?php echo $safeCsrfToken->input("topicUpdateToken"); ?>
                <div class="grid">
                  <label for="title" class="pl-2 text-gray-700 fw-bolder"><?php echo languageVariables("title", "words", $languageType); ?></label>
                  <input id="title" type="text" name="title" class="w-full mt-2 form-control" placeholder="<?php echo languageVariables("title", "words", $languageType); ?>" value="<?php echo $readForumTopic["title"]; ?>">
                </div>
                <div style="margin-top: 2rem;">
                  <textarea name="content" class="forum-editor" rows="30" placeholder="<?php echo languageVariables("pleaseMessageEnter", "words", $languageType); ?>"><?php echo $readForumTopic["content"]; ?></textarea>
                </div>
                <button type="submit" name="topicUpdate" class="btn btn-primary mt-3" style="float: right;"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("forum", $languageType)); } ?>
<?php } else { go(urlConverter("forum", $languageType)); } ?>
<?php } else { go(urlConverter("forum", $languageType)); } ?>
<?php } else if (get("target") == "message") { ?>
<!-- MESSAGE EDIT -->
<?php if (isset($_GET["messageID"])) { ?>
<?php $searchForumMessage = $db->prepare("SELECT * FROM forumMessage WHERE id = ? AND status = ?"); ?>
<?php $searchForumMessage->execute(array(get("messageID"), 0)); ?>
<?php if ($searchForumMessage->rowCount() > 0) { ?>
<?php $readForumMessage = $searchForumMessage->fetch(); ?>
<?php $searchForumTopic = $db->prepare("SELECT * FROM forumTopic WHERE id = ? AND (status = ? OR status = ?)"); ?>
<?php $searchForumTopic->execute(array($readForumMessage["topicID"], 0, 1)); ?>
<?php if ($searchForumTopic->rowCount() > 0) { ?>
<?php $readForumTopic = $searchForumTopic->fetch(); ?>
<?php if ($readForumMessage["author"] == $readAccount["username"] || AccountPermControl($readAccount["id"], "forum") !== "PERMISSION_NOT_FOUND") { ?>
<div class="row md:p-10 mt-5 mb-10">
  <div class="col-md-12">
  <nav class="card flex" aria-label="Breadcrumb">
      <ol class=" w-full mx-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
        <li class="flex">
          <div class="flex items-center">
            <a href="/" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-home"></i>
              <span class="sr-only"><?php echo languageVariables("home", "words", $languageType); ?></span>
            </a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum", $languageType); ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo languageVariables("forum", "words", $languageType); ?></a>
          </div>
        </li>
        <li class="flex">
          <div class="flex items-center py-1">
            <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"></path>
            </svg>
            <a href="<?php echo urlConverter("forum", $languageType); ?>/<?php echo createSlug($readTopicSubCategory["title"])."/".createSlug($readForumTopic["title"])."/".$readForumTopic["id"]; ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"><?php echo $readForumTopic["title"]; ?></a>
          </div>
        </li>
      </ol>
    </nav>
    <div class="forum-content mt-10">
      <div class="forum-post-list">
        <?php
          require_once(__DR__."/main/includes/packages/class/csrf/class.php");
          $safeCsrfToken = new CSRF('csrf-sessions', 'csrf-token');
          if (isset($_POST["messageUpdate"])) {
            if ($safeCsrfToken->validate('messageUpdateToken')) {
              if (post("content") !== "") {
                $updateTopic = $db->prepare("UPDATE forumMessage SET message = ? WHERE id = ?");
                $updateTopic->execute(array($_POST["content"], $readForumMessage["id"]));
                echo alert(languageVariables("alertEditMessageSuccess", "forum", $languageType), "success", "2", "");
              } else {
                echo alert(languageVariables("alertNone", "forum", $languageType), "danger", "0", "/");
              }
            } else {
              echo alert(languageVariables("alertSystem", "forum", $languageType), "danger", "0", "/");
            }
          }
        ?>
        <div class="forum-post">
          <div class="forum-post-meta">
            <p class="forum-post-timestamp"><?php echo languageVariables("editMessage", "words", $languageType); ?></p>
          </div>
          <div class="forum-post-content">
            <div class="forum-post-user" style="margin-bottom: 2rem;">
              <a class="user-avatar no-outline" href="<?php echo urlConverter("player", $languageType)."/".$readAccount["username"]; ?>">
                <img src="https://minotar.net/bust/<?php echo $readAccount["username"]; ?>/100.png" width="100" alt="Avatar">
              </a>
              <p class="forum-post-user-title"><a href="<?php echo urlConverter("player", $languageType)."/".$readAccount["username"]; ?>"><?php echo $readAccount["username"]; ?></a></p>
              <p class="forum-post-user-tag" style="background-color: <?php echo $readAccountPermission["permColorBG"]; ?> !important; color: <?php echo $readAccountPermission["permColorText"]; ?> !important;"><?php echo $readAccountPermission["permName"]; ?></p>
            </div>
            <div class="forum-post-info">
              <form action="" method="POST">
                <?php echo $safeCsrfToken->input("messageUpdateToken"); ?>
                <div>
                  <textarea name="content" class="forum-editor" rows="30" placeholder="<?php echo languageVariables("pleaseMessageEnter", "words", $languageType); ?>"><?php echo $readForumMessage["message"]; ?></textarea>
                </div>
                <button type="submit" name="messageUpdate" class="btn btn-primary mt-3" style="float: right;"><?php echo languageVariables("saveChanges", "words", $languageType); ?></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { go(urlConverter("forum", $languageType)); } ?>
<?php } else { go(urlConverter("forum", $languageType)); } ?>
<?php } else { go(urlConverter("forum", $languageType)); } ?>
<?php } else { go(urlConverter("forum", $languageType)); } ?>
<?php } ?>
<?php } ?>
<?php } ?>