<?php
include_once './inc/common.php';
require_once './inc/charfunctions2.php';

if(!defined('IN_PHPBB'))
{
	die("You do not have permission to access this file.");
}
if($user->data['is_registered']) {
	$phpbb_user_id = $user->data['user_id'];
        
	$connector = new DarscapeDbc();
        //$wielded_result = $connector->query("SELECT wk_players.*, wk_invitems.user, wk_invitems.wielded, wk_invitems.id as weapon FROM wk_players LEFT JOIN wk_invitems on wk_players.user = wk_invitems.user WHERE phpbb_id='$phpbb_user_id'"); // AND wk_invitems.id=81 AND wk_invitems.wielded=1
        $wielded_result = $connector->query("SELECT wk_players.*, wk_invitems.user, wk_invitems.wielded, wk_invitems.id as weapon FROM wk_players LEFT JOIN wk_invitems on wk_players.user = wk_invitems.user WHERE phpbb_id='$phpbb_user_id' AND wk_invitems.wielded=1"); // AND wk_invitems.id=81 AND wk_invitems.wielded=1
        $weapon1 = $wielded_result->fetch_object()->weapon;
        $weapon2 = $wielded_result->fetch_object()->weapon;
        $weapon3 = $wielded_result->fetch_object()->weapon;
        $weapon4 = $wielded_result->fetch_object()->weapon;
        $weapon5 = $wielded_result->fetch_object()->weapon;
        $weapon6 = $wielded_result->fetch_object()->weapon;
        
        $characters_result = $connector->query("SELECT * FROM wk_players WHERE phpbb_id=$phpbb_user_id");
?>

<div class="main">
        <div class="content">
                <article>	
                        <h4>Player Management</h4>
                        <p>Manage your player accounts, view their statistics, and change up your gear!</p>
                        <a id="inline" href="register.php" class="button">Create Hero</a>
                        <?php
                                if(mysqli_num_rows($characters_result) > 0) {
                        
                        ?>
                                <div id="sm-list">
                                        <ul>
                                <?php 
                                        $c=0;
                                        while($row = $connector->fetchArray($characters_result)){
                                                
                                                        /*if ($i > 10) {
                                                            break;
                                                        }*/
                                ?>
                                                <a href="#" onClick="javascript:loadContent('<?php echo $row['username']; ?>','<?php echo $row['user']; ?>','<?php echo $row['phpbb_id']; ?>','<?php echo $row['haircolour']; ?>','<?php echo $row['headsprite']; ?>','<?php echo $row['skincolour']; ?>','<?php echo $row['topcolour']; ?>','<?php echo $row['male']; ?>','<?php echo $row['trousercolour']; ?>','<?php echo $row['combat']; ?>','<?php echo $row['online']; ?>','<?php echo $weapon1; ?>','<?php echo $weapon2; ?>','<?php echo $weapon3; ?>','<?php echo $weapon4; ?>','<?php echo $weapon5; ?>','<?php echo $weapon6; ?>');"><li id="toggle"><?php echo $row['username']; ?></li></a>
                                <?php
                                        if($c==0){ 
                                                $username=$row['username'];
                                                $user=$row['wk_players.user'];
                                                $id=$row['phpbb_id'];

                                                $hc = $row['haircolour'];
                                                $hsprite = $row['headsprite'];
                                                $sc = $row['skincolour'];
                                                $tc = $row['topcolour'];
                                                $gender = $row['male'];
                                                $pc = $row['trousercolour'];

                                                $combat = $row['combat'];
                                                $online = $row['online'];

                                                //$weapon = $row['weapon'];
                                                //$wielded = $row['wielded'];
                                                //echo $weapon;
                                        }
                                        $c++;
                                        }
                                ?>
                                        </ul>
                                </div>
                                <script type="text/javascript" language="JavaScript">
                                        $(document).ready(function() {
                                                $.post("/js/account.php", {username: '<?php echo $username; ?>', userenc: '<?php echo $user; ?>', owner: '<?php echo $id; ?>', hair: <?php echo $hc; ?>, head: <?php echo $hsprite; ?>, skin: <?php echo $sc; ?>, top: <?php echo $tc; ?>, gen: <?php echo $gender; ?>, pants: <?php echo $pc; ?>, combat: <?php echo $combat; ?>, online: <?php echo $online; ?>, weapon1: <?php echo $weapon1; ?>, weapon2: <?php echo $weapon2; ?>, weapon3: <?php echo $weapon3; ?>, weapon4: <?php echo $weapon4; ?>, weapon5: <?php echo $weapon5; ?>, weapon6: <?php echo $weapon6; ?>} ,function(data) {
                                                        $("#character-details").html(data).show();
                                                        $("a#inline").fancybox({
                                                                'hideOnContentClick': false,
                                                                'overlayColor': '#000000',
                                                                'padding': 0,
                                                        });
                                                });
                                        });
                                </script>
                                <div id="character-details">
                                </div>
                        <?php } ?>
		</article>
        </div>
</div>
<?php
	}