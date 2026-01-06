<?php

namespace App\Models;

use App\Core\Database;

class Kategori
{
    private Database $db;
    private ?int $id = null;
    private int $mahasiswaId;
    private string $nama = '';
    private string $tipe = '';
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getMahasiswaId(): int
    {
        return $this->mahasiswaId;
    }
    public function getNama(): string
    {
        return $this->nama;
    }
    public function getTipe(): string
    {
        return $this->tipe;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setMahasiswaId(int $mahasiswaId): self
    {
        if ($mahasiswaId <= 0)
            throw new \InvalidArgumentException("Mahasiswa ID tidak valid");
        $this->mahasiswaId = $mahasiswaId;
        return $this;
    }

    public function setNama(string $nama): self
    {
        $nama = trim($nama);
        if (empty($nama))
            throw new \InvalidArgumentException("Nama kategori tidak boleh kosong");
        if (strlen($nama) > 50)
            throw new \InvalidArgumentException("Nama kategori maksimal 50 karakter");
        $this->nama = $nama;
        return $this;
    }

    public function setTipe(string $tipe): self
    {
        if (!in_array($tipe, ['pemasukan', 'pengeluaran'])) {
            throw new \InvalidArgumentException("Tipe harus 'pemasukan' atau 'pengeluaran'");
        }
        $this->tipe = $tipe;
        return $this;
    }

    public function find(int $id): ?self
    {
        $data = $this->db->fetch("SELECT * FROM kategori WHERE id = :id", ['id' => $id]);
        return $data ? $this->hydrate($data) : null;
    }

    public function findByIdAndMahasiswa(int $id, int $mahasiswaId): ?self
    {
        $data = $this->db->fetch(
            "SELECT * FROM kategori WHERE id = :id AND mahasiswa_id = :mahasiswa_id",
            ['id' => $id, 'mahasiswa_id' => $mahasiswaId]
        );
        return $data ? $this->hydrate($data) : null;
    }

    public function getAllByMahasiswa(int $mahasiswaId): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM kategori WHERE mahasiswa_id = :mahasiswa_id ORDER BY tipe, nama ASC",
            ['mahasiswa_id' => $mahasiswaId]
        );
    }

    public function getByTipe(int $mahasiswaId, string $tipe): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM kategori WHERE mahasiswa_id = :mahasiswa_id AND tipe = :tipe ORDER BY nama ASC",
            ['mahasiswa_id' => $mahasiswaId, 'tipe' => $tipe]
        );
    }

    public function create(): int
    {
        if ($this->isDuplicate()) {
            throw new \InvalidArgumentException("Kategori dengan nama dan tipe yang sama sudah ada");
        }
        return $this->db->insert(
            "INSERT INTO kategori (mahasiswa_id, nama, tipe) VALUES (:mahasiswa_id, :nama, :tipe)",
            ['mahasiswa_id' => $this->mahasiswaId, 'nama' => $this->nama, 'tipe' => $this->tipe]
        );
    }

    public function update(): bool
    {
        if ($this->isDuplicate($this->id)) {
            throw new \InvalidArgumentException("Kategori dengan nama dan tipe yang sama sudah ada");
        }
        return $this->db->update(
            "UPDATE kategori SET nama = :nama, tipe = :tipe, updated_at = NOW() WHERE id = :id",
            ['nama' => $this->nama, 'tipe' => $this->tipe, 'id' => $this->id]
        ) > 0;
    }

    public function delete(): bool
    {
        $count = $this->db->fetch("SELECT COUNT(*) as count FROM transaksi WHERE kategori_id = :id", ['id' => $this->id]);
        if ($count['count'] > 0) {
            throw new \InvalidArgumentException("Kategori tidak dapat dihapus karena masih digunakan oleh " . $count['count'] . " transaksi");
        }
        return $this->db->delete("DELETE FROM kategori WHERE id = :id", ['id' => $this->id]) > 0;
    }

    private function isDuplicate(?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM kategori WHERE mahasiswa_id = :mahasiswa_id AND nama = :nama AND tipe = :tipe";
        $params = ['mahasiswa_id' => $this->mahasiswaId, 'nama' => $this->nama, 'tipe' => $this->tipe];
        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }
        return $this->db->fetch($sql, $params)['count'] > 0;
    }

    public function getWithTransaksiCount(int $mahasiswaId): array
    {
        return $this->db->fetchAll(
            "SELECT k.*, COUNT(t.id) as transaksi_count FROM kategori k LEFT JOIN transaksi t ON k.id = t.kategori_id WHERE k.mahasiswa_id = :mahasiswa_id GROUP BY k.id ORDER BY k.tipe, k.nama ASC",
            ['mahasiswa_id' => $mahasiswaId]
        );
    }

    protected function hydrate(array $data): self
    {
        $this->id = (int) $data['id'];
        $this->mahasiswaId = (int) $data['mahasiswa_id'];
        $this->nama = $data['nama'];
        $this->tipe = $data['tipe'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'mahasiswa_id' => $this->mahasiswaId,
            'nama' => $this->nama,
            'tipe' => $this->tipe,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}
