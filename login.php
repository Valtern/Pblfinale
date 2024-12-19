<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid border-bottom border-2">
        <a class="navbar-brand" href="index.php">
            <img src="img/brand1.png" alt="Logo" style="height: 30px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"></a>
        </li>
    </ul>
</div>

    </div>
</nav>


    <div class="d-block justify-content-center mt-5">
        <h2 class="text-center my-0"><strong>Welcome!</strong></h2>
        <h3 class="text-center">Masukkan detail akun anda!</h3>
    </div>

    <div class="d-flex justify-content-center">
      <div class="card" style="width: 600px;">
        <img class="card-img-top mx-auto d-block mt-4" src="img/brand1.png" style="width: 44%; height: 30%;" alt="Title" />
        <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php 
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
    </div>
<?php endif; ?>

        <form action="func/login.php" method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            class="form-control"
            name="email"
            id="email"
            required
            aria-describedby="emailHelpId"
            placeholder="username or email"
        />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            class="form-control"
            name="password"
            id="password"
            required
            placeholder="password"
        />
    </div>
    <div class="form-check mb-3">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="remember"> Remember me
        </label>
    </div>
    <button type="submit" class="btn btn-primary mx-auto d-block">Masuk</button>
</form>

        </div>
      </div>
    </div>
        
</body>
</html>