-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2026 at 10:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `target_role` enum('all','patient','doctor') DEFAULT 'all',
  `published_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `author_id`, `title`, `body`, `target_role`, `published_at`) VALUES
(1, 6, 'New Medical Equipment', 'We have acquired new ECG machines. Please attend training on Friday.', 'doctor', '2026-05-17 08:38:45'),
(2, 6, 'Holiday Schedule', 'Hospital will be closed on Sunday. Emergency services available.', 'all', '2026-05-17 08:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','confirmed','checked_in','completed','cancelled','no_show') DEFAULT 'pending',
  `booked_by` enum('patient','receptionist') DEFAULT 'patient',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `reason`, `status`, `booked_by`, `created_at`) VALUES
(1, 1, 1, '2026-05-07', '10:00:00', 'Chest pain check', 'completed', 'patient', '2026-05-02 08:38:45'),
(2, 2, 2, '2026-05-09', '14:30:00', 'Skin rash', 'completed', 'patient', '2026-05-05 08:38:45'),
(3, 3, 1, '2026-05-12', '11:00:00', 'High blood pressure follow-up', 'completed', 'patient', '2026-05-07 08:38:45'),
(4, 1, 1, '2026-05-17', '09:30:00', 'ECG review', 'confirmed', 'patient', '2026-05-17 08:38:45'),
(5, 2, 1, '2026-05-17', '11:00:00', 'Medication refill', 'pending', 'patient', '2026-05-17 08:38:45'),
(6, 3, 2, '2026-05-17', '13:00:00', 'Acne treatment', 'checked_in', 'patient', '2026-05-17 08:38:45'),
(7, 1, 1, '2026-05-19', '10:30:00', 'Follow-up', 'confirmed', 'patient', '2026-05-17 08:38:45'),
(8, 2, 2, '2026-05-20', '15:00:00', 'Skin check', 'pending', 'patient', '2026-05-17 08:38:45'),
(9, 3, 1, '2026-05-21', '09:00:00', 'Routine checkup', 'confirmed', 'patient', '2026-05-17 08:38:45'),
(10, 2, 1, '2026-05-02', '14:00:00', 'Routine', 'cancelled', 'patient', '2026-04-27 08:38:45'),
(11, 1, 2, '2026-05-05', '11:30:00', 'Follow-up', 'no_show', 'patient', '2026-05-02 08:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','card','online') DEFAULT 'cash',
  `payment_status` enum('pending','paid') DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `appointment_id`, `patient_id`, `amount`, `payment_method`, `payment_status`, `paid_at`) VALUES
(1, 1, 1, 800.00, 'card', 'paid', '2026-05-17 08:38:45'),
(2, 2, 2, 600.00, 'cash', 'paid', '2026-05-17 08:38:45'),
(3, 3, 3, 800.00, 'online', 'pending', NULL),
(4, 4, 1, 800.00, NULL, 'pending', NULL),
(5, 5, 2, 800.00, NULL, 'pending', NULL),
(6, 6, 3, 600.00, NULL, 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consultation_notes`
--

CREATE TABLE `consultation_notes` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `symptoms` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `follow_up_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultation_notes`
--

