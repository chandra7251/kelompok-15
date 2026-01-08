<?php

namespace App\Services;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\OrangTua;

class AuthService
{
    private User $userModel;
    private Mahasiswa $mahasiswaModel;
    private OrangTua $orangtuaModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->mahasiswaModel = new Mahasiswa();
        $this->orangtuaModel = new OrangTua();
    }

    public function login(string $email, string $password): array
    {
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return ['success' => false, 'message' => 'Email tidak terdaftar'];
        }
        if (!$user->verifyPassword($password)) {
            return ['success' => false, 'message' => 'Password salah'];
        }
        if (!$user->isActive()) {
            return ['success' => false, 'message' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.'];
        }

        if ($user->getRole() === 'mahasiswa') {
            $mahasiswa = $this->mahasiswaModel->findByUserId($user->getId());
            if ($mahasiswa) {
                $userData = $mahasiswa->toArray();
            } else {
                $userData = $user->toArray();
            }
        } elseif ($user->getRole() === 'orangtua') {
            $orangtua = $this->orangtuaModel->findByUserId($user->getId());
            if ($orangtua) {
                $userData = $orangtua->toArray();
            } else {
                $userData = $user->toArray();
            }
        } else {
            $userData = $user->toArray();
        }

        $this->setSession($userData);
        return ['success' => true, 'message' => 'Login berhasil', 'user' => $userData];
    }

    public function registerMahasiswa(array $data): array
    {
        if ($this->userModel->emailExists($data['email'])) {
            return ['success' => false, 'message' => 'Email sudah terdaftar'];
        }
        if ($this->mahasiswaModel->nimExists($data['nim'])) {
            return ['success' => false, 'message' => 'NIM sudah terdaftar'];
        }

        try {
            $mahasiswa = new Mahasiswa();
            $mahasiswa->setNama($data['nama']);
            $mahasiswa->setEmail($data['email']);
            $mahasiswa->setPassword($data['password']);
            $mahasiswa->setNim($data['nim']);
            $mahasiswa->setJurusan($data['jurusan'] ?? '');

            $mahasiswaId = $mahasiswa->createMahasiswa();
            return ['success' => true, 'message' => 'Registrasi berhasil', 'mahasiswa_id' => $mahasiswaId];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function registerOrangtua(array $data): array
    {
        if ($this->userModel->emailExists($data['email'])) {
            return ['success' => false, 'message' => 'Email sudah terdaftar'];
        }

        try {
            $orangtua = new OrangTua();
            $orangtua->setNama($data['nama']);
            $orangtua->setEmail($data['email']);
            $orangtua->setPassword($data['password']);
            $orangtua->setNoTelepon($data['no_telepon'] ?? null);

            $orangtuaId = $orangtua->createOrangtua();
            return ['success' => true, 'message' => 'Registrasi berhasil', 'orangtua_id' => $orangtuaId];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']['id']);
    }

    public function getCurrentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public function hasRole(string $role): bool
    {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === $role;
    }

    private function setSession(array $userData): void
    {
        $_SESSION['user'] = $userData;
        $_SESSION['login_time'] = time();
        session_regenerate_id(true);
    }

    public function refreshSession(): void
    {
        if (!$this->isLoggedIn())
            return;

        $user = $this->userModel->find($_SESSION['user']['id']);
        if (!$user)
            return;

        if ($user->getRole() === 'mahasiswa') {
            $mahasiswa = $this->mahasiswaModel->findByUserId($user->getId());
            $userData = $mahasiswa ? $mahasiswa->toArray() : $user->toArray();
        } elseif ($user->getRole() === 'orangtua') {
            $orangtua = $this->orangtuaModel->findByUserId($user->getId());
            $userData = $orangtua ? $orangtua->toArray() : $user->toArray();
        } else {
            $userData = $user->toArray();
        }

        $_SESSION['user'] = array_merge($_SESSION['user'], $userData);
    }
}
