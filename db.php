<?php

$host = '127.0.0.1';
$db   = 'bookworm';
$user = 'root';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

class Database {
    public function __construct(private $pdo) {
    }

    function execQuery($query) {
        $stmt = $this->pdo->query($query);
        return $stmt->execute();
    }

    function query($query) {
        $stmt = $this->pdo->query($query);
        return $stmt->fetch();
    }

    function addAuthor($author) {
        $name = $author['name'];
        $born = $author['born'];
        $died = $author['died'];
        $query = "INSERT INTO authors (name, born, died) VALUES ('$name', '$born', '$died')";
        $stmt = $this->pdo->query($query);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }

    function addBook($book) {
        $title = $book['title'];
        $authorId = $book['authorId'];
        $genre = $book['genre'];
        $first_published = $book['firstPublished'];
        $rating = $book['rating'];
        $query = "INSERT INTO book VALUES ($title, $authorId, $genre, $first_published, $rating)";
        $stmt = $this->pdo->query($query);
        return $stmt->execute();
    }
    function addEdition($edition) {
        $printing = $edition['printing'];
        $coverImage = $edition['coverImage'];
        $bookId = $edition['bookId'];
        $published = $edition['published'];
        $price = $edition['price'];
        $query = "INSERT INTO editions VALUES ($printing, $coverImage, $bookId, $published, $price)";
        $stmt = $this->pdo->query($query);
        return $stmt->execute();
    }

    function getAuthorId($author) {

    }
}

$pdo = new PDO($dsn, $user, $pass, $options);
