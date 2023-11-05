<?php

class backend
{
    private $db_controller;

    function __construct()
    {
        require_once 'db.php';
        $this->db_controller = new db_controller();
    }
    
    public function read_reservation_day_datas(&$day_code)
    {
        $return = array();
        
        $sql = "SQL_SELECT day_activities FROM sse_szallasfoglalo_reservations WHERE day_code ='$day_code';";
        $day_datas_json = $this->db_controller->sql_query($sql);
        
        
        return $return;
    }
    
}

?>