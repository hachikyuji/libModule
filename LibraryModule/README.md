TO DO LIST:
	PATRON DASHBOARD - FUNCTIONALITIES
	REGISTER - INPUT VALIDATION
	BOOK ACQUISITION - INPUT VALIDATION, RESULT MESSAGE
	BOOK TERMINATION - INPUT VALIDATION, RESULT MESSAGE
	HISTORY - FINES UPDATE


Here's how to create the new table for the new system:

In 'library_module' schema,

CREATE TABLE `users` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`last_name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`account_type` VARCHAR(255) NOT NULL DEFAULT 'patron' COLLATE 'utf8mb4_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`remember_token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `users_email_unique` (`email`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6
;
