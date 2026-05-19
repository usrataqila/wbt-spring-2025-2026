<?php
$pageTitle = "Portfolio | Projects";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <nav>
      <hr>
      <a href="index.php">Home</a> |
      <a href="educations.php">Education</a> |
      <a href="experience.php">Experience</a> |
      <a href="projects.php">Projects</a> |
      <a href="contact.php">Contact</a>
      <hr>
    </nav>
  </header>

  <div class="profile-box">

    <h1>Projects</h1>
    <p>This page contains my academic and personal projects with screenshots and technologies used.</p>
    <hr />

    <!-- Project 1 -->
    <section>
      <h2>1) Personal Portfolio Website</h2>
      <img src="images/personalportfolio.png" alt="Screenshot of Portfolio Home Page" width="300">
      <img src="images/educationportfolio.png" alt="Screenshot of Portfolio Education Page" width="300">
      <img src="images/experienceportfolio.png" alt="Screenshot of Portfolio Experience Page" width="300">
      
      <img src="images/projectsportfolio.png" alt="Screenshot of Portfolio Projects Page" width="300">
      <img src="images/contactportfolio.png" alt="Screenshot of Portfolio Contact Page" width="300">
      <h3>Project Description</h3>
      <p>
        This is a multi-page personal portfolio website developed using HTML and PHP. The project includes
        sections such as Home, Education, Experience, Projects, and Contact. The purpose of this
        project was to practice proper folder structure, semantic HTML, PHP templating, and professional
        content organization.
      </p>
      <h3>Skills & Technologies Used</h3>
      <ul>
        <li>HTML5</li>
        <li>PHP</li>
        <li>CSS3</li>
        <li>Semantic Page Structure</li>
        <li>Image Integration</li>
        <li>Folder Organization</li>
      </ul>
      <h3>Key Features</h3>
      <ul>
        <li>Multi-page layout with organized content</li>
        <li>Clear sections for personal information</li>
        <li>Styled using a shared CSS file</li>
      </ul>
    </section>
    <hr />

    <!-- Project 2 -->
    <section>
      <h2>2) Simple ATM System</h2>
      <img src="images/simpleatm.png" alt="Screenshot of Simple ATM System" width="300">
      <h3>Project Description</h3>
      <p>
        This is a console-based ATM simulation system developed in C++ using object-oriented programming.
        The program allows a user to withdraw money, transfer money to another account, and view recent
        transaction history. It uses a class-based structure with private balance and transaction record
        arrays, demonstrating encapsulation and basic OOP concepts.
      </p>
      <h3>Skills & Technologies Used</h3>
      <ul>
        <li>C++</li>
        <li>Object-Oriented Programming (OOP)</li>
        <li>Classes and Encapsulation</li>
        <li>Arrays and Loops</li>
        <li>Switch-Case Menu Logic</li>
      </ul>
      <h3>Key Features</h3>
      <ul>
        <li>Withdraw money with balance validation</li>
        <li>Transfer money to another account by entering account number</li>
        <li>View full transaction history with amounts</li>
        <li>Menu-driven interface with loop until exit</li>
      </ul>
    </section>
    <hr />

    <!-- Project 3 -->
    <section>
      <h2>3) Metro Train and City Scene</h2>
      <img src="images/day.png" alt="Day scene of Metro Train project" width="300">
      <img src="images/night.png" alt="Night scene of Metro Train project" width="300">
      <img src="images/dayandrain.png" alt="Day with rain scene of Metro Train project" width="300">
      <img src="images/nightandrain.png" alt="Night with rain scene of Metro Train project" width="300">
      <h3>Project Description</h3>
      <p>
        This project is a computer graphics based metro train and city scene developed in C++ using
        OpenGL and GLUT. It was my Computer Graphics course semester project. The scene includes a
        moving metro train, road vehicles, buildings, station structures, clouds, rain effects, and
        day-night mode. The purpose of this project was to practice 2D graphics design, animation
        logic, and interactive scene control.
      </p>
      <h3>Skills & Technologies Used</h3>
      <ul>
        <li>C++</li>
        <li>OpenGL</li>
        <li>GLUT</li>
        <li>2D Computer Graphics</li>
        <li>Animation and Interaction Logic</li>
      </ul>
      <h3>Key Features</h3>
      <ul>
        <li>Animated metro train, cars, and microbus movement</li>
        <li>Day and night mode with cloud and rain effects</li>
        <li>Keyboard and mouse controls for pausing and scene interaction</li>
      </ul>
    </section>

  </div>

</body>
</html>