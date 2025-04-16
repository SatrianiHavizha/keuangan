<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Perbaikan di sini
    public function get_user($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            $user = $query->row();

            // Cocokkan password yang diinput dengan hash di DB
            if (password_verify($password, $user->password)) {
                return $user;
            } else {
                return false; // Password salah
            }
        } else {
            return false; // Username tidak ditemukan
        }
    }

    public function is_username_exist($username) {
        return $this->db->where('username', $username)->get('users')->num_rows() > 0;
    }

    public function create_user($data) {
        return $this->db->insert('users', $data);
    }

    public function get_all_users() {
        return $this->db->get('users')->result(); // Sesuaikan nama tabel
    }
    
    public function get_saldo_by_user($user_id) {
        // Hitung total pemasukan - pengeluaran untuk user tertentu
        $pemasukan = $this->db->select_sum('jumlah')->where('user_id', $user_id)->get('pemasukan')->row()->jumlah;
        $pengeluaran = $this->db->select_sum('jumlah')->where('user_id', $user_id)->get('pengeluaran')->row()->jumlah;
        return $pemasukan - $pengeluaran;
    }
    
}
?>
