<?php

session_start();
require "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$code = $_POST['code'];
	$email = $_SESSION['email'];

	if (!isset($email)) {
		$_SESSION['error'] = 'No email found.';
		header('Location: forgot-password.php');
		exit();
	}

	$stmt = $pdo->prepare('SELECT reset_code FROM users WHERE email = ?');
	$stmt->execute([$email]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user) {
		if ($code === $user['reset_code'])  {
			$_SESSION['reset_email'] = $email;
			$_SESSION['reset_code_verified'] = true;
			header('Location: new-password.php');
			exit();
		} else {
			$_SESSION['error'] = 'Invalid code.';
			header('Location: forgot-password.php');
			exit();
		}
	} else {
		$_SESSION['error'] = 'No user found with that email.';
		header('Location: forgot-password.php');
		exit();
	}
}

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

      <form action="send-code.php" method="POST" class="login-form">
        <h2>Enter code</h2>

        <?php if (isset($_SESSION['success'])): ?>
        <p class="alert alert-success" role="alert"><?= $_SESSION['success'] ?></p>
        <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <p class="alert alert-danger" role="alert"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="input-group">
          <label class="input-group-text" for="code">Code:</label>
          <input name="code" type="text" class="form-control" id="code" />
          <button class="btn btn-outline-primary" type="submit" id="button-addon2">
            Send code
          </button>
        </div>

        <div class="form-actions"></div>
      </form>
    </div>
  </div>
</body>

</html>