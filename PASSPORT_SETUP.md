# Laravel Passport Setup Instructions

Follow these steps to set up Laravel Passport for API authentication:

## Step 1: Install Laravel Passport

```bash
composer require laravel/passport
```

## Step 2: Run Migrations

```bash
php artisan migrate
```

## Step 3: Install Passport

```bash
php artisan passport:install
```

This will create the encryption keys needed to generate secure access tokens.

## Step 4: Update AppServiceProvider (if needed)

The User model already has `HasApiTokens` trait added. Make sure your `app/Providers/AppServiceProvider.php` registers Passport routes if needed:

```php
use Laravel\Passport\Passport;

public function boot(): void
{
    Passport::tokensExpireIn(now()->addDays(15));
    Passport::refreshTokensExpireIn(now()->addDays(30));
}
```

## Step 5: Verify Configuration

The following files have already been configured:
- ✅ `app/Models/User.php` - Has `HasApiTokens` trait
- ✅ `config/auth.php` - Has `api` guard configured with Passport
- ✅ `bootstrap/app.php` - API routes registered, admin middleware alias added

## Step 6: Test API Authentication

Use the Postman collection (`BlissBox_API.postman_collection.json`) to test the API endpoints.

### Getting an Access Token:

1. Register a new user: `POST /api/v1/register`
2. Or login: `POST /api/v1/login`
3. Copy the `token` from the response
4. Use this token in the `Authorization` header for protected routes:
   ```
   Authorization: Bearer {your-token-here}
   ```

## API Endpoints

### Public Endpoints (No Authentication):
- `GET /api/v1/products` - List products
- `GET /api/v1/products/{id}` - Get product details
- `GET /api/v1/products/search?q=search_term` - Search products
- `GET /api/v1/categories` - List categories
- `GET /api/v1/categories/{id}` - Get category details
- `POST /api/v1/register` - Register new user
- `POST /api/v1/login` - Login user

### Protected Endpoints (Require Authentication):
- `GET /api/v1/user` - Get authenticated user info
- `GET /api/v1/orders` - Get user orders
- `GET /api/v1/orders/{id}` - Get order details
- `POST /api/v1/orders` - Create new order
- `PUT /api/v1/orders/{id}` - Update order (Admin only)
- `POST /api/v1/logout` - Logout

### Admin Only Endpoints (Require Authentication + Admin Role):
- `POST /api/v1/products` - Create product
- `PUT /api/v1/products/{id}` - Update product
- `DELETE /api/v1/products/{id}` - Delete product
- `POST /api/v1/categories` - Create category
- `PUT /api/v1/categories/{id}` - Update category
- `DELETE /api/v1/categories/{id}` - Delete category

## Important Notes:

1. Make sure your database has users with `is_admin = 1` to access admin endpoints
2. All protected routes require the `Authorization: Bearer {token}` header
3. The API uses JSON format for requests and responses
4. Image uploads use multipart/form-data for file uploads

