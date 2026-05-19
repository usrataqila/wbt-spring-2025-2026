<?php
$pageTitle = "Portfolio | Experience";

$experiences = [
  [
    "title" => "1) IT Support Intern",
    "logo" => "images/citybank.png",
    "logo_alt" => "City Bank Logo",
    "company" => "City Bank Limited",
    "details" => [
      "Location" => "Dhaka, Bangladesh",
      "Duration" => "January 2025 - April 2025"
    ],
    "groups" => [
      "Key Responsibilities" => [
        "Provided basic technical support for internal software systems.",
        "Assisted employees with hardware and software troubleshooting.",
        "Helped maintain system updates and documentation.",
        "Reported technical issues to senior IT personnel."
      ],
      "Skills Developed" => [
        "Improved troubleshooting and problem-solving abilities.",
        "Enhanced communication skills in a professional environment.",
        "Gained exposure to corporate IT operations."
      ]
    ]
  ],
  [
    "title" => "2) Junior IT Executive",
    "logo" => "images/bracbank.png",
    "logo_alt" => "BRAC Bank Logo",
    "company" => "BRAC Bank PLC",
    "details" => [
      "Location" => "Dhaka, Bangladesh",
      "Duration" => "May 2025 - August 2025"
    ],
    "groups" => [
      "Key Responsibilities" => [
        "Assisted in managing internal IT systems and databases.",
        "Monitored system performance and reported technical issues.",
        "Supported software testing processes.",
        "Maintained technical documentation."
      ],
      "Skills Developed" => [
        "Basic understanding of database management systems.",
        "Exposure to cybersecurity awareness practices.",
        "Strengthened teamwork and analytical skills."
      ]
    ]
  ],
  [
    "title" => "3) IT Operations Assistant",
    "logo" => "images/unilever.png",
    "logo_alt" => "Unilever Bangladesh Logo",
    "company" => "Unilever Bangladesh Limited",
    "details" => [
      "Location" => "Dhaka, Bangladesh",
      "Duration" => "September 2025 - Present"
    ],
    "groups" => [
      "Key Responsibilities" => [
        "Assisted in supporting IT infrastructure across departments.",
        "Helped maintain internal web applications.",
        "Collaborated with team members to ensure smooth system operations."
      ],
      "Skills Developed" => [
        "Improved understanding of enterprise IT environments.",
        "Developed technical troubleshooting skills.",
        "Enhanced organizational and communication abilities."
      ]
    ]
  ]
];
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

    <h1>Experience</h1>
    <p>My experience in IT-related positions.</p>

    <hr />

    <?php foreach ($experiences as $exp): ?>
      <section>
        <h2><?php echo $exp["title"]; ?></h2>
        <img src="<?php echo $exp["logo"]; ?>" alt="<?php echo $exp["logo_alt"]; ?>" width="150">
        <h3>Company: <?php echo $exp["company"]; ?></h3>

        <?php foreach ($exp["details"] as $label => $value): ?>
          <p><b><?php echo $label; ?>:</b> <?php echo $value; ?></p>
        <?php endforeach; ?>

        <?php foreach ($exp["groups"] as $groupName => $items): ?>
          <h4><?php echo $groupName; ?></h4>
          <ul>
            <?php foreach ($items as $item): ?>
              <li><?php echo $item; ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
      </section>
      <hr />
    <?php endforeach; ?>

  </div>

</body>
</html>