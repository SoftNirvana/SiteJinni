/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  bishwaroop.mukherjee
 * Created: Sep 24, 2017
 */

-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 24, 2017 at 03:16 PM
-- Server version: 5.6.35
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `CMSDBMAIN`
--

-- --------------------------------------------------------

--
-- Table structure for table `BILLITEM`
--

CREATE TABLE `BILLITEM` (
  `itemid` varchar(250) NOT NULL,
  `itemname` varchar(256) NOT NULL,
  `cartitemid` varchar(50) NOT NULL,
  `billdate` datetime DEFAULT NULL,
  `itemqty` int(11) DEFAULT NULL,
  `itemrate` double DEFAULT NULL,
  `itemdiscount` double DEFAULT NULL,
  `itemstax` double DEFAULT NULL,
  `itemgtax` double DEFAULT NULL,
  `itemtotal` double DEFAULT NULL,
  `itemrenewfreq` int(11) DEFAULT NULL,
  `itemdescription` varchar(256) DEFAULT NULL,
  `itemnotes` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `CART`
--

CREATE TABLE `CART` (
  `cartid` varchar(250) NOT NULL,
  `clientid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `userid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ispaid` bit(1) DEFAULT NULL,
  `cartdescription` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CART`
--

INSERT INTO `CART` (`cartid`, `clientid`, `userid`, `ispaid`, `cartdescription`) VALUES
('bishwaroopm-bishwaroopm-CLNT-4-CART59a13aee8b67d4.01954152', 'bishwaroopm-CLNT-4', 'bishwaroopm', b'0', 'bishwaroopm: cart 2017-08-26-14-40-06');

-- --------------------------------------------------------

--
-- Table structure for table `CARTITEM`
--

CREATE TABLE `CARTITEM` (
  `cartitemid` varchar(250) NOT NULL,
  `cartitemname` varchar(256) NOT NULL,
  `cartid` varchar(50) NOT NULL,
  `servicetypeid` int(11) NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `offerid` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `CLIENT`
--

CREATE TABLE `CLIENT` (
  `clientid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `clientname` varchar(250) CHARACTER SET utf8 NOT NULL,
  `clientcontactnumber1` varchar(12) CHARACTER SET utf8 NOT NULL,
  `clientcontactnumber2` varchar(12) CHARACTER SET utf8 NOT NULL,
  `clientaddressline1` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `clientaddressline2` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `clientaddressline3` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `clientcity` varchar(100) CHARACTER SET utf8 NOT NULL,
  `clientzipcode` varchar(12) CHARACTER SET utf8 NOT NULL,
  `clientmailaddress` varchar(250) CHARACTER SET utf8 NOT NULL,
  `clientmainURL` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `clientnumofservices` int(11) DEFAULT NULL,
  `userid` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CLIENT`
--

INSERT INTO `CLIENT` (`clientid`, `clientname`, `clientcontactnumber1`, `clientcontactnumber2`, `clientaddressline1`, `clientaddressline2`, `clientaddressline3`, `clientcity`, `clientzipcode`, `clientmailaddress`, `clientmainURL`, `clientnumofservices`, `userid`) VALUES
('bishwaroopm-CLNT-1', 'softnirvana', '8793259479', '', 'A14-1001, Sparklet, Megapolis', 'Hinjewadi Phase III', '', 'Pune', '411057', 'bishwaroopm@sitejinni.com', 'softnirvana.sitejinni.com', 0, 'bishwaroopm'),
('bishwaroopm-CLNT-2', 'home', '8793259479', '', 'A14-1001, Sparklet, Megapolis', 'Hinjewadi Phase III', '', 'Pune', '411057', 'home@sitejinni.com', 'home.sitejinni.com', 0, 'bishwaroopm'),
('bishwaroopm-CLNT-3', 'office', '8793259479', '', 'A14-1001, Sparklet, Megapolis', 'Hinjewadi Phase III', '', 'Pune', '411057', 'office@sitejinni.com', 'office.sitejinni.com', 0, 'bishwaroopm'),
('bishwaroopm-CLNT-4', 'shop', '8793259479', '', 'A14-1001, Sparklet, Megapolis', 'Hinjewadi Phase III', '', 'Pune', '411057', 'shop@sitejinni.com', 'shop.sitejinni.com', 0, 'bishwaroopm');

-- --------------------------------------------------------

--
-- Table structure for table `INDUSTRY`
--

CREATE TABLE `INDUSTRY` (
  `industryid` varchar(10) NOT NULL,
  `industry name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `INDUSTRY`
--

INSERT INTO `INDUSTRY` (`industryid`, `industry name`) VALUES
('EN', 'Entertainment'),
('IN', 'Individual'),
('RE', 'Real Estate');

-- --------------------------------------------------------

--
-- Table structure for table `MICROSITE`
--

CREATE TABLE `MICROSITE` (
  `siteid` varchar(100) CHARACTER SET utf8 NOT NULL,
  `serviceid` varchar(100) CHARACTER SET utf8 NOT NULL,
  `sitename` varchar(256) CHARACTER SET utf8 NOT NULL,
  `siteurl` varchar(256) CHARACTER SET utf8 NOT NULL,
  `sitetemplate` varchar(512) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MICROSITE`
--

INSERT INTO `MICROSITE` (`siteid`, `serviceid`, `sitename`, `siteurl`, `sitetemplate`) VALUES
('bishwaroopm-CLNT-1-1-SITE', 'bishwaroopm-CLNT-1-1', 'softnirvana', 'softnirvana.sitejinni.com', '/docroots/templates/Real Estate/Commercial/REC1'),
('bishwaroopm-CLNT-2-1-SITE', 'bishwaroopm-CLNT-2-1', 'home', 'home.sitejinni.com', '/docroots/templates/Real Estate/Commercial/REC1'),
('bishwaroopm-CLNT-3-1-SITE', 'bishwaroopm-CLNT-3-1', 'office', 'office.sitejinni.com', '/docroots/templates/Real Estate/Commercial/REC1'),
('bishwaroopm-CLNT-4-1-SITE', 'bishwaroopm-CLNT-4-1', 'shop', 'shop.sitejinni.com', '/docroots/templates/Individual/Resume/Ceevee');

-- --------------------------------------------------------

--
-- Table structure for table `SERVICE`
--

CREATE TABLE `SERVICE` (
  `serviceid` varchar(100) CHARACTER SET utf8 NOT NULL,
  `servicetype` int(11) NOT NULL,
  `clientid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `servicename` varchar(250) CHARACTER SET utf8 NOT NULL,
  `servicestartdate` datetime NOT NULL,
  `serviceisactive` bit(1) NOT NULL,
  `servicelastintactdate` datetime NOT NULL,
  `servicelastextactdate` datetime NOT NULL,
  `servicedomain` varchar(250) CHARACTER SET utf8 NOT NULL,
  `serviceissubdomain` bit(1) NOT NULL,
  `servicedetails` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `serviceisfree` bit(1) NOT NULL DEFAULT b'1',
  `isadallowed` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SERVICE`
--

INSERT INTO `SERVICE` (`serviceid`, `servicetype`, `clientid`, `servicename`, `servicestartdate`, `serviceisactive`, `servicelastintactdate`, `servicelastextactdate`, `servicedomain`, `serviceissubdomain`, `servicedetails`, `serviceisfree`, `isadallowed`) VALUES
('bishwaroopm-CLNT-1-1', 1, 'bishwaroopm-CLNT-1', 'Microsite', '2017-08-19 00:00:00', b'1', '2017-08-19 00:00:00', '2017-08-19 00:00:00', 'softnirvana.sitejinni.com', b'1', 'Free Microsite - Self Design Site with Sub Domain', b'1', b'1'),
('bishwaroopm-CLNT-2-1', 1, 'bishwaroopm-CLNT-2', 'Microsite', '2017-08-19 00:00:00', b'1', '2017-08-19 00:00:00', '2017-08-19 00:00:00', 'home.sitejinni.com', b'1', 'Free Microsite - Self Design Site with Sub Domain', b'1', b'1'),
('bishwaroopm-CLNT-3-1', 1, 'bishwaroopm-CLNT-3', 'Microsite', '2017-08-23 00:00:00', b'1', '2017-08-23 00:00:00', '2017-08-23 00:00:00', 'office.sitejinni.com', b'1', 'Free Microsite - Self Design Site with Sub Domain', b'1', b'1'),
('bishwaroopm-CLNT-4-1', 1, 'bishwaroopm-CLNT-4', 'Microsite', '2017-08-26 00:00:00', b'1', '2017-08-26 00:00:00', '2017-08-26 00:00:00', 'shop.sitejinni.com', b'1', 'Free Microsite - Self Design Site with Sub Domain', b'1', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `SERVICETYPE`
--

CREATE TABLE `SERVICETYPE` (
  `servicetypeid` int(11) NOT NULL,
  `servicetypename` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(250) NOT NULL,
  `pricetag` double(4,2) UNSIGNED ZEROFILL NOT NULL,
  `url` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SERVICETYPE`
--

INSERT INTO `SERVICETYPE` (`servicetypeid`, `servicetypename`, `description`, `pricetag`, `url`) VALUES
(1, 'Microsite', 'Free Microsite - Self Design Site with Sub Domain', 0.00, './microsite/selection.php'),
(2, 'Domain', 'Domain Registration - Buy Domain', 0.00, './domain/selection.php'),
(3, 'Digital Marketing', 'Digital Marketing - SEO, Social Networking', 0.00, './digimart/selection.php'),
(4, 'Web Design', 'Full Paid Web Design - Communication of requirements', 0.00, './webdesign/selection.php');

-- --------------------------------------------------------

--
-- Table structure for table `SUBINDUSTRY`
--

CREATE TABLE `SUBINDUSTRY` (
  `subindustryid` varchar(10) NOT NULL,
  `subindustryname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SUBINDUSTRY`
--

INSERT INTO `SUBINDUSTRY` (`subindustryid`, `subindustryname`) VALUES
('AG', 'Agency'),
('AR', 'Architecture'),
('CO', 'Commercial'),
('HO', 'Housing');

-- --------------------------------------------------------

--
-- Table structure for table `SURVEY`
--

CREATE TABLE `SURVEY` (
  `Id` int(11) NOT NULL,
  `personname` varchar(200) NOT NULL,
  `personplace` varchar(300) NOT NULL,
  `professionField` varchar(100) NOT NULL,
  `industryField` varchar(100) NOT NULL,
  `doescreate` bit(1) NOT NULL DEFAULT b'0',
  `creativetypeField` varchar(100) NOT NULL,
  `localreach` bit(1) NOT NULL DEFAULT b'0',
  `cityreach` bit(1) NOT NULL DEFAULT b'0',
  `statereach` bit(1) NOT NULL,
  `nationalreach` bit(1) NOT NULL,
  `globalreach` bit(1) NOT NULL,
  `globalreachTypeField` varchar(100) NOT NULL,
  `needwebsite` bit(1) NOT NULL,
  `wantsmicrosite` bit(1) NOT NULL,
  `wantsfullwebsite` bit(1) NOT NULL,
  `subdomain` bit(1) NOT NULL,
  `fulldomain` bit(1) NOT NULL,
  `diy` bit(1) NOT NULL,
  `diywithtraining` bit(1) NOT NULL,
  `webdesigner` bit(1) NOT NULL,
  `nodiy` bit(1) NOT NULL,
  `nodigimart` bit(1) NOT NULL DEFAULT b'0',
  `digimart` bit(1) NOT NULL DEFAULT b'0',
  `nomarketing` bit(1) NOT NULL DEFAULT b'0',
  `wantads` bit(1) NOT NULL DEFAULT b'0',
  `wantthemedtemplates` bit(1) NOT NULL DEFAULT b'0',
  `norecommend` bit(1) NOT NULL DEFAULT b'0',
  `willrecommendfree` bit(1) NOT NULL DEFAULT b'0',
  `willrecommendall` bit(1) NOT NULL DEFAULT b'0',
  `willrecommendforreturn` bit(1) NOT NULL DEFAULT b'0',
  `cantsay` bit(1) NOT NULL DEFAULT b'0',
  `noadonpage` bit(1) NOT NULL DEFAULT b'0',
  `adonpagefree` bit(1) NOT NULL DEFAULT b'0',
  `adonpagediscount` bit(1) NOT NULL DEFAULT b'0',
  `adonpageprofit` bit(1) NOT NULL DEFAULT b'0',
  `adonpagead` bit(1) NOT NULL DEFAULT b'0',
  `adonpagespace` bit(1) NOT NULL DEFAULT b'0',
  `adonpagedisply` bit(1) NOT NULL DEFAULT b'0',
  `adonpageok` bit(1) NOT NULL DEFAULT b'0',
  `suggestions` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SURVEY`
--

INSERT INTO `SURVEY` (`Id`, `personname`, `personplace`, `professionField`, `industryField`, `doescreate`, `creativetypeField`, `localreach`, `cityreach`, `statereach`, `nationalreach`, `globalreach`, `globalreachTypeField`, `needwebsite`, `wantsmicrosite`, `wantsfullwebsite`, `subdomain`, `fulldomain`, `diy`, `diywithtraining`, `webdesigner`, `nodiy`, `nodigimart`, `digimart`, `nomarketing`, `wantads`, `wantthemedtemplates`, `norecommend`, `willrecommendfree`, `willrecommendall`, `willrecommendforreturn`, `cantsay`, `noadonpage`, `adonpagefree`, `adonpagediscount`, `adonpageprofit`, `adonpagead`, `adonpagespace`, `adonpagedisply`, `adonpageok`, `suggestions`) VALUES
(5, 'Bishwaroop Mukherjee', 'Pune', 'Self Employed', 'IT Enabled Services', b'1', 'Performing Art (dance/music/theatre etc.)', b'1', b'1', b'1', b'1', b'1', 'Social Networks', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', NULL),
(6, 'vikas', 'pune hadapsar', 'Employed', 'Financial', b'1', 'Software/IT Services', b'1', b'1', b'1', b'1', b'1', 'Direct Contacts', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', NULL),
(7, 'vikas', 'pune hadapsar', 'Employed', 'Financial', b'1', 'Software/IT Services', b'1', b'1', b'1', b'1', b'1', 'Direct Contacts', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', NULL),
(8, 'vinay Tripathi', 'Delhi', 'Self Employed', 'Manufacturing', b'1', 'Performing Art (dance/music/theatre etc.)', b'1', b'1', b'1', b'1', b'1', 'Own Website', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', 'teasd adfadfasf sfsaffws fsafsgrhhg sfsfafd adfdf afewf df'),
(9, 'vinay Tripathi', 'Delhi', 'Self Employed', 'Manufacturing', b'1', 'Performing Art (dance/music/theatre etc.)', b'1', b'1', b'1', b'1', b'1', 'Own Website', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', 'teasd adfadfasf sfsaffws fsafsgrhhg sfsfafd adfdf afewf df'),
(10, 'Bishwaroop Mukherjee', 'Pune', 'Self Employed', 'Manufacturing', b'1', 'Visual Art (painting/photography/video/filmmaking etc.)', b'1', b'1', b'1', b'1', b'1', 'Own Website', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', 'sss'),
(11, 'vinay Tripathi', 'Delhi', 'Self Employed', 'Manufacturing', b'1', 'Performing Art (dance/music/theatre etc.)', b'1', b'1', b'1', b'1', b'1', 'Own Website', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', 'teasd adfadfasf sfsaffws fsafsgrhhg sfsfafd adfdf afewf df'),
(12, 'vinay Tripathi', 'Delhi', 'Self Employed', 'Manufacturing', b'1', 'Performing Art (dance/music/theatre etc.)', b'1', b'1', b'1', b'1', b'1', 'Own Website', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', 'teasd adfadfasf sfsaffws fsafsgrhhg sfsfafd adfdf afewf df'),
(13, 'vinay Tripathi', 'Delhi', 'Self Employed', 'Manufacturing', b'1', 'Performing Art (dance/music/theatre etc.)', b'0', b'1', b'0', b'0', b'0', 'Own Website', b'1', b'1', b'0', b'1', b'0', b'0', b'0', b'0', b'1', b'0', b'1', b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'1', b'1', b'1', b'0', b'0', b'0', b'0', b'0', b'1', 'teasd adfadfasf sfsaffws fsafsgrhhg sfsfafd adfdf afewf df'),
(14, 'vinay Tripathi', 'Delhi', 'Self Employed', 'Manufacturing', b'1', 'Performing Art (dance/music/theatre etc.)', b'0', b'1', b'0', b'0', b'0', 'Own Website', b'1', b'1', b'0', b'1', b'0', b'0', b'0', b'0', b'1', b'0', b'1', b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'1', b'1', b'1', b'0', b'0', b'0', b'0', b'0', b'1', 'teasd adfadfasf sfsaffws fsafsgrhhg sfsfafd adfdf afewf df'),
(15, 'ads', 'hghg', 'Employed', 'Manufacturing', b'1', 'Visual Art (painting/photography/video/filmmaking etc.)', b'1', b'1', b'1', b'1', b'1', 'Own Website', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'0', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'0', b'1', 'gfhfhjf'),
(16, 'OmKar Patil', 'Pandharpur', 'Employed', 'Public Sector Services', b'1', 'Software/IT Services', b'1', b'0', b'0', b'1', b'0', 'Own Website', b'0', b'1', b'1', b'0', b'0', b'0', b'0', b'0', b'0', b'1', b'0', b'0', b'1', b'0', b'1', b'0', b'1', b'0', b'1', b'0', b'1', b'0', b'0', b'1', b'1', b'0', b'0', 'oiytfdfj jvkjkjlkhkh jhyiiikhjkb jgjkjkhjkhjhj jjkhjjhjhj '),
(17, '', '', 'Employed', 'Manufacturing', b'0', 'Visual Art (painting/photography/video/filmmaking etc.)', b'0', b'0', b'0', b'0', b'0', 'Own Website', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', ''),
(18, '', '', 'Employed', 'Manufacturing', b'0', 'Visual Art (painting/photography/video/filmmaking etc.)', b'0', b'0', b'0', b'0', b'0', 'Own Website', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', '');

-- --------------------------------------------------------

--
-- Table structure for table `TEMPLATES`
--

CREATE TABLE `TEMPLATES` (
  `templateid` varchar(50) NOT NULL,
  `templatename` text NOT NULL,
  `templateindustry` varchar(50) NOT NULL,
  `templatesubindustry` varchar(50) NOT NULL,
  `templatestyle` varchar(50) NOT NULL,
  `templatepath` longtext NOT NULL,
  `templatedesc` longtext,
  `templatekeys` longtext,
  `templateform` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TEMPLATES`
--

INSERT INTO `TEMPLATES` (`templateid`, `templatename`, `templateindustry`, `templatesubindustry`, `templatestyle`, `templatepath`, `templatedesc`, `templatekeys`, `templateform`) VALUES
('RE-AG-2PSP1-1', 'Real Estate - Agency - 2 Page - Simple - Business Casual', 'RE', 'AG', '2PSP1', '/docroots/templates/Real Estate/Agency/businesscasual/', 'Two Page simple template with enquiry mail allowed. Business Casual style.', 'TWO PAGE;SIMPLE;TEMPLATE;BUSINESS CASUAL;', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `TEMPLATESTYLES`
--

CREATE TABLE `TEMPLATESTYLES` (
  `styleid` varchar(20) NOT NULL,
  `stylename` varchar(256) NOT NULL,
  `styledescription` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TEMPLATESTYLES`
--

INSERT INTO `TEMPLATESTYLES` (`styleid`, `stylename`, `styledescription`) VALUES
('1PENQ1', 'Stylish Single Page', '1 Page with Enquiry Form'),
('1PSP1', 'Unknown', '1 Page Simple'),
('2PSP1', 'Business Casual', '2 Page Simple');

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `userid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `userfirstname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `userlastname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `userpasswd` varchar(512) CHARACTER SET utf8 NOT NULL,
  `usermail` varchar(256) CHARACTER SET utf8 NOT NULL,
  `userbilladdressl1` varchar(256) CHARACTER SET utf8 NOT NULL,
  `userbilladdressl2` varchar(256) DEFAULT NULL,
  `usercity` varchar(100) NOT NULL,
  `userzipcode` varchar(20) CHARACTER SET utf8 NOT NULL,
  `userstate` varchar(100) CHARACTER SET utf8 NOT NULL,
  `usercountry` varchar(100) CHARACTER SET utf8 NOT NULL,
  `userphone1` varchar(12) CHARACTER SET utf8 NOT NULL,
  `ismailverified` bit(1) NOT NULL DEFAULT b'0',
  `isphoneverified` bit(1) NOT NULL DEFAULT b'0',
  `useruniqueidtype` varchar(50) NOT NULL,
  `useruniqueid` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`userid`, `userfirstname`, `userlastname`, `userpasswd`, `usermail`, `userbilladdressl1`, `userbilladdressl2`, `usercity`, `userzipcode`, `userstate`, `usercountry`, `userphone1`, `ismailverified`, `isphoneverified`, `useruniqueidtype`, `useruniqueid`) VALUES
('bishwaroopm', 'Bishwaroop', 'Mukherjee', '$2y$10$Y7YVK/sp6uagssfBRJR9lOf9D2jfHxqcryxOyiozEPEL5K32ZnxCe', 'bishwaroopm@sitejinni.com', 'A14-1001, Sparklet, Megapolis', 'Hinjewadi Phase III', 'Pune', '411057', 'Maharashtra', 'India', '8793259479', b'0', b'0', 'PAN', 'ASGPM8280L');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BILLITEM`
--
ALTER TABLE `BILLITEM`
  ADD PRIMARY KEY (`itemid`),
  ADD KEY `FK_BillItem_CartItem_idx` (`cartitemid`);

--
-- Indexes for table `CART`
--
ALTER TABLE `CART`
  ADD PRIMARY KEY (`cartid`),
  ADD KEY `FK_Cart_User_idx` (`userid`),
  ADD KEY `FK_Cart_Client_idx` (`clientid`);

--
-- Indexes for table `CARTITEM`
--
ALTER TABLE `CARTITEM`
  ADD PRIMARY KEY (`cartitemid`),
  ADD KEY `FK_CartItem_Cart_idx` (`cartid`),
  ADD KEY `FK_CartItem_ServiceType_idx` (`servicetypeid`);

--
-- Indexes for table `CLIENT`
--
ALTER TABLE `CLIENT`
  ADD PRIMARY KEY (`clientid`),
  ADD KEY `fk_client_user` (`userid`);

--
-- Indexes for table `INDUSTRY`
--
ALTER TABLE `INDUSTRY`
  ADD PRIMARY KEY (`industryid`);

--
-- Indexes for table `MICROSITE`
--
ALTER TABLE `MICROSITE`
  ADD PRIMARY KEY (`siteid`),
  ADD KEY `fk_micrisite_service` (`serviceid`);

--
-- Indexes for table `SERVICE`
--
ALTER TABLE `SERVICE`
  ADD PRIMARY KEY (`serviceid`),
  ADD KEY `fk_service_client` (`clientid`),
  ADD KEY `fk_service_servicetype` (`servicetype`);

--
-- Indexes for table `SERVICETYPE`
--
ALTER TABLE `SERVICETYPE`
  ADD PRIMARY KEY (`servicetypeid`);

--
-- Indexes for table `SUBINDUSTRY`
--
ALTER TABLE `SUBINDUSTRY`
  ADD PRIMARY KEY (`subindustryid`);

--
-- Indexes for table `SURVEY`
--
ALTER TABLE `SURVEY`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `TEMPLATES`
--
ALTER TABLE `TEMPLATES`
  ADD PRIMARY KEY (`templateid`),
  ADD KEY `FK_Templates_Industry_idx` (`templateindustry`),
  ADD KEY `FK_Templates_Styles_idx` (`templatestyle`),
  ADD KEY `FK_Templates_SubInd_idx` (`templatesubindustry`);

--
-- Indexes for table `TEMPLATESTYLES`
--
ALTER TABLE `TEMPLATESTYLES`
  ADD PRIMARY KEY (`styleid`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `SERVICETYPE`
--
ALTER TABLE `SERVICETYPE`
  MODIFY `servicetypeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `SURVEY`
--
ALTER TABLE `SURVEY`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `BILLITEM`
--
ALTER TABLE `BILLITEM`
  ADD CONSTRAINT `FK_BillItem_CartItem` FOREIGN KEY (`cartitemid`) REFERENCES `CARTITEM` (`cartitemid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `CART`
--
ALTER TABLE `CART`
  ADD CONSTRAINT `FK_Cart_Client` FOREIGN KEY (`clientid`) REFERENCES `CLIENT` (`clientid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Cart_User` FOREIGN KEY (`userid`) REFERENCES `USER` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `CARTITEM`
--
ALTER TABLE `CARTITEM`
  ADD CONSTRAINT `FK_CartItem_Cart` FOREIGN KEY (`cartid`) REFERENCES `CART` (`cartid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_CartItem_ServiceType` FOREIGN KEY (`servicetypeid`) REFERENCES `SERVICETYPE` (`servicetypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `CLIENT`
--
ALTER TABLE `CLIENT`
  ADD CONSTRAINT `fk_client_user` FOREIGN KEY (`userid`) REFERENCES `USER` (`userid`);

--
-- Constraints for table `MICROSITE`
--
ALTER TABLE `MICROSITE`
  ADD CONSTRAINT `fk_micrisite_service` FOREIGN KEY (`serviceid`) REFERENCES `SERVICE` (`serviceid`);

--
-- Constraints for table `SERVICE`
--
ALTER TABLE `SERVICE`
  ADD CONSTRAINT `fk_service_client` FOREIGN KEY (`clientid`) REFERENCES `CLIENT` (`clientid`),
  ADD CONSTRAINT `fk_service_servicetype` FOREIGN KEY (`servicetype`) REFERENCES `SERVICETYPE` (`servicetypeid`);

--
-- Constraints for table `TEMPLATES`
--
ALTER TABLE `TEMPLATES`
  ADD CONSTRAINT `FK_Templates_Industry` FOREIGN KEY (`templateindustry`) REFERENCES `INDUSTRY` (`industryid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Templates_Styles` FOREIGN KEY (`templatestyle`) REFERENCES `TEMPLATESTYLES` (`STYLEID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Templates_SubInd` FOREIGN KEY (`templatesubindustry`) REFERENCES `SUBINDUSTRY` (`SUBINDUSTRYID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
