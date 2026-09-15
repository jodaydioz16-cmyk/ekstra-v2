<?php
namespace App\Controllers;
use App\Core\App;use App\Core\Request;use App\Core\View;use App\Services\Auth;
final class DashboardController {
    public function index(Request $r): never {$user=Auth::requireLogin();$pdo=App::container()->get(\App\Core\Database::class)->pdo();$stats=['activities'=>(int)$pdo->query("SELECT COUNT(*) FROM activities WHERE activity_date>=CURDATE() - INTERVAL 30 DAY")->fetchColumn(),'proposals'=>(int)$pdo->query("SELECT COUNT(*) FROM proposals WHERE status IN ('submitted','under_review','forwarded')")->fetchColumn(),'attendance'=>(int)$pdo->query("SELECT COUNT(*) FROM attendance_sessions WHERE status='open'")->fetchColumn()];View::render('internal/dashboard',compact('user','stats'),'internal');}
    public function profile(Request $r): never {$user=Auth::requireLogin();View::render('internal/profile',compact('user'),'internal');}
}
