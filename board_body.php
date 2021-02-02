<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <form action="" method="post" accept-charset="UTF-8">

            <div class="main"  style='background-color: silver;
                background-image: linear-gradient(335deg, #b4745c 23px, transparent 23px),
                linear-gradient(155deg, #d08e71 23px, transparent 23px),
                linear-gradient(335deg, #b4745c 23px, transparent 23px),
                linear-gradient(155deg, #d08e71 23px, transparent 23px);
                background-size: 58px 58px;
                background-position: 0px 2px, 4px 35px, 29px 31px, 34px 6px;'>
                <!-- ここはsessionを使ってログイン状態限定のアクセスにする -->
                <div align="center">
                                
                    <br>
                    <table align="center" border='0' bgcolor='#dddddd' style='width:85vw;'>

                        <tr>
                            <td align='center'><font size='6'>— 掲示板(<?php echo $_SESSION['cat_board'] ?>) —</font></td>
                        </tr>

                        <tr>
                            <td align='center'>ブログジャンル間で自由に交流できる掲示板です。</td>
                        </tr>
                              
                        
                        <tr><td>
                                
                            <?php
                                
                                if(isset($_POST['com_del'])):
                                
                                    $stmt = $pdo -> prepare("UPDATE BOARD_COMMENT SET del=TRUE WHERE id=:id");
                                    $stmt -> bindParam(':id', $_POST['com_del'], PDO::PARAM_INT);
                                    $stmt -> execute();
                                
                                endif;
                                
                                $stmt = $pdo -> prepare("SELECT * FROM BLOGTITLE WHERE name=:name");
                                $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
                                $stmt -> execute();
                                $results = $stmt->fetch();
                                $num = $stmt->rowCount();
                                if($num!=0) $nickname = $results['nickname'];
                                else $nickname = $name;
                                $category = $_SESSION['cat_board'];
                        
                                if(isset($_POST['sub_comment'])):
                        
                                    $poster_name = $_POST['poster_name'];
                                    $poster_account = $_SESSION['name'];
                                    $str = $_POST['str'];
                        
                                    if($poster_name == "") $poster_name = "名無しさん"; //名前未指定の場合
                                    if($str != ""):
                                        
                                        $date = date("Y-m-d G:i");
                                        
                                        $stmt = $pdo -> prepare("INSERT INTO BOARD_COMMENT (name, category, poster_name, poster_account, date, str, del) VALUES (:name, :category, :poster_name, :poster_account, :date, :str, :del)");
                                        $stmt -> bindParam(':name', $page, PDO::PARAM_STR);
                                        $stmt -> bindParam(':category', $category, PDO::PARAM_STR);
                                        $stmt -> bindParam(':poster_name', $poster_name, PDO::PARAM_STR);
                                        $stmt -> bindParam(':poster_account', $poster_account, PDO::PARAM_STR);
                                        $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
                                        $stmt -> bindParam(':str', $str, PDO::PARAM_STR);
                                        $stmt -> bindValue(':del', FALSE, PDO::PARAM_BOOL);
                                        $stmt -> execute();

                                    else:
                                        echo "<font color=\"red\">！本文がありません<br></font>";
                                    endif;
                        
                                endif;
                        
                                $name = $_SESSION['name'];
                        
                                //コメントの読み込み
                                $stmt = $pdo -> prepare("SELECT * FROM BOARD_COMMENT WHERE category = :category ORDER BY id DESC");
                                $stmt -> bindParam(':category', $category, PDO::PARAM_STR);
                                $stmt -> execute();
                        
                                $disp_comment = $stmt->fetchAll();
                                $com_count = $stmt->rowCount();
                        
                                echo "<hr>この記事にコメントする：<br>"
                                    ."名前：<input type='text' name='poster_name' size='20' value='".$nickname."'><br>"
                                    ."コメント：<br>"
                                    ."<div style='text-align: left; float: left;'><textarea style='width: 70vw;' name='str' placeholder='コメントを入力してください' rows='4'></textarea></div><br><br>"
                                    ."<div style='text-align: right;'><input type='submit' name='sub_comment' value='確定'><div><br><hr><hr>"
                                    ."<div align='left'>この掲示板へのコメント：".$com_count."件<hr>";
                        
                                if($com_count!=0):
                                    for($i=0;$i<$com_count;$i++):

                                        $poster_disp = $disp_comment[$i]['poster_name'];
                            
                                        $str_view = $disp_comment[$i]['str'];
                                        $str_view = preg_replace('/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $str_view);
                                        $str_view = nl2br($str_view);
                                
                                        $del_disp = "";
                                        if($disp_comment[$i]['del']==FALSE && $name!="" && $disp_comment[$i]['poster_account']==$name):
                                            $del_disp = "<button type='submit' class='btn-link' name='com_del' value=".$disp_comment[$i]['id'].">削除</button>";
                                        elseif($disp_comment[$i]['del']==TRUE):
                                            $str_view = "<font color='blue'>書き込みをした人によって削除されました</font>";
                                        endif;
                                    
                                        //表示部
                                        echo    "<div align='left'>[".($com_count - $i)."] ".$poster_disp." <i><font color='grey'>"
                                                .$disp_comment[$i]['date']."</font></i> "
                                                .$del_disp."</div>"
                                                ."<div align='left'>".$str_view."</div>"
                                                ."<hr>";

                                    endfor;
                                
                                else:
                                    echo "この掲示板にはまだ書き込みがありません。なにか書き込んでみましょう！<br>";
                                
                                endif;

                            ?>
                                
                        </td></tr>

                        <tr>
                            <td><div align="center"><button type="submit" class="btn-link" name="board_top">掲示板トップに戻る</button></div></td>
                        </tr>
                                
                        <tr>
                            <td><div align="center"><button type="submit" class="btn-link" name="link_toppage">トップに戻る</button></div></td>
                        </tr>
                                
                        <tr>
                            <td><br></td>
                        </tr>

                    </table>
                                
                    <br>

            </div>
                            
        </form>

    </body>
</html>
