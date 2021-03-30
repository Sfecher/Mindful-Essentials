<!-- This page is the quiz that the user will take to specify what they are wanting to get out of the quiz (skin care wants and needs) -->
<?php
    session_start();
    $_SESSION['userName'] = 'Root';
?>

<!DOCTYPE html>
<html lang="en">
    <head>  
        <link rel="icon" href="brain.jpg" type="image/x-icon">
    </head>
    <body>
         <?php include ("header.php")?>
        <?php include ("nav.php")?>

        <h1> Hello and welcome to the quiz!</h1>
        <form method="post" action="result.php">

            <h2>Choose your skin type (you can select more than one):</h2>

            <input class="normal" type='checkbox' name='skinType[]' value='Normal' id="normal"/>
            <label for="skinType[]">Normal</label><br>

            <input class="oily" type='checkbox' name='skinType[]' value='Oily' id="oily"/>
            <label for="skinType[]">Oily</label><br>

            <input class="dry" type='checkbox' name='skinType[]' value='Dry' id="dry"/>
            <label for="skinType[]">Dry</label><br>

            <input class="combination" type='checkbox' name='skinType[]' value='Combination' id="combination"/>
            <label for="skinType[]">Combination</label><br>

            <input class="sensitive" type='checkbox' name='skinType[]' value='Sensitive' id="sensitive"/>
            <label for="skinType[]">Sensitive</label><br>

            <input class="aging" type='checkbox' name='skinType[]' value='Aging' id="aging"/>
            <label for="skinType[]">Aging</label><br><br>


            <h2>What are some skin concerns? (you can select more than one):</h2>

            <input class="redness" type='checkbox' name='concerns[]' value='Redness' id="Redness"/>
            <label for="concerns[]">Redness</label><br>

            <input class="wrinkles" type='checkbox' name='concerns[]' value='Wrinkles' id="Wrinkles"/>
            <label for="concerns[]">Wrinkles/Finelines</label><br>

            <input class="acne" type='checkbox' name='concerns[]' value='Problem Skin' id="Problem Skin"/>
            <label for="concerns[]">Acne</label><br>


            <input class="hyperpigmentation" type='checkbox' name='concerns[]' value='hyperpigmentation' id="Hyperpigmentation"/>
            <label for="concerns[]">Hyperpigmentation</label><br>


            <input class="pores" type='checkbox' name='concerns[]' value='Pores' id="Pores"/>
            <label for="concerns[]">Large Pores</label><br>

            <input class="dullness" type='checkbox' name='concerns[]' value='Dullness' id="Dullness"/>
            <label for="concerns[]">Dullness</label><br>

            

            <h2>Would you like natural ingredients?:</h2>

            <input class="yes" type='radio' name='natural' value='yesNat' id="yes"/>
            <label for="natural">Yes</label><br>

            <input class="no" type='radio' name='natural' value='noNat' id="no"/>
            <label for="natural">No</label><br><br>


            <h2>Would you like a sunscreen in your routine?:</h2>

            <input class="sunscreen" type='radio' name='sunscreen' value='yesScreen' id="sunscreen"/>
            <label for="sunscreen">Yes</label><br>

            <input class="sunscreen" type='radio' name='sunscreen' value='noScreen' id="sunscreen"/>
            <label for="sunscreen">No</label><br><br>

            <input class="skinT" type="submit" name="button" id="button" value="CHOOSE">
        </form>
        <br>
        <?php include ("footer.php")?>
    </body>
</html>