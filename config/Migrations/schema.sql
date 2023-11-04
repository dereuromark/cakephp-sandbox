-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Nov 04, 2023 at 07:46 PM
-- Server version: 10.5.18-MariaDB-1:10.5.18+maria~ubu2004-log
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `sandbox_local`
--

-- --------------------------------------------------------

--
-- Table structure for table `bitmasked_records`
--

CREATE TABLE `bitmasked_records` (
									 `id` int(11) NOT NULL,
									 `name` varchar(100) NOT NULL,
									 `flag_optional` int(11) DEFAULT NULL,
									 `flag_required` int(11) NOT NULL,
									 `created` datetime NOT NULL,
									 `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `captchas`
--

CREATE TABLE `captchas` (
							`id` int(11) NOT NULL,
							`session_id` varchar(255) NOT NULL,
							`ip` varchar(255) NOT NULL,
							`image` binary(255) DEFAULT NULL,
							`result` varchar(255) DEFAULT NULL,
							`created` datetime DEFAULT NULL,
							`used` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `continents`
--

CREATE TABLE `continents` (
							  `id` int(11) UNSIGNED NOT NULL,
							  `name` varchar(64) NOT NULL,
							  `ori_name` varchar(64) NOT NULL,
							  `parent_id` int(11) UNSIGNED DEFAULT NULL,
							  `lft` int(11) UNSIGNED DEFAULT NULL,
							  `rght` int(11) UNSIGNED DEFAULT NULL,
							  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
							  `modified` datetime NOT NULL,
							  `code` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
							 `id` int(11) UNSIGNED NOT NULL,
							 `name` varchar(64) NOT NULL,
							 `ori_name` varchar(64) NOT NULL,
							 `iso2` varchar(2) NOT NULL,
							 `iso3` varchar(3) NOT NULL,
							 `eu_member` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Member of the EU',
							 `special` varchar(40) NOT NULL,
							 `zip_length` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'if > 0 validate on this length',
							 `zip_regexp` varchar(255) NOT NULL,
							 `sort` int(11) UNSIGNED NOT NULL DEFAULT 0,
							 `lat` float(10,6) DEFAULT NULL COMMENT 'latitude',
  `lng` float(10,6) DEFAULT NULL COMMENT 'longitude',
  `address_format` varchar(255) NOT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `phone_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
							  `id` int(11) UNSIGNED NOT NULL,
							  `name` varchar(255) NOT NULL DEFAULT '',
							  `code` char(3) NOT NULL DEFAULT '',
							  `symbol_left` varchar(12) DEFAULT '',
							  `symbol_right` varchar(12) DEFAULT '',
							  `decimal_places` char(1) DEFAULT '',
							  `value` float(9,4) DEFAULT 0.0000,
  `base` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'is base currency',
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `database_logs`
--

CREATE TABLE `database_logs` (
								 `id` int(11) NOT NULL,
								 `type` varchar(50) NOT NULL,
								 `summary` varchar(255) NOT NULL,
								 `message` text NOT NULL,
								 `context` text DEFAULT NULL,
								 `created` datetime NOT NULL,
								 `ip` varchar(100) DEFAULT NULL,
								 `hostname` varchar(100) DEFAULT NULL,
								 `uri` text DEFAULT NULL,
								 `refer` varchar(255) DEFAULT NULL,
								 `user_agent` varchar(255) DEFAULT NULL,
								 `count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
						  `id` int(11) NOT NULL,
						  `title` varchar(200) NOT NULL,
						  `location` varchar(200) NOT NULL,
						  `lat` float DEFAULT NULL,
						  `lng` float DEFAULT NULL,
						  `description` text NOT NULL,
						  `beginning` datetime DEFAULT NULL,
						  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exposed_users`
--

CREATE TABLE `exposed_users` (
								 `id` int(11) NOT NULL,
								 `name` varchar(100) NOT NULL,
								 `uuid` binary(16) NOT NULL,
								 `created` datetime NOT NULL,
								 `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
							 `id` int(11) UNSIGNED NOT NULL,
							 `name` varchar(40) NOT NULL,
							 `ori_name` varchar(40) NOT NULL,
							 `code` varchar(6) NOT NULL,
							 `iso3` char(3) NOT NULL,
							 `iso2` char(2) NOT NULL,
							 `locale` varchar(30) NOT NULL,
							 `locale_fallback` varchar(30) NOT NULL,
							 `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
							 `sort` int(11) UNSIGNED NOT NULL DEFAULT 0,
							 `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phinxlog`
--

CREATE TABLE `phinxlog` (
							`version` bigint(20) NOT NULL,
							`migration_name` varchar(100) DEFAULT NULL,
							`start_time` timestamp NULL DEFAULT NULL,
							`end_time` timestamp NULL DEFAULT NULL,
							`breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queued_jobs`
--

CREATE TABLE `queued_jobs` (
							   `id` int(11) NOT NULL,
							   `job_task` varchar(90) NOT NULL,
							   `data` text DEFAULT NULL,
							   `job_group` varchar(255) DEFAULT NULL,
							   `reference` varchar(255) DEFAULT NULL,
							   `created` datetime NOT NULL,
							   `notbefore` datetime DEFAULT NULL,
							   `fetched` datetime DEFAULT NULL,
							   `completed` datetime DEFAULT NULL,
							   `progress` float DEFAULT NULL,
							   `attempts` int(11) NOT NULL DEFAULT 0,
							   `failure_message` text DEFAULT NULL,
							   `workerkey` varchar(45) DEFAULT NULL,
							   `status` varchar(255) DEFAULT NULL,
							   `priority` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queue_processes`
--

CREATE TABLE `queue_processes` (
								   `id` int(11) NOT NULL,
								   `pid` varchar(40) NOT NULL,
								   `created` datetime NOT NULL,
								   `modified` datetime NOT NULL,
								   `terminate` tinyint(1) NOT NULL DEFAULT 0,
								   `server` varchar(90) DEFAULT NULL,
								   `workerkey` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
								 `id` int(11) NOT NULL,
								 `session_id` varchar(100) NOT NULL,
								 `user_id` int(11) NOT NULL,
								 `status` varchar(100) NOT NULL DEFAULT 'pending',
								 `created` datetime NOT NULL,
								 `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
						 `id` int(11) UNSIGNED NOT NULL,
						 `name` varchar(64) NOT NULL DEFAULT '',
						 `alias` varchar(20) NOT NULL,
						 `created` datetime NOT NULL,
						 `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sandbox_animals`
--

CREATE TABLE `sandbox_animals` (
								   `id` int(11) UNSIGNED NOT NULL,
								   `name` varchar(100) NOT NULL,
								   `created` datetime NOT NULL,
								   `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sandbox_categories`
--

CREATE TABLE `sandbox_categories` (
									  `id` int(11) UNSIGNED NOT NULL,
									  `parent_id` int(11) DEFAULT NULL,
									  `name` varchar(180) NOT NULL,
									  `description` text NOT NULL,
									  `status` int(11) UNSIGNED DEFAULT NULL,
									  `lft` int(11) UNSIGNED DEFAULT NULL,
									  `rght` int(11) UNSIGNED DEFAULT NULL,
									  `created` datetime DEFAULT NULL,
									  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sandbox_posts`
--

CREATE TABLE `sandbox_posts` (
								 `id` int(11) UNSIGNED NOT NULL,
								 `title` varchar(180) NOT NULL,
								 `content` text NOT NULL,
								 `rating_count` int(11) UNSIGNED NOT NULL DEFAULT 0,
								 `rating_sum` int(11) UNSIGNED NOT NULL DEFAULT 0,
								 `created` datetime DEFAULT NULL,
								 `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sandbox_profiles`
--

CREATE TABLE `sandbox_profiles` (
									`id` int(11) UNSIGNED NOT NULL,
									`username` varchar(255) NOT NULL,
									`balance` decimal(10,2) NOT NULL DEFAULT 0.00,
									`extra` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sandbox_ratings`
--

CREATE TABLE `sandbox_ratings` (
								   `id` int(11) NOT NULL,
								   `user_id` int(11) DEFAULT NULL,
								   `foreign_key` int(11) DEFAULT NULL,
								   `model` varchar(255) DEFAULT NULL,
								   `value` float(8,4) NOT NULL DEFAULT 0.0000,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sandbox_users`
--

CREATE TABLE `sandbox_users` (
								 `id` int(11) NOT NULL,
								 `created` datetime DEFAULT NULL,
								 `modified` datetime DEFAULT NULL,
								 `username` varchar(30) NOT NULL,
								 `slug` varchar(255) NOT NULL,
								 `password` varchar(255) NOT NULL,
								 `email` varchar(80) NOT NULL,
								 `role_id` tinyint(4) NOT NULL DEFAULT 0,
								 `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
						  `id` int(11) UNSIGNED NOT NULL,
						  `country_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
						  `code` varchar(3) NOT NULL,
						  `name` varchar(40) NOT NULL,
						  `lat` float(10,6) NOT NULL DEFAULT 0.000000,
  `lng` float(10,6) NOT NULL DEFAULT 0.000000,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags_tagged`
--

CREATE TABLE `tags_tagged` (
							   `id` int(11) NOT NULL,
							   `tag_id` int(11) NOT NULL,
							   `fk_id` int(11) NOT NULL,
							   `fk_model` varchar(255) NOT NULL,
							   `created` datetime NOT NULL,
							   `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags_tags`
--

CREATE TABLE `tags_tags` (
							 `id` int(11) NOT NULL,
							 `namespace` varchar(255) DEFAULT NULL,
							 `slug` varchar(255) NOT NULL,
							 `label` varchar(255) NOT NULL,
							 `counter` int(11) UNSIGNED NOT NULL DEFAULT 0,
							 `created` datetime DEFAULT NULL,
							 `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
							 `id` int(11) NOT NULL,
							 `name` varchar(100) NOT NULL,
							 `offset` varchar(10) NOT NULL,
							 `offset_dst` varchar(10) NOT NULL,
							 `type` varchar(100) NOT NULL,
							 `country_code` varchar(2) DEFAULT NULL COMMENT 'ISO_3166-2',
							 `active` tinyint(1) NOT NULL DEFAULT 0,
							 `lat` float(10,6) DEFAULT NULL,
  `lng` float(10,6) DEFAULT NULL,
  `covered` varchar(190) DEFAULT NULL,
  `notes` varchar(190) DEFAULT NULL,
  `linked_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
						 `id` int(11) NOT NULL,
						 `active` tinyint(1) NOT NULL DEFAULT 0,
						 `last_login` datetime DEFAULT NULL,
						 `created` datetime NOT NULL,
						 `modified` datetime NOT NULL,
						 `logins` int(11) UNSIGNED NOT NULL DEFAULT 0,
						 `username` varchar(30) NOT NULL,
						 `password` varchar(255) NOT NULL,
						 `email` varchar(80) NOT NULL,
						 `role_id` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bitmasked_records`
--
ALTER TABLE `bitmasked_records`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `captchas`
--
ALTER TABLE `captchas`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `continents`
--
ALTER TABLE `continents`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `database_logs`
--
ALTER TABLE `database_logs`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exposed_users`
--
ALTER TABLE `exposed_users`
	ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
	ADD PRIMARY KEY (`version`);

--
-- Indexes for table `queued_jobs`
--
ALTER TABLE `queued_jobs`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue_processes`
--
ALTER TABLE `queue_processes`
	ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `workerkey` (`workerkey`),
  ADD UNIQUE KEY `pid` (`pid`,`server`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sandbox_animals`
--
ALTER TABLE `sandbox_animals`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sandbox_categories`
--
ALTER TABLE `sandbox_categories`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sandbox_posts`
--
ALTER TABLE `sandbox_posts`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sandbox_profiles`
--
ALTER TABLE `sandbox_profiles`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sandbox_ratings`
--
ALTER TABLE `sandbox_ratings`
	ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_RATING` (`user_id`,`foreign_key`,`model`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `foreign_key` (`foreign_key`);

--
-- Indexes for table `sandbox_users`
--
ALTER TABLE `sandbox_users`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags_tagged`
--
ALTER TABLE `tags_tagged`
	ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_id` (`tag_id`,`fk_id`,`fk_model`);

--
-- Indexes for table `tags_tags`
--
ALTER TABLE `tags_tags`
	ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`,`namespace`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
	ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bitmasked_records`
--
ALTER TABLE `bitmasked_records`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `captchas`
--
ALTER TABLE `captchas`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `continents`
--
ALTER TABLE `continents`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `database_logs`
--
ALTER TABLE `database_logs`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exposed_users`
--
ALTER TABLE `exposed_users`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queued_jobs`
--
ALTER TABLE `queued_jobs`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue_processes`
--
ALTER TABLE `queue_processes`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sandbox_animals`
--
ALTER TABLE `sandbox_animals`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sandbox_categories`
--
ALTER TABLE `sandbox_categories`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sandbox_posts`
--
ALTER TABLE `sandbox_posts`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sandbox_profiles`
--
ALTER TABLE `sandbox_profiles`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sandbox_ratings`
--
ALTER TABLE `sandbox_ratings`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sandbox_users`
--
ALTER TABLE `sandbox_users`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
	MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags_tagged`
--
ALTER TABLE `tags_tagged`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags_tags`
--
ALTER TABLE `tags_tags`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
