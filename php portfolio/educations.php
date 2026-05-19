<?php
$pageTitle = "Portfolio | Education";
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

    <h1>Education</h1>
    <p>This page contains my complete academic history.</p>

    <hr />

    <?php
    $education = [
      [
        "title" => "1) Bachelor of Science in Computer Science & Engineering (CSE)",
        "logo" => "images/aiublogo.png",
        "logo_alt" => "AIUB Logo",
        "institution" => "American International University-Bangladesh (AIUB)",
        "details" => [
          "Program" => "BSc in Computer Science & Engineering",
          "Status" => "Currently Studying"
        ],
        "course_groups" => [
          "Completed Major Courses" => [
            "Data Structures and Algorithms (DSA)",
            "Discrete Mathematics and Engineering Mathematics",
            "Compiler Design",
            "Software Engineering",
            "Artificial Intelligence",
            "Digital Logic and Circuits (DLC)",
            "Electrical Devices and Circuits"
          ],
          "Other Academic Courses" => [
            "Physics",
            "Chemistry",
            "English"
          ]
        ]
      ],
      [
        "title" => "2) A Levels",
        "logo" => "images/mastermind.png",
        "logo_alt" => "Mastermind School Logo",
        "institution" => "Mastermind School",
        "details" => [
          "Board" => "Pearson Edexcel"
        ],
        "course_groups" => [
          "Subjects" => [
            "Mathematics",
            "Physics",
            "Chemistry",
            "Biology"
          ]
        ]
      ],
      [
        "title" => "3) O Levels",
        "logo" => "images/mastermind.png",
        "logo_alt" => "Mastermind School Logo",
        "institution" => "Mastermind School",
        "details" => [
          "Board" => "Pearson Edexcel"
        ],
        "course_groups" => [
          "Subjects" => [
            "Mathematics B",
            "Further Mathematics",
            "English",
            "Bangla",
            "Biology",
            "Human Biology",
            "Physics",
            "Chemistry",
            "Economics",
            "Accounting",
            "ICT"
          ]
        ]
      ]
    ];

    foreach ($education as $edu): ?>
      <section>
        <h2><?php echo $edu["title"]; ?></h2>
        <img src="<?php echo $edu["logo"]; ?>" alt="<?php echo $edu["logo_alt"]; ?>" width="150">
        <h3>Institution: <?php echo $edu["institution"]; ?></h3>

        <?php foreach ($edu["details"] as $label => $value): ?>
          <p><b><?php echo $label; ?>:</b> <?php echo $value; ?></p>
        <?php endforeach; ?>

        <?php foreach ($edu["course_groups"] as $groupName => $courses): ?>
          <h4><?php echo $groupName; ?></h4>
          <ul>
            <?php foreach ($courses as $course): ?>
              <li><?php echo $course; ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
      </section>
      <hr />
    <?php endforeach; ?>

  </div>

</body>
</html>