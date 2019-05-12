<!DOCTYPE HTML>
<html>
    <head>
        <title>naMemorizer - Créer un compte</title>
        <meta charset="utf-8"/>
        <link rel="icon" type="image/png" href="img/favicon.png"/>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
        <header>
            <div class="header-img">
                <img src="img/logo.png" alt="Logo Name Memorizer"/>
            </div>
            <div class="not_connected">
                <form action="" method="post">
                    <input type="text" name="login" placeholder="Identifiant" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <button type="submit" name="connexion" value="Connexion" class="button">Connexion</button>
                </form>
                <div class="button">
                    <a href="create.php">Créer un compte</a>
                </div>
            </div>
        </header>
        <div class="contenu">
            <div>
                <form action="" method="post">
                    <h2>Nouveau compte</h2>
                    <p>
                        <label for="name">Nom :</label>
                        <input type="text" name="name" id="name" required/>
                    </p>
                    <p>
                        <label for="firstname">Prénom :</label>
                        <input type="text" name="firstname" id="firstname" required/>
                    </p>
                    <p>
                        <label for="login">Identifiant :</label>
                        <input type="text" name="login" id="login" required/>
                    </p>
                    <p>
                        <label for="email">Email :</label>
                        <input type="email" name="email" id="email" required/>
                    </p>
                    <p>
                        <label for="pass">Mot de passe :</label>
                        <input type="password" name="pass" id="pass" required/>
                    </p>
                    <p>
                        <label for="passconf">Confirmation :</label>
                        <input type="password" name="passconf" id="passconf" required/>
                    </p>
                    <button type="submit" class="button" name = "creation" value="Creation">Créer</button>
                </form>

            </div>
        
        </div>
        <footer>
            <div>
                <p>
                    Projet réalisé par Gael HUSSON, Nathan MINGER, Nicolas CARBONNIER et Tristan GARNI,<br/> dans le cadre du cours de Web avancé de Licence MIASHS 2ème année 
                </p>
            </div>
            <div>
                <a target="_blank" href="http://institut-sciences-digitales.fr/" alt="Site de l'IDMC">
                    <img src="img/idmc_logo.png" alt="Logo IDMC"/>
                </a>
            </div>
            
        <?php 

        //CONNEXION A LA BASE DE DONNEES
        try {
            //OUVERTURE DE LA CONNEXION A LA BASE DE DONNEES 
            $connection = new PDO(
            "mysql:host=localhost;dbname=projetweb",
            "root",
            ""
            );

            //L'UTILISATEUR A CLIQUE SUR LE BOUTON INSCRIPTION
            if (isset($_POST['creation'])){
  				$valid = true;
                $name = $_POST['name'];

                $firstname = $_POST['firstname'];  
                $login = $_POST['login'];  
          
                $mdp = $_POST['pass'];

                if (($_POST["pass"]) != ($_POST["passconf"])){
                	$valid = false;
                }
          
                $email = $_POST['email'];


                if($valid){
                $query = "INSERT INTO teachers (login, lastname, firstname, email, password) VALUES (:login, :lastname, :firstname, :email, :password)";
                $inscr = $connection->prepare($query);
				$inscr->bindValue(":login", $login, PDO::PARAM_STR);
				$inscr->bindValue(":lastname", $name, PDO::PARAM_STR);
				$inscr->bindValue(":firstname", $firstname, PDO::PARAM_STR);
				$inscr->bindValue(":email", $email, PDO::PARAM_STR);
				$inscr->bindValue(":password", $mdp, PDO::PARAM_STR);
                $inscr->execute();     
            	header("Location: ./index.php");
            }
        } else if (isset($_POST['connexion'])){
        		$login = $_POST['login']; 
                $mdp = $_POST['password'];
                $query = "SELECT * FROM teachers WHERE `login` = :login AND `password` = :password";
                $conn = $connection->prepare($query);
                $conn->bindValue(":login", $login, PDO::PARAM_STR);
                $conn->bindValue(":password", $mdp, PDO::PARAM_STR);
                $conn->execute();    
                $user = $conn->fetch();

                if($conn->rowCount()>0){
                    $_SESSION['id'] = $user['id'];
                header("Location: ./index.php");
                }
        }

            //FERMETURE DE LA CONNEXION A LA BASE DE DONNEES
            $connection = null;

        } catch(PDOException $e) { 
            die('Erreur : '.$e->getMessage());
        }
        ?>
        </footer>
    </body>
</html>