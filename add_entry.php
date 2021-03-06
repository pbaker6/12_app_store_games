<?php include("topbit.php");

// Get Genre list from database
$genre_sql="SELECT * FROM `tblgenre` ORDER BY `tblgenre`.`genreName` ASC";
$genre_query = mysqli_query($dbconnect, $genre_sql);
$genre_rs = mysqli_fetch_assoc($genre_query);

// Initialise form variables

$app_name = "";
$subtitle = "";
$url = "";
$genreID = "";
$dev_name = "";
$age = "";
$rating = "";
$rate_count = "";
$cost = "";
$in_app = 1;
$description = "Please enter a description";

$has_errors = "no";

// set up error field colours / visibility (no errors first)
$app_error = $url_error = $dev_error = $description_error = $genre_error = $age_error = $rating_error = $count_error = "no-error";

$app_field = $url_field = $dev_field = $description_field = $genre_field = $age_field = $rating_field = $count_field = "form-ok";

$age_message = $cost_message = "";

//Code below executes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Get values from form...
    $app_name = mysqli_real_escape_string($dbconnect, $_POST['app_name']);
    $subtitle = mysqli_real_escape_string($dbconnect, $_POST['subtitle']);
    $url = mysqli_real_escape_string($dbconnect, $_POST['url']);
    
    $genreID = mysqli_real_escape_string($dbconnect, $_POST['genre']);
    
    // If genreID, is not blank, get genre so that genre box does not lose its value if there are errors
    if ($genreID != "") {
        $genreitem_sql = "SELECT * FROM `tblgenre` WHERE `genreID` = $genreID"; 
        $genreitem_query = mysqli_query($dbconnect, $genreitem_sql);
        $genreitem_rs = mysqli_fetch_assoc($genreitem_query);
        
        $genre =  $genreitem_rs['genreName'];
            
    } // End genreID if
    
    
    $dev_name = mysqli_real_escape_string($dbconnect, $_POST['dev_name']);
    $age = mysqli_real_escape_string($dbconnect, $_POST['age']);
    $rating = mysqli_real_escape_string($dbconnect, $_POST['rating']);
    $rate_count = mysqli_real_escape_string($dbconnect, $_POST['count']);
    $cost = mysqli_real_escape_string($dbconnect, $_POST['price']);
    $in_app = mysqli_real_escape_string($dbconnect, $_POST['in_app']);
    $description = mysqli_real_escape_string($dbconnect, $_POST['description']);
    
    // error checking will go here...
    
    // Check App Name is not blank
    if ($app_name == ""){
        $has_errors = "yes";
        $app_error = "error-text";
        $app_field = "form-error";
    }

    
    // Check URL is valid...
    // Remove all illiegal characters from a URL
    $url = filter_var($url, FILTER_SANITIZE_URL);
    
    if (filter_var($url, FILTER_VALIDATE_URL) == false) {
        $has_errors = "yes";
        $url_error = "error-text";
        $url_field = "form-error";
    }
    
    // Check Genre is not blank
    if ($genreID == ""){
        $has_errors = "yes";
        $genre_error = "error-text";
        $genre_field = "form-error";
    }
    
    // Check Developer is not blank
    if ($dev_name == ""){
        $has_errors = "yes";
        $dev_error = "error-text";
        $dev_field = "form-error";
    }
    
    // check Age and if left blank set it to 0
    if ($age == "" || $age == "0"){
        $age = 0;
        $age_message = "The age has been set to 0 (ie: All ages)";
        $age_error = "defaulted";
    }
    
    // check that Age is an integer > 0
    else if (!ctype_digit($age) || $age < 0){
        $age_message = "Age must be an integer that is > = 0";
        $has_errors = "yes";
        $age_error = "error-text";
        $age_field = "form-error";
    }
     
    // Check that rating is a decimal between 0 and 5
    if (!is_numeric($rating) || $rating <0 || $rating > 5){
        $has_errors = "yes";
        $rating_error = "error-text";
        $rating_field = "form-error";
    }
    
    // Check number of ratings is an integer > 0
    if (!ctype_digit($rate_count) || $rate_count < 1){
        $has_errors = "yes";
        $count_error = "error-text";
        $count_field = "form-error";
    }
      // Check that cost is not blank - if so, set it to 0
    if ($cost == ""|| $cost == "0"){
        $cost = 0;
        $cost_message = "The price has been set to 0 (ie: Free)";
        $cost_error = "defaulted";
    }
    
    // Check that cost is a decimal > 0
    else if (!is_numeric($cost) || $cost < 0){
        $cost_message = "The cost should be a number > or = 0 (Do not include the $ symbol)";
        $has_errors = "yes"; // not sure that this line does anything
        $cost_error = "error-text";
        $cost_field = "form-error";
    }
    
     // Check Description is not blank / 'Description required'
    if ($description  == "" || $description == "Please enter a description"){
        $has_errors = "yes";
        $description_error = "error-text";
        $description_field = "form-error";
        $description = "";
    }
    
    // if there are no errors...
    if ($has_errors == "no"){
        
        // Go to success page... 
        header('Location: add_success.php');
        
        // Get developer ID if it exists...
        $dev_sql = "SELECT * FROM `tbldeveloper` WHERE `developerName` LIKE '$dev_name'";
        $dev_query = mysqli_query($dbconnect, $dev_sql);
        $dev_rs = mysqli_fetch_assoc($dev_query);
        $dev_count = mysqli_num_rows($dev_query);

        // If developer not already in developer table, add them and get the 'new' developerID
        if ($dev_count > 0) {
            $developerID = $dev_rs['developerID'];
        }
        
        else {
            $add_dev_sql = "INSERT INTO `tbldeveloper` (`developerID`, `developerName`) VALUES (NULL, '$dev_name');";
            $add_dev_query = mysqli_query($dbconnect, $add_dev_sql);
            
            // Get developer ID
            $newdev_sql = "SELECT * FROM `tbldeveloper` WHERE `developerName` LIKE '$dev_name'";
            $newdev_query = mysqli_query($dbconnect, $newdev_sql);
            $newdev_rs = mysqli_fetch_assoc($newdev_query);
            
            $developerID = $newdev_rs['developerID'];
            
        }  // end adding developer to developer table
        
        // Get ageRatingID if it exists...
        $age_sql = "SELECT * FROM `tblagerating` WHERE `ageRating` LIKE '$age'";
        $age_query = mysqli_query($dbconnect, $age_sql);
        $age_rs = mysqli_fetch_assoc($age_query);
        $age_count = mysqli_num_rows($age_query);

        // If age rating not already in age rating table, add it and get the 'new' ageRatingID
        if ($age_count > 0) {
            $ageRatingID = $age_rs['ageRatingID'];
        }
        
        else {
            $add_age_sql = "INSERT INTO `tblagerating` (`ageRatingID`, `ageRating`) VALUES (NULL, '$age');";
            $add_age_query = mysqli_query($dbconnect, $add_age_sql);
            
            // Get age ID
            $newage_sql = "SELECT * FROM `tblagerating` WHERE `ageRating` LIKE '$age'";
            $newage_query = mysqli_query($dbconnect, $newage_sql);
            $newage_rs = mysqli_fetch_assoc($newage_query);
            
            $ageRatingID = $newage_rs['ageRatingID'];
            
        }  // end adding age to tblagerating

        // Add entry to database
        $addentry_sql = "INSERT INTO `tblgames` (`gameID`, `gameName`, `gameSubTitle`, `gameURL`, `genreID`, `developerID`, `ageRatingID`, `gameUserRating`, `gameUserCount`, `gamePrice`, `gameInAppPurchase`, `gameDescription`) VALUES (NULL, '$app_name', '$subtitle', '$url', $genreID, $developerID, $ageRatingID, $rating, $rate_count, $cost, $in_app, '$description');";
        
        $addentry_query = mysqli_query($dbconnect, $addentry_sql);
        
        // Get ID for next page
        $getid_sql = "SELECT * FROM `tblgames` WHERE 
        `gameName` LIKE '$app_name' 
        AND `gameSubTitle` LIKE '$subtitle' 
        AND `gameURL` LIKE '$url'
        AND `genreID` LIKE $genreID
        AND `developerID` LIKE $developerID
        AND `ageRatingID` = $ageRatingID
        AND `gameUserRating` = $rating
        AND `gameUserCount` = $rate_count
        AND `gamePrice` = $cost
        AND `gameInAppPurchase` = $in_app
        ";
        $getid_query = mysqli_query($dbconnect, $getid_sql);
        $getid_rs = mysqli_fetch_assoc($getid_query);
        
        $ID = $getid_rs['gameID'];
        $_SESSION['gameID']=$ID;
        
        
        
        
        }  // End of 'no errors' if
            

    }   // end of Button Submitted code

    ?>

        <div class="box main">
            <div class="add-entry">
                <h2>Add An Entry</h2>
                
                <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    
                    <!-- App Name (Required) -->
                    <div class = "<?php echo $app_error; ?>">
                        Please fill in the 'App Name' field
                    </div>
                    
                    <input class="add-field <?php echo $app_field; ?>" type="text" name="app_name" value="<?php echo $app_name; ?>" placeholder="App Name (required) ..." />
                    
                    <!-- Subtitle (Optional) -->
                    <input class="add-field" type="text" name="subtitle" size="40" value="<?php echo $subtitle; ?>" placeholder="Subtitle (optional) ..." />  

                    <!-- URL (Required, must start with http://) -->
                    <div class = "<?php echo $url_error; ?>">
                        Please provide a valid URL (include the http://)
                    </div>
                    
                    <input class="add-field <?php echo $url_field; ?>" type="text" name="url" size="40" value="<?php echo $url; ?>" placeholder="URL (required) ..." /> 
                    
                    <!-- Genre dropdown (required) -->
                    <div class = "<?php echo $genre_error; ?>">
                        Please choose a genre                    
                    </div>
             
                    <select class="adv <?php echo $genre_field; ?>"name="genre">
                        <!-- first / selected option -->
                        <?php
                        if($genreID==""){
                            ?>
                        <option value="" selected>Genre (Choose something)...
                        </option>
                        <?php
                        }
                        
                        else {
                            ?>
                        <option value="<?php echo $genreID; ?>" selected><?php echo $genre; ?></option>
                        <?php
                        }
                        ?>
                                                    
                        <!-- get options from database -->
                    <?php 
                        $genre_sql="SELECT * FROM `tblgenre` ORDER BY `tblgenre`.`genreID` ASC";
                        $genre_query=mysqli_query($dbconnect, $genre_sql);
                        $genre_rs=mysqli_fetch_assoc($genre_query);
                    
                        do {
                            ?>
                        <option value="<?php echo $genre_rs['genreID']; ?>"><?php echo $genre_rs['genreName']; ?></option>
                    
                        <?php
                        } // end genre do loop
                        
                        while($genre_rs=mysqli_fetch_assoc($genre_query))
                    
                    ?>
                   
                   
                    </select>

                    <!-- Developer Name (required) -->
                    <div class = "<?php echo $dev_error; ?>">
                        Developer name can't be blank
                    </div>
             
                    
                    <input class="add-field <?php echo $dev_field; ?>" type="text" name="dev_name" size="40" value="<?php echo $dev_name; ?>" placeholder="Developer Name (required) ..." />                 
                                        
                    <!-- Age (Set to 0 if left blank) -->
                    <div class = "<?php echo $age_error; ?>">
                        <?php echo $age_message; ?>
                    </div>
                    <input class="add-field <?php echo $age_field; ?>" type="text" name="age" size="40" value="<?php echo $age; ?>" placeholder="Age (0 for all)" />                 

                    
                    <!-- Rating (Number between 0-5, 1dp) -->
                    <div class = "<?php echo $rating_error; ?>">
                        Rating must be a number between 0 and 5
                    </div>
                    
                    <input class="add-field <?php echo $rating_field; ?>" type="text" name="rating" value="<?php echo $rating; ?>" step="0.1" min=0 max=5 placeholder="Rating (0-5)" />
                    
                    <!-- # of ratings (Integer > 0) -->
                    <div class = "<?php echo $count_error; ?>">
                        Rating count must be an integer that is > 0
                    </div>
                        
                     <input class="add-field <?php echo $count_field; ?>" type="text" name="count" value="<?php echo $rate_count; ?>" placeholder="Number of Ratings (number > 0)" />   
                    
                    <!-- Cost (Decimal 2dp, must bemore than 0) -->
                    <div class = "<?php echo $cost_error; ?>">
                        <?php echo $cost_message; ?>
                    </div>
                    
                    <input class="add-field <?php echo $cost_field; ?>" type="text" name="price" value="<?php echo $cost; ?>" placeholder="Cost (number only)" />  
                    
                    <!-- In App Purchase (Radio buttons) -->
                    <div>
                        <br />
                        <b>In App Purchase:</b>
                        <!-- defaults to 'yes' -->
                        <!-- NOTE: value in database is boolean, so 'no' becomes 0 and 'yes' 1 -->
                        
                        <?php
                        if($in_app==1) {
                        // Default value, 'Yes' is selected
                            ?>
                        <input type="radio" name="in_app" value = "1" checked="checked" />Yes
                        <input type="radio" name="in_app" value = "0" />No
                        <?php
                        }// end 'yes in_app' if
                        
                        else{
                            ?>
                        <input type="radio" name="in_app" value = "1" />Yes
                        <input type="radio" name="in_app" value = "0" checked="checked"/>No
                        <?php                        
                        } // end 'yes in_app' else
                            ?>
                            
                    </div>
                    <br />
                    <!-- Description (text area) -->
                    <div class = "<?php echo $description_error; ?>">
                        Please provide a valid description
                    </div>
             
                    <textarea class="add-field <?php echo $description_field?>" name="description"
                              rows="6"><?php echo $description; ?></textarea>
                    
                    <!-- Submit button -->
                    <p>
                        <input class="submit advanced-button" type="submit" value="Submit" />
                    </p>
                </form>
            
            </div> <!-- / add-entry -->
            
        
            

            
        </div> <!-- / main -->
        
 <?php include("bottombit.php") ?>