<?php
include("connect.php");

session_start();

if (isset($_POST['btnLogin'])) {
    $username = $_POST['uname'];
    $password = $_POST['password'];

    // Query the database to check if the user exists
    $loginQuery = "SELECT * FROM users WHERE userName = '$username' AND password = '$password'";
    $loginResult = executeQuery($loginQuery);

    if (mysqli_num_rows($loginResult) > 0) {
        // Fetch user data if login is successful
        $user = mysqli_fetch_assoc($loginResult);
        
        // Set session variables
        $_SESSION['usersID'] = $user['usersID'];  // Ensure session variable is set correctly
        $_SESSION['userName'] = $user['userName'];
        $_SESSION['role'] = $user['role'];  // Store the user role

        // Redirect based on user role
        if ($_SESSION['role'] == 'admin') {
            header("Location: Admin/admin.php");
        } else {
            header("Location: index.php");  // Regular user goes to index.php
        }
        exit;  // Always call exit after redirect
    } else {
        $error_message = "No user found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Coffee  Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/ionicons@5.4.0/dist/ionicons/ionicons.min.css" rel="stylesheet">
  <style>
    
    :root {
      --main-bg-color: #6F4F28; 
      --main-text-color: #6F4F28; 
      --second-text-color: #D1B29E; 
      --second-bg-color: #E9D8A6;
      --sidebar-bg-color: #FFF9E1; 
      --sidebar-text-color: #3E2C41; 
      --icon-color: #3E2C41; 
      --icon-hover-color: #6F4F28; 
      --border-color: #D9C6A1; 
    }


    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: var(--second-bg-color); 
    }


    .login-card {
      background-color: white;
      padding: 3rem;
      border-radius: 1rem;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      border: 1px solid var(--border-color); 
    }

  
    .login-logo svg {
      width: 80px;
      height: 80px;
      margin-bottom: 1rem;
    }

    .form-control {
      padding-left: 35px;
      border-radius: 10px;
      border: 1px solid var(--border-color); 
    }

    .form-control:focus {
      border-color: var(--main-bg-color);
      box-shadow: 0 0 5px var(--main-bg-color);
    }

  
    .ion-icon {
      position: absolute;
      left: 10px;
      top: 10px;
      color: var(--icon-color); 
    }

    
    .sec-2 {
      position: relative;
      margin-bottom: 1rem;
    }

    .btn-primary {
      width: 100%;
      padding: 1rem;
      background-color: var(--main-bg-color); 
      color: white;
      border: none;
      border-radius: 30px;
      font-weight: 600;
      transition: background-color 0.3s;
    }

    .btn-primary:hover {
      background-color: var(--sidebar-bg-color); 
    }

  
    .footer-links {
      text-align: center;
      margin-top: 1rem;
    }

    .footer-links a {
      margin: 0 1rem;
      color: var(--main-text-color); 
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    .footer-links a:hover {
      color: var(--icon-hover-color); 
    }

   
    @media (max-width: 768px) {
      .login-card {
        padding: 2rem; 
      }

      .footer-links {
        margin-top: 0.5rem;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-card">
     
      <div class="login-logo text-center">
        
      </div>

      
      <form method="POST">
        <?php if (isset($error_message)) { ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
          </div>
        <?php } ?>

        <div class="sec-2">
          <label for="uname">Username or Email</label>
          <ion-icon name="mail-outline"></ion-icon>
          <input type="text" id="uname" class="form-control" name="uname" placeholder="Username or Email" required>
        </div>
        
        <div class="sec-2">
          <label for="password">Password</label>
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input type="password" id="password" class="form-control" name="password" placeholder="············" required>
          <ion-icon name="eye-outline" class="show-hide"></ion-icon>
        </div>

        
        <button type="submit" class="btn btn-primary" name="btnLogin">Login</button>
      </form>

      
      <div class="footer-links">
        <a href="register.php">Sign Up</a> | <a href="#">Forgot Password?</a>
      </div>
    </div>
  </div>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/ionicons@5.4.0/dist/ionicons/ionicons.min.js"></script>
</body>
</html>
