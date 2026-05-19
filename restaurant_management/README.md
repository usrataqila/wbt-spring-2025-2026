# Restaurant Management System (Compact MVC)

A minimal PHP + MySQL Restaurant Management System, built with procedural mysqli + prepared statements. All CRUD operations live on a single dashboard page per role (form on top, searchable table below).

## Project Structure (MVC, flat)

```
restaurant_management/
├── config.php           # DB connection + auto-seed of default admin
├── models.php           # M  - all DB functions
├── controllers.php      # C  - login, register, admin, waiter
├── index.php            # Front controller (router + AJAX + logout)
├── style.css            # All styling
├── database.sql         # DB schema
└── views/               # V
    ├── login.php
    ├── register.php
    ├── admin.php        # Single dashboard: waiter CRUD + AJAX search
    └── waiter.php       # Single dashboard: dish CRUD + AJAX search
```

## Install (XAMPP)

1. Copy folder into `C:\xampp\htdocs\` (so it becomes `htdocs/restaurant_management/`)
2. Start Apache + MySQL in XAMPP
3. Open `http://localhost/phpmyadmin` → **Import** → choose `database.sql` → Go
4. Open `http://localhost/restaurant_management/`
5. Login with the default admin: **admin / admin123** (auto-created on first request)

## Default Credentials

| Role   | Username | Password   |
| ------ | -------- | ---------- |
| Admin  | admin    | admin123   |
| Waiter | register one yourself, or admin can add | |

## How CRUD Works on a Single Page

- **Top of page** = a form (Add mode by default, Edit mode when an "Edit" row link is clicked).
- **Bottom of page** = a searchable table with Edit / Delete links per row.
- Clicking "Edit" reloads the page with `?action=edit&id=N`, pre-filling the same form.
- Clicking "Delete" hits `?action=delete&id=N` after a confirm prompt.
- The search box uses **AJAX** (`fetch` → `index.php?page=ajax&type=...`) and rerenders the table body without a full reload.

