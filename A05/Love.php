<?php include('connect.php');


$passionQuery = 'SELECT * FROM islandcontents WHERE islandOfPersonalityID = 3 and islandContentID = 7;';
$passionResults = executeQuery($passionQuery);


$careQuery = 'SELECT * FROM islandcontents WHERE islandOfPersonalityID = 3 and islandContentID = 8;';
$careResults = executeQuery($careQuery);


$cherishQuery = 'SELECT * FROM islandcontents WHERE islandOfPersonalityID = 3 and islandContentID = 9;';
$cherishResults = executeQuery($cherishQuery);
?>

<!DOCTYPE html>
<html>

<head>
  <title>W3.CSS Template</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /> <!-- AOS CSS -->
  <style>
    body,
    html {
      height: 100%;
      font-family: "Inconsolata", sans-serif;
    }

    .bgimg {
      background-position: center;
      background-size: cover;
      background-image: url("/assets/homepic.jpg");
      height: 100vh;
    }

    .menu {
      display: none;
    }

    .btn {
      font-weight: 500;
      font-size: 25px;
      text-transform: uppercase;
      border-radius: 8px;
      padding: 10px 24px;
      outline: none;
      transition: 0.3s ease-in-out;
    }

    .btn-light {
      background-color: #000000;
      border-color: 1px solid #FFFFFF;
      color: whitesmoke;
    }

    .btn-light:hover {
      background-color: whitesmoke;
      border-color: 1px solid var();
      color: var(--c-dark);
    }
  </style>
</head>

<body>


  <div class="w3-top">
    <div class="w3-row w3-padding-16 w3-black w3-wide" style="display: flex; justify-content: flex-end; width: 100%;">
      <div class="w3-col w3-padding-0">
        <a href="index.php" class="w3-button w3-block w3-black">HOME</a>
      </div>
      <div class="w3-col w3-padding-0">
        <a href="Hope.php" class="w3-button w3-block w3-black">HOPE</a>
      </div>
      <div class="w3-col w3-padding-0">
        <a href="Courage.php" class="w3-button w3-block w3-black">COURAGE</a>
      </div>
      <div class="w3-col w3-padding-0">
        <a href="Love.php" class="w3-button w3-block w3-black">LOVE</a>
      </div>
      <div class="w3-col w3-padding-0">
        <a href="Eagerness.php" class="w3-button w3-block w3-black">EAGERNESS</a>
      </div>
    </div>
  </div>


  <header class="bgimg w3-display-container w3-grayscale-min" id="home">
    <div class="w3-display-bottomleft w3-center w3-padding-large w3-hide-small">
      <span class="w3-tag">My personalities</span>
    </div>
    <div class="w3-display-middle w3-center">
      <a href="#personalities" class="btn btn-light ms-2" data-aos="fade-up" data-aos-delay="250">Explore Now</a> 
    </div>
    <div class="w3-display-bottomright w3-center w3-padding-large">
      <span class="w3-text-white">Explore my Emotions</span>
    </div>
  </header>

  <div class="w3-sand w3-grayscale w3-large">

    <?php if (mysqli_num_rows($passionResults) > 0) {
      while ($passionRow = mysqli_fetch_assoc($passionResults)) {
    ?>

      <!-- About Passion -->
      <div class="w3-container" id="about" data-aos="fade-up" data-aos-delay="200">
        <div class="w3-content" style="max-width:700px">
          <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide" style="background-color: <?php echo $passionRow['color'] ?>; color: white;">PASSION</span></h5>
          <p><?php echo $passionRow['content']; ?></p>
          <img src="/assets/<?php echo $passionRow['image']; ?>" style="width:100%;max-width:1000px" class="w3-margin-top" data-aos="zoom-in" data-aos-delay="300">
        </div>
      </div>

    <?php
      }
    }
    ?>

 
    <?php if (mysqli_num_rows($careResults) > 0) {
      while ($careRow = mysqli_fetch_assoc($careResults)) {
    ?>

      <div class="w3-container" id="personalities" data-aos="fade-up" data-aos-delay="250">
        <div class="w3-content" style="max-width:700px">
          <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide" style="background-color: <?php echo $careRow['color'] ?>; color: white;">CARE</span></h5>
          <p><?php echo $careRow['content']; ?></p>
          <img src="/assets/<?php echo $careRow['image']; ?>" style="width:100%;max-width:1000px" class="w3-margin-top" data-aos="zoom-in" data-aos-delay="500">
        </div>
      </div>

    <?php
      }
    }
    ?>


    <?php if (mysqli_num_rows($cherishResults) > 0) {
      while ($cherishRow = mysqli_fetch_assoc($cherishResults)) {
    ?>


      <div class="w3-container" id="about" style="padding-bottom:32px;" data-aos="fade-up" data-aos-delay="250">
        <div class="w3-content" style="max-width:700px">
          <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide" style="background-color: <?php echo $cherishRow['color'] ?>; color: white;">CHERISHING</span></h5>
          <p><span class="w3-tag">FOREVER! </span><?php echo $cherishRow['content']; ?></p>
          <img src="/assets/<?php echo $cherishRow['image']; ?>" class="w3-image" style="width:100%" data-aos="zoom-in" data-aos-delay="700">
        </div>
      </div>

    <?php
      }
    }
    ?>

  </div>


  <footer class="w3-center w3-light-grey w3-padding-48 w3-large">
    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>
  </footer>

  
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init(); 
  </script>

</body>

</html>
