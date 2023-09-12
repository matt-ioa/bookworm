<?php

$host = '172.18.0.4';
$db   = 'bookworm';
$user = 'root';
$pass = 'password';
$charset = 'utf8mb4';
$port = '3306';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
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
        $born = $author['born'] ?? 'NULL';
        $died = $author['died'] ?? 'NULL';
        $query = "INSERT INTO authors (name, born, died) VALUES ('$name', '$born', '$died')";
        $stmt = $this->pdo->query($query);
//        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }

    function findAuthor($author) {
        $query = "SELECT * from authors WHERE name LIKE '$author'";
        $stmt = $this->pdo->query($query);
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return $result[0]['author_id'];
        }
        else {
            return NULL;
        }
    }

    function findBook($book) {
        $query = "SELECT * from books WHERE title LIKE '$book'";
        $stmt = $this->pdo->query($query);
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            return $result[0]['book_id'];
        }
        else {
            return NULL;
        }
    }

    function addBook($book) {
        var_dump($book);
        $title = str_replace(["'"], '&apos;', $book['title']);
        $authorId = intval($book['authorId']);
        $first_published = $book['firstPublished'] ?? 'NULL';
        $query = "INSERT INTO books (title, author_id, first_published)
                  VALUES ('$title', $authorId, '$first_published')";
        echo $query;
        $stmt = $this->pdo->query($query);
        return intval($this->pdo->lastInsertId());
    }
    function addEdition($edition) {
        $coverImage = $edition['coverImage'];
        $bookId = $edition['bookId'];
        $published = $edition['published'];
        $price = floatval($edition['price']);
        $condition = $edition['condition'];
        $query = "INSERT INTO editions (cover_image, book_id, published, price, `condition`)
                  VALUES ('$coverImage', $bookId, '$published', $price, '$condition')";
        $stmt = $this->pdo->query($query);
        return intval($this->pdo->lastInsertId());
    }

    function getAuthor($authorId) {
        $query = "SELECT * from authors WHERE author_id = $authorId";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll()[0];
    }

    function getAuthors() {
        $query = "SELECT * from authors";
        return $this->pdo->query($query);
    }

    function getBook($bookId) {
        $query = "SELECT * from books WHERE book_id = $bookId";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll()[0];
    }

    function getBooks() {
        $query = "SELECT * from books";
        return $this->pdo->query($query);
    }

    function getBooksByAuthor($authorId) {
        $query = "SELECT * from books WHERE author_id = $authorId";
        return $this->pdo->query($query);
    }
    function getEditions() {
        $query = "SELECT * from editions";
        return $this->pdo->query($query);
    }

    function getEditionsByBook($bookId) {
        $query = "SELECT * from editions WHERE book_id = $bookId";
        return $this->pdo->query($query);
    }
}

$pdo = new PDO($dsn, $user, $pass, $options);
$database = new Database($pdo);
