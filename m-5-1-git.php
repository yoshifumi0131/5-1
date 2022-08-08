<?php    
    $name = @$_POST["name"];
    $comment = @$_POST["comment"];
    $delete = @$_POST["delete"];
    $edit = @$_POST["edit"];
    $edit_num = @$_POST["edit_num"];
    $pass = @$_POST["password"];
    $password_d = @$_POST["password_d"];
    $password_e = @$_POST["password_e"];
    
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //記入例；
    //4-1で書いた「// DB接続設定」のコードの下に続けて記載する。
    $sql = "CREATE TABLE IF NOT EXISTS tbtest2"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TEXT,"
    . "password TEXT"
    .");";
    $stmt = $pdo->query($sql);
    
    if(!empty($edit)){
        
        $id = $edit;
        $sql = 'SELECT * FROM tbtest2';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if($row['id'] == $id){
                if($row['password']==$password_e){
                    $edit_name = $row['name'];
                    $edit_comment = $row['comment'];
                    $passnum = $row['password'];
                    
                    
                }else{
                    echo "パスワードが異なります"."<br>";
                }
            }
             
            
            
        }
        
    }
    
?>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>
        好きなスポーツを入力してください！
        <form action="" method="post">
            投稿フォーム<br>
            <input type="text" name="name"  placeholder="名前" value="<?php if((!empty($edit_name))&&($passnum == $password_e)) {echo $edit_name;} ?>"><br>
            <input type="text" name="comment" placeholder="コメント" value="<?php if((!empty($edit_comment))&&($passnum == $password_e)) {echo $edit_comment;} ?>"><br>
            <input type="text" name="password" placeholder="パスワード" ><br>
            <input type="submit" name="submit" value="送信"><br>
            削除フォーム<br>
            <input type="text" name="delete" placeholder="削除対象番号"><br>
            <input type="text" name="password_d" placeholder="パスワード" ><br>
            <input type="submit" name="submit2" value="削除"><br>
            編集フォーム<br>
            <input type="text" name="edit" placeholder="編集対象番号"><br>
            <input type="text" name="password_e" placeholder="パスワード" ><br>
            <input type="submit" name="submit3" value="編集"><br>
            <input type="hidden" name="edit_num" value ="<?php if(!empty($edit)) {echo $edit;} ?>">
            
        </form>
    </body>
</html>
<?php
    
    if(!empty($delete)){
        // ファイルを開く
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        $id = $delete;
        $sql = 'SELECT * FROM tbtest2';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if($row['id'] == $id){
                if($row['password']==$password_d){
                    $sql = 'delete from tbtest2 where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $sql = 'SELECT * FROM tbtest2';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row){
                        //$rowの中にはテーブルのカラム名が入る
                        echo $row['id'].',';
                        echo $row['name'].',';
                        echo $row['comment'].',';
                        echo $row['date'].'<br>';
                    echo "<hr>";  
                    }
                }else{
                    echo "パスワードが異なります";
                }
            }
             
            
            
        }
                
        
                    
                
        
        
        
        
    }
    
    
    if(!empty($name)&&!empty($comment)&&empty($edit)&&!empty($pass)){
        if(!empty($edit_num)){
            $id = $edit_num; //変更する投稿番号
            $name = $name;
            $comment = $comment;
            $pass= $pass;
            $date = date("Y/m/d H:i:s");
            $sql = 'UPDATE tbtest2 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $sql = 'SELECT * FROM tbtest2';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
            echo "<hr>";  
            }
        }else{
            $date = date("Y/m/d H:i:s");
            $sql = $pdo -> prepare("INSERT INTO tbtest2 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql -> bindParam(':password', $pass, PDO::PARAM_STR);
            $sql -> execute();
            
            $sql = 'SELECT * FROM tbtest2';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
            echo "<hr>";
            }
        }
    
    }  