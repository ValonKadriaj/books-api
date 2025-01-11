# Laravel Project

This is a Laravel-based application. Below are the steps to set up and run the project on your local machine.

## Requirements

Before you begin, make sure you have the following installed:

- PHP >= 8.1
- Composer (for dependency management)
- MySQL or another database system

## Installation

Follow these steps to get the project running:

### 1. Clone the Repository

Clone the repository to your local machine using:

```bash
git clone https://github.com/ValonKadriaj/books-api.git

cd books-api
composer install
cp .env.example .env
php artisan key:generate
php artisan db:seed

