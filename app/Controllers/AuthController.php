<?php

namespace App\Controllers;

use App\Services\AuthService;

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function showLogin(): void
    {
        if ($this->authService->isLoggedIn()) {
            redirect('index.php?page=dashboard');
        }
        view('auth.login');
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?page=login');
        }

        if (!verify_csrf()) {
            flash('error', 'Token tidak valid');
            redirect('index.php?page=login');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            flash('error', 'Email dan password wajib diisi');
            set_old_input($_POST);
            redirect('index.php?page=login');
        }

        $result = $this->authService->login($email, $password);

        if ($result['success']) {
            clear_old_input();
            flash('success', 'Selamat datang, ' . e($result['user']['nama']));
            redirect('index.php?page=dashboard');
        } else {
            flash('error', $result['message']);
            set_old_input($_POST);
            redirect('index.php?page=login');
        }
    }

    public function showRegister(): void
    {
        if ($this->authService->isLoggedIn()) {
            redirect('index.php?page=dashboard');
        }
        view('auth.register');
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?page=register');
        }

        if (!verify_csrf()) {
            flash('error', 'Token tidak valid');
            redirect('index.php?page=register');
        }

        $role = $_POST['role'] ?? 'mahasiswa';
        $data = [
            'nama' => trim($_POST['nama'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? ''
        ];

        $errors = [];
        if (empty($data['nama']))
            $errors[] = 'Nama wajib diisi';
        if (!validate_email($data['email']))
            $errors[] = 'Format email tidak valid';
        if (strlen($data['password']) < 6)
            $errors[] = 'Password minimal 6 karakter';
        if ($data['password'] !== $data['password_confirm'])
            $errors[] = 'Konfirmasi password tidak cocok';

        if ($role === 'mahasiswa') {
            $data['nim'] = trim($_POST['nim'] ?? '');
            $data['jurusan'] = trim($_POST['jurusan'] ?? '');
            if (empty($data['nim']))
                $errors[] = 'NIM wajib diisi';
        } else {
            $data['no_telepon'] = trim($_POST['no_telepon'] ?? '');
        }

        if (!empty($errors)) {
            flash('error', implode('<br>', $errors));
            set_old_input($_POST);
            redirect('index.php?page=register');
        }

        $result = $role === 'mahasiswa'
            ? $this->authService->registerMahasiswa($data)
            : $this->authService->registerOrangtua($data);

        if ($result['success']) {
            clear_old_input();
            flash('success', 'Registrasi berhasil! Silakan login.');
            redirect('index.php?page=login');
        } else {
            flash('error', $result['message']);
            set_old_input($_POST);
            redirect('index.php?page=register');
        }
    }

    public function logout(): void
    {
        $this->authService->logout();
        flash('success', 'Anda telah logout');
        redirect('index.php?page=login');
    }
}