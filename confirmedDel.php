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
    <?php 
        include ("managerHeader.php");
        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $id = $_GET['id'];

        $sql1 = 'Delete From Product_purpose where product_id="'.$id.'"'; 
        $stmt1 = $mysqli->prepare($sql1);
        $stmt1->execute();

        $sql = 'Delete From Products where id="'.$id.'"'; 
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();

        echo "<h1> YOUR ENTRY HAS BEEN DELETED </h1>";
        echo "<a href='modify.php'><button>RETURN TO EDIT AND DELETE</button></a>";
        echo "<br>";
        echo "<a href='managerHome.php'><button>RETURN TO MANAGER HOME</button></a>";

        $mysqli -> close();
    ?>
</body>
</html>