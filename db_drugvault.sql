-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 03, 2024 at 04:22 AM
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
-- Database: `db_drugvault`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` char(36) NOT NULL,
  `upid_menu` varchar(36) NOT NULL DEFAULT '0',
  `code_menu` varchar(15) NOT NULL,
  `name_menu` varchar(100) NOT NULL,
  `link_menu` varchar(255) DEFAULT NULL,
  `icon_menu` varchar(50) DEFAULT NULL,
  `action_menu` mediumtext NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `upid_menu`, `code_menu`, `name_menu`, `link_menu`, `icon_menu`, `action_menu`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0ab9d815-00d0-4a21-be14-494567f6dcb2', '7570da2b-2029-4084-aeee-4ceafef60d5f', 'MD-DC', 'Drug\'s Category', 'drug-category', 'fas fa-hand-holding-medical', 'create,read,update,delete,detail,list', '2023-06-20 04:21:26', '2023-06-22 07:51:07', NULL),
('0ac2a0e2-0698-45f7-8375-a13620e91823', '7570da2b-2029-4084-aeee-4ceafef60d5f', 'MD-CNTRY', 'Country', 'country', 'fas fa-globe-asia', 'create,read,update,delete,detail,list', '2023-06-20 04:23:45', '2023-06-20 04:23:45', NULL),
('1881ba1e-2ffb-4300-ac8e-1c7f7e5a7d09', '7570da2b-2029-4084-aeee-4ceafef60d5f', 'MD-PH', 'Pharma Manufacturers', 'pharma', 'fas fa-mortar-pestle', 'create,read,update,delete,detail,list', '2023-06-20 04:12:52', '2023-06-22 03:53:26', NULL),
('2a791efb-5305-4f29-8df0-e421f031dc13', '7570da2b-2029-4084-aeee-4ceafef60d5f', 'MD-DT', 'Drug\'s Type', 'drug-type', 'fas fa-pills', 'create,read,update,delete,detail,list', '2023-06-20 04:20:05', '2023-06-20 04:20:05', NULL),
('3e8b7d14-8924-48d3-a2d5-8e0fc7e328a1', 'd313fc32-deea-450e-9d40-172e5b560f7d', 'USR', 'User', 'user', 'fas fa-user', 'create,read,update,delete,detail,list,reset', '2023-06-09 17:50:49', '2023-06-09 17:50:49', NULL),
('3ebe9d4e-8565-4ae4-a9b0-5176cafeb53d', '8596bc68-47fc-4c61-bdd1-94a28d4d785c', 'RNA-Y', 'Yearly Report', 'yearly-report', 'fas fa-calendar-alt', 'read,list', '2023-07-02 18:29:12', '2023-07-02 18:29:12', NULL),
('7570da2b-2029-4084-aeee-4ceafef60d5f', '0', 'MD', 'Master Data', '#', 'fas fa-server', 'read,list', '2023-06-19 16:12:53', '2023-06-20 04:30:56', NULL),
('7fe036ac-2f10-471a-a1e9-3eea4be25b20', '7570da2b-2029-4084-aeee-4ceafef60d5f', 'MD-D', 'Drugs', 'drug', 'fas fa-capsules', 'create,read,update,delete,detail,list', '2023-06-20 04:18:57', '2023-06-20 04:19:06', NULL),
('8596bc68-47fc-4c61-bdd1-94a28d4d785c', '0', 'RNA', 'Report & Analytics', 'report', 'fas fa-chart-bar', 'read,list', '2023-07-02 12:41:38', '2023-07-03 14:43:45', NULL),
('906ebe05-36e9-4655-be8c-726ff553be96', 'd313fc32-deea-450e-9d40-172e5b560f7d', 'ROLE', 'User Role', 'role', 'fas fa-user-tag', 'create,read,update,delete,detail,list,privilege', '2023-06-09 17:56:58', '2023-06-09 17:56:58', NULL),
('ade595d5-93e0-4423-8f1a-36ef74fd4f53', '8596bc68-47fc-4c61-bdd1-94a28d4d785c', 'RNA-M', 'Monthly Report', 'monthly-report', 'fas fa-calendar-week', 'read,list', '2023-07-02 18:24:50', '2023-07-02 18:28:15', NULL),
('b6ed48f4-e362-488e-aa62-1210e95215f0', '0', 'HOME', 'Dashboard', 'home', 'fas fa-th-large', 'read,list', '2023-06-20 04:42:10', '2023-07-03 14:46:28', NULL),
('d313fc32-deea-450e-9d40-172e5b560f7d', '0', 'USM', 'User Management', '#', 'fas fa-users', 'read,list', '2023-06-09 17:49:11', '2023-06-20 04:32:56', NULL),
('dc9dfcdf-3588-4e1a-8a93-5b2fed65b88f', '0', 'SL', 'Storage Logs', 'storage-log', 'fas fa-warehouse', 'create,read,delete,detail,list,cancel', '2023-06-21 11:06:56', '2023-06-22 13:00:16', NULL),
('e922542c-d5e2-4e58-969e-21fe35a63eda', '0', 'MM', 'Master Menu', 'menu', 'fas fa-list-alt', 'create,read,update,delete,detail,list', '2023-06-19 04:41:17', '2023-06-19 04:41:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_auth`
--

