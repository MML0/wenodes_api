# 📄 Laravel  API Documentation

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
- **Rate Limited:** ✅ (3 attempts per 10 minutes per IP)

### ✅ Request Body

```json
{
  "name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "phone": "09123456789",
  "password": "MyPassword@1",
  "password_confirmation": "MyPassword@1",
  "want_news": true,
  "want_pro_membership": false
}
```

### 🔒 Validation Rules

- `name`: required, string, max 255
- `last_name`: optional, string, max 255
- `email`: required, valid, unique
- `phone`: required, string, max 15, unique
- `password`: required, confirmed, min 8, must contain:
  - At least 1 uppercase letter
  - At least 1 lowercase letter
  - At least 1 number
  - At least 1 special character
- `want_news`: optional, boolean
- `bio`: optional, string (nullable) - User's biography
- `want_pro_membership`: optional, boolean - Indicates if the user wants pro membership
- `photo`: optional, string (nullable) - URL to the user's profile image

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

## 🔒 2. User Model Structure

### User Table Structure

The `users` table contains the following fields:

| Field                     | Type        | Description                                      |
|---------------------------|-------------|--------------------------------------------------|
| `id`                      | Integer     | Primary key for the user                         |
| `name`                    | String      | User's first name                                |
| `last_name`               | String      | User's last name (nullable)                      |
| `bio`                     | String      | User's biography (nullable)                      |
| `type`                    | Enum        | User role (admin, editor, pro_member, team_member, user) |
| `email`                   | String      | User's email (unique)                            |
| `email_verified_at`       | Timestamp   | Timestamp for email verification (nullable)      |
| `password`                | String      | User's password                                  |
| `want_news`               | Boolean     | Indicates if the user wants to receive news      |
| `want_pro_membership`     | Boolean     | Indicates if the user wants pro membership       |
| `phone`                   | String      | User's phone number (nullable)                   |
| `photo`                   | String      | URL to the user's profile image (nullable)       |
| `remember_token`          | String      | Token for "remember me" functionality            |
| `created_at`              | Timestamp   | Timestamp for when the user was created          |
| `updated_at`              | Timestamp   | Timestamp for when the user was last updated     |

---

## 🔓 3. Login

- **Endpoint:** `POST /api/login`  
- **Auth Required:** ❌  
- **Rate Limited:** ✅ (5 attempts per identifier per 10 min)

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

## ✏️ 4. Edit User Profile

- **Endpoint:** `POST /api/edit_user`  
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

## 🚪 5. Logout (All Devices)

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

## 🚪 6. See User Data (All Devices)

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

## 📸 7. Update User Photo

- **Endpoint:** `POST /api/user/photo` or `POST /api/users/{user}/photo`  
- **Auth Required:** ✅ (Bearer Token)  
- **Method:** POST

### ✅ Request Body

```json
{
  "photo": "file" // The photo file to upload
}
```

### 🔒 Validation Rules

- `photo`: required, image, max 2MB

### 📤 Response Example (200 OK)

```json
{
  "message": "Photo uploaded successfully.",
  "photo_url": "/storage/users/user_1_photo.jpg"
}
```

### ❌ Error Example (400 Bad Request)

```json
{
  "message": "No photo uploaded."
}
```

---

## 🎨 8. Get All Works

- **Endpoint:** `GET /api/works`  
- **Auth Required:** ❌  
- **Method:** GET

### 📤 Response Example (200 OK)

```json
[
  {
    "id": 1,
    "title_fa": "عنوان کار",
    "title_en": "Work Title",
    "description_fa": "توضیحات کار",
    "description_en": "Work Description",
    "cover_image": "path/to/image.jpg",
    ...
  },
  ...
]
```

---

## 👥 9. Get All Team Members

- **Endpoint:** `GET /api/team-members`  
- **Auth Required:** ❌  
- **Method:** GET

### 📤 Response Example (200 OK)

```json
[
  {
    "id": 1,
    "user_id": 1,
    "role": "artist",
    "profile_image_url": "https://via.placeholder.com/150",
    "name_fa": "هنرمند اول",
    "name_en": "First Artist",
    "bio_fa": "این هنرمند در زمینه هنرهای تجسمی فعالیت می‌کند.",
    "bio_en": "This artist works in the field of visual arts.",
    ...
  },
  ...
]
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
5. `POST /api/edit_user` – Update user info.
6. `POST /api/logout` – Logout user.
7. `GET /api/works` – Retrieve all works.
8. `GET /api/team-members` – Retrieve all team members.
9. `POST /api/user/photo` or `POST /api/users/{user}/photo` – Update user photo.

---

## ✅ Summary

| Action        | Endpoint         | Method | Auth Required | Rate Limited     |
|---------------|------------------|--------|----------------|-----------------|
| Register      | /api/register    | POST   | ❌             | ✅ (3/10min/IP)|
| Login         | /api/login       | POST   | ❌             | ✅ (5/10min)   |
| Edit Profile  | /api/edit_user   | POST   | ✅             | ❌             |
| Logout        | /api/logout      | POST   | ✅             | ❌             |
| See User Data | /api/user        | GET    | ✅             | ❌             |
| Update Photo  | /api/user/photo or /api/users/{user}/photo | POST | ✅ | ❌ |
| Get All Works | /api/works       | GET    | ❌             | ❌             |
| Get Team Members | /api/team-members | GET | ❌            | ❌             |

---

© 2025 — Your API Service
