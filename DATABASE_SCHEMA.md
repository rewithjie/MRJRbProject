# Database Schema

This schema reflects the current structure used by the project.

## Core tables

- `users`
- `profiles`
- `posts`
- `students`
- `degrees`
- `courses`
- `course__students` (pivot for many-to-many student/course)
- `user_accounts`

## Laravel/system tables

- `password_reset_tokens`
- `sessions`
- `cache`
- `cache_locks`

## Relationship map

- `users (1) -> (many) posts`
- `users (1) -> (many) profiles` (app logic usually treats this as one-to-one)
- `degrees (1) -> (many) students`
- `user_accounts (1) -> (many) students`
- `students (many) <-> (many) courses` through `course__students`

## Notes

- SQL DDL is available in `database/project_schema.sql`.
- The project currently has a naming mismatch in model relation for student courses:
  - `Student` model uses `course_students`
  - migration/table is `course__students`
- The migration `2026_04_14_024144_add_user_account_id_to_students_table.php` places the `user_account_id` change in `down()` instead of `up()`.
  The SQL schema includes `user_account_id` because it is referenced by app code and later migration logic.
