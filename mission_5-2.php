<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    
    $name = $_POST['name'];/*名前を取得*/
    $comment = $_POST['comment'];/*コメントを取得 */
    $deletenum = $_POST['deletenum'];/*削除番号を取得 */
    $editnum = $_POST['editnum'];
    $editnum1 = $_POST['editnum1'];
    $pas1 = $_POST['password1'];
    $pas2 = $_POST['password2'];
    $pas3 = $_POST['password3'];
    // 投稿機能
    if ($name != null && $comment != null && $pas1 != null) {
        $sql = $db->prepare("INSERT INTO techbase (name, comment,password) VALUES (:name, :comment,:password)");
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql->bindParam(':password', $pas1, PDO::PARAM_STR);
        $sql->execute();
    }
    // 削除機能
    if ($deletenum != null && $pas2 != null) {

        $sql02 = "delete from techbase where password=:password AND num=:num";
        $stmt01 = $db->prepare($sql02);
        $stmt01->bindParam(':password', $pas2, PDO::PARAM_STR);
        $stmt01->bindParam(':num', $deletenum, PDO::PARAM_STR);
        $stmt01->execute();
        echo '削除しました';
    }
    // 編集機能
    if ($editnum != null && $pas3 != null) {

        $sql04 = 'SELECT * FROM techbase';
        $stmt04 = $db->query($sql04);
        $results04 = $stmt04->fetchAll();
        foreach ($results04 as $rows) {
            if ($rows['password'] == $pas3 && $rows['num'] == $editnum) {
                $editname = $rows['name'];
                $editcomment = $rows['comment'];
            }
        }
    }
    if ($editnum1 != null && $name != null && $comment != null) {

        $sql03 = 'UPDATE techbase SET name=:name,comment=:comment where num=:num';
        $stmt03 = $db->prepare($sql03);
       $stmt03->bindParam(':name',$name,PDO::PARAM_STR);
       $stmt03->bindParam(':comment',$comment,PDO::PARAM_STR);
       $stmt03->bindParam(':num',$editnum1,PDO::PARAM_STR);
        $stmt03->execute($param);
        echo '編集しました';
    }
    ?>
    <form action="" method="post" value="コメント">
        <label for="name">名前</label>
        <input type="text" name="name" value='<?php if (isset($editnum)) {
                                                    echo $editname;
                                                } else {
                                                    echo "";
                                                } ?>'><br>
        <label for="comment">コメント</label>
        <input type="text" name="comment" id="comment" value="<?php if (isset($editnum)) {
                                                                    echo $editcomment;
                                                                } else {
                                                                    echo "";
                                                                } ?>">
        <label for="password">パスワード</label>
        <input type="text" name="password1" id="password">
        <input type="submit" value="送信する" name="normal"><br>

        <label for="deletenum">削除対象番号</label>
        <input type="text" name="deletenum">
        <input type="text" name="password2" placeholder="パスワードを入力してください">
        <input type="submit" value="削除" name="delete">
        <br>
        <label for="editnum">編集</label>
        <input type="text" name="editnum">
        <input type="text" name="password3" placeholder="パスワードを入力してください">
        <input type="hidden" name="editnum1" value="<?php if (isset($editnum)) {
                                                        echo $editnum;
                                                    } else {
                                                        echo "";
                                                    }
                                                    ?>">
        <input type="submit" value="編集" name="editing">

    </form>
    <?php
    $sql01 = 'SELECT * FROM techbase';
    $stmt = $db->query($sql01);
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        echo '<p>' . $row['num'] . '</p> ';
        echo '<p>' . $row['name'] . '</p> ';
        echo '<p>' . $row['comment'] . '</p>';
        echo '<p>' . $row['date'] . '</p>' . '<br>';
        echo "<hr>";
    }
    ?>

</html>