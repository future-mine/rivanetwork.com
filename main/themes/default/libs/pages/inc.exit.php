<?php
  AccountLoginControl(false);
  $removeAccountSessions = $db->prepare("DELETE FROM accountLoginSessions WHERE sessionToken = ?");
  $removeAccountSessions->execute(array($_SESSION["incAccountLogin"]));
  deleteCookie("rememberToken");
  session_destroy();
  go("/");
?>