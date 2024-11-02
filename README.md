# Smart Home Control App Overview

This project is designed to provide a comprehensive solution for controlling various smart home devices,
including lights, ventilation, air conditioning, heating, and more.

## Features 
- **Lighting Control**: Manage and automate your home's lighting system, including dimming, color changes, and scheduling. 
- **Ventilation Management**: Control ventilation systems to ensure optimal air quality and comfort.
- **Climate Control**: Adjust and automate air conditioning and heating systems to maintain the desired temperature.
- **User Interface**: Intuitive web interface for easy control and monitoring of all connected devices.
- **Automation**: Create custom automation rules to enhance convenience and energy efficiency.

## Project Installation Guide

This guide will walk through the necessary steps to set up and configure the project.

## Prerequisites

Before the beginning, the following prerequisites have to be installed on the system:

- [Laravel 11.28.1](https://laravel.com/) - This project used the Laravel framework.
- [Git](https://git-scm.com/) - Version control system.
- [PHP 8.3.13](https://www.php.net/) - Main programming language.
- [Node.js 21.7.3](https://nodejs.org/) - JavaScript runtime environment.
- [Composer 2.7.7](https://getcomposer.org/) - PHP dependency manager.
- [npm 10.5.0](https://www.npmjs.com/) - Node.js package manager.
- Development environments can be used:
    - [Herd](https://herd.laravel.com/) - One click PHP development environment.
    - [Docker](https://www.docker.com/) - Containerization platform.

## Installation Steps

1. **Clone the Project**:

   Start by cloning the project repository using Git.

2. **Configure the Environment**:

   Navigate to the project directory and locate the .env.exemple files.
   Configure .env files base on these files with the specific environment settings,
   such as database credentials and other project-specific configurations.

3. **Install Dependencies, Packages and run Project**:

    ```bash
    composer install
    ```
    ```bash
    php artisan key:generate
    php artisan migrate
    ```
    ```bash
    npm install
    npm run dev
    ```

## Additional Information
- This project uses the following formatting standards:
   - Laravel Pint;
   - PEAR;
   - PSR-12.

- This project follows [Git Commit Patterns](https://dev.to/hornet_daemon/git-commit-patterns-5dm7).

- This project uses Pest PHP for testing frameworks.

- Useful Commands
  - Seed database with dev user and devices data:
    ```bash
    php artisan db:seed
    ```
  - Run cron in a development environment (task scheduling):
    ```bash
    php artisan schedule:work
    ```
## Next step
See [Smart-Home-Control-Data](https://github.com/StevenFV/smart-home-control-data) project
for configuring the necessary backend server for the services.
