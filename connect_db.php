<?php

    $dsn = 'mysql:dbname=tb220906db;host=localhost';
    $user = 'tb-220906';
    $password = '32U4f7YhTm';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql = "CREATE TABLE IF NOT EXISTS ARTICLE"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(64),"
    . "title char(64),"
    . "date char(32),"
    . "edit_date char(32),"
    . "tag char(128),"
    . "str text,"
    . "fav int,"
    . "private boolean"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS TEMP_ARTICLE"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(64),"
    . "title char(64),"
    . "edit_date char(32),"
    . "tag char(128),"
    . "str text,"
    . "private boolean"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS ARTICLE_COMMENT"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(64),"
    . "art_id int,"
    . "title char(64),"
    . "poster_name char(64),"
    . "poster_account char(64),"
    . "date char(32),"
    . "str text,"
    . "private boolean,"
    . "del boolean"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS BOARD_COMMENT"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(64),"
    . "category char(64),"
    . "poster_name char(64),"
    . "poster_account char(64),"
    . "date char(32),"
    . "str text,"
    . "del int"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS BLOGTITLE"
    ." ("
    . "name char(64) PRIMARY KEY,"
    . "blogtitle char(64),"
    . "blogsubtitle char(64),"
    . "blogcolor char(16),"
    . "category char(32),"
    . "nickname char(64),"
    . "profile char(64),"
    . "prof_img char(64),"
    . "private boolean"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS IMG_LIST"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(64),"
    . "img_title char(64),"
    . "date char(32)"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS FAV_LIST"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(64),"
    . "fav_name char(64)"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS UNTREATED"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(64),"
    . "pass char(64),"
    . "birthday char(32),"
    . "mail char(64),"
    . "authentication char(16)"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS REGISTRATION"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(64),"
    . "pass char(64),"
    . "birthday char(32),"
    . "mail char(64)"
    .");";
    $stmt = $pdo->query($sql);
    
?>
