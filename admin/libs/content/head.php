<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $rSettings["serverName"]; ?> - <?php echo languageVariables("dashboard", "words", $languageType); ?></title>
  <link rel="stylesheet" type="text/css" href="/admin/theme/sources/vendors/core/core.css">
  <link rel="stylesheet" type="text/css" href="/admin/theme/sources/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <link rel="stylesheet" type="text/css" href="/admin/theme/assets/fonts/feather-font/css/iconfont.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.css">
  <link rel="stylesheet" type="text/css" href="/admin/theme/sources/vendors/dropimage/css/<?php echo $_SESSION["adminThemeModeType"]; ?>.min.css?v=1">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/css/bootstrap-iconpicker.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/css/froala_editor.pkgd.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/css/froala_style.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.9.1/css/themes/dark.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/codemirror.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/theme/material.min.css">
  <link rel="stylesheet" type="text/css" href="/admin/theme/assets/<?php echo $_SESSION["adminThemeModeType"]; ?>/css/style.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" type="text/css" href="/admin/theme/assets/<?php echo $_SESSION["adminThemeModeType"]; ?>/css/edit.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="shortcut icon" href="<?php echo $rSettings["serverLogo"]; ?>" />
</head>
<style type="text/css">
.fa-lira-sign:before {content: '<?php echo languageVariables("currencyIcon", "words", $languageType); ?>' !important;}
.fa-dollar-sign:before {content: '<?php echo languageVariables("currencyIcon", "words", $languageType); ?>' !important;}
</style>
<body>
  <div class="main-wrapper">