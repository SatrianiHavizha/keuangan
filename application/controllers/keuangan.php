<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        if (!$this->session->userdata('username')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');

        if ($role == 'admin') {
            // Admin: semua transaksi
            $data['transaksi'] = $this->db->get('transaksi')->result();

            // Total semua pemasukan
            $this->db->select_sum('jumlah');
            $this->db->where('jenis', 'Pemasukan');
            $pemasukan = $this->db->get('transaksi')->row();
            $data['total_pemasukan'] = $pemasukan->jumlah ?? 0;

            // Total semua pengeluaran
            $this->db->select_sum('jumlah');
            $this->db->where('jenis', 'Pengeluaran');
            $pengeluaran = $this->db->get('transaksi')->row();
            $data['total_pengeluaran'] = $pengeluaran->jumlah ?? 0;

            // Saldo total semua user
            $data['saldo'] = $data['total_pemasukan'] - $data['total_pengeluaran'];

            // Ambil semua user
            $data['users'] = $this->user_model->get_all_users();

            // Loop user dan hitung saldo + total pengeluaran
            foreach ($data['users'] as &$user) {
                if ($user->role != 'admin') {
                    // Pemasukan
                    $this->db->select_sum('jumlah');
                    $this->db->where(['jenis' => 'Pemasukan', 'user_id' => $user->id]);
                    $pemasukan = $this->db->get('transaksi')->row()->jumlah ?? 0;

                    // Pengeluaran
                    $this->db->select_sum('jumlah');
                    $this->db->where(['jenis' => 'Pengeluaran', 'user_id' => $user->id]);
                    $pengeluaran = $this->db->get('transaksi')->row()->jumlah ?? 0;

                    $user->saldo = $pemasukan - $pengeluaran;
                    $user->total_pengeluaran = $pengeluaran;
                } else {
                    $user->saldo = null;
                    $user->total_pengeluaran = null;
                }
            }
        } else {
            // User biasa: hanya transaksi sendiri
            $data['transaksi'] = $this->db->get_where('transaksi', ['user_id' => $user_id])->result();

            // Pemasukan
            $this->db->select_sum('jumlah');
            $this->db->where(['jenis' => 'Pemasukan', 'user_id' => $user_id]);
            $pemasukan = $this->db->get('transaksi')->row();
            $data['total_pemasukan'] = $pemasukan->jumlah ?? 0;

            // Pengeluaran
            $this->db->select_sum('jumlah');
            $this->db->where(['jenis' => 'Pengeluaran', 'user_id' => $user_id]);
            $pengeluaran = $this->db->get('transaksi')->row();
            $data['total_pengeluaran'] = $pengeluaran->jumlah ?? 0;

            // Saldo
            $data['saldo'] = $data['total_pemasukan'] - $data['total_pengeluaran'];
        }

        $this->load->view('dashboard', $data);
    }


    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('transaksi');
        redirect('keuangan');
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $data = [
                'tanggal' => $this->input->post('tanggal'),
                'keterangan' => $this->input->post('keterangan'),
                'jenis' => $this->input->post('jenis'),
                'jumlah' => $this->input->post('jumlah'),
                'user_id' => $this->session->userdata('user_id') // penting bro!
            ];
            $this->db->insert('transaksi', $data);
            redirect('keuangan');
        } else {
            $this->load->view('tambah_transaksi');
        }
    }

    public function simpan_transaksi()
    {
        $data = [
            'keterangan' => $this->input->post('keterangan'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal'),
            'jenis' => $this->input->post('jenis'),
            'user_id' => $this->session->userdata('user_id')
        ];

        $this->db->insert('transaksi', $data);
        redirect('keuangan');
    }

    public function delete_user($id)
{
    $this->load->model('User_model'); // Pastikan model dimuat
    $this->User_model->deleteUserById($id);
    $this->session->set_flashdata('success', 'User berhasil dihapus.');
    redirect('keuangan'); // Ganti dengan halaman list user kamu
}

}
