<?php
require_once 'connexion.php';
require_once 'fonctions.php';

if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $erreur = "ID de propriété non valide.";
} else {
    $id_propriete = $_GET['id'];
    $propriete = getProprieteById($id_propriete);
    $agent = $propriete ? getAgentByProprieteId($id_propriete) : null;
    $photo_principale = $propriete['photo_principale'] ?: 'assets/images/placeholder.jpg';
    $photo_galerie = explode(',', $propriete['photo_galerie'] ?: '');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche Propriété</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-img-top { height: 300px; object-fit: cover; }
        .gallery-img { height: 100px; object-fit: cover; margin: 5px; }
        .btn-custom { background: #dc3545; color: white; }
        .agent-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; }
        .price { font-size: 1.5rem; font-weight: bold; color: #dc3545; }
        .badge { background: #dc3545; }
    
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

        <?php if ($propriete) { ?>
            <div class="row">
                <section class="col-md-8">
                    <article class="card">
                        <div class="card-body">
                            <h1 class="card-title"><?php echo $propriete['adresse']; ?> <span class="badge">For Sale</span></h1>
                            <p class="text-muted"><?php echo $propriete['ville']; ?></p>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h2 class="price">$<?php echo number_format($propriete['prix'], 2, '.', ','); ?></h2>
                                    <p>$1,200/sq ft</p>
                                </div>
                                <div>
                                    <button class="btn btn-custom">Schedule a Tour</button>
                                </div>
                            </div>
                            <hr>
                            <h3>Gallery</h3>
                            <div class="d-flex">
                                <img src="<?php echo $photo_principale; ?>" class="card-img-top" alt="Main Image">
                                <div>
                                    <?php foreach (array_slice($photo_galerie, 0, 3) as $photo) { ?>
                                        <img src="<?php echo $photo; ?>" class="gallery-img" alt="Gallery Image">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </article>
                </section>
                <aside class="col-md-4">
                    <article class="card">
                        <div class="card-body text-center">
                            <h2>Agent Information</h2>
                            <img src="<?php echo $agent && $agent['photo_agent'] ? $agent['photo_agent'] : 'assets/images/default-agent.jpg'; ?>" class="agent-img mb-3" alt="Agent Photo">
                            <h3><?php echo $agent ? $agent['nom'] . ' ' . $agent['prenom'] : 'N/A'; ?></h3>
                            <p>Agent of Property</p>
                            <p><i class="bi bi-geo-alt"></i> <?php echo $agent ? $agent['adresse'] : 'N/A'; ?></p>
                            <p><i class="bi bi-telephone"></i> <?php echo $agent ? $agent['telephone'] : 'N/A'; ?></p>
                            <p><i class="bi bi-envelope"></i> <?php echo $agent ? $agent['email'] : 'N/A'; ?></p>
                            <button class="btn btn-custom w-100">Request Inquiry</button>
                        </div>
                    </article>
                </aside>
            </div>
        <?php } else { ?>
            <section>
                <div class="alert alert-warning text-center">Propriété non trouvée.</div>
            </section>
        <?php } ?>
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
