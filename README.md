# OAuth Laravel Project - Installation Guide

## 📋 Prerequisites

Before starting, make sure you have:
- **PHP 8.1+** installed
- **Composer** installed
- **Node.js & NPM** installed
- **MySQL/PostgreSQL** or SQLite
- **Git** installed

## 🚀 Installation Steps

### **Step 1: Clone Repository**
```bash
git clone [YOUR_REPOSITORY_URL]
cd AuthCodeGrant
```

### **Step 2: Install Dependencies**
```bash
composer install
```

```bash
npm install
```

### **Step 3: Environment Configuration**
```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

### **Step 4: Database Setup**

**Option A: SQLite**
```bash
touch database/database.sqlite
```
Update `.env`:
```env
DB_CONNECTION=sqlite
```

### **Step 5: Run Migrations**
```bash
php artisan migrate
```

### **Step 6: Install Laravel Passport**
```bash
php artisan passport:install
```

**⚠️ IMPORTANT**: Copy the Client ID and Client Secret from the output!

### **Step 7: Update Environment with OAuth Credentials**
Edit `.env` file and add:
```env
PASSPORT_CLIENT_ID=1
PASSPORT_CLIENT_SECRET=paste_your_client_secret_here
PASSPORT_REDIRECT_URI=http://localhost:8000/auth/callback
```

### **Step 8: Install Authentication (Laravel Breeze)**
```bash
php artisan breeze:install vue
```

```bash
npm run build
```

### **Step 9: Create Test User**
```bash
php artisan tinker
```

In the tinker console, run:
```php
\App\Models\User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password123')
]);
```

Type `exit` to leave tinker.

### **Step 10: Start Development Servers**

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Frontend Assets (if needed):**
```bash
npm run dev
```

## ✅ Verify Installation

### **Test 1: Basic API Test**
Open browser/Postman and visit:
```
GET http://127.0.0.1:8000/api/test
```
Should return: `{"message": "API is working"}`

### **Test 2: OAuth Authorization URL**
```
GET http://127.0.0.1:8000/oauth/url
```
Should return JSON with authorization URL.

### **Test 3: Login Page**
Visit: `http://127.0.0.1:8000/login`
Should show login form.

## 🔧 Troubleshooting

### **Common Issues:**

**"Class 'Laravel\Passport\PassportServiceProvider' not found"**
```bash
composer dump-autoload
php artisan config:clear
```

**"No application encryption key has been specified"**
```bash
php artisan key:generate
```

**"Database does not exist"**
- Create the database manually in MySQL/PostgreSQL
- Or use SQLite option from Step 4

**"Client authentication failed"**
- Make sure you copied the correct Client Secret from `passport:install`
- Check your `.env` file has the right `PASSPORT_CLIENT_SECRET`

**"npm command not found"**
- Install Node.js from https://nodejs.org/

## 📁 Project Structure

After installation, you should have:
```
AuthCodeGrant/
├── app/Http/Controllers/OAuthController.php
├── routes/web.php
├── routes/api.php
├── .env (with your credentials)
├── database/migrations/
└── vendor/ (dependencies)
```

## 🎯 Next Steps

Once installation is complete:
1. Test the OAuth flow using Postman
2. Check the main README for API usage examples
3. Start building your OAuth client application

## 📞 Support

If you encounter issues:
1. Check PHP version: `php --version` (needs 8.1+)
2. Check Composer: `composer --version`
3. Check Node.js: `node --version`
4. Verify database connection in `.env`
5. Ensure all environment variables are set correctly

**Installation complete! 🎉**
