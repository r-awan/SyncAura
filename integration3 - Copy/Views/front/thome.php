
<?php
include '../../confige.php';
session_start();

// Check if user is logged in
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
   $profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'imggg.png';
}else{
   // Redirect to login if not logged in
   header("Location: sign/signin.php");
   exit();
}

// Include database functions
include '../../models/post_functions.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_post'])) {
        $title = $_POST['post_title'] ?? '';
        $content = $_POST['post_content'] ?? '';
        $category = $_POST['post_category'] ?? 'General';
        
        $media_type = 'none';
        $media_path = null;
        
        // Handle file upload
        if (isset($_FILES['post_media']) && $_FILES['post_media']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_ext = strtolower(pathinfo($_FILES['post_media']['name'], PATHINFO_EXTENSION));
            $allowed_image = ['jpg', 'jpeg', 'png', 'gif'];
            $allowed_video = ['mp4', 'mov', 'avi'];
            
            if (in_array($file_ext, $allowed_image)) {
                $media_type = 'image';
            } elseif (in_array($file_ext, $allowed_video)) {
                $media_type = 'video';
            }
            
            if ($media_type !== 'none') {
                $file_name = uniqid() . '.' . $file_ext;
                $file_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['post_media']['tmp_name'], $file_path)) {
                    $media_path = 'uploads/' . $file_name;
                }
            }
        }
        
        if (!empty($content)) {
            createPost($user_id, $title, $content, $media_type, $media_path, $category);
            header("Location: thome.php");
            exit();
        }
    } elseif (isset($_POST['like_post'])) {
        $post_id = $_POST['post_id'];
        likePost($user_id, $post_id);
        header("Location: thome.php");
        exit();
    } elseif (isset($_POST['add_comment'])) {
        $post_id = $_POST['post_id'];
        $comment_content = $_POST['comment_content'];
        addComment($user_id, $post_id, $comment_content);
        header("Location: thome.php");
        exit();
    } elseif (isset($_POST['delete_post'])) {
        $post_id = $_POST['post_id'];
        // Verify that the user owns the post before deleting
        $post = getPostById($post_id);
        if ($post && $post['user_id'] == $user_id) {
            deletePost($post_id);
        }
        header("Location: thome.php");
        exit();
    }
}

