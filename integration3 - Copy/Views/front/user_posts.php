<?php
require_once '../../confige.php';
require_once '../../models/post_functions.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$current_user_id = $_SESSION['user_id'];
$profile_picture = $_SESSION['profile_picture'];
$username = $_SESSION['username'];

// Get the user_id from URL parameter
$view_user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if (!$view_user_id) {
    header('Location: thome.php');
    exit();
}

// Get user information
$conn = Config::getConnexion();
$stmt = $conn->prepare("SELECT username, profile_picture, bio FROM users WHERE user_id = ?");
$stmt->execute([$view_user_id]);
$user_info = $stmt->fetch();

if (!$user_info) {
    header('Location: thome.php');
    exit();
}

// Get user's posts
$stmt = $conn->prepare("SELECT p.*, u.username, u.profile_picture 
                      FROM posts p 
                      JOIN users u ON p.user_id = u.user_id 
                      WHERE p.user_id = ? 
                      ORDER BY p.created_at DESC");
$stmt->execute([$view_user_id]);
$posts = $stmt->fetchAll();

// Handle post actions (like, comment, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['like_post'])) {
        $post_id = $_POST['post_id'];
        likePost($current_user_id, $post_id);
        header("Location: user_posts.php?user_id=" . $view_user_id);
        exit();
    } elseif (isset($_POST['add_comment'])) {
        $post_id = $_POST['post_id'];
        $content = trim($_POST['comment_content']);
        if (!empty($content)) {
            addComment($current_user_id, $post_id, $content);
        }
        header("Location: user_posts.php?user_id=" . $view_user_id);
        exit();
    } elseif (isset($_POST['delete_post'])) {
        $post_id = $_POST['post_id'];
        $post = getPostById($post_id);
        if ($post && $post['user_id'] == $current_user_id) {
            deletePost($post_id);
        }
        header("Location: user_posts.php?user_id=" . $view_user_id);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user_info['username']); ?>'s Posts | SyncAura Social</title>
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

        .post-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .post-card:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-2px);
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .post-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary);
        }

        .post-author {
            flex-grow: 1;
        }

        .post-author h3 {
            color: var(--text-light);
            font-size: 1.1rem;
            margin-bottom: 4px;
        }

        .time {
            color: var(--text-gray);
            font-size: 0.9rem;
        }

        .post-category {
            background: var(--secondary);
            color: var(--text-light);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .post-content {
            margin-bottom: 20px;
        }

        .post-title {
            color: var(--text-light);
            font-size: 1.4rem;
            margin-bottom: 15px;
            font-family: 'Poppins', sans-serif;
        }

        .post-text {
            color: var(--text-gray);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .post-image {
            width: 100%;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }

        .post-stats {
            color: var(--text-gray);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .post-actions-bar {
            display: flex;
            gap: 20px;
            padding: 15px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .post-action {
            color: var(--text-gray);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .post-action:hover,
        .post-action.active {
            color: var(--accent);
        }

        .post-comments {
            display: none;
        }

        .comment {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 15px;
            margin-bottom: 15px;
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .comment-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .comment-author {
            color: var(--text-light);
            font-weight: 500;
        }

        .comment-time {
            color: var(--text-gray);
            font-size: 0.85rem;
            margin-left: auto;
        }

        .comment-text {
            color: var(--text-gray);
            line-height: 1.5;
        }

        .delete-post-btn {
            color: var(--accent) !important;
            opacity: 0.8;
            transition: var(--transition);
        }

        .delete-post-btn:hover {
            opacity: 1;
            transform: scale(1.1);
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
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .user-profile {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 40px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .user-profile:hover {
            box-shadow: var(--hover-shadow);
        }

        .user-profile img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 4px solid var(--secondary);
            box-shadow: 0 0 20px rgba(69, 123, 157, 0.3);
        }

        .user-profile h1 {
            color: var(--text-light);
            margin-bottom: 15px;
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
        }

        .user-profile .bio {
            color: var(--text-gray);
            margin-bottom: 20px;
            font-size: 1.1rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .post-count {
            font-size: 1.1rem;
            color: var(--secondary);
            font-weight: 500;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: var(--secondary);
            color: var(--text-light);
            border-radius: var(--border-radius);
            text-decoration: none;
            margin-bottom: 30px;
            font-weight: 500;
            transition: var(--transition);
        }

        .back-button:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }

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
    </style>
</head>
<body>
    <nav class="site-navigation">
        <div class="nav-left">
            <a href="thome.php" class="syncaura-logo">
                <i class="fas fa-sync-alt"></i>
                <span>SyncAura</span>
            </a>
        </div>
        <div class="nav-right">
            <a href="thome.php" class="back-button"><i class="fas fa-arrow-left"></i> Back to Home</a>
        </div>
    </nav>

    <div class="social-container">
        <div class="user-profile">
            <img src="<?php echo htmlspecialchars($user_info['profile_picture']); ?>" alt="Profile Picture">
            <h1><?php echo htmlspecialchars($user_info['username']); ?></h1>
            <?php if (!empty($user_info['bio'])): ?>
                <p class="bio"><?php echo htmlspecialchars($user_info['bio']); ?></p>
            <?php endif; ?>
            <p class="post-count"><i class="fas fa-newspaper"></i> <?php echo count($posts); ?> posts</p>
        </div>

        <!-- Display Posts -->
        <?php foreach ($posts as $post): ?>
        <div class="post-card">
            <div class="post-header">
                <img src="<?php echo htmlspecialchars($post['profile_picture']); ?>" alt="Author Profile Picture">
                <div class="post-author">
                    <h3><?php echo htmlspecialchars($post['username']); ?></h3>
                    <div class="time"><?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></div>
                </div>
                <div class="post-category"><?php echo htmlspecialchars($post['category']); ?></div>
                <?php if ($post['user_id'] == $current_user_id): ?>
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
                <form action="" method="POST" class="post-action <?php echo isLikedByUser($current_user_id, $post['post_id']) ? 'active' : ''; ?>">
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
                
                <form action="" method="POST" class="comment-form">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <div class="comment-input-container">
                        <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Your Profile" class="comment-avatar">
                        <input type="text" name="comment_content" placeholder="Write a comment..." required>
                        <button type="submit" name="add_comment">Post</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
        
        <?php if (empty($posts)): ?>
        <div class="no-posts">
            <p>No posts yet.</p>
        </div>
        <?php endif; ?>
    </div>

    <script>
        function toggleComments(element) {
            const commentsSection = element.closest('.post-card').querySelector('.post-comments');
            commentsSection.style.display = commentsSection.style.display === 'none' ? 'block' : 'none';
        }
    </script>
        <script>
        function toggleComments(element) {
            const postCard = element.closest('.post-card');
            const comments = postCard.querySelector('.post-comments');
            if (comments.style.display === 'none' || !comments.style.display) {
                comments.style.display = 'block';
            } else {
                comments.style.display = 'none';
            }
        }

        // Auto-expand textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });

        // Initialize like buttons
        document.querySelectorAll('.post-action').forEach(button => {
            if (button.classList.contains('active')) {
                button.querySelector('i').style.color = 'var(--accent)';
            }
        });
        </script>
    </body>
</html>