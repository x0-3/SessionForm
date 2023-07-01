# SessionForm

Welcome to the Symfony Session Management System! This web application is built using Symfony and provides functionalities for managing sessions, interns, programs, categories, and modules. With this system, you can easily add sessions, interns, create programs, categories, and modules to keep track of your session-related activities.

## Installation

To run this project locally, please follow the steps below:

1. Clone the repository to your local machine:
   ```
   git clone https://github.com/x0-3/SessionForm.git
   ```

2. Change into the project directory:
   ```
   cd SessionForm
   ```

3. Install the required dependencies using Composer:
   ```
   composer install
   ```

4. Import the provided database into your MySQL server:
   - Locate the database file named `SessionForm_db.sql` inside the project directory.
   - Import this file into your MySQL server to create the necessary tables and populate them with sample data. You can use a tool like HeidiSql or run the following command:
     ```
     mysql -u your-username -p your-database-name < SessionForm_db.sql
     ```

5. Configure the database connection:
   - Open the `.env` file and update the `DATABASE_URL` parameter with your MySQL database credentials.

6. Start the Symfony development server:
   ```
   symfony server:start
   ```

7. Access the application in your web browser:
   ```
   http://localhost:8000
   ```

## Features

### Session Management
- Add new sessions with details such as session name, start date, end date.
- Edit existing sessions to update their details.
- Delete sessions that are no longer required.

### Intern Management
- Add new interns with their personal information, including name, email, and phone number...
- Assign interns to specific sessions.
- Edit intern details.
- Remove interns from sessions.

### Program Management
- Create new programs with a name, description, and associated category.
- Assign programs to sessions.
- Edit program details.
- Remove programs from sessions.

### Category Management
- Edit category names.
- Delete categories.

### Module Management
- Create new modules.
- Edit module details.
- Remove modules from programs.
