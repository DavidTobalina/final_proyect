<div id="calendar">

<?php
    require_once './connection.php';
    require_once './sessions.php';
    if (session_status() === PHP_SESSION_NONE) {
        check_session();
    }

    function build_calendar($month,$year) {
        $a = array();

        // Array con los nombres de los dias de la semana
        $daysOfWeek = array('Mon','Tues','Wed','Thur','Frid','Sat','Sun');

        // Obtener el primer dia del mes
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

        // Numero de dias del mes
        $numberDays = date('t',$firstDayOfMonth);

        // Obtener informacion del primer dia del mes
        $dateComponents = getdate($firstDayOfMonth);

        // Nombre del mes
        $monthName = $dateComponents['month'];

        // Indice del primer dia del mes (0-6)
        $dayOfWeek = $dateComponents['wday']-1;
        if($dayOfWeek<0){
            $dayOfWeek=6;
        }
        if($dayOfWeek>6){
            $dayOfWeek=0;
        }


        // Crear tabla y botones
        $calendar = "<button class='button'><div class='arrow leftButton'></div></button><button class='button'><div class='arrow rightButton'></div></button><h2>$monthName $year</h2><table>";
        $calendar .= "<tr>";

        // Crear los nombres de los dias de la semana
        foreach($daysOfWeek as $day) {
            $calendar .= "<th>$day</th>";
        }

        // Inicializar el contador de dia empezando por el 1
        $currentDay = 1;
        $calendar .= "</tr><tr>";

        // El array $daysOfWeek se usa para crear 7 columnas para los dias
        if ($dayOfWeek > 0) { 
            $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>"; 
        }
        
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);

        while ($currentDay <= $numberDays) {
            // La columna 7 ha llegado (domingo). Se empieza otra fila.
            if ($dayOfWeek == 7) {
                $dayOfWeek = 0;
                $calendar .= "</tr><tr>";
            }
            
            $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
            $date = "$year-$month-$currentDayRel";

            $cod=getUserCod($_SESSION['user']);
            $arr = getTasks($cod);

            $text1 = "<td rel='$date'>$currentDay</td>";
            $text2 = "<td rel='$date' style='color:red;'><div class='dropdownCalendar'><span>".$currentDay."</span><div class='dropdownCalendar-content'>";
            $long = strlen($text2);

            foreach($arr as $row){
                if($row['date']==$date) $text2 .= "<p><span style='color:red'>".$row["text"]."</span> at ".substr($row["time"] , 0, 5)."</p>";
            }

            if(strlen($text2) > $long) {
                $text2 .="</div></div></td>";
                $calendar .= $text2;
            }else {
                $calendar .= $text1;
            }

            // Incrementar contadores
            $currentDay++;
            $dayOfWeek++;
        }

        // Completar la lista de la ultima semana si es necesario
        if ($dayOfWeek != 7) {
            $remainingDays = 7 - $dayOfWeek;
            $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>"; 
        }
        
        $calendar .= "</tr>";
        $calendar .= "</table>";

        return $calendar;
    }

    $dateComponents = getdate();
    $month = $dateComponents['mon']; 			     
    $year = $dateComponents['year'];

    if(isset($_COOKIE['calendar'])){
        $array = explode(",", $_COOKIE["calendar"]);
		echo build_calendar($array[0], $array[1]);
	}else{
        echo build_calendar($month, $year);
        setcookie("calendar",$month.",".$year, time()+3600*24);
    }
?> 
</div>