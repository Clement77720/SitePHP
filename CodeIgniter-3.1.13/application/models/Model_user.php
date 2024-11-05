<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function registerUser($data){
        // Vérifier si l'email est déjà utilisé
        $email_exists = $this->db->where('email', $data['email'])->get('user')->row();
        if($email_exists){
            return false; // L'email existe déjà
        }

        // Crypter le mot de passe avant de l'insérer dans la base de données
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Ajouter un log pour vérifier le hash généré
        log_message('debug', 'Hash généré pour le mot de passe: ' . $data['password']);

        // Insérer les données de l'utilisateur dans la base de données
        $this->db->insert('user', $data);
        return $this->db->insert_id(); // Retourner l'ID de l'utilisateur inséré
    }

    public function loginUser($email, $password){
        // Récupérer les données de l'utilisateur à partir de l'email
        $user = $this->db->where('email', $email)->get('user')->row();
    
        if($user && password_verify($password, $user->password)){
            return $user; // Authentification réussie, retourner les données de l'utilisateur
        } else {
            return false; // Authentification échouée
        }
    }
    
    public function getUserByEmail($email){
        // Récupérer les données de l'utilisateur à partir de l'email
        return $this->db->where('email', $email)->get('user')->row();
    }

    public function updateUser($email, $data){
        // Mettre à jour les données de l'utilisateur
        $this->db->where('email', $email)->update('user', $data);
    }

    public function deleteUser($email){
        // Supprimer l'utilisateur de la base de données
        $this->db->where('email', $email)->delete('user');
    }

    public function resetPassword($email, $new_password){
        // Crypter le nouveau mot de passe
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe dans la base de données
        $this->db->where('email', $email)->update('user', array('password' => $hashed_password));
    }
}
?>
