<?php

namespace App\Models;

use App\Core\Database;

class TransferSaldo
{
    private Database $db;
    private ?int $id = null;
    private int $orangtuaId;
    private int $mahasiswaId;
    private float $jumlah;
    private string $mataUang = 'IDR';
    private float $jumlahIdr;
    private float $kursRate = 1;
    private ?string $keterangan = null;
    private string $status = 'completed';
    private ?string $createdAt = null;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getOrangtuaId(): int
    {
        return $this->orangtuaId;
    }
    public function getMahasiswaId(): int
    {
        return $this->mahasiswaId;
    }
    public function getJumlah(): float
    {
        return $this->jumlah;
    }
    public function getMataUang(): string
    {
        return $this->mataUang;
    }
    public function getJumlahIdr(): float
    {
        return $this->jumlahIdr;
    }
    public function getKursRate(): float
    {
        return $this->kursRate;
    }
    public function getKeterangan(): ?string
    {
        return $this->keterangan;
    }
    public function getStatus(): string
    {
        return $this->status;
    }

    public function setOrangtuaId(int $orangtuaId): self
    {
        $this->orangtuaId = $orangtuaId;
        return $this;
    }
    public function setMahasiswaId(int $mahasiswaId): self
    {
        $this->mahasiswaId = $mahasiswaId;
        return $this;
    }

    public function setJumlah(float $jumlah): self
    {
        if ($jumlah <= 0)
            throw new \InvalidArgumentException("Jumlah harus lebih dari 0");
        $this->jumlah = $jumlah;
        return $this;
    }

    public function setMataUang(string $mataUang): self
    {
        $this->mataUang = strtoupper(trim($mataUang));
        return $this;
    }
    public function setJumlahIdr(float $jumlahIdr): self
    {
        $this->jumlahIdr = $jumlahIdr;
        return $this;
    }
    public function setKursRate(float $kursRate): self
    {
        $this->kursRate = $kursRate;
        return $this;
    }
    public function setKeterangan(?string $keterangan): self
    {
        $this->keterangan = $keterangan;
        return $this;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, ['pending', 'completed', 'failed'])) {
            throw new \InvalidArgumentException("Status tidak valid");
        }
        $this->status = $status;
        return $this;
    }

    public function find(int $id): ?self
    {
        $data = $this->db->fetch("SELECT * FROM transfer_saldo WHERE id = :id", ['id' => $id]);
        return $data ? $this->hydrate($data) : null;
    }

    public function getAllByOrangtua(int $orangtuaId, int $limit = 50): array
    {
        $stmt = $this->db->getConnection()->prepare(
            "SELECT t.*, u.nama as mahasiswa_nama, m.nim FROM transfer_saldo t JOIN mahasiswa m ON t.mahasiswa_id = m.id JOIN users u ON m.user_id = u.id WHERE t.orangtua_id = :orangtua_id ORDER BY t.created_at DESC LIMIT :limit"
        );
        $stmt->bindValue(':orangtua_id', $orangtuaId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllByMahasiswa(int $mahasiswaId, int $limit = 50): array
    {
        $stmt = $this->db->getConnection()->prepare(
            "SELECT t.*, u.nama as orangtua_nama FROM transfer_saldo t JOIN orangtua o ON t.orangtua_id = o.id JOIN users u ON o.user_id = u.id WHERE t.mahasiswa_id = :mahasiswa_id ORDER BY t.created_at DESC LIMIT :limit"
        );
        $stmt->bindValue(':mahasiswa_id', $mahasiswaId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create(): int
    {
        $this->db->beginTransaction();
        try {
            $id = $this->db->insert(
                "INSERT INTO transfer_saldo (orangtua_id, mahasiswa_id, jumlah, mata_uang, jumlah_idr, kurs_rate, keterangan, status) VALUES (:orangtua_id, :mahasiswa_id, :jumlah, :mata_uang, :jumlah_idr, :kurs_rate, :keterangan, :status)",
                [
                    'orangtua_id' => $this->orangtuaId,
                    'mahasiswa_id' => $this->mahasiswaId,
                    'jumlah' => $this->jumlah,
                    'mata_uang' => $this->mataUang,
                    'jumlah_idr' => $this->jumlahIdr,
                    'kurs_rate' => $this->kursRate,
                    'keterangan' => $this->keterangan,
                    'status' => $this->status
                ]
            );

            if ($this->status === 'completed') {
                $this->db->update("UPDATE mahasiswa SET saldo = saldo + :amount WHERE id = :id", ['amount' => $this->jumlahIdr, 'id' => $this->mahasiswaId]);
            }

            $this->db->commit();
            return $id;
        } catch (\Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function getTotalByMahasiswa(int $mahasiswaId): float
    {
        $result = $this->db->fetch("SELECT COALESCE(SUM(jumlah_idr), 0) as total FROM transfer_saldo WHERE mahasiswa_id = :id AND status = 'completed'", ['id' => $mahasiswaId]);
        return (float) $result['total'];
    }

    protected function hydrate(array $data): self
    {
        $this->id = (int) $data['id'];
        $this->orangtuaId = (int) $data['orangtua_id'];
        $this->mahasiswaId = (int) $data['mahasiswa_id'];
        $this->jumlah = (float) $data['jumlah'];
        $this->mataUang = $data['mata_uang'];
        $this->jumlahIdr = (float) $data['jumlah_idr'];
        $this->kursRate = (float) $data['kurs_rate'];
        $this->keterangan = $data['keterangan'];
        $this->status = $data['status'];
        $this->createdAt = $data['created_at'];
        return $this;
    }
}
