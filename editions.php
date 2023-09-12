<!DOCTYPE html>
<html>
<?php
include_once 'head.php';
?>
<div>
<?php
include_once 'nav.php';
?>
<?php
require_once 'db.php';
global $database;
if (isset($_GET['book'])) {
    $bookId = $_GET['book'];
    $book = $database->getBook($bookId);
    $editions = $database->getEditionsByBook($bookId);
    $bookTitle = $book['title'];
    echo "<h1>Editions of &ldquo;$bookTitle&rdquo;</h1>";
}
else {
    echo "<h1>Editions</h1>";
    $editions = $database->getEditions();
}

echo "<div class='editions'>";

$bookId = NULL;
$authorId = NULL;
$title = NULL;
$newAuthorId = NULL;
$authorName = NULL;

foreach ($editions as $edition) {
    echo "<div class='edition'>";
    $printing = $edition['printing'];
    $coverImage = $edition['cover_image'];
    $published = $edition['published'];
    $price = $edition['price'];
    $condition = $edition['condition'];
    $newBookId = $edition['book_id'];

    if ($newBookId != $bookId) {
        $bookId = $newBookId;
        $book = $database->getBook($bookId);
        $newAuthorId = $book['author_id'];
        $title = $book['title'];
    }

    if ($newAuthorId != $authorId) {
        $authorId = $newAuthorId;
        $author = $database->getAuthor($authorId);
        $authorName = $author['name'];
    }


    if ($coverImage) {
        echo "<img alt='cover' class='cover-image' src='$coverImage'/><br/>";
    }
    else {
        echo "<img alt='cover' class='cover-image' src='img/bookcover.jpg'/><br/>";
    }
    if (!isset($_GET['book'])) {
        echo "<b>Title: </b> $title<br/>";
    }

    echo "<b>Author: </b>$authorName<br/>";
    echo "<b>Published: </b>$published<br/>";
    echo "<b>Price: </b> £$price<br/>";
    echo "<b>Condition: </b>$condition<br/><br/>";
    echo "</div>";
}
?>
</div>
</body>
</html>

