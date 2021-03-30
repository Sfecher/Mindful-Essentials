<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: login.php");
    }
    include 'database.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="brain.jpg" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<h1>Your New Entry</h1>
    <?php 
        include ("managerHeader.php");
        $informtion = array();

        if(isset($_SESSION["user"])) {
            //name of product
            if(isset($_POST['name'])){
                $_SESSION['name'] = $_POST['name'];
                $name = $_POST['name'];
                $count = count($information);
                $information[$count] = $name;
            }
            //product link
            if(isset($_POST['link'])){
                $_SESSION['link'] = $_POST['link'];
                $link = $_POST['link'];
                $count = count($information);
                $information[$count] = $link;
            }
            //image path
            if(isset($_POST['image'])){
                $_SESSION['image'] = $_POST['image'];
                $image = $_POST['image'];
                $count = count($information);
                $information[$count] = $image;
            }
            //type
            if(isset($_POST['type'])){
                $_SESSION['type'] = $_POST['type'];
                $type = $_POST['type'];
                $count = count($information);
                $information[$count] = $type;
            }
            //brand
            if(isset($_POST['brand'])){
                $_SESSION['brand'] = $_POST['brand'];
                $brand = $_POST['brand'];
                $count = count($information);
                $information[$count] = $brand;
            }
            //tags
            if(isset($_POST['tags'])){
                $_SESSION['tags'] = $_POST['tags'];
                $tags = $_POST['tags'];
                $number = count($tags);

                //using a for loop to do this because concerns are a check box (this means that they are placed into an array)
                for($i=0; $i<$number; $i++){
                    $count = count($information);
                    $information[$count] = $tags[$i];
                }
            }
            // for($i=0; $i<count($information); $i++){
            //     echo $information[$i];
            // }
        }
        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        $sql="INSERT INTO `Products`(`name`, `link`, `imgPath`, `type`, `brand`) VALUES ('$name', '$link', '$image', '$type', '$brand')";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        echo '<h3> Your product has been added! </h3>';

        $sqlLast="SELECT * FROM Products ORDER BY id DESC LIMIT 1;";
        $stmtLast = $mysqli->prepare($sqlLast);
        $stmtLast->execute();
        $resultLast = $stmtLast->get_result();
        while($row = mysqli_fetch_array($resultLast)){
            $id = $row['id'];
            echo'<p>Product Name: "'.$row['name'].'" </p>';
            echo'<p>Affiliate Link: "'.$row['link'].'" </p>';
            echo'<p>Image Path: "'.$row['imgPath'].'" </p>';
            echo'<p>Type: "'.$row['type'].'" </p>';
            echo'<p>Brand: "'.$row['brand'].'" </p>';

            //this is now putting the tags together with the product
            if(count($tags)>0){
                $number = count($tags);
                for($i=0; $i<$number; $i++){
                    $sqlTags = "INSERT INTO Product_purpose (`product_id`, `tag_name`) VALUES ('$id', '$tags[$i]')"; 
                    $stmtTags = $mysqli->prepare($sqlTags);
                    $stmtTags->execute();
                }
            }
        }
    ?>    
   
    <a href='managerHome.php'><button>RETURN TO MANAGER HOME</button></a>
    <br>
    <a href='newEntry.php'><button>CREATE NEW ENTRY</button></a>
</body>
</html>