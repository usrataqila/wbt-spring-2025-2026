<?php
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"] ?? "");
    $lastname = trim($_POST["lastname"] ?? "");
    $company = trim($_POST["company"] ?? "");
    $address1 = trim($_POST["address1"] ?? "");
    $address2 = trim($_POST["address2"] ?? "");
    $city = trim($_POST["city"] ?? "");
    $state = trim($_POST["state"] ?? "");
    $zip = trim($_POST["zip"] ?? "");
    $country = trim($_POST["country"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $fax = trim($_POST["fax"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $donation = trim($_POST["donation"] ?? "");
    $other_amount = trim($_POST["other-amount"] ?? "");
    $recurring = isset($_POST["recurring"]) ? "yes" : "no";
    $monthly_amount = trim($_POST["monthly-amount"] ?? "");
    $months_for = trim($_POST["months-for"] ?? "");

    if (empty($firstname)) $errors[] = "First Name is required.";
    if (empty($lastname)) $errors[] = "Last Name is required.";
    if (empty($address1)) $errors[] = "Address 1 is required.";
    if (empty($city)) $errors[] = "City is required.";
    if (empty($state)) $errors[] = "State is required.";
    if (empty($zip)) $errors[] = "Zip Code is required.";
    if (empty($country)) $errors[] = "Country is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid Email is required.";
    if (empty($donation)) $errors[] = "Donation Amount is required.";

    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Form</title>
    <link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>

<main>
    <h1>Donor Information</h1>

    <?php if ($success): ?>
        <p style="color:green;">Thank you! Your donation form has been submitted successfully.</p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="donor-form">
        <form method="post">
            <fieldset>
                <legend>Donor Information</legend>
                <table>
                    <tr>
                        <td><label for="firstname">First Name *</label></td>
                        <td><input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname ?? ''); ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="lastname">Last Name *</label></td>
                        <td><input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname ?? ''); ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="company">Company</label></td>
                        <td><input type="text" id="company" name="company" value="<?php echo htmlspecialchars($company ?? ''); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="address1">Address 1 *</label></td>
                        <td><input type="text" id="address1" name="address1" value="<?php echo htmlspecialchars($address1 ?? ''); ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="address2">Address 2</label></td>
                        <td><input type="text" id="address2" name="address2" value="<?php echo htmlspecialchars($address2 ?? ''); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="city">City *</label></td>
                        <td><input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city ?? ''); ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="state">State *</label></td>
                        <td>
                            <select id="state" name="state" required>
                                <option value="">Select a State</option>
                                <option value="dhaka" <?php echo (($state ?? '') == 'dhaka') ? 'selected' : ''; ?>>Dhaka</option>
                                <option value="chittagong" <?php echo (($state ?? '') == 'chittagong') ? 'selected' : ''; ?>>Chittagong</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="zip">Zip Code *</label></td>
                        <td><input type="text" id="zip" name="zip" value="<?php echo htmlspecialchars($zip ?? ''); ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="country">Country *</label></td>
                        <td>
                            <select id="country" name="country" required>
                                <option value="">Select a Country</option>
                                <option value="BD" <?php echo (($country ?? '') == 'BD') ? 'selected' : ''; ?>>Bangladesh</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="phone">Phone</label></td>
                        <td><input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="fax">Fax</label></td>
                        <td><input type="text" id="fax" name="fax" value="<?php echo htmlspecialchars($fax ?? ''); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email *</label></td>
                        <td><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required></td>
                    </tr>
                    <tr>
                        <td>
                            <label>Donation Amount *</label><br>
                            <span class="field-note">(Check a button or type in your amount)</span>
                        </td>
                        <td>
                            <?php foreach (["none" => "None", "50" => "$50", "75" => "$75", "100" => "$100", "250" => "$250"] as $val => $label): ?>
                                <input type="radio" name="donation" value="<?php echo $val; ?>" <?php echo (($donation ?? 'none') == $val) ? 'checked' : ''; ?>> <?php echo $label; ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label for="other-amount">Other Amount $</label> <input type="text" id="other-amount" name="other-amount" value="<?php echo htmlspecialchars($other_amount ?? ''); ?>"></td>
                    </tr>
                    <tr>
                        <td>
                            <label>Recurring Donation</label><br>
                            <span class="field-note">(Check if yes)</span>
                        </td>
                        <td>
                            <input type="checkbox" name="recurring" value="yes" <?php echo (($recurring ?? '') == 'yes') ? 'checked' : ''; ?>> I am interested in giving on a regular basis.
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <label for="monthly-amount">Monthly Credit Card $</label>
                            <input type="text" id="monthly-amount" name="monthly-amount" value="<?php echo htmlspecialchars($monthly_amount ?? ''); ?>">
                            <label for="months-for">For</label>
                            <input type="text" id="months-for" name="months-for" value="<?php echo htmlspecialchars($months_for ?? ''); ?>">
                            <label>Months</label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="Submit">
                            <input type="reset">
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
</main>

</body>
</html>