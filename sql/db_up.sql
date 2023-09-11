CREATE DATABASE bookworm;

USE bookworm;

CREATE TABLE authors
(
    author_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    born VARCHAR(255),
    died VARCHAR(255)
);

CREATE TABLE books
(
    book_id         INT AUTO_INCREMENT PRIMARY KEY,
    title           VARCHAR(255),
    author_id       INT,
    FOREIGN KEY (author_id)
        REFERENCES authors (author_id),
    genre           VARCHAR(255),
    first_published VARCHAR(50),
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
    published VARCHAR(50),
    price DECIMAL
);
