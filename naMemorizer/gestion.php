<?php
session_start();


        //CONNEXION A LA BASE DE DONNEES
        try {
            //OUVERTURE DE LA CONNEXION A LA BASE DE DONNEES 
            $connection = new PDO(
            "mysql:host=localhost;dbname=projetweb",
            "root",
            ""
            );


                $query = "SELECT * FROM teachers WHERE `id` = :id";
                $conn = $connection->prepare($query);
                $conn->bindValue(":id", $_SESSION['id'], PDO::PARAM_STR);
                $conn->execute();    
                $user = $conn->fetch();



                if($conn->rowCount()>0){
                    $firstname = $user['firstname'];
                    $lastname = $user['lastname'];
                    $login = $user['login'];
                    $email = $user['email'];
                    $password = $user['password'];

                }

            //FERMETURE DE LA CONNEXION A LA BASE DE DONNEES
            $connection = null;

        } catch(PDOException $e) { 
            die('Erreur : '.$e->getMessage());
        }


?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>naMemorizer - Gestion du compte</title>
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
                    <a href="game.php">Jeu</a>
                    <a href="gestion.php" class="selected">Gestion du Compte</a>
                    <a href="classes.php">Gestion des Classes</a>
                </nav>
                <button class="button">Déconnexion</button>
            </div>
        </header>
        <div class="contenu">
            <div>
                <div class="multiple_form">
                    <form action="" method="post">
                        <h2>Modifier vos<br/>informations</h2>
                        <p>
                            <label for="name">Nom :</label>
                            <input type="text" name="name" id="name" value = "<?php echo $lastname;?>" required/>
                        </p>
                        <p>
                            <label for="firstname">Prénom :</label>
                            <input type="text" name="firstname" id="firstname" value = "<?php echo $firstname;?>" required/>
                        </p>
                        <p>
                            <label for="login">Identifiant :</label>
                            <input type="text" name="login" id="login" value = "<?php echo $login;?>" required/>
                        </p>
                        <p>
                            <label for="email">Email :</label>
                            <input type="email" name="email" id="email" value = "<?php echo $email;?>" required/>
                        </p>
                        <p>
                            <label for="pass">Mot de passe :</label>
                            <input type="password" name="passM" id="passM" required/>
                        </p>
                        <button type="submit" class="button" name="ModifInfos">Modifier</button>
                    </form>
                    <form action="" method="post">
                        <h2>Modifier votre<br/>mot de passe</h2>
                        <p>
                            <label for="oldpass">Ancien mot de passe :</label>
                            <input type="password" name="oldpass" id="oldpass" required/>
                        </p>
                        <p>
                            <label for="newpass">Nouveau mot de passe :</label>
                            <input type="password" name="newpass" id="newpass" required/>
                        </p>
                        <p>
                            <label for="newpassconf">Confirmation :</label>
                            <input type="password" name="newpassconf" id="newpassconf" required/>
                        </p>    
                        <button type="submit" class="button" name="ModifPassword">Modifier</button>
                    </form>
                    <form action="" method="post">
                        <h2>Suppression de votre<br/>Compte</h2>
                        <p>
                            <label for="pass">Mot de passe :</label>
                            <input type="password" name="passD" id="pass" required/>
                        </p>  
                        <button type="submit" class="delete button" name="DeleteAcc">Supprimer</button>
                    </form>
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

            <?php 
            //CONNEXION A LA BASE DE DONNEES
            try {
                //OUVERTURE DE LA CONNEXION A LA BASE DE DONNEES 
                $connection = new PDO(
                "mysql:host=localhost;dbname=projetweb",
                "root",
                ""
                );

                if (isset($_POST['ModifInfos'])){
                    $valid = true;
                    $nameM = $_POST['name'];

                    $firstnameM = $_POST['firstname'];  
                    $loginM = $_POST['login'];  

              
                    $passwordM = $_POST['passM'];
              
                    $emailM = $_POST['email'];

                    if ($password != $passwordM){
                        $valid = false;
                    }

                    if($valid){
                    $query = "UPDATE `teachers` SET `login`= :login, `lastname`= :lastname, `firstname`= :firstname, `email`= :email WHERE `id`= :id";
                    $modif = $connection->prepare($query);
                    $modif->bindValue(":login", $loginM, PDO::PARAM_STR);
                    $modif->bindValue(":lastname", $nameM, PDO::PARAM_STR);
                    $modif->bindValue(":firstname", $firstnameM, PDO::PARAM_STR);
                    $modif->bindValue(":email", $emailM, PDO::PARAM_STR);
                    $modif->bindvalue(":id", $_SESSION['id'], PDO::PARAM_STR);
                    $modif->execute();
                }

            } else if (isset($_POST['ModifPassword'])){
                $valid = true;

                $oldP = $_POST['oldpass']; 
                $newP = $_POST['newpass'];
                $newPConf = $_POST['newpassconf'];

                if(($password != $oldP) || ($newP != $newPConf)){
                    $valid = false;
                }

                if($valid){
                    $query = "UPDATE `teachers` SET `password`= :password WHERE `id`= :id";
                    $modif = $connection->prepare($query);
                     $modif->bindValue(":password", $newP, PDO::PARAM_STR);
                    $modif->bindvalue(":id", $_SESSION['id'], PDO::PARAM_STR);
                    $modif->execute();
                }

            } else if (isset($_POST['DeleteAcc'])){
                if($password == $_POST['passD']){
                    $query = "DELETE FROM `teachers` WHERE `id`= :id";
                    $modif = $connection->prepare($query);
                    $modif->bindvalue(":id", $_SESSION['id'], PDO::PARAM_STR);
                    $modif->execute();
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