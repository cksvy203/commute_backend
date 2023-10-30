<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/register') {
    require 'register.php'; // 회원가입 요청 처리
} else {
    http_response_code(404);
    echo json_encode(array("error" => "Not Found"));
}
?>