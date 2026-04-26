<?php
$fnameErr = $lnameErr = $genderErr = $emailErr = $topicErr = $dateErr = $reasonErr = ""; 
$fname = $lname = $gender = $email = $company = $topic = $date = "";
$reason = [];

function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["firstname"])) {
        $fnameErr = "First name is required";
    } else {
        $fname = cleanInput($_POST["firstname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $fnameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["lastname"])) {
        $lnameErr = "Last name is required";
    } else {
        $lname = cleanInput($_POST["lastname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
            $lnameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = cleanInput($_POST["gender"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    $company = cleanInput($_POST["company"] ?? "");

    if (empty($_POST["reason"])) {
        $reasonErr = "At least one reason is required";
    } else {
        foreach ($_POST["reason"] as $r) {
            $reason[] = cleanInput($r);
        }
    }

    if (empty($_POST["topic"])) {
        $topicErr = "Topic is required";
    } else {
        $topic = cleanInput($_POST["topic"]);
    }

    if (empty($_POST["date"])) {
        $dateErr = "Consultation date is required";
    } else {
        $date = cleanInput($_POST["date"]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Aqila Usrat</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f9f9f9;
            color: #222;
        }

        h1 {
            margin-bottom: 10px;
        }

        fieldset {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            max-width: 700px;
        }

        legend {
            font-weight: bold;
            padding: 0 8px;
        }

        label {
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
            width: 320px;
            padding: 8px 10px;
            margin-top: 5px;
            border: 1px solid #bbb;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 6px;
        }

        input[type="submit"],
        input[type="reset"] {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
            margin-right: 8px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
        }

        input[type="reset"] {
            background-color: #6c757d;
            color: white;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        input[type="reset"]:hover {
            background-color: #545b62;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-text {
            color: red;
            margin-left: 6px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .submitted-box {
            margin-top: 25px;
            padding: 15px;
            max-width: 700px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <header>
        <nav>
            <hr>
            <a href="index.html">Home</a> |
            <a href="educations.html">Education</a> |
            <a href="experience.html">Experience</a> |
            <a href="projects.html">Projects</a> |
            <a href="contact.php">Contact</a>
            <hr>
        </nav>
    </header>

    <h1>Contact - Aqila Usrat</h1>

    <p><span style="color:red">* required field</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <fieldset>
            <legend>Contact Form</legend>

            <div class="form-group">
                <label for="fname1">First Name (required)</label><br>
                <input type="text" id="fname1" name="firstname" value="<?php echo $fname; ?>">
                <span class="error-text">* <?php echo $fnameErr; ?></span>
            </div>

            <div class="form-group">
                <label for="lname1">Last Name (required)</label><br>
                <input type="text" id="lname1" name="lastname" value="<?php echo $lname; ?>">
                <span class="error-text">* <?php echo $lnameErr; ?></span>
            </div>

            <div class="form-group">
                <label>Gender (required)</label><br>
                <input type="radio" id="male1" name="gender" value="male" <?php if ($gender == "male") echo "checked"; ?>>
                <label for="male1">Male</label>

                <input type="radio" id="female1" name="gender" value="female" <?php if ($gender == "female") echo "checked"; ?>>
                <label for="female1">Female</label>
                <span class="error-text">* <?php echo $genderErr; ?></span>
            </div>

            <div class="form-group">
                <label for="email1">Email (required)</label><br>
                <input type="email" id="email1" name="email" value="<?php echo $email; ?>">
                <span class="error-text">* <?php echo $emailErr; ?></span>
            </div>

            <div class="form-group">
                <label for="company1">Company</label><br>
                <input type="text" id="company1" name="company" value="<?php echo $company; ?>">
            </div>

            <div class="form-group">
                <label>Reason for Contact (required)</label><br>
                <input type="checkbox" id="projects1" name="reason[]" value="projects" <?php if (in_array("projects", $reason)) echo "checked"; ?>>
                <label for="projects1">Projects</label>

                <input type="checkbox" id="thesis1" name="reason[]" value="thesis" <?php if (in_array("thesis", $reason)) echo "checked"; ?>>
                <label for="thesis1">Thesis</label>

                <input type="checkbox" id="job1" name="reason[]" value="job" <?php if (in_array("job", $reason)) echo "checked"; ?>>
                <label for="job1">Job</label>
                <span class="error-text">* <?php echo $reasonErr; ?></span>
            </div>

            <div class="form-group">
                <label for="topic1">Topics (required)</label><br>
                <select id="topic1" name="topic">
                    <option value="">Select Topic</option>
                    <option value="Web Development" <?php if ($topic == "Web Development") echo "selected"; ?>>Web Development</option>
                    <option value="Mobile Development" <?php if ($topic == "Mobile Development") echo "selected"; ?>>Mobile Development</option>
                    <option value="AI/ML Development" <?php if ($topic == "AI/ML Development") echo "selected"; ?>>AI/ML Development</option>
                </select>
                <span class="error-text">* <?php echo $topicErr; ?></span>
            </div>

            <div class="form-group">
                <label for="date1">Consultation Date (required)</label><br>
                <input type="date" id="date1" name="date" value="<?php echo $date; ?>">
                <span class="error-text">* <?php echo $dateErr; ?></span>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Clear">

        </fieldset>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$fnameErr && !$lnameErr && !$genderErr && !$emailErr && !$reasonErr && !$topicErr && !$dateErr): ?>
        <div class="submitted-box">
            <h3>Submitted Values</h3>
            First Name: <?php echo $fname; ?><br>
            Last Name: <?php echo $lname; ?><br>
            Gender: <?php echo $gender; ?><br>
            Email: <?php echo $email; ?><br>
            Company: <?php echo $company; ?><br>
            Reason for Contact: <?php echo implode(", ", $reason); ?><br>
            Topic: <?php echo $topic; ?><br>
            Consultation Date: <?php echo $date; ?><br>
        </div>
    <?php endif; ?>

    <br><br>
    <a href="index.html">Back to Home</a>

</body>
</html>