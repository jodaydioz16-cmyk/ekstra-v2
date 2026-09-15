<?php
namespace App\Services;
use App\Core\App; use App\Core\Database; use App\Core\Session;
final class Auth {
    public static function user(): ?array { Session::start(); return $_SESSION['user'] ?? null; }
    public static function attempt(string $email, string $password): bool {
        $pdo=App::container()->get(Database::class)->pdo(); $s=$pdo->prepare("SELECT u.id,u.name,u.email,u.password_hash,r.code role FROM users u JOIN roles r ON r.id=u.role_id WHERE u.email=? AND u.status='active'");$s->execute([$email]);$user=$s->fetch();
        if (!$user || !password_verify($password,$user['password_hash'])) return false;
        Session::start(); session_regenerate_id(true); unset($user['password_hash']); $_SESSION['user']=$user;
        $pdo->prepare("INSERT INTO audit_logs (actor_user_id,action,entity_type,entity_id,ip_address) VALUES (?, 'auth.login','user',?,?,?)")->execute([$user['id'],$user['id'],$_SERVER['REMOTE_ADDR']??null]); return true;
    }
    public static function logout(): void { Session::start(); $_SESSION=[]; session_destroy(); }
    public static function requireLogin(): array { $user=self::user(); if (!$user) { header('Location: /login'); exit; } return $user; }
    public static function hasRole(string ...$roles): bool { return in_array(self::user()['role'] ?? '', $roles, true); }
}
