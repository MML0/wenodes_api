
# 📄 Laravel AuthController API Documentation

## 🌐 Base URL

```
https://api.wenodes.org/api/
```

---

## 📋 Common Headers

| Header           | Value                          |
|------------------|--------------------------------|
| Accept           | application/json               |
| Authorization    | Bearer {token} *(if required)* |

---

## 🔐 1. Register a New User

- **Endpoint:** `POST /api/register`  
- **Auth Required:** ❌  
- **Rate Limited:** ✅ (3 attempts per minute per IP)

### ✅ Request Body

```json
{
  "name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "phone": "09123456789",
  "password": "MyPassword@1",
  "password_confirmation": "MyPassword@1",
  "want_news": true
}
```

### 🔒 Validation Rules

- `name`: required, string, max 255
- `email`: required, valid, unique
- `phone`: required, string, max 15, unique
- `password`: required, confirmed, min 8, must contain:
  - Uppercase
  - Lowercase
  - Number
  - Special character
- `want_news`: optional, boolean

### 📤 Response Example (201 Created)

```json
{
  "user": {
    "id": 1,
    "name": "John",
    "last_name": "Doe",
    "email": "john@example.com",
    "phone": "09123456789",
    "want_news": true
  },
  "token": "eyJ0eXAiOiJKV1QiLCJh..."
}
```

---

## 🔓 2. Login

- **Endpoint:** `POST /api/login`  
- **Auth Required:** ❌  
- **Rate Limited:** ✅ (5 attempts per identifier)

### ✅ Request Body

```json
{
  "identifier": "john@example.com", // or phone number
  "password": "MyPassword@1"
}
```

### 🔒 Validation Rules

- `identifier`: required, string (email or phone)
- `password`: required, min 8, with uppercase, lowercase, number, special character

### 📤 Response Example (200 OK)

```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    ...
  },
  "token": "eyJ0eXAiOiJKV1QiLCJh..."
}
```

### ❌ Error Example (401 Unauthorized)

```json
{
  "message": "Invalid credentials"
}
```

---

## ✏️ 3. Edit User Profile

- **Endpoint:** `POST /api/edit-user`  
- **Auth Required:** ✅ (Bearer Token)  
- **Method:** POST

### ✅ Request Body (All fields optional)

```json
{
  "name": "John Updated",
  "last_name": "Doe",
  "email": "new@example.com",
  "phone": "09999999999",
  "password": "NewPass@123",
  "password_confirmation": "NewPass@123",
  "want_news": false
}
```

### 🔒 Validation Rules

- All fields optional
- Same password/email/phone rules as registration
- `email` and `phone` must be unique except current user

### 📤 Response Example (200 OK)

```json
{
  "user": {
    "id": 1,
    "name": "John Updated",
    "email": "new@example.com",
    "phone": "09999999999",
    "want_news": false
  }
}
```

---

## 🚪 4. Logout (All Devices)

- **Endpoint:** `POST /api/logout`  
- **Auth Required:** ✅ (Bearer Token)  
- **Method:** POST

### 📤 Response Example (200 OK)

```json
{
  "message": "You are logged out from all devices."
}
```

---

---

## 🚪 5. see user data (All Devices)

- **Endpoint:** `GET /api/user`  
- **Auth Required:** ✅ (Bearer Token)  
- **Method:** GET

### 📤 Response Example (200 OK)

```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    ...
  }
}
```

---

## 🛡️ Notes

- All input and output is in `application/json`.
- Use `Authorization: Bearer {token}` in headers after login/registration.
- Token is generated using Laravel Sanctum.
- Registration and login have rate limits to prevent abuse.
- Login accepts both `email` or `phone` as identifier.
- All password fields require:
  - Minimum 8 characters
  - At least 1 uppercase letter
  - At least 1 lowercase letter
  - At least 1 number
  - At least 1 special character

---

## 🧪 Test Your API

You can test using [Postman](https://www.postman.com/) or other REST tools.

### 🔁 Flow:

1. `POST /api/register` – Register a new user.
2. `POST /api/login` – Login and save token.
3. Use `Authorization: Bearer {token}` header.
4. `GET /api/user` – see user info.
5. `POST /api/edit-user` – Update user info.
6. `POST /api/logout` – Logout user.

---

## ✅ Summary

| Action        | Endpoint         | Method | Auth Required | Rate Limited     |
|---------------|------------------|--------|----------------|-----------------|
| Register      | /api/register    | POST   | ❌             | ✅ (3/min/IP)  |
| Login         | /api/login       | POST   | ❌             | ✅ (5/min)     |
| Edit Profile  | /api/edit-user   | POST   | ✅             | ❌             |
| Logout        | /api/logout      | POST   | ✅             | ❌             |
| see user data | /api/user        | GET    | ✅             | ❌             |

---

© 2025 — Your API Service
