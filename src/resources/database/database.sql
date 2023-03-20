-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2022 at 06:12 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `image`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'demo@example.com', NULL, '$2y$10$izQP6xySqec7PXn03fxHCeX8gK2K.xHDJ3THTGcIPytSziP4fIHWa', NULL, '2022-10-15 05:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `android_apis`
--

CREATE TABLE `android_apis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Active : 1, Inactive : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `android_api_sim_infos`
--

CREATE TABLE `android_api_sim_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `android_gateway_id` int(11) DEFAULT NULL,
  `sim_number` varchar(90) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_interval` int(11) DEFAULT NULL,
  `sms_remaining` int(11) DEFAULT NULL,
  `send_sms` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT 'Active : 1, Inactive : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `contact_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(90) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Enable : 1, Disable : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit_logs`
--

CREATE TABLE `credit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `trx_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `post_credit` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Active : 1, Inactive : 2, default : 3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'USD', '$', '1.00000000', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_contacts`
--

CREATE TABLE `email_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `email_group_id` int(10) UNSIGNED DEFAULT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(90) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Enable : 1, Disable : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_credit_logs`
--

CREATE TABLE `email_credit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `trx_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `post_credit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_groups`
--

CREATE TABLE `email_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Active : 1, Inactive : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `from_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply_to_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initiated_time` datetime DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `subject` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Pending : 1, Schedule : 2 Fail : 3 Success : 4',
  `schedule_status` tinyint(4) DEFAULT '1' COMMENT 'Send Now : 1, Send Later : 2',
  `response_gateway` varchar(299) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `codes` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Active : 1, Inactive : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `slug`, `subject`, `body`, `codes`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Password Reset', 'PASSWORD_RESET', 'Password Reset', '<p>We have received a request to reset the password for your account on {{code}} and Request time {{time}}</p>', '{\"code\":\"Password Reset Code\", \"time\":\"Time\"}', 1, NULL, '2022-05-30 04:48:02'),
(2, 'Admin Support Reply', 'SUPPORT_TICKET_REPLY', 'Support Ticket Reply', NULL, '{\"ticket_number\":\"Support Ticket Number\",\"link\":\"Ticket URL For relpy\"}', 1, NULL, NULL),
(10, 'Payment Confirmation', 'PAYMENT_CONFIRMED', 'Payment confirm', '<p>Your Transaction Number {{trx}} and payment amount {{amount}} and charge {{charge}}</p>', '{\"trx\":\"Transaction Number\",\"amount\":\"Payment Amount\",\"charge\":\"Payment Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Payment Method name\",\"method_currency\":\"Payment Method Currency\"}', 1, NULL, '2022-07-25 12:34:03'),
(11, 'Admin Password Reset', 'ADMIN_PASSWORD_RESET', 'Admin Password Reset', '<p>We have received a request to reset the password for your account on {{code}} and Request time {{time}}</p>', '{\"code\":\"Password Reset Code\", \"time\":\"Time\"}', 1, NULL, '2022-05-30 04:48:02'),
(12, 'Password Reset Confirm', 'PASSWORD_RESET_CONFIRM', 'Password Reset Confirm', '<p>We have received a request to reset the password for your account on {{code}} and Request time {{time}}</p>', '{\"time\":\"Time\"}', 1, NULL, '2022-05-30 04:48:02'),
(13, 'Registration Verify', 'REGISTRATION_VERIFY', 'Registration Verify', '<p>Hi, {{name}} We have received a request to create an account, you need to verify email first, your verification code is {{code}} and request time {{time}}</p>', '{\"name\":\"Name\", \"code\":\"Password Reset Code\", \"time\":\"Time\"}', 1, NULL, '2022-09-22 04:25:23'),
(14, 'Test Mail', 'TEST_MAIL', 'Mail Configuration Test', '<h5>Hi,<span style=\"background-color: rgb(255, 255, 0);\"> {{name}} </span></h5><h5>This is testing mail for mail configuration.</h5><h5>Request time<span style=\"background-color: rgb(255, 255, 0);\"> {{time}}</span></h5>', '{\"name\":\"Name\",\"time\":\"Time\"}', 1, NULL, '2022-12-12 05:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_gateway` tinyint(4) DEFAULT '1' COMMENT 'Api Gateway : 1, Android Gateway : 2',
  `currency_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_gateway_id` int(11) DEFAULT NULL,
  `email_gateway_id` int(11) DEFAULT NULL,
  `mail_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text COLLATE utf8mb4_unicode_ci,
  `s_login_google_info` text COLLATE utf8mb4_unicode_ci,
  `frontend_section` text COLLATE utf8mb4_unicode_ci,
  `registration_status` tinyint(4) DEFAULT '1' COMMENT 'On : 1, Off : 2',
  `cron_job_run` timestamp NULL DEFAULT NULL,
  `plan_id` int(10) NOT NULL,
  `sign_up_bonus` tinyint(10) NOT NULL,
  `debug_mode` enum('true','false') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  `maintenance_mode` enum('true','false') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  `maintenance_mode_message` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `phone`, `country_code`, `sms_gateway`, `currency_name`, `currency_symbol`, `sms_gateway_id`, `email_gateway_id`, `mail_from`, `email_template`, `s_login_google_info`, `frontend_section`, `registration_status`, `cron_job_run`, `plan_id`, `sign_up_bonus`, `debug_mode`, `maintenance_mode`, `maintenance_mode_message`, `schedule_at`, `created_at`, `updated_at`) VALUES
(2, 'Company Name', '352345234', '1', 1, 'USD', '$', 2, 1, 'support@igensolutionsltd.com', '<p>{{message}}</p>', '{\"g_client_id\":\"#\",\"g_client_secret\":\"#\"}', '{\"heading\":\"Over 1K people using this app. Smooth SMS and Email Marketing tools\",\"sub_heading\":\"Our mass SMS and Email service provide you to reach more client engage, and also you can fill your target with the potential customer on the basis of different types of products and services which is you want to reach your client door. So why late if no account, sign up quickly and get your expect to plan and start from today with the best and cheap SMS cost!\"}', 1, '2022-12-12 18:19:39', 8, 2, 'false', 'false', 'Please be advised that there will be scheduled downtime across our network from 12.00AM to 2.00AM', NULL, '2022-04-13 18:18:21', '2022-12-17 01:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Active : 1, Inactive : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT NULL COMMENT 'default : 1, Not default : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `flag`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'us', 1, '2022-05-16 08:04:28', '2022-12-03 23:38:03');

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Active : 1 Inactive : 2',
  `driver_information` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mails`
