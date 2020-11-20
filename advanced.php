<?php include("topbit.php");

$app_name = mysqli_real_escape_string($dbconnect, $_POST['app_name']);
$dev_name = mysqli_real_escape_string($dbconnect, $_POST['dev_name']);
$genre = mysqli_real_escape_string($dbconnect, $_POST['genre']);
$cost = mysqli_real_escape_string($dbconnect, $_POST['cost']);

if (isset($_POST['in_app'])) {
    $in_app = 0;
}

else {
    $in_app = 1;
}

$find_sql = "SELECT * FROM `tblgames`
JOIN tblgenre ON (tblgames.genreID = tblgenre.genreID)
JOIN tbldeveloper ON (tblgames.developerID = tbldeveloper.developerID)
JOIN tblagerating ON (tblgames.ageRatingID = tblagerating.ageRatingID)
WHERE `gameName` LIKE '%$app_name%'
AND `developerName` LIKE `%$dev_name%`
AND `genreName` LIKE `%$genre%`
AND `gamePrice` <= `$cost`
AND (`gameInAppPurchase` = $in_app OR `gameInAppPurchase` = 0)
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