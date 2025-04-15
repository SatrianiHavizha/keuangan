<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan extends CI_Controller {

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
        $data['transaksi'] = $this->db->get('transaksi')->result(); // AMBIL semua transaksi
        
        // Hitung total pemasukan
        $this->db->select_sum('jumlah');
        $this->db->where('jenis', 'Pemasukan');
        $pemasukan = $this->db->get('transaksi')->row();
        $data['total_pemasukan'] = $pemasukan->jumlah ?? 0;
    
        // Hitung total pengeluaran
        $this->db->select_sum('jumlah');
        $this->db->where('jenis', 'Pengeluaran');
        $pengeluaran = $this->db->get('transaksi')->row();
        $data['total_pengeluaran'] = $pengeluaran->jumlah ?? 0;
    
        // Saldo akhir
        $data['saldo'] = $data['total_pemasukan'] - $data['total_pengeluaran'];
    
        // Load view
        $this->load->view('dashboard', $data);
    }
    
    public function hapus($id)
{
    $this->db->where('id', $id);
    $this->db->delete('transaksi'); // ganti "transaksi" sama nama tabel kamu kalau beda

    redirect('keuangan');
}

    
    public function tambah()
    {
        if ($this->input->post()) {
            $data = [
                'tanggal' => $this->input->post('tanggal'),
                'keterangan' => $this->input->post('keterangan'),
                'jenis' => $this->input->post('jenis'),
                'jumlah' => $this->input->post('jumlah')
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
        'jenis' => $this->input->post('jenis')
    ];

    $this->db->insert('transaksi', $data);
    redirect('keuangan');
}


}
