# School Application System - Deployment Guide

## Render Deployment

This Laravel application is configured for deployment on Render.com.

### Prerequisites

1. **GitHub Repository**: Ensure your code is pushed to a GitHub repository
2. **Render Account**: Sign up at [render.com](https://render.com)

### Deployment Steps

1. **Connect Repository**

    - Log in to Render
    - Click "New +" → "Web Service"
    - Connect your GitHub repository
    - Select the repository containing this Laravel application

2. **Configure Service**

    - **Name**: `school-application-system` (or your preferred name)
    - **Environment**: `PHP`
    - **Region**: Choose closest to your users
    - **Branch**: `main` (or your default branch)
    - **Root Directory**: Leave empty (if Laravel is in root)

3. **Build & Deploy Settings**

    - **Build Command**: `composer install --no-dev --optimize-autoloader && npm ci && npm run build`
    - **Start Command**: `php artisan migrate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache && vendor/bin/heroku-php-apache2 public/`

4. **Environment Variables**
   The following environment variables will be automatically set:

    - `APP_ENV=production`
    - `APP_DEBUG=false`
    - `APP_KEY` (auto-generated)
    - `APP_URL` (your Render URL)
    - `DB_CONNECTION=sqlite`
    - `DB_DATABASE=/opt/render/project/src/database/database.sqlite`
    - `SESSION_DRIVER=database`
    - `CACHE_STORE=database`
    - `QUEUE_CONNECTION=database`
    - `FILESYSTEM_DISK=local`
    - `LOG_CHANNEL=stack`
    - `MAIL_MAILER=log`

5. **Deploy**
    - Click "Create Web Service"
    - Render will automatically build and deploy your application

### Post-Deployment

1. **Database Setup**

    - The application will automatically run migrations
    - You may want to seed the database with initial data:

    ```bash
    php artisan db:seed --class=AdminUserSeeder
    php artisan db:seed --class=ProgramSeeder
    ```

2. **Admin Access**

    - Default admin credentials:
        - Email: `admin@school.com`
        - Password: `password`

3. **File Uploads**
    - File uploads are stored locally on Render
    - For production, consider using AWS S3 or similar for file storage

### Important Notes

-   **Free Tier Limitations**: Render's free tier has limitations on build time and runtime
-   **Database**: Uses SQLite for simplicity. For production, consider PostgreSQL
-   **File Storage**: Uses local storage. Consider cloud storage for production
-   **Email**: Configured to use log driver. Set up proper email service for production

### Troubleshooting

1. **Build Failures**

    - Check build logs in Render dashboard
    - Ensure all dependencies are in `composer.json` and `package.json`

2. **Database Issues**

    - Verify migrations run successfully
    - Check database permissions

3. **File Upload Issues**
    - Ensure storage directory is writable
    - Check storage link is created

### Security Considerations

-   `APP_DEBUG` is set to `false` in production
-   Sensitive files are excluded via `.gitignore`
-   Use strong passwords for admin accounts
-   Consider implementing HTTPS redirects
-   Set up proper email configuration for notifications

### Performance Optimization

-   All caches are enabled (config, route, view)
-   Assets are compiled and minified
-   Database queries are optimized
-   Consider implementing Redis for caching in production
