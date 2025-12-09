# Simple Password Generator

A lightweight Laravel-based web application for generating secure, unique passwords.

![Password Generator Screenshot](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP Version](https://img.shields.io/badge/PHP-8.5-blue?style=flat-square&logo=php)

## Features

- **Customizable Length** - Generate passwords from 1 to 128 characters
- **Character Options** - Choose from:
  - Numbers (0-9)
  - Uppercase letters (A-Z)
  - Lowercase letters (a-z)
- **Guaranteed Uniqueness** - Every password is checked against the database before saving
- **Balanced Distribution** - Characters are distributed evenly across selected character sets
- **SQLite Storage** - All generated passwords are stored for uniqueness validation

## Requirements

- PHP 8.2 or higher
- Composer
- SQLite extension (`pdo_sqlite`)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/igorsavinkin/simple-password-app.git
   cd simple-password-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Create database and migrate**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

5. **Start the server**
   ```bash
   php artisan serve
   ```

6. **Open the app in browser**
   ```
   http://127.0.0.1:8000
   ```

## Usage

1. Enter the desired password length (default: 8)
2. Select character types to include:
   - ☑ Numbers
   - ☑ Big letters
   - ☑ Small letters
3. Click **Generate**
4. Your unique password will be displayed

## How It Works

The password generator uses a balanced algorithm that ensures each selected character set is represented evenly. This accomodates each set of characters be present at least once in a generated password (as much as password lenght allows).

### Uniqueness Check

Before saving, each generated password is checked against the database. If a duplicate is found, the system regenerates (up to 100 attempts) to ensure every stored password is unique.

## Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   └── PasswordController.php    # Main controller
│   └── Models/
│       └── Password.php              # Password model
├── database/
│   ├── migrations/
│   │   └── *_create_passwords_table.php
│   └── database.sqlite               # SQLite database
├── resources/views/
│   └── password/
│       └── index.blade.php           # Main view
└── routes/
    └── web.php                       # Routes
```

## API Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/` | Display the password generator form |
| POST | `/generate` | Generate a new password |

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Author

Igor Savinkin, [Webscraping.pro](https://webscraping.pro)
