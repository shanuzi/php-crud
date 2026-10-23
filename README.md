# Core PHP (OOP) CRUD – Student Records

Plain PHP 8+, PDO, MySQL. No frameworks or Composer.

## Setup (XAMPP / Laragon / any PHP + MySQL)
1. Copy the `php-crud` folder into `htdocs` (XAMPP) or `www` (Laragon).
2. Import `database.sql` (phpMyAdmin → Import, or `mysql -u root < database.sql`).
3. Edit `config/config.php` if your MySQL credentials differ.
4. Open `http://localhost/php-crud/public/`

Or use PHP's built-in server:
    php -S localhost:8000 -t public
then visit http://localhost:8000

## Structure
    app/Core/          Database (singleton PDO), Session (flash + CSRF), View
    app/Models/        Student entity
    app/Repositories/  StudentRepository – all SQL (prepared statements)
    app/Validators/    StudentValidator – input rules, unique checks
    app/Controllers/   StudentController – index/create/store/edit/update/destroy
    views/             Layout + list/form templates
    public/            Front controller (index.php) + assets

## Features
- Create, Read (with search), Update, Delete
- Server-side validation with per-field errors
- CSRF protection; delete is POST-only
- Output escaping (XSS) and prepared statements (SQL injection)
- Post/Redirect/Get with flash messages
