<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST["email"];
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $sexe = $_POST["sexe"];
    $datenaiss = $_POST["datenaiss"];
    $lieunaiss = $_POST["lieunaiss"];
    $phone = $_POST["phone"];
    $titre = $_POST["titre"];
    $domaine = $_POST["domaine"];
    $niveau = $_POST["niveau"];
    $classe = $_POST["classe"];

    // Traiter les fichiers téléchargés
    $cvFileName = $_FILES["cv"]["name"];
    $cvTmpName = $_FILES["cv"]["tmp_name"];
    $propositionsFileName = $_FILES["propositions"]["name"];
    $propositionsTmpName = $_FILES["propositions"]["tmp_name"];

    var_dump($_POST["email"]);
    die();
    // Définir les dossiers de destination
    $cvUploadDirectory = "LESCV/";
    $propositionsUploadDirectory = "PROPOSITIONS/";

    // Déplacer les fichiers téléchargés vers les dossiers de destination
    move_uploaded_file($cvTmpName, $cvUploadDirectory . $cvFileName);
    move_uploaded_file($propositionsTmpName, $propositionsUploadDirectory . $propositionsFileName);

    // Connexion à la base de données (à adapter avec vos propres informations)
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'bdSujetMemoire';

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Créer la requête SQL
    $sql = "INSERT INTO utilisateurs (email, prenom, nom, sexe, datenaiss, lieunaiss, phone, titre, domaine, niveau, classe, cv, propositions) 
            VALUES ('$email', '$prenom', '$nom', '$sexe', '$datenaiss', '$lieunaiss', '$phone', '$titre', '$domaine', '$niveau', '$classe', '$cvFileName', '$propositionsFileName')";

    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {
        // Rediriger ou afficher un message de confirmation
        header("Location: index.html");
        exit();
    } else {
        echo "Erreur lors de l'insertion des données : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
