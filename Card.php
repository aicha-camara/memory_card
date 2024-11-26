<?php
require_once 'config.php';

class Memory {
    private $id;
    public $pseudo;
    public $score;
    private $pdo;

    public function __construct($pdo, $id = '', $pseudo = '') {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->score = 0;
        $this->pdo = $pdo;
    }

    // Méthode pour obtenir l'ID de l'utilisateur
    public function getId() {
        return $this->id;
    }

    // Méthode pour définir l'ID de l'utilisateur
    public function setId($id) {
        $this->id = $id;
    }

    // Méthode pour obtenir les détails d'un utilisateur à partir de l'ID
    public function get_user_Id($id) {
        $query = "SELECT * FROM utilisateur WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Méthode pour enregistrer un nouvel utilisateur avec mot de passe haché
    public function register($pseudo, $password) {
        // Hacher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO utilisateur (pseudo, password) VALUES (:pseudo, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':password', $hashedPassword);
        $result = $stmt->execute();

        if ($result) {
            $this->id = $this->pdo->lastInsertId();
            return $this->get_user_Id($this->id);
        }

        return false;
    }

    // Méthode pour connecter un utilisateur en vérifiant le mot de passe
    public function connect($pseudo, $password) {
      $query = "SELECT id, pseudo, password, score FROM utilisateur WHERE pseudo = :pseudo";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindParam(':pseudo', $pseudo);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          // Comparaison simple du mot de passe en texte brut
          if ($password === $user['password']) {
              $this->id = $user['id'];
              $this->pseudo = $user['pseudo'];
              $this->score = $user['score'];

              if (session_status() === PHP_SESSION_NONE) {
                  session_start();
              }
              $_SESSION['user_id'] = $this->id;

              return true;
          }
      }

      return false;
  }

    // Méthode pour déconnecter un utilisateur
    public function disconnect() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();

        $this->id = null;
        $this->pseudo = null;
        $this->score = null;

        return true;
    }
    
    public function getAllInfos() {
      // Vérifiez si l'ID est défini
      if ($this->id === null) {
          return false;
      }
  
      // Préparez la requête SQL pour récupérer les informations de l'utilisateur
      $query = "SELECT * FROM utilisateur WHERE id = :id"; // Assurez-vous que 'utilisateur' est le nom correct de la table
      $stmt = $this->pdo->prepare($query);
      $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
      $stmt->execute();
  
      // Vérifiez si des données ont été trouvées
      if ($stmt->rowCount() > 0) {
          $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
          // Mettez à jour les propriétés de l'objet avec les données récupérées
          $this->pseudo = $user['pseudo'];
          $this->score = $user['score'];
  
          return $user;
      }
  
      return false;
  }
  
}
?>
