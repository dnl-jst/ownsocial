-- add user language column
ALTER TABLE `users` ADD `language` VARCHAR(2) NOT NULL DEFAULT 'en' AFTER `password`;

-- add default config value for language
INSERT INTO configs (`key`, `value`) VALUES ('default_language', 'en');
