<!DOCTYPE html>
<html>
<?php
include_once 'head.php';
?>
<body>
<?php
include_once 'nav.php';
?>
<h1>Authors</h1>
<div class="content">
<?php
require_once 'db.php';
global $database;
$authors = $database->getAuthors();
foreach ($authors as $author) {
    $name = $author['name'];
    $id = $author['author_id'];
    echo "<a href='books.php?author=$id'><h2>$name</h2></a>";
}
?>
</div>
</body>
</html>

