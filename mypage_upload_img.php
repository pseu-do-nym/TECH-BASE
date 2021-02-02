<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <div class="flex_item">

            <div class="main">
                <hr>
                <table align="center" border='0'>

                    <?php
                        //画像のアップロード
                        if(isset($_POST['upload_img'])):
                            if(isset($_FILES["img"]["name"])):

                                require("./img_rename.php");
                        
                                if(!move_uploaded_file($_FILES["img"]["tmp_name"],($filename))):
                                          print "アップロードに失敗しました<br>";
                                else:
                        
                                        $sql = $pdo -> prepare("INSERT INTO IMG_LIST (name, img_title, date)
                                        VALUES (:name, :img_title, :date)");
                                        $sql -> bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
                                        $sql -> bindParam(':img_title', $filename, PDO::PARAM_STR);
                                        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                                        $sql -> execute();
                        
                                        echo "<tr><td spancol='2' align='left'>記事中の画像を配置したい位置に以下を貼り付けてください：</td></tr>";
                                        echo "<tr><td spancol='2' align='left'><input type='text' size='80' value='[img:".$filename."]'></td></tr>";
                        
                                endif;
                            
                            else:
                                echo "<font color='red'>！画像が選択されていません</font><br>";
                            endif;
                        endif;
                    ?>

                    <tr>

                        <td align='left'>*画像をアップロードする*</td>

                    </tr>

                    <tr>
                        <form method="post" enctype="multipart/form-data">
                            <td colspan='2'><input type="file" name="img" accept="image/*"><input type="submit" name="upload_img" value="送信"></td>
                        </form>

                    </tr>

                </table>

            </div>

        </div>

    </body>
</html>
