<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body style="background-color:#EDF7FF;">
        <form action="" method="post" accept-charset="UTF-8">
            
            <?php
                
                if(isset($_GET['auth'])):
                
                    $auth = $_GET['auth'];
                    $error_flag = 0;
                    
                    require("./connect_db.php");
                    
                    $sql = 'SELECT * FROM REGISTRATION WHERE name=:name';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->execute();
                    if(($stmt->rowCount())!=0):
                        echo "そのIDは既に登録が完了しています。<br>今一度お確かめください。<br>";
                        $error_flag = 1;
                    
                    else:
                        $sql = 'SELECT * FROM REGISTRATION WHERE mail=:mail1';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':mail1', $mail1, PDO::PARAM_STR);
                        $stmt->execute();
                        if(($stmt->rowCount())!=0):
                            echo "そのメールアドレスは既に登録が完了しています。<br>今一度お確かめください。<br>";
                            $error_flag = 1;
                        endif;
                    endif;
                    
                    if($error_flag == 0):
                        $sql = $pdo -> prepare("SELECT * FROM UNTREATED WHERE authentication=:auth");
                        $sql -> bindValue(':auth', $auth, PDO::PARAM_STR);
                        $sql -> execute();
                        $sqlc = $sql->rowCount();
                
                        if($sqlc==1):
                        
                            $results = $sql->fetch();
                            $sql = $pdo -> prepare("INSERT INTO REGISTRATION (name, pass, birthday, mail)
                            VALUES (:name, :pass, :birthday, :mail)");
                            $sql -> bindParam(':name', $results['name'], PDO::PARAM_STR);
                            $sql -> bindParam(':pass', $results['pass'], PDO::PARAM_STR);
                            $sql -> bindParam(':birthday', $results['birthday'], PDO::PARAM_STR);
                            $sql -> bindParam(':mail', $results['mail'], PDO::PARAM_STR);
                            $sql -> execute();
                                                   
                            $sql = $pdo -> prepare("DELETE FROM UNTREATED WHERE authentication=:auth");
                            $sql -> bindParam(':auth', $auth, PDO::PARAM_STR);
                            $sql -> execute();
                                                   
                            echo "本登録が完了いたしました！<br>トップページから再度ログインをお願いいたします。<br>";
                                                   
                        elseif($sqlc==0):
                            echo "無効なリンクです。<br>";
                                                   
                        else:
                            echo "データベースでエラーが発生いたしました。申し訳ございません。<br>";
                                                   
                        endif;

                    endif;
                    
                else:
                    echo "無効なリンクです。<br>";
                                                   
                endif;
            
        ?>

        <form action="" method="post" accept-charset="UTF-8">
            <div align="right">
                <input type="button" onclick="location.href='./toppage.php'" value="トップページに戻る">
            </div>
        </form>

    </body>
</html>

