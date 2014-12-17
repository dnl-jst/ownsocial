ALTER TABLE `configs` CHARACTER SET = utf8;
ALTER TABLE `configs` CHANGE `key` `key` VARCHAR(50)  CHARACTER SET utf8  NOT NULL  DEFAULT '';
ALTER TABLE `configs` CHANGE `value` `value` TEXT  CHARACTER SET utf8  NOT NULL;

ALTER TABLE `files` CHARACTER SET = utf8;
ALTER TABLE `files` CHANGE `type` `type` VARCHAR(255)  CHARACTER SET utf8  NOT NULL  DEFAULT '';

ALTER TABLE `groups` CHARACTER SET = utf8;
ALTER TABLE `groups` CHANGE `name` `name` VARCHAR(255)  CHARACTER SET utf8  NOT NULL  DEFAULT '';
ALTER TABLE `groups` CHANGE `description` `description` VARCHAR(255)  CHARACTER SET utf8  NULL  DEFAULT NULL;
ALTER TABLE `groups` CHANGE `type` `type` ENUM('public','protected','hidden')  CHARACTER SET utf8  NOT NULL  DEFAULT 'hidden';

ALTER TABLE `posts` CHARACTER SET = utf8;
ALTER TABLE `posts` CHANGE `visibility` `visibility` ENUM('public','contacts','me','group','comment')  CHARACTER SET utf8  NOT NULL  DEFAULT 'public';
ALTER TABLE `posts` CHANGE `content` `content` MEDIUMTEXT  CHARACTER SET utf8  NOT NULL;

ALTER TABLE `relations` CHARACTER SET = utf8;

ALTER TABLE `user_groups` CHANGE `role` `role` ENUM('member','admin')  CHARACTER SET utf8  NOT NULL  DEFAULT 'member';

ALTER TABLE `users` CHARACTER SET = utf8;
ALTER TABLE `users` CHANGE `type` `type` ENUM('user','admin')  CHARACTER SET utf8  NOT NULL  DEFAULT 'user';
ALTER TABLE `users` CHANGE `email` `email` VARCHAR(100)  CHARACTER SET utf8  NOT NULL  DEFAULT '';
ALTER TABLE `users` CHANGE `email_confirmation_hash` `email_confirmation_hash` VARCHAR(32)  CHARACTER SET utf8  NULL  DEFAULT NULL;
ALTER TABLE `users` CHANGE `password` `password` VARCHAR(255)  CHARACTER SET utf8  NOT NULL  DEFAULT '';
ALTER TABLE `users` CHANGE `language` `language` VARCHAR(2)  CHARACTER SET utf8  NOT NULL  DEFAULT 'en';
ALTER TABLE `users` CHANGE `first_name` `first_name` VARCHAR(255)  CHARACTER SET utf8  NOT NULL  DEFAULT '';
ALTER TABLE `users` CHANGE `last_name` `last_name` VARCHAR(255)  CHARACTER SET utf8  NOT NULL  DEFAULT '';
ALTER TABLE `users` CHANGE `department` `department` VARCHAR(255)  CHARACTER SET utf8  NULL  DEFAULT NULL;
