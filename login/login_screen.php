<?php

session_start();

require_once '../classes/LoginLogic.php';


//ログインしているかを判定。していたらログイン完了画面に遷移
$result = LoginLogic::checkLogin();
if ($result) {
    header('Location: login_success_screen.php');
    return;
}

$error = $_SESSION;

// セッションが切れてない状態でログアウトボタンが押されたら、ログアウトする
LoginLogic::logout();

// セッションを消す
//リロードした時にセッションファイルを消したい
// $_SESSION = array();
// session_destroy();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/technical_training.css" />
</head>

<body>

    <div class="container login_container">
        <div class="title">
            <h1>ログイン画面</h1>
        </div class="error_message_container">
        <?php if (isset($error['message'])) : ?>
            <p class="error_message"><?php echo $error['message']; ?></p>
        <?php endif; ?>
        <div>
        </div>
        <div class="loginID_password_container">
            <form action="login_success_screen.php" method="post">
                <div class="mb-3">
                    <label for="UserID" class="form-label">UserID</label>
                    <input type="text" class="form-control" id="UserID" name="UserID" id="UserID" placeholder="UserID">
                    <?php if (isset($error['UserID'])) : ?>
                        <p class="UserID_not_entered"><?php echo $error['UserID']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="Password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="Password" name="Password" id="Password" placeholder="Password">
                    <?php if (isset($error['Password'])) : ?>
                        <p class="Password_not_entered"><?php echo $error['Password']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="showHidePassowordCheckBox">
                    <input type="checkbox" onclick="showHidePassword()"> Show/Hide Password</p>
                </div>
                <div class="login_button">
                    <button type="submit" class="btn btn-primary">ログイン</button>
                </div>
            </form>
            <div>
                <p>ブランチテスト</p>
            </div>
        </div>
    </div>

    <script>
        function showHidePassword() {
            let input_password = document.getElementById("Password");
            if (input_password.type === "password") {
                input_password.type = "text";
            } else {
                input_password.type = "password";
            }
            console.log(input_password.type);
        }
    </script>

</body>

</html>