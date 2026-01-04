# BlissBox API Documentation

## Base URL
```
http://127.0.0.1:8000/api/v1
```

## Authentication

All protected routes require a Bearer token in the Authorization header:
```
Authorization: Bearer {your_token_here}
```

---

## Public Endpoints (No Authentication Required)

### Authentication

#### Register User
```
POST /register
```
**Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Login User
```
POST /login
```
**Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Admin Register
```
POST /admin/register
```
**Body:**
```json
{
  "name": "Admin User",
  "email": "admin@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Admin Login
```
POST /admin/login
```
**Body:**
```json
{
  "email": "admin@example.com",
  "password": "password123"
}
```

**Response (all auth endpoints):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "is_admin": false
    },
    "token": "your_api_token_here"
  }
}
```

---

### Products (Public - Read Only)

#### Get All Products
```
GET /products
```
**Query Parameters:**
- `category` (optional): Filter by category
- `search` (optional): Search in name, description, category
- `per_page` (optional): Items per page (default: 15)

#### Get Single Product
```
GET /products/{id}
```

#### Search Products
```
GET /products/search?q={search_term}
```

---

### Categories (Public - Read Only)

#### Get All Categories
```
GET /categories
```
**Query Parameters:**
- `search` (optional): Search in name, description
- `include_inactive` (optional): Include inactive categories

#### Get Single Category
```
GET /categories/{id}
```

---

## Protected Endpoints (Require Authentication)

### User Info
```
GET /user
```
**Headers:**
```
Authorization: Bearer {token}
```

---

### Orders (Authenticated Users)

#### Get All Orders
```
GET /orders
```
**Query Parameters:**
- `status` (optional): Filter by order_status
- `payment_status` (optional): Filter by payment_status
- `per_page` (optional): Items per page

**Note:** Non-admin users can only see their own orders.

#### Get Single Order
```
GET /orders/{id}
```

#### Create Order
```
POST /orders
```
**Body:**
```json
{
  "customer_name": "John Doe",
  "customer_email": "john@example.com",
  "customer_phone": "1234567890",
  "shipping_address": "123 Main St",
  "billing_address": "123 Main St",
  "payment_method": "cash_on_delivery",
  "notes": "Please deliver in the morning",
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ]
}
```

#### Update Order
```
PUT /orders/{id}
```
**Body:**
```json
{
  "order_status": "processing",
  "payment_status": "paid",
  "shipping_address": "Updated address",
  "notes": "Updated notes"
}
```

**Note:** Only admins can update orders.

#### Logout
```
POST /logout
```

---

## Admin Protected Endpoints (Require Admin Authentication)

### Admin Products CRUD

#### Get All Products (Admin - Includes Inactive)
```
GET /admin/products
```
**Query Parameters:**
- `category` (optional): Filter by category
- `search` (optional): Search term
- `per_page` (optional): Items per page

#### Get Single Product (Admin)
```
GET /admin/products/{id}
```

#### Create Product (Admin)
```
POST /admin/products
```
**Body (multipart/form-data or JSON):**
```json
{
  "name": "Product Name",
  "description": "Product Description",
  "price": 99.99,
  "discount_price": 79.99,
  "category": "For Her",
  "stock_quantity": 100,
  "features": "Feature 1, Feature 2",
  "is_featured": true,
  "in_stock": true,
  "is_active": true,
  "image": "file_upload" // or
  "image_url": "https://example.com/image.jpg"
}
```

#### Update Product (Admin)
```
PUT /admin/products/{id}
```
**Body:** Same as create

#### Delete Product (Admin)
```
DELETE /admin/products/{id}
```

---

### Admin Categories CRUD

#### Get All Categories (Admin)
```
GET /admin/categories
```
**Query Parameters:**
- `search` (optional): Search term
- `per_page` (optional): Items per page

#### Create Category (Admin)
```
POST /admin/categories
```
**Body:**
```json
{
  "name": "Category Name",
  "description": "Category Description",
  "image": "file_upload" // or
  "image_url": "https://example.com/image.jpg",
  "is_active": true
}
```

#### Update Category (Admin)
```
PUT /admin/categories/{id}
```
**Body:** Same as create

#### Delete Category (Admin)
```
DELETE /admin/categories/{id}
```

---

### Admin Orders

#### Get All Orders (Admin)
```
GET /admin/orders
```
**Query Parameters:**
- `status` (optional): Filter by order_status
- `per_page` (optional): Items per page

#### Get Single Order (Admin)
```
GET /admin/orders/{id}
```

#### Update Order (Admin)
```
PUT /admin/orders/{id}
```
**Body:**
```json
{
  "order_status": "shipped",
  "payment_status": "paid",
  "shipping_address": "Updated address",
  "notes": "Updated notes"
}
```

#### Delete Order (Admin)
```
DELETE /admin/orders/{id}
```

---

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field": ["Error message"]
  }
}
```

### Status Codes
- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error

---

## Example Usage

### Using cURL

**Login:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password123"}'
```

**Get Products:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/products \
  -H "Authorization: Bearer {your_token}"
```

**Create Product (Admin):**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/admin/products \
  -H "Authorization: Bearer {admin_token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Product",
    "description": "Product description",
    "price": 99.99,
    "category": "For Her",
    "stock_quantity": 50,
    "is_active": true
  }'
```

---

## Notes

1. All timestamps are in ISO 8601 format
2. Image URLs are automatically generated for uploaded images
3. Product prices are in decimal format (2 decimal places)
4. Admin endpoints require both authentication and admin privileges
5. Token expires when user logs out or token is revoked
6. Pagination is available for list endpoints using `per_page` parameter

