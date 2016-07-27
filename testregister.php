<?php

if(isset($_POST['submit'])){
    $error = 0;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $username = str_replace(" ", "_", $username);
    $password = str_replace(" ", "_", $password);
    $password2 = str_replace(" ", "_", $password2);
    //$user_id = "PUT UZER ID VB THING HERE PlOCKS";
    
    if ($password != $password2){
        die ("Error: Passwords do not match");
        $erorr + 1;
    }
    if (strlen($password) < 3 or strlen($password) > 20){
        die ("Error: Password must be between 3 - 20 username");
        $error + 1;
    }
    if (strlen($username) < 3 or strlen($username) > 12){
        die ("Error: Username must be between 3 - 12 username");
        $error + 1;
    }

        $account_array['pass'] = $password;

    }
}else{
echo '
        <form method="post">
                Username:</br>
                <input name="username" type="text" size="20" maxlength="12" /><br />
                Password:</br>
                <input name="password" type="password" size="20" maxlength="20" /> <input name="password2" type="password" size="20" maxlength="20" /><br /><br />
                <input type="submit" name="submit" value="submit" />
        </form>
';
}
        function write_ini($assoc_arr, $path) {
                foreach ($assoc_arr as $key=>$elem) {
                        if (is_array($elem)) {
                                for ($i = 0; $i < count($elem); $i++)
                                        $content .= $key . "=" . $elem[$i] . "\n";
                        }
                        else if ($elem == NULL)
                                $content .= $key . "=\n";
                        else
                                $content .= $key . "=" . $elem . "\n";
                }

                if (!$handle = fopen($path, 'w'))
                        return false;
                
                if (!fwrite($handle, $content))
                        return false;
                
                fclose($handle);
                
                return true;
        }
?>