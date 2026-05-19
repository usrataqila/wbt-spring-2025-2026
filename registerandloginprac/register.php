<?php
$usernameErr = $passwordErr = "";
$username = $password = "";
$msg = "";

function cleanInput($data) {
    $data = trim($data);
    $data = preg_replace('/\s+/', ' ', $data); // removes extra spaces
    return htmlspecialchars(stripslashes($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = cleanInput($_POST["username"]);
        $username = strtolower($username); // turns username to lowercase
    }

    // Password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = cleanInput($_POST["password"]);
    }

    // Login check
    if ($usernameErr == "" && $passwordErr == "") {

        if ($username == "admin" && $password == "Admin12345") {
            $msg = "Login successful!";
        } else {
            $msg = "Invalid username or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

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
            width: 130px;
            font-weight: bold;
            text-align: right;
            padding-top: 10px;
        }

        .form-table input[type="text"],
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

        .message {
            margin-top: 15px;
            font-weight: bold;
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
    </style>
</head>

<body>

    <h2>Login</h2>
    <p><span class="required">* required field</span></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class="form-table">

            <tr>
                <td>Username <span class="required">*</span></td>
                <td>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                    <span class="error"><?php echo $usernameErr; ?></span>
                </td>
            </tr>

            <tr>
                <td>Password <span class="required">*</span></td>
                <td>
                    <input type="password" name="password">
                    <span class="error"><?php echo $passwordErr; ?></span>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Login">
                </td>
            </tr>

        </table>
    </form>

    <?php if (!empty($msg)): ?>
        <p class="message"><?php echo $msg; ?></p>
    <?php endif; ?>

    <p>Don't have an account? <a href="register.php">Register</a></p>

</body>
</html>