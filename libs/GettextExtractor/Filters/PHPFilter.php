<?php

require_once dirname(__FILE__) . '/iFilter.php';

class PHPFilter implements iFilter
{
    public $keywords = array('translate', '_');
    public function extract($file)
    {
        $pInfo = pathinfo($file);
        $data = array();
        $tokens = token_get_all(file_get_contents($file));
        $next = false;
        foreach ($tokens as $c)
        {
            if(is_array($c)) {
                if ($c[0] != T_STRING && $c[0] != T_CONSTANT_ENCAPSED_STRING) continue;
                if ($c[0] == T_STRING && in_array($c[1], $this->keywords)) {
                    $next = true;
                    continue;
                }
                if ($c[0] == T_CONSTANT_ENCAPSED_STRING && $next == true) {
                    $data[substr($c[1], 1, -1)][] = $pInfo['basename'] . ':' . $c[2];
                    $next = false; 
                }
            } else {
                if ($c == ')') $next = false;
            }
        }
        return $data;
    }
}