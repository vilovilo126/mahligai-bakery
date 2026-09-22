---
paths:
  - '**'
---

# General

## Single users table auth; no customers-table login
All users (admin & customer) live in the users table with a role column ('admin' | 'customer'). There is ONE login form (GET /login POST /login.submit, username+password) and ONE logout (POST /logout -> '/', session invalidate + regenerateToken). Redirect after login is role-aware (customer -> menu, admin -> admin.dashboard) via redirectUsersTo in bootstrap/app.php. redirectGuestsTo -> login. New customers register via GET/POST customer/register (name, unique username, password min 8). Legacy customers table rows were converted to users rows with random hashed passwords (migration 2026_09_21_024927); customers table still exists only as a data link (account_user_id) and is never used for auth.

## Backend always recomputes prices from config/menu.php
Prices/qris_fee are always recomputed from config/menu.php on the backend (OrderCalculatorService); the frontend price payload is ignored. EnsureAdmin alias 'admin' returns 403 for non-admins. Admin credentials come from env via AdminSeeder (default admin / 'bakery mahligai').

## Single users table auth; no customers-table login
All users (admin & customer) live in the users table with a role column ('admin' | 'customer'). There is ONE login form (GET /login POST /login.submit, username+password) and ONE logout (POST /logout -> '/', session invalidate + regenerateToken). Redirect after login is role-aware (customer -> menu, admin -> admin.dashboard) via redirectUsersTo in bootstrap/app.php. redirectGuestsTo -> login. New customers register via GET/POST customer/register (name, unique username, password min 8). Legacy customers table rows were converted to users rows with random hashed passwords (migration 2026_09_21_024927); customers table still exists only as a data link (account_user_id) and is never used for auth.

## Batch file context/uploads in chunks of max 90-95, grouped by type
NEVER send or analyze >=100 files in one context/upload batch (max 90-95) — producer-budgeting error "Try uploading fewer than 100 at a time" must never happen. Split by type: images/media/fonts/asset files/Tailwind & CSS/large assets are NEVER batched together with main source code. For source code send only files relevant to the current task (app, resources/views, resources/js, routes, config, database/migrations, required config files). Images/media count as reference paths only — never upload a whole image folder. Tailwind/CSS: only files actually used by the page/feature in scope, not all styling files. If needed files exceed the limit, split automatically into several batches each under 100 and process them gradually. This is a batching/context rule only — do not modify, delete, or restructure project files to comply.
