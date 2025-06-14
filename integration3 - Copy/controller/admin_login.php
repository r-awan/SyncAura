<?php
include '../config.php';

session_start();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']); // Consider using password_hash() instead
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
    $select_admin->execute([$name, $pass]);

    if ($select_admin->rowCount() > 0) {
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location:../views/dash/dash.php');
        exit();
    } else {
        $message[] = 'Incorrect username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        body {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #000;
        }

        /* Spline 3D Background */
        .spline-viewer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 1;
        }

        .spline-viewer spline-viewer {
            width: 100%;
            height: 100%;
        }



        /* Form container with glassmorphism effect */
        .form-container {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(59, 130, 246, 0.2);
            padding: 50px 40px;
            border-radius: 25px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.2) inset;
            width: 100%;
            max-width: 420px;
            animation: slideInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform-style: preserve-3d;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.05) 0%,
                rgba(139, 92, 246, 0.03) 50%,
                rgba(236, 72, 153, 0.05) 100%);
            border-radius: 25px;
            z-index: -1;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }



        .form-container h3 {
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 10px rgba(30, 58, 138, 0.3);
        }

        .form-container p {
            text-align: center;
            color: #1e40af;
            font-size: 0.95rem;
            margin-bottom: 20px;
            font-weight: 500;
        }

        /* Input field styling */
        .input-group {
            position: relative;
            margin: 25px 0;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 18px 20px;
            border-radius: 15px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            font-size: 1rem;
            color: #1e40af;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            outline: none;
            font-weight: 500;
        }

        .form-container input[type="text"]::placeholder,
        .form-container input[type="password"]::placeholder {
            color: #60a5fa;
            font-weight: 400;
        }

        .form-container input[type="text"]:focus,
        .form-container input[type="password"]:focus {
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.4);
            box-shadow: 
                0 0 25px rgba(59, 130, 246, 0.4),
                0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
            color: #1e40af;
        }

        /* Button styling */
        .form-container .btn {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
            color: #fff;
            padding: 18px;
            border: none;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            position: relative;
            overflow: hidden;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .form-container .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .form-container .btn:hover::before {
            left: 100%;
        }

        .form-container .btn:hover {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 50%, #db2777 100%);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.5);
        }

        .form-container .btn:active {
            transform: translateY(-1px);
        }

        /* Message styling */
        .message {
            position: fixed;
            top: 30px;
            right: 30px;
            background: rgba(248, 215, 218, 0.95);
            backdrop-filter: blur(10px);
            color: #721c24;
            padding: 15px 20px;
            border: 1px solid rgba(245, 198, 203, 0.8);
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            animation: slideInRight 0.5s ease;
            z-index: 1000;
            min-width: 300px;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .message span {
            font-size: 1rem;
            font-weight: 500;
        }

        .message i {
            cursor: pointer;
            font-size: 1.2rem;
            color: #721c24;
            transition: color 0.3s ease;
            margin-left: 15px;
        }

        .message i:hover {
            color: #dc3545;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .form-container {
                margin: 20px;
                padding: 40px 30px;
                max-width: none;
            }
            
            .form-container h3 {
                font-size: 1.8rem;
            }
            
            .message {
                top: 20px;
                right: 20px;
                left: 20px;
                min-width: auto;
            }
        }

        /* Loading animation for inputs */
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .form-container input:invalid {
            animation: pulse 2s infinite;
        }
    </style>
</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message">
                <span>' . $message . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>

    
    <div class="spline-viewer">
        <spline-viewer url="https://prod.spline.design/51mMRPdfFukJLVWC/scene.splinecode"></spline-viewer>
    </div>

    <section class="form-container">
        <form action="" method="POST">
            <h3>Login Now</h3>
            <div class="input-group">
                <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <div class="input-group">
                <input type="password" name="pass" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <input type="submit" value="Login Now" name="submit" class="btn">
        </form>
    </section>
    
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.10.2/build/spline-viewer.js"></script>
    <script>
         window.onload = function() {
        const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
        if (shadowRoot) {
            const logo = shadowRoot.querySelector('#logo');
            if (logo) logo.remove();
        }
    }
    </script>
</body>

</html>