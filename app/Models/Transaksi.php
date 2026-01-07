<?php

namespace App\Models;

use App\Core\Database;

class Transaksi
{
    private Database $db;
    private ?int $id = null;
    private int $mahasiswaId;
    private int $kategoriId;
    private float $jumlah;
    private string $mataUang = 'IDR';
    private float $jumlahIdr;
    private float $kursRate = 1;
    private ?string $keterangan = null;
    private string $tanggal;
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
    public function getKategoriId(): int
    {
        return $this->kategoriId;
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
    public function getTanggal(): string
    {
        return $this->tanggal;
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

    public function setKategoriId(int $kategoriId): self
    {
        if ($kategoriId <= 0)
            throw new \InvalidArgumentException("Kategori ID tidak valid");
        $this->kategoriId = $kategoriId;
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

    public function setTanggal(string $tanggal): self
    {
        if (!validate_date($tanggal))
            throw new \InvalidArgumentException("Format tanggal tidak valid");
        $this->tanggal = $tanggal;
        return $this;
    }

    public function find(int $id): ?self
    {
        $data = $this->db->fetch(
            "SELECT t.*, k.nama as kategori_nama, k.tipe FROM transaksi t JOIN kategori k ON t.kategori_id = k.id WHERE t.id = :id",
            ['id' => $id]
        );
        return $data ? $this->hydrate($data) : null;
    }

    public function findByIdAndMahasiswa(int $id, int $mahasiswaId): ?self
    {
        $data = $this->db->fetch(
            "SELECT t.*, k.nama as kategori_nama, k.tipe FROM transaksi t JOIN kategori k ON t.kategori_id = k.id WHERE t.id = :id AND t.mahasiswa_id = :mahasiswa_id",
            ['id' => $id, 'mahasiswa_id' => $mahasiswaId]
        );
        return $data ? $this->hydrate($data) : null;
    }

    public function getAllByMahasiswa(int $mahasiswaId, int $limit = 50): array
    {
        $stmt = $this->db->getConnection()->prepare(
            "SELECT t.*, k.nama as kategori_nama, k.tipe FROM transaksi t JOIN kategori k ON t.kategori_id = k.id WHERE t.mahasiswa_id = :mahasiswa_id ORDER BY t.tanggal DESC LIMIT :limit"
        );
        $stmt->bindValue(':mahasiswa_id', $mahasiswaId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getMonthlySummary(int $mahasiswaId, int $year, int $month): array
    {
        return $this->db->fetchAll(
            "SELECT k.tipe, SUM(t.jumlah_idr) as total FROM transaksi t JOIN kategori k ON t.kategori_id = k.id WHERE t.mahasiswa_id = :mahasiswa_id AND YEAR(t.tanggal) = :year AND MONTH(t.tanggal) = :month GROUP BY k.tipe",
            ['mahasiswa_id' => $mahasiswaId, 'year' => $year, 'month' => $month]
        );
    }

    public function getCategorySummary(int $mahasiswaId, string $tipe = 'pengeluaran'): array
    {
        return $this->db->fetchAll(
            "SELECT k.id, k.nama, SUM(t.jumlah_idr) as total FROM transaksi t JOIN kategori k ON t.kategori_id = k.id WHERE t.mahasiswa_id = :mahasiswa_id AND k.tipe = :tipe GROUP BY k.id, k.nama ORDER BY total DESC",
            ['mahasiswa_id' => $mahasiswaId, 'tipe' => $tipe]
        );
    }

    public function create(): int
    {
        return $this->db->insert(
            "INSERT INTO transaksi (mahasiswa_id, kategori_id, jumlah, mata_uang, jumlah_idr, kurs_rate, keterangan, tanggal) VALUES (:mahasiswa_id, :kategori_id, :jumlah, :mata_uang, :jumlah_idr, :kurs_rate, :keterangan, :tanggal)",
            [
                'mahasiswa_id' => $this->mahasiswaId,
                'kategori_id' => $this->kategoriId,
                'jumlah' => $this->jumlah,
                'mata_uang' => $this->mataUang,
                'jumlah_idr' => $this->jumlahIdr,
                'kurs_rate' => $this->kursRate,
                'keterangan' => $this->keterangan,
                'tanggal' => $this->tanggal
            ]
        );
    }

    public function update(): bool
    {
        return $this->db->update(
            "UPDATE transaksi SET kategori_id = :kategori_id, jumlah = :jumlah, mata_uang = :mata_uang, jumlah_idr = :jumlah_idr, kurs_rate = :kurs_rate, keterangan = :keterangan, tanggal = :tanggal WHERE id = :id",
            [
                'kategori_id' => $this->kategoriId,
                'jumlah' => $this->jumlah,
                'mata_uang' => $this->mataUang,
                'jumlah_idr' => $this->jumlahIdr,
                'kurs_rate' => $this->kursRate,
                'keterangan' => $this->keterangan,
                'tanggal' => $this->tanggal,
                'id' => $this->id
            ]
        ) > 0;
    }

    public function delete(): bool
    {
        return $this->db->delete("DELETE FROM transaksi WHERE id = :id", ['id' => $this->id]) > 0;
    }

    protected function hydrate(array $data): self
    {
        $this->id = (int) $data['id'];
        $this->mahasiswaId = (int) $data['mahasiswa_id'];
        $this->kategoriId = (int) $data['kategori_id'];
        $this->jumlah = (float) $data['jumlah'];
        $this->mataUang = $data['mata_uang'];
        $this->jumlahIdr = (float) $data['jumlah_idr'];
        $this->kursRate = (float) $data['kurs_rate'];
        $this->keterangan = $data['keterangan'];
        $this->tanggal = $data['tanggal'];
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'mahasiswa_id' => $this->mahasiswaId,
            'kategori_id' => $this->kategoriId,
            'jumlah' => $this->jumlah,
            'mata_uang' => $this->mataUang,
            'jumlah_idr' => $this->jumlahIdr,
            'kurs_rate' => $this->kursRate,
            'keterangan' => $this->keterangan,
            'tanggal' => $this->tanggal
        ];
    }
}
