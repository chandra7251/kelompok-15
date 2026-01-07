<?php

namespace App\Models;

use App\Core\Database;

class User
{
    protected Database $db;
    private ?int $id = null;
    private string $nama = '';
    private string $email = '';
    private string $password = '';
    private string $role = '';
    private bool $isActive = true;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;
    private ?string $photo = null;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNama(): string
    {
        return $this->nama;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }
    public function getPhoto(): ?string
    {
        return $this->photo;
    }
    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setNama(string $nama): self
    {
        $nama = trim($nama);
        if (empty($nama))
            throw new \InvalidArgumentException("Nama tidak boleh kosong");
        if (strlen($nama) > 100)
            throw new \InvalidArgumentException("Nama maksimal 100 karakter");
        $this->nama = $nama;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $email = trim(strtolower($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new \InvalidArgumentException("Format email tidak valid");
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password, bool $hash = true): self
    {
        if ($hash) {
            if (strlen($password) < 6)
                throw new \InvalidArgumentException("Password minimal 6 karakter");
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $this->password = $password;
        }
        return $this;
    }

    public function setRole(string $role): self
    {
        if (!in_array($role, ['mahasiswa', 'orangtua', 'admin']))
            throw new \InvalidArgumentException("Role tidak valid");
        $this->role = $role;
        return $this;
    }

    public function find(int $id): ?self
    {
        $data = $this->db->fetch("SELECT * FROM users WHERE id = :id", ['id' => $id]);
        return $data ? $this->hydrate($data) : null;
    }

    public function findByEmail(string $email): ?self
    {
        $data = $this->db->fetch("SELECT * FROM users WHERE email = :email", ['email' => strtolower(trim($email))]);
        return $data ? $this->hydrate($data) : null;
    }

    public function all(): array
    {
        return $this->db->fetchAll("SELECT * FROM users ORDER BY created_at DESC");
    }

    public function findByRole(string $role): array
    {
        return $this->db->fetchAll("SELECT * FROM users WHERE role = :role ORDER BY nama ASC", ['role' => $role]);
    }

    public function create(): int
    {
        return $this->db->insert(
            "INSERT INTO users (nama, email, password, role) VALUES (:nama, :email, :password, :role)",
            ['nama' => $this->nama, 'email' => $this->email, 'password' => $this->password, 'role' => $this->role]
        );
    }

    public function update(): bool
    {
        return $this->db->update(
            "UPDATE users SET nama = :nama, email = :email, updated_at = NOW() WHERE id = :id",
            ['nama' => $this->nama, 'email' => $this->email, 'id' => $this->id]
        ) > 0;
    }

    public function updatePassword(string $newPassword): bool
    {
        $this->setPassword($newPassword);
        return $this->db->update(
            "UPDATE users SET password = :password, updated_at = NOW() WHERE id = :id",
            ['password' => $this->password, 'id' => $this->id]
        ) > 0;
    }

    public function delete(): bool
    {
        return $this->db->delete("DELETE FROM users WHERE id = :id", ['id' => $this->id]) > 0;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
        $params = ['email' => strtolower(trim($email))];
        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }
        return $this->db->fetch($sql, $params)['count'] > 0;
    }

    protected function hydrate(array $data): self
    {
        $this->id = (int) $data['id'];
        $this->nama = $data['nama'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->role = $data['role'];
        $this->isActive = (bool) ($data['is_active'] ?? 1);
        $this->createdAt = $data['created_at'];
        $this->updatedAt = $data['updated_at'];
        $this->photo = $data['photo'] ?? null;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'email' => $this->email,
            'role' => $this->role,
            'photo' => $this->photo,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}
