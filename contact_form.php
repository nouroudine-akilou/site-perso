<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="accueil.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouroudine Akilou</title>
    <style>
        .section {
            padding: 2em 0;
            border-bottom: 1px solid #ddd;
        }
        .section:last-child {
            border-bottom: none;
        }
        .contact-form {
            display: flex;
            flex-direction: column;
        }
        .contact-form input, .contact-form textarea {
            margin-bottom: 1em;
            padding: 0.5em;
            border: 1px solid #ddd;
        }
        .contact-form input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

    <h2 id="titre1">Laissez un message à N.Akilou</h2>
    <div class="form_bloc">
        <section class="section" id="contact">
            <?php
            // Configuration de la base de données
            $servername = "localhost";
            $username = "root";  // Remplacez par votre nom d'utilisateur MySQL
            $password = "";  // Remplacez par votre mot de passe MySQL
            $dbname = "contact_form_db";

            // Créer une connexion
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("La connexion a échoué : " . $conn->connect_error);
            }

            $name = $message = "";
            $errors = [];

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Récupérer les données du formulaire
                $name = trim($_POST["name"]);
                $message = trim($_POST["message"]);

                // Validation du nom
                if (empty($name)) {
                    $errors[] = "Le nom et prénom sont requis.";
                } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
                    $errors[] = "Le nom et prénom ne doivent contenir que des lettres et des espaces.";
                }

                // Validation du message
                if (empty($message)) {
                    $errors[] = "Le message est requis.";
                }

                // Afficher les erreurs ou traiter les données
                if (empty($errors)) {
                    // Préparer et exécuter la requête d'insertion
                    $stmt = $conn->prepare("INSERT INTO contacts (name, message) VALUES (?, ?)");
                    $stmt->bind_param("ss", $name, $message);

                    if ($stmt->execute()) {
                        // Rediriger vers la page de remerciement
                        header("Location: merci.php");
                        exit();
                    } else {
                        echo "<p class='error'>Erreur lors de la soumission du formulaire : " . $stmt->error . "</p>";
                    }

                    // if ($stmt->execute()) {
                    //     echo "<p class='success'>Formulaire soumis avec succès !</p>";
                    //     $name = $message = ""; // Réinitialiser les champs après succès
                    // } else {
                    //     echo "<p class='error'>Erreur lors de la soumission du formulaire : " . $stmt->error . "</p>";
                    // }

                    // Fermer la déclaration
                    $stmt->close();
                }
            }

            // Fermer la connexion
            $conn->close();
            ?>

            <form class="contact-form" action="contact_form.php" method="post">
                <input type="text" name="name" placeholder="Nom et prénom" value="<?php echo htmlspecialchars($name); ?>" required>
                <textarea name="message" rows="5" placeholder="Votre message" required><?php echo htmlspecialchars($message); ?></textarea>
                <input type="submit" value="Envoyer">
            </form>

            <?php
            // Afficher les erreurs
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
            ?>
        </section>
    </div>
</body>
</html>
