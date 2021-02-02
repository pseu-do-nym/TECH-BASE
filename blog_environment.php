<?php
    require("./mypage_title.php");
    if($name==$page) $new_article = '<div align="center"><input type="submit" name="new" value="新規記事作成" style="padding: 15px 40px; font-size: 1.2em;"></div><br><hr>';
    else $new_article = '';
    
    //お気に入りに登録
    if(isset($_POST['fav_register'])):
    
        $stmt = $pdo -> prepare("INSERT IGNORE INTO FAV_LIST (name, fav_name) VALUES (:name, :fav_name)");
        $stmt -> bindValue(':name', $name, PDO::PARAM_STR);
        $stmt -> bindValue(':fav_name', $page, PDO::PARAM_STR);
        $stmt -> execute();
    
    endif;
    
    //お気に入り解除
    if(isset($_POST['fav_delist'])):
    
        $stmt = $pdo -> prepare("DELETE FROM FAV_LIST WHERE name=:name AND fav_name=:fav_name");
        $stmt -> bindValue(':name', $name, PDO::PARAM_STR);
        $stmt -> bindValue(':fav_name', $page, PDO::PARAM_STR);
        $stmt -> execute();
    
    endif;
    
    //お気に入りページに登録するかどうかの表示
    $blog_fav_disp = "";
    if($name!="" && $name!=$page):
    
        $stmt = $pdo -> prepare("SELECT * FROM FAV_LIST WHERE name=:name AND fav_name=:fav_name ORDER BY id DESC");
        $stmt -> bindValue(':name', $name, PDO::PARAM_STR);
        $stmt -> bindValue(':fav_name', $page, PDO::PARAM_STR);
        $stmt -> execute();
        $already_fav = $stmt->rowCount();
    
        if($already_fav == 0) $blog_fav_disp = "<button class='btn-link' type='submit' name='fav_register'>⭐️ お気に入りに登録</button><br>";
        else $blog_fav_disp = "<button class='btn-link' type='submit' name='fav_delist'>⭐️ お気に入りから解除</button><br>";
    
    endif;
    
    $stmt = $pdo -> prepare("SELECT * FROM FAV_LIST WHERE name=:page ORDER BY id ASC");
    $stmt -> bindValue(':page', $page, PDO::PARAM_STR);
    $stmt -> execute();
    $fav_list = $stmt->fetchAll();
    $fav_count = $stmt->rowCount();
    
?>
