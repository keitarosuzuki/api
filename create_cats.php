<?php
// PHPのコード
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// POSTリクエストから値を取得
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name'])) {
  $name = $data['name'];
  
  // データベース接続
  $mysqli = new mysqli('localhost', 'phpuser', 'php', 'phptest');
  if($mysqli->connect_error){
    echo json_encode(["error" => $mysqli->connect_error]);
    exit();
  } else {
    $mysqli->set_charset("utf8mb4");
  }

  function generateRandomInt() {
    // 10桁の無作為な数字を生成
    $int = '';
    for ($i = 0; $i < 5; $i++) {
        $int .= mt_rand(0, 9); // 0から9までの乱数を連結
    }
    return $int;
  }
  
  // Create (INSERT)
    $id = generateRandomInt();
    $sql = "INSERT INTO mycats (id, name) VALUES ('$id', '$name')";
    if ($mysqli->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $mysqli->error;
    }

} else {
  echo 'Key not found in the request.';
}

// 接続を閉じる
$mysqli->close();