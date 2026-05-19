# Final Term Project - Hospital Management System

## Overview

A multi-role hospital management system built with PHP, MySQL, mysqli, and an MVC-style folder structure. The platform connects patients, doctors, receptionists, and hospital admins in one local hospital portal. Patients can register, manage profiles, browse doctors, book appointments, view billing, manage dependents, review doctors, and read announcements. Doctors can manage schedules, availability, leave dates, consultation notes, patient messages, reviews, earnings, and appointment requests. Receptionists can book appointments, search patients, register patients, and process payments. Admin users can manage doctors, receptionists, specializations, reviews, revenue, and hospital dashboard statistics.

## Roles

| Role | Responsibility |
| --- | --- |
| Patient | Register/login, profile management, find doctors, book appointments, manage dependents, medical history, billing, reviews, announcements |
| Doctor | Dashboard, profile, availability, leave dates, today schedule, weekly calendar, appointment requests, consultation notes, patient notes, reviews, earnings, statistics, messages |
| Receptionist | Dashboard, book appointments, search patients, register patients, process payments, payment receipts |
| Admin | Admin dashboard, add doctors, manage receptionists, manage specializations, view doctor reviews, total revenue, hospital statistics |

## Technical Requirements

- MVC-style structure with controllers, models, and views separated by responsibility
- PHP server-side application
- MySQL database using XAMPP/MariaDB
- mysqli database connections through module-specific database files
- PHP sessions with role-based dashboard routing
- Role-based access control on dashboard and protected pages
- AJAX/fetch features for appointment slot loading and dashboard partial data
- Runnable locally on XAMPP Apache from `htdocs/Final_Term_Project`
- Main login route: `Login/index.php`
- Main database import files: `Login/Doctor/hospital_db.sql` and `Login/patient/hospital_db.sql`

## Separation of Concerns

- `Login/index.php` works as the shared login entry point for admin, doctor, patient, and receptionist roles.
- Admin files are separated under `Login/ADMIN/`.
- Doctor files are separated under `Login/Doctor/`.
- Patient files are separated under `Login/patient/`.
- Receptionist files are separated under `Login/RECEPTIONIST/`.
- Controllers handle request routing and business actions.
- Models handle database queries and data operations.
- Views render dashboard pages, forms, and UI screens.
- CSS and JavaScript are stored inside each role folder where needed.
- Protected dashboard pages validate PHP session data before rendering.

## Folder Structure

```text
Final_Term_Project/
+-- README.md
+-- Login/
    +-- index.php                         # Shared login and role redirect
    +-- ADMIN/
    |   +-- CONTROLLER/                   # Admin dashboard, doctors, revenue, reviews, specialization logic
    |   +-- MODEL/                        # Admin DB connection and database operations
    |   +-- VIEW/                         # Admin dashboard and admin pages
    |   |   +-- admin_dashboard.php
    |   |   +-- add_doctor.php
    |   |   +-- manage_receptionist.php
    |   |   +-- manage_specialization.php
    |   |   +-- doctor_reviews.php
    |   |   +-- total_revenue.php
    |   |   +-- logout.php
    |   |   +-- script/
    |   |       +-- formvalidation.js
    |   +-- README.md
    +-- Doctor/
    |   +-- assets/css/style.css          # Doctor dashboard styling
    |   +-- config/database.php           # Doctor module DB connection
    |   +-- controllers/                  # DoctorController and AjaxController
    |   +-- models/                       # Doctor, appointment, review, earnings, message models
    |   +-- views/
    |   |   +-- login.php
    |   |   +-- doctor/                   # Doctor dashboard pages
    |   +-- index.php
    |   +-- logout.php
    |   +-- hospital_db.sql
    +-- patient/
    |   +-- assets/css/style.css          # Patient dashboard styling
    |   +-- config/database.php           # Patient module DB connection
    |   +-- controllers/                  # PatientController and AjaxController
    |   +-- models/                       # Patient, doctor, appointment, billing, review models
    |   +-- views/
    |   |   +-- login.php
    |   |   +-- register.php
    |   |   +-- patient/                  # Patient dashboard pages
    |   +-- uploads/profiles/             # Uploaded profile pictures
    |   +-- index.php
    |   +-- logout.php
    |   +-- hospital_db.sql
    +-- RECEPTIONIST/
        +-- CONTROLLER/                   # Receptionist dashboard, appointments, payments, patient registration
        +-- MODEL/                        # Receptionist DB connection and operations
        +-- VIEW/                         # Receptionist dashboard and pages
        |   +-- receptionist_dashboard.php
        |   +-- book_appointment.php
        |   +-- search_patient.php
        |   +-- register_patient.php
        |   +-- process_payment.php
        |   +-- payment_receipt.php
        |   +-- registration_rep.php
        |   +-- logout.php
        |   +-- script/
        |       +-- valid.js
        +-- readme.txt
```

