<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login()
    {
        if ($this->input->post()) {
            // Ambil data username dan password dari form
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Cek apakah username dan password valid
            $user = $this->User_model->get_user($username, $password);

            if ($user) {
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role
                ]);
                // Login berhasil, simpan data session
                $this->session->set_userdata('username', $user->username);
                redirect('keuangan'); // Setelah login, redirect ke halaman keuangan
            } else {
                // Login gagal, beri pesan error
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('auth/login'); // Redirect ke halaman login dengan pesan error
            }
        } else {
            // Tampilkan halaman login
            $this->load->view('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login'); // Redirect ke halaman login setelah logout
    }

    public function register()
    {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $role = $this->input->post('role'); // Ambil role dari input

            // Cek jika username sudah ada
            if ($this->User_model->is_username_exist($username)) {
                $this->session->set_flashdata('error', 'Username sudah terdaftar!');
                redirect('auth/register');
                return;
            }

            // Simpan ke database
            $data = [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role // Simpan role yang dipilih user
            ];

            if ($this->User_model->create_user($data)) {
                $this->session->set_flashdata('success', 'Akun berhasil dibuat. Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat akun.');
                redirect('auth/register');
            }
        } else {
            $this->load->view('register');
        }
    }
}
