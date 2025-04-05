# 📘 Authentication API Guide

## 🔧 Base URL
```
https://yourdomain.com/api/
```

## 📌 Headers (Required for all requests)
```
Accept: application/json
Content-Type: application/json
Authorization: Bearer {your_token} (only for protected routes)
```

---

## 🔐 Endpoints

### 1. ✅ Register a New User
**POST** `/register`

#### Request Body
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "09123456789",
  "password": "Password@123",
  "password_confirmation": "Password@123",
  "want_news": true
}
```

#### Response
```json
{
  "user": { ... },
  "token": "your-auth-token"
}
```

---

### 2. 🔓 Login (by email or phone)
**POST** `/login`

#### Request Body
```json
{
  "identifier": "john@example.com", // OR phone number
  "password": "Password@123"
}
```

#### Response
```json
{
  "user": { ... },
  "token": "your-auth-token"
}
```

---

### 3. 🛠️ Edit User Profile
**POST** `/edit-user`  
🔒 **Requires token**

#### Request Body (any field is optional)
```json
{
  "name": "New Name",
  "email": "new@example.com",
  "phone": "0999888777",
  "password": "NewPass@123",
  "password_confirmation": "NewPass@123",
  "want_news": false
}
```

#### Response
```json
{
  "user": { ... }
}
```

---

### 4. 🚪 Logout
**GET** `/logout`  
🔒 **Requires token**

#### Response
```json
{
  "message": "You are logged out from all devices."
}
```

---

## ⚠️ Notes
- Passwords must include at least **one uppercase letter, one lowercase letter, one number, and one special character**.
- After login/registration, store the token and use it for all further authenticated requests.
- Rate limiting:
  - Max 3 registrations per minute per IP.
  - Max 5 login attempts per identifier.
