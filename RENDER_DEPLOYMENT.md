# Render Deployment Guide

## Quick Deployment with Environment File

### Option 1: Use the Environment File (Easiest)

1. **Copy the environment variables** from `env-production.txt`
2. **Go to Render Dashboard** → Your Service → Environment
3. **Add Environment Variables** by copying from the file

### Option 2: Generate APP_KEY (Optional)

If you want to generate your own APP_KEY:

```bash
./generate-key.sh
```

Then replace `base64:your-generated-key-here` in `env-production.txt` with the generated key.

### Option 3: Let Render Auto-Generate (Recommended)

Keep the `render.yaml` configuration as is - Render will auto-generate the APP_KEY.

## Environment Variables for Copy-Paste

Copy these variables to Render:

```
APP_NAME="School Application System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://schoolapplication-entity.onrender.com
APP_KEY=base64:your-generated-key-here
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=/var/www/html/database/database.sqlite
DB_USERNAME=
DB_PASSWORD=
BROADCAST_DRIVER=log
CACHE_STORE=database
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120
MEMCACHED_HOST=127.0.0.1
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
MAIL_MAILER=log
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@school.com"
MAIL_FROM_NAME="School Application System"
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1
VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

## Deployment Steps

1. **Create Web Service** on Render
2. **Connect GitHub Repository**: `1Kwadwo/schoolapplication-entity`
3. **Environment**: Docker
4. **Copy Environment Variables** from above
5. **Deploy**

## Default Login Credentials

After deployment, login with:

-   **Email**: `admin@school.com`
-   **Password**: `password`
