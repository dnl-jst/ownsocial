ALTER TABLE `files` ADD `name` VARCHAR(255) NULL DEFAULT NULL AFTER `content`;
ALTER TABLE `posts` ADD `attachment_file_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL AFTER `image_file_id`;

