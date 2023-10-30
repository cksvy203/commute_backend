<?php
require_once 'vendor/autoload.php'; // Firebase JWT 라이브러리 로드

// 데이터베이스 연결 정보
$host = "localhost";
$db_name = "your_database_name";
$username = "your_database_username";
$password = "your_database_password";

// JWT 시크릿 키
$jwt_key = "your-secret-key";

use \Firebase\JWT\JWT;

// JWT 생성 함수
function generateJWT($data) {
    global $jwt_key;
    $token_payload = array(
        "data" => $data,
        "exp" => time() + 3600 // 토큰 유효 기간 설정 (1 시간)
    );
    return JWT::encode($token_payload, $jwt_key);
}

// JWT 검증 함수
function verifyJWT($token) {
    global $jwt_key;
    try {
        $decoded = JWT::decode($token, $jwt_key, array('HS256'));
        return $decoded->data;
    } catch (Exception $e) {
        return null;
    }
}

// 사용자 로그인 함수
function loginUser($email, $password) {
    global $host, $db_name, $username, $password;
    // 사용자 인증 확인 및 데이터베이스 연결 로직 (예: 데이터베이스에서 사용자 정보 확인)

    if (/* 사용자 인증 성공 */) {
        // JWT 생성
        $token = generateJWT(array("email" => $email));
        return $token;
    } else {
        return false;
    }
}

try {
    // 데이터베이스 연결
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login') {
        $data = json_decode(file_get_contents("php://input"));
        $email = $data->email;
        $password = $data->password;

        // 사용자 로그인 및 JWT 생성 (위의 코드와 동일)

    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/protected') {
        $auth_header = getallheaders()['Authorization'];
        if ($auth_header) {
            $jwt = str_replace('Bearer ', '', $auth_header);

            // JWT 검증 및 해독 (위의 코드와 동일)

        } else {
            http_response_code(401);
            echo json_encode(array("error" => "인증 헤더가 누락됨"));
        }
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("error" => $e->getMessage()));
}
?>