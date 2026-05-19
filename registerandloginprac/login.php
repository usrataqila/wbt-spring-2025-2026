<?php
$firstNameErr = $lastNameErr = $emailErr = $contactErr = $passwordErr = "";
$firstName = $lastName = $email = $contact = $password = "";

function cleanInput($data) {
    $data = trim($data);
    $data = preg_replace('/\s+/', ' ', $data);
    return htmlspecialchars(stripslashes($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["first_name"])) {
        $firstNameErr = "First name is required";
    } else {
        $firstName = cleanInput($_POST["first_name"]);

        if (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
            $firstNameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["last_name"])) {
        $lastNameErr = "Last name is required";
    } else {
        $lastName = cleanInput($_POST["last_name"]);

        if (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
            $lastNameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = cleanInput($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["contact"])) {
        $contactErr = "Contact number is required";
    } else {
        $contact = cleanInput($_POST["contact"]);

        if (!preg_match("/^[0-9]*$/", $contact)) {
            $contactErr = "Only numbers are allowed";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = cleanInput($_POST["password"]);

        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h2 {
            margin-bottom: 5px;
        }

        .form-table {
            border-collapse: collapse;
            width: 600px;
        }

        .form-table td {
            padding: 8px 10px;
            vertical-align: top;
        }

        .form-table td:first-child {
            width: 150px;
            font-weight: bold;
            text-align: right;
            padding-top: 10px;
        }

        .form-table input[type="text"],
        .form-table input[type="email"],
        .form-table input[type="password"] {
            width: 280px;
            padding: 5px 7px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-size: 13px;
            display: block;
            margin-top: 3px;
        }

        .required {
            color: red;
        }

        .form-table input[type="submit"] {
            padding: 7px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .form-table input[type="submit"]:hover {
            background-color: #45a049;
        }

        .result-table {
            border-collapse: collapse;
            width: 500px;
            margin-top: 10px;
        }

        .result-table td {
            padding: 7px 12px;
            border: 1px solid #ddd;
        }

        .result-table td:first-child {
            font-weight: bold;
            background-color: #f2f2f2;
            width: 150px;
        }
    </style>
</head>

<body>

    <h2>Registration</h2>
    <p><span class="required">* required field</span></p>

    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class="form-table">

            <tr>
                <td>First Name <span class="required">*</span></td>
                <td>
                    <input type="text" name="first_name" value="<?= $firstName ?>">
                    <span class="error"><?= $firstNameErr ?></span>
                </td>
            </tr>

            <tr>
                <td>Last Name <span class="required">*</span></td>
                <td>
                    <input type="text" name="last_name" value="<?= $lastName ?>">
                    <span class="error"><?= $lastNameErr ?></span>
                </td>
            </tr>

            <tr>
                <td>Email <span class="required">*</span></td>
                <td>
                    <input type="text" name="email" value="<?= $email ?>">
                    <span class="error"><?= $emailErr ?></span>
                </td>
            </tr>

            <tr>
                <td>Contact Number <span class="required">*</span></td>
                <td>
                    <input type="text" name="contact" value="<?= $contact ?>">
                    <span class="error"><?= $contactErr ?></span>
                </td>
            </tr>

            <tr>
                <td>Password <span class="required">*</span></td>
                <td>
                    <input type="password" name="password">
                    <span class="error"><?= $passwordErr ?></span>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Register">
                </td>
            </tr>

        </table>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" &&
        !$firstNameErr && !$lastNameErr && !$emailErr && !$contactErr && !$passwordErr): ?>

        <h3>Submitted values</h3>

        <table class="result-table">
            <tr>
                <td>First Name</td>
                <td><?= $firstName ?></td>
            </tr>

            <tr>
                <td>Last Name</td>
                <td><?= $lastName ?></td>
            </tr>

            <tr>
                <td>Email</td>
                <td><?= $email ?></td>
            </tr>

            <tr>
                <td>Contact Number</td>
                <td><?= $contact ?></td>
            </tr>

            <tr>
                <td>Password</td>
                <td><?= $password ?></td>
            </tr>
        </table>

    <?php endif; ?>

</body>
</html>