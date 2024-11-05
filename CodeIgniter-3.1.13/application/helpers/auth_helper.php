<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('check_login')) {
    function check_login() {
        // Obtenir l'instance de CodeIgniter
        $CI =& get_instance();
        $CI->load->library('session');
        
        // Vérifier si l'utilisateur est connecté
        if (!$CI->session->userdata('logged_in')) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            redirect('connexion');
        }
    }
}
?>
