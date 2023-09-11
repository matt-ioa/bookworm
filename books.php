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
if (isset($_GET['author'])) {
    $authorId = $_GET['author'];
    $author = $database->getAuthor($authorId);
    $books = $database->getBooksByAuthor($authorId);
    $authorName = $author['name'];
    echo "<h1>Books by $authorName</h1>";
}
else {
    echo "<h1>Books</h1>";
    $books = $database->getBooks();
}

echo "<div class='content'>";
foreach ($books as $book) {
    $bookTitle = $book['title'];
    $bookId = $book['book_id'];
    echo "<a href='editions.php?book=$bookId'><h2>$bookTitle</h2></a>";
}
?>
</div>
</body>
</html>

