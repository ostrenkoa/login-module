--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_email` varchar(128) NOT NULL,
  `user_password` varchar(128) NOT NULL,
  `user_admin` tinyint(1) UNSIGNED DEFAULT NULL,
  `user_hash` varchar(128) NOT NULL,
  `user_activation_state` tinyint(1) UNSIGNED DEFAULT NULL,
  `user_activation_code` varchar(128) NOT NULL,
  `user_regdate` datetime NOT NULL,
  `user_ref_code` varchar(8) DEFAULT NULL,
  `user_refreg_code` varchar(8) DEFAULT NULL,
  `user_state` tinyint(1) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `invites`
--

CREATE TABLE IF NOT EXISTS `invites` (
  `invite_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invite_code` varchar(64) NOT NULL,
  `invite_owner_user` int(11) UNSIGNED NOT NULL,
  `invite_invited_user` int(11) UNSIGNED NOT NULL,
  `invite_state` tinyint(1) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`invite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;