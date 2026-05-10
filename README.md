# Cinema Ticket Booking System

A responsive cinema ticket booking web application built with PHP, MySQL, HTML, CSS, and Bootstrap.

## Project Overview

This application allows customers to browse available movies, book tickets, view their reservations, and manage their account. It also includes an admin dashboard where staff members can manage movie showtimes, add new movies, and update reservation statuses.

## Features

### Customer

- User registration and login
- Movie browsing
- Ticket reservation
- Personal reservation history
- Password change
- Logout functionality

### Admin

- Admin login
- Add new movies
- Update movie showtimes
- Approve or cancel reservations
- Manage pending reservations

## Technologies Used

- PHP
- MySQL / MariaDB
- HTML
- CSS
- Bootstrap
- PDO

## Folder Structure

```text
cinema-ticket-booking/
├── css/
├── database/
├── images/
├── admin.php
├── change_password.php
├── change_password_process.php
├── index.php
├── login.php
├── logout.php
├── manage.php
├── movies.php
├── profile.php
├── register.php
├── reservations.php
├── userreservations.php
└── README.md
```

## Database Setup

Import the SQL files located inside the `database` folder:

```text
database/movies_db.sql
database/reservations_db.sql
database/user_db.sql
```

The project uses the following database names:

```text
movies_db
reservations_db
user_db
```

## How to Run

1. Install XAMPP or another local PHP/MySQL server.
2. Place the project folder inside the `htdocs` directory.
3. Start Apache and MySQL.
4. Import the SQL files using phpMyAdmin.
5. Open the project in your browser:

```text
http://localhost/cinema-ticket-booking/login.php
```

## Default Admin Account

```text
Username: Admin
Password: Admin!@#
```

## Notes

This project is designed as a simple cinema booking system and demonstrates authentication, database interaction, reservation handling, and responsive interface design.
