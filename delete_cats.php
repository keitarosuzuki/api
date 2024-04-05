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
  
  // Delete (DELETE)
  $sql = "DELETE FROM mycats WHERE id=$id";
  if ($mysqli->query($sql) === TRUE) {
      echo "Record deleted successfully";
  } else {
      echo "Error deleting record: " . $mysqli->error;
  }

} else {
  echo 'Key not found in the request.';
}

// 接続を閉じる
$mysqli->close();