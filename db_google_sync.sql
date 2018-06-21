-- phpMyAdmin SQL Dump
-- version 4.7.8
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2018 at 06:53 AM
-- Server version: 5.6.39
-- PHP Version: 7.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_google_sync`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `appointment_id` varchar(15) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `vet_id` int(11) NOT NULL DEFAULT '0',
  `client_id` int(11) NOT NULL DEFAULT '0',
  `pet_id` int(11) NOT NULL DEFAULT '0',
  `appointment_type_id` int(11) NOT NULL COMMENT 'appointment type from appointment type table',
  `appointment_date` date NOT NULL,
  `appointment_slot` varchar(20) DEFAULT NULL,
  `slot_start` varchar(10) NOT NULL COMMENT 'slot start time of an appointment',
  `slot_end` varchar(10) NOT NULL COMMENT 'slot end timw of an appointment',
  `is_sync` tinyint(4) DEFAULT '0' COMMENT '0 = not synced, 1 = synced',
  `google_sync_data` text COMMENT 'return data after google sync',
  `notify_email` tinyint(4) DEFAULT NULL,
  `notify_sms` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '''1''=''Requested'',''2''=''Approved'',''3''=''Cancelled'',''4''=''Rescheduled'', 5 = completed',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `appointment_id`, `title`, `description`, `vet_id`, `client_id`, `pet_id`, `appointment_type_id`, `appointment_date`, `appointment_slot`, `slot_start`, `slot_end`, `is_sync`, `google_sync_data`, `notify_email`, `notify_sms`, `status`, `created`, `modified`) VALUES
(98, '3965b239e1300a6', 'Test1', NULL, 12536, 21, 25, 4, '2018-06-22', NULL, '7:20', '07:30', 0, '{\"kind\":\"calendar#event\",\"etag\":\"\\\"3058620730848000\\\"\",\"id\":\"soiab5s3slknhiosl1pg6o03v8\",\"status\":\"confirmed\",\"htmlLink\":\"https:\\/\\/www.google.com\\/calendar\\/event?eid=c29pYWI1czNzbGtuaGlvc2wxcGc2bzAzdjggY29vbHRlYW01NzNAbQ\",\"created\":\"2018-06-18T08:26:05.000Z\",\"updated\":\"2018-06-18T08:26:05.424Z\",\"summary\":\"Test1\",\"creator\":{\"email\":\"coolteam573@gmail.com\",\"displayName\":\"Cool Team\",\"self\":\"true\"},\"organizer\":{\"email\":\"coolteam573@gmail.com\",\"displayName\":\"Cool Team\",\"self\":\"true\"},\"start\":{\"dateTime\":\"2018-06-20T07:20:00+02:00\",\"timeZone\":\"Europe\\/Paris\"},\"end\":{\"dateTime\":\"2018-06-20T07:30:00+02:00\",\"timeZone\":\"Europe\\/Paris\"},\"iCalUID\":\"soiab5s3slknhiosl1pg6o03v8@google.com\",\"sequence\":\"0\",\"reminders\":{\"useDefault\":\"true\"},\"result\":{\"kind\":\"calendar#event\",\"etag\":\"\\\"3058620730848000\\\"\",\"id\":\"soiab5s3slknhiosl1pg6o03v8\",\"status\":\"confirmed\",\"htmlLink\":\"https:\\/\\/www.google.com\\/calendar\\/event?eid=c29pYWI1czNzbGtuaGlvc2wxcGc2bzAzdjggY29vbHRlYW01NzNAbQ\",\"created\":\"2018-06-18T08:26:05.000Z\",\"updated\":\"2018-06-18T08:26:05.424Z\",\"summary\":\"Test1\",\"creator\":{\"email\":\"coolteam573@gmail.com\",\"displayName\":\"Cool Team\",\"self\":\"true\"},\"organizer\":{\"email\":\"coolteam573@gmail.com\",\"displayName\":\"Cool Team\",\"self\":\"true\"},\"start\":{\"dateTime\":\"2018-06-20T07:20:00+02:00\",\"timeZone\":\"Europe\\/Paris\"},\"end\":{\"dateTime\":\"2018-06-20T07:30:00+02:00\",\"timeZone\":\"Europe\\/Paris\"},\"iCalUID\":\"soiab5s3slknhiosl1pg6o03v8@google.com\",\"sequence\":\"0\",\"reminders\":{\"useDefault\":\"true\"}}}', NULL, NULL, 2, '2018-06-16 11:08:02', '2018-06-18 08:25:58'),
(99, '8725b24b67a9edc', 'Test2', NULL, 12536, 21, 25, 5, '2018-06-21', NULL, '7:20', '07:30', 0, '{\"kind\":\"calendar#event\",\"etag\":\"\\\"3058620730182000\\\"\",\"id\":\"0r34fn9220mkivmpjoh99h75n4\",\"status\":\"confirmed\",\"htmlLink\":\"https:\\/\\/www.google.com\\/calendar\\/event?eid=MHIzNGZuOTIyMG1raXZtcGpvaDk5aDc1bjQgY29vbHRlYW01NzNAbQ\",\"created\":\"2018-06-18T08:26:05.000Z\",\"updated\":\"2018-06-18T08:26:05.091Z\",\"summary\":\"Test2\",\"creator\":{\"email\":\"coolteam573@gmail.com\",\"displayName\":\"Cool Team\",\"self\":\"true\"},\"organizer\":{\"email\":\"coolteam573@gmail.com\",\"displayName\":\"Cool Team\",\"self\":\"true\"},\"start\":{\"dateTime\":\"2018-06-19T07:20:00+02:00\",\"timeZone\":\"Europe\\/Paris\"},\"end\":{\"dateTime\":\"2018-06-19T07:30:00+02:00\",\"timeZone\":\"Europe\\/Paris\"},\"iCalUID\":\"0r34fn9220mkivmpjoh99h75n4@google.com\",\"sequence\":\"0\",\"reminders\":{\"useDefault\":\"true\"},\"result\":{\"kind\":\"calendar#event\",\"etag\":\"\\\"3058620730182000\\\"\",\"id\":\"0r34fn9220mkivmpjoh99h75n4\",\"status\":\"confirmed\",\"htmlLink\":\"https:\\/\\/www.google.com\\/calendar\\/event?eid=MHIzNGZuOTIyMG1raXZtcGpvaDk5aDc1bjQgY29vbHRlYW01NzNAbQ\",\"created\":\"2018-06-18T08:26:05.000Z\",\"updated\":\"2018-06-18T08:26:05.091Z\",\"summary\":\"Test2\",\"creator\":{\"email\":\"coolteam573@gmail.com\",\"displayName\":\"Cool Team\",\"self\":\"true\"},\"organizer\":{\"email\":\"coolteam573@gmail.com\",\"displayName\":\"Cool Team\",\"self\":\"true\"},\"start\":{\"dateTime\":\"2018-06-19T07:20:00+02:00\",\"timeZone\":\"Europe\\/Paris\"},\"end\":{\"dateTime\":\"2018-06-19T07:30:00+02:00\",\"timeZone\":\"Europe\\/Paris\"},\"iCalUID\":\"0r34fn9220mkivmpjoh99h75n4@google.com\",\"sequence\":\"0\",\"reminders\":{\"useDefault\":\"true\"}}}', NULL, NULL, 2, '2018-06-16 07:04:26', '2018-06-18 08:25:58');

-- --------------------------------------------------------

--
-- Table structure for table `vets`
--

CREATE TABLE `vets` (
  `id` int(11) NOT NULL,
  `finstackUserId` varchar(255) DEFAULT NULL,
  `urlname` varchar(255) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `maiden_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_salt` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `licence` varchar(255) DEFAULT NULL,
  `bio` text,
  `picture` varchar(255) DEFAULT NULL,
  `spoken_languages` varchar(255) DEFAULT NULL,
  `study` varchar(255) DEFAULT NULL,
  `practical_information` varchar(255) DEFAULT NULL,
  `means_of_payment` varchar(255) DEFAULT NULL,
  `association` varchar(255) DEFAULT NULL,
  `other_information` text,
  `street_address` text,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `type` enum('nonregistered','free','plus','premium') DEFAULT 'nonregistered' COMMENT '''nonregistered'',''free'',''plus'',''premium''',
  `clinic_id` int(11) NOT NULL DEFAULT '0' COMMENT 'associated clinic id else 0',
  `speciality` varchar(255) DEFAULT NULL,
  `personal_address` text,
  `clinic` text NOT NULL,
  `professionnal_address` text,
  `address2` text,
  `vet_speciality` varchar(255) DEFAULT NULL,
  `promocode` varchar(255) NOT NULL,
  `approve` set('1','0') DEFAULT '1' COMMENT '1 = Auto Approve,0 => Not Auto Approve',
  `other_functions` varchar(255) DEFAULT NULL,
  `mobile_phone` varchar(20) DEFAULT NULL,
  `fax_number` varchar(255) DEFAULT NULL,
  `direct_contact` text,
  `status` int(5) NOT NULL DEFAULT '0' COMMENT '0 = inactive. 1 = approve, 2 = new created from register table, 3 = enable, i.e. vet created password from emailed link',
  `credential_send` set('1','0','2') DEFAULT '0' COMMENT '1 = sent approval link, 2 = approval link used',
  `last_login` datetime DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `clinicname` varchar(255) NOT NULL,
  `dist` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Vet Table';

--
-- Dumping data for table `vets`
--

INSERT INTO `vets` (`id`, `finstackUserId`, `urlname`, `fname`, `lname`, `maiden_name`, `email`, `password`, `password_salt`, `class`, `licence`, `bio`, `picture`, `spoken_languages`, `study`, `practical_information`, `means_of_payment`, `association`, `other_information`, `street_address`, `city`, `state`, `zipcode`, `phone_number`, `type`, `clinic_id`, `speciality`, `personal_address`, `clinic`, `professionnal_address`, `address2`, `vet_speciality`, `promocode`, `approve`, `other_functions`, `mobile_phone`, `fax_number`, `direct_contact`, `status`, `credential_send`, `last_login`, `activation_code`, `latitude`, `longitude`, `token`, `created_at`, `updated_at`, `clinicname`, `dist`) VALUES
(12536, 'eef03893-1935-4512-9514-47c218c5f2f9', 'coolteam', 'Cool', 'Team', NULL, 'coolteam573@gmail.com', '0bff70d03b100fcf4a3faef9c49ca86573e4cd79c661d340802b9b2bb8417f9a86795e63085f9d698f262b0922c855ffc3ed5f38035bae0da3b638bf746891cc', 'asdf', '', '85667', 'Des spécialistes en Cardiologie, en Imagerie, en Chirurgie Orthopédique et des Tissus Mous se joignent à nous pour vous apporter le service le plus attentif au bien être de votre animal.\r\ncategories', NULL, 'Français, Anglais,', 'BAC+8', 'Venez avec votre animal !', 'CB, Liquide', 'Rotary', 'Psycho animal', '2 Rue Henri barbusse', 'Rueil Malmaison', NULL, '92500', '0648272688', 'premium', 0, '1,2', '2 Rue Henri barbusse', '', '1 rue colette', '', '12,13,14,16,17', '', '1', 'Garde animal', '0648272688', '', '0648272688', 1, '2', '2016-08-20 14:39:57', NULL, '48.8646770', '2.1901373', '56bd27c023a4a8d1b0127810e1899d96', '2016-08-20 14:38:42', '2018-01-03 13:04:06', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `vet_calendar`
--

CREATE TABLE `vet_calendar` (
  `id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `google_user_id` varchar(64) NOT NULL,
  `google_auth_data` text NOT NULL,
  `calendar_id` varchar(64) NOT NULL,
  `calendar_auth_data` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vet_calendar`
--

INSERT INTO `vet_calendar` (`id`, `vet_id`, `google_user_id`, `google_auth_data`, `calendar_id`, `calendar_auth_data`, `created`, `modified`) VALUES
(16, 12536, '118323977285784439237', '{\"kind\":\"plus#person\",\"etag\":\"\\\"RKS4-q7QGL10FxltAebpjqjKQR0\\/75_AIM69ma5W4RhV5eu8rw-AAb0\\\"\",\"objectType\":\"person\",\"id\":\"118323977285784439237\",\"displayName\":\"Cool Team\",\"name\":{\"familyName\":\"Team\",\"givenName\":\"Cool\"},\"url\":\"https:\\/\\/plus.google.com\\/118323977285784439237\",\"image\":{\"url\":\"https:\\/\\/lh4.googleusercontent.com\\/-n82XNFr9KsE\\/AAAAAAAAAAI\\/AAAAAAAAAAA\\/AB6qoq2Izw8ADZotI8CLWnGWJR2PkWhMDA\\/mo\\/photo.jpg?sz=50\",\"isDefault\":\"true\"},\"isPlusUser\":\"true\",\"circledByCount\":\"0\",\"verified\":\"false\",\"result\":{\"kind\":\"plus#person\",\"etag\":\"\\\"RKS4-q7QGL10FxltAebpjqjKQR0\\/75_AIM69ma5W4RhV5eu8rw-AAb0\\\"\",\"objectType\":\"person\",\"id\":\"118323977285784439237\",\"displayName\":\"Cool Team\",\"name\":{\"familyName\":\"Team\",\"givenName\":\"Cool\"},\"url\":\"https:\\/\\/plus.google.com\\/118323977285784439237\",\"image\":{\"url\":\"https:\\/\\/lh4.googleusercontent.com\\/-n82XNFr9KsE\\/AAAAAAAAAAI\\/AAAAAAAAAAA\\/AB6qoq2Izw8ADZotI8CLWnGWJR2PkWhMDA\\/mo\\/photo.jpg?sz=50\",\"isDefault\":\"true\"},\"isPlusUser\":\"true\",\"circledByCount\":\"0\",\"verified\":\"false\"}}', 'coolteam573@gmail.com', '{\"kind\":\"calendar#calendarListEntry\",\"etag\":\"\\\"1513590902237000\\\"\",\"id\":\"coolteam573@gmail.com\",\"summary\":\"coolteam573@gmail.com\",\"timeZone\":\"Europe\\/Paris\",\"colorId\":\"3\",\"backgroundColor\":\"#f83a22\",\"foregroundColor\":\"#000000\",\"selected\":\"true\",\"accessRole\":\"owner\",\"defaultReminders\":[{\"method\":\"popup\",\"minutes\":\"30\"}],\"notificationSettings\":{\"notifications\":[{\"type\":\"eventCreation\",\"method\":\"email\"},{\"type\":\"eventChange\",\"method\":\"email\"},{\"type\":\"eventCancellation\",\"method\":\"email\"},{\"type\":\"eventResponse\",\"method\":\"email\"},{\"type\":\"agenda\",\"method\":\"email\"}]},\"primary\":\"true\",\"conferenceProperties\":{\"allowedConferenceSolutionTypes\":[\"eventHangout\"]}}', '2018-06-16 07:41:27', '2018-06-16 07:45:33'),
(17, 12536, '100768592124347280259', '{\"kind\":\"plus#person\",\"etag\":\"\\\"RKS4-q7QGL10FxltAebpjqjKQR0\\/qMZXFvSY_3CZn-i9nnwY4uU_xeY\\\"\",\"gender\":\"male\",\"urls\":[{\"value\":\"http:\\/\\/billwilliamsrealty.com\",\"type\":\"contributor\",\"label\":\"billwilliamsrealty.com\"}],\"objectType\":\"person\",\"id\":\"100768592124347280259\",\"displayName\":\"syn a\",\"name\":{\"familyName\":\"a\",\"givenName\":\"syn\"},\"url\":\"https:\\/\\/plus.google.com\\/100768592124347280259\",\"image\":{\"url\":\"https:\\/\\/lh6.googleusercontent.com\\/-5cbv8-D6j_Y\\/AAAAAAAAAAI\\/AAAAAAAAAAA\\/AB6qoq3fwBoRC0Vk7lputHx41753DM3Ybw\\/mo\\/photo.jpg?sz=50\",\"isDefault\":\"true\"},\"isPlusUser\":\"true\",\"circledByCount\":\"3\",\"verified\":\"false\",\"result\":{\"kind\":\"plus#person\",\"etag\":\"\\\"RKS4-q7QGL10FxltAebpjqjKQR0\\/qMZXFvSY_3CZn-i9nnwY4uU_xeY\\\"\",\"gender\":\"male\",\"urls\":[{\"value\":\"http:\\/\\/billwilliamsrealty.com\",\"type\":\"contributor\",\"label\":\"billwilliamsrealty.com\"}],\"objectType\":\"person\",\"id\":\"100768592124347280259\",\"displayName\":\"syn a\",\"name\":{\"familyName\":\"a\",\"givenName\":\"syn\"},\"url\":\"https:\\/\\/plus.google.com\\/100768592124347280259\",\"image\":{\"url\":\"https:\\/\\/lh6.googleusercontent.com\\/-5cbv8-D6j_Y\\/AAAAAAAAAAI\\/AAAAAAAAAAA\\/AB6qoq3fwBoRC0Vk7lputHx41753DM3Ybw\\/mo\\/photo.jpg?sz=50\",\"isDefault\":\"true\"},\"isPlusUser\":\"true\",\"circledByCount\":\"3\",\"verified\":\"false\"}}', 'synapse979@gmail.com', '{\"kind\":\"calendar#calendarListEntry\",\"etag\":\"\\\"1501073989559000\\\"\",\"id\":\"synapse979@gmail.com\",\"summary\":\"synapse979@gmail.com\",\"location\":\"India\",\"timeZone\":\"Asia\\/Calcutta\",\"colorId\":\"17\",\"backgroundColor\":\"#9a9cff\",\"foregroundColor\":\"#000000\",\"selected\":\"true\",\"accessRole\":\"owner\",\"defaultReminders\":[{\"method\":\"popup\",\"minutes\":\"30\"}],\"notificationSettings\":{\"notifications\":[{\"type\":\"eventCreation\",\"method\":\"email\"},{\"type\":\"eventChange\",\"method\":\"email\"},{\"type\":\"eventCancellation\",\"method\":\"email\"},{\"type\":\"eventResponse\",\"method\":\"email\"}]},\"primary\":\"true\",\"conferenceProperties\":{\"allowedConferenceSolutionTypes\":[\"eventHangout\"]}}', '2018-06-16 09:17:46', '2018-06-16 09:19:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointment_id` (`appointment_id`);
ALTER TABLE `appointments` ADD FULLTEXT KEY `title` (`title`);

--
-- Indexes for table `vet_calendar`
--
ALTER TABLE `vet_calendar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `vet_calendar`
--
ALTER TABLE `vet_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
