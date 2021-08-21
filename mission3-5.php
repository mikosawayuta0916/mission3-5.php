
      
      
<?php
        ini_set('display_errors', 0);//エラー非表示
        $date = date("Y/m/d/ H:i:s"); //日付
        $filename="mission_3-05.txt"; //ファイル名前
        $lines = file($filename,FILE_IGNORE_NEW_LINES);
        //編集したい箇所を代入する
        $edit_val= '';
        $edit_name = '';
        $edit_comment = '';
        $edit_password = '';
        $edit = $_POST["edit"]; //編集ボタン
        $submit = $_POST["submit"]; //送信ボタン
        $name = $_POST['name'];  //名前受信
        $text = $_POST['text'];  //コメント受信
        $password = $_POST['password'];  //パスワード受信
         if(file_exists($filename)){ //投稿番号
        //ファイルが有るなら...
             $num = count(file($filename))+1;
             //一番はじめの値は０にだから＋１
             }else{
                $num = 1; //
             }
        //データ保存     1<>赤坂太郎<>これはテストです<>2017/10/20 0:00:00
        $savetext = $num. "<>" .$name. "<>".$text. "<>" .$date  . "<>" . $password;
        $delete = $_POST['delete'];   //削除したい番号
        
    
        
    if(isset($edit)) { //編集ボタンを押したとき
            foreach($lines as $line){
              
                $line_date = explode("<>",$line);
                if($line_date[0] == $_POST['edit_number'] && $line_date[4] == $password){ //入力された編集番号のデータを探す
                    $edit_val = $line_date[0]; //変数に代入
                    $edit_name = $line_date[1];
                    $edit_comment = $line_date[2];
                    $edit_password = $line_date[4];
                    echo "パスワード一致";
                    break;
                }else{   //パスワード一致しないとき
                    if(!strlen($password)) {
                    echo "<br>";
                    echo "パスワードを入力してください";
                    } elseif(!strlen($_POST['edit_number'])){
                      echo "<br>";
                      echo "編集番号を入力してください";
                    } 
                    else {
                        echo "<br>";
                        echo "パスワードが一致しません";
                    }
                }
            }
        } 
        
        
        
        elseif(isset($submit)){ //送信ボタン押したとき
            //書き込みデータ作成（テキストに書き込まれたデータで）
            $write_date = $num  . "<>" . $name . "<>" . $text . "<>" . $date . "<>" . $password;
            echo "書き込みデータ作成";
            echo "<br>";
            if($_POST["edit_post"]){ //編集番号があれば
                foreach($lines as &$line){ 
                    $line_date = explode("<>",$line);
                    //編集番号のとき上書き
                    if($line_date[0] == $_POST["edit_post"]) { 
                       // $line_date[0] -1;
                        echo "<br>";
                        echo "上書き";
                        $line = $write_date;
                    }
                }
            }
             else { //編集番号がないとき
             if (!strlen($text AND $name AND $password)){//それぞれからのとき
             echo "<br>";
             echo "それぞれ文字を入力してください";
             }else {
            echo "新規投稿";
            echo "<br>";
            $lines[] = $write_date;
             }
        }
        
            file_put_contents($filename,implode("\n",$lines));
            echo "<br>";
            echo "ファイル書き込み";
        }
       
       
       
   //削除
         if(strlen($delete AND $password)){ //$deleteに記入されているとき
           $file_date = file($filename);//file中身読み込む
           $fpw = fopen($filename,"w");//書き込み準備
            echo "記入完了";
           for ($i = 0; $i < count($file_date);$i++) {
            $del_date = explode("<>",trim($file_date[$i])); //文字連結して空白を取り除く
            
            if($del_date[0] == $delete && $del_date[4] == $password){
                echo "<br>";
                echo "パスワード一致";
                fwrite($fpw,"削除しました". PHP_EOL);
            }else {
                    fwrite($fpw,$file_date[$i]);
            }
           }
           fclose($fpw);//ファイル閉じる
         } 
         
    
    ?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>m3-05</title>
        <meta charaset="UTF-8">
    </head>
    <body>
        <form action="m3-05.php" method="post">
            <input type="hidden" name="edit_post" value="<?php echo $edit_val; ?>">
            <input type="text" name="name" placeholder="名前" value="<?php echo $edit_name; ?>">
            <br>
            <input type="text" name="text" placeholder="コメント" value="<?php echo $edit_comment; ?>">
            <br>
            <input type="password" name="password" placeholder="パスワード" value="<?php echo $edit_password; ?>">
            <br>
            <input type="submit" name="submit" value="送信">
            <br>
        </form>
        <form action="m3-05.php" method="post">
            <input type="text" name="delete" placeholder="削除対象番号">
            <br>
            <input type="password" name="password" placeholder="パスワード">
            <br>
            <input type="submit" value="削除">
        </form>
        <form action="m3-05.php" method="post">
            <input type="text" name="edit_number" placeholder="編集対象番号">
            <br>
            <input type="password" name="password" placeholder="パスワード">
             <br>
            <input type="submit" name="edit" value="編集">
        </form>
        
        
        <?php    
         //ファイル内容表示
          $lines = file($filename,FILE_IGNORE_NEW_LINES);
          if(file_exists($filename)){
                 foreach($lines as $line){
                     $explode = explode("<>",$line);//<>で区切って保存
                     $implode = implode(" ",$explode);//文字連結
                     echo $implode;
                     echo "<br>";
                 }
                 }
        ?>
        </body>
            
    </html>
