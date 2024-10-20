# Epig Assessment Project

## Basic Requirements

- **PHP**: 8.0+
- **MySQL**: Ensure you have a running MySQL server.
- **Composer**: Dependency manager for PHP.
- **Online Connection**: Required for certain CDN packages.

## Deployment Instructions

Follow these steps to set up the project locally:

1. **Clone the Repository**:
   ```bash
   git clone git@github.com:Jamessks/epig_assessment.git
   ```
or just download it as a zip file and place it in the directory of your choice.

2. **Import the Database**: Import the db.sql file into your MySQL server which is located in the project's root. Once it has been imported you can delete it to free up space, or even keep it for backup just in case. This will create the epignosis_site database along with its tables and some initial data.

3. **Configure Environment Variables**: From the project root, make a copy of the .env.example file and rename it to .env.

4. **Database Configuration**: Fill out the different fields in the .env file to match your MySQL database settings. IMPORTANT: The ```DB_NAME``` should be set to epignosis-site.
5. **Install Dependencies**: Run the following command to install the necessary dependencies: ```composer install```
6. **Navigate to the Public Folder**: Change to the public directory: ```cd public```
7. **Run the Local PHP Server**: Start the PHP server with: ```php -S localhost:8080``` or use any free port depending on what is available to you.
8. **Done!**: You can now access the project at http://localhost:8080

**User Journey**
===================
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

These users and credentials and their respective roles and permissions have been set by default during the db import

Other than that the project is doing what is expected as per the requirements.

Please let me know if you encounter any problems. Thank you.
