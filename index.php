<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accueil - MMI LAN</title>
    <link rel="stylesheet" href="./assets/style/index.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon">
</head>

<body>
    <?php
    include 'navbar.php';

    ?>
    <header>
        <div class="header-container">
            <div class="count-down">
                <h1 class="title-mmilan">MMI LAN</h1>
                <div class="count-down-timer"></div>

                <!-- <a href="./inscription.php" class="cta-button">Inscrivez-vous</a> -->
            </div>
        </div>
    </header>

    <main>
        <img src="./assets/img/homepage_pattern.svg" alt="" class="background-pattern">
        <section class="teaser-container">
            <div class="teaser">
                <iframe src="https://www.youtube.com/embed/O59B8-AmZLA?si=oAptY_z1HKfgUVEQ"></iframe>
            </div>
        </section>

        <section class="sponsors hidden-content">
            <h2>Avec le soutien de</h2>
            <div class="logo-container">
                <img src="assets/img/logo-univ-toulon.png" alt="Université de Toulon" class="sponsor-logo">
                <img src="assets/img/logo-univ-toulon.png" alt="Université de Toulon" class="sponsor-logo">
                <img src="assets/img/logo-univ-toulon.png" alt="Université de Toulon" class="sponsor-logo">
                <img src="assets/img/logo-univ-toulon.png" alt="Université de Toulon" class="sponsor-logo">
                <img src="assets/img/logo-univ-toulon.png" alt="Université de Toulon" class="sponsor-logo">
                <img src="assets/img/logo-univ-toulon.png" alt="Université de Toulon" class="sponsor-logo">
            </div>
        </section>

        <section class="about-section">
            <div class="about-content-container">
                <div class="explanation-text-container">
                    <div class="lan-explanation-text">C'est quoi la MMI LAN ?</div>
                    <div class="description-text">La <span class="colored-words">MMI LAN</span> est un événement centré
                        sur le jeu vidéo, organisé par des MMI pour des MMI !Elle se présente sous la forme d’un
                        <span class="colored-words">tournoi</span> dans lequel des équipes de
                        <span class="colored-words">trois joueurs </span> se réunissent et s'affrontent au travers de
                        plusieurs jeux vidéo tout au long d’une <span class="colored-words">journée</span>.
                        Que vous soyez un pro ou un débutant, cet événement est l’occasion de passer un moment de
                        <span class="colored-words">convivialité</span> placé sous le signe de la
                        <span class="colored-words">compétition</span>.
                        <br><br>
                        Des <span class="colored-words">récompenses</span> seront à gagner à l’issue du tournoi pour
                        gratifier les efforts des équipes gagnantes.
                        <br><br>
                        Si la compétition n’est pas votre domaine, et que vous voulez simplement
                        <span class="colored-words">profiter d’une ambiance conviviale</span>, vous êtes également au
                        bon endroit ! Des <span class="colored-words">activités</span> et
                        <span class="colored-words">points de restauration</span>
                        seront à votre disposition sur le lieu de l’événement, afin que chacun puisse profiter de cette
                        journée à leur façon.
                        <br>
                        La compétition sera retransmise <span class="colored-words">en direct sur
                            <a href="https://www.twitch.tv/lanmmi" class="twitch-link" target="_blank">
                                la chaîne Twitch</a>
                        </span> de l’événement, vous pourrez donc suivre le déroulé de la LAN sans vous déplacer.
                    </div>
                </div>
                <div class="navigation-buttons-container">
                    <a href="#" class="navigation-button registration-button">
                        <div class="button-label">
                            <h3 id="play_button">Jouer à Shard'Venture</h3>
                        </div>
                        <div class="icon-box"><img src="assets/img/Vector.svg" alt=""></div>
                    </a>

                    <a href="./covoiturage.php" class="navigation-button carpooling-button">
                        <div class="button-label">
                            <h3>Co-voiturage</h3>
                        </div>
                        <div class="icon-box"><img src="assets/img/Vector.svg" alt=""></div>
                    </a>

                    <a href="./faq.php" class="navigation-button faq-button">
                        <div class="button-label">
                            <h3>FAQ</h3>
                        </div>
                        <div class="icon-box"><img src="assets/img/Vector.svg" alt=""></div>
                    </a>
                </div>
            </div>
        </section>

        <div class="animated-banner">
            <div class="space-invaders" id="group1">
                <img src="./assets/img/space-invaders.png" alt="space invader" class="space-invader">
                <img src="./assets/img/space-invaders.png" alt="space invader" class="space-invader">
                <img src="./assets/img/space-invaders.png" alt="space invader" class="space-invader">
            </div>
            <div class="space-invaders" id="group2">
                <img src="./assets/img/space-invaders.png" alt="space invader" class="space-invader">
                <img src="./assets/img/space-invaders.png" alt="space invader" class="space-invader">
                <img src="./assets/img/space-invaders.png" alt="space invader" class="space-invader">
            </div>
            <div class="space-invaders" id="group3">
                <img src="./assets/img/space-invaders.png" alt="space invader" class="space-invader">
                <img src="./assets/img/space-invaders.png" alt="space invader" class="space-invader">
                <img src="./assets/img/space-invaders.png" alt="space invader" class="space-invader">
            </div>
        </div>
        <section class="social-media">
            <div class="follow-us">
                Pour rester informé, suivez-nous sur nos réseaux sociaux !
            </div>
            <ul class="social-medias-listing">
                <li class="social-wrapper">
                    <a href="https://www.tiktok.com/@mmi.lan" class="social-link tiktok-link" target="_blank">
                        <img id="tiktok-logo" src="./assets/img/tiktok-logo.svg" alt="Logo TikTok"
                            class="social-logo" />
                        <img id="tiktok-logo-hover" src="./assets/img/tiktok-logo-hover.svg" alt="tiktok-logo-hover"
                            class="social-logo" />
                    </a>
                </li>

                <li class="social-wrapper">
                    <a href="https://www.instagram.com/mmi_lan2023/" class="social-link instagram-link" target="_blank">
                        <img id="instagram-logo" src="./assets/img/insta-logo.svg" alt="instagram-logo"
                            class="social-logo" />
                        <img id="instagram-logo-hover" src="./assets/img/insta-logo-hover.svg"
                            alt="instagram-logo-hover" class="social-logo" />
                    </a>
                </li>
                <li class="social-wrapper">
                    <a href="https://www.youtube.com/@MMILAN_2023" class="social-link ytb-link" target="_blank">
                        <img id="ytb-logo" src=" ./assets/img/yt-logo.svg" alt="youtube-logo" class="social-logo" />
                        <img id="ytb-logo-hover" src="./assets/img/ytb-logo-hover.svg" alt="ytb-logo-hover"
                            class="social-logo" />
                    </a>
                </li>
                <li class="social-wrapper">
                    <a href="https://twitter.com/MMI_LAN_2023" class="social-link twitter-link" target="_blank">
                        <img id="twitter-logo" src="./assets/img/twitter-logo.svg" alt="twitter-logo"
                            class="social-logo" />
                        <img id="twitter-logo-hover" src="./assets/img/twitter-logo-hover.svg" alt="twitter-logo-hover"
                            class="social-logo" />
                    </a>
                </li>
                <li class="social-wrapper">
                    <a href="https://discord.gg/uPFq4y96vy" class="social-link discord-link" target="_blank">
                        <img id="discord-logo" src="./assets/img/discord-logo.svg" alt="discord-logo"
                            class="social-logo" />
                        <img id="discord-logo-hover" src="./assets/img/discord-logo-hover.svg" alt="discord-logo-hover"
                            class="social-logo" />
                    </a>
                </li>
            </ul>
            <div class="help-text">Vous recherchez une équipe, un covoiturage ou simplement des informations
                supplémentaires ? Rejoignez notre Discord où vous trouverez tout ce dont vous avez besoin. Nous sommes
                là pour faciliter votre expérience et répondre à toutes vos questions.</div>
        </section>



        <section class="twitch-preview">
            <div class="countdown" id="twitch-section">
                <div class="count-down-timer"></div>
                <div class="countdown-title">Avant le grand jour !</div>
            </div>
            <div class="twitch-livestream">
                <div class="twitch-title">
                    Retrouvez ici la retranscription live Twitch de la MMI LAN
                </div>
                <div class="twitch-embed" loading="lazy"></div>
            </div>
        </section>
    </main>

    <?php include 'footer.php' ?>

    <!-- JS files -->
    <script src="assets/js/countDown.js"></script>
    <script src="https://player.twitch.tv/js/embed/v1.js"></script>
    <script src=" assets/js/twitchPlayer.js"></script>
    <!-- Inclure p5.js -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.4.0/p5.js"></script>-->

</body>

</html>