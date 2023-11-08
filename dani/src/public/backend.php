<?php

class backend
{
    private $db_controller;

    function __construct()
    {
        require_once 'db.php';
        $this->db_controller = new db_controller();
    }
    
    public function get_parcell_matrix()
    {
        $parcell_matrix = array();
        for ($i=1;$i<=36;$i++)
        {
            if ($i <= 11) //első sor pozíciók
            {
                if ($i == 1) //első parcella pozíció
                {
                    $top = 45.3;
                    $left = 62;
                }
                else if ($i == 6) //nagyobb köztes távolság
                {
                    $top = 61.3;
                    $left = 43.8;
                }
                else if ($i == 9) //sortörés
                {
                    $top = 58.4;
                    $left = 42.3;
                }
                else //normál köztes távolság
                {
                    $top+= 3;
                    $left-= 3.4;
                }
            }
            else if ($i <= 15) //bal sor pozíciók
            {
                if ($i == 12)
                {
                    $top = 71.7;
                    $left = 25;
                }
                else
                {
                    $top+= 2.25;
                    $left+= 2.6;
                }
            }
            else if ($i <= 24) //második sor pozíciók
            {
                if ($i == 16) 
                {
                    $top = 46.2;
                    $left = 69.9;
                }
                else if (in_array($i,array(19,20,21,23))) //nagyobb köztes távolság
                {
                    $top+= 4;
                    $left-= 4.6;
                }
                else if ($i == 24) //köztes parcella
                {
                    $top = 75.4;
                    $left = 38.8;
                }
                else
                {
                    $top+= 3;
                    $left-= 3.4;
                }
            }
            else if ($i <= 32) //második sor pozíciók sortöréssel visszafordítva
            {
                if ($i == 25)
                {
                    $top = 74.2;
                    $left = 44.9;
                }
                else if (in_array($i,array(27,31,32))) //normál köztes távolság
                {
                    $top-= 3;
                    $left+= 3.4;
                }
                else //nagyobb köztes távolság
                {
                    $top-= 4;
                    $left+= 4.55;
                }
            }
            else //harmadik sor pozíciók
            {
                if ($i == 33)
                {
                    $top = 53.3;
                    $left = 78;
                }
                else if ($i == 36) //nagyobb köztes távolság
                {
                    $top = 63.2;
                    $left = 66.6;
                }
                else //normál köztes távolság
                {
                    $top+= 3;
                    $left-= 3.4;
                }
            }
            
            $key = sprintf("%02d", $i);
            $parcell_matrix[$key] = array(
                'top' => $top,
                'left' => $left
            );
        }
        
        return $parcell_matrix;
    }
    
    public function read_reservation_day_datas()
    {
        $return = array();
        
//        $sql = "SQL_SELECT day_activities FROM sse_szallasfoglalo_reservations WHERE day_code ='$day_code';";
//        $day_datas_json = $this->db_controller->sql_query($sql);
        
        return $return;
    }
    
}

?>