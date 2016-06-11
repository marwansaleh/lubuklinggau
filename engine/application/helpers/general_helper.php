<?php
if (!function_exists('breadcumb')){
    function breadcrumb($pages, $showServerTime=FALSE){
        $str = '<ol class="breadcrumb">';
        
        if (is_array($pages)){
            if ($showServerTime){
                $new_bc = array (array('title'=> date('D, dMY H:i:s')));
                array_splice($pages, 0,0, $new_bc);
            }
            foreach ($pages as $page){
                $active = (isset($page['active'])&&$page['active']==TRUE);
                $str.= '<li';
                if ($active)
                    $str.= ' class="active"';
                        
                $str.= '>';
                if (isset($page['link']))
                    $str.= '<a href="'.$page['link'].'">'. $page['title'].'</a>';
                else
                    $str.= $page['title'];
                
                
                $str.= '</li>';
            }
        }
        else
        {
            $str.= '<li>'.$page.'</li>';
        }
        $str.= '</ol>';
        return $str;
    }
}

if (!function_exists('breadcumb_add')){
    function breadcumb_add(&$breadcumb,$title,$link=NULL,$active=FALSE){
        if (is_array($breadcumb)){
            $item = array('title'=>$title, 'active'=>$active);
            if ($link){
                $item['link'] = $link;
            }
            $breadcumb [] = $item;
        }
    }
}

if (!function_exists('create_alert_box')){
    function create_alert_box($alert_text, $alert_type=NULL, $alert_title=NULL, $autohide=TRUE, $secs=6000){
        $type_labels = array(
            'default' => 'Information', 'info'=>'Information', 'success'=>'Successfull', 
            'warning'=>'Warning', 'danger'=>'Danger', 'error'=>'Error'
        );
        $type_alerts = array(
            'default'=>'alert-info', 'info'=>'alert-info', 'success'=>'alert-success', 
            'warning'=>'alert-warning', 'danger'=>'alert-danger', 'error'=>'alert-danger'
        );
        $s = '<div class="alert '.(isset($type_alerts[$alert_type])?$type_alerts[$alert_type]:$type_alerts['default']).' alert-dismissible" role="alert">';
        //button dismiss
        $s.= '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
        //Label in bold
        $s.= '<strong>'. ($alert_title?$alert_title:(isset($type_labels[$alert_type])?$type_labels[$alert_type]:$type_labels['default']).'!').'</strong> ';
        //Alert text
        $s.= $alert_text;
        $s.= '</div>';
        
        //add js to hide automatically
        if ($autohide){
            $s.= PHP_EOL . '<script>setTimeout(function(){$(".alert-dismissible").fadeOut("slow");},'.$secs.');</script>';
        }
        
        return $s;
    }
}

if (!function_exists('get_list_month')){
    function get_list_month($tipe='long'){
        $short = array(1=>'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nop', 'Des');
        $long = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
        
        if ($tipe == 'long'){
            return $long;
        }else{
            return $short;
        }
    }
}
if (!function_exists('get_list_year')){
    function get_list_year(){
        $range_years = range(2004, date('Y'), 1);
        //sort from highest to lowest
        rsort($range_years);
        
        return $range_years;
    }
}

if (!function_exists('get_asset_url')){
    function get_asset_url($filename=NULL){
        $base_assets = config_item('assets_path');
        if (!$filename){
            return site_url($base_assets) . '/';
        }else{
            return site_url($base_assets . $filename);
        }
    }
}

if (!function_exists('get_action_url')){
    function get_action_url($filename=NULL){
        if (!$filename){
            return site_url() ;
        }else{
            return site_url($filename);
        }
    }
}

if (!function_exists('array_submits')){
    function array_submits($array_keys, $posts){
        $data = array();
        foreach (explode(',', $array_keys) as $key){
            $data[$key] = isset($posts[$key])?$posts[$key] : NULL;
        }
        
        return $data;
    }
}

if (!function_exists('variable_type_cast')){
    function variable_type_cast($value, $type='string', $list=FALSE){
        if ($list){
            $value = explode(',', $value);
            $result = array();
            foreach ($value as $val){
                switch ($type){
                    case 'integer': $result[] = intval($val); break; 
                    case 'numeric': $result [] = floatval($val); break;
                    case 'boolean': $result[] = boolval($val); break;
                    default : $result[] = strval($val);
                }
            }
            
            return $result;
        }else{
            switch ($type){
                case 'integer': return intval($value); 
                case 'numeric': return floatval($value);
                case 'boolean': return boolval($value);
                default : return strval($value);
            }
        }
    }
}

