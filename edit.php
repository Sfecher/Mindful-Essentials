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

    <h1>Edit Entry</h1>

    <?php
        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        $id = $_GET['id'];
        $sql = 'select * from Products where id="'.$id.'"'; 
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_array($result);

        $sql2 = 'select distinct name from Tags'; 
        $stmt2 = $mysqli->prepare($sql2);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $row2 = mysqli_fetch_array($result2);
        
    ?>
    <form method = "post" action = "functions.php">
        <label class="label" for="ProdId">Product id</label>
        <input type="text" name="ProdId" value="<?php echo $row["id"]; ?>" readonly>
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>"><br><br>

        <label class="label" for="name">Product Name</label>
        <input class="input" type="text" name="name" id="name" placeholder="Name..." value="<?php echo $row["name"]; ?>"><br><br>

        <label class="label" for="link">Product Link</label>
        <input class="input" type="text" name="link" id="link" placeholder="link..." value="<?php echo $row["link"]; ?>"><br><br>

        <label class="label" for="image">Product Image Path</label>
        <input class="input" type="text" name="image" id="image" placeholder="image..." value="<?php echo $row["imgPath"]; ?>"><br><br>

        <label class="label" for="type">Product Type</label>
        <input class="input" type="text" name="type" id="type" placeholder="Type..." value="<?php echo $row["type"]; ?>"><br><br>

        <label class="label" for="brand">Product Brand</label>
        <input class="input" type="text" name="brand" id="brand" placeholder="brand..." value="<?php echo $row["brand"]; ?>"><br><br>
        <br>
        <?php
        if($result2->num_rows >= 1){
            print "<h2>Select some tags:</h2>";
            while($row= mysqli_fetch_assoc($result2)){
                echo '<input type="checkbox" id="'.$row["name"].'" name="tags[]" value="'.$row["name"].'">';
                echo '<label for="tags[]">'.$row["name"].'</label><br>';
                echo '<br>';
            }
        }else{
            echo '<p>Sorry there are no tags to display</p>';
        }
        ?>
        <input type="submit" id="login" class="btn btn-primary btn-lg active btn-rounded" value="SAVE CHANGES">
        <br>
    </form>
    <br>
    <a href='managerHome.php'><button>RETURN TO MANAGER HOME</button></a>
</body>
</html>