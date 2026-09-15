<?php
namespace App\Repositories;
use App\Core\Database;
final class ExtracurricularRepository {
    public function __construct(private Database $db) {}
    public function featured(): array { return $this->db->pdo()->query("SELECT e.*, g.name group_name FROM extracurriculars e JOIN extracurricular_groups g ON g.id=e.group_id WHERE e.status='active' ORDER BY e.is_featured DESC,e.name LIMIT 6")->fetchAll(); }
    public function all(): array { return $this->db->pdo()->query("SELECT e.*, g.name group_name FROM extracurriculars e JOIN extracurricular_groups g ON g.id=e.group_id WHERE e.status='active' ORDER BY g.sort_order,e.name")->fetchAll(); }
    public function bySlug(string $slug): ?array { $s=$this->db->pdo()->prepare("SELECT e.*,g.name group_name,g.description group_description FROM extracurriculars e JOIN extracurricular_groups g ON g.id=e.group_id WHERE e.slug=? AND e.status='active'"); $s->execute([$slug]); return $s->fetch() ?: null; }
}
