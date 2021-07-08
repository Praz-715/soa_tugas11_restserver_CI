<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Mahasiswa extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');
        $this->methods['index_get']['limit'] = 2;
    }
    // Kode program method GET
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $mahasiswa = $this->mahasiswa->getMahasiswa();
        } else {
            $mahasiswa = $this->mahasiswa->getMahasiswa($id);
        }

        if ($mahasiswa) {
            $this->response([
                'status' => true,
                'data' => $mahasiswa
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
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], 400);
        } else {
            if ($this->mahasiswa->deleteMahasiswa($id) > 0) {
                //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'data mahasiswa has been deleted!'

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
            'id' => $this->post('id', true),
            'nim' => $this->post('nim', true),
            'nama' => $this->post('nama', true),
            'email' => $this->post('email', true),
            'jurusan' => $this->post('jurusan', true)
        ];

        if ($this->mahasiswa->createMahasiswa($data) > 0) {
            //ok
            $this->response([
                'status' => true,
                'message' => 'new mahasiswa has been created.'
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
        $id = $this->put('id');
        $data = [
            'id' => $this->put('id', true),
            'nim' => $this->put('nim', true),
            'nama' => $this->put('nama', true),
            'email' => $this->put('email', true),
            'jurusan' => $this->put('jurusan', true)
        ];
        if ($this->mahasiswa->updateMahasiswa($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data mahasiswa has been updated.'
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
