<!DOCTYPE html>
<html>

<head>
    <title>Facturation</title>
    <link rel="stylesheet" type="text/css" href="modification_facturation.css">
    
</head>

<body>
    <?php include '../navigation.php'; ?> 
    <div class="modification_facturation">
        
        <h1>Modification Facturation</h1>
        <?php
        session_start();
        if ($_COOKIE['acces'] == '' || $_COOKIE['acces'] == 'secretariat') {
            echo "<p>Vous n'avez pas les droits pour accéder au site, merci de faire une demande d'accès sur support@sas-nfl.fr</p>";
        } else {
            // Vérification de la session utilisateur
            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                header('Location: connexion.php');
                exit;
            }

            // Vérification des cookies utilisateur
            if (isset($_COOKIE['username'])) {
                $username = $_COOKIE['username'];
                $password = $_COOKIE['password'];
            } else {
                echo "Les cookies ne sont pas définis.";
            }

            $servername = "localhost";
            $dbname = "nfl";

            // Créer une connexion
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("La connexion a échoué : " . $conn->connect_error);
            }

            // Envoi des requêtes
            $requete1 = "SELECT DISTINCT CODE_WAVESOFT FROM client ORDER BY CODE_WAVESOFT ASC";
           

            $resultat1 = $conn->query($requete1);
       

            // Vérifier la requête 1
            if ($resultat1 === false) {
                echo "Erreur de requête MySQL : " . $conn->error;
            } else {
                // Formulaire client
                echo "<center>";
                echo "<form method='POST'>";
                echo "<select id='code_wavesoft' name='code_wavesoft' onchange='this.form.submit()'>";
                echo "<option value='firstone' selected>Choix du client</option>";

                while ($row = $resultat1->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['CODE_WAVESOFT']) . "'>" . 
                    htmlspecialchars($row['CODE_WAVESOFT']) . "</option>";
                }
                echo "</select>";
                echo "</form>";
            }

            // Afficher le nom du client
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $selectedOption = isset($_POST['code_wavesoft']) ? $_POST['code_wavesoft'] : 'Aucun choix';
                echo htmlspecialchars($selectedOption);
            }

            $requete = "SELECT c.CODE_MACHINE, c.CODE_WAVESOFT, cmp.*, t.* 
            FROM client c 
            INNER JOIN compteur cmp ON cmp.id_facturationc = cmp.id_facturationc
            INNER JOIN trimestre t ON t.id_trimestre = t.id_trimestre";

            $resultreq = $conn->query($requete);
            $requete = NULL;

            if ($resultreq === false) {
            // La requête a échoué, afficher une erreur ou faire quelque chose d'autre
            echo "Erreur de requête MySQL : " . $conn->error;
            } else {
            // Récupérer tous les enregistrements de la requête
            $requetes = $resultreq->fetch_all(MYSQLI_ASSOC);
            // Afficher les valeurs des enregistrements
             for ($i = 0; $i < count($requetes); $i++) {
                $requete = $requetes[$i];
        // Faire quelque chose avec $requete
             }
        }
                echo "<center>";
        echo "<div class='trimestres'>";
            echo "<div class='trimestre1'>";
            echo "Trimestre 1 <br>";
            echo "Ancien NB : " . $requete['trim1_OLD_NB'] . "<br>";
            echo "Nouveau NB : " . $requete['trim1_NEW_NB'] . "<br>";
            echo "Ancien Coul : " . $requete['trim1_OLD_COUL'] . "<br>";
            echo "Nouveau Coul : " . $requete['trim1_NEW_COUL'] . "<br>";
            echo "</div>";
    
            echo "<div class='trimestre2'>";
            echo "Trimestre 2 <br>";
            echo "Ancien NB : " . $requete['trim2_OLD_NB'] . "<br>";
            echo "Nouveau NB : " . $requete['trim2_NEW_NB'] . "<br>";
            echo "Ancien Coul : " . $requete['trim2_OLD_COUL'] . "<br>";
            echo "Nouveau Coul : " . $requete['trim2_NEW_COUL'] . "<br>";
            echo "</div>";
    
            echo "<div class='trimestre3'>";
            echo "Trimestre 3 <br>";
            echo "Ancien NB : " . $requete['trim3_OLD_NB'] . "<br>";
            echo "Nouveau NB : " . $requete['trim3_NEW_NB'] . "<br>";
            echo "Ancien Coul : " . $requete['trim3_OLD_COUL'] . "<br>";
            echo "Nouveau Coul : " . $requete['trim3_NEW_COUL'] . "<br>";
            echo "</div>";
    
            echo "<div class='trimestre4'>";
            echo "Trimestre 4 <br>";
            echo "Ancien NB : " . $requete['trim4_OLD_NB'] . "<br>";
            echo "Nouveau NB : " . $requete['trim4_NEW_NB'] . "<br>";
            echo "Ancien Coul : " . $requete['trim4_OLD_COUL'] . "<br>";
            echo "Nouveau Coul : " . $requete['trim4_NEW_COUL'] . "<br>";
            echo "</div>";
        echo "</div>";
       
    
        echo "<div class='container'>";
            echo "<div class='compteur'>";
            echo "Parametre <br>";
            echo "Info client : " . $requete['info_client'] . "<br>";
            echo "Info facturation client : " . $requete['info_fact'] . "<br>";
            echo "Date départ : " . $requete['date_depart'] . "<br>";
            echo "Coût copie NB: " . $requete['px_nb'] . "<br>";
            echo "Coût copie COUL: " . $requete['px_coul'] . "<br>";
            echo "Compteur depart NB: " . $requete['compt_depart_nb'] . "<br>";
            echo "Compteur depart COUL: " . $requete['compt_depart_coul'] . "<br>";
            echo "</div>";
        echo "</div>";
    echo "</div>";

                echo '<form method="post" action="traitement.php">'; 
                        echo '<input type="submit" name="valider" value="Valider">';
                        echo '</form>';
                        echo "</center>";
            }
        $conn->close();
       
        ?>
    </div>
</body> 
</html>