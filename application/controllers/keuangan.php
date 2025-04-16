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

        // Cek apakah admin atau bukan
        if ($role == 'admin') {
            // Admin bisa lihat semua transaksi
            $data['transaksi'] = $this->db->get('transaksi')->result();

            // Total pemasukan semua user
            $this->db->select_sum('jumlah');
            $this->db->where('jenis', 'Pemasukan');
            $pemasukan = $this->db->get('transaksi')->row();
            $data['total_pemasukan'] = $pemasukan->jumlah ?? 0;

            // Total pengeluaran semua user
            $this->db->select_sum('jumlah');
            $this->db->where('jenis', 'Pengeluaran');
            $pengeluaran = $this->db->get('transaksi')->row();
            $data['total_pengeluaran'] = $pengeluaran->jumlah ?? 0;

        } else {
            // User hanya lihat transaksinya sendiri
            $data['transaksi'] = $this->db->get_where('transaksi', ['user_id' => $user_id])->result();

            // Total pemasukan user
            $this->db->select_sum('jumlah');
            $this->db->where(['jenis' => 'Pemasukan', 'user_id' => $user_id]);
            $pemasukan = $this->db->get('transaksi')->row();
            $data['total_pemasukan'] = $pemasukan->jumlah ?? 0;

            // Total pengeluaran user
            $this->db->select_sum('jumlah');
            $this->db->where(['jenis' => 'Pengeluaran', 'user_id' => $user_id]);
            $pengeluaran = $this->db->get('transaksi')->row();
            $data['total_pengeluaran'] = $pengeluaran->jumlah ?? 0;
        }

        $data['saldo'] = $data['total_pemasukan'] - $data['total_pengeluaran'];

        // Load user list hanya kalau admin (opsional)
        if ($role == 'admin') {
            $data['users'] = $this->user_model->get_all_users();
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
                'user_id' => $this->session->userdata('user_id') // penting!
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
            'user_id' => $this->session->userdata('user_id') // jangan lupa tambahkan ini
        ];

        $this->db->insert('transaksi', $data);
        redirect('keuangan');
    }
}
