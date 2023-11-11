<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="./assets/style/inscription.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>
    <header>
    </header>
    <div class="count-down-timer">
    </div>
    <main>
        <div>
            <div id="title">
                <h1>Inscription</h1>
                <h2>Rejoignez-nous ici !</h2>
            </div>
            <div id="form">

                <!--je me questionne sur quoi mettre en action du form-->

                <form action="#" method="post">
                    <div>
                        <div>
                            <div class="double_inp">
                                <input type="text" placeholder="Entrer votre nom" name="nom" required>
                                <input type="text" placeholder="Entrer votre prénom" name="prenom" required>
                            </div>
                            <div class="simple_inp">
                                <input type="text" placeholder="Entrer votre pseudo" name="pseudo" required>
                            </div>
                            <div class="simple_inp">
                                <input type="email" placeholder="Entrer votre email" name="email" required>
                            </div>
                            <div class="double_inp">
                                <input type="password" placeholder="Entrer votre mot de passe" name="mdp1" required>
                                <input type="password" placeholder="Confirmer votre mot de passe" name="mdp2" required>
                            </div>
                            <p id="config_psw">
                                Le mot de passe doit contenir : <br>
                                8 caractères, 1 caractère en minuscule, 1 caractère en majuscule, 1 chiffre
                            </p>
                            <div class="radio">
                                <div>
                                    <input type="radio" name="setup" value="PC portable" id="portable" required>
                                    <label for="portable">PC portable</label><br>
                                </div>
                                <div>
                                    <input type="radio" name="setup" value="PC fixe" id="fixe" required>
                                    <label for="fixe">PC fixe</label><br>
                                </div>
                            </div>
                            <div class="radio">
                                <div>
                                    <input type="radio" name="role" class="role" value="Participant" id="participant">
                                    <label for="participant">Participant</label><br>
                                </div>
                                <div>
                                    <input type="radio" name="role" class="role" value="Spectateur" id="spectateur">
                                    <label for="spectateur">Spectateur</label>
                                </div>
                            </div>
                            <div class="simple_inp">
                                <select name="favjeu" id="select_jeu">
                                    <option value="">Choississez votre jeu favoris</option>
                                    <option value="Track Mania: Nation Forever">Track Mania: Nation Forever</option>
                                    <option value="Geo Guesseur">Geo Guesseur</option>
                                    <option value="Overwatch">Overwatch</option>
                                    <option value="Brawlhalla">Brawlhalla</option>
                                    <option value="CS GO">CS GO</option>
                                    <option value="Rocket League">Rocket League</option>
                                    <option value="Mario Kart">Mario Kart</option>
                                </select>
                            </div>
                            <div id="fin_form">
                                <div>
                                    <input type="checkbox" name="souvenir" id="souvenir">
                                    <label for="souvenir">Se souvenir de moi</label>
                                </div>
                                <a href="#">Se connecter ?</a>
                            </div>
                        </div>
                        <div id="choix_ava">
                            <div>
                                <h3>Choisissez votre avatar</h3>
                                <div id="liste_ava">
                                    <svg id="pre" xmlns="http://www.w3.org/2000/svg" width="13" height="25" viewBox="0 0 13 25" fill="none">
                                        <path d="M11.5 1L0 12.5L11.5 24" stroke="white" stroke-width="2"/>
                                    </svg>
                                    <div class="avatar">

                                        <!--toutes les img sont à changé par celles de la base de donnée-->

                                        <div class="avatar-option prem">
                                            <img src="./assets/img/ava1.gif" alt="" >
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/ava2.gif" alt="" >
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/ava1.gif" alt="" >
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/ava1.gif" alt="" >
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/ava1.gif" alt="" >
                                        </div>
                                        <div class="avatar-option prem">
                                            <img src="./assets/img/ava1.gif" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/ava1.gif" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/ava1.gif" alt="" >
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/ava1.gif" alt="">
                                        </div>
                                        <div class= "avatar-option sec">
                                            <img src="./assets/img/ava1.gif" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/ava1.gif" alt="">
                                        </div>
                                        <div class="avatar-option sec">
                                            <img src="./assets/img/ava1.gif" alt="">
                                        </div>
                                    </div>
                                    <svg id="next" xmlns="http://www.w3.org/2000/svg" width="13" height="25" viewBox="0 0 13 25" fill="none">
                                        <path d="M1 24L12.5 12.5L1 1" stroke="white" stroke-width="2"/>
                                    </svg>
                                </div>

                                <!--Input qui prend comme valeur la src de l'image sur laquelle l'utilisateur à cliquer-->

                                <input type="hidden" name="avatar" id="avatar" value="">
                            </div>
                        </div>
                    </div>
                    <input type="submit" id="submit" value="Inscription">
                </form>
            </div>
        </div>
    </main>
<script src="./assets/js/countDown.js"></script>
<script src="./assets/js/jeu_fav.js"></script>
<script src="./assets/js/gallerie_avatar.js"></script>
</body>
</html>
