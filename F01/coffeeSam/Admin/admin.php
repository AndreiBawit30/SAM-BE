<?php
include('connect.php');

$totalOrdersQuery = "
    SELECT 
    COUNT(DISTINCT orders.orderID) AS totalOrders,
    COUNT(DISTINCT CASE WHEN orders.coffeeID != 0 AND orders.merchID = 0 THEN orders.orderID END) AS totalCoffeeOrders,
    COUNT(DISTINCT CASE WHEN orders.coffeeID = 0 AND orders.merchID != 0 THEN orders.orderID END) AS totalMerchOrders,
    SUM(CASE WHEN orders.coffeeID != 0 AND orders.merchID = 0 THEN coffee.price ELSE 0 END) AS totalCoffeeSales,
    SUM(CASE WHEN orders.coffeeID = 0 AND orders.merchID != 0 THEN olympicmerchandise.price ELSE 0 END) AS totalMerchSales,
    SUM(CASE 
            WHEN orders.coffeeID != 0 AND orders.merchID != 0 
            THEN coffee.price + olympicmerchandise.price
            WHEN orders.coffeeID != 0 AND orders.merchID = 0
            THEN coffee.price
            WHEN orders.coffeeID = 0 AND orders.merchID != 0
            THEN olympicmerchandise.price
            ELSE 0 
        END) AS totalSales
FROM orders
LEFT JOIN coffee ON orders.coffeeID = coffee.coffeeID
LEFT JOIN olympicmerchandise ON orders.merchID = olympicmerchandise.merchID;
";

$allFeedbackQuery = "SELECT 
CONCAT(users.firstName, ' ', users.lastName) AS fullName, 
feedback.feedbackName, 
feedback.feedbackDescription,
feedback.dateTIme AS feedbackDate
FROM feedback
JOIN users ON feedback.usersID = users.usersID";

$allFeedbackResult = executeQuery($allFeedbackQuery);

$totalOrdersResult = executeQuery($totalOrdersQuery);
$totalRow = mysqli_fetch_assoc($totalOrdersResult);

$historyQuery = "
    SELECT orders.orderID, orders.dateTime, 
           coffee.coffeeName, coffee.price AS coffeePrice, 
           olympicmerchandise.merchName, olympicmerchandise.price AS merchPrice,
           orders.coffeeID, orders.merchID
    FROM orders
    LEFT JOIN coffee ON orders.coffeeID = coffee.coffeeID
    LEFT JOIN olympicmerchandise ON orders.merchID = olympicmerchandise.merchID
";
$historyResult = executeQuery($historyQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <title>Coffee Shop Admin</title>
</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                <i class="fas fa-coffee sidebar-icon"></i> Coffee Shop
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="#dashboard-tab" class="list-group-item list-group-item-action bg-transparent second-text active" data-bs-toggle="pill">
                    <i class="fas fa-tachometer-alt me-2 sidebar-icon"></i>Dashboard
                </a>
                <a href="#reports-tab" class="list-group-item list-group-item-action bg-transparent second-text" data-bs-toggle="pill">
                    <i class="fas fa-paperclip me-2 sidebar-icon"></i>Reports
                </a>
                <a href="#products-tab" class="list-group-item list-group-item-action bg-transparent second-text" data-bs-toggle="pill">
                    <i class="fas fa-cogs me-2 sidebar-icon"></i>Products
                </a>
                <!-- Logout Button -->
                <a href="/login.php" class="list-group-item list-group-item-action bg-transparent second-text">
                    <i class="fas fa-sign-out-alt me-2 sidebar-icon"></i>Logout
                </a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0 primary-text">Dashboard</h2>
                </div>
            </nav>

            <div class="container-fluid px-4">
            <div class="row g-3 my-2">
    <div class="col-md-3 col-sm-6">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded h-100">
            <div>
                <h3 class="fs-2"><?php echo $totalRow['totalOrders']?></h3>
                <p class="fs-5">Total Orders</p>
            </div>
            <i class="fas fa-gift fs-1 icon-neutral border rounded-full secondary-bg p-3"></i>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded h-100">
            <div>
                <h3 class="fs-2"><?php echo $totalRow['totalSales']?></h3>
                <p class="fs-5">Sales</p>
            </div>
            <i class="fas fa-hand-holding-usd fs-1 icon-neutral border rounded-full secondary-bg p-3"></i>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded h-100">
            <div>
                <h3 class="fs-2"><?php echo $totalRow['totalCoffeeSales']?></h3>
                <p class="fs-5">Coffee</p>
            </div>
            <i class="fas fa-coffee fs-1 icon-neutral border rounded-full secondary-bg p-3"></i>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="p-3 bg-white shadow-sm d-flex justify-content-between align-items-center rounded h-100">
            <div>
                <h3 class="fs-2"><?php echo $totalRow['totalMerchSales']?></h3>
                <p class="fs-5">Merch Sales</p>
            </div>
            <i class="fas fa-tshirt fs-1 icon-neutral border rounded-full secondary-bg p-3"></i>
        </div>
    </div>
</div>


                <div class="tab-content mt-4">
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="dashboard-tab" role="tabpanel">
                        <h2 class="primary-text">Order History</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($historyResult) > 0) {
                                        while ($historyRow = mysqli_fetch_assoc($historyResult)) {
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
                    </div>

                    <!-- Reports Tab -->
                    <div class="tab-pane fade" id="reports-tab" role="tabpanel">
                        <h2 class="primary-text">Feedbacks</h2>
                        <div class="row">
                            <?php 
                            if (mysqli_num_rows($allFeedbackResult) > 0) {
                                while ($feedbackRow = mysqli_fetch_assoc($allFeedbackResult)) {
                            ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $feedbackRow['fullName']; ?></h5>
                                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $feedbackRow['feedbackName']; ?></h6>
                                            <p class="card-text"><?php echo $feedbackRow['feedbackDescription']; ?></p>
                                            <p class="card-text"><small class="text-muted">Feedback Date: <?php echo $feedbackRow['feedbackDate']; ?></small></p>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                }
                            } else {
                                echo "<p>No feedback available.</p>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Products Tab -->
                    <div class="tab-pane fade" id="products-tab" role="tabpanel">
                        <h2 class="primary-text">Products</h2>
                        <p class="second-text">Product details will be shown here.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Sidebar for Small Screens -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const wrapper = document.getElementById('wrapper');
        
        menuToggle.addEventListener('click', function() {
            wrapper.classList.toggle('toggled');
        });
    </script>
</body>

</html>
