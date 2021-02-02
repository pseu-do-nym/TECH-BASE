<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <form action="" method="post" accept-charset="UTF-8">

            <div class="flex_item">

                <?php
                
                    if(isset($_POST['title'])) $title = ($_POST['title']);
                    else $title = "";
                    if(isset($_POST['tag'])) $tag = ($_POST['tag']);
                    else $tag = "";
                    if(isset($_POST['str'])) $str = ($_POST['str']);
                    else $str = "";
                    if(isset($_POST['private'])) $private_check = '<input type="checkbox" name="private" value="TRUE" checked="checked">';
                    else $private_check = $private_check = '<input type="checkbox" name="private" value="TRUE">';
                    $edit_art_array = array();
                    
                    require("./connect_db.php");
                    
                    $sql = "SELECT * FROM ARTICLE WHERE id=:id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $_SESSION['edit_art_id'], PDO::PARAM_INT);
                    $stmt->execute();
                    
                    if(($stmt->rowCount())==0):
                        echo "記事番号が無効です。<br>";
                    else:
                        $edit_art_array = $stmt->fetch();
                        $title = $edit_art_array['title'];
                        $tag = substr($edit_art_array['tag'],1,-1);
                        $str = $edit_art_array['str'];
                        if($edit_art_array['private']) $private_check = '<input type="checkbox" name="private" value="TRUE" checked="checked">';
                        else $private_check = $private_check = '<input type="checkbox" name="private" value="TRUE">';
                    endif;
                    
                ?>

                <div class="main">
                    <!-- ここはsessionを使ってログイン状態限定のアクセスにする -->
                    <div align="center">-- 記事編集 --</div>
                    <br>
                    <table align="center" border='0'>

                        <tr>
                            <td align='right'>記事タイトル：</td>
                            <td align='left'><input type='text' name='title' size='40' placeholder='記事タイトルを入力してください' value=<?php echo $title; ?>></td>
                        </tr>

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

                        <input type="submit" name="sub_edit_article" value="確定" style="padding: 8px 20px; font-size: 1.2em;">
                        <input type="submit" name="del_article" value="この記事を削除" style="padding: 8px 40px; font-size: 1.2em;">
                        <input type="submit" name="back_to_home" value="保存せずに戻る" style="padding: 8px 40px; font-size: 1.2em;">
                    </div>

                </form>

                <?php require("./mypage_upload_img.php");?>

            </div>

        </div>

    </body>
</html>
