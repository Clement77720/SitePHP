<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Connexion extends CI_Controller {

    public function __construct(){
        parent::__construct();
        // Charger les modèles, les helpers, etc.
        $this->load->model('Model_user');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('auth'); // Charger le helper d'authentification
        $this->load->library('session');
    }

    public function index(){
        // Charger le header
        $this->load->view('layout/header');

        // Afficher la page de connexion
        $this->load->view('connexion_view');

        // Charger le footer
        $this->load->view('layout/footer');
    }

    public function login(){
        // Récupérer les données du formulaire de connexion
        $email = $this->input->post('email');
        $password = $this->input->post('password');
    
        // Récupérer les données de l'utilisateur à partir de l'email
        $user = $this->Model_user->getUserByEmail($email);

        if ($user) {
            // Afficher le hash du mot de passe pour le débogage
            log_message('debug', 'Hash du mot de passe de la base de données: ' . $user->password);
            // Vérifier le mot de passe
            if (password_verify($password, $user->password)) {
                // Authentification réussie
                $user_data = array(
                    'email' => $user->email,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($user_data);
                redirect('playlists'); // Rediriger vers les playlists après connexion réussie
            } else {
                // Mot de passe incorrect
                log_message('debug', 'Mot de passe incorrect pour l\'email: ' . $email);
                $this->session->set_flashdata('error', 'Mot de passe incorrect.');
                redirect('connexion');
            }
        } else {
            // Utilisateur non trouvé
            log_message('debug', 'Utilisateur non trouvé pour l\'email: ' . $email);
            $this->session->set_flashdata('error', 'Adresse email incorrecte.');
            redirect('connexion');
        }
    }

    public function logout(){
        // Déconnexion de l'utilisateur
        $this->session->sess_destroy();
        // Rediriger vers la page de connexion
        redirect('connexion');
    }
}
?>