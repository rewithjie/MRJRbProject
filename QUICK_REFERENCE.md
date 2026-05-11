# Dashboard System - Quick Reference Guide

## System Architecture

```
┌──────────────────────────────────────────────────────────────────┐
│                      MRJR Management System                       │
│                                                                    │
│  ┌────────────────────────────────────────────────────────────┐  │
│  │ Route: GET /                                               │  │
│  │ View: resources/views/home.blade.php                       │  │
│  │ Purpose: Role selection and login portal                  │  │
│  └────────────────────────────────────────────────────────────┘  │
│                                                                    │
│  ┌────────────┬──────────────┬──────────────────────────────┐   │
│  │            │              │                              │   │
│  ▼            ▼              ▼                              ▼   │
│                                                                    │
│  STUDENT          TEACHER            ADMIN                       │
│  ────────         ───────            ─────                       │
│  Login Form       Login Form          Login Form                 │
│  ↓                ↓                   ↓                          │
│  Auth via         Auth via            Auth via                   │
│  Students         Teachers            Admins                     │
│  ↓                ↓                   ↓                          │
│  Dashboard        Dashboard           Dashboard                  │
│                                       + Management               │
│                                                                    │
└──────────────────────────────────────────────────────────────────┘
```

## File Location Reference

### Controllers at `app/Http/Controllers/`
```
TeacherController.php  ← Handles teacher auth & dashboard
AdminController.php    ← Handles admin auth, dashboard, & management
```

### Middleware at `app/Http/Middleware/`
```
TeacherAuth.php        ← Checks teacher session
AdminAuth.php          ← Checks admin session
```

### Models at `app/Models/`
```
Teacher.php            ← Teacher data model
Admin.php              ← Admin data model
Student.php            ← MODIFIED to include 'role'
```

### Views at `resources/views/`
```
auth/
  ├── teacher_login.blade.php
  └── admin_login.blade.php

teacher/
  ├── home.blade.php
  └── dashboard.blade.php

admin/
  ├── dashboard.blade.php
  ├── manage_students.blade.php
  ├── add_student.blade.php
  ├── manage_teachers.blade.php
  └── add_teacher.blade.php

home.blade.php         ← Main portal (role selection)
```

### Database at `database/migrations/`
```
2026_05_12_000001_create_teachers_table.php
2026_05_12_000002_create_admins_table.php
2026_05_12_000003_add_role_to_students_table.php
```

## Route Summary Table

| Method | Route | Name | Controller | Middleware |
|--------|-------|------|-----------|-----------|
| GET | `/` | home | home view | - |
| GET | `/student/login` | student.login.show | AuthController | - |
| POST | `/student/login` | student.login | AuthController | - |
| GET | `/student/home-dashboard` | student.home | AuthController | student.auth |
| GET | `/teacher/login` | teacher.login.show | TeacherController | - |
| POST | `/teacher/login` | teacher.login | TeacherController | - |
| GET | `/teacher/home` | teacher.home | TeacherController | teacher.auth |
| GET | `/admin/login` | admin.login.show | AdminController | - |
| POST | `/admin/login` | admin.login | AdminController | - |
| GET | `/admin/dashboard` | admin.dashboard | AdminController | admin.auth |
| GET | `/admin/students` | admin.manage.students | AdminController | admin.auth |
| GET | `/admin/students/add` | admin.add.student | AdminController | admin.auth |
| POST | `/admin/students/store` | admin.store.student | AdminController | admin.auth |
| DELETE | `/admin/students/{id}` | admin.delete.student | AdminController | admin.auth |
| GET | `/admin/teachers` | admin.manage.teachers | AdminController | admin.auth |
| GET | `/admin/teachers/add` | admin.add.teacher | AdminController | admin.auth |
| POST | `/admin/teachers/store` | admin.store.teacher | AdminController | admin.auth |
| DELETE | `/admin/teachers/{id}` | admin.delete.teacher | AdminController | admin.auth |

## Authentication Method Reference

### Student Authentication (Existing)
```php
// Login
$student = Student::where('email', $email)->first();
if (Hash::check($password, $student->password)) {
    Session::put('student_id', $student->id);
}

// Check Authentication
if (!Session::has('student_id')) {
    // Not authenticated
}

// Access: {{ Session::get('student_name') }}
```

