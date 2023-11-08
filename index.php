<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accueil | MMI LAN</title>
    <link rel="stylesheet" href="./assets/style/index.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>

<body>
    <header>
        <div class="header-container">
            <div class="count-down">
                <h1>MMI LAN</h1>
                <div class="count-down-timer"></div>

                <button class="cta-button">Inscrivez-vous</button>
            </div>
        </div>
    </header>

    <main>
        <section class="teaser-container">
            <div class="teaser">
                <iframe src="https://www.youtube.com/embed/AuoUHzb4kRs" allowfullscreen></iframe>
            </div>
        </section>

        <section class="sponsors">
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
                    <div class="lan-explanation-text">Texte d’explication de la LAN</div>
                    <div class="description-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa
                        mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula
                        consectetur, ultrices mauris. Maecenas vitae mattis tellus. Nullam quis imperdiet augue.
                        Vestibulum auctor ornare leo, non suscipit magna interdum eu. Curabitur pellentesque nibh nibh,
                        at maximus ante fermentum sit amet. <br> <br>

                        Pellentesque commodo lacus at sodales sodales. Quisque sagittis orci ut diam condimentum, vel
                        euismod erat placerat. In iaculis arcu eros, eget tempus orci facilisis id.Lorem ipsum dolor sit
                        amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit
                        amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus.
                        <br><br>

                        Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna interdum eu.
                        Curabitur pellentesque nibh nibh, at maximus ante fermentum sit amet. Pellentesque commodo lacus
                        at sodales sodales. Quisque sagittis orci ut diam condimentum, vel euismod erat placerat. In
                        iaculis arcu eros, eget tempus orci facilisis id.
                    </div>
                </div>
                <div class="navigation-buttons-container">
                    <a href="#" class="navigation-button registration-button">
                        <div class="icon-box"><img src="assets/img/Vector.svg" alt=""></div>
                        <div class="button-label">Inscription</div>
                    </a>

                    <a href="#" class="navigation-button carpooling-button">
                        <div class="icon-box"><img src="assets/img/Vector.svg" alt=""></div>
                        <div class="button-label">Co-voiturage</div>
                    </a>

                    <a href="#" class="navigation-button faq-button">
                        <div class="icon-box"><img src="assets/img/Vector.svg" alt=""></div>
                        <div class="button-label">FAQ</div>
                    </a>
                </div>
            </div>
        </section>






        <section class="social-media">
            <div class="follow-us">
                Pour rester informé, suivez-nous sur nos réseaux sociaux !
            </div>
            <ul class="social-medias-listing">


                <li class="social-wrapper">
                    <a href="" class="social-link">
                        <img src="" alt="Logo TikTok" class="social-img" />
                    </a>
                </li>

                <li class="social-wrapper">
                    <a href="" class="social-link">
                        <img src="" alt="instagram-logo" class="social-img" />
                    </a>
                </li>
                <li class="social-wrapper">
                    <a href="" class="social-link">
                        <img src="" alt="youtube-logo" class="social-img" />
                    </a>
                </li>
                <li class="social-wrapper">
                    <a href="" class="social-link">
                        <img src="" alt="twitter-logo" class="social-img" />
                    </a>
                </li>
                <li class="social-wrapper">
                    <a href="" class="social-link">
                        <img src="" alt="discord-logo" class="social-img" />
                    </a>
                </li>

            </ul>
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
                <div class="twitch-embed"></div>
            </div>
        </section>
    </main>

    <footer>

    </footer>

    <!-- JS files -->
    <script src="assets/js/countDown.js"></script>
    <script src="https://player.twitch.tv/js/embed/v1.js"></script>
    <script src=" assets/js/twitchPlayer.js"></script>
</body>

</html>