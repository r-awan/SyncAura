<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="../imggg.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

  <link href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
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

  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: Arial, sans-serif;
      overflow: hidden;
      cursor: none; /* Hide default cursor */
    }

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

    /* Center button styles */
    .button-container {
      position: absolute;
      top: 50%;
      left: 22%;
      transform: translate(-50%, -50%);
      text-align: center;
      z-index: 10;
    }

    .button-container .btn {
      margin: 10px;
      padding: 15px 30px;
      font-size: 18px;
      font-weight: bold;
      color: #ffffff;
      background: linear-gradient(135deg, #007bff, #00d4ff);
      border: none;
      border-radius: 50px;
      cursor: none; /* Hide default cursor */
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
    }

    .button-container .btn:hover {
      background: linear-gradient(135deg, #0056b3, #00aaff);
      transform: scale(1.1);
      box-shadow: 0 6px 20px rgba(0, 123, 255, 0.6);
    }

    .button-container .btn:active {
      transform: scale(0.95);
      box-shadow: 0 2px 10px rgba(0, 123, 255, 0.4);
    }

    /* Spline viewer for the background */
    .spline-viewer {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      z-index: 1;
    }

    /* Navbar styling */
    .nav-item {
      margin-left: 15px;
    }

    .nav-item a {
      text-decoration: none;
      color: black;
      transition: color 0.3s;
      cursor: none; /* Hide default cursor */
    }

    .nav-item a:hover {
      color: #007bff;
    }
  </style>

  <title>Learner Free Bootstrap Template by Untree.co</title>
</head>

<body>
  
  <!-- Blue Cubic Cursor Elements -->
  <div class="cursor"></div>
  <div class="cursor-follower"></div>
  <div class="cursor-ring"></div>

  <!-- Navigation Bar -->
  <nav class="site-nav mb-5">
    <div class="sticky-nav js-sticky-header">
      <div class="container position-relative">
        <div class="site-navigation d-flex justify-content-between align-items-center">
          <ul class="js-clone-nav d-lg-inline-block site-menu d-flex align-items-center">
          </ul>
          <a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
            <span></span>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="untree_co-hero overlay" style="background-image: url('images/hero-img-1-min.jpg');">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-12">
          <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
              <h1 class="mb-4 heading text-white" data-aos="fade-up" data-aos-delay="100">Live Collaboration,Shared Success
              </h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Center Buttons -->
  <div class="button-container">
    <button class="btn" onclick="window.location.href='../sign/signin.php';">Sign In</button>
    <button class="btn" onclick="window.location.href='../sign/signup.php';">Sign Up</button>
  </div>

  <div class="spline-viewer">
    <spline-viewer url="https://prod.spline.design/vtn4AYoz9pdMnTBF/scene.splinecode"></spline-viewer>
  </div>

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
    // Remove Spline logo
    window.onload = function() {
      const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
      if (shadowRoot) {
        const logo = shadowRoot.querySelector('#logo');
        if (logo) logo.remove();
      }
      
      // Initialize cursor system
      initCursor();
    };

    function initCursor() {
      const cursor = document.querySelector('.cursor');
      const follower = document.querySelector('.cursor-follower');
      const ring = document.querySelector('.cursor-ring');
      const links = document.querySelectorAll('a, button, .btn, [data-cursor]');
      
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
      links.forEach(link => {
        link.addEventListener('mouseenter', () => {
          cursor.classList.add('cursor-active');
          follower.classList.add('cursor-follower-active');
          ring.style.transform = 'translate(-50%, -50%) scale(1) rotate(45deg)';
          ring.style.opacity = '0.7';
          
          // Create hover particles
          for (let i = 0; i < 3; i++) {
            createCubeParticle(mouseX, mouseY);
          }
        });
        
        link.addEventListener('mouseleave', () => {
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
  </script>
</body>
</html>