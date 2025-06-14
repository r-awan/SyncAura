<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="../imggg.png">
    <style>
        form {
    background: rgba(255, 255, 255, 0.15); /* Glassmorphism effect */
    backdrop-filter: blur(20px); /* Stronger blur */
    padding: 50px;
    border-radius: 25px; /* Softer rounded corners */
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6); /* Elevated shadow */
    width: 380px; /* Slightly wider for better spacing */
    animation: dropIn 0.8s ease-in-out; /* Smooth animation for form entry */
    position: relative;
    z-index: 2;
}

@keyframes dropIn {
    from {
        transform: translateY(-50px) scale(0.95); /* Drop in with slight zoom */
        opacity: 0;
    }
    to {
        transform: translateY(0) scale(1); /* Normal size and position */
        opacity: 1;
    }
}

h1 {
    color: #ffffff; /* White text for contrast */
    text-align: center;
    font-size: 30px;
    font-weight: bold;
    margin-bottom: 25px;
    text-shadow: 0 3px 12px rgba(0, 0, 0, 0.5); /* Glowing effect */
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"],
input[type="file"] {
    width: 100%;
    padding: 14px;
    margin-bottom: 20px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    background: rgba(255, 255, 255, 0.9); /* Softer background */
    color: #333;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: box-shadow 0.3s, transform 0.3s; /* Smooth interactions */
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
input[type="date"]:focus,
input[type="file"]:focus {
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.5); /* Brighter glow */
    transform: translateY(-2px); /* Subtle lift */
    outline: none;
}

input[type="radio"] {
    margin: 0 10px;
    transform: scale(1.2);
}

label {
    font-size: 16px;
    color: #fff;
    margin-right: 15px;
}

input[type="submit"] {
    background: linear-gradient(135deg, #0066ff, #33ccff); 
            color: #fff; 
            border: none;
            border-radius: 25px; 
            padding: 10px 20px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); 
            outline: none;
}

input[type="submit"]:hover {
    background: linear-gradient(135deg, #33ccff, #0066ff); 
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4); 
}

.error {
    font-size: 14px;
    color: #ff4d4d; /* Red for errors */
    margin-top: -15px;
    margin-bottom: 10px;
    text-shadow: 0 1px 5px rgba(255, 77, 77, 0.5); /* Subtle glow */
}  
.form-image-container {
    text-align: center;
    margin-bottom: 20px;
}

.form-image {
    width: 100%;
    max-width: 150px;
    border-radius: 50%; /* Circular image */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Cool shadow */
    transition: transform 0.3s ease;
}

.form-image:hover {
    transform: scale(1.1); /* Slight zoom on hover */
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
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
<video style="z-index: 2"  id="video" width="640" height="480" autoplay hidden></video>
<canvas style="z-index: 2"  id="canvas" width="640" height="480" hidden></canvas>
<div class="spline-viewer">
<spline-viewer url="https://prod.spline.design/O4wdVneKYyKKbJbX/scene.splinecode"></spline-viewer>
    </div>
    <form id="registrationForm" action="../../../controller/usersign/SignupController.php" method="post" enctype="multipart/form-data">
        <h1>Signup Form</h1>
        <div class="form-image-container">
        <img src="imgggg.png" alt="Signup Illustration" class="form-image">
    </div>
        <!-- Name and Surname -->
        <div>
            <input type="text" placeholder="Put your name" name="namex" id="namex" >
            <div id="nameError" class="error"></div>
        </div>
        <div>
            <input type="text" placeholder="Put your surname" name="surname" id="surname" >
            <div id="surnameError" class="error"></div>
        </div>

        <!-- Username -->
        <div>
            <input type="text" placeholder="Put your username" name="name" id="name" >
            <div id="username-error" class="error"></div>
        </div>

        <!-- Email -->
        <div>
            <input type="text" placeholder="Email" name="email" id="email" >
            <div id="email-error" class="error"></div>
        </div>

        <!-- Password -->
        <div>
            <input type="password" placeholder="Password" name="pass" id="pass" >
            <div id="password-error" class="error"></div>
        </div>

        <!-- Gender -->
        <div>
    <label for="genderMale">Male</label>
    <input type="radio" name="gender" value="Male" id="genderMale">
    <label for="genderFemale">Female</label>
    <input type="radio" name="gender" value="Female" id="genderFemale">
    <div id="genderError" class="error"></div>
</div>
<br>

        <!-- Birthdate -->
        <div>
            <input type="date" name="birthdate" id="birthdate" >
            <div id="birthdateError" class="error"></div>
        </div>

        <!-- Phone Number -->
        <div>
            <input type="text" placeholder="Phone Number" name="phone" id="phone" >
            <div id="phoneError" class="error"></div>
        </div>

        <!-- Profile Picture -->
        <div>
            <input type="file" name="profilePicture" id="profilePicture" accept="image/*">
            <div id="profilePictureError" class="error"></div>
        </div>

        <div>
                <button type="button" id="registerFace" class="face-recognition-btn" onclick="startFaceRecognition()">
                    <img id="face-icon"
                        src="data:image/png;base64,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" />
                    Set Up Face ID
                </button>
                <input type="hidden" name="face_id" id="face_id" value="">
            </div>

        <!-- Submit Button -->
        <input type="submit" value="Sign Up" class="button">

        <!-- Error message display -->
        <div id="php-error-messages">
            <?php
            if (isset($_GET['error'])) {
                $error_message = $_GET['error'] == 2 ? "Username or email already exists." : "";
                echo '<p>' . $error_message . '</p>';
            }
            ?>
        </div>
        <p>Already a member? <a href="signin.php" style="color: blue;">Sign In</a></p>
    </form>

    <script>
        document.getElementById("registrationForm").addEventListener("submit", function(event) {
        // Clear error messages
        document.querySelectorAll(".error").forEach(el => el.textContent = "");

        let errors = false;

        //////////////////////////////////////////////////
        // Profile Picture Validation
        const profilePicture = document.getElementById("profilePicture").files[0];
        const allowedExtensions = ["image/jpeg", "image/png", "image/gif"];
        
        if (profilePicture) {
            if (!allowedExtensions.includes(profilePicture.type)) {
                document.getElementById("profilePictureError").textContent = "Invalid file type. Only JPEG, PNG, and GIF are allowed.";
                errors = true;
            } else if (profilePicture.size > 2 * 1024 * 1024) {  // Check if file size exceeds 2MB
                document.getElementById("profilePictureError").textContent = "File size exceeds 2MB.";
                errors = true;
            }
        }

        //////////////////////////////////////////////////
        // Name validation
        let name = document.getElementById('namex').value;
        if (name === '') {
            errors = true;
            document.getElementById('nameError').textContent = 'Name is required.';
        }else if (!/^[a-zA-Z]+$/.test(name)) {
        errors = true;
        document.getElementById('nameError').textContent = 'Name can only contain letters.';
    }

        // Surname validation
        let surname = document.getElementById('surname').value;
        if (surname === '') {
            errors = true;
            document.getElementById('surnameError').textContent = 'Surname is required.';
        } else if (!/^[a-zA-Z]+$/.test(surname)) {
        errors = true;
        document.getElementById('surnameError').textContent = 'Surname can only contain letters.';
    }

        // Username validation
        let username = document.getElementById('name').value;
        if (username === '') {
            errors = true;
            document.getElementById('usernameError').textContent = 'Username is required.';
        } else if (username.length < 3) {
            errors = true;
            document.getElementById('usernameError').textContent = 'Username must be at least 3 characters long.';
        } else if (/^\d+$/.test(username)) {  // Check if username contains only numbers
            errors = true;
            document.getElementById('usernameError').textContent = 'Username cannot contain only numbers.';
        }

        // Email validation
        let email = document.getElementById('email').value;
        let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            errors = true;
            document.getElementById('emailError').textContent = 'Please enter a valid email address.';
        }else if (email ==='')
        {
            errors = true;
            document.getElementById('emailError').textContent = 'email address is required.';
        }

        // Password validation
        let password = document.getElementById('pass').value;
        if (password === '') {
            errors = true;
            document.getElementById('passwordError').textContent = 'Password is required.';
        } else if (password.length < 8) {
            errors = true;
            document.getElementById('passwordError').textContent = 'Password must be at least 8 characters long.';
        }
        // Check for at least one number and one symbol
        const passwordPattern = /^(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).+$/;
                    if (!passwordPattern.test(newPassword)) {
                        document.getElementById("PasswordError").textContent = " password must contain at least one number and one symbol.";
                        errors =true;
                    }

        // Gender validation
        let gender = document.querySelector('input[name="gender"]:checked');
        if (!gender) {
            errors = true;
            document.getElementById('genderError').textContent = 'Gender is required.';
        }

        // Birthdate validation
        let birthdate = document.getElementById('birthdate').value;
        if (birthdate === '') {
            errors = true;
            document.getElementById('birthdateError').textContent = 'Birthdate is required.';
        }

        // Phone number validation
        let phone = document.getElementById('phone').value;
        let phonePattern = /^[0-9]{10}$/;  // Assumes a 10-digit phone number
        if (!phonePattern.test(phone)) {
            errors = true;
            document.getElementById('phoneError').textContent = 'Please enter a valid phone number.';
        } else if (phone ==='')
        { errors= true;
            document.getElementById('phoneError').textContent = 'Phone number is required.';

        }

        // Prevent submission if there are errors
        if (errors) {
            event.preventDefault();
        }
    });
    </script>
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
    <script>
        function startFaceRecognition() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            var faceIdInput = document.getElementById('face_id');;
            console.log(faceIdInput);

            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                    setTimeout(() => {  // Give user a moment to adjust their position
                        context.drawImage(video, 0, 0, 640, 480);
                        video.hidden = true;
                        const imageDataURL = canvas.toDataURL('image/png');
                        canvas.hidden = false;

                        // Here we call the Face++ API to register the face
                        registerFace(imageDataURL)
                            .then(faceId => {
                                faceIdInput.value = faceId;  // Store the faceId in a hidden input to be sent with the form
                                stream.getTracks().forEach(track => track.stop());  // Stop the camera stream
                                alert("Face registered successfully!");
                                stopVideoStream(video);
                                //activate check mark and desactivate button
                            })
                            .catch(error => {
                                alert("Failed to register face: " + error.message);
                                stopVideoStream(video);
                            });
                    }, 2000);
                });
        }

        function registerFace(imageDataURL) {
            return fetch('../faceid/capture_face.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `image_data=${encodeURIComponent(imageDataURL)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("date face id: ", data.face_id);
                        return data.face_id;  // Return the faceId received from the server
                    } else {
                        console.log("error: ", data.message);
                        throw new Error(data.message);
                    }
                });
        }
        function stopVideoStream(video) {
            const stream = video.srcObject;
            if (stream) {
                const tracks = stream.getTracks();

                tracks.forEach(function (track) {
                    track.stop();
                });

                video.srcObject = null; // Clear the source after stopping the track
            }
            video.hidden = true; // Optionally hide the video element
            canvas.hidden = true; // Optionally hide the canvas if you're using it
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