INSERT INTO `consultation_notes` (`id`, `appointment_id`, `doctor_id`, `patient_id`, `symptoms`, `diagnosis`, `prescription`, `follow_up_date`, `created_at`) VALUES
(1, 1, 1, 1, 'Chest discomfort, shortness of breath', 'Mild angina, stable condition', 'Nitroglycerin 0.4mg as needed. Low sodium diet. Regular exercise.', '2026-06-16', '2026-05-17 08:38:45'),
(2, 2, 2, 2, 'Red itchy patches on arms and face', 'Contact dermatitis', 'Hydrocortisone cream 1% twice daily. Avoid irritants.', NULL, '2026-05-17 08:38:45'),
(3, 3, 1, 3, 'Headaches, dizziness, BP 145/90', 'Stage 1 hypertension', 'Lisinopril 10mg daily. Reduce salt intake. Follow up in 2 weeks.', '2026-05-31', '2026-05-17 08:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `dependents`
--

CREATE TABLE `dependents` (
  `id` int(11) NOT NULL,
  `primary_patient_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `relationship` varchar(50) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dependents`
--

INSERT INTO `dependents` (`id`, `primary_patient_id`, `name`, `date_of_birth`, `relationship`, `blood_group`) VALUES
(1, 1, 'Emma Patient', '2015-08-20', 'Daughter', 'O+'),
(2, 1, 'James Patient', '2018-11-10', 'Son', 'A-');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `specialization_id` int(11) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `consultation_fee` decimal(10,2) DEFAULT 500.00,
  `photo_path` varchar(255) DEFAULT NULL,
  `license_number` varchar(100) DEFAULT NULL,
  `experience_years` int(11) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `specialization_id`, `bio`, `consultation_fee`, `photo_path`, `license_number`, `experience_years`, `is_approved`) VALUES
(1, 4, 1, 'Experienced cardiologist specializing in heart disease prevention and treatment.', 800.00, NULL, 'LIC123456', 15, 1),
(2, 5, 2, 'Board-certified dermatologist with expertise in acne, eczema, and skin cancer screening.', 600.00, NULL, 'LIC789012', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_availability`
--

CREATE TABLE `doctor_availability` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `slot_duration_minutes` int(11) DEFAULT 30,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_availability`
--

INSERT INTO `doctor_availability` (`id`, `doctor_id`, `day_of_week`, `start_time`, `end_time`, `slot_duration_minutes`, `is_available`) VALUES
(1, 1, 'Monday', '09:00:00', '17:00:00', 30, 1),
(2, 1, 'Tuesday', '09:00:00', '17:00:00', 30, 1),
(3, 1, 'Wednesday', '09:00:00', '17:00:00', 30, 1),
(4, 1, 'Thursday', '09:00:00', '17:00:00', 30, 1),
(5, 1, 'Friday', '09:00:00', '14:00:00', 30, 1),
(6, 2, 'Monday', '10:00:00', '18:00:00', 45, 1),
(7, 2, 'Tuesday', '10:00:00', '18:00:00', 45, 1),
(8, 2, 'Wednesday', '10:00:00', '18:00:00', 45, 1),
(9, 2, 'Thursday', '10:00:00', '18:00:00', 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_reviews`
--

CREATE TABLE `doctor_reviews` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review_text` text DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_reviews`
--

INSERT INTO `doctor_reviews` (`id`, `appointment_id`, `patient_id`, `doctor_id`, `rating`, `review_text`, `reply`, `created_at`) VALUES
(1, 1, 1, 1, 5, 'Excellent doctor! Very thorough and caring. Explained everything clearly.', 'Thank you for your kind words! I\'m glad to help.', '2026-05-17 08:38:45'),
(2, 2, 2, 2, 4, 'Good experience, but waiting time was a bit long.', 'We apologize for the wait. Thank you for your feedback.', '2026-05-17 08:38:45'),
(3, 3, 3, 1, 5, 'Dr. Smith helped me manage my BP effectively. Highly recommended.', NULL, '2026-05-17 08:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `leave_dates`
--

CREATE TABLE `leave_dates` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `leave_date` date DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_dates`
--

INSERT INTO `leave_dates` (`id`, `doctor_id`, `leave_date`, `reason`) VALUES
(1, 1, '2026-05-27', 'Annual Conference'),
(2, 1, '2026-06-11', 'Vacation'),
(3, 2, '2026-05-22', 'Personal Leave');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `appointment_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 4, 1, 'Doctor, I have a question about my medication. Can you advise?', 0, '2026-05-15 08:38:45'),
(2, 4, 1, 1, 'Please schedule a follow-up appointment to discuss your medication in detail.', 0, '2026-05-16 08:38:45'),
(3, 2, 5, 2, 'The cream you prescribed is helping a lot. Thank you!', 1, '2026-05-14 08:38:45'),
(4, 5, 2, 2, 'Glad to hear that! Continue using it for another week.', 0, '2026-05-15 08:38:45'),
(5, 3, 4, 3, 'My BP readings are improving. Should I continue the same dose?', 0, '2026-05-17 08:38:45'),
(6, 4, 3, 3, 'Yes, continue with 10mg. I will check again in your next visit.', 0, '2026-05-17 08:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `medical_history_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `date_of_birth`, `blood_group`, `gender`, `address`, `emergency_contact_name`, `emergency_contact_phone`, `medical_history_notes`) VALUES
(1, 1, '1985-06-15', 'O+', 'Male', '123 Main St, Dhaka', 'Mary Patient', '01711111112', 'Hypertension, no allergies'),
(2, 2, '1990-03-22', 'A-', 'Female', '456 Park Ave, Dhaka', 'John Doe', '01722222223', 'Asthma'),
(3, 3, '1978-11-05', 'B+', 'Male', '789 Lake Rd, Dhaka', 'Lisa Wilson', '01733333334', 'Diabetic type 2');

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`id`, `name`, `description`) VALUES
(1, 'Cardiology', 'Heart and cardiovascular system'),
(2, 'Dermatology', 'Skin, hair, and nails'),
(3, 'Neurology', 'Brain and nervous system'),
(4, 'Pediatrics', 'Child healthcare'),
(5, 'Orthopedics', 'Bones and joints');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('patient','doctor','receptionist','admin') DEFAULT 'patient',
  `profile_pic` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `role`, `profile_pic`, `is_active`, `created_at`) VALUES
