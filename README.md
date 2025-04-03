# Holiday Requests Project

## Basic Requirements

- **PHP**: 8.0+
- **MySQL**: Ensure you have a running MySQL server.
- **Composer**: Dependency manager for PHP.
- **Javascript enabled**: Required for JS scripting.

## Deployment Instructions

Follow these steps to set up the project locally:

1. **Clone the Repository**:
   ```bash
   git@github.com:Jamessks/holiday_requests.git
   ```
or just download it as a zip file and extract it in the directory of your choice.

2. **Import the Database**: Create a database called 'your_preferred_db_name' and in that database, import the db.sql file, which is located in the project's root. Once it has been imported you can delete it to free up space, or even keep it for backup just in case.

3. **Configure Environment Variables**: From the project root, make a copy of the .env.example file and rename it to .env.

4. **Database Configuration**: Fill out the different fields in the .env file to match your MySQL database settings. IMPORTANT: The ```DB_NAME``` should be set to ```the_same_db_name_as_in_step_2```.
5. **Install Dependencies**: Run the following command to install the necessary dependencies: ```composer install```
6. **Navigate to the Public Folder**: Change to the public directory: ```cd public```
7. **Run the Local PHP Server**: Start the PHP server with: ```php -S localhost:8080``` or use any free port depending on what is available to you.
8. **Done!**: You can now access the project at http://localhost:8080

Run tests from project root using
```
vendor/bin/pest  tests/Unit/ValidatorTest.php 
```
from the CLI

**User Journey**
===================
The project includes a custom RBAC (role-based authentication access) system which provides different roles and their respective permissions to users.
As a guest you may only login or visit non important pages such as about, contact.

If you would like to login as a **manager** role use these credentials:
```
username: dimitrisst
password: password
```

If you would like to login as a **employee** role use these credentials:
```
username: employee1
password: password
```
These users' credentials and their respective roles and permissions have been set by default during the db import.

**Employee Journey**

Employee may: View their own holiday requests

Employee may: Create their own holiday requests

Employee may: Cancel their own holiday requests

Employee may: Log out


**Manager Journey**

Manager may: View users table

Manager may: Create users

Manager may: Edit users

Manager may: Delete users

Manager may: View Holiday Requests

Manager may: Manage Holiday Requests

Manager may: Receive Live Notifications (via AJAX polling)

Manager may: Log out
