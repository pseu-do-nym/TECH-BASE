<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body style="background-color:#EDF7FF;">
        <form action="" method="post" accept-charset="UTF-8">
            
            <?php
                $name = "";
                $birthday = "";
                $mail1 = "";
                $mail2 = "";
                $pass1 = "";
                $pass2 = "";
                $error_flag = 0;
                
                $name_input="";
                $birth_input="";
                $mail1_input="";
                $mail2_input="";
                $pass1_input="";
                $pass2_input="";
                
                if(isset($_POST["enter"])):
                    
                    $name = $_POST["name"];
                    $birthday = $_POST["birthday"];
                    $mail1 = $_POST["mail1"];
                    $mail2 = $_POST["mail2"];
                    $pass1 = $_POST["pass1"];
                    $pass2 = $_POST["pass2"];
                    $authentication = "";
                    
                    require("./connect_db.php");
    	            
    	            $sql = 'SELECT * FROM REGISTRATION WHERE name=:name';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->execute();
                    if(($stmt->rowCount())!=0):
                        $name_input="<font color='red'>！そのIDは既に使われています</font>";
                        $error_flag = 1;
                    endif;
                    
                    $sql = 'SELECT * FROM UNTREATED WHERE name=:name';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->execute();
                    if(($stmt->rowCount())!=0):
                        $name_input="<font color='red'>！そのIDは既に使われています</font>";
                        $error_flag = 1;
                    endif;
                    
                    $sql = 'SELECT * FROM REGISTRATION WHERE mail=:mail1';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':mail1', $mail1, PDO::PARAM_STR);
                    $stmt->execute();
                    if(($stmt->rowCount())!=0):
                        $mail1_input="<font color='red'>！そのメールアドレスは既に使われています</font>";
                        $error_flag = 1;
                    endif;
                    
                    $sql = 'SELECT * FROM UNTREATED WHERE mail=:mail1';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':mail1', $mail1, PDO::PARAM_STR);
                    $stmt->execute();
                    if(($stmt->rowCount())!=0):
                        $mail1_input="<font color='red'>！そのメールアドレスは既に使われています</font>";
                        $error_flag = 1;
                    endif;
                    
                    if($name==""):
                        $name_input="<font color='red'>！IDを入力してください</font>";
                        $error_flag = 1;
                    elseif(strlen($name)<4 || strlen($name)>30):
                        $name_input="<font color='red'>！IDは英数字4文字以上30文字以内で指定してください</font>";
                        $error_flag = 1;
                    endif;
                    
                    if($birthday==""):
                        $birth_input="<font color='red'>！誕生日を入力してください</font>";
                        $error_flag = 1;
                    endif;
                    
                    if($pass1==""):
                        $pass1_input="<font color='red'>！パスワードを入力してください</font>";
                        $error_flag = 1;
                    elseif(strlen($pass1)<6 || strlen($pass1)>30):
                        $pass1_input="<font color='red'>！パスワードは英数字6文字以上30文字以内で指定してください</font>";
                        $error_flag = 1;
                    elseif($pass2==""):
                        $pass2_input="<font color='red'>！パスワードを再度入力してください</font>";
                        $error_flag = 1;
                    elseif($pass1 != $pass2):
                        $pass2_input="<font color='red'>！同一のパスワードを入力してください</font>";
                        $error_flag = 1;
                    endif;
                    
                    if($mail1==""):
                        $mail1_input="<font color='red'>！メールアドレスを入力してください</font>";
                        $error_flag = 1;
                    elseif($mail2==""):
                        $mail2_input="<font color='red'>！メールアドレスを再度入力してください</font>";
                        $error_flag = 1;
                    elseif($mail1 != $mail2):
                        $mail2_input="<font color='red'>！同一のメールアドレスを入力してください</font>";
                        $error_flag = 1;
                    endif;
                    
                    if($error_flag == 0):
                        $sql = $pdo -> prepare("INSERT INTO UNTREATED (name, pass, birthday, mail, authentication) 
    	                VALUES (:name, :pass, :birthday, :mail, :authentication)");
    	                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    	                $sql -> bindParam(':pass', $pass1, PDO::PARAM_STR);
    	                $sql -> bindParam(':birthday', $birthday, PDO::PARAM_STR);
    	                $sql -> bindParam(':mail', $mail1, PDO::PARAM_STR);
    	                $authentication = base_convert(mt_rand(pow(36,9),pow(36,10)-1),10,36); //10桁のランダムパスワードを作成
    	                $sql -> bindValue(':authentication', $authentication, PDO::PARAM_STR);
    	                $sql -> execute();
    	                
    	                include './phpmailer/send_test.php'; //メールを送信
    	                
                        //$sql = 'DROP TABLE UNTREATED';
	                    //$stmt = $pdo->query($sql);
                        
                    endif;
                    
                endif;
                
            ?>

            
            <table bgcolor="white" align="center" border="0"> <!-- 見やすいようにテーブルを使っています -->
                <tr>
                    <td colspan="2" align="center"><font size="12">新規登録</font></td>
                </tr>
                <hr>
                <tr>
                    <td align="right">ログインID：</td>
                    <td><input type="text" name="name" size="50" maxlength="30" value="<?php echo $name; ?>" placeholder="英数字4文字以上30文字以内で指定してください"></td>
                    <td><?php echo $name_input; ?></td></td>
                </tr>
                <tr>
                    <td align="right">生年月日：</td>
                    <td><input type="date" name="birthday" value="<?php echo $birthday; ?>"></td>
                    <td><?php echo $birth_input; ?></td></td>
                </tr>
                <tr>
                    <td align="right">メールアドレス：</td>
                    <td><input type="text" name="mail1" size="50" maxlength="50" value="<?php echo $mail1; ?>" placeholder=""></td>
                    <td><?php echo $mail1_input; ?></td>
                </tr>
                <tr>
                    <td align="right">メールアドレス(確認用)：</td>
                    <td><input type="text" name="mail2" size="50" maxlength="50" value="<?php echo $mail2; ?>" placeholder=""></td>
                    <td><?php echo $mail2_input; ?></td>
                </tr>
                <tr>
                    <td align="right">パスワード：</td>
                    <td><input type="password" name="pass1" size="50" maxlength="50" value="<?php echo $pass1; ?>" placeholder="英数字6文字以上30文字以内で指定してください"></td>
                    <td><?php echo $pass1_input; ?></td>
                </tr>
                <tr>
                    <td align="right">パスワード(確認用)：</td>
                    <td><input type="password" name="pass2" size="50" maxlength="50" value="<?php echo $pass2; ?>" placeholder=""></td>
                    <td><?php echo $pass2_input; ?></td>
                </tr>
                    <td></td>
                    <td align="right"><input type="button" onclick="location.href='./toppage.php'" value="トップページに戻る"><input type="submit" name="enter" value="確認"></td>
                <tr>
                </tr>
            </table>
        </form>
    </body>
</html>
