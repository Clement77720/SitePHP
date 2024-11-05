<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Album_model extends CI_Model {

    public function getAlbums($order = 'name_asc', $search = '') {
        if ($search) {
            $this->db->like('name', $search);
        }
        switch ($order) {
            case 'name_asc':
                $this->db->order_by('name', 'ASC');
                break;
            case 'name_desc':
                $this->db->order_by('name', 'DESC');
                break;
            case 'year_asc':
                $this->db->order_by('year', 'ASC');
                break;
            case 'year_desc':
                $this->db->order_by('year', 'DESC');
                break;
            default:
                $this->db->order_by('name', 'ASC');
                break;
        }
        $this->db->select('album.id, album.name, album.year, artist.name as artist_name, cover.jpeg');
        $this->db->from('album');
        $this->db->join('artist', 'album.artistid = artist.id', 'left');
        $this->db->join('cover', 'album.coverid = cover.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

}