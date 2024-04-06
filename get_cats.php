<?php
// PHPのコード
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// データベース接続
$mysqli = new mysqli('localhost', 'phpuser', 'php', 'phptest');
if($mysqli->connect_error){
  echo json_encode(["error" => $mysqli->connect_error]);
  exit();
} else {
  $mysqli->set_charset("utf8mb4");
}

// データ取得
$sql = "SELECT id, name, mine FROM mycats";
$result = $mysqli->query($sql);

// 結果を配列に格納して出力
$data = [];
while ($row = $result->fetch_assoc()){
  // データを取得し、必要な値をbooleanに変換して格納する
  $id = $row['id'];
  $name = $row['name'];
  $mine = $row['mine'] === '1'; // '1'をtrueとして扱う
  $data[] = ['id' => $id, 'name' => $name, 'mine' => $mine];
}
echo json_encode($data);

// 接続を閉じる
$mysqli->close();