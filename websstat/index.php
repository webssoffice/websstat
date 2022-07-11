<?php
	/* Error handling */
	error_reporting(0);
	
	/* Total number of days from the beginning of the analysis of the site until today */
	$start_time = strtotime("11-07-2022"); // Date of starting the analysis of the site
	$end_time = strtotime(date("d-m-Y"));
	$time_diff = abs($end_time - $start_time);
	$number_days = $time_diff/86400;  // 86400 seconds in a day
	$number_days = intval($number_days);
		
	/* Total */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_total = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if (!empty($element[0]) && $element[1] != "Spider" && $element[2] != "Spider") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_total++;
		} 
		
		closedir($handle);
	} else {
		$count_total = "0";
	}
	
	/* Today */
	if (file_exists("db/".date("m-Y").".txt")) {
		$contents = file_get_contents("db/".date("m-Y").".txt");
		$records = explode("\n", $contents);
		$array = "";
		$count_today = 0;
		
		foreach ($records as $value) {
			$element = explode("#", $value);
			
			if ($element[4] == date("d-m-Y") && $element[1] != "Spider" && $element[2] != "Spider") {
				$array[] .= $element[0];
			}
		}
		
		$array = array_unique($array);
			
		foreach ($array as $value) {
			if ($element[4] == date("d-m-Y")) {
				$count_today++;
			}
		}
	} else {
		$count_today = "0";
	}
	
	/* Yesterday */
	if (file_exists("db/".date("m-Y").".txt")) {
		$contents = file_get_contents("db/".date("m-Y").".txt");
		$records = explode("\n", $contents);
		$array = "";
		$count_yesterday = 0;
		
		foreach ($records as $value) {
			$element = explode("#", $value);
			
			if ($element[4] == date("d-m-Y", strtotime("-1 day")) && $element[1] != "Spider" && $element[2] != "Spider") {
				$array[] .= $element[0];
			}
		}
		
		$array = array_unique($array);
			
		foreach ($array as $value) {
			$count_yesterday++;
		}
	} else {
		$count_yesterday = "0";
	}
	
	/* Average per day */
	$average = $count_total / $number_days;
	$count_average = round(number_format((float)$average, 1, ".", ""));
	
	/* This month */
	if (file_exists("db/".date("m-Y").".txt")) {
		$contents = file_get_contents("db/".date("m-Y").".txt");
		$records = explode("\n", $contents);
		$array = "";
		$count_this_month = 0;
		
		foreach ($records as $value) {
			$element = explode("#", $value);
			
			if ($element[1] != "Spider" && $element[2] != "Spider") {
				$array[] .= $element[0];
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_this_month++;
		}
	} else {
		$count_this_month = "0";
	}
	
	/* Last month */	
	if (file_exists("db/".date("m-Y", strtotime("-1 month")).".txt")) {
		$contents = file_get_contents("db/".date("m-Y", strtotime("-1 month")).".txt");
		$records = explode("\n", $contents);
		$array = "";
		$count_last_month = 0;
		
		foreach ($records as $value) {
			$element = explode("#", $value);
			
			if ($element[1] != "Spider" && $element[2] != "Spider") {
				$array[] .= $element[0];
			}
		}
		
		$array = array_unique($array);
	
		foreach ($array as $value) {
			$count_last_month++;
		} 
	} else {
		$count_last_month = "0";
	}
	
	/* This year */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_this_year = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != ".." && strrpos($entry, "-".date("Y").".txt") !== false) {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if (!empty($element[0]) && $element[1] != "Spider" && $element[2] != "Spider") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_this_year++;
		} 
		
		closedir($handle);
	} else {
		$count_this_year = "0";
	}
	
	/* Last year */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_last_year = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != ".." && strrpos($entry, "-".date("Y", strtotime("-1 year")).".txt") !== false) {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if (!empty($element[0]) && $element[1] != "Spider" && $element[2] != "Spider") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_last_year++;
		} 
		
		closedir($handle);
	} else {
		$count_last_year = "0";
	}
	
	/* Detailed today */
	if (!empty($_GET["v"])) {
		$variable = explode("-", $_GET["v"]);
	}
	
	if (isset($variable[0]) && isset($variable[1]) && isset($variable[2]) && is_numeric($variable[0]) && is_numeric($variable[1]) && is_numeric($variable[2])) {
		$date = $_GET["v"];
		
		if (file_exists("db/".$variable[1]."-".$variable[2].".txt")) {
			$contents = file_get_contents("db/".$variable[1]."-".$variable[2].".txt");
			$records = explode("\n", $contents);
			$count_detail = 1;
			$today_detail = "";
			
			foreach ($records as $value) {
				$element = explode("#", $value);
				
				if ($element[4] == $date && $element[1] != "Spider" && $element[2] != "Spider") {
					if ($color == 1) {
						$today_detail .= "<tbody class=\"gray\">
											<tr>
												<td class=\"border-left text-center\">".$count_detail++."</td>
												<td class=\"border-left text-center\">".$element[4]." <br> ".$element[5]."</td>
												<td class=\"border-left text-center\"><a href=\"https://geoiptool.com/en/?ip=".$element[0]."\" title=\"".$element[0]."\" target=\"_blank\">".$element[0]."</a></td>
												<td class=\"border-left text-center\">".$element[1]."</td>
												<td class=\"border-left text-center\">".$element[2]."</td>
												<td class=\"border-left text-center\">".$element[3]."</td>
												<td class=\"border-left text-center\">".preg_replace("/(?<!\ )[A-Z]/", " $0", $element[7])."</td>
												<td class=\"border-left text-center\">".preg_replace("/(?<!\ )[A-Z]/", " $0", $element[8])."</td>
												<td class=\"border-last border-right\">".$element[6]."</td>
											</tr>
										</tbody>";
						
						$color = 2;
					} else {
						$today_detail .= "<tbody class=\"white\">
											<tr>
												<td class=\"border-left text-center\">".$count_detail++."</td>
												<td class=\"border-left text-center\">".$element[4]." <br> ".$element[5]."</td>
												<td class=\"border-left text-center\"><a href=\"https://geoiptool.com/en/?ip=".$element[0]."\" title=\"".$element[0]."\" target=\"_blank\">".$element[0]."</a></td>
												<td class=\"border-left text-center\">".$element[1]."</td>
												<td class=\"border-left text-center\">".$element[2]."</td>
												<td class=\"border-left text-center\">".$element[3]."</td>
												<td class=\"border-left text-center\">".preg_replace("/(?<!\ )[A-Z]/", " $0", $element[7])."</td>
												<td class=\"border-left text-center\">".preg_replace("/(?<!\ )[A-Z]/", " $0", $element[8])."</td>
												<td class=\"border-last border-right\">".$element[6]."</td>
											</tr>
										</tbody>";
						$color = 1;
					}
				}
			}
		}
	} else {
		if (file_exists("db/".date("m-Y").".txt")) {
			$contents = file_get_contents("db/".date("m-Y").".txt");
			$records = explode("\n", $contents);
			$count_detail = 1;
			$today_detail = "";
			
			foreach ($records as $value) {
				$element = explode("#", $value);
				
				if ($element[4] == date("d-m-Y") && $element[1] != "Spider" && $element[2] != "Spider") {
					if ($color == 1) {
						$today_detail .= "<tbody class=\"gray\">
											<tr>
												<td class=\"border-left text-center\">".$count_detail++."</td>
												<td class=\"border-left text-center\">".$element[4]." <br> ".$element[5]."</td>
												<td class=\"border-left text-center\"><a href=\"https://geoiptool.com/en/?ip=".$element[0]."\" title=\"".$element[0]."\" target=\"_blank\">".$element[0]."</a></td>
												<td class=\"border-left text-center\">".$element[1]."</td>
												<td class=\"border-left text-center\">".$element[2]."</td>
												<td class=\"border-left text-center\">".substr($element[3], 0, 2)."</td>
												<td class=\"border-left text-center\">".preg_replace("/(?<!\ )[A-Z]/", " $0", $element[7])."</td>
												<td class=\"border-left text-center\">".preg_replace("/(?<!\ )[A-Z]/", " $0", $element[8])."</td>
												<td class=\"border-last border-right\">".$element[6]."</td>
											</tr>
										</tbody>";
						
						$color = 2;				
					} else {
						$today_detail .= "<tbody class=\"white\">
											<tr>
												<td class=\"border-left text-center\">".$count_detail++."</td>
												<td class=\"border-left text-center\">".$element[4]." <br> ".$element[5]."</td>
												<td class=\"border-left text-center\"><a href=\"https://geoiptool.com/en/?ip=".$element[0]."\" title=\"".$element[0]."\" target=\"_blank\">".$element[0]."</a></td>
												<td class=\"border-left text-center\">".$element[1]."</td>
												<td class=\"border-left text-center\">".$element[2]."</td>
												<td class=\"border-left text-center\">".substr($element[3], 0, 2)."</td>
												<td class=\"border-left text-center\">".preg_replace("/(?<!\ )[A-Z]/", " $0", $element[7])."</td>
												<td class=\"border-left text-center\">".preg_replace("/(?<!\ )[A-Z]/", " $0", $element[8])."</td>
												<td class=\"border-last border-right\">".$element[6]."</td>
											</tr>
										</tbody>";
						$color = 1;
					}
				}
			}
		}
	}
	
	/* Page numbering */
	if (!empty($_GET["v"])) {
		$variable = explode("-", $_GET["v"]);
	}
	
	if (isset($variable[0]) && isset($variable[1]) && isset($variable[2]) && is_numeric($variable[0]) && is_numeric($variable[1]) && is_numeric($variable[2])) {
		$date = $_GET["v"];
		$real_date = date("d-m-Y");
		$prev_day = date("d-m-Y", strtotime($date ." -1 day"));
		$next_day = date("d-m-Y", strtotime($date ." +1 day"));
		$real_next_day = date("d-m-Y", strtotime($real_date ." +1 day"));
		
		if ($start_time < strtotime($date)) {
			$back = "<li><a href=\"/websstat/index.php?v=".$prev_day."\" title=\"".$prev_day."\">&laquo;&laquo;</a></li>";
		} else {
			$back = "<li>&nbsp;</li>";
		}
		
		if (strtotime(date("d-m-Y")) > strtotime($real_next_day)) {
			$forward = "<li><a href=\"/websstat/index.php?v=".$next_day."\" title=\"".$next_day."\">&raquo;&raquo;</a></li>";
		} elseif (strtotime($next_day) < strtotime($real_next_day)) {
			$forward = "<li><a href=\"/websstat/index.php?v=".$next_day."\" title=\"".$next_day."\">&raquo;&raquo;</a></li>";
		} else {
			$forward = "<li>&nbsp;</li>";
		}
	} else {
		$date = date("d-m-Y");
		$prev_day = date("d-m-Y", strtotime($date ." -1 day"));
		$next_day = date("d-m-Y", strtotime($date ." +1 day"));
		
		if ($start_time <= strtotime(date("d-m-Y"))) {
			$back = "<li><a href=\"/websstat/index.php?v=".$prev_day."\" title=\"".$prev_day."\">&laquo;&laquo;</a></li>";
		} elseif ($start_time <= strtotime(date("d-m-Y"))) {
			$back = "<li><a href=\"/websstat/index.php?v=".$prev_day."\" title=\"".$prev_day."\">&laquo;&laquo;</a></li>";
		} else {
			$back = "<li>&nbsp;</li>";
		}
		
		if (strtotime($next_day) < strtotime(date("d-m-Y"))) {
			$forward = "<li><a href=\"/websstat/index.php?v=".$next_day."\" title=\"".$next_day."\">&raquo;&raquo;</a></li>";
		} else {
			$forward = "<li>&nbsp;</li>";
		}
	}
	
	/* Chrome */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_chrome = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[1] == "Chrome") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_chrome++;
		} 
		
		closedir($handle);
	} else {
		$count_chrome = "0";
	}

	/* Edge */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_ie = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[1] == "Edge") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_ie++;
		} 
		
		closedir($handle);
	} else {
		$count_ie = "0";
	}
	
	/* Internet Explorer */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_ie = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[1] == "Internet Explorer") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_ie++;
		} 
		
		closedir($handle);
	} else {
		$count_ie = "0";
	}
	
	/* Fiefox */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_firefox = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[1] == "Firefox") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_firefox++;
		} 
		
		closedir($handle);
	} else {
		$count_firefox = "0";
	}
	
	/* Safari */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_safari = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[1] == "Safari") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_safari++;
		} 
		
		closedir($handle);
	} else {
		$count_safari = "0";
	}
	
	/* Opera */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_opera = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[1] == "Opera") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_opera++;
		} 
		
		closedir($handle);
	} else {
		$count_opera = "0";
	}
	
	/* Spider */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_spider = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Spider") { // Modificat $element[1] in $element[2]
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_spider++;
		} 
		
		closedir($handle);
	} else {
		$count_spider = "0";
	}

	/* Windows 11 */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_win11 = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Windows 11") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_win11++;
		} 
		
		closedir($handle);
	} else {
		$count_win11 = "0";
	}
	
	/* Windows 10 */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_win10 = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Windows 10") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_win10++;
		} 
		
		closedir($handle);
	} else {
		$count_win10 = "0";
	}
	
	/* Windows 8.1 */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_win81 = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Windows 8.1") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_win81++;
		} 
		
		closedir($handle);
	} else {
		$count_win81 = "0";
	}
	
	/* Windows 8 */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_win8 = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Windows 8") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_win8++;
		} 
		
		closedir($handle);
	} else {
		$count_win8 = "0";
	}
	
	/* Windows 7 */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_win7 = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Windows 7") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_win7++;
		} 
		
		closedir($handle);
	} else {
		$count_win7 = "0";
	}
	
	/* Windows Vista */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_winvista = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Windows Vista") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_winvista++;
		} 
		
		closedir($handle);
	} else {
		$count_winvista = "0";
	}
	
	/* Windows XP */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_winxp = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Windows XP") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_winxp++;
		} 
		
		closedir($handle);
	} else {
		$count_winxp = "0";
	}
	
	/* Linux */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_linux = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Linux") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_linux++;
		} 
		
		closedir($handle);
	} else {
		$count_linux = "0";
	}
	
	/* Mac OS */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_mac = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Mac OS") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_mac++;
		} 
		
		closedir($handle);
	} else {
		$count_mac = "0";
	}
	
	/* Android */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_android = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Android") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_android++;
		} 
		
		closedir($handle);
	} else {
		$count_android = "0";
	}
	
	/* Spider */
	/* if ($handle = opendir("db/")) {
		$array = "";
		$count_spideros = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[2] == "Spider") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_spideros++;
		} 
		
		closedir($handle);
	} else {
		$count_spideros = "0";
	} */

	/* ENGLISH language */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_en = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[3] == "EN") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_en++;
		} 
		
		closedir($handle);
	} else {
		$count_en = "0";
	}
	
	/* ITALIAN language */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_it = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[3] == "IT") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_it++;
		} 
		
		closedir($handle);
	} else {
		$count_it = "0";
	}
	
	/* ROMANIAN language */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_ro = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[3] == "RO") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_ro++;
		} 
		
		closedir($handle);
	} else {
		$count_ro = "0";
	}
	
	/* RUSSIAN language */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_ru = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[3] == "RU") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_ru++;
		} 
		
		closedir($handle);
	} else {
		$count_ru = "0";
	}
	
	/* GERMAN language */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_de = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[3] == "DE") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_de++;
		} 
		
		closedir($handle);
	} else {
		$count_de = "0";
	}
	
	/* FRENCH language */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_fr = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[3] == "FR") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_fr++;
		} 
		
		closedir($handle);
	} else {
		$count_fr = "0";
	}
	
	/* SPANISH language */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_es = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[3] == "ES") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_es++;
		} 
		
		closedir($handle);
	} else {
		$count_es = "0";
	}
	
	/* HUNGARIAN language */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_hu = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[3] == "HU") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_hu++;
		} 
		
		closedir($handle);
	} else {
		$count_hu = "0";
	}
	
	/* BULGARIAN language */
	if ($handle = opendir("db/")) {
		$array = "";
		$count_bg = 0;
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$contents = file_get_contents("db/".$entry);
				$records = explode("\n", $contents);
				
				foreach ($records as $value) {
					$element = explode("#", $value);
					
					if ($element[3] == "BG") {
						$array[] .= $element[0];
					}
				}
			}
		}
		
		$array = array_unique($array);
		
		foreach ($array as $value) {
			$count_bg++;
		} 
		
		closedir($handle);
	} else {
		$count_bg = "0";
	}
	
	/* Visitors by year */
	// if ($handle = opendir("db/")) {
		// $array = "";
		// $count_years = 0;
		
		// while (false !== ($entry = readdir($handle))) {
			// if ($entry != "." && $entry != "..") {
				// $contents = file_get_contents("db/".$entry);
				// $records = explode("\n", $contents);
				
				// foreach ($records as $value) {
					// $element = explode("#", $value);
					
					// if (!empty($element[0]) && $element[1] != "Spider" && $element[2] != "Spider") {
						// $records = explode("-", $element[4]);
						// $array[] .= $element[4];
					// }
				// }
			// }
		// }
		
		// foreach ($array as $value) {
			// echo array_count_values($value);
		// }
		
		// closedir($handle);
	// } else {
		// $count_years = "0";
	// }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>websstat - Statistics and Counter</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
	<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="/websstat/css/styles.css">
	<script type="text/javascript" src="/websstat/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		})
	</script>
