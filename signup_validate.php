<?php

session_start();

require "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $studentID = $_POST['studentID'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  if ($password !== $confirmPassword)  {
    $_SESSION['error'] = 'Passwords do not match.';
    header('Location: signup.php');
    exit();
  }

  $stmt = $pdo->prepare('SELECT * FROM users WHERE studentID = ?');
  $stmt->execute([$studentID]);

  if ($stmt->rowCount() > 0) {
    $_SESSION['error'] = 'Student ID already exists.';
    header('Location: signup.php');
    exit();
  }

  $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
  $stmt->execute([$username]);
  
  if ($stmt->rowCount() > 0) {
    $_SESSION['error'] = 'Username already exists.';
    header('Location: signup.php');
    exit();
  }

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare('INSERT INTO users (studentID, firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ?, ?)');
  $stmt->execute([$studentID, $firstname, $lastname, $username, $email, $hashedPassword]);

  $_SESSION['success'] = 'Account created successfully.';
  header('Location: login.php');
  exit();
}