<?php
// Connect to database
$db = new PDO("sqlite:data/stocks.db");
$db ->setAttribure(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get customers
$sql = "SELECT * FROM users";
$result = $db ->query($sql);
$customers = $result->fetchAll(PDO::FETCH_ASSOC);
?>

