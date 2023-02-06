<?php
	/* Error handling */
	error_reporting(0);

	/* Filename */
	$filename = "db/".date("m-Y").".txt";

	if (!file_exists($filename)) {			
		/* Create file if not exist */
		$handle = fopen($filename, "w+");
		fwrite($handle, "");
		fclose($handle);
			
		/* Check file for the next month */
		$next = "db/".date("m-Y", strtotime("+1 month")).".txt";
			
		if (!file_exists($next)) {
			/* If file does not exist for next month, create it */
			$handle = fopen($next, "w+");
			fwrite($handle, "");
			fclose($handle);
		}
	} else {
		/* Check the file if it can be written */
		if (is_writable($filename)) {
			/* Open the file to be written */
			if ($handle = fopen($filename, "a")) {
				/* Visitor browser */
				$browser = array("Edge" => "Edg",
								"Internet Explorer" => "MSIE|Trident",
								"Chrome" => "Google Chrome|Chrome",
								"Firefox" => "Gecko|Firefox",
								"Safari" => "Safari",
								"Opera" => "Opera",
								"Spider" => "nuhk|Googlebot|Yammybot|Openbot|Slurp|MSNBot|Ask Jeeves/Teoma|ia_archiver|YandexBlogs|YandexBot|YandexMedia|YandexAntivirus|YandexDirect|Baiduspider|Mail.RU");
						
				foreach($browser as $bs => $match) {
					if (preg_match("/".$match."/i", $_SERVER["HTTP_USER_AGENT"])) {
						break;
					}
				}
						
				/* Reference page */
				if (!empty($_SERVER["HTTP_REFERER"])) {
					$referer = $_SERVER["HTTP_REFERER"];
				} else {
					$referer = "https://www.webss.ro"; // URL's site
				}

				/* Visitor browser language */
				$languages = array("af" => "af",
					"sq" => "sq",
					"ar-dz" => "ar-dz",
					"ar-bh" => "ar-bh",
					"ar-eg" => "ar-eg",
					"ar-iq" => "ar-iq",
					"ar-jo" => "ar-jo",
					"ar-kw" => "ar-kw",
					"ar-lb" => "ar-lb",
					"ar-ly" => "ar-ly",
					"ar-ma" => "ar-mav",
					"ar-omv" => "ar-om",
					"ar-qa" => "ar-qav",
					"ar-sa" => "var-sa",
					"var-sy" => "ar-sy",
					"ar-tn" => "ar-tn",
					"ar-ae" => "ar-ae",
					"ar-ye" => "ar-ye",
					"ar" => "ar",
					"hy" => "hy",
					"as" => "as",
					"az" => "az",
					"eu" => "eu",
					"be" => "be",
					"bn" => "bn",
					"bg" => "bg",
					"ca" => "ca",
					"zh-cn" => "zh-cn",
					"zh-hk" => "zh-hk",
					"zh-mo" => "zh-mo",
					"vzh-sg" => "zh-sg",
					"zh-tw" => "zh-tw",
					"zh" => "zh",
					"hr" => "hr",
					"cs" => "cs",
					"da" => "da",
					"div" => "div",
					"nl-be" => "nl-be",
					"nl" => "nl",
					"en-au" => "en-au",
					"en-bz" => "en-bz",
					"en-ca" => "en-ca",
					"en-ie" => "en-ie",
					"en-jm" => "en-jm",
					"en-nz" => "en-nz",
					"en-ph" => "en-ph",
					"en-za" => "en-za",
					"en-tt" => "en-tt",
					"en-gb" => "en-gb",
					"en-us" => "en-us",
					"en-zw" => "en-zw",
					"en" => "en",
					"us" => "us",
					"et" => "et",
					"fo" => "fo",
					"fa" => "fa",
					"fi" => "fi",
					"fr-be" => "fr-be",
					"fr-ca" => "fr-ca",
					"fr-lu" => "fr-lu",
					"fr-mc" => "fr-mc",
					"fr-ch" => "fr-ch",
					"fr" => "fr",
					"mk" => "mk",
					"gd" => "gd",
					"ka" => "ka",
					"de-at" => "de-at",
					"de-li" => "de-li",
					"de-lu" => "de-lu",
					"de-ch" => "de-ch",
					"de" => "de",
					"el" => "el",
					"gu" => "gu",
					"he" => "he",
					"hi" => "hi",
					"hu" => "hu",
					"is" => "is",
					"id" => "id",
					"it-ch" => "it-ch",
					"it" => "it",
					"ja" => "ja",
					"kn" => "kn",
					"kk" => "kk",
					"kok" => "kok",
					"ko" => "ko",
					"kz" => "kz",
					"lv" => "lv",
					"lt" => "lt",
					"ms" => "ms",
					"ml" => "ml",
					"mt" => "mt",
					"mr" => "mr",
					"mn" => "mn",
					"ne" => "ne",
					"nb-no" => "nb-no",
					"nn-no" => "nn-no",
					"no" => "no",
					"or" => "or",
					"pl" => "pl",
					"pt-br" => "pt-br",
					"pt" => "pt",
					"pa" => "pa",
					"rm" => "rm",
					"ro-md" => "ro-md",
					"ro" => "ro",
					"ru-md" => "ru-md",
					"ru" => "ru",
					"sa" => "sa",
					"sr" => "sr",
					"sk" => "sk",
					"ls" => "ls",
					"sb" => "sb",
					"es-ar" => "es-ar",
					"es-bo" => "es-bo",
					"es-cl" => "es-cl",
					"es-co" => "es-co",
					"es-cr" => "es-cr",
					"es-do" => "es-do",
					"es-ec" => "es-ec",
					"es-sv" => "es-sy",
					"es-gt" => "es-gt",
					"es-hn" => "es-hn",
					"es-mx" => "es-mx",
					"es-ni" => "es-ni",
					"es-pa" => "es-pa",
					"es-py" => "es-py",
					"es-pe" => "es-pe",
					"es-pr" => "es-pr",
					"es-us" => "es-us",
					"es-uy" => "es-uy",
					"es-ve" => "es-ve",
					"es" => "es",
					"sx" => "sx",
					"sw" => "sw",
					"sv-fi" => "sv-fi",
					"sv" => "sv",
					"syr" => "syr",
					"ta" => "ta",
					"tt" => "tt",
					"te" => "te",
					"th" => "th",
					"ts" => "ts",
					"tn" => "tn",
					"tr" => "tr",
					"uk" => "uk",
					"ur" => "ur",
					"uz" => "uz",
					"vi" => "vi",
					"xh" => "xh",
					"yi" => "yi",
					"zu" => "zu",
					"nd" => "");
						
				foreach($languages as $language => $match) {
					if (preg_match("/".$match."/i", substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 5))) {
						break;
					} elseif (preg_match("/".strtoupper($match)."/i", substr(strtoupper($_SERVER["HTTP_ACCEPT_LANGUAGE"]), 0, 5))) {
						break;
					}
				}

				/* Country and city of origin */
				$ip = $_SERVER["REMOTE_ADDR"];
				$url = "https://www.geodatatool.com/en/?ip=".$ip."";
				$content = file_get_contents($url);
				$first_step_country = explode( '<div class="data-item">' , $content );
				$second_step_country = explode("</div>" , $first_step_country[3] );
				$third_step_country = strip_tags($second_step_country[0]);
				$four_step_country = str_replace("Country:","",$third_step_country);
				$country = trim($four_step_country);
				$first_step_city = explode( '<div class="data-item">' , $content );
				$second_step_city = explode("</div>" , $first_step_city[6] );
				$third_step_city = strip_tags($second_step_city[0]);
				$four_step_city = str_replace("City:","",$third_step_city);
				$city = trim($four_step_city);
						
				/* Today */
				$today = date("d-m-Y");
						
				/* Current time */
				$hour = date("H:i:s");

				/* Visitor OS */
				$osystem = array("Windows 3.11" => "Win16",
					"Windows 95" => "(Windows 95)|(Win95)|(Windows_95)",
					"Windows 98" => "(Windows 98)|(Win98)",
					"Windows 2000" => "(Windows NT 5.0)|(Windows 2000)",
					"Windows XP" => "(Windows NT 5.1)|(Windows XP)",
					"Windows Server 2003" => "(Windows NT 5.2)",
					"Windows Vista" => "(Windows NT 6.0)",
					"Windows 7" => "(Windows NT 7.0)|(Windows NT 6.1)",
					"Windows 8" => "(Windows NT 6.2)",
					"Windows 8.1" => "(Windows NT 6.3)",
					"Windows 10" => "(Windows NT 10.0)|(WinNT4.0)|(WinNT)|(Windows NT)",
					"Windows 11" => "(Windows NT 11.0)",
					"Windows ME" => "Windows ME",
					"Android" => "Android",
					"Open BSD" => "OpenBSD",
					"Sun OS" => "SunOS",
					"Linux" => "(Linux)|(X11)",
					"Mac OS" => "(Mac_PowerPC)|(Macintosh)",
					"QNX" => "QNX",
					"BeOS" => "BeOS",
					"OS/2" => "OS/2",
					"Spider" => "(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)");
									
				foreach($osystem as $os => $match) {
					if (preg_match("/".$match."/i", $_SERVER["HTTP_USER_AGENT"])) {
						break;
					}
				}
						
				/* Write information into the file */
				if (filesize("db/".date("m-Y").".txt") <= 2) {
					$insert = $ip."#".$bs."#".$os."#".strtoupper($language)."#".$today."#".$hour."#".$referer."#".$country."#".$city."#".$_SERVER["HTTP_USER_AGENT"]."#".$_SERVER["HTTP_ACCEPT_LANGUAGE"]."#";
				} else {
					$insert = "\n".$ip."#".$bs."#".$os."#".strtoupper($language)."#".$today."#".$hour."#".$referer."#".$country."#".$city."#".$_SERVER["HTTP_USER_AGENT"]."#".$_SERVER["HTTP_ACCEPT_LANGUAGE"]."#";
				}
						
				fwrite($handle, $insert);
				fclose($handle);
			}
		}
	}
?>