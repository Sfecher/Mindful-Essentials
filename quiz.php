<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SKIN CARE</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
        <div id="wrapper">
            <img src="imgs/logo2.png" alt="logo" id="logo">   
            <nav>
                <a href="quiz.php" class="navLink">QUIZ</a> 
                <a href="#" class="navLink">PRODUCTS</a> 
                <a href="#" class="navLink">ABOUT US</a> 
            </nav>
        </div>
        <h1> Hello and welcome to the quiz</h1>
        <form method="get">
            <h2>Choose your skin type (you can select more than one):</h2>
            <input class="normal" type='checkbox' name='normal' value='valuable' id="normal"/>
            <label for="normal"></label><br>

            <input class="oily" type='checkbox' name='oily' value='valuable' id="oily"/>
            <label for="oily"></label><br>

            <input class="dry" type='checkbox' name='dry' value='valuable' id="dry"/>
            <label for="dry"></label><br>

            <input class="combination" type='checkbox' name='combination' value='valuable' id="combination"/>
            <label for="combination"></label><br>

            <input class="sensitive" type='checkbox' name='sensitive' value='valuable' id="sensitive"/>
            <label for="sensitive"></label><br>

            <input class="aging" type='checkbox' name='aging' value='valuable' id="aging"/>
            <label for="aging"></label><br><br>

            <h2>What are some skin concerns? (you can select more than one):</h2>
            <input class="redness" type='checkbox' name='redness' value='valuable' id="redness"/>
            <label for="redness">Redness</label><br>

            <input class="wrinkles" type='checkbox' name='wrinkles' value='valuable' id="wrinkles"/>
            <label for="wrinkles">Wrinkles/Finelines</label><br>

            <input class="firmness" type='checkbox' name='firmness' value='valuable' id="firmness"/>
            <label for="firmness">Loss of Firmness</label><br>

            <input class="acne" type='checkbox' name='acne' value='valuable' id="acne"/>
            <label for="acne">Acne</label><br>

            <input class="dryness" type='checkbox' name='dryness' value='valuable' id="dryness"/>
            <label for="dryness">Dryness</label><br>

            <input class="hyperpigmentation" type='checkbox' name='hyperpigmentation' value='valuable' id="hyperpigmentation"/>
            <label for="hyperpigmentation">Hyperpigmentation</label><br>

            <input class="sensitiveC" type='checkbox' name='sensitiveC' value='valuable' id="sensitiveC"/>
            <label for="sensitiveC">Sensitive</label><br>

            <input class="pores" type='checkbox' name='pores' value='valuable' id="pores"/>
            <label for="pores">Large Pores</label><br>

            <input class="texture" type='checkbox' name='texture' value='valuable' id="texture"/>
            <label for="texture">Rough Texture</label><br><br>
            
            <h2>Would you like natural ingredients?:</h2>
            <input class="yes" type='radio' name='yes' value='valuable' id="yes"/>
            <label for="yes">Yes</label><br>
            <input class="no" type='radio' name='no' value='valuable' id="no"/>
            <label for="no">No</label><br><br>

            <h2>Would you like a sunscreen in your routine?:</h2>
            <input class="yes" type='radio' name='yes' value='valuable' id="yes"/>
            <label for="yes">Yes</label><br>
            <input class="no" type='radio' name='no' value='valuable' id="no"/>
            <label for="no">No</label><br><br>

            <input class="skinT" type="submit" name="button" id="button" value="CHOOSE">
        </form>
    </body>
</html>
