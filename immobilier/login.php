<?php
require_once 'connexion.php';
require_once 'fonctions.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $_POST['email'];
    $id_client = verifyLogin($email);
    if ($id_client) {
        $_SESSION['id_client'] = $id_client;
        $sql = "SELECT nom, prenom FROM clients WHERE id_client = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("i", $id_client);
        $stmt->execute();
        $result = $stmt->get_result();
        $client = $result->fetch_assoc();
        $_SESSION['nom'] = $client['nom'];
        $_SESSION['prenom'] = $client['prenom'];
        $stmt->close();
        header("Location: liste_proprietes.php");
        exit;
    } else {
        $erreur_login = "Email incorrect ou inexistant.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'register') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $genre = $_POST['genre'];
    $email = $_POST['email'];
    if (empty($nom) || empty($prenom) || empty($date_naissance) || empty($genre) || empty($email)) {
        $erreur_register = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur_register = "Email invalide.";
    } else {
        $result = registerClient($nom, $prenom, $date_naissance, $genre, $email);
        if ($result) {
            $message_register = "Inscription réussie ! Connectez-vous.";
        } else {
            $erreur_register = "Erreur : Email déjà utilisé.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion / Inscription</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background: #dc3545;
            color: white;
        }

        .btn-custom:hover {
            background: #c82333;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <main class="container">
        <header>
            <h1 class="text-center mb-4">Bienvenue</h1>
        </header>

        <section class="section">
            <h2 class="mb-4">Connexion</h2>
            <?php if (isset($erreur_login)) {
                echo "<div class='alert alert-danger'>$erreur_login</div>";
            } ?>
            <form method="POST" action="">
                <input type="hidden" name="action" value="login">
                <div class="mb-3">
                    <label for="email_login" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email_login" name="email" required autocomplete="email">
                </div>
                <button type="submit" class="btn btn-custom w-100">Se connecter</button>
            </form>
        </section>

        <section class="section">
            <h2 class="mb-4">Inscription</h2>
            <?php if (isset($erreur_register)) {
                echo "<div class='alert alert-danger'>$erreur_register</div>";
            } ?>
            <?php if (isset($message_register)) {
                echo "<div class='alert alert-success'>$message_register</div>";
            } ?>
            <form method="POST" action="">
                <input type="hidden" name="action" value="register">
                <div class="mb-3">
                    <label for="nom_register" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom_register" name="nom" required autocomplete="family-name">
                </div>
                <div class="mb-3">
                    <label for="prenom_register" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenom_register" name="prenom" required autocomplete="given-name">
                </div>
                <div class="mb-3">
                    <label for="date_naissance" class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <select class="form-control" id="genre" name="genre" required>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email_register" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email_register" name="email" required autocomplete="email">
                </div>
                <button type="submit" class="btn btn-custom w-100">S'inscrire</button>
            </form>
        </section>

        <footer class="text-center mt-3">
            <p>01:11 PM EAT, 18/06/2025</p>
        </footer>
    </main>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
