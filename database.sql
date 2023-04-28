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

CREATE TABLE `bt_user` (

                           `id_user` INT AUTO_INCREMENT NOT NULL ,

                           `first_name` VARCHAR(100)  NULL ,
                           `last_name` VARCHAR(100)  NULL ,
                           `user_name` VARCHAR(25)  NOT NULL ,
                           `email` VARCHAR(255)  NOT NULL ,
                           `access_level` INT  NOT NULL DEFAULT 3,
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
                              `article_created_at` DATETIME  NOT NULL DEFAULT NOW(),
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
                              `is_main` BOOL NOT NULL DEFAULT 0,
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
                              `comment_created_at` DATETIME  NOT NULL DEFAULT NOW(),
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
VALUES
    ('Jean', 'Marc', 'JM', 'jean.marc@gmail.com', '1', '1990-04-01', 'jm'),
    ('Ben ', 'Johnson', 'Big ben', 'ben.john@gmail.com', '2', '2000-01-01', 'bj'),
    ('Karim', 'Waly', 'wk', 'karim@gmail.com', '2', '1995-08-15', 'wc'),
    ('Paul', 'Newman', 'popol', 'paul@gmail.com', '3', '1998-06-12', 'pn');

INSERT INTO bt_article ( user_id, title, description_article, body_article)
values
    (1, 'La Tech : un monde en constante évolution', 'Cet article explore les dernières tendances et innovations dans le monde de la technologie, de l''intelligence artificielle et de la réalité virtuelle aux objets connectés et à la cybersécurité. ', 'La technologie est un domaine en constante évolution qui ne cesse de fasciner et d''impressionner. Les dernières avancées dans le domaine de l''intelligence artificielle, de la réalité virtuelle, de la cybersécurité et de la blockchain ont bouleversé les industries et ont ouvert de nouvelles perspectives pour l''avenir.

La révolution de ''IA est en train de changer la façon dont les entreprises fonctionnent et interagissent avec leurs clients. Les algorithmes d''apprentissage automatique ont permis de prédire les comportements des consommateurs, d''optimiser les processus de production et de fournir des solutions personnalisées.

La réalité virtuelle et augmentée a transformé l''industrie du divertissement, permettant aux utilisateurs de s''immerger complètement dans des environnements virtuels. Des entreprises telles que Google, Oculus et HTC ont développé des casques VR qui permettent aux utilisateurs de jouer à des jeux vidéo, de regarder des films et de visiter des endroits lointains sans quitter leur domicile.

La cybersécurité est devenue une préoccupation majeure pour les entreprises et les gouvernements, avec l''augmentation des cyberattaques et des menaces en ligne. Les professionnels de la sécurité informatique travaillent sans relâche pour développer des systèmes de défense robustes qui protègent les réseaux et les données sensibles.

La blockchain est une technologie de registre distribué qui permet de stocker des informations de manière sécurisée et transparente. Elle a le potentiel de révolutionner les transactions financières en éliminant les intermédiaires et en réduisant les coûts.

Enfin, les entreprises technologiques continuent de bousculer les industries traditionnelles, de la vente au détail à la finance en passant par les voyages. Amazon, Uber et Airbnb sont devenus des géants en offrant des services innovants qui ont transformé la façon dont nous achetons, voyageons et interagissons les uns avec les autres.

En somme, la technologie est en constante évolution et nous réserve encore de nombreuses surprises. Les dernières avancées ont déjà transformé notre façon de vivre et de travailler, mais l''avenir nous réserve encore plus d''innovations qui pourraient changer le monde tel que nous le connaissons. Il est donc important de rester informé des dernières tendances technologiques pour être prêt à saisir les opportunités de demain.'),
    (2, 'La robotique : des machines au service de l''homme', 'Robotique', 'La robotique est un domaine en constante évolution qui a déjà révolutionné plusieurs industries, telles que la fabrication, la médecine et l''agriculture. Les robots sont de plus en plus utilisés pour effectuer des tâches répétitives ou dangereuses, ou encore pour aider les travailleurs humains à accomplir des tâches plus complexes.

Les robots industriels, par exemple, sont utilisés pour assembler des voitures, des appareils électroniques et des produits manufacturés. Ils peuvent également être utilisés pour effectuer des tâches de maintenance et de réparation dans des environnements dangereux, tels que les centrales nucléaires.

Dans le domaine médical, les robots sont utilisés pour effectuer des interventions chirurgicales précises et minimiser les risques pour les patients. Les robots peuvent également aider les patients à récupérer de blessures ou de maladies, en offrant une assistance à la marche et en effectuant des exercices de rééducation.

Dans l''agriculture, les robots peuvent être utilisés pour semer et récolter des cultures, surveiller les plantes pour détecter les maladies ou les carences en nutriments et pour pulvériser les pesticides de manière précise et ciblée.

Cependant, les robots ne remplaceront jamais complètement les travailleurs humains. Les machines peuvent accomplir des tâches spécifiques, mais elles manquent de la créativité et de la souplesse d''esprit des humains. Les robots ne peuvent pas prendre de décisions complexes et ne peuvent pas interagir de manière aussi naturelle que les êtres humains.

En fin de compte, la robotique est un outil qui peut aider les humains à accomplir des tâches plus efficacement et en toute sécurité. Les machines peuvent compléter les compétences et les connaissances des travailleurs humains, mais elles ne peuvent pas les remplacer complètement. La robotique est donc un domaine passionnant qui offre de nombreuses possibilités pour améliorer notre qualité de vie, mais qui doit être utilisé avec sagesse pour s''assurer que les robots restent au service de l''homme.'),
    (3, 'Le langage PHP : un incontournable pour le développement web', 'Language', 'Depuis sa création en 1995, PHP est devenu un langage de programmation incontournable pour le développement web. Il est souvent utilisé pour créer des sites web dynamiques et des applications web. PHP est un langage open source, ce qui signifie qu''il est gratuit et peut être modifié pour répondre aux besoins spécifiques d''un projet.

PHP offre de nombreuses fonctionnalités, telles que la gestion des formulaires, la manipulation des fichiers et la communication avec les bases de données. Il peut également être intégré à d''autres langages de programmation pour créer des applications plus complexes.

En outre, PHP est compatible avec la plupart des systèmes d''exploitation et des serveurs web, ce qui le rend facile à déployer. Les développeurs peuvent également utiliser des frameworks PHP, tels que Laravel et Symfony, pour accélérer le développement de projets et gérer les tâches courantes plus efficacement.

Cependant, malgré ses avantages, PHP a été critiqué pour sa sécurité. Il est important de s''assurer que les sites web et les applications construits en utilisant PHP sont correctement sécurisés pour éviter les attaques malveillantes.

En conclusion, PHP reste un langage de programmation essentiel pour le développement web. Il offre une grande flexibilité et est utilisé par de nombreux sites web et applications populaires. Les développeurs devraient s''assurer qu''ils connaissent bien les bonnes pratiques de sécurité et utiliser les outils appropriés pour garantir la fiabilité et la sécurité de leurs projets.');

INSERT INTO bt_picture (article_id, link, is_main)
VALUES (1, 'pexels-sanket-mishra-16125027.jpg', 1);
INSERT INTO bt_picture (article_id, link)
VALUES (1, 'pexels-cottonbro-studio-8721318.jpg');
INSERT INTO bt_picture (article_id, link)
VALUES (1, 'pexels-tara-winstead-8386434.jpg');

INSERT INTO bt_comment (article_id, user_id, content_comment)
VALUES (1, 1, 'Je commente un article haha lol c''est trop rigolo de pouvoir commenter des articles je hurle !');
