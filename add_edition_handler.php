<!DOCTYPE html>
<html>
<?php
include_once 'head.php';
?>
<body>
<?php
include_once 'nav.php';
require_once 'db.php';
global $database;

$author = $_POST['author'];
$book = $_POST['book'];
$published = $_POST['published'];
$coverImage = $_POST['cover-image'];
$price = $_POST['price'];
$condition = $_POST['condition'];

$authorId = $database->findAuthor($author);

if ($authorId === NULL) {
    $authorId = $database->addAuthor(['name'=>$author]);
}

$bookId = $database->findBook($book);

if ($bookId === NULL) {
    $bookId = $database->addBook(['title'=>$book,'authorId'=>$authorId]);
}

$editionMap = ['published'=>$published,'bookId'=>$bookId,
    'coverImage'=>$coverImage,'price'=>$price,'condition'=>$condition];

$editionId = $database->addEdition($editionMap);

$editionLink = "editions.php?book=$bookId";

echo "<h1>Edition added!</h1>"
    . "<div class='blurb'"
. "<p>$author</p>"
    . "<p>$book</p>"
    . "<p>$published</p>"
    . "<p>$coverImage</p>"
    . "<p>$price</p>"
    . "<p>$condition</p>"
. "<p>Click <a href='$editionLink'>here</a> to view it.</p>";
?>
</body>
</html>
