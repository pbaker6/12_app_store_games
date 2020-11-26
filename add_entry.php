<?php include("topbit.php");

// Initialise form variables

$app_name = "";
$subtite = "";
$url = "";
$dev_name = "";
$age = "";
$rating = "";
$rate_count = "";
$cost = "";
$description = "";

$has_errors = "no";
?>
                       
            
        <div class="box main">
            <div class="add-entry">
                <h2>Add An Entry</h2>
                
                <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                </form>
            
            </div> <!-- / add-entry -->
            
        
            

            
        </div> <!-- / main -->
        
 <?php include("bottombit.php") ?>