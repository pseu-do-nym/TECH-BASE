<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <div class="flex_item">

            <?php
                
                require("./connect_db.php");
            
                if(isset($_POST['title'])) $title = ($_POST['title']);
                else $title = "";
                if(isset($_POST['tag'])) $tag = ($_POST['tag']);
                else $tag = "";
                if(isset($_POST['str'])) $str = ($_POST['str']);
                else $str = "";
                if(isset($_POST['private'])):
                    $private = TRUE;
                    $private_check = '<input type="checkbox" name="private" value="TRUE" checked="checked">';
                else:
                    $private = FALSE;
                    $private_check = '<input type="checkbox" name="private" value="TRUE">';
                endif;
                $img_title = "";
                $temp_art_disp = "";
                
                $stmt = $pdo -> prepare("SELECT * FROM TEMP_ARTICLE WHERE name=:name ORDER BY edit_date DESC, id DESC");
                $stmt -> bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
                $stmt -> execute();
                $temp_list = $stmt->fetchAll();
                $temp_num = $stmt->rowCount();
                
                if($temp_num != 0):
                
                    $temp_art_disp = "<div align='right'>保存した記事を編集<br><select name='temp_art'><option value=0>選択してください</option>";
                    
                    for($i=0;$i<$temp_num;$i++):
                
                        $temp_art_disp .= "<option value=".$temp_list[$i]['id'].">".$temp_list[$i]['title']."/".$temp_list[$i]['edit_date']."</option>";
                
                    endfor;
                
                    $temp_art_disp .= "</select><input type='submit' name='edit_saved_art' value='編集'></div>";
                
                endif;
                
            ?>

            <form action="" method="post" accept-charset="UTF-8">

                <div class="main">
                    <!-- ここはsessionを使ってログイン状態限定のアクセスにする -->
                    <div align="center">-- 新規記事作成 --</div><br>
                    <?php echo $temp_art_disp; ?>
                    <table align="center" border='0'>

                        <tr>
                            <td align='right'>記事タイトル：</td>
                            <td align='left'><input type='text' name='title' size='40' placeholder='記事タイトルを入力してください' value=<?php echo $title; ?>></td>
                        </tr>

                        <!-- 日付は自動入力に変更
                        <tr>
                            <td align='right'>日時：</td>
                            <td align='left'><input type='date' name='date' value=<?php echo $date; ?>></td>
                        </tr>
                        -->

                        <tr>
                            <td align='right'>タグ：</td>
                            <td align='left'><input type='text' name='tag' size='80' placeholder='記事タグを半角コンマ区切りで入力してください <例:旅行, 食べ物, ショッピング>' value=<?php echo $tag; ?>></td>
                        </tr>

                        <tr>
                            <td align='right'>本文：</td>
                            <td colspan='2'><textarea style='width: 80vw;' name='str' placeholder='記事内容を入力してください（最大1000文字程度）' rows="30"><?php echo $str; ?></textarea></td>
                        </tr>

                    </table>

                    <div align="right">

                        <?php echo $private_check; ?>記事を非公開に設定する<br>

                        <input type="submit" name="sub_article" value="確定" style="padding: 8px 20px; font-size: 1.2em;">
                        <input type="submit" name="save_article" value="下書きを保存" style="padding: 8px 40px; font-size: 1.2em;">
                        <input type="submit" name="back_to_home" value="保存せずに戻る" style="padding: 8px 40px; font-size: 1.2em;">
                    </div>

                </form>

                <?php require("./mypage_upload_img.php");?>

            </div>

        </div>

    </body>
</html>
