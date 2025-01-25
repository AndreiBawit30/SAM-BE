<?php
include("connect.php");

session_start();

$userID = $_SESSION['usersID'];

if (empty($userID)) {
    header("Location: login.php");
    exit;
}

$orderSuccessfully = "";

if (isset($_POST['orderBtn'])) {
    // Determine which product type is being ordered
    if (isset($_POST['coffeeID'])) {
        $productID = $_POST['coffeeID'];
        $productType = 'coffee';
    } elseif (isset($_POST['merchID'])) {
        $productID = $_POST['merchID'];
        $productType = 'merch';
    }

    if (!empty($productID) && !empty($userID)) {
        // Prepare the order query based on the product type
        if ($productType === 'coffee') {
            $Orderquery = "INSERT INTO orders (coffeeID, usersID) VALUES ($productID, $userID)";
        } elseif ($productType === 'merch') {
            $Orderquery = "INSERT INTO orders (merchID, usersID) VALUES ($productID, $userID)";
        }

        // Execute the query and check for success
        if (executeQuery($Orderquery)) {
            $_SESSION['order_successful'] = true; // Set session flag for success
        }
    }
}

// Fetch categories and products
$categoryQuery = "SELECT * FROM categories";
$categoryResult = executeQuery($categoryQuery);

$featuredQuery = "SELECT * FROM coffee WHERE type='featured'";
$featuredResult = executeQuery($featuredQuery);

$latestQuery = "SELECT * FROM coffee WHERE type='latest'";
$latestResult = executeQuery($latestQuery);

$bestsellerQuery = "SELECT * FROM coffee WHERE type='bestseller'";
$bestsellerResult = executeQuery($bestsellerQuery);


$bestsellerQuery = "SELECT * FROM coffee WHERE type='bestseller'";
$bestsellerResult = executeQuery($bestsellerQuery);

$merchQuery = "SELECT * FROM olympicMerchandise";
$merchResult = executeQuery($merchQuery);

$feedbackShow= "Select * from feedback";
$feedbackShowResult = executeQuery($feedbackShow);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop</title>
    <link rel="shortcut icon" href="img/pngegg (1).png" type="image/x-icon">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- bootstrap link  -->
    <link rel="stylesheet" href="bootstrap-4.6.2-dist/css/bootstrap.min.css">
    <!-- css link  -->
    <link rel="stylesheet" href="style.css">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    

</head>

