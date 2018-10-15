<?php
    session_start();
    
    require_once("lib/slim/autoload.php");
    require_once("lib/template/raelgc/view/Template.php");
    require_once("lib/Medoo/Medoo.php");

    $templates = [];

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app/views/')) as $filename){
        $parsed = substr($filename, 10);
	    $parsed = str_replace('\\', '/',$parsed);
        $parsed = str_replace('.html', '', $parsed);

        if(!(strpos($parsed, '.') !== false)){
            $templates[$parsed] = $filename.'';
        }
    }

    use raelgc\view\Template;
    use \Slim\App;


    $tpl = new Template('app/views/index.html');
    
    foreach (glob("app/models/*.php") as $filename){
        include $filename;
    }
    
    $app = new App([
        'settings' => [
            'displayErrorDetails' => true
        ]
    ]);

    foreach (glob("app/routes/*.php") as $filename){
        include $filename;
    }

    $app->run();
?>
