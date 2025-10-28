# TODO: Implement PHP News Upload and MySQL Database

## Steps to Complete

1. **Create MySQL Database Schema**
   - Create SQL script to set up database and tables for news articles and categories.
   - Tables: news (id, title, content, category, image_path, date, author), categories (id, name).
   - [x] Completed: Created database_setup.sql

2. **Create Database Connection File**
   - Create `db_connect.php` for MySQL connection using PDO or mysqli.

3. **Implement Upload Functionality**
   - Create `upload_news.php` with form for title, content, category, image upload, and handler to insert into database.

4. **Modify News Display Page**
   - Edit `noticias.html` to `noticias.php` to fetch and display news dynamically from the database.

5. **Add Admin Management (Optional)**
   - Create `manage_news.php` for viewing, editing, and deleting news articles.

6. **Test and Setup**
   - Run SQL script to create database in MySQL via XAMPP.
   - Test upload and display functionality.
   - Ensure security measures for file uploads.

## Progress
- [x] Step 1: Create MySQL Database Schema
- [x] Step 2: Create Database Connection File
- [x] Step 3: Implement Upload Functionality
- [x] Step 4: Modify News Display Page
- [x] Step 5: Add Admin Management (Optional)
- [x] Step 6: Test and Setup
