<?php


if(!function_exists('to_float')){
    function to_float($string_number){
        // NOTE: You don't really have to use floatval() here, it's just to prove that it's a legitimate float value.
        $number = floatval(str_replace('.', ',', str_replace(',', '', $string_number)));

        // At this point, $number is a "natural" float.
        return $number;
    }
}

if(!function_exists('parseFloatComma')) {
    function parseFloatComma($numComma) {
        $number = str_replace(',', '', $numComma);

        return (float)$number;
    }
}


if(!function_exists('nav_url')){
    function nav_url(){
        $user       = Sentinel::check();
        $menus      = config('menu');
        $newMenu    = [];
        $subMenu    = [];
        foreach($menus as $menu){
            $isActive   = false;
            $asHeader   = !empty($menu['as']) ? $menu['as'] : null;
            if($user->hasAccess($asHeader . "*")){
                if(!empty($menu['sub']) AND count($menu['sub']) > 0){
                    foreach($menu['sub'] as $sub){
                        /*
                         * Hardcode for philip ev
                         */
                        if($sub['as'] == 'shipping-message.' AND $user->id == 40){
                            continue;
                        }
                        $asSub      = !empty($sub['as']) ? $sub['as'] : null;
                        if($user->hasAccess($asHeader . $asSub . "*")){
                            $subActive  = false;
                            $link       = !empty($sub['link']) ? $sub['link'] : null;
                            if(Request::is('backend/' . $link . '/*') OR Request::is('backend/' . $link)){
                                $isActive   = true;
                                $subActive  = true;
                            }

                            $sub['is_active']   = $subActive;

                            $subMenu[]          = $sub;
                        }
                    }
                }

                $menu['is_open']    = $isActive;
                $menu['sub']        = $subMenu;
                $subMenu            = [];   // reset

                $newMenu[]          = $menu;
            }
        }

        return $newMenu;
    }
}

if (! function_exists('numFormat')) {
    function numFormat($numComma = "") {
        $number = str_replace(',', '', $numComma);

        return (float)$number;
    }
}


if(! function_exists('alertNotify')){
    function alertNotify($isSuccess  = true, $message = '', $request){
        if($isSuccess){
            $request->session()->flash('alert-class','success');
            $request->session()->flash('status', $message);
        }else{
            $request->session()->flash('alert-class','danger');
            $request->session()->flash('status', $message);
        }
    }
}

if(!function_exists('hasGroup')){
    function hasGroup($groups, $groupID = null){
        if(is_null($groupID) OR !$groups OR $groups->count() == 0){
            return false;
        }

        foreach($groups as $group){
            if($group->group_id == $groupID OR $groupID == 1 /* is importir admin */){
                return true;
            }
        }

        return false;
    }
}

if(!function_exists('isActiveMenu')){
    function isActiveMenu($menu1 = '', $menu2 = ''){
        if($menu2 != ''){
            if(in_array(Request::segment(1),['dashboard','operator']) AND Request::segment(2) == $menu1 AND Request::segment(3) == $menu2){
                return "active";
            }

            return "";
        }
        if(Request::segment(3) != ''){
            return "";
        }
        if(in_array(Request::segment(1),['dashboard','operator']) AND Request::segment(2) == $menu1){
            return "active";
        }

        return "";
    }
}

if(!function_exists('isActiveMenuMain')){
    function isActiveMenuMain($menu1 = ''){
        if(in_array(Request::segment(1),['dashboard','operator']) AND Request::segment(2) == $menu1){
            return "active";
        }

        return "";
    }
}


if(!function_exists('waMessageGenerate')){
    function waMessageGenerate($message = '', $csName = ''){
        if(!$message){
            return '';
        }

        $message    = str_replace('%NAMA_CS%', $csName, $message);
        return $message;
    }
}


function weeklyList(){
    $days     = [
        "Sunday"    => "Minggu",
        "Monday"    => "Senin",
        "Tuesday"   => "Selasa",
        "Wednesday" => "Rabu",
        "Thursday"  => "Kamis",
        "Friday"    => "Jumat",
        "Saturday"  => "Sabtu"
    ];

    return $days;
}

