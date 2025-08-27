#!/bin/bash

echo "Generating Laravel APP_KEY..."
APP_KEY=$(php artisan key:generate --show)

echo "Your APP_KEY is: $APP_KEY"
echo ""
echo "Copy this key and replace 'base64:your-generated-key-here' in your env-production.txt file"
echo ""
echo "Or you can let Render auto-generate it by keeping the render.yaml configuration as is."
