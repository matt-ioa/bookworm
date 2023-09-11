<?php
require_once 'db.php';

$authors = ['asimov', 'j-r-r-tolkien', 'joseph-campbell', 'j-k-rowling', 'gaiman', 'george-r-r-martin'];

global $pdo;
$db = new Database($pdo);

foreach ($authors as $author) {
    $authorUrl = "https://openlibrary.org/search/authors.json?q=$author";
    $authorCurl = curl_init($authorUrl);
    curl_setopt($authorCurl, CURLOPT_URL, $authorUrl);
    curl_setopt($authorCurl, CURLOPT_RETURNTRANSFER, true);

    $authorResp = curl_exec($authorCurl);
    curl_close($authorCurl);

    $decodedText = html_entity_decode($authorResp);
    $authorRespMap = json_decode($decodedText, TRUE)['docs'][0];

    $authorMap = ['name'=>$authorRespMap['name'],
        'born'=>$authorRespMap['birth_date'],
        'died'=> ($authorRespMap['death_date'] ? $authorRespMap['death_date'] : null)];

    $authorId = $db->addAuthor($authorMap);

    for ($i = 0; $i < 5; $i++) {
        $bookUrl = "https://openlibrary.org/search.json?author=$author&language=eng&sort=rating";
        $bookCurl = curl_init($bookUrl);
        curl_setopt($bookCurl, CURLOPT_URL, $bookUrl);
        curl_setopt($bookCurl, CURLOPT_RETURNTRANSFER, true);
        $bookResp = curl_exec($bookCurl);
        curl_close($bookCurl);
        $decodedText = html_entity_decode($bookResp);
        $bookRespMap = json_decode($decodedText, TRUE)['docs'][$i];


        $bookMap = ['title'=>$bookRespMap['title'], 'authorId'=>$authorId,
            'genre'=>$bookRespMap['subject'][0],'firstPublished'=>$bookRespMap['first_publish_year']];
        $bookId = $db->addBook($bookMap);

        $workKey = $bookRespMap['key'];
        $editionsUrl = "https://openlibrary.org$workKey/editions.json";
        $editionsCurl = curl_init($editionsUrl);
        curl_setopt($editionsCurl, CURLOPT_URL, $editionsUrl);
        curl_setopt($editionsCurl, CURLOPT_RETURNTRANSFER, true);
        $editionsResp = curl_exec($editionsCurl);
        curl_close($editionsCurl);
        $decodedText = html_entity_decode($editionsResp);
        $editionsRespMap = json_decode($decodedText, TRUE)['entries'];
        $englishEditions = [];

        foreach ($editionsRespMap as $edition) {
            if ($edition['languages']) {
                foreach ($edition['languages'] as $language) {
                    if ($language['key'] === "/languages/eng") {
                        $englishEditions[] = $edition;
                    }
                }
            }
        }

        $editionIndex = array_rand($englishEditions);
        $edition = $englishEditions[$editionIndex];

        if (gettype($edition['covers']) == 'array') {
            $edition['cover'] = $edition['covers'][0];
        }
        else {
            $edition['cover'] = $edition['covers'];
        }

        $coverImage = null;

        if ($edition['cover']) {
            $coverImage = 'https://covers.openlibrary.org/b/id/'
                . $edition['cover']
                . '-M.jpg';
        }

        $editionMap = ['printing'=>$edition['revision'],
            'coverImage'=>$coverImage,
            'bookId'=>$bookId,
            'published'=>$edition['publish_date'],
            'price'=>mt_rand (2*10, 200*10) / 10];

        $db->addEdition($editionMap);

    }
}



