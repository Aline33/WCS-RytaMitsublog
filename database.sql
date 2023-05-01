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
    (1,'La Tech : un monde en constante évolution','les avancées technologiques','La technologie est un domaine en constante évolution qui ne cesse de fasciner et d\'impressionner. Les dernières avancées dans le domaine de l\'intelligence artificielle, de la réalité virtuelle, de la cybersécurité et de la blockchain ont bouleversé les industries et ont ouvert de nouvelles perspectives pour l\'avenir.\r\n\r\nLa révolution de l\'IA est en train de changer la façon dont les entreprises fonctionnent et interagissent avec leurs clients. Les algorithmes d\'apprentissage automatique ont permis de prédire les comportements des consommateurs, d\'optimiser les processus de production et de fournir des solutions personnalisées.\r\n\r\nLa réalité virtuelle et augmentée a transformé l\'industrie du divertissement, permettant aux utilisateurs de s\'immerger complètement dans des environnements virtuels. Des entreprises telles que Google, Oculus et HTC ont développé des casques VR qui permettent aux utilisateurs de jouer à des jeux vidéo, de regarder des films et de visiter des endroits lointains sans quitter leur domicile.\r\n\r\nLa cybersécurité est devenue une préoccupation majeure pour les entreprises et les gouvernements, avec l\'augmentation des cyberattaques et des menaces en ligne. Les professionnels de la sécurité informatique travaillent sans relâche pour développer des systèmes de défense robustes qui protègent les réseaux et les données sensibles.\r\n\r\nLa blockchain est une technologie de registre distribué qui permet de stocker des informations de manière sécurisée et transparente. Elle a le potentiel de révolutionner les transactions financières en éliminant les intermédiaires et en réduisant les coûts.\r\n\r\nEnfin, les entreprises technologiques continuent de bousculer les industries traditionnelles, de la vente au détail à la finance en passant par les voyages. Amazon, Uber et Airbnb sont devenus des géants en offrant des services innovants qui ont transformé la façon dont nous achetons, voyageons et interagissons les uns avec les autres.\r\n\r\nEn somme, la technologie est en constante évolution et nous réserve encore de nombreuses surprises. Les dernières avancées ont déjà transformé notre façon de vivre et de travailler, mais l\'avenir nous réserve encore plus d\'innovations qui pourraient changer le monde tel que nous le connaissons. Il est donc important de rester informé des dernières tendances technologiques pour être prêt à saisir les opportunités de demain.'),(2,'La robotique : des machines au service de l\'homme','Robotique','La robotique est un domaine en constante évolution qui a déjà révolutionné plusieurs industries, telles que la fabrication, la médecine et l\'agriculture. Les robots sont de plus en plus utilisés pour effectuer des tâches répétitives ou dangereuses, ou encore pour aider les travailleurs humains à accomplir des tâches plus complexes.\r\n\r\nLes robots industriels, par exemple, sont utilisés pour assembler des voitures, des appareils électroniques et des produits manufacturés. Ils peuvent également être utilisés pour effectuer des tâches de maintenance et de réparation dans des environnements dangereux, tels que les centrales nucléaires.\r\n\r\nDans le domaine médical, les robots sont utilisés pour effectuer des interventions chirurgicales précises et minimiser les risques pour les patients. Les robots peuvent également aider les patients à récupérer de blessures ou de maladies, en offrant une assistance à la marche et en effectuant des exercices de rééducation.\r\n\r\nDans l\'agriculture, les robots peuvent être utilisés pour semer et récolter des cultures, surveiller les plantes pour détecter les maladies ou les carences en nutriments et pour pulvériser les pesticides de manière précise et ciblée.\r\n\r\nCependant, les robots ne remplaceront jamais complètement les travailleurs humains. Les machines peuvent accomplir des tâches spécifiques, mais elles manquent de la créativité et de la souplesse d\'esprit des humains. Les robots ne peuvent pas prendre de décisions complexes et ne peuvent pas interagir de manière aussi naturelle que les êtres humains.\r\n\r\nEn fin de compte, la robotique est un outil qui peut aider les humains à accomplir des tâches plus efficacement et en toute sécurité. Les machines peuvent compléter les compétences et les connaissances des travailleurs humains, mais elles ne peuvent pas les remplacer complètement. La robotique est donc un domaine passionnant qui offre de nombreuses possibilités pour améliorer notre qualité de vie, mais qui doit être utilisé avec sagesse pour s\'assurer que les robots restent au service de l\'homme.'),(3,'Le langage PHP : un incontournable pour le développement web','Language','Depuis sa création en 1995, PHP est devenu un langage de programmation incontournable pour le développement web. Il est souvent utilisé pour créer des sites web dynamiques et des applications web. PHP est un langage open source, ce qui signifie qu\'il est gratuit et peut être modifié pour répondre aux besoins spécifiques d\'un projet.\r\n\r\nPHP offre de nombreuses fonctionnalités, telles que la gestion des formulaires, la manipulation des fichiers et la communication avec les bases de données. Il peut également être intégré à d\'autres langages de programmation pour créer des applications plus complexes.\r\n\r\nEn outre, PHP est compatible avec la plupart des systèmes d\'exploitation et des serveurs web, ce qui le rend facile à déployer. Les développeurs peuvent également utiliser des frameworks PHP, tels que Laravel et Symfony, pour accélérer le développement de projets et gérer les tâches courantes plus efficacement.\r\n\r\nCependant, malgré ses avantages, PHP a été critiqué pour sa sécurité. Il est important de s\'assurer que les sites web et les applications construits en utilisant PHP sont correctement sécurisés pour éviter les attaques malveillantes.\r\n\r\nEn conclusion, PHP reste un langage de programmation essentiel pour le développement web. Il offre une grande flexibilité et est utilisé par de nombreux sites web et applications populaires. Les développeurs devraient s\'assurer qu\'ils connaissent bien les bonnes pratiques de sécurité et utiliser les outils appropriés pour garantir la fiabilité et la sécurité de leurs projets.'),(1,'Les compétences clés pour devenir un développeur web réussi','Cet article explore les fondamentaux du développement web.','Le développement web est un domaine en constante évolution qui permet de créer des sites et des applications web pour différents usages. En utilisant un ensemble de langages de programmation, de technologies et d\\\'outils, les développeurs web peuvent concevoir des applications pour une variété de dispositifs et de plateformes.\r\n\r\nLe développement web se divise en deux parties principales : le développement côté client (front-end) et le développement côté serveur (back-end). Le développement côté client se concentre sur l\\\'interface utilisateur (UI), les interactions avec les utilisateurs et la visualisation des données. Les développeurs front-end utilisent des langages comme HTML, CSS et JavaScript pour créer des pages web interactives et esthétiques.\r\n\r\nLe développement côté serveur se concentre sur la gestion des données, la sécurité et la logique de l\\\'application. Les développeurs back-end utilisent des langages comme PHP, Python, Ruby et Java pour créer des serveurs web et des bases de données. Ils travaillent également avec des frameworks comme Laravel, Django et Ruby on Rails pour accélérer le développement et la maintenance des applications web.\r\n\r\nLe développement web a évolué pour inclure de nouvelles technologies telles que les applications web progressives (PWA), les sites web réactifs, les microservices et les conteneurs. Les développeurs web doivent être à jour avec les dernières tendances et les meilleures pratiques pour offrir des expériences utilisateur de qualité.\r\n\r\nEn outre, le développement web est devenu un secteur d\\\'emploi en forte croissance. Les développeurs web travaillent pour des entreprises de toutes tailles, des start-ups aux grandes entreprises, et peuvent travailler dans différents domaines tels que le commerce électronique, les réseaux sociaux et la finance.\r\n\r\nEn somme, le développement web est un domaine passionnant qui évolue rapidement et qui offre de nombreuses opportunités professionnelles. Les développeurs web doivent être prêts à apprendre de nouvelles technologies et à rester à jour pour offrir des applications web de qualité.'),(2,'Lorem Ipsum : le texte fictif qui facilite la conception','Un texte d\'origine latine utilisé comme modèle de remplissage pour les maquettes de documents ou de pages web.','Lorem Ipsum est un texte fictif utilisé comme espace réservé pour des mises en page de sites web, des maquettes de documents et des publications imprimées. Ce texte standard est utilisé depuis des siècles et est devenu un outil essentiel pour les concepteurs graphiques, les imprimeurs et les éditeurs.\r\n\r\nLe Lorem Ipsum est généralement composé de passages en latin altérés, mais il existe également des variantes en d\'autres langues. La version la plus couramment utilisée est basée sur un texte de Cicéron, un écrivain romain de l\'Antiquité.\r\n\r\nLe texte Lorem Ipsum est souvent utilisé pour remplir les espaces réservés dans les modèles de conception, car il a une apparence proche de celle d\'un texte réel. Cela aide les concepteurs à visualiser comment le texte final sera disposé sur la page et comment il s\'intégrera avec les images et les éléments de conception.\r\n\r\nLe Lorem Ipsum est également utilisé dans la production de maquettes de livres, de magazines et de journaux. Les éditeurs peuvent utiliser ce texte fictif pour planifier et concevoir leur publication sans avoir à attendre la fin de la rédaction du contenu final.\r\n\r\nBien que l\'utilisation du Lorem Ipsum soit courante, certains critiques s\'opposent à son utilisation. Certains estiment que son utilisation est une forme de tromperie envers les clients, car elle ne fournit pas de contenu réel. D\'autres soutiennent que l\'utilisation du Lorem Ipsum nuit à la qualité globale de la conception, car elle peut masquer les problèmes de lisibilité et d\'ergonomie.\r\n\r\nEn conclusion, le Lorem Ipsum est un texte fictif largement utilisé dans les maquettes et les conceptions de sites web, les publications imprimées et les travaux d\'édition. Bien qu\'il soit controversé pour certains, il reste un outil utile pour les professionnels de la conception et de la publication pour aider à visualiser et à planifier la disposition de leur contenu.'),(3,'L\'évolution des jeux vidéo : une histoire de divertissement interactif','Cet article explore l\'univers des jeux vidéo, de leur histoire à leur influence sur la culture populaire.','Les jeux vidéo sont un passe-temps populaire pour des millions de personnes à travers le monde. Depuis les premiers jeux d\'arcade jusqu\'aux titres récents sur les consoles et les ordinateurs, les jeux vidéo ont évolué de manière significative au fil des décennies.\r\n\r\nLes jeux vidéo sont une forme de divertissement interactif qui permet aux joueurs de s\'immerger dans des mondes virtuels et d\'interagir avec des personnages et des objets fictifs. Les jeux vidéo sont disponibles sur de nombreuses plates-formes différentes, y compris les consoles de jeux, les ordinateurs, les appareils mobiles et même les navigateurs Web.\r\n\r\nLes jeux vidéo peuvent être classés en plusieurs catégories différentes, y compris les jeux d\'action, les jeux de rôle, les jeux de simulation et les jeux de sport. Les jeux vidéo peuvent également être joués en solo ou en multijoueur, en ligne ou en mode local.\r\n\r\nLes jeux vidéo sont devenus une industrie majeure, avec des revenus qui dépassent souvent ceux de l\'industrie cinématographique. Les développeurs de jeux vidéo travaillent sur des projets qui peuvent prendre plusieurs années pour être complétés, et de nombreux jeux sont vendus à des millions d\'exemplaires.\r\n\r\nLes jeux vidéo sont également devenus un outil éducatif pour certains, avec des jeux éducatifs qui aident les enfants à apprendre des compétences importantes comme les mathématiques et les langues étrangères. Les jeux vidéo peuvent également être utilisés pour la formation professionnelle et la simulation.\r\n\r\nBien que les jeux vidéo soient souvent considérés comme une activité de loisirs, ils ont suscité des préoccupations quant à leur impact sur la santé mentale et physique des joueurs. Certains experts craignent que les jeux vidéo addictifs puissent nuire à la santé mentale des joueurs et augmenter les risques d\'obésité et de maladies liées à la sédentarité.\r\n\r\nEn conclusion, les jeux vidéo sont une forme de divertissement populaire et diversifiée qui a évolué au fil des années. Ils sont disponibles sur de nombreuses plates-formes différentes et peuvent être utilisés à des fins éducatives et professionnelles. Bien que des préoccupations subsistent quant à leur impact sur la santé, les jeux vidéo continuent de fournir des heures de divertissement pour des millions de joueurs à travers le monde.'),(1,'SpaceX : La nouvelle ère de l\'industrie spatiale','Découvrez comment SpaceX a bouleversé l\'industrie spatiale avec ses lanceurs réutilisables et ses projets ambitieux pour l\'avenir de la colonisation de Mars et de la connectivité mondiale.','SpaceX est une entreprise américaine de transport spatial fondée en 2002 par Elon Musk. L\'entreprise est spécialisée dans la conception et la fabrication de lanceurs et de véhicules spatiaux réutilisables, avec pour objectif ultime de permettre aux humains de vivre sur d\'autres planètes.\r\n\r\nLe premier succès majeur de SpaceX est survenu en 2008, avec la première mission Falcon 1. Depuis lors, SpaceX a connu une croissance rapide, avec de nombreuses réalisations importantes. En 2010, SpaceX est devenue la première entreprise privée à envoyer un vaisseau spatial dans l\'espace et à le ramener sur Terre. En 2012, SpaceX a livré sa première cargaison à la Station spatiale internationale (ISS).\r\n\r\nLe lanceur Falcon 9 de SpaceX a été conçu pour être réutilisable, réduisant ainsi considérablement le coût des missions spatiales. En 2015, SpaceX a réussi à faire atterrir le premier étage du Falcon 9 sur une barge en mer, marquant une étape importante dans la réutilisation des fusées.\r\n\r\nEn 2020, SpaceX a lancé avec succès deux astronautes de la NASA dans l\'espace à bord de la capsule Crew Dragon, marquant le premier vol habité lancé à partir de sol américain depuis 2011. Depuis lors, SpaceX a effectué plusieurs autres missions avec succès, notamment la livraison de fournitures à la Station spatiale internationale et le lancement de satellites de communication.\r\n\r\nSpaceX travaille également sur plusieurs projets ambitieux pour l\'avenir. Le plus notable est probablement le programme Starship, qui vise à envoyer des humains sur Mars et établir une colonie sur la planète rouge. SpaceX a également annoncé son intention de fournir un accès à Internet haut débit dans les régions rurales du monde entier grâce à sa constellation de satellites Starlink.\r\n\r\nEn conclusion, SpaceX est une entreprise innovante et ambitieuse qui a accompli de nombreuses réalisations importantes dans le domaine de la technologie spatiale. Avec sa vision de coloniser d\'autres planètes et de fournir un accès à Internet haut débit à tous, SpaceX est un acteur important dans l\'avenir de l\'exploration spatiale et de la connectivité mondiale.'),(2,'test','test','test');

