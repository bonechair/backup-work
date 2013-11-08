-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2013 at 04:59 AM
-- Server version: 5.1.72
-- PHP Version: 5.3.2-1ubuntu4.21

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `five`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert`
--

CREATE TABLE IF NOT EXISTS `alert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `show_alert` enum('yes','no') NOT NULL DEFAULT 'no',
  `date_set` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `alert`
--

INSERT INTO `alert` (`id`, `text`, `show_alert`, `date_set`) VALUES
(1, 'Please join and add more jobs we need the support', 'no', '8, 11, 2013');

-- --------------------------------------------------------

--
-- Table structure for table `attatchments`
--

CREATE TABLE IF NOT EXISTS `attatchments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` varchar(25) NOT NULL,
  `receiver_id` varchar(100) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `filepath` varchar(100) NOT NULL,
  `date` varchar(20) NOT NULL,
  `ip` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `attatchments`
--


-- --------------------------------------------------------

--
-- Table structure for table `buyer_feedback`
--

CREATE TABLE IF NOT EXISTS `buyer_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `rating` enum('images/positive.png','images/neutral.png','images/negative.png') NOT NULL,
  `text` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `buyer_feedback`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `catid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catname` varchar(255) NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catid`, `catname`) VALUES
(1, 'Gift-Ideas'),
(2, 'Travel'),
(3, 'Fun-and-Bizarre'),
(4, 'Writing'),
(5, 'Graphics'),
(6, 'Video'),
(7, 'Misc'),
(8, 'Other'),
(9, 'Advertising'),
(10, 'Music-and-Audio'),
(11, 'Business'),
(12, 'Technology'),
(13, 'Silly-Stuff'),
(14, 'Spiritual'),
(15, 'Programming'),
(16, 'SEO'),
(17, 'Link Building'),
(18, 'Webdesign'),
(19, 'Wordpress');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `faqs` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `faqs`) VALUES
(1, 'This is where you put your faq''s.\r\nThis page can be edited in the admin panel.');

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE IF NOT EXISTS `help` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `help` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `help`
--

INSERT INTO `help` (`id`, `help`) VALUES
(1, 'This is where you put your help topics.\r\nThis page can be edited in the admin panel.');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `willdo` varchar(250) NOT NULL,
  `username` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `job_cost` int(5) NOT NULL,
  `link` varchar(100) NOT NULL,
  `video_link` varchar(150) NOT NULL DEFAULT 'None',
  `job_description` text NOT NULL,
  `part_description` varchar(85) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `time_span` int(20) NOT NULL,
  `img_path` varchar(250) NOT NULL,
  `postdate` varchar(100) NOT NULL,
  `approved` enum('No','Yes') NOT NULL DEFAULT 'No',
  `times_bought` int(10) NOT NULL,
  `times_viewed` int(20) NOT NULL DEFAULT '0',
  `pos_feed` int(15) NOT NULL,
  `featured` enum('yes','no') NOT NULL DEFAULT 'no',
  `voteup` int(11) NOT NULL,
  `votedown` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `willdo`, `username`, `category`, `job_cost`, `link`, `video_link`, `job_description`, `part_description`, `keywords`, `time_span`, `img_path`, `postdate`, `approved`, `times_bought`, `times_viewed`, `pos_feed`, `featured`, `voteup`, `votedown`) VALUES
