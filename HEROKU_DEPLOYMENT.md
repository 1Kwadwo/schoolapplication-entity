# Heroku Deployment Guide

## Prerequisites

1. **Heroku Account**: Sign up at [heroku.com](https://heroku.com)
2. **Heroku CLI**: Install from [devcenter.heroku.com/articles/heroku-cli](https://devcenter.heroku.com/articles/heroku-cli)
3. **Git**: Make sure your code is in a Git repository

## Step 1: Install Heroku CLI

### macOS (using Homebrew):
```bash
brew tap heroku/brew && brew install heroku
```

### Windows:
Download and install from: https://devcenter.heroku.com/articles/heroku-cli

### Linux:
```bash
curl https://cli-assets.heroku.com/install.sh | sh
```

## Step 2: Login to Heroku

```bash
heroku login
```

## Step 3: Create Heroku App

```bash
# Create a new Heroku app
heroku create your-app-name

# Or let Heroku generate a name
heroku create
```

## Step 4: Add PostgreSQL Database

```bash
# Add PostgreSQL addon
heroku addons:create heroku-postgresql:mini
```

## Step 5: Set Environment Variables

```bash
# Set application key
heroku config:set APP_KEY=base64:ko3dW4IMQqhA5Y8RiFZqref/ahOasL6jbZLOKMCO9kk=

# Set database connection
heroku config:set DB_CONNECTION=pgsql

# Set other environment variables
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set LOG_LEVEL=error
heroku config:set CACHE_STORE=database
heroku config:set SESSION_DRIVER=database
heroku config:set QUEUE_CONNECTION=database
heroku config:set MAIL_MAILER=log
```

## Step 6: Deploy to Heroku

```bash
# Add Heroku remote
heroku git:remote -a your-app-name

# Push to Heroku
git push heroku main
```

## Step 7: Run Migrations and Seeders

```bash
# Run migrations
heroku run php artisan migrate --force

# Run seeders
heroku run php artisan db:seed --force
```

## Step 8: Open Your App

```bash
# Open in browser
heroku open
```

## Troubleshooting

### Check Logs
```bash
heroku logs --tail
```

### Run Commands
```bash
heroku run php artisan list
```

### Check Environment Variables
```bash
heroku config
```

### Database Connection
```bash
heroku run php artisan tinker
```

## Important Notes

1. **Database**: Heroku uses PostgreSQL, not SQLite
2. **Environment**: All environment variables are set via Heroku config
3. **Storage**: Use Heroku's ephemeral filesystem or external storage
4. **SSL**: Heroku provides automatic SSL certificates
5. **Scaling**: Upgrade your dyno plan for better performance

## Cost

- **Free Tier**: No longer available
- **Basic Dyno**: $7/month
- **PostgreSQL Mini**: $5/month
- **Total**: ~$12/month

## Next Steps

1. Set up custom domain (optional)
2. Configure email service (SendGrid, Mailgun, etc.)
3. Set up monitoring and logging
4. Configure backups
5. Set up CI/CD pipeline

## Support

- [Heroku Documentation](https://devcenter.heroku.com/)
- [Laravel on Heroku](https://devcenter.heroku.com/articles/deploying-php)
- [Heroku Support](https://help.heroku.com/)
