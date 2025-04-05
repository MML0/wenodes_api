<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:k


For more information on the authentication API, please refer to the [Laravel Authentication API Documentation](laravel_auth_api_doc.md).


## 📘 Authentication API Guide

1. ✅ **Register a New User**  
   **POST** `/register`  

2. 🔓 **Login (by email or phone)**  
   **POST** `/login`  
   **Request Body**  

3. 🛠️ **Edit User Profile**  
   **POST** `/edit-user`  
   🔒 **Requires token**  
   **Request Body (any field is optional)**   

4. 🚪 **Logout**  
   **GET** `/logout`  
   🔒 **Requires token**  

5. **see user data**
    **GET** `/user`