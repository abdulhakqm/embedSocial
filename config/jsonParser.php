
<?php

    //Reviews.json had 4 errors so I validated it to data.json

    $jsonParser = file_get_contents("./data.json");  
    $results = json_decode($jsonParser , true);

    $reviews = [];

    for ($i = 0; $i < count($results); $i++) {
        array_push($reviews, $results[$i]);
    };


?>