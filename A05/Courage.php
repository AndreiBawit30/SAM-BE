<?php include('connect.php');

// Fetch Heroism content for island personality 2
$heroismQuery = 'SELECT * FROM islandcontents WHERE islandOfPersonalityID = 2 and islandContentID = 4;';
$heroismResults = executeQuery($heroismQuery);

// Fetch Determination content for island personality 2
$determinationQuery = 'SELECT * FROM islandcontents WHERE islandOfPersonalityID = 2 and islandContentID = 5;';
$determinationResults = executeQuery($determinationQuery);

// Fetch Boldness content for island personality 2
$boldnessQuery = 'SELECT * FROM islandcontents WHERE islandOfPersonalityID = 2 and islandContentID = 6;';
$boldnessResults = executeQuery($boldnessQuery);

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

  <!-- Links (sit on top) -->
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

  <!-- Header with image -->
  <header class="bgimg w3-display-container w3-grayscale-min" id="home">
    <div class="w3-display-bottomleft w3-center w3-padding-large w3-hide-small">
      <span class="w3-tag">My personalities</span>
    </div>
    <div class="w3-display-middle w3-center">
      <a href="#personalities" class="btn btn-light ms-2" data-aos="fade-up" data-aos-delay="100">Explore Now</a>
    </div>
    <div class="w3-display-bottomright w3-center w3-padding-large">
      <span class="w3-text-white">Explore my Emotions</span>
    </div>
  </header>

  <!-- Add a background color and large text to the whole page -->
  <div class="w3-sand w3-grayscale w3-large" id="personalities">

    <!-- Heroism content -->
    <?php if (mysqli_num_rows($heroismResults) > 0) {
      while ($heroismRow = mysqli_fetch_assoc($heroismResults)) {
    ?>

      <!-- About Heroism -->
      <div class="w3-container" id="about" data-aos="fade-up" data-aos-delay="200">
        <div class="w3-content" style="max-width:700px">
          <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide" style="background-color: <?php echo $heroismRow['color'] ?>; color: white;">HEROISM</span></h5>
          <p><?php echo $heroismRow['content']; ?></p>
          <img src="/assets/<?php echo $heroismRow['image']; ?>" style="width:100%;max-width:1000px" class="w3-margin-top" data-aos="zoom-in" data-aos-delay="300">
        </div>
      </div>

    <?php
      }
    }
    ?>

    <!-- Determination content -->
    <?php if (mysqli_num_rows($determinationResults) > 0) {
      while ($determinationRow = mysqli_fetch_assoc($determinationResults)) {
    ?>

      <!-- About Determination -->
      <div class="w3-container" id="about" data-aos="fade-up" data-aos-delay="400">
        <div class="w3-content" style="max-width:700px">
          <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide" style="background-color: <?php echo $determinationRow['color'] ?>; color: white;">DETERMINATION</span></h5>
          <p><?php echo $determinationRow['content']; ?></p>
          <img src="/assets/<?php echo $determinationRow['image']; ?>" style="width:100%;max-width:1000px" class="w3-margin-top" data-aos="zoom-in" data-aos-delay="500">
        </div>
      </div>

    <?php
      }
    }
    ?>

    <!-- Boldness content -->
    <?php if (mysqli_num_rows($boldnessResults) > 0) {
      while ($boldnessRow = mysqli_fetch_assoc($boldnessResults)) {
    ?>

      <!-- About Boldness -->
      <div class="w3-container" id="where" style="padding-bottom:32px;" data-aos="fade-up" data-aos-delay="600">
        <div class="w3-content" style="max-width:700px">
          <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide" style="background-color: <?php echo $boldnessRow['color'] ?>; color: white;">BOLDNESS</span></h5>
          <p><span class="w3-tag">ALWAYS!</span><?php echo $boldnessRow['content']; ?></p>
          <img src="/assets/<?php echo $boldnessRow['image']; ?>" class="w3-image" style="width:100%" data-aos="zoom-in" data-aos-delay="700">
        </div>
      </div>

    <?php
      }
    }
    ?>

  </div>

  <!-- Footer -->
  <footer class="w3-center w3-light-grey w3-padding-48 w3-large">
    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>
  </footer>

  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init(); // Initialize AOS
  </script>

</body>

</html>
