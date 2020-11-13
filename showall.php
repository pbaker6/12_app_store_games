<?php include("topbit.php");

$find_sql="SELECT * FROM `tblgames`
JOIN tblgenre ON (tblgames.genreID = tblGenre.genreID)
JOIN tbldeveloper ON (tblgames.developerID = tbldeveloper.developerID)

";
$find_query=mysqli_query($dbconnect, $find_sql);
$find_rs=mysqli_fetch_assoc($find_query);
$count=mysqli_num_rows($find_query);
?>   
            
        <div class="box main">
            <h2>All Results</h2>
            
            <?php
            if($count < 1){
            ?>
            
            <div class="error">
                
                Sorry! There are no results that match your search.<br />
                Please use the search box in the side bar to try again.
                
            </div> <!-- end error -->
            
            <?php
                } // end no results if
            
            else {
                do
                {
                    
            ?>
            
            <!-- Results go here -->
            <div class="results">
                <span class="sub_heading">
                    <a href="<?php echo $find_rs['gameURL']; ?>">
                        <?php echo $find_rs['gameName']; ?>
                        <br />
                    </a>
                </span> - <?php echo $find_rs['gameSubTitle']; ?>
                
                <p>
                    <b>Genre: </b>
                    <?php echo $find_rs['genreName'] ?>
                    <br />
                    <b>Developer: </b>
                    <?php echo $find_rs['developerName'] ?>     
                    <br />
                    <b>Rating: </b>
                    <?php echo $find_rs['gameUserRating'] ?>  
                    (based on <?php echo $find_rs['gameUserCount'] ?> votes)
                    <br />
                    <b>Cost: $</b>
                
                    <?php echo $find_rs['gamePrice'] ?>   
                    <br />
                    <b>In-app purchases: </b>
                    <?php echo $find_rs['gameInAppPurchase'] 
                    ?>  
                </p>
                    <hr />
                    <?php echo $find_rs['gameDescription']?>                             
            </div> <!-- / results -->
            
            <br />
            

            <?php
            
                } //end results 'do'
                while
                        ($find_rs=mysqli_fetch_assoc($find_query));

    
            } //end else
            ?>
            
        </div> <!-- / main -->
 
 <?php include("bottombit.php");