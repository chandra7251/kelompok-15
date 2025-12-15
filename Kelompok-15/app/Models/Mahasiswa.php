<?php

namespace App\Models;

use App\Core\Database;

class Mahasiswa extends User
{
    private ?int $mahasiswaId = null;
    private ?int $userId = null;
    private string $nim = '';
    private string $jurusan = '';
    private float $saldo = 0;
    private ?string $pairingCode = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getMahasiswaId(): ?int
    {
        return $this->mahasiswaId;
    }
    public function getUserId(): ?int
    {
        return $this->userId;
    }
    public function getNim(): string
    {
        return $this->nim;
    }
    public function getJurusan(): string
    {
        return $this->jurusan;
    }
    public function getSaldo(): float
    {
        return $this->saldo;
    }
    public function getPairingCode(): ?string
    {
        return $this->pairingCode;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setNim(string $nim): self
    {
        $nim = trim($nim);
        if (empty($nim))
            throw new \InvalidArgumentException("NIM tidak boleh kosong");
        if (strlen($nim) > 20)
            throw new \InvalidArgumentException("NIM maksimal 20 karakter");
        $this->nim = $nim;
        return $this;
    }

    public function setJurusan(string $jurusan): self
    {
        $this->jurusan = trim($jurusan);
        return $this;
    }

    public function setSaldo(float $saldo): self
    {
        if ($saldo < 0)
            throw new \InvalidArgumentException("Saldo tidak boleh negatif");
        $this->saldo = $saldo;
        return $this;
    }

    public function setPairingCode(?string $code): self
    {
        $this->pairingCode = $code;
        return $this;
    }

    public function findMahasiswa(int $id): ?self
    {
        $sql = "SELECT m.*, u.nama, u.email, u.password, u.role, u.created_at, u.updated_at FROM mahasiswa m JOIN users u ON m.user_id = u.id WHERE m.id = :id";
        $data = $this->db->fetch($sql, ['id' => $id]);
        return $data ? $this->hydrateMahasiswa($data) : null;
    }

    public function findByUserId(int $userId): ?self
    {
        $sql = "SELECT m.*, u.nama, u.email, u.password, u.role, u.created_at, u.updated_at FROM mahasiswa m JOIN users u ON m.user_id = u.id WHERE m.user_id = :user_id";
        $data = $this->db->fetch($sql, ['user_id' => $userId]);
        return $data ? $this->hydrateMahasiswa($data) : null;
    }

    public function findByNim(string $nim): ?self
    {
        $sql = "SELECT m.*, u.nama, u.email, u.password, u.role, u.created_at, u.updated_at FROM mahasiswa m JOIN users u ON m.user_id = u.id WHERE m.nim = :nim";
        $data = $this->db->fetch($sql, ['nim' => $nim]);
        return $data ? $this->hydrateMahasiswa($data) : null;
    }

    public function findByPairingCode(string $code): ?self
    {
        $sql = "SELECT m.*, u.nama, u.email, u.password, u.role, u.created_at, u.updated_at FROM mahasiswa m JOIN users u ON m.user_id = u.id WHERE m.pairing_code = :code";
        $data = $this->db->fetch($sql, ['code' => strtoupper(trim($code))]);
        return $data ? $this->hydrateMahasiswa($data) : null;
    }

    public function allMahasiswa(): array
    {
        return $this->db->fetchAll("SELECT m.*, u.nama, u.email FROM mahasiswa m JOIN users u ON m.user_id = u.id ORDER BY u.nama ASC");
    }

    public function createMahasiswa(): int
    {
        $this->db->beginTransaction();
        try {
            $this->setRole('mahasiswa');
            $userId = $this->create();
            $this->userId = $userId;
            $this->pairingCode = $this->generateUniquePairingCode();

            $mahasiswaId = $this->db->insert(
                "INSERT INTO mahasiswa (user_id, nim, jurusan, saldo, pairing_code) VALUES (:user_id, :nim, :jurusan, :saldo, :pairing_code)",
                ['user_id' => $userId, 'nim' => $this->nim, 'jurusan' => $this->jurusan, 'saldo' => $this->saldo, 'pairing_code' => $this->pairingCode]
            );

            $this->createDefaultCategories($mahasiswaId);
            $this->db->commit();
            return $mahasiswaId;
        } catch (\Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function updateMahasiswa(): bool
    {
        $affected = $this->db->update(
            "UPDATE mahasiswa SET nim = :nim, jurusan = :jurusan, updated_at = NOW() WHERE id = :id",
            ['nim' => $this->nim, 'jurusan' => $this->jurusan, 'id' => $this->mahasiswaId]
        );
        $this->update();
        return $affected > 0;
    }

    public function updateSaldo(float $amount, string $operation = 'add'): bool
    {
        if ($operation === 'add') {
            $newSaldo = $this->saldo + $amount;
        } else {
            $newSaldo = $this->saldo - $amount;
        }

        if ($newSaldo < 0)
            throw new \InvalidArgumentException("Saldo tidak mencukupi");

        $affected = $this->db->update("UPDATE mahasiswa SET saldo = :saldo, updated_at = NOW() WHERE id = :id", ['saldo' => $newSaldo, 'id' => $this->mahasiswaId]);
        if ($affected > 0)
            $this->saldo = $newSaldo;
        return $affected > 0;
    }

    public function getTransaksi(int $limit = 10): array
    {
        $stmt = $this->db->getConnection()->prepare(
            "SELECT t.*, k.nama as kategori_nama, k.tipe FROM transaksi t JOIN kategori k ON t.kategori_id = k.id WHERE t.mahasiswa_id = :mahasiswa_id ORDER BY t.tanggal DESC, t.created_at DESC LIMIT :limit"
        );
        $stmt->bindValue(':mahasiswa_id', $this->mahasiswaId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function nimExists(string $nim, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM mahasiswa WHERE nim = :nim";
        $params = ['nim' => $nim];
        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }
        return $this->db->fetch($sql, $params)['count'] > 0;
    }

    private function generateUniquePairingCode(): string
    {
        do {
            $code = generate_pairing_code(8);
            $result = $this->db->fetch("SELECT COUNT(*) as count FROM mahasiswa WHERE pairing_code = :code", ['code' => $code]);
        } while ($result['count'] > 0);
        return $code;
    }

    private function createDefaultCategories(int $mahasiswaId): void
    {
        $categories = [
            // Pemasukan
            ['Transfer Orang Tua', 'pemasukan'],
            ['Beasiswa', 'pemasukan'],
            ['Kerja Part-time', 'pemasukan'],
            ['Pemasukan Lainnya', 'pemasukan'],
            // Pengeluaran Utama (sesuai dokumen)
            ['Makanan', 'pengeluaran'],           // Bobot 35%
            ['Biaya Kos', 'pengeluaran'],         // Bobot 25%
            ['Transportasi', 'pengeluaran'],      // Bobot 15%
            ['Kebutuhan Lain', 'pengeluaran'],    // Bobot 15%
            // Pengeluaran Tambahan
            ['Pendidikan', 'pengeluaran'],
            ['Hiburan', 'pengeluaran'],
            // Tabungan (kategori khusus - bobot -10%)
            ['Tabungan', 'pemasukan']
        ];

        foreach ($categories as $cat) {
            $this->db->insert(
                "INSERT INTO kategori (mahasiswa_id, nama, tipe) VALUES (:mahasiswa_id, :nama, :tipe)",
                ['mahasiswa_id' => $mahasiswaId, 'nama' => $cat[0], 'tipe' => $cat[1]]
            );
        }
    }

    protected function hydrateMahasiswa(array $data): self
    {
        $this->mahasiswaId = (int) $data['id'];
        $this->userId = (int) $data['user_id'];
        $this->nim = $data['nim'];
        $this->jurusan = $data['jurusan'] ?? '';
        $this->saldo = (float) $data['saldo'];
        $this->pairingCode = $data['pairing_code'];

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

    public function toArrayMahasiswa(): array
    {
        return array_merge($this->toArray(), [
            'mahasiswa_id' => $this->mahasiswaId,
            'nim' => $this->nim,
            'jurusan' => $this->jurusan,
            'saldo' => $this->saldo,
            'pairing_code' => $this->pairingCode
        ]);
    }
}
