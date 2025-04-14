<?php

session_start();
require "includes/db.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = $_POST['email'];

	$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
	$stmt->execute([$email]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user) {
		$reset_code = rand(100000, 999999);

		$update = $pdo->prepare('UPDATE users SET reset_code = ? WHERE email = ?');
		$update->execute([$reset_code, $email]);
		
		$_SESSION['email'] = $email;
		$mail = new PHPMailer(true);

		try {
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'nickxylanmelloria@gmail.com';
			$mail->Password = 'nsse oemy xeir arqe';
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;

			$mail->setFrom('nickxylanmelloria@gmail.com', 'Nick Xylan Melloria');
			$mail->addAddress($email, 'This is your Client');
			
			$mail->isHTML(true);
			$mail->Subject = 'Password Reset Code';
			$mail->Body = "
				<h1>Reset Code</h1>
				<p>Your reset code is: $reset_code</p>
			";

			$mail->AltBody = 'Hello, use the code below to reset your password: \n\n' . $reset_code . '\n\n';
			$mail->send();

			$_SESSION['email_sent'] = true;
			$_SESSION['success'] = 'Verification code has been sent to your email.';
			header('Location: send-code.php');
			exit();
		} catch (Exception $e) {
			$_SESSION['error'] = 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
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

      <form action="forgot-password.php" class="login-form" method="POST">
        <h2>Forgot password</h2>

        <div class="input-group">
          <span class="input-group-text">@</span>
          <input type="email" name="email" class="form-control" placeholder="Email" />
        </div>

        <?php if (isset($_SESSION['success'])): ?>
        <p class="alert alert-success" role="alert"><?= $_SESSION['success'] ?></p>
        <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <p class="alert alert-danger" role="alert"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Send code</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>