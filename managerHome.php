<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: login.php");
    }
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
    <?php include ("managerHeader.php")?>
    
    <h1>Home</h1>
    <h2> Hello, <?php echo $_SESSION['user']; ?></h2>
    <br>
    <h3>Edit/Delete Entries </h3>
    <form action="modify.php">
        <input type="submit" value="Edit/Delete Entries"/>
    </form>
    <br>
    <h3>Create new Entry</h3>
    <form action="newEntry.php">
        <input type="submit" value="New Entry"/>
    </form> 
    <br>
    <a href="index.php"><button>RETURN TO WEBSITE</button></a>
</body>
</html>