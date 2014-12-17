DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `email` varchar(60) NOT NULL COMMENT 'Email address',
  `first_name` varchar(45) NOT NULL COMMENT 'First Name',
  `last_name` varchar(45) NOT NULL COMMENT 'Last Name',
  `phone` varchar(45) NOT NULL COMMENT 'Phone #',
  `status` int(1) NOT NULL COMMENT 'Status',
  `role` int(1) NOT NULL COMMENT 'Role',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_email` (`email`),
  KEY `idx_user_last_name` (`last_name`),
  KEY `idx_user_phone` (`phone`),
  KEY `idx_user_status` (`status`),
  KEY `idx_user_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Location ID',
  `street` varchar(255) NOT NULL COMMENT 'Street address',
  `city` varchar(45) NOT NULL COMMENT 'City',
  `state` varchar(45) NOT NULL COMMENT 'State',
  `zip` varchar(12) NOT NULL COMMENT 'ZIP',
  `access_type` varchar(45) NOT NULL COMMENT 'Access type',
  `access_info` varchar(255) NULL COMMENT 'Access information',
  PRIMARY KEY (`id`),
  KEY `idx_location_street` (`street`),
  KEY `idx_location_city` (`city`),
  KEY `idx_location_zip` (`zip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Appointment ID',
  `rei` varchar(60) NOT NULL COMMENT 'REI #',
  `work_description` varchar(255) NOT NULL COMMENT 'Description of work',
  `location_id` int(11) NOT NULL COMMENT 'Location ID',
  `user_id` int(11) NULL COMMENT 'User ID',
  PRIMARY KEY (`id`),
  KEY `idx_appointment_rei` (`rei`),
  KEY `idx_appointment_location_id` (`location_id`),
  KEY `idx_appointment_user_id` (`user_id`),
  FOREIGN KEY (`location_id`)
    REFERENCES `location` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Event ID',
  `date` date NOT NULL COMMENT 'Event date',
  `time` time NULL COMMENT 'Event time',
  `created_at` datetime NOT NULL COMMENT 'Date created',
  `appointment_id` int(11) NOT NULL COMMENT 'Appointment ID',
  `status` int(1) NOT NULL COMMENT 'Status',
  PRIMARY KEY (`id`),
  KEY `idx_event_date` (`date`),
  KEY `idx_event_time` (`time`),
  KEY `idx_event_created_at` (`created_at`),
  KEY `idx_event_appointment_id` (`appointment_id`),
  KEY `idx_event_status` (`status`),
  FOREIGN KEY (`appointment_id`)
    REFERENCES `appointment` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `event_notes`;
CREATE TABLE `event_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Event notes ID',
  `notes` text NULL COMMENT 'Event notes',
  `created_at` datetime NOT NULL COMMENT 'Date created',
  `event_id` int(11) NOT NULL COMMENT 'Event ID',
  `user_id` int(11) NULL COMMENT 'User ID',
  `status` int(1) NOT NULL COMMENT 'Status',
  PRIMARY KEY (`id`),
  KEY `idx_event_notes_created_at` (`created_at`),
  KEY `idx_event_notes_event_id` (`event_id`),
  KEY `idx_event_notes_user_id` (`user_id`),
  KEY `idx_event_notes_status` (`status`),
  FOREIGN KEY (`event_id`)
    REFERENCES `event` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

