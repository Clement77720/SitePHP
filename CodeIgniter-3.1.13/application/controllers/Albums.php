<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Albums extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('model_music');
        $this->load->model('playlist'); // Charger le modèle de playlist
        $this->load->helper('url');
        $this->load->helper('html');
    }

    public function index(){
        $order = $this->input->get('order', TRUE);
        $order = isset($order) ? $order : 'name_asc';
        $search = $this->input->get('search', TRUE);

        if ($search) {
            $albums = $this->model_music->searchAlbumsByTitle($search);
            if ($albums) {
                $album_id = $albums[0]->id;
                redirect('albums/view/' . $album_id);
                return;
            }
        }

        $albums = $this->model_music->getAlbums($order, $search);
        $this->load->view('layout/header');
        $this->load->view('albums_list', ['albums' => $albums, 'order' => $order, 'search' => $search]);
        $this->load->view('layout/footer');
    }

    public function view($id) {
        $albumDetails = $this->model_music->getAlbumDetails($id);
        $playlists = $this->playlist->getAllPlaylists($this->session->userdata('email')); // Récupérer les playlists de l'utilisateur connecté
        
        $this->load->view('layout/header');
        $this->load->view('album_details', ['details' => $albumDetails, 'playlists' => $playlists]);
        $this->load->view('layout/footer');
    }
    public function add_to_playlist() {
        $track_id = $this->input->post('track_id');
        $playlist_id = $this->input->post('playlist_id');
    
        // Appel à une méthode du modèle Playlist pour ajouter le morceau à la playlist
        $this->playlist->addSongToPlaylist($playlist_id, $track_id);
    
        // Redirection vers la page de la playlist
        redirect('playlists/view/' . $playlist_id);
    }
     
    public function add_album_to_playlist() {
        $album_id = $this->input->post('album_id');
        $playlist_id = $this->input->post('playlist_id');
    
        // Récupérer tous les morceaux de l'album
        $tracks = $this->model_music->getAlbumTracks($album_id);
    
        // Ajouter chaque morceau à la playlist
        foreach ($tracks as $track) {
            $this->playlist->addSongToPlaylist($playlist_id, $track->track_id);
        }
    
        // Rediriger vers la page de la playlist
        redirect('playlists/view/' . $playlist_id);
    }
    
    
    }


?>