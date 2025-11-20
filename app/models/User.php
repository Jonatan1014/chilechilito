<?php
require_once __DIR__ . '/../config/Database.php';

class User {
    private $conn;
    private $table = 'users';
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    /**
     * Autenticar usuario
     */
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE (username = :username OR email = :email) 
                  AND is_active = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // No devolver la contraseña
            unset($user['password']);
            return $user;
        }
        
        return false;
    }
    
    /**
     * Obtener todos los usuarios
     */
    public function getAll() {
        $query = "SELECT id, username, email, role, is_active, created_at 
                  FROM " . $this->table . " 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener usuario por ID
     */
    public function getById($id) {
        $query = "SELECT id, username, email, role, is_active, created_at, updated_at 
                  FROM " . $this->table . " 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Crear nuevo usuario
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (username, email, password, role, is_active) 
                  VALUES (:username, :email, :password, :role, :is_active)";
        
        $stmt = $this->conn->prepare($query);
        
        // Encriptar contraseña
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':is_active', $data['is_active']);
        
        return $stmt->execute();
    }
    
    /**
     * Actualizar usuario
     */
    public function update($id, $data) {
        // Si hay nueva contraseña, actualizarla
        if (!empty($data['password'])) {
            $query = "UPDATE " . $this->table . " 
                      SET username = :username, 
                          email = :email, 
                          password = :password, 
                          role = :role, 
                          is_active = :is_active 
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashed_password);
        } else {
            $query = "UPDATE " . $this->table . " 
                      SET username = :username, 
                          email = :email, 
                          role = :role, 
                          is_active = :is_active 
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
        }
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':is_active', $data['is_active']);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar usuario
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    /**
     * Verificar si username ya existe
     */
    public function usernameExists($username, $excludeId = null) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE username = :username";
        
        if ($excludeId) {
            $query .= " AND id != :id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        
        if ($excludeId) {
            $stmt->bindParam(':id', $excludeId);
        }
        
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Verificar si email ya existe
     */
    public function emailExists($email, $excludeId = null) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE email = :email";
        
        if ($excludeId) {
            $query .= " AND id != :id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        
        if ($excludeId) {
            $stmt->bindParam(':id', $excludeId);
        }
        
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
}
