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

	function drawCharacter($hc, $hsprite, $sc, $tc, $gender, $pc, $weapon1, $weapon2, $weapon3, $weapon4, $weapon5, $weapon6){
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
                if($weapon1 != 81) {
			$weapon1 = 0;
		}
                if($weapon2 != 81) {
			$weapon2 = 0;
		}
                if($weapon3 != 81) {
			$weapon3 = 0;
		}
                if($weapon4 != 81) {
			$weapon4 = 0;
		}
                if($weapon5 != 81) {
			$weapon5 = 0;
		}
                if($weapon6 != 81) {
			$weapon6 = 0;
		}
		$gender = ($gender == 1) ? 0 : 1;
		return '<img src="/css/images/character/heads/c'.$hc.'t'.$hsprite.'sc'.$sc.'.png" id="head" alt="head" />
				<img src="/css/images/character/bodies/c'.$tc.'sc'.$sc.'t'.$gender.'.png" id="body" alt="body" />
				<img src="/css/images/character/legs/c'.$pc.'.png" id="leg" alt="leg" />
                                <img src="/css/images/character/weapons/c'.$weapon1.'.png" id="weapon1" alt="weapon1" />
                                <img src="/css/images/character/weapons/c'.$weapon2.'.png" id="weapon2" alt="weapon2" />
                                <img src="/css/images/character/weapons/c'.$weapon3.'.png" id="weapon3" alt="weapon3" />
                                <img src="/css/images/character/weapons/c'.$weapon4.'.png" id="weapon4" alt="weapon4" />
                                <img src="/css/images/character/weapons/c'.$weapon5.'.png" id="weapon5" alt="weapon5" />
                                <img src="/css/images/character/weapons/c'.$weapon6.'.png" id="weapon6" alt="weapon6" />';
	}
	
?>
	
	