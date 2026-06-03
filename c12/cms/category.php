<?php
// 슬라이드 50
declare(strict_types = 1); // 엄격한 타입 사용
require_once 'includes/datebase-connection.php'; // PDO 객체
require_once 'includes/functions.php';

// ---------
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // 아이디 유효성 확인
if (!$id) {
  include 'page-not-found.php';
}
$sql = "SELECT id, name, description FROM category WHERE id=:id;";
$category = pdo($pdo, $sql, [$id])->fetch();
if (!$category) {
  include 'page-not-found.php';
}
// ---------

$sql = "SELECT a.id, a.title, a.summary, a.category_id, a.member_id,
               c.name AS category,
               CONCAT(m.forename, ' ', m.surname) AS author,
               i.file   AS image_file,
               i.alt    AS image_alt
          FROM article  AS a
          JOIN category AS c ON a.category_id = c.id
          JOIN member   AS m ON a.member_id   = m.id
        LEFT JOIN image AS i ON a.image_id    = i.id
      WHERE a.category_id = :id AND a.published = 1;
      ORDER BY a.id DESC;"; // 최근 기사 가져오는 SQL
$articles = pdo($pdo, $sql, [$id])->fetchAll(); // 기사 6개 불러오기

$sql = "SELECT id, name FROM category WHERE navigation = 1;";
$navigation = pdo($pdo, $sql)->fetchAll();

$section    = $category['id'];
$title      = $category['name']; // HTML <Title> tag
$description= $category['description']; // 메타 description
?>
<?php include 'includes/header.php'; ?>
<main class="container" id="content">
  <section class="header">
    <h1><?= html_escape($category['name']) ?></h1>
    <p><?= html_escape($category['description']) ?></p>
  </section>
  <section class="grid">
  <?php foreach ($articles as $article) { ?>
    <article class="summary">
      <a href="article.php?id=<?= $article['id'] ?>">
        <img src="uploads/<?= html_escape($article['image_file'] ?? 'blank.png') ?>"
             alt="<?= html_escape($article['image_alt']) ?>">
        <h2><?= html_escape($article['title']) ?></h2>
        <p><?= html_escape($article['summary']) ?></p>
      </a>
      <p class="credit">
        Posted in <a href="category.php?id=<?= $article['category_id'] ?>">
        <?= html_escape($article['category']) ?></a>
        by <a href="member.php?id=<?= $article['member_id'] ?>">
        <?= html_escape($article['author']) ?></a>
      </p>
    </article>
  <?php } ?>
  </section>
</main>
<?php include 'includes/footer.php'; ?>