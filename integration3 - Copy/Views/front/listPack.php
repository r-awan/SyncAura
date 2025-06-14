<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the PackManager class to interact with the pack data
include 'C:\xampp4\htdocs\integration3\controller\packP.php';

// Create an instance of the PackManager to fetch all packs
$PackController = new PackController();
$packs = $PackController->listPacks(); // Fetch all packs data
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>packs manager</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styleCard.css">
    <script src="https://unpkg.com/@splinetool/viewer/build/spline-viewer.js" type="module"></script>
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="imgggg.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

  <link href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">


  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

  <link rel="stylesheet" href="main/css/bootstrap.min.css">
  <link rel="stylesheet" href="main/css/animate.min.css">
  <link rel="stylesheet" href="main/css/owl.carousel.min.css">
  <link rel="stylesheet" href="main/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="flaticon.css">
  <link rel="stylesheet" href="main/style.css">
  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="main/css/aos.css">
  <link rel="stylesheet" href="main/css/style.css">
  <link rel="stylesheet" href="main/css/stylo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="imgggg.png">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <link href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <style>
    .packs-container {
    position: relative; /* Ensures it is positioned over the background */
    z-index: 10; /* Higher than the Spline viewer */
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px; /* Adds spacing between cards */
    margin-top: 50px; /* Adjust as needed */
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8); /* Slight background to improve readability */
    border-radius: 15px; /* Rounded corners for modern design */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    transition: box-shadow 0.3s ease-in-out; /* Smooth shadow transition */
}

.pack-card {
    position: relative;
    z-index: 11; /* Ensures cards are individually above the container */
    width: 300px; /* Larger card width for better visibility */
    padding: 15px;
    background-color: #fff; /* White background for clarity */
    border: 1px solid #ddd;
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease-in-out;
}

.pack-card img {
    max-width: 100%;
    border-radius: 10px; /* Rounded corners on images */
}

.pack-card:hover {
    transform: translateY(-5px); /* Hover effect for better UI */
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2); /* Increase shadow effect on hover */
}

