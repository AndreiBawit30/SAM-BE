<?php include('connect.php');

$personalityQuery = 'SELECT * FROM islandsofpersonality';
$personalityResults = executeQuery($personalityQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>W3.CSS Template</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />  <!-- AOS CSS -->
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
      border-color: 1px solid whitesmoke;
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
      <a href="#personalities" class="btn btn-light ms-2 explore" data-aos="fade-up" data-aos-delay="100">Explore Now</a> <!-- AOS added here -->
    </div>
    <div class="w3-display-bottomright w3-center w3-padding-large">
      <span class="w3-text-white">Explore my Emotions</span>
    </div>
  </header>

  <!-- Add a background color and large text to the whole page -->
  <div class="w3-sand w3-grayscale w3-large">
    <?php if (mysqli_num_rows($personalityResults) > 0) {
      while ($personalityRow = mysqli_fetch_assoc($personalityResults)) {
    ?>

      <!-- About Container -->
      <div class="w3-container" id="personalities">
        <div class="w3-content" style="max-width:700px">
          <h5 class="w3-center w3-padding-64">
            <span class="w3-tag w3-wide" data-aos="fade-up" data-aos-delay="200"><?php echo $personalityRow['name'] ?></span> <!-- AOS added here -->
          </h5>
          <p data-aos="fade-right" data-aos-delay="300"><?php echo $personalityRow['shortDescription'] ?></p> <!-- AOS added here -->

          <div class="w3-panel w3-leftbar" style="background-color: <?php echo $personalityRow['color']; ?>; border-radius: 2rem;" data-aos="fade-left" data-aos-delay="400">
            <!-- Enlarge the image, center it, and maintain consistent size -->
            <img src="/assets/<?php echo $personalityRow['image']; ?>"
              style="width: 250px; height: 250px; display: block; margin: 0 auto;"
              class="w3-margin-top" data-aos="zoom-in" data-aos-delay="500"> <!-- AOS added here -->

            <!-- Description -->
            <p><i>"<?php echo $personalityRow['longDescription']; ?>"</i></p>
            <p>- <?php echo $personalityRow['name']; ?></p>
          </div>
        </div>
      </div>

    <?php
      }
    }
    ?>

    <!-- Footer -->
    <footer class="w3-center w3-light-grey w3-padding-48 w3-large">
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>
    </footer>

  </div>

  <!-- AOS script -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init(); // Initialize AOS
  </script>

</body>

</html>
