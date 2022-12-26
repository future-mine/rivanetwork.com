<?php if (get("page") !== "404") { ?>
<?php if ($_SESSION["adminThemeModeType"] == "light") { ?>
<div class="horizontal-menu">
  <nav class="navbar top-navbar">
    <div class="container">
      <div class="navbar-content">
        <a href="<?php echo urlConverter("admin_home", $languageType); ?>" class="navbar-brand d-none d-md-block mt-2">
          <?php echo $rSettings["serverName"]; ?>
        </a>
        <div class="search-form">
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <i data-feather="search"></i>
              </div>
            </div>
            <input type="text" class="form-control" placeholder="<?php echo languageVariables("playerSearch", "words", $languageType); ?>" data-toggle="searchAccount">
          </div>
        </div>
        <?php $searchLanguageHeader = $db->query("SELECT * FROM languages ORDER BY id ASC"); ?>
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="languageDropdowns" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-<?php echo $languageCountry[$readLang["code"]]; ?> mr-2" title="<?php echo $readLang["title"]; ?>"></i><span class="d-none d-md-inline-block"><?php echo $readLang["title"]; ?></span></a>
            <div class="dropdown-menu" aria-labelledby="languageDropdowns">
			        <?php foreach ($searchLanguageHeader as $readLanguageHeader) { ?>
			        <a href="/admin/index.php?language=<?php echo $readLanguageHeader["code"]; ?>&ref=<?php echo $_SERVER["REQUEST_URI"]; ?>" class="dropdown-item py-2"><i class="flag-icon flag-icon-<?php echo $languageCountry[$readLanguageHeader["code"]]; ?> mr-2" title="<?php echo $readLanguageHeader["title"]; ?>"></i> <?php echo $readLanguageHeader["title"]; ?></a>
              <?php } ?>
            </div>
          </li>
          <li class="nav-item dropdown nav-notifications">
            <a class="nav-link dropdown-toggle" href="<?php echo urlConverter("home", $languageType); ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="<?php echo languageVariables("leftHome", "words", $languageType); ?>">
              <i data-feather="home"></i>
            </a>
          </li>
          <li class="nav-item dropdown nav-notifications">
            <a class="nav-link dropdown-toggle" href="/admin/index.php?changeTheme=dark&ref=<?php echo $_SERVER["REQUEST_URI"]; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo languageVariables("darkThemeGo", "words", $languageType); ?>">
              <i data-feather="sun"></i>
            </a>
          </li>
          <li class="nav-item dropdown nav-notifications">
            <a class="nav-link dropdown-toggle" href="<?php echo urlConverter("admin_updates", $languageType); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo languageVariables("updates", "words", $languageType); ?>">
              <i data-feather="refresh-ccw"></i>
            </a>
          </li>
          <li class="nav-item dropdown nav-notifications">
            <a class="nav-link dropdown-toggle" href="<?php echo urlConverter("admin_modules_backup", $languageType); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo languageVariables("backups", "words", $languageType); ?>">
              <i data-feather="save"></i>
            </a>
          </li>
          <li class="nav-item dropdown nav-notifications">
            <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i data-feather="bell"></i>
              <div class="indicator">
                <div class="circle"></div>
              </div>
            </a>
            <?php $searchNotification = $db->query("SELECT * FROM systemNotifications ORDER BY id DESC LIMIT 3"); ?>
            <div class="dropdown-menu" aria-labelledby="notificationDropdown">
              <div class="dropdown-header d-flex align-items-center justify-content-between">
                <p class="mb-0 font-weight-medium"><?php echo languageVariables("notifications", "words", $languageType); ?> (<?php echo mysqlCount($searchNotification); ?>)</p>
              </div>
              <div class="dropdown-body" style="overflow: scroll;">
                <?php if (mysqlCount($searchNotification) > 0) { ?>
                <?php foreach ($searchNotification as $readNotification) { ?>
                <?php $searchNotificationAccount = $db->prepare("SELECT * FROM accounts WHERE id = ?"); ?>
                <?php $searchNotificationAccount->execute(array($readNotification["userID"])); ?>
                <?php $readNotificationAccount = fetch($searchNotificationAccount); ?>
                <?php $readNotificationsVariables = json_decode($readNotification["variables"],true); ?>
                <a href="#" class="dropdown-item">
                  <div class="icon">
                    <i data-feather="user-plus"></i>
                  </div>
                  <div class="content">
                    <p class="font-weight-bold"><?php echo $readNotificationAccount["username"]; ?></p>
                    <p><?php echo str_replace(array("[username]", "[credit]"), array($readNotificationAccount["username"], $readNotificationsVariables["credit"]), $readNotification['text']); ?></p>
                    <p class="sub-text text-muted"><?php echo checkTime($readNotification["date"]); ?></p>
                  </div>
                </a>
                <?php } } else { echo "<a href=\"#\" class=\"dropdown-item\">".alert(languageVariables("alertNotificationsError", "words", $languageType), "warning", "0", "/")."</a>"; } ?>
              </div>
              <div class="dropdown-footer d-flex align-items-center justify-content-center">
                <a href="#"><?php echo languageVariables("allNotificationsView", "words", $languageType); ?></a>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdowns" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="wd-30 ht-30 rounded-circle" src="<?php echo avatarAPI($readAccount["username"], 100); ?>" alt="<?php echo languageVariables("playerAvatar", "words", $languageType); ?>">
            </a>
            <div class="dropdown-menu p-0" aria-labelledby="profileDropdowns">
              <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                <div class="mb-3">
                  <img class="wd-80 ht-80 rounded-circle" src="<?php echo avatarAPI($readAccount["username"], 100); ?>" alt="<?php echo languageVariables("playerAvatar", "words", $languageType); ?>">
                </div>
                <div class="text-center">
                  <p class="tx-16 fw-bolder"><?php echo $readAccount["username"]; ?></p>
                  <p class="tx-12 text-muted"><?php echo $readAccount["email"]; ?></p>
                </div>
              </div>
              <ul class="list-unstyled p-1">
                <li class="dropdown-item py-2">
                  <a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readAccount["username"]; ?>" class="text-body ms-0">
                    <i class="me-2 icon-md" data-feather="user"></i>
                    <span><?php echo languageVariables("profile", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="dropdown-item py-2">
                  <a href="<?php echo urlConverter("admin_settings_general", $languageType); ?>" class="text-body ms-0">
                    <i class="me-2 icon-md" data-feather="edit"></i>
                    <span><?php echo languageVariables("settings", "words", $languageType); ?></span>
                  </a>
                </li>
                <li class="dropdown-item py-2">
                  <a href="<?php echo urlConverter("logout", $languageType); ?>" class="text-body ms-0">
                    <i class="me-2 icon-md" data-feather="log-out"></i>
                    <span><?php echo languageVariables("logout", "words", $languageType); ?></span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
          <i data-feather="menu"></i>
        </button>
      </div>
    </div>
  </nav>
  <nav class="bottom-navbar">
    <div class="container">
      <ul class="nav page-navigation">
        <li class="nav-item <?php if (get("page") == "home") { echo "active"; } ?>">
          <a class="nav-link" href="<?php echo urlConverter("admin_home", $languageType); ?>">
            <i class="link-icon" data-feather="home"></i>
            <span class="menu-title"><?php echo languageVariables("dashboard", "words", $languageType); ?></span>
          </a>
        </li>
        <li class="nav-item mega-menu <?php if (get("page") == "store") { echo "active"; } ?>">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="shopping-cart"></i>
            <span class="menu-title"><?php echo languageVariables("store", "words", $languageType); ?></span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <div class="col-group-wrapper row">
             <div class="col-group col-md-9">
               <div class="row">
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("server", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_server_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_server", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("category", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_category_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_category", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("product", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_product_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_product", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_product_poster_add", $languageType); ?>"><?php echo languageVariables("posterAdd", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_product_poster", $languageType); ?>"><?php echo languageVariables("posterEdit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("coupon", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_coupon_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_coupon", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-group col-md-3">
               <div class="row">
                 <div class="col-12">
                   <p class="category-heading"><?php echo languageVariables("general", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-12">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_discount", $languageType); ?>"><?php echo languageVariables("totalDiscount", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_extra_credit", $languageType); ?>"><?php echo languageVariables("extraCredit", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_send_invent", $languageType); ?>"><?php echo languageVariables("sendIvent", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_send_credit", $languageType); ?>"><?php echo languageVariables("sendCredit", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_history_store", $languageType); ?>"><?php echo languageVariables("storeHistory", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_history_credit", $languageType); ?>"><?php echo languageVariables("creditTransHistory", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_history_chest", $languageType); ?>"><?php echo languageVariables("chestHistory", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_store_payments", $languageType); ?>"><?php echo languageVariables("payments", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </li>
       <li class="nav-item mega-menu <?php if (get("page") == "forum") { echo "active"; } ?>">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="globe"></i>
            <span class="menu-title"><?php echo languageVariables("forum", "words", $languageType); ?></span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <div class="col-group-wrapper row">
             <div class="col-group col-md-9">
               <div class="row">
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("topics", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_forum_topics", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("category", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_forum_category_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/0"><?php echo languageVariables("edit", "words", $languageType)." (".languageVariables("topCategory", "words", $languageType).")"; ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/1"><?php echo languageVariables("edit", "words", $languageType)." (".languageVariables("subCategory", "words", $languageType).")"; ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("reports", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_forum_reports_message", $languageType); ?>"><?php echo languageVariables("messages", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_forum_reports_topic", $languageType); ?>"><?php echo languageVariables("topics", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("logs", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_forum_logs_message", $languageType); ?>"><?php echo languageVariables("messages", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_forum_logs_topic", $languageType); ?>"><?php echo languageVariables("topics", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </li>
       <li class="nav-item mega-menu <?php if (get("page") == "support") { echo "active"; } ?>">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="aperture"></i>
            <span class="menu-title"><?php echo languageVariables("support", "words", $languageType); ?></span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <div class="col-group-wrapper row">
             <div class="col-group col-md-9">
               <div class="row">
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("helpCenter", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_help_center_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_help_center", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("category", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_category_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_category", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-4">
                   <p class="category-heading"><?php echo languageVariables("readyAnswer", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_ready_answer_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_ready_answer", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-group col-md-3">
               <div class="row">
                 <div class="col-12">
                   <p class="category-heading"><?php echo languageVariables("general", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-12">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_all", $languageType); ?>"><?php echo languageVariables("all", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_not_replys", $languageType); ?>"><?php echo languageVariables("notReplys", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_replys", $languageType); ?>"><?php echo languageVariables("replys", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_support_closed", $languageType); ?>"><?php echo languageVariables("closeds", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </li>
       <li class="nav-item mega-menu <?php if (get("page") == "general") { echo "active"; } ?>">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="bookmark"></i>
            <span class="menu-title"><?php echo languageVariables("general", "words", $languageType); ?></span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <div class="col-group-wrapper row">
             <div class="col-group col-md-12">
               <div class="row">
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("news", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_general_news_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_general_news", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_general_news_comment", $languageType); ?>"><?php echo languageVariables("general", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("category", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_general_news_category_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_general_news_category", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("announcement", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_general_announcement_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_general_announcement", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("page", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_general_page_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_general_page", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </li>
       <li class="nav-item mega-menu <?php if (get("page") == "player") { echo "active"; } ?>">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="menu-title"><?php echo languageVariables("player", "words", $languageType); ?></span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <div class="col-group-wrapper row">
             <div class="col-group col-md-12">
               <div class="row">
                 <div class="col-6">
                   <p class="category-heading"><?php echo languageVariables("players", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player", $languageType); ?>"><?php echo languageVariables("players", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player_owners", $languageType); ?>"><?php echo languageVariables("authorities", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-6">
                   <p class="category-heading"><?php echo languageVariables("ban", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player_banned_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player_banned_all", $languageType); ?>"><?php echo languageVariables("all", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player_banned_site", $languageType); ?>"><?php echo languageVariables("site", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player_banned_comment", $languageType); ?>"><?php echo languageVariables("comment", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player_banned_support", $languageType); ?>"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-6">
                   <p class="category-heading"><?php echo languageVariables("permission", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player_permission_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_player_permissions", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </li>
       <li class="nav-item <?php if (get("page") == "settings") { echo "active"; } ?>">
         <a href="#" class="nav-link">
           <i class="link-icon" data-feather="settings"></i>
           <span class="menu-title"><?php echo languageVariables("settings", "words", $languageType); ?></span>
           <i class="link-arrow"></i>
         </a>
         <div class="submenu">
           <ul class="submenu-item">
             <li class="category-heading"><?php echo languageVariables("general", "words", $languageType); ?></li>
             <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_settings_general", $languageType); ?>"><?php echo languageVariables("settings", "words", $languageType); ?></a></li>
             <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_settings_system", $languageType); ?>"><?php echo languageVariables("systemSettings", "words", $languageType); ?></a></li>
             <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_settings_smtp", $languageType); ?>"><?php echo languageVariables("smtpSettings", "words", $languageType); ?></a></li>
             <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_settings_payment", $languageType); ?>"><?php echo languageVariables("paymentSettings", "words", $languageType); ?></a></li>
             <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_settings_credit", $languageType); ?>"><?php echo languageVariables("creditSettings", "words", $languageType); ?></a></li>
             <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_settings_languages", $languageType); ?>"><?php echo languageVariables("languages", "words", $languageType); ?></a></li>
           </ul>
         </div>
       </li>
       <li class="nav-item mega-menu <?php if (get("page") == "modules") { echo "active"; } ?>">
          <a href="#" class="nav-link">
            <i class="link-icon" data-feather="sliders"></i>
            <span class="menu-title"><?php echo languageVariables("modules", "words", $languageType); ?></span>
            <i class="link-arrow"></i>
          </a>
          <div class="submenu">
            <div class="col-group-wrapper row">
             <div class="col-group col-md-12">
               <div class="row">
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("lottery", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_lottery", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_lottery_history", $languageType); ?>"><?php echo languageVariables("history", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_lottery_winners", $languageType); ?>"><?php echo languageVariables("winners", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("cardGame", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_card_game_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_card_game", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_card_game_history", $languageType); ?>"><?php echo languageVariables("history", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_gift_coupon_add", $languageType); ?>"><?php echo languageVariables("add", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_gift_coupon", $languageType); ?>"><?php echo languageVariables("edit", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_gift_coupon_history", $languageType); ?>"><?php echo languageVariables("history", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("theme", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_theme_css", $languageType); ?>">CSS</a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>"><?php echo languageVariables("themes", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>/default">Default <?php echo languageVariables("theme", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>/south">South <?php echo languageVariables("theme", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>/sitary">Sitary <?php echo languageVariables("theme", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-3">
                   <p class="category-heading">Discord Webhooks</p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_webhook_credit", $languageType); ?>"><?php echo languageVariables("credit", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_webhook_store", $languageType); ?>"><?php echo languageVariables("store", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_webhook_news", $languageType); ?>"><?php echo languageVariables("news", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_webhook_comment", $languageType); ?>"><?php echo languageVariables("comment", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_webhook_support", $languageType); ?>"><?php echo languageVariables("support", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("image", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_image_upload", $languageType); ?>"><?php echo languageVariables("upload", "words", $languageType); ?></a></li>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_image", $languageType); ?>"><?php echo languageVariables("images", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="col-3">
                   <p class="category-heading"><?php echo languageVariables("module", "words", $languageType); ?></p>
                   <div class="submenu-item">
                     <div class="row">
                       <div class="col-md-4">
                         <ul>
                           <li class="nav-item"><a class="nav-link" href="<?php echo urlConverter("admin_modules_module_upload", $languageType); ?>"><?php echo languageVariables("upload", "words", $languageType); ?></a></li>
                         </ul>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </li>
     </ul>
   </div>
 </nav>
</div>
<div class="page-wrapper">
<?php } else { ?>
<nav class="sidebar">
  <div class="sidebar-header">
    <a href="<?php echo urlConverter("admin_home", $languageType); ?>" class="sidebar-brand">
      <?php echo $rSettings["serverName"]; ?>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category"><?php echo languageVariables("home", "words", $languageType); ?></li>
      <li class="nav-item <?php echo ((get("page") == "home") ? "active" : ""); ?>">
        <a href="<?php echo urlConverter("admin_home", $languageType); ?>" class="nav-link">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title"><?php echo languageVariables("dashboard", "words", $languageType); ?></span>
        </a>
      </li>
      <li class="nav-item nav-category"><?php echo languageVariables("store", "words", $languageType); ?></li>
      <li class="nav-item <?php echo ((get("page") == "store" && get("action") == "server") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#store-servers" role="button" aria-expanded="false" aria-controls="store-servers">
          <i class="link-icon" data-feather="layers"></i>
          <span class="link-title"><?php echo languageVariables("server", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="store-servers">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_server_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_server", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "store" && get("action") == "category") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#store-category" role="button" aria-expanded="false" aria-controls="store-category">
          <i class="link-icon" data-feather="align-left"></i>
          <span class="link-title"><?php echo languageVariables("category", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="store-category">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_category_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_category", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "store" && (get("action") == "product" || get("action") == "productPoster")) ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#store-products" role="button" aria-expanded="false" aria-controls="store-products">
          <i class="link-icon" data-feather="archive"></i>
          <span class="link-title"><?php echo languageVariables("product", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="store-products">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_product_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_product", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_product_poster_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("posterAdd", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_product_poster", $languageType); ?>" class="nav-link"><?php echo languageVariables("posterEdit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "store" && get("action") == "coupon") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#store-coupons" role="button" aria-expanded="false" aria-controls="store-coupons">
          <i class="link-icon" data-feather="tag"></i>
          <span class="link-title"><?php echo languageVariables("coupon", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="store-coupons">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_coupon_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_coupon", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "store" && get("action") == "general") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#store-general" role="button" aria-expanded="false" aria-controls="store-general">
          <i class="link-icon" data-feather="aperture"></i>
          <span class="link-title"><?php echo languageVariables("general", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="store-general">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_discount", $languageType); ?>" class="nav-link"><?php echo languageVariables("totalDiscount", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_extra_credit", $languageType); ?>" class="nav-link"><?php echo languageVariables("extraCredit", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_send_invent", $languageType); ?>" class="nav-link"><?php echo languageVariables("sendIvent", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_send_credit", $languageType); ?>" class="nav-link"><?php echo languageVariables("sendCredit", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_history_store", $languageType); ?>" class="nav-link"><?php echo languageVariables("storeHistory", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_history_credit", $languageType); ?>" class="nav-link"><?php echo languageVariables("creditTransHistory", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_history_chest", $languageType); ?>" class="nav-link"><?php echo languageVariables("chestHistory", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_store_payments", $languageType); ?>" class="nav-link"><?php echo languageVariables("payments", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category"><?php echo languageVariables("forum", "words", $languageType); ?></li>
      <li class="nav-item <?php echo ((get("page") == "forum" && get("action") == "topics") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#forum-topics" role="button" aria-expanded="false" aria-controls="forum-topics">
          <i class="link-icon" data-feather="sidebar"></i>
          <span class="link-title"><?php echo languageVariables("topics", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="forum-topics">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_forum_topics", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "forum" && get("action") == "category") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#forum-category" role="button" aria-expanded="false" aria-controls="forum-category">
          <i class="link-icon" data-feather="align-left"></i>
          <span class="link-title"><?php echo languageVariables("category", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="forum-category">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_forum_category_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/0" class="nav-link"><?php echo languageVariables("edit", "words", $languageType)." (".languageVariables("topCategory", "words", $languageType).")"; ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_forum_category", $languageType); ?>/1" class="nav-link"><?php echo languageVariables("edit", "words", $languageType)." (".languageVariables("subCategory", "words", $languageType).")"; ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "forum" && get("action") == "reports") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#forum-reports" role="button" aria-expanded="false" aria-controls="forum-reports">
          <i class="link-icon" data-feather="info"></i>
          <span class="link-title"><?php echo languageVariables("reports", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="forum-reports">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_forum_reports_message", $languageType); ?>" class="nav-link"><?php echo languageVariables("messages", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_forum_reports_topic", $languageType); ?>" class="nav-link"><?php echo languageVariables("topics", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "forum" && get("action") == "logs") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#forum-logs" role="button" aria-expanded="false" aria-controls="forum-logs">
          <i class="link-icon" data-feather="hash"></i>
          <span class="link-title"><?php echo languageVariables("logs", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="forum-logs">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_forum_logs_message", $languageType); ?>" class="nav-link"><?php echo languageVariables("messages", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_forum_logs_topic", $languageType); ?>" class="nav-link"><?php echo languageVariables("topics", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category"><?php echo languageVariables("support", "words", $languageType); ?></li>
      <li class="nav-item <?php echo ((get("page") == "support" && get("action") == "help-center") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#support-help-center" role="button" aria-expanded="false" aria-controls="support-help-center">
          <i class="link-icon" data-feather="info"></i>
          <span class="link-title"><?php echo languageVariables("helpCenter", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="support-help-center">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_help_center_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_help_center", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "support" && get("action") == "category") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#support-category" role="button" aria-expanded="false" aria-controls="support-category">
          <i class="link-icon" data-feather="align-left"></i>
          <span class="link-title"><?php echo languageVariables("category", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="support-category">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_category_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_category", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "support" && get("action") == "repartee") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#support-answeries" role="button" aria-expanded="false" aria-controls="support-answeries">
          <i class="link-icon" data-feather="at-sign"></i>
          <span class="link-title"><?php echo languageVariables("readyAnswer", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="support-answeries">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_ready_answer_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_ready_answer", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "support" && get("action") == "general" || get("action") == "view") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#support-general" role="button" aria-expanded="false" aria-controls="support-general">
          <i class="link-icon" data-feather="aperture"></i>
          <span class="link-title"><?php echo languageVariables("general", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="support-general">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_all", $languageType); ?>" class="nav-link"><?php echo languageVariables("all", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_not_replys", $languageType); ?>" class="nav-link"><?php echo languageVariables("notReplys", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_replys", $languageType); ?>" class="nav-link"><?php echo languageVariables("replys", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_support_closed", $languageType); ?>" class="nav-link"><?php echo languageVariables("closeds", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category"><?php echo languageVariables("general", "words", $languageType); ?></li>
      <li class="nav-item <?php echo ((get("page") == "general" && get("action") == "news" || get("action") == "comments") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#general-news" role="button" aria-expanded="false" aria-controls="general-news">
          <i class="link-icon" data-feather="file-text"></i>
          <span class="link-title"><?php echo languageVariables("news", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="general-news">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_general_news_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_general_news", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_general_news_comment", $languageType); ?>" class="nav-link"><?php echo languageVariables("comments", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "general" && get("action") == "category") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#general-news-category" role="button" aria-expanded="false" aria-controls="general-news-category">
          <i class="link-icon" data-feather="align-left"></i>
          <span class="link-title"><?php echo languageVariables("category", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="general-news-category">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_general_news_category_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_general_news_category", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "general" && get("action") == "broadcast") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#general-broadcast" role="button" aria-expanded="false" aria-controls="general-broadcast">
          <i class="link-icon" data-feather="radio"></i>
          <span class="link-title"><?php echo languageVariables("announcement", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="general-broadcast">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_general_announcement_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_general_announcement", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "general" && get("action") == "pages") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#general-pages" role="button" aria-expanded="false" aria-controls="general-pages">
          <i class="link-icon" data-feather="sidebar"></i>
          <span class="link-title"><?php echo languageVariables("page", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="general-pages">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_general_page_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_general_page", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category"><?php echo languageVariables("player", "words", $languageType); ?></li>
      <li class="nav-item <?php echo ((get("page") == "player" && get("action") == "account") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#player-players" role="button" aria-expanded="false" aria-controls="player-players">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title"><?php echo languageVariables("players", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="player-players">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player", $languageType); ?>" class="nav-link"><?php echo languageVariables("players", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player_owners", $languageType); ?>" class="nav-link"><?php echo languageVariables("authorities", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "player" && get("action") == "banned") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#player-banned" role="button" aria-expanded="false" aria-controls="player-banned">
          <i class="link-icon" data-feather="slash"></i>
          <span class="link-title"><?php echo languageVariables("ban", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="player-banned">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player_banned_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player_banned_all", $languageType); ?>" class="nav-link"><?php echo languageVariables("all", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player_banned_site", $languageType); ?>" class="nav-link"><?php echo languageVariables("site", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player_banned_comment", $languageType); ?>" class="nav-link"><?php echo languageVariables("comment", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player_banned_support", $languageType); ?>" class="nav-link"><?php echo languageVariables("support", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "player" && get("action") == "permission") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#player-perm" role="button" aria-expanded="false" aria-controls="player-perm">
          <i class="link-icon" data-feather="key"></i>
          <span class="link-title"><?php echo languageVariables("permission", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="player-perm">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player_permission_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_player_permissions", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category"><?php echo languageVariables("settings", "words", $languageType); ?></li>
      <li class="nav-item <?php echo ((get("page") == "settings") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#settings" role="button" aria-expanded="false" aria-controls="settings">
          <i class="link-icon" data-feather="settings"></i>
          <span class="link-title"><?php echo languageVariables("settings", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="settings">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_settings_general", $languageType); ?>" class="nav-link"><?php echo languageVariables("generalSettings", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_settings_system", $languageType); ?>" class="nav-link"><?php echo languageVariables("systemSettings", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_settings_smtp", $languageType); ?>" class="nav-link"><?php echo languageVariables("smtpSettings", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_settings_payment", $languageType); ?>" class="nav-link"><?php echo languageVariables("paymentSettings", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_settings_credit", $languageType); ?>" class="nav-link"><?php echo languageVariables("creditSettings", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_settings_languages", $languageType); ?>" class="nav-link"><?php echo languageVariables("languages", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category"><?php echo languageVariables("modules", "words", $languageType); ?></li>
      <li class="nav-item <?php echo ((get("page") == "modules" && get("action") == "lottery") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#modules-lottery" role="button" aria-expanded="false" aria-controls="modules-lottery">
          <i class="link-icon" data-feather="compass"></i>
          <span class="link-title"><?php echo languageVariables("lottery", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="modules-lottery">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_lottery", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_lottery_history", $languageType); ?>" class="nav-link"><?php echo languageVariables("history", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_lottery_winners", $languageType); ?>" class="nav-link"><?php echo languageVariables("winners", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "modules" && get("action") == "cardGame") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#modules-card-game" role="button" aria-expanded="false" aria-controls="modules-card-game">
          <i class="link-icon" data-feather="slack"></i>
          <span class="link-title"><?php echo languageVariables("cardGame", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="modules-card-game">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_card_game_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_card_game", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_card_game_history", $languageType); ?>" class="nav-link"><?php echo languageVariables("history", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "modules" && get("action") == "coupon") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#modules-coupons" role="button" aria-expanded="false" aria-controls="modules-coupons">
          <i class="link-icon" data-feather="gift"></i>
          <span class="link-title"><?php echo languageVariables("giftCoupon", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="modules-coupons">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_gift_coupon_add", $languageType); ?>" class="nav-link"><?php echo languageVariables("add", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_gift_coupon", $languageType); ?>" class="nav-link"><?php echo languageVariables("edit", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_gift_coupon_history", $languageType); ?>" class="nav-link"><?php echo languageVariables("history", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "modules" && get("action") == "theme") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#modules-theme" role="button" aria-expanded="false" aria-controls="modules-theme">
          <i class="link-icon" data-feather="pen-tool"></i>
          <span class="link-title"><?php echo languageVariables("theme", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="modules-theme">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_theme_css", $languageType); ?>" class="nav-link">CSS</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>" class="nav-link"><?php echo languageVariables("themes", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>/default" class="nav-link">Default <?php echo languageVariables("theme", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>/south" class="nav-link">South <?php echo languageVariables("theme", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_theme_edit", $languageType); ?>/sitary" class="nav-link">Sitary <?php echo languageVariables("theme", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "modules" && get("action") == "webhooks") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#modules-webhooks" role="button" aria-expanded="false" aria-controls="modules-webhooks">
          <i class="link-icon" data-feather="airplay"></i>
          <span class="link-title">Discord Webhooks</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="modules-webhooks">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_webhook_credit", $languageType); ?>" class="nav-link"><?php echo languageVariables("credit", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_webhook_store", $languageType); ?>" class="nav-link"><?php echo languageVariables("store", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_webhook_news", $languageType); ?>" class="nav-link"><?php echo languageVariables("news", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_webhook_comment", $languageType); ?>" class="nav-link"><?php echo languageVariables("comment", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_webhook_support", $languageType); ?>" class="nav-link"><?php echo languageVariables("support", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "modules" && get("action") == "images") ? "active" : ""); ?>">
        <a class="nav-link" data-toggle="collapse" href="#modules-image" role="button" aria-expanded="false" aria-controls="modules-image">
          <i class="link-icon" data-feather="file"></i>
          <span class="link-title"><?php echo languageVariables("image", "words", $languageType); ?></span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="modules-image">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_image_upload", $languageType); ?>" class="nav-link"><?php echo languageVariables("upload", "words", $languageType); ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo urlConverter("admin_modules_image", $languageType); ?>" class="nav-link"><?php echo languageVariables("images", "words", $languageType); ?></a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item <?php echo ((get("page") == "modules" && get("action") == "images") ? "active" : ""); ?>">
        <a class="nav-link" href="<?php echo urlConverter("admin_modules_module_upload", $languageType); ?>">
          <i class="link-icon" data-feather="slack"></i>
          <span class="link-title"><?php echo languageVariables("module", "words", $languageType); ?></span>
        </a>
      </li>
      <li class="nav-item nav-category"><?php echo languageVariables("docs", "words", $languageType); ?></li>
      <li class="nav-item">
        <a href="<?php echo urlConverter("help", $languageType); ?>" target="_blank" class="nav-link">
          <i class="link-icon" data-feather="hash"></i>
          <span class="link-title"><?php echo languageVariables("help", "words", $languageType); ?></span>
        </a>
      </li>
    </ul>
  </div>
</nav>
<div class="page-wrapper">
  <nav class="navbar">
    <a href="#" class="sidebar-toggler">
      <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
      <div class="search-form">
        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i data-feather="search"></i>
            </div>
          </div>
          <input type="text" class="form-control" id="navbarForm" placeholder="<?php echo languageVariables("playerSearch", "words", $languageType); ?>" data-toggle="searchAccount">
        </div>
      </div>
      <?php $searchLanguageHeader = $db->query("SELECT * FROM languages ORDER BY id ASC"); ?>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="languageDropdowns" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-<?php echo $languageCountry[$readLang["code"]]; ?> mr-2" title="<?php echo $readLang["title"]; ?>"></i><span class="d-none d-md-inline-block"><?php echo $readLang["title"]; ?></span></a>
          <div class="dropdown-menu" aria-labelledby="languageDropdowns">
            <?php foreach ($searchLanguageHeader as $readLanguageHeader) { ?>
			      <a href="/admin/index.php?language=<?php echo $readLanguageHeader["code"]; ?>&ref=<?php echo $_SERVER["REQUEST_URI"]; ?>" class="dropdown-item py-2"><i class="flag-icon flag-icon-<?php echo $languageCountry[$readLanguageHeader["code"]]; ?> mr-2" title="<?php echo $readLanguageHeader["title"]; ?>"></i> <?php echo $readLanguageHeader["title"]; ?></a>
            <?php } ?>
          </div>
        </li>
        <li class="nav-item dropdown nav-notifications">
          <a class="nav-link dropdown-toggle" href="<?php echo urlConverter("home", $languageType); ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="<?php echo languageVariables("leftHome", "words", $languageType); ?>">
            <i data-feather="home"></i>
          </a>
        </li>
        <li class="nav-item dropdown nav-notifications">
          <a class="nav-link dropdown-toggle" href="/admin/index.php?changeTheme=light&ref=<?php echo $_SERVER["REQUEST_URI"]; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo languageVariables("lightThemeGo", "words", $languageType); ?>">
            <i data-feather="moon"></i>
          </a>
        </li>
        <li class="nav-item dropdown nav-notifications">
          <a class="nav-link dropdown-toggle" href="<?php echo urlConverter("admin_updates", $languageType); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo languageVariables("updates", "words", $languageType); ?>">
            <i data-feather="refresh-ccw"></i>
          </a>
        </li>
        <li class="nav-item dropdown nav-notifications">
          <a class="nav-link dropdown-toggle" href="<?php echo urlConverter("admin_modules_backup", $languageType); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo languageVariables("backups", "words", $languageType); ?>">
            <i data-feather="save"></i>
          </a>
        </li>
        <?php $searchNotification = $db->query("SELECT * FROM systemNotifications ORDER BY id DESC LIMIT 3"); ?>
        <li class="nav-item dropdown nav-notifications">
          <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i data-feather="bell"></i>
            <div class="indicator">
              <div class="circle"></div>
            </div>
          </a>
          <div class="dropdown-menu" aria-labelledby="notificationDropdown">
            <div class="dropdown-header d-flex align-items-center justify-content-between">
              <p class="mb-0 font-weight-medium"><?php echo languageVariables("notifications", "words", $languageType); ?> (<?php echo mysqlCount($searchNotification); ?>)</p>
            </div>
            <div class="dropdown-body">
              <?php if (mysqlCount($searchNotification) > 0) { ?>
              <?php foreach ($searchNotification as $readNotification) { ?>
              <?php $searchNotificationAccount = $db->prepare("SELECT * FROM accounts WHERE id = ?"); ?>
              <?php $searchNotificationAccount->execute(array($readNotification["userID"])); ?>
              <?php $readNotificationAccount = fetch($searchNotificationAccount); ?>
              <?php $readNotificationsVariables = json_decode($readNotification["variables"],true); ?>
                <a href="#" class="dropdown-item">
                  <div class="icon">
                    <i data-feather="user-plus"></i>
                  </div>
                  <div class="content">
                    <p class="font-weight-bold"><?php echo $readNotificationAccount["username"]; ?></p>
                    <p><?php echo str_replace(array("[username]", "[credit]"), array($readNotificationAccount["username"], $readNotificationsVariables["credit"]), $readNotification['text']); ?></p>
                    <p class="sub-text text-muted"><?php echo checkTime($readNotification["date"]); ?></p>
                  </div>
                </a>
              <?php } } else { echo "<a href=\"#\" class=\"dropdown-item\">".alert(languageVariables("alertNotificationsError", "words", $languageType), "warning", "0", "/")."</a>"; } ?>
            </div>
            <div class="dropdown-footer d-flex align-items-center justify-content-center">
              <a href="#"><?php echo languageVariables("allNotificationsView", "words", $languageType); ?></a>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown nav-profile">
          <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="<?php echo avatarAPI($readAccount["username"], 100); ?>" alt="<?php echo languageVariables("playerAvatar", "words", $languageType); ?>">
          </a>
          <div class="dropdown-menu" aria-labelledby="profileDropdown">
            <div class="dropdown-header d-flex flex-column align-items-center">
              <div class="figure mb-3">
                <img src="<?php echo avatarAPI($readAccount["username"], 100); ?>" alt="<?php echo languageVariables("playerAvatar", "words", $languageType); ?>">
              </div>
              <div class="info text-center">
                <p class="name font-weight-bold mb-0"><?php echo $readAccount["username"]; ?></p>
                <p class="email text-muted mb-3"><?php echo $readAccount["email"]; ?></p>
              </div>
            </div>
            <div class="dropdown-body">
              <ul class="profile-nav p-0 pt-3">
                <li class="nav-item">
                    <a href="<?php echo urlConverter("admin_player", $languageType); ?>/<?php echo $readAccount["username"]; ?>" class="nav-link">
                      <i data-feather="user"></i>
                      <span><?php echo languageVariables("profile", "words", $languageType); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo urlConverter("admin_settings_general", $languageType); ?>" class="nav-link">
                      <i data-feather="edit"></i>
                      <span><?php echo languageVariables("settings", "words", $languageType); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo urlConverter("logout", $languageType); ?>" class="nav-link">
                      <i data-feather="log-out"></i>
                      <span><?php echo languageVariables("logout", "words", $languageType); ?></span>
                    </a>
                  </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
<?php } } ?>