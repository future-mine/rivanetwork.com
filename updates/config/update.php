<?php
$MySQLDatabaseCode = "
";
$MySQLDatabaseUpdate = $db->exec($MySQLDatabaseCode);
unlink(__DR__."/updates/sql/update.sql");
?>