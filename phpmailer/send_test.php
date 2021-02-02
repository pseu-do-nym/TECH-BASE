<?php
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'setting.php';

// PHPMailerのインスタンス生成
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP(); // SMTPを使うようにメーラーを設定する
    $mail->SMTPAuth = true;
    $mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
    $mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
    $mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
    $mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
    $mail->Port = SMTP_PORT; // 接続するTCPポート

    // メール内容設定
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "base64";
    $mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
    $mail->addAddress($mail1, $name); //受信者（送信先）を追加する
//    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');
//    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加
//    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加
    $mail->Subject = MAIL_SUBJECT; // メールタイトル
    $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
    
    $body = $name.' 様<br><br>'
    .'仮登録が完了いたしました。<br>'
    .'以下のリンクから本登録にお進みください。<br><br>'
    .'<a href="https://tb-220906.tech-base.net/mission_6/register_exec.php?auth='.$authentication.'">本登録に進む</a><br>';

    $mail->Body  = $body; // メール本文
    // メール送信の実行
    if(!$mail->send()) {
    	echo 'メッセージは送られませんでした。アドレスなどにお間違いがないか再度確認するようお願いいたします。';
    	echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
    	echo '仮登録手続きが完了いたしました。<br>'
        .'注：本登録はまだ完了していません！<br>'
        .'ご記載いただいたメールアドレスに添付されたurlから本登録にお進みいただけるようよろしくお願いいたします。<br>'
        .'なお、登録期限は現在より1時間となっているのでご注意くださいますようよろしくお願いいたします。';
    }
