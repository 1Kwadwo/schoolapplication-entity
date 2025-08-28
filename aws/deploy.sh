#!/bin/bash

# AWS Laravel Deployment Script
set -e

echo "🚀 Starting AWS Laravel Deployment..."

# Configuration
STACK_NAME="laravel-school-app"
REGION="us-east-1"
ENVIRONMENT="production"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if AWS CLI is installed
if ! command -v aws &> /dev/null; then
    print_error "AWS CLI is not installed. Please install it first."
    echo "Installation guide: https://docs.aws.amazon.com/cli/latest/userguide/getting-started-install.html"
    exit 1
fi

# Check if AWS credentials are configured
if ! aws sts get-caller-identity &> /dev/null; then
    print_error "AWS credentials are not configured. Please run 'aws configure' first."
    exit 1
fi

print_status "AWS CLI and credentials verified"

# Create S3 bucket for CloudFormation templates
BUCKET_NAME="laravel-deployment-$(date +%s)"
print_status "Creating S3 bucket: $BUCKET_NAME"

aws s3 mb s3://$BUCKET_NAME --region $REGION

# Upload CloudFormation template
print_status "Uploading CloudFormation template to S3"
aws s3 cp cloudformation.yaml s3://$BUCKET_NAME/cloudformation.yaml

# Deploy CloudFormation stack
print_status "Deploying CloudFormation stack: $STACK_NAME"

aws cloudformation deploy \
    --template-url https://s3.$REGION.amazonaws.com/$BUCKET_NAME/cloudformation.yaml \
    --stack-name $STACK_NAME \
    --parameter-overrides Environment=$ENVIRONMENT \
    --capabilities CAPABILITY_IAM \
    --region $REGION

# Get stack outputs
print_status "Getting stack outputs..."
LOAD_BALANCER_DNS=$(aws cloudformation describe-stacks \
    --stack-name $STACK_NAME \
    --region $REGION \
    --query 'Stacks[0].Outputs[?OutputKey==`LoadBalancerDNS`].OutputValue' \
    --output text)

VPC_ID=$(aws cloudformation describe-stacks \
    --stack-name $STACK_NAME \
    --region $REGION \
    --query 'Stacks[0].Outputs[?OutputKey==`VPCId`].OutputValue' \
    --output text)

S3_BUCKET=$(aws cloudformation describe-stacks \
    --stack-name $STACK_NAME \
    --region $REGION \
    --query 'Stacks[0].Outputs[?OutputKey==`AssetsBucketName`].OutputValue' \
    --output text)

print_status "Deployment completed successfully!"
echo ""
echo "📋 Deployment Summary:"
echo "======================"
echo "Stack Name: $STACK_NAME"
echo "Region: $REGION"
echo "Environment: $ENVIRONMENT"
echo "Load Balancer DNS: $LOAD_BALANCER_DNS"
echo "VPC ID: $VPC_ID"
echo "S3 Assets Bucket: $S3_BUCKET"
echo ""
echo "🌐 Your application should be available at:"
echo "   http://$LOAD_BALANCER_DNS"
echo ""
print_warning "Note: It may take a few minutes for the load balancer to become healthy."
echo ""
echo "📚 Next Steps:"
echo "1. Wait for the load balancer to become healthy"
echo "2. Access your application at the URL above"
echo "3. Set up a custom domain (optional)"
echo "4. Configure SSL certificate (optional)"
echo "5. Set up monitoring and alerts"
echo ""
print_status "Deployment script completed!"
