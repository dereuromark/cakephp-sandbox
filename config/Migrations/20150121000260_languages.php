<?php

use Phinx\Migration\AbstractMigration;

class Languages extends AbstractMigration {

	/**
	 * Migrate Up.
	 *
	 * @return void
	 */
	public function up() {
		$content = <<<SQL
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ori_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `iso3` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `iso2` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `locale_fallback` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=137 ;

--
-- Daten für Tabelle `languages`
--

INSERT INTO `languages` (`id`, `name`, `ori_name`, `code`, `iso3`, `iso2`, `locale`, `locale_fallback`, `status`, `sort`, `modified`) VALUES
(1, 'Afrikaans', 'Afrikaans', 'af', '', '', 'afr', 'afr', 0, 0, '2011-07-17 15:23:08'),
(2, 'Arabic', 'Arabic', 'ar', '', '', 'ara', 'ara', 0, 0, '2011-07-17 15:23:08'),
(3, 'Arabic (U.A.E.)', 'Arabic (U.A.E.)', 'ar', '', '', 'ar_ae', 'ara', 0, 0, '2011-07-17 15:23:08'),
(4, 'Arabic (Bahrain)', 'Arabic (Bahrain)', 'ar', '', '', 'ar_bh', 'ara', 0, 0, '2011-07-17 15:23:08'),
(5, 'Arabic (Algeria)', 'Arabic (Algeria)', 'ar', '', '', 'ar_dz', 'ara', 0, 0, '2011-07-17 15:23:08'),
(6, 'Arabic (Egypt)', 'Arabic (Egypt)', 'ar', '', '', 'ar_eg', 'ara', 0, 0, '2011-07-17 15:23:08'),
(7, 'Arabic (Iraq)', 'Arabic (Iraq)', 'ar', '', '', 'ar_iq', 'ara', 0, 0, '2011-07-17 15:23:08'),
(8, 'Arabic (Jordan)', 'Arabic (Jordan)', 'ar', '', '', 'ar_jo', 'ara', 0, 0, '2011-07-17 15:23:08'),
(9, 'Arabic (Kuwait)', 'Arabic (Kuwait)', 'ar', '', '', 'ar_kw', 'ara', 0, 0, '2011-07-17 15:23:08'),
(10, 'Arabic (Lebanon)', 'Arabic (Lebanon)', 'ar', '', '', 'ar_lb', 'ara', 0, 0, '2011-07-17 15:23:08'),
(11, 'Arabic (Libya)', 'Arabic (Libya)', 'ar', '', '', 'ar_ly', 'ara', 0, 0, '2011-07-17 15:23:08'),
(12, 'Arabic (Morocco)', 'Arabic (Morocco)', 'ar', '', '', 'ar_ma', 'ara', 0, 0, '2011-07-17 15:23:08'),
(13, 'Arabic (Oman)', 'Arabic (Oman)', 'ar', '', '', 'ar_om', 'ara', 0, 0, '2011-07-17 15:23:08'),
(14, 'Arabic (Qatar)', 'Arabic (Qatar)', 'ar', '', '', 'ar_qa', 'ara', 0, 0, '2011-07-17 15:23:08'),
(15, 'Arabic (Saudi Arabia)', 'Arabic (Saudi Arabia)', 'ar', '', '', 'ar_sa', 'ara', 0, 0, '2011-07-17 15:23:08'),
(16, 'Arabic (Syria)', 'Arabic (Syria)', 'ar', '', '', 'ar_sy', 'ara', 0, 0, '2011-07-17 15:23:08'),
(17, 'Arabic (Tunisia)', 'Arabic (Tunisia)', 'ar', '', '', 'ar_tn', 'ara', 0, 0, '2011-07-17 15:23:08'),
(18, 'Arabic (Yemen)', 'Arabic (Yemen)', 'ar', '', '', 'ar_ye', 'ara', 0, 0, '2011-07-17 15:23:08'),
(19, 'Byelorussian', 'Byelorussian', 'be', '', '', 'bel', 'bel', 0, 0, '2011-07-17 15:23:08'),
(20, 'Bulgarian', 'Bulgarian', 'bg', '', '', 'bul', 'bul', 0, 0, '2011-07-17 15:23:08'),
(21, 'Bosnian', 'Bosnian', 'bs', '', '', 'bos', 'bos', 0, 0, '2011-07-17 15:23:08'),
(22, 'Catalan', 'Catalan', 'ca', '', '', 'cat', 'cat', 0, 0, '2011-07-17 15:23:08'),
(23, 'Czech', 'Czech', 'cs', '', '', 'cze', 'cze', 0, 0, '2011-07-17 15:23:08'),
(24, 'Danish', 'Danish', 'da', '', '', 'dan', 'dan', 0, 0, '2011-07-17 15:23:08'),
(25, 'German (Standard)', 'German (Standard)', 'de', '', '', 'deu', 'deu', 0, 0, '2011-07-17 15:23:08'),
(26, 'German (Austria)', 'German (Austria)', 'de', '', '', 'de_at', 'deu', 0, 0, '2011-07-17 15:23:08'),
(27, 'German (Swiss)', 'German (Swiss)', 'de', '', '', 'de_ch', 'deu', 0, 0, '2011-07-17 15:23:08'),
(28, 'German (Germany)', 'German (Germany)', 'de', '', '', 'de_de', 'deu', 0, 0, '2011-07-17 15:23:08'),
(29, 'German (Liechtenstein)', 'German (Liechtenstein)', 'de', '', '', 'de_li', 'deu', 0, 0, '2011-07-17 15:23:08'),
(30, 'German (Luxembourg)', 'German (Luxembourg)', 'de', '', '', 'de_lu', 'deu', 0, 0, '2011-07-17 15:23:08'),
(31, 'Greek', 'Greek', 'el', '', '', 'gre', 'gre', 0, 0, '2011-07-17 15:23:08'),
(32, 'English', 'English', 'en', '', '', 'eng', 'eng', 0, 0, '2011-07-17 15:23:08'),
(33, 'English (Australian)', 'English (Australian)', 'en', '', '', 'en_au', 'eng', 0, 0, '2011-07-17 15:23:08'),
(34, 'English (Belize)', 'English (Belize)', 'en', '', '', 'en_bz', 'eng', 0, 0, '2011-07-17 15:23:08'),
(35, 'English (Canadian)', 'English (Canadian)', 'en', '', '', 'en_ca', 'eng', 0, 0, '2011-07-17 15:23:08'),
(36, 'English (British)', 'English (British)', 'en', '', '', 'en_gb', 'eng', 0, 0, '2011-07-17 15:23:08'),
(37, 'English (Ireland)', 'English (Ireland)', 'en', '', '', 'en_ie', 'eng', 0, 0, '2011-07-17 15:23:08'),
(38, 'English (Jamaica)', 'English (Jamaica)', 'en', '', '', 'en_jm', 'eng', 0, 0, '2011-07-17 15:23:08'),
(39, 'English (New Zealand)', 'English (New Zealand)', 'en', '', '', 'en_nz', 'eng', 0, 0, '2011-07-17 15:23:08'),
(40, 'English (Trinidad)', 'English (Trinidad)', 'en', '', '', 'en_tt', 'eng', 0, 0, '2011-07-17 15:23:08'),
(41, 'English (United States)', 'English (United States)', 'en', '', '', 'en_us', 'eng', 0, 0, '2011-07-17 15:23:08'),
(42, 'English (South Africa)', 'English (South Africa)', 'en', '', '', 'en_za', 'eng', 0, 0, '2011-07-17 15:23:08'),
(43, 'Spanish (Spain - Traditional)', 'Spanish (Spain - Traditional)', 'es', '', '', 'spa', 'spa', 0, 0, '2011-07-17 15:23:08'),
(44, 'Spanish (Argentina)', 'Spanish (Argentina)', 'es', '', '', 'es_ar', 'spa', 0, 0, '2011-07-17 15:23:08'),
(45, 'Spanish (Bolivia)', 'Spanish (Bolivia)', 'es', '', '', 'es_bo', 'spa', 0, 0, '2011-07-17 15:23:08'),
(46, 'Spanish (Chile)', 'Spanish (Chile)', 'es', '', '', 'es_cl', 'spa', 0, 0, '2011-07-17 15:23:08'),
(47, 'Spanish (Colombia)', 'Spanish (Colombia)', 'es', '', '', 'es_co', 'spa', 0, 0, '2011-07-17 15:23:08'),
(48, 'Spanish (Costa Rica)', 'Spanish (Costa Rica)', 'es', '', '', 'es_cr', 'spa', 0, 0, '2011-07-17 15:23:08'),
(49, 'Spanish (Dominican Republic)', 'Spanish (Dominican Republic)', 'es', '', '', 'es_do', 'spa', 0, 0, '2011-07-17 15:23:08'),
(50, 'Spanish (Ecuador)', 'Spanish (Ecuador)', 'es', '', '', 'es_ec', 'spa', 0, 0, '2011-07-17 15:23:08'),
(51, 'Spanish (Spain)', 'Spanish (Spain)', 'es', '', '', 'es_es', 'spa', 0, 0, '2011-07-17 15:23:08'),
(52, 'Spanish (Guatemala)', 'Spanish (Guatemala)', 'es', '', '', 'es_gt', 'spa', 0, 0, '2011-07-17 15:23:08'),
(53, 'Spanish (Honduras)', 'Spanish (Honduras)', 'es', '', '', 'es_hn', 'spa', 0, 0, '2011-07-17 15:23:08'),
(54, 'Spanish (Mexican)', 'Spanish (Mexican)', 'es', '', '', 'es_mx', 'spa', 0, 0, '2011-07-17 15:23:08'),
(55, 'Spanish (Nicaragua)', 'Spanish (Nicaragua)', 'es', '', '', 'es_ni', 'spa', 0, 0, '2011-07-17 15:23:08'),
(56, 'Spanish (Panama)', 'Spanish (Panama)', 'es', '', '', 'es_pa', 'spa', 0, 0, '2011-07-17 15:23:09'),
(57, 'Spanish (Peru)', 'Spanish (Peru)', 'es', '', '', 'es_pe', 'spa', 0, 0, '2011-07-17 15:23:09'),
(58, 'Spanish (Puerto Rico)', 'Spanish (Puerto Rico)', 'es', '', '', 'es_pr', 'spa', 0, 0, '2011-07-17 15:23:09'),
(59, 'Spanish (Paraguay)', 'Spanish (Paraguay)', 'es', '', '', 'es_py', 'spa', 0, 0, '2011-07-17 15:23:09'),
(60, 'Spanish (El Salvador)', 'Spanish (El Salvador)', 'es', '', '', 'es_sv', 'spa', 0, 0, '2011-07-17 15:23:09'),
(61, 'Spanish (Uruguay)', 'Spanish (Uruguay)', 'es', '', '', 'es_uy', 'spa', 0, 0, '2011-07-17 15:23:09'),
(62, 'Spanish (Venezuela)', 'Spanish (Venezuela)', 'es', '', '', 'es_ve', 'spa', 0, 0, '2011-07-17 15:23:09'),
(63, 'Estonian', 'Estonian', 'et', '', '', 'est', 'est', 0, 0, '2011-07-17 15:23:09'),
(64, 'Basque', 'Basque', 'eu', '', '', 'baq', 'baq', 0, 0, '2011-07-17 15:23:09'),
(65, 'Farsi', 'Farsi', 'fa', '', '', 'per', 'per', 0, 0, '2011-07-17 15:23:09'),
(66, 'Finnish', 'Finnish', 'fi', '', '', 'fin', 'fin', 0, 0, '2011-07-17 15:23:09'),
(67, 'Faeroese', 'Faeroese', 'fo', '', '', 'fao', 'fao', 0, 0, '2011-07-17 15:23:09'),
(68, 'French (Standard)', 'French (Standard)', 'fr', '', '', 'fre', 'fre', 0, 0, '2011-07-17 15:23:09'),
(69, 'French (Belgium)', 'French (Belgium)', 'fr', '', '', 'fr_be', 'fre', 0, 0, '2011-07-17 15:23:09'),
(70, 'French (Canadian)', 'French (Canadian)', 'fr', '', '', 'fr_ca', 'fre', 0, 0, '2011-07-17 15:23:09'),
(71, 'French (Swiss)', 'French (Swiss)', 'fr', '', '', 'fr_ch', 'fre', 0, 0, '2011-07-17 15:23:09'),
(72, 'French (France)', 'French (France)', 'fr', '', '', 'fr_fr', 'fre', 0, 0, '2011-07-17 15:23:09'),
(73, 'French (Luxembourg)', 'French (Luxembourg)', 'fr', '', '', 'fr_lu', 'fre', 0, 0, '2011-07-17 15:23:09'),
(74, 'Irish', 'Irish', 'ga', '', '', 'gle', 'gle', 0, 0, '2011-07-17 15:23:09'),
(75, 'Gaelic (Scots)', 'Gaelic (Scots)', 'gd', '', '', 'gla', 'gla', 0, 0, '2011-07-17 15:23:09'),
(76, 'Gaelic (Irish)', 'Gaelic (Irish)', 'gd', '', '', 'gd_ie', 'gla', 0, 0, '2011-07-17 15:23:09'),
(77, 'Galician', 'Galician', 'gl', '', '', 'glg', 'glg', 0, 0, '2011-07-17 15:23:09'),
(78, 'Hebrew', 'Hebrew', 'he', '', '', 'heb', 'heb', 0, 0, '2011-07-17 15:23:09'),
(79, 'Hindi', 'Hindi', 'hi', '', '', 'hin', 'hin', 0, 0, '2011-07-17 15:23:09'),
(80, 'Croatian', 'Croatian', 'hr', '', '', 'hrv', 'hrv', 0, 0, '2011-07-17 15:23:09'),
(81, 'Hungarian', 'Hungarian', 'hu', '', '', 'hun', 'hun', 0, 0, '2011-07-17 15:23:09'),
(82, 'Armenian - Armenia', 'Armenian - Armenia', 'hy', '', '', 'hye', 'hye', 0, 0, '2011-07-17 15:23:09'),
(83, 'Indonesian', 'Indonesian', 'id', '', '', 'ind', 'ind', 0, 0, '2011-07-17 15:23:09'),
(84, 'Icelandic', 'Icelandic', 'is', '', '', 'ice', 'ice', 0, 0, '2011-07-17 15:23:09'),
(85, 'Italian', 'Italian', 'it', '', '', 'ita', 'ita', 0, 0, '2011-07-17 15:23:09'),
(86, 'Italian (Swiss) ', 'Italian (Swiss) ', 'it', '', '', 'it_ch', 'ita', 0, 0, '2011-07-17 15:23:09'),
(87, 'Japanese', 'Japanese', 'ja', '', '', 'jpn', 'jpn', 0, 0, '2011-07-17 15:23:09'),
(88, 'Korean', 'Korean', 'ko', '', '', 'kor', 'kor', 0, 0, '2011-07-17 15:23:09'),
(89, 'Korea (North)', 'Korea (North)', 'ko', '', '', 'ko_kp', 'kor', 0, 0, '2011-07-17 15:23:09'),
(90, 'Korea (South)', 'Korea (South)', 'ko', '', '', 'ko_kr', 'kor', 0, 0, '2011-07-17 15:23:09'),
(91, 'Russian', 'Russian', 'ru', '', '', 'koi8_r', 'rus', 0, 0, '2011-07-17 15:23:09'),
(92, 'Lithuanian', 'Lithuanian', 'lt', '', '', 'lit', 'lit', 0, 0, '2011-07-17 15:23:09'),
(93, 'Latvian', 'Latvian', 'lv', '', '', 'lav', 'lav', 0, 0, '2011-07-17 15:23:09'),
(94, 'FYRO Macedonian', 'FYRO Macedonian', 'mk', '', '', 'mk', 'mac', 0, 0, '2011-07-17 15:23:09'),
(95, 'Macedonian', 'Macedonian', 'mk', '', '', 'mk_mk', 'mac', 0, 0, '2011-07-17 15:23:09'),
(96, 'Malaysian', 'Malaysian', 'ms', '', '', 'may', 'may', 0, 0, '2011-07-17 15:23:09'),
(97, 'Maltese', 'Maltese', 'mt', '', '', 'mlt', 'mlt', 0, 0, '2011-07-17 15:23:09'),
(98, 'Dutch (Standard)', 'Dutch (Standard)', 'nl', '', '', 'dut', 'dut', 0, 0, '2011-07-17 15:23:09'),
(99, 'Norwegian Bokmal', 'Norwegian Bokmal', 'no', '', '', 'nob', 'nor', 0, 0, '2011-07-17 15:23:09'),
(100, 'Dutch (Belgium)', 'Dutch (Belgium)', 'nl', '', '', 'nl_be', 'dut', 0, 0, '2011-07-17 15:23:09'),
(101, 'Norwegian Nynorsk', 'Norwegian Nynorsk', 'no', '', '', 'nno', 'nor', 0, 0, '2011-07-17 15:23:09'),
(102, 'Norwegian', 'Norwegian', 'no', '', '', 'nor', 'nor', 0, 0, '2011-07-17 15:23:09'),
(103, 'Polish', 'Polish', 'pl', '', '', 'pol', 'pol', 0, 0, '2011-07-17 15:23:09'),
(104, 'Portuguese (Portugal)', 'Portuguese (Portugal)', 'pt', '', '', 'por', 'por', 0, 0, '2011-07-17 15:23:09'),
(105, 'Portuguese (Brazil)', 'Portuguese (Brazil)', 'pt', '', '', 'pt_br', 'por', 0, 0, '2011-07-17 15:23:09'),
(106, 'Rhaeto-Romanic', 'Rhaeto-Romanic', 'rm', '', '', 'roh', 'roh', 0, 0, '2011-07-17 15:23:09'),
(107, 'Romanian', 'Romanian', 'ro', '', '', 'rum', 'rum', 0, 0, '2011-07-17 15:23:09'),
(108, 'Romanian (Moldavia)', 'Romanian (Moldavia)', 'ro', '', '', 'ro_mo', 'rum', 0, 0, '2011-07-17 15:23:09'),
(109, 'Russian', 'Russian', 'ru', '', '', 'rus', 'rus', 0, 0, '2011-07-17 15:23:09'),
(110, 'Russian (Moldavia)', 'Russian (Moldavia)', 'ru', '', '', 'ru_mo', 'rus', 0, 0, '2011-07-17 15:23:09'),
(111, 'Sorbian', 'Sorbian', 'sb', '', '', 'wen', 'wen', 0, 0, '2011-07-17 15:23:09'),
(112, 'Slovak', 'Slovak', 'sk', '', '', 'slo', 'slo', 0, 0, '2011-07-17 15:23:09'),
(113, 'Slovenian', 'Slovenian', 'sl', '', '', 'slv', 'slv', 0, 0, '2011-07-17 15:23:09'),
(114, 'Albanian', 'Albanian', 'sq', '', '', 'alb', 'alb', 0, 0, '2011-07-17 15:23:09'),
(115, 'Serbian', 'Serbian', 'sr', '', '', 'scc', 'scc', 0, 0, '2011-07-17 15:23:09'),
(116, 'Swedish', 'Swedish', 'sv', '', '', 'swe', 'swe', 0, 0, '2011-07-17 15:23:09'),
(117, 'Swedish (Finland)', 'Swedish (Finland)', 'sv', '', '', 'sv_fi', 'swe', 0, 0, '2011-07-17 15:23:09'),
(118, 'Sutu', 'Sutu', '', '', '', 'sx', 'sx', 0, 0, '2011-07-17 15:23:09'),
(119, 'Sami (Lappish)', 'Sami (Lappish)', 'sz', '', '', 'smi', 'smi', 0, 0, '2011-07-17 15:23:09'),
(120, 'Thai', 'Thai', 'th', '', '', 'tha', 'tha', 0, 0, '2011-07-17 15:23:09'),
(121, 'Tswana', 'Tswana', 'tn', '', '', 'tsn', 'tsn', 0, 0, '2011-07-17 15:23:09'),
(122, 'Turkish', 'Turkish', 'tr', '', '', 'tur', 'tur', 0, 0, '2011-07-17 15:23:09'),
(123, 'Tsonga', 'Tsonga', 'ts', '', '', 'tso', 'tso', 0, 0, '2011-07-17 15:23:09'),
(124, 'Ukrainian', 'Ukrainian', 'uk', '', '', 'ukr', 'ukr', 0, 0, '2011-07-17 15:23:09'),
(125, 'Urdu', 'Urdu', 'ur', '', '', 'urd', 'urd', 0, 0, '2011-07-17 15:23:09'),
(126, 'Venda', 'Venda', 've', '', '', 'ven', 'ven', 0, 0, '2011-07-17 15:23:09'),
(127, 'Vietnamese', 'Vietnamese', 'vi', '', '', 'vie', 'vie', 0, 0, '2011-07-17 15:23:09'),
(128, 'Welsh', 'Welsh', 'cy', '', '', 'cym', 'cym', 0, 0, '2011-07-17 15:23:09'),
(129, 'Xhosa', 'Xhosa', 'xh', '', '', 'xho', 'xho', 0, 0, '2011-07-17 15:23:09'),
(130, 'Yiddish', 'Yiddish', 'yi', '', '', 'yid', 'yid', 0, 0, '2011-07-17 15:23:09'),
(131, 'Chinese', 'Chinese', 'zh', '', '', 'chi', 'chi', 0, 0, '2011-07-17 15:23:09'),
(132, 'Chinese (PRC)', 'Chinese (PRC)', 'zh', '', '', 'zh_cn', 'chi', 0, 0, '2011-07-17 15:23:09'),
(133, 'Chinese (Hong Kong)', 'Chinese (Hong Kong)', 'zh', '', '', 'zh_hk', 'chi', 0, 0, '2011-07-17 15:23:09'),
(134, 'Chinese (Singapore)', 'Chinese (Singapore)', 'zh', '', '', 'zh_sg', 'chi', 0, 0, '2011-07-17 15:23:09'),
(135, 'Chinese (Taiwan)', 'Chinese (Taiwan)', 'zh', '', '', 'zh_tw', 'chi', 0, 0, '2011-07-17 15:23:09'),
(136, 'Zulu', 'Zulu', 'zu', '', '', 'zul', 'zul', 0, 0, '2011-07-17 15:23:09');

SQL;

		$this->query($content);
	}

	/**
	 * Migrate Down.
	 *
	 * @return void
	 */
	public function down() {

	}

}
