<?php
// ================================================================
// CONTROLLERS - request handling + role-based logic
// ================================================================

/* ============== Login ============== */
function loginCtrl($conn) {
    $error = '';
    $prefill = $_COOKIE['remember_user'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $u = trim($_POST['username'] ?? '');
        $p = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        if ($u === '' || $p === '') {
            $error = 'Please fill in both fields.';
        } else {
            // Try admin first
            $admin = authAdmin($conn, $u, $p);
            if ($admin) {
                $_SESSION['user'] = [
                    'id' => $admin['id'], 'username' => $admin['username'],
                    'name' => 'Administrator', 'role' => 'admin'
                ];
                if ($remember) setcookie('remember_user', $u, time() + 86400 * 30, '/');
                else setcookie('remember_user', '', time() - 3600, '/');
                header('Location: index.php?page=admin');
                exit;
            }
            // Then waiter
            $waiter = authWaiter($conn, $u, $p);
            if ($waiter) {
                $_SESSION['user'] = [
                    'id' => $waiter['id'], 'username' => $waiter['username'],
                    'name' => $waiter['name'], 'role' => 'waiter'
                ];
                if ($remember) setcookie('remember_user', $u, time() + 86400 * 30, '/');
                else setcookie('remember_user', '', time() - 3600, '/');
                header('Location: index.php?page=waiter');
                exit;
            }
            $error = 'Invalid username or password.';
        }
    }

    require 'views/login.php';
}

/* ============== Register (waiter self-registration) ============== */
function registerCtrl($conn) {
    $error = $success = '';
    $old = ['name' => '', 'contact' => '', 'username' => ''];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name     = trim($_POST['name'] ?? '');
        $contact  = trim($_POST['contact'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';
        $old = compact('name', 'contact', 'username');

        if ($name === '' || $contact === '' || $username === '' || $password === '') {
            $error = 'All fields are required.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match.';
        } elseif (waiterUsernameExists($conn, $username)) {
            $error = 'Username is already taken.';
        } else {
            if (addWaiter($conn, $name, $contact, $username, $password)) {
                $success = 'Account created! You can now log in.';
                $old = ['name' => '', 'contact' => '', 'username' => ''];
            } else {
                $error = 'Registration failed. Try again.';
            }
        }
    }

    require 'views/register.php';
}

/* ============== Admin Dashboard (manages waiters) ============== */
function adminCtrl($conn) {
    $action = $_GET['action'] ?? 'list';
    $error = '';
    $editing = null;  // when set, view shows Edit form instead of Add form

    /* --- Add (POST) --- */
    if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $name     = trim($_POST['name'] ?? '');
        $contact  = trim($_POST['contact'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $contact === '' || $username === '' || $password === '') {
            $error = 'All fields are required.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif (waiterUsernameExists($conn, $username)) {
            $error = 'Username is already taken.';
        } else {
            if (addWaiter($conn, $name, $contact, $username, $password)) {
                header('Location: index.php?page=admin&msg=added');
                exit;
            }
            $error = 'Failed to add waiter.';
        }
    }

    /* --- Update (POST) --- */
    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id       = intval($_GET['id'] ?? 0);
        $name     = trim($_POST['name'] ?? '');
        $contact  = trim($_POST['contact'] ?? '');
        $username = trim($_POST['username'] ?? '');

        // ===== NULL VALIDATION on UPDATE =====
        if ($name === '' || $contact === '' || $username === '') {
            $error = 'No field can be empty (NULL). All fields are required.';
            $editing = ['id' => $id, 'name' => $name, 'contact' => $contact, 'username' => $username];
        } elseif (waiterUsernameExists($conn, $username, $id)) {
            $error = 'That username is used by another waiter.';
            $editing = ['id' => $id, 'name' => $name, 'contact' => $contact, 'username' => $username];
        } else {
            if (updateWaiter($conn, $id, $name, $contact, $username)) {
                header('Location: index.php?page=admin&msg=updated');
                exit;
            }
            $error = 'Update failed.';
            $editing = ['id' => $id, 'name' => $name, 'contact' => $contact, 'username' => $username];
        }
    }

    /* --- Show edit form (GET) --- */
    if ($action === 'edit' && !$editing) {
        $id = intval($_GET['id'] ?? 0);
        $editing = getWaiter($conn, $id);
    }

    /* --- Delete (GET) --- */
    if ($action === 'delete') {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) deleteWaiter($conn, $id);
        header('Location: index.php?page=admin&msg=deleted');
        exit;
    }

    $waiters = getWaiters($conn);
    require 'views/admin.php';
}

/* ============== Waiter Dashboard (manages dishes) ============== */
function waiterCtrl($conn) {
    $action = $_GET['action'] ?? 'list';
    $error = '';
    $editing = null;

    /* --- Add (POST) --- */
    if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish_name = trim($_POST['dish_name'] ?? '');
        $category  = trim($_POST['category'] ?? '');
        $stock     = trim($_POST['stock'] ?? '');
        $price     = trim($_POST['price'] ?? '');

        if ($dish_name === '' || $category === '' || $stock === '' || $price === '') {
            $error = 'All fields are required.';
        } elseif (!ctype_digit($stock) || intval($stock) < 0) {
            $error = 'Stock must be a non-negative whole number.';
        } elseif (!is_numeric($price) || floatval($price) < 0) {
            $error = 'Price must be a non-negative number.';
        } else {
            $waiterId = $_SESSION['user']['id'];
            if (addDish($conn, $dish_name, $category, intval($stock), floatval($price), $waiterId)) {
                header('Location: index.php?page=waiter&msg=added');
                exit;
            }
            $error = 'Failed to add dish.';
        }
    }

    /* --- Update (POST) --- */
    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id        = intval($_GET['id'] ?? 0);
        $dish_name = trim($_POST['dish_name'] ?? '');
        $category  = trim($_POST['category'] ?? '');
        $stock     = trim($_POST['stock'] ?? '');
        $price     = trim($_POST['price'] ?? '');

        // ===== NULL VALIDATION on UPDATE =====
        if ($dish_name === '' || $category === '' || $stock === '' || $price === '') {
            $error = 'No field can be empty (NULL). All fields are required.';
            $editing = ['id' => $id, 'dish_name' => $dish_name, 'category' => $category,
                        'stock' => $stock, 'price' => $price];
        } elseif (!ctype_digit($stock) || intval($stock) < 0) {
            $error = 'Stock must be a non-negative whole number.';
            $editing = ['id' => $id, 'dish_name' => $dish_name, 'category' => $category,
                        'stock' => $stock, 'price' => $price];
        } elseif (!is_numeric($price) || floatval($price) < 0) {
            $error = 'Price must be a non-negative number.';
            $editing = ['id' => $id, 'dish_name' => $dish_name, 'category' => $category,
                        'stock' => $stock, 'price' => $price];
        } else {
            if (updateDish($conn, $id, $dish_name, $category, intval($stock), floatval($price))) {
                header('Location: index.php?page=waiter&msg=updated');
                exit;
            }
            $error = 'Update failed.';
            $editing = ['id' => $id, 'dish_name' => $dish_name, 'category' => $category,
                        'stock' => $stock, 'price' => $price];
        }
    }

    /* --- Show edit form --- */
    if ($action === 'edit' && !$editing) {
        $id = intval($_GET['id'] ?? 0);
        $editing = getDish($conn, $id);
    }

    /* --- Delete --- */
    if ($action === 'delete') {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) deleteDish($conn, $id);
        header('Location: index.php?page=waiter&msg=deleted');
        exit;
    }

    $dishes = getDishes($conn);
    require 'views/waiter.php';
}
?>
