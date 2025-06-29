-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 29 juin 2025 à 21:13
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `domaines`
--

CREATE TABLE `domaines` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `domaines`
--

INSERT INTO `domaines` (`id`, `nom`) VALUES
(1, 'Architecture'),
(2, 'Commerce'),
(3, 'Communication'),
(4, 'Droit'),
(5, 'Économie et Gestion'),
(6, 'Informatique'),
(7, 'Management'),
(8, 'Santé'),
(9, 'Sciences Politiques'),
(10, 'Sport');

-- --------------------------------------------------------

--
-- Structure de la table `etablissements`
--

CREATE TABLE `etablissements` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `site_web` varchar(255) DEFAULT NULL,
  `ville_id` int(11) DEFAULT NULL,
  `domaine_id` int(11) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etablissements`
--

INSERT INTO `etablissements` (`id`, `nom`, `description`, `site_web`, `ville_id`, `domaine_id`, `image`) VALUES
(1, 'ENSA Paris-La Villette', 'École d\'architecture majeure à Paris, reconnue pour la diversité de ses programmes et l\'importance de sa recherche.', 'https://www.paris-lavillette.archi.fr/', 1, 1, 'ENSA Paris-La Villette.jpg'),
(2, 'ENSA Paris-Belleville', 'École d\'architecture réputée, axée sur la théorie architecturale, l\'urbanisme et le patrimoine.', 'https://www.paris-belleville.archi.fr/', 1, 1, 'ENSA Paris-Belleville.jpg'),
(3, 'ENSA Paris-Malaquais', 'École d\'architecture innovante au cœur de Paris, connue pour son approche expérimentale et ses collaborations internationales.', 'https://www.malaquais.archi.fr/', 1, 1, 'ENSA Paris-Malaquais.jpg'),
(4, 'ENSA Versailles', 'École d\'architecture axée sur l\'histoire, le paysage et l\'urbanisme, dans un cadre prestigieux.', 'https://www.versailles.archi.fr/', 2, 1, 'ENSA Versailles.jpg'),
(5, 'ENSA Nantes', 'École d\'architecture dynamique, reconnue pour son expertise en architecture durable et conception numérique.', 'https://www.nantes.archi.fr/', 3, 1, 'ENSA Nantes.jpg'),
(6, 'ENSA Lyon', 'École d\'architecture de référence, centrée sur le design architectural, les stratégies urbaines et les enjeux sociétaux.', 'https://www.lyon.archi.fr/', 4, 1, 'ENSA Lyon.jpg'),
(7, 'ENSA Marseille', 'École d\'architecture spécialisée dans le contexte méditerranéen, l\'urbanisme et les pratiques durables.', 'https://www.marseille.archi.fr/', 5, 1, 'ENSA Marseille.jpg'),
(8, 'ENSA Toulouse', 'École d\'architecture orientée vers l\'architecture régionale, l\'urbanisme et l\'intégration des nouvelles technologies.', 'https://www.toulouse.archi.fr/', 6, 1, 'ENSA Toulouse.jpg'),
(9, 'ENSA Strasbourg', 'École d\'architecture complète, avec une forte dimension européenne et des collaborations transfrontalières.', 'https://www.strasbourg.archi.fr/', 7, 1, 'ENSA Strasbourg.jpg'),
(10, 'ENSA Montpellier', 'École d\'architecture reconnue pour son expertise en conception environnementale et développement durable.', 'https://www.montpellier.archi.fr/', 8, 1, 'ENSA Montpellier.jpg'),
(11, 'HEC Paris', 'École de commerce de renommée mondiale, très sélective, offrant une formation d\'excellence en management.', 'https://www.hec.edu/', 9, 2, 'HEC Paris.png'),
(12, 'INSEAD', 'École de commerce globale avec des campus internationaux, célèbre pour ses programmes MBA diversifiés.', 'https://www.insead.edu/fr', 10, 2, 'INSEAD.jpeg'),
(13, 'ESCP Business School', 'Ancienne école de commerce avec un modèle multi-campus, réputée pour son orientation internationale.', 'https://escp.eu/fr', 1, 2, 'ESCP Business School.jpg'),
(14, 'ESSEC Business School', 'Grande école de commerce française, innovante, reconnue pour son esprit entrepreneurial et ses liens solides avec les entreprises.', 'https://www.essec.edu/fr/', 11, 2, 'ESSEC Business School.jpeg'),
(15, 'EDHEC Business School', 'École de commerce reconnue pour ses programmes en finance, son excellence en recherche et son leadership responsable.', 'https://www.edhec.edu/fr', 12, 2, 'EDHEC Business School.jpeg'),
(16, 'emlyon business school', 'École de commerce axée sur l\'innovation et l\'entrepreneuriat, avec des programmes en management et transformation digitale.', 'https://em-lyon.com/fr', 4, 2, 'emlyon business school.png'),
(17, 'EMLV', 'École de commerce du Pôle Léonard de Vinci, proposant des programmes avec une forte composante numérique et technologique.', 'https://www.emlv.fr/', 13, 2, 'EMLV.jpg'),
(18, 'INSEEC Business School', 'École de commerce privée offrant un large éventail de programmes en management, finance, marketing et communication.', 'https://www.inseec.com/', 1, 2, 'INSEEC Business School.jpg'),
(19, 'EDC Paris Business School', 'École de commerce spécialisée dans l\'entrepreneuriat, formant des leaders et innovateurs d\'entreprise.', 'https://www.edcparis.edu/', 13, 2, 'EDC Paris Business School.jpeg'),
(20, 'PSB Paris School of Business', 'École de commerce proposant des programmes internationaux, axés sur le développement professionnel et les perspectives mondiales.', 'https://www.psbedu.paris/', 1, 2, 'PSB Paris School of Business.jpeg'),
(21, 'CELSA (Sorbonne Université)', 'École prestigieuse de la Sorbonne Université, spécialisée en communication, journalisme et marketing.', 'https://celsa.fr/', 14, 3, 'CELSA (Sorbonne Université).png'),
(22, 'EFAP', 'Grande école de communication, offrant des programmes en relations publiques, publicité, médias et communication numérique.', 'https://www.efap.com/', 1, 3, 'EFAP.png'),
(23, 'ISCOM', 'École de communication globale et marketing, axée sur la créativité et l\'insertion professionnelle.', 'https://www.iscom.fr/', 1, 3, 'ISCOM.jpeg'),
(24, 'Sup de Pub', 'École renommée pour la publicité, le marketing et la communication, membre du groupe INSEEC U.', 'https://www.supdepub.com/', 1, 3, 'Sup de Pub.jpg'),
(25, 'Audencia SciencesCom', 'École de communication et médias, partie d\'Audencia Business School, avec une forte orientation professionnelle.', 'https://www.audencia.com/formations/sciencescom/', 3, 3, 'Audencia SciencesCom.jpg'),
(26, 'ESP', 'École de communication proposant des programmes en publicité et marketing digital, avec une approche pratique.', 'https://www.esp-edu.com/', 1, 3, 'ESP.jpg'),
(27, 'ISCPA', 'École spécialisée en journalisme, communication et production, offrant une formation pratique et des liens avec l\'industrie.', 'https://www.iscpa-ecoles.com/', 1, 3, 'ISCPA.jpg'),
(28, 'ISEG', 'École proposant des programmes en marketing, communication et digital, axés sur l\'innovation et les défis du marché.', 'https://www.iseg.fr/', 1, 3, 'ISEG.jpg'),
(29, 'ISG', 'École de commerce et management avec une forte dimension internationale, incluant des spécialisations en communication.', 'https://www.isg.fr/', 1, 3, 'ISG.jpg'),
(30, 'IICP', 'École de communication et de journalisme connue pour sa formation professionnelle et ses partenariats avec les entreprises.', 'https://www.iicp.fr/', 1, 3, 'IICP.jpg'),
(31, 'Université Paris-Panthéon-Assas', 'Université de droit très respectée, reconnue pour sa rigueur académique et son approche traditionnelle du droit.', 'https://www.u-paris2.fr/', 1, 4, 'Université Paris-Panthéon-Assas.jpg'),
(32, 'Université Paris 1 Panthéon-Sorbonne', 'Grande université française avec une solide réputation en droit, économie et sciences humaines.', 'https://www.pantheonsorbonne.fr/', 1, 4, 'Université Paris 1 Panthéon-Sorbonne.jpg'),
(33, 'Université Paris Cité', 'Université pluridisciplinaire offrant un large éventail de programmes juridiques, reconnue pour sa recherche et ses collaborations internationales.', 'https://u-paris.fr/', 1, 4, 'Université Paris Cité.jpg'),
(34, 'Université de Strasbourg', 'Université proposant des programmes de droit complets avec une forte orientation européenne et internationale.', 'https://www.unistra.fr/', 7, 4, 'Université de Strasbourg.jpg'),
(35, 'Université de Bordeaux', 'Université majeure avec de solides programmes de droit, particulièrement connue pour sa recherche en droit public et privé.', 'https://www.u-bordeaux.fr/', 16, 4, 'Université de Bordeaux.jpg'),
(36, 'Université Paris-Est Créteil', 'Université offrant une variété de diplômes en droit axés sur l\'insertion professionnelle et les compétences juridiques pratiques.', 'https://www.u-pec.fr/', 15, 4, 'Université Paris-Est Créteil.jpg'),
(37, 'Université Toulouse 1 Capitole', 'Université spécialisée en droit, économie et gestion, avec un fort accent sur la recherche et la formation professionnelle.', 'https://www.ut-capitole.fr/', 6, 4, 'Université Toulouse 1 Capitole.jpg'),
(38, 'Université Rennes 1', 'Université reconnue pour sa solide faculté de droit et sa recherche dans divers domaines juridiques.', 'https://www.univ-rennes1.fr/', 17, 4, 'Université Rennes 1.jpg'),
(39, 'Université de Montpellier', 'L\'une des plus anciennes universités de France, offrant de vastes programmes de droit avec un riche héritage historique.', 'https://www.umontpellier.fr/', 8, 4, 'Université de Montpellier.jpg'),
(40, 'Université de Lorraine', 'Université proposant divers programmes de droit sur ses campus, axés sur les questions juridiques régionales et européennes.', 'https://www.univ-lorraine.fr/', 18, 4, 'Université de Lorraine.png'),
(41, 'Université Paris-Dauphine', 'Université prestigieuse spécialisée en sciences des organisations et de la décision, avec de solides programmes en économie, gestion et finance.', 'https://dauphine.psl.eu/', 1, 5, 'Université Paris-Dauphine.png'),
(42, 'Université Paris 1 Panthéon-Sorbonne', 'Grande université française avec une solide réputation en droit, économie et sciences humaines.', 'https://www.pantheonsorbonne.fr/', 1, 5, 'Université Paris 1 Panthéon-Sorbonne.jpg'),
(43, 'Université Paris Cité', 'Université pluridisciplinaire offrant un large éventail de programmes juridiques, reconnue pour sa recherche et ses collaborations internationales.', 'https://u-paris.fr/', 1, 5, 'Université Paris Cité.jpg'),
(44, 'Université Lyon 2', 'Université reconnue pour ses programmes solides en économie, gestion et sciences sociales, avec un fort accent sur la recherche.', 'https://www.univ-lyon2.fr/', 4, 5, 'Université Lyon 2.jpg'),
(45, 'Université Clermont Auvergne', 'Université majeure avec de solides programmes de droit, particulièrement connue pour sa recherche en droit public et privé.', 'https://uca.fr', 25, 5, 'Université Clermont Auvergne.jpg'),
(46, 'Université Toulouse 1 Capitole', 'Université spécialisée en droit, économie et gestion, avec un fort accent sur la recherche et la formation professionnelle.', 'https://www.ut-capitole.fr/', 6, 5, 'Université Toulouse 1 Capitole.jpg'),
(47, 'Université Rennes 1', 'Université reconnue pour sa solide faculté de droit et sa recherche dans divers domaines juridiques.', 'https://www.univ-rennes1.fr/', 17, 5, 'Université Rennes 1.jpg'),
(48, 'Université de Corse Pasquale Paoli', 'L\'une des plus anciennes universités de France, offrant de vastes programmes de droit avec un riche héritage historique.', 'https://universita.corsica', 25, 5, 'Université de Corse Pasquale Paoli.jpg'),
(49, 'Université de Nantes', 'Université proposant divers programmes en économie et gestion, avec un lien fort avec les industries régionales.', 'https://www.univ-nantes.fr/', 3, 5, 'Université de Nantes.jpg'),
(50, 'Université de Strasbourg', 'Université proposant des programmes de droit complets avec une forte orientation européenne et internationale.', 'https://www.unistra.fr/', 7, 5, 'Université de Strasbourg.jpg'),
(51, 'École polytechnique', 'Établissement prestigieux en sciences et ingénierie. Formation d’excellence avec un fort rayonnement international.', 'https://www.polytechnique.edu/', 19, 6, 'École polytechnique.jpg'),
(52, 'Mines Paris – PSL', 'Grande école d\'ingénieurs de PSL, reconnue pour ses programmes en informatique, science des données et IA.', 'https://www.minesparis.psl.eu/', 1, 6, 'Mines Paris – PSL.png'),
(53, 'CentraleSupélec', 'École d\'ingénieurs de premier plan, offrant des programmes avancés en informatique et numérique.', 'https://www.centralesupelec.fr/', 20, 6, 'CentraleSupélec.jpg'),
(54, 'Télécom Paris', 'Grande école d\'ingénieurs spécialisée en sciences et technologies de l\'information et de la communication.', 'https://www.telecom-paris.fr/', 1, 6, 'Télécom Paris.jpg'),
(55, 'Centrale Lyon', 'École d\'ingénieurs de premier plan, proposant de solides programmes en informatique, ingénierie numérique et systèmes industriels.', 'https://www.ec-lyon.fr/', 4, 6, 'Centrale Lyon.jpg'),
(56, 'Centrale Nantes', 'École d\'ingénieurs innovante, connue pour ses programmes en informatique, robotique et fabrication numérique.', 'https://www.ec-nantes.fr/', 3, 6, 'Centrale Nantes.jpg'),
(57, 'IMT Atlantique', 'Grande école d\'ingénieurs spécialisée dans les technologies numériques, l\'énergie et l\'environnement.', 'https://www.imt-atlantique.fr/', 3, 6, 'IMT Atlantique.jpg'),
(58, 'INSA Lyon', 'Une des plus grandes écoles d\'ingénieurs de France, offrant un programme d\'informatique complet avec un fort accent sur la recherche.', 'https://www.insa-lyon.fr/', 21, 6, 'INSA Lyon.jpg'),
(59, 'ECE Paris', 'École d\'ingénieurs spécialisée dans la technologie numérique, l\'informatique et l\'innovation.', 'https://www.ece.fr/', 1, 6, 'ECE Paris.jpeg'),
(60, 'EPITA', 'École de premier plan en informatique et ingénierie, reconnue pour son expertise en IT, cybersécurité et intelligence artificielle.', 'https://www.epita.fr/', 22, 6, 'EPITA.png'),
(61, 'HEC Paris', 'École de commerce de renommée mondiale, très sélective, offrant une formation d\'excellence en management.', 'https://www.hec.edu/', 9, 7, 'HEC Paris.jpg'),
(62, 'INSEAD', 'École de commerce globale avec des campus internationaux, célèbre pour ses programmes MBA diversifiés.', 'https://www.insead.edu/fr', 10, 7, 'INSEAD.jpg'),
(63, 'ESCP Business School', 'Ancienne école de commerce avec un modèle multi-campus, réputée pour son orientation internationale.', 'https://escp.eu/fr', 1, 7, 'ESCP Business School.jpg'),
(64, 'ESSEC Business School', 'Grande école de commerce française, innovante, reconnue pour son esprit entrepreneurial et ses liens solides avec les entreprises.', 'https://www.essec.edu/fr/', 11, 7, 'ESSEC Business School.jpg'),
(65, 'EDHEC Business School', 'École de commerce reconnue pour ses programmes en finance, son excellence en recherche et son leadership responsable.', 'https://www.edhec.edu/fr', 12, 7, 'EDHEC Business School.jpg'),
(66, 'emlyon business school', 'École de commerce axée sur l\'innovation et l\'entrepreneuriat, avec des programmes en management et transformation digitale.', 'https://em-lyon.com/fr', 4, 7, 'emlyon business school.jpg'),
(67, 'EMLV', 'École de commerce du Pôle Léonard de Vinci, proposant des programmes avec une forte composante numérique et technologique.', 'https://www.emlv.fr/', 13, 7, 'EMLV.jpg'),
(68, 'INSEEC Business School', 'École de commerce privée offrant un large éventail de programmes en management, finance, marketing et communication.', 'https://www.inseec.com/', 1, 7, 'INSEEC Business School.jpg'),
(69, 'EDC Paris Business School', 'École de commerce spécialisée dans l\'entrepreneuriat, formant des leaders et innovateurs d\'entreprise.', 'https://www.edcparis.edu/', 13, 7, 'EDC Paris Business School.jpeg'),
(70, 'PSB Paris School of Business', 'École de commerce proposant des programmes internationaux, axés sur le développement professionnel et les perspectives mondiales.', 'https://www.psbedu.paris/', 1, 7, 'PSB Paris School of Business.jpg'),
(71, 'Université Claude Bernard Lyon 1', 'Grande université spécialisée en science, technologie et santé, offrant un large éventail de diplômes dans le domaine de la santé.', 'https://www.univ-lyon1.fr/', 4, 8, 'Université Claude Bernard Lyon 1.jpg'),
(72, 'Université Paris Cité', 'Université pluridisciplinaire offrant un large éventail de programmes juridiques, reconnue pour sa recherche et ses collaborations internationales.', 'https://u-paris.fr/', 1, 8, 'Université Paris Cité.jpg'),
(73, 'Université de Strasbourg', 'Université proposant des programmes de droit complets avec une forte orientation européenne et internationale.', 'https://www.unistra.fr/', 7, 8, 'Université de Strasbourg.jpg'),
(74, 'Université de Lille', 'Grande université avec de robustes facultés de santé, offrant des diplômes en médecine, pharmacie et sciences de la santé.', 'https://www.univ-lille.fr/', 12, 8, 'Université de Lille.jpg'),
(75, 'Université Aix-Marseille', 'Grande université pluridisciplinaire avec de vastes programmes de santé, incluant médecine, pharmacie et odontostomatologie.', 'https://www.univ-amu.fr/', 23, 8, 'Université Aix-Marseille.jpg'),
(76, 'Université de Caen Normandie', 'Université majeure avec de solides programmes de droit, particulièrement connue pour sa recherche en droit public et privé.', 'https://unicaen.fr', 25, 8, 'Université de Caen Normandie.jpg'),
(77, 'Mediplus', 'Établissement privé souvent spécialisé dans les cours préparatoires ou la formation complémentaire pour les professions de la santé.', 'https://mediplus.fr/', 1, 8, 'Mediplus.jpg'),
(78, 'Paracelse', 'Généralement un établissement privé offrant une formation spécialisée ou des cours préparatoires pour les domaines liés à la santé.', 'https://www.paracelse.fr/', 1, 8, 'Paracelse.jpg'),
(79, 'Université de Nantes', 'Université proposant divers programmes en économie et gestion, avec un lien fort avec les industries régionales.', 'https://www.univ-nantes.fr/', 3, 8, 'Université de Nantes.jpg'),
(80, 'Université de Limoges', 'L\'une des plus anciennes universités de France, offrant de vastes programmes de droit avec un riche héritage historique.', 'https://unilim.fr', 25, 8, 'Université de Limoges.jpeg'),
(81, 'Sciences Po Paris', 'Institution très prestigieuse réputée pour ses programmes en sciences politiques, relations internationales et affaires publiques.', 'https://www.sciencespo.fr/', 1, 9, 'Sciences Po Paris.jpg'),
(82, 'Sciences Po Bordeaux', 'IEP réputé, axé sur les études régionales, les relations internationales et les politiques publiques.', 'https://www.sciencespobordeaux.fr/', 16, 9, 'Sciences Po Bordeaux.jpg'),
(83, 'Sciences Po Lyon', 'Propose des programmes complets en sciences politiques, relations internationales et administration publique, avec un fort accent régional.', 'https://www.sciencespo-lyon.fr/', 4, 9, 'Sciences Po Lyon.jpg'),
(84, 'Sciences Po Aix', 'Connue pour son expertise en études méditerranéennes, relations internationales et politiques publiques au sein du réseau Sciences Po.', 'https://www.sciencespo-aix.fr/', 23, 9, 'Sciences Po Aix.jpg'),
(85, 'Sciences Po Lille', 'Propose de solides programmes en sciences politiques, journalisme et affaires européennes, avec un accent sur les questions internationales.', 'https://www.sciencespo-lille.eu/', 12, 9, 'Sciences Po Lille.jpg'),
(86, 'Sciences Po Rennes', 'Connue pour son approche multidisciplinaire des sciences politiques, avec des programmes en affaires européennes, politiques publiques et journalisme.', 'https://www.sciencespo-rennes.fr/', 17, 9, 'Sciences Po Rennes.jpg'),
(87, 'Sciences Po Strasbourg', 'Propose des programmes complets en sciences politiques avec un fort accent sur les études européennes et les relations internationales.', 'https://www.sciencespo-strasbourg.fr/', 7, 9, 'Sciences Po Strasbourg.jpg'),
(88, 'Sciences Po Toulouse', 'Connue pour son accent sur les politiques publiques, les relations internationales et la gouvernance territoriale, avec une forte composante de recherche.', 'https://www.sciencespo-toulouse.fr/', 6, 9, 'Sciences Po Toulouse.jpg'),
(89, 'Sciences Po Grenoble', 'Propose des programmes spécialisés en sciences politiques, relations internationales et études urbaines, avec un fort accent sur la recherche.', 'https://www.sciencespo-grenoble.fr/', 24, 9, 'Sciences Po Grenoble.jpg'),
(90, 'Sciences Po Saint-Germain-en-Laye', 'Nouvelle addition au réseau Sciences Po, axée sur les sciences politiques, les relations internationales et l\'administration publique.', 'https://www.sciencespo-saintgermainenlaye.fr/', 24, 9, 'Sciences Po Saint-Germain-en-Laye.jpeg'),
(91, 'INSEP', 'Institut National du Sport, de l\'Expertise et de la Performance, dédié à la formation sportive de haut niveau et à la recherche en sciences du sport.', 'https://www.insep.fr/', 1, 10, 'INSEP.jpg'),
(92, 'STAPS Université Lyon 1', 'Département STAPS de l\'Université Claude Bernard Lyon 1, offrant des programmes complets en sciences du sport, éducation et management.', 'https://www.univ-lyon1.fr/', 4, 10, 'STAPS Université Lyon 1.jpg'),
(93, 'STAPS Université Paris-Saclay', 'Propose un large éventail de programmes STAPS, combinant rigueur scientifique et applications pratiques dans le sport et les activités physiques.', 'https://www.universite-paris-saclay.fr/', 1, 10, 'STAPS Université Paris-Saclay.jpg'),
(94, 'STAPS Université Rennes 2', 'Département STAPS dynamique, couvrant divers aspects des sciences du sport, de l\'éducation physique et des activités physiques adaptées.', 'https://www.univ-rennes2.fr/', 17, 10, 'STAPS Université Rennes 2.jpg'),
(95, 'STAPS Université Bordeaux', 'Propose divers programmes STAPS axés sur l\'entraînement sportif, la santé et le management dans l\'industrie du sport.', 'https://www.u-bordeaux.fr/', 16, 10, 'STAPS Université Bordeaux.jpg'),
(96, 'STAPS Université Toulouse III', 'Département STAPS de l\'Université Toulouse III - Paul Sabatier, offrant de solides programmes en sciences du sport et carrières professionnelles.', 'https://www.univ-tlse3.fr/', 6, 10, 'STAPS Université Toulouse III.jpg'),
(97, 'STAPS Université Montpellier', 'Propose des programmes STAPS complets, incluant des spécialisations en activité physique, santé et gestion du sport.', 'https://www.umontpellier.fr/', 8, 10, 'STAPS Université Montpellier.jpg'),
(98, 'STAPS Université Nantes', 'Département STAPS offrant divers programmes axés sur l\'insertion professionnelle dans les secteurs du sport, de la santé et des loisirs.', 'https://www.univ-nantes.fr/', 3, 10, 'STAPS Université Nantes.jpeg'),
(99, 'STAPS Université Lille', 'Département STAPS reconnu pour ses vastes programmes, couvrant l\'éducation physique, l\'entraînement sportif et la gestion des organisations sportives.', 'https://www.univ-lille.fr/', 12, 10, 'STAPS Université Lille.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `indices`
--

CREATE TABLE `indices` (
  `id` int(11) NOT NULL,
  `libellé` varchar(255) NOT NULL,
  `etablissement_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `indices`
