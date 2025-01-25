<?php
include('connect.php');
session_start();

// Fetch user information from the database
if (!isset($_SESSION['usersID'])) {
    die("User not logged in.");
}

$userID = $_SESSION['usersID'];

$personalityInfoQuery = "SELECT * FROM users WHERE usersID = '$userID'";
$personalityInfoResult = executeQuery($personalityInfoQuery);
$personalityInfoRow = mysqli_fetch_assoc($personalityInfoResult);

// Determine which content to show based on the clicked section
$infoSection = isset($_GET['section']) ? $_GET['section'] : '1';  // Default to '1' (Personal Information)

$historyQuery = "
    SELECT orders.orderID, orders.dateTime, 
        coffee.coffeeName, coffee.price AS coffeePrice, 
        olympicmerchandise.merchName, olympicmerchandise.price AS merchPrice,
        orders.coffeeID, orders.merchID
    FROM orders
    LEFT JOIN coffee ON orders.coffeeID = coffee.coffeeID
    LEFT JOIN olympicmerchandise ON orders.merchID = olympicmerchandise.merchID
    WHERE orders.usersID = '$userID'
";
$historyResult = executeQuery($historyQuery);


// Initialize variables to avoid undefined index warnings
$feedbackSubmit = "";
$rating = "";
$feedbackDescription = "";

// Check if form was submitted and process feedback
if (isset($_POST['feedbackBtn'])) {
    // Debugging: check if feedback fields are set
    var_dump($_POST);

    if (isset($_POST['feedbackName']) && isset($_POST['feedbackDescription'])) {
        $rating = $_POST['feedbackName'];
        $feedbackDescription = $_POST['feedbackDescription'];

        // Debugging: print the rating and description
        echo "Rating: $rating, Description: $feedbackDescription";

        // Check if both fields are filled in
        if (!empty($rating) && !empty($feedbackDescription)) {
            // Prepare the query to insert feedback into the database
            $feedbackQuery = "INSERT INTO feedback (usersID, feedbackName, feedbackDescription) 
                            VALUES ('$userID', '$rating', '$feedbackDescription')";

            // Debugging: print the query to check correctness
            echo "Feedback Query: $feedbackQuery";

            // Execute the query
            if (executeQuery($feedbackQuery)) {
                $_SESSION['feedbackSubmit'] = true;  // Set session flag for success
                $_SESSION['feedbackMessage'] = "Feedback submitted successfully!";
                header("Location: index.php"); // Redirect to index.php after success
                exit();
            } else {
                $_SESSION['feedbackMessage'] = "Failed to submit feedback. Please try again.";
                header("Location: index.php"); // Redirect to index.php after failure
                exit();
            }
        } else {
            // If fields are empty
            $_SESSION['feedbackMessage'] = "Please fill in all fields.";
            header("Location: index.php"); // Redirect to index.php with error message
            exit();
        }
    } else {
        // If the fields are not set (if any unexpected error occurs)
        $_SESSION['feedbackMessage'] = "Please fill in all fields.";
        header("Location: index.php"); // Redirect to index.php with error message
        exit();
    }
}




?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee Shop</title>
  <link rel="shortcut icon" href="img/pngegg (1).png" type="image/x-icon">
  <link rel="stylesheet" href="bootstrap-4.6.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body>

  <div class="container mt-5">
  <div class="row">
    <!-- First Column: Back Button and Coffee Account Title -->
    <div class="col-6">
        <!-- Back Button -->
        <a href="index.php">
            <button type="button" class="btn btn-secondary mb-3">
                <i class="bx bx-arrow-back"></i> Back
            </button>
        </a>
        <h1>Coffee Account</h1>
    </div>

    <!-- Second Column: Logout Button -->
    <div class="col-6 d-flex justify-content-end">
        <a href="login.php">
            <button type="button" class="btn btn-danger">Logout</button>
        </a>
    </div>
</div>


    <hr class="my-4">

    <div class="row">
      <!-- Profile Section -->
      <div class="col-12 col-sm-3 d-flex justify-content-center">
        <div class="text-center">
          <img src="img/profile.png" alt="Profile Picture" class="rounded-circle shadow-lg" width="150" height="150">
          <h1 class="mt-3"><?php echo $personalityInfoRow['firstName'] . " " . $personalityInfoRow['lastName']; ?></h1>
        </div>
      </div>

      <div class="col-12 col-sm-9">
      <div class="nav nav-pills flex-column flex-sm-row mb-3" id="profileTabs" role="tablist">
    <a class="nav-item nav-link <?php echo $infoSection == '1' ? 'active' : ''; ?>" href="?section=1" id="personal-info-tab" data-toggle="pill">
        Personal Information
    </a>
    <a class="nav-item nav-link <?php echo $infoSection == '2' ? 'active' : ''; ?>" href="?section=2" id="order-history-tab" data-toggle="pill">
        History of Orders
    </a>
    <a class="nav-item nav-link <?php echo $infoSection == '3' ? 'active' : ''; ?>" href="?section=3" id="feedback-tab" data-toggle="pill">
        Feedback
    </a>
