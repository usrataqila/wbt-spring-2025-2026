<?php
// ================================================================
// MODELS - All DB access using procedural mysqli + prepared stmts
// ================================================================

/* ------------------- Admin ------------------- */
function authAdmin($conn, $username, $password) {
    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM admins WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return ($row && password_verify($password, $row['password'])) ? $row : false;
}

/* ----------------- Waiter ----------------- */
function getWaiters($conn) {
    $r = mysqli_query($conn, "SELECT id, name, contact, username FROM waiters ORDER BY id DESC");
    return mysqli_fetch_all($r, MYSQLI_ASSOC);
}

function getWaiter($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT id, name, contact, username FROM waiters WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function addWaiter($conn, $name, $contact, $username, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn,
        "INSERT INTO waiters (name, contact, username, password) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $contact, $username, $hash);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateWaiter($conn, $id, $name, $contact, $username) {
    $stmt = mysqli_prepare($conn,
        "UPDATE waiters SET name = ?, contact = ?, username = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'sssi', $name, $contact, $username, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function deleteWaiter($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM waiters WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function searchWaiters($conn, $term) {
    $like = '%' . $term . '%';
    $stmt = mysqli_prepare($conn,
        "SELECT id, name, contact, username FROM waiters
         WHERE name LIKE ? OR username LIKE ? OR contact LIKE ?
         ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function authWaiter($conn, $username, $password) {
    $stmt = mysqli_prepare($conn,
        "SELECT id, name, username, password FROM waiters WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return ($row && password_verify($password, $row['password'])) ? $row : false;
}

function waiterUsernameExists($conn, $username, $excludeId = null) {
    if ($excludeId) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM waiters WHERE username = ? AND id != ?");
        mysqli_stmt_bind_param($stmt, 'si', $username, $excludeId);
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM waiters WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}

/* ------------------- Dish ------------------- */
function getDishes($conn) {
    $r = mysqli_query($conn, "SELECT id, dish_name, category, stock, price FROM dishes ORDER BY id DESC");
    return mysqli_fetch_all($r, MYSQLI_ASSOC);
}

function getDish($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT id, dish_name, category, stock, price FROM dishes WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function addDish($conn, $dish_name, $category, $stock, $price, $waiterId) {
    $stmt = mysqli_prepare($conn,
        "INSERT INTO dishes (dish_name, category, stock, price, waiter_id) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssidi', $dish_name, $category, $stock, $price, $waiterId);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateDish($conn, $id, $dish_name, $category, $stock, $price) {
    $stmt = mysqli_prepare($conn,
        "UPDATE dishes SET dish_name = ?, category = ?, stock = ?, price = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'ssidi', $dish_name, $category, $stock, $price, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function deleteDish($conn, $id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM dishes WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function searchDishes($conn, $term) {
    $like = '%' . $term . '%';
    $stmt = mysqli_prepare($conn,
        "SELECT id, dish_name, category, stock, price FROM dishes
         WHERE dish_name LIKE ? OR category LIKE ?
         ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, 'ss', $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}
?>
