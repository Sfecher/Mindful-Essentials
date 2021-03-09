<!-- This page gets ifnoramtion from the user via the form/filter and then dispalys it -->
<?php
    session_start();
    include 'database.inc.php';

    //opening the connect and checking if it worked or not
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="brain.jpg" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <!-- including the header and nav -->
        <?php include ("header.php")?>
        <?php include ("nav.php")?>

        <form action="products.php" method="get">

            <?php
            //this is selecting all of the tag_names that are unique (distinct) from the product_purpose table and getting the result 
            $sqlConcern = "select distinct tag_name as tag_name from Product_purpose";
            $stmtConcern = $mysqli->prepare($sqlConcern);
            $stmtConcern->execute();
            $resultConcern = $stmtConcern->get_result();

            //this is putting the result into a drop down 
            if($resultConcern->num_rows >= 1){
                ?>
                <select name="concerns">
                    <option>Select a Concern</option>

                <?php
                while($concern= mysqli_fetch_assoc($resultConcern)){
                    echo '<option vlaue='.$concern["tag_name"].'>'.$concern["tag_name"].'</option>';
                }
                ?>
                </select>

                <?php
            }

            //this is selecting all of the types that are unique (distinct) from the product table and getting the result
            $sqlType = "select distinct type from Products ";
            $stmtType = $mysqli->prepare($sqlType);
            $stmtType->execute();
            $resultType = $stmtType->get_result();

            //this is taking the result and putting it into a drop down 
            if($resultType->num_rows >= 1){
                ?>
                <select name="type">
                <option>Select a Type</option>

                <?php
                while($type= mysqli_fetch_assoc($resultType)){
                    echo '<option vlaue='.$type["type"].'>'.$type["type"].'</option>';
                }
                ?>
                </select>

                <?php
            }

            //this is selecting all of the brands that are unique (distinct) from the products table and getting the result 
            $sqlBrand = "select distinct brand from Products ";
            $stmtBrand = $mysqli->prepare($sqlBrand);
            $stmtBrand->execute();
            $resultBrand = $stmtBrand->get_result();

            //this is taking the result and putting it into a drop down 
            if($resultBrand->num_rows >= 1){
                ?>
                <select name="brand">
                <option>Select a Brand</option>

                <?php
                while($type= mysqli_fetch_assoc($resultBrand)){
                    echo '<option vlaue='.$type["brand"].'>'.$type["brand"].'</option>';
                }
                ?>
                </select>

            <?php
            }

            ?>

            </br>
            <input class="skinT" type="submit" name="submitButton" id="button" value="CHOOSE">
            </br>

            <?php
            $informtion = array();

            //if the submit button has been clicked
            if(isset($_GET['submitButton'])) {
                
                //if the concerns are set then we are going to put it into the session. We then put what the user selected into the information array
                if(isset($_GET['concerns'])){
                    $_SESSION['concerns'] = $_GET['concerns'];
                    $concerns = $_GET['concerns'];
                    $count = count($information);
                    $information[$count] = $concerns;
                    ?>
                    <script>
                    //this area would be where i would figure out how to populate the drop downs with what the user choose
                    //$("#concerns option:contains('Aging')").attr("selected", "selected");
                    //alert($("#brand").val());

                    // alert($("#concerns option").filter(function() {
                    //     return $.trim($(this).text())=='Aging';
                    // }).val());
                    
                    
                    //.attr("selected", "selected");
                    </script>
                    <?php
                }

                //if the type is set then we are going to put it into the session. We then put what the user selected into the information array
                if(isset($_GET['type'])){
                    $_SESSION['type'] = $_GET['type'];
                    $type = $_GET['type'];
                    $count = count($information);
                    $information[$count] = $type;
                }

                //if the brand is set then we are going to put it into the session. It then puts what the user selected into the inforamtion array
                if(isset($_GET['brand'])){
                    $_SESSION['brand'] = $_GET['brand'];
                    $brand = $_GET['brand'];
                    $count = count($information);
                    $information[$count] = $brand;
                }

                //the sql is selecting all from products 
                $sql = "select * from products where 1=1";

                //if the concern is equal to an actual selected concern then we are going to add it to the sql. it is going to get the 
                //product id from the product_purpose table where it equals what the concern is
                if($concerns != "Select a Concern"){
                    $sql = $sql. " and id in (
                        select product_id from Product_purpose where tag_name = '".$concerns."')";
                }

                //if the type is equal to an actual selected type then we are going to add it to the sql. it is going to get the 
                //product id from the product_purpose table where it equals what the type is
                if($type != "Select a Type"){
                    $sql = $sql." and type = '".$type."' ";
                }

                //if the brand is equal to an actual selected brand then we are going to add it to the sql. it is going to get the 
                //product id from the product_purpose table where it equals what the brand is
                if($brand != "Select a Brand"){
                    $sql = $sql. " and brand = '".$brand."' ";
                }

                //echo $sql;
                //this is preparing the sql and getting the results
                $stmt = $mysqli->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                //
                if($result->num_rows >= 1){
                    print "<h2 style='color:#8da4a4; font-family:Avenir; text-align: center;'>Here is what might suit your needs:</h2>";
                    while($row= mysqli_fetch_assoc($result)){
                        echo '<div class="catWrapper">';
                        echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                        echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                        echo '</div>';
                        echo '<br>';
                    }
                }else{
                    print "<h3 style='color:#8da4a4; font-family:Avenir; text-align: center;'>Sorry, we were unable to find an exact result.</h3>";
                    print "<h3 style='color:#8da4a4; font-family:Avenir; text-align: center;'>Here are some choices based off your individual choices</h3>";
                ?>
                    </br>
                    <div id="productDiv">
                        <nav id="productNav">
                            <a href="#Concern" class="productNavLink">Concern</a> 
                            <a href="#Type" class="productNavLink">Type</a> 
                            <a href="#Brand" class="productNavLink">Brand</a> 
                        </nav>
                    </div>

                    <?php
                    //this is selecting everything from products where the concerns are what the user choose and its getting the result
                    $sql = "select * from Products where id in (select product_id from Product_purpose where tag_name = '".$concerns."')"; 
                    $stmt = $mysqli->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    //this is taking the result and dispalying it to the user
                    if($result->num_rows >= 1){
                        print "<h2 id = 'Concern'class='catNames'>Concern:</h3>";

                        //this is looping through the result and displaying all of the results from the database with all of its information
                        while($row= mysqli_fetch_assoc($result)){
                            echo '<div class="catWrapper">';
                            echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                            echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                            echo '</div>';
                            echo '<br>';
                        }
                    }

                    //this is selecting everything from products where the type is what the user choose and its getting the result 
                    $sql = "select * from Products where type = '".$type."'"; 
                    $stmt = $mysqli->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    //this is taking the result and displaying it to the user
                    if($result->num_rows >= 1){
                        print "<h2 id = 'Type'class='catNames'>Type:</h3>";

                        //this is looping through the result and displaying all of the results from the database with all of its information
                        while($row= mysqli_fetch_assoc($result)){
                            echo '<div class="catWrapper">';
                            echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                            echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                            echo '</div>';
                            echo '<br>';
                        }
                    }

                    //this is selecting everything from products where the brand is what the user choose and its getting the result 
                    $sql = "select * from Products where brand = '".$brand."'"; 
                    $stmt = $mysqli->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    //this is looping through the result and displaying all of the results from the database with all of its inforamtion
                    if($result->num_rows >= 1){
                        print "<h2 id = 'Brand'class='catNames'>Brand:</h3>";

                        //this is looping through the result and displaying all of the results from the databse with all of its information
                        while($row= mysqli_fetch_assoc($result)){
                            echo '<div class="catWrapper">';
                            echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                            echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                            echo '</div>';
                            echo '<br>';
                        }
                    }
                }
            }else{ //this else is if the submit button has not been clicked
                ?>
                <!-- creating a navigation for the products -->
                </br>
                <div id="productDiv">
                    <nav id="productNav">
                        <a href="#cleansers" class="productNavLink">CLEANSERS</a> 
                        <a href="#toners" class="productNavLink">TONERS</a> 
                        <a href="#moisterizers" class="productNavLink">MOISTERIZERS</a> 
                        <a href="#serums" class="productNavLink">SERUMS</a> 
                        <a href="#sunscreens" class="productNavLink">SUNSCREEN</a> 
                    </nav>
                </div>
                <?php

                    //selecting everything from the products table 
                    $sql = "select * 
                            from products";

                    $stmt = $mysqli->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $cleanser= array();
                    $cleanserCount = 0;

                    $toner= array();
                    $tonerCount = 0;

                    $moisturizer=array();
                    $moisturizerCount = 0;

                    $sunscreen= array();
                    $sunscreenCount = 0;

                    $serum= array();
                    $serumCount = 0;

                    //taking the results and putting them into their correct arrays 
                    if($result->num_rows >= 1){
                        while($row= mysqli_fetch_assoc($result)){

                            if($row['type'] == 'Cleanser'){
                                $cleanser[$cleanserCount] = $row;
                                $cleanserCount++;
                            }

                            if($row['type'] == 'Toner'){
                                $toner[$tonerCount] = $row;
                                $tonerCount++;
                            }

                            if($row['type'] == 'Serum'){
                                $serum[$serumCount] = $row;
                                $serumCount++;
                            }

                            if($row['type'] == 'Moisturizer'){
                                $moisturizer[$moisturizerCount] = $row;
                                $moisturizerCount++;
                            }

                            if($row['type'] == 'Sunscreen'){
                                $sunscreen[$sunscreenCount] = $row;
                                $sunscreenCount++;
                            }
                        }
                        //if the cleanser array has something in it then we are going to dispaly everything in the array
                        if($cleanserCount > 0){
                            print "<h2 id ='Cleansers' class='catNames'>Cleansers:</h3>";

                            for($i=0; $i<count($cleanser); $i++){
                                $row = $cleanser[$i];
                                echo '<div class="catWrapper">';
                                echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                                echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                                echo '</div>';
                                echo '<br>';
                            }  
                        }

                        //if the toner array has something in it then we are going to dispaly everything in the array
                        if($tonerCount > 0){
                            print "<h2 id='toners' class='catNames'>Toners:</h2>";

                            for($i=0; $i<count($toner); $i++){
                                $row = $toner[$i];
                                echo '<div class="catWrapper">';
                                echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                                echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                                echo '</div>';
                                echo '<br>';
                            }  
                        }

                        //if the moisturizer array has something in it then we are going to dispaly everything in the array
                        if($moisturizerCount > 0){
                            print "<h2 id='moisterizers' class='catNames'>Moisturizers:</h2>";
                            for($i=0; $i<count($moisturizer); $i++){
                                $row = $moisturizer[$i];
                                echo '<div class="catWrapper">';
                                echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                                echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                                echo '</div>';
                                echo '<br>';
                            }  
                        }

                        //if the serum array has something in it then we are going to dispaly everything in the array
                        if($serumCount > 0){
                            print "<h2 id='serums' class='catNames'>Serums:</h2>";
                            for($i=0; $i<count($serum); $i++){
                                $row = $serum[$i];
                                echo '<div class="catWrapper">';
                                echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                                echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                                echo '</div>';
                                echo '<br>';
                            }  
                        }

                        //if the sunscreen array has something in it then we are going to dispaly everything in the array
                        if($sunscreenCount > 0){
                            print "<h2 id='sunscreens'class='catNames'>Sunscreens:</h2>";
                            for($i=0; $i<count($sunscreen); $i++){
                                $row = $sunscreen[$i];
                                echo '<div class="catWrapper">';
                                echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                                echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                                echo '</div>';
                                echo '<br>';
                            }  
                        }
                    }else{
                        print "<p style='color:#726a6a; font-family:Avenir;'>Sorry, no data found :(</p>";
                    }
            }
            //closing the sql connection
            $mysqli -> close();
            ?>

        </form>
    </body>
</html>