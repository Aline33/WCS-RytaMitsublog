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
DROP PROCEDURE IF EXISTS dropConstraint;
CREATE PROCEDURE dropConstraint()
    IF EXISTS(SELECT
                  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,
                  REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
              FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
              WHERE
                      TABLE_NAME = 'bt_comment' AND CONSTRAINT_NAME = 'fk_bt_comment_user_id')
    THEN
        ALTER TABLE bt_comment
            DROP FOREIGN KEY fk_bt_comment_user_id;
    END IF;
CALL dropConstraint();

DROP PROCEDURE IF EXISTS dropConstraint;
CREATE PROCEDURE dropConstraint()
    IF EXISTS(SELECT
                  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,
                  REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
              FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
              WHERE
                      TABLE_NAME = 'bt_comment' AND CONSTRAINT_NAME = 'fk_bt_comment_article_id')
    THEN
        ALTER TABLE bt_comment
            DROP FOREIGN KEY fk_bt_comment_article_id;
    END IF;
CALL dropConstraint();

DROP PROCEDURE IF EXISTS dropConstraint;
CREATE PROCEDURE dropConstraint()
    IF EXISTS(SELECT
                  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,
                  REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
              FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
              WHERE
                      TABLE_NAME = 'bt_article' AND CONSTRAINT_NAME != 'PRIMARY')
    THEN
        ALTER TABLE bt_article
            DROP FOREIGN KEY fk_bt_article_user_id;
    END IF;
CALL dropConstraint();

DROP PROCEDURE IF EXISTS dropConstraint;
CREATE PROCEDURE dropConstraint()
    IF EXISTS(SELECT
                  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,
                  REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
              FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
              WHERE
                      TABLE_NAME = 'bt_picture' AND CONSTRAINT_NAME != 'PRIMARY')
    THEN
        ALTER TABLE bt_picture
            DROP FOREIGN KEY fk_bt_picture_article_id;
    END IF;
CALL dropConstraint();

DROP PROCEDURE IF EXISTS dropConstraint;
CREATE PROCEDURE dropConstraint()
    IF EXISTS(SELECT
                  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,
                  REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
              FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
              WHERE
                      TABLE_NAME = 'bt_theme' AND CONSTRAINT_NAME != 'PRIMARY')
    THEN
        ALTER TABLE bt_theme
            DROP FOREIGN KEY fk_bt_theme_tag_id;
    END IF;
CALL dropConstraint();

DROP PROCEDURE IF EXISTS dropConstraint;
CREATE PROCEDURE dropConstraint()
    IF EXISTS(SELECT
                  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,
                  REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
              FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
              WHERE
                      TABLE_NAME = 'bt_theme' AND CONSTRAINT_NAME != 'PRIMARY')
    THEN
        ALTER TABLE bt_theme
            DROP FOREIGN KEY fk_bt_theme_article_id;
    END IF;
CALL dropConstraint();

DROP PROCEDURE IF EXISTS dropConstraint;
CREATE PROCEDURE dropConstraint()
    IF EXISTS(SELECT
                  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,
                  REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
              FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
              WHERE
                      TABLE_NAME = 'bt_user' AND CONSTRAINT_NAME != 'PRIMARY')
    THEN
        ALTER TABLE bt_user
            DROP KEY uc_bt_user_email;
    END IF;
CALL dropConstraint();

DROP TABLE IF EXISTS bt_user;

