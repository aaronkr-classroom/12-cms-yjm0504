<?php
declare(strict_types = 1); // 엄격한 타입 사용
http_response_code(404);
require_once 'includes/datebase-connection.php'; // PDO 객체
require_once 'includes/functions.php';

$sql = "SELECT id, name FROM category WHERE navigation = 1;";
$navigation = pdo($pdo, $sql)->fetchAll();

$section    = '';
$title      = 'Page Not Found'; // HTML <Title> tag
$description= ''; // 메타 description
?>
<?php require_once 'includes/header.php'; ?>
  <main class="container" id="content">
    <h1>Sorry! We cannot find that page.</h1>
    <p>Try the <a href="index.php">home page</a> or email us
      <a href="mailto:hello@eg.link">hello@eg.link</a></p>
  </main>
<?php
require_once 'includes/footer.php';
exit;
?>