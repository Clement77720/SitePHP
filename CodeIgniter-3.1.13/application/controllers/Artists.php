<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artists extends CI_Controller {

    public function __construct() {
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
            $artist = $this->model_music->searchArtistByName($search);
            if ($artist) {
                redirect('artists/view/' . $artist->id);
                return;
            }
        }

        $artists = $this->model_music->getArtists($order, $search);
        $this->load->view('layout/header');
        $this->load->view('artists_list', ['artists' => $artists, 'order' => $order, 'search' => $search]);
        $this->load->view('layout/footer');
    }

    public function view($id) {
        $artistDetails = $this->model_music->getArtistDetails($id);
        $playlists = $this->playlist->getAllPlaylists($this->session->userdata('email')); // Récupérer les playlists de l'utilisateur connecté

        $this->load->view('layout/header');
        $this->load->view('artist_details', ['details' => $artistDetails, 'playlists' => $playlists]);
        $this->load->view('layout/footer');
    }


    public function search() {
        $searchTerm = $this->input->get('search');
        $searchResults = $this->model_music->searchAlbums($searchTerm);
        $this->load->view('search_results', ['searchResults' => $searchResults]);
    }
    public function add_to_playlist() {
        $track_id = $this->input->post('track_id');
        $playlist_id = $this->input->post('playlist_id');
    
        // Appel à une méthode du modèle Playlist pour ajouter le morceau à la playlist
        $this->playlist->addSongToPlaylist($playlist_id, $track_id);
    
        // Redirection vers la page de la playlist
        redirect('playlists/view/' . $playlist_id);
    }
}