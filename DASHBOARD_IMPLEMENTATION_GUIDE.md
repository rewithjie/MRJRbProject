# MRJR Student, Teacher & Admin Dashboard Implementation Guide

## Overview
This document outlines the complete implementation of Student, Teacher, and Admin dashboards for the MRJR Laravel project. The system provides role-based access control with separate authentication and dashboards for each user type.

---

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                    MRJR Management System                    │
│                   (Home Page / Login Portal)                 │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │   STUDENT    │  │   TEACHER    │  │    ADMIN     │     │
│  │   PORTAL     │  │   PORTAL     │  │   PORTAL     │     │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤     │
│  │ - Login      │  │ - Login      │  │ - Login      │     │
│  │ - Dashboard  │  │ - Dashboard  │  │ - Dashboard  │     │
│  │ - Courses    │  │ - Courses    │  │ - Manage     │     │
│  │ - Grades     │  │ - Students   │  │   Students   │     │
│  │ - Profile    │  │ - Profile    │  │ - Manage     │     │
│  │ - Settings   │  │ - Settings   │  │   Teachers   │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

---

## Files Created

### 1. **Migrations**
- `database/migrations/2026_05_12_000001_create_teachers_table.php` - Teachers table
- `database/migrations/2026_05_12_000002_create_admins_table.php` - Admins table
- `database/migrations/2026_05_12_000003_add_role_to_students_table.php` - Add role to students

### 2. **Models**
- `app/Models/Teacher.php` - Teacher model with password hashing
- `app/Models/Admin.php` - Admin model with role support

### 3. **Controllers**
- `app/Http/Controllers/TeacherController.php` - Teacher authentication and dashboard
- `app/Http/Controllers/AdminController.php` - Admin authentication, dashboard, and management

### 4. **Middleware**
- `app/Http/Middleware/TeacherAuth.php` - Teacher authentication middleware
- `app/Http/Middleware/AdminAuth.php` - Admin authentication middleware

### 5. **Views**

#### Authentication Views
- `resources/views/auth/teacher_login.blade.php` - Teacher login form
- `resources/views/auth/admin_login.blade.php` - Admin login form
- `resources/views/home.blade.php` - Role selection home page

#### Teacher Views
- `resources/views/teacher/home.blade.php` - Teacher dashboard
- `resources/views/teacher/dashboard.blade.php` - Teacher detail dashboard

#### Admin Views
- `resources/views/admin/dashboard.blade.php` - Admin main dashboard
- `resources/views/admin/manage_students.blade.php` - Student management list
- `resources/views/admin/add_student.blade.php` - Add new student form
- `resources/views/admin/manage_teachers.blade.php` - Teacher management list
- `resources/views/admin/add_teacher.blade.php` - Add new teacher form

### 6. **Configuration**
- `bootstrap/app.php` - Middleware registration
- `routes/web.php` - New routes added

### 7. **Modified Files**
- `app/Models/Student.php` - Added 'role' to fillable array

---

## Database Schema

