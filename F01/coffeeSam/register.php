<?php
include("connect.php");

session_start();

$_SESSION['usersID'] = "";
$_SESSION['userName'] = "";
$_SESSION['contact'] = "";
$_SESSION['role'] = "";
$_SESSION['firstName'] = "";
$_SESSION['lastName'] = "";

$error = "";

if (isset($_POST['btnRegister'])) {
    $username = $_POST['uname'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    if ($password == $cpassword) {
        // Hash the password before saving it to the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user info into database
        $userQuery = "INSERT INTO users (userName, firstName, lastName, password, role, contact) 
                      VALUES ('$username', '$fname', '$lname', '$hashedPassword', 'user', '$contact')";
        
        if (executeQuery($userQuery)) {
            $userID = mysqli_insert_id($GLOBALS['conn']); // Assuming $conn is your database connection

            // Set session data
            $_SESSION['usersID'] = $userID;
            $_SESSION['userName'] = $username;
            $_SESSION['contact'] = $contact;
            $_SESSION['firstName'] = $fname;
            $_SESSION['lastName'] = $lname;
            $_SESSION['role'] = 'user';

            // Redirect to home page after successful registration
            header("Location: index.php");
            exit();
        } else {
            $error = "There was an error while registering. Please try again.";
        }
    } else {
        $error = "Passwords do not match!";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coffee Shop | Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Applying theme colors */
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

        body {
            background-color: var(--second-bg-color);
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 5rem;
        }

        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            color: var(--main-text-color);
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
        }

        .form-control:focus {
            border-color: var(--main-text-color);
        }

        .btn-primary {
            background-color: var(--main-bg-color);
            border: none;
            border-radius: 1rem;
            color: white;
        }

        .btn-secondary {
            background-color: var(--second-bg-color);
            border: none;
            border-radius: 1rem;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .h3 {
            color: var(--main-text-color);
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-12 col-lg-7 mx-auto">
                <!-- Display error message if any -->
                <?php if ($error != "") { ?>
                    <div class="alert alert-danger mb-3" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <!-- Registration Form -->
                <form method="POST">
                    <div class="card p-5 shadow rounded-5">
                        <div class="h3 my-4 text-center">Misinjir Register</div>
                        
                        <!-- First Name -->
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" id="fname" class="form-control" name="fname" required>
                        </div>

                        <!-- Last Name -->
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" id="lname" class="form-control" name="lname" required>
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="uname" class="form-label">Username</label>
                            <input type="text" id="uname" class="form-control" name="uname" required>
                        </div>

                        <!-- Contact -->
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" id="contact" class="form-control" name="contact" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" name="password" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="cpassword" class="form-label">Confirm Password</label>
                            <input type="password" id="cpassword" class="form-control" name="cpassword" required>
                        </div>

                        <!-- Buttons -->
                        <div class="mb-3 text-center">
                            <a href="login.php">
                                <button type="button" class="btn btn-secondary py-3 px-5 rounded-5">Back</button>
                            </a>
                            <button class="btn btn-primary py-3 px-5 rounded-5" name="btnRegister">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
