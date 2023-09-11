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
    echo "<h1>Editions of $bookTitle</h1>";
}
else {
    echo "<h1>Editions</h1>";
    $editions = $database->getEditions();
}

echo "<div class='editions'>";
foreach ($editions as $edition) {
    echo "<div class='edition'>";
    $printing = $edition['printing'];
    $coverImage = $edition['cover_image'];
    $published = $edition['published'];
    $price = $edition['price'];
    $bookId = $edition['book_id'];
    if ($coverImage) {
        echo "<img alt='cover' class='cover-image' src='$coverImage'/><br/>";
    }
    else {
        echo "<img alt='cover' class='cover-image' src='img/bookcover.jpg'/><br/>";
    }
    if (!isset($_GET['book'])) {
        $book = $database->getBook($bookId);
        $bookTitle = $book['title'];
        echo "<b>Title: </b> $bookTitle<br/>";
    }

//    $condition = $edition['condition'];
    echo "<b>Printing: </b> $printing<br/>";
    echo "<b>Published: </b> $published<br/>";
    echo "<b>Price: </b> £$price</p><br/>";
    echo "</div>";
}
?>
</div>
</body>
</html>

