# 📚 Library Management System

> A comprehensive solution for modern libraries to manage books, members, and transactions.

## 🌟 Overview

The Library Management System is a full-featured web application built with Laravel that helps libraries efficiently manage their resources, members, and day-to-day operations. Whether you're running a small community library or a large institutional collection, this system provides the tools you need to streamline your processes.

---

## ✨ Features

### 📖 Book Management

* ✅ Add, edit, and delete books
* 🔍 Search books by title, author, or ISBN
* 🏷️ Categorize books
* 📊 Track book availability
* 📝 Maintain detailed book information

### 👥 User Management

* 👮 Role-based access control (Admin, Librarian, Member)
* 👤 User registration and authentication
* 🔐 Secure password management
* 👑 Admin panel for user administration

### 🔄 Transaction Management

* 📤 Issue books to members
* 📥 Process book returns
* ⏱️ Track due dates
* 💰 Calculate late fees automatically
* 🚨 Identify overdue books

### 📋 Acquisition Requests

* 🛒 Members can request new books
* ✅ Librarians can approve/reject requests
* 📈 Track acquisition status

### 📊 Reporting

* 📈 Generate usage reports
* 📉 View most popular books
* 📋 Track overdue books
* 👥 Monitor user activity
* 🏷️ Analyze category popularity

### 🔔 Notifications

* 🍞 Toast notifications for user actions
* ✅ Success messages
* ❌ Error alerts
* ⚠️ Warning notifications
* ℹ️ Information messages

---

## 🛠️ Technologies Used

* 🐘 **PHP 8.1+**
* 🚀 **Laravel 10.x**
* 🗄️ **MySQL/MariaDB**
* 🎨 **Bootstrap 5**
* 📱 **Responsive Design**
* 🔐 **Custom Authentication**
* 🍞 **Toast Notifications**

---

## 📋 Requirements

* PHP 8.1 or higher
* Composer
* MySQL or MariaDB
* Web server (Apache/Nginx)

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/swostik720/library_management.git
cd library_management
```

### 2. Install dependencies

```bash
composer install
```

### 3. Set up environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure the database in the `.env` file

```
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=library_management  
DB_USERNAME=root  
DB_PASSWORD=  
```

### 5. Run migrations and seeders

```bash
php artisan migrate
php artisan db:seed
```

### 6. Start the development server

```bash
php artisan serve
```

### 7. Open the application

Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

## 👥 Default Users

| Role         | Email                                                 | Password    |
| ------------ | ----------------------------------------------------- | ----------- |
| 👑 Admin     | [admin@library.com](mailto:admin@library.com)         | password123 |
| 📚 Librarian | [librarian@library.com](mailto:librarian@library.com) | password123 |
| 👤 Member    | [member@library.com](mailto:member@library.com)       | password123 |

---

## 🔐 User Roles and Permissions

### 👑 Admin

* Full access to all system features
* Manage users (add, edit, delete)
* Manage books and categories
* View all reports
* Process transactions
* Manage acquisition requests

### 📚 Librarian

* Manage books and categories
* Process transactions (issue/return)
* View reports
* Manage acquisition requests
* Cannot manage users

### 👤 Member

* View available books
* View personal borrowing history
* Submit acquisition requests
* Cannot manage books or users

---

## 🗂️ Project Structure

```
library-management-system/  
├── app/  
│   ├── Http/  
│   │   ├── Controllers/      # Application controllers  
│   │   └── Middleware/       # Custom middleware  
│   └── Models/               # Eloquent models  
├── database/  
│   ├── migrations/           # Database migrations  
│   └── seeders/              # Database seeders  
├── public/                   # Publicly accessible files  
│   └── css/                  # CSS files  
├── resources/  
│   └── views/                # Blade templates  
│       ├── auth/             # Authentication views  
│       ├── books/            # Book management views  
│       ├── categories/       # Category management views  
│       ├── dashboard/        # Dashboard views  
│       ├── layouts/          # Layout templates  
│       ├── reports/          # Report views  
│       ├── transactions/     # Transaction views  
│       └── users/            # User management views  
└── routes/                   # Application routes  
```

---

## 📱 Key Features in Detail

### 📊 Dashboard

* Role-specific dashboards
* Quick statistics and insights
* Recent activity tracking
* Low stock alerts

### 🔍 Advanced Search

* Filter books by multiple criteria
* Sort results by various fields
* Pagination for large result sets

### 📈 Comprehensive Reports

* Most borrowed books
* User activity analysis
* Category popularity
* Overdue books tracking

### 🍞 Toast Notifications

* Non-intrusive user feedback
* Color-coded by message type
* Auto-dismissing after 5 seconds
* Stacked notifications support

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch:

   ```bash
   git checkout -b feature/amazing-feature
   ```
3. Commit your changes:

   ```bash
   git commit -m 'Add some amazing feature'
   ```
4. Push to the branch:

   ```bash
   git push origin feature/amazing-feature
   ```
5. Open a Pull Request

---

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 🙏 Acknowledgements

* [Laravel](https://laravel.com/)
* [Bootstrap](https://getbootstrap.com/)
* [Bootstrap Icons](https://icons.getbootstrap.com/)

---

Made with ❤️ for libraries everywhere

---
