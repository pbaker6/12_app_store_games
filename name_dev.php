<?php include("topbit.php");

$dev_name = $_POST['dev_name'];


$find_sql="SELECT * FROM `tblgames`
JOIN tblgenre ON (tblgames.genreID = tblGenre.genreID)
JOIN tbldeveloper ON (tblgames.developerID = tbldeveloper.developerID)
JOIN tblagerating ON (tblgames.ageratingID = tblagerating.ageratingID)
WHERE `gameName` LIKE '%$dev_name%' OR `developerName`LIKE '%$dev_name%'
";
$find_query=mysqli_query($dbconnect, $find_sql);
$find_rs=mysqli_fetch_assoc($find_query);
$count=mysqli_num_rows($find_query);
?>   
            
        <div class="box main">
            <h2>Name / Developer Results</h2>
            
            <?php 
            include ("results.php")
            ?>

        </div> <!-- / main -->
 
 <?php include("bottombit.php")?>