### Teachers Table
```sql
CREATE TABLE teachers (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    fname VARCHAR(255) NOT NULL,
    mname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    contact_no VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    specialty VARCHAR(255) NULLABLE,
    department VARCHAR(255) NULLABLE,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Admins Table
```sql
CREATE TABLE admins (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'admin',  -- 'admin' or 'super_admin'
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Students Table (Modified)
```sql
ALTER TABLE students ADD COLUMN role VARCHAR(50) DEFAULT 'student' AFTER password;
```

---

## Routes Map

### Public Routes
- `GET /` - Home page with role selection (`home`)
- `GET /home` - Alternate home route

### Student Routes
- `GET /student/login` - Student login page (`student.login.show`)
- `POST /student/login` - Process student login (`student.login`)
- `GET /student/dashboard` - Student dashboard (protected by `student.auth`) (`student.dashboard`)
- `GET /student/home-dashboard` - Student home dashboard (`student.home`)
- `POST /student/change-password` - Change student password (`student.password.update`)
- `POST /student/logout` - Student logout (`student.logout`)

### Teacher Routes
- `GET /teacher/login` - Teacher login page (`teacher.login.show`)
- `POST /teacher/login` - Process teacher login (`teacher.login`)
- `GET /teacher/dashboard` - Teacher dashboard (protected by `teacher.auth`) (`teacher.dashboard`)
- `GET /teacher/home` - Teacher home dashboard (`teacher.home`)
- `POST /teacher/change-password` - Change teacher password (`teacher.password.update`)
- `POST /teacher/logout` - Teacher logout (`teacher.logout`)

### Admin Routes (all protected by `admin.auth` middleware)
- `GET /admin/login` - Admin login page (`admin.login.show`)
- `POST /admin/login` - Process admin login (`admin.login`)
- `GET /admin/dashboard` - Main admin dashboard (`admin.dashboard`)
- **Student Management:**
  - `GET /admin/students` - View all students (`admin.manage.students`)
  - `GET /admin/students/add` - Add student form (`admin.add.student`)
  - `POST /admin/students/store` - Store new student (`admin.store.student`)
  - `DELETE /admin/students/{id}` - Delete student (`admin.delete.student`)
- **Teacher Management:**
  - `GET /admin/teachers` - View all teachers (`admin.manage.teachers`)
  - `GET /admin/teachers/add` - Add teacher form (`admin.add.teacher`)
  - `POST /admin/teachers/store` - Store new teacher (`admin.store.teacher`)
  - `DELETE /admin/teachers/{id}` - Delete teacher (`admin.delete.teacher`)
- **Account:**
  - `POST /admin/change-password` - Change admin password (`admin.password.update`)
  - `POST /admin/logout` - Admin logout (`admin.logout`)

---

## Authentication Flow

### Student Authentication (Existing)
1. User visits `/student/login`
2. Enters email and password
3. System verifies credentials against `students` table
4. On success: Session stores `student_id`, `student_email`, `student_name`
5. User redirected to `/student/home`
6. `student.auth` middleware protects routes

### Teacher Authentication (New)
1. User visits `/teacher/login`
2. Enters email and password
3. System verifies credentials against `teachers` table
4. On success: Session stores `teacher_id`, `teacher_email`, `teacher_name`
5. User redirected to `/teacher/home`
6. `teacher.auth` middleware protects routes

### Admin Authentication (New)
1. User visits `/admin/login`
2. Enters email and password
3. System verifies credentials against `admins` table
4. On success: Session stores `admin_id`, `admin_email`, `admin_name`, `admin_role`
5. User redirected to `/admin/dashboard`
6. `admin.auth` middleware protects routes

---

## Key Features

### Student Dashboard
- View profile information
- Change password
- Access courses and grades
- View important announcements

### Teacher Dashboard
- View profile and academic information
- Manage courses and students
- Track assignments and submissions
- Change account password
- View department information

### Admin Dashboard
- **Dashboard Overview:**
  - Total students count
  - Total teachers count
  - Active students count
  - Active teachers count

- **Student Management:**
  - View all students with pagination
  - Add new students
  - Delete students
  - Bulk operations (expandable)

- **Teacher Management:**
  - View all teachers with pagination
  - Add new teachers
  - Delete teachers
  - Manage active/inactive status

- **Account Management:**
  - Change admin password
  - View admin profile
  - Logout

---

## Setup Instructions

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will create:
- `teachers` table
- `admins` table
- Add `role` column to `students` table

### Step 2: Seed Initial Admin (Optional)
Create an admin seeder or manually insert using SQL:
```sql
INSERT INTO admins (name, email, password, role, is_active, created_at, updated_at)
VALUES ('Super Admin', 'admin@mrjr.edu', '$2y$12$...', 'super_admin', 1, NOW(), NOW());
```

*Note: Password should be hashed using `Hash::make('password')`*

### Step 3: Test the System

1. **Student Login:**
   - Go to `http://localhost:8000/`
   - Click "Student Login"
   - Use existing student credentials

2. **Teacher Login:**
   - Go to `http://localhost:8000/teacher/login`
   - Use teacher credentials (created by admin)

3. **Admin Login:**
   - Go to `http://localhost:8000/admin/login`
   - Use admin credentials (seeded or manually created)

---

## Important Controller Methods

### TeacherController
```php
public function login(Request $request)          // Process teacher login
public function dashboard()                      // Show teacher dashboard
public function homeDashboard()                  // Show teacher home
public function changePassword(Request $request) // Update password
public function logout()                         // Logout teacher
```

### AdminController
```php
public function login(Request $request)          // Process admin login
public function dashboard()                      // Show admin dashboard
public function manageStudents()                 // List students with pagination
public function addStudentForm()                 // Show add student form
public function storeStudent(Request $request)   // Create new student
public function deleteStudent($id)               // Delete student
public function manageTeachers()                 // List teachers with pagination
public function addTeacherForm()                 // Show add teacher form
public function storeTeacher(Request $request)   // Create new teacher
public function deleteTeacher($id)               // Delete teacher
public function changePassword(Request $request) // Update admin password
public function logout()                         // Logout admin
```

---

## Validation Rules

### Student Registration (by Admin)
```
fname       : required|min:2
mname       : required|min:2
lname       : required|min:2
email       : required|email|unique:students,email
contact_no  : required|digits:11
password    : required|min:8|confirmed
degree_id   : required|exists:degrees,id
```

### Teacher Registration (by Admin)
```
fname       : required|min:2
mname       : required|min:2
lname       : required|min:2
email       : required|email|unique:teachers,email
contact_no  : required|digits:11
password    : required|min:8|confirmed
specialty   : nullable|min:2
department  : required|min:2
```

### Login (All Roles)
```
email       : required|email
password    : required|min:6
```

### Password Change (All Roles)
```
old_password                : required|min:6
new_password                : required|min:8|confirmed
new_password_confirmation   : required
```

---

## Session Variables

### Student Session
```php
Session::put('student_id', $student->id);
Session::put('student_email', $student->email);
Session::put('student_name', $student->fname . ' ' . $student->lname);
```

### Teacher Session
```php
Session::put('teacher_id', $teacher->id);
Session::put('teacher_email', $teacher->email);
Session::put('teacher_name', $teacher->fname . ' ' . $teacher->lname);
```

### Admin Session
```php
Session::put('admin_id', $admin->id);
Session::put('admin_email', $admin->email);
Session::put('admin_name', $admin->name);
Session::put('admin_role', $admin->role); // 'admin' or 'super_admin'
```

---

## Logging

All critical operations are logged:
- Successful and failed logins
- Password changes
- Admin creates student/teacher
- Admin deletes student/teacher
- Logouts

Logs are stored in `storage/logs/laravel.log`

---

## Security Features

1. **Password Hashing:** All passwords are hashed using Laravel's `Hash::make()`
2. **Session Management:** Session timeout on logout
3. **Middleware Protection:** Route middleware ensures only authenticated users access protected routes
4. **CSRF Protection:** All forms include CSRF tokens
5. **Input Validation:** All inputs validated before processing
6. **SQL Injection Prevention:** Eloquent ORM prevents SQL injection
7. **XSS Prevention:** Blade templating escapes output by default

---

## Troubleshooting

### Issue: "Middleware not registered"
**Solution:** Make sure you updated `bootstrap/app.php` with the middleware aliases:
```php
'teacher.auth' => \App\Http\Middleware\TeacherAuth::class,
'admin.auth' => \App\Http\Middleware\AdminAuth::class,
```

### Issue: "Table not found"
**Solution:** Run migrations:
```bash
php artisan migrate
```

### Issue: "Session not persisting"
**Solution:** Ensure `APP_DEBUG=true` in `.env` and session driver is set to `'session' => env('SESSION_DRIVER', 'file'),`

### Issue: "Login redirects to login page again"
**Solution:** Check that credentials exist in respective table and check `.env` file is properly configured.

---

## Future Enhancements

1. **Role-Based Permissions:** Add fine-grained permission system
2. **Email Notifications:** Send email on account creation
3. **Two-Factor Authentication:** Add 2FA for enhanced security
4. **Audit Trail:** Track all admin actions
5. **Batch Upload:** Import students/teachers via CSV
6. **API Integration:** Build REST API for mobile apps
7. **Advanced Analytics:** Dashboard with charts and graphs
8. **Course Assignment:** Allow admins to assign courses to teachers
9. **Grade Management:** Full grade tracking system
10. **Attendance Tracking:** Monitor student attendance

---

## Support & Contact

For issues or questions:
- Email: admin@mrjr.edu
- Phone: +63 (0) XXX-XXXX
- Documentation: Refer to Laravel official docs at https://laravel.com

---

**Last Updated:** May 12, 2026
**Version:** 1.0
