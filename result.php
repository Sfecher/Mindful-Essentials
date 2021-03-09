<?php
    session_start();
    include 'database.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="brain.jpg" type="image/x-icon">
    </head>
    <body>
        <?php include ("header.php")?>
        <?php include ("nav.php")?>
    </body>
    <?php
        print "<h1 style='text-align: center;'>HERE ARE YOUR RESULTS:</h1>";

        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
        //this array holds the information of what the user has selected in the quiz
        $informtion = array();
        
        //if the username is set in the session (this means that the session is started) then we are able to set the below items
        if(isset($_SESSION['userName'])) {

            //this is checking if the skin type is set and if it is put it into the informationa array
            if(isset($_POST['skinType'])){
                $_SESSION['skinType'] = $_POST['skinType'];
                $skinType = $_POST['skinType'];
                $number = count($skinType);

                //using a for loop to do this because skin type is a check box (this means that they are placed into an array)
                for($i=0; $i<$number; $i++){
                    $count = count($information);
                    $information[$count] = $skinType[$i];
                }
            }

            //this is checking if the concerns is set and if it is put it into the informationa array
            if(isset($_POST['concerns'])){
                $_SESSION['concerns'] = $_POST['concerns'];
                $concerns = $_POST['concerns'];
                $number = count($concerns);

                //using a for loop to do this because concerns are a check box (this means that they are placed into an array)
                for($i=0; $i<$number; $i++){
                    $count = count($information);
                    $information[$count] = $concerns[$i];
                }
            }

            //this is checking if the natural radio button is set and if it is put it into the informationa array
            if(isset($_POST['natural'])){
                $_SESSION['natural'] = $_POST['natural'];
                $ingred = $_POST['natural'];
                $count = count($information);
                $information[$count] = $ingred;
            }

            //this is checking if the sunscreen radio button is set and if it is put it into the informationa array
            if(isset($_POST['sunscreen'])){
                $_SESSION['sunscreen'] = $_POST['sunscreen'];
                $sunscreen = $_POST['sunscreen'];
                $count = count($information);
                $information[$count] = $sunscreen;
            }
            
            $checkTot = 0;

            //the start fo our sql. This is everything from products where it is then grabbing inforamtion from product_purpose
            $sql = "select * 
                    from products
                    where id in (select b.product_id 
                                from (select count(1), a.product_id 
                                        from (select product_id, tag_name from Product_purpose where 1=0";

            //if there is objects inside of skin type then we are going to get all of them with the for loop and place them into the sql
            //the sql is concatinating the previous sql with a union all that is using the skin type inforamtion as the tag_name then adding to count
            if(count($skinType)>0){
                $number = count($skinType);
                for($i=0; $i<$number; $i++){
                    $sql = $sql . " UNION ALL
                    select product_id, tag_name from Product_purpose where tag_name = '". $skinType[$i] ."'";
                    $checkTot++;
                }
            }
            //if there is objects inside of concerns then we are going to get all of them with the for loop and place them into the sql 
            //the sql is concatinating the previous sql with a union all that is using the skin type inforamtion as the tag_name then adding to count
            if(count($concerns)>0){
                $number = count($concerns);
                for($i=0; $i<$number; $i++){
                    $sql = $sql . " UNION ALL
                    select product_id, tag_name from Product_purpose where tag_name = '". $concerns[$i] ."'";
                    $checkTot++;
                }

            }

            //the sql is concatinating the previous sql with a union all that is using the skin type inforamtion as the tag_name then adding to count
            //for this particular one it is determining what the user put and if it is natural or not.
            if($ingred == 'yesNat'){
                $sql = $sql . " UNION ALL
                                select product_id, tag_name from Product_purpose where tag_name = 'Natural'";
                $checkTot++;
            }else{

                if($ingred == 'noNat'){
                    $sql = $sql . " UNION ALL
                    select product_id, tag_name from Product_purpose where tag_name = 'Not Natural'";
                    $checkTot++;
                }
            }

            //the sql is concatinating the previous sql with a union all that is using the skin type inforamtion as the tag_name then adding to count
            if($sunscreen == 'yesScreen'){
                $sql = $sql. " UNION ALL
                            select product_id, tag_name from Product_purpose where tag_name = 'Sunscreen'";
                $checkTot++;
            }

            //this is taking the above sql and concatinating it with the ending that is taking the total and will display things that match 
            //this query EXACTLY
            $mainSQL = $sql . ") a
            group by a.product_id
            having count(1) = ".$checkTot.") b)"; 

            //this is taking the above sql and concatinating it with the ending that is displaying everything that has the above inforamtion
            //not as exact (you chose this concern so we will dispaly all products that have this concern)
            $secondarySQL = $sql . ") a
            group by a.product_id
            having count(1) > 0) b)";

            //executing the sql and getting a result
            $stmtMain = $mysqli->prepare($mainSQL);
            $stmtMain->execute();
            $result1 = $stmtMain->get_result();

            //taking the result and placing it into html. This is also using the different objects from the database and displaying them 
            //if there is no result it will print out a sorry message
            if($result1->num_rows >= 1){
                print "<h2 style='color:#8da4a4; font-family:Avenir; text-align: center;'>Here is what might suit your needs:</h2>";
                while($row= mysqli_fetch_assoc($result1)){
                    echo '<div class="catWrapper">';
                    echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                    echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                    echo '</div>';
                    echo '<br>';
                }
            }else{
                print "<h3 style='color:#8da4a4; font-family:Avenir; text-align: center;'>Sorry, we were unable to find an exact result.</h3>";
            }
            print "<h2 style='color:#8da4a4; font-family:Avenir; text-align: center;'>Some other fun choices:</h2>";
            ?>

            <!-- this is a nav that will help the user to navigate through all of the products that were selected according to their less 
            exact needs. -->
            <div id="productDiv">
                <nav id="productNav">
                    <a href="#cleansers" class="productNavLink">CLEANSERS</a> 
                    <a href="#toners" class="productNavLink">TONERS</a> 
                    <a href="#moisterizers" class="productNavLink">MOISTERIZERS</a> 
                    <a href="#serums" class="productNavLink">SERUMS</a> 
                    <a href="#sunscreens" class="productNavLink">SUNSCREENS</a> 
                </nav>
            </div>

            <?php
            //this is executing the second sql and getting the result
            $stmtSecondary = $mysqli->prepare($secondarySQL);
            $stmtSecondary->execute();
            $result2 = $stmtSecondary->get_result();

            //just creatign arrays so that we can best dispaly inforamtion
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

            //this is using the result and putting the information from the database (from the sql query) and placing it into 
            //the above arrays by type categories
            if($result2->num_rows >= 1){
                while($row= mysqli_fetch_assoc($result2)){

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

                //checking if the cleanser array has anything in it and if it does it dispalys all of the cleansers in the cleanser area 
                if($cleanserCount > 0){
                    print "<h2 id = 'cleansers' class='catNames'>Cleansers:</h3>";

                    //this for loop is going through the array and displaying everything inside it 
                    for($i=0; $i<count($cleanser); $i++){
                        $row = $cleanser[$i];
                        echo '<div class="catWrapper">';
                        echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                        echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                        echo '</div>';
                        echo '<br>';
                    }  
                }

                //checking if the toner array has anything in it and if it does it dispalys all of the toners in the toner area 
                if($tonerCount > 0){
                    print "<h2 id = 'toners' class='catNames'>Toners:</h2>";

                    //this for loop is going through the array and displaying everything inside it 
                    for($i=0; $i<count($toner); $i++){
                        $row = $toner[$i];
                        echo '<div class="catWrapper">';
                        echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                        echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                        echo '</div>';
                        echo '<br>';
                    }  
                }

                //checking if the moisturizer array has anything in it and if it does it dispalys all of the moisturizer in the moisturizer area 
                if($moisturizerCount > 0){
                    print "<h2 id = 'moisterizers' class='catNames'>Moisturizers:</h2>";
                                       
                    //this for loop is going through the array and displaying everything inside it 
                    for($i=0; $i<count($moisturizer); $i++){
                        $row = $moisturizer[$i];
                        echo '<div class="catWrapper">';
                        echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                        echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                        echo '</div>';
                        echo '<br>';
                    }  
                }

                //checking if the serum array has anything in it and if it does it dispalys all of the serum in the serum area 
                if($serumCount > 0){
                    print "<h2 id = 'serums'class='catNames'>Serums:</h2>";

                    //this for loop is going through the array and displaying everything inside it 
                    for($i=0; $i<count($serum); $i++){
                        $row = $serum[$i];
                        echo '<div class="catWrapper">';
                        echo '<div class="catImg"><a href="'.$row["link"].' " target="_blank"><img src="'.$row["imgPath"].'" style="width: 200px;"></a></div>';
                        echo '<div class="bonk"><a class="chonk" href="'.$row["link"].' " target="_blank">'.$row["name"].' <br> '.$row["brand"].'</a></div>';
                        echo '</div>';
                        echo '<br>';
                    }  
                }

                //checking if the serum array has anything in it and if it does it dispalys all of the serum in the serum area 
                if($sunscreenCount > 0){
                    print "<h2 id = 'sunscreens' class='catNames'>Sunscreens:</h2>";

                    //this for loop is going through the array and displaying everything inside it 
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
        //closing the sql connection
        $mysqli -> close();
        }
    ?>

</html>