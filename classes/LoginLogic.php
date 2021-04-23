<?php

require_once '../dbconnect.php';

class LoginLogic
{
	/**
	 * ログイン処理
	 * @param string $UserID
	 * @param string $Password
	 * @return bool $result
	 */
	public static function login($UserID, $Password)
	{
		// 結果
		$result = false;

		// ユーザーをUserIDから検索して取得
		$user = self::getUserByUserID($UserID);

		// 入力したUserIDがtechnical_trainingデータベースのuserテーブルに存在しなかった場合の処理
		if (!$user) {
			$_SESSION['message'] = 'UserIDが一致しません。';
			return  $result;
		}



		//　パスワードの照会
		if ($Password === $user['Password']) {

			// ログイン成功時
			// セッションハイジャック対策
			session_regenerate_id(true);
			$_SESSION['login_user'] = $user;
			$result = true;
			return $result;
		}

		$_SESSION['message'] = 'パスワードが一致しません。';
		return  $result;
	}


	/**
	 * $UserIDからユーザーを取得
	 * @param string $UserID
	 * @return array|bool $user|false
	 */
	public static function getUserByUserID($UserID)
	{

		// SQLの準備
		// SQLの実行
		// SQLの結果を返す

		$sql = "SELECT * FROM user WHERE UserID = ?";

		//UserIDを配列に入れる 
		$arr = [];
		$arr[] = $UserID;

		try {
			// SQLの準備
			$stmt =  connect()->prepare($sql);

			// 用意したSQL文$stmtを実行
			$stmt->execute($arr);

			// SQLの結果を返す
			$user = $stmt->fetch();

			return $user;
		} catch (\Exception $e) {

			return false;
		}
	}



	/**
	 * ログインチェック
	 * @param void
	 * @return bool $result
	 */
	public static function checkLogin()
	{
		$result = false;

		// セッションにログインユーザが入っていなかったらfalse
		// && $_SESSION['login_user']['名前'] > 0 →なぜこれがif文の中にあるとうまくいかないのか
		if (isset($_SESSION['login_user'])) {
			return $result = true;
		}


		return $result;
	}

	/**
	 * ログアウト処理
	 */
	public static function logout()
	{
		// セッション変数を全て解除する
		$_SESSION = array();

		// セッションを切断するにはセッションクッキーも削除する。
		// Note: セッション情報だけでなくセッションを破壊する。
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}

		// 最終的に、セッションを破壊する
		session_destroy();
	}
}
