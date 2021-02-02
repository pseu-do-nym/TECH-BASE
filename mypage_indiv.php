<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <form action="" method="post" accept-charset="UTF-8">

            <?php

                require("./blog_environment.php");
                
            ?>

            <div class="flex_item">

                <div class="menu" align="left">

                    <?php
                    
                        require("./blog_sidebar.php");
                        
                    ?>

                </div>

                <div class="line"></div>

                <div class="main">

                    <?php
                        
                        echo $new_article;
                        
                        $art_id = $_SESSION['edit_art_id'];
                        
                        $stmt = $pdo -> prepare("SELECT * FROM BLOGTITLE WHERE name=:name");
                        $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt -> execute();
                        $results = $stmt->fetch();
                        $num = $stmt->rowCount();
                        if($num!=0) $nickname = $results['nickname'];
                        else $nickname = $name;
                        
                        $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE id=:id");
                        $stmt -> bindParam(':id', $art_id, PDO::PARAM_STR);
                        $stmt -> execute();
                        $disp_art = array($stmt->fetch());
                        $disp_count = 0;
                        
                        if(isset($disp_art)):
                            if($disp_art[0]['private']==TRUE && $name!=$page):
                                echo "<div align='center'>この記事は現在非公開に設定されています。</div>";
                            else:
                                
                                require("./one_article.php");
                        
                                //前後の記事を表示
                                if($name==$page) $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name and id>:id ORDER BY id ASC LIMIT 1");
                                else $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name and id>:id and private=0 ORDER BY id ASC LIMIT 1");
                                $stmt -> bindParam(':name', $page, PDO::PARAM_STR);
                                $stmt -> bindParam(':id', $art_id, PDO::PARAM_STR);
                                $stmt -> execute();
                                $former_art = $stmt->fetch();
                                $former_count = $stmt->rowCount();
                                $former_title = $former_art['title'];
                                if(mb_strlen($former_title)>10) $former_title = (mb_substr($former_title, 0, 10))."...";
                                
                                if($name==$page) $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name and id<:id ORDER BY id DESC LIMIT 1");
                                else $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name and id<:id and private=0 ORDER BY id DESC LIMIT 1");
                                $stmt -> bindParam(':name', $page, PDO::PARAM_STR);
                                $stmt -> bindParam(':id', $art_id, PDO::PARAM_STR);
                                $stmt -> execute();
                                $latter_art = $stmt->fetch();
                                $latter_count = $stmt->rowCount();
                                $latter_title = $latter_art['title'];
                                if(mb_strlen($latter_title)>10) $latter_title = (mb_substr($latter_title, 0, 10))."...";
                        
                                echo "<div style='text-align: left; float: left;'>";
                                if($former_count!=0) echo '<button class="btn-link" type="submit" name="art_jump" value='.$former_art['id'].'>←前の記事：'.$former_title.'</button>';
                                echo "</div><div style='text-align: right;'>";
                                if($latter_count!=0) echo '<button class="btn-link" type="submit" name="art_jump" value='.$latter_art['id'].'>次の記事：'.$latter_art['title'].'→</button>';
                                echo "</div>";
                        

                        
                                if(isset($_POST['sub_comment'])):
                        
                                    $page = $_SESSION['page'];
                                    $poster_name = $_POST['poster_name'];
                                    $poster_account = $_SESSION['name'];
                                    $title = $_POST['title'];
                                    $str = $_POST['str'];
                                    $private = isset($_POST['private']);
                        
                                    if($poster_name == "") $poster_name = "名無しさん"; //名前未指定の場合
                                    if($title == "") $title = "無題";
                                    if($str != ""):
                                        
                                        $date = date("Y-m-d G:i");
                                        
                                        $stmt = $pdo -> prepare("INSERT INTO ARTICLE_COMMENT (name, art_id, title, poster_name, poster_account, date, str, private, del) VALUES (:name, :art_id, :title, :poster_name, :poster_account, :date, :str, :private, :del)");
                                        $stmt -> bindParam(':name', $page, PDO::PARAM_STR);
                                        $stmt -> bindParam(':art_id', $art_id, PDO::PARAM_INT);
                                        $stmt -> bindParam(':title', $title, PDO::PARAM_STR);
                                        $stmt -> bindParam(':poster_name', $poster_name, PDO::PARAM_STR);
                                        $stmt -> bindParam(':poster_account', $poster_account, PDO::PARAM_STR);
                                        $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
                                        $stmt -> bindParam(':str', $str, PDO::PARAM_STR);
                                        $stmt -> bindParam(':private', $private, PDO::PARAM_BOOL);
                                        $stmt -> bindValue(':del', 0, PDO::PARAM_INT);
                                        $stmt -> execute();

                                    else:
                                        echo "<font color=\"red\">！本文がありません<br></font>";
                                    endif;
                        
                                endif;
                        
                                $name = $_SESSION['name'];
                        
                                //コメントの読み込み
                                $stmt = $pdo -> prepare("SELECT * FROM ARTICLE_COMMENT WHERE art_id = :art_id ORDER BY id DESC");
                                $stmt -> bindParam(':art_id', $art_id, PDO::PARAM_INT);
                                $stmt -> execute();
                        
                                $disp_comment = $stmt->fetchAll();
                                $com_count = $stmt->rowCount();
                        
                                //ログイン時、当人とブログ主しか見えない投稿を可能に
                                if($name!="") $private_comment = "<input type='checkbox' name='private' value='TRUE'>コメントをブログ主にのみ表示";
                                else $private_comment = "";
                        
                                echo "<hr>この記事にコメントする：<br>"
                                    ."名前：<input type='text' name='poster_name' size='20' value='".$nickname."'><br>"
                                    ."件名：<input type='text' name='title' size='20'><br>"
                                    ."コメント：<br>"
                                    ."<textarea style='width: 70vw;' name='str' placeholder='コメントを入力してください' rows='4'></textarea><br>"
                                    ."<div style='text-align: left; float: left;'>".$private_comment."</div>"
                                    ."<div style='text-align: right;'><input type='submit' name='sub_comment' value='確定'><div><hr><hr>"
                                    ."<div align='left'>この記事へのコメント：".$com_count."件<hr>";
                        
                                for($i=0;$i<$com_count;$i++):

                                    //ブログ主は名前を強調
                                    if($disp_comment[$i]['poster_account']==$page) $poster_disp = "<font color='blue'>".$disp_comment[$i]['poster_name']."(ブログ主)</font>";
                                    else $poster_disp = "<font color='grey'>".$disp_comment[$i]['poster_name']."</font>";
                        
                                    if($disp_comment[$i]['private']==TRUE && $name!=$page && $name!=$disp_comment[$i]['poster_account']):
                                        $str_view = "<i><font color='grey'>(このコメントは投稿者とブログ主のみ閲覧できます)</font></i>";
                                    else:
                                        $str_view = $disp_comment[$i]['str'];
                                        $str_view = preg_replace('/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $str_view);
                                        $str_view = nl2br($str_view);
                                    endif;
                        
                                    $del_disp = "";
                                    if($disp_comment[$i]['del']==0 && $name!=""):
                                        if($disp_comment[$i]['poster_account']==$name) $del_disp = "<button type='submit' class='btn-link' name='com_del' value=".$disp_comment[$i]['id'].">削除</button>";
                                        elseif($name==$page) $del_disp = "<button type='submit' class='btn-link' name='com_del2' value=".$disp_comment[$i]['id'].">削除</button>";
                                    endif;
                        
                                    if($disp_comment[$i]['del']==1):
                                        $str_view = "<font color='blue'>書き込みをした人によって削除されました</font>";
                                    elseif($disp_comment[$i]['del']==2):
                                        $str_view = "<font color='blue'>ブログ主によって削除されました</font>";
                                    endif;
                        
                                    //表示部
                                    echo    "<div align='left'>[".($com_count - $i)."] ".$disp_comment[$i]['title']." <i>".$poster_disp." <font color='grey'>"
                                            .$disp_comment[$i]['date']."</font></i> ".$del_disp."</div>"
                                            ."<div align='left'>".$str_view."</div>"
                                            ."<hr>";

                                endfor;
                            
                            endif;
                        else:
                            echo "<div align='center'>記事番号が間違っているか削除されています。</div>";
                        endif;
                        
                        echo '<br><div align="center"><button type="submit" class="btn-link" name="back_to_home">ブログトップに戻る</div>';
                        
                    ?>

                </div>

            </div>

        </form>
    </body>
</html>

