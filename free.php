<?php include("topbit.php");


$find_sql="SELECT * FROM `tblgames`
JOIN tblgenre ON (tblgames.genreID = tblGenre.genreID)
JOIN tbldeveloper ON (tblgames.developerID = tbldeveloper.developerID)
JOIN tblagerating ON (tblgames.ageratingID = tblagerating.ageratingID)
WHERE `gamePrice` = 0 AND `gameInAppPurchase` = 0
";
$find_query=mysqli_query($dbconnect, $find_sql);
$find_rs=mysqli_fetch_assoc($find_query);
$count=mysqli_num_rows($find_query);
?>   
            
        <div class="box main">
            <h2>Free with no In-App Purchase Results</h2>
            
            <?php 
            include ("results.php")
            ?>

        </div> <!-- / main -->
 
 <?php include("bottombit.php")?>