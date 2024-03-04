SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE IF NOT EXISTS `language`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50) NOT NULL,
    `code` VARCHAR(2) NOT NULL,
    `priority` INTEGER DEFAULT 0,
    `is_default` TINYINT(1) DEFAULT 0 NOT NULL,
    `link_title` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `unique_title` (`title`),
    UNIQUE INDEX `unique_code` (`code`),
    UNIQUE INDEX `unique_link_title` (`link_title`)
) ENGINE=InnoDB;

INSERT INTO `language` (`id`, `title`, `code`, `priority`, `is_default`, `link_title`) VALUES
(1, 'Česky',  'cs', 10, 1,  'Česky'),
(2, 'English',  'en', 8,  0,  'English')
ON DUPLICATE KEY UPDATE id = id;

CREATE TABLE IF NOT EXISTS  `text`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `tid` VARCHAR(50) NOT NULL,
    `length` INTEGER NOT NULL,
    `text_group_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `unique_tid` (`tid`),
    INDEX `fi_t_FK_1` (`text_group_id`),
    CONSTRAINT `text_FK_1`
        FOREIGN KEY (`text_group_id`)
        REFERENCES `text_group` (`id`)
) ENGINE=InnoDB;

INSERT INTO `text` (`id`, `tid`, `length`, `text_group_id`) VALUES
(1, 'Globální titulek', 255,  3),
(2, 'Globální description', 255,  3),
(3, 'Globální keywords',  255,  3),
(4, 'Backend - Titulek',  255,  4)
ON DUPLICATE KEY UPDATE id = id;

CREATE TABLE IF NOT EXISTS  `text_group`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `domain` VARCHAR(100) NOT NULL,
    `priority` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `unique_name` (`name`)
) ENGINE=InnoDB;

INSERT INTO `text_group` (`id`, `name`, `domain`, `priority`) VALUES
(1, 'Všeobecné',  'frontend', 0),
(2, 'Zákazník', 'frontend', 0),
(3, 'SEO',  'frontend', 0),
(4, 'Backend',  'backend',  0)
ON DUPLICATE KEY UPDATE id = id;

CREATE TABLE IF NOT EXISTS  `text_i18n`
(
    `id` INTEGER NOT NULL,
    `culture` VARCHAR(5) DEFAULT 'cs' NOT NULL,
    `value` TEXT,
    PRIMARY KEY (`id`,`culture`),
    CONSTRAINT `text_i18n_fk_c96668`
        FOREIGN KEY (`id`)
        REFERENCES `text` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO `text_i18n` (`value`, `id`, `culture`) VALUES
('Fontai Backend',  1,  'cs'),
('Fontai backend in English', 1,  'en'),
('Fontai backend',  2,  'cs'),
('Fontai backend',  2,  'en'),
('Fontai backend',  3,  'cs'),
('Fontai backend',  3,  'en'),
('Fontai backend',  4,  'cs'),
('Fontai backend',  4,  'en')
ON DUPLICATE KEY UPDATE id = id;