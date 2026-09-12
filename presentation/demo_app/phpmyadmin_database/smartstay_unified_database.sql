-- SmartOps fixed synthetic product-demo seed database
-- This file contains curated fake data only; it never imports production records.
-- Each visitor receives an isolated database and PHP automatically rebases all
-- operational dates into the current rolling seven-day window after import.
-- All dashboards and the Technician Website use the same isolated demo database.
-- case_id is the only identifier shared across complaint, HITL, workforce, and technician task records.
-- technician_id remains only for technician login and assignment ownership.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP DATABASE IF EXISTS `smartstay_php`;
CREATE DATABASE `smartstay_php` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smartstay_php`;

CREATE TABLE `demo_meta` (
  `meta_key` VARCHAR(100) PRIMARY KEY,
  `meta_value` VARCHAR(255) NOT NULL,
  `updated_at` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `demo_meta` (`meta_key`,`meta_value`,`updated_at`) VALUES
('dataset_version','2026-07-31-room305-dynamic-rolling-v6-assignment-persistence-fix','2026-07-31 19:15:00'),
('dataset_mode','Fixed synthetic seed + dynamic rolling dates','2026-07-31 19:15:00'),
('data_policy','Isolated demo only; no production sync','2026-07-31 19:15:00');


CREATE TABLE `cases` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `case_id` VARCHAR(20) NOT NULL,
  `room_id` VARCHAR(50) NULL,
  `issue_summary` TEXT NULL,
  `issue` TEXT NULL,
  `hotel_asset` VARCHAR(100) NULL,
  `component` VARCHAR(150) NULL,
  `severity` VARCHAR(50) NULL,
  `priority` VARCHAR(50) NULL,
  `source_module` VARCHAR(80) NULL,
  UNIQUE KEY `uk_case_id` (`case_id`),
  INDEX `idx_cases_room_id` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `technicians` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `technician_id` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NULL,
  `name` VARCHAR(255) NULL,
  `phone` VARCHAR(50) NULL,
  `email` VARCHAR(255) NULL,
  `department` VARCHAR(100) NULL,
  `category` VARCHAR(100) NULL,
  `role` VARCHAR(100) NULL,
  `technician_level` VARCHAR(20) NOT NULL DEFAULT 'Junior',
  `status` VARCHAR(50) NULL,
  `total_tasks` INT NOT NULL DEFAULT 0,
  `active_tasks` INT NOT NULL DEFAULT 0,
  `completed_tasks` INT NOT NULL DEFAULT 0,
  `overdue_tasks` INT NOT NULL DEFAULT 0,
  `workload_percent` INT NOT NULL DEFAULT 0,
  `warning_reason` VARCHAR(255) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `deleted_at` DATETIME NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_technician_id` (`technician_id`),
  INDEX `idx_technician_department_role` (`department`,`role`),
  INDEX `idx_technician_active_status` (`is_active`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `hitl_cases` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `case_id` VARCHAR(20) NOT NULL,
  `room` VARCHAR(50) NULL,
  `issue_summary` TEXT NULL,
  `issue` TEXT NULL,
  `hotel_asset` VARCHAR(100) NULL,
  `component` VARCHAR(150) NULL,
  `severity` VARCHAR(50) NULL,
  `priority` VARCHAR(50) NULL,
  `hitl_reason` VARCHAR(100) NULL,
  `safety_flag` VARCHAR(20) NULL,
  `review_status` VARCHAR(100) NULL,
  `manager_comment` TEXT NULL,
  `created_at` DATETIME NULL,
  `failure_mode` VARCHAR(255) NULL,
  `observed_symptoms` TEXT NULL,
  `possible_root_cause` TEXT NULL,
  UNIQUE KEY `uk_hitl_case` (`case_id`),
  INDEX `idx_hitl_room` (`room`),
  INDEX `idx_hitl_review_status` (`review_status`),
  INDEX `idx_hitl_asset_component` (`hotel_asset`,`component`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `workforce_cases` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `case_id` VARCHAR(20) NOT NULL,
  `room` VARCHAR(50) NULL,
  `issue_summary` TEXT NULL,
  `issue` TEXT NULL,
  `hotel_asset` VARCHAR(100) NULL,
  `component` VARCHAR(150) NULL,
  `severity` VARCHAR(50) NULL,
  `priority` VARCHAR(50) NULL,
  `work_stage` VARCHAR(100) NULL,
  `task_status` VARCHAR(100) NULL,
  `response_target_minutes` INT NULL,
  `response_minutes` INT NULL,
  `response_sla_status` VARCHAR(50) NULL,
  `repair_target_minutes` INT NULL,
  `repair_minutes` INT NULL,
  `repair_sla_status` VARCHAR(50) NULL,
  `overall_sla_status` VARCHAR(50) NULL,
  `sla_status` VARCHAR(50) NULL,
  `support_reason` VARCHAR(100) NULL,
  `support_status` VARCHAR(100) NULL,
  `required_external_service` VARCHAR(255) NULL,
  `outsourcing_reason` VARCHAR(255) NULL,
  `requested_part` VARCHAR(255) NULL,
  `support_other_detail` TEXT NULL,
  `assigned_technician_id` VARCHAR(20) NULL,
  `assigned_at` DATETIME NULL,
  `accepted_at` DATETIME NULL,
  `started_at` DATETIME NULL,
  `completed_at` DATETIME NULL,
  `hitl_status` VARCHAR(100) NULL,
  `manager_note` TEXT NULL,
  `risk_score` DECIMAL(6,5) NULL,
  `safety_flag` VARCHAR(20) NULL,
  `technician_id` VARCHAR(20) NULL,
  `technician_note` TEXT NULL,
  `case_created_at` DATETIME NULL,
  `previous_technician_id` VARCHAR(20) NULL,
  `support_requested_at` DATETIME NULL,
  `released_at` DATETIME NULL,
  `transfer_reason` VARCHAR(100) NULL,
  `transfer_requested_at` DATETIME NULL,
  `parts_status` VARCHAR(100) NULL,
  `parts_requested_at` DATETIME NULL,
  `parts_ordered_at` DATETIME NULL,
  `parts_ready_at` DATETIME NULL,
  `outsourcing_status` VARCHAR(100) NULL,
  `outsourced_at` DATETIME NULL,
  `assignment_round` INT NOT NULL DEFAULT 0,
  `sla_reason` VARCHAR(255) NULL,
  `sla_source` VARCHAR(255) NULL,
  `sla_cause` VARCHAR(255) NULL,
  `technician_sla_reason` TEXT NULL,
  UNIQUE KEY `uk_workforce_case_id` (`case_id`),
  INDEX `idx_workforce_room` (`room`),
  INDEX `idx_workforce_assigned_technician` (`assigned_technician_id`),
  INDEX `idx_workforce_stage` (`work_stage`),
  INDEX `idx_workforce_asset_component` (`hotel_asset`,`component`),
  INDEX `idx_workforce_previous_technician` (`previous_technician_id`),
  INDEX `idx_workforce_support_state` (`support_reason`,`support_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `technician_tasks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `case_id` VARCHAR(20) NOT NULL,
  `technician_id` VARCHAR(20) NULL,
  `room` VARCHAR(50) NULL,
  `issue_summary` TEXT NULL,
  `issue` TEXT NULL,
  `priority` VARCHAR(50) NULL,
  `severity` VARCHAR(50) NULL,
  `escalation_trigger` VARCHAR(50) NULL,
  `task_status` VARCHAR(100) NULL,
  `assigned_time` DATETIME NULL,
  `accepted_time` DATETIME NULL,
  `started_time` DATETIME NULL,
  `completed_time` DATETIME NULL,
  `response_target_minutes` INT NULL,
  `response_minutes` INT NULL,
  `response_sla_status` VARCHAR(50) NULL,
  `repair_target_minutes` INT NULL,
  `repair_minutes` INT NULL,
  `repair_sla_status` VARCHAR(50) NULL,
  `overall_sla_status` VARCHAR(50) NULL,
  `sla_status` VARCHAR(50) NULL,
  `support_reason` VARCHAR(100) NULL,
  `support_status` VARCHAR(100) NULL,
  `required_external_service` VARCHAR(255) NULL,
  `outsourcing_reason` VARCHAR(255) NULL,
  `requested_part` VARCHAR(255) NULL,
  `support_other_detail` TEXT NULL,
  `technician_note` TEXT NULL,
  `safety_flag` VARCHAR(20) NULL,
  `component` VARCHAR(150) NULL,
  `failure_mode` VARCHAR(255) NULL,
  `observed_symptoms` TEXT NULL,
  `possible_root_cause` TEXT NULL,
  `corrective_action` TEXT NULL,
  `preventive_maintenance` TEXT NULL,
  `verification` TEXT NULL,
  `hotel_asset` VARCHAR(100) NULL,
  `assigned_technician_id` VARCHAR(20) NULL,
  `case_created_at` DATETIME NULL,
  `previous_technician_id` VARCHAR(20) NULL,
  `support_requested_at` DATETIME NULL,
  `released_at` DATETIME NULL,
  `assignment_round` INT NOT NULL DEFAULT 0,
  `sla_reason` VARCHAR(255) NULL,
  `sla_source` VARCHAR(255) NULL,
  `sla_cause` VARCHAR(255) NULL,
  `technician_sla_reason` TEXT NULL,
  UNIQUE KEY `uk_task_case_id` (`case_id`),
  INDEX `idx_task_room` (`room`),
  INDEX `idx_task_technician_id` (`technician_id`),
  INDEX `idx_task_status` (`task_status`),
  INDEX `idx_task_previous_technician` (`previous_technician_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `task_assignment_history` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `case_id` VARCHAR(20) NOT NULL,
  `technician_id` VARCHAR(20) NOT NULL,
  `assignment_round` INT NOT NULL DEFAULT 1,
  `assigned_at` DATETIME NOT NULL,
  `accepted_at` DATETIME NULL,
  `started_at` DATETIME NULL,
  `ended_at` DATETIME NULL,
  `end_status` VARCHAR(100) NULL,
  `event_note` TEXT NULL,
  `response_minutes` INT NULL,
  `response_sla_status` VARCHAR(50) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_assignment_round` (`case_id`,`assignment_round`),
  INDEX `idx_assignment_technician` (`technician_id`,`ended_at`),
  INDEX `idx_assignment_case` (`case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `smart_maintenance_tickets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `case_id` VARCHAR(20) NOT NULL,
  `room_id` VARCHAR(50) NULL,
  `guest_phone` VARCHAR(50) NULL,
  `guest_chat_id` VARCHAR(150) NULL,
  `guest_message_id` VARCHAR(255) NULL,
  `guest_start_notified_at` DATETIME NULL,
  `guest_notification_status` VARCHAR(40) NULL,
  `guest_notification_error` TEXT NULL,
  `guest_notification_method` VARCHAR(40) NULL,
  `guest_notification_recipient` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `cleaned_comment` TEXT NULL,
  `hotel_asset` VARCHAR(100) NULL,
  `failure_mode` VARCHAR(255) NULL,
  `component` VARCHAR(150) NULL,
  `observed_symptoms` TEXT NULL,
  `possible_root_cause` TEXT NULL,
  `safety_precautions` TEXT NULL,
  `verification` TEXT NULL,
  `corrective_action` TEXT NULL,
  `preventive_maintenance` TEXT NULL,
  `severity_level` VARCHAR(50) NULL,
  `priority_level` VARCHAR(50) NULL,
  `safety` VARCHAR(20) NULL,
  `sla` VARCHAR(100) NULL,
  `sla_target` VARCHAR(100) NULL,
  `actual_time` VARCHAR(100) NULL,
  `sla_status` VARCHAR(50) NULL,
  `escalation_required` VARCHAR(20) NULL,
  `human_approval_required` VARCHAR(20) NULL,
  `technician_assigned_timestamp` DATETIME NULL,
  `technician_assigned` VARCHAR(20) NULL,
  `assigned_to` VARCHAR(20) NULL,
  `ticket_status` VARCHAR(100) NULL,
  `completed_date` DATETIME NULL,
  `support_status` VARCHAR(100) NULL,
  `support_reason` VARCHAR(100) NULL,
  `part_name` VARCHAR(255) NULL,
  `vendor_status` VARCHAR(100) NULL,
  `ai_confidence` DECIMAL(6,5) NULL,
  `risk_score` DECIMAL(6,5) NULL,
  UNIQUE KEY `uk_smart_case_id` (`case_id`),
  INDEX `idx_smart_room_id` (`room_id`),
  INDEX `idx_smart_asset` (`hotel_asset`),
  INDEX `idx_smart_status` (`ticket_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `admin_notifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `event_key` VARCHAR(120) NOT NULL,
  `notification_type` VARCHAR(60) NOT NULL DEFAULT 'case_completed',
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT NULL,
  `case_id` VARCHAR(20) NULL,
  `technician_id` VARCHAR(20) NULL,
  `target_path` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_at` DATETIME NULL,
  UNIQUE KEY `uk_admin_notification_event` (`event_key`),
  INDEX `idx_admin_notification_read` (`read_at`),
  INDEX `idx_admin_notification_created` (`created_at`),
  INDEX `idx_admin_notification_case` (`case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` VARCHAR(100) NOT NULL DEFAULT 'System Administrator',
  `created_at` DATETIME NOT NULL,
  UNIQUE KEY `uk_admin_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dataset imported from data/whole_pipeline_results.jsonl
-- AI Automation cases begin as Pending Assignment and are assigned by FastAPI after the website opens.
INSERT INTO `technicians` (`technician_id`,`password`,`name`,`phone`,`email`,`department`,`category`,`role`,`technician_level`,`status`,`total_tasks`,`active_tasks`,`completed_tasks`,`overdue_tasks`,`workload_percent`,`warning_reason`) VALUES
('TECH-001','$2y$12$u9uxruhat8a1GjTvovNUCu.rIsGWNPvgcpNqoYMgE4SZsk5r9qOkK','Aiden Tan','012-7000001','tech-001@smartstay.com','HVAC','HVAC','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-002','$2y$12$51083.BNt9wkOKWkxGGG..Q00l/uP8DSMhaRYLycpwbf8RQKC/4H6','Brandon Tan','012-7000002','tech-002@smartstay.com','HVAC','HVAC','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-003','$2y$12$tmrD0Omq3gY9.knAiTX9b.VbIlp2Z46.T2JJBR79MhcKZE5CKzGSy','Calvin Tan','012-7000003','tech-003@smartstay.com','HVAC','HVAC','Technician','Senior','Available',0,0,0,0,0,''),
('TECH-004','$2y$12$0ewpHuL4rHip0Jra8GMfz.Dc7ebVIKgbdlflc/W13aTiEmdBWGaXy','Darren Tan','012-7000004','tech-004@smartstay.com','Plumbing','Plumbing','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-005','$2y$12$yLmP50O1t1P/.SugHTJL.e.v1ukmG9cCqH8xr5BBpJ25pFPY8Akhe','Ethan Tan','012-7000005','tech-005@smartstay.com','Plumbing','Plumbing','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-006','$2y$12$kpvrBrlKy0Wn5HMdLn2r8.wD3luJklcv2rHLU.w8wC1S8y8LBVcgS','Felix Tan','012-7000006','tech-006@smartstay.com','Plumbing','Plumbing','Technician','Senior','Available',0,0,0,0,0,''),
('TECH-007','$2y$12$Z9gr3gPnx/XhudDMF4h02e2D3Ypm7LY8iZpB6Aq1TPB6EAh9OOGH6','Gavin Tan','012-7000007','tech-007@smartstay.com','Electrical','Electrical','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-008','$2y$12$M706yP68AVcWsMQh5W7mGepmMsP60F.RS6blHoXk5PDibDRpuQLOq','Henry Tan','012-7000008','tech-008@smartstay.com','Electrical','Electrical','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-009','$2y$12$p14ZPRZISWuC1UifACvgFOwr.u/dXJxgcq.QHEX479N3ipHGwmjUC','Ivan Tan','012-7000009','tech-009@smartstay.com','Electrical','Electrical','Technician','Senior','Available',0,0,0,0,0,''),
('TECH-010','$2y$12$YC/0jzcT7z/EoONr57Yw2ue7bBMfUVaFkjiVcZOCNmJKxwjQsTuL.','Jason Tan','012-7000010','tech-010@smartstay.com','Fire Protection','Fire Protection','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-011','$2y$12$yoAlQV7l1S5spPwZ4ws6oe1rM5g6f0OtVB5N/2HwcvZNGk3KJovVy','Kelvin Tan','012-7000011','tech-011@smartstay.com','Fire Protection','Fire Protection','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-012','$2y$12$Jjy4Ce8GzaUaVmd1kVSfkezzkgMEyDJImiEWIUf9sKH8QpS0pYmZ6','Leon Tan','012-7000012','tech-012@smartstay.com','Fire Protection','Fire Protection','Technician','Senior','Available',0,0,0,0,0,''),
('TECH-013','$2y$12$dNL4pfpEF7oTTxLKT//TS.Z.XqvMYw6DWhQNrzSp8bFy5wh7NsYWC','Marcus Tan','012-7000013','tech-013@smartstay.com','Conveying','Conveying','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-014','$2y$12$iJcIpzVaSFdbKRNt8.aUQeQFp6B7xlh.9hOiwGUKuqoQCiFdqRmlu','Nathan Tan','012-7000014','tech-014@smartstay.com','Conveying','Conveying','Technician','Junior','Available',0,0,0,0,0,''),
('TECH-015','$2y$12$aSbmpfxRE9y.A6sjINqP.e.6qw5ZtBS/lcRl2Pc0GJVpbSB.MG7S.','Owen Tan','012-7000015','tech-015@smartstay.com','Conveying','Conveying','Technician','Senior','Available',0,0,0,0,0,''),
('TECH-016','$2y$12$C90DvuBZNu4alhI3lxsJSejjEP74/YGH72x/Wh2nfwx.SVcdfziny','Ryan Tan','012-7000016','tech-016@smartstay.com','All Departments','All Departments','Technical Specialist','Junior','Available',0,0,0,0,0,''),
('TECH-017','$2y$12$QBtQzLLf8E4.7WrU9.06Mu.2/ESlZPCF9fXHZiBslxFYBl8gdp3WG','Sean Tan','012-7000017','tech-017@smartstay.com','All Departments','All Departments','Technical Specialist','Junior','Available',0,0,0,0,0,''),
('TECH-018','$2y$12$xKmMOqoED8GJLD42FWjbLOmUSjBDGQ4wrhOm4yrFUNqBqZqIxehAG','Tristan Tan','012-7000018','tech-018@smartstay.com','All Departments','All Departments','Technical Specialist','Junior','Available',0,0,0,0,0,''),
('TECH-019','$2y$12$QHb/VqedHVXO/0nW90pRg.V5vN54YHXJTuleotj9Zg6.e/ZFh9AVe','Vincent Tan','012-7000019','tech-019@smartstay.com','All Departments','All Departments','Technical Specialist','Junior','Available',0,0,0,0,0,''),
('TECH-020','$2y$12$4FoJBszhEaun7P6RAEKST.R7JeIa6puiRkfwLWoe4B9DcKisgzbYW','Wilson Tan','012-7000020','tech-020@smartstay.com','All Departments','All Departments','Technical Specialist','Junior','Available',0,0,0,0,0,''),
('TECH-021','$2y$12$IH92fGD9Z6A.vVKP5i0QcObBcbAwbNTpiQlOgyYVB4Br15J0NTUhG','Xavier Tan','012-7000021','tech-021@smartstay.com','All Departments','All Departments','Technical Specialist','Senior','Available',0,0,0,0,0,''),
('TECH-022','$2y$12$f5OsUpiu2MvoaL8vOfD/NeF6cjXSoJhv3SWmawMJtnPJNORNXpQv.','Yong Tan','012-7000022','tech-022@smartstay.com','All Departments','All Departments','Technical Specialist','Senior','Available',0,0,0,0,0,''),
('TECH-023','$2y$12$aOM4mhrmeGmg70zvk4y6auXUQfP3C9/odXNxeBdKNeWtS5O.ZIcMq','Zachary Tan','012-7000023','tech-023@smartstay.com','All Departments','All Departments','Technical Specialist','Senior','Available',0,0,0,0,0,''),
('TECH-024','$2y$12$Um7yQmycaBJ/IYHVOn9HCOGJm9IiP4L.GwmnOB1T5DK86BTlWytWe','Adrian Lim','012-7000024','tech-024@smartstay.com','All Departments','All Departments','Technical Specialist','Senior','Available',0,0,0,0,0,''),
('TECH-025','$2y$12$yzBXx0nxcbQu5mxfA6LWx.ymPklubSInV541J9bmdXDr2bdKYZlUq','Bryan Lim','012-7000025','tech-025@smartstay.com','All Departments','All Departments','Technical Specialist','Senior','Available',0,0,0,0,0,'');

INSERT INTO `cases` (`case_id`,`room_id`,`issue_summary`,`issue`,`hotel_asset`,`component`,`severity`,`priority`,`source_module`) VALUES
('GEN10_001','Not provided','The hot-water service became unreliable after developing weak hot-water pressure before checkout.','The hot-water service became unreliable after developing weak hot-water pressure before checkout.','Plumbing','Domestic Water Distribution','High','Urgent','HITL'),
('GEN10_002','Not provided','Normal operation of the room electrical supply was disrupted by a persistent electrical buzzing sound.','Normal operation of the room electrical supply was disrupted by a persistent electrical buzzing sound.','Electrical','Electrical Service & Distribution','High','Urgent','HITL'),
('GEN10_003','Not provided','The passenger elevator car floor display was unlit and showed no information.','The passenger elevator car floor display was unlit and showed no information.','Conveying','Elevator & Lifts','High','Urgent','HITL'),
('GEN10_004','Not provided','Please inspect the bathroom ventilation system; the bathroom exhaust fan would not run when switched on.','Please inspect the bathroom ventilation system; the bathroom exhaust fan would not run when switched on.','HVAC','Distribution Systems','Medium','Standard','HITL'),
('GEN10_005','Not provided','I experienced a blank elevator display while using the hotel''s passenger elevator.','I experienced a blank elevator display while using the hotel''s passenger elevator.','Conveying','Elevator & Lifts','High','Urgent','HITL'),
('GEN10_006','Not provided','The fire-fighting cylinder safety pin was broken or missing.','The fire-fighting cylinder safety pin was broken or missing.','Fire Protection','Fire Protection Specialisties','Critical','Immediate','HITL'),
('GEN10_007','Not provided','Normal operation of the fire alarm and detection system was disrupted by a fire alarm with no emergency.','Normal operation of the fire alarm and detection system was disrupted by a fire alarm with no emergency.','Fire Protection','Other Fire Protection System','Critical','Immediate','HITL'),
('GEN10_008','Not provided','Water was leaking from the hot-water appliance.','Water was leaking from the hot-water appliance.','Plumbing','Domestic Water Distribution','High','Urgent','HITL'),
('GEN10_009','Not provided','Please inspect the room electrical supply; the electrical point provided no power.','Please inspect the room electrical supply; the electrical point provided no power.','Electrical','Electrical Service & Distribution','High','Urgent','HITL'),
('GEN10_010','Not provided','Several lighting fixtures in the corridor were completely unresponsive.','Several lighting fixtures in the corridor were completely unresponsive.','Electrical','Lighting & Branch Wiring','High','Urgent','HITL'),
('GEN10_011','Not provided','The concierge queue moved extremely slowly during the busy afternoon.','The concierge queue moved extremely slowly during the busy afternoon.','','','','','HITL'),
('GEN10_012','Not provided','A fault in the fire sprinkler head caused a blocked sprinkler head during my stay.','A fault in the fire sprinkler head caused a blocked sprinkler head during my stay.','Fire Protection','Sprinklers','Critical','Immediate','HITL'),
('GEN10_013','Not provided','I experienced an unpleasant odor while using the hotel''s sink disposal unit.','I experienced an unpleasant odor while using the hotel''s sink disposal unit.','Plumbing','Sanitary Waste','Medium','Standard','AI Automation'),
('GEN10_014','Not provided','The bathroom odor remained because the ventilation did not clear it.','The bathroom odor remained because the ventilation did not clear it.','HVAC','Distribution Systems','Medium','Standard','AI Automation'),
('GEN10_015','Not provided','Maintenance is required for delayed floor information on the elevator display affecting the passenger elevator before checkout.','Maintenance is required for delayed floor information on the elevator display affecting the passenger elevator before checkout.','Conveying','Elevator & Lifts','High','Urgent','HITL');

INSERT INTO `smart_maintenance_tickets` (`case_id`,`room_id`,`created_at`,`cleaned_comment`,`hotel_asset`,`failure_mode`,`component`,`observed_symptoms`,`possible_root_cause`,`corrective_action`,`preventive_maintenance`,`severity_level`,`priority_level`,`safety`,`sla`,`sla_target`,`actual_time`,`sla_status`,`escalation_required`,`human_approval_required`,`technician_assigned_timestamp`,`technician_assigned`,`assigned_to`,`ticket_status`,`completed_date`,`support_status`,`support_reason`,`part_name`,`vendor_status`,`ai_confidence`,`risk_score`) VALUES
('GEN10_001','Not provided','2026-07-23 09:00:00','The hot-water service became unreliable after developing weak hot-water pressure before checkout.','Plumbing','D2022 Hot Water Service','Domestic Water Distribution','Low hot water pressure','Sediment Buildup, Clogged showerhead, Water Leakage','Flush your water heater to remove sediment buildup, Check Water Meter, Remove the showerhead or faucet and soak it in vinegar, Check for damp spots, mould, or mildew in areas where plumbing runs','Check for Leaks Regularly, Inspect Your Water Heater, Clean Your Drains','High','Urgent','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9620',''),
('GEN10_002','Not provided','2026-07-23 09:40:00','Normal operation of the room electrical supply was disrupted by a persistent electrical buzzing sound.','Electrical','Main Electrical Supply','Electrical Service & Distribution','Buzzing or Humming Sounds','Loose or faulty electrical components, wiring, or transformers','Secure Fixtures; Replace Transformers; Repair Wiring','Check loose electrical connections; Inspect busbars for wear; Thermal imaging for hot spots; Inspect breaker contacts; Clean contacts; Monitor motor vibration; Verify motor alignment; Inspect transformer components','High','Urgent','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9959',''),
('GEN10_003','Not provided','2026-07-23 10:20:00','The passenger elevator car floor display was unlit and showed no information.','Conveying','Elevators related','Elevator & Lifts','Incorrect floor indication','Position sensor misalignment or encoder issue','Recalibrate position sensors and verify floor count settings in the control panel','Regularly test floor display accuracy and calibrate position sensors and encoders during scheduled service','High','Urgent','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9970',''),
('GEN10_004','Not provided','2026-07-23 11:05:00','Please inspect the bathroom ventilation system; the bathroom exhaust fan would not run when switched on.','HVAC','Exhaust Ventilation Systems','Distribution Systems','Bathroom smell does not go away','Exhaust fan not operating properly or blockage in exhaust system','Check and clean exhaust fan, grille, and duct; replace fan motor if weak or not running; ensure proper air discharge and clear air path','Clean bathroom exhaust grilles regularly; inspect exhaust fan operation during routine room maintenance; remove dust buildup from exhaust ducts when required','Medium','Standard','false','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9940',''),
('GEN10_005','Not provided','2026-07-23 12:15:00','I experienced a blank elevator display while using the hotel''s passenger elevator.','Conveying','Elevators related','Elevator & Lifts','Blank or Completely Dead Display','Power supply issues, loose wiring, blown fuses, unstable voltage, grounding, damaged internal parts','Check power supply, inspect wiring, replace damaged parts if necessary','Inspect display power supply regularly, check fuses, wiring, and connectors, ensure stable voltage supply','High','Urgent','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9996',''),
('GEN10_006','Not provided','2026-07-23 13:30:00','The fire-fighting cylinder safety pin was broken or missing.','Fire Protection','Fire Extinguishers','Fire Protection Specialisties','Broken or Missing Safety Pin','Tampering or improper maintenance','Check the safety pin, replace if damaged, report for servicing if tampered with','Check safety pin, inspect tamper seal, replace missing/loose/broken pins, train staff','Critical','Immediate','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9942',''),
('GEN10_007','Not provided','2026-07-23 14:10:00','Normal operation of the fire alarm and detection system was disrupted by a fire alarm with no emergency.','Fire Protection','Fire Alarm System & Smoke Detector Related','Other Fire Protection System','False Alarm Triggered by Smoke Detector','Low battery, zone fault, sounder fault, or general fault','Read the fire alarm control panel display, identify the fault message, replace low backup batteries if needed, check the fire alarm circuit breaker after a power cut, reset the panel only after the fault has been cleared, call a professional technician if the beeping returns after reset.','Read the fire alarm control panel display, identify the fault message, replace low backup batteries if needed, check the fire alarm circuit breaker after a power cut, reset the panel only after the fault has been cleared, call a professional technician if the beeping returns after reset.','Critical','Immediate','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9997',''),
('GEN10_008','Not provided','2026-07-23 15:25:00','Water was leaking from the hot-water appliance.','Plumbing','D2022 Hot Water Service','Domestic Water Distribution','Low hot water pressure','Sediment Buildup, Clogged showerhead, Water Leakage','Flush your water heater to remove sediment buildup, Check Water Meter, Remove the showerhead or faucet and soak it in vinegar, Check for damp spots, mould, or mildew in areas where plumbing runs','Check for Leaks Regularly, Inspect Your Water Heater, Clean Your Drains','High','Urgent','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.7365',''),
('GEN10_009','Not provided','2026-07-23 16:00:00','Please inspect the room electrical supply; the electrical point provided no power.','Electrical','Main Electrical Supply','Electrical Service & Distribution','Power Outages','Overloads, short circuits, or external factors','Check circuit breakers, examine fuses, reset breakers, replace fuses, contact utility company','Check for loose connections, test control circuits, verify switch and breaker operation, inspect circuit breakers, test breaker trip functions, verify relay settings, inspect protective device wiring, confirm coordination, inspect transformers, ensure cooling system operation, monitor transformer temperature, inspect cables, inspect cable connections','High','Urgent','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9908',''),
('GEN10_010','Not provided','2026-07-23 17:10:00','Several lighting fixtures in the corridor were completely unresponsive.','Electrical','Lighting Not Working Related','Lighting & Branch Wiring','Flickering Lights','Loose Bulbs, Faulty Fixtures, Voltage Fluctuations','Tighten Bulbs, Repair or Replace Fixtures, Stabilize Voltage','Replace burned-out or flickering bulbs, Clean light diffusers, Tighten loose fixture mounts, Recalibrate dimmers, Replace emergency and exit lighting batteries','High','Urgent','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.5348',''),
('GEN10_011','Not provided','2026-07-24 09:15:00','The concierge queue moved extremely slowly during the busy afternoon.','','','','','','','','','','false','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.6937',''),
('GEN10_012','Not provided','2026-07-24 10:30:00','A fault in the fire sprinkler head caused a blocked sprinkler head during my stay.','Fire Protection','Clogging and Blockage','Sprinklers','Sprinkler head is blocked','Blockage due to debris or obstructions','Replace the clogged sprinkler head. If multiple heads are affected, flush the system.','Keep at least 18 inches clearance below sprinkler heads, inspect sprinkler heads regularly, and arrange routine sprinkler inspection by qualified fire protection technicians.','Critical','Immediate','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9973',''),
('GEN10_013','Not provided','2026-07-24 13:20:00','I experienced an unpleasant odor while using the hotel''s sink disposal unit.','Plumbing','Disposal','Sanitary Waste','Unpleasant Odors','Food waste and debris accumulation','Try the Ice and Salt Method, Citrus Fresh, or Baking Soda and Vinegar methods to clear blockages and deodorize the disposal','Run cold water while using the disposal and for 15-20 seconds after; Grind ice cubes and citrus peels regularly; Dispose of small food scraps; Avoid fibrous foods, grease, non-food items, expandable foods, and large bones','Medium','Standard','false','90 minutes','90','','Pending','false','false','','','','Pending Assignment','','','','','','0.9726',''),
('GEN10_014','Not provided','2026-07-24 15:10:00','The bathroom odor remained because the ventilation did not clear it.','HVAC','Exhaust Ventilation Systems','Distribution Systems','Bathroom smell does not go away','Exhaust fan not operating properly or blockage in exhaust system','Check and clean exhaust fan, grille, and duct; Replace fan motor if weak or not running; Ensure proper air discharge and clear air path','Clean bathroom exhaust grilles regularly; Inspect exhaust fan operation during routine room maintenance; Remove dust buildup from exhaust ducts when required','Medium','Standard','false','90 minutes','90','','Pending','false','false','','','','Pending Assignment','','','','','','0.6182',''),
('GEN10_015','Not provided','2026-07-25 11:45:00','Maintenance is required for delayed floor information on the elevator display affecting the passenger elevator before checkout.','Conveying','Elevators related','Elevator & Lifts','Delayed or lagging floor updates','Firmware or display controller performance issues','Update firmware or upgrade the display controller if delay continues','Update display firmware when required, test display response time during routine checks, avoid overloading the display system with unnecessary multimedia features, upgrade old display controllers when performance becomes slow','High','Urgent','true','90 minutes','90','','Pending','true','true','','','','HITL Required','','','','','','0.9988','');

INSERT INTO `hitl_cases` (`case_id`,`room`,`issue_summary`,`issue`,`hotel_asset`,`component`,`severity`,`priority`,`hitl_reason`,`safety_flag`,`review_status`,`manager_comment`,`created_at`,`failure_mode`,`observed_symptoms`,`possible_root_cause`) VALUES
('GEN10_001','Not provided','The hot-water service became unreliable after developing weak hot-water pressure before checkout.','The hot-water service became unreliable after developing weak hot-water pressure before checkout.','Plumbing','Domestic Water Distribution','High','Urgent','Low Confidence','true','Pending Review','','2026-07-23 09:00:00','D2022 Hot Water Service','Low hot water pressure','Sediment Buildup, Clogged showerhead, Water Leakage'),
('GEN10_002','Not provided','Normal operation of the room electrical supply was disrupted by a persistent electrical buzzing sound.','Normal operation of the room electrical supply was disrupted by a persistent electrical buzzing sound.','Electrical','Electrical Service & Distribution','High','Urgent','High','true','Pending Review','','2026-07-23 09:40:00','Main Electrical Supply','Buzzing or Humming Sounds','Loose or faulty electrical components, wiring, or transformers'),
('GEN10_003','Not provided','The passenger elevator car floor display was unlit and showed no information.','The passenger elevator car floor display was unlit and showed no information.','Conveying','Elevator & Lifts','High','Urgent','Low Confidence','true','Pending Review','','2026-07-23 10:20:00','Elevators related','Incorrect floor indication','Position sensor misalignment or encoder issue'),
('GEN10_004','Not provided','Please inspect the bathroom ventilation system; the bathroom exhaust fan would not run when switched on.','Please inspect the bathroom ventilation system; the bathroom exhaust fan would not run when switched on.','HVAC','Distribution Systems','Medium','Standard','Low Confidence','false','Pending Review','','2026-07-23 11:05:00','Exhaust Ventilation Systems','Bathroom smell does not go away','Exhaust fan not operating properly or blockage in exhaust system'),
('GEN10_005','Not provided','I experienced a blank elevator display while using the hotel''s passenger elevator.','I experienced a blank elevator display while using the hotel''s passenger elevator.','Conveying','Elevator & Lifts','High','Urgent','Low Confidence','true','Pending Review','','2026-07-23 12:15:00','Elevators related','Blank or Completely Dead Display','Power supply issues, loose wiring, blown fuses, unstable voltage, grounding, damaged internal parts'),
('GEN10_006','Not provided','The fire-fighting cylinder safety pin was broken or missing.','The fire-fighting cylinder safety pin was broken or missing.','Fire Protection','Fire Protection Specialisties','Critical','Immediate','High','true','Pending Review','','2026-07-23 13:30:00','Fire Extinguishers','Broken or Missing Safety Pin','Tampering or improper maintenance'),
('GEN10_007','Not provided','Normal operation of the fire alarm and detection system was disrupted by a fire alarm with no emergency.','Normal operation of the fire alarm and detection system was disrupted by a fire alarm with no emergency.','Fire Protection','Other Fire Protection System','Critical','Immediate','Low Confidence','true','Pending Review','','2026-07-23 14:10:00','Fire Alarm System & Smoke Detector Related','False Alarm Triggered by Smoke Detector','Low battery, zone fault, sounder fault, or general fault'),
('GEN10_008','Not provided','Water was leaking from the hot-water appliance.','Water was leaking from the hot-water appliance.','Plumbing','Domestic Water Distribution','High','Urgent','Low Confidence','true','Pending Review','','2026-07-23 15:25:00','D2022 Hot Water Service','Low hot water pressure','Sediment Buildup, Clogged showerhead, Water Leakage'),
('GEN10_009','Not provided','Please inspect the room electrical supply; the electrical point provided no power.','Please inspect the room electrical supply; the electrical point provided no power.','Electrical','Electrical Service & Distribution','High','Urgent','Low Confidence','true','Pending Review','','2026-07-23 16:00:00','Main Electrical Supply','Power Outages','Overloads, short circuits, or external factors'),
('GEN10_010','Not provided','Several lighting fixtures in the corridor were completely unresponsive.','Several lighting fixtures in the corridor were completely unresponsive.','Electrical','Lighting & Branch Wiring','High','Urgent','Low Confidence','true','Pending Review','','2026-07-23 17:10:00','Lighting Not Working Related','Flickering Lights','Loose Bulbs, Faulty Fixtures, Voltage Fluctuations'),
('GEN10_011','Not provided','The concierge queue moved extremely slowly during the busy afternoon.','The concierge queue moved extremely slowly during the busy afternoon.','','','','','Out of Knowledge Base','false','Pending Review','','2026-07-24 09:15:00','','',''),
('GEN10_012','Not provided','A fault in the fire sprinkler head caused a blocked sprinkler head during my stay.','A fault in the fire sprinkler head caused a blocked sprinkler head during my stay.','Fire Protection','Sprinklers','Critical','Immediate','Low Confidence','true','Pending Review','','2026-07-24 10:30:00','Clogging and Blockage','Sprinkler head is blocked','Blockage due to debris or obstructions'),
('GEN10_015','Not provided','Maintenance is required for delayed floor information on the elevator display affecting the passenger elevator before checkout.','Maintenance is required for delayed floor information on the elevator display affecting the passenger elevator before checkout.','Conveying','Elevator & Lifts','High','Urgent','Low Confidence','true','Pending Review','','2026-07-25 11:45:00','Elevators related','Delayed or lagging floor updates','Firmware or display controller performance issues');


-- HITL review-reason normalization for the ML JSONL contract.
-- Low Confidence is a manager-facing review reason. Category, Severity and
-- Priority remain available for routing and dashboard display.
UPDATE `hitl_cases`
SET `hitl_reason`='Critical'
WHERE LOWER(TRIM(COALESCE(`severity`,'')))='critical'
   OR UPPER(TRIM(COALESCE(`priority`,''))) LIKE 'P1%'
   OR LOWER(TRIM(COALESCE(`priority`,'')))='immediate';


-- Dedicated verification is separate from safety precautions. The dataset derives
-- a case-specific verification check only for unrestricted guidance cases.
UPDATE `smart_maintenance_tickets`
SET `verification`=CASE `case_id`
    WHEN 'GEN10_002' THEN 'Verify that the reported condition is resolved: Buzzing or Humming Sounds.'
    WHEN 'GEN10_006' THEN 'Verify that the reported condition is resolved: Broken or Missing Safety Pin.'
    WHEN 'GEN10_007' THEN 'Verify that the reported condition is resolved: False Alarm Triggered by Smoke Detector.'
    WHEN 'GEN10_012' THEN 'Verify that the reported condition is resolved: Sprinkler head is blocked.'
    WHEN 'GEN10_013' THEN 'Check the disposal for unpleasant odors after completing the corrective action.'
    WHEN 'GEN10_014' THEN 'Verify that bathroom smell has been eliminated after corrective action.'
    ELSE `verification`
END
WHERE `case_id` IN ('GEN10_002','GEN10_006','GEN10_007','GEN10_012','GEN10_013','GEN10_014');

UPDATE `cases`
SET `hotel_asset`='Other'
WHERE `hotel_asset` IS NULL
   OR TRIM(`hotel_asset`)=''
   OR LOWER(TRIM(`hotel_asset`)) IN ('-','unknown','none','null','n/a','na','out_of_kb','out of kb','out of knowledge base');

UPDATE `smart_maintenance_tickets`
SET `hotel_asset`='Other'
WHERE `hotel_asset` IS NULL
   OR TRIM(`hotel_asset`)=''
   OR LOWER(TRIM(`hotel_asset`)) IN ('-','unknown','none','null','n/a','na','out_of_kb','out of kb','out of knowledge base');

UPDATE `hitl_cases`
SET `hotel_asset`='Other'
WHERE `hotel_asset` IS NULL
   OR TRIM(`hotel_asset`)=''
   OR LOWER(TRIM(`hotel_asset`)) IN ('-','unknown','none','null','n/a','na','out_of_kb','out of kb','out of knowledge base');

INSERT INTO `workforce_cases` (`case_id`,`room`,`issue_summary`,`issue`,`hotel_asset`,`component`,`severity`,`priority`,`work_stage`,`task_status`,`response_target_minutes`,`repair_target_minutes`,`overall_sla_status`,`sla_status`,`safety_flag`,`case_created_at`) VALUES
('GEN10_013','Not provided','I experienced an unpleasant odor while using the hotel''s sink disposal unit.','I experienced an unpleasant odor while using the hotel''s sink disposal unit.','Plumbing','Sanitary Waste','Medium','Standard','Pending Assignment','Pending Assignment','30','90','Pending','Pending','false','2026-07-24 13:20:00'),
('GEN10_014','Not provided','The bathroom odor remained because the ventilation did not clear it.','The bathroom odor remained because the ventilation did not clear it.','HVAC','Distribution Systems','Medium','Standard','Pending Assignment','Pending Assignment','30','90','Pending','Pending','false','2026-07-24 15:10:00');

INSERT INTO `technician_tasks` (`case_id`,`technician_id`,`room`,`issue_summary`,`issue`,`priority`,`severity`,`escalation_trigger`,`task_status`,`response_target_minutes`,`repair_target_minutes`,`overall_sla_status`,`sla_status`,`safety_flag`,`component`,`failure_mode`,`observed_symptoms`,`possible_root_cause`,`corrective_action`,`preventive_maintenance`,`verification`,`hotel_asset`,`assigned_technician_id`,`case_created_at`) VALUES
('GEN10_013',NULL,'Not provided','I experienced an unpleasant odor while using the hotel''s sink disposal unit.','I experienced an unpleasant odor while using the hotel''s sink disposal unit.','Standard','Medium','AI Automation','Pending Assignment','30','90','Pending','Pending','false','Sanitary Waste','Disposal','Unpleasant Odors','Food waste and debris accumulation','Try the Ice and Salt Method, Citrus Fresh, or Baking Soda and Vinegar methods to clear blockages and deodorize the disposal','Run cold water while using the disposal and for 15-20 seconds after; Grind ice cubes and citrus peels regularly; Dispose of small food scraps; Avoid fibrous foods, grease, non-food items, expandable foods, and large bones','Check the disposal for unpleasant odors after completing the corrective action.','Plumbing',NULL,'2026-07-24 13:20:00'),
('GEN10_014',NULL,'Not provided','The bathroom odor remained because the ventilation did not clear it.','The bathroom odor remained because the ventilation did not clear it.','Standard','Medium','AI Automation','Pending Assignment','30','90','Pending','Pending','false','Distribution Systems','Exhaust Ventilation Systems','Bathroom smell does not go away','Exhaust fan not operating properly or blockage in exhaust system','Check and clean exhaust fan, grille, and duct; Replace fan motor if weak or not running; Ensure proper air discharge and clear air path','Clean bathroom exhaust grilles regularly; Inspect exhaust fan operation during routine room maintenance; Remove dust buildup from exhaust ducts when required','Verify that bathroom smell has been eliminated after corrective action','HVAC',NULL,'2026-07-24 15:10:00');


-- Additional fixed SQL seed cases (16-25).
-- These rows ensure every fresh installation starts with the same 25 cases.
INSERT INTO `cases` (`case_id`,`room_id`,`issue_summary`,`issue`,`hotel_asset`,`component`,`severity`,`priority`,`source_module`) VALUES
('SOAI-20260728-016','Room 305','Water is leaking from the ceiling beside the air-conditioning unit and the floor is becoming wet.','Water is leaking from the ceiling beside the air-conditioning unit and the floor is becoming wet.','HVAC','Air Distribution & Drainage','High','Urgent','HITL'),
('SOAI-20260728-017','Room 412','The toilet flush is weak and does not clear the bowl properly.','The toilet flush is weak and does not clear the bowl properly.','Plumbing','Sanitary Fixtures','Medium','Standard','AI Automation'),
('SOAI-20260728-018','Room 508','The bedside lamp keeps flickering even after I switched it off and on again.','The bedside lamp keeps flickering even after I switched it off and on again.','Electrical','Lighting & Branch Wiring','Medium','Standard','AI Automation'),
('SOAI-20260728-019','Room 611','The air conditioner is running but the room is still not cooling.','The air conditioner is running but the room is still not cooling.','HVAC','Cooling System','Medium','Standard','AI Automation'),
('SOAI-20260728-020','Lobby','The elevator door is stuck partly open and passengers cannot use it safely.','The elevator door is stuck partly open and passengers cannot use it safely.','Conveying','Elevator Doors','High','Urgent','HITL'),
('SOAI-20260729-021','Room 705','The bathroom sink drains very slowly after normal use.','The bathroom sink drains very slowly after normal use.','Plumbing','Sanitary Waste','Low','Low','AI Automation'),
('SOAI-20260729-022','Level 8 Corridor','The illuminated exit sign is completely dark.','The illuminated exit sign is completely dark.','Fire Protection','Emergency & Exit Lighting','Critical','Immediate','HITL'),
('SOAI-20260729-023','Room 809','The shower water stays cold even after waiting several minutes.','The shower water stays cold even after waiting several minutes.','Plumbing','Domestic Hot Water','Medium','Standard','AI Automation'),
('SOAI-20260729-024','Ballroom','There is a burning smell coming from a wall socket near the stage.','There is a burning smell coming from a wall socket near the stage.','Electrical','Electrical Service & Distribution','Critical','Immediate','HITL'),
('SOAI-20260729-025','Room 910','The bathroom exhaust fan makes a loud rattling noise.','The bathroom exhaust fan makes a loud rattling noise.','HVAC','Exhaust Ventilation Systems','Low','Low','AI Automation');

INSERT INTO `smart_maintenance_tickets`
(`case_id`,`room_id`,`created_at`,`cleaned_comment`,`hotel_asset`,`failure_mode`,`component`,`observed_symptoms`,`possible_root_cause`,`safety_precautions`,`verification`,`corrective_action`,`preventive_maintenance`,`severity_level`,`priority_level`,`safety`,`sla`,`sla_target`,`actual_time`,`sla_status`,`escalation_required`,`human_approval_required`,`technician_assigned_timestamp`,`technician_assigned`,`assigned_to`,`ticket_status`,`completed_date`,`support_status`,`support_reason`,`part_name`,`vendor_status`,`ai_confidence`,`risk_score`) VALUES
('SOAI-20260728-016','Room 305','2026-07-28 08:20:00','Water is leaking from the ceiling beside the air-conditioning unit and the floor is becoming wet.','HVAC','Condensate drainage blockage','Air Distribution & Drainage','Ceiling water leak near air-conditioning unit','Blocked drain line or overflowing condensate tray','Isolate electricity near the wet area and place a warning sign.','Confirm the leak has stopped and the floor is dry.','Inspect and clear the condensate drain; check the drain pan and insulation.','Clean drain lines and inspect condensate trays during scheduled HVAC maintenance.','High','Urgent','true','90 minutes','90','','Pending','true','true',NULL,NULL,NULL,'HITL Required',NULL,'','','','',0.94120,0.88000),
('SOAI-20260728-017','Room 412','2026-07-28 09:10:00','The toilet flush is weak and does not clear the bowl properly.','Plumbing','Partial blockage or low cistern water level','Sanitary Fixtures','Weak flushing performance','Blocked rim jets, faulty fill valve, or partial drain obstruction','','Confirm the toilet flushes normally without overflow.','Inspect the cistern level, clean rim jets, and clear any partial blockage.','Inspect fill valves and clean toilet jets during preventive room maintenance.','Medium','Standard','false','90 minutes','90','80 minutes','Within SLA','false','false','2026-07-28 09:15:00','TECH-005','TECH-005','Completed','2026-07-28 10:30:00','','','','',0.98200,0.42000),
('SOAI-20260728-018','Room 508','2026-07-28 11:40:00','The bedside lamp keeps flickering even after I switched it off and on again.','Electrical','Loose bulb or lamp connection','Lighting & Branch Wiring','Intermittent flickering','Loose lamp holder, worn bulb, or unstable connection','','Verify stable lighting for at least five minutes.','Tighten or replace the bulb and inspect the lamp holder and plug connection.','Inspect guest-room lamps and replace aging bulbs during room checks.','Medium','Standard','false','90 minutes','90','70 minutes','Within SLA','false','false','2026-07-28 11:45:00','TECH-007','TECH-007','Completed','2026-07-28 13:00:00','','','','',0.97600,0.38000),
('SOAI-20260728-019','Room 611','2026-07-28 14:20:00','The air conditioner is running but the room is still not cooling.','HVAC','Insufficient cooling output','Cooling System','Warm room while unit is operating','Dirty filter, incorrect thermostat setting, or low airflow','','Confirm the room temperature begins dropping after corrective action.','Check thermostat settings, clean the filter, and inspect airflow and cooling performance.','Clean filters and verify room temperature during scheduled HVAC servicing.','Medium','Standard','false','90 minutes','90','','Pending','false','false','2026-07-28 14:25:00','TECH-002','TECH-002','Assigned',NULL,'','','','',0.98800,0.45000),
('SOAI-20260728-020','Lobby','2026-07-28 16:45:00','The elevator door is stuck partly open and passengers cannot use it safely.','Conveying','Door interlock or obstruction fault','Elevator Doors','Door remains partly open','Obstruction, misaligned sensor, or door interlock fault','Keep passengers away and take the elevator out of service.','Verify the door closes and locks correctly through repeated tests.','Inspect door tracks, sensors, and interlocks; escalate to a qualified elevator specialist.','Clean door tracks and test interlocks during scheduled elevator maintenance.','High','Urgent','true','90 minutes','90','','Pending','true','true',NULL,NULL,NULL,'HITL Required',NULL,'','','','',0.96500,0.91000),
('SOAI-20260729-021','Room 705','2026-07-29 08:15:00','The bathroom sink drains very slowly after normal use.','Plumbing','Partial drain blockage','Sanitary Waste','Slow drainage','Hair, soap residue, or debris in the trap','','Confirm water drains freely without backing up.','Clean the stopper and trap, then flush the drain line.','Clean drain traps and strainers during routine room maintenance.','Low','Low','false','90 minutes','90','45 minutes','Within SLA','false','false','2026-07-29 08:20:00','TECH-006','TECH-006','Completed','2026-07-29 09:05:00','','','','',0.99100,0.22000),
('SOAI-20260729-022','Level 8 Corridor','2026-07-29 09:30:00','The illuminated exit sign is completely dark.','Fire Protection','Failed lamp, battery, or power supply','Emergency & Exit Lighting','Exit sign not illuminated','Battery failure, blown lamp, loose wiring, or supply loss','Keep the escape route clearly marked and arrange immediate inspection.','Test the sign on normal and backup power after repair.','Replace the failed lamp or battery and inspect the power connection.','Test emergency and exit lighting monthly and replace weak batteries.','Critical','Immediate','true','90 minutes','90','','Pending','true','true',NULL,NULL,NULL,'HITL Required',NULL,'','','','',0.99700,0.98000),
('SOAI-20260729-023','Room 809','2026-07-29 11:05:00','The shower water stays cold even after waiting several minutes.','Plumbing','Hot-water delivery issue','Domestic Hot Water','No hot water at shower','Mixer fault, isolated supply, or hot-water circulation issue','','Confirm stable hot-water temperature at the shower outlet.','Check the mixer valve, hot-water isolation valve, and circulation supply.','Inspect mixer valves and verify hot-water circulation during preventive maintenance.','Medium','Standard','false','90 minutes','90','','Pending','false','false','2026-07-29 11:10:00','TECH-004','TECH-004','In Progress',NULL,'','','','',0.98400,0.47000),
('SOAI-20260729-024','Ballroom','2026-07-29 13:50:00','There is a burning smell coming from a wall socket near the stage.','Electrical','Overheating electrical connection','Electrical Service & Distribution','Burning smell at socket','Loose terminal, overloaded circuit, or damaged socket','Isolate the circuit immediately and prevent use of the socket.','Confirm there is no heat, odor, or abnormal current after repair.','Isolate power, inspect wiring and terminals, and replace damaged components.','Perform thermal inspections and tighten electrical connections during maintenance.','Critical','Immediate','true','90 minutes','90','','Pending','true','true',NULL,NULL,NULL,'HITL Required',NULL,'','','','',0.99800,0.99000),
('SOAI-20260729-025','Room 910','2026-07-29 16:20:00','The bathroom exhaust fan makes a loud rattling noise.','HVAC','Loose fan blade or mounting','Exhaust Ventilation Systems','Rattling during operation','Loose grille, worn bearing, or unbalanced fan blade','','Confirm the fan runs quietly with normal airflow.','Secure the grille and mounting, inspect the blade, and replace worn parts if needed.','Clean and inspect exhaust fans during routine room maintenance.','Low','Low','false','90 minutes','90','','Pending','false','false','2026-07-29 16:25:00','TECH-003','TECH-003','Assigned',NULL,'','','','',0.98900,0.25000);

INSERT INTO `hitl_cases`
(`case_id`,`room`,`issue_summary`,`issue`,`hotel_asset`,`component`,`severity`,`priority`,`hitl_reason`,`safety_flag`,`review_status`,`manager_comment`,`created_at`,`failure_mode`,`observed_symptoms`,`possible_root_cause`) VALUES
('SOAI-20260728-016','Room 305','Water is leaking from the ceiling beside the air-conditioning unit and the floor is becoming wet.','Water is leaking from the ceiling beside the air-conditioning unit and the floor is becoming wet.','HVAC','Air Distribution & Drainage','High','Urgent','High','true','Pending Review','','2026-07-28 08:20:00','Condensate drainage blockage','Ceiling water leak near air-conditioning unit','Blocked drain line or overflowing condensate tray'),
('SOAI-20260728-020','Lobby','The elevator door is stuck partly open and passengers cannot use it safely.','The elevator door is stuck partly open and passengers cannot use it safely.','Conveying','Elevator Doors','High','Urgent','High','true','Pending Review','','2026-07-28 16:45:00','Door interlock or obstruction fault','Door remains partly open','Obstruction, misaligned sensor, or door interlock fault'),
('SOAI-20260729-022','Level 8 Corridor','The illuminated exit sign is completely dark.','The illuminated exit sign is completely dark.','Fire Protection','Emergency & Exit Lighting','Critical','Immediate','Critical','true','Pending Review','','2026-07-29 09:30:00','Failed lamp, battery, or power supply','Exit sign not illuminated','Battery failure, blown lamp, loose wiring, or supply loss'),
('SOAI-20260729-024','Ballroom','There is a burning smell coming from a wall socket near the stage.','There is a burning smell coming from a wall socket near the stage.','Electrical','Electrical Service & Distribution','Critical','Immediate','Critical','true','Pending Review','','2026-07-29 13:50:00','Overheating electrical connection','Burning smell at socket','Loose terminal, overloaded circuit, or damaged socket');

INSERT INTO `workforce_cases`
(`case_id`,`room`,`issue_summary`,`issue`,`hotel_asset`,`component`,`severity`,`priority`,`work_stage`,`task_status`,`response_target_minutes`,`response_minutes`,`response_sla_status`,`repair_target_minutes`,`repair_minutes`,`repair_sla_status`,`overall_sla_status`,`sla_status`,`assigned_technician_id`,`assigned_at`,`accepted_at`,`started_at`,`completed_at`,`safety_flag`,`technician_id`,`case_created_at`,`assignment_round`) VALUES
('SOAI-20260728-017','Room 412','The toilet flush is weak and does not clear the bowl properly.','The toilet flush is weak and does not clear the bowl properly.','Plumbing','Sanitary Fixtures','Medium','Standard','Completed','Completed',30,5,'Within SLA',90,80,'Within SLA','Within SLA','Within SLA','TECH-005','2026-07-28 09:15:00','2026-07-28 09:20:00','2026-07-28 09:25:00','2026-07-28 10:30:00','false','TECH-005','2026-07-28 09:10:00',1),
('SOAI-20260728-018','Room 508','The bedside lamp keeps flickering even after I switched it off and on again.','The bedside lamp keeps flickering even after I switched it off and on again.','Electrical','Lighting & Branch Wiring','Medium','Standard','Completed','Completed',30,5,'Within SLA',90,70,'Within SLA','Within SLA','Within SLA','TECH-007','2026-07-28 11:45:00','2026-07-28 11:50:00','2026-07-28 11:55:00','2026-07-28 13:00:00','false','TECH-007','2026-07-28 11:40:00',1),
('SOAI-20260728-019','Room 611','The air conditioner is running but the room is still not cooling.','The air conditioner is running but the room is still not cooling.','HVAC','Cooling System','Medium','Standard','Assigned - Not Started','Assigned',30,NULL,'Pending',90,NULL,'Pending','Pending','Pending','TECH-002','2026-07-28 14:25:00',NULL,NULL,NULL,'false','TECH-002','2026-07-28 14:20:00',1),
('SOAI-20260729-021','Room 705','The bathroom sink drains very slowly after normal use.','The bathroom sink drains very slowly after normal use.','Plumbing','Sanitary Waste','Low','Low','Completed','Completed',30,5,'Within SLA',90,45,'Within SLA','Within SLA','Within SLA','TECH-006','2026-07-29 08:20:00','2026-07-29 08:25:00','2026-07-29 08:30:00','2026-07-29 09:05:00','false','TECH-006','2026-07-29 08:15:00',1),
('SOAI-20260729-023','Room 809','The shower water stays cold even after waiting several minutes.','The shower water stays cold even after waiting several minutes.','Plumbing','Domestic Hot Water','Medium','Standard','Repair In Progress','In Progress',30,5,'Within SLA',90,NULL,'Pending','Pending','Pending','TECH-004','2026-07-29 11:10:00','2026-07-29 11:15:00','2026-07-29 11:20:00',NULL,'false','TECH-004','2026-07-29 11:05:00',1),
('SOAI-20260729-025','Room 910','The bathroom exhaust fan makes a loud rattling noise.','The bathroom exhaust fan makes a loud rattling noise.','HVAC','Exhaust Ventilation Systems','Low','Low','Assigned - Not Started','Assigned',30,NULL,'Pending',90,NULL,'Pending','Pending','Pending','TECH-003','2026-07-29 16:25:00',NULL,NULL,NULL,'false','TECH-003','2026-07-29 16:20:00',1);

INSERT INTO `technician_tasks`
(`case_id`,`technician_id`,`room`,`issue_summary`,`issue`,`priority`,`severity`,`escalation_trigger`,`task_status`,`assigned_time`,`accepted_time`,`started_time`,`completed_time`,`response_target_minutes`,`response_minutes`,`response_sla_status`,`repair_target_minutes`,`repair_minutes`,`repair_sla_status`,`overall_sla_status`,`sla_status`,`safety_flag`,`component`,`failure_mode`,`observed_symptoms`,`possible_root_cause`,`corrective_action`,`preventive_maintenance`,`verification`,`hotel_asset`,`assigned_technician_id`,`case_created_at`,`assignment_round`) VALUES
('SOAI-20260728-017','TECH-005','Room 412','The toilet flush is weak and does not clear the bowl properly.','The toilet flush is weak and does not clear the bowl properly.','Standard','Medium','AI Automation','Completed','2026-07-28 09:15:00','2026-07-28 09:20:00','2026-07-28 09:25:00','2026-07-28 10:30:00',30,5,'Within SLA',90,80,'Within SLA','Within SLA','Within SLA','false','Sanitary Fixtures','Partial blockage or low cistern water level','Weak flushing performance','Blocked rim jets, faulty fill valve, or partial drain obstruction','Inspect the cistern level, clean rim jets, and clear any partial blockage.','Inspect fill valves and clean toilet jets during preventive room maintenance.','Confirm the toilet flushes normally without overflow.','Plumbing','TECH-005','2026-07-28 09:10:00',1),
('SOAI-20260728-018','TECH-007','Room 508','The bedside lamp keeps flickering even after I switched it off and on again.','The bedside lamp keeps flickering even after I switched it off and on again.','Standard','Medium','AI Automation','Completed','2026-07-28 11:45:00','2026-07-28 11:50:00','2026-07-28 11:55:00','2026-07-28 13:00:00',30,5,'Within SLA',90,70,'Within SLA','Within SLA','Within SLA','false','Lighting & Branch Wiring','Loose bulb or lamp connection','Intermittent flickering','Loose lamp holder, worn bulb, or unstable connection','Tighten or replace the bulb and inspect the lamp holder and plug connection.','Inspect guest-room lamps and replace aging bulbs during room checks.','Verify stable lighting for at least five minutes.','Electrical','TECH-007','2026-07-28 11:40:00',1),
('SOAI-20260728-019','TECH-002','Room 611','The air conditioner is running but the room is still not cooling.','The air conditioner is running but the room is still not cooling.','Standard','Medium','AI Automation','Assigned','2026-07-28 14:25:00',NULL,NULL,NULL,30,NULL,'Pending',90,NULL,'Pending','Pending','Pending','false','Cooling System','Insufficient cooling output','Warm room while unit is operating','Dirty filter, incorrect thermostat setting, or low airflow','Check thermostat settings, clean the filter, and inspect airflow and cooling performance.','Clean filters and verify room temperature during scheduled HVAC servicing.','Confirm the room temperature begins dropping after corrective action.','HVAC','TECH-002','2026-07-28 14:20:00',1),
('SOAI-20260729-021','TECH-006','Room 705','The bathroom sink drains very slowly after normal use.','The bathroom sink drains very slowly after normal use.','Low','Low','AI Automation','Completed','2026-07-29 08:20:00','2026-07-29 08:25:00','2026-07-29 08:30:00','2026-07-29 09:05:00',30,5,'Within SLA',90,45,'Within SLA','Within SLA','Within SLA','false','Sanitary Waste','Partial drain blockage','Slow drainage','Hair, soap residue, or debris in the trap','Clean the stopper and trap, then flush the drain line.','Clean drain traps and strainers during routine room maintenance.','Confirm water drains freely without backing up.','Plumbing','TECH-006','2026-07-29 08:15:00',1),
('SOAI-20260729-023','TECH-004','Room 809','The shower water stays cold even after waiting several minutes.','The shower water stays cold even after waiting several minutes.','Standard','Medium','AI Automation','In Progress','2026-07-29 11:10:00','2026-07-29 11:15:00','2026-07-29 11:20:00',NULL,30,5,'Within SLA',90,NULL,'Pending','Pending','Pending','false','Domestic Hot Water','Hot-water delivery issue','No hot water at shower','Mixer fault, isolated supply, or hot-water circulation issue','Check the mixer valve, hot-water isolation valve, and circulation supply.','Inspect mixer valves and verify hot-water circulation during preventive maintenance.','Confirm stable hot-water temperature at the shower outlet.','Plumbing','TECH-004','2026-07-29 11:05:00',1),
('SOAI-20260729-025','TECH-003','Room 910','The bathroom exhaust fan makes a loud rattling noise.','The bathroom exhaust fan makes a loud rattling noise.','Low','Low','AI Automation','Assigned','2026-07-29 16:25:00',NULL,NULL,NULL,30,NULL,'Pending',90,NULL,'Pending','Pending','Pending','false','Exhaust Ventilation Systems','Loose fan blade or mounting','Rattling during operation','Loose grille, worn bearing, or unbalanced fan blade','Secure the grille and mounting, inspect the blade, and replace worn parts if needed.','Clean and inspect exhaust fans during routine room maintenance.','Confirm the fan runs quietly with normal airflow.','HVAC','TECH-003','2026-07-29 16:20:00',1);

-- Freeze all original 15 imported records to exact dates so that importing on a
-- different day never changes the dashboard history.
UPDATE `smart_maintenance_tickets` SET `created_at`=CASE `case_id`
  WHEN 'GEN10_001' THEN '2026-07-23 09:10:00'
  WHEN 'GEN10_002' THEN '2026-07-23 10:25:00'
  WHEN 'GEN10_003' THEN '2026-07-23 14:15:00'
  WHEN 'GEN10_004' THEN '2026-07-24 08:45:00'
  WHEN 'GEN10_005' THEN '2026-07-24 11:20:00'
  WHEN 'GEN10_006' THEN '2026-07-24 15:05:00'
  WHEN 'GEN10_007' THEN '2026-07-25 09:00:00'
  WHEN 'GEN10_008' THEN '2026-07-25 12:40:00'
  WHEN 'GEN10_009' THEN '2026-07-25 16:10:00'
  WHEN 'GEN10_010' THEN '2026-07-26 08:30:00'
  WHEN 'GEN10_011' THEN '2026-07-26 13:20:00'
  WHEN 'GEN10_012' THEN '2026-07-26 17:45:00'
  WHEN 'GEN10_013' THEN '2026-07-27 09:15:00'
  WHEN 'GEN10_014' THEN '2026-07-27 12:00:00'
  WHEN 'GEN10_015' THEN '2026-07-27 15:30:00'
  ELSE `created_at` END;

UPDATE `hitl_cases` h
INNER JOIN `smart_maintenance_tickets` s ON s.`case_id`=h.`case_id`
SET h.`created_at`=s.`created_at`;

UPDATE `workforce_cases` w
INNER JOIN `smart_maintenance_tickets` s ON s.`case_id`=w.`case_id`
SET w.`case_created_at`=s.`created_at`;

UPDATE `technician_tasks` t
INNER JOIN `smart_maintenance_tickets` s ON s.`case_id`=t.`case_id`
SET t.`case_created_at`=s.`created_at`;

-- Keep the two original AI cases deterministic instead of relying on FastAPI
-- to assign them differently on each recipient's computer.
UPDATE `workforce_cases` SET
  `assigned_technician_id`=CASE `case_id` WHEN 'GEN10_013' THEN 'TECH-004' WHEN 'GEN10_014' THEN 'TECH-001' ELSE `assigned_technician_id` END,
  `technician_id`=CASE `case_id` WHEN 'GEN10_013' THEN 'TECH-004' WHEN 'GEN10_014' THEN 'TECH-001' ELSE `technician_id` END,
  `assigned_at`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 09:20:00' WHEN 'GEN10_014' THEN '2026-07-27 12:05:00' ELSE `assigned_at` END,
  `accepted_at`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 09:25:00' WHEN 'GEN10_014' THEN '2026-07-27 12:10:00' ELSE `accepted_at` END,
  `started_at`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 09:30:00' WHEN 'GEN10_014' THEN '2026-07-27 12:15:00' ELSE `started_at` END,
  `completed_at`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 10:25:00' ELSE `completed_at` END,
  `work_stage`=CASE `case_id` WHEN 'GEN10_013' THEN 'Completed' WHEN 'GEN10_014' THEN 'Repair In Progress' ELSE `work_stage` END,
  `task_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Completed' WHEN 'GEN10_014' THEN 'In Progress' ELSE `task_status` END,
  `response_minutes`=5,
  `response_sla_status`='Within SLA',
  `repair_minutes`=CASE `case_id` WHEN 'GEN10_013' THEN 70 ELSE NULL END,
  `repair_sla_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Within SLA' ELSE 'Pending' END,
  `overall_sla_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Within SLA' ELSE 'Pending' END,
  `sla_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Within SLA' ELSE 'Pending' END,
  `assignment_round`=1
WHERE `case_id` IN ('GEN10_013','GEN10_014');

UPDATE `technician_tasks` SET
  `technician_id`=CASE `case_id` WHEN 'GEN10_013' THEN 'TECH-004' WHEN 'GEN10_014' THEN 'TECH-001' ELSE `technician_id` END,
  `assigned_technician_id`=CASE `case_id` WHEN 'GEN10_013' THEN 'TECH-004' WHEN 'GEN10_014' THEN 'TECH-001' ELSE `assigned_technician_id` END,
  `assigned_time`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 09:20:00' WHEN 'GEN10_014' THEN '2026-07-27 12:05:00' ELSE `assigned_time` END,
  `accepted_time`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 09:25:00' WHEN 'GEN10_014' THEN '2026-07-27 12:10:00' ELSE `accepted_time` END,
  `started_time`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 09:30:00' WHEN 'GEN10_014' THEN '2026-07-27 12:15:00' ELSE `started_time` END,
  `completed_time`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 10:25:00' ELSE `completed_time` END,
  `task_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Completed' WHEN 'GEN10_014' THEN 'In Progress' ELSE `task_status` END,
  `response_minutes`=5,
  `response_sla_status`='Within SLA',
  `repair_minutes`=CASE `case_id` WHEN 'GEN10_013' THEN 70 ELSE NULL END,
  `repair_sla_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Within SLA' ELSE 'Pending' END,
  `overall_sla_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Within SLA' ELSE 'Pending' END,
  `sla_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Within SLA' ELSE 'Pending' END,
  `assignment_round`=1
WHERE `case_id` IN ('GEN10_013','GEN10_014');

UPDATE `smart_maintenance_tickets` SET
  `technician_assigned_timestamp`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 09:20:00' WHEN 'GEN10_014' THEN '2026-07-27 12:05:00' ELSE `technician_assigned_timestamp` END,
  `technician_assigned`=CASE `case_id` WHEN 'GEN10_013' THEN 'TECH-004' WHEN 'GEN10_014' THEN 'TECH-001' ELSE `technician_assigned` END,
  `assigned_to`=CASE `case_id` WHEN 'GEN10_013' THEN 'TECH-004' WHEN 'GEN10_014' THEN 'TECH-001' ELSE `assigned_to` END,
  `ticket_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Completed' WHEN 'GEN10_014' THEN 'In Progress' ELSE `ticket_status` END,
  `completed_date`=CASE `case_id` WHEN 'GEN10_013' THEN '2026-07-27 10:25:00' ELSE `completed_date` END,
  `actual_time`=CASE `case_id` WHEN 'GEN10_013' THEN '70 minutes' ELSE `actual_time` END,
  `sla_status`=CASE `case_id` WHEN 'GEN10_013' THEN 'Within SLA' ELSE 'Pending' END
WHERE `case_id` IN ('GEN10_013','GEN10_014');


-- AI Automation routing is authoritative. Remove any stale HITL rows that may
-- have been left by an older imported database before FastAPI assigns work.
DELETE h FROM `hitl_cases` h
INNER JOIN `cases` c ON c.`case_id`=h.`case_id`
WHERE c.`source_module`='AI Automation';

INSERT INTO `admin_users` (`full_name`,`email`,`password_hash`,`role`,`created_at`) VALUES ('SmartStay Admin','admin@smartstay.com','$2y$12$PzoFexcQ7SnKrXayG.Fr8ewWFi5XrdznhLPTG7T9z2ecfFKfU3ETS','System Administrator','2026-07-23 08:00:00');

ALTER TABLE `hitl_cases`
  ADD CONSTRAINT `fk_hitl_case_master`
  FOREIGN KEY (`case_id`) REFERENCES `cases`(`case_id`)
  ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `workforce_cases`
  ADD CONSTRAINT `fk_workforce_case_master`
  FOREIGN KEY (`case_id`) REFERENCES `cases`(`case_id`)
  ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `fk_workforce_assigned_technician`
  FOREIGN KEY (`assigned_technician_id`) REFERENCES `technicians`(`technician_id`)
  ON UPDATE CASCADE ON DELETE SET NULL,
  ADD CONSTRAINT `fk_workforce_previous_technician`
  FOREIGN KEY (`previous_technician_id`) REFERENCES `technicians`(`technician_id`)
  ON UPDATE CASCADE ON DELETE SET NULL;

ALTER TABLE `technician_tasks`
  ADD CONSTRAINT `fk_task_case_master`
  FOREIGN KEY (`case_id`) REFERENCES `cases`(`case_id`)
  ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `fk_task_technician`
  FOREIGN KEY (`technician_id`) REFERENCES `technicians`(`technician_id`)
  ON UPDATE CASCADE ON DELETE SET NULL,
  ADD CONSTRAINT `fk_task_assigned_technician`
  FOREIGN KEY (`assigned_technician_id`) REFERENCES `technicians`(`technician_id`)
  ON UPDATE CASCADE ON DELETE SET NULL,
  ADD CONSTRAINT `fk_task_previous_technician`
  FOREIGN KEY (`previous_technician_id`) REFERENCES `technicians`(`technician_id`)
  ON UPDATE CASCADE ON DELETE SET NULL;

ALTER TABLE `task_assignment_history`
  ADD CONSTRAINT `fk_assignment_case`
  FOREIGN KEY (`case_id`) REFERENCES `cases`(`case_id`)
  ON UPDATE CASCADE ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assignment_technician`
  FOREIGN KEY (`technician_id`) REFERENCES `technicians`(`technician_id`)
  ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `smart_maintenance_tickets`
  ADD CONSTRAINT `fk_smart_case_master`
  FOREIGN KEY (`case_id`) REFERENCES `cases`(`case_id`)
  ON UPDATE CASCADE ON DELETE CASCADE;

CREATE OR REPLACE VIEW `v_technician_department_team` AS
SELECT
  department,
  SUM(CASE WHEN role='Technician' THEN 1 ELSE 0 END) AS regular_technician_count,
  SUM(CASE WHEN role='Technical Specialist' THEN 1 ELSE 0 END) AS technical_specialist_count
FROM technicians
WHERE is_active=1
GROUP BY department;

CREATE OR REPLACE VIEW `v_workforce_capacity_groups` AS
SELECT
  department AS capacity_group,
  COUNT(*) AS available_people
FROM technicians
WHERE is_active=1 AND role='Technician' AND status='Available'
GROUP BY department
UNION ALL
SELECT
  'Technical Specialist' AS capacity_group,
  COUNT(*) AS available_people
FROM technicians
WHERE is_active=1 AND role='Technical Specialist' AND status='Available';

CREATE OR REPLACE VIEW `v_smartstay_case_workflow` AS
SELECT
  c.case_id,
  c.room_id,
  c.issue_summary,
  c.hotel_asset,
  c.component,
  c.severity,
  c.priority,
  sm.created_at AS complaint_created_at,
  sm.ticket_status AS smart_ticket_status,
  sm.human_approval_required,
  h.hitl_reason,
  h.severity AS hitl_severity,
  h.priority AS hitl_priority,
  h.review_status,
  h.manager_comment,
  w.work_stage,
  w.task_status AS workforce_task_status,
  w.support_reason,
  w.support_status,
  w.assigned_technician_id,
  t.name AS technician_name,
  t.department AS technician_department,
  t.role AS database_role,
  CASE
    WHEN t.role='Technical Specialist' THEN 'HITL Technician'
    WHEN t.role='Technician' THEN 'AI Automation Technician'
    ELSE NULL
  END AS technician_workflow_role,
  tt.task_status AS technician_task_status,
  tt.assigned_time,
  tt.accepted_time,
  tt.started_time,
  tt.completed_time,
  tt.response_minutes,
  tt.response_sla_status,
  tt.repair_minutes,
  tt.repair_sla_status,
  tt.overall_sla_status,
  COALESCE(NULLIF(tt.sla_status,''),NULLIF(w.sla_status,''),NULLIF(sm.sla_status,'')) AS final_sla_status
FROM cases c
LEFT JOIN smart_maintenance_tickets sm ON sm.case_id=c.case_id
LEFT JOIN hitl_cases h ON h.case_id=c.case_id
LEFT JOIN workforce_cases w ON w.case_id=c.case_id
LEFT JOIN technicians t ON t.technician_id=w.assigned_technician_id
LEFT JOIN technician_tasks tt ON tt.case_id=c.case_id;


UPDATE technicians SET department='All Departments', category='All Departments', status='Available', total_tasks=0, active_tasks=0, completed_tasks=0, overdue_tasks=0, workload_percent=0, warning_reason='' WHERE role='Technical Specialist';
UPDATE technicians SET technician_level='Junior' WHERE technician_id BETWEEN 'TECH-016' AND 'TECH-020';
UPDATE technicians SET technician_level='Senior' WHERE technician_id BETWEEN 'TECH-021' AND 'TECH-025';
UPDATE technicians t
LEFT JOIN (
  SELECT technician_id,
         COUNT(*) AS total_tasks,
         SUM(CASE WHEN LOWER(COALESCE(task_status,'')) NOT LIKE '%complete%' THEN 1 ELSE 0 END) AS active_tasks,
         SUM(CASE WHEN LOWER(COALESCE(task_status,'')) LIKE '%complete%' THEN 1 ELSE 0 END) AS completed_tasks,
         SUM(CASE WHEN LOWER(COALESCE(overall_sla_status,'')) LIKE '%breach%' THEN 1 ELSE 0 END) AS overdue_tasks
  FROM technician_tasks
  WHERE COALESCE(technician_id,'')<>''
  GROUP BY technician_id
) x ON x.technician_id=t.technician_id
SET t.total_tasks=COALESCE(x.total_tasks,0),
    t.active_tasks=COALESCE(x.active_tasks,0),
    t.completed_tasks=COALESCE(x.completed_tasks,0),
    t.overdue_tasks=COALESCE(x.overdue_tasks,0),
    t.workload_percent=CASE WHEN COALESCE(x.active_tasks,0)>0 THEN 100 ELSE 0 END,
    t.status=CASE WHEN COALESCE(x.active_tasks,0)>0 THEN 'Busy' ELSE 'Available' END,
    t.warning_reason='';
-- Canonical Hotel Asset labels: keep JSON terminology and remove only the leading D-category code.
UPDATE cases SET hotel_asset=TRIM(SUBSTRING(TRIM(hotel_asset), LOCATE(' ', TRIM(hotel_asset)) + 1)) WHERE TRIM(hotel_asset) REGEXP '^D[0-9]+[[:space:]]+';
UPDATE hitl_cases SET hotel_asset=TRIM(SUBSTRING(TRIM(hotel_asset), LOCATE(' ', TRIM(hotel_asset)) + 1)) WHERE TRIM(hotel_asset) REGEXP '^D[0-9]+[[:space:]]+';
UPDATE workforce_cases SET hotel_asset=TRIM(SUBSTRING(TRIM(hotel_asset), LOCATE(' ', TRIM(hotel_asset)) + 1)) WHERE TRIM(hotel_asset) REGEXP '^D[0-9]+[[:space:]]+';
UPDATE technician_tasks SET hotel_asset=TRIM(SUBSTRING(TRIM(hotel_asset), LOCATE(' ', TRIM(hotel_asset)) + 1)) WHERE TRIM(hotel_asset) REGEXP '^D[0-9]+[[:space:]]+';
UPDATE smart_maintenance_tickets SET hotel_asset=TRIM(SUBSTRING(TRIM(hotel_asset), LOCATE(' ', TRIM(hotel_asset)) + 1)) WHERE TRIM(hotel_asset) REGEXP '^D[0-9]+[[:space:]]+';

UPDATE cases SET hotel_asset='Fire Protection' WHERE LOWER(TRIM(hotel_asset)) IN ('fire','fire system');
UPDATE hitl_cases SET hotel_asset='Fire Protection' WHERE LOWER(TRIM(hotel_asset)) IN ('fire','fire system');
UPDATE workforce_cases SET hotel_asset='Fire Protection' WHERE LOWER(TRIM(hotel_asset)) IN ('fire','fire system');
UPDATE technician_tasks SET hotel_asset='Fire Protection' WHERE LOWER(TRIM(hotel_asset)) IN ('fire','fire system');
UPDATE smart_maintenance_tickets SET hotel_asset='Fire Protection' WHERE LOWER(TRIM(hotel_asset)) IN ('fire','fire system');

UPDATE cases SET hotel_asset='Conveying' WHERE LOWER(TRIM(hotel_asset)) IN ('elevator','elevator & lifts','lifts');
UPDATE hitl_cases SET hotel_asset='Conveying' WHERE LOWER(TRIM(hotel_asset)) IN ('elevator','elevator & lifts','lifts');
UPDATE workforce_cases SET hotel_asset='Conveying' WHERE LOWER(TRIM(hotel_asset)) IN ('elevator','elevator & lifts','lifts');
UPDATE technician_tasks SET hotel_asset='Conveying' WHERE LOWER(TRIM(hotel_asset)) IN ('elevator','elevator & lifts','lifts');
UPDATE smart_maintenance_tickets SET hotel_asset='Conveying' WHERE LOWER(TRIM(hotel_asset)) IN ('elevator','elevator & lifts','lifts');

-- Demo login credentials (reset on every import of this single SQL file).
UPDATE technicians
SET password = CASE technician_id
  WHEN 'TECH-001' THEN '$2y$12$u9uxruhat8a1GjTvovNUCu.rIsGWNPvgcpNqoYMgE4SZsk5r9qOkK'
  WHEN 'TECH-002' THEN '$2y$12$51083.BNt9wkOKWkxGGG..Q00l/uP8DSMhaRYLycpwbf8RQKC/4H6'
  WHEN 'TECH-003' THEN '$2y$12$tmrD0Omq3gY9.knAiTX9b.VbIlp2Z46.T2JJBR79MhcKZE5CKzGSy'
  WHEN 'TECH-004' THEN '$2y$12$0ewpHuL4rHip0Jra8GMfz.Dc7ebVIKgbdlflc/W13aTiEmdBWGaXy'
  WHEN 'TECH-005' THEN '$2y$12$yLmP50O1t1P/.SugHTJL.e.v1ukmG9cCqH8xr5BBpJ25pFPY8Akhe'
  WHEN 'TECH-006' THEN '$2y$12$kpvrBrlKy0Wn5HMdLn2r8.wD3luJklcv2rHLU.w8wC1S8y8LBVcgS'
  WHEN 'TECH-007' THEN '$2y$12$Z9gr3gPnx/XhudDMF4h02e2D3Ypm7LY8iZpB6Aq1TPB6EAh9OOGH6'
  WHEN 'TECH-008' THEN '$2y$12$M706yP68AVcWsMQh5W7mGepmMsP60F.RS6blHoXk5PDibDRpuQLOq'
  WHEN 'TECH-009' THEN '$2y$12$p14ZPRZISWuC1UifACvgFOwr.u/dXJxgcq.QHEX479N3ipHGwmjUC'
  WHEN 'TECH-010' THEN '$2y$12$YC/0jzcT7z/EoONr57Yw2ue7bBMfUVaFkjiVcZOCNmJKxwjQsTuL.'
  WHEN 'TECH-011' THEN '$2y$12$yoAlQV7l1S5spPwZ4ws6oe1rM5g6f0OtVB5N/2HwcvZNGk3KJovVy'
  WHEN 'TECH-012' THEN '$2y$12$Jjy4Ce8GzaUaVmd1kVSfkezzkgMEyDJImiEWIUf9sKH8QpS0pYmZ6'
  WHEN 'TECH-013' THEN '$2y$12$dNL4pfpEF7oTTxLKT//TS.Z.XqvMYw6DWhQNrzSp8bFy5wh7NsYWC'
  WHEN 'TECH-014' THEN '$2y$12$iJcIpzVaSFdbKRNt8.aUQeQFp6B7xlh.9hOiwGUKuqoQCiFdqRmlu'
  WHEN 'TECH-015' THEN '$2y$12$aSbmpfxRE9y.A6sjINqP.e.6qw5ZtBS/lcRl2Pc0GJVpbSB.MG7S.'
  WHEN 'TECH-016' THEN '$2y$12$C90DvuBZNu4alhI3lxsJSejjEP74/YGH72x/Wh2nfwx.SVcdfziny'
  WHEN 'TECH-017' THEN '$2y$12$QBtQzLLf8E4.7WrU9.06Mu.2/ESlZPCF9fXHZiBslxFYBl8gdp3WG'
  WHEN 'TECH-018' THEN '$2y$12$xKmMOqoED8GJLD42FWjbLOmUSjBDGQ4wrhOm4yrFUNqBqZqIxehAG'
  WHEN 'TECH-019' THEN '$2y$12$QHb/VqedHVXO/0nW90pRg.V5vN54YHXJTuleotj9Zg6.e/ZFh9AVe'
  WHEN 'TECH-020' THEN '$2y$12$4FoJBszhEaun7P6RAEKST.R7JeIa6puiRkfwLWoe4B9DcKisgzbYW'
  WHEN 'TECH-021' THEN '$2y$12$IH92fGD9Z6A.vVKP5i0QcObBcbAwbNTpiQlOgyYVB4Br15J0NTUhG'
  WHEN 'TECH-022' THEN '$2y$12$f5OsUpiu2MvoaL8vOfD/NeF6cjXSoJhv3SWmawMJtnPJNORNXpQv.'
  WHEN 'TECH-023' THEN '$2y$12$aOM4mhrmeGmg70zvk4y6auXUQfP3C9/odXNxeBdKNeWtS5O.ZIcMq'
  WHEN 'TECH-024' THEN '$2y$12$Um7yQmycaBJ/IYHVOn9HCOGJm9IiP4L.GwmnOB1T5DK86BTlWytWe'
  WHEN 'TECH-025' THEN '$2y$12$yzBXx0nxcbQu5mxfA6LWx.ymPklubSInV541J9bmdXDr2bdKYZlUq'
  ELSE password
END
WHERE technician_id BETWEEN 'TECH-001' AND 'TECH-025';
UPDATE admin_users SET password_hash='$2y$12$PzoFexcQ7SnKrXayG.Fr8ewWFi5XrdznhLPTG7T9z2ecfFKfU3ETS', created_at='2026-07-23 08:00:00' WHERE email='admin@smartstay.com';

SET FOREIGN_KEY_CHECKS = 1;

-- Expected fixed SQL seed: cases 25; smart tickets 25; HITL 17; workforce 8; tasks 8; technicians 25.
-- Capacity rule: one active task per technician. HITL specialists: 5 Junior (TECH-016–020) and 5 Senior (TECH-021–025).
