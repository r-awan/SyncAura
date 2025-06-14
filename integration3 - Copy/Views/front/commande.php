<?php
include 'C:\xampp4\htdocs\integration3\controller\achatA.php';

$achatManager = new AchatManager();
$packs = $achatManager->getAllPacks(); // Fetch all packs for ComboBox

// Handle form submission for adding or editing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data and create Achat object
    $nom_user = $_POST['nom_user'];
    $email = $_POST['email'];
    $idPack = $_POST['idPack'];

    // Create Achat object and add to the database
    $achat = new Achat(null, $nom_user, $email, $idPack);
    $achatManager->addAchat($achat); // Or use updateAchat() for editing
    header("Location: listPack.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="imgggg.png">

    <meta name="description" content=""/>
    <meta name="keywords" content="bootstrap, bootstrap4"/>

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
<style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .spline-viewer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 1;
        }

        .form-container {
            position: relative;
            z-index: 10;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        table {
            width: 100%;
        }

        input, select {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
        }

        input[type="submit"], input[type="reset"] {
            width: 48%;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
        <script src="scriptAch.js"></script>

</head>
<body>
    <div class="spline-viewer">
    <spline-viewer url="https://prod.spline.design/BK83Flm76SwRJlHz/scene.splinecode"></spline-viewer>
    </div>

    <!-- Form for Adding/Editing Achat -->
    <div class="form-container">
        <h2>add a purchase</h2>
        <form action="" method="POST" onsubmit="return validateForm();" novalidate>>>
            <table>
                <tr>
                    <td><label for="nom_user">username:</label></td>
                    <td><input type="text" name="nom_user" id="nom_user" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" name="email" id="email" required></td>
                </tr>
          
                <tr>
                    <td><label for="idPack">Pack:</label></td>
                    <td>
                        <select name="idPack" id="idPack" required>
                            <?php foreach ($packs as $pack): ?>
                                <option value="<?php echo $pack['id']; ?>"><?php echo $pack['nom']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="2">
                        <input type="submit" value="Save">
                        <input type="reset" value="Reset">
                    </td>
                </tr>
            </table>
        </form>
       
        <div align="center">
    <a href="listPack.php" class="btn btn-primary">Retour à la liste</a>
</div>
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
        window.onload = function() {
            const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
            if (shadowRoot) {
                const logo = shadowRoot.querySelector('#logo');
                if (logo) logo.remove();
            }
        }
    </script><div class="cursor"></div>
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
