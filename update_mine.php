<?php
// PHPのコード
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// POSTリクエストから値を取得
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
  $id = $data['id'];
  
  // データベース接続
  $mysqli = new mysqli('localhost', 'phpuser', 'php', 'phptest');
  if($mysqli->connect_error){
    echo json_encode(["error" => $mysqli->connect_error]);
    exit();
  } else {
    $mysqli->set_charset("utf8mb4");
  }

  // 現在のmineの値を取得
  $sql = "SELECT mine FROM mycats WHERE id=$id";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  $currentMineValue = $row['mine'];

  // mineの値をトグルして更新
  $newMineValue = $currentMineValue == 0 ? 1 : 0;
  
  // Update (UPDATE)
  $updateSql = "UPDATE mycats SET mine='$newMineValue' WHERE id=$id";
  if ($mysqli->query($updateSql)) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $mysqli->error;
  }

} else {
  echo 'Key not found in the request.';
}

// 接続を閉じる
$mysqli->close();