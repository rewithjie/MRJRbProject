# ELECTIVEI Activity #6: Laravel MVC Implementation Guide

## Project Summary

This Laravel project implements a complete MVC application with Student and Degree management system featuring:
- **Models**: Student, Degree with proper relationships
- **Controllers**: StudentController, DegreeController with full CRUD operations
- **Views**: Blade templates for all operations with Bootstrap styling
- **Routes**: RESTful resource routes for both entities
- **Database**: MySQL with migrations for students and degrees tables
- **Pagination**: Implemented for student listing

---

## Setup Instructions

### Step 1: Start XAMPP Services

1. Open XAMPP Control Panel
2. Start the following services:
   - **Apache** (starts web server)
   - **MySQL** (starts database server)

### Step 2: Run Migrations

Open PowerShell in the project directory and run:

```powershell
cd c:\xampp\htdocs\MRJRbProject
php artisan migrate
```

This will:
- Create the `degrees` table with columns: id, title, timestamps
- Add `degree_id` foreign key column to the `students` table

### Step 3: Start Laravel Development Server

```powershell
php artisan serve
```

The application will be available at: **http://localhost:8000**

---

## Application Features

### 1. **Degree Management**

#### Routes:
- `GET /degrees` - List all degrees with pagination
- `GET /degrees/create` - Show form to create degree
- `POST /degrees` - Store new degree
- `GET /degrees/{id}` - Show degree details with enrolled students
- `GET /degrees/{id}/edit` - Show edit form
- `PUT /degrees/{id}` - Update degree
- `DELETE /degrees/{id}` - Delete degree

#### Features:
- Display all degrees in paginated table (10 per page)
- Shows total number of students enrolled in each degree
- Click on degree to view all enrolled students
- Add, edit, and delete degrees
- Validates unique degree title
- Shows confirmation before deletion

---

### 2. **Student Management**

#### Routes:
- `GET /students` - List all students with pagination
- `GET /students/create` - Show form to create student
- `POST /students` - Store new student
- `GET /students/{id}` - Show student details
- `GET /students/{id}/edit` - Show edit form
- `PUT /students/{id}` - Update student
- `DELETE /students/{id}` - Delete student

#### Features:
- Display all students in paginated table (10 per page)
- Dropdown to select degree during creation and editing
- Shows student details including assigned degree
- Can link to degree details page from student view
- Year level badge based on age (Freshman/Sophomore/Junior/Senior)
- Email and phone contact links in detail view
- Add, edit, and delete students with confirmation

---

## Database Schema

### Degrees Table
```sql
CREATE TABLE degrees (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Students Table (with added field)
```sql
ALTER TABLE students ADD COLUMN degree_id BIGINT UNSIGNED NULLABLE;
ALTER TABLE students ADD CONSTRAINT `students_degree_id_foreign` 
    FOREIGN KEY (degree_id) REFERENCES degrees(id) ON DELETE SET NULL;
```

---

## Model Relationships

### Student Model
```php
// Belongs to Degree
public function degree(): BelongsTo
{
    return $this->belongsTo(Degree::class);
}
```

### Degree Model
```php
// Has many Students
public function students(): HasMany
{
    return $this->hasMany(Student::class);
}
```

---

## Validation Rules

### Degree Validation
- `title`: Required, string, max 255 chars, unique

### Student Validation
- `fname`: Required, string, max 255
- `mname`: Required, string, max 255
- `lname`: Required, string, max 255
- `email`: Required, email format, unique
- `contact_no`: Required, string, max 20
- `age`: Required, integer, min 1, max 120
- `course`: Required, string, max 255
- `degree_id`: Optional, must exist in degrees table

---

## Testing Checklist

Complete these tests to verify the application works correctly:

### Degree Management Tests
- [ ] Visit http://localhost:8000/degrees
- [ ] Create new degree (e.g., "Bachelor of Science in Computer Science")
- [ ] View degree details and see empty student list
- [ ] Edit degree title
- [ ] Pagination works with multiple degrees

### Student Management Tests
- [ ] Visit http://localhost:8000/students to see list
- [ ] Create new student with all required fields and assign degree
- [ ] Degree dropdown shows all available degrees
- [ ] View student details and see assigned degree as clickable link
- [ ] Edit student and change assigned degree
- [ ] Delete student with confirmation
- [ ] Pagination works with 10+ students

### Integration Tests
- [ ] Create 2-3 degrees first
- [ ] Create 15+ students assigned to different degrees
- [ ] Visit degree details page and verify students are listed
- [ ] Check pagination on student listing page
- [ ] Check all form validations (try empty fields, invalid email, etc.)

---

## Project Structure

```
MRJRbProject/
├── app/
│   ├── Models/
│   │   ├── Student.php          [Updated with degree relationship]
│   │   └── Degree.php            [New - Degree model]
│   └── Http/
│       └── Controllers/
│           ├── StudentController.php    [Updated with pagination & degree]
│           └── DegreeController.php      [New - CRUD controller]
├── database/
│   └── migrations/
│       ├── 2026_03_19_043053_create_degrees_table.php
│       └── 2026_03_19_043106_add_degree_id_to_students_table.php
├── resources/
│   └── views/
│       ├── students/
│       │   ├── index.blade.php  [Updated with pagination]
│       │   ├── create.blade.php [Updated with degree dropdown]
│       │   ├── edit.blade.php   [Updated with degree dropdown]
│       │   └── show.blade.php   [Updated with degree display]
│       └── degrees/             [New folder]
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
└── routes/
    └── web.php                  [Updated with degree routes]
