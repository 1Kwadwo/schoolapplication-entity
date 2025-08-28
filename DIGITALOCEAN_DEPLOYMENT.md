# DigitalOcean App Platform Deployment Guide

## Prerequisites

1. **DigitalOcean Account**: Sign up at [digitalocean.com](https://digitalocean.com)
2. **GitHub Repository**: Your code should be in a GitHub repo
3. **Credit Card**: Required for account verification (but you get $5 free credit)

## Step 1: Create DigitalOcean Account

1. Go to [digitalocean.com](https://digitalocean.com)
2. Click "Sign Up"
3. Complete registration and verify your account
4. You'll get $5 free credit

## Step 2: Access App Platform

1. Login to DigitalOcean
2. Go to "Apps" in the left sidebar
3. Click "Create App"

## Step 3: Connect GitHub Repository

1. Click "Link Your GitHub Account"
2. Authorize DigitalOcean to access your repos
3. Select your repository: `1Kwadwo/schoolapplication-entity`
4. Choose the `main` branch

## Step 4: Configure App Settings

### Basic Settings:

-   **App Name**: `school-application-system`
-   **Region**: Choose closest to your users
-   **Environment**: `PHP`

### Build Settings:

-   **Build Command**: Leave empty (auto-detected)
-   **Run Command**: `vendor/bin/heroku-php-apache2 public/`

### Environment Variables:

Add these environment variables:

```
APP_NAME=School Application System
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:ko3dW4IMQqhA5Y8RiFZqref/ahOasL6jbZLOKMCO9kk=
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
LOG_CHANNEL=stack
LOG_LEVEL=error
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@school.com
MAIL_FROM_NAME=School Application System
```

## Step 5: Deploy

1. Click "Create Resources"
2. Wait for deployment (5-10 minutes)
3. Your app will be live at: `https://your-app-name.ondigitalocean.app`

## Step 6: Run Migrations and Seeders

After deployment, you can run Laravel commands:

```bash
# Install doctl CLI (optional)
brew install doctl

# Login to DigitalOcean
doctl auth init

# Run migrations
doctl apps run your-app-id -- php artisan migrate --force

# Run seeders
doctl apps run your-app-id -- php artisan db:seed --force
```

## Step 7: Verify Deployment

1. Visit your app URL
2. Check if Laravel is running
3. Test the application features

## Troubleshooting

### Check Logs

-   Go to your app in DigitalOcean dashboard
-   Click "Runtime Logs" tab
-   Check for any errors

### Common Issues

1. **Build Failures**:

    - Check if all dependencies are in `composer.json`
    - Ensure PHP version is compatible

2. **Database Issues**:

    - SQLite file should be created automatically
    - Check file permissions

3. **Environment Variables**:
    - Verify all required env vars are set
    - Check APP_KEY is correct

## Cost Breakdown

-   **Basic App (XXS)**: $5/month
-   **Free Credit**: $5/month
-   **Net Cost**: $0 (completely free!)

## Scaling

When you need to scale:

1. Go to app settings
2. Increase instance count
3. Upgrade instance size
4. Add load balancer if needed

## Custom Domain

1. Go to app settings
2. Click "Domains" tab
3. Add your custom domain
4. Update DNS records

## Monitoring

-   **Logs**: Available in dashboard
-   **Metrics**: CPU, memory, requests
-   **Alerts**: Set up notifications

## Support

-   [DigitalOcean Documentation](https://docs.digitalocean.com/)
-   [App Platform Guide](https://docs.digitalocean.com/products/app-platform/)
-   [Community Support](https://www.digitalocean.com/community/)

## Next Steps

1. Set up custom domain
2. Configure email service
3. Set up monitoring
4. Configure backups
5. Set up CI/CD pipeline
