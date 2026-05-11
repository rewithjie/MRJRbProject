# Quick Setup Checklist - Student, Teacher & Admin Dashboards

## Pre-Implementation Checklist

### Files to Verify Exist
- [x] `app/Http/Controllers/TeacherController.php`
- [x] `app/Http/Controllers/AdminController.php`
- [x] `app/Http/Middleware/TeacherAuth.php`
- [x] `app/Http/Middleware/AdminAuth.php`
- [x] `app/Models/Teacher.php`
- [x] `app/Models/Admin.php`
- [x] `database/migrations/2026_05_12_000001_create_teachers_table.php`
- [x] `database/migrations/2026_05_12_000002_create_admins_table.php`
- [x] `database/migrations/2026_05_12_000003_add_role_to_students_table.php`

## Views to Verify Exist
- [x] `resources/views/auth/teacher_login.blade.php`
- [x] `resources/views/auth/admin_login.blade.php`
- [x] `resources/views/teacher/home.blade.php`
- [x] `resources/views/teacher/dashboard.blade.php`
- [x] `resources/views/admin/dashboard.blade.php`
- [x] `resources/views/admin/manage_students.blade.php`
- [x] `resources/views/admin/add_student.blade.php`
- [x] `resources/views/admin/manage_teachers.blade.php`
- [x] `resources/views/admin/add_teacher.blade.php`
- [x] `resources/views/home.blade.php`

## Configuration Updates Made
- [x] Updated `bootstrap/app.php` with middleware aliases
- [x] Added routes to `routes/web.php`
- [x] Updated `app/Models/Student.php` with 'role' field

## Step-by-Step Setup Instructions

### Step 1: Database Migrations
Run the following command in terminal:
```bash
php artisan migrate
```

This creates:
- `teachers` table
- `admins` table
- Adds `role` column to `students` table

### Step 2: Create Initial Admin User

Option A - Using Tinker (Interactive):
```bash
php artisan tinker
```

Then run:
```php
use App\Models\Admin;
Admin::create([
    'name' => 'Admin User',
    'email' => 'admin@mrjr.edu',
    'password' => 'SecurePassword123',
    'role' => 'super_admin',
    'is_active' => true
]);
```

Option B - Using SQL directly:
```sql
INSERT INTO admins (name, email, password, role, is_active, created_at, updated_at) 
VALUES (
    'Admin User',
    'admin@mrjr.edu',
    '$2y$12$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86AGR.f3u8e',
    'super_admin',
    1,
    NOW(),
    NOW()
);
```
*Note: Password hash is for "password". Use `Hash::make('password')` in PHP to generate actual hash.*

### Step 3: Create Sample Teachers (Optional)

Using Tinker:
```bash
php artisan tinker
```

```php
use App\Models\Teacher;
Teacher::create([
    'fname' => 'John',
    'mname' => 'Michael',
    'lname' => 'Doe',
    'email' => 'john.doe@mrjr.edu',
    'contact_no' => '09123456789',
    'password' => 'TeacherPass123',
    'department' => 'Computer Science',
    'specialty' => 'Web Development',
    'is_active' => true
]);
```

### Step 4: Test the System

1. **Start Local Server:**
   ```bash
   php artisan serve
   ```

2. **Access Home Page:**
   - Open `http://localhost:8000/`
   - Should display role selection page

3. **Test Student Login:**
   - Click "Student Login"
   - Use existing student credentials
   - Should redirect to student dashboard

4. **Test Teacher Login:**
   - Click "Teacher Login"
   - Use teacher credentials (john.doe@mrjr.edu / TeacherPass123)
   - Should redirect to teacher dashboard

5. **Test Admin Login:**
   - Click "Admin Login"
   - Use admin credentials (admin@mrjr.edu / password)
   - Should redirect to admin dashboard

### Step 5: Admin Dashboard Operations

1. **Add New Student:**
   - Go to Admin Dashboard
   - Click "Add New Student"
   - Fill form with student details
   - Click "Add Student"

2. **Add New Teacher:**
   - Go to Admin Dashboard
   - Click "Add New Teacher"
   - Fill form with teacher details
   - Click "Add Teacher"

3. **View All Students:**
   - Click "View All Students"
   - See paginated list with delete option

