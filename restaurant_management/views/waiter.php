<?php $user = $_SESSION['user']; $isEdit = !empty($editing); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Waiter Dashboard &mdash; Restaurant Management</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="app-body">

<!-- Navbar -->
<header class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="index.php?page=waiter">
            <span class="brand-icon">&#127869;</span>
            <span>RestSys</span>
        </a>
        <div class="nav-user">
            <span class="user-pill">
                <span class="user-avatar"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                <span class="user-meta">
                    <span class="user-name"><?= htmlspecialchars($user['name']) ?></span>
                    <span class="user-role">Waiter</span>
                </span>
            </span>
            <a href="index.php?page=logout" class="btn-logout">Logout</a>
        </div>
    </div>
</header>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Manage Dishes</h1>
            <p class="page-sub">Add, edit, search and remove dishes in the menu</p>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php $messages = ['added' => 'Dish added successfully.',
                           'updated' => 'Dish updated successfully.',
                           'deleted' => 'Dish deleted successfully.'];
              $msg = $messages[$_GET['msg']] ?? null; ?>
        <?php if ($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- ============ Add / Edit Form ============ -->
    <div class="card form-card">
        <h3 class="card-title">
            <?= $isEdit ? '&#9998; Edit Dish (#' . intval($editing['id']) . ')' : '+ Add New Dish' ?>
        </h3>
        <form method="POST"
              action="index.php?page=waiter&action=<?= $isEdit ? 'update&id=' . intval($editing['id']) : 'add' ?>"
              class="form" novalidate>
            <div class="field-row">
                <div class="field">
                    <label for="dish_name">Dish Name</label>
                    <input type="text" id="dish_name" name="dish_name"
                           value="<?= htmlspecialchars($editing['dish_name'] ?? '') ?>"
                           placeholder="e.g. Grilled Salmon" required>
                </div>
                <div class="field">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category"
                           value="<?= htmlspecialchars($editing['category'] ?? '') ?>"
                           placeholder="e.g. Main Course" required>
                </div>
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" min="0"
                           value="<?= htmlspecialchars($editing['stock'] ?? '') ?>"
                           placeholder="0" required>
                </div>
                <div class="field">
                    <label for="price">Price ($)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0"
                           value="<?= htmlspecialchars($editing['price'] ?? '') ?>"
                           placeholder="0.00" required>
                </div>
            </div>
            <div class="form-actions">
                <?php if ($isEdit): ?>
                    <a href="index.php?page=waiter" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Dish</button>
                <?php else: ?>
                    <button type="submit" class="btn btn-primary">Save Dish</button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- ============ Dishes Table ============ -->
    <div class="card">
        <div class="card-toolbar">
            <div class="search-wrap">
                <span class="search-icon">&#128269;</span>
                <input type="text" id="searchInput" class="search-input"
                       placeholder="Search by dish name or category...">
            </div>
            <span class="badge" id="resultCount"><?= count($dishes) ?> total</span>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Dish Name</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (empty($dishes)): ?>
                        <tr><td colspan="6" class="empty">No dishes yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($dishes as $i => $dish): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($dish['dish_name']) ?></td>
                                <td><?= htmlspecialchars($dish['category']) ?></td>
                                <td><?= htmlspecialchars($dish['stock']) ?></td>
                                <td>$<?= number_format($dish['price'], 2) ?></td>
                                <td class="text-right">
                                    <a class="btn-sm btn-edit"
                                       href="index.php?page=waiter&action=edit&id=<?= $dish['id'] ?>">Edit</a>
                                    <a class="btn-sm btn-delete"
                                       href="index.php?page=waiter&action=delete&id=<?= $dish['id'] ?>"
                                       onclick="return confirm('Delete this dish?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<footer class="footer">&copy; <?= date('Y') ?> Restaurant Management System</footer>

<!-- =========== Inline AJAX search =========== -->
<script>
(function () {
    var input    = document.getElementById('searchInput');
    var body     = document.getElementById('tableBody');
    var counter  = document.getElementById('resultCount');
    var timer;

    function esc(s) {
        return String(s == null ? '' : s)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;').replace(/'/g,'&#039;');
    }

    function render(rows) {
        if (!rows.length) {
            body.innerHTML = '<tr><td colspan="6" class="empty">No matching results.</td></tr>';
            counter.textContent = '0 results';
            return;
        }
        var html = '';
        rows.forEach(function (d, i) {
            html +=
                '<tr>' +
                    '<td>' + (i + 1) + '</td>' +
                    '<td>' + esc(d.dish_name) + '</td>' +
                    '<td>' + esc(d.category) + '</td>' +
                    '<td>' + esc(d.stock) + '</td>' +
                    '<td>$' + parseFloat(d.price).toFixed(2) + '</td>' +
                    '<td class="text-right">' +
                        '<a class="btn-sm btn-edit" href="index.php?page=waiter&action=edit&id=' + d.id + '">Edit</a>' +
                        '<a class="btn-sm btn-delete" href="index.php?page=waiter&action=delete&id=' + d.id +
                        '" onclick="return confirm(\'Delete this dish?\')">Delete</a>' +
                    '</td>' +
                '</tr>';
        });
        body.innerHTML = html;
        counter.textContent = rows.length + (input.value.trim() ? ' results' : ' total');
    }

    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            fetch('index.php?page=ajax&type=dish&q=' + encodeURIComponent(input.value.trim()),
                  { credentials: 'same-origin' })
                .then(function (r) { return r.json(); })
                .then(render)
                .catch(function (e) { console.error(e); });
        }, 200);
    });
})();
</script>

</body>
</html>
