<?php
    $today = date("Y-m-d");
    $nextYear = (date("Y")+1)."-".date("m-d");

    $nowH = date('H');
    $nowH2 = date('H');
    $nowM = date('i')+30;
    $nowM2 = date('i')+5;
    if($nowM>=60){
        $nowH++;
        $nowM = str_pad(($nowM-60), 2, "0", STR_PAD_LEFT);
        $nowH = str_pad($nowH, 2, "0", STR_PAD_LEFT);
        if($nowH==24){
            $nowH=0;
            $nowH = str_pad($nowH, 2, "0", STR_PAD_LEFT);
        }
    }
?>
<h2>Create task</h2>
<form action = "./main.php" method = "POST" autocomplete="off">
    <div id="auto" class="suggestions">
        <input type="text" id="i" name="i" maxlength="30" placeholder="I want to..." required>
    </div><br>
    On: <input type="date" id="d" name="d" value="<?php echo $today;?>" min="<?php echo $today;?>" max="<?php echo $nextYear;?>" required><br>
    At: <input type="time" id="t" name="t" value="<?php echo $nowH.':'.$nowM;?>" required><br>
    <input type = "submit" value="Next">
</form>