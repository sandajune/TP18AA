
<?php
require_once 'connexion.php';
require_once 'fonctions.php';

if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id_agent']) || !is_numeric($_GET['id_agent'])) {
    $erreur = "Erreur : ID d'agent non valide.";
} else {
    $id_agent = $_GET['id_agent'];
    $agent = getAgentById($id_agent);
    $proprietes = $agent ? getProprietesByAgentId($id_agent) : [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Propriétés de l'Agent</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .navbar { background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-img-top { height: 200px; object-fit: cover; }
        .btn-custom { background: #dc3545; color: white; }
        .agent-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; }
        .price { font-size: 1.2rem; font-weight: bold; color: #dc3545; }

        .navbar-nav.d-flex .nav-link {
            margin-left: 15px;
            padding: 8px 12px;
        }
        .navbar-nav.d-flex .nav-link.dropdown-toggle {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .navbar-nav.d-flex .nav-link#logout {
            background-color: #dc3545;
            color: white !important;
            border-radius: 5px;
        }
        .navbar-nav.d-flex .nav-link#logout:hover {
            background-color: #c82333;
        }
        .navbar-nav.d-flex .nav-link#greeting {
            background-color: #28a745;
            color: white !important;
            border-radius: 5px;
        }
        .navbar-nav.d-flex .nav-link#greeting:hover {
            background-color: #218838;
        }

        footer { background-color: #343a40; color: white; padding: 20px 0; margin-top: 50px; border-top: 3px solid #dc3545; }
        footer a { color: #dc3545; text-decoration: none; }
        footer a:hover { text-decoration: underline; }
        footer .container { max-width: 1200px; }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="assets/images/logo.png" alt="FindHouses" width="30"> FindHouses
                </a>
                <div class="navbar-nav">
                    <a class="nav-link px-3" href="liste_proprietes.php">Home</a>
                    <a class="nav-link px-3" href="#">Listing</a>
                    <a class="nav-link px-3" href="#">Property</a>
                    <a class="nav-link px-3" href="#">Pages</a>
                    <a class="nav-link px-3" href="#">Blog</a>
                    <a class="nav-link px-3" href="#">Contact</a>
                </div>
                <div class="d-flex">
                    <a class="nav-link dropdown-toggle px-3" href="#" id="lang" data-bs-toggle="dropdown">ENG</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">FR</a></li>
                    </ul>
                    <a class="nav-link px-3" href="login.php?logout=1" id="logout">Sign Out</a>
                    <span class="nav-link px-3" id="greeting">Hi, <?php echo htmlspecialchars($_SESSION['prenom']); ?>!</span>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <?php if (isset($erreur)) { ?>
            <section>
                <div class="alert alert-danger text-center"><?php echo $erreur; ?></div>
            </section>
        <?php exit; } ?>

        <?php if ($agent) { ?>
            <section class="text-center mb-4">
                <img src="<?php echo $agent['photo_agent'] ? $agent['photo_agent'] : 'assets/images/default-agent.jpg'; ?>" class="agent-img mb-3" alt="Agent Photo">
                <h1>Propriétés de l'agent : <?php echo $agent['nom'] . ' ' . $agent['prenom']; ?></h1>
            </section>
        <?php } else { ?>
            <section>
                <div class="alert alert-warning text-center">Agent non trouvé.</div>
            </section>
        <?php exit; } ?>

        <section class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($proprietes)) { foreach ($proprietes as $propriete) { 
                $photo_principale = $propriete['photo_principale'] ?: 'assets/images/placeholder.jpg';
            ?>
                <article class="col">
                    <div class="card h-100">
                        <img src="<?php echo $photo_principale; ?>" class="card-img-top" alt="Property">
                        <div class="card-body text-center">
                            <h2 class="card-title"><?php echo $propriete['adresse']; ?></h2>
                            <p class="text-muted"><?php echo $propriete['ville']; ?></p>
                            <p class="price">$<?php echo number_format($propriete['prix'], 2, '.', ','); ?></p>
                            <a href="fiche_propriete.php?id=<?php echo $propriete['id_propriete']; ?>" class="btn btn-custom mt-3 w-100">View Details</a>
                        </div>
                    </div>
                </article>
            <?php } } else { ?>
                <div class="col-12">
                    <p class="text-center">Aucune propriété trouvée pour cet agent.</p>
                </div>
            <?php } ?>
        </section>
        <section class="text-center mt-4">
            <a href="liste_proprietes.php" class="btn btn-outline-secondary">Retour à la liste des propriétés</a>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>© 2025 FindHouses. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#">Accueil</a> | 
                    <a href="#">À propos</a> | 
                    <a href="#">Contact</a> | 
                    <a href="#">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
