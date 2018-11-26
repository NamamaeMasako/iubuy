-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1:3306
-- 產生時間： 2018 年 11 月 26 日 09:59
-- 伺服器版本: 5.7.23
-- PHP 版本： 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `iubuy`
--

-- --------------------------------------------------------

--
-- 資料表結構 `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL,
  `acount` varchar(50) NOT NULL COMMENT '會員帳號',
  `name` varchar(50) NOT NULL COMMENT '帳號暱稱',
  `email` varchar(255) NOT NULL COMMENT '綁定電子信箱',
  `admin` int(11) NOT NULL COMMENT '帳號階級',
  `premission` int(11) NOT NULL COMMENT '帳號權限',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acount_UNIQUE` (`acount`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `shops_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_shops1_idx` (`shops_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `shops`
--

DROP TABLE IF EXISTS `shops`;
CREATE TABLE IF NOT EXISTS `shops` (
  `id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `premission` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_shops_members_idx` (`members_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '名稱',
  `email` varchar(255) NOT NULL COMMENT 'email(帳號)',
  `password` varchar(255) NOT NULL COMMENT '密碼',
  `admin` int(11) DEFAULT NULL COMMENT '身分別\n0:總管理員\n1:管理員',
  `avator` varchar(45) DEFAULT NULL COMMENT '頭像',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `avator`, `remember_token`, `created_at`, `updated_at`) VALUES
(1543212378, 'ALEX', 'alex_chiou@powerbright.com.tw', '$2y$10$fZ2IeM5Vv5qrzBl2sXa3Bua/IaE6GpS9U8fp2REiUzyNb8Uub3S/i', 0, NULL, NULL, '2018-11-25 22:06:18', '2018-11-25 22:06:18');

--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_shops1` FOREIGN KEY (`shops_id`) REFERENCES `shops` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 資料表的 Constraints `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `fk_shops_members` FOREIGN KEY (`members_id`) REFERENCES `members` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