### Teacher Authentication (New)
```php
// Login
$teacher = Teacher::where('email', $email)->first();
if (Hash::check($password, $teacher->password)) {
    Session::put('teacher_id', $teacher->id);
}

// Check Authentication
if (!Session::has('teacher_id')) {
    // Not authenticated
}

// Access: {{ Session::get('teacher_name') }}
```

### Admin Authentication (New)
```php
// Login
$admin = Admin::where('email', $email)->first();
if (Hash::check($password, $admin->password)) {
    Session::put('admin_id', $admin->id);
}

// Check Authentication
if (!Session::has('admin_id')) {
    // Not authenticated
}

// Access: {{ Session::get('admin_name') }}
```

## Key Controller Methods

### TeacherController
```
public function showLogin()              → GET /teacher/login → auth.teacher_login view
public function login()                  → POST /teacher/login → process credentials
public function homeDashboard()          → GET /teacher/home → teacher.home view
public function logout()                 → POST /teacher/logout → session clear
public function changePassword()         → POST /teacher/change-password → update password
```

### AdminController
```
public function showLogin()              → GET /admin/login → auth.admin_login view
public function login()                  → POST /admin/login → process credentials
public function dashboard()              → GET /admin/dashboard → admin.dashboard view
public function manageStudents()         → GET /admin/students → manage_students view
public function addStudentForm()         → GET /admin/students/add → add_student view
public function storeStudent()           → POST /admin/students/store → create student
public function deleteStudent()          → DELETE /admin/students/{id} → delete student
public function manageTeachers()         → GET /admin/teachers → manage_teachers view
public function addTeacherForm()         → GET /admin/teachers/add → add_teacher view
public function storeTeacher()           → POST /admin/teachers/store → create teacher
public function deleteTeacher()          → DELETE /admin/teachers/{id} → delete teacher
public function logout()                 → POST /admin/logout → session clear
public function changePassword()         → POST /admin/change-password → update password
```

## Middleware Usage

### StudentAuth Middleware
```php
// Location: app/Http/Middleware/StudentAuth.php
// Usage in routes: Route::middleware('student.auth')->group(...)
// Check: Session::has('student_id')
// Redirect: route('student.login.show')
```

### TeacherAuth Middleware
```php
// Location: app/Http/Middleware/TeacherAuth.php
// Usage in routes: Route::middleware('teacher.auth')->group(...)
// Check: Session::has('teacher_id')
// Redirect: route('teacher.login.show')
```

### AdminAuth Middleware
```php
// Location: app/Http/Middleware/AdminAuth.php
// Usage in routes: Route::middleware('admin.auth')->group(...)
// Check: Session::has('admin_id')
// Redirect: route('admin.login.show')
```

## Model Relationships

### Teacher Model
```php
protected $fillable = [
    'fname', 'mname', 'lname', 'email', 'contact_no',
    'password', 'specialty', 'department', 'is_active'
];

// Relationships: None defined (can be extended)
```

### Admin Model
```php
protected $fillable = [
    'name', 'email', 'password', 'role', 'is_active'
];

// Methods
public function isSuperAdmin()    → Check if super_admin role
public function isActive()        → Check if account is active
```

### Student Model (Updated)
```php
// Added to fillable array:
'role'  // Default: 'student'
```

## Common Code Snippets

### Check User Type in Blade
```blade
@if(Session::has('student_id'))
    {{-- Student dashboard --}}
@elseif(Session::has('teacher_id'))
    {{-- Teacher dashboard --}}
@elseif(Session::has('admin_id'))
    {{-- Admin dashboard --}}
@endif
```

### Get Current User Info
```blade
{{-- For Students --}}
{{ Session::get('student_name') }}
{{ Session::get('student_email') }}

{{-- For Teachers --}}
{{ Session::get('teacher_name') }}
{{ Session::get('teacher_email') }}

{{-- For Admins --}}
{{ Session::get('admin_name') }}
{{ Session::get('admin_email') }}
{{ Session::get('admin_role') }}
```

