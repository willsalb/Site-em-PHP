<?php

//importação
require_once 'app/Core/core.php';
require_once 'lib/Database/connection.php';
require_once 'app/controller/HomeController.php';
require_once 'app/controller/ErrorController.php';
require_once 'app/model/postagem.php';
require_once 'app/controller/post.Controller.php';
require_once 'app/model/comentario.php';
require_once 'app/controller/sobreController.php';
require_once 'app/controller/perfilController.php';



require_once 'vendor/autoload.php';

$template = file_get_contents('app/template/Homepage.html');

//pega o retorno e armazena em uma variavel.
ob_start();
$core = new Core;
//visualiza a pagina que o usuario tenta acessar.
$core->start($_GET);

$saida = ob_get_contents();
ob_end_clean();

$templatepronto = str_replace('{{area_dinamica}}', $saida, $template);
echo $templatepronto;
