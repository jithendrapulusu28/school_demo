# PHP - Application Form

## 1. Basic Setup

Create a new PHP project named `school_demo`.

## 2. Database Setup

### Create MySQL Database

1. **Create a MySQL database** named `school_db`.

2. **Create the following tables**:

   **Table: `student`**
   ```sql
   CREATE TABLE student (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(255) NOT NULL,
       email VARCHAR(255) NOT NULL,
       address TEXT,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       class_id INT,
       image VARCHAR(255),
       created_at DATETIME
   );
 **Table: `classes`**
  ```sql
CREATE TABLE classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME
);
```
## 3. Functionality

### Home Page (`index.php`)

- Display a list of all students.
- For each student, show:
  - Name
  - Email
  - Creation date
  - Class name
  - Image (thumbnail)
- Provide links to view, edit, and delete each student.
- Use a JOIN query to fetch the class name associated with each student.

### Create Student (`create.php`)

- Form fields:
  - Name
  - Email
  - Address
  - Class (dropdown)
  - Image upload

- Validation:
  - Ensure the name field is not empty.
  - Ensure the uploaded image is in JPG or PNG format.

- On form submission:
  - Upload the image to the `uploads/` directory.
  - Insert the new student record into the database.
  - Redirect to the home page.

- Use a JOIN query to populate the class dropdown list.

### View Student (`view.php`)

- Display:
  - Full name
  - Email
  - Address
  - Class name
  - Image
- Show the creation date of the student record.
- Use a JOIN query to fetch the class name.

### Edit Student (`edit.php`)

- Form pre-filled with:
  - Current name
  - Email
  - Address
  - Class (dropdown)
  - Option to upload a new image

- Validation:
  - Ensure the name field is not empty.
  - Validate the image format (JPG, PNG) if a new image is uploaded.

- On form submission:
  - Update the student details in the database.
  - Redirect to the home page.

- Use a JOIN query to populate the class dropdown list.

### Delete Student (`delete.php`)

- Confirm the deletion of the student.
- On confirmation:
  - Delete the student record from the database.
  - Remove the associated image file from the server.
  - Redirect to the home page.

### Manage Classes (`classes.php`)

- Display a list of all classes.
- Provide options to:
  - Add a new class.
  - Edit an existing class.
  - Delete a class.

### Image Upload Handling

- Store uploaded images in a directory named `uploads/`.
- Validate that the image format is either JPG or PNG.
- Ensure images have unique filenames to avoid overwriting.
