<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

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

	User::verifyLogin();

	//Usado para testar *.html dentro da pasta views.
	$page = new \Hcode\PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function() {

	//Usado para testar *.html dentro da pasta views.
	$page = new \Hcode\PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function() {

	User::login(post('deslogin'), post('despassword'));

	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function() {

	User::logout();

	header("Location: /admin/login");
	exit;

});

$app->get("/admin/users", function() {

	User::verifyLogin();

	$users = User::listAll();

	$page = new \Hcode\PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));

});

$app->get('/admin/users/create', function() {

	User::verifyLogin();

	$page = new \Hcode\PageAdmin();

	$page->setTpl("users-create");

});

$app->get("/admin/users/:iduser/delete", function ($iduser) {

	User::verifyLogin();
});

$app->get('/admin/users/:iduser', function($iduser){
 
	User::verifyLogin();
  
	$user = new User();
  
	$user->get((int)$iduser);
  
	$page = new PageAdmin();
  
	$page ->setTpl("users-update", array(
		 "user"=>$user->getValues()
	 ));
  
 });

$app->post("/admin/users/create", function () {

	User::verifyLogin();

   $user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

		"cost"=>12

	]);

	$user->setData($_POST);

   $user->save();

   header("Location: /admin/users");
	exit;

});
/* $app->post("/admin/users/create", function () {

	User::verifyLogin();
}); */

$app->post("/admin/users/:iduser", function ($iduser) {

	User::verifyLogin();
});


$app->run();

 ?>