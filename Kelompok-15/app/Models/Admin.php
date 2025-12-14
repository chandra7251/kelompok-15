<?php

namespace App\Models;

class Admin extends User
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAdmin(int $userId): ?self
    {
        $data = $this->db->fetch("SELECT * FROM users WHERE id = :id AND role = 'admin'", ['id' => $userId]);
        if ($data) {
            return $this->hydrate($data);
        }
        return null;
    }

    public function getStatistics(): array
    {
        $stats = [];
        $stats['total_users'] = $this->db->fetch("SELECT COUNT(*) as c FROM users")['c'];
        $stats['total_mahasiswa'] = $this->db->fetch("SELECT COUNT(*) as c FROM mahasiswa")['c'];
        $stats['total_orangtua'] = $this->db->fetch("SELECT COUNT(*) as c FROM orangtua")['c'];
        $stats['total_transaksi'] = $this->db->fetch("SELECT COUNT(*) as c FROM transaksi")['c'];
        $stats['total_transaksi_amount'] = $this->db->fetch("SELECT COALESCE(SUM(jumlah_idr), 0) as c FROM transaksi")['c'];
        $stats['total_transfer'] = $this->db->fetch("SELECT COUNT(*) as c FROM transfer_saldo WHERE status = 'completed'")['c'];
        $stats['total_transfer_amount'] = $this->db->fetch("SELECT COALESCE(SUM(jumlah_idr), 0) as c FROM transfer_saldo WHERE status = 'completed'")['c'];
        return $stats;
    }

    public function getRecentActivities(int $limit = 20): array
    {
        $stmt = $this->db->getConnection()->prepare(
            "SELECT 'registration' as type, nama, email, role, created_at FROM users ORDER BY created_at DESC LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllUsers(): array
    {
        return $this->db->fetchAll(
            "SELECT u.*, CASE WHEN u.role = 'mahasiswa' THEN m.nim WHEN u.role = 'orangtua' THEN o.no_telepon ELSE NULL END as extra_info FROM users u LEFT JOIN mahasiswa m ON u.id = m.user_id LEFT JOIN orangtua o ON u.id = o.user_id ORDER BY u.created_at DESC"
        );
    }
}
