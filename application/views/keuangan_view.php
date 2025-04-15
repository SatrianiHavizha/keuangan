<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Keuangan_model');
    }

    public function index() {
        $data['keuangan'] = $this->Keuangan_model->get_all();
        $this->load->view('keuangan_view', $data);
    }

    public function add() {
        $this->load->view('add_keuangan');
    }

    public function save() {
        $data = [
            'deskripsi' => $this->input->post('deskripsi'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal')
        ];
        $this->Keuangan_model->insert_transaksi($data);
        redirect('keuangan');
    }

    public function edit($id) {
        $data['keuangan'] = $this->Keuangan_model->get_transaksi_by_id($id);
        $this->load->view('edit_keuangan', $data);
    }

    public function update($id) {
        $data = [
            'deskripsi' => $this->input->post('deskripsi'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal')
        ];
        $this->Keuangan_model->update_transaksi($id, $data);
        redirect('keuangan');
    }

    public function delete($id) {
        $this->Keuangan_model->delete_transaksi($id);
        redirect('keuangan');
    }
}
