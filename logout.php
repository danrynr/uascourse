<?php
$session_name = session_name();
setcookie($session_name, "", -70000, '/');
session_unset();
session_destroy();
header("location:login.php");
exit;
?>