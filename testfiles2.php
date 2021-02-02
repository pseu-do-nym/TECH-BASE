<?php

    //4-1. データベースへの接続
    $dsn = 'mysql:dbname=tb220906db;host=localhost';
    $user = 'tb-220906';
    $password = '32U4f7YhTm';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
//    $stmt = $pdo -> prepare("ALTER TABLE BLOGTITLE ADD private boolean DEFAULT FALSE;");
//    $stmt -> execute();
    
//    $stmt = $pdo -> prepare("ALTER TABLE BLOGTITLE ADD category char(32) DEFAULT '指定なし';");
//    $stmt -> execute();
    
//    $stmt = $pdo -> prepare("ALTER TABLE BLOGTITLE ADD nickname char(64)");
//    $stmt -> execute();
//
//    $stmt = $pdo -> prepare("ALTER TABLE BLOGTITLE ADD profile char(64) DEFAULT '';");
//    $stmt -> execute();
//
//    $stmt = $pdo -> prepare("ALTER TABLE BLOGTITLE ADD prof_img char(64) DEFAULT 'avatar_default.png';");
//    $stmt -> execute();
    
//    $stmt = $pdo -> prepare("ALTER TABLE BOARD_COMMENT DROP title;");
//    $stmt -> execute();
        
//        $stmt = $pdo -> prepare("ALTER TABLE ARTICLE_COMMENT MODIFY del int DEFAULT 0;");
//        $stmt -> execute();
//        $stmt = $pdo -> prepare("ALTER TABLE BOARD_COMMENT ADD del boolean DEFAULT FALSE;");
//        $stmt -> execute();
    
//    $stmt = $pdo -> prepare("UPDATE IMG_LIST SET img_title=CONCAT('img/test/',img_title)");
//    $stmt -> execute();
    
//    $stmt = $pdo -> prepare("UPDATE BLOGTITLE SET prof_img=CONCAT('img/',prof_img)");
//    $stmt -> execute();
    
//    $stmt = $pdo -> prepare("DELETE FROM BLOGTITLE WHERE name='test2'");
//    $stmt -> execute();
    
//$stmt = $pdo -> prepare("DROP TABLE BOARD_COMMENT");
//$stmt -> execute();
    
//
//    $sql = $pdo -> prepare("INSERT INTO REGISTRATION (name, pass, birthday, mail)
//    VALUES (:name, :pass, :birthday, :mail)");
//    $sql -> bindValue(':name', "guest", PDO::PARAM_STR);
//    $sql -> bindValue(':pass', "guest1234", PDO::PARAM_STR);
//    $sql -> bindValue(':birthday', null, PDO::PARAM_NULL);
//    $sql -> bindValue(':mail', null, PDO::PARAM_NULL);
//    $sql -> execute();
//
//    $sql = $pdo -> prepare("INSERT INTO REGISTRATION (name, pass, birthday, mail)
//    VALUES (:name, :pass, :birthday, :mail)");
//    $sql -> bindValue(':name', "test2", PDO::PARAM_STR);
//    $sql -> bindValue(':pass', "testes", PDO::PARAM_STR);
//    $sql -> bindValue(':birthday', null, PDO::PARAM_NULL);
//    $sql -> bindValue(':mail', null, PDO::PARAM_NULL);
//    $sql -> execute();
    
//      $sql = $pdo -> prepare("DELETE FROM REGISTRATION WHERE id NOT IN (SELECT min_id from (SELECT MIN(id) min_id FROM REGISTRATION GROUP BY name) tmp)");
//      $sql -> execute();
                             
//     $sql ='SELECT * from ARTICLE';
//     $result = $pdo -> query($sql); //戻り値はテーブル名のリスト？
//     foreach ($result as $row){
//         echo $row['title'];
//         echo '<br>';
//     }
//     echo "<hr>";
    
    $sql ='DESCRIBE BOARD_COMMENT';
    $result = $pdo -> query($sql); //戻り値はテーブル名のリスト？
    foreach ($result as $row){
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";
//
    echo "本登録が完了いたしました！<br>トップページから再度ログインをお願いいたします。<br>";
                           
?>
