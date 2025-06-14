<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Find Your Ideal Pack</title>
    <link rel="shortcut icon" href="imgggg.png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #e3f2fd, #bbdefb);
            color: #333;
            text-align: center;
            padding: 20px;
        }
        .quiz-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }
        h1 {
            color: #007bff;
        }
        .question-box {
            display: none;
        }
        .question-box.active {
            display: block;
        }
        .question {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        button {
            padding: 12px 25px;
            margin: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            display: none;
            margin-top: 30px;
            padding: 20px;
            border-radius: 10px;
            font-size: 18px;
            background-color: #f4f4f4;
            text-align: center;
        }
        .pack-promodoro {
            background-color: #cce7ff;
            border-radius: 10px;
            padding: 10px;
        }
        .pack-code-editor {
            background-color: #fff2cc;
            border-radius: 10px;
            padding: 10px;
        }
        .pack-both {
            background: linear-gradient(90deg, #cce7ff 50%, #fff2cc 50%);
            border-radius: 10px;
            padding: 10px;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff5722;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 8px;
            display: inline-block;
        }
        .back-button:hover {
            background-color: #e64a19;
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
    <div class="quiz-container">
        <h1>Quiz: Which Pack is Right for You?</h1>
        <form id="quizForm" method="post">
            <div class="question-box active" data-question="1">
                <p class="question">1. Do you prefer working in a calm environment with music?</p>
                <button type="button" data-answer="promodoro">Yes</button>
                <button type="button" data-answer="code-editor">No</button>
            </div>
            <div class="question-box" data-question="2">
                <p class="question">2. Do you need a tool to organize your thoughts visually?</p>
                <button type="button" data-answer="code-editor">Yes</button>
                <button type="button" data-answer="promodoro">No</button>
            </div>
            <div class="question-box" data-question="3">
                <p class="question">3. Do you find it motivating to work with music?</p>
                <button type="button" data-answer="promodoro">Yes</button>
                <button type="button" data-answer="code-editor">No</button>
            </div>
            <div class="question-box" data-question="4">
                <p class="question">4. Do you prefer organizing your tasks visually?</p>
                <button type="button" data-answer="code-editor">Yes</button>
                <button type="button" data-answer="promodoro">No</button>
            </div>
            <div class="question-box" data-question="5">
                <p class="question">5. Do you enjoy focusing in a calm and immersive atmosphere?</p>
                <button type="button" data-answer="promodoro">Yes</button>
                <button type="button" data-answer="code-editor">No</button>
            </div>
            <div class="question-box" data-question="6">
                <p class="question">6. Do you like using tools to visualize or explain ideas?</p>
                <button type="button" data-answer="code-editor">Yes</button>
                <button type="button" data-answer="promodoro">No</button>
            </div>
            <div class="question-box" data-question="7">
                <p class="question">7. Do you work better when immersed in a musical atmosphere?</p>
                <button type="button" data-answer="promodoro">Yes</button>
                <button type="button" data-answer="code-editor">No</button>
            </div>
            <div class="question-box" data-question="8">
                <p class="question">8. Do you need a platform to jot down and share your ideas visually?</p>
                <button type="button" data-answer="code-editor">Yes</button>
                <button type="button" data-answer="promodoro">No</button>
            </div>
        </form>
        <div class="result" id="resultBox">
            <h2>Your Recommended Pack:</h2>
            <div id="resultText"></div>
            <a href="listPack.php" class="back-button">Back to Packs</a>
        </div>
    </div>

    <script>
        const questions = document.querySelectorAll('.question-box');
        const resultBox = document.getElementById('resultBox');
        const resultText = document.getElementById('resultText');

        let currentQuestion = 0;
        let promodoroCount = 0;
        let codeEditorCount = 0;

        function showNextQuestion() {
            questions[currentQuestion].classList.remove('active');
            currentQuestion++;
            if (currentQuestion < questions.length) {
                questions[currentQuestion].classList.add('active');
            } else {
                showResult();
            }
        }

        function showResult() {
            resultBox.style.display = 'block';
            if (promodoroCount > codeEditorCount) {
                resultText.innerHTML = `<div class="pack-promodoro">Promodoro Pack</div><p>You thrive in an immersive, music-driven workspace.</p>`;
            } else if (codeEditorCount > promodoroCount) {
                resultText.innerHTML = `<div class="pack-code-editor">Code Editor Pack</div><p>Perfect for visually organizing your ideas.</p>`;
            } else {
                resultText.innerHTML = `<div class="pack-both">Both Packs</div><p>Enjoy immersive music and visual tools for your tasks.</p>`;
            }
        }

        document.querySelectorAll('button[data-answer]').forEach(button => {
            button.addEventListener('click', () => {
                const answer = button.getAttribute('data-answer');
                if (answer === 'promodoro') {
                    promodoroCount++;
                } else if (answer === 'code-editor') {
                    codeEditorCount++;
                }
                showNextQuestion();
            });
        });
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








