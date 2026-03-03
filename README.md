CampusFeedback is a dynamic feedback management system built using Core PHP, MySQL, JWT Authentication, and Bootstrap 5.

It allows administrators to:

Create multiple feedback forms

Manage dynamic fields

Activate only one form at a time

Collect and manage student responses

Students can submit feedback through the currently active form.

✨ Key Features
👨‍💼 Admin Panel

🔐 Secure JWT Authentication (HttpOnly cookies)

📄 Create & Manage Multiple Forms

⚡ Activate only one form at a time

➕ Add Dynamic Fields:

Text

Textarea

Radio (with options)

Checkbox (with options)

✏️ Edit / Delete Fields

🗂 Manage All Forms

📊 View Submissions

📱 Fully Responsive Admin Layout

🎓 Student Side

Automatically loads active form

Dynamic form rendering

Anonymous submission system

Supports multiple field types

Clean & responsive UI

🏗 Architecture
CampusFeedback/
│
├── config/
│   └── Database.php
│
├── api/
│   ├── login.php
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
│   ├── AuthMiddleware.php
│   └── JWTService.php
│
├── views/
│   ├── admin/
│   │   ├── layout/
│   │   │   ├── header.php
│   │   │   ├── sidebar.php
│   │   │   └── footer.php
│   │   ├── dashboard.php
│   │   ├── manage_forms.php
│   │   ├── manage_fields.php
│   │   └── login.php
│   │
│   └── site/
│       └── form.php
│
├── assets/
│   └── css/style.css
│
├── vendor/
└── composer.json
🔐 Authentication Flow

Admin logs in

JWT token generated

Token stored in HttpOnly cookie

Middleware validates token on protected routes

Unauthorized users redirected to login

🗄 Database Schema
📝 forms
Column	Type
id	INT (PK)
title	VARCHAR
description	TEXT
is_active	TINYINT(1)
created_at	TIMESTAMP
📌 fields
Column	Type
id	INT (PK)
form_id	INT
label	VARCHAR
type	VARCHAR
options	TEXT
📥 submissions
Column	Type
id	INT
form_id	INT
submitted_at	TIMESTAMP
🗂 submission_answers
Column	Type
id	INT
submission_id	INT
field_id	INT
answer	TEXT
⚙ Installation Guide
1️⃣ Clone Repository
git clone https://github.com/yourusername/CampusFeedback.git
2️⃣ Install Dependencies
composer install
3️⃣ Configure Database

Update credentials inside:

/config/Database.php
4️⃣ Import Tables

Run SQL scripts to create required tables.

5️⃣ Run Project

Place project inside:

htdocs/ (XAMPP)

Open:

http://localhost/CampusFeedback/views/admin/login.php
🎯 System Workflow
What is this?
🛡 Security Features

JWT Authentication

HttpOnly Cookie Storage

Middleware Protected Routes

PDO Prepared Statements

Input Validation

Controlled Form Activation

📸 Screenshots

Add screenshots here

/screenshots/dashboard.png
/screenshots/manage-forms.png
/screenshots/student-form.png
🚀 Future Improvements

📊 Analytics Dashboard

📥 CSV Export

🗓 Form Scheduling (Start/End Date)

👥 Role-Based Access

🔔 Email Notifications

🎨 Drag & Drop Field Builder

👨‍💻 Author

Nitish Goel
Backend Developer (PHP | CodeIgniter | Laravel)

⭐ Why This Project Is Strong

Dynamic Form Builder

Secure JWT Implementation

Clean Admin Architecture

Responsive Layout

API-Based Backend Structure

Real-world Project Design

📄 License

This project is developed for learning and educational purposes.
