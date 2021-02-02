<?php

    $filename = $_FILES["img"]["name"];
    
    $folderpath = "./img/".$name;
    if(!file_exists($folderpath)):
        if(mkdir($folderpath, 0777)) chmod($folderpath, 0777);
        else "フォルダ作成に失敗しました。<br>";
    endif;

    $stmt = $pdo -> prepare("SELECT * FROM IMG_LIST WHERE img_title=:img_title");
    $stmt -> bindValue(':img_title', $filename, PDO::PARAM_STR);
    $stmt -> execute();
    $temp_num = $stmt->rowCount();
    
    if($temp_num>0):
    
        $i = 0;

        //拡張子調整
        $img_sep_title = explode(".",$filename);
        $filename = $img_sep_title[0];
        $filename_count = (count($img_sep_title)) - 1;
        for($i=1;$i<$filename_count;$i++) $filename .= '.'.$img_sep_title[$i];

        $i = 0;
        while(TRUE):

            $i += 1;
            $stmt = $pdo -> prepare("SELECT * FROM IMG_LIST WHERE img_title=:img_title");
            $stmt -> bindValue(':img_title', ($filename.'('.$i.')'.'.'.$img_sep_title[$filename_count]), PDO::PARAM_STR);
            $stmt -> execute();
            $temp_num = $stmt->rowCount();
            if($temp_num == 0) break;

        endwhile;
        $filename .= '('.$i.')'.'.'.$img_sep_title[$filename_count];
        $filename = "img/".$name."/".$filename;

    endif;
    
?>
