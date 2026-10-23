<?php use App\Core\View; use App\Core\Session; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Records</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar"><div class="container"><a href="index.php" class="brand">Student Records</a></div></header>
<main class="container">
    <?php if ($msg = Session::pull('success')): ?>
        <div class="alert success"><?= View::e($msg) ?></div>
    <?php endif; ?>
    <?= $content ?>
</main>
</body>
</html>
