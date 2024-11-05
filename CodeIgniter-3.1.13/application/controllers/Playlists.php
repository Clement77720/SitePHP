<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlists extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('playlist');
        $this->load->model('Genre'); // Charger le modèle Genre
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('auth');
    
    }
    public function addSongToPlaylist($playlist_id, $track_id) {
        $data = array(
            'playlistid' => $playlist_id,
            'trackid' => $track_id
        );
        $this->db->insert('playlist_track', $data);
    }
    public function index() {
        check_login();
        $user_email = $this->session->userdata('email');
        $playlists = $this->playlist->getPlaylist($user_email);

        $this->load->view('layout/header');
        $this->load->view('playlists_list', ['playlists' => $playlists]);
        $this->load->view('layout/footer');
    }

    public function create() {
        check_login();
        
        // Charger les genres disponibles depuis la base de données
        $data['genres'] = $this->Genre->getAllGenres();

        if ($this->input->method() === 'post') {
            $playlist_name = $this->input->post('playlist_name');
            $is_random = $this->input->post('is_random');
            $genre = $this->input->post('genre');
            $num_tracks = $this->input->post('num_tracks');
            $user_email = $this->session->userdata('email');

            if (!empty($playlist_name)) {
                if ($this->Playlist->isPlaylistNameTaken($user_email, $playlist_name)) {
                    echo "Le nom de playlist est déjà pris pour cet utilisateur.";
                } else {
                    if ($is_random) {
                        $this->Playlist->createPlaylistRandom($user_email, $playlist_name, $genre, $num_tracks);
                    } else {
                        $this->Playlist->createPlaylist($user_email, $playlist_name);
                    }
                    redirect('playlists');
                }
            }
        } else {
            $this->load->view('layout/header');
            $this->load->view('create_playlist', $data); // Passer les données des genres à la vue
            $this->load->view('layout/footer');
        }
    
    

    
    }    public function delete($id) {
        check_login();
        $user_email = $this->session->userdata('email');
        $this->playlist->deletePlaylist($user_email, $id);
        redirect('playlists');
    }

    public function duplicate($id) {
        check_login();
        $user_email = $this->session->userdata('email');
        $this->playlist->duplicatePlaylist($user_email, $id);
        redirect('playlists');
    }

    public function view($playlist_id) {
        $playlist = $this->playlist->getPlaylistName($playlist_id); // Récupérer le nom de la playlist et la date de modification
        $songs = $this->playlist->getSongsInPlaylist($playlist_id); // Récupérer les chansons dans la playlist
    
        // Vérifiez si la playlist a été trouvée
        if ($playlist) {
            $playlist_name = $playlist->playlist_name;
            $playlist_modified_date = $playlist->playlist_modified_date;
        } else {
            $playlist_name = 'Unknown Playlist';
            $playlist_modified_date = 'N/A';
        }
    
        $this->load->view('layout/header');
        $this->load->view('view_playlist', [
            'playlist_name' => $playlist->playlist_name,
            'playlist_modified_date' => $playlist->playlist_modified_date,
            'songs' => $songs,
            'playlist_id' => $playlist_id  // Assurez-vous que $playlist_id est passé à la vue
        ]);
        $this->load->view('layout/footer');
    }


    public function add_song_to_playlist() {
        check_login();
        
        if ($this->input->method() === 'post') {
            $playlist_id = $this->input->post('playlist_id');
            $track_id = $this->input->post('track_id');
        
            if (!empty($playlist_id) && !empty($track_id)) {
                $this->playlist->addSongToPlaylist($playlist_id, $track_id);
                redirect($this->agent->referrer()); // Rediriger vers la page précédente
            }
        }
    }
    

    
    
        public function addAlbumToPlaylist() {
            check_login(); // Assurez-vous que l'utilisateur est connecté
        
            if ($this->input->method() === 'post') {
                $playlist_id = $this->input->post('playlist_id');
                $album_id = $this->input->post('album_id');
        
                if (!empty($playlist_id) && !empty($album_id)) {
                    $this->Playlist->addAlbumToPlaylist($playlist_id, $album_id);
                    redirect($this->agent->referrer()); // Redirection vers la page précédente après l'ajout
                }
            }
        }

    public function remove_song($playlist_id) {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $track_id = $this->input->post('track_id');
    
            // Exécuter la suppression dans la base de données
            $this->playlist->removeSongFromPlaylist($playlist_id, $track_id);
    
            // Redirection vers la vue de la playlist
            redirect('playlists/view/' . $playlist_id);
        }
    }
    
        
    }

?>
    
