<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syncaura|Pomodoro Timer</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="shortcut icon" href="imgggg.png">
    <script src="https://unpkg.com/@splinetool/viewer/build/spline-viewer.js" type="module"></script>
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="../imggg.png">

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
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <link href="https://fonts.googleapis.com/css2?family=Display+Playfair:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #f43f5e;
            --dark: rgba(20, 25, 35, 0.6);
            --darker: #0f172a;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--darker);
            color: var(--light);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }
        
        .container {
        width: 95%;
        max-width: 1400px;
        height: 85vh;
        display: grid;
        grid-template-columns: 2fr 2fr; /* Changed from 1fr 1fr to give more space to music panel */
        gap: 4rem;
        padding: 2rem;
        z-index: 2;
    }
        
        .panel {
            background: var(--dark);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(179, 176, 176, 0.53);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        
        /* Fullscreen Spline Background */
        .spline-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 1;
            opacity: 0.7;
            overflow: hidden;
        }
        
        .spline-background spline-viewer {
            width: 100%;
            height: 100%;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
        }
        
        .panel:hover {
            background: rgba(25, 30, 40, 0.7);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(179, 0, 104, 0.68);
        }
        
        .music-panel {
    position: relative;
    left: -50px; /* Moves the panel 30px to the left */
}
        
        .timer-panel {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .playlist {
            width: 100%;
            height: 100%;
            min-height: 300px;
            border-radius: 1rem;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .timer-display {
            font-size: 5.5rem;
            font-weight: 600;
            margin: 1.5rem 0;
            color: var(--light);
            text-align: center;
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .timer-controls {
            display: flex;
            gap: 1.2rem;
            margin-bottom: 2rem;
            justify-content: center;
        }
        
        .btn {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
        
        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
        }
        
        .btn-danger {
            background-color: var(--secondary);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #e11d48;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(244, 63, 94, 0.4);
        }
        
        .timer-settings {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            justify-content: center;
        }
        
        .time-option {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .time-option label {
            font-size: 0.95rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .time-option input {
            width: 80px;
            padding: 0.7rem;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 0.75rem;
            color: white;
            text-align: center;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .time-option input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.3);
        }
        
        .timer-mode {
            display: flex;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 0.75rem;
            padding: 0.3rem;
            margin-bottom: 2rem;
            justify-content: center;
        }
        
        .mode-btn {
            padding: 0.7rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            background: transparent;
            color: var(--gray);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .mode-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        
        .progress-container {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 3px;
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            width: 0%;
            transition: width 0.5s linear;
            border-radius: 3px;
        }
        
        .fullscreen-btn {
            position: absolute;
            bottom: 2.5rem;
            right: 2.5rem;
            background: rgba(255, 255, 255, 0.15);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .fullscreen-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.1) rotate(90deg);
        }
        
        .notification {
            position: fixed;
            top: 2.5rem;
            right: 2.5rem;
            background: var(--success);
            color: white;
            padding: 1.2rem 1.8rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(-100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.68, -0.6, 0.32, 1.6);
            z-index: 100;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .notification.show {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
        
        h2 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
            color: var(--light);
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        @media (max-width: 1200px) {
            .container {
                grid-template-columns: 1fr;
                height: auto;
                max-height: 90vh;
                overflow-y: auto;
                padding: 1.5rem;
            }
            
            .panel {
                min-height: 400px;
            }
            
            .timer-display {
                font-size: 4.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .timer-controls, .timer-settings {
                flex-wrap: wrap;
            }
            
            .btn {
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
            }
            
            .timer-display {
                font-size: 3.5rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
        }
        
        /* Floating animation for panels */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .panel {
            animation: float 6s ease-in-out infinite;
        }
        
        .timer-panel {
            animation-delay: 0.5s;
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
  background-color: rgba(94, 77, 153, 0.53);
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
  background-color: rgba(26, 50, 75, 0.8);
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


<div class="controller-icon">
  <div class="profile-block">
    <a href="../loading_screen/laoding_modif.html"><img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" ></a>
  </div>
  <a href="../loading_screen/loading_game.html" title="Play Game">
    <i class="fas fa-gamepad"></i>
  </a>
  <a href="../ghub/gilo.html" title="GitHub">
    <i class="fab fa-github"></i>
  </a>
  <a href="../Ai/loding3.html" title="AI Chat">
    <i class="fas fa-robot"></i>
  </a>
  <a href="../loading_screen/loading_editor.html" title="Code Editor">
    <i class="fas fa-code"></i>
  </a>
  <a href="../media/media.html" title="Social Media">
    <i class="fas fa-users"></i>
  </a>
  <a href="../loading_screen/loading_main.html" title="main_page">
    <i class="fas fa-chalkboard"></i>
  </a>
</div>

    <!-- Fullscreen Spline Background -->
    <div class="spline-background">
        <spline-viewer url="https://prod.spline.design/XOnel5vnRnN4mHYm/scene.splinecode"></spline-viewer>
    </div>
    
    <div class="container">
        <div class="panel music-panel">
            <h2>Focus Music</h2>
            <div class="playlist">
                <iframe src="https://open.spotify.com/embed/playlist/2VV2tifRGiXCxo8PntCQPx?utm_source=generator&theme=0" 
                        width="100%" height="100%" frameBorder="0" allowfullscreen="" 
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" 
                        loading="lazy"></iframe>
            </div>
        </div>
        
        <div class="panel timer-panel">
            <h2>Focus Timer</h2>
            <div class="timer-mode">
                <button class="mode-btn active" id="pomodoro-btn">Work</button>
                <button class="mode-btn" id="short-break-btn">Short Break</button>
                <button class="mode-btn" id="long-break-btn">Long Break</button>
            </div>
            
            <div class="timer-display" id="timer">25:00</div>
            
            <div class="progress-container">
                <div class="progress-bar" id="progress-bar"></div>
            </div>
            
            <div class="timer-controls">
                <button class="btn btn-primary" id="start-btn">
                    <svg width="18" height="18" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 2L13 8L3 14V2Z" fill="currentColor"/>
                    </svg>
                    Start
                </button>
                <button class="btn btn-secondary" id="pause-btn" disabled>
                    <svg width="18" height="18" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="4" height="12" fill="currentColor"/>
                        <rect x="6" width="4" height="12" fill="currentColor"/>
                    </svg>
                    Pause
                </button>
                <button class="btn btn-danger" id="reset-btn">
                    <svg width="18" height="18" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 3V1L4 5L8 9V7C10.2091 7 12 8.79086 12 11C12 13.2091 10.2091 15 8 15C5.79086 15 4 13.2091 4 11H2C2 14.3137 4.68629 17 8 17C11.3137 17 14 14.3137 14 11C14 7.68629 11.3137 5 8 5V3Z" fill="currentColor"/>
                    </svg>
                    Reset
                </button>
            </div>
            
            <div class="timer-settings">
                <div class="time-option">
                    <label for="work-duration">Work (min)</label>
                    <input type="number" id="work-duration" value="25" min="1" max="60">
                </div>
                <div class="time-option">
                    <label for="short-break">Short Break (min)</label>
                    <input type="number" id="short-break" value="5" min="1" max="30">
                </div>
                <div class="time-option">
                    <label for="long-break">Long Break (min)</label>
                    <input type="number" id="long-break" value="15" min="1" max="60">
                </div>
            </div>
        </div>
    </div>
    
    <div class="notification" id="notification">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 8V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Time's up! Take a break.
    </div>
    
    <button class="fullscreen-btn" onclick="toggleFullscreen()">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 3H5C3.89543 3 3 3.89543 3 5V8M21 8V5C21 3.89543 20.1046 3 19 3H16M16 21H19C20.1046 21 21 20.1046 21 19V16M3 16V19C3 20.1046 3.89543 21 5 21H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
    
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.35/build/spline-viewer.js"></script>
    <script>
        // Remove Spline logo
        window.onload = function() {
            const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
            const logo = shadowRoot.querySelector('#logo');
            if (logo) logo.remove();
            
            // Ensure Spline background covers entire viewport
            const resizeBackground = () => {
                const splineViewer = document.querySelector('spline-viewer');
                if (splineViewer) {
                    splineViewer.style.width = '100vw';
                    splineViewer.style.height = '100vh';
                    splineViewer.style.position = 'fixed';
                    splineViewer.style.top = '0';
                    splineViewer.style.left = '0';
                }
            };
            
            resizeBackground();
            window.addEventListener('resize', resizeBackground);
        };
        
        // Timer functionality
        let timer;
        let isRunning = false;
        let currentMode = 'pomodoro';
        let timeLeft = 25 * 60;
        let totalTime = 25 * 60;
        
        const timerDisplay = document.getElementById('timer');
        const progressBar = document.getElementById('progress-bar');
        const startBtn = document.getElementById('start-btn');
        const pauseBtn = document.getElementById('pause-btn');
        const resetBtn = document.getElementById('reset-btn');
        const pomodoroBtn = document.getElementById('pomodoro-btn');
        const shortBreakBtn = document.getElementById('short-break-btn');
        const longBreakBtn = document.getElementById('long-break-btn');
        const workDurationInput = document.getElementById('work-duration');
        const shortBreakInput = document.getElementById('short-break');
        const longBreakInput = document.getElementById('long-break');
        const notification = document.getElementById('notification');
        const panels = document.querySelectorAll('.panel');
        
        // Add parallax effect to panels
        document.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            panels.forEach((panel, index) => {
                const offsetX = (x - 0.5) * 20 * (index % 2 ? 1 : -1);
                const offsetY = (y - 0.5) * 20;
                panel.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
            });
        });
        
        // Initialize timer
        updateTimerDisplay();
        
        // Mode switching
        pomodoroBtn.addEventListener('click', () => switchMode('pomodoro'));
        shortBreakBtn.addEventListener('click', () => switchMode('shortBreak'));
        longBreakBtn.addEventListener('click', () => switchMode('longBreak'));
        
        // Timer controls
        startBtn.addEventListener('click', startTimer);
        pauseBtn.addEventListener('click', pauseTimer);
        resetBtn.addEventListener('click', resetTimer);
        
        // Settings changes
        workDurationInput.addEventListener('change', updateSettings);
        shortBreakInput.addEventListener('change', updateSettings);
        longBreakInput.addEventListener('change', updateSettings);
        
        function switchMode(mode) {
            currentMode = mode;
            isRunning = false;
            clearInterval(timer);
            
            // Update active button
            pomodoroBtn.classList.remove('active');
            shortBreakBtn.classList.remove('active');
            longBreakBtn.classList.remove('active');
            
            if (mode === 'pomodoro') {
                pomodoroBtn.classList.add('active');
                timeLeft = parseInt(workDurationInput.value) * 60;
            } else if (mode === 'shortBreak') {
                shortBreakBtn.classList.add('active');
                timeLeft = parseInt(shortBreakInput.value) * 60;
            } else {
                longBreakBtn.classList.add('active');
                timeLeft = parseInt(longBreakInput.value) * 60;
            }
            
            totalTime = timeLeft;
            updateTimerDisplay();
            updateProgressBar();
            
            // Enable start button
            startBtn.disabled = false;
            pauseBtn.disabled = true;
        }
        
        function startTimer() {
            if (isRunning) return;
            
            isRunning = true;
            timer = setInterval(() => {
                if (timeLeft > 0) {
                    timeLeft--;
                    updateTimerDisplay();
                    updateProgressBar();
                } else {
                    clearInterval(timer);
                    isRunning = false;
                    showNotification();
                    
                    // Auto switch to break after pomodoro
                    if (currentMode === 'pomodoro') {
                        const breakMode = timeLeft % 2 === 0 ? 'shortBreak' : 'longBreak';
                        switchMode(breakMode);
                    } else {
                        switchMode('pomodoro');
                    }
                }
            }, 1000);
            
            startBtn.disabled = true;
            pauseBtn.disabled = false;
        }
        
        function pauseTimer() {
            if (!isRunning) return;
            
            clearInterval(timer);
            isRunning = false;
            startBtn.disabled = false;
            pauseBtn.disabled = true;
        }
        
        function resetTimer() {
            clearInterval(timer);
            isRunning = false;
            
            if (currentMode === 'pomodoro') {
                timeLeft = parseInt(workDurationInput.value) * 60;
            } else if (currentMode === 'shortBreak') {
                timeLeft = parseInt(shortBreakInput.value) * 60;
            } else {
                timeLeft = parseInt(longBreakInput.value) * 60;
            }
            
            totalTime = timeLeft;
            updateTimerDisplay();
            updateProgressBar();
            startBtn.disabled = false;
            pauseBtn.disabled = true;
        }
        
        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            
            // Pulse animation when time is running
            if (isRunning) {
                timerDisplay.style.animation = 'pulse 1s infinite alternate';
            } else {
                timerDisplay.style.animation = 'none';
            }
        }
        
        function updateProgressBar() {
            const progress = ((totalTime - timeLeft) / totalTime) * 100;
            progressBar.style.width = `${progress}%`;
            
            // Change color based on mode
            if (currentMode === 'pomodoro') {
                progressBar.style.background = 'linear-gradient(90deg, var(--primary), var(--primary-dark))';
            } else {
                progressBar.style.background = 'linear-gradient(90deg, var(--secondary), #e11d48)';
            }
        }
        
        function updateSettings() {
            if (currentMode === 'pomodoro') {
                timeLeft = parseInt(workDurationInput.value) * 60;
            } else if (currentMode === 'shortBreak') {
                timeLeft = parseInt(shortBreakInput.value) * 60;
            } else {
                timeLeft = parseInt(longBreakInput.value) * 60;
            }
            
            totalTime = timeLeft;
            updateTimerDisplay();
            updateProgressBar();
        }
        
        function showNotification() {
            notification.textContent = currentMode === 'pomodoro' 
                ? "Time's up! Take a break." 
                : "Break's over! Time to focus.";
            notification.classList.add('show');
            
            // Add vibration if supported
            if ('vibrate' in navigator) {
                navigator.vibrate([200, 100, 200]);
            }
            
            // Play sound if allowed
            const audio = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-alarm-digital-clock-beep-989.mp3');
            audio.volume = 0.3;
            audio.play().catch(e => console.log('Audio playback prevented:', e));
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }
        
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.error(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                e.preventDefault();
                if (isRunning) {
                    pauseTimer();
                } else {
                    startTimer();
                }
            }
            
            if (e.code === 'KeyP') {
                e.preventDefault();
                switchMode('pomodoro');
            }
            
            if (e.code === 'KeyS') {
                e.preventDefault();
                switchMode('shortBreak');
            }
            
            if (e.code === 'KeyL') {
                e.preventDefault();
                switchMode('longBreak');
            }
            
            if (e.code === 'KeyR') {
                e.preventDefault();
                resetTimer();
            }
            
            if (e.code === 'KeyF') {
                e.preventDefault();
                toggleFullscreen();
            }
        });
        
        // Add pulse animation for timer
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
        `;
        document.head.appendChild(style);
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