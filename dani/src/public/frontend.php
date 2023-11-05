<?php
 
class frontend
{
    private $backend;
    
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
        $return.= '<link href="style.css?v=' . $ver . '" rel="stylesheet" type="text/css" />';
        $return.= '</head>';
        
        return $return;
    }

    public function page_content()
    {
        $return = '<body>';
            $return.= '<img src="src/public/img/map.png" />';
        $return.= '</img>';

        return $return;
    }
    
    public function show_output()
    {
        $output = $this->get_header();
        $output = $this->page_content();
        
        return $output;
    }
}

?>