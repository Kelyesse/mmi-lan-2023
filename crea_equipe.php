<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'équipe</title>
    <link rel="stylesheet" href="./assets/style/crea_equipe.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>
    <header>
    </header>
    <div class="count-down-timer">
        
    </div>
    <main>
        <div>
            <div id="titre">
                <h1>Création d'équipe</h1>
                <h2>Créer votre propre équipe !</h2>
            </div>
            <div id="formulaire">
                <form action="">
                    <input type="text" placeholder="Nom de l'équipe" name="nom" id="nom">
                    <input type="file" placeholder="Image du logo de l'équipe" name="img_equipe" id="img_equipe">
                    <select name="joueur_un" id="joueur_un">
                        <option value="">Ajouter un joueur</option>
                        <option value="joueur1">joueur1</option><!--importer joueurs depuis bdd-->
                        <option value="joueur2">joueur2</option><!--importer joueurs depuis bdd-->
                    </select>
                    <select name="joueur_deux" id="joueur_deux">
                        <option value="">Ajouter un deuxieme joueur</option>
                        <option value="joueur 1">joueur 1</option> <!--importer joueurs depuis bdd-->
                        <option value="joueur 2">joueur 2</option> <!--importer joueurs depuis bdd-->
                    </select>
                    <textarea placeholder="Écrire une description de l’équipe (x caractères maximum)" name="desc_equipe" id="desc_equipe" cols="30" rows="10"></textarea>
                    <textarea placeholder="Écrire une description de vous (x caractères maximum)" name="desc_createur" id="desc_createur" cols="30" rows="10"></textarea>
                    <input type="submit" id="submit" value="Rejoindre l’aventure">
                </form>
            </div>
        </div>
    </main>
<script src="./assets/js/countDown.js"></script>
<script src="./assets/js/joueur2.js"></script>
</body>
