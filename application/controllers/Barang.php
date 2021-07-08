<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Barang extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model', 'barang');
        $this->methods['index_get']['limit'] = 2;
    }
    // Kode program method GET
    public function index_get()
    {
        $kode = $this->get('kode');
        if ($kode === null) {
            $barang = $this->barang->getbarang();
        } else {
            $barang = $this->barang->getbarang($kode);
        }

        if ($barang) {
            $this->response([
                'status' => true,
                'data' => $barang
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'data' => 'id not found'
            ], 404);
        }
    }

    public function index_delete()
    {
        $kode = $this->delete('kode');

        if ($kode === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], 400);
        } else {
            if ($this->barang->deletebarang($kode) > 0) {
                //ok
                $this->response([
                    'status' => true,
                    'kode' => $kode,
                    'message' => 'data barang has been deleted!'

                ], 204);
            } else {
                //id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], 400);
            }
        }
    }


    public function index_post()
    {
        $data = [
            'kode'       	=> $this->post('kode', true),
            'namabarang'    => $this->post('namabarang', true),
            'jenis' 	    => $this->post('jenis', true),
            'harga'		    => $this->post('harga', true),
            'stok'		    => $this->post('stok', true)
        ];

        if ($this->barang->createbarang($data) > 0) {
            //ok
            $this->response([
                'status' => true,
                'message' => 'new barang has been created.'
            ], 201);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], 400);
        }
    }

    public function index_put()
    {
        // kenapa dibedakan agar id masuk ke where
        $kode = $this->put('kode');
        $data = [
            'kode'       	=> $this->put('kode', true),
            'namabarang'    => $this->put('namabarang', true),
            'jenis' 	    => $this->put('jenis', true),
            'harga'		    => $this->put('harga', true),
            'stok'		    => $this->put('stok', true)
        ];
        if ($this->barang->updatebarang($data, $kode) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data barang has been updated.'
            ], 200);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to update new data!'
            ], 400);
        }
    }
}
