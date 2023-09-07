CREATE DATABASE bookworm;

USE bookworm;

CREATE TABLE authors
(
    author_id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50),
    lname VARCHAR(50),
    country VARCHAR(50),
    born DATE
);

CREATE TABLE books
(
    book_id         INT AUTO_INCREMENT PRIMARY KEY,
    title           VARCHAR(50),
    author_id       INT,
    FOREIGN KEY (author_id)
        REFERENCES authors (author_id),
    genre           VARCHAR(50),
    first_published DATE,
    rating          INT
);

CREATE TABLE editions
(
    edition_id INT AUTO_INCREMENT PRIMARY KEY,
    printing INT,
    cover_image VARCHAR(255),
    book_id INT,
    FOREIGN KEY(book_id)
        REFERENCES books(book_id),
    published DATE,
    price DECIMAL
);
