<?php
	
	function combatCalc($attack, $defense, $strength, $hits, $ranged, $magic, $prayer){
		$calcatkdefstr = (($attack + $defense + $strength + $hits) * .25);
		$calcmagicprayer = ($magic + $prayer) * 0.125;
						
		if(($attack + $strength) < ($ranged * 1.5)){
			$defhits = ($defense + $hits) * 0.25;
			$fixrange = $ranged * 0.375;
			$newcb = $defhits + $fixrange + $calcmagicprayer;
			$base = 0;
		} else {
			$base = 1;
			$newcb = $calcatkdefstr + $calcmagicprayer;
		}

		return $newcb;
	
	}
	
	function headSprite($num){
		
		return $head;
	}	

	function drawCharacter($hc, $hsprite, $sc, $tc, $gender, $pc){
		if($hsprite == 1) {
			$hsprite = 0;
		} else if($hsprite == 4) {
			$hsprite = 1;
		} else if($hsprite == 6) {
			$hsprite = 2;
		} else if($hsprite == 7) {
			$hsprite = 3;
		} else if($hsprite == 8) {
			$hsprite = 4;
		}
		$gender = ($gender == 1) ? 0 : 1;
		return '<img src="/css/images/character/heads/c'.$hc.'t'.$hsprite.'sc'.$sc.'.png" id="head" alt="head" />
				<img src="/css/images/character/bodies/c'.$tc.'sc'.$sc.'t'.$gender.'.png" id="body" alt="body" />
				<img src="/css/images/character/legs/c'.$pc.'.png" id="leg" alt="leg" />';
	}
	
?>
	
	