</head>
<body>
	<div class="loader">&nbsp;</div>
	<div id="container">
		<div id="header">&nbsp;</div>
		
		<div class="column">
			<h4>VISITORS</h4>
			<span>Total: <?php echo $count_total; ?> <em>(unique)</em></span>
			<span>Today: <?php echo $count_today; ?></span>
			<span>Yesterday: <?php echo $count_yesterday; ?></span>
			<span>Average per day: <?php echo $count_average; ?></span>
			<span>This month: <?php echo $count_this_month; ?></span>
			<span>Last month: <?php echo $count_last_month; ?></span>
			<span>This year: <?php echo $count_this_year; ?></span>
			<span>Last year: <?php echo $count_last_year; ?></span>
		</div>
		
		<div class="column">
			<h4>BROWSER</h4>
			<span>Internet Explorer: <?php echo $count_ie; ?></span>
			<span>Firefox: <?php echo $count_firefox; ?></span>
			<span>Chrome: <?php echo $count_chrome; ?></span>
			<span>Safari: <?php echo $count_safari; ?></span>
			<span>Opera: <?php echo $count_opera; ?></span>
			<span>Spider: <?php echo $count_spider; ?></span>
		</div>
		
		<div class="column">
			<h4>OS</h4>
			<span>Windows 11: <?php echo $count_win11; ?></span>
			<span>Windows 10: <?php echo $count_win10; ?></span>
			<span>Windows 8.1: <?php echo $count_win81; ?></span>
			<span>Windows 8: <?php echo $count_win8; ?></span>
			<span>Windows 7: <?php echo $count_win7; ?></span>
			<span>Windows Vista: <?php echo $count_winvista; ?></span>
			<span>Windows XP: <?php echo $count_winxp; ?></span>
			<span>Linux: <?php echo $count_linux; ?></span>
			<span>Mac OS: <?php echo $count_mac; ?></span>
			<span>Android: <?php echo $count_android; ?></span>
		</div>
		
		<div class="column">
			<h4>BROWSER LANGUAGE</h4>
			<span>English: <?php echo $count_en; ?></span>
			<span>Italian: <?php echo $count_it; ?></span>
			<span>Spanish: <?php echo $count_es; ?></span>
			<span>German: <?php echo $count_de; ?></span>
			<span>Franch: <?php echo $count_fr; ?></span>
			<span>Romanian: <?php echo $count_ro; ?></span>			
			<span>Russian: <?php echo $count_ru; ?></span>
			<span>Hungarian: <?php echo $count_hu; ?></span>
			<span>Bulgarian: <?php echo $count_bg; ?></span>
		</div>
		
		<div class="clear">&nbsp;</div>
		
		<div id="content">
			<ul>
				<?php
					if (!empty($back)) {
						echo $back;
					} 
					
					if (!empty($forward)) {
						echo $forward;
					} 
				?>
			</ul>
			
			<div class="clear">&nbsp;</div>

			<?php 
				if (!empty($today_detail)) {
					echo "<table cellspacing=\"0\" cellpadding=\"0\">";
					
					echo "<thead>
							<tr>
								<td class=\"col-one text-center\">&#8470;</td>
								<td class=\"col-two text-center\">DATE / TIME</td>
								<td class=\"col-three text-center\">IP</td>
								<td class=\"col-four text-center\">BROWSER</td>
								<td class=\"col-five text-center\">OS</td>
								<td class=\"col-six text-center\">LANGUAGE</td>
								<td class=\"col-six text-center\">COUNTRY</td>
								<td class=\"col-six text-center\">CITY</td>
								<td class=\"col-seven text-center\">REFERENCE PAGE</td>
							</tr>
						</thead>";
							
					echo $today_detail;
					
					echo "</table>";
					
					echo "<ul>";
					
					if (!empty($back)) {
						echo $back;
					} 
					
					if (!empty($forward)) {
						echo $forward;
					} 
					
					echo "</ul>";
				} else {
					echo "<p>No results!</p>";
				}
			?>
		</div>
		
		<div class="clear">&nbsp;</div>

		<div id="footer">
			<p>&copy; <?php echo date("Y"); ?>. Made with &#9829; in <a href="https://www.webss.ro">webss</a> lab.</p>
		</div>
	</div>
</body>
</html>