(1, 'John Patient', 'patient1@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '01711111111', 'patient', NULL, 1, '2026-05-17 08:38:45'),
(2, 'Sarah Patient', 'patient2@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '01722222222', 'patient', NULL, 1, '2026-05-17 08:38:45'),
(3, 'Mike Patient', 'patient3@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '01733333333', 'patient', NULL, 1, '2026-05-17 08:38:45'),
(4, 'Dr. John Smith', 'doctor1@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '01744444444', 'doctor', NULL, 1, '2026-05-17 08:38:45'),
(5, 'Dr. Sarah Ahmed', 'doctor2@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '01755555555', 'doctor', NULL, 1, '2026-05-17 08:38:45'),
(6, 'Admin User', 'admin@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '01766666666', 'admin', NULL, 1, '2026-05-17 08:38:45'),
(7, 'Receptionist', 'reception@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '01777777777', 'receptionist', NULL, 1, '2026-05-17 08:38:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `consultation_notes`
--
ALTER TABLE `consultation_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `dependents`
--
ALTER TABLE `dependents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `primary_patient_id` (`primary_patient_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `specialization_id` (`specialization_id`);

--
-- Indexes for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctor_reviews`
--
ALTER TABLE `doctor_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `leave_dates`
--
ALTER TABLE `leave_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `consultation_notes`
--
ALTER TABLE `consultation_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `dependents`
--
ALTER TABLE `dependents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `doctor_reviews`
--
ALTER TABLE `doctor_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `leave_dates`
--
ALTER TABLE `leave_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `billing_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `consultation_notes`
--
ALTER TABLE `consultation_notes`
  ADD CONSTRAINT `consultation_notes_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultation_notes_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `consultation_notes_ibfk_3` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `dependents`
--
ALTER TABLE `dependents`
  ADD CONSTRAINT `dependents_ibfk_1` FOREIGN KEY (`primary_patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `doctors_ibfk_2` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`);

--
-- Constraints for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD CONSTRAINT `doctor_availability_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_reviews`
--
ALTER TABLE `doctor_reviews`
  ADD CONSTRAINT `doctor_reviews_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `doctor_reviews_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `doctor_reviews_ibfk_3` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `leave_dates`
--
ALTER TABLE `leave_dates`
  ADD CONSTRAINT `leave_dates_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
