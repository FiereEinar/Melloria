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

      <form action="new-password.html" class="login-form">
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
          <input type="text" class="form-control" id="code" />
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