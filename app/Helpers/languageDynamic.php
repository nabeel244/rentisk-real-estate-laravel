<?php

use Illuminate\Support\Facades\Session;

function getAllResourceFiles($dir, &$results = array()) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = $dir ."/". $value;
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getAllResourceFiles($path, $results);
        }
    }
    return $results;
}

function getRegexBetween($content) {

    preg_match_all("%\{{__\(['|\"](.*?)['\"]\)}}%i", $content, $matches1, PREG_PATTERN_ORDER);
    preg_match_all("%\@lang\(['|\"](.*?)['\"]\)%i", $content, $matches2, PREG_PATTERN_ORDER);
    preg_match_all("%trans\(['|\"](.*?)['\"]\)%i", $content, $matches3, PREG_PATTERN_ORDER);
    $Alldata = [$matches1[1], $matches2[1], $matches3[1]];
    $data = [];
    foreach ($Alldata as  $value) {
        if(!empty($value)){
            foreach ($value as $val) {
                $data[$val] = $val;
            }
        }
    }
    return $data;
}

function generateLang($path = ''){

    // user panel
    // $paths = getAllResourceFiles(resource_path('views/user'));
    // $paths = array_merge($paths, getAllResourceFiles(resource_path('views/test')));
    // end user panel

    // user validation
    // $paths = getAllResourceFiles(app_path('Http/Controllers/WEB/User'));
    // $paths = array_merge($paths, getAllResourceFiles(app_path('Http/Controllers/test')));
    // $paths = array_merge($paths, getAllResourceFiles(app_path('Http/Controllers/WEB/Auth')));
    // end user validation

    // admin panel
    // $paths = getAllResourceFiles(resource_path('views/admin'));
    // $paths = array_merge($paths, getAllResourceFiles(resource_path('views/staff')));
    // end admin panel

    // admin validation
    $paths = getAllResourceFiles(app_path('Http/Controllers/WEB/Admin'));
    $paths = array_merge($paths, getAllResourceFiles(app_path('Http/Controllers/WEB/Staff')));
    // end validation
    $AllData= [];
    foreach ($paths as $key => $path) {
    $AllData[] = getRegexBetween(file_get_contents($path));
    }
    $modifiedData = [];
    foreach ($AllData as  $value) {
        if(!empty($value)){
            foreach ($value as $val) {
                $modifiedData[$val] = $val;
            }
        }
    }

    // file_put_contents(resource_path('lang/en.json'), json_encode($modifiedData, JSON_PRETTY_PRINT));

    $modifiedData = var_export($modifiedData, true);
    file_put_contents(resource_path('lang/en/admin_validation.php'), "<?php\n return {$modifiedData};\n ?>");

}


if (!function_exists('getSessionLanguage')) {
    function getSessionLanguage(): string
    {
        if (!session()->has('lang')) {
            $lang = session()->put('lang', config('app.locale'));
            session()->forget('text_direction');
            session()->put('text_direction', 'ltr');
        }

        $lang = Session::get('lang');

        return $lang;
    }
}
