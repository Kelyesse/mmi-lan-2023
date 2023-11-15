<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="./assets/style/contact.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>

<body>
    <header>
        <?php
            include('navbar.php');
        ?>
    </header>
    <main>
        <div id="title">
            <h1>CONTACTEZ NOUS !</h1>
        </div>
        <section>
            <div id="info" >
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <div>
                    <h4>70 Avenue Roger Devoucoux, 83000 Toulon</h4>
                </div>
                <div>
                    <img src="./assets/img/mail.svg" alt="">
                    <h4>info@form.com</h4>
                </div>
                <div>
                    <a href="https://www.tiktok.com/@mmi.lan?is_from_webapp=1&sender_device=pc">
                        <img src="./assets/img/tiktok-logo.svg" alt="">
                    </a>
                    <a href="https://www.instagram.com/mmi_lan2023/">
                        <img src="./assets/img/insta-logo.svg" alt="">
                    </a>
                    <a href="https://www.youtube.com/@MMILAN_2023?sub_confirmation=1">
                        <img src="./assets/img/yt-logo.svg" alt="">
                    </a>
                    <a href="https://x.com/MMI_LAN_2023?s=20">
                        <img src="./assets/img/twitter-logo.svg" alt="">
                    </a>
                </div>
            </div>
            <div id="form">
                <form action="" method="post">
                    <div>
                        <div class="double-inp">
                            <input type="text" placeholder="Entrer votre nom" name="nom" required>
                            <input type="text" placeholder="Entrer votre prénom" name="prenom" required>
                        </div>
                        <div class="simple-inp">
                            <img src="./assets/img/mail.svg" alt="">
                            <input type="email" placeholder="Entrer votre email" name="email" id="email" required>
                        </div>
                        <div class="simple-inp">
                            <img src="./assets/img/profil.svg" alt="">
                            <input type="text" placeholder="Objet" name="objet" id="objet" required>
                        </div>
                        <div class="simple-inp">
                            <textarea name="" id="" cols="1000" rows="10" placeholder="Votre messages" name="message" id="message"></textarea>
                        </div>
                        <div id="sub">
                            <a href="">En nous contactant vous acceptez le RGPD</a>
                            <input type="submit" id="submit" value="envoyer">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>