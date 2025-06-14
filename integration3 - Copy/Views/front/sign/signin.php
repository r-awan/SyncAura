<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="shortcut icon" href="../imggg.png">
    <link rel="stylesheet" href="styles.css">
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

        /* Existing styles */
        button, input, a {
            cursor: none !important;
        }

        button {
            margin-top:20px;
            background: linear-gradient(135deg, #0066ff, #33ccff); 
            color: #fff; 
            border: none;
            border-radius: 25px; 
            padding: 10px 20px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); 
            outline: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    
        button:hover {
            background: linear-gradient(135deg, #33ccff, #0066ff); 
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4); 
        }

        button:active {
            transform: scale(0.98);
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
            color: red;
        }
        
        .faceid {
            margin-top: 15px;
        }
        
        /* Google button specific styles */
        #google-login-btn {
            background: #ffffff;
            color: #444;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 500;
        }
        
        #google-login-btn img {
            width: 20px;
            height: 20px;
        }
        
        #google-login-btn:hover {
            background: #f8f8f8;
            border-color: #ccc;
        }
        
        .google-login-container {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 15px;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 15px 0;
            color: #666;
            font-size: 0.9rem;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }
        
        .divider::before {
            margin-right: 10px;
        }
        
        .divider::after {
            margin-left: 10px;
        }
        
        /* hCaptcha container styling */
        .h-captcha-container {
            margin: 15px 0;
            display: flex;
            justify-content: center;
        }
        
        /* Modal for hCaptcha verification */
        .hcaptcha-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 10000;
            justify-content: center;
            align-items: center;
        }
        
        .hcaptcha-modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .hcaptcha-modal-close {
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #0077ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Blue Cubic Cursor Elements -->
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
    <div class="cursor-ring"></div>

    <video style="z-index: 2" id="video" width="640" height="480" autoplay hidden></video>
    <canvas style="z-index: 2" id="canvas" width="640" height="480" hidden></canvas>
    
    <div class="spline-viewer">
        <spline-viewer url="https://prod.spline.design/O4wdVneKYyKKbJbX/scene.splinecode"></spline-viewer>
    </div>
    
    <!-- hCaptcha Verification Modal -->
    <div id="hcaptcha-modal" class="hcaptcha-modal">
        <div class="hcaptcha-modal-content">
            <h3>Complete hCaptcha Verification</h3>
            <p>Please complete the hCaptcha verification to continue.</p>
            <div class="h-captcha" data-sitekey="40b45e0e-a5e4-4ad4-b7a8-ad8e70641dbc"></div>
            <button class="hcaptcha-modal-close" onclick="closeHcaptchaModal()">Close</button>
        </div>
    </div>
    
    <div class="container">
        <form id="signin-form" action="../../../controller/loginController.php" method="post" autocomplete="on" onsubmit="return validateForm(event)">
            <h1>Login Form</h1>
            
            <!-- Username Input -->
            <input type="text" placeholder="Enter your username" name="username" id="username" autocomplete="username">
            <div id="username-error" class="error-messages"></div>

            <!-- Password Input -->
            <input type="password" placeholder="Enter your password" name="pass" id="pass" autocomplete="current-password">
            <div id="password-error" class="error-messages"></div>
            
            <button type="submit">Login</button>
            
            <div class="h-captcha-container">
                <div class="h-captcha" data-sitekey="40b45e0e-a5e4-4ad4-b7a8-ad8e70641dbc"></div>
            </div>
            <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

            <div class="divider">or</div>
            
            <!-- Google Sign-In Button -->
            <div class="google-login-container">
                <button type="button" id="google-login-btn">
                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo">
                    Sign in with Google
                </button>
            </div>
            
            <!-- Face ID Button -->
            <div class="faceid">
                <button type="button" id="face-login-btn" onclick="handleFaceLoginClick()" class="nav-buttons">
                    Sign in with Face ID
                </button>
            </div>
            
            <div id="error-messages2" class="error-messages" style="display: block;">
                <?php if (isset($_GET['error'])): ?>
                    <?php
                    $error_message = '';
                    if ($_GET['error'] == 1) {
                        $error_message = 'Forgot your password? <a href="reset-password.php">Click here</a>';
                    }
                    echo "<p>{$error_message}</p>";
                    ?>
                <?php endif; ?>
            </div>
            
            <p>Not a member? <a href="signup.php">Sign Up</a></p>
            
            <!-- PHP error messages -->
            <div id="error-messages" class="error-messages" style="display: block;">
                <?php if (isset($_GET['error'])): ?>
                    <?php
                    $error_message = '';
                    if ($_GET['error'] == 1) {
                        $error_message = "Invalid password.";
                    } elseif ($_GET['error'] == 2) {
                        $error_message = "User not found.";
                    } elseif ($_GET['error'] == 3) {
                        $error_message = 'Your account is inactive. <a href="contact/loding2.php">Please contact support.</a>';
                    } elseif ($_GET['error'] == 5) {
                        $error_message = '"No account found with that email address."';
                    } elseif ($_GET['error'] == 6) {
                        $error_message = "Failed to send password reset email.";
                    }
                    echo "<p>{$error_message}</p>";
                    ?>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
    
    <script>
        // Initialize the cubic cursor
        function initCursor() {
            const cursor = document.querySelector('.cursor');
            const follower = document.querySelector('.cursor-follower');
            const ring = document.querySelector('.cursor-ring');
            const interactiveElements = document.querySelectorAll('a, button, input, [data-cursor]');
            
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

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyBDkHoKXPjUUHPOc0_3obelvi5SlKCJLTQ",
            authDomain: "sentra-a8a27.firebaseapp.com",
            projectId: "sentra-a8a27",
            storageBucket: "sentra-a8a27.firebasestorage.app",
            messagingSenderId: "611105282487",
            appId: "1:611105282487:web:0f9a9c3e46b71d496ff032"
        };
        
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();
        
        // hCaptcha Modal Functions
        function showHcaptchaModal() {
            document.getElementById('hcaptcha-modal').style.display = 'flex';
            // Reset hCaptcha if already completed
            hcaptcha.reset();
        }
        
        function closeHcaptchaModal() {
            document.getElementById('hcaptcha-modal').style.display = 'none';
        }
        
        function checkHcaptcha() {
            const hcaptchaResponse = hcaptcha.getResponse();
            if (hcaptchaResponse.length === 0) {
                showHcaptchaModal();
                return false;
            }
            return true;
        }
        
        // Google Sign-In Functionality
        document.getElementById('google-login-btn').addEventListener('click', function() {
            if (!checkHcaptcha()) {
                return;
            }
            
            const provider = new firebase.auth.GoogleAuthProvider();
            
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<div>Signing in...</div>';
            this.disabled = true;
            
            auth.signInWithPopup(provider)
                .then((result) => {
                    // Successful login
                    console.log("Google sign-in successful", result.user);
                    
                    // Redirect to main page
                    window.location.href = '../loading_screen/loading_main.html';
                })
                .catch((error) => {
                    // Handle Errors here
                    console.error("Google sign-in error", error);
                    
                    // Restore button state
                    this.innerHTML = originalText;
                    this.disabled = false;
                    
                    // Show error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-messages';
                    errorDiv.style.display = 'block';
                    errorDiv.innerHTML = `<p>Google sign-in failed: ${error.message}</p>`;
                    
                    // Insert after the Google button container
                    document.querySelector('.google-login-container').after(errorDiv);
                    
                    // Remove error after 5 seconds
                    setTimeout(() => {
                        errorDiv.remove();
                    }, 5000);
                });
        });
        
        // Face ID Login Handler
        function handleFaceLoginClick() {
            if (!checkHcaptcha()) {
                return;
            }
            
            // Start face recognition if hCaptcha is verified
            startFaceRecognition();
        }
        
        // Form validation function
        function validateForm(event) {
            // Clear previous error messages
            const usernameErrorDiv = document.getElementById('username-error');
            const passwordErrorDiv = document.getElementById('password-error');
            usernameErrorDiv.innerHTML = '';
            passwordErrorDiv.innerHTML = '';
            usernameErrorDiv.style.display = 'none';
            passwordErrorDiv.style.display = 'none';
        
            let errors = false;
        
            // Verify hCaptcha
            if (!checkHcaptcha()) {
                event.preventDefault();
                return false;
            }
        
            // Get values from form inputs
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('pass').value.trim();
        
            // Validate username
            if (username === '') {
                errors = true;
                usernameErrorDiv.innerHTML = 'Username is required.';
                usernameErrorDiv.style.display = 'block';
            } else if (username.length < 3) {
                errors = true;
                usernameErrorDiv.innerHTML = 'Username must be at least 3 characters long.';
                usernameErrorDiv.style.display = 'block';
            }
        
            // Validate password
            if (password === '') {
                errors = true;
                passwordErrorDiv.innerHTML = 'Password is required.';
                passwordErrorDiv.style.display = 'block';
            } else if (password.length < 8) {
                errors = true;
                passwordErrorDiv.innerHTML = 'Password must be at least 8 characters long.';
                passwordErrorDiv.style.display = 'block';
            }
        
            // If there are validation errors, prevent form submission
            if (errors) {
                event.preventDefault();
                return false;
            }
        
            // If no errors, allow form submission
            return true;
        }

        // Initialize cursor when page loads
        window.onload = function() {
            initCursor();
            
            const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
            if (shadowRoot) {
                const logo = shadowRoot.querySelector('#logo');
                if (logo) logo.remove();
            }
            
            // Show PHP error messages on page load if any
            const errorMessagesDiv = document.getElementById('error-messages');
            if (errorMessagesDiv.innerHTML.trim() !== '') {
                errorMessagesDiv.style.display = 'block';
            }
            
            // Initialize hCaptcha
            window.hcaptchaOnLoad = function() {
                console.log('hCaptcha loaded');
            };
        }
        
        // Global function for face recognition (to be called from face_recognition_login.js)
        function startFaceRecognition() {
            // This function should be implemented in face_recognition_login.js
            console.log('Starting face recognition...');
            // Your face recognition implementation goes here
        }
    </script>

    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.35/build/spline-viewer.js"></script>
    <script src="../faceid/face_recognition_login.js"></script>
</body>
</html>