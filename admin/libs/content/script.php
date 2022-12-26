  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/mode/css/css.min.js"></script>
  <script type="text/javascript" src="/admin/theme/sources/vendors/core/core.js"></script>

  <script type="text/javascript">
    const $languages = {
      success: "<?php echo str_replace('"', '\"', languageVariables("success", "javascript", $languageType)); ?>",
      error: "<?php echo str_replace('"', '\"', languageVariables("error", "javascript", $languageType)); ?>",
      warning: "<?php echo str_replace('"', '\"', languageVariables("warning", "javascript", $languageType)); ?>",
      credit: "<?php echo str_replace('"', '\"', languageVariables("credit", "javascript", $languageType)); ?>",
      product: "<?php echo str_replace('"', '\"', languageVariables("product", "javascript", $languageType)); ?>",
      approve: "<?php echo str_replace('"', '\"', languageVariables("approve", "javascript", $languageType)); ?>",
      giveUp: "<?php echo str_replace('"', '\"', languageVariables("giveUp", "javascript", $languageType)); ?>",
      okey: "<?php echo str_replace('"', '\"', languageVariables("okey", "javascript", $languageType)); ?>",
      currency: "<?php echo str_replace('"', '\"', languageVariables("currency", "words", $languageType)); ?>",
      currencyIcon: "<?php echo str_replace('"', '\"', languageVariables("currencyIcon", "words", $languageType)); ?>",
      day: "<?php echo str_replace('"', '\"', languageVariables("day", "words", $languageType)); ?>",
      clear: "<?php echo str_replace('"', '\"', languageVariables("clear", "words", $languageType)); ?>",
      title: "<?php echo str_replace('"', '\"', languageVariables("title", "words", $languageType)); ?>",
      search: "<?php echo str_replace('"', '\"', languageVariables("search", "words", $languageType)); ?>",
      content: "<?php echo str_replace('"', '\"', languageVariables("content", "words", $languageType)); ?>",
      month01: "<?php echo str_replace('"', '\"', languageVariables("month01", "date", $languageType)); ?>",
      month02: "<?php echo str_replace('"', '\"', languageVariables("month02", "date", $languageType)); ?>",
      month03: "<?php echo str_replace('"', '\"', languageVariables("month03", "date", $languageType)); ?>",
      month04: "<?php echo str_replace('"', '\"', languageVariables("month04", "date", $languageType)); ?>",
      month05: "<?php echo str_replace('"', '\"', languageVariables("month05", "date", $languageType)); ?>",
      month06: "<?php echo str_replace('"', '\"', languageVariables("month06", "date", $languageType)); ?>",
      month07: "<?php echo str_replace('"', '\"', languageVariables("month07", "date", $languageType)); ?>",
      month08: "<?php echo str_replace('"', '\"', languageVariables("month08", "date", $languageType)); ?>",
      month09: "<?php echo str_replace('"', '\"', languageVariables("month09", "date", $languageType)); ?>",
      month10: "<?php echo str_replace('"', '\"', languageVariables("month10", "date", $languageType)); ?>",
      month11: "<?php echo str_replace('"', '\"', languageVariables("month11", "date", $languageType)); ?>",
      month12: "<?php echo str_replace('"', '\"', languageVariables("month12", "date", $languageType)); ?>",
      day01: "<?php echo str_replace('"', '\"', languageVariables("day01", "date", $languageType)); ?>",
      day02: "<?php echo str_replace('"', '\"', languageVariables("day01", "date", $languageType)); ?>",
      day03: "<?php echo str_replace('"', '\"', languageVariables("day01", "date", $languageType)); ?>",
      day04: "<?php echo str_replace('"', '\"', languageVariables("day01", "date", $languageType)); ?>",
      day05: "<?php echo str_replace('"', '\"', languageVariables("day01", "date", $languageType)); ?>",
      day06: "<?php echo str_replace('"', '\"', languageVariables("day01", "date", $languageType)); ?>",
      day07: "<?php echo str_replace('"', '\"', languageVariables("day01", "date", $languageType)); ?>",
      minMonth01: "<?php echo str_replace('"', '\"', languageVariables("minMonth01", "date", $languageType)); ?>",
      minMonth02: "<?php echo str_replace('"', '\"', languageVariables("minMonth02", "date", $languageType)); ?>",
      minMonth03: "<?php echo str_replace('"', '\"', languageVariables("minMonth03", "date", $languageType)); ?>",
      minMonth04: "<?php echo str_replace('"', '\"', languageVariables("minMonth04", "date", $languageType)); ?>",
      minMonth05: "<?php echo str_replace('"', '\"', languageVariables("minMonth05", "date", $languageType)); ?>",
      minMonth06: "<?php echo str_replace('"', '\"', languageVariables("minMonth06", "date", $languageType)); ?>",
      minMonth07: "<?php echo str_replace('"', '\"', languageVariables("minMonth07", "date", $languageType)); ?>",
      minMonth08: "<?php echo str_replace('"', '\"', languageVariables("minMonth08", "date", $languageType)); ?>",
      minMonth09: "<?php echo str_replace('"', '\"', languageVariables("minMonth09", "date", $languageType)); ?>",
      minMonth10: "<?php echo str_replace('"', '\"', languageVariables("minMonth10", "date", $languageType)); ?>",
      minMonth11: "<?php echo str_replace('"', '\"', languageVariables("minMonth11", "date", $languageType)); ?>",
      minMonth12: "<?php echo str_replace('"', '\"', languageVariables("minMonth12", "date", $languageType)); ?>",
      minDay01: "<?php echo str_replace('"', '\"', languageVariables("minDay01", "date", $languageType)); ?>",
      minDay02: "<?php echo str_replace('"', '\"', languageVariables("minDay02", "date", $languageType)); ?>",
      minDay03: "<?php echo str_replace('"', '\"', languageVariables("minDay03", "date", $languageType)); ?>",
      minDay04: "<?php echo str_replace('"', '\"', languageVariables("minDay04", "date", $languageType)); ?>",
      minDay05: "<?php echo str_replace('"', '\"', languageVariables("minDay05", "date", $languageType)); ?>",
      minDay06: "<?php echo str_replace('"', '\"', languageVariables("minDay06", "date", $languageType)); ?>",
      minDay07: "<?php echo str_replace('"', '\"', languageVariables("minDay07", "date", $languageType)); ?>",
      sales: "<?php echo str_replace('"', '\"', languageVariables("sales", "javascript", $languageType)); ?>",
      controlLoading: "<?php echo str_replace('"', '\"', languageVariables("controlLoading", "javascript", $languageType)); ?>",
      modulesRewardType: "<?php echo str_replace('"', '\"', languageVariables("modulesRewardType", "javascript", $languageType)); ?>",
      modulesRewardAmount: "<?php echo str_replace('"', '\"', languageVariables("modulesRewardAmount", "javascript", $languageType)); ?>",
      modulesRewardTitle: "<?php echo str_replace('"', '\"', languageVariables("modulesRewardTitle", "javascript", $languageType)); ?>",
      modulesRewardChance: "<?php echo str_replace('"', '\"', languageVariables("modulesRewardChance", "javascript", $languageType)); ?>",
      modulesRewardImage: "<?php echo str_replace('"', '\"', languageVariables("modulesRewardImage", "javascript", $languageType)); ?>",
      modulesRewardNone: "<?php echo str_replace('"', '\"', languageVariables("modulesRewardNone", "javascript", $languageType)); ?>",
      updatesAlertNot: "<?php echo str_replace('"', '\"', languageVariables("updatesAlertNot", "javascript", $languageType)); ?>",
      updatesApproveText: "<?php echo str_replace('"', '\"', languageVariables("updatesApproveText", "javascript", $languageType)); ?>",
      updatesUpdateLoading: "<?php echo str_replace('"', '\"', languageVariables("updatesUpdateLoading", "javascript", $languageType)); ?>",
      updatesAlertSuccess: "<?php echo str_replace('"', '\"', languageVariables("updatesAlertSuccess", "javascript", $languageType)); ?>"
    };

    const $links = {
      admin_player: "<?php echo urlConverter("admin_player", $languageType); ?>"
    };
  </script>

  <script type="text/javascript" src="/admin/theme/sources/vendors/dropimage/js/dropimage.min.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/admin/theme/sources/vendors/chartjs/Chart.min.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/admin/theme/sources/vendors/jquery.flot/jquery.flot.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/admin/theme/sources/vendors/jquery.flot/jquery.flot.resize.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/admin/theme/sources/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/js/bootstrap-iconpicker.bundle.min.js"></script>
  <script type="text/javascript" src="/admin/theme/sources/vendors/apexcharts/apexcharts.min.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/admin/theme/sources/vendors/progressbar.js/progressbar.min.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/admin/theme/sources/vendors/feather-icons/feather.min.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script type="text/javascript" src="/admin/theme/sources/vendors/tableitems/js/tableitems.min.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/js/froala_editor.pkgd.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/js/languages/<?php echo $languageType; ?>.js"></script>
  <script type="text/javascript" src="/admin/theme/sources/js/template.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/admin/theme/sources/js/dashboard.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/admin/theme/sources/js/chat.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript" src="/admin/theme/sources/js/datepicker.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <script type="text/javascript">
    var $theme = "<?php echo (($_SESSION["adminThemeModeType"] == "light") ? "default" : "dark"); ?>";
    var $language = "<?php echo $languageType; ?>";
  </script>
  <script type="text/javascript" src="/admin/theme/sources/layouts/main.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php if (get("page") == "store") { ?>
  <script type="text/javascript" src="/admin/theme/sources/layouts/store.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php if (get("target") == "payments") { ?>
  <script type="text/javascript" src="/admin/theme/sources/layouts/payments.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } ?>
  <?php } else if (get("page") == "support") { ?>
  <?php if (get("topicID") !== "") { ?>
  <script type="text/javascript">
    $('[data-toggle="iconpicker"]').iconpicker("setIcon", "<?php echo $readHelpCenter["categoryIcon"]; ?>");
  </script>
  <?php } ?>
  <script type="text/javascript" src="/admin/theme/sources/layouts/support.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if (get("page") == "general") { ?>
  <script type="text/javascript" src="/admin/theme/sources/layouts/general.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if (get("page") == "player") { ?>
  <script type="text/javascript" src="/admin/theme/sources/layouts/player.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if (get("page") == "settings") { ?>
  <script type="text/javascript" src="/admin/theme/sources/layouts/settings.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if (get("page") == "modules") { ?>
  <script type="text/javascript" src="/admin/theme/sources/layouts/modules.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if (get("page") == "forum") { ?>
  <script type="text/javascript" src="/admin/theme/sources/layouts/forum.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if (get("page") == "updates") { ?>
  <script type="text/javascript">
    var $sweetAlertBackgroundColor = "<?php echo (($_SESSION["adminThemeModeType"] == "light") ? "#ffffff" : "#0f1531"); ?>";
  </script>
  <script type="text/javascript" src="/admin/theme/sources/layouts/updates.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } else if (get("page") == "home") { ?>
  <script type="text/javascript" src="/admin/theme/sources/layouts/home.js?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>"></script>
  <?php } ?>
</body>
</html>