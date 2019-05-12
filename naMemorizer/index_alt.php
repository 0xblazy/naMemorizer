<?php
session_start();
$_SESSION['id']=0;
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>naMemorizer - Accueil</title>
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
                <h2>Bienvenue sur naMemorizer</h2>
                <p>
                    naMemorizer est un jeu à destination des enseignants, permettant de mémoriser le visage et le nom des élèves
                </p>
                <p>
                    Créez-vous un compte dès maintenant pour en savoir plus !
                </p>
                <div class="button">
                    <a href="create.php">Créer un compte</a>
                </div>
                <p>
                    Vous avez déjà un compte ? Connectez-vous et amusez-vous bien ;)
                </p>
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
            if (isset($_POST['connexion'])){

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