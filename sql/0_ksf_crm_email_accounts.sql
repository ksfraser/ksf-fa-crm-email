-- ksf_FA_CRM_Email: email account tables

CREATE TABLE IF NOT EXISTS `0_ksf_crm_email_accounts` (
  `account_id`      INT(11) NOT NULL AUTO_INCREMENT,
  `name`            VARCHAR(255) NOT NULL,
  `email_address`   VARCHAR(255) NOT NULL,
  `smtp_host`       VARCHAR(255) NOT NULL,
  `smtp_port`       INT(11) NOT NULL DEFAULT 587,
  `username`        VARCHAR(255) DEFAULT NULL,
  `password_encrypted` VARCHAR(500) DEFAULT NULL,
  `from_name`       VARCHAR(255) DEFAULT NULL,
  `is_default`      TINYINT(1) NOT NULL DEFAULT 0,
  `created_at`      DATETIME NOT NULL,
  `updated_at`      DATETIME NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `uq_email_address` (`email_address`),
  KEY `idx_default` (`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