--

INSERT INTO `mails` (`id`, `name`, `status`, `driver_information`, `created_at`, `updated_at`) VALUES
(1, 'SMTP', 1, '{\"driver\":\"SMTP\",\"host\":\"\",\"smtp_port\":\"\",\"from\":{\"address\":\"\",\"name\":\"\"},\"encryption\":\"\",\"username\":\"\",\"password\":\"\"}', '2022-09-09 14:52:30', '2022-12-17 01:08:33'),
(2, 'PHP MAIL', 1, NULL, '2022-09-08 18:00:00', '2022-07-20 04:41:46'),
(3, 'SendGrid Api', 1, '{\"app_key\":\"#\",\"from\":{\"address\":\"#\",\"name\":\"#\"}}', '2022-09-08 18:00:00', '2022-09-17 18:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(974, NULL, 'xsender', 'sVI4taykksvLiUXz01w3lTjq0Ao5vfTIhTXXD6I1', NULL, 'http://localhost', 1, 0, 0, '2022-09-19 20:35:57', '2022-09-19 20:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 974, '2022-09-19 20:35:57', '2022-09-19 20:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscriptions_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `method_id` int(11) DEFAULT NULL,
  `charge` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `amount` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `final_amount` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `trx_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT 'Pending : 1, Success : 2, Cancel : 3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `percent_charge` decimal(18,8) DEFAULT NULL,
  `rate` decimal(18,8) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_parameter` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Active : 1, Inactive : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `currency_id`, `percent_charge`, `rate`, `name`, `unique_code`, `image`, `payment_parameter`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '0.00000000', '1.00000000', 'Stripe', 'STRIPE101', '62e7b2232c5ae1659351587.png', '{\"secret_key\":\"sk_test_51LOQWUEfy7yAErveu6z5RjjR4RlbqMmPw1zp5oPGQIXuEPF1HBaqVsRSJFXUaKmaLKlKDFYffxduXnpliICNv4CZ00UEj1igy9\",\"publishable_key\":\"pk_test_51LOQWUEfy7yAErve1U7CN5nmH0taNMfqOT1poxFxUUgdhWvec90hXmm3bSNf3Q0IOfNSOhM3fKp4JwxdjbrpqsaP00hWrEvpct\"}', 1, '2022-05-31 18:25:39', '2022-11-15 21:17:29'),