### Navigation Links
```blade
{{-- From Any Page, Get Back to Home --}}
<a href="{{ route('home') }}">Home</a>

{{-- Student Navigation --}}
<a href="{{ route('student.login.show') }}">Student Login</a>
<a href="{{ route('student.home') }}">Student Dashboard</a>
<a href="{{ route('student.logout') }}">Logout</a>

{{-- Teacher Navigation --}}
<a href="{{ route('teacher.login.show') }}">Teacher Login</a>
<a href="{{ route('teacher.home') }}">Teacher Dashboard</a>
<a href="{{ route('teacher.logout') }}">Logout</a>

{{-- Admin Navigation --}}
<a href="{{ route('admin.login.show') }}">Admin Login</a>
<a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
<a href="{{ route('admin.manage.students') }}">Manage Students</a>
<a href="{{ route('admin.manage.teachers') }}">Manage Teachers</a>
<a href="{{ route('admin.logout') }}">Logout</a>
```

### Form Validation Example
```php
$request->validate([
    'email' => 'required|email',
    'password' => 'required|min:6',
]);
```

### Password Hashing
```php
// Create user with password
$user = Teacher::create([
    'email' => 'teacher@example.com',
    'password' => 'PlainTextPassword', // Auto-hashed by mutator
]);

// Check password
Hash::check('PlainTextPassword', $user->password) // Returns true
```

## Tables Column Reference

### Teachers Table
| Column | Type | Notes |
|--------|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| fname | VARCHAR | First Name |
| mname | VARCHAR | Middle Name |
| lname | VARCHAR | Last Name |
| email | VARCHAR | Unique email |
| contact_no | VARCHAR | Phone number |
| password | VARCHAR | Hashed password |
| specialty | VARCHAR | Nullable |
| department | VARCHAR | Nullable |
| is_active | BOOLEAN | Default: true |
| created_at | TIMESTAMP | Auto-set |
| updated_at | TIMESTAMP | Auto-set |

### Admins Table
| Column | Type | Notes |
|--------|------|-------|
| id | BIGINT UNSIGNED | Primary Key |
| name | VARCHAR | Full name |
| email | VARCHAR | Unique email |
| password | VARCHAR | Hashed password |
| role | VARCHAR | admin or super_admin |
| is_active | BOOLEAN | Default: true |
| created_at | TIMESTAMP | Auto-set |
| updated_at | TIMESTAMP | Auto-set |

### Students Table (Added Column)
| Column | Type | Notes |
|--------|------|-------|
| role | VARCHAR | Default: 'student' |

## Error Handling

### Invalid Login
```php
// Teacher login with wrong credentials
→ Redirects to: route('teacher.login.show')
→ Message: "Invalid email or password"
→ Logged: Failed attempt with email and IP
```

### Inactive Account
```php
// Login attempt with inactive account
→ Redirects to: route('teacher.login.show')
→ Message: "Your account has been deactivated"
→ Logged: Inactive account attempt
```

### Session Expired
```php
// Access protected route with expired session
→ Redirects to: route('*.login.show')
→ Message: "Session expired. Please login again."
```

## Logging Reference

Logs stored in: `storage/logs/laravel.log`

```
[2026-05-12 10:30:45] local.INFO: Teacher login successful {"teacher_id":1,"email":"john.doe@mrjr.edu"}
[2026-05-12 10:31:20] local.INFO: Student created by admin {"student_id":5,"admin_id":1}
[2026-05-12 10:32:00] local.INFO: Teacher password changed {"teacher_id":1,"timestamp":"2026-05-12 10:32:00"}
[2026-05-12 10:32:30] local.INFO: Teacher logout {"teacher_id":1}
```

## Testing Checklist

- [ ] Student login works
- [ ] Student can change password
- [ ] Student logout works
- [ ] Teacher login works
- [ ] Teacher can change password
- [ ] Teacher logout works
- [ ] Admin login works
- [ ] Admin can view all students
- [ ] Admin can add new student
- [ ] Admin can delete student
- [ ] Admin can view all teachers
- [ ] Admin can add new teacher
- [ ] Admin can delete teacher
- [ ] Admin can change password
- [ ] Admin logout works
- [ ] Non-authenticated users redirected to login
- [ ] Role-based redirects work correctly
- [ ] Pagination works on admin lists
- [ ] Form validation works
- [ ] Error messages display properly

---

**Quick Reference Version:** 1.0
**Last Updated:** May 12, 2026
**Author:** MRJR Development Team
