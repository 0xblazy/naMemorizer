<?php 
	session_start();
    $_SESSION['score'] = 0;
    $_SESSION['numQuestion'] = 1;
	//echo $_SESSION['score'];
	try {
	    //OUVERTURE DE LA CONNEXION A LA BASE DE DONNEES 
	    $connection = new PDO(
	    "mysql:host=localhost;dbname=projetweb",
	    "root",
	    ""
	    );
		$query = 'SELECT COUNT(*) FROM students';
		$conn = $connection->prepare($query);
	    $conn->execute();    
	    $res = $conn->fetch();

	    if($conn->rowCount()>0){
	        $nb_etu = $res['COUNT(*)'];
	    }


		$random = rand(1, $nb_etu);
		$random2 = rand(1, $nb_etu);

		while($random == $random2){
			$random2 = rand(1, $nb_etu);
		}

		//Récupération photo + nom + prénom du premier étudiant
		$query = 'SELECT * FROM students WHERE `id` = :id';

        $conn = $connection->prepare($query);
        $conn->bindValue(":id", $random, PDO::PARAM_STR);
        $conn->execute();    
        $stud = $conn->fetch();
        if($conn->rowCount()>0){
            $stud_photo = $stud['photo'];
            $stud_lastname = strtoupper($stud['lastname']);
            $stud_firstname = $stud['firstname'];
        }

        //Récupération nom + prénom du second étudiant
		$query = 'SELECT * FROM students WHERE `id` = :id';

        $conn = $connection->prepare($query);
        $conn->bindValue(":id", $random2, PDO::PARAM_STR);
        $conn->execute();    
        $stud = $conn->fetch();
        if($conn->rowCount()>0){
            $stud2_lastname = strtoupper($stud['lastname']);
            $stud2_firstname = $stud['firstname'];
        }

        $invers = false;

        //Une chance sur deux d'inverser les noms sur les bouttons, pour pas que la bonne réponse soit toujours sur le bouton de gauche
        $randPlace = rand(1,100);

        if($randPlace>50){
            $tmp = $stud_firstname;
            $tmp2 = $stud_lastname;

            $stud_firstname = $stud2_firstname;
            $stud_lastname = $stud2_lastname;

            $stud2_firstname = $tmp;
            $stud2_lastname = $tmp2;

            $invers = true;
        }

        if($invers){
        	$buttonAState = '"buttonAFalse()"';
        	$buttonBState = '"buttonBTrue()"';
        } else {
        	$buttonAState = '"buttonATrue()"';
        	$buttonBState = '"buttonBFalse()"';
        }

	    } catch(PDOException $e) { 
	        die('Erreur : '.$e->getMessage());
	}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>naMemorizer - Jeu</title>
        <meta charset="utf-8"/>
        <link rel="icon" type="image/png" href="img/favicon.png"/>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
        <header>
            <div class="header-img">
                <img src="img/logo.png" alt="Logo Name Memorizer"/>
            </div>
            <div class="menu">
                <nav>
                    <a href="index.php">Accueil</a>
                    <a href="game.php" class="selected">Jeu</a>
                    <a href="gestion.php">Gestion du Compte</a>
                    <a href="classes.php">Gestion des Classes</a>
                </nav>
                <button class="button">Déconnexion</button>
            </div>
        </header>
        <div class="contenu">
            <div>
                <div class="game">
                    <h2>Question <?php echo $_SESSION['numQuestion'] ?>/10</h2>
                    <p>
                        Choisissez le nom associé à la photo
                    </p>
                    <img src=<?php echo "photos/" . $stud_photo; ?> alt=""/>
                    <div>
                        <button class="button" onclick=<?php echo $buttonAState ?> id="button1"><?php echo $stud_firstname . " " . $stud_lastname; ?></button>
                        <button class="button" onclick=<?php echo $buttonBState ?> id="button2"><?php echo $stud2_firstname . " " . $stud2_lastname; ?></button>
                    </div>
                    <button class="button" onclick="window.location='game.php';">Suivant</button>
                </div>
            </div>
        </div>
        <footer>
            <div>
                <p>
                    Projet réalisé par Gael HUSSON, Nathan MINGER, Nicolas CARBONNIER et Tristan GARNI, dans le cadre du cours de Web avancé de Licence MIASHS 2ème année 
                </p>
            </div>
            <div>
                <a target="_blank" href="http://institut-sciences-digitales.fr/" alt="Site de l'IDMC">
                    <img src="img/idmc_logo.png" alt="Logo IDMC"/>
                </a>
            </div>
        </footer>
        <script>
        	function buttonATrue(){
        		var element = document.getElementById("button1").className = "button true";
        		document.getElementById("button1").disabled = true;
        		document.getElementById("button2").disabled = true;
        		//element.classList.toggle("button true");
        	}

			function buttonAFalse(){
        		var element = document.getElementById("button1").className = "button false";
        		document.getElementById("button1").disabled = true;
        		document.getElementById("button2").disabled = true;
        		//element.classList.toggle("button true");
        	}

			function buttonBTrue(){
        		var element = document.getElementById("button2").className = "button true";
        		document.getElementById("button1").disabled = true;
        		document.getElementById("button2").disabled = true;
        		//element.classList.toggle("button true");
        	}

			function buttonBFalse(){
        		var element = document.getElementById("button2").className = "button false";
        		document.getElementById("button1").disabled = true;
        		document.getElementById("button2").disabled = true;
        		//element.classList.toggle("button true");
        	}

        </script>
    </body>
</html>