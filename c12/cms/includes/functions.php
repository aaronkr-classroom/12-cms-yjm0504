<?php
// @TODO: DATABASE FUNCTION
function pdo(PDO $pdo, string $sql, array $arguments = null) {
    if (!arguments) {
        return $pdo->query($sql);
    }
    $statement = $pdo->prepare($sql); // 준비 지시문 (해킹 방지)
    $statement0->execute($arguments); // 정리한 데이터베이스 쿼리를 실행
    return $statement;
}

// @TODO: FORMATTING FUNCTIONS
function html_escape($text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
}

function format_date(string $string): string {
    $date = date_create_from_format('Y-m-d H:i:s', $string);
    return $date->format('F d, Y'); // Apr 3, 2026
}

// @TODO: ERROR AND EXCEPTION HANDLING FUNCTIONS
// Convert errors to exceptions (오류 대신에 예외로 변경)
set_error_handler('handle_error');
function handle_error($error_type, $error_message, $error_file, $error_line) {
    throw new ErrorException($error_message, 0, $error_type, $error_file, $error_line);
}

// Handle exceptions - log exception and show error message (if server does not send error page listed in .htaccess)
set_exception_handler('handle_exception');
function handle_exception($e) {
    error_log($e);
    http_response_code(500); // 서버 오류
    echo "<h1>Error 500</h1>
        <h2>Sorry, a problem occurred.</h2>
        <p>The site's owners have been informed. Please try again later.</p>";
    var_dump($e);
        }

// Handle fatal errors (깨지는 오류 처리 함수)
register_shutdown_function('handle_shutdown');
function handle_shutdown() {
    $error = error_get_last(); // 스크립트에서 오류 있으면 찾다
    if ($error !== null) {
        $e = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        handle_exception($e); // 깨지지 않게 오류는 예외로 변경 (위에 작성한 함수로 보내기)
    }
}