<?php include("topbit.php");

$app_name = mysqli_real_escape_string($dbconnect, $_POST['app_name']);
$dev_name = mysqli_real_escape_string($dbconnect, $_POST['dev_name']);
$genre = mysqli_real_escape_string($dbconnect, $_POST['genre']);
$cost = mysqli_real_escape_string($dbconnect, $_POST['cost']);

// Cost code (to handle when cost is not specified)
if($cost ==""){
    $cost_op = ">=";
    $cost = 0;
}
else{
    $cost_op = "<=";
} // Cost if / else


// In App Purchases
if (isset($_POST['in_app'])) {
    $in_app = 0;
}

else {
    $in_app = 1;
}

// Ratings
$rate_more_less = mysqli_real_escape_string($dbconnect, $_POST['rate_more_less']);
$rating = mysqli_real_escape_string($dbconnect, $_POST['rating']);

if($rating == ""){
    $rating = 0;
    $rating_more_less = "at least";
    $rate_op = ">=";
} // Set rating to 0 if it is blank

if($rate_more_less == "at most"){
    $rate_op = "<=";
}
else{
    $rate_op = ">=";
    $rating = 0;
} // end Rating if / elseif / else

// Age Rating
$age_more_less = mysqli_real_escape_string($dbconnect, $_POST['age_more_less']);
$age = mysqli_real_escape_string($dbconnect, $_POST['age']);

if($age == ""){
    $age = 0;
    $age_more_less = "at least";
} //Set age to 0 if it is blank

if($age_more_less == "at most"){
    $age_op = "<=";
}
else{
    $age_op = ">=";
} // end Age rating if / elseif / else

$find_sql = "SELECT * FROM `tblgames`
JOIN tblgenre ON (tblgames.genreID = tblgenre.genreID)
JOIN tbldeveloper ON (tblgames.developerID = tbldeveloper.developerID)
JOIN tblagerating ON (tblgames.ageRatingID = tblagerating.ageRatingID)
WHERE `gameName` LIKE '%$app_name%'
AND `developerName` LIKE '%$dev_name%'
AND `genreName` LIKE '%$genre%'
AND `gamePrice`$cost_op $cost
AND (`gameInAppPurchase` = $in_app OR `gameInAppPurchase` = 0)
AND `gameUserRating` $rate_op $rating
AND `ageRating` $age_op $age

";


$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);
$count = mysqli_num_rows($find_query);

?>   
            
        <div class="box main">
            <h2>Advanced Search Results</h2>
            
            <?php 
            include ("results.php")
            ?>

        </div> <!-- / main -->
 
 <?php include("bottombit.php")?>