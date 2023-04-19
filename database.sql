-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 26 Octobre 2017 à 13:53
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `circuit_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `bt_user`
--
CREATE TABLE `bt_user` (
                           `id_user` INT  NOT NULL ,
                           `first_name` VARCHAR(100)  NULL ,
                           `last_name` VARCHAR(100)  NULL ,
                           `user_name` VARCHAR(25)  NOT NULL ,
                           `email` VARCHAR(255)  NOT NULL ,
                           `access_level` INT  NOT NULL ,
                           `birthday` DATE  NULL ,
                           `user_password` VARCHAR(255)  NOT NULL ,
                           PRIMARY KEY (
                                        `id_user`
                               ),
                           CONSTRAINT `uc_bt_user_email` UNIQUE (
                                                                 `email`
                               )
);

-- Structure de la table `bt_article`
--
CREATE TABLE `bt_article` (
                              `id_article` INT  NOT NULL ,
                              `user_id` INT  NOT NULL ,
                              `title` VARCHAR(100)  NOT NULL ,
                              `description_article` VARCHAR(255)  NOT NULL ,
                              `body_article` TEXT  NOT NULL ,
                              `article_created_at` DATE  NOT NULL ,
                              PRIMARY KEY (
                                           `id_article`
                                  )
);

--Structure de la table `bt_picture`
--
CREATE TABLE `bt_picture` (
                              `id_picture` INT  NOT NULL ,
                              `article_id` INT  NOT NULL ,
                              `link` VARCHAR(300)  NOT NULL ,
                              PRIMARY KEY (
                                           `id_picture`
                                  )
);

--Structure de la table `bt_comment`
--
CREATE TABLE `bt_comment` (
                              `id_comment` INT  NOT NULL ,
                              `article_id` INT  NOT NULL ,
                              `user_id` INT  NOT NULL ,
                              `content_comment` VARCHAR(600)  NOT NULL ,
                              `comment_created_at` DATE  NOT NULL ,
                              PRIMARY KEY (
                                           `id_comment`
                                  )
);

--Structure de la table `bt_tag`
--
CREATE TABLE `bt_tag` (
                          `id_tag` INT  NOT NULL ,
                          `name_tag` VARCHAR(15)  NOT NULL ,
                          PRIMARY KEY (
                                       `id_tag`
                              )
);

--Structure de la table `bt_theme`
--
CREATE TABLE `bt_theme` (
                            `article_id` INT  NOT NULL ,
                            `tag_id` INT  NOT NULL
);

--
ALTER TABLE `bt_user` ADD CONSTRAINT `fk_bt_user_id_user` FOREIGN KEY(`id_user`)
    REFERENCES `bt_comment` (`user_id`);

ALTER TABLE `bt_article` ADD CONSTRAINT `fk_bt_article_id_article` FOREIGN KEY(`id_article`)
    REFERENCES `bt_comment` (`article_id`);

ALTER TABLE `bt_article` ADD CONSTRAINT `fk_bt_article_user_id` FOREIGN KEY(`user_id`)
    REFERENCES `bt_user` (`id_user`);

ALTER TABLE `bt_picture` ADD CONSTRAINT `fk_bt_picture_article_id` FOREIGN KEY(`article_id`)
    REFERENCES `bt_article` (`id_article`);

ALTER TABLE `bt_tag` ADD CONSTRAINT `fk_bt_tag_id_tag` FOREIGN KEY(`id_tag`)
    REFERENCES `bt_theme` (`tag_id`);

ALTER TABLE `bt_theme` ADD CONSTRAINT `fk_bt_theme_article_id` FOREIGN KEY(`article_id`)
    REFERENCES `bt_article` (`id_article`);
