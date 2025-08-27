#!/bin/bash

echo "Testing Docker build..."

# Build the Docker image
docker build -t school-app-test .

if [ $? -eq 0 ]; then
    echo "✅ Docker build successful!"
    echo "You can now deploy to Render with confidence."
else
    echo "❌ Docker build failed. Check the errors above."
    exit 1
fi
