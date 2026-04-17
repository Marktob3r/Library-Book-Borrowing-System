# Library Book Borrowing System

## Project Overview
The Library Book Borrowing System is a web-based application designed to digitize and streamline the book lending process of a school library. Built as part of the Backend Development course at Gordon College, this system provides librarians and authorized staff with tools to manage book inventory, process borrowing and return transactions, and maintain a complete borrowing history for accountability.

## Key Features
The application implements the following core functionalities as specified in the project requirements:

- **Librarian Authentication:** Secure login and session management powered by Laravel Breeze.
- **Book Inventory Management (CRUD):** Full interface to create, read, update, and delete book records, including Title, Author, ISBN, and Quantity.
- **Real-time Availability Tracking:** Automatically updates book status when items are checked out or returned.
- **Borrow/Return Processing:** Dedicated transaction forms to record borrowing events and process returns with timestamps.
- **Borrower History Log:** A comprehensive, filterable log showing the complete transaction history per student and book.
- **Statistical Dashboard:** A visual summary of library status, including total inventory, currently borrowed books, and available stock.

## Technical Stack
- **Framework:** Laravel (Latest Stable Version)
- **Database:** MySQL
- **Architecture:** Model-View-Controller (MVC)
- **ORM:** Eloquent ORM
- **Authentication:** Laravel Breeze
- **Frontend:** Blade Templates with Tailwind CSS/Bootstrap

## Installation & Setup

### Prerequisites
* PHP (>= 8.2)
* Composer
* Node.js & NPM
* MySQL (XAMPP/Laragon)

### Setup Steps
1. **Clone the Repository:**
```bash
git clone https://github.com/Marktob3r/Library-Book-Borrowing-System.git
cd library-book-borrowing-system
```

2. **Install Dependencies:**
```bash
composer install
npm install
```

3. **Environment Configuration:**
* Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```
* Open `.env` and configure your database settings (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

4. **Generate Application Key:**
```bash
php artisan key:generate
```

5. **Run Migrations & Seeders:**
```bash
php artisan migrate --seed
```

6. **Compile Assets:**
```bash
npm run dev
```

7. **Start the Server:**
```bash
php artisan serve
```

## Database Schema (3NF)
The database is designed using proper normalization (1NF to 3NF) and utilizes Eloquent relationships to link students, books, and transactions:
- **Users:** Stores librarian credentials for authentication.
- **Books:** Stores title, author, ISBN, and stock levels.
- **Students:** Stores borrower information.
- **BorrowTransactions:** Pivot table managing the relationship between students and books with borrow/return timestamps.

## Group Members
- **Arvin Kiel Bacani**
- **John Rayniel Bonifacio**
- **Mark Christian Gabriel**
- **Justin Monsalud**

## License
This project was developed for academic purposes at Gordon College, College of Computer Studies.
