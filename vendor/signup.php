<?php
require_once __DIR__ . '/functions.php';

$name = $_POST['name'] ?? null;
$login = $_POST['login'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;
$password = $_POST['password'] ?? null;
$confirm_password = $_POST['confirm_password'] ?? null;
$loginLength = 5;
$passLength = 5;

$user_login = findUser($login, 'login');
$user_email = findUser($email, 'email');
$user_phone = findUser($phone, 'phone');

if ($login === 'admin' && $password === 'restaurant') {
    $role = 'admin';
}
else {
    $role = 'user';
}

$nameArray = explode(' ', $name);

if (count($nameArray) > 3 || count($nameArray) < 2) {
    setError('name', 'Введите корректное ФИО');
}

if (empty($name)) {
    setError('name', 'Заполните поле');
}
elseif (preg_match("/[0-9$*<>]/", $name)) {
    setError('name', 'Некорректные символы');
}

if (empty($login)) {
    setError('login', 'Заполните поле');
}
elseif (strlen($login) < $loginLength) {
    setError('login', 'Минимальная длина логина ' . $loginLength . ' символов');
}

if (empty($email)) {
    setError('email', 'Заполните поле');
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    setError('email', 'Неверный формат почты');
}

if (empty($phone)) {
    setError('phone', 'Заполните поле');
}

if (empty($password)) {
    setError('password', 'Заполните поле'); 
}
elseif (strlen($password) < $passLength) {
    setError('password', 'Минимальная длина пароля ' . $passLength . ' символов');
}

if (empty($confirm_password)) {
    setError('confirm_password', 'Заполните поле'); 
}
elseif (strlen($confirm_password) < $passLength) {
    setError('confirm_password', 'Минимальная длина пароля ' . $passLength . ' символов');
}

if ($password !== $confirm_password) {
    setAlert('error', 'Пароли не совпадают');
}

if (!empty($user_login)) {
    setError('login', 'Такой логин уже существует');
}

if (!empty($user_email)) {
    setError('email', 'E-mail занят');
}

if (!empty($user_phone)) {
    setError('phone', 'Номер телефона занят');
}

if (!empty($_SESSION['validation'] || !empty($_SESSION['message']))) {
    oldValue('name', $name);
    oldValue('login', $login);
    oldValue('email', $email);
    oldValue('phone', $phone);
    redirect('/signup.php');
}

$pdo = getPDO();

$query = "INSERT INTO users (role, name, login, email, phone, password) VALUES (:role, :name, :login, :email, :phone, :password)";
$params = [
    'role' => $role,
    'name' => $name,
    'login' => $login,
    'email' => $email,
    'phone' => $phone,
    'password' => password_hash($password, PASSWORD_DEFAULT, ['cost' => 11])
];

$stmt = $pdo->prepare($query);
try {
    $stmt->execute($params);
}
catch (\PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    require('../errors/500.php');
    die();
}

redirect('/signin.php');