<body>
    <!-- ============================= nav ============================= -->
    <div class="navbar navbar-expand-lg fixed-top px-4">
        <a href="#" class="navbar-brand h1 text-capitalize">
            Coffee<span> Shop.</span>
        </a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#menu" type="button">
            <i class='bx bx-menu text-white h1'></i>
        </button>

        <?php if ($orderSuccessfully == "Success") { ?>
            <div class="alert alert-success" role="alert">
                This is a success alert—check it out!
            </div>
        <?php } ?>



        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ml-auto text-center">
                <li class="nav-item">
                    <a href="#home" class="nav-link text-capitalize">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#categories" class="nav-link text-capitalize">categories</a>
                </li>
                <li class="nav-item">
                    <a href="#products" class="nav-link text-capitalize">products</a>
                </li>
                <li class="nav-item">
                    <a href="#blogs" class="nav-link text-capitalize">blogs</a>
                </li>
                <li class="nav-item">
                    <a href="myaccount.php" class="nav-link text-capitalize">My Account</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- ============================= home ============================= -->
    <section id="home" class="home">
        <div class="carousel slide" id="carousel-indi">
            <ol class="carousel-indicators">
                <li data-target="#carousel-indi" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-indi" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active c-item1 d-flex align-items-center justify-content-center flex-column">
                    <h6 class="text-capitalize my-3">delicious coffee</h6>
                    <h1 class="text-capitalize text-white mb-3 text-center">freshly roasted coffee</h1>
                    <a href="#products">
                        <button type="button" class="btn button text-uppercase mt-3">Shop Now</button>
                    </a>

                </div>
                <div class="carousel-item c-item2">
                    <div class="h-100 d-flex align-items-center justify-content-center flex-column">
                        <h6 class="text-capitalize my-3">delicious coffee</h6>
                        <h1 class="text-capitalize text-white mb-3 text-center">100% natural fresh coffee</h1>
                        <button type="button" class="btn button text-uppercase mt-3">shop now</button>
                    </div>
                </div>
            </div>
            <a href="#carousel-indi" class="carousel-control-prev" data-slide="prev">
                <div class="arrow-icon"><span class="carousel-control-prev-icon" aria-hidden="true"></span></div>
            </a>
            <a href="#carousel-indi" class="carousel-control-next" data-slide="next">
                <span class="arrow-icon"><span class="carousel-control-next-icon" aria-hidden="true"></span></span>
            </a>
        </div>
    </section>
    <div class="container rows my-5 px-4">
        <div class="row">
            <div class="col-lg-3 p-2">
                <div class="bg-white box py-3 px-4 shadow d-flex align-items-center">
                    <div class="mr-3 icon">
                        <i class='bx bxs-plane-alt h1'></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase mb-1">free shopping</h6>
                        <p class="text-muted mb-0">on order over $150</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 p-2">
                <div class="bg-white box py-3 px-4 shadow d-flex align-items-center">
                    <div class="mr-3 icon">
                        <i class='bx bxs-plane-alt h1'></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase mb-1">cash on delivery</h6>
                        <p class="text-muted mb-0">100% money book..</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 p-2">
                <div class="bg-white box py-3 px-4 shadow d-flex align-items-center">
                    <div class="mr-3 icon">
                        <i class='bx bxs-gift h1'></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase mb-1">special gift card</h6>
                        <p class="text-muted mb-0">on order over $150</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 p-2">
                <div class="bg-white box py-3 px-4 shadow d-flex align-items-center">
                    <div class="mr-3 icon">
                        <i class='bx bxs-plane-alt h1'></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase mb-1">free shopping</h6>
                        <p class="text-muted mb-0">call us 123-456-789</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================= categories ============================= -->
    <section id="categories" class="categories px-4 py-5">
        <h1 class="text-capitalize text-center">top categories</h1>
        <div class="container">
            <div class="row my-4 justify-content-between">

                <?php while ($categoryRow = mysqli_fetch_assoc($categoryResult)) { ?>
                    <div class="col-md-4 mt-4 mt-md-0">
                        <div class="categorie">

                            <img src="img/<?php echo $categoryRow['categoriesImage']; ?>" class="categImg" alt="<?php echo $categoryRow['categoriesName']; ?>">
                            <div class="over-lay d-flex align-items-center justify-content-center">
                                <h3 class="text-capitalize text-white text-center"><?php echo $categoryRow['categoriesName']; ?></h3>
                                <div class="line my-3 bg-white"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>
    <section id="products" class="products py-5">
        <div class="container pt-5">
            <h1 class="text-capitalize text-center">top products</h1>
            <div class="row my-3 d-flex align-items-center justify-content-center">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="#dd" class="nav-link active text-capitalize list" data-toggle="pill">featured</a>
                    </li>
                    <li class="nav-item">
                        <a href="#dd" class="nav-link text-capitalize list" data-toggle="pill">latest</a>
                    </li>
                    <li class="nav-item">
                        <a href="#dd" class="nav-link text-capitalize list" data-toggle="pill">bestseller</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ============================== tab content ============================== -->
        <div class="slider">
            <!-- ============================== featured ============================== -->
            <div class="sliderItem px-4">
                <div class="container p-0">
                    <div class="row">



                        <?php while ($featuredRow = mysqli_fetch_assoc($featuredResult)) { ?>

                            <div class="col-md-3 mt-4 mt-md-0">
                                <div class="product bg-white shadow rounded p-2">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="img/<?php echo $featuredRow['image'] ?>" alt="product-1">
                                    </div>
                                    <div class="d-flex align-items-center mb-3 flex-column">
                                        <div class="stars">
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                        </div>
                                        <h6 class="text-capitalize mt-2"><?php echo $featuredRow['coffeeName'] ?></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <form method="post" action="index.php">
                                            <input type="hidden" name="coffeeID" value="<?php echo $featuredRow['coffeeID']; ?>">
                                            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                                            <button type="submit" name="orderBtn" style="border: none; background: transparent; padding: 0;">
                                                <span class="cart p-2 d-flex align-items-center justify-content-center">
                                                    <i class='bx bx-shopping-bag'></i>
                                                </span>
                                            </button>
                                        </form>



                                        <h6><?php echo "$" . number_format($featuredRow['price'], 2); ?></h6>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>
            <!-- ============================== latest ============================== -->
            <div class="sliderItem px-4">
                <div class="container p-0">
                    <div class="row">
                        <?php while ($latestRow = mysqli_fetch_assoc($latestResult)) { ?>
                            <div class="col-md-3 mt-4 mt-md-0">
                                <div class="product bg-white shadow rounded p-2">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="img/<?php echo $latestRow['image']; ?>" alt="product-1">
                                    </div>
                                    <div class="d-flex align-items-center mb-3 flex-column">
                                        <div class="stars">
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bx-star'></i></span>
                                        </div>
                                        <h6 class="text-capitalize mt-2"><?php echo $latestRow['coffeeName']; ?></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="cart p-2 d-flex align-items-center justify-content-center">
                                                <form method="post" action="index.php">
                                                    <input type="hidden" name="coffeeID" value="<?php echo $latestRow['coffeeID']; ?>">
                                                    <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                                                    <button type="submit" name="orderBtn" style="border: none; background: transparent; padding: 0;">
                                                        <span class="cart p-2 d-flex align-items-center justify-content-center">
                                                            <i class='bx bx-shopping-bag'></i>
                                                        </span>
                                                    </button>
                                                </form>
                                            </span>
                                        </div>
                                        <h6><?php echo "$" . number_format($latestRow['price'], 2); ?></h6>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- ============================== bestseller ============================== -->
            <div class="sliderItem px-4">
                <div class="container p-0">
                    <div class="row">
                        <?php while ($bestsellerRow = mysqli_fetch_assoc($bestsellerResult)) { ?>
                            <div class="col-md-3 mt-4 mt-md-0">
                                <div class="product bg-white shadow rounded p-2">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="img/<?php echo $bestsellerRow['image']; ?>" alt="product-1">
                                    </div>
                                    <div class="d-flex align-items-center mb-3 flex-column">
                                        <div class="stars">
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                            <span><i class='bx bxs-star'></i></span>
                                        </div>
                                        <h6 class="text-capitalize mt-2"><?php echo $bestsellerRow['coffeeName']; ?></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="cart p-2 d-flex align-items-center justify-content-center">
                                                <form method="post" action="index.php">
                                                    <input type="hidden" name="coffeeID" value="<?php echo $bestsellerRow['coffeeID']; ?>">
                                                    <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                                                    <button type="submit" name="orderBtn" style="border: none; background: transparent; padding: 0;">
                                                        <span class="cart p-2 d-flex align-items-center justify-content-center">
                                                            <i class='bx bx-shopping-bag'></i>
                                                        </span>
                                                    </button>
                                                </form>

                                                </i>
                                            </span>
                                        </div>
                                        <h6><?php echo "$" . number_format($bestsellerRow['price'], 2); ?></h6>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
    </section>
    <!-- Order Success Modal -->
    <div class="modal fade" id="orderSuccessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Successful!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Your order has been successfully placed! Check your email for details.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- gallery -->
    <div class="container-fluid px-0 py-5">
        <div class="row">
            <div class="col-md-3 py-0">
                <div class="gallery">
                    <img src="img/banner1.jpg" class="rounded imgGaller" alt="banner1">
                    <div class="over-lay d-flex align-items-center justify-content-center">
                        <h3 class="text-capitalize text-white text-center">coffee americano</h3>
                        <div class="line my-3 bg-white"></div>
                        <p class="text-capitalize text-light">american baristas</p>
                    </div>
                </div>
                <div class="gallery">
                    <img src="img/banner2.jpg" class="rounded imgGaller mt-5" alt="banner2">
                    <div class="over-lay d-flex align-items-center justify-content-center">
                        <h3 class="text-capitalize text-white text-center">coppuccino</h3>
                        <div class="line my-3 bg-white"></div>
                        <p class="text-capitalize text-light">Get Up To 50% Disscounts</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 py-0">
                <div class="gallery">
                    <img src="img/banner3.jpg" class="rounded mt-3 mt-md-0 imgGaller" alt="banner3">
                    <div class="over-lay d-flex align-items-center justify-content-center">
                        <h3 class="text-capitalize text-white text-center">dalgana</h3>
                        <div class="line my-3 bg-white"></div>
                        <p class="text-capitalize text-light">Get Up To 60% Disscounts</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 py-0">
                <div class="gallery">
                    <img src="img/banner4.jpg" class="rounded mt-3 mt-md-0 imgGaller" alt="banner3">
                    <div class="over-lay d-flex align-items-center justify-content-center">
                        <h3 class="text-capitalize text-white text-center">flat white</h3>
                        <div class="line my-3 bg-white"></div>
                        <p class="text-capitalize text-light">Get Up To 40% Disscounts</p>
                    </div>
                </div>
                <div class="gallery">
                    <img src="img/banner5.jpg" class="mt-5 rounded imgGaller" alt="banner5">
                    <div class="over-lay d-flex align-items-center justify-content-center">
                        <h3 class="text-capitalize text-white text-center">long black</h3>
                        <div class="line my-3 bg-white"></div>
                        <p class="text-capitalize text-light">Coffee At Breakfast</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container products my-4">
    <h1 class="text-capitalize my-4 text-center">Olympic Merchandise</h1>
    <div class="row justify-content-between">
        <?php if (mysqli_num_rows($merchResult) > 0) {
            while ($merchRow = mysqli_fetch_assoc($merchResult)) {
        ?>
            <div class="col-md-3 mt-4 mt-md-0">
                <div class="product card shadow rounded">
                    <img src="img/<?php echo $merchRow['image'] ?>" class="card-img-top" alt="product-1">
                    <div class="card-body">
                        <div class="stars mb-3">
                            <span><i class='bx bxs-star'></i></span>
                            <span><i class='bx bxs-star'></i></span>
                            <span><i class='bx bxs-star'></i></span>
                            <span><i class='bx bxs-star'></i></span>
                            <span><i class='bx bxs-star'></i></span>
                        </div>
                        <h6 class="card-title text-capitalize"><?php echo $merchRow['merchName'] ?></h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6><?php echo "$" . number_format($merchRow['price'], 2); ?></h6>
                            <form method="post" action="index.php">
                                <input type="hidden" name="merchID" value="<?php echo $merchRow['merchID']; ?>">
                                <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                                <button type="submit" name="orderBtn" class="btn btn-outline-primary cart">
                                    <i class='bx bx-shopping-bag'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
        }
        } ?>
    </div>
</div>


    <!-- ================================= blogs ================================= -->
    <section id="blogs" class="px-4 blogs">
        <h1 class="text-capitalize my-4 text-center">Feedback</h1>
        <div class="container">
            <div class="row">

            <?php if(mysqli_num_rows($feedbackShowResult)>0){
                while($feedbackShowRow=mysqli_fetch_assoc($feedbackShowResult)){

               ?> 
                <div class="col-md-4 mt-4 mt-md-0">
                    <div>
                        <img src="img/blog1-430x287.jpg" class="mb-3 img-fluid rounded alt="blog1">
                        <h4 class="text-capitalize"><?php echo $feedbackShowRow['feedbackName'] ?></h4>
                        <h6 class="text-warning text-capitalize"><?php echo $feedbackShowRow['dateTIme'] ?></h6>
                        <p class="lead">
                        <?php echo $feedbackShowRow['feedbackDescription'] ?>
                        </p>
                        <button class="btn btn-primary text-white">read more</button>
                    </div>
                </div>
                <?php 
                }
            } ?>
            </div>
        </div>
    </section>

    <!-- footer -->
    <section id="footer" class="footer mt-4 pt-5 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3 class="text-capitalize text-black">contact info</h3>
                    <p class="text-white">phone +252 827173</p>
                    <p class="text-white">fax 012-345-234</p>
                    <p class="text-white">email coffee@gmail.com</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-capitalize text-black">information</h3>
                    <p class="text-white">about us</p>
                    <p class="text-white">Delivery information</p>
                    <p class="text-white">Privacy Policy</p>
                    <p class="text-white">Terms & Condition</p>
                    <p class="text-white">Contact Us</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-capitalize text-black">my account</h3>
                    <p class="text-white">My Account</p>
                    <p class="text-white">Order History</p>
                    <p class="text-white">Wish List</p>
                    <p class="text-white">NewsLetter</p>
                    <p class="text-white">Returns</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-capitalize text-black"><?php echo $feedbackShowRow['feedbackName'] ?></h3>
                    <p class="text-white"><?php echo $feedbackShowRow['feedbackDescription'] ?></p>
                    <input type="text" placeholder="Enter e-mail here.." class="w-100 text-white py-2"
                        style="background-color: transparent;outline: none; border: none;border-bottom: 1px solid #ddd;">
                    <button class="btn btn-primary text-uppercase mt-4">subscribe</button>
                </div>
            </div>
        </div>
        <div class="container-fluid border-top mt-3">
            <div class="container">
                <div class="row justify-content-between mt-4">
                    <div class="col-md-4 mt-4 mt-md-0">
                        <p>WWW.DownloadNewTheme.com</p>
                    </div>
                    <div class="col-md-4 mt-4 mt-md-0">
                        <img src="img/payment.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script>
        <?php if (isset($_SESSION['order_successful']) && $_SESSION['order_successful'] == true): ?>
            $('#orderSuccessModal').modal('show');
            <?php unset($_SESSION['order_successful']); // Clear session flag 
            ?>
        <?php endif; ?>
    </script>
</body>

</html>