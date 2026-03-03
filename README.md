# 🎓 CampusFeedback

A Dynamic Feedback Management System built using **Core PHP, MySQL, JWT
Authentication, and Bootstrap 5**.

This system allows admins to create feedback forms and students to
submit responses to the currently active form.

------------------------------------------------------------------------

## 🚀 Features

### 👨‍💼 Admin Panel

-   Secure JWT Authentication (HttpOnly Cookie)
-   Create multiple feedback forms
-   Only one form can be active at a time
-   Add dynamic fields:
    -   Text
    -   Textarea
    -   Radio (with options)
    -   Checkbox (with options)
-   Edit / Delete fields
-   Manage forms
-   Responsive admin dashboard

### 🎓 Student Side

-   Automatically loads active form
-   Dynamic form rendering
-   Anonymous feedback submission
-   Stores responses in database

------------------------------------------------------------------------

## 🛠 Tech Stack

-   PHP (Core PHP, OOP)
-   MySQL
-   Bootstrap 5
-   Firebase PHP-JWT
-   PDO (Prepared Statements)

------------------------------------------------------------------------

## 📂 Project Structure

CampusFeedback/ 
│ 
├── config/ 
│   └── Database.php 
│ 
├── api/ 
│   ├──login.php 
│   ├── create_form.php 
│   ├── add_field.php 
│   ├── get_forms.php
│   ├── get_fields.php 
│   ├── update_field.php 
│   ├── delete_field.php 
│   ├── set_active_form.php 
│   └── submit.php 
│   
├── helper/ 
│   ├──AuthMiddleware.php 
│   └── JWTService.php 
│
├── views/ 
│   ├── admin/
│   └──site/ 
│
├── assets/ 
│   └── css/ 
│
├── vendor/ 
└── composer.json

------------------------------------------------------------------------

## 🗄 Database Tables

### forms

-   id
-   title
-   description
-   is_active
-   created_at

### fields

-   id
-   form_id
-   label
-   type
-   options

### submissions

-   id
-   form_id
-   submitted_at

### submission_answers

-   id
-   submission_id
-   field_id
-   answer

------------------------------------------------------------------------

## ⚙ Installation

### 1. Clone Repository

git clone https://github.com/yourusername/CampusFeedback.git

### 2. Install Dependencies

composer install

### 3. Configure Database

Update database credentials inside:

/config/Database.php

### 4. Import Database Tables

Create required tables in MySQL.

### 5. Run Project

Place the project inside:

htdocs/ (for XAMPP)

Open in browser:

http://localhost/CampusFeedback/views/admin/login.php

------------------------------------------------------------------------

## 🔐 Authentication Flow

1.  Admin logs in
2.  JWT token is generated
3.  Token stored in HttpOnly cookie
4.  Middleware validates token on protected routes

------------------------------------------------------------------------

## 🎯 How It Works

1.  Admin creates form\
2.  Admin adds fields\
3.  Admin sets one form as active\
4.  Student opens form page\
5.  Student submits feedback\
6.  Data stored in database

------------------------------------------------------------------------

## 🛡 Security

-   JWT Authentication
-   HttpOnly Cookie
-   Middleware Protection
-   PDO Prepared Statements
-   Input Validation

------------------------------------------------------------------------

## 👨‍💻 Author

Nitish Goel\
Backend Developer (PHP \| CodeIgniter \| Laravel)

------------------------------------------------------------------------

## 📄 License

This project is for educational and learning purposes.