CREATE TABLE `menu_auth` (
  `id_menu_auth` char(36) NOT NULL,
  `role_id` char(36) NOT NULL,
  `menu_id` char(36) NOT NULL,
  `action_menu_auth` mediumtext,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_auth`
--

INSERT INTO `menu_auth` (`id_menu_auth`, `role_id`, `menu_id`, `action_menu_auth`, `is_active`, `created_at`, `updated_at`) VALUES
('0685ee98-dfac-4e8f-ac15-cf27b86d174b', 'b35c17a5-9fbb-4d83-b797-2ad146625144', 'e922542c-d5e2-4e58-969e-21fe35a63eda', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('107c332b-1799-4ce1-b072-f2a14691cf4f', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', 'ade595d5-93e0-4423-8f1a-36ef74fd4f53', 'read,list', '1', '2023-07-02 18:29:56', '2023-07-02 18:29:56'),
('10e40be4-6462-4893-8d97-648e00c62e8f', 'b35c17a5-9fbb-4d83-b797-2ad146625144', 'd313fc32-deea-450e-9d40-172e5b560f7d', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('1303bfea-8201-4a47-8bc4-3eb6014a7570', 'b35c17a5-9fbb-4d83-b797-2ad146625144', '0ab9d815-00d0-4a21-be14-494567f6dcb2', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('1553a495-eafa-4f7d-a560-1d93fe8aa0f2', '31417a8f-6a2a-4d7c-9884-85c83d483f89', 'd313fc32-deea-450e-9d40-172e5b560f7d', NULL, '0', '2023-06-22 03:19:41', '2023-06-22 03:19:41'),
('1cc3235c-d8fc-403a-aff8-08a18da27767', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', 'd313fc32-deea-450e-9d40-172e5b560f7d', 'read,list', '1', '2023-06-20 08:32:57', '2023-06-20 08:32:57'),
('22a1d147-3e68-4d89-8ee3-8c5488a9ade5', '31417a8f-6a2a-4d7c-9884-85c83d483f89', '0ab9d815-00d0-4a21-be14-494567f6dcb2', NULL, '0', '2023-06-22 03:19:41', '2023-06-22 03:19:41'),
('281ddb4f-c3a2-4415-8366-8f397c9e2839', '31417a8f-6a2a-4d7c-9884-85c83d483f89', '2a791efb-5305-4f29-8df0-e421f031dc13', NULL, '0', '2023-06-22 03:19:41', '2023-06-22 03:19:41'),
('2cd77ab7-f8f4-4b32-84e7-9c632284a64e', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '3ebe9d4e-8565-4ae4-a9b0-5176cafeb53d', 'read,list', '1', '2023-07-02 18:29:56', '2023-07-02 18:29:56'),
('3cc225d1-943e-4d19-8d28-77be33e1398f', '31417a8f-6a2a-4d7c-9884-85c83d483f89', '0ac2a0e2-0698-45f7-8375-a13620e91823', 'create,read,update,delete,detai,list', '1', '2023-06-22 03:19:41', '2023-06-22 03:45:46'),
('4a5170ec-237d-46e4-bf02-71cc6b43de32', 'b35c17a5-9fbb-4d83-b797-2ad146625144', '906ebe05-36e9-4655-be8c-726ff553be96', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('4ad3081a-2b61-48f9-a697-47f34e517149', '31417a8f-6a2a-4d7c-9884-85c83d483f89', '3e8b7d14-8924-48d3-a2d5-8e0fc7e328a1', NULL, '0', '2023-06-22 03:19:41', '2023-06-22 03:19:41'),
('56dbf3fb-6fc0-49cb-8fa6-048e234dc604', '31417a8f-6a2a-4d7c-9884-85c83d483f89', '7fe036ac-2f10-471a-a1e9-3eea4be25b20', NULL, '0', '2023-06-22 03:19:41', '2023-06-22 03:19:41'),
('5a456cd6-50bb-46f7-92e0-5e832e1e76d4', 'b35c17a5-9fbb-4d83-b797-2ad146625144', '3e8b7d14-8924-48d3-a2d5-8e0fc7e328a1', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('5f84a5fa-2045-4674-815b-856966209719', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '1881ba1e-2ffb-4300-ac8e-1c7f7e5a7d09', 'create,read,update,delete,detail,list', '1', '2023-06-20 08:32:57', '2023-06-20 08:37:10'),
('64ebc6a2-ddff-496a-9a04-088b6b030a6f', 'b35c17a5-9fbb-4d83-b797-2ad146625144', '7570da2b-2029-4084-aeee-4ceafef60d5f', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('6c024508-8561-408a-89f6-70757aa2752e', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '0ac2a0e2-0698-45f7-8375-a13620e91823', 'create,read,update,delete,detail,list', '1', '2023-06-20 08:32:57', '2023-06-20 08:36:59'),
('7ef8cdfb-f24e-4fbd-8b72-e3521944fbf7', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '906ebe05-36e9-4655-be8c-726ff553be96', 'create,read,update,delete,detail,list,privilege', '1', '2023-06-09 18:00:03', '2023-06-20 08:34:54'),
('84aceee5-a6d2-4a15-97b5-4a14e83d1721', 'b35c17a5-9fbb-4d83-b797-2ad146625144', 'dc9dfcdf-3588-4e1a-8a93-5b2fed65b88f', 'create,read,list', '1', '2023-06-22 03:53:10', '2023-06-22 04:02:10'),
('867c6a90-ceff-421e-b70e-8472c959d676', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '0ab9d815-00d0-4a21-be14-494567f6dcb2', 'create,read,update,delete,detail,list', '1', '2023-06-20 08:32:57', '2023-06-20 08:36:59'),
('88934c78-69df-48b5-976c-77dd5e4d90c8', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', 'e922542c-d5e2-4e58-969e-21fe35a63eda', 'create,read,update,delete,detail,list', '1', '2023-06-19 04:41:21', '2023-06-19 04:41:21'),
('8fe3ce0b-b261-4218-a62a-abe140fca4c4', 'b35c17a5-9fbb-4d83-b797-2ad146625144', '0ac2a0e2-0698-45f7-8375-a13620e91823', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('93ef698a-2f3c-4466-9ee4-8ed88d186ac6', 'b35c17a5-9fbb-4d83-b797-2ad146625144', '1881ba1e-2ffb-4300-ac8e-1c7f7e5a7d09', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('949e4b39-519f-421a-921f-a521b02638e5', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '3e8b7d14-8924-48d3-a2d5-8e0fc7e328a1', 'create,update,delete,detail,reset,read,list', '1', '2023-06-09 17:59:41', '2023-07-04 03:27:14'),
('977c65d6-8d76-46ab-8c8e-e3fd2d3d3e24', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', 'dc9dfcdf-3588-4e1a-8a93-5b2fed65b88f', 'create,read,delete,detail,list,cancel', '1', '2023-06-21 11:07:47', '2023-06-22 13:00:46'),
('9dde69a4-3fdb-4107-acfe-fbc1ff6dce40', '31417a8f-6a2a-4d7c-9884-85c83d483f89', 'dc9dfcdf-3588-4e1a-8a93-5b2fed65b88f', NULL, '0', '2023-06-22 03:19:41', '2023-06-22 03:19:41'),
('9fc7520d-d5c5-4377-91bc-d0d4b4e3802a', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '8596bc68-47fc-4c61-bdd1-94a28d4d785c', 'read,list', '1', '2023-07-02 12:43:08', '2023-07-02 12:43:08'),
('a3336d4f-1699-4f76-b87d-58e8385d1be9', '31417a8f-6a2a-4d7c-9884-85c83d483f89', 'e922542c-d5e2-4e58-969e-21fe35a63eda', NULL, '0', '2023-06-22 03:19:41', '2023-06-22 03:19:41'),
('a8d843dc-dbef-4710-adfa-6f233c4b898b', '31417a8f-6a2a-4d7c-9884-85c83d483f89', '1881ba1e-2ffb-4300-ac8e-1c7f7e5a7d09', 'create,read,update,delete,detail,list', '1', '2023-06-22 03:19:41', '2023-06-22 03:49:52'),
('b88d93f7-dac3-4d6c-a19f-27e480373978', 'b35c17a5-9fbb-4d83-b797-2ad146625144', '2a791efb-5305-4f29-8df0-e421f031dc13', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('b9e888e5-a632-4d18-8d46-5cdbfed00632', '31417a8f-6a2a-4d7c-9884-85c83d483f89', '7570da2b-2029-4084-aeee-4ceafef60d5f', 'read,list', '1', '2023-06-22 03:19:41', '2023-06-22 03:45:46'),
('c715b525-4fb0-42dc-ad72-567505c76aab', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '7fe036ac-2f10-471a-a1e9-3eea4be25b20', 'create,read,update,delete,detail,list', '1', '2023-06-20 08:32:57', '2023-06-20 08:37:00'),
('c9a27cd3-e2fa-43f3-ba46-0200ce3f7c85', '31417a8f-6a2a-4d7c-9884-85c83d483f89', '906ebe05-36e9-4655-be8c-726ff553be96', NULL, '0', '2023-06-22 03:19:41', '2023-06-22 03:19:41'),
('ddf52ec1-dca3-4c97-9f5d-353fc9296ca9', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '2a791efb-5305-4f29-8df0-e421f031dc13', 'create,read,update,delete,detail,list', '1', '2023-06-20 08:32:57', '2023-06-20 08:37:10'),
('e58ac162-3c14-440a-82bf-d8aaa24b74e9', '31417a8f-6a2a-4d7c-9884-85c83d483f89', 'b6ed48f4-e362-488e-aa62-1210e95215f0', 'read,list', '1', '2023-06-22 03:19:41', '2023-06-22 03:19:41'),
('eb943c4b-e264-4008-9909-e0547f07f09f', 'b35c17a5-9fbb-4d83-b797-2ad146625144', '7fe036ac-2f10-471a-a1e9-3eea4be25b20', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('ecbd675f-76f7-4ad3-9f0e-d42b5068d498', 'b35c17a5-9fbb-4d83-b797-2ad146625144', 'b6ed48f4-e362-488e-aa62-1210e95215f0', NULL, '0', '2023-06-22 03:53:10', '2023-06-22 03:53:10'),
('ed9beafa-e818-42a0-be6d-318f963159d9', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', '7570da2b-2029-4084-aeee-4ceafef60d5f', 'read,list', '1', '2023-06-20 08:32:57', '2023-06-20 08:32:57'),
('ff3cce02-34c1-4f14-a82f-3ed3eb6c5e92', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', 'b6ed48f4-e362-488e-aa62-1210e95215f0', 'read,list', '1', '2023-06-20 08:32:57', '2023-06-20 08:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `ms_country`
--

CREATE TABLE `ms_country` (
  `id_country` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `name_country` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_country`
--

INSERT INTO `ms_country` (`id_country`, `user_id`, `name_country`, `created_at`, `updated_at`, `deleted_at`) VALUES
('3b293be3-5a15-4e09-a6a9-d6d6abaadf14', 'a4847186-7225-4301-a65f-bb7e54012391', 'USA (United States of America)', '2023-06-20 15:07:14', '2023-06-20 15:10:20', NULL),
('5d906a93-18cd-4e3a-baf2-1e2b32e430a7', 'a4847186-7225-4301-a65f-bb7e54012391', 'Indonesia', '2023-06-20 15:02:58', '2023-06-20 15:02:58', NULL),
('e7c5ce0a-4789-4234-8332-7936a4d7a533', 'a4847186-7225-4301-a65f-bb7e54012391', 'UK (United Kingdom)', '2023-06-20 15:06:22', '2023-06-20 15:06:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ms_drug`
--

CREATE TABLE `ms_drug` (
  `id_drug` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `pharma_id` char(36) NOT NULL,
  `drug_type_id` char(36) NOT NULL,
  `drug_category_id` char(36) NOT NULL,
  `name_drug` varchar(255) NOT NULL,
  `qty_drug` int(11) DEFAULT NULL,
  `note_drug` varchar(255) DEFAULT NULL,
  `avatar_drug` varchar(255) DEFAULT NULL,
  `avatar_mimetype_drug` varchar(50) DEFAULT NULL,
  `avatar_originalfile_drug` varchar(255) DEFAULT NULL,
  `avatar_originalmimetype_drug` varchar(50) DEFAULT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_drug`
--

INSERT INTO `ms_drug` (`id_drug`, `user_id`, `pharma_id`, `drug_type_id`, `drug_category_id`, `name_drug`, `qty_drug`, `note_drug`, `avatar_drug`, `avatar_mimetype_drug`, `avatar_originalfile_drug`, `avatar_originalmimetype_drug`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('c577ce40-15de-480a-9d9d-fa35fdf826fe', 'a4847186-7225-4301-a65f-bb7e54012391', '41db1e14-462d-47d0-92c0-4194a4fd741b', '20dcbbe8-5dc9-48e3-955e-d8a0de31a362', 'b30df3eb-b0f3-47c1-bd5d-5296305b575e', 'Sanbe Paracetamol', 2790, NULL, NULL, NULL, NULL, NULL, '1', '2023-06-22 03:22:53', '2023-07-10 09:54:49', NULL),
('d567a6de-b094-489a-b164-5e3c82b9ce4f', 'a4847186-7225-4301-a65f-bb7e54012391', '974738e9-1225-4574-8edf-8412439ad0c4', '20dcbbe8-5dc9-48e3-955e-d8a0de31a362', 'ce5e7b0f-4fa4-45c9-894c-f785d91ab6f3', 'Paratusin', 5595, 'Isi 10 Tablet', 'drug-avatar/RXVqzsibnljMWUWFrr3jUqmDkv4sg1zDAVQjzObD.jpg', 'image/jpeg', 'paratusin.jpg', 'jpg', '1', '2023-06-20 18:54:24', '2023-07-10 03:21:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ms_drug_category`
--

CREATE TABLE `ms_drug_category` (
  `id_drug_category` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `name_drug_category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_drug_category`
--

INSERT INTO `ms_drug_category` (`id_drug_category`, `user_id`, `name_drug_category`, `created_at`, `updated_at`, `deleted_at`) VALUES
('293dcbb9-2f0e-485d-a145-71464ebb1f06', 'a4847186-7225-4301-a65f-bb7e54012391', 'Herbal (Terstandar)', '2023-06-20 17:30:16', '2023-06-20 17:30:16', NULL),
('3507cc15-ebaf-4dca-b5b7-b81fba337bdf', 'a4847186-7225-4301-a65f-bb7e54012391', 'Wajib Apotek', '2023-06-20 17:27:48', '2023-06-20 17:27:48', NULL),
('4667aad7-9a31-4125-8c17-b06cb7752da7', 'a4847186-7225-4301-a65f-bb7e54012391', 'Herbal (Jamu)', '2023-06-20 17:28:36', '2023-06-20 17:29:53', NULL),
('491cb825-b184-4fa1-a314-5b342dd4e638', 'a4847186-7225-4301-a65f-bb7e54012391', 'Psikotropika', '2023-06-20 17:28:08', '2023-06-20 17:28:27', NULL),
('50d2a02d-18d7-4496-aec3-47136d17042b', 'a4847186-7225-4301-a65f-bb7e54012391', 'Keras', '2023-06-20 17:26:05', '2023-06-20 17:26:05', NULL),
('51182c3c-6256-482c-b06f-42d0ab6eddf4', 'a4847186-7225-4301-a65f-bb7e54012391', 'Herbal (Fitofarmaka)', '2023-06-20 17:30:35', '2023-06-20 17:30:35', NULL),
('7bd90f56-00f5-4689-80e9-82900dc541b1', 'a4847186-7225-4301-a65f-bb7e54012391', 'Narkotika', '2023-06-20 17:27:55', '2023-06-20 17:27:55', NULL),
('b30df3eb-b0f3-47c1-bd5d-5296305b575e', 'a4847186-7225-4301-a65f-bb7e54012391', 'Bebas', '2023-06-20 17:25:39', '2023-06-20 17:25:39', NULL),
('ce5e7b0f-4fa4-45c9-894c-f785d91ab6f3', 'a4847186-7225-4301-a65f-bb7e54012391', 'Bebas Terbatas', '2023-06-20 17:25:54', '2023-06-20 17:25:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ms_drug_type`
--

CREATE TABLE `ms_drug_type` (
  `id_drug_type` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `name_drug_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_drug_type`
--

INSERT INTO `ms_drug_type` (`id_drug_type`, `user_id`, `name_drug_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1a1fbe41-dbd4-41ab-80d0-d59077890db9', 'a4847186-7225-4301-a65f-bb7e54012391', 'Inhaler', '2023-06-20 17:16:06', '2023-06-20 17:16:06', NULL),
('20dcbbe8-5dc9-48e3-955e-d8a0de31a362', 'a4847186-7225-4301-a65f-bb7e54012391', 'Tablet', '2023-06-20 17:14:16', '2023-06-20 17:14:16', NULL),
('372b5e6c-6621-4f77-8441-ae7890ee5753', 'a4847186-7225-4301-a65f-bb7e54012391', 'Supositoria', '2023-06-20 17:15:32', '2023-06-20 17:15:32', NULL),
('4a9be6e9-b830-4e40-8fee-6433c57b596e', 'a4847186-7225-4301-a65f-bb7e54012391', 'Implan / Tempel', '2023-06-20 17:16:30', '2023-06-20 17:16:30', NULL),
('5a055d8e-1aa0-49ee-903f-3938db52db3d', 'a4847186-7225-4301-a65f-bb7e54012391', 'Cair', '2023-06-20 17:13:59', '2023-06-20 17:13:59', NULL),
('95991d82-145b-4e7e-9ec4-c4558f002db1', 'a4847186-7225-4301-a65f-bb7e54012391', 'Tetes', '2023-06-20 17:15:59', '2023-06-20 17:15:59', NULL),
('973d020d-31d8-4040-b1c4-4a04748aa736', 'a4847186-7225-4301-a65f-bb7e54012391', 'Bukal / Sublingual', '2023-06-20 17:16:47', '2023-06-20 17:16:47', NULL),
('ae747900-56ea-448d-af06-35c6a75999ee', 'a4847186-7225-4301-a65f-bb7e54012391', 'Suntik', '2023-06-20 17:16:19', '2023-06-20 17:16:19', NULL),
('b17c5bee-3546-4fa0-91f5-5c46424625fc', 'a4847186-7225-4301-a65f-bb7e54012391', 'Kapsul', '2023-06-20 17:14:24', '2023-06-20 17:14:24', NULL),
('c5b8eccd-4eb8-4db5-985d-204d680d2da1', 'a4847186-7225-4301-a65f-bb7e54012391', 'Oles', '2023-06-20 17:14:46', '2023-06-20 17:14:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ms_pharma`
--

CREATE TABLE `ms_pharma` (
  `id_pharma` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `country_id` char(36) NOT NULL,
  `name_pharma` varchar(255) NOT NULL,
  `address_pharma` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_pharma`
--

INSERT INTO `ms_pharma` (`id_pharma`, `user_id`, `country_id`, `name_pharma`, `address_pharma`, `created_at`, `updated_at`, `deleted_at`) VALUES
('41db1e14-462d-47d0-92c0-4194a4fd741b', 'a4847186-7225-4301-a65f-bb7e54012391', '5d906a93-18cd-4e3a-baf2-1e2b32e430a7', 'PT Sanbe Farma', 'Jl. Tamansari No.10, Kota Bandung, Jawa Barat 40116', '2023-06-20 16:12:01', '2023-06-20 16:12:01', NULL),
('974738e9-1225-4574-8edf-8412439ad0c4', 'a4847186-7225-4301-a65f-bb7e54012391', '5d906a93-18cd-4e3a-baf2-1e2b32e430a7', 'PT Darya-Varia Laboratoria Tbk', 'Jl. R.A. Kartini Kav.8, DKI Jakarta 12430', '2023-06-20 16:02:08', '2023-06-20 16:12:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ms_role`
--

CREATE TABLE `ms_role` (
  `id_role` char(36) NOT NULL,
  `code_role` varchar(20) NOT NULL,
  `name_role` varchar(50) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_role`
--

INSERT INTO `ms_role` (`id_role`, `code_role`, `name_role`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('31417a8f-6a2a-4d7c-9884-85c83d483f89', 'GUEST', 'Guest', '1', '2023-06-19 04:19:06', '2023-06-22 03:20:05', NULL),
('58da3a69-81d3-4d0e-bb11-7ce569ea05bd', 'ADM', 'Admin', '1', '2023-06-09 17:06:50', '2023-06-09 17:06:50', NULL),
('b35c17a5-9fbb-4d83-b797-2ad146625144', 'OP', 'Operator', '1', '2023-06-22 03:52:07', '2023-07-02 13:07:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ms_user`
--

CREATE TABLE `ms_user` (
  `id` char(36) NOT NULL,
  `role_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sandi` varchar(50) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `avatar_mimetype` varchar(50) DEFAULT NULL,
  `avatar_originalfile` varchar(255) DEFAULT NULL,
  `avatar_originalmimetype` varchar(50) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ms_user`
--

INSERT INTO `ms_user` (`id`, `role_id`, `name`, `username`, `password`, `sandi`, `avatar`, `avatar_mimetype`, `avatar_originalfile`, `avatar_originalmimetype`, `remember_token`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('a4847186-7225-4301-a65f-bb7e54012391', '58da3a69-81d3-4d0e-bb11-7ce569ea05bd', 'DrugVault Dev', 'drugvault-dev', '$2y$10$.ccT8LF9kuT88HwYlAzSGulUA48sqOq/3GS8UqzZhP5cgjIbWClQ2', 'drugvault', NULL, NULL, NULL, NULL, 'AFGYUJxqnXdX1Dkhbcpo6WqBwxSNxYHaHtKXwfzlwZq82fyyDaNHplSTjJDk', '1', '2023-06-09 17:06:56', '2023-06-09 17:06:56', NULL),
('f1dbe306-b4f7-4815-9881-56103c4476a4', 'b35c17a5-9fbb-4d83-b797-2ad146625144', 'Retno', 'retno', '$2y$10$vm/HhElMhJG98XciwhqfHuEM6w5lfy.Ey5w551sNa8G3YavIEijx.', 'drugvault', NULL, NULL, NULL, NULL, 'KXsw5p3sXw9Ci5QjNZpfcZG7bt3PZtfiVANDYjmMQctjoYjEluzUAvWUPAeE', '1', '2023-06-22 03:54:36', '2023-07-03 23:50:06', NULL),
('fe3b1ef5-3396-41d6-b425-fcbfd37cfdea', '31417a8f-6a2a-4d7c-9884-85c83d483f89', 'Testing', 'testing', '$2y$10$vrRGmuwk/S0g/WB7ehYKteQMXHZpbp1fbnd2RzNLmasObeQXyyLD2', 'drugvault', NULL, NULL, NULL, NULL, 'zH32X7AqOIW1erNCIGj4VsAkX2pqrSRb5b745tHTSVWH86gf2bL7mrc7RnWH', '1', '2023-06-18 08:58:12', '2023-06-22 03:20:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_storage`
--

CREATE TABLE `tb_storage` (
  `id_storage` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `drug_id` char(36) NOT NULL,
  `type_storage` enum('IN','OUT') NOT NULL,
  `qty_storage` int(11) NOT NULL,
  `expired_storage` date NOT NULL,
  `note_storage` varchar(255) DEFAULT NULL,
  `is_cancelled` enum('0','1','2') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_storage`
--

INSERT INTO `tb_storage` (`id_storage`, `user_id`, `drug_id`, `type_storage`, `qty_storage`, `expired_storage`, `note_storage`, `is_cancelled`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0e46bc7d-26b6-4d23-9e9c-8c3ae89d4521', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 50, '2024-01-30', NULL, '0', '2023-06-21 17:04:07', '2023-06-21 17:04:07', NULL),
('20210dec-6b03-4d34-8118-c9b9fd484355', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 10, '2024-03-30', NULL, '0', '2023-06-21 17:32:17', '2023-06-21 17:32:17', NULL),
('27b9d100-ba87-402f-b9ad-a6ba1bbf56e7', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 80, '2024-03-30', NULL, '0', '2023-06-21 17:04:07', '2023-06-21 17:04:07', NULL),
('28d24f37-b423-4681-876c-2f89b5f4ee0e', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 520, '2026-09-22', NULL, '2', '2023-06-22 10:52:41', '2023-06-22 15:34:24', NULL),
('291dbf58-896a-4979-977a-3f4c98895052', 'a4847186-7225-4301-a65f-bb7e54012391', 'c577ce40-15de-480a-9d9d-fa35fdf826fe', 'IN', 250, '2024-03-30', NULL, '0', '2023-06-24 10:59:32', '2023-06-24 10:59:32', NULL),
('2a8fddca-ff13-41c9-a776-311cc76cc5e1', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 200, '2028-03-30', NULL, '0', '2023-06-24 10:59:32', '2023-06-24 10:59:32', NULL),
('3bc1b292-2e0e-4210-9bb3-43fa6137666f', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'IN', 80, '2028-03-30', NULL, '2', '2023-06-22 10:52:41', '2023-06-22 15:38:11', NULL),
('42d16e14-26d1-4837-8640-1a6760d12460', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 750, '2026-09-22', NULL, '0', '2023-06-22 18:52:26', '2023-06-22 18:52:26', NULL),
('4be24825-c99d-4a2f-b674-8f60ecd4fed9', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'IN', 120, '2028-03-30', NULL, '0', '2023-06-22 07:14:30', '2023-06-22 07:14:30', NULL),
('4e7b66a9-a90a-4776-9d1f-cf49ee1d30e6', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 70, '2024-01-30', NULL, '0', '2023-06-21 16:30:46', '2023-06-21 16:30:46', NULL),
('5caa73ef-c844-4824-959d-54c3eba157f6', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'IN', 90, '2024-03-30', 'Inisiasi Awal Stok', '0', '2023-06-21 16:19:54', '2023-06-21 16:19:54', NULL),
('644c4bd1-0076-4132-a865-97600a4cd50b', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'IN', 3400, '2028-12-12', NULL, '0', '2023-06-24 11:02:06', '2023-06-24 11:02:06', NULL),
('794c3262-0f09-4c87-a2a9-6b4bf01f174c', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 2500, '2025-12-30', NULL, '0', '2023-06-21 17:04:07', '2023-06-21 17:04:07', NULL),
('90d44143-3345-4566-8ab9-a102a3f2fc21', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 120, '2026-09-22', NULL, '0', '2023-06-24 10:59:32', '2023-06-24 10:59:32', NULL),
('ae14bfdb-4836-4759-baaa-b66798aad624', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'IN', 120, '2024-01-30', NULL, '0', '2023-06-21 16:19:54', '2023-06-21 16:19:54', NULL),
('b2551b3d-d97a-4db1-951c-1077fe92ba8a', 'a4847186-7225-4301-a65f-bb7e54012391', 'c577ce40-15de-480a-9d9d-fa35fdf826fe', 'IN', 450, '2025-12-30', NULL, '0', '2023-06-22 18:52:26', '2023-06-22 18:52:26', NULL),
('b6035570-9cae-424d-bad6-c8e6b692073f', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'IN', 3850, '2026-09-22', NULL, '0', '2023-06-21 17:36:05', '2023-06-22 01:32:03', NULL),
('cf8b1338-a6ef-45aa-a7ce-f3950ffd4c9c', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 85, '2023-08-05', NULL, '0', '2023-07-10 03:21:59', '2023-07-10 03:21:59', NULL),
('d7725ad0-4c95-42b9-8ef4-58b8b7fea01d', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'IN', 2500, '2025-12-30', NULL, '0', '2023-06-21 16:30:46', '2023-06-21 16:30:46', NULL),
('df8b4f0a-b1e7-4e4d-b447-28ebe3a8bb27', 'a4847186-7225-4301-a65f-bb7e54012391', 'c577ce40-15de-480a-9d9d-fa35fdf826fe', 'OUT', 250, '2025-12-30', NULL, '2', '2023-06-22 10:52:41', '2023-06-22 15:21:34', NULL),
('ec58a4ee-b5c7-4992-b0d5-b77d47d3850e', 'a4847186-7225-4301-a65f-bb7e54012391', 'c577ce40-15de-480a-9d9d-fa35fdf826fe', 'IN', 140, '2023-07-30', NULL, '0', '2023-07-10 03:12:43', '2023-07-10 03:12:43', NULL),
('eddf4a60-7ac3-4321-bdfe-acfd473a17aa', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'IN', 200, '2023-08-05', NULL, '0', '2023-07-10 03:12:43', '2023-07-10 03:12:43', NULL),
('f21baf00-faeb-434e-9524-31666fd569ee', 'a4847186-7225-4301-a65f-bb7e54012391', 'c577ce40-15de-480a-9d9d-fa35fdf826fe', 'IN', 1200, '2025-12-30', 'Inisiasi Stok', '0', '2023-06-22 03:25:15', '2023-06-22 03:25:15', NULL),
('f4893d93-c70d-4253-b9df-3e1cec0cafc3', 'a4847186-7225-4301-a65f-bb7e54012391', 'c577ce40-15de-480a-9d9d-fa35fdf826fe', 'IN', 1000, '2023-07-30', NULL, '0', '2023-07-10 09:54:49', '2023-07-10 09:54:49', NULL),
('f8087e9b-b888-441b-bb51-fdb65ef601d2', 'a4847186-7225-4301-a65f-bb7e54012391', 'd567a6de-b094-489a-b164-5e3c82b9ce4f', 'OUT', 380, '2026-09-22', NULL, '0', '2023-06-22 03:25:15', '2023-06-22 03:25:15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD UNIQUE KEY `code_menu` (`code_menu`);

--
-- Indexes for table `menu_auth`
--
ALTER TABLE `menu_auth`
  ADD PRIMARY KEY (`id_menu_auth`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `ms_country`
--
ALTER TABLE `ms_country`
  ADD PRIMARY KEY (`id_country`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ms_drug`
--
ALTER TABLE `ms_drug`
  ADD PRIMARY KEY (`id_drug`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pharma_id` (`pharma_id`),
  ADD KEY `drug_type_id` (`drug_type_id`),
  ADD KEY `drug_category_id` (`drug_category_id`);

--
-- Indexes for table `ms_drug_category`
--
ALTER TABLE `ms_drug_category`
  ADD PRIMARY KEY (`id_drug_category`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ms_drug_type`
--
ALTER TABLE `ms_drug_type`
  ADD PRIMARY KEY (`id_drug_type`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ms_pharma`
--
ALTER TABLE `ms_pharma`
  ADD PRIMARY KEY (`id_pharma`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `ms_role`
--
ALTER TABLE `ms_role`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `code_role` (`code_role`);

--
-- Indexes for table `ms_user`
--
ALTER TABLE `ms_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `tb_storage`
--
ALTER TABLE `tb_storage`
  ADD PRIMARY KEY (`id_storage`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `drug_id` (`drug_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_auth`
--
ALTER TABLE `menu_auth`
  ADD CONSTRAINT `menu_auth_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ms_role` (`id_role`),
  ADD CONSTRAINT `menu_auth_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id_menu`);

--
-- Constraints for table `ms_country`
--
ALTER TABLE `ms_country`
  ADD CONSTRAINT `ms_country_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ms_user` (`id`);

--
-- Constraints for table `ms_drug`
--
ALTER TABLE `ms_drug`
  ADD CONSTRAINT `ms_drug_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ms_user` (`id`),
  ADD CONSTRAINT `ms_drug_ibfk_2` FOREIGN KEY (`pharma_id`) REFERENCES `ms_pharma` (`id_pharma`),
  ADD CONSTRAINT `ms_drug_ibfk_3` FOREIGN KEY (`drug_type_id`) REFERENCES `ms_drug_type` (`id_drug_type`),
  ADD CONSTRAINT `ms_drug_ibfk_4` FOREIGN KEY (`drug_category_id`) REFERENCES `ms_drug_category` (`id_drug_category`);

--
-- Constraints for table `ms_drug_category`
--
ALTER TABLE `ms_drug_category`
  ADD CONSTRAINT `ms_drug_category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ms_user` (`id`);

--
-- Constraints for table `ms_drug_type`
--
ALTER TABLE `ms_drug_type`
  ADD CONSTRAINT `ms_drug_type_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ms_user` (`id`);

--
-- Constraints for table `ms_pharma`
--
ALTER TABLE `ms_pharma`
  ADD CONSTRAINT `ms_pharma_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ms_user` (`id`),
  ADD CONSTRAINT `ms_pharma_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `ms_country` (`id_country`);

--
-- Constraints for table `ms_user`
--
ALTER TABLE `ms_user`
  ADD CONSTRAINT `ms_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ms_role` (`id_role`);

--
-- Constraints for table `tb_storage`
--
ALTER TABLE `tb_storage`
  ADD CONSTRAINT `tb_storage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ms_user` (`id`),
  ADD CONSTRAINT `tb_storage_ibfk_2` FOREIGN KEY (`drug_id`) REFERENCES `ms_drug` (`id_drug`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
