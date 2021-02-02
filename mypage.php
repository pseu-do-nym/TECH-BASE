<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
        <link rel="stylesheet" href="./layout.css">
    </head>
    <body>

        <form action="" method="post" accept-charset="UTF-8">

            <div class="head">

                <?php
                    
                    require("./connect_db.php");
                    if($_SESSION['name']!="") require("mypage_header.php");
                    else require("toppage_header.php");
                    
                    require("./blog_jump.php");
                    
                    $name = $_SESSION['name'];
                    $page = $_SESSION['page'];
                    
                    if(isset($_POST['new'])):
                    
                        $_SESSION['mode'] = 'new';
                    
                    endif;
                    
                    if(isset($_SESSION['mode'])):
                    
                        //編集画面へのモード変更
                        if(isset($_POST['edit_art'])):

                            $_SESSION['edit_art_id'] = $_POST['edit_art'];
                            $_SESSION['mode'] = 'edit';
                            
                        endif;
                    
                        //個別記事へのモード変更
                        if(isset($_POST['indiv_art'])):
                    
                            $_SESSION['edit_art_id'] = $_POST['indiv_art'];
                            $_SESSION['mode'] = 'indiv';
                    
                        endif;
                    
                        //一時保存した記事の編集
                        if(isset($_POST['edit_saved_art'])):

                            if($_POST['temp_art'] != 0):
                    
                                $_SESSION['edit_art_id'] = $_POST['temp_art'];
                                $_SESSION['mode'] = 'saved';
                    
                            endif;
                                                   
                        endif;
                    
                        if(isset($_POST['tag_search'])):

                            $_SESSION['tag'] = $_POST['tag_search'];
                            $_SESSION['mode'] = 'tag_search';
                            
                        endif;
                    
                        if(isset($_POST['art_search'])):

                            $_SESSION['kind_of_search'] = $_POST['kind_of_search'];
                            $_SESSION['art'] = $_POST['art_search_text'];
                            $_SESSION['mode'] = 'art_search';
                            
                        endif;
                    
                        //DBへの記事の登録
                        if(isset($_POST['sub_article'])):
                        
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
                        
                            $name = $_SESSION['name'];
                            $title = $_POST['title'];
                            if($title=="") $title = "(無題)";
                            $date = date("Y-m-d G:i");
                            //$date = $_POST['date'];
                            $tag = $_POST['tag'];
                            $str = $_POST['str'];
                            $fav = 0;
                            $private = isset($_POST['private']);
                        
                            //保存形式の変換。のちの検索のために半角スペースを削除し、最初と最後にも,を追加しておく。
                            $tag_post = ",".str_replace(array(" ", "　"), "", $tag).",";
                        
                            $sql = $pdo -> prepare("INSERT INTO ARTICLE (name, title, date, tag, str, fav, private)
                            VALUES (:name, :title, :date, :tag, :str, :fav, :private)");
                            $sql -> bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
                            $sql -> bindParam(':title', $title, PDO::PARAM_STR);
                            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                            $sql -> bindParam(':tag', $tag_post, PDO::PARAM_STR);
                            $sql -> bindParam(':str', $str, PDO::PARAM_STR);
                            $sql -> bindParam(':fav', $fav, PDO::PARAM_INT);
                            $sql -> bindParam(':private', $private, PDO::PARAM_BOOL);
                            $sql -> execute();
                                                   
                            if($_SESSION['mode'] == 'saved'):
                                                   
                                $sql = "DELETE FROM TEMP_ARTICLE WHERE id=:id";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':id', $_SESSION['edit_art_id'], PDO::PARAM_INT);
                                $stmt->execute();
                                                   
                            endif;
                                                   
                            $_SESSION['mode'] = 'home';
                            $_SESSION['edit_art_id'] = -1;
                        
                        endif;
                                                   
                        //記事の一時保存
                        if(isset($_POST['save_article'])):
                       

                       
                            $name = $_SESSION['name'];
                            $title = $_POST['title'];
                            if($title=="") $title = "(無題)";
                            $edit_date = date("Y-m-d G:i");
                            $tag = $_POST['tag'];
                            $str = $_POST['str'];
                            $private = isset($_POST['private']);
                       
                            //保存形式の変換。のちの検索のために半角スペースを削除し、最初と最後にも,を追加しておく。
                            $tag_post = ",".str_replace(array(" ", "　"), "", $tag).",";
                       
                            if($_SESSION['mode'] == 'saved'):
                                                   
                                $sql = $pdo -> prepare("UPDATE TEMP_ARTICLE SET title=:title, edit_date=:edit_date, tag=:tag, str=:str, private=:private WHERE id=:id");
                                $sql -> bindParam(':title', $title, PDO::PARAM_STR);
                                $sql -> bindParam(':edit_date', $edit_date, PDO::PARAM_STR);
                                $sql -> bindParam(':tag', $tag_post, PDO::PARAM_STR);
                                $sql -> bindParam(':str', $str, PDO::PARAM_STR);
                                $sql -> bindParam(':private', $private, PDO::PARAM_BOOL);
                                $sql -> bindParam(':id', $_SESSION['edit_art_id'], PDO::PARAM_INT);
                                $sql -> execute();
                                                   
                            else:
                                                   
                                $sql = $pdo -> prepare("INSERT INTO TEMP_ARTICLE (name, title, edit_date, tag, str, private)
                                VALUES (:name, :title, :edit_date, :tag, :str, :private)");
                                $sql -> bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
                                $sql -> bindParam(':title', $title, PDO::PARAM_STR);
                                $sql -> bindParam(':edit_date', $edit_date, PDO::PARAM_STR);
                                $sql -> bindParam(':tag', $tag_post, PDO::PARAM_STR);
                                $sql -> bindParam(':str', $str, PDO::PARAM_STR);
                                $sql -> bindParam(':private', $private, PDO::PARAM_BOOL);
                                $sql -> execute();
                                                       
                            endif;
                                                       
                            $_SESSION['mode'] = 'home';
                            $_SESSION['edit_art_id'] = -1;
                       
                        endif;
                        
                        //記事の編集(更新)
                        if(isset($_POST['sub_edit_article'])):
                                                   
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
                            
                            $title = $_POST['title'];
                            if($title=="") $title = "(無題)";
                            $edit_date = date("Y-m-d G:i");
                            //$date = $_POST['date'];
                            $tag = $_POST['tag'];
                            $str = $_POST['str'];
                            $private = isset($_POST['private']);
                       
                            //保存形式の変換。のちの検索のために半角スペースを削除し、最初と最後にも,を追加しておく。
                            $tag_post = ",".str_replace(array(" ", "　"), "", $tag).",";
                       
                            $sql = $pdo -> prepare("UPDATE ARTICLE SET title=:title, edit_date=:edit_date, tag=:tag, str=:str, private=:private WHERE id=:id");
                            $sql -> bindParam(':title', $title, PDO::PARAM_STR);
                            $sql -> bindParam(':edit_date', $edit_date, PDO::PARAM_STR);
                            $sql -> bindParam(':tag', $tag_post, PDO::PARAM_STR);
                            $sql -> bindParam(':str', $str, PDO::PARAM_STR);
                            $sql -> bindParam(':private', $private, PDO::PARAM_BOOL);
                            $sql -> bindParam(':id', $_SESSION['edit_art_id'], PDO::PARAM_INT);
                            $sql -> execute();
                                                  
                            $_SESSION['mode'] = 'home';
                            $_SESSION['edit_art_id'] = -1;

                        endif;
                                                   
                        //記事の削除
                        if(isset($_POST['del_article'])):
                                                       
                            if($_SESSION['mode'] == 'saved'):
                                                       
                               $sql = "CREATE TABLE IF NOT EXISTS TEMP_ARTICLE"
                               ." ("
                               . "id INT AUTO_INCREMENT PRIMARY KEY,"
                               . "name char(64),"
                               . "title char(64),"
                               . "date char(32),"
                               . "edit_date char(32),"
                               . "tag char(128),"
                               . "str text,"
                               . "private boolean"
                               .");";
                               $stmt = $pdo->query($sql);
                          
                               $sql = "DELETE FROM TEMP_ARTICLE WHERE id=:id";
                               $stmt = $pdo->prepare($sql);
                               $stmt->bindParam(':id', $_SESSION['edit_art_id'], PDO::PARAM_INT);
                               $stmt->execute();
                          
                               $_SESSION['mode'] = 'home';
                               $_SESSION['edit_art_id'] = -1;
                                    
                            else:
                                                       
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
                          
                               $sql = "DELETE FROM ARTICLE WHERE id=:id";
                               $stmt = $pdo->prepare($sql);
                               $stmt->bindParam(':id', $_SESSION['edit_art_id'], PDO::PARAM_INT);
                               $stmt->execute();
                          
                               $_SESSION['mode'] = 'home';
                               $_SESSION['edit_art_id'] = -1;
                                                       
                            endif;
                       
                        endif;
                            
                        //コメントの削除
                        if(isset($_POST['com_del'])||isset($_POST['com_del2'])):
                       
                            $stmt = $pdo -> prepare("UPDATE ARTICLE_COMMENT SET del=:del WHERE id=:id");
                            if(isset($_POST['com_del'])):
                                $stmt -> bindValue(':del', 1, PDO::PARAM_INT);
                                $stmt -> bindValue(':id', $_POST['com_del'], PDO::PARAM_INT);
                            else:
                                $stmt -> bindValue(':del', 2, PDO::PARAM_INT);
                                $stmt -> bindValue(':id', $_POST['com_del2'], PDO::PARAM_INT);
                            endif;
                            $stmt -> execute();
                       
                        endif;
                                           
                        //homeへ戻る
                        if(isset($_POST['back_to_home'])):
                                                   
                            $_SESSION['mode'] = 'home';
                            $_SESSION['cat_board'] = "";
                            $_SESSION['edit_art_id'] = -1;
                                                   
                        endif;
                        
                        //記事へのイイね！
                        if(isset($_POST['art_fav'])):
                            
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
                                                       
                           $id = $_POST['art_fav'];
                                                       
                           $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE id=:id");
                           $stmt -> bindValue(':id', $id, PDO::PARAM_STR);
                           $stmt -> execute();
                           
                           $disp_art = $stmt->fetch();
                           $fav = $disp_art['fav'] + 1;
                                                       
                           $sql = $pdo -> prepare("UPDATE ARTICLE SET fav=:fav WHERE id=:id");
                           $sql -> bindParam(':fav', $fav, PDO::PARAM_INT);
                           $sql -> bindParam(':id', $id, PDO::PARAM_INT);
                           $sql -> execute();
                                                       
                        endif;
                                                       
                        //モード遷移
                        $mode = $_SESSION['mode'];
                                                   
                        require("./mypage_".$_SESSION['mode'].".php");
                        
                        /*
                        switch($mode):
                            case("home"):
                            
                                require("./mypage_home.php");
                                break;
                        
                            case("new"):
                        
                                require("./mypage_new.php");
                                break;
                                                   
                            case("edit"):
                       
                                require("./mypage_edit.php");
                                break;
                                                   
                            case("saved"):
                      
                                require("./mypage_saved.php");
                                break;
                         
                         endswitch;
                         */
                         
                    endif;
                    
                ?>

            </div>

        </form>
    </body>
</html>
