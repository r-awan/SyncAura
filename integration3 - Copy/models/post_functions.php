<?php
require_once __DIR__ . "/../confige.php";

// Function to create a new post
function createPost($user_id, $title, $content, $media_type = 'none', $media_path = null, $category = null) {
    $conn = Config::getConnexion();
    
    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, media_type, media_path, category) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$user_id, $title, $content, $media_type, $media_path, $category]);
}

// Function to get all posts with user info
function getAllPosts() {
    $conn = Config::getConnexion();
    
    $query = "SELECT p.*, u.username, u.profile_picture 
              FROM posts p 
              JOIN users u ON p.user_id = u.user_id 
              ORDER BY p.created_at DESC";
    $stmt = $conn->query($query);
    
    return $stmt->fetchAll();
}

// Function to like a post
function likePost($user_id, $post_id) {
    $conn = Config::getConnexion();
    
    // Check if already liked
    $check = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
    $check->execute([$user_id, $post_id]);
    
    if ($check->rowCount() > 0) {
        // Unlike if already liked
        $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
        return $stmt->execute([$user_id, $post_id]);
    } else {
        // Like the post
        $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $post_id]);
    }
}

// Function to add a comment
function addComment($user_id, $post_id, $content) {
    $conn = Config::getConnexion();
    
    $stmt = $conn->prepare("INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)");
    return $stmt->execute([$user_id, $post_id, $content]);
}

// Function to get comments for a post
function getComments($post_id) {
    $conn = Config::getConnexion();
    
    $query = "SELECT c.*, u.username, u.profile_picture 
              FROM comments c 
              JOIN users u ON c.user_id = u.user_id 
              WHERE c.post_id = ? 
              ORDER BY c.created_at ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute([$post_id]);
    
    return $stmt->fetchAll();
}

// Function to get like count for a post
function getLikeCount($post_id) {
    $conn = Config::getConnexion();
    
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM likes WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $result = $stmt->fetch();
    
    return $result['count'];
}

// Function to check if current user liked a post
function isLikedByUser($user_id, $post_id) {
    $conn = Config::getConnexion();
    
    $stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    
    return $stmt->rowCount() > 0;
}

// Function to get a specific post by ID
function getPostById($post_id) {
    $conn = Config::getConnexion();
    
    $query = "SELECT p.*, u.username, u.profile_picture 
              FROM posts p 
              JOIN users u ON p.user_id = u.user_id 
              WHERE p.post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$post_id]);
    
    return $stmt->fetch();
}

// Function to delete a post and its associated data
function deletePost($post_id) {
    $conn = Config::getConnexion();
    
    try {
        $conn->beginTransaction();
        
        // Delete associated likes
        $stmt = $conn->prepare("DELETE FROM likes WHERE post_id = ?");
        $stmt->execute([$post_id]);
        
        // Delete associated comments
        $stmt = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
        $stmt->execute([$post_id]);
        
        // Get post media info before deletion
        $stmt = $conn->prepare("SELECT media_path FROM posts WHERE post_id = ?");
        $stmt->execute([$post_id]);
        $post = $stmt->fetch();
        
        // Delete the post
        $stmt = $conn->prepare("DELETE FROM posts WHERE post_id = ?");
        $stmt->execute([$post_id]);
        
        $conn->commit();
        
        // Delete media file if exists
        if ($post && $post['media_path']) {
            $file_path = __DIR__ . "/../" . $post['media_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        return false;
    }
}
?>