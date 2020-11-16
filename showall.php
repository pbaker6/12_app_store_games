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
                
                <!-- Heading and subtitle -->
                
                <div class="flex-container">
                    <div>
                        <span class="sub_heading">
                            <a href="<?php echo $find_rs['gameURL']; ?>">
                                <?php echo $find_rs['gameName']; ?>
                            </a>
                        </span>
                    </div> <!-- / Title -->
                    
                    <?php
                        if($find_rs['gameSubTitle'] != "")
                        
                        { 
                    ?>
                    <div>
                        
                        &nbsp; &nbsp; | &nbsp; &nbsp;

                        <?php echo $find_rs['gameSubTitle'] ?>
                    </div> <!-- / subtitle -->
                    
                    <?php
                
                        }
                    ?>
                
                </div>  <!-- / flex-container -->
                
                <!-- / Heading and subtitle -->
                
                <!-- Ratings Area -->
                <div class="flex-container">
                    <!-- Partial Stars Original Source: https://codepen.io/Bluetidepro/pen/GkpEa -->
                    <div class="star-ratings-sprite">
                    
                    
                    </div> <!-- / Star rating div -->
                    
                    <div class="actual-rating"> 
                        (<?php echo $find_rs['gameUserRating'] ?> rating based on # ratings)
                    
                    
                    </div> <!-- / text rating div -->
                
                
                </div> <!-- / Ratings flexbox -->
                
                <!-- / Ratings Area -->
               
                <!-- Price -->
                
                <?php 
                    
                    if($find_rs['gamePrice'] == 0) {
                        ?>
                
                    <p>
                        Free!
                        <?php
                            if($find_rs['gameInAppPurchase'] == 1)
                            {
                                ?>
                                    (In App Purchase)
                                <?php
                            } //end In App if
                        ?>
                        
                    </p>
                
                    <?php
                    } // end price if
                    
                    else {
                                                
                        ?>
                <br/>
                    <b>Price: $</b>
                    <?php echo $find_rs['gamePrice'] ?>   
                    <br />
                
                <?php
                
                } // end price else (displays price)
                ?>
                
                <!-- / Price -->
      
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