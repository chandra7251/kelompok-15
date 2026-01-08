<?php

namespace App\Models;

use App\Core\Database;

class OrangTua extends User
{
    private ?int $orangtuaId = null;
    private ?int $userId = null;
    private ?string $noTelepon = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getOrangtuaId(): ?int
    {
        return $this->orangtuaId;
    }
    public function getUserId(): ?int
    {
        return $this->userId;
    }
    public function getNoTelepon(): ?string
    {
        return $this->noTelepon;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setNoTelepon(?string $noTelepon): self
    {
        if ($noTelepon) {
            $noTelepon = preg_replace('/[^0-9+]/', '', $noTelepon);
            if (strlen($noTelepon) > 20)
                throw new \InvalidArgumentException("Nomor telepon maksimal 20 karakter");
        }
        $this->noTelepon = $noTelepon;
        return $this;
    }

    public function findOrangtua(int $id): ?self
    {
        $sql = "SELECT o.*, u.nama, u.email, u.password, u.role, u.created_at, u.updated_at FROM orangtua o JOIN users u ON o.user_id = u.id WHERE o.id = :id";
        $data = $this->db->fetch($sql, ['id' => $id]);
        return $data ? $this->hydrateOrangtua($data) : null;
    }

    public function findByUserId(int $userId): ?self
    {
        $sql = "SELECT o.*, u.nama, u.email, u.password, u.role, u.created_at, u.updated_at FROM orangtua o JOIN users u ON o.user_id = u.id WHERE o.user_id = :user_id";
        $data = $this->db->fetch($sql, ['user_id' => $userId]);
        return $data ? $this->hydrateOrangtua($data) : null;
    }

    public function allOrangtua(): array
    {
        return $this->db->fetchAll("SELECT o.*, u.nama, u.email FROM orangtua o JOIN users u ON o.user_id = u.id ORDER BY u.nama ASC");
    }

    public function createOrangtua(): int
    {
        $this->db->beginTransaction();
        try {
            $this->setRole('orangtua');
            $userId = $this->create();
            $this->userId = $userId;

            $orangtuaId = $this->db->insert(
                "INSERT INTO orangtua (user_id, no_telepon) VALUES (:user_id, :no_telepon)",
                ['user_id' => $userId, 'no_telepon' => $this->noTelepon]
            );

            $this->db->commit();
            return $orangtuaId;
        } catch (\Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function updateOrangtua(): bool
    {
        $affected = $this->db->update(
            "UPDATE orangtua SET no_telepon = :no_telepon, updated_at = NOW() WHERE id = :id",
            ['no_telepon' => $this->noTelepon, 'id' => $this->orangtuaId]
        );
        $this->update();
        return $affected > 0;
    }

    public function getMahasiswaLinked(): array
    {
        return $this->db->fetchAll(
            "SELECT m.*, u.nama, u.email FROM mahasiswa m JOIN users u ON m.user_id = u.id JOIN relasi_orangtua_mahasiswa r ON m.id = r.mahasiswa_id WHERE r.orangtua_id = :orangtua_id ORDER BY u.nama ASC",
            ['orangtua_id' => $this->orangtuaId]
        );
    }

    public function linkMahasiswa(int $mahasiswaId): bool
    {
        $exists = $this->db->fetch(
            "SELECT COUNT(*) as count FROM relasi_orangtua_mahasiswa WHERE orangtua_id = :orangtua_id AND mahasiswa_id = :mahasiswa_id",
            ['orangtua_id' => $this->orangtuaId, 'mahasiswa_id' => $mahasiswaId]
        );
        if ($exists['count'] > 0)
            return true;

        $this->db->insert(
            "INSERT INTO relasi_orangtua_mahasiswa (orangtua_id, mahasiswa_id) VALUES (:orangtua_id, :mahasiswa_id)",
            ['orangtua_id' => $this->orangtuaId, 'mahasiswa_id' => $mahasiswaId]
        );
        return true;
    }

    public function unlinkMahasiswa(int $mahasiswaId): bool
    {
        return $this->db->delete(
            "DELETE FROM relasi_orangtua_mahasiswa WHERE orangtua_id = :orangtua_id AND mahasiswa_id = :mahasiswa_id",
            ['orangtua_id' => $this->orangtuaId, 'mahasiswa_id' => $mahasiswaId]
        ) > 0;
    }

    public function isMahasiswaLinked(int $mahasiswaId): bool
    {
        $result = $this->db->fetch(
            "SELECT COUNT(*) as count FROM relasi_orangtua_mahasiswa WHERE orangtua_id = :orangtua_id AND mahasiswa_id = :mahasiswa_id",
            ['orangtua_id' => $this->orangtuaId, 'mahasiswa_id' => $mahasiswaId]
        );
        return $result['count'] > 0;
    }

    public function getTransferHistory(int $limit = 10): array
    {
        $stmt = $this->db->getConnection()->prepare(
            "SELECT t.*, u.nama as mahasiswa_nama FROM transfer_saldo t JOIN mahasiswa m ON t.mahasiswa_id = m.id JOIN users u ON m.user_id = u.id WHERE t.orangtua_id = :orangtua_id ORDER BY t.created_at DESC LIMIT :limit"
        );
        $stmt->bindValue(':orangtua_id', $this->orangtuaId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    protected function hydrateOrangtua(array $data): self
    {
        $this->orangtuaId = (int) $data['id'];
        $this->userId = (int) $data['user_id'];
        $this->noTelepon = $data['no_telepon'];

        $this->setId($data['user_id']);
        parent::hydrate([
            'id' => $data['user_id'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at']
        ]);
        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'orangtua_id' => $this->orangtuaId,
            'no_telepon' => $this->noTelepon
        ]);
    }
}
