<?php

session_start();

require_once '../classes/LoginLogic.php';


// エラーメッセージ
$error = [];


// バリデーション
//inputの中身がカラだった場合（未入力だった場合）
if (!$UserID = filter_input(INPUT_POST, 'UserID')) {
    $error['UserID'] = 'UserIDを入力してください。';
}

if (!$Password = filter_input(INPUT_POST, 'Password')) {
    $error['Password'] = 'Passwordを入力してください。';
}


// $errorがあった時（inputが未入力であった場合）はログイン画面に戻す処理
if (count($error) > 0) {
    $_SESSION = $error;
    header('Location: login_screen.php');
    return;
}

// ログイン成功時の処理
$result = LoginLogic::login($UserID, $Password);

// ログインに失敗していた場合の処理
// ログイン画面に戻る
if (!$result) {
    header('Location: login_screen.php');
    return;
}

$login_user = $_SESSION['login_user'];

// echo '<br>';
// var_dump($login_user);



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログイン完了画面</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/technical_training.css" />
</head>

<body>
    <div class="container login_success_container">
        <div class="title">
            <h1>ログイン完了！</h1>
        </div>
        <div class="login_UserName">
            <p>ログインユーザ：<?php echo $login_user['UserName']; ?></p>
        </div>
        <div class="go_to_table">
            <div class="to_product_list">
                <form action="./product_list_screen.php">
                    <button type="submit" class="btn btn-success ">商品一覧へ</button>
                </form>
            </div>
            <div class="to_product_category">
                <form action="./product_category_screen.php">
                    <button type="submit" class="btn btn-success ">商品カテゴリ</button>
                </form>
            </div>
        </div>
        <div class="logout_button">
            <form action="./login_screen.php">
                <button type="submit" class="btn btn-primary" name="logout">ログアウト</button>
            </form>
        </div>

    </div>


</html>