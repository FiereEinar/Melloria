<?php
session_start();

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$siteKey = $_ENV['RECAPTCHA_SITE_KEY'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="./styles/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="styles/styles.css" />
</head>

<body>
  <div class="container">
    <div class="card">
      <img src="images/BUKSU_LOGO.png" alt="logo" />

      <form action="login_validate.php" class="login-form" method="POST">
        <h2>Login</h2>

        <div class="input-group">
          <span class="input-group-text" id="basic-addon1">@</span>
          <input type="text" class="form-control" name="username" placeholder="Username" />
        </div>

        <input type="password" class="form-control" name="password" placeholder="Password" />

        <div class="">
          <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($siteKey) ?>"></div>
        </div>

        <div class="form-questions">
          <span class="form-signup">
            Don&apos;t have an account? <a href="/Melloria/signup.php">Signup</a>
          </span>
          <a href="/Melloria/forgot-password.php">Forgot password?</a>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
        <p class="alert alert-danger" role="alert"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Login</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://www.google.com/recaptcha/api.js"></script>
</body>

</html>