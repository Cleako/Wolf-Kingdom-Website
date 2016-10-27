<?php
	
	$statNames = array('exp_attack', 'exp_defense', 'exp_strength', 'exp_hits', 'exp_ranged', 'exp_prayer', 'exp_magic', 'exp_cooking', 'exp_woodcut', 'exp_fletching', 'exp_fishing', 'exp_firemaking', 'exp_crafting', 'exp_smithing', 'exp_mining', 'exp_herblaw', 'exp_agility', 'exp_thieving');

	$statNames2 = array('attack', 'defense', 'strength', 'hits', 'ranged', 'prayer', 'magic', 'cooking', 'woodcut', 'fletching', 'fishing', 'firemaking', 'crafting', 'smithing', 'mining', 'herblaw', 'agility', 'thieving');
	
	$experienceArray = array();
	for($index = 0, $exp = 0;$index < 119;$index++) {
		$offset = intval(($index + 1) + 300 * pow(2, ($index + 1) / 7));
		$exp += $offset;
		$experienceArray[$index] = ($exp & 0xffffffc) / 4;
	}

	function usernameToHash($s) {
		$s = strtolower($s);
		$s1 = '';
		for ($i = 0;$i < strlen($s);$i++) {
			$c = $s{$i};
			if ($c >= 'a' && $c <= 'z')
				$s1 = $s1.$c;
			else if ($c >= '0' && $c <= '9')
				$s1 = $s1.$c;
			else
				$s1 = $s1.' ';
		}

		$s1 = trim($s1);
		if (strlen($s1) > 12)
			$s1 = substr($s1, 0, 12); //trims the username down to 12 characters if more are sent

		$l = 0;
		for ($j = 0;$j < strlen($s1);$j++) {
			$c1 = $s1{$j};
			$l *= 37;
			if ($c1 >= 'a' && $c1 <= 'z')
				$l += (1 + ord($c1)) - 97;
			else if ($c1 >= '0' && $c1 <= '9')
				$l += (27 + ord($c1)) - 48;
		}
		return $l;
	}

	function hashToUsername($l) {
		if ($l < 0)
			return 'invalid_name';
		$s = '';
		while ($l != 0) {
			$i = floor(floatval($l % 37));
			$l = floor(floatval($l / 37));
			if ($i == 0)
				$s = ' '.$s;
			else if ($i < 27) {
				if ($l % 37 == 0)
					$s = chr(($i + 65) - 1).$s;
				else
					$s = chr(($i + 97) - 1).$s;
			}
			else {
				$s = chr(($i + 48) - 27).$s;
			}
		}
		return $s;
	}
	
	function experienceToLevel($exp) {
		global $experienceArray;
		for($level = 0;$level < 119;$level++) {
			if($exp >= $experienceArray[$level]) {
				continue;
			}
			return ($level + 1);
		}
		return 120; // This means were over the highest level there is
	}
	
	function encode_username($username) {
	$username = strtolower($username);
	$clean = '';
	for($i = 0;$i < strlen($username);$i++) {
		$c = ord($username{$i});
		if($c >= 97 && $c <= 122) {
			$clean .= chr($c);
		}
		else if($c >= 48 && $c <= 57) {
			$clean .= chr($c);
		}
		else {
			$clean .= ' ';
		}
	}
	$clean = trim($clean);
	if(strlen($clean) > 12) {
		$clean = substr($clean, 0, 12);
	}
	$hash = '0';
	for($i = 0;$i < strlen($clean);$i++) {
		$c = ord($clean{$i});
		$hash = bcmul($hash, 37);
		if($c >= 97 && $c <= 122) {
			$hash = bcadd($hash, (1 + $c) - 97);
		}
		else if($c >= 48 && $c <= 57) {
			$hash = bcadd($hash, (27 + $c) - 48);
		}
	}
	$rewriteValue = explode(".", $hash);
	return $rewriteValue[0];

	#return $hash;
}
	