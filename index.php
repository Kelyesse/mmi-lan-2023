<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accueil</title>
    <link rel="stylesheet" href="./assets/style/index.css" />
</head>

<body>
    <section id="header">
        <div class="header-container">
            <div class="count-down">
                <h1>MMI LAN</h1>
                <span id="count-down-timer"></span>
                <span class="button"> Inscrivez vous</span>
            </div>
        </div>
    </section>

    <section class="main">
        <div class="teaser-container">
            <div class="teaser">
                <!-- video intégré comme vignette -->
                <iframe src="https://www.youtube.com/watch?v=AuoUHzb4kRs/embed" allowfullscreen></iframe>
            </div>
        </div>

        <div class="partner-container">
            <h1>Avec le soutien de</h1>
            <div class="partner"></div>
        </div>
    </section>
    <section class="social-media">
        <div class="follow-us">
            Pour rester informer, suivez-nous sur nos réseaux sociaux !
        </div>
        <ul class="social-medias-listing">
            <li class="social-wrapper">
                <a href="" class="social-link">
                    <img src="" alt="tiktok-logo" class="social-img" />
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
            <!-- temporary countdown before js  -->
            <div class="countdown-display">
                <span class="time-value">30</span>
                <span class="time-unit">J</span>
                <span class="time-value">6</span>
                <span class="time-unit">H</span>
                <span class="time-value">48</span>
                <span class="time-unit">M</span>
                <span class="time-value">37</span>
                <span class="time-unit">S</span>
            </div>
            <div class="countdown-title">Avant le grand jour !</div>
        </div>
        <div class="twitch-livestream">
            <div class="twitch-title">
                Retrouvez ici la retranscription live twich de la MMI LAN
            </div>
            <div class="twitch-media"></div>
        </div>
    </section>

    <!-- JS files -->

    <script src="assets/js/countDown.js"></script>

</body>

</html>