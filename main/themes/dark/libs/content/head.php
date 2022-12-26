<!DOCTYPE html>
<html lang="en">
<head>
  <!-- META -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Hasan ESKİSARAÇ">
  <title><?php echo metaTitle(); ?></title>
  <link rel="shortcut icon" href="<?php echo $rSettings['serverLogo']; ?>">
  <meta name="description" content="<?php echo $metaDescription; ?>" />
  <meta name="keywords" content="<?php echo $metaKeyword; ?>" />
  <link rel="canonical" href="<?php echo $siteURL; ?>" />
  <meta property="og:locale" content="<?php echo $languageType; ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?php echo metaTitle(); ?>">
  <meta property="og:description" content="<?php echo $metaDescription; ?>">
  <meta property="og:url" content="<?php echo $siteURL; ?>" />
  <meta property="og:site_name" content="<?php echo $rSettings['serverName']; ?>" />

<!-- MAIN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">
  <link rel="stylesheet" href="/main/themes/dark/theme/assets/css/style.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
</head>
<style type="text/css">
.overflow-auto { overflow: auto; }
footer .footer-details .mail::before {content: "<?php echo languageVariables("email", "words", $languageType); ?>:"!important;}
.turkish-lira::after {content: "<?php echo languageVariables("currencyIcon", "words", $languageType); ?>";}
<?php echo $readTheme["CSS"]; ?>
.select-none{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
</style>
<body class="bg-dark--4 tab-bar-padding">