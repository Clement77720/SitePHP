<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscription extends CI_Controller {

    public function __construct(){
        parent::__construct();
        // Charger les modèles, les helpers, etc.
        $this->load->model('Model_user');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
    }

    public function index(){
        // Charger le header
        $this->load->view('layout/header');

        // Afficher la page d'inscription
        $this->load->view('inscription_view');

        // Charger le footer
        $this->load->view('layout/footer');
    }

    public function register(){
        // Gérer l'inscription de l'utilisateur
        // Récupérer les données du formulaire d'inscription
        $data = array(
            'email' => $this->input->post('email'),
            'nom' => $this->input->post('nom'),
            'prenom' => $this->input->post('prenom'),
            'password' => $this->input->post('password') // Passer le mot de passe brut
        );

        // Inscrire l'utilisateur
        $user_id = $this->Model_user->registerUser($data);

        if($user_id){
            // Inscription réussie
            // Rediriger vers une page appropriée
            redirect('connexion');
        } else {
            // Erreur d'inscription
            // Afficher un message d'erreur et rediriger vers la page d'inscription
            $this->session->set_flashdata('error', 'Inscription échouée. Email déjà utilisé.');
            redirect('inscription');
        }
    }
}
?>