if (!function_exists('draw_menus')){
    function draw_menus($mainmenus, $active_menu=NULL, $level=0, $module_active='dashboard'){
        if (!$mainmenus || !is_array($mainmenus)){
            return '';
        }
        $str = '';
        foreach ($mainmenus as $menu){
            $caption = $level==0 ? strtoupper($menu->caption) : ($level==1 ? ucfirst($menu->caption) : $menu->caption);
            //$str.= '<li'.($level==0&&$menu->module_name==$module_active?' class="active"':'').'>';
            if ($level==0){
                $str.= '<li '.($menu->module_name==$module_active?'class="active"':'').'>';
            }else{
                $str.= '<li '.($active_menu ? ($menu->id==$active_menu->id||$menu->id==$active_menu->parent?'class="active"':''):'').'>';
            }
            if ($menu->children){
                $str.= '<a href="#" class="js-sub-menu-toggle" '.($menu->title?' title="'.$menu->title.'"':'').'>';
                $str.= ($menu->icon ? '<i class="fa '.$menu->icon.' fa-fw"></i>':'').'<span class="text">'.$caption.'</span>';
                $str.= '<i class="toggle-icon fa '.($active_menu?($menu->id==$active_menu->id||$menu->id==$active_menu->parent?'fa-angle-down':'fa-angle-left'):'fa-angle-left').'"></i>';
                $str.= '</a>';
                if ($level==0&&$menu->module_name==$module_active){
                    $str.= '<ul class="sub-menu open">';
                }else{
                    $str.= '<ul class="sub-menu '.($active_menu ? ($menu->id==$active_menu->id||$menu->id==$active_menu->parent?'open':''):'').'">';
                }
                $str.= draw_menus($menu->children, $active_menu, $level+1, $module_active);
                $str.= '</ul>';
            }else{
                $str.= '<a href="'.($menu->link ? get_action_url($menu->link):'#').'"'.($menu->title?' title="'.$menu->title.'"':'').'>'.($menu->icon ? '<i class="fa '.$menu->icon.' fa-fw"></i>':'').'<span class="text">'.$caption.'</span></a>';
            }
            $str.= '</li>';
        }
        
        return $str;
    }
}

if (!function_exists('draw_manual_tree')){
    function draw_manual_tree($manuals, $active_id=0){
        if (!isset($ci)){
            $ci =& get_instance(); 
        }
        $str = '<ul>';
        foreach ($manuals as $manual){
            if (!$ci->session->userdata('manual_index')){
                $manual_index = array($manual->id);
            }else{
                $manual_index [] = $manual->id;
            }
            $ci->session->set_userdata('manual_index', $manual_index);
            
            $str.= '<li'.($manual->id==$active_id?' data-jstree=\'{"opened":true,"selected":true}\'':'').'>';
            if ($manual->content){
                $str.= '<a href="'.get_action_url('manual/usermanual/detail/'.$manual->id).'">'.$manual->caption.'</a>';
            }else{
                $str.= '$manual->caption';
            }
            if ($manual->children){
                $str.= draw_manual_tree($manual->children, $active_id);
            }
            $str.= '</li>';
        }
        $str.= '</ul>';
        
        return $str;
    }
}

if (!function_exists('module_name')){
    function module_name($module_id){
        $module_name = 'dashboard';
        
        switch ($module_id){
            case CT_MODULE_DASHBOARD: $module_name = 'dashboard'; break;
            case CT_MODULE_MARKETING: $module_name = 'marketing'; break;
            case CT_MODULE_KEUANGAN: $module_name = 'keuangan'; break;
            case CT_MODULE_MASTER: $module_name = 'master'; break;
            case CT_MODULE_SYSTEM: $module_name = 'system'; break;
            case CT_MODULE_USERMGT: $module_name = 'usermgt'; break;
            case CT_MODULE_MANUAL: $module_name = 'manual';break;
            case CT_MODULE_REPORTING: $module_name = 'report';break;
            case CT_MODULE_KLAIM: $module_name = 'klaim';break;
            case CT_MODULE_CIT: $module_name = 'cit';break;
            default : $module_name = CT_MODULE_OTHER;
        }
        
        return $module_name;
    }
}

if (!function_exists('number_parse')){
    function number_parse($value_string){
        return preg_replace("/([^0-9\\.])/i", "", $value_string);
    }
}

if (!function_exists('themes_available')){
    function themes_available(){
        return array(THEME_DEFAULT, THEME_DARK_TRANSPARENT);
    }
}

if (!function_exists('upload_path')){
    function upload_path($type=UPLOAD_TYPE_POLIS){
        if ($type==UPLOAD_TYPE_POLIS){
            return config_item('upload_polis');
        }else if ($type == UPLOAD_TYPE_CLAIM){
            return config_item('upload_klaim');
        }else if ($type == UPLOAD_TYPE_CIT){
            return config_item('upload_cit');
        }else{
            return config_item('upload_path');
        }
    }
}

if (!function_exists('upload_url')){
    function upload_url($filename=NULL){
        if ($filename){
            return site_url(config_item('upload_path').$filename);
        }else{
            return site_url(config_item('upload_path'));
        }
    }
}

