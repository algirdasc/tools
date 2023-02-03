SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `snippets` (
  `hash` varchar(32) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `snippetLeft` mediumtext COLLATE utf8_bin NOT NULL,
  `snippetRight` mediumtext COLLATE utf8_bin DEFAULT NULL,
  `format` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `snippets`
  ADD PRIMARY KEY (`hash`);
COMMIT;
