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
    <?php include ("managerHeader.php")?>

    <h1>Create A New Entry</h1>
    <form method = "post" action = "addedEntry.php" style="margin-left:2%;">
        <label class="label" for="name">Product Name</label>
        <input class="input" type="text" name="name" id="name" placeholder="Name..."><br><br>

        <label class="label" for="link">Affiliate Link</label>
        <input class="input" type="text" name="link" id="link" placeholder="link..."><br><br>

        <label class="label" for="image">Product Image Path</label>
        <input class="input" type="text" name="image" id="image" placeholder="image..."><br><br>

        <label class="label" for="type">Product Type</label>
        <input class="input" type="text" name="type" id="type" placeholder="Type..."><br><br>

        <label class="label" for="brand">Product Brand</label>
        <input class="input" type="text" name="brand" id="brand" placeholder="brand..."><br>
        <?php
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            $sql = 'select distinct name from Tags'; 
            $stmt = $mysqli->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = mysqli_fetch_array($result);
            if($result->num_rows >= 1){
                print "<h2>Select some tags:</h2>";
                while($row= mysqli_fetch_assoc($result)){
                    echo '<input type="checkbox" id="'.$row["name"].'" name="tags[]" value="'.$row["name"].'">';
                    echo '<label for="tags[]">'.$row["name"].'</label><br>';
                    echo '<br>';
                }
            }else{
                echo '<p>Sorry there are no tags to display</p>';
            }
        ?>
        <input type="submit" id="login" class="btn btn-primary btn-lg active btn-rounded" value="ADD NEW PRODUCT">
        <br>
    </form>
    <br>
    <a href='managerHome.php'><button>RETURN TO MANAGER HOME</button></a>
</body>
</html>