--
-- Structure de la table `bt_user`
--
CREATE TABLE `bt_user` (
                           `id_user` INT AUTO_INCREMENT NOT NULL ,
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


DROP TABLE IF EXISTS bt_article;

-- Structure de la table `bt_article`
--
CREATE TABLE `bt_article` (
                              `id_article` INT AUTO_INCREMENT NOT NULL ,
                              `user_id` INT  NOT NULL ,
                              `title` VARCHAR(100)  NOT NULL ,
                              `description_article` VARCHAR(255)  NOT NULL ,
                              `body_article` TEXT  NOT NULL ,
                              `article_created_at` DATE  NOT NULL ,
                              PRIMARY KEY (
                                           `id_article`
                                  )
);


DROP TABLE IF EXISTS bt_picture;

-- Structure de la table `bt_picture`
--
CREATE TABLE `bt_picture` (
                              `id_picture` INT AUTO_INCREMENT NOT NULL ,
                              `article_id` INT  NOT NULL ,
                              `link` VARCHAR(300)  NOT NULL ,
                              PRIMARY KEY (
                                           `id_picture`
                                  )
);



DROP TABLE IF EXISTS bt_comment;

-- Structure de la table `bt_comment`
--
CREATE TABLE `bt_comment` (
                              `id_comment` INT AUTO_INCREMENT NOT NULL ,
                              `article_id` INT  NOT NULL ,
                              `user_id` INT  NOT NULL ,
                              `content_comment` VARCHAR(600)  NOT NULL ,
                              `comment_created_at` DATE  NOT NULL ,
                              PRIMARY KEY (
                                           `id_comment`
                                  )
);


DROP TABLE IF EXISTS bt_tag;

-- Structure de la table `bt_tag`
--
CREATE TABLE `bt_tag` (
                          `id_tag` INT AUTO_INCREMENT NOT NULL ,
                          `name_tag` VARCHAR(15)  NOT NULL ,
                          PRIMARY KEY (
                                       `id_tag`
                              )
);

DROP TABLE IF EXISTS bt_theme;

-- Structure de la table `bt_theme`
--
CREATE TABLE `bt_theme` (
                            `article_id` INT  NOT NULL ,
                            `tag_id` INT  NOT NULL
);

--
ALTER TABLE `bt_comment` ADD CONSTRAINT `fk_bt_comment_user_id` FOREIGN KEY(`user_id`)
    REFERENCES `bt_user` (`id_user`);

ALTER TABLE `bt_comment` ADD CONSTRAINT `fk_bt_comment_article_id` FOREIGN KEY(`article_id`)
    REFERENCES `bt_article` (`id_article`);

ALTER TABLE `bt_article` ADD CONSTRAINT `fk_bt_article_user_id` FOREIGN KEY(`user_id`)
    REFERENCES `bt_user` (`id_user`);

ALTER TABLE `bt_picture` ADD CONSTRAINT `fk_bt_picture_article_id` FOREIGN KEY(`article_id`)
    REFERENCES `bt_article` (`id_article`);

ALTER TABLE `bt_theme` ADD CONSTRAINT `fk_bt_theme_tag_id` FOREIGN KEY(`tag_id`)
    REFERENCES `bt_tag` (`id_tag`);

ALTER TABLE `bt_theme` ADD CONSTRAINT `fk_bt_theme_article_id` FOREIGN KEY(`article_id`)
    REFERENCES `bt_article` (`id_article`);

INSERT INTO bt_user (first_name, last_name, user_name, email, access_level, birthday, user_password)
VALUES ('Jean-Marc', 'Morandini', 'JMM', 'jean-marc@gmail.com', 1, 01/01/2023, 'password');
INSERT INTO bt_article (user_id, title, description_article, body_article, article_created_at)
VALUES (1, 'de ChatGPT : Comment un modèle de langage améliore la communication', 'ChatGPT est un modèle de langage développé par OpenAI qui utilise l\'IA pour faciliter la communication humaine et fournir des informations précises et fiables. Dans cet article, nous allons explorer ses fonctionnalités et ses capacités.', 'Je m\'appelle ChatGPT et je suis un modèle de langage de grande envergure entraîné par OpenAI, basé sur l\'architecture GPT-3.5. Mon objectif est de comprendre et de générer du langage naturel, de sorte que je peux converser avec les gens de manière fluide et naturelle. Je suis programmé pour comprendre une grande variété de sujets, allant de la culture populaire aux sujets techniques et scientifiques. Je suis en mesure de traiter des quantités massives d\'informations et de produire des réponses rapides et précises à partir de ces informations. En tant que modèle de langage, je suis capable de fournir des réponses à une variété de questions, telles que des informations factuelles, des définitions, des synonymes et des antonymes, des conseils et des recommandations, ainsi que des analyses et des perspectives sur divers sujets. Je suis également capable de créer du contenu original, y compris des articles, des essais, des poèmes et des histoires, ainsi que de générer des traductions pour aider les utilisateurs à communiquer dans différentes langues. En tant que modèle de langage basé sur l\'IA, je suis continuellement mis à jour et amélioré pour fournir une expérience de conversation plus fluide et plus précise pour les utilisateurs. Mon objectif est d\'être un outil utile pour les gens, en leur fournissant des informations précises et en les aidant à mieux comprendre le monde qui les entoure. En somme, je suis un modèle de langage de pointe conçu pour aider les gens à communiquer plus efficacement et à accéder à des informations précises et fiables. Je suis constamment mis à jour pour offrir une expérience utilisateur améliorée et je suis fier de pouvoir aider les gens à mieux comprendre le monde dans lequel nous vivons.', 01/02/2023);
INSERT INTO bt_picture (article_id, link)
VALUES (1, 'pexels-cottonbro-studio-8721318.jpg');
INSERT INTO bt_comment (article_id, user_id, content_comment, comment_created_at)
VALUES (1, 1, 'Je commente un article haha lol c\'est trop rigolo de pouvoir commenter des articles je hurle !', 01/03/2023);