INSERT INTO bt_picture (article_id, link, is_main)
VALUES (1,'pexels-sanket-mishra-16125027.jpg',1),(1,'pexels-cottonbro-studio-8721318.jpg',0),(1,'pexels-tara-winstead-8386434.jpg',0),(2,'wesson-wang-y0_vFxOHayg-unsplash.jpg644a8a5bd1a26.jpg',1),(2,'technology-g0e01266d9_640.jpg644a8a5bd1de7.jpg',0),(2,'maximalfocus-naSAHDWRNbQ-unsplash.jpg644a8a5bd2864.jpg',0),(3,'pexels-miguel-á-padriñán-1591056.jpg644a8c2ed6591.jpg',1),(3,'shyam-mishra-0WjJZMyc-XU-unsplash.jpg644a8c2ed697f.jpg',0),(3,'anton-maksimov-5642-su-qM37iptlCNY-unsplash (1).jpg644a8c2ed6d2c.jpg',0),(4,'martin-katler-caNzzoxls8Q-unsplash.jpg644a8d8c4ddf6.jpg',1),(4,'wesson-wang-y0_vFxOHayg-unsplash.jpg644a8d8c4e2ee.jpg',0),(4,'javier-martinez-hUD0PUczwJQ-unsplash.jpg644a8d8c4e6c4.jpg',0),(5,'rocket-launch-g126549ff8_1920.jpg644a8e6feac3c.jpg',1),(6,'jr-korpa-9XngoIpxcEo-unsplash (1).jpg644b9a6b911ae.jpg',1),(6,'anton-maksimov-5642-su-qM37iptlCNY-unsplash (1).jpg644b9a6b91897.jpg',0),(6,'maximalfocus-naSAHDWRNbQ-unsplash.jpg644b9a6b91eb3.jpg',0);

INSERT INTO bt_comment (article_id, user_id, content_comment)
VALUES (1, 1, 'Je commente un article haha lol c''est trop rigolo de pouvoir commenter des articles je hurle !');
