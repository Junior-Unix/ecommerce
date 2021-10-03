<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {

	//Usado para testar *.html dentro da pasta views.
	$page = new Hcode\Page();

	$page->setTpl("index");

	/*  
//foi usado para testar o banco de dados. Ok!   
	$sql = new Hcode\DB\Sql();

	$results = $sql->select("SELECT * FROM tb_users"); 

	echo json_encode($results);
*/
});

$app->get('/admin', function() {

	//Usado para testar *.html dentro da pasta views.
	$page = new \Hcode\PageAdmin();

	$page->setTpl("index");

});

$app->run();

 ?>