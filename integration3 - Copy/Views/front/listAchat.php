<?php
// Inclure les fichiers nécessaires pour la gestion des achats
include 'C:\xampp4\htdocs\integration3\controller\achatA.php';

// Instancier l'objet AchatManager pour récupérer les achats avec l'image du pack
$achatManager = new AchatManager();
$achats = $achatManager->showAchatWithImage(); // Récupérer les achats avec le pack et l'image

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="imgggg.png">
  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

  <link href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* General styles */
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      overflow: hidden;
    }

    /* Spline viewer as the background */
    .spline-viewer {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    /* Foreground content styles */
    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 20px;
      z-index: 2;
      position: relative;
    }

    .card {
      margin: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
    }

    .card img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
    }

    .card-body {
      text-align: center;
    }

    .btn {
      margin-top: 10px;
      width: 100%;
    }

    .card-title {
      font-size: 1.2rem;
      font-weight: bold;
    }

    .card-text {
      color: #555;
    }

    .actions a {
      color: #007bff;
      text-decoration: none;
      margin: 0 5px;
    }

    .actions a:hover {
      text-decoration: underline;
    }

    .text-center {
      z-index: 2;
      position: relative;
    }
  </style><style>
         /* Blue Cubic Cursor System */
    .cursor {
        position: fixed;
        width: 16px;
        height: 16px;
        background: #0077ff;
        transform: translate(-50%, -50%) rotate(45deg);
        pointer-events: none;
        z-index: 9999;
        mix-blend-mode: difference;
        transition: 
            transform 0.15s ease, 
            width 0.2s ease, 
            height 0.2s ease,
            background 0.2s ease;
        box-shadow: 0 0 10px rgba(0, 119, 255, 0.7);
    }

    .cursor-follower {
        position: fixed;
        width: 8px;
        height: 8px;
        background: #00aaff;
        transform: translate(-50%, -50%) rotate(45deg);
        pointer-events: none;
        z-index: 9998;
        transition: transform 0.3s ease;
        box-shadow: 0 0 8px rgba(0, 170, 255, 0.6);
    }

    .cursor-particle {
        position: fixed;
        width: 6px;
        height: 6px;
        background: #0066cc;
        transform: translate(-50%, -50%) rotate(45deg);
        pointer-events: none;
        z-index: 9997;
        opacity: 0;
        box-shadow: 0 0 5px rgba(0, 102, 204, 0.5);
    }

    .cursor-ring {
        position: fixed;
        width: 30px;
        height: 30px;
        border: 2px solid rgba(0, 170, 255, 0.7);
        transform: translate(-50%, -50%) scale(0) rotate(45deg);
        pointer-events: none;
        z-index: 9996;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    /* Interactive states */
    .cursor-active {
        transform: translate(-50%, -50%) scale(1.5) rotate(45deg);
        background: #00aaff;
        box-shadow: 0 0 15px rgba(0, 170, 255, 0.8);
    }

    .cursor-follower-active {
        transform: translate(-50%, -50%) scale(1.5) rotate(45deg);
        background: #0077ff;
    }

    .cursor-click {
        transform: translate(-50%, -50%) scale(0.8) rotate(45deg);
        background: #0066cc;
    }

    /* Hide default cursor */
    html, body {
        cursor: none;
    }

    /* Make sure interactive elements don't show default cursor */
    a, button, input, [data-cursor] {
        cursor: none !important;
    }
    </style>

</head>
<body>
  <div class="spline-viewer ">
  <spline-viewer url="https://prod.spline.design/UUgna2upZYWedWKa/scene.splinecode"></spline-viewer>
  </div>
  <!-- Lien pour ajouter un nouvel achat -->
  <div class="text-center my-4">
    <a href="listPack.php" class="btn btn-primary">Buy !</a>
  </div>

  <!-- Affichage des achats sous forme de cartes -->
  <div class="container">
    <?php
    // Afficher chaque achat sous forme de carte
    foreach ($achats as $achat) {
        echo '<div class="card" style="width: 18rem;">';
        // Affichage de l'image du pack
        echo '<div class="card-body">';
        echo '<h5 class="card-title">purchase' . $achat['ida'] . '</h5>';
        echo '<p class="card-text">username: ' . $achat['nom_user'] . '</p>';
        echo '<p class="card-text">Email: ' . $achat['email'] . '</p>';
        echo '<p class="card-text">Pack: ' . $achat['pack_nom'] . '</p>';
        echo '<div class="actions">';
        echo '<a href="editAchat.php?id=' . $achat['ida'] . '" class="btn btn-outline-primary">modify</a>';
        echo '</div>';
        echo '<a href="deleteAchat.php?id=' . $achat['ida'] . '" class="btn btn-outline-danger">delete</a>';
        echo '</div>';
        echo '</div>';
        
    }
    ?>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.48/build/spline-viewer.js"></script>
  <script>
   window.onload = function() {
    const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
    if (shadowRoot) {
        const logo = shadowRoot.querySelector('#logo');
        if (logo) logo.remove();
    }
}
</script>
<div class="cursor"></div>
  <div class="cursor-follower"></div>
  <div class="cursor-ring"></div>

  <div class="site-mobile-menu">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close">
        <span class="icofont-close js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div> 


<script>
    // Initialize the cubic cursor
    function initCursor() {
        const cursor = document.querySelector('.cursor');
        const follower = document.querySelector('.cursor-follower');
        const ring = document.querySelector('.cursor-ring');
        const interactiveElements = document.querySelectorAll('a, button, input, .controller-icon a, .profile-block a, .site-menu li a, .btn-secondary');
        
        let mouseX = 0, mouseY = 0;
        let posX = 0, posY = 0;
        let particleCount = 0;
        const maxParticles = 15;
        
        // Mouse move event
        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
            
            // Position main cursor immediately
            cursor.style.left = mouseX + 'px';
            cursor.style.top = mouseY + 'px';
            
            // Create trailing cube particles
            if (particleCount < maxParticles && Math.random() > 0.3) {
                createCubeParticle(mouseX, mouseY);
                particleCount++;
            }
        });
        
        // Animate follower with delay
        function animate() {
            // Smooth follower movement
            posX += (mouseX - posX) / 6;
            posY += (mouseY - posY) / 6;
            
            follower.style.left = posX + 'px';
            follower.style.top = posY + 'px';
            
            // Ring follows with more delay
            ring.style.left = posX + 'px';
            ring.style.top = posY + 'px';
            
            requestAnimationFrame(animate);
        }
        
        animate();
        
        // Create cube particle effect
        function createCubeParticle(x, y) {
            const particle = document.createElement('div');
            particle.className = 'cursor-particle';
            particle.style.left = x + 'px';
            particle.style.top = y + 'px';
            document.body.appendChild(particle);
            
            // Randomize blue shade
            const blues = ['#0077ff', '#00aaff', '#0066cc', '#0099ff'];
            const color = blues[Math.floor(Math.random() * blues.length)];
            particle.style.background = color;
            particle.style.boxShadow = `0 0 5px ${color}`;
            
            // Animate particle
            let size = Math.random() * 6 + 4;
            let life = Math.random() * 1000 + 500;
            let angle = Math.random() * Math.PI * 2;
            let speed = Math.random() * 2 + 1;
            let rotation = Math.random() * 360;
            
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.opacity = '0.9';
            
            let startTime = Date.now();
            
            function updateParticle() {
                const elapsed = Date.now() - startTime;
                const progress = elapsed / life;
                
                if (progress >= 1) {
                    particle.remove();
                    particleCount--;
                    return;
                }
                
                const moveX = Math.cos(angle) * speed * 10 * progress;
                const moveY = Math.sin(angle) * speed * 10 * progress;
                rotation += 2;
                
                particle.style.transform = `translate(-50%, -50%) translate(${moveX}px, ${moveY}px) rotate(${rotation}deg)`;
                particle.style.opacity = 0.9 * (1 - progress);
                
                requestAnimationFrame(updateParticle);
            }
            
            requestAnimationFrame(updateParticle);
        }
        
        // Hover effects
        interactiveElements.forEach(element => {
            element.addEventListener('mouseenter', () => {
                cursor.classList.add('cursor-active');
                follower.classList.add('cursor-follower-active');
                ring.style.transform = 'translate(-50%, -50%) scale(1) rotate(45deg)';
                ring.style.opacity = '0.7';
                
                // Create hover particles
                for (let i = 0; i < 3; i++) {
                    createCubeParticle(mouseX, mouseY);
                }
            });
            
            element.addEventListener('mouseleave', () => {
                cursor.classList.remove('cursor-active');
                follower.classList.remove('cursor-follower-active');
                ring.style.transform = 'translate(-50%, -50%) scale(0) rotate(45deg)';
                ring.style.opacity = '0';
            });
        });
        
        // Click effect
        document.addEventListener('mousedown', () => {
            cursor.classList.add('cursor-click');
            ring.style.transform = 'translate(-50%, -50%) scale(1.5) rotate(45deg)';
            ring.style.opacity = '0';
            ring.style.borderColor = '#0077ff';
            
            // Create click cubes
            for (let i = 0; i < 8; i++) {
                createCubeParticle(mouseX, mouseY);
            }
        });
        
        document.addEventListener('mouseup', () => {
            cursor.classList.remove('cursor-click');
        });
    }

    // Initialize cursor when page loads
    window.onload = function() {
        initCursor();
        
        const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
        if (shadowRoot) {
            const logo = shadowRoot.querySelector('#logo');
            if (logo) logo.remove();
        }
    }

    function confirmLogout() {
        return confirm('Are you sure you want to leave the website?');
    }
  </script>
</body>
</html>


