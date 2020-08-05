-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 05, 2020 at 08:30 AM
-- Server version: 5.6.35
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sr11apm4_wp926`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_level`
--

CREATE TABLE `access_level` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `access` enum('0','1','2','3','4','5','6','7','8','9','10') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addinfo_tb`
--

CREATE TABLE `addinfo_tb` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `addinfo` text,
  `spinstruct` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `adminusers`
--

CREATE TABLE `adminusers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT '',
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `lastlogin` varchar(100) DEFAULT NULL,
  `logincount` int(11) DEFAULT NULL,
  `datecr` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userlevel` int(11) DEFAULT NULL,
  `activated` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminusers`
--

INSERT INTO `adminusers` (`id`, `fullname`, `email`, `username`, `password`, `lastlogin`, `logincount`, `datecr`, `userlevel`, `activated`) VALUES
(2, 'Super Admin', 'admin@tisvdigital.com', 'admin', 'default2012', '20-07-2014 13:45:21', 558, '2015-06-01 11:23:16', -1, 'Y'),
(3, NULL, '', NULL, NULL, NULL, NULL, '2020-02-19 13:59:49', NULL, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `alt_beneficiary`
--

CREATE TABLE `alt_beneficiary` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `childid` varchar(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assets_legacy`
--

CREATE TABLE `assets_legacy` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `legacy` varchar(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assets_tb`
--

CREATE TABLE `assets_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `asset_type` text,
  `property_location` text,
  `property_type` text,
  `property_registered` text,
  `shares_company` text,
  `shares_volume` text,
  `shares_percent` text,
  `shares_cscs` text,
  `shares_chn` varchar(100) DEFAULT NULL,
  `insurance_company` text,
  `insurance_type` text,
  `insurance_owner` text,
  `insurance_facevalue` text,
  `bvn` text,
  `account_name` text,
  `account_no` text,
  `bankname` text,
  `accounttype` text,
  `pension_name` text,
  `pension_owner` text,
  `pension_plan` text,
  `rsano` text,
  `pension_admin` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `investment_type` varchar(20) DEFAULT NULL,
  `investment_account` varchar(100) DEFAULT NULL,
  `investment_accountname` varchar(100) DEFAULT NULL,
  `investment_units` varchar(100) DEFAULT NULL,
  `investment_facevalue` varchar(100) DEFAULT NULL,
  `personal_chattels` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_dump`
--

CREATE TABLE `beneficiary_dump` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `childid` varchar(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `percentage` varchar(10) DEFAULT NULL,
  `percentage1` varchar(10) DEFAULT NULL,
  `percentage2` varchar(10) DEFAULT NULL,
  `percentage3` varchar(10) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `passport` varchar(200) DEFAULT NULL,
  `dob` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `children_details`
--

CREATE TABLE `children_details` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `age` varchar(5) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `guardianname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `stipend` text,
  `alt_beneficiary` varchar(5) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `passport` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `child_tb`
--

CREATE TABLE `child_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comprehensivewill_tb`
--

CREATE TABLE `comprehensivewill_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `willtype` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `employmentstatus` varchar(50) DEFAULT NULL,
  `employer` text,
  `employerphone` varchar(50) DEFAULT NULL,
  `employeraddr` text,
  `maritalstatus` varchar(50) DEFAULT NULL,
  `spname` varchar(50) DEFAULT NULL,
  `spemail` varchar(50) DEFAULT NULL,
  `spphone` varchar(20) DEFAULT NULL,
  `sdob` varchar(10) DEFAULT NULL,
  `spaddr` text,
  `spcity` varchar(50) DEFAULT NULL,
  `spstate` varchar(50) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `marriagecity` varchar(50) DEFAULT NULL,
  `marriagecountry` varchar(50) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `addinfo` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comprehensive_will`
--

CREATE TABLE `comprehensive_will` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `employer` text,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `spname` varchar(50) DEFAULT NULL,
  `spaddr` text,
  `spphone` varchar(20) DEFAULT NULL,
  `sdob` varchar(10) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `rsano` varchar(20) DEFAULT NULL,
  `pensionadmin` varchar(100) DEFAULT NULL,
  `spinstruct` text,
  `addinfo` text,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `pg_cat` varchar(200) DEFAULT NULL,
  `pg_name` varchar(200) NOT NULL,
  `pg_menu` varchar(150) DEFAULT NULL,
  `keywords` text,
  `pg_title` varchar(200) DEFAULT NULL,
  `pg_alias` varchar(100) NOT NULL,
  `pr_status` enum('1','0') NOT NULL DEFAULT '0',
  `content` text,
  `intro` text,
  `sidebar` text,
  `pg_url` varchar(50) DEFAULT NULL,
  `secured_st` enum('0','1') DEFAULT '0',
  `pg_type` varchar(100) DEFAULT 'default',
  `postdate` date DEFAULT NULL,
  `img1` varchar(150) DEFAULT NULL,
  `img2` varchar(150) DEFAULT NULL,
  `uploads` varchar(250) DEFAULT NULL,
  `creator` varchar(100) DEFAULT NULL,
  `rate_ord` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL,
  `datep` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `pg_cat`, `pg_name`, `pg_menu`, `keywords`, `pg_title`, `pg_alias`, `pr_status`, `content`, `intro`, `sidebar`, `pg_url`, `secured_st`, `pg_type`, `postdate`, `img1`, `img2`, `uploads`, `creator`, `rate_ord`, `datep`) VALUES
(2, 'Our Services', 'Corporate Trust Services', NULL, NULL, 'Corporate Trust Services', 'corporate-trust-services', '0', '<p>We act as trustees to numerous Credit or Debt-related transactions locally and internationally, and offer a full range of Trust-related services tailored to meet corporate and institutional needs.</p>\r\n\r\n<p>FCMB Trustees has a robust client base and has acquired exposure in the various sectors of the economy cutting across oil &amp; gas, manufacturing and real estate.</p>\r\n\r\n<p>Our services include:</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=debenture-security-trust\">Debenture/ Security Trust&nbsp;Services</a>;<br />\r\n&bull; <a href=\"page.php?a=bonds-debt-issuance\">Bonds/ Debt Issuance Trust&nbsp;Services</a>;<br />\r\n&bull; <a href=\"page.php?a=mutual-funds\">Mutual Funds/ Collective Investment Schemes Trust&nbsp;Services</a>.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '1', '2019-08-02 12:02:04'),
(3, 'Our Services', 'Private Trust & Wealth Management Services', NULL, NULL, 'Private Trust & Wealth Management Services', 'private-wealth-services', '0', '<p>A significant aspect of our services involve&nbsp;helping private individuals organise, grow, protect and transfer their assets efficiently by setting up shielded structures which minimise estate and asset transfer taxes.</p>\r\n\r\n<p>In addition to drafting core Private Wealth documents such as Wills and Trusts, we can also implement sophisticated trust structures if necessary to meet a client&rsquo;s Private Wealth protection goals.</p>\r\n\r\n<p>Our Trust Advisors and Lawyers are experienced in the most effective and sophisticated Private Wealth techniques to ensure seamless wealth and asset transfer, wealth preservation, business succession and tax planning.</p>\r\n\r\n<p>Our products include :</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=wills-probate-services\">Wills and Probate Services</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=private-trust\">Private/ Living&nbsp;Trust</a><a href=\"page.php?a=private-living-trust\">;</a></p>\r\n\r\n<p>&bull; <a href=\"page.php?a=education-trust\">Education Trust</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=reserve-trust\">Reserve Trust</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=investment-management-trust\">Investment Management Trust</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=codicil\">Codicil</a>.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '2', '2019-08-02 13:02:25'),
(4, 'Corporate Trust Services', 'Debenture/ Security Trustees', NULL, NULL, 'Debenture/ Security Trustees', 'debenture-security-trustees', '0', '<p style=\"margin-left:0in; margin-right:0in\">In lending situations,&nbsp;banks and other financial institutions seeking to finance various projects of small, medium and large Corporates usually prefer a Security Trust arrangement, which is essentially a contractual arrangement amongst Borrowers, Lenders and the (Security) Trustee.</p>\r\n\r\n<p style=\"margin-left:0in; margin-right:0in\">As Security Trustees, FCMB Trustees will hold charge on, and secure, the Borrower&rsquo;s assets on behalf of multiple lenders.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '1', '2019-08-02 12:37:19'),
(5, 'Corporate Trust Services', 'Bonds/ Debt Issuance Trust', NULL, NULL, 'Bonds/ Debt Issuance Trust', 'bonds-debt-issuance', '0', '<p>As a leading provider of Trustee services, we know that administering Government Bonds is an act of public trust and there is the ever-present need to find a balance between protecting public investors from the attendant risks of investment of public funds and ensuring return on investments.</p>\r\n\r\n<p>We, therefore, provide transparent investment, compliance and reporting services to all parties to Government Bond issuances.</p>\r\n\r\n<p>As Bond Trustees, FCMB Trustees will perform specific financial functions including:</p>\r\n\r\n<p>&bull; Payment of coupon and principal to bond-holders;<br />\r\n&bull; The maintenance of the Sinking Fund (Reserve Funds);<br />\r\n&bull; Taking custody of investments.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '2', '2019-08-02 12:39:06'),
(6, 'Corporate Trust Services', 'Collective Investment Schemes/ Mutual Funds', NULL, NULL, 'Collective Investment Schemes/ Mutual Funds', 'mutual-funds', '0', '<p>Collective Investment Schemes such as Mutual Funds and Real Estate Investment Trusts, require Trustees to undertake detailed supervisory functions to ensure that the Scheme is managed by the relevant parties,&nbsp;such as the Fund Manager, Custodian, Registrar and Auditor, in accordance with the Scheme&rsquo;s Trust Deed.</p>\r\n\r\n<p>As Scheme Trustees, FCMB Trustees will ensure that it adequately protects the unit-holders&rsquo; interests, as well as, assets under its control.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '3', '2019-08-02 12:41:35'),
(7, 'Private Wealth Services', 'Wills and Probate Services', NULL, NULL, 'Wills and Probate Services', 'wills', '0', '<p>The death of a partner or spouse in Nigeria may lead to significant financial hardship and the people you may want to benefit from your property and affairs may not do so if a Will is not prepared.</p>\r\n\r\n<p>More and more people are coming to the realisation that without a Will (i.e. dying intestate), they have no control over who will receive any property, money or other assets, as Intestacy Laws will stipulate how the estate will be distributed in that instance.</p>\r\n\r\n<p>People who die without a Will are, therefore, leaving unnecessary work, complications and costs for&nbsp;their family and friends and often unintentionally gift assets to the Government.</p>\r\n\r\n<p>Administration of an Estate should not become a problem for bereaved families. There are many factors to be taken into consideration when writing a Will and it is important to take qualified advice at that stage, otherwise, families may become divided over the Estate, spending valuable time and money on court hearings.</p>\r\n\r\n<p>Our specialist Estate Planning team, at FCMB Trustees, have considerable experience in drawing up Wills, Administration of Estates and Estate Planning and will guide you through the process expertly.</p>\r\n\r\n<p><strong>Types Of Will</strong></p>\r\n\r\n<p><a href=\"https://on.fcmb.com/Write-Your-Will-Now3\" target=\"_blank\">&bull; Simple Will</a></p>\r\n\r\n<p><a href=\"../images/downloads/Premium-WIll.pdf\" target=\"_blank\">&bull; Premium Will</a></p>\r\n\r\n<p><a href=\"../images/downloads/Comprehensive-WIll.pdf\" target=\"_blank\">&bull; Comprehensive Will</a></p>\r\n\r\n<p>At FCMB Trustees, we also offer a professional, caring and sympathetic service to assist and guide bereaved families through the complicated legal process of Administration of Estates, including:</p>\r\n\r\n<p>&bull; Intestacy (where the deceased leaves no Will).</p>\r\n\r\n<p>&bull; Estate Administration (we can serve as Executors and Administrators).</p>\r\n\r\n<p>&bull; Attachment of Additional Assets where some assets have been omitted.</p>\r\n\r\n<p>&bull; Confirming the value of the assets and debts of the Estate.</p>\r\n\r\n<p>&bull; Applying for the Grant of Probate.</p>\r\n\r\n<p>&bull; Disposal of Assets.</p>\r\n\r\n<p>&bull; Liaising with banks, pension fund administrators, insurance companies and other institutions.</p>\r\n\r\n<p>&bull; Paying debts, taxes and other liabilities.</p>\r\n\r\n<p>&bull; Paying out the estate according to the Will or under the Intestacy rules.</p>\r\n\r\n<p>&bull; Provide estate accounts and tax returns.</p>\r\n\r\n<p>Many individuals choose to instruct us to carry out some or all of the administration process(es) and ensure their responsibilities are fully complied with. Our personal service ensures that this process is handled professionally,&nbsp;efficiently&nbsp;and at affordable prices.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '1', '2020-01-31 07:28:48'),
(8, 'Private Wealth Services', 'Private/ Living Trust', NULL, NULL, 'Private/ Living Trust', 'private-living-trust', '0', '<p>&bull; A Trust is simply a legal relationship created when one person is given assets&nbsp;to hold, in trust, for the benefit of another.</p>\r\n\r\n<p>&bull; A Trust is a great tool available for the use of intelligent&nbsp;(not necessarily wealthy) individuals who want to go beyond writing a Will to explore the option of protecting their assets in a way that could help avoid the pitfalls of inheritance tax and the rigours/ inadequacies of the Probate process.</p>\r\n\r\n<p>&bull; FCMB Trustees offers a range of Trusts for use, taking into account clients&rsquo; Estate Planning, Wealth Preservation, and Privacy needs.</p>\r\n\r\n<p>&bull; Setting up Trusts require specific expertise, as well as, a full understanding of clients&rsquo; goals and priorities. Our Trust Advisors will work with you to understand your needs and collaborate with other advisors to help you develop a strategic Trust plan.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '2', '2019-08-05 16:56:56'),
(9, 'Private Wealth Services', 'Education Trust', NULL, NULL, 'Education Trust', 'education-trust', '0', '<p>An Education Trust Plan is a Savings Trust managed and administered by FCMB Trustees for the benefit of a named beneficiary, for the purpose of enabling you to build up funds towards the financial security for the future education of your children/ wards.</p>\r\n\r\n<p>Whether you want to make a certain amount available each year to pay for your child&rsquo;s education or you want to provide for your beneficiary in the event of your demise to ensure education is not disrupted, we will craft bespoke Trust plans for you.</p>\r\n\r\n<p>FCMB Trustees pays the school fees directly to the school, so the burden is taken off you. The funds will also be invested and yield returns.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '3', '2019-08-02 13:11:22'),
(10, 'Private Wealth Services', 'Reserve Trust', NULL, NULL, 'Reserve Trust', 'reserve-trust', '0', '<p>Reserve Trusts are&nbsp;Savings Trusts for upwardly mobile people who want to set aside funds in a short-term Trust attached to a specific purpose or intended for specific beneficiaries. The minimum investment tenure&nbsp;is 6 months and it is interest bearing.</p>\r\n\r\n<p>Features:<br />\r\n&bull; It is a savings plan that doubles as a Trust.<br />\r\n&bull; The savings/ contributions fund the Trust.<br />\r\n&bull; It works like a mutual fund/ collective investment scheme.<br />\r\n&bull; There is a minimum investment tenure&nbsp;of 6 months.<br />\r\n&bull; The investment is interest-bearing.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '4', '2019-08-05 16:42:44'),
(11, 'Private Wealth Services', 'Investment Management Trust', NULL, NULL, 'Investment Management Trust', 'investment-management-trust', '0', '<p>FCMB Trustees can manage individual investment portfolios through a Separately Managed Trust structure. We listen to your needs, goals and aspirations for the short-term and the long-term. With a clear understanding of your priorities and objectives, we work with you to develop and administer a co-ordinated approach for managing your assets and executing your plans through a carefully crafted Trust structure.</p>\r\n\r\n<p>Investment Management Trusts have several advantages</p>\r\n\r\n<p>&bull; They are tax-efficient.<br />\r\n&bull; They are tailored to your specific investment guidelines.<br />\r\n&bull; They are flexible to respond to changes in investment objectives.<br />\r\n&bull; The Trust is funded by liquid assets which form an Investment Portfolio.<br />\r\n&bull; There are two types of Investment Management Trusts-Discretionary and Non-Discretionary.</p>\r\n\r\n<p>For the discretionary, the settlor grants FCMB Trustees the discretion to make investment decisions while, for the Non-Discretionary, we will revert to the settlor for all investment decisions.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '5', '2019-08-08 15:39:00'),
(12, 'About Us', 'Company Profile', NULL, NULL, 'Company Profile', 'company-profile', '0', '<p>FCMB Trustees Limited is a Limited Liability Company licensed by the Securities and Exchange Commission (SEC) to carry out the business of Trustee Services.</p>\r\n\r\n<p>As a member of the FCMB Group Plc and prior to our incorporation in 2010, our Trustee activities were carried out by City Securities Limited, which acted as trustees to numerous debt-related transactions locally and internationally since 1977.</p>\r\n\r\n<p>We are well-known for our professionalism and play a major role in Corporate, Public and Private Trust transactions, as well as Wealth Management services.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Vision</strong></p>\r\n\r\n<p>Our Vision at FCMB Trustees Limited is to be the fastest growing mid-tier wealth management organisation.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Mission</strong></p>\r\n\r\n<p>Our Mission is to be consistent in delivering superior returns to our shareholders and customers, as well as, offer accessible and relatable Wealth Management solutions to our customers. A hallmark of this mission is our commitment to preserving&nbsp;our reputation for integrity in the market place.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '1', '2019-08-02 10:21:06'),
(13, 'About Us', 'What We Do', NULL, NULL, 'What We Do', 'what-we-do', '0', '<p>As Trustees, we provide the following services:</p>\r\n\r\n<p>&bull; <a href=\"../debenture-security-trustees\">Debenture/ Security Trust&nbsp;Services (Consortium/ Syndicated lending)</a>;</p>\r\n\r\n<p>&bull; <a href=\"../bonds-debt-issuance\">Bonds/ Debt Issuance Trust&nbsp;Services (Government &amp; Corporate)</a>;</p>\r\n\r\n<p>&bull; <a href=\"../mutual-funds\">Mutual Funds/ Collective Investment Schemes Trust&nbsp;Services</a>;</p>\r\n\r\n<p>&bull; <a href=\"../wills-probate-services\">Estate Planning &ndash; Wills and Living Trusts</a>;</p>\r\n\r\n<p>&bull; <a href=\"../education-trust\">Education Trusts</a>;</p>\r\n\r\n<p>&bull; <a href=\"../investment-management-trust\">Investment Management Trusts</a>;</p>\r\n\r\n<p>&bull; <a href=\"../reserve-trust\">Reserve Trusts</a>;</p>\r\n\r\n<p>&bull; <a href=\"../endowment-foundation-management\">Endowment Fund/ Foundations</a>;</p>\r\n\r\n<p>&bull; <a href=\"../codicil\">Codicils</a>.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '2', '2020-01-30 14:43:39'),
(18, 'Other Services', 'Co-operative Schemes', NULL, NULL, 'Co-operative Schemes', 'cooperative-schemes', '0', '<p>Seedwise Co-operative Society is the brainchild of FCMB Trustees. It is a fully digital multipurpose co-operative society and all assets of the Society are managed and invested by FCMB Trustees.</p>\r\n\r\n<p>The purpose of Co-operative Societies is to promote a savings culture among people and create an alternative avenue for loans and joint investment.</p>\r\n\r\n<p>FCMB Trustees equally help&nbsp;set up other Co-operative Societies and supports the Societies&rsquo; main activities including:</p>\r\n\r\n<p>&bull; Asset Management;<br />\r\n&bull; Investment Management; and<br />\r\n&bull; Secretariat Management.</p>\r\n\r\n<p>FCMB Trustees holds the assets of the Co-operative Society and hedges against the risks associated with Co-operative Societies, protecting the investors\' funds.</p>\r\n\r\n<p>&nbsp;</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '3', '2019-08-02 12:35:28'),
(17, 'Other Services', 'Escrow Agent', NULL, NULL, 'Escrow Agent', 'escrow-agent', '0', '<p>FCMB Trustees offers professional escrow services which is a third-party financial arrangement intended to protect parties to a transaction until such a time as pre-agreed release criteria are met.</p>\r\n\r\n<p>As an escrow agent, we act by holding documents, providing bank and securities accounts, monitoring and releasing the securities upon completion of the transaction in line with an Escrow Agreement, which stipulates the terms under which the transaction is consummated by the Parties.</p>\r\n\r\n<p>Our role is to ensure that the asset(s) are managed properly even as we accept and hold same until all terms and conditions are achieved. We do this by:</p>\r\n\r\n<p>&bull; Determining the identity and residence of all parties to the transaction. We will also determine whether any other parties are acting on behalf of another person as nominated party or any other intermediary.</p>\r\n\r\n<p>&bull; Obtaining details of the type of Escrow i.e. Whether it be for Merger &amp; Acquisition, Capital Raising, Collateral, Project Financing or Litigation.</p>\r\n\r\n<p>&bull; Opening off-shore escrow accounts when necessary to hedge against foreign exchange losses.</p>\r\n\r\n<p>&bull; Opening and maintaining multi-currency accounts for the escrow.</p>\r\n\r\n<p>&bull; Ensuring strict Compliance to instructions (payment of approved invoices and request for information) issued by the principals and parties to the transaction in a precise manner.</p>\r\n\r\n<p>&bull; Tracking and Investing idle funds via a daily sweep arrangement to ensure no investment benefit is lost and prompt reconciliation of accounts.</p>\r\n\r\n<p>&bull; Periodic reporting to all parties parallel with the transaction dynamics and agreement.</p>\r\n\r\n<p>&bull; Closing the escrow in concurrence with instructions when and where necessary.</p>\r\n\r\n<p>&bull; Handling the funds and/or documents in a confidential manner and in accordance with the instruction.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '2', '2019-08-02 12:30:01'),
(19, 'About Us', 'Management Team', NULL, NULL, 'Management Team', 'management-team', '0', NULL, NULL, NULL, NULL, '0', 'management', NULL, NULL, NULL, NULL, NULL, '3', '2019-06-22 13:41:23'),
(20, 'About Us', 'Board Of Directors', NULL, NULL, 'Board Of Directors', 'board-of-directors', '0', NULL, NULL, NULL, NULL, '0', 'board', NULL, NULL, NULL, NULL, NULL, '4', '2019-06-22 13:44:38'),
(21, NULL, 'Trust FAQs', NULL, NULL, 'Trust FAQs', 'trusts-faqs', '0', NULL, NULL, NULL, NULL, '0', 'faq', NULL, NULL, NULL, NULL, NULL, '1', '2019-06-06 13:16:33'),
(22, NULL, 'Will FAQs', NULL, NULL, 'Will FAQs', 'wills-faqs', '0', NULL, NULL, NULL, NULL, '0', 'will-faq', NULL, NULL, NULL, NULL, NULL, '2', '2019-06-10 11:53:23'),
(23, NULL, 'Step by step guide to create your will', NULL, NULL, NULL, 'step-by-step-guide', '0', '<p><strong>You Sign Up</strong></p>\r\n\r\n<p>We will ask you basic questions necessary to establish this relationship.</p>\r\n\r\n<p><strong>Write your Will</strong></p>\r\n\r\n<p>We will ask you a few questions to establish your eligibility and help you write your Will. Our legal professionals are at your service to assist you <gwmw class=\"ginger-module-highlighter-mistake-type-3\" id=\"gwmw-15621634839530660975250\">by</gwmw> emails and phone support.</p>\r\n\r\n<p><strong>We Review</strong></p>\r\n\r\n<p>Our legal professionals will review the Will and be in touch through this course.</p>\r\n\r\n<p><strong>Execution by Your Witnesses</strong></p>\r\n\r\n<p>We will print and forward hard copies of your Will via courier and your witnesses will need to sign in your presence.</p>\r\n\r\n<p><strong><gwmw class=\"ginger-module-highlighter-mistake-type-1\" id=\"gwmw-15621634939557959108722\">Probacy</gwmw></strong></p>\r\n\r\n<p>We will get the Will registered at the Probate Registry.</p>\r\n\r\n<p><strong>Distribution</strong></p>\r\n\r\n<p>You will tell us how you want copies of your Will to be distributed</p>\r\n\r\n<p><strong>Safe Keeping</strong></p>\r\n\r\n<p>You have the option of keeping your Will in our custody as Trustees (subject, however, to the payment of a Custody fee).</p>', NULL, NULL, NULL, '0', 'step-guide', NULL, NULL, NULL, NULL, NULL, '1', '2019-07-03 14:20:09'),
(26, 'Private Wealth Services', 'Codicil', NULL, NULL, 'Codicil', 'codicil', '0', '<p>Life is not static, the only thing constant in life is change. Children are born, old ones transit to beyond, people get married or divorced, our opinion on our loved ones changes, appointed Executors may&nbsp;have passed away or become incapacitated, you might have changed your mind as to who should receive gifts in your Will, the value of your cash gifts might have changed, as a result of inflation etc, since the Will was made etc.</p>\r\n\r\n<p>After making a Will, there might be a need to make changes to your Will without completely writing a new document. What you need is a Codicil to amend your Will.</p>\r\n\r\n<p>A Codicil is a document that amends an existing Will, but does not replace it. It allows you to change your Will without making an entirely new Will. The main benefit of using a Codicil is that it is time and cost-effective.</p>\r\n\r\n<p><strong>How do I make a Codicil?</strong></p>\r\n\r\n<p>At FCMB Trustees, our highly skilled professionals with expertise and experience will take you through making&nbsp;a Codicil if one is desired by you.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '6', '2019-08-02 13:17:50'),
(24, 'Our Services', 'Other Services', NULL, NULL, 'Other Services', 'other-services', '0', '<p>Our other services include:</p>\r\n\r\n<p><a href=\"page.php?a=endowment-foundation-management\">&bull;&nbsp;</a><a href=\"page.php?a=endowment-foundation-management\">Endowment/ Foundation Management</a></p>\r\n\r\n<p>&bull; <a href=\"page.php?a=escrow-agent\">Escrow Agents</a></p>\r\n\r\n<p>&bull; <a href=\"page.php?a=cooperative-schemes\">Cooperative Schemes</a></p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '3', '2019-08-02 12:22:01'),
(27, NULL, 'Downloadable Forms', NULL, NULL, NULL, 'downloads', '0', NULL, NULL, NULL, NULL, '0', 'downloads', NULL, NULL, NULL, NULL, NULL, '1', '2019-08-02 12:00:02'),
(29, 'Other Services', 'Endowment/ Foundation Management', NULL, NULL, 'Endowment/ Foundation Management', 'endowment-foundation-management', '0', '<p>At FCMB Trustees Limited, we offer services in the area of Endowment scheme management as part of our professional expertise.&nbsp;We specialise in, amongst other things, setting up and managing Endowment Funds on behalf of our clients to meet a certain objective.</p>\r\n\r\n<p>An Endowment Fund is simply set up to achieve a long-lasting objective. It is also a vehicle used to cater for charitable courses&nbsp;such as the less privileged members of the society, aged people, and school children or to address security challenges.</p>\r\n\r\n<p>The Endowed object could be education, medical or another area of interest, as outlined by the Client.</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '1', '2019-08-02 12:22:34'),
(30, NULL, 'What We Do - backup', NULL, NULL, 'What We Do', 'what-we-do', '0', '<p>As Trustees, we provide the following services:</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=debenture-security-trust\">Debenture/Security Trust&nbsp;Services (Consortium/Syndicated lending)</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=bonds-debt-issuance\">Bonds/Debt Issuance Trust&nbsp;Services (Government &amp; Corporate)</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=mutual-funds\">Mutual Funds/Collective Investment Schemes Trust&nbsp;Services</a>;</p>\r\n\r\n<p>&bull; <a href=\"http://page.php?a=wills-probate-services\">Estate Planning &ndash; Wills and Living Trusts</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=education-trust\">Education Trusts</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=investment-management-trust\">Investment Management Trusts</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=reserve-trust\">Reserve Trusts</a>;</p>\r\n\r\n<p>&bull; <a href=\"#\">Endowment Fund /Foundations</a>;</p>\r\n\r\n<p>&bull; <a href=\"page.php?a=codicil\">Codicils</a>.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', NULL, NULL, NULL, '0', 'default', NULL, NULL, NULL, NULL, NULL, '2', '2019-08-05 14:31:16');

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `descrp` text,
  `category` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `rate_ord` enum('0','1','2','3','4','5','6','7','8','9','10') DEFAULT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `divorce_tb`
--

CREATE TABLE `divorce_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `divorceorder` varchar(200) DEFAULT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `education_access_level`
--

CREATE TABLE `education_access_level` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `access` enum('0','1','2','3','4','5','6','7','8','9','10') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `education_beneficiary`
--

CREATE TABLE `education_beneficiary` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `nameofchild` varchar(100) DEFAULT NULL,
  `dob` varchar(10) DEFAULT NULL,
  `relationship` varchar(20) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `percentage` int(5) DEFAULT NULL,
  `passport` varchar(200) DEFAULT NULL,
  `dateposted` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `education_form`
--

CREATE TABLE `education_form` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `mailingaddr` text,
  `email` varchar(50) DEFAULT NULL,
  `maidenname` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `maritalstatus` text,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `spname` varchar(50) DEFAULT NULL,
  `spaddr` text,
  `spphone` varchar(20) DEFAULT NULL,
  `sdob` varchar(10) DEFAULT NULL,
  `empstatus` varchar(20) DEFAULT NULL,
  `employer` text,
  `employerphone` varchar(20) DEFAULT NULL,
  `employeraddr` text,
  `idtype` varchar(50) DEFAULT NULL,
  `idnumber` varchar(20) DEFAULT NULL,
  `issuedate` varchar(10) DEFAULT NULL,
  `expirydate` varchar(10) DEFAULT NULL,
  `placeofissue` varchar(20) DEFAULT NULL,
  `sfund` varchar(20) DEFAULT NULL,
  `income` varchar(20) DEFAULT NULL,
  `purpose` text,
  `trustname` text,
  `contribution` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `education_tb`
--

CREATE TABLE `education_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `willtype` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `maidenname` varchar(50) DEFAULT NULL,
  `identificationtype` varchar(50) DEFAULT NULL,
  `idnumber` varchar(50) DEFAULT NULL,
  `issuedate` varchar(50) DEFAULT NULL,
  `expirydate` varchar(50) DEFAULT NULL,
  `issueplace` varchar(50) DEFAULT NULL,
  `employmentstatus` varchar(50) DEFAULT NULL,
  `employer` text,
  `employerphone` varchar(50) DEFAULT NULL,
  `employeraddr` text,
  `maritalstatus` varchar(50) DEFAULT NULL,
  `spousename` varchar(50) DEFAULT NULL,
  `spouseemail` varchar(50) DEFAULT NULL,
  `spousephone` varchar(20) DEFAULT NULL,
  `spousedob` varchar(10) DEFAULT NULL,
  `spouseaddr` text,
  `spousecity` varchar(50) DEFAULT NULL,
  `spousestate` varchar(50) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `cityofmarriage` varchar(50) DEFAULT NULL,
  `countryofmarriage` varchar(50) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `earning` varchar(50) DEFAULT NULL,
  `otherspecify` text,
  `annualincome` varchar(50) DEFAULT NULL,
  `purposeoftrust` text,
  `nameoftrust` text,
  `initialcontribution` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employer_tb`
--

CREATE TABLE `employer_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employmentbenefit_tb`
--

CREATE TABLE `employmentbenefit_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `plan` varchar(10) DEFAULT NULL,
  `rsa_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employment_tb`
--

CREATE TABLE `employment_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `employer` text,
  `address` text,
  `phone` varchar(50) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `executor_power`
--

CREATE TABLE `executor_power` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `willtype` varchar(50) DEFAULT NULL,
  `question1` text,
  `question2` text,
  `question3` text,
  `question4` text,
  `question5` text,
  `question6` text,
  `question7` text,
  `question8` text,
  `question9` text,
  `question10` text,
  `question11` text,
  `question12` text,
  `question13` text,
  `question14` text,
  `question15` text,
  `dateposted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `executor_tb`
--

CREATE TABLE `executor_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `content` text,
  `category` varchar(50) DEFAULT NULL,
  `rate_ord` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL,
  `datep` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `title`, `content`, `category`, `rate_ord`, `datep`) VALUES
(1, 'Who is a Trustee?', '<p>A Trustee is a Person or institution that oversees and manages a Trust.<br />\r\nThe Trustee stands in a fiduciary relationship with respect to the assets/Trust property which is held on behalf of another (others) called the beneficiary (or beneficiaries).&nbsp; A fiduciary usually takes care of finances or assets for another person.</p>\r\n\r\n<p>&nbsp;</p>', 'trust-faq', '1', '2019-06-06 13:29:20'),
(2, 'What is a Trust?', '<p>A Trust is a legal contract/relationship where you (the Settlor) transfer assets to a legal entity, the Trust, which will be administered by a Trustee (such as FCMB Trustees or an individual) for the benefit of a beneficiary (which could be yourself or another person).</p>\r\n\r\n<p>Trusts are separate legal entities, like companies, whose purpose is to hold and manage assets for you or for the benefit of others.</p>', 'trust-faq', '2', '2019-06-06 13:39:36'),
(3, 'What are the types of Trust in Common use?', '<p>An irrevocable Trust is simply a Trust with terms and provisions that cannot be changed by the Settlor. This is distinguished from a Revocable Trust, which allows the Settlor to change the terms of the Trust and/or take the property back at any time.</p>', 'trust-faq', '3', '2019-06-06 15:38:19'),
(4, 'Will or Trust? Which is best?', '<p>Most people need both. A big advantage of a Trust is that it is generally the best strategy to avoid probate and protect financial privacy. Wills must be validated by Probate court, a lengthy and expensive process that can take six months to two years and, in some cases, even longer. Probating a will may involve solicitor&rsquo;s fees, executor&rsquo;s commissions, administrative and other court costs. Unlike Wills, Trusts are not subject to probate and therefore enable the Settlor keep his affairs private and minimize probate costs and estate taxes.</p>\r\n\r\n<p>&nbsp;</p>', 'trust-faq', '4', '2019-07-09 16:00:48'),
(5, 'What is a Trust Deed?', '<p><br />\r\nThe Trust Deed is the document executed between the Settlor (You) and the Trustee and it outlines how, when and to whom your assets will be distributed, in accordance with your wishes.</p>\r\n\r\n<p>&nbsp;</p>', 'trust-faq', '5', '2019-06-06 15:43:33'),
(6, 'What can Trust Do for You?', '<p>&bull; Ensure the orderly and private transfer of your assets/wealth/property.</p>\r\n\r\n<p>&bull; Safeguard the process of providing for loved or vulnerable ones-children, parents or wards.</p>\r\n\r\n<p>&bull; Help set up a structure to finance a child\'s or ward&rsquo;s education after your demise.</p>\r\n\r\n<p>&bull; Manage your Estate Tax exposure.</p>\r\n\r\n<p>&bull; Legally avoid Probate costs.</p>\r\n\r\n<p>&bull; Legally shield assets from Creditor\'s claims.</p>\r\n\r\n<p>&bull; Provide a structured way to administer your personal and financial affairs should you become ill or otherwise incapacitated.</p>\r\n\r\n<p>&nbsp;</p>', 'trust-faq', '6', '2019-06-10 13:29:22'),
(7, 'Who are the parties to a Trust?', '<p>In all Trust arrangements, there will be 3 separate parties to the Trust-<strong>The Settlor, the Trustee and the Beneficiary</strong>.</p>\r\n\r\n<p>&bull; The Settlor is the benefactor i.e. <gwmw class=\"ginger-module-highlighter-mistake-type-1\" id=\"gwmw-15627346860459878230889\">the</gwmw> creator of the Trust, who transfers the assets to the Trustees.</p>\r\n\r\n<p>&bull; The Trustee is the one to whom the Settlor transfers the assets to hold in Trust for the beneficiaries. Legal ownership will pass from the Settlor to the Trustees but beneficial ownership resides in the beneficiary.</p>\r\n\r\n<p>&bull; The Beneficiaries are the persons who are entitled to use or enjoy the income or assets of the Trust.</p>', 'trust-faq', '7', '2019-07-10 04:58:24'),
(8, 'What are the advantages of a Trust?', '<ul>\r\n	<li>With a Trust, you can name one or more beneficiaries to receive your assets at your demise, just like a Will, but in this case, you legally avoid probate expenses. Probate Expenses and Estate Taxes can become excessive, making the assets inaccessible to your loved ones/beneficiaries. Trusts can provide for the tidy transfer of property without the expense, delay, or publicity of probate, and for professional asset management for beneficiaries.</li>\r\n	<li>A Trust can endure beyond your lifetime, becoming a source of lasting income and upkeep for your spouse, a child or others whom you choose.</li>\r\n	<li>A Trust will guarantee succession of property- by gifting assets to a trust; the Settlor is ensuring that the assets he is giving away remain within his family. For example, a Settlor can create a Trust for the benefit of his wife and specify in the Trust Deed that on his wife&rsquo;s death, the assets will pass directly to his children or grandchildren. This prevents his wife from disposing of the Trust Property to a non-family member.</li>\r\n	<li>The details of a Trust are, by nature, private, as opposed to a Will that can be easily accessed by the Public at the Probate Registry. Trustees are also required by Law to be discreet about all aspects/details of a Trust.</li>\r\n	<li>A Trust can make provisions for a spouse, spouse from a previous marriage or children from previous marriages while keeping assets within the Settlor&rsquo;s family.</li>\r\n	<li>An Education Trust, which is different from an Education Savings Plan, can help with providing for the education of in-school beneficiaries upon the event of the demise of a Settlor. An Education Trust can either be a Stand-Alone Trust or it may be incorporated into a larger Trust.</li>\r\n	<li>If your assets are transferred into a trust during your lifetime, those assets will not be subject to claims after your demise from family members or others whom you do not wish to share in those assets.</li>\r\n	<li>In the event of the Settlor&rsquo;s demise or incapacity, a Trustee (such as FCMB Trustees) will guarantee that the aims of the Trust as specified by the Settlor are realized.</li>\r\n	<li>The Trust is separate from your estate and is therefore sheltered from creditors.</li>\r\n	<li>The designated beneficiaries automatically receive the accumulated benefits even in the event of your demise, without recourse to a Will or Letters of Administration.</li>\r\n</ul>', 'trust-faq', '8', '2019-06-06 15:55:25'),
(9, 'What types of assets can you put in a Trust?', '<p>Stocks and Bonds</p>\r\n\r\n<p>Real Estate (including Land)</p>\r\n\r\n<p>Mutual Funds<br />\r\nArt<br />\r\nIntellectual property<br />\r\nBank Accounts, Safe Deposit boxes<br />\r\nNotes payable (money owed to you)<br />\r\nLife insurance (or use irrevocable trust)</p>', 'trust-faq', '9', '2019-06-06 15:57:33'),
(10, 'What are our duties as Trustees?', '<p>Our duties include to:</p>\r\n\r\n<ul>\r\n	<li>To comply with the terms of the Trust Deed</li>\r\n	<li>To act fairly between the beneficiaries</li>\r\n	<li>To ensure that we do not put ourselves in a position where our interests conflict with those of the beneficiaries.&nbsp; For example, we will not buy any Trust Property if it was for sale</li>\r\n	<li>To keep accounts and provide information and accounts to the Settlor and or the beneficiaries upon request</li>\r\n	<li>To take reasonable care in making investments. We will consider the suitability of any investment and the need to diversify.</li>\r\n	<li>To protect Trust Assets</li>\r\n	<li>To insure where necessary</li>\r\n</ul>\r\n\r\n<p>&ndash; Unless trust documents state otherwise</p>\r\n\r\n<ul>\r\n	<li>Ensure proper transfers of title of assets to be transferred into the Trust.</li>\r\n	<li>Invest the Trust Property for the benefit of the Beneficiaries.</li>\r\n	<li>Maintain detailed records of all assets and transactions.</li>\r\n	<li>Review assets regularly for quality and performance.</li>\r\n	<li>Ensure that payment and distributions are made to genuine Beneficiaries.</li>\r\n	<li>Facilitate final transfer of Trust assets to the eventual owners i.e. Beneficiaries.</li>\r\n</ul>', 'trust-faq', '10', '2019-06-06 15:58:57'),
(11, 'What are the service fees and charges?', '<p>Generally, fees for Trust services are spelled out in the Trust document. Under normal circumstances, they are calculated annually, based on the level of responsibility assumed by the Trustee and the value of the assets in the Trust.</p>\r\n\r\n<p>Our usual fees start from N150, 000 (take-on fee) and N100, 000 Annual Fees, depending on your specific needs and other variables. If we have to manage the Settlor&rsquo;s assets after his demise, we will have a right to a management fee out of which we can pay a third party for the management.</p>', 'trust-faq', '10', '2019-07-11 10:58:21'),
(12, 'Is it difficult to set up a Trust?', '<p>No. You should start by discussing your financial and investment goals with us and with your Financial Adviser.</p>\r\n\r\n<p>&nbsp;</p>', 'trust-faq', '10', '2019-06-06 16:01:30'),
(13, 'How are Trust assets invested?', '<p>Ultimately, it is the purpose of the Trust that determines how the assets are invested, and it is the responsibility of the Trustee to see that the purpose is carried out. Often, FCMB Trustees will recommend a professional investment manager who will make investment recommendations based on the goals of the Trust, the needs of the beneficiaries and the time horizon.</p>', 'trust-faq', '10', '2019-06-06 16:02:11'),
(14, 'Do I have to give up control if I set up a Trust?', '<p>No. You do not have to give up control when you create a Revocable Living Trust. You keep as much control as you want. Typically, the creator of a Revocable Living Trust stays in control by retaining the power to do one of the following:</p>\r\n\r\n<ul>\r\n	<li>Withdraw Trust assets</li>\r\n	<li>Change instructions to the Trustee by amending the Trust agreement</li>\r\n	<li>Cancel the Trust all together</li>\r\n</ul>', 'trust-faq', '10', '2019-06-06 16:02:58'),
(15, 'Do I have enough money for a Trust?', '<p>Trusts are variable and can be revised to cater to an assortment of wishes, situations and goals.&nbsp; Many people still wrongly believe that Trusts are only for the wealthy. Here at FCMB Trustees, the majority of our customers do not classify themselves as wealthy, they do not have multi-million Naira Trusts. Whether you need to safeguard a retirement portfolio, or need assistance with your Estate Planning, you should consider our services.</p>', 'trust-faq', '10', '2019-06-06 16:03:35'),
(16, 'Why should I pick FCMB Trustees as my Trustee?', '<p>In addition to possessing professional Estate Planning competences, we know how to take care of all Investment details since we are affiliated to an assortment of Investment and Wealth Management companies. We are therefore that One-Stop shop you&rsquo;ve been searching for.</p>', 'trust-faq', '10', '2019-06-06 16:04:19'),
(17, 'Is a Trust expensive?', '<p>No. As you can see, our annual charges as Trustees are less than you were previously paying for Investment Advice or Wealth Management services.</p>', 'trust-faq', '10', '2019-06-06 16:06:23'),
(18, 'What is a Living Trust?', '<p>Settlors often create a Trust where they act both as Settlors and co-Trustees. While Settlors are alive, they can continue to control all assets in the Trust because they are Trustees of their own Trust. He can also continue to be the beneficiary of all assets and income from the Trust. When the Settlor dies or becomes disabled, the Trust will name the successor Trustees (FCMB Trustees) who are given power and authority over the assets by the terms of the Trust Deed. A Living Trust is sometimes referred to as a Will Substitute. It is also called a Revocable Living Trust because it can be amended, changed or revoked by the Settlor during his lifetime.</p>', 'trust-faq', '10', '2019-06-06 16:10:10'),
(19, 'What is a Family Trust?', '<p>Usually, Trusts are named after the Settlor. An example would be the Tolu Alabi Living Trust. A joint Trust for a married couple might be called the Tolu and Tope Alabi Living Trust. There is no difference between a Living Trust and a Family Trust when they are established during the lifetime of the Settlor(s) and are revocable trusts.</p>\r\n\r\n<p>The name &ldquo;Family Trust&rdquo; is also used for Trusts that are established at the time of death for the benefit of the surviving spouse and children.</p>', 'trust-faq', '10', '2019-06-06 16:12:16'),
(20, 'What does â€˜fundingâ€™ the Trust mean?', '<p>In order for a Living Trust to control your assets at the time of death or disability, all assets need to be titled in the name of your Trust. Funding your trust is the process of transferring your assets from you to your trust. To do this, you physically change the titles of your assets from your individual name (or joint names, if married) to the name of your trust. You will also change most beneficiary designations to your trust. The process of changing titles and beneficiary designations is what is referred to as &ldquo;funding&rdquo; the Trust.</p>\r\n\r\n<p>To transfer cash or securities, FCMB Trustees will open an account in the Trust&rsquo;s name, and the Settlor will instruct his or her bank or broker to move the funds from his or her account to the Trust&rsquo;s account. For real estate, a deed is used to transfer legal title of the property from the Settlor to the Trust. All future insurance and property tax statements should be sent to FCMB Trustees and paid with Trust funds. Finally, to transfer an existing life insurance policy, the Settlor simply needs to obtain and complete a change of ownership form and change of beneficiary form from his or her life insurance company.</p>', 'trust-faq', '10', '2019-06-06 16:13:25'),
(21, 'Can I do my own Trust funding?', '<p>Funding a Trust is complicated and requires in-depth knowledge of Law, Banking, Forms, Deeds, Titling, Real Estate and the proper conveyance instruments. It is better to leave the hard work to FCMB Trustees.</p>', 'trust-faq', '10', '2019-06-06 16:13:56'),
(22, 'If I have a Living Trust, do I also need a will?', '<p>If you have a Living Trust-based plan, you will still want to have a Pour-Over Will. Your Pour-Over Will does two things. First, it names guardians for minor children. Second, the Pour-Over Will assures that any assets that were not re-titled into the name of the Trust will pass through probate and into the Trust for proper distribution to loved ones.</p>', 'trust-faq', '10', '2019-06-06 16:14:44'),
(23, 'What is a Pour-Over Will?', '<p>A&nbsp;Pour-Over Will&nbsp;is a Will established by a Settlor who has already taken the necessary steps to set up a Trust, so that upon the death of the Settlor, all of his or her assets are to be transferred &ndash; or &ldquo;poured&nbsp;over&rdquo; &ndash; to the Trust.</p>', 'trust-faq', '10', '2019-06-06 16:15:18'),
(24, 'What happens if my Trust is not funded?', '<p>The Trustee can only control assets titled in the name of the Trust. If assets are not in the Trust at the time of death or disability, the Trust will not effectively pass control of the assets to the person or persons that you have designated in the Trust. This means that assets might go through probate at your death. A pour-over will can provide a &ldquo;safety net&rdquo; for your Trust, but we recommend full and continuous funding of your Living Trust.</p>\r\n\r\n<p>&nbsp;</p>', 'trust-faq', '10', '2019-06-06 16:16:43'),
(25, 'What happens to a Trust after the Settlor dies?', '<p>By Law, Trustees have the responsibility to follow the instructions in the Trust. This is called a Trustee&rsquo;s fiduciary duty. The property and assets in the Trust are distributed to family members or distributed into one or more new Trusts (like the Education Trust) for the benefit of family members. In addition, the Trustee is required to satisfy creditors of the estate of the deceased Settlor, file income and estate tax returns, manage and liquidate assets, provide an accounting to beneficiaries and generally wind up the affairs of the person who has passed away. We call this process post-mortem Trust administration.</p>', 'trust-faq', '10', '2019-06-06 16:18:49'),
(26, 'Is the Trustee subject to any Rules or Regulations?', '<p>The Trust Deed sets out the scope of a Trustee&rsquo;s powers. FCMB Trustees are also subject to a variety of other requirements imposed by the Securities and Exchange Commission.</p>\r\n\r\n<p>Importantly, a Trustee has a fiduciary relationship with the beneficiaries. This relationship exists because of the Trust placed in the Trustee. To protect those in a vulnerable position (those putting Trust in the Trustee) the law recognizes this special relationship and places duties on the Trustee to ensure they act in good faith and the best interests of the Trust.</p>\r\n\r\n<p>&nbsp;</p>', 'trust-faq', '10', '2019-06-06 16:20:02'),
(27, 'Can a Trustee Also be a Beneficiary of a Trust?', '<p>Yes, a Trustee can be one of the beneficiaries of a Trust. For example, an individual could set up a Trust, appoint himself or herself as Trustee and distribute income to their family. However, a Trustee cannot be the sole beneficiary of a Trust. This is because they would legally own property for the benefit of themselves.</p>', 'trust-faq', '10', '2019-06-06 16:20:42'),
(28, 'Can I Transfer Property I Already Own Into a New Trust?', '<p>Yes, you can. It is noteworthy though that the transfer of property into a Trust will generally be classified as a sale and this will attract Stamp Duty and perfection costs.</p>', 'trust-faq', '10', '2019-06-06 16:21:22'),
(29, 'Why choose FCMB Trustees?', '<p>There are several advantages to naming FCMB Trustees as Trustee. Unlike other providers of Trust services, our skilled Trust advisors deal exclusively with Trust issues. The solutions our Trust experts provide are never &ldquo;one size fits all,&rdquo; but are individually tailored to fit personal needs.</p>\r\n\r\n<p>In addition, FCMB Trustees offers:</p>\r\n\r\n<ul>\r\n	<li>Professional management by trained experts</li>\r\n	<li>Impartiality in making investment decisions and in dealing with beneficiaries</li>\r\n	<li>FCMB Trustees&rsquo; commitment to placing our clients&rsquo; interests first and serving them with integrity, innovation, quality and hard work</li>\r\n	<li>The confidence that comes from knowing your Trustee is subject to regular audits by external auditors and government regulators (Securities and Exchange Commission)</li>\r\n</ul>\r\n\r\n<p>FCMB Trustees is a wholly owned subsidiary of FCMB Group.</p>\r\n\r\n<p>&nbsp;</p>', 'trust-faq', '10', '2019-06-06 16:22:11'),
(30, 'How can I find out more about your Trust Services?', '<p>Our Trust staff will be glad to assemble further information for you, analyze your trust requirements and answer questions not covered here. Please e-mail us at fcmbtrustees@fcmb.com or call our office at 01-2902721.</p>\r\n\r\n<p>&nbsp;</p>', 'trust-faq', '10', '2019-06-06 16:22:55'),
(31, 'What is a Will?', '<p>A Will is a written instrument/document containing directions/instructions for how the assets of the person making the Will should be divided/distributed upon his/her death.</p>', 'will-faq', '1', '2019-06-06 16:25:59'),
(32, 'Who should have a Will?', '<p>Every adult should have a Will, regardless of marital status and asset value. It doesn&rsquo;t matter if you&rsquo;re single, divorced or married, with or without children, with minor or adult children, or with specific or no specific desires about who gets your property when you&rsquo;re gone.</p>', 'will-faq', '2', '2019-06-06 16:27:19'),
(33, 'Why is it important to have a Will?', '<ul>\r\n	<li>If a person dies without leaving a Will (intestate), or if the Will is not valid for any reason, the beneficiaries of his Estate will be determined according to the Laws of Intestate Succession.</li>\r\n</ul>\r\n\r\n<p>Generally, the law determines who the closest blood relatives are and distributes the assets in terms of this. In Nigeria, the laws of Intestate Succession may be complicated in the case of customary marriage because the different cultures and tribes have variants of this Law, thus each situation will be different, but the important point to note is that a family member you may never have chosen to inherit from you could end up with all your assets.</p>\r\n\r\n<ul>\r\n	<li>In a Will, parents can name whom they want to be the guardian of their minor children. This by far is the most important part of Wills for parents with minor children.</li>\r\n	<li>Your Will can direct that a Trust be set up for your beneficiaries instead of simply giving them lump sums of money. With many people today in second marriages, a Will with appropriate Trust provisions helps in ensuring that your assets ultimately pass to your children after being available for the support of your surviving spouse.</li>\r\n	<li>A Will lets you choose the individual or Trustee to serve as executor of your estate. The executor will manage and settle your estate according to the law and your desires expressed in your Will. Without a Will, your beneficiaries would have to petition the court to appoint an administrator through a Letter of Administration, which can be expensive and which can invite disagreement especially if they disagree as to the person qualified to administer your estate.</li>\r\n	<li>A Will lets you grant your executor full power to sell your property and liquidate your assets without having to petition the court for permission. Without a Will, you wait (after you file) until the court nominates an administrator.</li>\r\n	<li>&nbsp;A Will enables you to eliminate unnecessary expenses and court costs involved in the administration of an estate without a Will.</li>\r\n</ul>', 'will-faq', '3', '2019-06-06 16:29:31'),
(34, 'What should I remember while drafting a Will?', '<p>There are a number of points to remember, including:</p>\r\n\r\n<ul>\r\n	<li>Keep the wording as plain as possible</li>\r\n	<li>When referring to a person use their full name and a short description &ndash; for example, my nephew, Tolu Alabi</li>\r\n	<li>Avoid using vague or ambiguous terms</li>\r\n	<li>Ensure that you understand each clause in the drafted document and that the Will reflects your wishes</li>\r\n	<li>Make sure that your Will reflects your current situation at all times.</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>', 'will-faq', '4', '2019-06-06 16:30:24'),
(35, 'What should a Will contain?', '<p>In brief, a Will should contain the following:</p>\r\n\r\n<ul>\r\n	<li>The identity (full names) of the person whose Will it is</li>\r\n	<li>The beneficiaries of the estate and the distributions of the assets</li>\r\n	<li>It may contain a clause for the setting up of a Trust (for example if beneficiaries are minors or still in school)</li>\r\n	<li>Guardian nominations- to minor children</li>\r\n	<li>The name of someone or a particular company nominated as Executor.</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>', 'will-faq', '5', '2019-06-06 16:33:49'),
(36, 'Who should sign the Will?', '<p>You, being the Testator (male) or Testatrix (female), need to sign each page of the Will, together with two witnesses. Any alteration also needs to be signed in this manner. The place and date of signing must be written in at the end of the document.</p>', 'will-faq', '6', '2019-06-06 16:34:35'),
(37, 'Who should I choose as Witnesses?', '<p>Witnesses should be people who have no interest in the Will. Their signatures merely acknowledge that they saw you sign the Will &ndash; they do not have to know the content of the Will. Any potential beneficiary or their spouse should not be a witness when signing your Will.</p>', 'will-faq', '7', '2019-06-06 16:37:22'),
(38, 'When should I review my Will?', '<p>Your Will should be reviewed periodically, especially when there has been any change in your status or circumstances, or those of your beneficiaries, such as marriage, divorce, the birth of a child, etc. We recommend a random review every 2 years in addition to these.</p>', 'will-faq', '8', '2019-06-06 16:38:10'),
(39, 'How much will it cost to draft a Will?', '<p>For as little as N60, 000 (or more, depending on your specific needs), we will help you draft your Will and lodge it at the Probate Registry. You will also receive a waxed (sealed) copy of the Will, which you can keep in a safe place.</p>\r\n\r\n<p>&nbsp;</p>', 'will-faq', '9', '2019-06-06 16:47:10'),
(40, 'What happens to you if you die without a Will ?', '<p>Dying without a Will is called dying &ldquo;intestate&rdquo;. Dying intestate creates additional costs in probating your estate such as the costs and rigors of procuring a Letter of Administration. Dying intestate can also create chaos and confusion among the children, spouses, siblings or parents of the deceased.</p>', 'will-faq', '10', '2019-06-06 16:47:53'),
(41, 'What are the Formal Requirements for a Will?', '<p>You need the following: &ndash;</p>\r\n\r\n<ol>\r\n	<li>The Will must be in writing.</li>\r\n	<li>The Will must be signed by the maker of the Will and witnessed by at least two witnesses. These witnesses should not be beneficiaries-persons who will receive property under your Will.</li>\r\n	<li>The signature must be affixed in the presence of two or more witnesses present at the same time.</li>\r\n	<li>The witnesses&nbsp;must&nbsp;attest&nbsp;and&nbsp; subscribe&nbsp; to&nbsp; the&nbsp; Will&nbsp; in&nbsp; the&nbsp; presence&nbsp; of&nbsp; the Testator. To attest is to see the Testator signing, while to subscribe is to sign the Will as proof of attestation.</li>\r\n</ol>\r\n\r\n<p>Other requirements are:</p>\r\n\r\n<ol>\r\n	<li>The will must be voluntarily made and executed by the Testator. This means that the Will must have&nbsp;been&nbsp;freely&nbsp; made&nbsp; without&nbsp; any&nbsp; form of&nbsp; influence&nbsp; whatsoever&nbsp; by&nbsp; any person&nbsp; on&nbsp; the&nbsp; Testator&nbsp; that&nbsp; affects&nbsp; the&nbsp; Testator&rsquo;s&nbsp; mind&nbsp; in&nbsp; the&nbsp; making&nbsp; of&nbsp; the</li>\r\n	<li>The Will must&nbsp;be&nbsp;made&nbsp; by&nbsp; a&nbsp; Testator&nbsp; with&nbsp; testamentary&nbsp; capacity&nbsp; for&nbsp; it&nbsp; to&nbsp; be</li>\r\n</ol>', 'will-faq', '10', '2019-06-06 16:48:54'),
(42, 'Testamentary capacity means  the  capacity  and  ability  to  make  a  valid  Will  and  it  Involves two elements:', '<p>Age: The Law provides that the minimum age at which a person can make a will is 18 years. Certain persons are however exempted from this age requirement, i.e. soldiers in actual military service and mariners or seamen at sea who can prepare valid Wills though under the age of 18 years.</p>\r\n\r\n<p>Sound Disposing Mind: The Testator must possess the mental capacity or sound-disposing mind to make a Will. This simply means that the Testator must not be suffering from&nbsp;any&nbsp; disease&nbsp; of&nbsp; the&nbsp; mind&nbsp; or&nbsp; of&nbsp; the&nbsp; body&nbsp; capable&nbsp; of&nbsp; affecting&nbsp; the mind&nbsp; of&nbsp; the&nbsp; Testator&nbsp; in&nbsp; the&nbsp; making&nbsp; of&nbsp; the&nbsp; will.</p>\r\n\r\n<p>&nbsp;</p>', 'will-faq', '10', '2019-06-06 17:01:37'),
(43, 'What is Probate?', '<p>A Will can only be enforced through a process called Probate. Probate is the legal process through which the court makes sure that, after you die, your Will is valid, your debts are paid and your assets are distributed according to your Will.</p>\r\n\r\n<p>Probate is the ONLY legal way to change the title on an asset when the person listed as the owner dies. Only the court can change titles after someone dies.</p>', 'will-faq', '10', '2019-06-06 17:15:56'),
(44, 'How often should a Will be reviewed?', '<p>Your estate plan &ndash; whether it&rsquo;s a Will or Trust &ndash; should generally be reviewed every 2 years and more often if you have a major life change such as the birth or adoption of a child, a divorce or marriage, or a significant increase in assets.</p>\r\n\r\n<p>Legally, a Will does not take effect until the testator dies and the probate court approves the Will. Prior to death, a competent testator can amend or revoke an existing Will. You can change your Will by writing and signing a new Will or signing an amendment to the Will called a &ldquo;codicil&rdquo;. A codicil is a separate document that explains the changes to the Will and you make it effective by using the same formalities as with a Will.</p>\r\n\r\n<p>&nbsp;</p>', 'will-faq', '10', '2019-06-06 17:25:02'),
(45, 'Who should prepare a Will?', '<p>Drafting a Will involves making decisions requiring professional judgment, which can be obtained only by years of training, experience and study. Only a practicing lawyer can avoid the innumerable pitfalls and advise you on the course best suited for your situation.</p>', 'will-faq', '10', '2019-06-06 17:25:51'),
(46, 'Why choose FCMB Trustees?', '<p>FCMB Trustees has a team of lawyers who are experts in drafting Wills and offering sound advice on Wills. There are several advantages to having FCMB Trustees draft your Will but one of the major attractions is that you can also name us as Executors, thus ensuring all your wishes are carried out without any form of partiality.</p>', 'will-faq', '10', '2019-06-06 17:26:41'),
(47, 'How can I find out about our Wills Services?', '<p>Our staff will be glad to assemble further information for you, analyze your requirements and answer questions not covered here. Please e-mail us at fcmbtrustees@fcmb.com or call our office at 01-2902721.</p>\r\n\r\n<p>FCMB Trustees is a wholly owned subsidiary of FCMB Group.</p>', 'will-faq', '10', '2019-06-06 17:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `faq_cat`
--

CREATE TABLE `faq_cat` (
  `id` int(5) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq_cat`
--

INSERT INTO `faq_cat` (`id`, `category`) VALUES
(1, 'trust-faq'),
(2, 'will-faq');

-- --------------------------------------------------------

--
-- Table structure for table `fileuploads`
--

CREATE TABLE `fileuploads` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `upload` varchar(250) NOT NULL,
  `datecr` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `financial_guardian`
--

CREATE TABLE `financial_guardian` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `address` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occupation` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `signature` varbinary(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guardian_tb`
--

CREATE TABLE `guardian_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `childid` int(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `stipend` text,
  `datecreated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `humanresourcescontact`
--

CREATE TABLE `humanresourcescontact` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `nameofcompany` varchar(100) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `emailaddress` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `identification_tb`
--

CREATE TABLE `identification_tb` (
  `id` int(10) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `idnumber` varchar(20) DEFAULT NULL,
  `issuedate` varchar(50) DEFAULT NULL,
  `expirydate` varchar(50) DEFAULT NULL,
  `issueplace` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_tb`
--

CREATE TABLE `insurance_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `company` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `beneficiary` text,
  `facevalue` varchar(50) DEFAULT NULL,
  `options` varchar(10) DEFAULT NULL,
  `comment` text,
  `pension_plan` varchar(5) DEFAULT NULL,
  `rsano` varchar(20) DEFAULT NULL,
  `pension_admin` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investmenttrust_tb`
--

CREATE TABLE `investmenttrust_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `willtype` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `maidenname` varchar(50) DEFAULT NULL,
  `identificationtype` varchar(50) DEFAULT NULL,
  `idnumber` varchar(50) DEFAULT NULL,
  `issuedate` varchar(50) DEFAULT NULL,
  `expirydate` varchar(50) DEFAULT NULL,
  `issueplace` varchar(50) DEFAULT NULL,
  `employmentstatus` varchar(50) DEFAULT NULL,
  `employer` text,
  `employerphone` varchar(50) DEFAULT NULL,
  `employeraddr` text,
  `maritalstatus` varchar(50) DEFAULT NULL,
  `spousename` varchar(50) DEFAULT NULL,
  `spouseemail` varchar(50) DEFAULT NULL,
  `spousephone` varchar(20) DEFAULT NULL,
  `spousedob` varchar(10) DEFAULT NULL,
  `spouseaddr` text,
  `spousecity` varchar(50) DEFAULT NULL,
  `spousestate` varchar(50) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `cityofmarriage` varchar(50) DEFAULT NULL,
  `countryofmarriage` varchar(50) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `nextofkinfullname` varchar(100) DEFAULT NULL,
  `nextofkintelephone` varchar(20) DEFAULT NULL,
  `nextofkinemail` varchar(50) DEFAULT NULL,
  `nextofkinaddress` text,
  `nameofcompany` varchar(100) DEFAULT NULL,
  `humanresourcescontacttelephone` varchar(20) DEFAULT NULL,
  `humanresourcescontactemailaddress` varchar(50) DEFAULT NULL,
  `request_amount` text,
  `investment_returns` text,
  `principal` text,
  `trustperiod` text,
  `additionalinvestment` text,
  `returntoBeneficiary` text,
  `paymentofInvestmentreturns` text,
  `paymentofreturns` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investment_access_level`
--

CREATE TABLE `investment_access_level` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `access` enum('0','1','2','3','4','5','6','7','8','9','10') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investment_beneficiary`
--

CREATE TABLE `investment_beneficiary` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investment_beneficiary_status`
--

CREATE TABLE `investment_beneficiary_status` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investment_form`
--

CREATE TABLE `investment_form` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `maritalstatus` varchar(30) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `kin` varchar(50) DEFAULT NULL,
  `kinaddr` text,
  `spname` varchar(50) DEFAULT NULL,
  `spaddr` text,
  `spphone` varchar(20) DEFAULT NULL,
  `sdob` varchar(10) DEFAULT NULL,
  `idtype` varchar(30) DEFAULT NULL,
  `dateissued` varchar(20) DEFAULT NULL,
  `expirydate` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investment_nextofkin`
--

CREATE TABLE `investment_nextofkin` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `maidenname` varchar(100) DEFAULT NULL,
  `address` text,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `dateposted` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `investment_request_savings`
--

CREATE TABLE `investment_request_savings` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `investment_sum` text,
  `investment_returns` text,
  `principal_fund` text,
  `investment_period` text,
  `additional_investment` text,
  `pay_both_to_beneficiaries` text,
  `pay_returns_only_to_beneficiaries` text,
  `reinvest_entire_principal` text,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `layout`
--

CREATE TABLE `layout` (
  `id` int(11) NOT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `meta-title` varchar(200) DEFAULT NULL,
  `meta-keywords` varchar(250) DEFAULT NULL,
  `meta-descp` varchar(250) DEFAULT NULL,
  `top-l` text,
  `top-r` text,
  `head-l` text,
  `head-r` text,
  `nav-text` text,
  `slide1` varchar(200) DEFAULT NULL,
  `slide2` varchar(200) DEFAULT NULL,
  `slide3` varchar(200) DEFAULT NULL,
  `slide4` varchar(200) DEFAULT NULL,
  `slide5` varchar(200) DEFAULT NULL,
  `slide6` varchar(200) DEFAULT NULL,
  `slide-box` text,
  `home-caption1` varchar(250) DEFAULT NULL,
  `home-text1` text,
  `home-caption2` varchar(100) DEFAULT NULL,
  `home-text2` text,
  `home-caption3` varchar(200) DEFAULT NULL,
  `home-text3` text,
  `home-caption4` varchar(300) DEFAULT NULL,
  `home-text4` text,
  `home-caption5` varchar(200) DEFAULT NULL,
  `home-text5` text,
  `home-caption6` varchar(200) DEFAULT NULL,
  `home-text6` text,
  `footer-1` text,
  `footer-2` text,
  `footer-3` text,
  `footer-4` text,
  `base-l` varchar(250) DEFAULT NULL,
  `base-r` varchar(250) DEFAULT NULL,
  `contact-text1` text,
  `contact-text2` text,
  `contact-text3` text,
  `contact-text4` text,
  `contact-email` varchar(100) DEFAULT NULL,
  `google-map` text,
  `fb-likebox` text,
  `custom-css` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `layout`
--

INSERT INTO `layout` (`id`, `logo`, `url`, `meta-title`, `meta-keywords`, `meta-descp`, `top-l`, `top-r`, `head-l`, `head-r`, `nav-text`, `slide1`, `slide2`, `slide3`, `slide4`, `slide5`, `slide6`, `slide-box`, `home-caption1`, `home-text1`, `home-caption2`, `home-text2`, `home-caption3`, `home-text3`, `home-caption4`, `home-text4`, `home-caption5`, `home-text5`, `home-caption6`, `home-text6`, `footer-1`, `footer-2`, `footer-3`, `footer-4`, `base-l`, `base-r`, `contact-text1`, `contact-text2`, `contact-text3`, `contact-text4`, `contact-email`, `google-map`, `fb-likebox`, `custom-css`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 'fcmbtrustees@fcmb.com', '+234 1 290 2721', 'write your will', 'create your trust', NULL, '5.jpg', '9.jpg', '1.jpg', '7.jpg', 'banner.jpg', NULL, NULL, 'Corporate Trust Services', '<p>We act as Trustees to numerous credit or debt-related transactions locally and internationally and offer a full range of Trust-related services.&nbsp;</p>', 'Private Wealth Services', '<p>A significant aspect of our services involve helping private individuals organise, grow and protect their assets efficiently.</p>', 'Other Services', '<p>At FCMB Trustees Limited, we offer other services including; Escrow Services and Co-operative Schemes.</p>', 'We Create Experiences', '<p>To explore the option of protecting and transferring your assets efficiently as a way to avoid certain pitfalls; FCMB Trustees is letting users draw up sophisticated, seamless and legally valid Trusts to grow, protect and transfer their assets on the go.&nbsp;</p>', 'We make Asset transfer easier!', '<p>Although the end of life is something you probably don\'t want to dwell on, deciding what will happen to your assets and possessions after you pass on is important. Preparing a Will is the simplest way to ensure that your funds and property will be distributed according to your wishes.<br />\r\n<strong>FCMB Trustees</strong> provides a free and simple way to compose your own legal Will online in a few easy steps:</p>', 'Subscribe to our newsletter', NULL, 'FCMB Trustees Limited. All rights reserved.', NULL, NULL, NULL, NULL, NULL, 'FCMB Trustees Ltd', '2nd Floor, FCMB HQ, <br>Primrose Tower, <br> 17A Tinubu Street,<br/> Lagos.', 'fcmbtrustees@fcmb.com', '+234 1 290 2721', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

CREATE TABLE `mail_templates` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `thead` text NOT NULL,
  `tfooter` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `uid`, `status`, `name`, `thead`, `tfooter`) VALUES
(2, 2, '1', 'FCMB Trustees', '<body>\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border: px solid #000\" width=\"600\" height:700px;>\r\n  <tbody>\r\n    <tr>\r\n      <td height=\"102\" align=\"center\" bgcolor=\"#ffffff\">\r\n        <img src=\"https://fcmbtrustees.com/portal/images/template/logo.png\"/>      </td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" valign=\"top\" style=\"padding: 10px; font-family: \"Courier New\", Courier, mono ; color:#000; line-height:150%;\"><table width=\"100%\"  border=\"0\" cellspacing=\"1\" cellpadding=\"15\">\r\n            <tr>\r\n              <td>', '<br>\r\n      <br> \r\n      <br> \r\n\r\n      Thanks for choosing FCMB Trustees</td>\r\n            </tr>\r\n          </table></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" bgcolor=\"#ffffff\" > <a href=\"https://www.facebook.com/csltrustees/\" target=\"_blank\"><img src=\"https://fcmbtrustees.com/portal/images/template/facebook.png\" /></a> &nbsp; <a href=\"https://twitter.com/fcmbtrustees\" target=\"_blank\"><img src=\"https://fcmbtrustees.com/portal/images/template/twitter.png\" /></a> &nbsp; <a href=\"https://www.instagram.com/fcmbtrusteeslimited/\" target=\"_blank\"><img src=\"https://fcmbtrustees.com/portal/images/template/instagram.png\" /></a> &nbsp; <a href=\"https://www.linkedin.com/company/csltrustees/\" target=\"_blank\"><img src=\"https://fcmbtrustees.com/portal/images/template/linkedin.png\" /></a> </td> \r\n    </tr>\r\n  </tbody>\r\n</table>\r\n</body>\r\n'),
(4, 3, '1', 'LBIC Plc', '<body>\r\n<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border: px solid #000\" width=\"600\" height:700px;>\r\n  <tbody>\r\n    <tr>\r\n      <td height=\"102\" align=\"center\" bgcolor=\"#ffffff\">\r\n        <img src=\"https://tisvdigital.com/lbic/images/lbic-logo.png\" />      </td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" valign=\"top\" style=\"padding: 10px; font-family: \"Courier New\", Courier, mono ; color:#000; line-height:150%;\"><table width=\"100%\"  border=\"0\" cellspacing=\"1\" cellpadding=\"15\">\r\n            <tr>\r\n              <td>', '<br>\r\n      <br> \r\n      <br> \r\n\r\n      Thanks for choosing LBIC Plc</td>\r\n            </tr>\r\n          </table></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" bgcolor=\"#ffffff\" > <a href=\"https://web.facebook.com/LBIC-PLC-1059931680751157/?_rdc=1&_rdr\" target=\"_blank\"><img src=\"https://fcmbtrustees.com/portal/images/template/facebook.png\" /></a> &nbsp; <a href=\"https://twitter.com/LbicPlc\" target=\"_blank\"><img src=\"https://fcmbtrustees.com/portal/images/template/twitter.png\" /></a> &nbsp; <a href=\"https://www.instagram.com/lbicplc/\" target=\"_blank\"><img src=\"https://fcmbtrustees.com/portal/images/template/instagram.png\" /></a></td> \r\n    </tr>\r\n  </tbody>\r\n</table>\r\n</body>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `management`
--

CREATE TABLE `management` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `descrp` text,
  `slug` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `rate_ord` enum('0','1','2','3','4','5','6','7','8','9','10') DEFAULT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `management`
--

INSERT INTO `management` (`id`, `name`, `position`, `image`, `descrp`, `slug`, `category`, `rate_ord`, `datecreated`) VALUES
(1, 'Oluwayemisi Arowolo', 'Team Lead, Corporate Trust Services', 'Oluwayemisi-Arowolo.jpg', '<p>Mrs. Oluwayemisi Arowolo is a Law graduate of the University of Ado Ekiti and was called to the Nigerian Bar in 2005.</p>\r\n\r\n<p>She began her legal career with the law firm of Wale Omotosho &amp; Co. as a Counsel in Chambers from where she joined Intercontinental Bank Plc and worked in the Product Development, Private Banking &amp; Wealth Management divisions respectively, as well as the Legal Department of the bank.</p>\r\n\r\n<p>Oluwayemisi thereafter joined Access Bank Plc, where she worked as a Corporate Counsel and Credit Documentation Officer.</p>\r\n\r\n<p>She is presently the Team Lead, Corporate Trust Services at FCMB Trustees Ltd, where she leads the team that handles Loan Syndication, Debenture and Bonds, Unit Trust Schemes services, amongst others.</p>', 'Oluwayemisi-Arowolo', 'Management Team', '4', '2020-01-27 13:04:40'),
(2, 'Adekunle Awoderu', 'Head, Finance and Operations', 'Adekunle-Awoderu.jpg', '<p style=\"margin-left:0in; margin-right:0in\">Adekunle started his career as a trainee in KPMG in 1995, he worked as an Account Officer in United Bank for Africa (UBA) Plc,&nbsp;from where he moved to Adewale Osinowo &amp; Co. an audit firm as Senior Auditor. He also worked in Toyota Nigeria Limited as an Assistant Manager in charge of Finance and Accounts until 2004 when he joined FCMB.</p>\r\n\r\n<p style=\"margin-left:0in; margin-right:0in\">He joined CSL in 2004 as the Deputy Head of&nbsp;Financial Control. Thereafter, he became the Head of&nbsp;Financial Control before he was deployed to Head the Internal Control and Compliance Units. He is currently the Head of Finance and Operations in FCMB Trustees Limited.</p>\r\n\r\n<p style=\"margin-left:0in; margin-right:0in\">Adekunle holds a Higher National Diploma in Accountancy from Federal Polytechnic, Ilaro. He is a fellow of the Institute of Chartered Accountants of Nigeria (ICAN);&nbsp;fellow of Certified Pension Institute of Nigeria;&nbsp;Associate member of Chartered institute of Taxation of Nigeria and certified member of the Institute of Financial Consultants, Canada. He has attended several courses both locally and internationally.</p>', 'Adekunle-Awoderu', 'Management Team', '2', '2020-01-27 13:05:29'),
(3, 'Abiodun Jinadu', 'Head, Risk Management, Control and Compliance', 'Abiodun-Jinadu.jpg', '<p>Abiodun Jinadu joined the FCMB Group as an officer in the Internal Control department of City Securities Limited in October 2006. Thereafter, he was redeployed to the Branch Control unit of First City Monument Bank Limited in September 2010, from where he moved to FCMB Trustees Limited as Head of&nbsp;Risk Management, Control and Compliance.</p>\r\n\r\n<p>Prior to joining FCMB Group in 2006, he worked as an Internal Control Officer at&nbsp;UBA Plc in 2000 and later moved to Spaceworld International Airline Ltd as a station accountant in 2004, from where he had a brief stint with Skye Bank Plc as an operation staff in 2006. Abiodun&nbsp;holds&nbsp;a&nbsp;Higher National Diploma in&nbsp;Accountancy from Federal&nbsp; Polytechnic in Offa, Kwara State. He has been an Associate of the Institute of Chartered Accountants of Nigeria (ICAN) since 2007.</p>', 'Abiodun-Jinadu', 'Management Team', '3', '2020-01-27 12:55:17'),
(4, 'Ladi Balogun', 'Chairman', 'mr-ladi-balogun.jpg', '<p>Ladi Balogun joined the FCMB group in 1996 as an Executive Assistant to the Chairman and Chief Executive. He has worked in various areas of the bank, including Treasury, Corporate Banking and Investment Banking. He was appointed an Executive Director in charge of the Institutional Banking Group (IBG) in 1997.</p>\r\n\r\n<p>In 2000,&nbsp;he was made Executive Director in charge of Strategy and Business Development and in 2001, he became Deputy Managing Director and was appointed the Managing Director of the bank in 2005.&nbsp;</p>\r\n\r\n<p>Ladi has extensive experience in Commercial and Investment Banking in Europe, the United States of America and Africa. He began his banking career in 1993 at Morgan Grenfell and Co Limited, where he worked in the areas of Risk Management and Corporate Finance (debt origination). He was responsible for managing the bank\'s trading and investment positions in Debt Instruments in Latin America and Eastern Europe. He was also part of a team that structured numerous complex debt deals in Latin America, Eastern Europe and the Asian sub-continent.</p>\r\n\r\n<p>Subsequently, he worked at Citibank in New York before returning to Nigeria in 1996. Ladi holds a Bachelor\'s degree in Economics from the University of East Anglia, United Kingdom and an MBA from Harvard Business School, United States of America. In 2017, Ladi became&nbsp;the Group Chief Executive of FCMB Group Plc.</p>', 'Ladi-Balogun', 'Board of Directors', '1', '2019-08-02 10:58:34'),
(5, 'Yemisi Edun', 'Director', 'yemisi-edun.jpg', '<p style=\"margin-left:0in; margin-right:0in\">&nbsp;</p>\r\n\r\n<p>Yemisi Edun holds a Bachelor of Science degree in Chemistry from the University of Ife, Ile-Ife and a Master\'s degree in International Accounting and Finance from the University of Liverpool, United Kingdom.</p>\r\n\r\n<p>She is a Fellow of the Institute of Chartered Accountants of Nigeria and a CFA&reg; Charter holder. She is also an Associate Member of the Chartered Institute of Stockbrokers, an Associate Member of the Institute of Taxation of Nigeria; a Member of Information Systems Audit and Control, U.S.A; and a Certified Information Systems Auditor.</p>\r\n\r\n<p>Yemisi began her career with Akintola Williams Deloitte (member firm of Deloitte Touch&eacute; Tohmatsu) in 1987, with a focus in Corporate Finance activities. She was also involved in the audit of banks and other financial institutions. She joined FCMB in&nbsp;2000 as Divisional Head of Internal Audit and Control before assuming the role of Chief Financial Officer of the Bank. Yemisi now holds the position of Executive Director: Finance/ Chief Financial Officer of First City Monument Bank Ltd.</p>', 'Yemisi-Edun', 'Board of Directors', '3', '2019-08-02 10:53:21'),
(7, 'Gboyega Balogun', 'Director', 'mr-gboyega-balogun.jpg', '<p>Gboyega holds a BSc. in Economics and Management from the University of London (Royal Holloway College), and MSc. in Property Investment from City University, London.&nbsp;</p>\r\n\r\n<p>He was a registered representative of the New York Stock Exchange (Series 7), the London Stock Exchange, through his accreditation with Futures and Securities Association Registration (SFA) and is now an authorised dealer on the Nigerian Stock Exchange.</p>\r\n\r\n<p>Gboyega\'s professional career began as a trainee with Merrill Lynch International Bank Chester Street, London and subsequently moved to Private Wealth Management in Merrill Lynch Financial Centre (London) within a team of Financial Consultants managing in excess of $600m in assets for Ultra High Net Worth clients in the African and Middle East Region.</p>\r\n\r\n<p>He returned to Nigeria in 2003, assuming the position of Divisional Head of Stockbroking, Asset Management and Registrars business. In 2008, Gboyega was appointed Managing Director of CSL Stockbrokers Limited.</p>', 'Gboyega-Balogun', 'Board of Directors', '5', '2019-08-02 11:14:50'),
(9, 'Bukola Smith', 'Director', 'bukola-smith.jpg', '<p>Bukola began her banking career in 1993 with FSB International Bank Plc where she worked&nbsp;in the Funds Transfer;&nbsp;International Trade;&nbsp;Treasury and Private Banking departments.</p>\r\n\r\n<p>She joined Fidelity Bank in 2000, becoming Divisional Head of Treasury and Institutional Banking in 2004. In 2006, she then joined FCMB and has worked in various capacities as Divisional Head, Group Internal Audit;&nbsp;Divisional Head, Investment Banking &amp; Financial Markets; Group Head, Treasury &amp; Financial Institution&nbsp;and Regional Head, Lagos. Bukola is currently Executive Director of Business Development at First City Monument Bank Ltd.</p>\r\n\r\n<p>She holds a Bachelor\'s degree in Economics from the University of Lagos. Associate of Institute of Chartered Accountants of Nigeria (1998) and Chartered Institute of Pension Management (2005).</p>', 'Bukola-Smith', 'Board of Directors', '4', '2019-08-02 11:03:02'),
(10, 'Samuel Adesanmi', 'Managing Director', 'samuel-adesanmi.jpg', '<p>Mr Samuel Adesanmi holds a HND in Accountancy from The Polytechnic, Ibadan. He is a Fellow of the Chartered Institute of Accountants of Nigeria (ICAN) and the Certified Pension Institute of Nigeria (CPIN).</p>\r\n\r\n<p>He has extensive work experience from several organisations such as&nbsp;Societe General Bank, where he was the Head of Final Accounts;&nbsp;United Commercial Bank in a corporate banking role;&nbsp;Vice President in Fundcorp Finance and Securities; and as the Financial Controller in Wood Industries Limited. He had a stint as the Head of Operations in Primrose Savings and Loans before joining Owofemi Alamu &amp; Co. as Managing Partner.</p>\r\n\r\n<p>Samuel joined CSL in 2001 as the Financial Controller and rose to become Head, Control &amp; Compliance. In 2013, he was appointed Managing Director of FCMB Trustees Limited.</p>', 'Samuel-Adesanmi', 'Board of Directors', '2', '2019-08-02 10:36:19'),
(11, 'Samuel Adesanmi', 'Managing Director', 'samuel-adesanmi(1).jpg', '<p>Mr Samuel Adesanmi holds a&nbsp;HND in Accountancy from The Polytechnic, Ibadan. He is a Fellow of the Chartered Institute of Accountants of Nigeria (ICAN) and the Certified Pension Institute of Nigeria (CPIN).</p>\r\n\r\n<p>He has extensive work experience from several organisations such as&nbsp;Societe General Bank, where he was the Head of Final Accounts;&nbsp;United Commercial Bank in a corporate banking role;&nbsp;Vice President in Fundcorp Finance and Securities; and as the Financial Controller in Wood Industries Limited. He had a stint as the Head of Operations in Primrose Savings and Loans before joining Owofemi Alamu &amp; Co. as Managing Partner.</p>\r\n\r\n<p>Samuel joined CSL in 2001 as the Financial Controller and rose to become Head, Control &amp; Compliance. In 2013, he was appointed Managing Director of FCMB Trustees Limited.</p>', 'Samuel-Adesanmi', 'Management Team', '1', '2019-08-02 10:36:36'),
(12, 'Osamuede Fadaka', 'Team Lead, Private Trust Services', 'Osamuede-Fadaka.jpg', '<p>Osamuede joined the FCMB Group as a Junior Sales Consultant in the Retail Business Unit of CSL Stockbrokers Limited in May 2008. Thereafter, she was redeployed to the Wealth Investment Management Unit in 2010, from where She moved to the Local Institutional Unit in 2014.</p>\r\n\r\n<p>She proceeded to work in Kedari Capital Limited in 2016 as a Senior Associate in the Asset Management Unit of the company, before finally returning to the FCMB Group to work in FCMB Trustees Limited.</p>\r\n\r\n<p>Osamuede is presently the Team Lead, Private Trust Services where she leads the team that handles Wills, Private/Living Trust, Education Trust services amongst others.</p>\r\n\r\n<p>She holds a B. Arts in English from Ambrose Alli University Ekpoma, Edo State and an MBA from Lagos State University.</p>', 'Osamuede-Fadaka', 'Management Team', '5', '2020-01-27 13:15:56');

-- --------------------------------------------------------

--
-- Table structure for table `marital_status`
--

CREATE TABLE `marital_status` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mgt_cat`
--

CREATE TABLE `mgt_cat` (
  `id` int(5) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mgt_cat`
--

INSERT INTO `mgt_cat` (`id`, `category`) VALUES
(1, 'Management Team'),
(2, 'Board of Directors');

-- --------------------------------------------------------

--
-- Table structure for table `nextofkin`
--

CREATE TABLE `nextofkin` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `maidenname` varchar(100) DEFAULT NULL,
  `address` text,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `dateposted` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `overall_asset`
--

CREATE TABLE `overall_asset` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `beneficiaryid` int(10) DEFAULT NULL,
  `propertyid` int(10) DEFAULT NULL,
  `property_type` varchar(50) DEFAULT NULL,
  `percentage` varchar(5) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `page_cat`
--

CREATE TABLE `page_cat` (
  `id` int(11) NOT NULL,
  `pg_cat` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_cat`
--

INSERT INTO `page_cat` (`id`, `pg_cat`) VALUES
(31, 'Corporate Trust Services'),
(30, 'Our Services'),
(29, 'About Us'),
(32, 'Private Wealth Services'),
(33, 'Other Services');

-- --------------------------------------------------------

--
-- Table structure for table `page_template`
--

CREATE TABLE `page_template` (
  `id` int(5) NOT NULL,
  `name` varchar(100) DEFAULT 'default'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_template`
--

INSERT INTO `page_template` (`id`, `name`) VALUES
(6, 'management'),
(7, 'board'),
(8, 'faq'),
(9, 'will-faq'),
(10, 'will-faq'),
(11, 'step-guide'),
(12, 'downloads');

-- --------------------------------------------------------

--
-- Table structure for table `payment_tb`
--

CREATE TABLE `payment_tb` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `transactionid` varchar(10) DEFAULT NULL,
  `willtype` varchar(200) DEFAULT NULL,
  `amount` varchar(10) DEFAULT NULL,
  `datepaid` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pension_tb`
--

CREATE TABLE `pension_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `company` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `beneficiary` text,
  `facevalue` varchar(50) DEFAULT NULL,
  `options` varchar(10) DEFAULT NULL,
  `comment` text,
  `pension_plan` varchar(5) DEFAULT NULL,
  `rsano` varchar(20) DEFAULT NULL,
  `pension_admin` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `salutation` varchar(20) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `lga` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `aphone` varchar(15) DEFAULT NULL,
  `msg` text,
  `city` varchar(10) DEFAULT NULL,
  `rstate` varchar(20) DEFAULT NULL,
  `maidenname` varchar(255) DEFAULT NULL,
  `employment_status` varchar(50) DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  `employer` text,
  `employerphone` varchar(50) DEFAULT NULL,
  `employeraddr` text,
  `passport` varchar(200) DEFAULT NULL,
  `identification_type` varchar(50) DEFAULT NULL,
  `identification_number` varchar(50) DEFAULT NULL,
  `issuedate` varchar(20) DEFAULT NULL,
  `expirydate` varchar(20) DEFAULT NULL,
  `issuedplace` varchar(50) DEFAULT NULL,
  `earning_type` varchar(50) DEFAULT NULL,
  `earning_note` text,
  `annual_income` varchar(100) DEFAULT NULL,
  `nameofcompany` varchar(255) DEFAULT NULL,
  `company_telephone` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `physical_guardian`
--

CREATE TABLE `physical_guardian` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `address` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occupation` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `signature` varbinary(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `premiumwill_tb`
--

CREATE TABLE `premiumwill_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `willtype` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `employmentstatus` varchar(50) DEFAULT NULL,
  `employer` text,
  `employerphone` varchar(50) DEFAULT NULL,
  `employeraddr` text,
  `maritalstatus` varchar(50) DEFAULT NULL,
  `spname` varchar(50) DEFAULT NULL,
  `spemail` varchar(50) DEFAULT NULL,
  `spphone` varchar(20) DEFAULT NULL,
  `sdob` varchar(10) DEFAULT NULL,
  `spaddr` text,
  `spcity` varchar(50) DEFAULT NULL,
  `spstate` varchar(50) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `marriagecity` varchar(50) DEFAULT NULL,
  `marriagecountry` varchar(50) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `addinfo` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `premium_will`
--

CREATE TABLE `premium_will` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `employer` text,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `spname` varchar(50) DEFAULT NULL,
  `spaddr` text,
  `spphone` varchar(20) DEFAULT NULL,
  `sdob` varchar(10) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `rsano` varchar(20) DEFAULT NULL,
  `pensionadmin` varchar(100) DEFAULT NULL,
  `spinstruct` text,
  `addinfo` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `privatetrust_tb`
--

CREATE TABLE `privatetrust_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `willtype` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `employmentstatus` varchar(50) DEFAULT NULL,
  `employer` text,
  `employerphone` varchar(50) DEFAULT NULL,
  `employeraddr` text,
  `maritalstatus` varchar(50) DEFAULT NULL,
  `spname` varchar(50) DEFAULT NULL,
  `spemail` varchar(50) DEFAULT NULL,
  `spphone` varchar(20) DEFAULT NULL,
  `sdob` varchar(10) DEFAULT NULL,
  `spaddr` text,
  `spcity` varchar(50) DEFAULT NULL,
  `spstate` varchar(50) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `marriagecity` varchar(50) DEFAULT NULL,
  `marriagecountry` varchar(50) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `addinfo` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `processflow_tb`
--

CREATE TABLE `processflow_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `stage` varchar(100) DEFAULT 'Registration',
  `progress` enum('Yes','No','In-view','') DEFAULT 'No',
  `stage2` varchar(100) DEFAULT 'Completion and Submission',
  `progress2` enum('Yes','No','In-view','') DEFAULT 'No',
  `stage3` varchar(100) DEFAULT 'Receipt and drafting',
  `progress3` enum('Yes','No','In-view','') DEFAULT 'No',
  `stage4` varchar(100) DEFAULT 'Review',
  `progress4` enum('Yes','No','In-view','') DEFAULT 'No',
  `stage5` varchar(100) DEFAULT 'Execution',
  `progress5` enum('Yes','No','In-view','') DEFAULT 'No',
  `stage6` varchar(100) DEFAULT 'Registry and Lodgment',
  `progress6` enum('Yes','No','In-view','') DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservetrust_tb`
--

CREATE TABLE `reservetrust_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `willtype` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `maidenname` varchar(50) DEFAULT NULL,
  `identificationtype` varchar(50) DEFAULT NULL,
  `idnumber` varchar(50) DEFAULT NULL,
  `issuedate` varchar(50) DEFAULT NULL,
  `expirydate` varchar(50) DEFAULT NULL,
  `issueplace` varchar(50) DEFAULT NULL,
  `employmentstatus` varchar(50) DEFAULT NULL,
  `employer` text,
  `employerphone` varchar(50) DEFAULT NULL,
  `employeraddr` text,
  `maritalstatus` varchar(50) DEFAULT NULL,
  `spousename` varchar(50) DEFAULT NULL,
  `spouseemail` varchar(50) DEFAULT NULL,
  `spousephone` varchar(20) DEFAULT NULL,
  `spousedob` varchar(10) DEFAULT NULL,
  `spouseaddr` text,
  `spousecity` varchar(50) DEFAULT NULL,
  `spousestate` varchar(50) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `cityofmarriage` varchar(50) DEFAULT NULL,
  `countryofmarriage` varchar(50) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `nextofkinfullname` varchar(100) DEFAULT NULL,
  `nextofkintelephone` varchar(20) DEFAULT NULL,
  `nextofkinemail` varchar(50) DEFAULT NULL,
  `nextofkinaddress` text,
  `nameofcompany` varchar(100) DEFAULT NULL,
  `humanresourcescontacttelephone` varchar(20) DEFAULT NULL,
  `humanresourcescontactemailaddress` varchar(50) DEFAULT NULL,
  `request_amount` text,
  `investment_returns` text,
  `principal` text,
  `trustperiod` text,
  `additionalinvestment` text,
  `returntoBeneficiary` text,
  `paymentofInvestmentreturns` text,
  `paymentofreturns` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reserve_access_level`
--

CREATE TABLE `reserve_access_level` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `access` enum('0','1','2','3','4','5','6','7','8','9','10') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reserve_beneficiary`
--

CREATE TABLE `reserve_beneficiary` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reserve_beneficiary_status`
--

CREATE TABLE `reserve_beneficiary_status` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reserve_form`
--

CREATE TABLE `reserve_form` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `maritalstatus` varchar(30) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `kin` varchar(50) DEFAULT NULL,
  `kinaddr` text,
  `spname` varchar(50) DEFAULT NULL,
  `spaddr` text,
  `spphone` varchar(20) DEFAULT NULL,
  `sdob` varchar(10) DEFAULT NULL,
  `idtype` varchar(30) DEFAULT NULL,
  `dateissued` varchar(20) DEFAULT NULL,
  `expirydate` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reserve_nextofkin`
--

CREATE TABLE `reserve_nextofkin` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `maidenname` varchar(100) DEFAULT NULL,
  `address` text,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `dateposted` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reserve_request_savings`
--

CREATE TABLE `reserve_request_savings` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `investment_sum` text,
  `investment_returns` text,
  `principal_fund` text,
  `investment_period` text,
  `additional_investment` text,
  `pay_both_to_beneficiaries` text,
  `pay_returns_only_to_beneficiaries` text,
  `reinvest_entire_principal` text,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sec_beneficiary`
--

CREATE TABLE `sec_beneficiary` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `beneficiary` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_access_level`
--

CREATE TABLE `simplewill_access_level` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `access` enum('0','1','2','3','4','5','6','7','8','9','10') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_assets_tb`
--

CREATE TABLE `simplewill_assets_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `asset_type` text,
  `bvn` text,
  `account_name` text,
  `account_no` text,
  `bankname` text,
  `accounttype` text,
  `rsa` text,
  `pension_admin` text,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_beneficiary`
--

CREATE TABLE `simplewill_beneficiary` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `childid` varchar(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `percentage` varchar(10) DEFAULT NULL,
  `percentage1` varchar(10) DEFAULT NULL,
  `percentage2` varchar(10) DEFAULT NULL,
  `percentage3` varchar(10) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `passport` varchar(200) DEFAULT NULL,
  `dob` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_executors_tb`
--

CREATE TABLE `simplewill_executors_tb` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `address` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occupation` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `signature` varbinary(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_financial_guardian`
--

CREATE TABLE `simplewill_financial_guardian` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `address` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occupation` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `signature` varbinary(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_guardian`
--

CREATE TABLE `simplewill_guardian` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `address` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occupation` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `signature` varbinary(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_overall_asset`
--

CREATE TABLE `simplewill_overall_asset` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `beneficiaryid` int(10) DEFAULT NULL,
  `propertyid` int(10) DEFAULT NULL,
  `property_type` varchar(50) DEFAULT NULL,
  `percentage` varchar(5) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_pension`
--

CREATE TABLE `simplewill_pension` (
  `id` int(3) NOT NULL,
  `uid` int(5) NOT NULL,
  `rsa` varchar(255) DEFAULT NULL,
  `pension_admin` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_tb`
--

CREATE TABLE `simplewill_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `willtype` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `aphoneno` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `lga` varchar(50) DEFAULT NULL,
  `maidenname` varchar(50) DEFAULT NULL,
  `identificationtype` varchar(50) DEFAULT NULL,
  `idnumber` varchar(50) DEFAULT NULL,
  `issuedate` varchar(50) DEFAULT NULL,
  `expirydate` varchar(50) DEFAULT NULL,
  `issueplace` varchar(50) DEFAULT NULL,
  `employmentstatus` varchar(50) DEFAULT NULL,
  `employer` text,
  `employerphone` varchar(50) DEFAULT NULL,
  `employeraddr` text,
  `maritalstatus` varchar(50) DEFAULT NULL,
  `spousename` varchar(50) DEFAULT NULL,
  `spouseemail` varchar(50) DEFAULT NULL,
  `spousephone` varchar(20) DEFAULT NULL,
  `spousedob` varchar(10) DEFAULT NULL,
  `spouseaddr` text,
  `spousecity` varchar(50) DEFAULT NULL,
  `spousestate` varchar(50) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `cityofmarriage` varchar(50) DEFAULT NULL,
  `countryofmarriage` varchar(50) DEFAULT NULL,
  `divorce` varchar(10) DEFAULT NULL,
  `divorceyear` varchar(10) DEFAULT NULL,
  `nextofkinfullname` varchar(100) DEFAULT NULL,
  `nextofkintelephone` varchar(20) DEFAULT NULL,
  `nextofkinemail` varchar(50) DEFAULT NULL,
  `nextofkinaddress` text,
  `nameofcompany` varchar(100) DEFAULT NULL,
  `humanresourcescontacttelephone` varchar(20) DEFAULT NULL,
  `humanresourcescontactemailaddress` varchar(50) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `simplewill_witness_tb`
--

CREATE TABLE `simplewill_witness_tb` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `address` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occupation` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `signature` varbinary(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sourceoffund`
--

CREATE TABLE `sourceoffund` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `earning_type` varchar(100) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `annual_income` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `spouse_tb`
--

CREATE TABLE `spouse_tb` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `title` varchar(10) DEFAULT NULL,
  `fullname` varchar(70) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `phoneno` varchar(20) DEFAULT NULL,
  `altphoneno` varchar(20) DEFAULT NULL,
  `addr` text,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `marriagetype` varchar(20) DEFAULT NULL,
  `marriageyear` varchar(10) DEFAULT NULL,
  `marriagecert` varchar(50) DEFAULT NULL,
  `citym` varchar(100) DEFAULT NULL,
  `countrym` varchar(100) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trustdeed_tb`
--

CREATE TABLE `trustdeed_tb` (
  `id` int(5) NOT NULL,
  `uid` int(5) NOT NULL,
  `purposeoftrust` text,
  `nameoftrust` text,
  `initialcontribution` text,
  `dateposted` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trustee_tb`
--

CREATE TABLE `trustee_tb` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `level` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `willtype`
--

CREATE TABLE `willtype` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `amount` varchar(10) DEFAULT NULL,
  `descrp` text,
  `datep` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `will_tb`
--

CREATE TABLE `will_tb` (
  `id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `pdflink` varchar(200) DEFAULT NULL,
  `rating_order` enum('1','2','3','4','5','6','7','8','9') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `witness_tb`
--

CREATE TABLE `witness_tb` (
  `id` int(5) NOT NULL,
  `uid` int(5) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `rtionship` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addr` text,
  `address` text,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occupation` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `signature` varbinary(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_level`
--
ALTER TABLE `access_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addinfo_tb`
--
ALTER TABLE `addinfo_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adminusers`
--
ALTER TABLE `adminusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alt_beneficiary`
--
ALTER TABLE `alt_beneficiary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_legacy`
--
ALTER TABLE `assets_legacy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_tb`
--
ALTER TABLE `assets_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beneficiary_dump`
--
ALTER TABLE `beneficiary_dump`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `children_details`
--
ALTER TABLE `children_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `child_tb`
--
ALTER TABLE `child_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comprehensivewill_tb`
--
ALTER TABLE `comprehensivewill_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comprehensive_will`
--
ALTER TABLE `comprehensive_will`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divorce_tb`
--
ALTER TABLE `divorce_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education_access_level`
--
ALTER TABLE `education_access_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education_beneficiary`
--
ALTER TABLE `education_beneficiary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education_form`
--
ALTER TABLE `education_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education_tb`
--
ALTER TABLE `education_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer_tb`
--
ALTER TABLE `employer_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employmentbenefit_tb`
--
ALTER TABLE `employmentbenefit_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employment_tb`
--
ALTER TABLE `employment_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `executor_power`
--
ALTER TABLE `executor_power`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `executor_tb`
--
ALTER TABLE `executor_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_cat`
--
ALTER TABLE `faq_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fileuploads`
--
ALTER TABLE `fileuploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_guardian`
--
ALTER TABLE `financial_guardian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardian_tb`
--
ALTER TABLE `guardian_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `humanresourcescontact`
--
ALTER TABLE `humanresourcescontact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `identification_tb`
--
ALTER TABLE `identification_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurance_tb`
--
ALTER TABLE `insurance_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investmenttrust_tb`
--
ALTER TABLE `investmenttrust_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment_access_level`
--
ALTER TABLE `investment_access_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment_beneficiary`
--
ALTER TABLE `investment_beneficiary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment_beneficiary_status`
--
ALTER TABLE `investment_beneficiary_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment_form`
--
ALTER TABLE `investment_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment_nextofkin`
--
ALTER TABLE `investment_nextofkin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment_request_savings`
--
ALTER TABLE `investment_request_savings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout`
--
ALTER TABLE `layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `management`
--
ALTER TABLE `management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marital_status`
--
ALTER TABLE `marital_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mgt_cat`
--
ALTER TABLE `mgt_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nextofkin`
--
ALTER TABLE `nextofkin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overall_asset`
--
ALTER TABLE `overall_asset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_cat`
--
ALTER TABLE `page_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_template`
--
ALTER TABLE `page_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_tb`
--
ALTER TABLE `payment_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pension_tb`
--
ALTER TABLE `pension_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `physical_guardian`
--
ALTER TABLE `physical_guardian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `premiumwill_tb`
--
ALTER TABLE `premiumwill_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `premium_will`
--
ALTER TABLE `premium_will`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privatetrust_tb`
--
ALTER TABLE `privatetrust_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `processflow_tb`
--
ALTER TABLE `processflow_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservetrust_tb`
--
ALTER TABLE `reservetrust_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserve_access_level`
--
ALTER TABLE `reserve_access_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserve_beneficiary`
--
ALTER TABLE `reserve_beneficiary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserve_beneficiary_status`
--
ALTER TABLE `reserve_beneficiary_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserve_form`
--
ALTER TABLE `reserve_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserve_nextofkin`
--
ALTER TABLE `reserve_nextofkin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserve_request_savings`
--
ALTER TABLE `reserve_request_savings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sec_beneficiary`
--
ALTER TABLE `sec_beneficiary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_access_level`
--
ALTER TABLE `simplewill_access_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_assets_tb`
--
ALTER TABLE `simplewill_assets_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_beneficiary`
--
ALTER TABLE `simplewill_beneficiary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_executors_tb`
--
ALTER TABLE `simplewill_executors_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_financial_guardian`
--
ALTER TABLE `simplewill_financial_guardian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_guardian`
--
ALTER TABLE `simplewill_guardian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_overall_asset`
--
ALTER TABLE `simplewill_overall_asset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_pension`
--
ALTER TABLE `simplewill_pension`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_tb`
--
ALTER TABLE `simplewill_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simplewill_witness_tb`
--
ALTER TABLE `simplewill_witness_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sourceoffund`
--
ALTER TABLE `sourceoffund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spouse_tb`
--
ALTER TABLE `spouse_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trustdeed_tb`
--
ALTER TABLE `trustdeed_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trustee_tb`
--
ALTER TABLE `trustee_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `willtype`
--
ALTER TABLE `willtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `will_tb`
--
ALTER TABLE `will_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `witness_tb`
--
ALTER TABLE `witness_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_level`
--
ALTER TABLE `access_level`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `addinfo_tb`
--
ALTER TABLE `addinfo_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adminusers`
--
ALTER TABLE `adminusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `alt_beneficiary`
--
ALTER TABLE `alt_beneficiary`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets_legacy`
--
ALTER TABLE `assets_legacy`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets_tb`
--
ALTER TABLE `assets_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beneficiary_dump`
--
ALTER TABLE `beneficiary_dump`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `children_details`
--
ALTER TABLE `children_details`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `child_tb`
--
ALTER TABLE `child_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comprehensivewill_tb`
--
ALTER TABLE `comprehensivewill_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comprehensive_will`
--
ALTER TABLE `comprehensive_will`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divorce_tb`
--
ALTER TABLE `divorce_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education_access_level`
--
ALTER TABLE `education_access_level`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education_beneficiary`
--
ALTER TABLE `education_beneficiary`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education_form`
--
ALTER TABLE `education_form`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education_tb`
--
ALTER TABLE `education_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employer_tb`
--
ALTER TABLE `employer_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employmentbenefit_tb`
--
ALTER TABLE `employmentbenefit_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employment_tb`
--
ALTER TABLE `employment_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `executor_power`
--
ALTER TABLE `executor_power`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `executor_tb`
--
ALTER TABLE `executor_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `faq_cat`
--
ALTER TABLE `faq_cat`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fileuploads`
--
ALTER TABLE `fileuploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_guardian`
--
ALTER TABLE `financial_guardian`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guardian_tb`
--
ALTER TABLE `guardian_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `humanresourcescontact`
--
ALTER TABLE `humanresourcescontact`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `identification_tb`
--
ALTER TABLE `identification_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_tb`
--
ALTER TABLE `insurance_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investmenttrust_tb`
--
ALTER TABLE `investmenttrust_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_access_level`
--
ALTER TABLE `investment_access_level`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_beneficiary`
--
ALTER TABLE `investment_beneficiary`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_beneficiary_status`
--
ALTER TABLE `investment_beneficiary_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_form`
--
ALTER TABLE `investment_form`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_nextofkin`
--
ALTER TABLE `investment_nextofkin`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_request_savings`
--
ALTER TABLE `investment_request_savings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layout`
--
ALTER TABLE `layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `management`
--
ALTER TABLE `management`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `marital_status`
--
ALTER TABLE `marital_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mgt_cat`
--
ALTER TABLE `mgt_cat`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nextofkin`
--
ALTER TABLE `nextofkin`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overall_asset`
--
ALTER TABLE `overall_asset`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_cat`
--
ALTER TABLE `page_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `page_template`
--
ALTER TABLE `page_template`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment_tb`
--
ALTER TABLE `payment_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pension_tb`
--
ALTER TABLE `pension_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `physical_guardian`
--
ALTER TABLE `physical_guardian`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `premiumwill_tb`
--
ALTER TABLE `premiumwill_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `premium_will`
--
ALTER TABLE `premium_will`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privatetrust_tb`
--
ALTER TABLE `privatetrust_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `processflow_tb`
--
ALTER TABLE `processflow_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservetrust_tb`
--
ALTER TABLE `reservetrust_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserve_access_level`
--
ALTER TABLE `reserve_access_level`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserve_beneficiary`
--
ALTER TABLE `reserve_beneficiary`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserve_beneficiary_status`
--
ALTER TABLE `reserve_beneficiary_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserve_form`
--
ALTER TABLE `reserve_form`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserve_nextofkin`
--
ALTER TABLE `reserve_nextofkin`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserve_request_savings`
--
ALTER TABLE `reserve_request_savings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sec_beneficiary`
--
ALTER TABLE `sec_beneficiary`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_access_level`
--
ALTER TABLE `simplewill_access_level`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_assets_tb`
--
ALTER TABLE `simplewill_assets_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_beneficiary`
--
ALTER TABLE `simplewill_beneficiary`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_executors_tb`
--
ALTER TABLE `simplewill_executors_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_financial_guardian`
--
ALTER TABLE `simplewill_financial_guardian`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_guardian`
--
ALTER TABLE `simplewill_guardian`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_overall_asset`
--
ALTER TABLE `simplewill_overall_asset`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_pension`
--
ALTER TABLE `simplewill_pension`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_tb`
--
ALTER TABLE `simplewill_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `simplewill_witness_tb`
--
ALTER TABLE `simplewill_witness_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sourceoffund`
--
ALTER TABLE `sourceoffund`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spouse_tb`
--
ALTER TABLE `spouse_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trustdeed_tb`
--
ALTER TABLE `trustdeed_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trustee_tb`
--
ALTER TABLE `trustee_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `willtype`
--
ALTER TABLE `willtype`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `will_tb`
--
ALTER TABLE `will_tb`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `witness_tb`
--
ALTER TABLE `witness_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
