<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" type="image/x-icon" href="icon.png">


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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgggg.png">
    <title>Change Password and Username</title>
    <style>
        /* Additional styling */
        .form-container {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
            position: relative;
            z-index: 2;

        }

        .form-container h3 {
            margin-bottom: 20px;
        }

        body {
            margin: 0;
            padding: 0;
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

        .error-messages {
            background-color: white;
            color: red;
            margin-top: 10px;
            padding: 5px;
            font-size: 0.9rem;
            display: none; /* Hide error messages initially */
        }

        .error-messages p {
            margin: 0;
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

  
    <div class="spline-viewer">
    <spline-viewer url="https://prod.spline.design/BK83Flm76SwRJlHz/scene.splinecode"></spline-viewer>
    </div>
        <br>
        <br>
        <br>
        <br>
    <div class="form-container">
        <h3>Change Your Details</h3>
        <form action="user_modify.php" method="POST" id="updateForm" enctype="multipart/form-data">
            <!-- Username -->
            <div class="form-group">
                <label for="username">New Username:</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter new username">
                <small id="usernameError" class="form-text text-danger"></small>
            </div>
            <!-- Password -->
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter current password">
                <small id="currentPasswordError" class="form-text text-danger"></small>
            </div>
            <!-- New Password -->
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password">
                <small id="newPasswordError" class="form-text text-danger"></small>
            </div>
            <!-- Confirm New Password -->
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm new password">
                <small id="confirmPasswordError" class="form-text text-danger"></small>
            </div>
            <!-- Profile Picture -->
            <div class="form-group">
                <label for="profile_picture">Upload Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                <small id="profilePictureError" class="form-text text-danger"></small>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Details</button>

            <!-- PHP error messages (if any) will be displayed here -->
            <div id="error-messages" class="error-messages">
                <?php if (isset($_GET['error'])): ?>
                    <?php
                        $error_message = '';
                        if ($_GET['error'] == 1) {
                            $error_message = "Password is required.";
                        } 
                        echo "<p>{$error_message}</p>";
                    ?>
                <?php endif; ?>
            </div>
        </form>

        <script>
            document.getElementById("updateForm").addEventListener("submit", function(event) {
                let isValid = true;
                const errorBlock = document.getElementById("error-messages");

                // Clear previous errors
                document.getElementById("usernameError").textContent = "";
                document.getElementById("currentPasswordError").textContent = "";
                document.getElementById("newPasswordError").textContent = "";
                document.getElementById("confirmPasswordError").textContent = "";
                document.getElementById("profilePictureError").textContent = "";

                // Validate new username (if provided)
                const username = document.getElementById("username").value;
                if (username && username.length < 3) {
                    document.getElementById("usernameError").textContent = "Username must be at least 3 characters long.";
                    isValid = false;
                }else if (/^\d+$/.test(username)) {  // Check if username contains only numbers
            errors = true;
            document.getElementById('usernameError').textContent = 'Username cannot contain only numbers.';
        }

                // Validate current password (always required)
                const currentPassword = document.getElementById("current_password").value;
                if (currentPassword.trim() === "") {
                    document.getElementById("currentPasswordError").textContent = "Current password is required.";
                    isValid = false;
                }

                // Validate new password (only if a new password is entered)
                const newPassword = document.getElementById("new_password").value;
                const confirmPassword = document.getElementById("confirm_password").value;
                if (newPassword || confirmPassword) {
                    if (newPassword.length < 8) {
                        document.getElementById("newPasswordError").textContent = "New password must be at least 8 characters long.";
                        isValid = false;
                    }

                    // Check for at least one number and one symbol
                    const passwordPattern = /^(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).+$/;
                    if (!passwordPattern.test(newPassword)) {
                        document.getElementById("newPasswordError").textContent = "New password must contain at least one number and one symbol.";
                        isValid = false;
                    }

                    if (newPassword !== confirmPassword) {
                        document.getElementById("confirmPasswordError").textContent = "Confirm password must match the new password.";
                        isValid = false;
                    }
                }

                // Validate profile picture (if provided)
                const profilePicture = document.getElementById("profile_picture").files[0];
                if (profilePicture && !['image/jpeg', 'image/png', 'image/gif'].includes(profilePicture.type)) {
                    document.getElementById("profilePictureError").textContent = "Only JPG, PNG, and GIF files are allowed.";
                    isValid = false;
                }

                // Show error block if there are errors
                if (!isValid) {
                    errorBlock.style.display = "block";
                    event.preventDefault(); // Prevent form submission
                } else {
                    errorBlock.style.display = "none"; // Hide error block if no errors
                }
            });
        </script>
    </div>

    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.35/build/spline-viewer.js"></script>
    <script>
        window.onload = function () {
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
