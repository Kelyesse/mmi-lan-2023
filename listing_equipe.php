<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Equipes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <h1>LES EQUIPES DE LA MMI LAN</h1>
        <div class="tri-btn">
            Trier
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M8 10.828 1.354 4.182a1 1 0 0 1 1.414-1.414L8 8.586l5.232-5.232a1 1 0 1 1 1.414 1.414L8 10.828z"/>
            </svg>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Plus Récent</a>
                <a class="dropdown-item" href="#">Plus Ancien</a>
                <a class="dropdown-item" href="#">Ordre Alphabétique</a>
                <a class="dropdown-item" href="#">Inverse Alphabétique</a>
            </div>
        </div>
    </header>
    <div class="liste_equipe"> 

    <?php include 'listing_equipe_vignette.php' ; ?>

    </div>
    <div class="LOGO"> 

    <?php include 'listing_equipe_logo.php' ; ?>

    </div>
</body>
</html>