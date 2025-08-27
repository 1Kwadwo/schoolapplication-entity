# School/University Application System

A complete Laravel-based school application system with role-based access control for students and administrators.

## Features

### Student Portal

-   User registration and login
-   Online application submission with comprehensive form
-   Application status tracking (Pending, Under Review, Accepted, Rejected)
-   View application details and timeline
-   File upload support for grades/transcripts

### Admin Portal

-   Dashboard with application statistics
-   View all submitted applications
-   Search and filter applications
-   Update application status
-   Export applications to CSV
-   View detailed application information including uploaded files

### Technical Features

-   Role-based authentication (Student/Admin)
-   File upload and storage
-   Responsive design with TailwindCSS
-   Form validation
-   Flash messages for user feedback
-   Pagination for large datasets

## Tech Stack

-   **Backend**: Laravel 12.x
-   **Frontend**: Laravel Blade with TailwindCSS
-   **Database**: SQLite (default) / MySQL
-   **Authentication**: Laravel Breeze
-   **File Storage**: Laravel Storage

## Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd school-application-system
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database setup**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. **Storage setup**

    ```bash
    php artisan storage:link
    ```

6. **Build assets**

    ```bash
    npm run build
    ```

7. **Start the server**
    ```bash
    php artisan serve
    ```

## Default Users

After running the seeder, the following users are created:

### Admin User

-   **Email**: admin@school.com
-   **Password**: password
-   **Role**: Admin

### Sample Student Users

-   **Email**: john@example.com
-   **Password**: password
-   **Role**: Student

-   **Email**: jane@example.com
-   **Password**: password
-   **Role**: Student

-   **Email**: mike@example.com
-   **Password**: password
-   **Role**: Student

## Database Schema

### Users Table

-   `id` - Primary key
-   `name` - User's full name
-   `email` - Email address (unique)
-   `password` - Hashed password
-   `role` - User role (student/admin)
-   `email_verified_at` - Email verification timestamp
-   `remember_token` - Remember me token
-   `created_at` - Creation timestamp
-   `updated_at` - Last update timestamp

### Applications Table

-   `id` - Primary key
-   `user_id` - Foreign key to users table
-   `full_name` - Applicant's full name
-   `email` - Applicant's email
-   `phone_number` - Phone number
-   `date_of_birth` - Date of birth
-   `gender` - Gender (male/female/other)
-   `address` - Full address
-   `program_of_choice` - Selected program
-   `previous_education` - Educational background
-   `grade_file` - Uploaded file path
-   `status` - Application status (pending/under_review/accepted/rejected)
-   `created_at` - Creation timestamp
-   `updated_at` - Last update timestamp

## Routes

### Public Routes

-   `/` - Welcome page
-   `/login` - Login page
-   `/register` - Registration page

### Student Routes (Authenticated)

-   `/student/dashboard` - Student dashboard
-   `/student/application/create` - Application form
-   `/student/application/{id}` - View application

### Admin Routes (Authenticated + Admin)

-   `/admin/dashboard` - Admin dashboard
-   `/admin/applications` - Applications list
-   `/admin/applications/{id}` - View application details
-   `/admin/applications/{id}/status` - Update application status
-   `/admin/applications/export/csv` - Export applications

## File Structure

```
school-application-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   └── ApplicationController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── Application.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── create_applications_table.php
│   │   └── add_role_to_users_table.php
│   └── seeders/
│       ├── AdminUserSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   └── applications/
│       │       ├── index.blade.php
│       │       └── show.blade.php
│       ├── student/
│       │   ├── dashboard.blade.php
│       │   └── application/
│       │       └── create.blade.php
│       └── applications/
│           └── show.blade.php
└── routes/
    └── web.php
```

## Usage

### For Students

1. Register a new account or login with existing credentials
2. Navigate to "Apply Now" to submit an application
3. Fill out the comprehensive application form
4. Upload required documents (grades/transcripts)
5. Submit the application
6. Track application status from the dashboard

### For Administrators

1. Login with admin credentials
2. View dashboard with application statistics
3. Navigate to "Applications" to view all submissions
4. Use search and filter options to find specific applications
5. Click "View" to see detailed application information
6. Update application status as needed
7. Export applications to CSV for external processing

## Security Features

-   Password hashing using Laravel's built-in bcrypt
-   CSRF protection on all forms
-   Role-based middleware for admin access
-   File upload validation and security
-   SQL injection protection through Eloquent ORM
-   XSS protection through Blade templating

## Customization

### Adding New Programs

Edit the application form in `resources/views/student/application/create.blade.php` and add new options to the program selection dropdown.

### Modifying Application Fields

1. Update the migration file for the applications table
2. Modify the Application model's `$fillable` array
3. Update the form validation rules in ApplicationController
4. Modify the application form and display views

### Styling

The application uses TailwindCSS for styling. Modify the CSS classes in the Blade templates to customize the appearance.

## Troubleshooting

### Common Issues

1. **Storage link not working**

    ```bash
    php artisan storage:link
    ```

2. **Database connection issues**

    - Check your `.env` file configuration
    - Ensure the database exists and is accessible

3. **File upload issues**

    - Verify storage permissions
    - Check file size limits in PHP configuration

4. **Authentication issues**
    - Clear application cache: `php artisan cache:clear`
    - Clear config cache: `php artisan config:clear`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please refer to the Laravel documentation or create an issue in the project repository.
