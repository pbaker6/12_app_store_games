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
$description = "";

$has_errors = "no";



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
    
    // if there are no errors...
    if ($has_errors == "no"){
        
        // Go to success page...   
        
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

        // Add entry to database
        
        }  // End of 'no errors' if
            
        echo "You pushed the button";
    }   // end of Button Submitted code

    ?>

        <div class="box main">
            <div class="add-entry">
                <h2>Add An Entry</h2>
                
                <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    
                    <!-- App Name (Required) -->
                    <input class="add-field" type="text" name="app_name" value="<?php echo $app_name; ?>" placeholder="App Name (required) ..." />
                    
                    <!-- Subtitle (Optional) -->
                    <input class="add-field" type="text" name="subtitle" size="40" value="<?php echo $subtitle; ?>" placeholder="Subtitle (optional) ..." />  

                    <!-- URL (Required, must start with http://) -->
                    <input class="add-field <?php echo $url_field; ?>" type="text" name="url" size="40" value="<?php echo $url; ?>" placeholder="App Name (required) ..." /> 
                    
                    <!-- Genre dropdown (required) -->
                    <select class="adv" name="genre">
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
                    <input class="add-field <?php echo $dev_field; ?>" type="text" name="dev_name" size="40" value="<?php echo $dev_name; ?>" placeholder="Developer Name (required) ..." />                 
                                        
                    <!-- Age (Set to 0 if left blank) -->
                    <input class="add-field" type="text" name="age" size="40" value="<?php echo $age; ?>" placeholder="Age (0 for all)" />                 

                    
                    <!-- Rating (Number between 0-5, 1dp) -->
                    <div>
                        <input class="add-field" type="text" name="rating" value="<?php echo $rating; ?>" step="0.1" min=0 max=5 placeholder="Rating (0-5)" />
                    </div>
                    
                    <!-- # of ratings (Integer > 0) -->
                     <input class="add-field" type="text" name="count" value="<?php echo $rate_count; ?>" placeholder="# of Ratings" />   
                    
                    <!-- Cost (Decimal 2dp, must bemore than 0) -->
                    <input class="add-field" type="text" name="price" value="<?php echo $cost; ?>" placeholder="Cost (number only)" />  
                    
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
                    <textarea class="add-field <?php echo $description_field?>" name="description"
                              placeholder="Description..." rows="6"><?php echo $description; ?></textarea>
                    
                    <!-- Submit button -->
                    <p>
                        <input class="submit advanced-button" type="submit" value="Submit" />
                    </p>
                </form>
            
            </div> <!-- / add-entry -->
            
        
            

            
        </div> <!-- / main -->
        
 <?php include("bottombit.php") ?>