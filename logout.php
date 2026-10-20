<?php
session_start();
session_unset();
session_destroy();
header('Location: ' . (defined('APP_URL') ? APP_URL . '/index.php' : 'index.php'));
exit;
?>