if (!function_exists('set_url_back')){
    function set_url_back($url){
        $url_string = urlencode(base64_encode($url));
        
        return $url_string;
    }
}

if (!function_exists('get_url_back')){
    function get_url_back($url){
        $url_back = base64_decode(urldecode($url));
        
        return $url_back;
    }
}

if (!function_exists('polis_status')){
    function polis_status($status=NULL){
        $statuses = array(
            STATUS_NEW => 'Registered',
            STATUS_TO_VERIFY => 'Verify',
            STATUS_VERIFIED => 'Verified',
            STATUS_APPROVED => 'Approved',
            STATUS_CLOSED => 'Closed'
        );
        
        if ($status === NULL){
            return $statuses;
        }else if (isset($statuses[$status])){
            return $statuses[$status];
        }else{
            return 'Unknown';
        }
    }
}

if (!function_exists('centi_2_point')){
    function centi_2_point($centimeter){
        $ratio_to_point = 5.5;
        
        return $centimeter * $ratio_to_point;
    }
}

if (!function_exists('ppn_tax')){
    function ppn_tax($object_value){
        $rate = 0.1; //10%
        return $rate * $object_value;
    }
}

if (!function_exists('pph_tax')){
    function pph_tax($object_value){
        $rate = 0.02; //2%
        return $rate * $object_value;
    }
}

if (!function_exists('nilai_terbilang_id')){
    function nilai_terbilang_id($x){
        $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($x < 12){
            return " " . $abil[$x];
        }elseif ($x < 20) {
            return nilai_terbilang_id($x - 10) . "belas";
        }elseif ($x < 100){
            return nilai_terbilang_id($x / 10) . " puluh" . nilai_terbilang_id($x % 10);
        }elseif ($x < 200){
            return " seratus" . nilai_terbilang_id($x - 100);
        }elseif ($x < 1000){
            return nilai_terbilang_id($x / 100) . " ratus" . nilai_terbilang_id($x % 100);
        }elseif ($x < 2000){
            return " seribu" . nilai_terbilang_id($x - 1000);
        }elseif ($x < 1000000){
            return nilai_terbilang_id($x / 1000) . " ribu" . nilai_terbilang_id($x % 1000);
        }elseif ($x < 1000000000){
            return nilai_terbilang_id($x / 1000000) . " juta" . nilai_terbilang_id($x % 1000000);
        }
    }
}

if (!function_exists('nilai_terbilang_en')){
    function nilai_terbilang_en($number){
        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }

        $Gn = floor($number / 1000000);  /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000);     /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);      /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);       /* Tens (deca) */
        $n = $number % 10;               /* Ones */

        $res = "";

        if ($Gn) {
            $res .= nilai_terbilang_en($Gn) . " Million";
        }

        if ($kn) {
            $res .= (empty($res) ? "" : " ") .
                    nilai_terbilang_en($kn) . " Thousand";
        }

        if ($Hn) {
            $res .= (empty($res) ? "" : " ") .
                    nilai_terbilang_en($Hn) . " Hundred";
        }

        $ones = array("", "one", "two", "three", "four", "five", "six",
            "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen",
            "fourteen", "fifteen", "sixteen", "seventeen", "eightteen",
            "Nineteen");
        $tens = array("", "", "twenty", "thirty", "fourty", "fifty", "sixty",
            "seventy", "eigthy", "ninety");

        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= " and ";
            }

            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];

                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }

        if (empty($res)) {
            $res = "zero";
        }

        return $res;
    }

}

/** KLAIM */
if (!function_exists('klaim_status')){
    /**
     * Get claim status text
     * @param TINYINT $status default NULL
     * @return string status IF success, or null if failed. Return Assoc of array of status if no param
     */
    function klaim_status($status=NULL){
        $status_array = array(
            CLAIMGEN_STATUS_AWAL    =>  'Lap. Awal',
            CLAIMGEN_STATUS_TOLAK   =>  'Lap. Rejected',
            CLAIMGEN_STATUS_TUNTUT  => 'Srt. Tuntutan',
            CLAIMGEN_STATUS_ADJUST  => 'Adjustment',
            CLAIMGEN_STATUS_BANDING => 'Banding',
            CLAIMGEN_STATUS_SETUJU  => 'Setuju',
            CLAIMGEN_STATUS_UNDER_DEDUCTIBLE => 'Under',
            CLAIMGEN_STATUS_PAYMENT => 'Payment',
            CLAIMGEN_STATUS_SETTLED => 'Settled'
        );
        if (!$status){
            return $status_array;
        }
        if (isset($status_array[$status])){
            return $status_array[$status];
        }else{
            return NULL;
        }
    }
}
/*
 * Filename: general_helper.php
 * Location: application/helpers/general_helper.php
 */