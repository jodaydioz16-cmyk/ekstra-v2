<?php
namespace App\Services;
use App\Core\App; use App\Core\Database;
/** Server-side policy for a single extracurricular; UI visibility must not replace this check. */
final class ScopeAuthorizer {
    public static function canManageExtracurricular(int $extracurricularId): bool {
        $user=Auth::requireLogin(); if (in_array($user['role'], ['admin','wakasek','kepala_sekolah'], true)) return true;
        $pdo=App::container()->get(Database::class)->pdo();
        if (in_array($user['role'], ['pembina','pelatih'], true)) { $s=$pdo->prepare('SELECT 1 FROM staff_extracurriculars WHERE user_id=? AND extracurricular_id=? AND active=1');$s->execute([$user['id'],$extracurricularId]);return (bool)$s->fetchColumn(); }
        if ($user['role']==='inti') { $s=$pdo->prepare("SELECT 1 FROM memberships m JOIN positions p ON p.id=m.position_id WHERE m.user_id=? AND m.extracurricular_id=? AND m.status='active' AND p.grants_management=1");$s->execute([$user['id'],$extracurricularId]);return (bool)$s->fetchColumn(); }
        return false;
    }
}
