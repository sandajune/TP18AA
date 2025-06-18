<?php
session_start();
require_once 'config.php';

function initializeSession() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = 1; // ID utilisateur fictif pour test
    }
}

function getVideos($pdo) {
    $stmt = $pdo->query("SELECT v.id, v.filename, u.username FROM videos v JOIN users u ON v.user_id = u.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCurrentIndex($videos) {
    $current = isset($_GET['video']) ? intval($_GET['video']) : 0;
    return max(0, min($current, count($videos) - 1));
}

function getNavigation($current, $videos) {
    $prev = ($current - 1 + count($videos)) % count($videos);
    $next = ($current + 1) % count($videos);
    return ['prev' => $prev, 'next' => $next];
}

function handleLike($pdo, $video_id, $user_id) {
    if (isset($_POST['like'])) {
        $stmt = $pdo->prepare("SELECT id FROM likes WHERE video_id = ? AND user_id = ?");
        $stmt->execute([$video_id, $user_id]);
        
        if ($stmt->fetch()) {
            $stmt = $pdo->prepare("DELETE FROM likes WHERE video_id = ? AND user_id = ?");
            $stmt->execute([$video_id, $user_id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO likes (video_id, user_id) VALUES (?, ?)");
            $stmt->execute([$video_id, $user_id]);
        }
    }
}

function handleComment($pdo, $video_id, $user_id) {
    if (!empty($_POST['comment'])) {
        $comment_text = strip_tags($_POST['comment']);
        $stmt = $pdo->prepare("INSERT INTO comments (video_id, user_id, comment_text) VALUES (?, ?, ?)");
        $stmt->execute([$video_id, $user_id, $comment_text]);
    }
}

function getVideoStats($pdo, $video_id) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM likes WHERE video_id = ?");
    $stmt->execute([$video_id]);
    $likes_count = $stmt->fetch()['count'];

    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM comments WHERE video_id = ?");
    $stmt->execute([$video_id]);
    $comments_count = $stmt->fetch()['count'];

    $stmt = $pdo->prepare("SELECT c.comment_text, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.video_id = ? ORDER BY c.created_at DESC");
    $stmt->execute([$video_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'likes_count' => $likes_count,
        'comments_count' => $comments_count,
        'comments' => $comments
    ];
}

function isVideoLiked($pdo, $video_id, $user_id) {
    $stmt = $pdo->prepare("SELECT id FROM likes WHERE video_id = ? AND user_id = ?");
    $stmt->execute([$video_id, $user_id]);
    return $stmt->fetch() ? true : false;
}
?>