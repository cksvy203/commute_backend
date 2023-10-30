<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 사용자 인증 로직 (실제로는 데이터베이스 등을 사용하여 확인)
    if ($username === '사용자명' && $password === '비밀번호') {
        echo "로그인 성공";
    } else {
        echo "로그인 실패";
    }
}
?>