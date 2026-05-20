<?php
session_start();
// Basic safety check so random visitors can't post
$SECRET_PASSWORD = "change_this_to_your_own_pass"; 

if (isset($_POST['login'])) {
    if ($_POST['password'] === $SECRET_PASSWORD) {
        $_SESSION['blog_admin'] = true;
    }
}

$is_logged_in = isset($_SESSION['blog_admin']) && $_SESSION['blog_admin'] === true;

if ($is_logged_in && isset($_POST['submit_post'])) {
    $db_host = "sql212.byetcluster.com";
    $db_name = "YOUR_GAMER_GD_DATABASE_NAME";
    $db_user = "YOUR_GAMER_GD_DATABASE_USER";
    $db_pass = "YOUR_DATABASE_PASSWORD";
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

    if ($title != '' && $content != '') {
        $stmt = $conn->prepare("INSERT INTO blog_posts (title, slug, content, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $slug, $content, $category);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Write Entry</title>
    <style>
        body { background: #0d1117; color: #c9d1d9; font-family: sans-serif; padding: 40px; }
        .box { max-width: 500px; margin: 0 auto; background: #161b22; padding: 30px; border: 1px solid #30363d; border-radius: 12px; }
        input, textarea, select { width: 100%; background: #0d1117; border: 1px solid #30363d; color: white; padding: 12px; border-radius: 6px; box-sizing: border-box; margin-bottom: 15px; }
        button { background: #238636; color: white; border: none; padding: 12px 20px; font-weight: bold; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>
<div class="box">
    <?php if (!$is_logged_in): ?>
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="password" name="password" placeholder="Secret Key" required>
            <button name="login">Unlock</button>
        </form>
    <?php else: ?>
        <h2>Create New Post</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Post Title" required>
            <select name="category">
                <option value="Gaming">Gaming</option>
                <option value="Dev Log">Dev Log</option>
                <option value="Random">Random</option>
            </select>
            <textarea name="content" rows="10" placeholder="Type what's on your mind..." required></textarea>
            <button name="submit_post">Publish to Site</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
