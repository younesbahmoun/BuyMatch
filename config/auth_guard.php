<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireOrganisateur(): ?int
{
    if (empty($_SESSION['user']) || empty($_SESSION['user']['user_id'])) {
        header("Location: ../auth/login.php");
        exit;
    }

    if (($_SESSION['user']['role'] ?? '') !== 'organisateur') {
        header("Location: ../auth/login.php");
        exit;
    }

    return (int) $_SESSION['user']['user_id'];
}

function requireAdmin(): ?int
{
    if (empty($_SESSION['user']) || empty($_SESSION['user']['user_id'])) {
        header("Location: ../auth/login.php");
        exit;
    }

    if (($_SESSION['user']['role'] ?? '') !== 'admin') {
        header("Location: ../auth/login.php");
        exit;
    }

    return (int) $_SESSION['user']['user_id'];
}