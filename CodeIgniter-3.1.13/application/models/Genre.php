
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Genre extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function getAllGenres() {
        $query = $this->db->get('genre');
        return $query->result();
    }
}
?>