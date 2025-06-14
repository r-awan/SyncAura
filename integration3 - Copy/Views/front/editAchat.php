<?php
include 'C:\xampp4\htdocs\integration3\controller\achatA.php'; // Correct controller

$error = "";
$achat = null;

// Create an instance of the controller
$AchatManager = new AchatManager();

// Check if the form was submitted
if (
    isset($_POST["Ida"]) &&
    isset($_POST["NomUser"]) &&
    isset($_POST["Email"]) &&
    isset($_POST["IdPack"])
) {
    if (
        !empty($_POST["Ida"]) &&
        !empty($_POST['NomUser']) &&
        !empty($_POST["Email"]) &&
        !empty($_POST["IdPack"])
    ) {
        // Create an Achat object
        $achat = new Achat(
            $_POST['Ida'],
            $_POST['NomUser'],
            $_POST['Email'],
            $_POST['IdPack']
        );
        
        // Update the achat using the correct object
        $AchatManager->updateAchat($achat, $_POST["Ida"]);
        
        // Redirect to the list page after the update
        header('Location: listAchat.php');
        exit(); // End the script after the redirection
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Achat</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS for styling -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styleCard.css">
    <link rel="shortcut icon" href="imgggg.png">

    <style>
        /* Example internal styles for form styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .container {
            width: 60%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-table {
            width: 100%;
            margin-top: 20px;
        }
        .form-table td {
            padding: 8px;
        }
        .form-table input[type="text"],
        .form-table input[type="email"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-table input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-table input[type="submit"]:hover {
            background-color: #000080;
        }
        #error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .back-button {
            text-align: center;
            margin-top: 20px;
        }
        .back-button a {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button a:hover {
            background-color: #0056b3;
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

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styleCard.css">
    <script src="https://unpkg.com/@splinetool/viewer/build/spline-viewer.js" type="module"></script>
    <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="imggg.png">

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
  <link rel="stylesheet" href="css/stylo/css">
  <link rel="stylesheet" href="css/card.css">
</head>
<body>
<div class="spline-viewer">
    <spline-viewer url="https://prod.spline.design/O4wdVneKYyKKbJbX/scene.splinecode"></spline-viewer>
</div>

<div class="site-mobile-menu">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close">
        <span class="icofont-close js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>

  <nav class="site-nav mb-5">

<div class="container">
    <h1>Update Achat Information</h1>

    <div id="error">
        <?php echo $error; ?>
    </div>
   
    <?php
    // Show the achat based on the ID passed in the URL
    if (isset($_GET['id'])) {
        $achat = $AchatManager->showAchat($_GET['id']);
    ?>
    <form action="" method="POST" enctype="multipart/form-data" novalidate>
        <table class="form-table" border="1" align="center">
            <tr>
                <td><label for="Ida">purchase id :</label></td>
                <td><input type="text" name="Ida" id="Ida" value="<?php echo $achat['ida']; ?>" readonly></td>
            </tr>
            <tr>
                <td><label for="NomUser">username:</label></td>
                <td><input type="text" name="NomUser" id="NomUser" value="<?php echo $achat['nom_user']; ?>"></td>
            </tr>
            <tr>
                <td><label for="Email">Email:</label></td>
                <td><input type="email" name="Email" id="Email" value="<?php echo $achat['email']; ?>"></td>
            </tr>
    
            <tr>
                <td><label for="IdPack">Id Pack:</label></td>
                <td>
                    <select name="IdPack" id="IdPack">
                        <?php
                        // Fetch all packs from the database and create options
                        $packs = $AchatManager->getAllPacks();
                        foreach ($packs as $pack) {
                            $selected = ($pack['id'] == $achat['idPack']) ? 'selected' : ''; // Mark the selected pack
                            echo "<option value='{$pack['id']}' {$selected}>{$pack['nom']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Modify">
                </td>
            </tr>
        </table>
    </form>

    <?php } ?>

    <div class="back-button">
        <a href="listAchat.php" class="back-button">Back to List</a>
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
