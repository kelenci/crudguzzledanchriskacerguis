<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Barang extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_m');
    }

    public function index_get()
    {
        $id = $this->get('item_id');
        if ($id === null) {
            $namabarang = $this->Barang_m->getBarang();
        } else {
            $namabarang = $this->Barang_m->getBarang($id);
        }

        if ($namabarang) {
            $this->response([
                'status' => true,
                'data' => $namabarang
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'pesan' => 'barang tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('item_id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'pesan' => 'barang yang dihapus tidak ditemukan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->Barang_m->deletebarang($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'pesan' => 'barang terhapus'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'pesan' => 'barang gagal dihapus'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'kode_barang' => $this->post('kode_barang'),
            'name' => $this->post('name'),
        ];

        if ($this->Barang_m->addbarang($data) > 0) {
            $this->response([
                'status' => true,
                'pesan' => 'barang berhasil ditambahkan'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'pesan' => 'barang gagal ditambahkan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('item_id');
        $data = [
            'kode_barang' => $this->put('kode_barang'),
            'name' => $this->put('name'),
        ];

        if ($this->Barang_m->editbarang($data, $id) > 0) {
            $this->response([
                'status' => true,
                'pesan' => 'barang berhasil diedit'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'pesan' => 'barang gagal diedit'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
