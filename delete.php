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

    <h1>Delete</h1>

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

        echo "<table border='1'>
        <tr>
        <th>Product id</th>
        <th>Product Name</th>
        <th>Product Link</th>
        <th>Product Type</th>
        <th>Product Brand</th>
        </tr>";

        while($row = mysqli_fetch_array($result))
        {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['link'] . "</td>";
        echo "<td>" . $row['type'] . "</td>";
        echo "<td>" . $row['brand'] . "</td>";
        echo "</tr>";
        }
        echo "</table>";

        $mysqli -> close();

        echo "<h3>ARE YOU SURE YOU WOULD LIKE TO DELETE THIS ENTRY?</h3>";
        echo "<a href='confirmedDel.php?id=".$id."'><button>YES</button></a>";
        echo "<a href='modify.php'><button>NO</button></a>";
    ?> 
</body>
</html>