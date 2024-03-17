
# Laravel Backend for Barber Shop Application

![Build Status](https://img.shields.io/badge/build-passing-brightgreen)
![License](https://img.shields.io/badge/license-MIT-green)
![Laravel Version](https://img.shields.io/badge/laravel-8-red.svg)

This repository contains the Laravel-based backend for the Barber Shop Application, an open-source project designed to showcase my Laravel skills. It supports the Angular frontend application by providing RESTful APIs for appointment booking, service selection, and news updates. This backend manages all the data interactions and business logic for the barber shop application, including user authentication, managing appointments, and more.

## Features

- **RESTful API Endpoints:** Support for the frontend's appointment booking, service selection, and news catalog features.
- **Admin Dashboard Support:** Backend logic to manage appointments, services, and posts.
- **Authentication:** User authentication and authorization for different roles (admin, users).

## Prerequisites

Before running this project, you should have the following installed:
- [PHP](https://www.php.net/) (version as required by Laravel 8)
- [Composer](https://getcomposer.org/) for managing PHP dependencies

## Installation

1. Clone the backend repository:
   ```
   git clone https://github.com/david-randjelovic/barber-app-be.git
   ```
2. Navigate to the project directory:
   ```
   cd <path-where-you-cloned-the-backend>
   ```
3. Install PHP dependencies:
   ```
   composer install
   ```
4. Copy `.env.example` to `.env` and configure your environment variables, including database settings.
5. Generate the application key:
   ```
   php artisan key:generate
   ```
6. Run database migrations and seeders (if any):
   ```
   php artisan migrate --seed
   ```
7. Start the backend server:
   ```
   php artisan serve
   ```

The server will start, typically on `http://localhost:8000`, serving the API endpoints for the frontend application to consume.

## Development and Contribution

This Laravel backend is part of an open-source project to showcase my development skills. Contributions, bug reports, and feature requests are welcome. Feel free to fork the project and submit pull requests. If you encounter any issues or have suggestions, please open an issue in the repository.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

For questions, collaborations, or feedback, please contact me through GitHub or LinkedIn.
