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
//        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }

    function addBook($book) {
        var_dump($book);
        $title = str_replace(["'"], '&apos;', $book['title']);
        $authorId = intval($book['authorId']);
        $genre = str_replace(["'"], '&apos;', $book['genre']);
        $first_published = $book['firstPublished'];
        $query = "INSERT INTO books (title, author_id, genre, first_published)
                  VALUES ('$title', $authorId, '$genre', '$first_published')";
        echo $query;
        $stmt = $this->pdo->query($query);
//        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }
    function addEdition($edition) {
        $printing = intval($edition['printing']);
        $coverImage = $edition['coverImage'];
        $bookId = $edition['bookId'];
        $published = $edition['published'];
        $price = $edition['price'];
        $query = "INSERT INTO editions (printing, cover_image, book_id, published, price)
                  VALUES ($printing, '$coverImage', $bookId, '$published', $price)";
        $stmt = $this->pdo->query($query);
//        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }

    function getAuthorId($author) {

    }
}

$pdo = new PDO($dsn, $user, $pass, $options);
