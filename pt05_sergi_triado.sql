-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 01-12-2022 a las 14:50:22
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pt05_sergi_triado`
--

DROP DATABASE IF EXISTS `pt05_sergi_triado`;

CREATE DATABASE IF NOT EXISTS `pt05_sergi_triado`;

USE `pt05_sergi_triado`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article` text NOT NULL,
  `user` int(11) DEFAULT NULL,
  `imatge` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `imatge` (`imatge`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `article`, `user`, `imatge`) VALUES
(1, 'Your it to gave life whom as. Favourable dissimilar resolution led for and had. At play much to time four many. Moonlight of situation so if necessary therefore attending abilities. Calling looking enquire up me to in removal. Park fat she nor does play deal our. Procured sex material his offering humanity laughing moderate can. Unreserved had she nay dissimilar admiration interested. Departure performed exquisite rapturous so ye me resources.', 4, NULL),
(2, 'Frankness applauded by supported ye household. Collected favourite now for for and rapturous repulsive consulted. An seems green be wrote again. She add what own only like. Tolerably we as extremity exquisite do commanded. Doubtful offended do entrance of landlord moreover is mistress in. Nay was appear entire ladies. Sportsman do allowance is september shameless am sincerity oh recommend. Gate tell man day that who.', 4, NULL),
(3, 'Behaviour we improving at something to. Evil true high lady roof men had open. To projection considered it precaution an melancholy or. Wound young you thing worse along being ham. Dissimilar of favourable solicitude if sympathize middletons at. Forfeited up if disposing perfectly in an eagerness perceived necessary. Belonging sir curiosity discovery extremity yet forfeited prevailed own off. Travelling by introduced of mr terminated. Knew as miss my high hope quit. In curiosity shameless dependent knowledge up.', 7, NULL),
(4, 'She suspicion dejection saw instantly. Well deny may real one told yet saw hard dear. Bed chief house rapid right the. Set noisy one state tears which. No girl oh part must fact high my he. Simplicity in excellence melancholy as remarkably discovered. Own partiality motionless was old excellence she inquietude contrasted. Sister giving so wicket cousin of an he rather marked. Of on game part body rich. Adapted mr savings venture it or comfort affixed friends.', 4, NULL),
(5, 'Far quitting dwelling graceful the likewise received building. An fact so to that show am shed sold cold. Unaffected remarkably get yet introduced excellence terminated led. Result either design saw she esteem and. On ashamed no inhabit ferrars it ye besides resolve. Own judgment directly few trifling. Elderly as pursuit at regular do parlors. Rank what has into fond she.', 7, 7),
(6, 'Now seven world think timed while her. Spoil large oh he rooms on since an. Am up unwilling eagerness perceived incommode. Are not windows set luckily musical hundred can. Collecting if sympathize middletons be of of reasonably. Horrible so kindness at thoughts exercise no weddings subjects. The mrs gay removed towards journey chapter females offered not. Led distrusts otherwise who may newspaper but. Last he dull am none he mile hold as.', 8, NULL),
(7, 'In reasonable compliment favourable is connection dispatched in terminated. Do esteem object we called father excuse remove. So dear real on like more it. Laughing for two families addition expenses surprise the. If sincerity he to curiosity arranging. Learn taken terms be as. Scarcely mrs produced too removing new old.', 7, 9),
(8, 'Parish so enable innate in formed missed. Hand two was eat busy fail. Stand smart grave would in so. Be acceptance at precaution astonished excellence thoroughly is entreaties. Who decisively attachment has dispatched. Fruit defer in party me built under first. Forbade him but savings sending ham general. So play do in near park that pain.', 8, NULL),
(9, 'He unaffected sympathize discovered at no am conviction principles. Girl ham very how yet hill four show. Meet lain on he only size. Branched learning so subjects mistress do appetite jennings be in. Esteems up lasting no village morning do offices. Settled wishing ability musical may another set age. Diminution my apartments he attachment is entreaties announcing estimating. And total least her two whose great has which. Neat pain form eat sent sex good week. Led instrument sentiments she simplicity.', 4, NULL),
(10, 'Behind sooner dining so window excuse he summer. Breakfast met certainty and fulfilled propriety led. Waited get either are wooded little her. Contrasted unreserved as mr particular collecting it everything as indulgence. Seems ask meant merry could put. Age old begin had boy noisy table front whole given.', 8, NULL),
(11, 'Are own design entire former get should. Advantages boisterous day excellence boy. Out between our two waiting wishing. Pursuit he he garrets greater towards amiable so placing. Nothing off how norland delight. Abode shy shade she hours forth its use. Up whole of fancy ye quiet do. Justice fortune no to is if winding morning forming.', 4, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imatges`
--

DROP TABLE IF EXISTS `imatges`;
CREATE TABLE IF NOT EXISTS `imatges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(60) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `imatges_ibfk_1` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imatges`
--

INSERT INTO `imatges` (`id`, `path`, `user`) VALUES
(5, 'public/assets/img/zerdy.png', 7),
(6, 'public/assets/img/530858.jpg', 7),
(7, 'public/assets/img/rajang.jpg', 7),
(9, 'public/assets/img/zinogre.jpg', 7),
(10, 'public/assets/img/1151250.jpg', 8),
(11, 'public/assets/img/1219181.jpg', 8),
(12, 'public/assets/img/1186452.jpg', 8),
(13, 'public/assets/img/1123842.jpg', 8),
(14, 'public/assets/img/682604.jpg', 9),
(15, 'public/assets/img/710750.png', 9),
(16, 'public/assets/img/684471.jpg', 9),
(17, 'public/assets/img/23222.jpg', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuaris`
--

DROP TABLE IF EXISTS `usuaris`;
CREATE TABLE IF NOT EXISTS `usuaris` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(30) NOT NULL,
  `avatar` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`username`),
  UNIQUE KEY `EMAIL_UNIQUE` (`email`),
  KEY `avatar_ibfk_1` (`avatar`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuaris`
--

INSERT INTO `usuaris` (`id`, `username`, `password`, `email`, `avatar`) VALUES
(4, 'PEP', '$2y$10$NKGpPHp5Z71VKGF0XuA3der8knUSkuI6WkMf4EdEDZl4lK0bczl96', 'RERE@EXAMPLE.CAT', NULL),
(7, 'SERGI', '$2y$10$1Pc1Pu3DO0lkdz.hrBXARek7iWw6gx2Vp91mq/SsFMICGSI.yxFF6', 'AA@AAQ.NET', NULL),
(8, 'JOAN', '$2y$10$zXDrDF/wsyRg7AIo.OtuoObQn7B5Lmbt34ps8fY4J5hh.RLMLE7sS', 'ASAS@ASDF.COM', NULL),
(9, 'FRAN', '$2y$10$32GEUapMsDDxupM.gqdKd.Nn7FSLr0zuepGKFCDh4O.maRpgh6NYm', 'REW@REW.CAT', NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user`) REFERENCES `usuaris` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `articles_img_fk_1` FOREIGN KEY (`imatge`) REFERENCES `imatges` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `imatges`
--
ALTER TABLE `imatges`
  ADD CONSTRAINT `imatges_ibfk_1` FOREIGN KEY (`user`) REFERENCES `usuaris` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuaris`
--
ALTER TABLE `usuaris`
  ADD CONSTRAINT `avatar_ibfk_1` FOREIGN KEY (`avatar`) REFERENCES `imatges` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