## Shared Database Tables

The hospital database uses tables such as:

`announcements`, `appointments`, `billing`, `consultation_notes`, `dependents`, `doctor_availability`, `doctor_reviews`, `doctors`, `leave_dates`, `messages`, `patients`, `specializations`, `users`

See:

- `Login/Doctor/hospital_db.sql`
- `Login/patient/hospital_db.sql`

## AJAX Features

| Role | AJAX feature |
| --- | --- |
| Patient | Available appointment slot loading through `Login/patient/controllers/AjaxController.php` |
| Doctor | Appointment status updates through `Login/Doctor/controllers/AjaxController.php` |
| Receptionist | Dashboard appointment loading through `Login/RECEPTIONIST/CONTROLLER/dataLoad.php` and JavaScript under `Login/RECEPTIONIST/VIEW/script/` |
| Admin | Dashboard and table loading through admin controller files and `Login/ADMIN/VIEW/script/formvalidation.js` |

## Main Routes

| Route | Purpose |
| --- | --- |
| `/Final_Term_Project/Login/index.php` | Shared login page |
| `/Final_Term_Project/Login/patient/views/register.php` | Patient registration |
| `/Final_Term_Project/Login/ADMIN/VIEW/admin_dashboard.php` | Admin dashboard |
| `/Final_Term_Project/Login/Doctor/controllers/DoctorController.php` | Doctor dashboard |
| `/Final_Term_Project/Login/patient/controllers/PatientController.php` | Patient dashboard |
| `/Final_Term_Project/Login/RECEPTIONIST/VIEW/receptionist_dashboard.php` | Receptionist dashboard |
| `/Final_Term_Project/Login/ADMIN/VIEW/add_doctor.php` | Add doctor |
| `/Final_Term_Project/Login/ADMIN/VIEW/manage_receptionist.php` | Manage receptionists |
| `/Final_Term_Project/Login/RECEPTIONIST/VIEW/book_appointment.php` | Receptionist appointment booking |
| `/Final_Term_Project/Login/RECEPTIONIST/VIEW/register_patient.php` | Receptionist patient registration |

## Local Setup

1. Keep the project folder at:

```text
C:\xampp\htdocs\Final_Term_Project
```

2. Start Apache and MySQL from the XAMPP Control Panel.

3. Create a MySQL database named:

```sql
CREATE DATABASE hospital_db;
```

4. Import the database SQL file. Use the fuller doctor SQL seed first:

```text
Login/Doctor/hospital_db.sql
```

If you are testing patient-specific data from the patient module, also review:

```text
Login/patient/hospital_db.sql
```

5. Confirm database settings in the role database connection files:

```php
host: localhost
user: root
password: ""
database: hospital_db
```

Relevant files:

- `Login/ADMIN/MODEL/db_connection.php`
- `Login/Doctor/config/database.php`
- `Login/patient/config/database.php`
- `Login/RECEPTIONIST/MODEL/db_connection.php`

6. Open the project in the browser:

```text
http://localhost/Final_Term_Project/Login/index.php
```

## Demo Accounts

The project uses demo accounts for local testing. The common demo password is:

```text
password
```

| Role | Email |
| --- | --- |
| Admin | `admin@test.com` |
| Doctor | `doctor@test.com` or `doctor1@test.com` |
| Patient | `patient@test.com` or `patient1@test.com` |
| Receptionist | `reception@test.com` |

Password hashes are stored in the database. If a demo user is missing after import, create it locally in the `users` table with the correct role and an active status.

## Member Assignment

| Folder / Area | Owner |
| --- | --- |
| `Login/patient/controllers/`, `Login/patient/models/`, `Login/patient/views/patient/`, `Login/patient/views/register.php` | Patient role |
| `Login/Doctor/controllers/`, `Login/Doctor/models/`, `Login/Doctor/views/doctor/` | Doctor role |
| `Login/RECEPTIONIST/CONTROLLER/`, `Login/RECEPTIONIST/MODEL/`, `Login/RECEPTIONIST/VIEW/` | Receptionist role |
| `Login/ADMIN/CONTROLLER/`, `Login/ADMIN/MODEL/`, `Login/ADMIN/VIEW/` | Admin role |
| `Login/index.php`, database imports, shared authentication flow, shared session routing | Shared project foundation |

## Notes

- Patient registration is public through the shared login page.
- Doctor, receptionist, and admin users should be created by an authorized admin or seeded in the database.
- Dashboards rely on PHP sessions and redirect back to `Login/index.php` when a user is not authenticated for the required role.
