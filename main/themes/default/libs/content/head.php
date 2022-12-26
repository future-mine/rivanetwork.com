<?php $themeDefaultVariables = json_decode($readTheme["defaultVariables"], true);?>
<!doctype html>
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

  <link rel="stylesheet" href="/main/themes/default/theme/assets/css/fontawesome-all.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/default/theme/assets/fonts/import/Poppins.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/default/theme/assets/fonts/import/Nunito.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <?php if ($incRequirePage == "profile") { ?>
  <link rel="stylesheet" href="/main/includes/packages/layouts/dropimage/css/dropimage.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <?php } ?>
  <style type="text/css">:root{--default-black:0 0 0;--default-white:255 255 255;--default-slate-50:248 250 252;--default-slate-100:241 245 249;--default-slate-200:226 232 240;--default-slate-300:203 213 225;--default-slate-400:148 163 184;--default-slate-500:100 116 139;--default-slate-600:71 85 105;--default-slate-700:51 65 85;--default-slate-800:30 41 59;--default-slate-900:15 23 42;--default-gray-50:249 250 251;--default-gray-100:243 244 246;--default-gray-200:229 231 235;--default-gray-300:209 213 219;--default-gray-400:156 163 175;--default-gray-500:107 114 128;--default-gray-600:75 85 99;--default-gray-700:55 65 81;--default-gray-800:31 41 55;--default-gray-900:17 24 39;--default-zinc-50:250 250 250;--default-zinc-100:244 244 245;--default-zinc-200:228 228 231;--default-zinc-300:212 212 216;--default-zinc-400:161 161 170;--default-zinc-500:113 113 122;--default-zinc-600:82 82 91;--default-zinc-700:63 63 70;--default-zinc-800:39 39 42;--default-zinc-900:24 24 27;--default-neutral-50:250 250 250;--default-neutral-100:245 245 245;--default-neutral-200:229 229 229;--default-neutral-300:212 212 212;--default-neutral-400:163 163 163;--default-neutral-500:115 115 115;--default-neutral-600:82 82 82;--default-neutral-700:64 64 64;--default-neutral-800:38 38 38;--default-neutral-900:23 23 23;--default-stone-50:250 250 249;--default-stone-100:245 245 244;--default-stone-200:231 229 228;--default-stone-300:214 211 209;--default-stone-400:168 162 158;--default-stone-500:120 113 108;--default-stone-600:87 83 78;--default-stone-700:68 64 60;--default-stone-800:41 37 36;--default-stone-900:28 25 23;--default-red-50:254 242 242;--default-red-100:254 226 226;--default-red-200:254 202 202;--default-red-300:252 165 165;--default-red-400:248 113 113;--default-red-500:239 68 68;--default-red-600:220 38 38;--default-red-700:185 28 28;--default-red-800:153 27 27;--default-red-900:127 29 29;--default-orange-50:255 247 237;--default-orange-100:255 237 213;--default-orange-200:254 215 170;--default-orange-300:253 186 116;--default-orange-400:251 146 60;--default-orange-500:249 115 22;--default-orange-600:234 88 12;--default-orange-700:194 65 12;--default-orange-800:154 52 18;--default-orange-900:124 45 18;--default-amber-50:255 251 235;--default-amber-100:254 243 199;--default-amber-200:253 230 138;--default-amber-300:252 211 77;--default-amber-400:251 191 36;--default-amber-500:245 158 11;--default-amber-600:217 119 6;--default-amber-700:180 83 9;--default-amber-800:146 64 14;--default-amber-900:120 53 15;--default-yellow-50:254 252 232;--default-yellow-100:254 249 195;--default-yellow-200:254 240 138;--default-yellow-300:253 224 71;--default-yellow-400:250 204 21;--default-yellow-500:234 179 8;--default-yellow-600:202 138 4;--default-yellow-700:161 98 7;--default-yellow-800:133 77 14;--default-yellow-900:113 63 18;--default-lime-50:247 254 231;--default-lime-100:236 252 203;--default-lime-200:217 249 157;--default-lime-300:190 242 100;--default-lime-400:163 230 53;--default-lime-500:132 204 22;--default-lime-600:101 163 13;--default-lime-700:77 124 15;--default-lime-800:63 98 18;--default-lime-900:54 83 20;--default-green-50:240 253 244;--default-green-100:220 252 231;--default-green-200:187 247 208;--default-green-300:134 239 172;--default-green-400:74 222 128;--default-green-500:34 197 94;--default-green-600:22 163 74;--default-green-700:21 128 61;--default-green-800:22 101 52;--default-green-900:20 83 45;--default-emerald-50:236 253 245;--default-emerald-100:209 250 229;--default-emerald-200:167 243 208;--default-emerald-300:110 231 183;--default-emerald-400:52 211 153;--default-emerald-500:16 185 129;--default-emerald-600:5 150 105;--default-emerald-700:4 120 87;--default-emerald-800:6 95 70;--default-emerald-900:6 78 59;--default-teal-50:240 253 250;--default-teal-100:204 251 241;--default-teal-200:153 246 228;--default-teal-300:94 234 212;--default-teal-400:45 212 191;--default-teal-500:20 184 166;--default-teal-600:13 148 136;--default-teal-700:15 118 110;--default-teal-800:17 94 89;--default-teal-900:19 78 74;--default-cyan-50:236 254 255;--default-cyan-100:207 250 254;--default-cyan-200:165 243 252;--default-cyan-300:103 232 249;--default-cyan-400:34 211 238;--default-cyan-500:6 182 212;--default-cyan-600:8 145 178;--default-cyan-700:14 116 144;--default-cyan-800:21 94 117;--default-cyan-900:22 78 99;--default-sky-50:240 249 255;--default-sky-100:224 242 254;--default-sky-200:186 230 253;--default-sky-300:125 211 252;--default-sky-400:56 189 248;--default-sky-500:14 165 233;--default-sky-600:2 132 199;--default-sky-700:3 105 161;--default-sky-800:7 89 133;--default-sky-900:12 74 110;--default-blue-50:239 246 255;--default-blue-100:219 234 254;--default-blue-200:191 219 254;--default-blue-300:147 197 253;--default-blue-400:96 165 250;--default-blue-500:59 130 246;--default-blue-600:37 99 235;--default-blue-700:29 78 216;--default-blue-800:30 64 175;--default-blue-900:30 58 138;--default-indigo-50:238 242 255;--default-indigo-100:224 231 255;--default-indigo-200:199 210 254;--default-indigo-300:165 180 252;--default-indigo-400:129 140 248;--default-indigo-500:99 102 241;--default-indigo-600:79 70 229;--default-indigo-700:67 56 202;--default-indigo-800:55 48 163;--default-indigo-900:49 46 129;--default-violet-50:245 243 255;--default-violet-100:237 233 254;--default-violet-200:221 214 254;--default-violet-300:196 181 253;--default-violet-400:167 139 250;--default-violet-500:139 92 246;--default-violet-600:124 58 237;--default-violet-700:109 40 217;--default-violet-800:91 33 182;--default-violet-900:76 29 149;--default-purple-50:250 245 255;--default-purple-100:243 232 255;--default-purple-200:233 213 255;--default-purple-300:216 180 254;--default-purple-400:192 132 252;--default-purple-500:168 85 247;--default-purple-600:147 51 234;--default-purple-700:126 34 206;--default-purple-800:107 33 168;--default-purple-900:88 28 135;--default-fuchsia-50:253 244 255;--default-fuchsia-100:250 232 255;--default-fuchsia-200:245 208 254;--default-fuchsia-300:240 171 252;--default-fuchsia-400:232 121 249;--default-fuchsia-500:217 70 239;--default-fuchsia-600:192 38 211;--default-fuchsia-700:162 28 175;--default-fuchsia-800:134 25 143;--default-fuchsia-900:112 26 117;--default-pink-50:253 242 248;--default-pink-100:252 231 243;--default-pink-200:251 207 232;--default-pink-300:249 168 212;--default-pink-400:244 114 182;--default-pink-500:236 72 153;--default-pink-600:219 39 119;--default-pink-700:190 24 93;--default-pink-800:157 23 77;--default-pink-900:131 24 67;--default-rose-50:255 241 242;--default-rose-100:255 228 230;--default-rose-200:254 205 211;--default-rose-300:253 164 175;--default-rose-400:251 113 133;--default-rose-500:244 63 94;--default-rose-600:225 29 72;--default-rose-700:190 18 60;--default-rose-800:159 18 57;--default-rose-900:136 19 55;/** THEME COLOR */--default-indigo-50: <?php echo colorConvert($themeDefaultVariables["color"]["50"]); ?>;--default-indigo-100: <?php echo colorConvert($themeDefaultVariables["color"]["100"]); ?>;--default-indigo-200: <?php echo colorConvert($themeDefaultVariables["color"]["200"]); ?>;--default-indigo-300: <?php echo colorConvert($themeDefaultVariables["color"]["300"]); ?>;--default-indigo-400: <?php echo colorConvert($themeDefaultVariables["color"]["400"]); ?>;--default-indigo-500: <?php echo colorConvert($themeDefaultVariables["color"]["500"]); ?>;--default-indigo-600: <?php echo colorConvert($themeDefaultVariables["color"]["600"]); ?>;--default-indigo-700: <?php echo colorConvert($themeDefaultVariables["color"]["700"]); ?>;--default-indigo-800: <?php echo colorConvert($themeDefaultVariables["color"]["800"]); ?>;--default-indigo-900: <?php echo colorConvert($themeDefaultVariables["color"]["900"]); ?>;/** THEME END COLOR */}</style>
  <link rel="stylesheet" href="/main/themes/default/theme/assets/libraries/sweatalert2/sweatalert2.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/default/theme/assets/css/main.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/default/theme/assets/css/owl.carousel.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
  <link rel="stylesheet" href="/main/themes/default/theme/assets/css/owl.theme.default.min.css?v=<?php echo $_CONFIG["VERSION_NUMBER"]; ?>">
</head>
<style type="text/css">
<?php if ($themeDefaultVariables["bodyType"] == "0") { ?>
.body-image {
    background-image: url('<?php echo $themeDefaultVariables["bodyImage"]; ?>');
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    background-size: cover;
}
<?php } else if ($themeDefaultVariables["bodyType"] == "1") { ?>
.body-image {
  background-image: url('<?php echo $themeDefaultVariables["bodyImage"]; ?>');
}
<?php } ?>
<?php echo $readTheme["CSS"]; ?>
.nav .nav-menu .nav-item {
  padding-left: 0.7rem !important;
  padding-right: 0.7rem !important;
}
</style>
<body>
<?php if ($readModule["preloaderStatus"] == "1") { ?>
<div class="page-loader">
  <div class="boxes mx-auto my-auto" style="position: absolute;">
    <div class="box"><div></div><div></div><div></div><div></div></div>
    <div class="box"><div></div><div></div><div></div><div></div></div>
    <div class="box"><div></div><div></div><div></div><div></div></div>
    <div class="box"><div></div><div></div><div></div><div></div></div>
  </div>
</div>
<?php } ?>
  <div id="app">