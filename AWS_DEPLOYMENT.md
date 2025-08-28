# AWS Deployment Guide for Laravel School Application

## 🏗️ **Infrastructure Overview**

This deployment creates a production-ready AWS infrastructure with:
- **VPC** with public subnets
- **Application Load Balancer** for high availability
- **Auto Scaling Group** with EC2 instances
- **S3 Bucket** for assets storage
- **CloudWatch** for monitoring and logging

## 📋 **Prerequisites**

### 1. **AWS Account**
- Sign up at [aws.amazon.com](https://aws.amazon.com)
- Verify your account (credit card required)
- Get 12 months free tier

### 2. **AWS CLI Installation**

#### macOS:
```bash
# Install AWS CLI
curl "https://awscli.amazonaws.com/AWSCLIV2.pkg" -o "AWSCLIV2.pkg"
sudo installer -pkg AWSCLIV2.pkg -target /
```

#### Windows:
Download from: https://awscli.amazonaws.com/AWSCLIV2.msi

#### Linux:
```bash
curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
sudo ./aws/install
```

### 3. **Configure AWS Credentials**
```bash
aws configure
# Enter your AWS Access Key ID
# Enter your AWS Secret Access Key
# Enter your default region (e.g., us-east-1)
# Enter your output format (json)
```

## 🚀 **Deployment Options**

### Option 1: Automated Deployment (Recommended)

1. **Make the deployment script executable:**
   ```bash
   chmod +x aws/deploy.sh
   ```

2. **Run the deployment:**
   ```bash
   cd aws
   ./deploy.sh
   ```

3. **Wait for deployment to complete** (10-15 minutes)

### Option 2: Manual CloudFormation Deployment

1. **Create S3 bucket for templates:**
   ```bash
   aws s3 mb s3://laravel-deployment-$(date +%s) --region us-east-1
   ```

2. **Upload CloudFormation template:**
   ```bash
   aws s3 cp aws/cloudformation.yaml s3://your-bucket-name/
   ```

3. **Deploy the stack:**
   ```bash
   aws cloudformation deploy \
     --template-url https://s3.us-east-1.amazonaws.com/your-bucket-name/cloudformation.yaml \
     --stack-name laravel-school-app \
     --capabilities CAPABILITY_IAM \
     --region us-east-1
   ```

### Option 3: Docker Deployment

1. **Deploy using Docker Compose:**
   ```bash
   cd aws
   docker-compose up -d
   ```

## 🔧 **Post-Deployment Setup**

### 1. **Get Application URL**
```bash
aws cloudformation describe-stacks \
  --stack-name laravel-school-app \
  --region us-east-1 \
  --query 'Stacks[0].Outputs[?OutputKey==`LoadBalancerDNS`].OutputValue' \
  --output text
```

### 2. **Run Laravel Commands**
```bash
# Get instance ID
INSTANCE_ID=$(aws autoscaling describe-auto-scaling-groups \
  --auto-scaling-group-names laravel-school-app-asg \
  --region us-east-1 \
  --query 'AutoScalingGroups[0].Instances[0].InstanceId' \
  --output text)

# Run migrations
aws ssm send-command \
  --instance-ids $INSTANCE_ID \
  --document-name "AWS-RunShellScript" \
  --parameters 'commands=["cd /var/www/html && php artisan migrate --force"]' \
  --region us-east-1

# Run seeders
aws ssm send-command \
  --instance-ids $INSTANCE_ID \
  --document-name "AWS-RunShellScript" \
  --parameters 'commands=["cd /var/www/html && php artisan db:seed --force"]' \
  --region us-east-1
```

### 3. **Set up Custom Domain (Optional)**

1. **Register domain in Route 53**
2. **Create hosted zone**
3. **Add DNS records pointing to load balancer**
4. **Request SSL certificate in Certificate Manager**

## 💰 **Cost Breakdown**

### Free Tier (12 months):
- **EC2 t3.micro**: 750 hours/month
- **Application Load Balancer**: 750 hours/month
- **S3**: 5GB storage
- **CloudWatch**: 5GB data ingestion
- **Total**: $0 for first year

### After Free Tier:
- **EC2 t3.micro**: ~$8/month
- **Application Load Balancer**: ~$18/month
- **S3**: ~$0.02/GB
- **CloudWatch**: ~$0.50/month
- **Total**: ~$26/month

## 🔍 **Monitoring and Troubleshooting**

### Check Application Status
```bash
# Get load balancer health
aws elbv2 describe-target-health \
  --target-group-arn $(aws elbv2 describe-target-groups \
    --names laravel-school-app-tg \
    --region us-east-1 \
    --query 'TargetGroups[0].TargetGroupArn' \
    --output text) \
  --region us-east-1
```

### View CloudWatch Logs
```bash
# Get log group name
aws logs describe-log-groups \
  --log-group-name-prefix "/aws/ec2/production-laravel" \
  --region us-east-1

# View recent logs
aws logs tail /aws/ec2/production-laravel --follow --region us-east-1
```

### Common Issues and Solutions

1. **Instance not healthy:**
   - Check security groups
   - Verify Apache is running
   - Check application logs

2. **Database connection issues:**
   - Ensure SQLite file exists
   - Check file permissions
   - Verify database path

3. **Application errors:**
   - Check Laravel logs
   - Verify environment variables
   - Check storage permissions

## 🔒 **Security Best Practices**

1. **Update security groups** to restrict access
2. **Use IAM roles** instead of access keys
3. **Enable CloudTrail** for audit logging
4. **Set up CloudWatch alarms** for monitoring
5. **Regular security updates** for EC2 instances

## 📈 **Scaling**

### Auto Scaling
- **CPU-based scaling**: Scale up when CPU > 70%
- **Memory-based scaling**: Scale up when memory > 80%
- **Custom metrics**: Scale based on application metrics

### Manual Scaling
```bash
# Update auto scaling group
aws autoscaling update-auto-scaling-group \
  --auto-scaling-group-name laravel-school-app-asg \
  --min-size 2 \
  --max-size 5 \
  --desired-capacity 3 \
  --region us-east-1
```

## 🧹 **Cleanup**

To remove all resources:
```bash
# Delete CloudFormation stack
aws cloudformation delete-stack \
  --stack-name laravel-school-app \
  --region us-east-1

# Wait for deletion to complete
aws cloudformation wait stack-delete-complete \
  --stack-name laravel-school-app \
  --region us-east-1
```

## 📚 **Additional Resources**

- [AWS CloudFormation Documentation](https://docs.aws.amazon.com/cloudformation/)
- [Laravel on AWS](https://laravel.com/docs/deployment#aws)
- [AWS Well-Architected Framework](https://aws.amazon.com/architecture/well-architected/)
- [AWS Cost Optimization](https://aws.amazon.com/cost-optimization/)

## 🆘 **Support**

- [AWS Support](https://aws.amazon.com/support/)
- [AWS Community](https://aws.amazon.com/community/)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/aws)
