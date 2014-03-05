ALTER TABLE `users` ADD `timezone` VARCHAR(100)  NULL  DEFAULT 'UTC'  AFTER `modified`;
ALTER TABLE `users` ADD `billing_currency` CHAR(3)  NOT NULL  DEFAULT 'EUR'  AFTER `timezone`;
ALTER TABLE `users` CHANGE `timezone` `timezone` VARCHAR(100)  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT 'UTC';
ALTER TABLE `users` ADD `billing_vat_reg_no` VARCHAR(100)  NULL  DEFAULT NULL  AFTER `billing_currency`;
ALTER TABLE `users` ADD `phone` VARCHAR(50)  NOT NULL  DEFAULT ''  AFTER `billing_vat_reg_no`;
ALTER TABLE `users` MODIFY COLUMN `created` DATETIME NOT NULL AFTER `phone`;
ALTER TABLE `users` MODIFY COLUMN `modified` DATETIME NOT NULL AFTER `created`;
ALTER TABLE `users` MODIFY COLUMN `phone` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `timezone`;
ALTER TABLE `users` MODIFY COLUMN `phone` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `email`;
ALTER TABLE `users` ADD `locale` VARCHAR(5)  NULL  DEFAULT 'de'  AFTER `is_active`;

