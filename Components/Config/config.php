<?php

try{
    $pdo=new PDO("mysql:host=127.0.0.1;dbname=shopping_site","root","",[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
}catch(Exception $err){
    echo "<pre>";
    die(var_dump($err));
}