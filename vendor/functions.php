<?php
session_start();

require_once __DIR__ . '/connect.php';

// Общие функции
function redirect(string $path): void
{
    header("Location: $path");
    die();
}

// Функции пользователя
function setError(string $field, string $message): void
{
    $_SESSION['validation'][$field] = $message;
}

function checkError(string $field): bool
{
    return isset($_SESSION['validation'][$field]);
}

function errorFrame(string $field): string
{
    return isset($_SESSION['validation'][$field]) ? 'aria-invalid="true"' : '';
}

function errorMessage(string $field): string
{
    $message = $_SESSION['validation'][$field] ?? '';
    unset($_SESSION['validation'][$field]);
    return $message;
}

function oldValue(string $key, mixed $value): void
{
    $_SESSION['old'][$key] = $value;
}

function old(string $key)
{
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

function setAlert(string $key, string $message): void
{
    $_SESSION['message'][$key] = $message;
}

function checkAlert(string $key): bool
{
    return isset($_SESSION['message'][$key]);
}

function getAlert(string $key): string
{
    $message = $_SESSION['message'][$key] ?? '';
    unset($_SESSION['message'][$key]);
    return $message;
}

function findUser(string $var, string $location = ''): array|bool
{
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE $location = :value");
    $stmt->execute(['value' => $var]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

function authorizedUserData(): array|false
{
    $pdo = getPDO();
    
    if (!isset($_SESSION['user'])) {
        return false;
    }

    $userId = $_SESSION['user']['id'] ?? null;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

function logout(): void
{
    unset($_SESSION['user']);
    redirect('/signin.php');
}

function denyNoUser(): void
{
    if (empty($_SESSION['user'])) {
        redirect('/signin.php');
    }
}

function denyUser(): void
{
    if (!empty($_SESSION['user'])) {
        redirect('/profile.php');
    }
}

function denyNoAdmin(): void
{
    if ($_SESSION['user']['status'] === 'user') {
        redirect('/');
    }
}