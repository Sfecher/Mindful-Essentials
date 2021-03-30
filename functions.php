<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php");
}else{
    include 'database.inc.php';
    //Opening up a connection to the databse
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    $id = $_POST['id'];
    if(isset($_POST['name'])){
        $_SESSION['name'] = $_POST['name'];
        $name = $_POST['name'];
        $sql = "UPDATE Products SET name = '".$name."' WHERE  id like ".$id."";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
    } 
    if(isset($_POST['link'])){
        $_SESSION['link'] = $_POST['link'];
        $link = $_POST['link'];
        $sql = "UPDATE Products SET link = '".$link."' WHERE  id like ".$id."";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
    }
    if(isset($_POST['image'])){
        $_SESSION['image'] = $_POST['image'];
        $image = $_POST['image'];
        $sql = "UPDATE Products SET imgPath = '".$image."' WHERE  id like ".$id."";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
    }
    if(isset($_POST['type'])){
        $_SESSION['type'] = $_POST['type'];
        $type = $_POST['type'];
        $sql = "UPDATE Products SET type = '".$type."' WHERE  id like ".$id."";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
    }
    if(isset($_POST['brand'])){
        $_SESSION['brand'] = $_POST['brand'];
        $brand = $_POST['brand'];
        $sql = "UPDATE Products SET brand = '".$brand."' WHERE  id like ".$id."";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
    }

    header("Refresh:0; url=edit.php?id=$id");
}
?>

