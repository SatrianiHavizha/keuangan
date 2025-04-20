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
        // Cek jika metode request adalah POST (submit form)
        if ($this->input->method() === 'post') {
            $username = $this->input->post('username');
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $role     = $this->input->post('role');

            $data = [
                'username' => $username,
                'password' => $password,
                'role'     => $role
            ];

            // Insert data ke database
            $this->db->insert('users', $data);
            $newUserId = $this->db->insert_id();

            // Simpan pesan sukses dengan session flashdata
            $this->session->set_flashdata('success', 'Account successfully created. Please login.');

            // Redirect ke halaman login setelah berhasil register
            redirect('auth/login');
        } else {
            // Jika bukan POST, tampilkan form register
            $this->load->view('register');
        }
    }

    public function create_user_by_admin()
    {
        // Cek apakah user sudah login sebagai admin
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }

        if ($this->input->method() === 'post') {
            $username = $this->input->post('username');
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $role     = 'user'; // default role

            $data = [
                'username' => $username,
                'password' => $password,
                'role'     => $role
            ];

            $this->db->insert('users', $data);

            $this->session->set_flashdata('success', 'User baru berhasil ditambahkan oleh admin.');
            redirect('keuangan'); // atau halaman list user
        } else {
            show_404(); // biar gak bisa akses langsung formnya dari URL
        }
    }
}