</div>


        <div class="tab-content mt-4">
          <?php
          if ($infoSection == '1') {
          ?>
            <div class="tab-pane fade show active" id="personal-info" role="tabpanel">
              <h2>Personal Information</h2>
              <p>Manage your personal information including name, password, and contact number.</p>
              <div class="row">
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                  <div class="card rounded">
                    <div class="card-body">
                      <h5 class="card-title d-flex justify-content-between">
                        Name
                        <i class="fas fa-user ms-auto"></i>
                      </h5>
                      <p class="card-text"><?php echo $personalityInfoRow['firstName'] . " " . $personalityInfoRow['lastName']; ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                  <div class="card rounded">
                    <div class="card-body">
                      <h5 class="card-title d-flex justify-content-between">
                        Password
                        <i class="fas fa-lock ms-auto"></i>
                      </h5>
                      <p class="card-text"><?php echo $personalityInfoRow['password']; ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                  <div class="card rounded">
                    <div class="card-body">
                      <h5 class="card-title d-flex justify-content-between">
                        Contact No:
                        <i class="fas fa-phone ms-auto"></i>
                      </h5>
                      <p class="card-text"><?php echo $personalityInfoRow['contact']; ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <?php
          } elseif ($infoSection == '2') {
          ?>
            <div class="tab-pane fade show active" id="order-history" role="tabpanel">
              <h2>History of Orders</h2>
              <table class="table mt-5">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Coffee Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Date and Time Purchased</th>
                  </tr>
                </thead>
                <tbody>
    <?php if (mysqli_num_rows($historyResult) > 0) {
        while ($historyRow = mysqli_fetch_assoc($historyResult)) {
            // Check if the order is for coffee
            if ($historyRow['coffeeID']) {
    ?>
                <tr>
                    <th scope="row"><?php echo $historyRow['orderID']; ?></th>
                    <td><?php echo $historyRow['coffeeName']; ?></td>
                    <td><?php echo "$" . number_format($historyRow['coffeePrice'], 2); ?></td>
                    <td><?php echo $historyRow['dateTime']; ?></td>
                </tr>
    <?php 
            }
            // Check if the order is for merchandise
            if ($historyRow['merchID']) {
    ?>
                <tr>
                    <th scope="row"><?php echo $historyRow['orderID']; ?></th>
                    <td><?php echo $historyRow['merchName']; ?></td>
                    <td><?php echo "$" . number_format($historyRow['merchPrice'], 2); ?></td>
                    <td><?php echo $historyRow['dateTime']; ?></td>
                </tr>
    <?php 
            }
        }
    } else { ?>
        <tr>
            <td colspan="4">No order history available.</td>
        </tr>
    <?php } ?>
</tbody>

              </table>
            </div>

          <?php
          } elseif ($infoSection == '3') {
          ?>
            <body>
            <main>
            <!-- Feedback Form in HTML -->

            <div class="card">
                <h3>Give feedback</h3>
                <form method="post" action="index.php">
                    <!-- Rating Section -->
                    <div class="form-group">
                        <label for="feedbackName">What do you think of the issue search experience within Jira projects?</label>
                        <div>
                            <label class="rating-option">
                                <input type="radio" name="feedbackName" value="Terrible" /> <img src="./img/terrible.svg" alt="Terrible" /> <span>Terrible</span>
                            </label>
                            <label class="rating-option">
                                <input type="radio" name="feedbackName" value="Bad" /> <img src="./img/bad.svg" alt="Bad" /> <span>Bad</span>
                            </label>
                            <label class="rating-option">
                                <input type="radio" name="feedbackName" value="Okay" /> <img src="./img/okay.svg" alt="Okay" /> <span>Okay</span>
                            </label>
                            <label class="rating-option">
                                <input type="radio" name="feedbackName" value="Good" /> <img src="./img/good.svg" alt="Good" /> <span>Good</span>
                            </label>
                            <label class="rating-option">
                                <input type="radio" name="feedbackName" value="Amazing" /> <img src="/img/amazing.svg" alt="Amazing" /> <span>Amazing</span>
                            </label>
                        </div>
                    </div>

                    <!-- Feedback Description Section -->
                    <div class="form-group">
                        <label for="feedbackDescription">What are the main reasons for your rating?</label>
                        <textarea name="feedbackDescription" id="feedbackDescription" cols="30" rows="10"></textarea>
                    </div>

                    <!-- Hidden User ID -->
                    <input type="hidden" name="userID" value="<?php echo $userID; ?>">

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" name="feedbackBtn" id="feedbackBtn">Submit</button>
                        <button type="reset">Cancel</button>
                    </div>

                    <!-- Feedback Submission Status -->
                    <?php if (isset($_SESSION['feedbackMessage'])) {
                        echo "<p>" . $_SESSION['feedbackMessage'] . "</p>";
                        unset($_SESSION['feedbackMessage']);  // Clear the message after displaying it
                    } ?>
                </form>
            </div>

          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
