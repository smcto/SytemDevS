-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 27 juil. 2018 à 08:51
-- Version du serveur :  10.1.12-MariaDB-1~jessie
-- Version de PHP :  5.6.36-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `piktoo_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `countrys`
--

CREATE TABLE `countrys` (
  `id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  `name_fr` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `countrys`
--

INSERT INTO `countrys` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`, `name_fr`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93, 'Afghanistan'),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355, 'Albanie'),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213, 'Algérie'),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684, 'Samoa Américaines'),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376, 'Andorre'),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244, 'Angola'),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264, 'Anguilla'),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', 'ATA', 10, 0, 'Antarctique'),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268, 'Antigua-et-Barbuda'),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54, 'Argentine'),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374, 'Arménie'),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297, 'Aruba'),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61, 'Australie'),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43, 'Autriche'),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994, 'Azerbaïdjan'),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242, 'Bahamas'),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973, 'Bahreïn'),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880, 'Bangladesh'),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246, 'Barbade'),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375, 'Bélarus'),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32, 'Belgique'),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501, 'Belize'),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229, 'Bénin'),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441, 'Bermudes'),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975, 'Bhoutan'),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591, 'Bolivie'),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387, 'Bosnie-Herzégovine'),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267, 'Botswana'),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', 'BVT', 74, 0, 'Île Bouvet'),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55, 'Brésil'),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', 'IOT', 86, 246, 'Territoire Britannique de l\'\'Océan Indien'),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673, 'Brunéi Darussalam'),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359, 'Bulgarie'),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226, 'Burkina Faso'),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257, 'Burundi'),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855, 'Cambodge'),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237, 'Cameroun'),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1, 'Canada'),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238, 'Cap-vert'),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345, 'Îles Caïmanes'),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236, 'République Centrafricaine'),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235, 'Tchad'),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56, 'Chili'),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86, 'Chine'),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', 'CXR', 162, 61, 'Île Christmas'),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', 'CCK', 166, 672, 'Îles Cocos (Keeling)'),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57, 'Colombie'),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269, 'Comores'),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242, 'République du Congo'),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242, 'République Démocratique du Congo'),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682, 'Îles Cook'),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506, 'Costa Rica'),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225, 'Côte d\'Ivoire'),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385, 'Croatie'),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53, 'Cuba'),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357, 'Chypre'),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420, 'République Tchèque'),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45, 'Danemark'),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253, 'Djibouti'),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767, 'Dominique'),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809, 'République Dominicaine'),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593, 'Équateur'),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20, 'Égypte'),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503, 'El Salvador'),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240, 'Guinée Équatoriale'),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291, 'Érythrée'),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372, 'Estonie'),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251, 'Éthiopie'),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500, 'Îles (malvinas) Falkland'),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298, 'Îles Féroé'),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679, 'Fidji'),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358, 'Finlande'),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33, 'France'),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594, 'Guyane Française'),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689, 'Polynésie Française'),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', 'ATF', 260, 0, 'Terres Australes Françaises'),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241, 'Gabon'),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220, 'Gambie'),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995, 'Géorgie'),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49, 'Allemagne'),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233, 'Ghana'),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350, 'Gibraltar'),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30, 'Grèce'),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299, 'Groenland'),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473, 'Grenade'),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590, 'Guadeloupe'),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671, 'Guam'),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502, 'Guatemala'),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224, 'Guinée'),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245, 'Guinée-Bissau'),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592, 'Guyana'),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509, 'Haïti'),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', 'HMD', 334, 0, 'Îles Heard et Mcdonald'),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39, 'Saint-Siège (état de la Cité du Vatican)'),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504, 'Honduras'),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852, 'Hong-Kong'),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36, 'Hongrie'),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354, 'Islande'),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91, 'Inde'),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62, 'Indonésie'),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98, 'République Islamique d\'Iran'),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964, 'Iraq'),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353, 'Irlande'),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972, 'Israël'),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39, 'Italie'),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876, 'Jamaïque'),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81, 'Japon'),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962, 'Jordanie'),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7, 'Kazakhstan'),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254, 'Kenya'),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686, 'Kiribati'),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850, 'République Populaire Démocratique de Corée'),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82, 'République de Corée'),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965, 'Koweït'),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996, 'Kirghizistan'),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856, 'République Démocratique Populaire Lao'),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371, 'Lettonie'),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961, 'Liban'),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266, 'Lesotho'),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231, 'Libéria'),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218, 'Jamahiriya Arabe Libyenne'),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423, 'Liechtenstein'),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370, 'Lituanie'),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352, 'Luxembourg'),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853, 'Macao'),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389, 'L\'ex-République Yougoslave de Macédoine'),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261, 'Madagascar'),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265, 'Malawi'),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60, 'Malaisie'),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960, 'Maldives'),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223, 'Mali'),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356, 'Malte'),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692, 'Îles Marshall'),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596, 'Martinique'),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222, 'Mauritanie'),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230, 'Maurice'),
(137, 'YT', 'MAYOTTE', 'Mayotte', 'MYT', 175, 269, 'Mayotte'),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52, 'Mexique'),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691, 'États Fédérés de Micronésie'),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373, 'République de Moldova'),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377, 'Monaco'),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976, 'Mongolie'),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664, 'Montserrat'),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212, 'Maroc'),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258, 'Mozambique'),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95, 'Myanmar'),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264, 'Namibie'),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674, 'Nauru'),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977, 'Népal'),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31, 'Pays-Bas'),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599, 'Antilles Néerlandaises'),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687, 'Nouvelle-Calédonie'),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64, 'Nouvelle-Zélande'),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505, 'Nicaragua'),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227, 'Niger'),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234, 'Nigéria'),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683, 'Niué'),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672, 'Île Norfolk'),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670, 'Îles Mariannes du Nord'),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47, 'Norvège'),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968, 'Oman'),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92, 'Pakistan'),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680, 'Palaos'),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', 'PSE', 275, 970, 'Territoire Palestinien Occupé'),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507, 'Panama'),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675, 'Papouasie-Nouvelle-Guinée'),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595, 'Paraguay'),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51, 'Pérou'),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63, 'Philippines'),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0, 'Pitcairn'),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48, 'Pologne'),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351, 'Portugal'),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787, 'Porto Rico'),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974, 'Qatar'),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262, 'Réunion'),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40, 'Romania'),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70, 'Fédération de Russie'),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250, 'Rwanda'),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290, 'Sainte-Hélène'),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869, 'Saint-Kitts-et-Nevis'),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758, 'Sainte-Lucie'),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508, 'Saint-Pierre-et-Miquelon'),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784, 'Saint-Vincent-et-les Grenadines'),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684, 'Samoa'),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378, 'Saint-Marin'),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239, 'Sao Tomé-et-Principe'),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966, 'Arabie Saoudite'),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221, 'Sénégal'),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381, ''),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248, 'Seychelles'),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232, 'Sierra Leone'),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65, 'Singapour'),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421, 'Slovaquie'),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386, 'Slovénie'),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677, 'Îles Salomon'),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252, 'Somalie'),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27, 'Afrique du Sud'),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0, ''),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34, 'Espagne'),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94, 'Sri Lanka'),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249, 'Soudan'),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597, 'Suriname'),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47, 'Svalbard etÎle Jan Mayen'),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268, 'Swaziland'),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46, 'Suède'),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41, 'Suisse'),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963, 'République Arabe Syrienne'),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886, 'Taïwan'),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992, 'Tadjikistan'),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255, 'République-Unie de Tanzanie'),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66, 'Thaïlande'),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670, ''),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228, 'Togo'),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690, 'Tokelau'),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676, 'Tonga'),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868, 'Trinité-et-Tobago'),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216, 'Tunisie'),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90, 'Turquie'),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370, 'Turkménistan'),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649, 'Îles Turks et Caïques'),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688, 'Tuvalu'),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256, 'Ouganda'),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380, 'Ukraine'),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971, 'Émirats Arabes Unis'),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44, 'Royaume-Uni'),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1, 'États-Unis'),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1, ''),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598, 'Uruguay'),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998, 'Ouzbékistan'),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678, 'Vanuatu'),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58, 'Venezuela'),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84, 'Viet Nam'),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284, 'Îles Vierges Britanniques'),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340, 'Îles Vierges des États-Unis'),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681, 'Wallis et Futuna'),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212, 'Sahara Occidental'),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967, 'Yémen'),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260, 'Zambie'),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263, 'Zimbabwe');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `countrys`
--
ALTER TABLE `countrys`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `countrys`
--
ALTER TABLE `countrys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
