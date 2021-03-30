<?php 
    session_start();
    include 'database.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager- Mindful Essentials</title>
</head>
<body>
    <h1>Please Login</h1>
    <form method = "post" action = "login.php">
        <label class="label" for="user">Username</label>
        <input class="input" type="text" name="user" id="user" placeholder="Username...">
        <br>
        <br>
        <label class="label" for="pass">Password</label>
        <input class="input" type="password" name="pass" id="pass" placeholder="Password...">
        <?php
            //Opening up a connection to the databse
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
            //setting up variables for the username and password inputs
            $usern = $_POST["user"];
            $pass = $_POST["pass"];
            //The if statment checks if username and password is set.
            if(isset($usern) && isset($pass)){
                //This is setting up a sql statment then setting the username and password as strings.
                $sql = "SELECT * FROM Users WHERE username LIKE ? AND password LIKE ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ss", $usern, $pass);
                //It is now executing the statment with the user name and password and getting the result.
                $stmt->execute();
                $result = $stmt->get_result();
                //It is checking if the result's rows are greater than or equal to 1 and if it is not it will display a message
                if($result->num_rows >= 1){
                    $_SESSION["user"] = $usern;
                    header("Location: managerHome.php");
                    exit();
                }else{ //bug for US2:1 and US2:2
                    print "<p style='color:red; font-size:13px; font-family:Museo Sans;'>USERNAME OR PASSWORD IS INCORRECT</p>";
                }
            }
        ?>
        <input type ="submit" id = "login" class="btn btn-primary btn-lg active btn-rounded" value= "LOGIN">
    </form>
</body>
</html>