(1, 'help you with wordpress for 2 hours   ', 'bonechair', 'Wordpress', 5, '', 'http://www.youtube.com/v/L8axQ17lTko', 'Im am very good at what I do and trustworthy', 'Im am very good at what I do and trustworthy', 'wordpress', 1, 'users/bonechair/203354032.jpg', '8-11-2013', 'Yes', 0, 2, 0, 'yes', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_bought`
--

CREATE TABLE IF NOT EXISTS `jobs_bought` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(10) NOT NULL,
  `willdo` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `seller_username` varchar(100) NOT NULL,
  `accepted` enum('yes','no') NOT NULL DEFAULT 'no',
  `feedback_left` enum('yes','no') NOT NULL DEFAULT 'no',
  `date` varchar(20) NOT NULL,
  `payment_confirmed` enum('yes','no') NOT NULL DEFAULT 'no',
  `job_completed` enum('yes','no') NOT NULL DEFAULT 'no',
  `rejected` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `jobs_bought`
--


-- --------------------------------------------------------

--
-- Table structure for table `jobs_sold`
--

CREATE TABLE IF NOT EXISTS `jobs_sold` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(10) NOT NULL,
  `willdo` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `buyer_username` varchar(100) NOT NULL,
  `accepted` enum('yes','no') NOT NULL DEFAULT 'no',
  `feedback_left` enum('yes','no') NOT NULL DEFAULT 'no',
  `date` varchar(20) NOT NULL,
  `payment_confirmed` enum('yes','no') NOT NULL DEFAULT 'no',
  `rejected` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `jobs_sold`
--


-- --------------------------------------------------------

--
-- Table structure for table `job_communication`
--

CREATE TABLE IF NOT EXISTS `job_communication` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `job_id` int(10) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `text` varchar(255) NOT NULL,
  `postdate` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `job_communication`
--


-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` text NOT NULL,
  `abb` text NOT NULL,
  `flag_image` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `abb`, `flag_image`, `status`) VALUES
(1, 'english', 'en', '<img src=''../flags/1302939389en.png'' alt=''english'' title=''english'' border=''0''>&nbsp;', 'active'),
(2, 'spanish', 'es', '<img src=''../flags/1305279459es.png'' alt=''spanish'' title=''spanish'' border=''0''>&nbsp;', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `job_id` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `likes`
--


-- --------------------------------------------------------

--
-- Table structure for table `logintable`
--

CREATE TABLE IF NOT EXISTS `logintable` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `logintable`
--

INSERT INTO `logintable` (`id`, `user_name`, `password`) VALUES
(1, 'admin', 'c90bceb4c796bc4c5d8caae89f04915c');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fbid` varchar(25) NOT NULL DEFAULT 'no',
  `twit_user` varchar(100) NOT NULL DEFAULT 'No',
  `username` varchar(16) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(40) NOT NULL DEFAULT '',
  `ppemail` varchar(100) NOT NULL,
  `joined` varchar(40) NOT NULL DEFAULT '',
  `full_name` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `msn` varchar(100) NOT NULL,
  `about` varchar(500) NOT NULL,
  `img_path` varchar(250) NOT NULL DEFAULT 'default.png',
  `isp` varchar(300) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `activationkey` varchar(255) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `isbanned` varchar(5) NOT NULL DEFAULT 'No',
  `status` varchar(100) NOT NULL DEFAULT '',
  `online` varchar(16) NOT NULL DEFAULT '',
  `level` varchar(11) NOT NULL DEFAULT '1',
  `my_jobs` varchar(250) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pos_feed` int(15) NOT NULL,
  `neut_feed` int(15) NOT NULL,
  `neg_feed` int(15) NOT NULL,
  `logged_in` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `fbid`, `twit_user`, `username`, `password`, `email`, `ppemail`, `joined`, `full_name`, `country`, `msn`, `about`, `img_path`, `isp`, `ip`, `timezone`, `activationkey`, `passkey`, `isbanned`, `status`, `online`, `level`, `my_jobs`, `balance`, `pos_feed`, `neut_feed`, `neg_feed`, `logged_in`) VALUES
