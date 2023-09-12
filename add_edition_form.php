<?php
require_once 'db.php';
global $database;
$output1 = '<h1>Add book edition</h1>'
    . '<div class="content">'
        . '<form action="add_edition.php" method="post" class="form-example" enctype="multipart/form-data">'
            . '<div class="form-add">'
                . '<label for="name">Author name</label><br/>'
                . '<input list="authors" name="author" id="author" required />'
                . '<datalist id="authors">';

echo $output1;
$authors = $database->getAuthors();

foreach ($authors as $author) {
    $authorName = $author['name'];
    echo "<option value='$authorName'></option>";
}

$output2 = '</datalist>'
            . '</div>'
            . '<div class="form-add">'
                . '<label for="book">Book title</label><br/>'
                . '<input type="text" name="book" id="book" required />'
            . '</div>'
            . '<div class="form-add">'
                . '<label for="published">Publication year</label><br/>'
                . '<input type="text" name="published" id="published" required />'
            . '</div>'
            . '<div class="form-add">'
                . '<label for="cover-image">Cover image URL</label><br/>'
                . '<input id="cover-image" name="cover-image" type="text" />'
            . '</div>'
            . '<div class="form-add">'
                . '<label for="price">Price</label><br/>'
                . '<input type="text" name="price" id="price" required />'
            . '</div>'
            . '<div class="form-add">'
                . '<label for="condition">Condition</label><br/>'
                . '<input type="text" name="condition" id="condition" required />'
            . '</div>'
            . '<div class="form-add">'
                . '<input name="add-edition" id="add-button" type="submit" value="Add edition" />'
            . '</div>'
        . '</form>'
    . '</div>';

echo $output2;
