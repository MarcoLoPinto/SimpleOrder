<?php
header("Location: index.php");

session_start();
unset($_SESSION);
session_destroy();

?>
