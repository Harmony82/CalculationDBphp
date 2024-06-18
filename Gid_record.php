<?php
// データベース接続情報
$servername = "mysql644.db.sakura.ne.jp";
$username = "kaitgamdev"; // 適宜変更
$password = "power-of-game0"; // 適宜変更
$dbname = "kaitgamdev_ogawa"; // 事前に作成しておく
$dsn ="mysql:host=$servername;dbname=$dbname;";

// エラーレポートの設定
error_reporting(E_ALL);
ini_set('display_errors', 1);

// デバッグ用ログファイルの準備
//$log_file = 'debug_Gid_record.txt';
//file_put_contents($log_file, ""); // ログファイルをクリア

// JSONデータの読み込み
$input = file_get_contents('php://input');
//file_put_contents($log_file, "Received JSON: $input\n", FILE_APPEND); // デバッグ用に受信データを保存

$data = json_decode($input, true);

if ($data === null) {
    //file_put_contents($log_file, "Invalid JSON\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON"]);
    exit();
}

$id = $data['player_id'];

//file_put_contents($log_file, "Decoded JSON: id=$id\n", FILE_APPEND);

// データベース接続
$dbh = new PDO($dsn, $username, $password);

// SQL文の定義
$sql = 'INSERT INTO Gid (id) VALUES (:id)';

// SQLの準備
$sth = $dbh->prepare($sql);

//値のバインド
$sth->bindValue(':id',$id);

//SQLの実行
$sth->execute();

// 挿入されたレコードのIDを取得
$last_id = $dbh->lastInsertId();

// IDをJSON形式で返す
echo json_encode(array("Gid" => $last_id));
?>