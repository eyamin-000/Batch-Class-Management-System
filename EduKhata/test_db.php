<?php
require_once 'config/db.php';

$database = new Database();
$db = $database->getConnection();

if($db) {
    echo "Hooray! Database Connection Successful!";
} else {
    echo "Connection Failed!";
}
?>