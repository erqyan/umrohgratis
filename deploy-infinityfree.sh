#!/bin/bash

# ============================================
# Deploy Script untuk InfinityFree
# ============================================

echo "🚀 Laravel Deployment to InfinityFree"
echo "======================================"

# Configuration
FTP_HOST="ftpupload.net"
FTP_USER="if0_42427373"
FTP_PASS="$1"  # Password作为参数传递

if [ -z "$FTP_PASS" ]; then
    echo "❌ Usage: ./deploy-infinityfree.sh <FTP_PASSWORD>"
    exit 1
fi

echo "📦 Preparing deployment files..."

# 1. Build frontend assets
echo "🔨 Building frontend assets..."
npm install
npm run build

# 2. Create deployment directory
echo "📁 Creating deployment directory..."
DEPLOY_DIR="deploy-temp"
rm -rf $DEPLOY_DIR
mkdir -p $DEPLOY_DIR

# 3. Copy Laravel files (except public)
echo "📋 Copying Laravel files..."
cp -r app $DEPLOY_DIR/
cp -r bootstrap $DEPLOY_DIR/
cp -r config $DEPLOY_DIR/
cp -r database $DEPLOY_DIR/
cp -r resources $DEPLOY_DIR/
cp -r routes $DEPLOY_DIR/
cp -r storage $DEPLOY_DIR/
cp -r vendor $DEPLOY_DIR/
cp artisan $DEPLOY_DIR/
cp composer.json $DEPLOY_DIR/
cp composer.lock $DEPLOY_DIR/

# 4. Copy public files to htdocs
echo "🌐 Copying public files to htdocs..."
mkdir -p $DEPLOY_DIR/htdocs
cp -r public/* $DEPLOY_DIR/htdocs/

# 5. Copy .env.production as .env
echo "🔐 Creating .env file..."
cp .env.production $DEPLOY_DIR/.env

# 6. Copy .htaccess
cp .htaccess $DEPLOY_DIR/

# 7. Fix public/index.php paths
echo "🔧 Fixing index.php paths..."
sed -i "s|require __DIR__.'/../vendor/autoload.php';|require __DIR__.'/../../vendor/autoload.php';|g" $DEPLOY_DIR/htdocs/index.php
sed -i "s|\$app = require_once __DIR__.'/../bootstrap/app.php';|\$app = require_once __DIR__.'/../../bootstrap/app.php';|g" $DEPLOY_DIR/htdocs/index.php

# 8. Upload via FTP
echo "📤 Uploading to InfinityFree..."
if command -v lftp &> /dev/null; then
    lftp -u $FTP_USER,$FTP_PASS $FTP_HOST <<EOF
set ssl:verify-certificate no
mirror -R --verbose $DEPLOY_DIR/ /
quit
EOF
else
    echo "⚠️  lftp not found. Please install it first:"
    echo "   sudo apt install lftp"
    echo ""
    echo "   Or upload manually using FileZilla:"
    echo "   Host: $FTP_HOST"
    echo "   User: $FTP_USER"
    echo "   Password: <your password>"
    echo ""
    echo "   Upload contents of $DEPLOY_DIR/ to server root"
fi

# 9. Cleanup
echo "🧹 Cleaning up..."
rm -rf $DEPLOY_DIR

echo ""
echo "✅ Deployment complete!"
echo "🌐 Visit: http://umroh.infinityfreeapp.com"
echo ""
echo "⚠️  Note: DNS propagation may take up to 72 hours"
