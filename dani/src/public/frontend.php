<?php
 
class frontend
{
    private $backend;
    protected $start_date;
    protected $end_date;
    
    function __construct()
    {
        require_once 'backend.php';
        $this->backend = new backend();
    }
    
    public function get_header()
    {
        $ver = 1;
        
        $return = '<head>';
            $return.= '<title>Egerszalók camping</title>';
            $return.= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            $return.= '<link href="src/public/style/style.css?v=' . $ver . '" rel="stylesheet" type="text/css" />';
            $return.= '<link href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />';
            $return.= '<script src="https://code.jquery.com/jquery-3.6.0.js"></script>';
            $return.= '<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>';
            $return.= '<script src="src/public/js/script.js?v=' . $ver . '"></script>';
        $return.= '</head>';
        
        return $return;
    }
    
    public function show_date_selection_box()
    {
        $return = '<div class="date_selection_box">';
            $return.= '<div class="datepicker_box"><span>Bejelentkezés napja:</span><input type="text" class="datepicker" id="start_date"></div>';
            $return.= '<div class="datepicker_box"><span>Kijelentkezés napja:</span><input type="text" class="datepicker" id="end_date"></div>';
            $return.= '<div class="datepicker_box"><div id="chk_dates">MUTAT</div></div>';
        $return.= '</div>'; //date_selection_box
        
        return $return;
    }
    
    public function show_parcells($start_date = 0,$end_date = 0)
    {
        $return = '<div class="parcells">';
        
        $parcell_datas = $this->backend->get_parcell_datas($start_date,$end_date);
        $parcell_matrix = $this->backend->get_parcell_matrix();
        foreach ($parcell_matrix as $pid => $coordinates)
        {
            $class = ' disabled';
            if (!empty($parcell_datas))
            {
                $class = (!empty($parcell_datas[$pid]['occupied']) && $parcell_datas[$pid]['occupied'] === true) ? ' occupied' : ' free';
            }
            
            $return.= '<div class="parcell_block' . $class . '" id="parcell_' . $pid . '" data-camp_id="' . $pid . '" style="top:' . $coordinates['top'] . '%;left:' . $coordinates['left'] . '%;">';
                $return.= $pid;
            $return.= '</div>';
        }
        
        $return.= '</div>'; //parcells
        
        return $return;
    }

    public function page_content()
    {
        $return = '<div class="page_content">';
            $return.= '<div class="main_map"><img src="src/public/img/map.png" />' . $this->show_parcells() . '</div>';
            $return.= $this->show_date_selection_box();
        $return.= '</div>'; //page_content

        return $return;
    }
    
    public function show_output()
    {
        $output = '';
        
        if (!empty($_POST['ajax'])) //AJAX
        {
            switch ($_POST['ajax'])
            {
                case 'show_parcells':
                    $start_date = (!empty($_POST['start']) && preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $_POST['start'])) ? $_POST['start'] : 0;
                    $end_date = (!empty($_POST['end']) && preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $_POST['end'])) ? $_POST['end'] : 0;
                    if (!empty($start_date) && !empty($end_date)) //validált dátumok POST adatokból
                    {
                        $output = $this->show_parcells($start_date,$end_date);
                    }
                break;
            }
        }
        else //FULL
        {
            $output.= $this->get_header();
            $output.= $this->page_content();
        }
        
        return $output;
    }
}

?>