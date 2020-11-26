       <div class="box side">
           
           <div class="heading"> </div> <!-- / end of heading -->
           
            <h2><a href="add_entry.php">Add an App</a> | <a class="side" href="showall.php">Show All</a></h2>
               
        <!-- Name/Developer search bar -->
          <form class="searchform" method="post" action="name_dev.php" enctype="multipart/form-data">
              
              <input class="search" type="text" name="dev_name" size="40" value="" required placeholder="App Name / Developer Name..."/>
              
              <input class="submit" type="submit" name="find_game_name" value="&#xf002;" />
        
           </form>
           
           <!-- Free and No In-App Purchase button -->
           <form class="searchform" method="post" action="free.php" enctype="multipart/form-data">
                 
               <input class="submit free" type="submit" name="free" value="Free with no In-App Purchase &nbsp &nbsp &nbsp &nbsp  &#xf002;" />
                 
        </form>
           
           <br />
           <hr />
           <br />
           
           <div class="advanced-frame">
               <h2>Advanced Search</h2>
               
               <form class="searchform" method="post" action="advanced.php" enctype="multipart/form-data">
                   
                <input class="adv" type="text" name="app_name" size="40" value="" placeholder="App Name / Title..."/>
                   
                <input class="adv" type="text" name="dev_name" size="40" value="" placeholder="Developer Name..."/>

                   
                
                <!-- Genre Dropdown -->
                   
                <select class="search adv" name="genre">
                    
                <option value="" selected>Genre....</option>
                    
                   <!-- get options from database -->
                    <?php 
                        $genre_sql="SELECT * FROM `tblgenre` ORDER BY `tblgenre`.`genreName` ASC";
                        $genre_query=mysqli_query($dbconnect, $genre_sql);
                        $genre_rs=mysqli_fetch_assoc($genre_query);
                    
                        do {
                            ?>
                        <option value="<?php echo $genre_rs['genreName']; ?>"><?php echo $genre_rs['genreName']; ?></option>
                    
                        <?php
                            
                            
                        } // end genre do loop
                        
                        while($genre_rs=mysqli_fetch_assoc($genre_query))
                    
                    ?>
                   
                   
                </select>
                   <!-- Cost -->
                   <div class="flex-container">
    
                           <div class="adv-txt">
                               Cost&nbsp;(less&nbsp;than):
                           </div> <!-- / cost label -->
                       
                           <div>  <!-- Cost input box-->
                               <input class="half-adv" type="text" name="cost" size="40" value="" placeholder="$..."/>
                           
                           </div> <!-- / Cost input box-->
                
                   </div> <!-- / Cost flex-box -->
                   
                   <!-- No In App Checkbox -->
                        <input class="adv-txt" type="checkbox" name="in_app" value="0">No In App Purchase
                   
                   <!-- Rating -->
                   <div class="flex-container">
                       <div class="adv-txt">
                           Rating:                      
                       </div> <!-- / rating label -->
                       
                       <div>
                           <select class="small-drop-down" name="rate_more_less">
                               <option value="" >Choose...</option>
                               <option value="at least">At Least</option>
                               <option value="at most">At Most</option>
                           </select>
                       </div> <!-- / rating drop down -->
                       
                       <div>
                           <input class="small-qty" type="text" name="rating" size="4" value="" placeholder=""/>
                       
                       </div> <!-- / rating amount -->
                   
    
                   </div>
                   <!-- Age -->
                    <div class="flex-container">
                       <div class="adv-txt">
                           Age:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                     
                       </div> <!-- / age label -->
                       
                       <div>
                           <select class="small-drop-down" name="age_more_less">
                               <option value="" >Choose...</option>
                               <option value="at least">At Least</option>
                               <option value="at most">At Most</option>
                           </select>
                       </div> <!-- / age drop down -->
                       
                       <div>
                           <input class="small-qty" type="text" name="age" size="4" value="" placeholder=""/>
                       
                       </div> <!-- / age amount -->
                   
    
                   </div>
                   
                   
                
                   <!-- Search Button is below -->                    
                <input class="submit advanced-button" type="submit" name="advanced" value="Search &nbsp;  &#xf002;" /> 
                   
                   
               </form>
               
               
           </div> <!-- / advanced frame -->
           
    

            
        </div> <!-- / side bar -->
        
        <div class="box footer">
            CC Patrick Baker 2021
        </div> <!-- / footer -->
                
        
    </div> <!-- / wrapper -->
    
            
</body>