--

INSERT INTO `indices` (`id`, `libellé`, `etablissement_id`) VALUES
(1, '🏗 École d\'architecture du 19ème', 1),
(2, '🌆 Quartier en transformation', 1),
(3, '🎨 Très renommée', 1),
(4, '🚇 Près de La Villette', 1),
(5, '🏛 Rayonne sur Rhône-Alpes', 6),
(6, '🍷 Capitale gastronomique', 6),
(7, '⛰ Entre Alpes et Massif Central', 6),
(8, '🏗 Ville aux deux fleuves', 6),
(9, '👑 Reine des Business Schools', 11),
(10, '🌍 Top 5 mondial', 11),
(11, '💼 Diplômés au CAC 40', 11),
(12, '🏆 MBA le plus prestigieux', 11),
(13, '🌏 Business school internationale', 12),
(14, '🏰 Près du château royal', 12),
(15, '📈 MBA ultra-sélectif', 12),
(16, '🌍 Campus multiple', 12),
(17, '📰 Référence journalisme', 21),
(18, '🎓 Rattachée Sorbonne', 21),
(19, '📺 Diplômés TV', 21),
(20, '💎 Commune huppée', 21),
(21, '📢 Spécialisée com/RP', 22),
(22, '🎪 Événements spectaculaires', 22),
(23, '🌟 Futurs directeurs com', 22),
(24, '🏢 Partenariats agences', 22),
(25, '⚖ Surnommée l\'Assas', 31),
(26, '🏛 Héritière Sorbonne', 31),
(27, '👨‍⚖ Forme magistrature', 31),
(28, '📚 Excellence droit privé', 31),
(29, '⚔ Uniforme militaire', 51),
(30, '🎓 Surnommée l\'X', 51),
(31, '🔬 Recherche mondiale', 51),
(32, '🏛 Fondée en 1794', 51),
(33, '💻 Spécialisée informatique', 60),
(34, '🎮 Jeux vidéo', 60),
(35, '🤖 Pionnière IA', 60),
(36, '🚀 Start-ups tech', 60),
(37, '🏥 Fusion universités', 72),
(38, '🧬 Excellence médecine', 72),
(39, '🔬 Partenariats hôpitaux', 72),
(40, '📚 Traditions séculaires', 72),
(41, '🏛 \"Sciences Po\"', 81),
(42, '👨‍💼 Forme élites politiques', 81),
(43, '🌍 Rue Saint-Guillaume', 81),
(44, '🎓 Hauts postes État', 81),
(45, '🏅 Temple sport haut niveau', 91),
(46, '🥇 Champions olympiques', 91),
(47, '🏃 Institut national sport', 91),
(48, '🌳 Bois de Vincennes', 91),
(49, '🌆 Environnement dynamique', 2),
(50, '🍽 Nombreux restos autour', 2),
(51, '🎭 Activités culturelles', 2),
(52, '🏐 Vie associative riche', 2),
(53, '🧬 Partenariats de recherche', 3),
(54, '🌍 Ouverture internationale', 3),
(55, '🚀 Projets étudiants', 3),
(56, '💡 Pédagogie innovante', 3),
(57, '🎭 Activités culturelles', 4),
(58, '🏐 Vie associative riche', 4),
(59, '🍽 Nombreux restos autour', 4),
(60, '🌆 Environnement dynamique', 4),
(61, '🏗️ Ancienne école réhabilitée', 5),
(62, '🏙️ Cœur de ville', 5),
(63, '📖 Forte tradition académique', 5),
(64, '🎯 Objectifs d’excellence', 5),
(65, '🎓 Corps enseignant reconnu', 7),
(66, '🏙️ Quartier historique', 7),
(67, '🧱 Patrimoine architectural', 7),
(68, '🚇 Accès facile', 7),
(69, '📖 Forte tradition académique', 8),
(70, '🎯 Objectifs d’excellence', 8),
(71, '🏗️ Ancienne école réhabilitée', 8),
(72, '🏙️ Cœur de ville', 8),
(73, '🎯 Objectifs d’excellence', 9),
(74, '📖 Forte tradition académique', 9),
(75, '🏗️ Ancienne école réhabilitée', 9),
(76, '🏙️ Cœur de ville', 9),
(77, '🎭 Activités culturelles', 10),
(78, '🏐 Vie associative riche', 10),
(79, '🍽 Nombreux restos autour', 10),
(80, '🌆 Environnement dynamique', 10),
(81, '📈 Forte employabilité', 13),
(82, '💼 Réseau alumni actif', 13),
(83, '🚌 Bien desservie', 13),
(84, '🏫 Campus verdoyant', 13),
(85, '🏙️ Quartier historique', 14),
(86, '🎓 Corps enseignant reconnu', 14),
(87, '🚇 Accès facile', 14),
(88, '🧱 Patrimoine architectural', 14),
(89, '🎭 Activités culturelles', 15),
(90, '🏐 Vie associative riche', 15),
(91, '🌆 Environnement dynamique', 15),
(92, '🍽 Nombreux restos autour', 15),
(93, '📈 Forte employabilité', 16),
(94, '🏫 Campus verdoyant', 16),
(95, '💼 Réseau alumni actif', 16),
(96, '🚌 Bien desservie', 16),
(97, '💡 Pédagogie innovante', 17),
(98, '🚀 Projets étudiants', 17),
(99, '🌍 Ouverture internationale', 17),
(100, '🧬 Partenariats de recherche', 17),
(101, '🧬 Partenariats de recherche', 18),
(102, '🚀 Projets étudiants', 18),
(103, '🌍 Ouverture internationale', 18),
(104, '💡 Pédagogie innovante', 18),
(105, '💡 Pédagogie innovante', 19),
(106, '🧬 Partenariats de recherche', 19),
(107, '🌍 Ouverture internationale', 19),
(108, '🚀 Projets étudiants', 19),
(109, '🌆 Environnement dynamique', 20),
(110, '🏐 Vie associative riche', 20),
(111, '🍽 Nombreux restos autour', 20),
(112, '🎭 Activités culturelles', 20),
(113, '💡 Pédagogie innovante', 23),
(114, '🌍 Ouverture internationale', 23),
(115, '🧬 Partenariats de recherche', 23),
(116, '🚀 Projets étudiants', 23),
(117, '📈 Forte employabilité', 24),
(118, '🏫 Campus verdoyant', 24),
(119, '💼 Réseau alumni actif', 24),
(120, '🚌 Bien desservie', 24),
(121, '🎨 Vie culturelle riche', 25),
(122, '🏛 Ancrée dans la tradition', 25),
(123, '📚 Excellence académique', 25),
(124, '🏞️ Vue panoramique', 25),
(125, '🏙️ Quartier historique', 26),
(126, '🎓 Corps enseignant reconnu', 26),
(127, '🧱 Patrimoine architectural', 26),
(128, '🚇 Accès facile', 26),
(129, '🧱 Patrimoine architectural', 27),
(130, '🚇 Accès facile', 27),
(131, '🎓 Corps enseignant reconnu', 27),
(132, '🏙️ Quartier historique', 27),
(133, '🎨 Vie culturelle riche', 28),
(134, '🏛 Ancrée dans la tradition', 28),
(135, '📚 Excellence académique', 28),
(136, '🏞️ Vue panoramique', 28),
(137, '🚌 Bien desservie', 29),
(138, '🏫 Campus verdoyant', 29),
(139, '📈 Forte employabilité', 29),
(140, '💼 Réseau alumni actif', 29),
(141, '🎯 Objectifs d’excellence', 30),
(142, '🏗️ Ancienne école réhabilitée', 30),
(143, '🏙️ Cœur de ville', 30),
(144, '📖 Forte tradition académique', 30),
(145, '📚 Excellence académique', 32),
(146, '🏞️ Vue panoramique', 32),
(147, '🎨 Vie culturelle riche', 32),
(148, '🏛 Ancrée dans la tradition', 32),
(149, '🎨 Vie culturelle riche', 33),
(150, '🏞️ Vue panoramique', 33),
(151, '📚 Excellence académique', 33),
(152, '🏛 Ancrée dans la tradition', 33),
(153, '💡 Pédagogie innovante', 34),
(154, '🚀 Projets étudiants', 34),
(155, '🌍 Ouverture internationale', 34),
(156, '🧬 Partenariats de recherche', 34),
(157, '💼 Réseau alumni actif', 35),
(158, '📈 Forte employabilité', 35),
(159, '🚌 Bien desservie', 35),
(160, '🏫 Campus verdoyant', 35),
(161, '📖 Forte tradition académique', 36),
(162, '🏗️ Ancienne école réhabilitée', 36),
(163, '🏙️ Cœur de ville', 36),
(164, '🎯 Objectifs d’excellence', 36),
(165, '🏙️ Cœur de ville', 37),
(166, '🎯 Objectifs d’excellence', 37),
(167, '📖 Forte tradition académique', 37),
(168, '🏗️ Ancienne école réhabilitée', 37),
(169, '🚌 Bien desservie', 38),
(170, '💼 Réseau alumni actif', 38),
(171, '📈 Forte employabilité', 38),
(172, '🏫 Campus verdoyant', 38),
(173, '🌆 Environnement dynamique', 39),
(174, '🏐 Vie associative riche', 39),
(175, '🎭 Activités culturelles', 39),
(176, '🍽 Nombreux restos autour', 39),
(177, '🧱 Patrimoine architectural', 40),
(178, '🏙️ Quartier historique', 40),
(179, '🎓 Corps enseignant reconnu', 40),
(180, '🚇 Accès facile', 40),
(181, '🏗️ Ancienne école réhabilitée', 41),
(182, '🏙️ Cœur de ville', 41),
(183, '📖 Forte tradition académique', 41),
(184, '🎯 Objectifs d’excellence', 41),
(185, '🎨 Vie culturelle riche', 42),
(186, '🏞️ Vue panoramique', 42),
(187, '📚 Excellence académique', 42),
(188, '🏛 Ancrée dans la tradition', 42),
(189, '💡 Pédagogie innovante', 43),
(190, '🌍 Ouverture internationale', 43),
(191, '🚀 Projets étudiants', 43),
(192, '🧬 Partenariats de recherche', 43),
(193, '🚇 Accès facile', 44),
(194, '🏙️ Quartier historique', 44),
(195, '🧱 Patrimoine architectural', 44),
(196, '🎓 Corps enseignant reconnu', 44),
(197, '💼 Réseau alumni actif', 45),
(198, '🚌 Bien desservie', 45),
(199, '📈 Forte employabilité', 45),
(200, '🏫 Campus verdoyant', 45),
(201, '🏫 Campus verdoyant', 46),
(202, '🚌 Bien desservie', 46),
(203, '💼 Réseau alumni actif', 46),
(204, '📈 Forte employabilité', 46),
(205, '💼 Réseau alumni actif', 47),
(206, '📈 Forte employabilité', 47),
(207, '🚌 Bien desservie', 47),
(208, '🏫 Campus verdoyant', 47),
(209, '🎭 Activités culturelles', 48),
(210, '🍽 Nombreux restos autour', 48),
(211, '🌆 Environnement dynamique', 48),
(212, '🏐 Vie associative riche', 48),
(213, '🌆 Environnement dynamique', 49),
(214, '🎭 Activités culturelles', 49),
(215, '🍽 Nombreux restos autour', 49),
(216, '🏐 Vie associative riche', 49),
(217, '🚇 Accès facile', 50),
(218, '🎓 Corps enseignant reconnu', 50),
(219, '🧱 Patrimoine architectural', 50),
(220, '🏙️ Quartier historique', 50),
(221, '📚 Excellence académique', 52),
(222, '🏛 Ancrée dans la tradition', 52),
(223, '🎨 Vie culturelle riche', 52),
(224, '🏞️ Vue panoramique', 52),
(225, '🏙️ Quartier historique', 53),
(226, '🚇 Accès facile', 53),
(227, '🧱 Patrimoine architectural', 53),
(228, '🎓 Corps enseignant reconnu', 53),
(229, '🏐 Vie associative riche', 54),
(230, '🎭 Activités culturelles', 54),
(231, '🌆 Environnement dynamique', 54),
(232, '🍽 Nombreux restos autour', 54),
(233, '📈 Forte employabilité', 55),
(234, '🚌 Bien desservie', 55),
(235, '🏫 Campus verdoyant', 55),
(236, '💼 Réseau alumni actif', 55),
(237, '🌍 Ouverture internationale', 56),
(238, '💡 Pédagogie innovante', 56),
(239, '🧬 Partenariats de recherche', 56),
(240, '🚀 Projets étudiants', 56),
(241, '🏐 Vie associative riche', 57),
(242, '🌆 Environnement dynamique', 57),
(243, '🎭 Activités culturelles', 57),
(244, '🍽 Nombreux restos autour', 57),
(245, '🎭 Activités culturelles', 58),
(246, '🏐 Vie associative riche', 58),
(247, '🌆 Environnement dynamique', 58),
(248, '🍽 Nombreux restos autour', 58),
(249, '🚀 Projets étudiants', 59),
(250, '🧬 Partenariats de recherche', 59),
(251, '🌍 Ouverture internationale', 59),
(252, '💡 Pédagogie innovante', 59),
(253, '🌆 Environnement dynamique', 61),
(254, '🎭 Activités culturelles', 61),
(255, '🏐 Vie associative riche', 61),
(256, '🍽 Nombreux restos autour', 61),
(257, '📚 Excellence académique', 62),
(258, '🏞️ Vue panoramique', 62),
(259, '🎨 Vie culturelle riche', 62),
(260, '🏛 Ancrée dans la tradition', 62),
(261, '🎭 Activités culturelles', 63),
(262, '🏐 Vie associative riche', 63),
(263, '🍽 Nombreux restos autour', 63),
(264, '🌆 Environnement dynamique', 63),
(265, '🎭 Activités culturelles', 64),
(266, '🏐 Vie associative riche', 64),
(267, '🌆 Environnement dynamique', 64),
(268, '🍽 Nombreux restos autour', 64),
(269, '🍽 Nombreux restos autour', 65),
(270, '🎭 Activités culturelles', 65),
(271, '🏐 Vie associative riche', 65),
(272, '🌆 Environnement dynamique', 65),
(273, '🎓 Corps enseignant reconnu', 66),
(274, '🏙️ Quartier historique', 66),
(275, '🚇 Accès facile', 66),
(276, '🧱 Patrimoine architectural', 66),
(277, '🏫 Campus verdoyant', 67),
(278, '💼 Réseau alumni actif', 67),
(279, '🚌 Bien desservie', 67),
(280, '📈 Forte employabilité', 67),
(281, '📖 Forte tradition académique', 68),
(282, '🎯 Objectifs d’excellence', 68),
(283, '🏙️ Cœur de ville', 68),
(284, '🏗️ Ancienne école réhabilitée', 68),
(285, '🎭 Activités culturelles', 69),
(286, '🍽 Nombreux restos autour', 69),
(287, '🌆 Environnement dynamique', 69),
(288, '🏐 Vie associative riche', 69),
(289, '🚇 Accès facile', 70),
(290, '🧱 Patrimoine architectural', 70),
(291, '🎓 Corps enseignant reconnu', 70),
(292, '🏙️ Quartier historique', 70),
(293, '🎭 Activités culturelles', 71),
(294, '🌆 Environnement dynamique', 71),
(295, '🏐 Vie associative riche', 71),
(296, '🍽 Nombreux restos autour', 71),
(297, '🌍 Ouverture internationale', 73),
(298, '🧬 Partenariats de recherche', 73),
(299, '🚀 Projets étudiants', 73),
(300, '💡 Pédagogie innovante', 73),
(301, '🌆 Environnement dynamique', 74),
(302, '🍽 Nombreux restos autour', 74),
(303, '🏐 Vie associative riche', 74),
(304, '🎭 Activités culturelles', 74),
(305, '🧬 Partenariats de recherche', 75),
(306, '💡 Pédagogie innovante', 75),
(307, '🚀 Projets étudiants', 75),
(308, '🌍 Ouverture internationale', 75),
(309, '🌍 Ouverture internationale', 76),
(310, '💡 Pédagogie innovante', 76),
(311, '🚀 Projets étudiants', 76),
(312, '🧬 Partenariats de recherche', 76),
(313, '🧱 Patrimoine architectural', 77),
(314, '🚇 Accès facile', 77),
(315, '🎓 Corps enseignant reconnu', 77),
(316, '🏙️ Quartier historique', 77),
(317, '📚 Excellence académique', 78),
(318, '🏛 Ancrée dans la tradition', 78),
(319, '🏞️ Vue panoramique', 78),
(320, '🎨 Vie culturelle riche', 78),
(321, '🏛 Ancrée dans la tradition', 79),
(322, '🏞️ Vue panoramique', 79),
(323, '🎨 Vie culturelle riche', 79),
(324, '📚 Excellence académique', 79),
(325, '🏐 Vie associative riche', 80),
(326, '🎭 Activités culturelles', 80),
(327, '🍽 Nombreux restos autour', 80),
(328, '🌆 Environnement dynamique', 80),
(329, '🏙️ Quartier historique', 82),
(330, '🚇 Accès facile', 82),
(331, '🧱 Patrimoine architectural', 82),
(332, '🎓 Corps enseignant reconnu', 82),
(333, '🧬 Partenariats de recherche', 83),
(334, '🚀 Projets étudiants', 83),
(335, '🌍 Ouverture internationale', 83),
(336, '💡 Pédagogie innovante', 83),
(337, '🧬 Partenariats de recherche', 84),
(338, '🌍 Ouverture internationale', 84),
(339, '🚀 Projets étudiants', 84),
(340, '💡 Pédagogie innovante', 84),
(341, '🌆 Environnement dynamique', 85),
(342, '🏐 Vie associative riche', 85),
(343, '🎭 Activités culturelles', 85),
(344, '🍽 Nombreux restos autour', 85),
(345, '🧱 Patrimoine architectural', 86),
(346, '🎓 Corps enseignant reconnu', 86),
(347, '🚇 Accès facile', 86),
(348, '🏙️ Quartier historique', 86),
(349, '🧱 Patrimoine architectural', 87),
(350, '🏙️ Quartier historique', 87),
(351, '🎓 Corps enseignant reconnu', 87),
(352, '🚇 Accès facile', 87),
(353, '🏫 Campus verdoyant', 88),
(354, '💼 Réseau alumni actif', 88),
(355, '🚌 Bien desservie', 88),
(356, '📈 Forte employabilité', 88),
(357, '📖 Forte tradition académique', 89),
(358, '🎯 Objectifs d’excellence', 89),
(359, '🏗️ Ancienne école réhabilitée', 89),
(360, '🏙️ Cœur de ville', 89),
(361, '📚 Excellence académique', 90),
(362, '🏞️ Vue panoramique', 90),
(363, '🎨 Vie culturelle riche', 90),
(364, '🏛 Ancrée dans la tradition', 90),
(365, '🎨 Vie culturelle riche', 92),
(366, '🏛 Ancrée dans la tradition', 92),
(367, '📚 Excellence académique', 92),
(368, '🏞️ Vue panoramique', 92),
(369, '🧱 Patrimoine architectural', 93),
(370, '🏙️ Quartier historique', 93),
(371, '🎓 Corps enseignant reconnu', 93),
(372, '🚇 Accès facile', 93),
(373, '🧱 Patrimoine architectural', 94),
(374, '🚇 Accès facile', 94),
(375, '🏙️ Quartier historique', 94),
(376, '🎓 Corps enseignant reconnu', 94),
(377, '🚇 Accès facile', 95),
(378, '🏙️ Quartier historique', 95),
(379, '🎓 Corps enseignant reconnu', 95),
(380, '🧱 Patrimoine architectural', 95),
(381, '🌆 Environnement dynamique', 96),
(382, '🍽 Nombreux restos autour', 96),
(383, '🏐 Vie associative riche', 96),
(384, '🎭 Activités culturelles', 96),
(385, '🏛 Ancrée dans la tradition', 97),
(386, '📚 Excellence académique', 97),
(387, '🎨 Vie culturelle riche', 97),
(388, '🏞️ Vue panoramique', 97),
(389, '🌍 Ouverture internationale', 98),
(390, '🚀 Projets étudiants', 98),
(391, '💡 Pédagogie innovante', 98),
(392, '🧬 Partenariats de recherche', 98),
(393, '🎨 Vie culturelle riche', 99),
(394, '📚 Excellence académique', 99),
(395, '🏛 Ancrée dans la tradition', 99),
(396, '🏞️ Vue panoramique', 99),
(397, '🎯 Objectifs d’excellence', NULL),
(398, '🏗️ Ancienne école réhabilitée', NULL),
(399, '📖 Forte tradition académique', NULL),
(400, '🏙️ Cœur de ville', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_infos`
--

CREATE TABLE `user_infos` (
  `id` int(11) NOT NULL,
  `Username` varchar(200) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `Permanent_token` varchar(255) DEFAULT NULL,
  `Admin` int(1) DEFAULT 0,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_infos`
--

INSERT INTO `user_infos` (`id`, `Username`, `Email`, `password`, `token`, `Permanent_token`, `Admin`, `Created_at`, `Updated_at`) VALUES
(9, 'NathanGoat', 'nathansuprm@gmail.com', '$2y$10$JTjtGpjvGIuVQyeGqMW8de1cgGCwK7qB1SwnWSEK5TeZbwQHEa16W', NULL, 'b9f1fdb4347e8623faeceea9d9c6870e8c92132d91485cb951c68ffc8c30ea3c', 1, '2025-06-25 20:36:30', '2025-06-26 01:37:04');

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

CREATE TABLE `villes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`id`, `nom`) VALUES
(23, 'Aix-en-Provence'),
(16, 'Bordeaux'),
(11, 'Cergy'),
(15, 'Créteil'),
(10, 'Fontainebleau'),
(20, 'Gif-sur-Yvette'),
(25, 'Grenoble'),
(9, 'Jouy-en-Josas'),
(13, 'La Défense'),
(22, 'Le Kremlin-Bicêtre'),
(12, 'Lille'),
(4, 'Lyon'),
(5, 'Marseille'),
(8, 'Montpellier'),
(18, 'Nancy'),
(3, 'Nantes'),
(14, 'Neuilly-sur-Seine'),
(19, 'Palaiseau'),
(1, 'Paris'),
(17, 'Rennes'),
(24, 'Saint-Germain-en-Laye'),
(7, 'Strasbourg'),
(6, 'Toulouse'),
(2, 'Versailles'),
(21, 'Villeurbanne');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `domaines`
--
ALTER TABLE `domaines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `etablissements`
--
ALTER TABLE `etablissements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etablissements_ibfk_1` (`ville_id`),
  ADD KEY `etablissements_ibfk_2` (`domaine_id`);

--
-- Index pour la table `indices`
--
ALTER TABLE `indices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indices_ibfk_1` (`etablissement_id`);

--
-- Index pour la table `user_infos`
--
ALTER TABLE `user_infos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `villes`
--
ALTER TABLE `villes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `domaines`
--
ALTER TABLE `domaines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `etablissements`
--
ALTER TABLE `etablissements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT pour la table `indices`
--
ALTER TABLE `indices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT pour la table `user_infos`
--
ALTER TABLE `user_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `villes`
--
ALTER TABLE `villes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etablissements`
--
ALTER TABLE `etablissements`
  ADD CONSTRAINT `etablissements_ibfk_1` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `etablissements_ibfk_2` FOREIGN KEY (`domaine_id`) REFERENCES `domaines` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `indices`
--
ALTER TABLE `indices`
  ADD CONSTRAINT `indices_ibfk_1` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
