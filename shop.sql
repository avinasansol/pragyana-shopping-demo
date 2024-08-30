-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2012 at 03:44 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `name` varchar(70) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `name`) VALUES
('avin.asansol@gmail.com', 'avinpass', 'Avinash Kumar Jha');

-- --------------------------------------------------------

--
-- Table structure for table `cart_nynpt@gmail.com`
--

CREATE TABLE IF NOT EXISTS `cart_nynpt@gmail.com` (
  `product` varchar(15) NOT NULL,
  `quantity` int(15) NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  PRIMARY KEY (`product`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart_nynpt@gmail.com`
--

INSERT INTO `cart_nynpt@gmail.com` (`product`, `quantity`, `date`) VALUES
('JHT74JK7J4FGYJK', 1, '2012-08-09');

-- --------------------------------------------------------

--
-- Table structure for table `cart_ramanuj@gmail.com`
--

CREATE TABLE IF NOT EXISTS `cart_ramanuj@gmail.com` (
  `product` varchar(15) NOT NULL,
  `quantity` int(15) NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  PRIMARY KEY (`product`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(5) NOT NULL AUTO_INCREMENT,
  `iso2` char(2) DEFAULT NULL,
  `short_name` varchar(80) NOT NULL DEFAULT '',
  `long_name` varchar(80) NOT NULL DEFAULT '',
  `iso3` char(3) DEFAULT NULL,
  `zone` int(3) NOT NULL DEFAULT '0',
  `currency` varchar(5) NOT NULL DEFAULT 'INR',
  `numcode` varchar(6) DEFAULT NULL,
  `un_member` varchar(12) DEFAULT NULL,
  `calling_code` varchar(8) DEFAULT NULL,
  `cctld` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `iso2`, `short_name`, `long_name`, `iso3`, `zone`, `currency`, `numcode`, `un_member`, `calling_code`, `cctld`) VALUES
(1, 'AF', 'Afghanistan', 'Islamic Republic of Afghanistan', 'AFG', 2, 'INR', '004', 'yes', '93', '.af'),
(2, 'AX', 'Aland Islands', '&Aring;land Islands', 'ALA', 1, 'INR', '248', 'no', '358', '.ax'),
(3, 'AL', 'Albania', 'Republic of Albania', 'ALB', 2, 'EURO', '008', 'yes', '355', '.al'),
(4, 'DZ', 'Algeria', 'People''s Democratic Republic of Algeria', 'DZA', 4, 'INR', '012', 'yes', '213', '.dz'),
(5, 'AS', 'American Samoa', 'American Samoa', 'ASM', 0, 'INR', '016', 'no', '1+684', '.as'),
(6, 'AD', 'Andorra', 'Principality of Andorra', 'AND', 5, 'INR', '020', 'yes', '376', '.ad'),
(7, 'AO', 'Angola', 'Republic of Angola', 'AGO', 0, 'INR', '024', 'yes', '244', '.ao'),
(8, 'AI', 'Anguilla', 'Anguilla', 'AIA', 1, 'INR', '660', 'no', '1+264', '.ai'),
(9, 'AQ', 'Antarctica', 'Antarctica', 'ATA', 3, 'INR', '010', 'no', '672', '.aq'),
(10, 'AG', 'Antigua and Barbuda', 'Antigua and Barbuda', 'ATG', 5, 'INR', '028', 'yes', '1+268', '.ag'),
(11, 'AR', 'Argentina', 'Argentine Republic', 'ARG', 4, 'INR', '032', 'yes', '54', '.ar'),
(12, 'AM', 'Armenia', 'Republic of Armenia', 'ARM', 0, 'INR', '051', 'yes', '374', '.am'),
(13, 'AW', 'Aruba', 'Aruba', 'ABW', 3, 'INR', '533', 'no', '297', '.aw'),
(14, 'AU', 'Australia', 'Commonwealth of Australia', 'AUS', 4, 'AUD', '036', 'yes', '61', '.au'),
(15, 'AT', 'Austria', 'Republic of Austria', 'AUT', 5, 'EURO', '040', 'yes', '43', '.at'),
(16, 'AZ', 'Azerbaijan', 'Republic of Azerbaijan', 'AZE', 4, 'INR', '031', 'yes', '994', '.az'),
(17, 'BS', 'Bahamas', 'Commonwealth of The Bahamas', 'BHS', 3, 'INR', '044', 'yes', '1+242', '.bs'),
(18, 'BH', 'Bahrain', 'Kingdom of Bahrain', 'BHR', 0, 'INR', '048', 'yes', '973', '.bh'),
(19, 'BD', 'Bangladesh', 'People''s Republic of Bangladesh', 'BGD', 5, 'INR', '050', 'yes', '880', '.bd'),
(20, 'BB', 'Barbados', 'Barbados', 'BRB', 0, 'INR', '052', 'yes', '1+246', '.bb'),
(21, 'BY', 'Belarus', 'Republic of Belarus', 'BLR', 5, 'INR', '112', 'yes', '375', '.by'),
(22, 'BE', 'Belgium', 'Kingdom of Belgium', 'BEL', 0, 'INR', '056', 'yes', '32', '.be'),
(23, 'BZ', 'Belize', 'Belize', 'BLZ', 4, 'INR', '084', 'yes', '501', '.bz'),
(24, 'BJ', 'Benin', 'Republic of Benin', 'BEN', 5, 'INR', '204', 'yes', '229', '.bj'),
(25, 'BM', 'Bermuda', 'Bermuda Islands', 'BMU', 5, 'INR', '060', 'no', '1+441', '.bm'),
(26, 'BT', 'Bhutan', 'Kingdom of Bhutan', 'BTN', 4, 'INR', '064', 'yes', '975', '.bt'),
(27, 'BO', 'Bolivia', 'Plurinational State of Bolivia', 'BOL', 0, 'INR', '068', 'yes', '591', '.bo'),
(28, 'BQ', 'Bonaire Sint Eustatius and Saba', 'Bonaire, Sint Eustatius and Saba', 'BES', 5, 'INR', '535', 'no', '599', '.bq'),
(29, 'BA', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'BIH', 0, 'INR', '070', 'yes', '387', '.ba'),
(30, 'BW', 'Botswana', 'Republic of Botswana', 'BWA', 1, 'INR', '072', 'yes', '267', '.bw'),
(31, 'BV', 'Bouvet Island', 'Bouvet Island', 'BVT', 0, 'INR', '074', 'no', 'NONE', '.bv'),
(32, 'BR', 'Brazil', 'Federative Republic of Brazil', 'BRA', 5, 'INR', '076', 'yes', '55', '.br'),
(33, 'IO', 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'IOT', 4, 'INR', '086', 'no', '246', '.io'),
(34, 'BN', 'Brunei', 'Brunei Darussalam', 'BRN', 0, 'INR', '096', 'yes', '673', '.bn'),
(35, 'BG', 'Bulgaria', 'Republic of Bulgaria', 'BGR', 0, 'INR', '100', 'yes', '359', '.bg'),
(36, 'BF', 'Burkina Faso', 'Burkina Faso', 'BFA', 0, 'INR', '854', 'yes', '226', '.bf'),
(37, 'BI', 'Burundi', 'Republic of Burundi', 'BDI', 5, 'INR', '108', 'yes', '257', '.bi'),
(38, 'KH', 'Cambodia', 'Kingdom of Cambodia', 'KHM', 0, 'INR', '116', 'yes', '855', '.kh'),
(39, 'CM', 'Cameroon', 'Republic of Cameroon', 'CMR', 0, 'INR', '120', 'yes', '237', '.cm'),
(40, 'CA', 'Canada', 'Canada', 'CAN', 5, 'INR', '124', 'yes', '1', '.ca'),
(41, 'CV', 'Cape Verde', 'Republic of Cape Verde', 'CPV', 3, 'INR', '132', 'yes', '238', '.cv'),
(42, 'KY', 'Cayman Islands', 'The Cayman Islands', 'CYM', 0, 'INR', '136', 'no', '1+345', '.ky'),
(43, 'CF', 'Central African Republic', 'Central African Republic', 'CAF', 0, 'INR', '140', 'yes', '236', '.cf'),
(44, 'TD', 'Chad', 'Republic of Chad', 'TCD', 0, 'INR', '148', 'yes', '235', '.td'),
(45, 'CL', 'Chile', 'Republic of Chile', 'CHL', 1, 'INR', '152', 'yes', '56', '.cl'),
(46, 'CN', 'China', 'People''s Republic of China', 'CHN', 0, 'INR', '156', 'yes', '86', '.cn'),
(47, 'CX', 'Christmas Island', 'Christmas Island', 'CXR', 0, 'INR', '162', 'no', '61', '.cx'),
(48, 'CC', 'Cocos (Keeling) Islands', 'Cocos (Keeling) Islands', 'CCK', 0, 'INR', '166', 'no', '61', '.cc'),
(49, 'CO', 'Colombia', 'Republic of Colombia', 'COL', 0, 'USD', '170', 'yes', '57', '.co'),
(50, 'KM', 'Comoros', 'Union of the Comoros', 'COM', 0, 'INR', '174', 'yes', '269', '.km'),
(51, 'CG', 'Congo', 'Republic of the Congo', 'COG', 0, 'INR', '178', 'yes', '242', '.cg'),
(52, 'CK', 'Cook Islands', 'Cook Islands', 'COK', 0, 'INR', '184', 'some', '682', '.ck'),
(53, 'CR', 'Costa Rica', 'Republic of Costa Rica', 'CRI', 5, 'INR', '188', 'yes', '506', '.cr'),
(54, 'CI', 'Cote d''ivoire (Ivory Coast)', 'Republic of C&ocirc;te D''Ivoire (Ivory Coast)', 'CIV', 0, 'INR', '384', 'yes', '225', '.ci'),
(55, 'HR', 'Croatia', 'Republic of Croatia', 'HRV', 0, 'INR', '191', 'yes', '385', '.hr'),
(56, 'CU', 'Cuba', 'Republic of Cuba', 'CUB', 0, 'INR', '192', 'yes', '53', '.cu'),
(57, 'CW', 'Curacao', 'Cura&ccedil;ao', 'CUW', 5, 'INR', '531', 'no', '599', '.cw'),
(58, 'CY', 'Cyprus', 'Republic of Cyprus', 'CYP', 0, 'INR', '196', 'yes', '357', '.cy'),
(59, 'CZ', 'Czech Republic', 'Czech Republic', 'CZE', 0, 'INR', '203', 'yes', '420', '.cz'),
(60, 'CD', 'Democratic Republic of the Congo', 'Democratic Republic of the Congo', 'COD', 0, 'INR', '180', 'yes', '243', '.cd'),
(61, 'DK', 'Denmark', 'Kingdom of Denmark', 'DNK', 4, 'INR', '208', 'yes', '45', '.dk'),
(62, 'DJ', 'Djibouti', 'Republic of Djibouti', 'DJI', 0, 'INR', '262', 'yes', '253', '.dj'),
(63, 'DM', 'Dominica', 'Commonwealth of Dominica', 'DMA', 0, 'INR', '212', 'yes', '1+767', '.dm'),
(64, 'DO', 'Dominican Republic', 'Dominican Republic', 'DOM', 3, 'INR', '214', 'yes', '1+809, 8', '.do'),
(65, 'EC', 'Ecuador', 'Republic of Ecuador', 'ECU', 0, 'INR', '218', 'yes', '593', '.ec'),
(66, 'EG', 'Egypt', 'Arab Republic of Egypt', 'EGY', 0, 'INR', '818', 'yes', '20', '.eg'),
(67, 'SV', 'El Salvador', 'Republic of El Salvador', 'SLV', 5, 'INR', '222', 'yes', '503', '.sv'),
(68, 'GQ', 'Equatorial Guinea', 'Republic of Equatorial Guinea', 'GNQ', 0, 'INR', '226', 'yes', '240', '.gq'),
(69, 'ER', 'Eritrea', 'State of Eritrea', 'ERI', 0, 'INR', '232', 'yes', '291', '.er'),
(70, 'EE', 'Estonia', 'Republic of Estonia', 'EST', 0, 'INR', '233', 'yes', '372', '.ee'),
(71, 'ET', 'Ethiopia', 'Federal Democratic Republic of Ethiopia', 'ETH', 0, 'INR', '231', 'yes', '251', '.et'),
(72, 'FK', 'Falkland Islands (Malvinas)', 'The Falkland Islands (Malvinas)', 'FLK', 0, 'INR', '238', 'no', '500', '.fk'),
(73, 'FO', 'Faroe Islands', 'The Faroe Islands', 'FRO', 0, 'INR', '234', 'no', '298', '.fo'),
(74, 'FJ', 'Fiji', 'Republic of Fiji', 'FJI', 2, 'INR', '242', 'yes', '679', '.fj'),
(75, 'FI', 'Finland', 'Republic of Finland', 'FIN', 2, 'EURO', '246', 'yes', '358', '.fi'),
(76, 'FR', 'France', 'French Republic', 'FRA', 4, 'INR', '250', 'yes', '33', '.fr'),
(77, 'GF', 'French Guiana', 'French Guiana', 'GUF', 2, 'INR', '254', 'no', '594', '.gf'),
(78, 'PF', 'French Polynesia', 'French Polynesia', 'PYF', 2, 'INR', '258', 'no', '689', '.pf'),
(79, 'TF', 'French Southern Territories', 'French Southern Territories', 'ATF', 2, 'INR', '260', 'no', NULL, '.tf'),
(80, 'GA', 'Gabon', 'Gabonese Republic', 'GAB', 0, 'INR', '266', 'yes', '241', '.ga'),
(81, 'GM', 'Gambia', 'Republic of The Gambia', 'GMB', 2, 'INR', '270', 'yes', '220', '.gm'),
(82, 'GE', 'Georgia', 'Georgia', 'GEO', 2, 'INR', '268', 'yes', '995', '.ge'),
(83, 'DE', 'Germany', 'Federal Republic of Germany', 'DEU', 4, 'EURO', '276', 'yes', '49', '.de'),
(84, 'GH', 'Ghana', 'Republic of Ghana', 'GHA', 2, 'INR', '288', 'yes', '233', '.gh'),
(85, 'GI', 'Gibraltar', 'Gibraltar', 'GIB', 2, 'INR', '292', 'no', '350', '.gi'),
(86, 'GR', 'Greece', 'Hellenic Republic', 'GRC', 3, 'INR', '300', 'yes', '30', '.gr'),
(87, 'GL', 'Greenland', 'Greenland', 'GRL', 2, 'INR', '304', 'no', '299', '.gl'),
(88, 'GD', 'Grenada', 'Grenada', 'GRD', 2, 'INR', '308', 'yes', '1+473', '.gd'),
(89, 'GP', 'Guadaloupe', 'Guadeloupe', 'GLP', 0, 'INR', '312', 'no', '590', '.gp'),
(90, 'GU', 'Guam', 'Guam', 'GUM', 0, 'INR', '316', 'no', '1+671', '.gu'),
(91, 'GT', 'Guatemala', 'Republic of Guatemala', 'GTM', 0, 'INR', '320', 'yes', '502', '.gt'),
(92, 'GG', 'Guernsey', 'Guernsey', 'GGY', 0, 'INR', '831', 'no', '44', '.gg'),
(93, 'GN', 'Guinea', 'Republic of Guinea', 'GIN', 0, 'INR', '324', 'yes', '224', '.gn'),
(94, 'GW', 'Guinea-Bissau', 'Republic of Guinea-Bissau', 'GNB', 2, 'INR', '624', 'yes', '245', '.gw'),
(95, 'GY', 'Guyana', 'Co-operative Republic of Guyana', 'GUY', 5, 'INR', '328', 'yes', '592', '.gy'),
(96, 'HT', 'Haiti', 'Republic of Haiti', 'HTI', 2, 'INR', '332', 'yes', '509', '.ht'),
(97, 'HM', 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', 'HMD', 2, 'INR', '334', 'no', 'NONE', '.hm'),
(98, 'HN', 'Honduras', 'Republic of Honduras', 'HND', 0, 'INR', '340', 'yes', '504', '.hn'),
(99, 'HK', 'Hong Kong', 'Hong Kong', 'HKG', 2, 'INR', '344', 'no', '852', '.hk'),
(100, 'HU', 'Hungary', 'Hungary', 'HUN', 0, 'INR', '348', 'yes', '36', '.hu'),
(101, 'IS', 'Iceland', 'Republic of Iceland', 'ISL', 3, 'INR', '352', 'yes', '354', '.is'),
(102, 'IN', 'India', 'Republic of India', 'IND', 2, 'INR', '356', 'yes', '91', '.in'),
(103, 'ID', 'Indonesia', 'Republic of Indonesia', 'IDN', 2, 'INR', '360', 'yes', '62', '.id'),
(104, 'IR', 'Iran', 'Islamic Republic of Iran', 'IRN', 0, 'INR', '364', 'yes', '98', '.ir'),
(105, 'IQ', 'Iraq', 'Republic of Iraq', 'IRQ', 0, 'INR', '368', 'yes', '964', '.iq'),
(106, 'IE', 'Ireland', 'Ireland', 'IRL', 0, 'INR', '372', 'yes', '353', '.ie'),
(107, 'IM', 'Isle of Man', 'Isle of Man', 'IMN', 0, 'INR', '833', 'no', '44', '.im'),
(108, 'IL', 'Israel', 'State of Israel', 'ISR', 0, 'INR', '376', 'yes', '972', '.il'),
(109, 'IT', 'Italy', 'Italian Republic', 'ITA', 0, 'INR', '380', 'yes', '39', '.jm'),
(110, 'JM', 'Jamaica', 'Jamaica', 'JAM', 0, 'INR', '388', 'yes', '1+876', '.jm'),
(111, 'JP', 'Japan', 'Japan', 'JPN', 0, 'INR', '392', 'yes', '81', '.jp'),
(112, 'JE', 'Jersey', 'The Bailiwick of Jersey', 'JEY', 5, 'INR', '832', 'no', '44', '.je'),
(113, 'JO', 'Jordan', 'Hashemite Kingdom of Jordan', 'JOR', 0, 'INR', '400', 'yes', '962', '.jo'),
(114, 'KZ', 'Kazakhstan', 'Republic of Kazakhstan', 'KAZ', 0, 'INR', '398', 'yes', '7', '.kz'),
(115, 'KE', 'Kenya', 'Republic of Kenya', 'KEN', 0, 'INR', '404', 'yes', '254', '.ke'),
(116, 'KI', 'Kiribati', 'Republic of Kiribati', 'KIR', 4, 'INR', '296', 'yes', '686', '.ki'),
(117, 'XK', 'Kosovo', 'Republic of Kosovo', '---', 3, 'INR', '---', 'some', '381', ''),
(118, 'KW', 'Kuwait', 'State of Kuwait', 'KWT', 0, 'INR', '414', 'yes', '965', '.kw'),
(119, 'KG', 'Kyrgyzstan', 'Kyrgyz Republic', 'KGZ', 0, 'INR', '417', 'yes', '996', '.kg'),
(120, 'LA', 'Laos', 'Lao People''s Democratic Republic', 'LAO', 0, 'INR', '418', 'yes', '856', '.la'),
(121, 'LV', 'Latvia', 'Republic of Latvia', 'LVA', 0, 'INR', '428', 'yes', '371', '.lv'),
(122, 'LB', 'Lebanon', 'Republic of Lebanon', 'LBN', 0, 'INR', '422', 'yes', '961', '.lb'),
(123, 'LS', 'Lesotho', 'Kingdom of Lesotho', 'LSO', 0, 'INR', '426', 'yes', '266', '.ls'),
(124, 'LR', 'Liberia', 'Republic of Liberia', 'LBR', 0, 'INR', '430', 'yes', '231', '.lr'),
(125, 'LY', 'Libya', 'Libya', 'LBY', 5, 'INR', '434', 'yes', '218', '.ly'),
(126, 'LI', 'Liechtenstein', 'Principality of Liechtenstein', 'LIE', 0, 'INR', '438', 'yes', '423', '.li'),
(127, 'LT', 'Lithuania', 'Republic of Lithuania', 'LTU', 0, 'INR', '440', 'yes', '370', '.lt'),
(128, 'LU', 'Luxembourg', 'Grand Duchy of Luxembourg', 'LUX', 0, 'INR', '442', 'yes', '352', '.lu'),
(129, 'MO', 'Macao', 'The Macao Special Administrative Region', 'MAC', 0, 'INR', '446', 'no', '853', '.mo'),
(130, 'MK', 'Macedonia', 'The Former Yugoslav Republic of Macedonia', 'MKD', 0, 'INR', '807', 'yes', '389', '.mk'),
(131, 'MG', 'Madagascar', 'Republic of Madagascar', 'MDG', 0, 'INR', '450', 'yes', '261', '.mg'),
(132, 'MW', 'Malawi', 'Republic of Malawi', 'MWI', 0, 'INR', '454', 'yes', '265', '.mw'),
(133, 'MY', 'Malaysia', 'Malaysia', 'MYS', 3, 'INR', '458', 'yes', '60', '.my'),
(134, 'MV', 'Maldives', 'Republic of Maldives', 'MDV', 0, 'INR', '462', 'yes', '960', '.mv'),
(135, 'ML', 'Mali', 'Republic of Mali', 'MLI', 0, 'INR', '466', 'yes', '223', '.ml'),
(136, 'MT', 'Malta', 'Republic of Malta', 'MLT', 0, 'INR', '470', 'yes', '356', '.mt'),
(137, 'MH', 'Marshall Islands', 'Republic of the Marshall Islands', 'MHL', 0, 'INR', '584', 'yes', '692', '.mh'),
(138, 'MQ', 'Martinique', 'Martinique', 'MTQ', 0, 'INR', '474', 'no', '596', '.mq'),
(139, 'MR', 'Mauritania', 'Islamic Republic of Mauritania', 'MRT', 0, 'INR', '478', 'yes', '222', '.mr'),
(140, 'MU', 'Mauritius', 'Republic of Mauritius', 'MUS', 0, 'INR', '480', 'yes', '230', '.mu'),
(141, 'YT', 'Mayotte', 'Mayotte', 'MYT', 0, 'INR', '175', 'no', '262', '.yt'),
(142, 'MX', 'Mexico', 'United Mexican States', 'MEX', 0, 'INR', '484', 'yes', '52', '.mx'),
(143, 'FM', 'Micronesia', 'Federated States of Micronesia', 'FSM', 5, 'INR', '583', 'yes', '691', '.fm'),
(144, 'MD', 'Moldava', 'Republic of Moldova', 'MDA', 0, 'INR', '498', 'yes', '373', '.md'),
(145, 'MC', 'Monaco', 'Principality of Monaco', 'MCO', 0, 'INR', '492', 'yes', '377', '.mc'),
(146, 'MN', 'Mongolia', 'Mongolia', 'MNG', 0, 'INR', '496', 'yes', '976', '.mn'),
(147, 'ME', 'Montenegro', 'Montenegro', 'MNE', 0, 'INR', '499', 'yes', '382', '.me'),
(148, 'MS', 'Montserrat', 'Montserrat', 'MSR', 0, 'INR', '500', 'no', '1+664', '.ms'),
(149, 'MA', 'Morocco', 'Kingdom of Morocco', 'MAR', 0, 'INR', '504', 'yes', '212', '.ma'),
(150, 'MZ', 'Mozambique', 'Republic of Mozambique', 'MOZ', 0, 'INR', '508', 'yes', '258', '.mz'),
(151, 'MM', 'Myanmar (Burma)', 'Republic of the Union of Myanmar', 'MMR', 0, 'INR', '104', 'yes', '95', '.mm'),
(152, 'NA', 'Namibia', 'Republic of Namibia', 'NAM', 0, 'INR', '516', 'yes', '264', '.na'),
(153, 'NR', 'Nauru', 'Republic of Nauru', 'NRU', 0, 'INR', '520', 'yes', '674', '.nr'),
(154, 'NP', 'Nepal', 'Federal Democratic Republic of Nepal', 'NPL', 3, 'INR', '524', 'yes', '977', '.np'),
(155, 'NL', 'Netherlands', 'Kingdom of the Netherlands', 'NLD', 0, 'INR', '528', 'yes', '31', '.nl'),
(156, 'NC', 'New Caledonia', 'New Caledonia', 'NCL', 0, 'INR', '540', 'no', '687', '.nc'),
(157, 'NZ', 'New Zealand', 'New Zealand', 'NZL', 0, 'AUD', '554', 'yes', '64', '.nz'),
(158, 'NI', 'Nicaragua', 'Republic of Nicaragua', 'NIC', 0, 'INR', '558', 'yes', '505', '.ni'),
(159, 'NE', 'Niger', 'Republic of Niger', 'NER', 0, 'INR', '562', 'yes', '227', '.ne'),
(160, 'NG', 'Nigeria', 'Federal Republic of Nigeria', 'NGA', 0, 'INR', '566', 'yes', '234', '.ng'),
(161, 'NU', 'Niue', 'Niue', 'NIU', 0, 'INR', '570', 'some', '683', '.nu'),
(162, 'NF', 'Norfolk Island', 'Norfolk Island', 'NFK', 5, 'INR', '574', 'no', '672', '.nf'),
(163, 'KP', 'North Korea', 'Democratic People''s Republic of Korea', 'PRK', 0, 'INR', '408', 'yes', '850', '.kp'),
(164, 'MP', 'Northern Mariana Islands', 'Northern Mariana Islands', 'MNP', 0, 'INR', '580', 'no', '1+670', '.mp'),
(165, 'NO', 'Norway', 'Kingdom of Norway', 'NOR', 0, 'EURO', '578', 'yes', '47', '.no'),
(166, 'OM', 'Oman', 'Sultanate of Oman', 'OMN', 0, 'INR', '512', 'yes', '968', '.om'),
(167, 'PK', 'Pakistan', 'Islamic Republic of Pakistan', 'PAK', 4, 'INR', '586', 'yes', '92', '.pk'),
(168, 'PW', 'Palau', 'Republic of Palau', 'PLW', 0, 'INR', '585', 'yes', '680', '.pw'),
(169, 'PS', 'Palestine', 'State of Palestine (or Occupied Palestinian Territory)', 'PSE', 0, 'INR', '275', 'some', '970', '.ps'),
(170, 'PA', 'Panama', 'Republic of Panama', 'PAN', 0, 'INR', '591', 'yes', '507', '.pa'),
(171, 'PG', 'Papua New Guinea', 'Independent State of Papua New Guinea', 'PNG', 0, 'INR', '598', 'yes', '675', '.pg'),
(172, 'PY', 'Paraguay', 'Republic of Paraguay', 'PRY', 0, 'INR', '600', 'yes', '595', '.py'),
(173, 'PE', 'Peru', 'Republic of Peru', 'PER', 0, 'INR', '604', 'yes', '51', '.pe'),
(174, 'PH', 'Phillipines', 'Republic of the Philippines', 'PHL', 0, 'INR', '608', 'yes', '63', '.ph'),
(175, 'PN', 'Pitcairn', 'Pitcairn', 'PCN', 3, 'INR', '612', 'no', 'NONE', '.pn'),
(176, 'PL', 'Poland', 'Republic of Poland', 'POL', 0, 'EURO', '616', 'yes', '48', '.pl'),
(177, 'PT', 'Portugal', 'Portuguese Republic', 'PRT', 0, 'INR', '620', 'yes', '351', '.pt'),
(178, 'PR', 'Puerto Rico', 'Commonwealth of Puerto Rico', 'PRI', 0, 'INR', '630', 'no', '1+939', '.pr'),
(179, 'QA', 'Qatar', 'State of Qatar', 'QAT', 0, 'INR', '634', 'yes', '974', '.qa'),
(180, 'RE', 'Reunion', 'R&eacute;union', 'REU', 0, 'INR', '638', 'no', '262', '.re'),
(181, 'RO', 'Romania', 'Romania', 'ROU', 0, 'INR', '642', 'yes', '40', '.ro'),
(182, 'RU', 'Russia', 'Russian Federation', 'RUS', 4, 'INR', '643', 'yes', '7', '.ru'),
(183, 'RW', 'Rwanda', 'Republic of Rwanda', 'RWA', 1, 'INR', '646', 'yes', '250', '.rw'),
(184, 'BL', 'Saint Barthelemy', 'Saint Barth&eacute;lemy', 'BLM', 0, 'INR', '652', 'no', '590', '.bl'),
(185, 'SH', 'Saint Helena', 'Saint Helena, Ascension and Tristan da Cunha', 'SHN', 0, 'INR', '654', 'no', '290', '.sh'),
(186, 'KN', 'Saint Kitts and Nevis', 'Federation of Saint Christopher and Nevis', 'KNA', 3, 'INR', '659', 'yes', '1+869', '.kn'),
(187, 'LC', 'Saint Lucia', 'Saint Lucia', 'LCA', 0, 'INR', '662', 'yes', '1+758', '.lc'),
(188, 'MF', 'Saint Martin', 'Saint Martin', 'MAF', 0, 'INR', '663', 'no', '590', '.mf'),
(189, 'PM', 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', 'SPM', 0, 'INR', '666', 'no', '508', '.pm'),
(190, 'VC', 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'VCT', 1, 'INR', '670', 'yes', '1+784', '.vc'),
(191, 'WS', 'Samoa', 'Independent State of Samoa', 'WSM', 0, 'INR', '882', 'yes', '685', '.ws'),
(192, 'SM', 'San Marino', 'Republic of San Marino', 'SMR', 0, 'INR', '674', 'yes', '378', '.sm'),
(193, 'ST', 'Sao Tome and Principe', 'Democratic Republic of S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'STP', 0, 'INR', '678', 'yes', '239', '.st'),
(194, 'SA', 'Saudi Arabia', 'Kingdom of Saudi Arabia', 'SAU', 0, 'INR', '682', 'yes', '966', '.sa'),
(195, 'SN', 'Senegal', 'Republic of Senegal', 'SEN', 0, 'INR', '686', 'yes', '221', '.sn'),
(196, 'RS', 'Serbia', 'Republic of Serbia', 'SRB', 0, 'INR', '688', 'yes', '381', '.rs'),
(197, 'SC', 'Seychelles', 'Republic of Seychelles', 'SYC', 0, 'INR', '690', 'yes', '248', '.sc'),
(198, 'SL', 'Sierra Leone', 'Republic of Sierra Leone', 'SLE', 3, 'INR', '694', 'yes', '232', '.sl'),
(199, 'SG', 'Singapore', 'Republic of Singapore', 'SGP', 1, 'INR', '702', 'yes', '65', '.sg'),
(200, 'SX', 'Sint Maarten', 'Sint Maarten', 'SXM', 4, 'INR', '534', 'no', '1+721', '.sx'),
(201, 'SK', 'Slovakia', 'Slovak Republic', 'SVK', 1, 'EURO', '703', 'yes', '421', '.sk'),
(202, 'SI', 'Slovenia', 'Republic of Slovenia', 'SVN', 0, 'INR', '705', 'yes', '386', '.si'),
(203, 'SB', 'Solomon Islands', 'Solomon Islands', 'SLB', 0, 'INR', '090', 'yes', '677', '.sb'),
(204, 'SO', 'Somalia', 'Somali Republic', 'SOM', 0, 'INR', '706', 'yes', '252', '.so'),
(205, 'ZA', 'South Africa', 'Republic of South Africa', 'ZAF', 1, 'INR', '710', 'yes', '27', '.za'),
(206, 'GS', 'South Georgia and the South Sandwich Islands', 'South Georgia and the South Sandwich Islands', 'SGS', 4, 'INR', '239', 'no', '500', '.gs'),
(207, 'KR', 'South Korea', 'Republic of Korea', 'KOR', 0, 'INR', '410', 'yes', '82', '.kr'),
(208, 'SS', 'South Sudan', 'Republic of South Sudan', 'SSD', 0, 'INR', '728', 'yes', '211', '.ss'),
(209, 'ES', 'Spain', 'Kingdom of Spain', 'ESP', 0, 'EURO', '724', 'yes', '34', '.es'),
(210, 'LK', 'Sri Lanka', 'Democratic Socialist Republic of Sri Lanka', 'LKA', 1, 'INR', '144', 'yes', '94', '.lk'),
(211, 'SD', 'Sudan', 'Republic of the Sudan', 'SDN', 4, 'INR', '729', 'yes', '249', '.sd'),
(212, 'SR', 'Suriname', 'Republic of Suriname', 'SUR', 0, 'INR', '740', 'yes', '597', '.sr'),
(213, 'SJ', 'Svalbard and Jan Mayen', 'Svalbard and Jan Mayen', 'SJM', 0, 'INR', '744', 'no', '47', '.sj'),
(214, 'SZ', 'Swaziland', 'Kingdom of Swaziland', 'SWZ', 1, 'INR', '748', 'yes', '268', '.sz'),
(215, 'SE', 'Sweden', 'Kingdom of Sweden', 'SWE', 3, 'INR', '752', 'yes', '46', '.se'),
(216, 'CH', 'Switzerland', 'Swiss Confederation', 'CHE', 4, 'INR', '756', 'yes', '41', '.ch'),
(217, 'SY', 'Syria', 'Syrian Arab Republic', 'SYR', 0, 'INR', '760', 'yes', '963', '.sy'),
(218, 'TW', 'Taiwan', 'Republic of China (Taiwan)', 'TWN', 0, 'INR', '158', 'former', '886', '.tw'),
(219, 'TJ', 'Tajikistan', 'Republic of Tajikistan', 'TJK', 0, 'INR', '762', 'yes', '992', '.tj'),
(220, 'TZ', 'Tanzania', 'United Republic of Tanzania', 'TZA', 4, 'INR', '834', 'yes', '255', '.tz'),
(221, 'TH', 'Thailand', 'Kingdom of Thailand', 'THA', 0, 'INR', '764', 'yes', '66', '.th'),
(222, 'TL', 'Timor-Leste (East Timor)', 'Democratic Republic of Timor-Leste', 'TLS', 0, 'INR', '626', 'yes', '670', '.tl'),
(223, 'TG', 'Togo', 'Togolese Republic', 'TGO', 0, 'INR', '768', 'yes', '228', '.tg'),
(224, 'TK', 'Tokelau', 'Tokelau', 'TKL', 5, 'INR', '772', 'no', '690', '.tk'),
(225, 'TO', 'Tonga', 'Kingdom of Tonga', 'TON', 4, 'INR', '776', 'yes', '676', '.to'),
(226, 'TT', 'Trinidad and Tobago', 'Republic of Trinidad and Tobago', 'TTO', 0, 'INR', '780', 'yes', '1+868', '.tt'),
(227, 'TN', 'Tunisia', 'Republic of Tunisia', 'TUN', 1, 'INR', '788', 'yes', '216', '.tn'),
(228, 'TR', 'Turkey', 'Republic of Turkey', 'TUR', 0, 'INR', '792', 'yes', '90', '.tr'),
(229, 'TM', 'Turkmenistan', 'Turkmenistan', 'TKM', 0, 'INR', '795', 'yes', '993', '.tm'),
(230, 'TC', 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'TCA', 3, 'INR', '796', 'no', '1+649', '.tc'),
(231, 'TV', 'Tuvalu', 'Tuvalu', 'TUV', 1, 'INR', '798', 'yes', '688', '.tv'),
(232, 'UG', 'Uganda', 'Republic of Uganda', 'UGA', 4, 'INR', '800', 'yes', '256', '.ug'),
(233, 'UA', 'Ukraine', 'Ukraine', 'UKR', 1, 'INR', '804', 'yes', '380', '.ua'),
(234, 'AE', 'United Arab Emirates', 'United Arab Emirates', 'ARE', 1, 'INR', '784', 'yes', '971', '.ae'),
(235, 'GB', 'United Kingdom', 'United Kingdom of Great Britain and Nothern Ireland', 'GBR', 1, 'INR', '826', 'yes', '44', '.uk'),
(236, 'US', 'United States', 'United States of America', 'USA', 1, 'USD', '840', 'yes', '1', '.us'),
(237, 'UM', 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', 'UMI', 0, 'INR', '581', 'no', 'NONE', 'NONE'),
(238, 'UY', 'Uruguay', 'Eastern Republic of Uruguay', 'URY', 4, 'INR', '858', 'yes', '598', '.uy'),
(239, 'UZ', 'Uzbekistan', 'Republic of Uzbekistan', 'UZB', 1, 'INR', '860', 'yes', '998', '.uz'),
(240, 'VU', 'Vanuatu', 'Republic of Vanuatu', 'VUT', 1, 'INR', '548', 'yes', '678', '.vu'),
(241, 'VA', 'Vatican City', 'State of the Vatican City', 'VAT', 1, 'INR', '336', 'no', '39', '.va'),
(242, 'VE', 'Venezuela', 'Bolivarian Republic of Venezuela', 'VEN', 3, 'INR', '862', 'yes', '58', '.ve'),
(243, 'VN', 'Vietnam', 'Socialist Republic of Vietnam', 'VNM', 1, 'INR', '704', 'yes', '84', '.vn'),
(244, 'VG', 'Virgin Islands British', 'British Virgin Islands', 'VGB', 1, 'INR', '092', 'no', '1+284', '.vg'),
(245, 'VI', 'Virgin Islands US', 'Virgin Islands of the United States', 'VIR', 3, 'INR', '850', 'no', '1+340', '.vi'),
(246, 'WF', 'Wallis and Futuna', 'Wallis and Futuna', 'WLF', 3, 'INR', '876', 'no', '681', '.wf'),
(247, 'EH', 'Western Sahara', 'Western Sahara', 'ESH', 3, 'INR', '732', 'no', '212', '.eh'),
(248, 'YE', 'Yemen', 'Republic of Yemen', 'YEM', 3, 'INR', '887', 'yes', '967', '.ye'),
(249, 'ZM', 'Zambia', 'Republic of Zambia', 'ZMB', 0, 'INR', '894', 'yes', '260', '.zm'),
(250, 'ZW', 'Zimbabwe', 'Republic of Zimbabwe', 'ZWE', 0, 'INR', '716', 'yes', '263', '.zw');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `currency_code` varchar(5) NOT NULL,
  `currency_name` varchar(40) NOT NULL,
  `value_in_INR` float NOT NULL,
  PRIMARY KEY (`currency_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_code`, `currency_name`, `value_in_INR`) VALUES
('AUD', 'Australlian Dollar', 49),
('EURO', 'European Dollar', 69),
('USD', 'United States Dollar', 54.14);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(9) NOT NULL,
  `user` varchar(35) NOT NULL,
  `date` date NOT NULL,
  `amount` int(15) NOT NULL,
  `payment_option` varchar(30) NOT NULL,
  `status` int(1) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `add` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `country` text NOT NULL,
  `pin_code` text NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `gateway` varchar(30) DEFAULT NULL,
  `transaction_id` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user`, `date`, `amount`, `payment_option`, `status`, `fname`, `lname`, `add`, `city`, `state`, `country`, `pin_code`, `delivery_date`, `gateway`, `transaction_id`) VALUES
(3239, 'ramanuj@gmail.com', '2012-08-07', 341776, 'PayPal', 1, 'Avinash Kumar', 'Jha', 'Village+Post: Chhotodighari', 'Asansol', 'West Bengal', 'IN', '713326', '2012-08-07', 'fdsdf', 'dfssd'),
(3240, 'ramanuj@gmail.com', '2012-08-07', 111554, 'PayPal', 1, 'Avinash Kumar', 'Jha', 'Village+Post: Chhotodighari', 'Asansol', 'West Bengal', 'IN', '713326', NULL, NULL, NULL),
(3241, 'ramanuj@gmail.com', '2012-08-07', 34500, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3242, 'ramanuj@gmail.com', '2012-08-07', 76000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3243, 'ramanuj@gmail.com', '2012-08-07', 6900, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3244, 'ramanuj@gmail.com', '2012-08-07', 8500, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3245, 'ramanuj@gmail.com', '2012-08-07', 8500, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3246, 'ramanuj@gmail.com', '2012-08-07', 8500, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3247, 'ramanuj@gmail.com', '2012-08-07', 6900, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3248, 'ramanuj@gmail.com', '2012-08-07', 36000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3249, 'ramanuj@gmail.com', '2012-08-07', 8500, 'PayPal', 1, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3250, 'ramanuj@gmail.com', '2012-08-07', 32010, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3251, 'ramanuj@gmail.com', '2012-08-07', 32010, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3252, 'ramanuj@gmail.com', '2012-08-07', 36000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3253, 'ramanuj@gmail.com', '2012-08-07', 8500, 'PayPal', 1, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3254, 'ramanuj@gmail.com', '2012-08-07', 8500, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3255, 'ramanuj@gmail.com', '2012-08-07', 358525, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3256, 'ramanuj@gmail.com', '2012-08-07', 792200, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3257, 'ramanuj@gmail.com', '2012-08-07', 245920, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3258, 'ramanuj@gmail.com', '2012-08-07', 297610, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3259, 'ramanuj@gmail.com', '2012-08-07', 31005, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3260, 'ramanuj@gmail.com', '2012-08-07', 31005, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3261, 'ramanuj@gmail.com', '2012-08-07', 24012, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3262, 'ramanuj@gmail.com', '2012-08-07', 12000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3263, 'ramanuj@gmail.com', '2012-08-07', 3000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3264, 'ramanuj@gmail.com', '2012-08-07', 38000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3265, 'ramanuj@gmail.com', '2012-08-07', 32010, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3266, 'ramanuj@gmail.com', '2012-08-07', 64000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3267, 'ramanuj@gmail.com', '2012-08-07', 44000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3268, 'ramanuj@gmail.com', '2012-08-07', 44000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3269, 'ramanuj@gmail.com', '2012-08-07', 32000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3270, 'ramanuj@gmail.com', '2012-08-07', 3000, 'PayPal', 1, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', '2012-08-07', 'SGHGTF', '567GFDSR6'),
(3271, 'ramanuj@gmail.com', '2012-08-07', 222, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3272, 'ramanuj@gmail.com', '2012-08-07', 3000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3273, 'ramanuj@gmail.com', '2012-08-07', 12000, 'PayPal', 1, 'Ramanujan', 'Rungam', 'quick add', 'Asansol', 'West Bengal', 'IN', '760054', '2012-08-07', 'THHFF', 'H577YYHD446'),
(3274, 'ramanuj@gmail.com', '2012-08-09', 44000, 'PayPal', 0, 'Ramanujan', 'Rungam', 'DS 43/1, Hill Valley Colony', 'Asansol', 'West Bengal', 'IN', '760054', NULL, NULL, NULL),
(3275, 'nynpt@gmail.com', '2012-08-09', 32000, 'PayPal', 0, 'Nayan Bhai', 'Patel', 'D2/1, 10 Newtown', 'Asansol', 'West Bengal', 'IN', '713326', NULL, NULL, NULL),
(3276, 'nynpt@gmail.com', '2012-08-09', 32000, 'PayPal', 0, 'Nayan Bhai', 'Patel', 'D 2/1, Road No. 10 Newtown', 'Asansol', 'West Bengal', 'IN', '713326', NULL, NULL, NULL),
(3277, 'nynpt@gmail.com', '2012-08-09', 36800, 'PayPal', 1, 'Nayan Bhai', 'Patel', 'D 2/1, Road No. 10 Newtown', 'Asansol', 'West Bengal', 'IN', '713326', '2012-08-09', 'AGDSGD', '56GGS68HSH'),
(3278, 'nynpt@gmail.com', '2012-08-09', 13800, 'PayPal', 0, 'Nayan Bhai', 'Patel', 'D 2/1, Road No. 10 Newtown', 'Asansol', 'West Bengal', 'IN', '713326', NULL, NULL, NULL),
(3279, 'nynpt@gmail.com', '2012-08-09', 48410, 'PayPal', 0, 'Nayan Bhai', 'Patel', 'D 2/1, Road No. 10 Newtown', 'Asansol', 'West Bengal', 'IN', '713326', NULL, NULL, NULL),
(3280, 'nynpt@gmail.com', '2012-08-09', 33189, 'PayPal', 0, 'Nayan Bhai', 'Patel', 'D 2/1, Road No. 10 Newtown', 'Asansol', 'West Bengal', 'IN', '713326', NULL, NULL, NULL),
(3281, 'nynpt@gmail.com', '2012-08-09', 48410, 'PayPal', 0, 'Nayan Bhai', 'Patel', 'D 2/1, Road No. 10 Newtown', 'Asansol', 'West Bengal', 'IN', '713326', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_nynpt@gmail.com`
--

CREATE TABLE IF NOT EXISTS `order_nynpt@gmail.com` (
  `order_id` int(9) NOT NULL DEFAULT '0',
  `product` varchar(15) NOT NULL,
  `quantity` int(15) NOT NULL DEFAULT '1',
  `price` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_nynpt@gmail.com`
--

INSERT INTO `order_nynpt@gmail.com` (`order_id`, `product`, `quantity`, `price`) VALUES
(3275, 'JHT74JK7J4FGYJK', 1, 32000),
(3276, 'JHT74JK7J4FGYJK', 1, 32000),
(3277, 'JHT74JK7J4FGYJK', 1, 32000),
(3278, 'FGYLKM469UR62FY', 1, 12000),
(3279, 'FGYLKM469UR62FY', 1, 12000),
(3280, 'JHT74JK7J4FGYJK', 1, 32000),
(3281, 'FGYLKM469UR62FY', 1, 12000),
(3281, 'JHT74JK7J4FGYJK', 1, 32000),
(3281, 'NYNPTL7658', 1, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `order_ramanuj@gmail.com`
--

CREATE TABLE IF NOT EXISTS `order_ramanuj@gmail.com` (
  `order_id` int(9) NOT NULL,
  `product` varchar(15) NOT NULL,
  `quantity` int(15) NOT NULL DEFAULT '1',
  `price` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_ramanuj@gmail.com`
--

INSERT INTO `order_ramanuj@gmail.com` (`order_id`, `product`, `quantity`, `price`) VALUES
(3239, 'FGYLKM469UR62GA', 8, 38000),
(3240, 'FGYLKM469UR62FZ', 3, 24000),
(3240, 'FGYLKM469UR62GA', 1, 38000),
(3240, 'ssaas', 7, 222),
(3241, 'THJKL76TG4ED98H', 5, 6900),
(3242, 'L5HDL8HBF6JGD6Y', 2, 38000),
(3243, 'THJKL76Tihi98H', 1, 6900),
(3244, 'TBLH597RVKtftfg', 1, 8500),
(3245, 'TBLH597RVKtftfg', 1, 8500),
(3246, 'TBLH597RVKtftfg', 1, 8500),
(3247, 'THJKL76Tihi98H', 1, 6900),
(3248, 'B5HD488KH6JGD69', 1, 36000),
(3249, 'TBLH597RVKtftf', 1, 8500),
(3250, 'A5HD48HB48JGD60', 1, 32010),
(3251, 'A5HD48HB48JKD60', 1, 32010),
(3252, 'B5HD488KH6JGD69', 1, 36000),
(3253, 'TBLH597RVKtftf', 1, 8500),
(3254, 'TBLH597RVKtftf', 1, 8500),
(3255, 'C5HD48HBF65EF6Y', 5, 31005),
(3255, 'F5HL488BF6JGD6M', 1, 26000),
(3255, 'H5HD486RF6JGD64', 3, 31000),
(3255, 'L5HBL8HBF6JGD6Y', 1, 38000),
(3255, 'L5HDL8HBF6JGD6Y', 1, 38000),
(3255, 'TBLH597RVKtftf', 1, 8500),
(3256, 'FGYLKM469UR62GB', 1, 26000),
(3256, 'KL76TG4Ugug8H', 7, 6900),
(3256, 'TBLGKITB864JGG', 1, 4500),
(3256, 'THJKL76H', 1, 678900),
(3256, 'THJKL7D98hghH', 5, 6900),
(3257, 'A5HD48HB48JGD6Y', 2, 32010),
(3257, 'B5HD488KH6JGD69', 3, 36000),
(3257, 'D5HD48HBHYJGD6Y', 1, 33000),
(3257, 'TBLH597RVKtftf', 1, 8500),
(3257, 'TBLH597RVKtftfg', 3, 8500),
(3257, 'THJKL76Tihi98H', 1, 6900),
(3258, 'C5HD48HBF65EF6L', 1, 31005),
(3258, 'C5HD48HBF65EF6Y', 1, 31005),
(3258, 'D5HD48HBHYJGDKY', 6, 33000),
(3258, 'E5HD48HBOKJGD6T', 1, 37600),
(3259, 'C5HD48HBF65EF6L', 1, 31005),
(3260, 'C5HD48H5F65EF6L', 1, 31005),
(3261, '432sdf', 1, 12),
(3261, 'FGYLKM469UR62FZ', 1, 24000),
(3262, 'FGYLKM469UR62FY', 1, 12000),
(3263, 'NYNPTL7658', 1, 3000),
(3264, 'FGYLKM469UR62GA', 1, 38000),
(3265, 'A5HD48HB48JGD60', 1, 32010),
(3266, 'J5HD48HBF6WGD6Y', 1, 64000),
(3267, 'I5HD480BF6JGD6Y', 1, 44000),
(3268, 'I5HD480BF6JGD6Y', 1, 44000),
(3269, 'JHT74JK7J4FGYJK', 1, 32000),
(3270, 'NYNPTL7658', 1, 3000),
(3271, 'ssaas', 1, 222),
(3272, 'NYNPTL7658', 1, 3000),
(3273, 'FGYLKM4692FY', 1, 12000),
(3274, 'FGYLKM469UR62FY', 1, 12000),
(3274, 'JHT74JK7J4FGYJK', 1, 32000);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` varchar(15) NOT NULL,
  `name` varchar(30) NOT NULL,
  `desc` text NOT NULL,
  `price` int(15) NOT NULL,
  `qty` int(15) NOT NULL,
  `catagory` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `img` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `desc`, `price`, `qty`, `catagory`, `date`, `img`) VALUES
('432sdf', 'Test', 'fsdfsf', 12, 10, 'sdasdsa', '2012-07-19', '432sdf.jpg'),
('A5HD48HB48JGD60', 'Dell Laptop Dellishky 1', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop Dellishky', 32010, 8, 'PC', '2010-01-20', ''),
('A5HD48HB48JGD6Y', 'Dell Laptop2', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 32010, 5, 'PC', '2010-01-20', ''),
('A5HD48HB48JKD60', 'Dell Laptop21', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 32010, 9, 'PC', '2010-01-20', ''),
('B5HD4889H6JGD69', 'Dell Laptop22', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 36000, 10, 'Laptop', '2010-01-20', ''),
('B5HD488KH6JGD69', 'Dell Laptop3', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 36000, 5, 'Laptop', '2010-01-20', ''),
('B5HD488KH6JGD6Y', 'Dell Laptop4', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 36000, 10, 'Laptop', '2010-01-20', ''),
('C5HD48H5F65EF6L', 'Dell Laptop23', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 31005, 9, 'Laptop', '2010-01-20', ''),
('C5HD48HBF65EF6L', 'Dell Laptop5', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 31005, 8, 'Laptop', '2010-01-20', ''),
('C5HD48HBF65EF6Y', 'Dell Laptop6', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 31005, 4, 'Laptop', '2010-01-20', ''),
('D5HD48HB4YJGDKY', 'Dell Laptop24', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 33000, 10, 'Laptop', '2010-01-20', ''),
('D5HD48HBHYJGD6Y', 'Dell Laptop7', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 33000, 9, 'Laptop', '2010-01-20', ''),
('D5HD48HBHYJGDKY', 'Dell Laptop8', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 33000, 4, 'Laptop', '2010-01-20', ''),
('E5HD48HBFKJGD6T', 'Dell Laptop9', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 37600, 10, 'PC', '2010-01-20', ''),
('E5HD48HBFKJGD6Y', 'Dell Laptop10', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything about Dell Laptop', 37600, 10, 'PC', '2010-01-20', ''),
('E5HD48HBOKJGD6T', 'Dell Laptop25', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 37600, 9, 'PC', '2010-01-20', ''),
('F5HL488BF6JGD6M', 'Dell Laptop26', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 26000, 9, 'PC', '2010-01-20', ''),
('F5HL48HBF6JGD6M', 'Dell Laptop11', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 26000, 10, 'PC', '2010-01-20', ''),
('F5HL48HBF6JGD6Y', 'Dell Laptop12', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 26000, 10, 'PC', '2010-01-20', ''),
('FGYLKM4692FY', 'Nokia 3452', 'Largest selling mobile phone.', 12000, 10, 'Mobile', '2012-07-16', 'FGYLKM4692FY.jpg'),
('FGYLKM469UR62FY', 'Nokia 5800', 'Largest selling mobile phone.', 12000, 5, 'Mobile', '2012-08-16', 'FGYLKM469UR62FY.jpg'),
('FGYLKM469UR62FZ', 'Samsung Galaxy', 'The most glamarous mobile from Samsung.', 24000, 3, 'Mobile', '2012-07-16', ''),
('FGYLKM469UR62GA', 'Dell Inspiron 1545', 'Dell Inspiron Laptop with Intel Core i5 processor, 6GB RAM, 512GB HDD', 38000, 0, 'Laptop', '2012-07-16', 'FGYLKM469UR62GA.jpg'),
('FGYLKM469UR62GB', 'Dell Studio 4898', 'Dell Studio one of the most cheep Laptop ', 26000, 9, 'Laptop', '2012-07-16', ''),
('frgfshfdfdfgf', 'abc''def''ghi''jklm''n', 'fgf', 12000, 10, 'Mobile', '2012-07-16', 'frgfshfdfdfgf.jpg'),
('frgfshgnhgfgf', 'Nokia''s  5800x', 'fgf', 12000, 10, 'Mobile', '2012-07-16', 'frgfshgnhgfgf.jpg'),
('H5HD484RF6JGD64', 'Dell Laptop27', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 31000, 10, 'PC', '2010-01-20', ''),
('H5HD486RF6JGD64', 'Dell Laptop13', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 31000, 7, 'PC', '2010-01-20', 'H5HD486RF6JGD64.jpg'),
('H5HD486RF6JGD6Y', 'Dell Laptop14', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 31000, 10, 'PC', '2010-01-20', ''),
('I5HD480BF6JGD6D', 'Dell Laptop15', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 44000, 10, 'PC', '2010-01-20', ''),
('I5HD480BF6JGD6Y', 'Dell Laptop16', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 44000, 8, 'PC', '2010-01-20', ''),
('J5HD48HBF6WGD6Y', 'Dell Laptop17', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 64000, 9, 'Laptop', '2010-01-20', ''),
('J5HD48HBF6ZGD6Y', 'Dell Laptop18', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 64000, 10, 'Laptop', '2010-01-20', ''),
('JHT74JK7J4FGYJK', 'Dell Inspiron 1545 Laptop', 'Its my laptop also. So, don’t worry it’s a good one', 32000, 26, 'Laptop', '2012-08-18', 'JHT74JK7J4FGYJK.jpg'),
('KL76TG4Ugug8H', 'Samsung Mobile', 'Everybody knows about it. Its Samsung yaar.', 6900, 3, 'Mobile', '2012-07-15', ''),
('L5HBL8HBF6JGD6Y', 'Dell Laptop19', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 38000, 9, 'PC', '2010-01-20', ''),
('L5HDL8HBF6JGD6Y', 'Dell Laptop20', 'Right now I am not providing any details. But, don''t worry I''ll do it latter. Anyways I don''t think that there is someone who doesn''t know anything abot Dell Laptop', 38000, 7, 'PC', '2010-01-20', ''),
('L76TG4EDhgy98H', 'Samsung Mobile', 'Everybody knows about it. Its Samsung yaar.', 6900, 10, 'Mobile', '2012-07-15', ''),
('NYNPTL7658', 'Nayan Patel', 'A very good animal that performs a lot of extra curricular activities', 3000, 5, 'Human', '2012-07-24', 'NYNPTL7658.jpg'),
('ssaas', 'assa', 'sasa', 222, 11, 'sasa', '2012-07-22', 'ssaas.jpg'),
('TBLGKITB864JGG', 'NOKIA Mobile', 'Nokia', 4500, 9, 'Mobile', '2012-07-15', ''),
('TBLH597DVTJIL', 'LG Mobile', 'Nothing to say.', 8500, 10, 'Mobile', '2012-07-15', ''),
('TBLH597RVK', 'LG Mobile', 'Nothing to say', 9900, 10, 'Mobile', '2012-07-15', ''),
('TBLH597RVKtftf', 'LG Mobile', 'Nothing to say.', 8500, 5, 'Mobile', '2012-07-15', ''),
('TBLH597RVKtftfg', 'LG Mobile', 'Nothing to say.', 8500, 4, 'Mobile', '2012-07-15', ''),
('THJKL76754EH', 'Samsung Mobile', 'Everybody knows about it. Its Samsung yaar.', 6900, 10, 'Mobile', '2012-07-15', ''),
('THJKL76H', 'Samsung Mobile', 'Everybody knows about it. Its Samsung yaar.', 678900, 9, 'Mobile', '2012-07-15', ''),
('THJKL76TG4E8H', 'Samsung Mobile', 'Everybody knows about it. Its Samsung yaar.', 900, 10, 'Mobile', '2012-07-15', ''),
('THJKL76TG4ED98H', 'Samsung Mobile', 'Everybody knows about it. Its Samsung yaar.', 6900, 5, 'Mobile', '2010-01-20', ''),
('THJKL76Tihi98H', 'Samsung Mobile', 'Everybody knows about it. Its Samsung yaar.', 6900, 7, 'Mobile', '2012-07-15', ''),
('THJKL7D98hghH', 'Samsung Mobile', 'Everybody knows about it. Its Samsung yaar.', 6900, 5, 'Mobile', '2012-07-15', ''),
('THJKLthjv4ED98H', 'Samsung Mobile', 'Everybody knows about it. Its Samsung yaar.', 6900, 10, 'Mobile', '2012-07-15', '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `function` varchar(20) NOT NULL,
  `value` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`function`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`function`, `value`) VALUES
('default_shipping', 15),
('products_per_page', 10);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE IF NOT EXISTS `shipping` (
  `slno` int(15) NOT NULL AUTO_INCREMENT,
  `zone` int(3) NOT NULL,
  `from` int(20) NOT NULL,
  `to` int(20) NOT NULL,
  `shipping` int(2) NOT NULL,
  PRIMARY KEY (`slno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`slno`, `zone`, `from`, `to`, `shipping`) VALUES
(3, 1, 10001, 100000, 5),
(5, 5, 12, 10001, 8),
(6, 4, 1, 3000, 11),
(18, 3, 98, 58998, 12),
(19, 2, 32001, 58998, 3),
(20, 1, 43, 2355, 11),
(21, 1, 1, 42, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `name` varchar(70) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `dob` date NOT NULL,
  `org` text NOT NULL,
  `add` text NOT NULL,
  `pin_code` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `country` text NOT NULL,
  `phno` int(15) NOT NULL,
  `date` date NOT NULL,
  `last_login` date NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `name`, `last_name`, `gender`, `dob`, `org`, `add`, `pin_code`, `city`, `state`, `country`, `phno`, `date`, `last_login`) VALUES
('nynpt@gmail.com', 'd85629cc', 'Nayan Bhai', 'Patel', 'Male', '1990-06-09', 'PrakritikShakti', 'D 2/1, Road No. 10 Newtown', '713326', 'Asansol', 'West Bengal', 'IN', 2147483647, '2012-08-06', '2012-08-09'),
('ramanuj@gmail.com', 'ramanuj', 'Ramanujan', 'Rungam', 'Male', '1984-08-05', 'Pragyana', 'quick add', '760054', 'Asansol', 'West Bengal', 'IN', 2147483647, '2008-10-28', '2012-08-09');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
