<?php
session_start();
session_destroy(); // clear all data
header("Location: index.php"); // Redirect to Login
exit();
?>