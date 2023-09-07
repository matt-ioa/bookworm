<?php
require_once 'db.php';

$authors = ['asimov', 'tolkien', 'pratchett', 'joseph-campbell', 'rowling', 'gaiman', 'george-martin'];

foreach ($authors as $author) {
    $url = "https://openlibrary.org/search.json?author=$author&language=eng&sort=rating";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $resp = curl_exec($curl);
    curl_close($curl);

    $decodedText = html_entity_decode($resp);
    $authorResp = json_decode($decodedText, TRUE);

    for ($i = 0; $i < 5; $i++) {
        $book = $authorResp['docs'][$i];

        $bookInfo = ['title' => $book['title'], 'authorName' => $book['author_name'][0], 'coverImage' => $book['cover_i'],
            'firstPublished' => $book['first_publish_year']];

        var_dump($bookInfo);
    }
}