// Get all posts
$posts = getAllPosts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyncAura Blog</title>
    <link rel="shortcut icon" href="imggg.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1d3557;
            --secondary: #457b9d;
            --accent: #e63946;
            --light: #f1faee;
            --dark: #0d1b2a;
            --dark-bg: #0f172a;
            --card-bg: #1e293b;
            --text-light: #f8fafc;
            --text-gray: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --transition: all 0.3s ease;
            --border-radius: 16px;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            --hover-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg), #0c1a2d);
            color: var(--text-light);
            padding-top: 80px;
            min-height: 100vh;
            line-height: 1.6;
        }
        
        .social-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
            display: grid;
            grid-template-columns: 280px 1fr 320px;
            gap: 25px;
        }
        
        /* Navigation */
        .site-navigation {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 50px;
            width: 100%;
            height: 80px;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-left, .nav-right {
            display: flex;
            align-items: center;
            gap: 30px;
        }
        
        .syncaura-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-light);
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
        }
        
        .syncaura-logo img {
            height: 45px;
            filter: drop-shadow(0 0 5px rgba(69, 123, 157, 0.7));
        }
        
        .site-menu {
            display: flex;
            list-style: none;
            gap: 25px;
        }
        
        .site-menu a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            padding: 10px 0;
            position: relative;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .site-menu a:hover,
        .site-menu a.active {
            color: white;
        }
        
        .site-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: var(--accent);
            transition: var(--transition);
        }
        
        .site-menu a:hover::after,
        .site-menu a.active::after {
            width: 100%;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }
        
        .user-profile img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary);
            transition: var(--transition);
            cursor: pointer;
        }
        
        .user-profile img:hover {
            transform: scale(1.1);
            border-color: var(--accent);
        }
        
        .username {
            color: white;
            font-weight: 500;
        }
        
        .logout-btn {
            background: rgba(230, 57, 70, 0.2);
            padding: 8px 20px;
            border-radius: 30px;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(230, 57, 70, 0.3);
        }
        
        .logout-btn:hover {
            background: rgba(230, 57, 70, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(230, 57, 70, 0.2);
        }
        
        .search-container {
            position: relative;
        }
        
        .search-container input {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 10px 20px 10px 45px;
            color: white;
            width: 240px;
            font-size: 0.95rem;
            transition: var(--transition);
        }
        
        .search-container input:focus {
            outline: none;
            border-color: var(--secondary);
            background: rgba(69, 123, 157, 0.15);
            box-shadow: 0 0 0 3px rgba(69, 123, 157, 0.2);
            width: 300px;
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
        }
        
        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }
        
        .sidebar-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .sidebar-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .card-header h2 {
            font-size: 1.3rem;
            color: var(--text-light);
            font-weight: 600;
        }
        
        .card-header i {
            color: var(--secondary);
            font-size: 1.2rem;
        }
        
        .profile-info {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-radius: 12px;
            transition: var(--transition);
            cursor: pointer;
            background: rgba(255, 255, 255, 0.03);
        }
        
        .profile-info:hover {
            background: rgba(69, 123, 157, 0.15);
        }
        
        .profile-info img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary);
        }
        
        .profile-text h3 {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 5px;
        }
        
        .profile-text p {
            color: var(--text-gray);
            font-size: 0.9rem;
        }
        
        .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .stat-item {
            text-align: center;
            padding: 0 10px;
        }
        
        .stat-item .count {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--accent);
        }
        
        .stat-item .label {
            font-size: 0.85rem;
            color: var(--text-gray);
        }
        
        .trending-topics {
            list-style: none;
        }
        
        .trending-topics li {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }
        
        .trending-topics li:last-child {
            border-bottom: none;
        }
        
        .trending-topics li:hover {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            padding: 12px 15px;
            margin: 0 -15px;
        }
        
        .trending-topics a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-light);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .trending-topics a:hover {
            color: var(--secondary);
        }
        
        .trending-topics .hashtag {
            color: var(--secondary);
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .trending-topics .trend-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--text-gray);
            margin-top: 5px;
        }
        
        .trending-topics .trend-count {
            color: var(--accent);
        }
        
        /* Main Content */
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .create-post-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .create-post-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--hover-shadow);
        }
        
        .create-post-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .create-post-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary);
        }
        
        .post-input {
            width: 100%;
            height: 120px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            resize: none;
            font-family: inherit;
            font-size: 1rem;
            transition: var(--transition);
            color: var(--text-light);
        }
        
        .post-input:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(69, 123, 157, 0.2);
            background: rgba(69, 123, 157, 0.1);
        }
        
        .post-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }
        
        .action-icons {
            display: flex;
            gap: 12px;
        }
        
        .action-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            background: rgba(255, 255, 255, 0.08);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .action-icon:hover {
            background: var(--secondary);
            color: white;
            transform: translateY(-3px);
        }
        
        .action-icon i {
            transition: var(--transition);
        }
        
        .action-icon:hover i {
            transform: scale(1.2);
        }
        
        .action-icon input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .post-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 15px rgba(29, 53, 87, 0.3);
        }
        
        .post-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(29, 53, 87, 0.4);
        }
        
        /* Posts */
        .post-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        .post-header {
            display: flex;
            align-items: center;
            padding: 20px;
            gap: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .post-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary);
            transition: var(--transition);
            cursor: pointer;
        }
        
        .post-header img:hover {
            transform: scale(1.1);
            border-color: var(--accent);
        }
        
        .post-author {
            flex: 1;
        }
        
        .post-author h3 {
            font-size: 1.1rem;
            color: var(--text-light);
            font-weight: 600;
        }
        
        .post-author .time {
            font-size: 0.85rem;
            color: var(--text-gray);
        }
        
        .post-category {
            background: rgba(69, 123, 157, 0.2);
            color: var(--secondary);
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .post-content {
            padding: 20px;
        }
        
        .post-title {
            font-size: 1.5rem;
            color: var(--text-light);
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .post-text {
            font-size: 1.05rem;
            line-height: 1.7;
            color: var(--text-light);
            margin-bottom: 20px;
            opacity: 0.9;
        }
        
        .post-image {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 20px;
            max-height: 500px;
            object-fit: cover;
            transition: var(--transition);
            cursor: pointer;
        }
        
        .post-image:hover {
            transform: scale(1.02);
        }
        
        video.post-image {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 20px;
            max-height: 500px;
            background: #000;
        }
        
        .post-stats {
            display: flex;
            justify-content: space-between;
            padding: 0 20px 15px;
            color: var(--text-gray);
            font-size: 0.9rem;
        }
        
        .post-actions-bar {
            display: flex;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .post-action {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 15px;
            color: var(--text-gray);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }
        
        .post-action:hover {
            background: rgba(69, 123, 157, 0.1);
            color: var(--secondary);
        }
        
        .post-action.active {
            color: var(--accent);
        }
        
        .post-action.active i {
            transform: scale(1.2);
        }
        
        .post-action i {
            transition: var(--transition);
        }
        
        .post-comments {
            padding: 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
        }
        
        .post-comments.expanded {
            max-height: 1000px;
        }
        
        .comment {
            margin-bottom: 15px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            animation: fadeIn 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .comment-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }
        
        .comment-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--secondary);
        }
        
        .comment-author {
            font-weight: 500;
            color: var(--text-light);
        }
        
        .comment-time {
            font-size: 0.8rem;
            color: var(--text-gray);
        }
        
        .comment-text {
            font-size: 0.95rem;
            line-height: 1.5;
            color: var(--text-light);
            opacity: 0.9;
        }
        
        .comment-input-container {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            align-items: center;
        }
        
        .comment-input-container img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .comment-input {
            flex: 1;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-light);
            transition: var(--transition);
        }
        
        .comment-input:focus {
            outline: none;
            border-color: var(--secondary);
            background: rgba(69, 123, 157, 0.1);
        }
        
        .comment-btn {
            background: var(--secondary);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .comment-btn:hover {
            background: var(--accent);
            transform: scale(1.1);
        }
        
        /* Right Sidebar */
        .right-sidebar .sidebar-card {
            padding: 25px;
        }
        
        .news-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .news-header h2 {
            font-size: 1.2rem;
            color: var(--text-light);
        }
        
        .news-header a {
            color: var(--secondary);
            font-size: 0.9rem;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .news-header a:hover {
            color: var(--accent);
        }
        
        .news-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }
        
        .news-item:hover {
            transform: translateX(5px);
        }
        
        .news-item:last-child {
            border-bottom: none;
        }
        
        .news-content h3 {
            font-size: 1rem;
            margin-bottom: 5px;
            color: var(--text-light);
        }
        
        .news-content p {
            font-size: 0.85rem;
            color: var(--text-gray);
        }
        
        .news-badge {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            font-size: 0.75rem;
            padding: 3px 10px;
            border-radius: 30px;
            margin-top: 8px;
            display: inline-block;
        }
        
        .ad-container {
            background: linear-gradient(135deg, #1d3557, #2a4d6e);
            border-radius: var(--border-radius);
            padding: 30px 25px;
            color: white;
            text-align: center;
            margin-top: 20px;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }
        
        .ad-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
            pointer-events: none;
        }
        
        .ad-container h3 {
            font-size: 1.4rem;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .ad-container p {
            margin-bottom: 20px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        
        .ad-btn {
            background: white;
            color: var(--primary);
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            z-index: 1;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .ad-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            background: var(--light);
        }
        
        /* Events */
        .event {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }
        
        .event:hover {
            transform: translateX(5px);
        }
        
        .event:last-child {
            border-bottom: none;
        }
        
        .event-date {
            text-align: center;
            min-width: 50px;
        }
        
        .event-date .day {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--accent);
        }
        
        .event-date .month {
            font-size: 0.8rem;
            color: var(--text-gray);
            text-transform: uppercase;
        }
        
        .event-details h3 {
            font-size: 1rem;
            margin-bottom: 5px;
            color: var(--text-light);
        }
        
        .event-details p {
            font-size: 0.85rem;
            color: var(--text-gray);
        }
        
        /* Footer */
        .social-footer {
            text-align: center;
            padding: 30px 0;
            color: var(--text-gray);
            font-size: 0.9rem;
            margin-top: 50px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Floating Controller */
        .controller-icon {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 15px;
            background: var(--card-bg);
            padding: 15px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .controller-icon a {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(29, 53, 87, 0.3);
        }
        
        .controller-icon a:hover {
            transform: translateY(-5px) scale(1.1);
            background: linear-gradient(135deg, var(--secondary), var(--accent));
            box-shadow: 0 8px 20px rgba(230, 57, 70, 0.3);
        }
        
        /* Stats Chart */
        .chart-container {
            height: 180px;
            margin-top: 15px;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .social-container {
                grid-template-columns: 250px 1fr;
            }
            
            .right-sidebar {
                display: none;
            }
        }
        
        @media (max-width: 992px) {
            .social-container {
                grid-template-columns: 1fr;
                padding: 20px;
            }
            
            .sidebar {
                display: none;
            }
            
            .site-menu {
                display: none;
            }
            
            .search-container input {
                width: 180px;
            }
            
            .search-container input:focus {
                width: 220px;
            }
        }
        
        @media (max-width: 768px) {
            .nav-left, .nav-right {
                gap: 15px;
            }
            
            .syncaura-logo {
                font-size: 1.5rem;
            }
            
            .syncaura-logo img {
                height: 35px;
            }
            
            .search-container {
                display: none;
            }
            
            .logout-btn span {
                display: none;
            }
            
            .logout-btn {
                padding: 10px;
                border-radius: 50%;
            }
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
<nav class="site-navigation">
  <div class="nav-left">
    <a href="#" class="syncaura-logo">
      <img src="../dash/user/user_dash/imggg.png" alt="SyncAura Logo">
      SyncAura
    </a>
    <ul class="site-menu">
      <li><a href="loading_screen/loading_meet.html"><i class="fas fa-video"></i> MEET</a></li>
      <li><a href="loading_screen/loading_p.html"><i class="fas fa-clock"></i> POMODORO</a></li>
      <li><a href="loading_screen/loadngg.php"><i class="fas fa-shopping-cart"></i> PACKS</a></li>
      <li><a href="todolist/loading_todo.html"><i class="fas fa-tasks"></i> To Do</a></li>
      <li><a href="loading_screen/loadng.html"><i class="fas fa-comments"></i> Chat</a></li>
      <li><a href="loading_screen/loading_share.html"><i class="fas fa-share-alt"></i> Share</a></li>
      <li><a href="thome.php" class="active"><i class="fas fa-blog"></i> Blog</a></li>
    </ul>
  </div>
  <div class="nav-right">
    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" placeholder="Search posts...">
    </div>
    <div class="user-info">
        <div class="user-profile">
        </div>
    </div>
  </div>
</nav>

<div class="social-container">
    <!-- Left Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-card">
            <div class="profile-info">
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile">
                <div class="profile-text">
                    <h3><?php echo htmlspecialchars($username); ?></h3>
                    <p>SyncAura User</p>
                </div>
            </div>
            
            <div class="stats">
                <div class="stat-item">
                    <div class="count">245</div>
                    <div class="label">Connections</div>
                </div>
                <div class="stat-item">
                    <div class="count">1.2K</div>
                    <div class="label">Followers</div>
                </div>
                <div class="stat-item">
                    <div class="count">28</div>
                    <div class="label">Posts</div>
                </div>
            </div>
            
            <div class="chart-container">
                <canvas id="engagementChart"></canvas>
            </div>
        </div>
        
        <div class="sidebar-card">
            <div class="card-header">
                <i class="fas fa-hashtag"></i>
                <h2>Trending Topics</h2>
            </div>
            <ul class="trending-topics">
                <li>
                    <a href="#">
                        <span class="hashtag">#</span> 
                        <div>
                            <div>WebDevelopment</div>
                            <div class="trend-meta">
                                <span>2.5K posts</span>
                                <span class="trend-count"><i class="fas fa-fire"></i> Hot</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="hashtag">#</span> 
                        <div>
                            <div>JavaScript</div>
                            <div class="trend-meta">
                                <span>1.8K posts</span>
                                <span class="trend-count"><i class="fas fa-chart-line"></i> Rising</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="hashtag">#</span> 
                        <div>
                            <div>UXDesign</div>
                            <div class="trend-meta">
                                <span>1.2K posts</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="hashtag">#</span> 
                        <div>
                            <div>RemoteWork</div>
                            <div class="trend-meta">
                                <span>980 posts</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="hashtag">#</span> 
                        <div>
                            <div>TechNews</div>
                            <div class="trend-meta">
                                <span>750 posts</span>
                                <span class="trend-count"><i class="fas fa-bolt"></i> New</span>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="sidebar-card">
            <div class="card-header">
                <i class="fas fa-user-friends"></i>
                <h2>Suggested People</h2>
            </div>
            <div class="suggestions">
                <div class="profile-info">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Profile">
                    <div class="profile-text">
                        <h3>Sarah Johnson</h3>
                        <p>Product Designer</p>
                    </div>
                    <button class="follow-btn">Follow</button>
                </div>
                <div class="profile-info">
                    <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Profile">
                    <div class="profile-text">
                        <h3>Michael Chen</h3>
                        <p>Data Scientist</p>
                    </div>
                    <button class="follow-btn">Follow</button>
                </div>
                <div class="profile-info">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Profile">
                    <div class="profile-text">
                        <h3>Emma Rodriguez</h3>
                        <p>Frontend Developer</p>
                    </div>
                    <button class="follow-btn">Follow</button>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- News Notifications -->
        <div class="news-icon" id="news-icon">
            <i class="fas fa-newspaper"></i>
            <span class="news-badge">5</span>
        </div>
        <div id="news-notifications" class="news-notifications hidden">
            <div class="news-header">
                <i class="fas fa-newspaper"></i>
                <h3>Tech News Updates</h3>
                <button class="close-news" id="close-news">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="news-container" class="news-container"></div>
        </div>

        <style>
            .news-icon {
                position: fixed;
                top: 20px;
                right: 30px;
                width: 40px;
                height: 40px;
                background: var(--accent);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 1000;
                transition: var(--transition);
            }

            .news-icon i {
                color: white;
                font-size: 1.2rem;
            }

            .news-icon:hover {
                transform: scale(1.1);
            }

            .news-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: var(--secondary);
                color: white;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                font-size: 0.8rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .news-notifications {
                position: fixed;
                top: 70px;
                right: 30px;
                width: 300px;
                background: var(--card-bg);
                border-radius: var(--border-radius);
                box-shadow: var(--card-shadow);
                z-index: 999;
                overflow: hidden;
                transition: var(--transition);
                opacity: 1;
                transform: translateY(0);
            }

            .news-notifications.hidden {
                opacity: 0;
                transform: translateY(-20px);
                pointer-events: none;
            }

            .news-header {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 15px 20px;
                background: rgba(255, 255, 255, 0.05);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .news-header i {
                color: var(--accent);
            }

            .news-header h3 {
                color: var(--text-light);
                font-size: 1.1rem;
                font-weight: 500;
                margin: 0;
            }

            .news-container {
                max-height: 400px;
                overflow-y: auto;
                padding: 15px;
            }

            .news-item {
                padding: 12px;
                border-radius: 8px;
                background: rgba(255, 255, 255, 0.05);
                margin-bottom: 10px;
                transition: var(--transition);
            }

            .news-item:hover {
                background: rgba(255, 255, 255, 0.1);
                transform: translateY(-2px);
            }

            .news-item h4 {
                color: var(--text-light);
                font-size: 0.95rem;
                margin-bottom: 8px;
            }

            .news-item p {
                color: var(--text-gray);
                font-size: 0.85rem;
                margin-bottom: 8px;
            }

            .news-item a {
                color: var(--secondary);
                font-size: 0.85rem;
                text-decoration: none;
                display: inline-block;
                transition: var(--transition);
            }

            .news-item a:hover {
                color: var(--accent);
            }

            .news-time {
                color: var(--text-gray);
                font-size: 0.8rem;
                margin-top: 5px;
            }
        </style>

        <script>
            let mediaRecorder;
            let audioChunks = [];
            let recordingTimer;
            let recordingTime = 0;
            const assemblyAIKey = 'd2b4b56fd9d44e3fb38085b797176e00';
            let isRecording = false;

            async function toggleVoiceRecording() {
                const voiceBtn = document.getElementById('voice-input-btn');
                const recordingStatus = document.getElementById('recording-status');
                const postInput = document.querySelector('textarea[name="post_content"]');

                if (!isRecording) {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        mediaRecorder = new MediaRecorder(stream);
                        audioChunks = [];

                        mediaRecorder.ondataavailable = (event) => {
                            audioChunks.push(event.data);
                        };

                        mediaRecorder.onstop = async () => {
                            const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                            await transcribeAudio(audioBlob);
                            stream.getTracks().forEach(track => track.stop());
                        };

                        mediaRecorder.start();
                        isRecording = true;
                        voiceBtn.style.color = 'var(--accent)';
                        recordingStatus.style.display = 'inline';
                        startRecordingTimer();
                    } catch (err) {
                        console.error('Error accessing microphone:', err);
                        alert('Error accessing microphone. Please check permissions.');
                    }
                } else {
                    stopRecording();
                }
            }

            function stopRecording() {
                if (mediaRecorder && isRecording) {
                    mediaRecorder.stop();
                    isRecording = false;
                    document.getElementById('voice-input-btn').style.color = '';
                    document.getElementById('recording-status').style.display = 'none';
                    clearInterval(recordingTimer);
                    recordingTime = 0;
                }
            }

            function startRecordingTimer() {
                const timerDisplay = document.getElementById('recording-time');
                recordingTimer = setInterval(() => {
                    recordingTime++;
                    const minutes = Math.floor(recordingTime / 60);
                    const seconds = recordingTime % 60;
                    timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                }, 1000);
            }

            async function transcribeAudio(audioBlob) {
                try {
                    // First, upload the audio file
                    const formData = new FormData();
                    formData.append('audio', audioBlob);

                    const uploadResponse = await fetch('https://api.assemblyai.com/v2/upload', {
                        method: 'POST',
                        headers: {
                            'authorization': assemblyAIKey
                        },
                        body: audioBlob
                    });

                    const uploadResult = await uploadResponse.json();
                    const audioUrl = uploadResult.upload_url;

                    // Then, start the transcription
                    const transcribeResponse = await fetch('https://api.assemblyai.com/v2/transcript', {
                        method: 'POST',
                        headers: {
                            'authorization': assemblyAIKey,
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            audio_url: audioUrl,
                            language_code: 'en'
                        })
                    });

                    const transcribeResult = await transcribeResponse.json();
                    const transcriptId = transcribeResult.id;

                    // Poll for the result
                    while (true) {
                        const pollingResponse = await fetch(`https://api.assemblyai.com/v2/transcript/${transcriptId}`, {
                            headers: {
                                'authorization': assemblyAIKey
                            }
                        });

                        const result = await pollingResponse.json();

                        if (result.status === 'completed') {
                            const postInput = document.querySelector('textarea[name="post_content"]');
                            postInput.value += (postInput.value ? '\n' : '') + result.text;
                            break;
                        } else if (result.status === 'error') {
                            throw new Error(`Transcription failed: ${result.error}`);
                        }

                        await new Promise(resolve => setTimeout(resolve, 1000));
                    }
                } catch (error) {
                    console.error('Transcription error:', error);
                    alert('Error transcribing audio. Please try again.');
                }
            }

            // Stop recording if the user navigates away
            window.addEventListener('beforeunload', stopRecording);
            const apiKey = '9dc2b782420048d1b5ef6e5f92cdcfc9';
            const newsContainer = document.getElementById('news-container');

            async function fetchTechNews() {
                try {
                    const response = await fetch(`https://newsapi.org/v2/top-headlines?category=technology&apiKey=${apiKey}&pageSize=5`);
                    const data = await response.json();

                    if (data.articles) {
                        newsContainer.innerHTML = '';
                        data.articles.forEach(article => {
                            const newsItem = document.createElement('div');
                            newsItem.className = 'news-item';
                            newsItem.innerHTML = `
                                <h4>${article.title}</h4>
                                <p>${article.description || ''}</p>
                                <a href="${article.url}" target="_blank">Read more</a>
                                <div class="news-time">${new Date(article.publishedAt).toLocaleString()}</div>
                            `;
                            newsContainer.appendChild(newsItem);
                        });
                    }
                } catch (error) {
                    console.error('Error fetching news:', error);
                }
            }

            // Fetch news initially
            fetchTechNews();

            // Update news every 5 minutes
            setInterval(fetchTechNews, 300000);

            // Toggle news panel
            const newsIcon = document.getElementById('news-icon');
            const newsPanel = document.getElementById('news-notifications');
            const closeNews = document.getElementById('close-news');

            newsIcon.addEventListener('click', () => {
                newsPanel.classList.remove('hidden');
            });

            closeNews.addEventListener('click', () => {
                newsPanel.classList.add('hidden');
            });
        </script>

        <!-- Create Post Card -->
        <div class="create-post-card">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="create-post-header">
                    <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile">
                    <div style="width: 100%;">
                        <input type="text" name="post_title" placeholder="Post title" class="post-input" style="height: 50px; margin-bottom: 10px;">
                        <textarea name="post_content" class="post-input" placeholder="What's on your mind, <?php echo htmlspecialchars($username); ?>?" required></textarea>
                    </div>
                </div>
                <div class="post-actions">
                    <div class="action-icons">
                        <label class="action-icon" title="Add Image">
                            <i class="fas fa-image"></i>
                            <input type="file" name="post_media" accept="image/*" onchange="previewMedia(this, 'image')">
                        </label>
                        <label class="action-icon" title="Add Video">
                            <i class="fas fa-video"></i>
                            <input type="file" name="post_media" accept="video/*" onchange="previewMedia(this, 'video')">
                        </label>
                        <div class="action-icon" id="voice-input-btn" title="Voice Input" onclick="toggleVoiceRecording()">
                            <i class="fas fa-microphone"></i>
                        </div>
                        <div id="recording-status" style="display: none; color: var(--accent); margin-left: 10px;">
                            Recording... <span id="recording-time">0:00</span>
                        </div>
                        <div id="media-preview" style="display: none; margin-top: 10px; width: 100%;">
                            <img id="image-preview" style="max-width: 100%; display: none;">
                            <video id="video-preview" style="max-width: 100%; display: none;" controls></video>
                            <button type="button" onclick="clearMediaPreview()" style="background: none; border: none; color: #ff4444; cursor: pointer; margin-top: 5px;">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                        <div class="action-icon" title="Category">
                            <i class="fas fa-tag"></i>
                            <select name="post_category" style="border: none; background: transparent; margin-left: 5px; color: white;">
                                <option value="General">General</option>
                                <option value="Technology">Technology</option>
                                <option value="Business">Business</option>
                                <option value="Education">Education</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="create_post" class="post-btn">Post</button>
                </div>
            </form>
        </div>
        
        <!-- Display Posts -->
        <?php foreach ($posts as $post): ?>
        <div class="post-card">
            <div class="post-header">
                <a href="user_posts.php?user_id=<?php echo htmlspecialchars($post['user_id']); ?>">
                    <img src="<?php echo htmlspecialchars($post['profile_picture']); ?>" alt="Author Profile Picture" style="cursor: pointer;">
                </a>
                <div class="post-author">
                    <h3><?php echo htmlspecialchars($post['username']); ?></h3>
                    <div class="time"><?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></div>
                </div>
                <div class="post-category"><?php echo htmlspecialchars($post['category']); ?></div>
                <?php if ($post['user_id'] == $user_id): ?>
                <form action="" method="POST" style="margin-left: auto;">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <button type="submit" name="delete_post" class="delete-post-btn" style="background: none; border: none; color: #ff4444; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this post?');">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                <?php endif; ?>
            </div>
            
            <div class="post-content">
                <?php if (!empty($post['title'])): ?>
                    <h2 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                <?php endif; ?>
                <p class="post-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                
                <?php if ($post['media_type'] === 'image' && $post['media_path']): ?>
                    <img src="../../<?php echo htmlspecialchars($post['media_path']); ?>" alt="Post Image" class="post-image">
                <?php elseif ($post['media_type'] === 'video' && $post['media_path']): ?>
                    <video class="post-image" controls>
                        <source src="../../<?php echo htmlspecialchars($post['media_path']); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
                
                <div class="post-stats">
                    <span><?php echo getLikeCount($post['post_id']); ?> likes</span>
                    <span>• <?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                </div>
            </div>
            
            <div class="post-actions-bar">
                <form action="" method="POST" class="post-action <?php echo isLikedByUser($user_id, $post['post_id']) ? 'active' : ''; ?>">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <button type="submit" name="like_post" style="background: none; border: none; color: inherit; cursor: pointer;">
                        <i class="fas fa-heart"></i> Like
                    </button>
                </form>
                <div class="post-action" onclick="toggleComments(this)">
                    <i class="fas fa-comment"></i> Comment
                </div>
                <div class="post-action">
                    <i class="fas fa-share"></i> Share
                </div>
            </div>
            
            <div class="post-comments">
                <?php $comments = getComments($post['post_id']); ?>
                <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <div class="comment-header">
                        <img src="<?php echo htmlspecialchars($comment['profile_picture']); ?>" alt="Commenter" class="comment-avatar">
                        <span class="comment-author"><?php echo htmlspecialchars($comment['username']); ?></span>
                        <span class="comment-time"><?php echo date('F j, Y, g:i a', strtotime($comment['created_at'])); ?></span>
                    </div>
                    <p class="comment-text"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                </div>
                <?php endforeach; ?>
                
                <form action="" method="POST" class="comment-input-container">
                    <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Your Profile Picture">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <input type="text" name="comment_content" class="comment-input" placeholder="Write a comment..." required>
                    <button type="submit" name="add_comment" class="comment-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
        
        <div class="post-card" style="animation-delay: 0.2s">
            <div class="post-header">
                <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Author">
                <div class="post-author">
                    <h3>Robert Davis</h3>
                    <div class="time">5 hours ago</div>
                </div>
                <div class="post-category">Business</div>
            </div>
            
            <div class="post-content">
                <p class="post-text">Just launched our new SaaS platform after months of hard work! 🚀 The journey from concept to product has been challenging but incredibly rewarding. Huge thanks to the entire team for their dedication and late nights!</p>
                
                <div class="post-stats">
                    <div class="likes">187 Likes</div>
                    <div class="comments">24 Comments</div>
                </div>
            </div>
            
            <div class="post-actions-bar">
                <button class="post-action like-btn active">
                    <i class="fas fa-thumbs-up"></i>
                    <span>Liked</span>
                </button>
                <button class="post-action comment-toggle">
                    <i class="far fa-comment"></i>
                    <span>Comment</span>
                </button>
                <button class="post-action">
                    <i class="far fa-share-square"></i>
                    <span>Share</span>
                </button>
            </div>
            
            <div class="post-comments expanded">
                <div class="comment">
                    <div class="comment-header">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Commenter" class="comment-avatar">
                        <div class="comment-author">Emma Rodriguez</div>
                        <div class="comment-time">3 hours ago</div>
                    </div>
                    <div class="comment-text">Congratulations Robert! The platform looks amazing. Can't wait to try it out!</div>
                </div>
                
                <div class="comment">
                    <div class="comment-header">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Commenter" class="comment-avatar">
                        <div class="comment-author">John Doe</div>
                        <div class="comment-time">2 hours ago</div>
                    </div>
                    <div class="comment-text">Incredible achievement! What was the most challenging part of the development process?</div>
                </div>
                
                <div class="comment-input-container">
                    <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Profile">
                    <input type="text" class="comment-input" placeholder="Write a comment...">
                    <button class="comment-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="post-card" style="animation-delay: 0.3s">
            <div class="post-header">
                <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Author">
                <div class="post-author">
                    <h3>Sophia Williams</h3>
                    <div class="time">1 day ago</div>
                </div>
                <div class="post-category">Education</div>
            </div>
            
            <div class="post-content">
                <h2 class="post-title">The Power of Continuous Learning</h2>
                <p class="post-text">In today's rapidly evolving tech landscape, continuous learning isn't just an advantage - it's a necessity. Here are my top resources for staying updated:</p>
                
                <p class="post-text">1. Online learning platforms (Coursera, Udemy, Pluralsight)<br>
                2. Tech newsletters (TLDR, Hacker Newsletter)<br>
                3. Developer communities (GitHub, Stack Overflow, Dev.to)<br>
                4. Podcasts during commute time<br>
                5. Regular participation in hackathons</p>
                
                <p class="post-text">What are your favorite learning resources? Share in the comments!</p>
                
                <div class="post-stats">
                    <div class="likes">324 Likes</div>
                    <div class="comments">56 Comments</div>
                </div>
            </div>
            
            <div class="post-actions-bar">
                <button class="post-action like-btn">
                    <i class="far fa-thumbs-up"></i>
                    <span>Like</span>
                </button>
                <button class="post-action comment-toggle">
                    <i class="far fa-comment"></i>
                    <span>Comment</span>
                </button>
                <button class="post-action">
                    <i class="far fa-share-square"></i>
                    <span>Share</span>
                </button>
            </div>
            
            <div class="post-comments">
                <div class="comment">
                    <div class="comment-header">
                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Commenter" class="comment-avatar">
                        <div class="comment-author">David Kim</div>
                        <div class="comment-time">20 hours ago</div>
                    </div>
                    <div class="comment-text">Great list! I'd add tech Twitter as well - following industry leaders provides amazing insights.</div>
                </div>
                
                <div class="comment-input-container">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile">
                    <input type="text" class="comment-input" placeholder="Write a comment...">
                    <button class="comment-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Right Sidebar -->
    <aside class="right-sidebar">
        <div class="sidebar-card">
            <div class="news-header">
                <h2>Tech News</h2>
                <a href="#">See All</a>
            </div>
            
            <div class="news-item">
                <div class="news-content">
                    <h3>New JavaScript Framework Released</h3>
                    <p>The developer community is buzzing about NovaJS, a new framework promising faster load times.</p>
                    <span class="news-badge">HOT</span>
                </div>
            </div>
            
            <div class="news-item">
                <div class="news-content">
                    <h3>AI Predicts 30% of Coding by 2025</h3>
                    <p>New study shows AI will significantly change how developers work in the coming years.</p>
                    <span class="news-badge">TRENDING</span>
                </div>
            </div>
            
            <div class="news-item">
                <div class="news-content">
                    <h3>Remote Work Here to Stay</h3>
                    <p>Major tech companies announce permanent remote work options for employees.</p>
                </div>
            </div>
        </div>
        
        <div class="ad-container">
            <h3>Upgrade to SyncAura Pro</h3>
            <p>Get access to premium features and exclusive content</p>
            <button class="ad-btn">Learn More</button>
        </div>
        
        <div class="sidebar-card">
            <div class="card-header">
                <i class="fas fa-calendar-alt"></i>
                <h2>Upcoming Events</h2>
            </div>
            
            <div class="event">
                <div class="event-date">
                    <div class="day">15</div>
                    <div class="month">JUN</div>
                </div>
                <div class="event-details">
                    <h3>Web Development Conference</h3>
                    <p>Virtual Event · 10:00 AM</p>
                </div>
            </div>
            
            <div class="event">
                <div class="event-date">
                    <div class="day">22</div>
                    <div class="month">JUN</div>
                </div>
                <div class="event-details">
                    <h3>UX Design Workshop</h3>
                    <p>Online · 2:00 PM</p>
                </div>
            </div>
            
            <div class="event">
                <div class="event-date">
                    <div class="day">30</div>
                    <div class="month">JUN</div>
                </div>
                <div class="event-details">
                    <h3>AI & Machine Learning Summit</h3>
                    <p>San Francisco · 9:00 AM</p>
                </div>
            </div>
        </div>
        
        <div class="sidebar-card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i>
                <h2>Community Stats</h2>
            </div>
            <div class="chart-container">
                <canvas id="communityChart"></canvas>
            </div>
        </div>
    </aside>
</div>

<div class="social-footer">
    <p>© 2023 SyncAura Social. All rights reserved. · Privacy · Terms · Cookies</p>
</div>
<div class="controller-icon">
  <div class="profile-block">
    <a href="loading_screen/laoding_modif.html"><img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" ></a>
  </div>
  <a href="loading_screen/loading_game.html" title="Play Game">
    <i class="fas fa-gamepad"></i>
  </a>
  <a href="ghub/gilo.html" title="GitHub">
    <i class="fab fa-github"></i>
  </a>
  <a href="Ai/loding3.html" title="AI Chat">
    <i class="fas fa-robot"></i>
  </a>
  <a href="loading_screen/loading_editor.html" title="Code Editor">
    <i class="fas fa-code"></i>
  </a>
  <a href="media/media.html" title="Social Media">
    <i class="fas fa-users"></i>
  </a>
  <a href="loading_screen/loading_main.html" title="main_page">
    <i class="fas fa-chalkboard"></i>
  </a>
</div>

<script>
    function previewMedia(input, type) {
        const mediaPreview = document.getElementById('media-preview');
        const imagePreview = document.getElementById('image-preview');
        const videoPreview = document.getElementById('video-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                mediaPreview.style.display = 'block';
                if (type === 'image') {
                    imagePreview.style.display = 'block';
                    videoPreview.style.display = 'none';
                    imagePreview.src = e.target.result;
                } else {
                    imagePreview.style.display = 'none';
                    videoPreview.style.display = 'block';
                    videoPreview.src = e.target.result;
                }
            };

            reader.readAsDataURL(input.files[0]);

            // Clear the other input
            const otherInput = type === 'image' ? 
                document.querySelector('input[accept="video/*"]') : 
                document.querySelector('input[accept="image/*"]');
            if (otherInput) otherInput.value = '';
        }
    }

    function clearMediaPreview() {
        const mediaPreview = document.getElementById('media-preview');
        const imagePreview = document.getElementById('image-preview');
        const videoPreview = document.getElementById('video-preview');
        const imageInput = document.querySelector('input[accept="image/*"]');
        const videoInput = document.querySelector('input[accept="video/*"]');

        mediaPreview.style.display = 'none';
        imagePreview.style.display = 'none';
        videoPreview.style.display = 'none';
        imagePreview.src = '';
        videoPreview.src = '';
        if (imageInput) imageInput.value = '';
        if (videoInput) videoInput.value = '';
    }

    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        // Engagement chart
        const engagementCtx = document.getElementById('engagementChart').getContext('2d');
        new Chart(engagementCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Engagement',
                    data: [12, 19, 15, 22, 18, 24, 20],
                    borderColor: '#e63946',
                    backgroundColor: 'rgba(230, 57, 70, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
        
        // Community chart
        const communityCtx = document.getElementById('communityChart').getContext('2d');
        new Chart(communityCtx, {
            type: 'doughnut',
            data: {
                labels: ['Developers', 'Designers', 'Managers', 'Students'],
                datasets: [{
                    data: [45, 25, 15, 15],
                    backgroundColor: [
                        '#457b9d',
                        '#e63946',
                        '#1d3557',
                        '#2a9d8f'
                    ],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#94a3b8',
                            padding: 20,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
        
        // Add event listeners
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                const isLiked = this.classList.contains('active');
                const icon = this.querySelector('i');
                
                if (isLiked) {
                    this.classList.remove('active');
                    icon.className = 'far fa-thumbs-up';
                    this.querySelector('span').textContent = 'Like';
                } else {
                    this.classList.add('active');
                    icon.className = 'fas fa-thumbs-up';
                    this.querySelector('span').textContent = 'Liked';
                    
                    // Animation
                    this.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 300);
                }
            });
        });
        
        document.querySelectorAll('.comment-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const postCard = this.closest('.post-card');
                const commentsSection = postCard.querySelector('.post-comments');
                commentsSection.classList.toggle('expanded');
                
                if (commentsSection.classList.contains('expanded')) {
                    this.classList.add('active');
                } else {
                    this.classList.remove('active');
                }
            });
        });
        
        document.querySelectorAll('.comment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.value.trim() !== '') {
                    const commentContainer = this.closest('.comment-input-container');
                    const commentsSection = commentContainer.closest('.post-comments');
                    
                    const newComment = document.createElement('div');
                    newComment.className = 'comment';
                    newComment.innerHTML = `
                        <div class="comment-header">
                            <img src="${commentContainer.querySelector('img').src}" alt="Commenter" class="comment-avatar">
                            <div class="comment-author">You</div>
                            <div class="comment-time">Just now</div>
                        </div>
                        <div class="comment-text">${input.value}</div>
                    `;
                    
                    commentsSection.insertBefore(newComment, commentContainer);
                    input.value = '';
                }
            });
        });
        
        // Auto-expand textarea
        const textarea = document.querySelector('.post-input');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Follow buttons
        document.querySelectorAll('.follow-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (this.textContent === 'Follow') {
                    this.textContent = 'Following';
                    this.style.background = 'rgba(69, 123, 157, 0.2)';
                    this.style.color = '#457b9d';
                } else {
                    this.textContent = 'Follow';
                    this.style.background = '';
                    this.style.color = '';
                }
            });
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