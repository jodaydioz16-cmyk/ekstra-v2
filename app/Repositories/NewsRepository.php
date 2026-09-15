<?php
namespace App\Repositories;
use App\Core\Database;
final class NewsRepository {
    public function __construct(private Database $db) {}
    public function published(int $limit = 12): array { $s=$this->db->pdo()->prepare("SELECT * FROM news WHERE status='published' AND published_at<=NOW() ORDER BY published_at DESC LIMIT ?"); $s->bindValue(1,$limit,\PDO::PARAM_INT); $s->execute(); return $s->fetchAll(); }
    public function bySlug(string $slug): ?array { $s=$this->db->pdo()->prepare("SELECT * FROM news WHERE slug=? AND status='published' AND published_at<=NOW()");$s->execute([$slug]);return $s->fetch()?:null; }
}
