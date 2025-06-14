<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../Views/front/sign/signin.php"); // Redirect if not logged in
    exit();
}

// Get session data
$username = $_SESSION["username"];
$profile_picture = $_SESSION["profile_picture"]; // Corrected path
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="../../../front/imggg.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

  <link href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="flaticon.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/stylo.css">
  <title>Syncaura</title>
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

    /* Navbar Styles */
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
      padding-left:250px;
    }
    /* Syncaura Logo */
    .syncaura-logo {
      position: absolute;
      top: 5px;
      z-index: 1001;
      font-size: 1.5rem;
      margin-top: 15px;
      color: #fff;
    }
    .site-navigation ul{
      top:0px;
    }

    /* User Info (Username Display) */
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
      background: linear-gradient(to right,rgb(233, 230, 232),rgb(12, 162, 231));
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
    .site-navigation ul {
      padding-left: 180px;
    }
    .untree_co-hero.overlay {
      background: linear-gradient(rgba(29,53,87,0.7), rgba(69,123,157,0.7)), url('images/hero-img-1-min.jpg') center/cover no-repeat;
      min-height: 70vh;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 30px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.2);
      margin-top: 90px;
    }
    .welcome-text-container {
      background: rgba(255,255,255,0.07);
      border-radius: 20px;
      padding: 30px 50px;
      box-shadow: 0 4px 24px rgba(30,144,255,0.15);
      margin-bottom: 30px;
    }
    .welcome-text {
      color: #fff;
      font-size: 2.5rem;
      font-weight: 700;
      letter-spacing: 1px;
      text-shadow: 0 2px 8px rgba(30,144,255,0.2);
    }
    .btn-secondary {
      background: linear-gradient(to right, #1E90FF, #457b9d);
      color: #fff;
      border: none;
      border-radius: 25px;
      padding: 12px 32px;
      font-size: 1.1rem;
      font-weight: 600;
      box-shadow: 0 2px 8px rgba(30,144,255,0.15);
      transition: background 0.3s, transform 0.2s;
    }
    .btn-secondary:hover {
      background: linear-gradient(to right, #457b9d, #1E90FF);
      transform: translateY(-2px) scale(1.04);
    }

    .logout-btn i {
      margin-right: 10px;
      font-size: 18px;
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
</head>

<body>
  <!-- Blue Cubic Cursor Elements -->
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

  <nav class="site-nav">
    <div class="container position-relative">
      <div class="site-navigation">
        <img src="imggg.png" alt="SyncAura Logo" style="max-height: 50px;" class="syncaura-logo"> 
       
        <!-- Display Username in Navbar -->
        <ul class="site-menu">
          <li><a href="../../../front/voice/loading.html">Meet</a></li>
          <li><a href="../../../front/loading_screen/loading_p.html">Pomodoro Timer</a></li>
          <li><a href="../../../front/loading_screen/loadngg.php">Buy a Pack</a></li>
          <li><a href="../../../front/loading_screen/loading_todo.html">To Do List</a></li>
          <li><a href="../../../front/loading_screen/loadng.html">Chat Room</a></li>
          <li><a href="../../../front/sharefiles/loading.html">Share Files</a></li>
          <li><a href="../../../front/loading_screen/loading_thome.html">Blog</a></li>
        </ul>
        <div class="user-info">
          <a href="../../../../Views/front/sign/signin.php" class="logout-btn" onclick="return confirmLogout()"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </div>
      </div>
    </div>
  </nav>

  <div class="untree_co-hero overlay" style="background-image: url('images/hero-img-1-min.jpg');">
    <div class="controller-icon">
      <div class="profile-block">
        <a href="../../../front/loading_screen/laoding_modif.html"><img src="<?php echo $profile_picture; ?>" alt="Profile Picture"></a>
      </div>

      <a href="../../../front/loading_screen/loading_game.html" title="Play Game">
        <i class="fas fa-gamepad"></i>
      </a>
      <a href="../../../front/ghub/gilo.html" title="GitHub">
        <i class="fab fa-github"></i>
      </a>
      <a href="../../../front/Ai/loding3.html" title="AI Chat">
        <i class="fas fa-robot"></i>
      </a>
      <a href="../../../front/loading_screen/loading_editor.html" title="Code Editor">
        <i class="fas fa-code"></i>
      </a>
      <a href="../../../front/media/media.html" title="Social Media">
        <i class="fas fa-users"></i>
      </a>
      <a href="main.php" title="main page">
        <i class="fas fa-chalkboard"></i>
      </a>
    </div>

    <div class="container">
      <div class="row align-items-center justify-content-center">
        <!-- Welcome text section -->
        <div class="welcome-text-container">
          <h1 class="welcome-text" style="margin-left:100px">
            Welcome to SyncAura  <?php echo $username; ?>!
          </h1>
        </div>

        <div class="col-12">
          <div class="row justify-content-center ">
            <div class="col-lg-6 text-center ">
              <h1 class="mb-4 heading text-white" data-aos="fade-up" data-aos-delay="100">Collaborez en Direct Réussissez Ensemble</h1>
              <p class="mb-0" data-aos="fade-up" data-aos-delay="300"><a href="#" class="btn btn-secondary">Crée une salle de project</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="spline-viewer">
    <spline-viewer url="https://prod.spline.design/BK83Flm76SwRJlHz/scene.splinecode"></spline-viewer>
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
  <script src="main.js"></script>
</body>
</html>