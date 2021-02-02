<?php
    
    //テキストの改行処理・画像挿入
    //…これ、ファイル名に文字列を参照させてるから違法なファイル読めそうでやばい。指定不能な文字列を入れるべき？
    $str_view = preg_replace('/\[img:(.*?)\]/','<img src="$1" style="width:10vx; height:auto;">',$disp_art[$disp_count]['str']);
    $str_view = preg_replace('/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/', '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $str_view);
    $str_view = nl2br($str_view);
    
    $edit_date = "";
    if($disp_art[$disp_count]['edit_date']!="") $edit_date = "最終更新日時：".$disp_art[$disp_count]['edit_date'];
    $private_setting = "";
    if($disp_art[$disp_count]['private']==TRUE) $private_setting = "＜非公開記事＞";

    $tag_arr = explode(",",$disp_art[$disp_count]['tag']);
    $tag_disp = "";
    
    $tag_num = array_filter($tag_arr, "strlen");
    if(!empty($tag_num)):
    
        $tag_disp .= "タグ：";
        foreach($tag_arr as $eachtag):
        
            if($eachtag != "") $tag_disp .= "<button class='btn-link' type='submit' name='tag_search' value=".$eachtag.">".$eachtag."</button>/";

        endforeach;
    
    endif;
    
    if($name==$page) $edit_art_button = "<button class='btn-link' type='submit' name='edit_art' value=".$disp_art[$disp_count]['id'].">この記事を編集</button>";
    else $edit_art_button = "<br>";

    echo
    //"<table border='1' class='main'>"
        //."<tr><td>"
            "<div style='background-color:#EDF7FF'>"
                ."<hr>"
                ."<div align='left'><button class='btn-link' type='submit' name='indiv_art' value=".$disp_art[$disp_count]['id'].">".$disp_art[$disp_count]['title']."</button></div>"
                ."<div align='right'>".$disp_art[$disp_count]['date']."</div>"
                ."<div align='right'><font size='2' color='grey'>".$edit_date.$private_setting."</font></div><hr>"
            ."</div>"

            ."<div align='left'>".$tag_disp."</div><br>"
            ."<div align='left'>".$str_view."</div><br>"
            ."<div style='text-align: left; float: left;'><button class='btn-link' type='submit' name='art_fav' value=".$disp_art[$disp_count]['id'].">👍イイね！</button>×".$disp_art[$disp_count]['fav']."</div>"
            ."<div style='text-align: right;'>".$edit_art_button."</div>"
            ."<hr>";
        //."</td></tr>"
    //."</table>";
    
?>