function defaultGeneratorForm(){
    $html   = '[{"type":"text","required":true,"label":"Nama","placeholder":"Masukan Nama Anda","className":"form-control","name":"name","subtype":"text"},{"type":"text","required":true,"label":"Email","description":"Pastikan Email Anda Valid","placeholder":"Masukan Email Anda","className":"form-control","name":"email","subtype":"text"},{"type":"textarea","required":true,"label":"Alamat","placeholder":"Masukan Alamat Lengkap Anda","className":"form-control","name":"alamat","subtype":"textarea"},{"type":"checkbox-group","required":true,"label":"Pilih Model Tas<br>","description":"Urutan dari atas kiri","name":"model-tas","values":[{"label":"Model 1","value":"model1","selected":true},{"label":"Model 2","value":"model2"},{"label":"Model 3","value":"model3"},{"label":"Model 4","value":"model4"},{"label":"Model 5","value":"model5"},{"label":"Model 6","value":"model6"}]},{"type":"button","subtype":"submit","label":"✓ Submit","className":"btn btn-primary","name":"submit","style":"primary"}]';

   return $html;
}

function defaultDescriptionForm(){
    return '<p><span style="background-color: rgb(255, 255, 0);"><span style="text-decoration: underline;"><span style="font-style: italic;">INI ADALAH CONTOH FORM YANG DIBUAT OLEH SYSTEM</span></span></span><br></p><p>Tas Pikachu Lucu Hanya <span style="font-weight: bold;">Rp299.000,-</span></p><p></p><p><img style="width: 100%;" src="https://ae01.alicdn.com/kf/HTB1k6WyNVXXXXasXFXXq6xXFXXXL/1pcs-lot-20cm-Sleeping-Bag-Pikachu-Plush-Pikachu-Cosplay-Charizard-Eevee-Ekans-Sleeping-Bag-Stuffed-Plush.jpg_640x640.jpg" class="img-thumbnail"><br></p><p>Isi Form berikut untuk pemesanan langsung ke CS Kami!!</p><br/>';
}


function getOnlyNameFormGeneratorToArray($generator, $withHashTag = true, $exclude = []){
    $decoded    = @json_decode($generator);
    if(is_null($decoded)){
        return [];
    }

    $inputs = [];
    foreach ($decoded as $value){
        if($value->name == 'submit'){
            continue;
        }

        if(!empty($exclude) AND in_array($value->name, $exclude)){
            continue;
        }
        $inputs[]   = [
            'key'   => $value->name,
            'value' => '%field_' . strtolower($value->name) . '%'
        ];
    }

    return $inputs;
}

function generateMessageByFormGenerator($message, $generator, $isHtml = false){
    $decoded    = @json_decode($generator);
    if(is_null($decoded)){
        return '';
    }

    $inputs = [];
    foreach ($decoded as $value){
        if($value->name == 'submit'){
            continue;
        }

        $inputs[]   = $value->name;
    }

    return generateMessageWhatsapp($message, $inputs);
}

function generateMessageWhatsapp($message, $inputs = [], $isHtml = false){
    $resultText     = '';

    $newInputs  = [];
    foreach ($inputs as $input){
        foreach ($input as $key => $value){
            $newInputs[$key]    = $value;
        }
    }

    $inputs     = $newInputs;

    foreach ($inputs as $key => $input){
        if(in_array($key,['submit','_token'])){
            continue;
        }
        if(is_null($input)){
            continue;
        }

        // multi select
        if(is_array($input)){
            $arrText    = '';
            foreach ($input as $text){
                $arrText    .= $text . ', ';
            }
            $input  = $arrText;
        }
        $resultText  .= $input .', ';
    }
    $message    = str_replace('%all_fields%', $resultText, $message);

    $customFields       = [];
    $customFieldsCount  = substr_count($message, "%field_");
    if($customFieldsCount > 0){
        for($i = 0; $i <= $customFields; $i++){
            $scrapped   = _getStringBetween($message,"%field_","%");

            $escaped    = str_replace("%field_", "", $scrapped);
            $escaped    = str_replace("%", "", $escaped);

            $value      = _hasKeyInArray($inputs, $escaped);
            if(!$value){
                if($i == $customFieldsCount){
                    break;
                }
                continue;
            }
            $message    = str_replace("%field_" . $escaped . "%", $value, $message);
        }
    }

    return trim($message);
}

function _hasKeyInArray($inputs = [], $escapedStr = ''){
    foreach ($inputs as $key => $input){
        if(strtolower($key) == strtolower($escapedStr)){
            return $input;
        }
    }

    return false;
}

function _getStringBetween($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function randomStrNum($len = 5){
    $characters = '23456789abcdefghjklmnpqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $len; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}