# School Application System

A Laravel-based school application system that runs completely offline with no external dependencies.

## 🚀 Quick Start

### Prerequisites

-   PHP 8.2+
-   Composer
-   SQLite (included with PHP)

### Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd school-application-system
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Set up the database**

    ```bash
    php artisan migrate:fresh --seed
    ```

4. **Start the development server**

    ```bash
    php artisan serve
    ```

5. **Access the application**
    - URL: http://localhost:8000
    - **Demo Login:** `demo@example.com` / `password`

## ✨ Features

### Offline-First Design

-   **No .env required** - All configuration is built-in
-   **SQLite database** - No external database setup needed
-   **Local file storage** - All files stored locally
-   **Mock services** - External APIs replaced with local stubs

### School Management

-   **Student Applications** - Complete application management system
-   **Program Management** - Create and manage academic programs
-   **Admin Dashboard** - Comprehensive admin interface
-   **User Management** - Role-based access control

### Authentication

-   **Built-in Laravel Auth** - No external authentication services
-   **Session-based** - Secure local session management
-   **Role-based access** - Admin and Student roles

## 🔧 Configuration

### Database

-   **Default:** SQLite at `database/database.sqlite`
-   **No configuration needed** - Works out of the box

### Mail

-   **Driver:** Log (emails written to `storage/logs/laravel.log`)
-   **No external mail services** - Perfect for development

### Cache & Sessions

-   **Cache:** File-based (`storage/framework/cache`)
-   **Sessions:** File-based (`storage/framework/sessions`)
-   **Queues:** Sync (no external queue workers needed)

### Security

-   **APP_KEY:** Pre-configured static key
-   **CSRF Protection:** Enabled
-   **External Requests:** Blocked by middleware

## 📁 Project Structure

```
school-application-system/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   ├── Services/Mocks/      # Mock services for offline mode
│   └── Http/Middleware/     # Custom middleware
├── config/                  # Configuration files (no env() calls)
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/            # Database seeders
│   └── database.sqlite     # SQLite database file
├── resources/views/         # Blade templates
├── routes/                  # Application routes
├── storage/
│   ├── fixtures/           # Mock API responses
│   └── logs/               # Application logs
└── public/                 # Public assets
```

## 🎯 Default Users

### Admin User

-   **Email:** `demo@example.com`
-   **Password:** `password`
-   **Role:** Admin

### Sample Students

-   **Email:** `john@example.com` / **Password:** `password`
-   **Email:** `jane@example.com` / **Password:** `password`
-   **Email:** `mike@example.com` / **Password:** `password`

## 🔒 Security Features

### Offline Security

-   **BlockExternalRequests Middleware** - Prevents external HTTP requests
-   **Local-only sessions** - No external session storage
-   **File-based storage** - All data stored locally

### Application Security

-   **CSRF Protection** - Built-in Laravel CSRF tokens
-   **Input Validation** - Comprehensive form validation
-   **SQL Injection Protection** - Eloquent ORM protection
-   **XSS Protection** - Blade template escaping

## 🛠️ Development

### Adding New Features

1. Create migrations: `php artisan make:migration create_new_table`
2. Create models: `php artisan make:model NewModel`
3. Create controllers: `php artisan make:controller NewController`
4. Add routes in `routes/web.php`
5. Create views in `resources/views/`

### Database Changes

```bash
# Create new migration
php artisan make:migration add_new_column_to_table

# Run migrations
php artisan migrate

# Reset database with fresh data
php artisan migrate:fresh --seed
```

### Mock Services

-   **Location:** `app/Services/Mocks/`
-   **Purpose:** Replace external API calls with local responses
-   **Usage:** Inject mock services instead of real external services

## 📝 Logging

### Application Logs

-   **Location:** `storage/logs/laravel.log`
-   **Mail Logs:** All emails are logged here instead of being sent
-   **Error Logs:** Application errors and exceptions

### Viewing Logs

```bash
# View application logs
tail -f storage/logs/laravel.log

# Clear logs
php artisan log:clear
```

## 🚫 What's Not Included

### External Dependencies

-   ❌ No external APIs (OpenAI, Google, Stripe, etc.)
-   ❌ No external databases (MySQL, PostgreSQL, Redis)
-   ❌ No external mail services (SendGrid, Mailgun, etc.)
-   ❌ No external authentication (OAuth, social login)
-   ❌ No external file storage (AWS S3, Google Cloud)

### Environment Variables

-   ❌ No .env file required
-   ❌ No environment-specific configuration
-   ❌ No API keys or secrets

## 🎉 Benefits

### For Development

-   **Instant Setup** - No configuration required
-   **Offline Work** - Works without internet connection
-   **Consistent Environment** - Same setup everywhere
-   **Fast Development** - No external service dependencies

### For Learning

-   **Self-Contained** - Everything needed is included
-   **No External Costs** - No paid services required
-   **Full Control** - Complete access to all components
-   **Educational** - Perfect for learning Laravel

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Ensure all tests pass
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

**Built with ❤️ using Laravel - Works completely offline!**
