<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Barang extends REST_Controller {
var $table_name = 'barang';

	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data kontak
function index_get() {
        $id = $this->get('kode');
        if ($id == '') {
            $data = $this->db->get($this->table_name)->result();
        } else {
            $this->db->where('kode', $id);
            $data = $this->db->get($this->table_name)->result();
        }
        $this->response($data, 200);
    }

    
function index_post() {
        $data = array(
            'kode'       	=> $this->post('kode'),
            'namabarang'    => $this->post('namabarang'),
            'jenis' 	    => $this->post('jenis'),
            'harga'		    => $this->post('harga'),
            'stok'		    => $this->post('stok')
        );
        
        $insert = $this->db->insert('barang', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

function index_put() {
        $kode = $this->put('kode');
        $data = array(
            'kode'       	=> $this->put('kode'),
            'namabarang'    => $this->put('namabarang'),
            'jenis' 	    => $this->put('jenis'),
            'harga'		    => $this->put('harga'),
            'stok'		    => $this->put('stok')
        );

        $this->db->where('kode', $kode);
        $update = $this->db->update('barang', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id = $this->delete('kode');
        $this->db->where('kode', $id);
        $delete = $this->db->delete('barang');
        if ($delete) {
            $this->response(array('status' => $id), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }



    



}

/* End of file  */
/* Location: ./application/controllers/ */