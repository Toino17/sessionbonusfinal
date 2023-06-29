<?php 
session_start();
include("tableaufilm.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
            <h1>Panneau d'administration</h1>
            <nav>
                <ul class='ulnav'>
                    <a href="index.php"><li>Accueil</li></a>
                    <a href="index.php?page=add_film"><li>Ajoutez un film</li></a>
                    <a href="index.php?page=user"><li>Utilisateurs</li></a>
                    <a href="index.php?page=settings"><li>Paramètres</li></a>
                    <?php
                        if (empty($_SESSION)) {
                            echo '<a href="index.php?page=login"><li>Connexion</li></a>';
                        }
                        else {
                            echo '<a href="index.php?page=login"><li>Déconnexion</li></a>';
                        }
                    ?>
                </ul>
            </nav>
    </header>
    <section>
    <?php 

    if (empty($_SESSION)) {
        
    echo '<form class=\'formacceuil\' method="POST">
        <label class=\'labelid\' for="identifiant">Identifiant:</label><br></br>
        <input type="text" name="identifiant"><br></br>
        <label class =\'labelmdp\' for="password">Mot de passe:</label><br></br>
        <input type="password" name="password"><br></br>
        <input type="submit" name="seconnecter" value=\'Se connecter\'><br></br>
    </form>' ;}
    ?>
    <?php
        
    if (isset($_POST['seconnecter']) && ($_POST['identifiant']=='Tony') && ($_POST['password']=='17071996')){
        
        $_SESSION=['Nom'=>'Colonna-Cesari', 'Prenom'=>'Tony', 'Age'=> '26', 'Role'=>'Developpeur Web', 'Vosfilms'=>[]];
        echo 
            '<p class=\'attentionnote\'>Bienvenue '. $_SESSION['Prenom'] .' !</p>';
    }
    
    if (isset($_POST['seconnecter']) && (($_POST['identifiant']!=='Tony') or ($_POST['password']!=='17071996'))) {
        echo '<p class=\'pop_up_idfalse\'>Identifiants incorrects</p>';
    }

    if (!isset($_GET['page']) && !empty($_SESSION) && empty($_SESSION['Vosfilms'])){
        echo 
            '<p class=\'accueilletext\'>Bienvenue sur votre page d\'accueille!</p>';
        echo
            '<p class=\'accueilletext\'>Vous pouvez ajouter un film à votre cette page en vous rendant dans l\'onglet "Ajoutez un film".</p>';    }

    if (isset($_GET['page']) && $_GET['page']=='login' && !empty($_SESSION)){
        echo 
            '<p class=\'logouttext\'>Voulez-vous vraiment vous déconnecter?</p>
              <form class=\'formdeco\' method="post">
              <input type="submit" class=\'decobutton\' name=\'deconnexion\' value=\'Déconnexion\'>
              </form>';
        }

    if (isset($_POST['deconnexion'])) {
        session_destroy();
    }
    
    if (isset($_GET['page']) && $_GET['page']=='settings' && empty($_SESSION)){
        echo 'Vous devez être connecté pour accéder à cette page';
    }

    if (isset($_GET['page']) && $_GET['page']=='settings' && !empty($_SESSION)){
    
        echo 
            '<h2 class=\'titre_settings\'>Modification de vos paramètres:</h2><br> 
            <form method=\'POST\' class=\'formsettings\'>
            <label for="Nom">Nom: </label><input type="text" name=\'Nom\' value=\''. $_SESSION['Nom'] .'\'>
            <label for="Prenom">Prénom: </label><input type="text" name=\'Prenom\' value=\''. $_SESSION['Prenom'] .'\'>
            <label for="Age">Age: </label><input type="number" name=\'Age\' value=\''. $_SESSION['Age'] .'\'>
            <label for="Rôle">Rôle: </label><input type="text" name=\'Rôle\' value=\''. $_SESSION['Role'] .'\'>
            <input type="submit" name=\'change\' value=\'Modifier\' class=\'change_button\'>
            </form>';
    }

    if (isset($_POST['change']) && !empty($_POST['Nom']) && !empty($_POST['Prenom']) && !empty($_POST['Age']) && !empty($_POST['Rôle'])) {
        echo '<p class=\'pop_up_settings\'>Félicitation vos modifications ont bien été enregistré!</p>';
        $_SESSION['Nom']=$_POST['Nom'];
        $_SESSION['Prenom']=$_POST['Prenom'];
        $_SESSION['Age']=$_POST['Age'];
        $_SESSION['Role']=$_POST['Rôle'];

    }
    
    if (isset($_GET['page']) && $_GET['page']=='user' && empty($_SESSION)){
        echo 'Vous devez être connecté pour accéder à cette page';
    }

    if (isset($_GET['page']) && $_GET['page']=='user' && !empty($_SESSION)){
        echo 
            '<h2 class=\'titre_user\'>Informations utilisateur:</h2><br></br>
            <p class=\'name_user\'>Nom: '. $_SESSION['Nom'] .'<br>
            <p class=\'firstname_user\'>Prenom: '. $_SESSION['Prenom'] .'<br>
            <p class=\'yo_user\'>Age: '. $_SESSION['Age'] .'<br>
            <p class=\'role_user\'>Rôle: '. $_SESSION['Role'] .'';

    }
    
    if (empty($_SESSION) && (isset($_GET['page']) && ($_GET['page']=='add_film')))
        echo
            '<p>Vous devez être connecter pour ajouter un film.</p>';

    if (!empty($_SESSION) && (isset($_GET['page']) && ($_GET['page']=='add_film'))) {
        foreach ($listfilm as $film => $value) {
            echo '<form method=\'POST\' class=\'div_film_add\'<p>'. $value['name'] .'</p>';
            if (!in_array($listfilm[$film], $_SESSION['Vosfilms'])) {
                echo '<input classe=\'listed\' type=\'submit\' name=\''. $film .'1\' value=\'Ajouter à ma liste\'<br></form>';
            }
            else {
                echo '<input classe=\'outlisted\' type=\'submit\' name=\''. $film .'2\' value=\'Retirer de ma liste\'<br></form>';
            }
            if (isset($_POST[$film .'1'])) {
                if (!in_array($listfilm[$film], $_SESSION['Vosfilms'])) {
                    array_push($_SESSION['Vosfilms'],($listfilm[$film]));
                }
            }
            if (isset($_POST[$film .'2'])) {
                if (!in_array($listfilm[$film], $_SESSION['Vosfilms'])) {
                    array_push($_SESSION['Vosfilms'],($listfilm[$film]));
                }
            }
        }
    }

    // if (!in_array($listfilm[$film], $_SESSION['Vosfilms'])) {
        
    // }
    
    if (!empty($_SESSION) && (!isset($_GET['page']))) {
       echo '<section class=\'section_card\'>';
       foreach ($_SESSION['Vosfilms'] as $key) {
        echo     
                    '<div class=\'card\'>
                    <p class=\'title\'>Film: '. $key['name'] .'</p>
                    <div class=\'img_card\'><img src="'. $key['img'] .'" alt="#"></div>
                    <p class=\'date\'>Date de sortie: '. $key['date'] .'</p>
                    <p class=\'realisateur\'>Réalisateur: '. $key['realisateur'] .'</p>
                    <p class=\'duree\'>Durée: '. $key['duree'] .'</p>
                    <p class=\'genre\'>Genre: '. $key['genre'] .'</p>
                    <p class=\'synopsis\'>Synopsis: '. $key['synopsis'] .'</p>
                    <p class=\'bandeannonce\'>Bande-annonce: '. $key['bandeannonce'] .'</p>
                    </div>'
                ;
        }
        echo '</section>';
    }
         
            
        
        
    

    ?>
    </section>
<div>
</div>
</body>
</html>