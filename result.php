<?php
session_start();

// ✅ FIXED SESSION NAMES
if (empty($_SESSION['results']) || empty($_SESSION['user'])) {
    echo "<h2>No session data found ⚠️</h2>";
    echo "<p>Please submit the form first.</p>";
    exit;
}

$user    = $_SESSION['user'];
$results = $_SESSION['results'];

// Optional: clear session after showing
unset($_SESSION['results']);
unset($_SESSION['user']);

// ── Helper: stipend color ──
function stipendColor($amount) {
    if ($amount >= 20000) return '#16a34a';
    if ($amount >= 10000) return '#1a56db';
    return '#f97316';
}

// ── Score to percentage ──
function scorePercent($score) {
    return min(100, (int)(($score / 15) * 100));
}

// ── Badge ──
function badgeHtml($badge) {
    $map = ['hot' => '🔥 Hot', 'new' => '✨ New', 'top' => '⭐ Top Pick'];
    return ($badge && isset($map[$badge]))
        ? "<span class='badge badge-$badge'>{$map[$badge]}</span>"
        : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AI Recommendations</title>

<link rel="stylesheet" href="style.css">

<style>
.match-bar-wrap { background:#e2e8f0; height:8px; border-radius:4px; }
.match-bar-fill { height:100%; background:#1a56db; border-radius:4px; transition:1s; }

.card { border:1px solid #ddd; padding:15px; margin-bottom:15px; border-radius:10px; }
.badge { padding:3px 8px; border-radius:10px; font-size:12px; }

.badge-hot { background:#fee2e2; color:#991b1b; }
.badge-new { background:#dcfce7; color:#166534; }
.badge-top { background:#fef3c7; color:#92400e; }

.btn { padding:8px 12px; border-radius:6px; text-decoration:none; margin-right:5px; }
.btn-apply { background:#16a34a; color:white; }
.btn-details { border:1px solid #ccc; }

.why-box { background:#f9fafb; padding:10px; margin-top:10px; border-radius:6px; }

</style>
</head>

<body>

<h2>🤖 AI Recommendations for <?= htmlspecialchars($user['name']) ?></h2>

<p>
🎓 <?= htmlspecialchars($user['education']) ?> |
📍 <?= htmlspecialchars($user['city']) ?> |
🎯 <?= htmlspecialchars($user['interest']) ?>
</p>

<hr>

<?php if (empty($results)): ?>

<h3>No results found</h3>
<a href="form.html">Go Back</a>

<?php else: ?>

<?php foreach ($results as $i => $item): ?>

<div class="card">

<h3>#<?= $i+1 ?> <?= htmlspecialchars($item['title']) ?></h3>

<p>🏢 <?= htmlspecialchars($item['company']) ?></p>

<p>
📍 <?= htmlspecialchars($item['location']) ?> |
💼 <?= htmlspecialchars($item['mode'] ?? 'On-site') ?> |
⏱️ <?= htmlspecialchars($item['duration'] ?? '3-6 months') ?>
</p>

<p style="color:<?= stipendColor($item['stipend'] ?? 5000) ?>">
💰 <?= htmlspecialchars($item['stipendDisplay'] ?? '₹5000/month') ?>
</p>

<?php
$percent = scorePercent($item['score']);
$label = $percent > 70 ? "Excellent Match" : ($percent > 40 ? "Good Match" : "Basic Match");
?>

<p>⭐ Score: <?= $item['score'] ?> / 15 (<?= $label ?>)</p>

<div class="match-bar-wrap">
    <div class="match-bar-fill" style="width:<?= $percent ?>%"></div>
</div>

<p><?= htmlspecialchars($item['description'] ?? '') ?></p>

<div class="why-box">
<b>Why this recommendation:</b><br>
<?= htmlspecialchars($item['why'] ?? 'Matches your profile') ?>
</div>

<br>

<a href="<?= htmlspecialchars($item['applyUrl'] ?? '#') ?>" target="_blank" class="btn btn-apply">
Apply Now
</a>

<a href="<?= htmlspecialchars($item['applyUrl'] ?? '#') ?>" target="_blank" class="btn btn-details">
View Details
</a>

</div>

<?php endforeach; ?>

<?php endif; ?>

<br>
<a href="form.html">← Edit Profile</a>

</body>
</html>