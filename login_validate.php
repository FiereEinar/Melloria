<?php

session_start();
require "includes/db.php";
require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $secretKey = $_ENV['RECAPTCHA_SECRET_KEY'];
  $recaptchaResponse = $_POST['g-recaptcha-response'];
  $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
  $response = json_decode($verify);

  if (!$response->success) {
    $_SESSION['error'] = 'Please verify that you are not a robot.';
    header('Location: login.php');
    exit();
  }

  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
  $stmt->execute([$username]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    header('Location: dashboard/index.html');
    exit();
  } else {
    $_SESSION['error'] = 'Incorrect credentials.';
    header('Location: login.php');
    exit();
  }
}