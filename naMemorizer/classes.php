<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>naMemorizer - Gestion des Classes</title>
        <meta charset="utf-8"/>
        <link rel="icon" type="image/png" href="img/favicon.png"/>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            function readUrl(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
        
                    reader.onload = function(e) {
                        $('#imageshow')
                            .attr('src', e.target.result);
                    };
        
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
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
                    <a href="gestion.php">Gestion du Compte</a>
                    <a href="classes.php" class="selected">Gestion des Classes</a>
                </nav>
                <button class="button">Déconnexion</button>
            </div>
        </header>
        <div class="contenu">
            <div>
                <div class="multiple_form classes">
                    <form enctype="multipart/form-data" action="" method="post">
                        <h2>Ajouter un étudiant</h2>
                        <p>
                            <label for="name">Nom :</label>
                            <input type="text" name="name" id="name" required/>
                        </p>
                        <p>
                            <label for="firstname">Prénom :</label>
                            <input type="text" name="firstname" id="firstname" required/>
                        </p>
                        <div>
                            <label for="class">Classe :</label>
                            <div class="select">
                                <select name="classA" id="class" required>
                                    <option value="" selected>---</option>
                                    <?php
                                    try {
                                        //OUVERTURE DE LA CONNEXION A LA BASE DE DONNEES 
                                        $connection = new PDO(
                                        "mysql:host=localhost;dbname=projetweb",
                                        "root",
                                        ""
                                        );
                                        $query = "SELECT * FROM `classes` WHERE `id` in (SELECT class_id FROM `teachersclasses` WHERE teacher_id = " . $_SESSION['id'] .") ";
                                        $data = $connection->query($query)->fetchAll();
                                        foreach($data as $row){
                                            echo '<option value=' .$row['id'] . '>' . $row['name'] .'</option>';
                                        }

                                        $connection = null;
                                    } catch(PDOException $e) { 
                                        die('Erreur : '.$e->getMessage());
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <p class="imageupload">
                            <label for="image">
                                <img id="imageshow" src="#" alt="Cliquez ici pour ajouter la photo de l'étudiant"/>
                            </label>
                            <input type="file" accept="image/jpeg, image/png" name="image" id="image" onchange="readUrl(this)" required/>
                        </p>
                        <button type="submit" name="ajoutEtu" class="button">Ajouter</button>
                    </form>
                    <div>
                        <form action="" method="post">
                            <h2>Ajouter une Classe</h2>
                            <p>
                                <label for="classname">Nom de la classe :</label>
                                <input type="text" name="classname" id="classname" required/>
                            </p>
                            <button type="submit" name="ajoutClasse" value="AjoutClasse" class="button">Ajouter</button>
                        </form>

                        <form action="" method="post">
                            <h2>Supprimer une Classe</h2>
                            <div>
                                <label for="class">Classe :</label>
                                <div class="select">
                                    <select name="classD" id="class" required>
                                        <option value="" selected>---</option>
                                        <?php
                                        try {
                                            //OUVERTURE DE LA CONNEXION A LA BASE DE DONNEES 
                                            $connection = new PDO(
                                            "mysql:host=localhost;dbname=projetweb",
                                            "root",
                                            ""
                                            );
                                            $query = "SELECT * FROM `classes` WHERE `id` in (SELECT class_id FROM `teachersclasses` WHERE teacher_id = " . $_SESSION['id'] .") ";
                                            $data = $connection->query($query)->fetchAll();
                                            foreach($data as $row){
                                                echo '<option value=' .$row['id'] . '>' . $row['name'] .'</option>';
                                            }

                                            $connection = null;
                                            } catch(PDOException $e) { 
                                              die('Erreur : '.$e->getMessage());
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="delClasse" class="button delete">Supprimer</button>
                        </form>
                    </div>

                    <div class="one_form">
                        <form action="" method="post">
                            <h2>Sélectionner vos Classes</h2>
                            <div class="select_classes">
                                <p>
                                    <?php
                                    try {
                                        //OUVERTURE DE LA CONNEXION A LA BASE DE DONNEES 
                                        $connection = new PDO(
                                        "mysql:host=localhost;dbname=projetweb",
                                        "root",
                                        ""
                                        );
                                        $query = "SELECT * FROM classes";
                                        $data = $connection->query($query)->fetchAll();
                                        foreach($data as $row){
                                            echo '<p><input type="checkbox" name="classes[]" value=' .$row['id'] . '><label>' . $row['name'] .'</label></p>';
                                        }

                                        $connection = null;
                                    } catch(PDOException $e) { 
                                        die('Erreur : '.$e->getMessage());
                                    }
                                    ?>
                                </p>
                            </div>
                            <button type="submit" name="selecClasse" class="button">Valider</button>
                        </form>
                    </div>

                    <div class="classlist">
                        <h2>Visionner une Classe</h2>
                        <div>
                            <label for="class">Classe :</label>
                            <div class="select">
                                <select onchange="salut()" name="classV" id="class" required>
                                    <option value="" selected>---</option>
                                    <?php
                                    try {
                                        //OUVERTURE DE LA CONNEXION A LA BASE DE DONNEES 
                                        $connection = new PDO(
                                        "mysql:host=localhost;dbname=projetweb",
                                        "root",
                                        ""
                                        );
                                        $query = "SELECT * FROM `classes` WHERE `id` in (SELECT class_id FROM `teachersclasses` WHERE teacher_id = " . $_SESSION['id'] .") ";
                                        $data = $connection->query($query)->fetchAll();
                                        foreach($data as $row){
                                            echo '<option value=' .$row['id'] . '>' . $row['name'] .'</option>';
                                        }

                                        $connection = null;
                                    } catch(PDOException $e) { 
                                        die('Erreur : '.$e->getMessage());
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Photo</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Carbonnier</td>
                                    <td>Nicolas</td>
                                    <td><img src="photos/carbonni1u.jpg"></td>
                                    <td><button class="button delete">Supprimer</button></td>
                                </tr>
                                <tr>
                                    <td>Minger</td>
                                    <td>Nathan</td>
                                    <td><img src="photos/minger3u.jpg"></td>
                                    <td><button class="button delete">Supprimer</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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

            //L'utilisateur appuie sur le bouton d'ajout de classe
            if (isset($_POST['ajoutClasse'])){
                $classname = $_POST['classname'];

                //Ajoute la classe dans la table "classes"
                $query = "INSERT INTO classes (name) VALUES (:classname)";
                $inscr = $connection->prepare($query);
                $inscr->bindValue(":classname", $classname, PDO::PARAM_STR);
                $inscr->execute();

                //On récupère l'ID de la classe qui vient d'être créée
                $query = "SELECT * FROM classes WHERE `name` = :classname";
                $conn = $connection->prepare($query);
                $conn->bindValue(":classname", $classname, PDO::PARAM_STR);
                $conn->execute();    
                $class = $conn->fetch();
                if($conn->rowCount()>0){
                    $class_id = $class['id'];
                }

                //Ajoute le lien prof/classe dans la table teachersclasses
                $query = "INSERT INTO teachersclasses (teacher_id, class_id) VALUES (:teacher_id, :class_id)";
                $inscr = $connection->prepare($query);
                $inscr->bindValue(":teacher_id", $_SESSION['id'], PDO::PARAM_STR);
                $inscr->bindValue(":class_id", $class_id, PDO::PARAM_STR);
                $inscr->execute();

            } else if(isset($_POST['selecClasse'])){
                if ($_POST['classes'] && !empty($_POST['classes'])){
                    $Col_Array = $_POST['classes'];
                    foreach($Col_Array as $selectValue){
                        $query = "INSERT INTO teachersclasses (teacher_id, class_id) VALUES (:teacher_id, :class_id)";
                        $inscr = $connection->prepare($query);
                        $inscr->bindValue(":teacher_id", $_SESSION['id'], PDO::PARAM_STR);
                        $inscr->bindValue(":class_id", $selectValue, PDO::PARAM_STR);
                        $inscr->execute();
                    }
                }

            } else if(isset($_POST['delClasse'])){

                $query = "DELETE FROM `teachersclasses` WHERE `class_id`= :id";
                    $modif = $connection->prepare($query);
                    $modif->bindvalue(":id", $_POST['classD'], PDO::PARAM_STR);
                    $modif->execute();

                $query = "DELETE FROM `studentsclasses` WHERE `class_id`= :id";
                    $modif = $connection->prepare($query);
                    $modif->bindvalue(":id", $_POST['classD'], PDO::PARAM_STR);
                    $modif->execute();

                $query = "DELETE FROM `classes` WHERE `id`= :id";
                    $modif = $connection->prepare($query);
                    $modif->bindvalue(":id", $_POST['classD'], PDO::PARAM_STR);
                    $modif->execute();

            } else if(isset($_POST['ajoutEtu'])){

                $filename = $_FILES['image']['name'];
                $tempname = $_FILES['image']['tmp_name'];

                $query = 'INSERT INTO `students`(`lastname`, `firstname`, `photo`) VALUES (:lastname, :firstname, :photo)';
                $insert = $connection->prepare($query);
                $insert->bindValue(":lastname", $_POST['name'], PDO::PARAM_STR);
                $insert->bindValue(":firstname", $_POST['firstname'], PDO::PARAM_STR);
                $insert->bindValue(":photo", $filename, PDO::PARAM_STR);
                $insert->execute();

                //On récupère l'ID de l'étudiant qui vient d'être créée
                //On se base sur le lien de la photo car deux étudiants pourraient avoir le même nom ou prénom
                $query = 'SELECT * FROM students WHERE `photo` = :photo';

                $conn = $connection->prepare($query);
                $conn->bindValue(":photo", $filename, PDO::PARAM_STR);
                $conn->execute();    
                $stud = $conn->fetch();
                if($conn->rowCount()>0){
                    $stud_id = $stud['id'];
                }

                $query = "INSERT INTO `studentsclasses`(`student_id`, `class_id`) VALUES (:student_id, :class_id)";
                $insert = $connection->prepare($query);
                $insert->bindValue(":student_id", $stud_id, PDO::PARAM_STR);
                $insert->bindValue(":class_id", $_POST['classA'], PDO::PARAM_STR);
                $insert->execute();

                if(isset($filename)){
                    if(!empty($filename)){
                        $location = "photos/";
                        move_uploaded_file($tempname, $location.$filename);
                    }
                }
            }

        $connection = null;
        } catch(PDOException $e) { 
            die('Erreur : '.$e->getMessage());
        }

        ?>
        </footer>

        <script src="app.js"></script>
    </body>
</html>