<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Playlist extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getPlaylist($user_email) {
        $query = $this->db->query(
            "SELECT id, name AS playlist_name, modified_date AS playlist_modified_date
            FROM playlist
            WHERE email = ?
            ORDER BY modified_date DESC",
            array($user_email)
        );
        return $query->result();
    }

    public function add_song_to_playlist() {
        check_login(); // Assurez-vous que l'utilisateur est connecté

        if ($this->input->method() === 'post') {
            $playlist_id = $this->input->post('playlist_id');
            $track_id = $this->input->post('track_id');

            if (!empty($playlist_id) && !empty($track_id)) {
                $this->playlist_model->addSongToPlaylist($playlist_id, $track_id);
                redirect($this->agent->referrer()); // Redirection vers la page précédente après l'ajout
            }
        }
    }
    public function deletePlaylist($user_email, $playlist_id) {
        $this->db->where('playlistid', $playlist_id);
        $this->db->delete('playlist_track');
        $this->db->where('email', $user_email);
        $this->db->where('id', $playlist_id);
        $this->db->delete('playlist');
    }

    public function createPlaylist($user_email, $playlist_name) {
        $this->db->query(
            "INSERT INTO playlist (email, name) VALUES (?, ?)",
            array($user_email, $playlist_name)
        );
        return $this->db->insert_id();
    }

    public function isPlaylistNameTaken($user_email, $playlist_name) {
        $query = $this->db->query(
            "SELECT COUNT(*) AS count
            FROM playlist
            WHERE email = ? AND name = ?",
            array($user_email, $playlist_name)
        );
        $result = $query->row();
        return ($result->count > 0);
    }

    public function getRandomSongsByGenres($genres, $limit) {
        $this->db->select('id as track_id');
        $this->db->from('songs');
        $this->db->where_in('genre', $genres);
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }
    public function addSongToPlaylist($playlist_id, $track_id) {
        $data = [
            'playlistid' => $playlist_id,
            'trackid' => $track_id
        ];
        $this->db->insert('playlist_track', $data);
    }
    

    public function duplicatePlaylist($user_email, $playlist_id) {
        $query = $this->db->query(
            "INSERT INTO playlist (email, name, modified_date)
            SELECT email, CONCAT(name, ' (copy)'), NOW()
            FROM playlist
            WHERE id = ? AND email = ?",
            array($playlist_id, $user_email)
        );
        $new_playlist_id = $this->db->insert_id();

        $query = $this->db->query(
            "INSERT INTO playlist_track (playlistid, trackid)
            SELECT ?, trackid
            FROM playlist_track
            WHERE playlistid = ?",
            array($new_playlist_id, $playlist_id)
        );
    }

    public function getPlaylistById($playlist_id, $user_email) {
        $query = $this->db->query(
            "SELECT id, name AS playlist_name, modified_date AS playlist_modified_date
            FROM playlist
            WHERE id = ? AND email = ?",
            array($playlist_id, $user_email)
        );
        return $query->row();
    }

    public function getSongsInPlaylist($playlist_id) {
        $query = $this->db->query(
            "SELECT song.id, song.name
            FROM song
            JOIN playlist_track ON song.id = playlist_track.trackid
            WHERE playlist_track.playlistid = ?",
            array($playlist_id)
        );
        return $query->result();
    }
    
    
    


    public function addAlbumToPlaylist($playlist_id, $album_id) {
        // Récupérer toutes les chansons de l'album
        $this->db->select('track.id');
        $this->db->from('track');
        $this->db->where('track.albumid', $album_id);
        $query = $query = $this->db->get();
        $tracks = $query->result();
    
        // Ajouter chaque chanson de l'album à la playlist
        foreach ($tracks as $track) {
            $data = array(
                'playlistid' => $playlist_id,
                'trackid' => $track->id
            );
            $this->db->insert('playlist_track', $data);
        }
    }

    public function getAllPlaylists($user_email) {
        $this->db->where('email', $user_email);
        $query = $this->db->get('playlist');
        return $query->result();
    }
    public function getPlaylistName($playlist_id) {
        $query = $this->db->query(
            "SELECT name AS playlist_name, modified_date AS playlist_modified_date
            FROM playlist
            WHERE id = ?",
            array($playlist_id)
        );
        return $query->row();
    }
    public function getAlbumTracks($album_id) {
        $sql = "
            SELECT track.id
            FROM track
            WHERE track.albumid = ?
        ";
        $query = $this->db->query($sql, array($album_id));
        return $query->result();
    }
    
    public function removeSongFromPlaylist($playlist_id, $track_id) {
        $this->db->where('playlistid', $playlist_id);
        $this->db->where('trackid', $track_id);
        $this->db->delete('playlist_track');
    }
    
    

    private function generateRandomTracks($genre, $num_tracks) {
        $this->db->select('t.id, s.name as song_name');
        $this->db->from('track t');
        $this->db->join('song s', 't.songid = s.id');
        $this->db->join('album a', 't.albumid = a.id'); // Ajout du lien avec l'album
        $this->db->join('genre g', 'a.genreid = g.id'); // Ajout du lien avec le genre via l'album
        $this->db->where('g.name', $genre);
        $this->db->order_by('RAND()');
        $this->db->limit($num_tracks);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    private function insertPlaylist($data) {
        $this->db->insert('playlist', $data);
        return $this->db->insert_id();
    }

    private function insertPlaylistTracks($playlist_id, $tracks) {
        foreach ($tracks as $track) {
            $data = array(
                'playlistid' => $playlist_id,
                'trackid' => $track->id
            );
            $this->db->insert('playlist_track', $data);
        }
    }
    
    public function createPlaylistRandom($user_email, $playlist_name, $genre, $num_tracks = 10) {
        $data = array(
            'email' => $user_email,
            'name' => $playlist_name,
            'modified_date' => date('Y-m-d H:i:s')
        );

        $tracks = $this->generateRandomTracks($genre, $num_tracks);
        if (!empty($tracks)) {
            $playlist_id = $this->insertPlaylist($data);
            $this->insertPlaylistTracks($playlist_id, $tracks);
            return $playlist_id;
        } else {
            return false; // Handle no tracks found for genre
        }
    }
  

public function getAllGenres() {
    $query = $this->db->get('genre'); 
    return $query->result();
}

}
?>