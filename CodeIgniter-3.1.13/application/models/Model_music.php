<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_music extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getAlbums($order = 'year_asc', $search = ''){
        switch ($order) {
            case 'year_asc':
                $orderBy = 'year ASC';
                break;
            case 'year_desc':
                $orderBy = 'year DESC';
                break;
            case 'name_asc':
                $orderBy = 'album.name ASC';
                break;
            case 'name_desc':
                $orderBy = 'album.name DESC';
                break;
            case 'artist_asc':
                $orderBy = 'artist.name ASC';
                break;
            case 'artist_desc':
                $orderBy = 'artist.name DESC';
                break;
            case 'genre_asc':
                $orderBy = 'genre.name ASC';
                break;
            case 'genre_desc':
                $orderBy = 'genre.name DESC';
                break;
            default:
                $orderBy = 'year ASC';
                break;
        }

        $searchCondition = $search ? "AND album.name LIKE '%{$this->db->escape_like_str($search)}%'" : '';

        $query = $this->db->query(
            "SELECT album.name, album.id, year, artist.name as artistName, genre.name as genreName, jpeg 
            FROM album 
            JOIN artist ON album.artistid = artist.id
            JOIN genre ON genre.id = album.genreid
            JOIN cover ON cover.id = album.coverid
            WHERE 1=1 $searchCondition
            ORDER BY $orderBy"
        );
        return $query->result();
    }

    public function getArtists($order = 'name_asc', $search = ''){
        switch ($order) {
            case 'name_asc':
                $orderBy = 'name ASC';
                break;
            case 'name_desc':
                $orderBy = 'name DESC';
                break;
            default:
                $orderBy = 'name ASC';
                break;
        }

        $searchCondition = $search ? "AND name LIKE '%{$this->db->escape_like_str($search)}%'" : '';

        $query = $this->db->query("SELECT id, name FROM artist WHERE 1=1 $searchCondition ORDER BY $orderBy");
        return $query->result();
    }

    public function searchArtistByName($name) {
        $query = $this->db->query("SELECT id FROM artist WHERE name = ?", array($name));
        return $query->row();
    }

    public function getArtistDetails($artist_id) {
        $this->db->select('artist.name as artist_name, album.name as album_name, song.name as song_name, song.id as song_id');
        $this->db->from('artist');
        $this->db->join('album', 'artist.id = album.artistid');
        $this->db->join('track', 'album.id = track.albumid');
        $this->db->join('song', 'track.songid = song.id');
        $this->db->where('artist.id', $artist_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function getAlbumDetails($id) {
        $sql = "
            SELECT 
                album.id as album_id, album.name as album_name, 
                artist.name as artist_name, genre.name as genre_name, 
                track.number as track_number, song.name as song_name, 
                track.duration as track_duration, track.id as track_id
            FROM album
            JOIN artist ON album.artistid = artist.id
            JOIN genre ON album.genreid = genre.id
            JOIN track ON track.albumid = album.id
            JOIN song ON track.songid = song.id
            WHERE album.id = ?
        ";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    
    }
    

    public function getPlaylists($order = 'name_asc', $search = ''){
        switch ($order) {
            case 'name_asc':
                $orderBy = 'name ASC';
                break;
            case 'name_desc':
                $orderBy = 'name DESC';
                break;
            default:
                $orderBy = 'name ASC';
                break;
        }

        $searchCondition = $search ? "AND name LIKE '%{$this->db->escape_like_str($search)}%'" : '';

        $query = $this->db->query("SELECT name FROM playlist WHERE 1=1 $searchCondition ORDER BY $orderBy");
        return $query->result();
    }

    public function searchAlbums($searchTerm) {
        $query = $this->db->query(
            "SELECT album.name, album.id, year, artist.name as artistName, genre.name as genreName, jpeg 
            FROM album 
            JOIN artist ON album.artistid = artist.id
            JOIN genre ON genre.id = album.genreid
            JOIN cover ON cover.id = album.coverid
            WHERE album.name LIKE '%$searchTerm%' OR artist.name LIKE '%$searchTerm%'
            ORDER BY year ASC"
        );
        return $query->result(); // Utilisez result() pour obtenir tous les résultats
    }
    
    public function searchAlbumsByTitle($title) {
        $query = $this->db->query(
            "SELECT album.name, album.id, year, artist.name as artistName, genre.name as genreName, jpeg 
            FROM album 
            JOIN artist ON album.artistid = artist.id
            JOIN genre ON genre.id = album.genreid
            JOIN cover ON cover.id = album.coverid
            WHERE album.name LIKE '%$title%'
            ORDER BY year ASC"
        );
        return $query->result();
    }
    public function getAlbumTracks($album_id) {
        $sql = "
            SELECT track.id as track_id
            FROM track
            WHERE track.albumid = ?
        ";
        $query = $this->db->query($sql, array($album_id));
        return $query->result();
    }
    
}