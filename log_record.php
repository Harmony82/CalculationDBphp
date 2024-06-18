<?php
// データベース接続情報
$servername = "mysql644.db.sakura.ne.jp";
$username = "kaitgamdev"; // 適宜変更
$password = "power-of-game0"; // 適宜変更
$dbname = "ogawa"; // 事前に作成しておく
$dsn ="mysql:host=$servername;dbname=$dbname;";

// エラーレポートの設定
error_reporting(E_ALL);
ini_set('display_errors', 1);

// デバッグ用ログファイルの準備
//$log_file = 'debug_log_record.txt';
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

$question_count = $data['question_count'];
$correct_count = $data['correct_count'];
$evaluation_count = $data['evaluation_count'];
$good_count = $data['good_count'];
$game_id=$data['game_id'];
//file_put_contents($log_file, "Decoded JSON: question_count=$question_count,correct_count=$correct_count,
//evaluation_count=$evaluation_count, good_count=$good_count,game_id=$game_id\n", FILE_APPEND);

// データベース接続
$dbh = new PDO($dsn, $username, $password);

// SQL文の定義
$sql = 'INSERT INTO log (question_count, correct_count, evaluation_count, good_count,game_id)
 VALUES (:question_count,:correct_count,:evaluation_count,:good_count,:game_id)';

// SQLの準備
$sth = $dbh->prepare($sql);

//値のバインド
$sth->bindValue(':question_count',$question_count);
$sth->bindValue(':correct_count',$correct_count);
$sth->bindValue(':evaluation_count',$evaluation_count);
$sth->bindValue(':good_count',$good_count);
$sth->bindValue(':game_id',$game_id);

//SQLの実行
$sth->execute();


?>