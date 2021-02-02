<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

                <?php

                    for($i=0;$i<10;$i++):

                        if(($disp_count < $art_count)):

                            //テキストの改行処理・画像挿入
                            //…これ、ファイル名に文字列を参照させてるから違法なファイル読めそうでやばい。指定不能な文字列を入れるべき？
                            $str_view = preg_replace('/\[img:(.*?)\]/','',$disp_art[$disp_count]['str']);
                            $str_view = preg_replace('/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/', '<a href="$1">$1</a>', $str_view);
                            $str_view = nl2br($str_view);
                            $str_view = preg_replace('/<.*?>/','',$str_view);
                            if(mb_strlen($str_view)>50) $str_view = (mb_substr($str_view, 0, 50))."...";
                    
                            $tag_arr = explode(",",$disp_art[$disp_count]['tag']);
                            $tag_disp = "";
                            
                            foreach($tag_arr as $eachtag):
                            
                                if($eachtag != "") $tag_disp .= $eachtag;

                            endforeach;
                    
                            echo

                                "<div>"
                                    ."<div align='left'><button class='btn-link' type='submit' name='art_jump' value=".$disp_art[$disp_count]['id'].">".$disp_art[$disp_count]['title']."</button>"
                                    ." - <button class='btn-link' type='submit' name='blog_jump' value=".$disp_art[$disp_count]['name'].">".$disp_art[$disp_count]['blogtitle']."</button>"
                                    ."<font size='2'>".$disp_art[$disp_count]['date']."</font></div>"
                                    ."<div align='left'><font size='2' color='grey'>".$str_view."</font></div>"
                                ."</div><hr>";

                        endif;
                        
                        $disp_count += 1;

                    endfor;

                    echo "<div style='text-align: left; float: left;'>";
                    if($disp_count>=20) echo '<button class="btn-link" type="submit" name="trans_blog" value='.($disp_count-20).'>←前のブログを表示</button>';
                    echo "</div><div style='text-align: right;'>";
                    if($disp_count<$art_count) echo '<button class="btn-link" type="submit" name="trans_blog" value='.$disp_count.'>次のブログを表示→</button>';

                    echo '</div>';

                ?>

    </body>
</html>
