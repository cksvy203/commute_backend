<?php
// 데이터베이스 연결 정보
$host = "localhost";
$db_name = "your_database_name";
$username = "your_database_username";
$password = "your_database_password";

try {
    // 데이터베이스 연결
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 사용자가 POST로 보낸 데이터 가져오기
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_salt = $_POST['password_salt'];
    $password_hash = $_POST['password_hash'];
    $encrypted_password = $_POST['encrypted_password'];

    // 데이터베이스에 사용자 정보 삽입
    $sql = "INSERT INTO users (username, email, password_salt, password_hash, encrypted_password) VALUES (:username, :email, :password_salt, :password_hash, :encrypted_password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_salt', $password_salt);
    $stmt->bindParam(':password_hash', $password_hash);
    $stmt->bindParam(':encrypted_password', $encrypted_password);
    $stmt->execute();

    // 회원가입 성공 메시지 반환
    echo json_encode(array("message" => "회원가입이 완료되었습니다."));
} catch (PDOException $e) {
    // 에러 발생 시 오류 메시지 반환
    echo json_encode(array("error" => $e->getMessage()));
}
?>