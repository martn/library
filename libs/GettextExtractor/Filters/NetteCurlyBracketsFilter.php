<?php

require_once dirname(__FILE__) . '/iFilter.php';

class NetteCurlyBracketsFilter implements iFilter
{
    public function extract($file)
    {
        $pInfo = pathinfo($file);
        $data = array();
        foreach (file($file) as $line => $contents) {
            // match all {!_ ... } tags
            preg_match_all('#{(!_)([^}]*?)([a-z](?:[^\'"}\s|]+|\\|[a-z]|\'[^\']*\'|"[^"]*")*)?}#', $contents, $matches);
            if (empty($matches)) continue;
            if (empty($matches[0])) continue;
            
            foreach ($matches[0] as $m) {
                if (preg_match('#\'[^\']*\'|"[^"]*"#', $m, $x) > 0)
                        $data[substr($x[0], 1, -1)][] = $pInfo['basename'] . ':' . $line;
           }
        }
        return $data;
    }
}