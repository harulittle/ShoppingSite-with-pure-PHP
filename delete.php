<?php

require "../config/common.php";
require "../config/config.php";

$id=$_GET['id'];
$stmt=$pdo->prepare("delete from products where id = ?");
$stmt->execute([$id]);
header("location:index.php");