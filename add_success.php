<?php include("topbit.php"); 

    // retrieves information...
    $ID = $_SESSION['gameID'];

     // Get ID 
    $find_sql = "SELECT * FROM `tblgames`
    JOIN tblgenre ON (tblgames.genreID = tblgenre.genreID)
    JOIN tbldeveloper ON (tblgames.developerID = tbldeveloper.developerID)
    JOIN tblagerating ON (tblgames.ageRatingID = tblagerating.ageRatingID)

    WHERE `gameID` = '$ID'
    ";

    $find_query = mysqli_query($dbconnect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);
    $count = mysqli_num_rows($find_query);
?>

        <div class="box main">
            <h2>Congratulations</h2>
            <p>You have added a game to the database.</p>

            <?php
            include ("results.php");
            ?>


        </div> <!-- / main -->
        
 <?php include("bottombit.php") ?>