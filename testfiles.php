<?php

    //4-1. データベースへの接続
    $dsn = 'mysql:dbname=tb220906db;host=localhost';
    $user = 'tb-220906';
    $password = '32U4f7YhTm';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    

  
//    $stmt = $pdo -> prepare("ALTER TABLE ARTICLE ADD fav int DEFAULT 0;");
//    $stmt -> execute();
//
//    $stmt = $pdo -> prepare("ALTER TABLE ARTICLE ADD private boolean DEFAULT FALSE;");
//    $stmt -> execute();
//
//    $stmt = $pdo -> prepare("ALTER TABLE TEMP_ARTICLE ADD fav int DEFAULT 0;");
//    $stmt -> execute();
//
//    $stmt = $pdo -> prepare("ALTER TABLE TEMP_ARTICLE ADD private boolean DEFAULT FALSE;");
//    $stmt -> execute();
    
//        $stmt = $pdo -> prepare("ALTER TABLE TEMP_ARTICLE DROP COLUMN fav;");
//        $stmt -> execute();
    
    $sql ='DESCRIBE ARTICLE';
    $result = $pdo -> query($sql); //戻り値はテーブル名のリスト？
    foreach ($result as $row){
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";
    
    $sql ='DESCRIBE TEMP_ARTICLE';
    $result = $pdo -> query($sql); //戻り値はテーブル名のリスト？
    foreach ($result as $row){
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";
    
?>