(2, 'no', 'No', 'bonechair', 'c90bceb4c796bc4c5d8caae89f04915c', 'lightsites@gmail.com', 'lightsites@gmail.com', 'November 8, 2013', 'Louis Christian Stoltz', 'South Africa', '', 'Im a website programmer for 10 years. Interested in Forex trading and healing people.', '391666278.jpg', 'access.mtnbusiness.co.za', '105.236.158.94', '', '', '', 'No', 'activated', '', '1', '', '0.00', 0, 0, 0, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `messages_all`
--

CREATE TABLE IF NOT EXISTS `messages_all` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sender_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `subject` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `message` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `messages_all`
--


-- --------------------------------------------------------

--
-- Table structure for table `messages_received`
--

CREATE TABLE IF NOT EXISTS `messages_received` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sender_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `subject` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `message` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filepath` varchar(200) NOT NULL,
  `date` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `message_read` enum('yes','no') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `messages_received`
--


-- --------------------------------------------------------

--
-- Table structure for table `messages_sent`
--

CREATE TABLE IF NOT EXISTS `messages_sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `receiver_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `subject` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `message` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `messages_sent`
--


-- --------------------------------------------------------

--
-- Table structure for table `payment_request`
--

CREATE TABLE IF NOT EXISTS `payment_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `amount` varchar(8) NOT NULL,
  `date_requested` varchar(30) NOT NULL,
  `date_paid` varchar(30) NOT NULL,
  `status` enum('paid','unpaid') NOT NULL DEFAULT 'unpaid',
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `payment_request`
--


-- --------------------------------------------------------

--
-- Table structure for table `paypal_payment_info`
--

CREATE TABLE IF NOT EXISTS `paypal_payment_info` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `itemname` varchar(100) NOT NULL DEFAULT '',
  `itemnumber` int(10) DEFAULT NULL,
  `postdate` varchar(10) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `mc_gross` varchar(6) NOT NULL DEFAULT '',
  `paymentstatus` varchar(15) NOT NULL DEFAULT '',
  `txnid` varchar(30) NOT NULL DEFAULT '',
  `pendingreason` varchar(10) DEFAULT NULL,
  `tax` varchar(10) DEFAULT NULL,
  `buyer_username` varchar(255) NOT NULL DEFAULT '',
  `seller_username` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `paypal_payment_info`
--


-- --------------------------------------------------------

--
-- Table structure for table `privacy`
--

CREATE TABLE IF NOT EXISTS `privacy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `privacy` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `privacy`
--

INSERT INTO `privacy` (`id`, `privacy`) VALUES
(1, 'What information do we collect?\r\n\r\nWe collect information from you when you register on our site or place an order.\r\nWhen ordering or registering on our site, as appropriate, you may be asked to enter your: name, e-mail address or mailing address. You may, however, visit our site anonymously.\r\nLike most websites, we use cookies and/or web beacons to enhance your experience, gather general visitor information, and track visits to our website.\r\n\r\nPlease refer to the ''do we use cookies?'' section below for information about cookies and how we use them.\r\nWhat do we use your information for?\r\n\r\nAny of the information we collect from you may be used in one of the following ways:\r\n\r\n* To personalize your experience\r\n(your information helps us to better respond to your individual needs)\r\n\r\n* To improve our website\r\n(we continually strive to improve our website offerings based on the information and feedback we receive from you)\r\n\r\n* To improve customer service\r\n(your information helps us to more effectively respond to your customer service requests and support needs)\r\n\r\n* To process transactions\r\n\r\nYour information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.\r\n\r\n* To send periodic emails\r\n\r\nThe email address you provide for order processing, will only be used to send you information and updates pertaining to your order.\r\nAfter a transaction, your private information (credit cards, social security numbers, financials, etc.) will not be stored on our servers.\r\n\r\nDo we use cookies?\r\n\r\nYes (Cookies are small files that a site or its service provider transfers to your computers hard drive through your Web browser (if you allow) that enables the sites or service providers systems to recognize your browser and capture and remember certain information.\r\nWe use cookies to help us remember and process the items in your shopping cart, understand and save your preferences for future visits, keep track of advertisements and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.\r\n\r\nDo we disclose any information to outside parties?\r\n\r\nWe do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.\r\n\r\nThird party links\r\n\r\nOccasionally, at our discretion, we may include or offer third party products or services on our website. These third party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.\r\n\r\nCalifornia Online Privacy Protection Act Compliance\r\n\r\nBecause we value your privacy we have taken the necessary precautions to be in compliance with the California Online Privacy Protection Act. We therefore will not distribute your personal information to outside parties without your consent.\r\n\r\nChildrens Online Privacy Protection Act Compliance\r\n\r\nWe are in compliance with the requirements of COPPA (Childrens Online Privacy Protection Act), we do not collect any information from anyone under 13 years of age. Our website, products and services are all directed to people who are at least 13 years old or older.\r\n\r\nYour Consent\r\n\r\nBy using our site, you consent to our websites privacy policy.\r\nChanges to our Privacy Policy\r\n\r\nIf we decide to change our privacy policy, we will post those changes on this page, and/or update the Privacy Policy modification date below.\r\n\r\nThis policy was last modified on 09/12/2010');

-- --------------------------------------------------------

--
-- Table structure for table `searches`
--

CREATE TABLE IF NOT EXISTS `searches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `searchterm` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `searches`
--

INSERT INTO `searches` (`id`, `searchterm`) VALUES
(1, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `seller_feedback`
--

CREATE TABLE IF NOT EXISTS `seller_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `rating` enum('images/positive.png','images/neutral.png','images/negative.png') NOT NULL,
  `text` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `seller_feedback`
--


-- --------------------------------------------------------

--
-- Table structure for table `sitesettings`
--

CREATE TABLE IF NOT EXISTS `sitesettings` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_url` varchar(100) NOT NULL,
  `domain` varchar(100) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `keywords` varchar(250) DEFAULT NULL,
  `price` varchar(10) NOT NULL,
  `fee` varchar(10) NOT NULL,
  `featured_fee` varchar(10) NOT NULL DEFAULT '0.3',
  `min_balance` varchar(10) NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `site_email` varchar(100) NOT NULL,
  `apikey` varchar(100) NOT NULL,
  `apisecret` varchar(100) NOT NULL,
  `twitter_key` varchar(100) NOT NULL,
  `twitter_sec` varchar(100) NOT NULL,
  `oauthkey` varchar(100) NOT NULL,
  `oauthsecret` varchar(100) NOT NULL,
  `pubid` varchar(100) NOT NULL,
  `google_channel` varchar(100) NOT NULL,
  `google_ads` enum('yes','no') NOT NULL DEFAULT 'no',
  `ppemail` varchar(250) NOT NULL,
  `alertpay_email` varchar(100) NOT NULL,
  `ipn_security_code` varchar(100) NOT NULL,
  `twitter_username` varchar(100) NOT NULL,
  `mod_job` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `feat_num` int(11) NOT NULL DEFAULT '5',
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `currency_symbol` varchar(10) NOT NULL DEFAULT '$',
  `tweet` enum('yes','no') NOT NULL,
  `lang` varchar(100) NOT NULL DEFAULT 'english',
  `price_range` varchar(500) NOT NULL,
  `dropdown` enum('yes','no') NOT NULL DEFAULT 'yes',
  `latest_tweets` enum('yes','no') NOT NULL DEFAULT 'yes',
  `suggestions` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_alert` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sitesettings`
--

INSERT INTO `sitesettings` (`config_id`, `site_url`, `domain`, `description`, `keywords`, `price`, `fee`, `featured_fee`, `min_balance`, `tagline`, `slogan`, `site_email`, `apikey`, `apisecret`, `twitter_key`, `twitter_sec`, `oauthkey`, `oauthsecret`, `pubid`, `google_channel`, `google_ads`, `ppemail`, `alertpay_email`, `ipn_security_code`, `twitter_username`, `mod_job`, `feat_num`, `currency`, `currency_symbol`, `tweet`, `lang`, `price_range`, `dropdown`, `latest_tweets`, `suggestions`, `show_alert`) VALUES
(1, 'http://five.triplegood.co.za', 'five.triplegood.co.za', '', '', '', '20', '30', '50', 'What are you willing to do for $5', '', 'lightsites@gmail.com', '660595123971970', '9889c14d3846159956d792e152f38ef3', '', '', '', '', '', '', 'no', 'lightsites@gmail.com', '', '', '', 'No', 5, 'USD', '$', 'yes', 'en', '5', 'no', 'no', 'yes', '');

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE IF NOT EXISTS `suggestions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `text` varchar(255) NOT NULL,
  `postdate` varchar(20) NOT NULL,
  `active` tinyint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `suggestions`
--

INSERT INTO `suggestions` (`id`, `username`, `text`, `postdate`, `active`) VALUES
(1, 'bonechair', 'Someone that can help with SEO of website', '8, 11, 2013', 1),
(2, 'bonechair', 'test', '8, 11, 2013', 0),
(5, 'bonechair', 'test', '8, 11, 2013', 0);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `terms` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `terms`) VALUES
(1, 'This is where you put your terms and conditions.\r\nThis page is edited in the admin panel');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `article_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `votes`
--

