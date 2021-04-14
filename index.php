
<?php
    include './config/jsonParser.php';   
    include './functions.php';  

    // FILTERS
    $minimumRating = $_POST['minimum'] ?? "1";
    $ratingOrder = $_POST['rating-order'] ?? "SORT_DESC";
    $date = $_POST['date'] ?? "SORT_DESC";
    $text = $_POST['text'] ?? "yes";    

    $filtered = [];
    
    foreach ($reviews as $review){

        if ($review['rating'] >= $minimumRating){
            
            array_push($filtered, $review);
           
        }        
    }

    // SORTING THE REVIEWS BASED ON POST VALUES
    $sorted = array_orderby($filtered, 'rating', constant($ratingOrder), 'reviewCreatedOnTime', constant($date));

   
    // CHECKING IF PRIORITIZE BY TEXT IS "ON" AND APPLYING IT
    if($text == "yes") {
        foreach($sorted as $key => $filterByText) {
            if($filterByText['reviewText'] == "") {
                $temp = $sorted[$key];
                unset($sorted[$key]);
                array_push($sorted, $temp);
            }
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


    <title>Embed Social</title>
</head>
<body>

    <div class="container w-50 my-5">
        <form action="index.php" method="POST" >

            <!-- order by ratings -->
            <label for="rating-order" class="form-label">Order by Rating:</label>
            <select name="rating-order" class="form-control" id="rating-order">
            <option value="SORT_DESC" <?php $ratingOrder =="SORT_DESC" ? "selected" : ""?>>Highest First</option>
            <option value="SORT_ASC">Lowest First</option>
            </select>

            <!-- minimum rating -->

            <label for="minimum" class="form-label">Minimum Rating</label>
            <select name="minimum" id="minimum" class="form-control">
                <option value="1" >1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <!-- order by date -->

            <label for="date" class="form-label">Order by Date</label>
            <select name="date" id="date" class="form-control">
                <option value="SORT_DESC">Newest first</option>
                <option value="SORT_ASC">Oldest first</option>
            </select>

            <!-- pioritize by text -->

            <label for="text" class="form-label">Prioritize by Text</label>
            <select name="text" id="text" class="form-control">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>

            <button type="submit" class="btn btn-primary btn-sm w-100 my-3">Submit</button>
        </form>



    </div>

    <div class="container">


    <table class="table">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">RATING</th>
            <th scope="col">TEXT REVIEW</th>
            <th scope="col">DATE</th>
            </tr>
        </thead>
        <tbody>
         

            <?php
                foreach($sorted as $finalItem){

                    echo("<tr>");
                    echo('<th scope="row">'.$finalItem['id']."</th>");
                    echo('<td>'.$finalItem['rating']."</td>");
                    echo('<td>'.$finalItem['reviewText']."</td>");
                    echo('<td>'.$finalItem['reviewCreatedOnDate']."</td>");
                    echo("</tr>");
                };
            ?>
           
        </tbody>
</table>
    
    </div>
    
</body>
</html>