.button-link {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background: linear-gradient(90deg, #007bff, #00aaff); /* Blue-to-white gradient */
    border-radius: 8px; /* Rounded corners */
    border: none;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease-in-out;
    text-decoration: none;
}
  </style>

<style>
.site-navigation {
  background: linear-gradient(to right, #1d3557, #457b9d);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  position: fixed;
  top: 0;
  margin:0px;
  left:0;
  display:flex;
  justify-content: space-between !important;
  padding:0px;
  width: 100%;
  height: 12%;
  z-index: 1000;
  font-family: 'Inter', sans-serif;
  opacity: 90%;
  padding-top: 25px;
  padding-left: 50px;
}
.site-navigation ul{
  padding-left:180px;
}
.syncaura-logo {
   position: absolute;
  top: 5px; /* Moved further to the left */
  z-index: 1001; /* Ensures visibility above other elements */
  font-size: 1.5rem;
  margin-top: 15px;
  color: #fff;
}
.user-info {
  position: absolute;
  right: 30px;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  align-items: center;
  gap: 20px;
}
.logout-btn {
  display: inline-block;
  background: linear-gradient(to right, #1E90FF, #457b9d);
  padding: 10px 24px;
  font-size: 16px;
  color: #fff;
  border-radius: 30px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  text-decoration: none;
  margin: 0;
  font-weight: bold;
  letter-spacing: 1px;
}
.logout-btn:hover {
  background: linear-gradient(to right, #457b9d, #1E90FF);
  transform: scale(1.08);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}
.username {
  font-size: 18px;
  color: #fff;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
  margin-bottom: 0;
  font-weight: 600;
}
.controller-icon {
  position: fixed;
  margin-bottom: 100px;
  bottom: 20px;
  right: 20px;
  z-index: 10;
  display: flex;
  flex-direction: column;
  gap: 15px;
  background-color: rgba(0, 123, 255, 0.8);
  padding: 10px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.profile-block {
  display: flex;
  align-items: center;
  gap: 10px;
  background: transparent;
  padding: 0;
  color: #fff;
  font-size: 14px;
}
.profile-block img {
  border-radius: 50%;
  width: 40px;
  height: 40px;
  object-fit: cover;
  border: 2px solid #fff;
}
.profile-block h2 {
  font-size: 14px;
  margin: 0;
  color: #fff;
}
.controller-icon a {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: rgba(0, 123, 255, 0.8);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.controller-icon a:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}
.controller-icon i {
  color: #fff;
  font-size: 24px;
}
    </style>

<style>
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
<div class="site-mobile-menu">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close">
        <span class="icofont-close js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>
  <nav class="site-nav">
  <div class="container position-relative">
    <div class="site-navigation">
      <img src="../dash/user/user_dash/imggg.png" alt="SyncAura Logo" style="max-height: 50px;" class="syncaura-logo"> 
      <ul class="site-menu">
        <li><a href="loading_screen/loading_meet.html">MEET</a></li>
        <li><a href="loading_screen/loading_p.html">POMODORO TIMER</a></li>
        <li><a href="listPack.php">BUY A PACK</a></li>
        <li><a href="todolist/loading_todo.html">To Do List</a></li>
        <li><a href="loading_screen/loadng.html">Chat ROOM</a></li>
        <li><a href="loading_screen/loading_share.html">Share files</a></li>
        <li><a href="loading_screen/loading_thome.html">blog</a></li>
      </ul>
      <div class="user-info">
        <a href="sign/signin.php" class="logout-btn" onclick="return confirm('Are you sure you want to leave the website?')"><i class="fas fa-sign-out-alt"></i> Log Out</a>
      </div>
    </div>
  </div>
</nav>

<div class="controller-icon">
  <div class="profile-block">
    <a href="loading_screen/laoding_modif.html"><img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" ></a>
  </div>
  <a href="loading_screen/loading_game.html" title="Play Game">
    <i class="fas fa-gamepad"></i>
  </a>
  <a href="ghub/gilo.html" title="GitHub">
    <i class="fab fa-github"></i>
  </a>
  <a href="Ai/loding3.html" title="AI Chat">
    <i class="fas fa-robot"></i>
  </a>
  <a href="loading_screen/loading_editor.html" title="Code Editor">
    <i class="fas fa-code"></i>
  </a>
  <a href="media/media.html" title="Social Media">
    <i class="fas fa-users"></i>
  </a>
  <a href="loading_screen/loading_main.html" title="main_page">
    <i class="fas fa-chalkboard"></i>
  </a>
</div>


<div class="spline-viewer">
<spline-viewer url="https://prod.spline.design/BK83Flm76SwRJlHz/scene.splinecode"></spline-viewer>
</div>

<div class="container">
    <div class="text-center">
        <h4>
        </h4>
    </div>

    <div class="packs-container">
        <?php foreach ($packs as $pack): ?>
            <div class="pack-card">
                <h2><?= htmlspecialchars($pack['nom']); ?></h2>
                <p><?= htmlspecialchars($pack['description']); ?></p>
                <p><strong>Price: </strong><?= htmlspecialchars($pack['prix']); ?> td</p>

                <!-- Display the image if available -->
                <div class="pack-image">
                    <?php
                    $imageName = $PackController->getImageByIdPack($pack['id']);
                    if (!empty($imageName)) {
                        $imageArray = explode('/', $imageName);
                        $imageFileName = end($imageArray);
                        $imagePath = "http://localhost/integration3/Views/dash/image_bdd/" . $imageFileName;
                        echo "<img src='$imagePath' alt='pack image'>";
                    } else {
                        echo "<p>Aucune image disponible</p>";
                    }
                    ?>
                </div>

                <!-- Update and Delete buttons -->
                <div class="pack-actions">
                 
                    <a href="commande.php?id=<?= $pack['id']; ?>" class="button-link">Command</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Add buttons below packs-container -->
    <div class="button-row" style="display: flex; justify-content: center; gap: 24px; margin-top: 32px; z-index: 20; position: relative;">
        <a href="listAchat.php" class="button-link" style="background: linear-gradient(90deg,rgb(4, 155, 255),rgba(108, 174, 218, 0.95)); font-size: 18px; font-weight: bold; box-shadow: 0 8px 24px rgba(240, 93, 220, 0.86);">View My Purchases</a>
        <a href="des.php" class="button-link" style="background: linear-gradient(90deg,rgba(108, 174, 218, 0.95),rgb(4, 155, 255)); font-size: 18px; font-weight: bold; box-shadow: 0 8px 24px rgba(240, 93, 220, 0.86);">Help in Choice of Package</a>
    </div>
</div>
<script>
    window.onload = function () {
        const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
        if (shadowRoot) {
            const logo = shadowRoot.querySelector('#logo');
            if (logo) logo.remove();
        }
    }; </script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/custom.js"></script>
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.35/build/spline-viewer.js"></script>

    <script>
        window.onload = function() {
            const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
            if (shadowRoot) {
                const logo = shadowRoot.querySelector('#logo');
                if (logo) logo.remove();
            }
        }
    </script>
</script>
</body>
</html>

<style>
    .button-row .button-link {
        background: linear-gradient(90deg, rgb(69, 126, 163), rgb(227, 228, 230));
        font-size: 18px;
        font-weight: bold;
        box-shadow: 0 8px 24px rgba(47, 81, 175, 0.18);
        border: none;
        border-radius: 8px;
        color: #222;
        padding: 12px 32px;
        margin: 0 8px;
        transition: transform 0.2s, box-shadow 0.2s, background 0.2s, color 0.2s;
        outline: none;
        position: relative;
        overflow: hidden;
    }
    .button-row .button-link:last-child {
        background: linear-gradient(90deg, rgb(37, 105, 241), rgb(247, 248, 248));
    }
    .button-row .button-link:hover {
        background: #fff;
        color:rgb(248, 248, 248);
        box-shadow: 0 12px 32px rgba(69,126,163,0.18);
        transform: translateY(-2px) scale(1.04) rotate(-1deg);
        border: 1.5px solid #457b9d;
    }
    .button-row .button-link:active {
        transform: scale(0.98);
        box-shadow: 0 4px 12px rgba(69, 110, 163, 0.12);
    }
    </style>
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