(3, 1, '1.00000000', '1.00000000', 'Paypal', 'PAYPAL102', '62e7b2507c25f1659351632.png', '{\"environment\":\"sandbox\",\"client_id\":\"AUUkOAidzdHM1hljQpvzXjM5-4g9cyE9GfVdNIuqi8MmAN9bmxs8yFqrfBk62-4aU84RiD9DtCZNaCjg\",\"secret\":\"EBpVGG9swmqbeOKdkFXlCeyoi6lT5qsJZZ8riMKEReHtPs_d8jsabMS_f2b-4AlEm3_1hT2bAxre-yjv\"}', 1, '2022-05-31 18:25:39', '2022-12-17 01:10:18'),
(4, 1, '1.00000000', '1.00000000', 'Paystack', 'PAYSTACK103', '6323760d9aa541663268365.png', '{\"public_key\":\"#\",\"secret_key\":\"#\"}', 1, '2022-05-31 18:25:39', '2022-09-17 23:35:38'),
(5, 1, '1.00000000', '1.00000000', 'SSL Commerz', 'SSLCOMMERZ104', '632375f6814fa1663268342.png', '{\"environment\":\"sandbox\",\"store_id\":\"#\",\"store_password\":\"#\"}', 1, '2022-05-31 18:25:39', '2022-09-17 23:35:46'),
(8, 1, '1.00000000', '1.00000000', 'Paytm', 'PAYTM105', '632375b316fbc1663268275.jpg', '{\"PAYTM_ENVIRONMENT\":\"https:\\/\\/securegw-stage.paytm.in\",\"PAYTM_MID\":\"DIY12386817555501617\",\"PAYTM_MERCHANT_KEY\":\"bKMfNxPPf_QdZppa\",\"PAYTM_WEBSITE\":\"DIYtestingweb\"}', 1, '2022-09-14 18:25:24', '2022-09-17 23:35:55'),
(10, 1, '1.00000000', '1.00000000', 'Instamojo', 'INSTA106', '63237723398f31663268643.jpg', '{\"api_key\":\"test_2241633c3bc44a3de84a3b33969\",\"auth_token\":\"test_279f083f7bebefd35217feef22d\",\"salt\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}', 1, '2022-09-14 18:25:24', '2022-09-17 23:36:15'),
(11, 1, '1.00000000', '1.00000000', 'RazorPay', 'RAZOR107', '6323770cacf5c1663268620.jpg', '{\"key_id\":\"rzp_test_7q0UphmyV22RNm\",\"key_secret\":\"GqxycDi6lkXeA9RT0bNp5SOz\"}', 1, '2022-09-14 18:25:24', '2022-09-17 23:36:22'),
(12, 1, '1.00000000', '1.00000000', 'Flutterwave', 'FLUTTER107', '632376c8e355f1663268552.jpg', '{\"public_key\":\"demo_publisher_ke\",\"secret_key\":\"demo_secret_key\",\"encryption_key\":\"demo_encryption_key\"}', 1, '2022-09-14 18:25:24', '2022-09-17 23:36:30'),
(13, 1, '1.00000000', '1.00000000', 'Coinbase Commerce', 'COINBASE108', '6346fbc3d84591665596355.jpg', '{\"api_key\":\"d714c897-0a5c-4150-9253-e37c051a2151\"}', 1, '2022-10-11 18:25:24', '2022-10-12 08:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pricing_plans`
--

CREATE TABLE `pricing_plans` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `credit` int(11) DEFAULT NULL,
  `email_credit` int(11) DEFAULT NULL,
  `whatsapp_credit` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Active : 1, Inactive : 2',
  `recommended_status` tinyint(4) DEFAULT NULL COMMENT 'Active : 1, Inactive : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricing_plans`
--

INSERT INTO `pricing_plans` (`id`, `name`, `amount`, `credit`, `email_credit`, `whatsapp_credit`, `duration`, `status`, `recommended_status`, `created_at`, `updated_at`) VALUES
(8, 'Free', '0.00000000', 5, 20, 40, 5, 1, 2, '2022-09-18 06:41:44', '2022-09-18 06:41:44'),
(9, 'Basic', '19.00000000', 500, 1500, 5000, 10, 1, 1, '2022-09-18 06:42:05', '2022-12-05 01:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `sms_gateways`
--

CREATE TABLE `sms_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gateway_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credential` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Active : 1, Inactive : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_gateways`
--

INSERT INTO `sms_gateways` (`id`, `gateway_code`, `name`, `credential`, `status`, `created_at`, `updated_at`) VALUES
(1, '101NEX', 'nexmo', '{\"api_key\":\"#\",\"api_secret\":\"#\",\"sender_id\":\"#\"}', 1, '2022-09-09 20:33:40', '2022-09-17 18:42:40'),
(2, '102TWI', 'twilio', '{\"account_sid\":\"@\",\"auth_token\":\"@\",\"from_number\":\"@\",\"sender_id\":\"@\"}', 1, '2022-09-09 20:33:40', '2022-09-17 18:42:28'),
(3, '103BIRD', 'message Bird', '{\"access_key\":\"#\",\"sender_id\":\"#\"}', 1, '2022-09-09 18:00:00', '2022-09-17 18:43:01'),
(4, '104MAG', 'Text Magic', '{\"api_key\":\"#\",\"text_magic_username\":\"#\",\"sender_id\":\"#\"}', 1, '2022-09-09 20:33:40', '2022-09-17 18:43:17'),
(5, '105CLICKATELL', 'Clickatell', '{\"clickatell_api_key\":\"#\",\"sender_id\":\"#\"}', 1, '2022-09-09 20:20:14', '2022-09-17 18:43:30'),
(6, '106INFOBIP', 'InfoBip', '{\"infobip_base_url\":\"#\",\"infobip_api_key\":\"#\",\"sender_id\":\"#\"}', 1, '2022-09-09 20:20:14', '2022-09-17 18:43:45'),
(7, '107SMSBROADCAST', 'SMS Broadcast', '{\"sms_broadcast_username\":\"#\",\"sms_broadcast_password\":\"#\",\"sender_id\":\"#\"}', 1, '2022-09-09 20:20:14', '2022-09-17 18:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `amount` decimal(18,8) DEFAULT NULL,
  `expired_date` timestamp NULL DEFAULT NULL,
  `trx_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT 'Running : 1, Expired : 2,Inactive :3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_files`
--

CREATE TABLE `support_files` (
  `id` int(20) UNSIGNED NOT NULL,
  `support_message_id` int(10) UNSIGNED DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `support_ticket_id` int(10) UNSIGNED DEFAULT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Running : 1, Answered : 2, Replied : 3, closed : 4',
  `priority` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Low : 1, medium : 2 high: 3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s_m_slogs`
--

CREATE TABLE `s_m_slogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_gateway_id` int(11) DEFAULT NULL,
  `android_gateway_sim_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initiated_time` datetime DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) DEFAULT '0' COMMENT 'Pending : 1, Schedule : 2 Fail : 3 Success: 4',
  `schedule_status` tinyint(4) DEFAULT '1' COMMENT 'Send Now : 1, Send Later : 2',
  `response_gateway` varchar(259) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(2) DEFAULT NULL COMMENT '1:pendding, 2:approve, 3:reject',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_method_id` tinyint(4) NOT NULL DEFAULT '1',
  `amount` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `transaction_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_number` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` int(11) NOT NULL DEFAULT '0',
  `email_credit` int(11) NOT NULL DEFAULT '0',
  `whatsapp_credit` varchar(299) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `address` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT 'Active : 1, Banned : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wa_device`
--

CREATE TABLE `wa_device` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `number` varchar(259) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(259) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(259) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delay_time` varchar(259) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('connected','disconnected','initiate') COLLATE utf8mb4_unicode_ci NOT NULL,
  `multidevice` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp_credit_logs`
--

CREATE TABLE `whatsapp_credit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `trx_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `post_credit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp_logs`
--

CREATE TABLE `whatsapp_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `whatsapp_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initiated_time` datetime DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(299) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT 'Pending : 1, Schedule : 2 Fail : 3 Success: 4',
  `schedule_status` tinyint(4) DEFAULT '1' COMMENT 'Send Now : 1, Send Later : 2',
  `response_gateway` varchar(259) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `android_apis`
--
ALTER TABLE `android_apis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `android_api_sim_infos`
--
ALTER TABLE `android_api_sim_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_logs`
--
ALTER TABLE `credit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_contacts`
--
ALTER TABLE `email_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_credit_logs`
--
ALTER TABLE `email_credit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_groups`
--
ALTER TABLE `email_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_unique_code_unique` (`unique_code`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_gateways`
--
ALTER TABLE `sms_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_files`
--
ALTER TABLE `support_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s_m_slogs`
--
ALTER TABLE `s_m_slogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wa_device`
--
ALTER TABLE `wa_device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whatsapp_credit_logs`
--
ALTER TABLE `whatsapp_credit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whatsapp_logs`
--
ALTER TABLE `whatsapp_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `android_apis`
--
ALTER TABLE `android_apis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `android_api_sim_infos`
--
ALTER TABLE `android_api_sim_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit_logs`
--
ALTER TABLE `credit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_contacts`
--
ALTER TABLE `email_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_credit_logs`
--
ALTER TABLE `email_credit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_groups`
--
ALTER TABLE `email_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=975;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sms_gateways`
--
ALTER TABLE `sms_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_files`
--
ALTER TABLE `support_files`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `s_m_slogs`
--
ALTER TABLE `s_m_slogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wa_device`
--
ALTER TABLE `wa_device`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `whatsapp_credit_logs`
--
ALTER TABLE `whatsapp_credit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `whatsapp_logs`
--
ALTER TABLE `whatsapp_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