```

---

## Troubleshooting

### MySQL Connection Error
**Error**: "No connection could be made because the target machine actively refused it"
**Solution**: 
1. Open XAMPP Control Panel
2. Click "Start" next to MySQL
3. Wait for it to show "Running"
4. Then run `php artisan migrate`

### Migration Already Exists
**Error**: "Migration file already exists"
**Solution**: This is normal if you've already created the migrations. Simply run:
```powershell
php artisan migrate --force
```

### Port 8000 Already in Use
**Error**: "Address already in use"
**Solution**: Run on different port:
```powershell
php artisan serve --port=8001
```
Then access at http://localhost:8001

### Database Doesn't Exist
**Error**: "Unknown database 'mrjrlaraveldb'"
**Solution**: Create the database manually using phpMyAdmin:
1. Open http://localhost/phpmyadmin
2. Click "New" in left sidebar
3. Name: `mrjrlaraveldb`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"
6. Run migrations

---

## Key Implementation Details

### Pagination
Students are paginated at 10 records per page using Laravel's built-in pagination:
```php
$students = Student::paginate(10);
$degrees = Degree::paginate(10);
```

### CSRF Protection
All forms include CSRF token using Blade directive:
```blade
@csrf
```

### Form Validation
All forms handle validation errors gracefully:
```blade
@if ($errors->any())
    <!-- Display all errors -->
@endif
```

### Relationships
Models use Eloquent relationships for querying:
```php
// In Student model
$student->degree;           // Get assigned degree
$student->degree->title;    // Access degree title

// In Degree model
$degree->students;          // Get all students with this degree
$degree->students->count(); // Count enrolled students
```

---

## Files Created/Modified

### New Files
- `app/Models/Degree.php`
- `app/Http/Controllers/DegreeController.php`
- `database/migrations/2026_03_19_043053_create_degrees_table.php`
- `database/migrations/2026_03_19_043106_add_degree_id_to_students_table.php`
- `resources/views/degrees/index.blade.php`
- `resources/views/degrees/create.blade.php`
- `resources/views/degrees/edit.blade.php`
- `resources/views/degrees/show.blade.php`

### Modified Files
- `app/Models/Student.php` - Added degree_id to fillable and degree() relationship
- `app/Http/Controllers/StudentController.php` - Added pagination and degree handling
- `resources/views/students/create.blade.php` - Added degree dropdown
- `resources/views/students/edit.blade.php` - Added degree dropdown
- `resources/views/students/index.blade.php` - Added pagination links
- `resources/views/students/show.blade.php` - Added degree display
- `routes/web.php` - Added degree routes

---

## Notes

- All timestamps (created_at, updated_at) are automatically managed by Laravel
- Foreign key constraint is set to ON DELETE SET NULL for students
- Pagination uses Bootstrap 5 styling (compatible with existing layout)
- All validation is done server-side with clear error messages
- All actions require CSRF token for security
- Confirmation dialogs appear before deletion

---

## Version Information
- Laravel Framework
- MySQL Database
- Bootstrap 5 UI
- PHP Artisan CLI

Enjoy your completed Laravel MVC application!
