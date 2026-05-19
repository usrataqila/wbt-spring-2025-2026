<?php
// ---------- Database connection ----------
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";          // default XAMPP password is blank
$DB_NAME = "library";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");

// ---------- Determine which action to run ----------
$action  = $_REQUEST["action"] ?? "";
$notice  = "";      // success notice
$problem = "";      // error notice
$editing = null;    // book being edited, if any

// ---------- CREATE ----------
if ($_SERVER["REQUEST_METHOD"] === "POST" && $action === "create") {
    $title  = trim($_POST["title"]       ?? "");
    $author = trim($_POST["author"]      ?? "");
    $genre  = trim($_POST["genre"]       ?? "");
    $pages  = (int)($_POST["pages"]      ?? 0);

    if ($title === "" || $author === "" || $genre === "" || $pages <= 0) {
        $problem = "All fields are required and pages must be a positive number.";
    } else {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO books (title, author, genre, pages)
             VALUES (?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "sssi", $title, $author, $genre, $pages);

        if (mysqli_stmt_execute($stmt)) {
            $notice = "Book added successfully (ID: "
                    . mysqli_stmt_insert_id($stmt) . ").";
        } else {
            $problem = "Could not add book: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// ---------- UPDATE ----------
if ($_SERVER["REQUEST_METHOD"] === "POST" && $action === "update") {
    $id     = (int)($_POST["id"]         ?? 0);
    $title  = trim($_POST["title"]       ?? "");
    $author = trim($_POST["author"]      ?? "");
    $genre  = trim($_POST["genre"]       ?? "");
    $pages  = (int)($_POST["pages"]      ?? 0);

    if ($id <= 0 || $title === "" || $author === "" || $genre === "" || $pages <= 0) {
        $problem = "Invalid input. All fields are required.";
    } else {
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE books
                SET title = ?, author = ?, genre = ?, pages = ?
              WHERE id = ?"
        );
        mysqli_stmt_bind_param($stmt, "sssii", $title, $author, $genre, $pages, $id);

        if (mysqli_stmt_execute($stmt)) {
            $notice = "Book #$id updated successfully.";
        } else {
            $problem = "Could not update book: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// ---------- DELETE ----------
if ($action === "delete") {
    $id = (int)($_REQUEST["id"] ?? 0);
    if ($id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM books WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            $notice = "Book #$id removed from library.";
        } else {
            $problem = "Could not delete: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// ---------- Load record for EDIT form ----------
if ($action === "edit") {
    $id = (int)($_REQUEST["id"] ?? 0);
    if ($id > 0) {
        $stmt = mysqli_prepare(
            $conn,
            "SELECT id, title, author, genre, pages FROM books WHERE id = ?"
        );
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res     = mysqli_stmt_get_result($stmt);
        $editing = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        if (!$editing) {
            $problem = "Book #$id not found.";
        }
    }
}

// ---------- READ — fetch all books ----------
$res   = mysqli_query($conn, "SELECT * FROM books ORDER BY id DESC");
$books = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res);

// Escape output before printing in HTML
function h($val) {
    return htmlspecialchars((string)$val, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library — Book Manager</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Georgia, "Times New Roman", serif;
            background: #f0ece4;
            margin: 0;
            padding: 24px;
            color: #2c2c2c;
        }
        h1 { margin-top: 0; color: #5b2333; }
        h2 { color: #3a5a40; margin-bottom: 12px; }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 24px 28px;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }
        .alert {
            padding: 10px 14px;
            border-radius: 4px;
            margin: 12px 0;
            font-size: 14px;
        }
        .alert.success { background: #e8f5e9; color: #1b5e20; border: 1px solid #a5d6a7; }
        .alert.error   { background: #fdecea; color: #b71c1c; border: 1px solid #f5b7b1; }

        form.crud {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            background: #faf8f5;
            padding: 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 24px;
        }
        form.crud label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #555;
            margin-bottom: 4px;
            font-family: Arial, sans-serif;
        }
        form.crud input {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #bbb;
            border-radius: 4px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        form.crud .actions {
            grid-column: 1 / -1;
            display: flex;
            gap: 10px;
        }
        button, .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background: #5b2333;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-family: Arial, sans-serif;
        }
        button:hover, .btn:hover { background: #44191f; }
        .btn.secondary { background: #7a7a7a; }
        .btn.secondary:hover { background: #555; }
        .btn.danger { background: #c0392b; }
        .btn.danger:hover { background: #922b21; }
        .btn.small { padding: 4px 10px; font-size: 12px; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        thead { background: #5b2333; color: #fff; }
        th, td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #e6e6e6;
        }
        tbody tr:hover { background: #fdf6f0; }
        td.actions { white-space: nowrap; }
        td.actions a { margin-right: 4px; }
        .empty { text-align: center; padding: 24px; color: #888; font-family: Arial, sans-serif; }
    </style>
</head>
<body>
<div class="container">

    <h1>📚 Library — Book Manager</h1>

    <?php if ($notice !== ""): ?>
        <div class="alert success"><?= h($notice) ?></div>
    <?php endif; ?>
    <?php if ($problem !== ""): ?>
        <div class="alert error"><?= h($problem) ?></div>
    <?php endif; ?>

    <!-- ===================================================
         ADD / EDIT FORM
         Shows "Edit" form when a book is selected, else "Add"
         =================================================== -->
    <h2><?= $editing ? "Edit Book #" . h($editing["id"]) : "Add New Book" ?></h2>

    <form class="crud" method="post" action="books_crud.php">
        <input type="hidden" name="action"
               value="<?= $editing ? "update" : "create" ?>">
        <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?= h($editing["id"]) ?>">
        <?php endif; ?>

        <div>
            <label>Title</label>
            <input type="text" name="title" required
                   value="<?= h($editing["title"] ?? "") ?>">
        </div>
        <div>
            <label>Author</label>
            <input type="text" name="author" required
                   value="<?= h($editing["author"] ?? "") ?>">
        </div>
        <div>
            <label>Genre</label>
            <input type="text" name="genre" required
                   value="<?= h($editing["genre"] ?? "") ?>">
        </div>
        <div>
            <label>Pages</label>
            <input type="number" name="pages" min="1" required
                   value="<?= h($editing["pages"] ?? "") ?>">
        </div>

        <div class="actions">
            <button type="submit">
                <?= $editing ? "Save Changes" : "Add Book" ?>
            </button>
            <?php if ($editing): ?>
                <a href="books_crud.php" class="btn secondary">Cancel</a>
            <?php endif; ?>
        </div>
    </form>

    <!-- ===================================================
         BOOK LIST
         =================================================== -->
    <h2>All Books (<?= count($books) ?>)</h2>

    <?php if (count($books) === 0): ?>
        <div class="empty">No books yet. Use the form above to add one.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Pages</th>
                    <th>Added at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($books as $row): ?>
                <tr>
                    <td><?= h($row["id"]) ?></td>
                    <td><?= h($row["title"]) ?></td>
                    <td><?= h($row["author"]) ?></td>
                    <td><?= h($row["genre"]) ?></td>
                    <td><?= h($row["pages"]) ?></td>
                    <td><?= h($row["created_at"]) ?></td>
                    <td class="actions">
                        <a class="btn small"
                           href="books_crud.php?action=edit&id=<?= h($row["id"]) ?>">Edit</a>
                        <a class="btn small danger"
                           href="books_crud.php?action=delete&id=<?= h($row["id"]) ?>"
                           onclick="return confirm('Remove this book from the library?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<?php mysqli_close($conn); ?>
</body>
</html>