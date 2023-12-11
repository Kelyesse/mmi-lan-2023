<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shard'Venture - MMI LAN</title>
  <link rel="shortcut icon" href="./assets/img/favicon.png">
  <link rel="stylesheet" href="./assets/style/header.css">
  <link rel="stylesheet" href="./assets/style/game.css">
  <link rel="stylesheet" href="./assets/style/footer.css">
</head>

<body>
  <?php include './navbar.php'; ?>

  <h1 id="main-title">Découvrez notre mini-jeu !</h1>

  <h1 id="sub-title">Tentez l'aventure</h1>
  <div id="unity-container" class="unity-desktop">
    <canvas id="unity-canvas" width=1200 height=675></canvas>
    <div id="unity-loading-bar">
      <div id="unity-logo"></div>
      <div id="unity-progress-bar-empty">
        <div id="unity-progress-bar-full"></div>
      </div>
    </div>
    <div id="unity-warning"> </div>
    <div id="unity-footer">
      <div id="unity-fullscreen-button"></div>
    </div>
  </div>

  <div id="board-container">
    <div id="board-title">Classement</div>
    <div id="board">
    </div>
  </div>

  <div id="pseudo-zone">
    <div id="pseudo-zone-title">Enregistrer le score</div>
    <div id="pseudo-zone-input-container">
      <input type="text" id="pseudo-zone-input" placeholder="Entrer votre pseudo">
    </div>
    <div id="pseudo-zone-submit">Valider</div>
  </div>
  <div id="pseudo-zone-background"></div>

  <?php include './footer.php'; ?>

  <script src="./assets/js/gameLeaderboard.js"></script>
  <script src="./assets/js/gamePointerlock.js"></script>
  <script>
    var container = document.querySelector("#unity-container");
    var canvas = document.querySelector("#unity-canvas");
    var loadingBar = document.querySelector("#unity-loading-bar");
    var progressBarFull = document.querySelector("#unity-progress-bar-full");
    var fullscreenButton = document.querySelector("#unity-fullscreen-button");
    var warningBanner = document.querySelector("#unity-warning");

    // Shows a temporary message banner/ribbon for a few seconds, or
    // a permanent error message on top of the canvas if type=='error'.
    // If type=='warning', a yellow highlight color is used.
    // Modify or remove this function to customize the visually presented
    // way that non-critical warnings and error messages are presented to the
    // user.
    function unityShowBanner(msg, type) {
      function updateBannerVisibility() {
        warningBanner.style.display = warningBanner.children.length ? 'block' : 'none';
      }

      if (type == 'error') {
        var div = document.createElement('div');
        div.innerHTML = msg;
        warningBanner.appendChild(div);
        div.style = 'background: red; padding: 10px;';

      }
      else {
        if (type == 'warning') {
          var div = document.createElement('div');
          div.innerHTML = msg;
          warningBanner.appendChild(div);
          div.style = 'background: transparent; padding: 5px';

          div.innerHTML = 'Chargement...'
          setTimeout(function () {
            warningBanner.removeChild(div);
            updateBannerVisibility();
          }, 3000);
        }
      }
      updateBannerVisibility();
    }

    var buildUrl = "./assets/gameFiles";
    var loaderUrl = buildUrl + "/testSendData12.loader.js";
    var config = {
      dataUrl: buildUrl + "/testSendData12.data",
      frameworkUrl: buildUrl + "/testSendData12.framework.js",
      codeUrl: buildUrl + "/testSendData12.wasm",
      streamingAssetsUrl: "StreamingAssets",
      companyName: "DefaultCompany",
      productName: "MmiLanGameTest",
      productVersion: "0.1",
      showBanner: unityShowBanner,
    };

    // By default Unity keeps WebGL canvas render target size matched with
    // the DOM size of the canvas element (scaled by window.devicePixelRatio)
    // Set this to false if you want to decouple this synchronization from
    // happening inside the engine, and you would instead like to size up
    // the canvas DOM size and WebGL render target sizes yourself.
    // config.matchWebGLToCanvasSize = false;

    if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
      // Mobile device style: fill the whole browser client area with the game canvas:

      var meta = document.createElement('meta');
      meta.name = 'viewport';
      meta.content = 'width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, shrink-to-fit=yes';
      document.getElementsByTagName('head')[0].appendChild(meta);
      container.className = "unity-mobile";
      canvas.className = "unity-mobile";

      // To lower canvas resolution on mobile devices to gain some
      // performance, uncomment the following line:
      // config.devicePixelRatio = 1;

      unityShowBanner('WebGL builds are not supported on mobile devices.');
    } else {
      // Desktop style: Render the game canvas in a window that can be maximized to fullscreen:

      canvas.style.width = "1200px";
      canvas.style.height = "675px";
    }

    loadingBar.style.display = "block";

    var script = document.createElement("script");
    script.src = loaderUrl;
    script.onload = () => {
      createUnityInstance(canvas, config, (progress) => {
        progressBarFull.style.width = 100 * progress + "%";
      }).then((unityInstance) => {
        loadingBar.style.display = "none";
        fullscreenButton.onclick = () => {
          unityInstance.SetFullscreen(1);
        };
      }).catch((message) => {
        alert(message);
      });
    };
    document.body.appendChild(script);
  </script>
</body>

</html>