4. **View All Teachers:**
   - Click "View All Teachers"
   - See paginated list with delete option

## Navigation Structure

### Home Page Links
- **Student Login** → `/student/login`
- **Teacher Login** → `/teacher/login`
- **Admin Login** → `/admin/login`

### Student Dashboard
- Home Dashboard
- View Profile
- Change Password
- Logout

### Teacher Dashboard
- Home Dashboard
- View Profile
- My Courses (Future)
- My Students (Future)
- Change Password
- Logout

### Admin Dashboard
- Dashboard Overview (Statistics)
- Manage Students
  - View All
  - Add New
  - Delete
- Manage Teachers
  - View All
  - Add New
  - Delete
- Change Password
- Logout

## Default Test Credentials

### Admin
- Email: `admin@mrjr.edu`
- Password: `password`

### Teacher (After Creation)
- Email: `john.doe@mrjr.edu`
- Password: `TeacherPass123`

### Student (Use existing)
- Email: Use existing student email
- Password: Use existing student password

## Common Issues & Solutions

### Issue: Migration Error "Table already exists"
**Solution:** The table may already exist, or another migration failed. Check `php artisan migrate:status`

### Issue: Login redirects back to login
**Solution:**
1. Verify credentials exist in correct table
2. Check password hashing is correct
3. Clear session/cache: `php artisan cache:clear`

### Issue: Middleware returns 404
**Solution:**
1. Verify middleware registered in `bootstrap/app.php`
2. Verify routes registered in `routes/web.php`
3. Run `php artisan route:list` to see all routes

### Issue: View not found
**Solution:**
1. Verify all blade files exist in correct directories
2. Check file naming matches controller
3. Clear cache: `php artisan view:clear`

## Database Tables Summary

### Teachers Table Columns
- id (Auto)
- fname (First Name)
- mname (Middle Name)
- lname (Last Name)
- email (Unique)
- contact_no (Phone)
- password (Hashed)
- specialty (Optional)
- department (Required)
- is_active (Boolean)
- created_at
- updated_at

### Admins Table Columns
- id (Auto)
- name (Full Name)
- email (Unique)
- password (Hashed)
- role (admin/super_admin)
- is_active (Boolean)
- created_at
- updated_at

### Students Table (New Column)
- role (VARCHAR 50, default: 'student')

## Features Implemented

### Student Dashboard
✓ Login/Logout
✓ View Profile
✓ Change Password
✓ Session Management

### Teacher Dashboard
✓ Login/Logout
✓ View Profile
✓ Change Password
✓ Department Info
✓ Specialty Info
✓ Session Management

### Admin Dashboard
✓ Login/Logout
✓ Dashboard Statistics
✓ Student Management (CRUD except Update)
✓ Teacher Management (CRUD except Update)
✓ Change Password
✓ Session Management
✓ Pagination for lists
✓ Proper error handling

## Security Checklist

- [x] Passwords hashed with Laravel's Hash::make()
- [x] CSRF tokens on all forms
- [x] Session-based authentication
- [x] Middleware route protection
- [x] Input validation on all forms
- [x] SQL injection prevention (Eloquent)
- [x] XSS prevention (Blade escaping)
- [x] Inactive account checks
- [x] Login attempt logging
- [x] Password change logging

## Performance Optimization Tips

1. **Database:**
   - Add indexes on email columns
   - Add indexes on is_active columns

2. **Caching:**
   - Consider caching user data in session
   - Cache degree/program list

3. **Pagination:**
   - Default 10 items per page (adjustable)
   - Reduces database load

## Maintenance

### Regular Tasks
- Monitor logs in `storage/logs/`
- Review failed login attempts
- Update inactive accounts
- Backup database regularly

### Monthly Review
- Check for unused accounts
- Review admin action logs
- Performance analysis
- Security audit

## Contact Technical Support

If issues persist:
1. Check `storage/logs/laravel.log` for errors
2. Run `php artisan config:cache` and `php artisan view:cache`
3. Verify database connection in `.env`
4. Review migration status: `php artisan migrate:status`

---

**Setup Guide Version:** 1.0
**Last Updated:** May 12, 2026
**Status:** ✅ Complete & Ready for Testing
