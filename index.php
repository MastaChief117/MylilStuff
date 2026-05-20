<?php
error_reporting(0);
mysqli_report(MYSQLI_REPORT_OFF);

// === CONFIGURATION ===
$db_host = "sql212.byetcluster.com"; // Check your InfinityFree Account Details for the actual host
$db_name = "YOUR_GAMER_GD_DATABASE_NAME";
$db_user = "YOUR_GAMER_GD_DATABASE_USER";
$db_pass = "YOUR_DATABASE_PASSWORD";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("<div style='color:white;text-align:center;margin-top:50px;'>Database connection lost. Hang tight!</div>");
}

// Fetch posts
$result = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Little Stuff</title>
    <style>
        :root {
            --bg: #0d1117; --panel: #161b22; --border: #30363d;
            --text: #c9d1d9; --text-bright: #f0f6fc; --accent: #1f6feb;
            --chat-glow: #238636;
        }
        body { font-family: -apple-system, system-ui, sans-serif; background: var(--bg); color: var(--text); margin: 0; padding: 0; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        
        /* Header styling */
        header { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; border-bottom: 1px solid var(--border); margin-bottom: 30px; }
        header h1 { margin: 0; font-size: 1.6rem; color: var(--text-bright); font-weight: 800; letter-spacing: -0.5px; }
        
        /* The RugChat Promo Card */
        .chat-banner { background: linear-gradient(135deg, #1f6feb 0%, #238636 100%); color: white; border-radius: 12px; padding: 25px; margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
        .chat-banner-text h2 { margin: 0 0 8px 0; color: white; font-size: 1.4rem; }
        .chat-banner-text p { margin: 0; opacity: 0.9; font-size: 0.95rem; }
        .chat-btn { background: white; color: #161b22; font-weight: bold; padding: 12px 24px; border-radius: 30px; text-decoration: none; transition: transform 0.2s; white-space: nowrap; }
        .chat-btn:hover { transform: scale(1.05); }

        /* Blog Grid Setup */
        .posts-grid { display: flex; flex-direction: column; gap: 20px; }
        .post-card { background: var(--panel); border: 1px solid var(--border); border-radius: 12px; padding: 25px; transition: border-color 0.2s; }
        .post-card:hover { border-color: #8b949e; }
        .post-meta { font-size: 0.8rem; color: #8b949e; margin-bottom: 10px; display: flex; gap: 10px; }
        .post-category { background: rgba(31, 111, 235, 0.15); color: var(--accent); padding: 2px 8px; border-radius: 4px; font-weight: bold; }
        .post-card h3 { margin: 0 0 12px 0; font-size: 1.3rem; color: var(--text-bright); }
        .post-content { line-height: 1.6; font-size: 0.98rem; white-space: pre-line; }
        
        @media(max-width: 600px) {
            .chat-banner { flex-direction: column; gap: 20px; text-align: center; }
            header { flex-direction: column; gap: 15px; text-align: center; }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>mylittlestuff.gamer.gd</h1>
        <div style="font-size: 0.9rem; color: #8b949e;">Welcome to my sandbox</div>
    </header>

    <!-- LIVE LINK TO RUGCHAT -->
    <div class="chat-banner">
        <div class="chat-banner-text">
            <h2>💬 Join the Live Room!</h2>
            <p>Come hang out, chat anonymously, and break things over at <b>rugchat.unaux.com</b>.</p>
        </div>
        <a href="http://rugchat.unaux.com" target="_blank" class="chat-btn">Jump Into Chat →</a>
    </div>

    <h2 style="color: var(--text-bright); margin-bottom: 20px; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 1px;">Recent Entries</h2>
    
    <div class="posts-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($post = $result->fetch_assoc()): ?>
                <div class="post-card">
                    <div class="post-meta">
                        <span class="post-category"><?= htmlspecialchars($post['category']) ?></span>
                        <span>•</span>
                        <span><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                    </div>
                    <h3><?= htmlspecialchars($post['title']) ?></h3>
                    <div class="post-content"><?= htmlspecialchars($post['content']) ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align:center; padding: 40px; color: #8b949e;">No entries written yet. Add one below!</div>
        <?php endif; ?>
    </div>
    
    <div style="margin-top: 50px; text-align: center; font-size: 0.8rem; color: #8b949e; border-top: 1px solid var(--border); padding-top: 20px;">
        <a href="write.php" style="color: var(--accent); text-decoration: none;">+ Admin Portal</a>
    </div>
</div>

</body>
</html>
