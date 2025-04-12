<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Signup</title>
  <link rel="stylesheet" href="./styles/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="styles/styles.css" />
</head>

<body>
  <div class="container">
    <div class="card">
      <img src="images/BUKSU_LOGO.png" alt="logo" />

      <form class="login-form" action="signup_validate.php" method="POST">
        <h2>Signup</h2>

        <input type="text" class="form-control" id="studentID" name="studentID" placeholder="Student ID:" />

        <div class="row">
          <div class="col">
            <input type="text" class="form-control" aria-label="First name" name="firstname" placeholder="First name" />
          </div>
          <div class="col">
            <input type="text" class="form-control" aria-label="Last name" name="lastname" placeholder="Last name" />
          </div>
        </div>

        <input type="text" class="form-control" id="username" name="username" placeholder="Username:" />
        <input type="email" class="form-control" id="email" name="email" placeholder="Email:" />

        <input type="password" class="form-control" id="password" name="password" placeholder="Password:" />

        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
          placeholder="Confirm:" />

        <div class="form-questions">
          <span class="form-signup">
            Already have an account? <a href="/Melloria/login.php">Login</a>
          </span>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
        <p class="alert alert-danger" role="alert"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Signup</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>