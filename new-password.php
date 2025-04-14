<?php

session_start();
require "includes/db.php";

if (!isset($_SESSION["email"]) || !isset($_SESSION["reset_email"]) || !$_SESSION["reset_code_verified"]) {
	header("Location: send-code.php");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$newPassword = $_POST['newPassword'];
	$confirmPassword = $_POST['confirmPassword'];

	if ($newPassword === $confirmPassword) {
		$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
		
		$stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
		$stmt->execute([$hashedPassword, $_SESSION['reset_email']]);

		unset($_SESSION['reset_email']);
		unset($_SESSION['reset_code_verified']);

		$_SESSION['success'] = 'Password changed successfully.';
		header('Location: login.php');
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

      <form action="new-password.php" method="POST" class="login-form">
        <h2>Change password</h2>

        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Password:" />

        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
          placeholder="Confirm password:" />

        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>