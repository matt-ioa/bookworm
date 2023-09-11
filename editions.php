<!DOCTYPE html>
<html>
<?php
include_once 'head.php';
?>
<body>
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
    $books = $database->getEditions();
}

//echo "<div class='content'>";
//foreach ($books as $book) {
//    $bookTitle = $book['title'];
//    $bookId = $book['book_id'];
//    echo "<a href='editions.php?edition=$bookId'><h2>$bookTitle</h2></a>";
//}
?>
</body>
</html>

