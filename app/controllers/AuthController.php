<?php

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    /**
     * Mostrar formulario de login
     */
    public function showLogin() {
        // Si ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: /chile_chilito/public/index.php?controller=dashboard&action=index');
            exit();
        }
        
        include __DIR__ . '/../views/auth/login.php';
    }
    
    /**
     * Procesar login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chile_chilito/public/index.php?controller=auth&action=showLogin');
            exit();
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Usuario y contraseña son requeridos';
            header('Location: /chile_chilito/public/index.php?controller=auth&action=showLogin');
            exit();
        }
        
        $user = $this->userModel->login($username, $password);
        
        if ($user) {
            // Iniciar sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['success'] = '¡Bienvenido ' . $user['username'] . '!';
            
            header('Location: /chile_chilito/public/index.php?controller=dashboard&action=index');
            exit();
        } else {
            $_SESSION['error'] = 'Usuario o contraseña incorrectos';
            header('Location: /chile_chilito/public/index.php?controller=auth&action=showLogin');
            exit();
        }
    }
    
    /**
     * Cerrar sesión
     */
    public function logout() {
        session_destroy();
        header('Location: /chile_chilito/public/index.php?controller=auth&action=showLogin');
        exit();
    }
    
    /**
     * Verificar si el usuario está autenticado
     */
    public static function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /chile_chilito/public/index.php?controller=auth&action=showLogin');
            exit();
        }
    }
    
    /**
     * Verificar si el usuario tiene un rol específico
     */
    public static function checkRole($required_role) {
        self::checkAuth();
        
        $roles_hierarchy = ['vendedor' => 1, 'supervisor' => 2, 'admin' => 3];
        $user_role_level = $roles_hierarchy[$_SESSION['role']] ?? 0;
        $required_role_level = $roles_hierarchy[$required_role] ?? 999;
        
        if ($user_role_level < $required_role_level) {
            $_SESSION['error'] = 'No tienes permisos para acceder a esta sección';
            header('Location: /chile_chilito/public/index.php?controller=dashboard&action=index');
            exit();
        }
    }
    
    /**
     * Gestión de usuarios (solo admin)
     */
    public function index() {
        self::checkRole('admin');
        
        $users = $this->userModel->getAll();
        include __DIR__ . '/../views/users/index.php';
    }
    
    /**
     * Mostrar formulario de creación de usuario
     */
    public function create() {
        self::checkRole('admin');
        include __DIR__ . '/../views/users/create.php';
    }
    
    /**
     * Guardar nuevo usuario
     */
    public function store() {
        self::checkRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chile_chilito/public/index.php?controller=auth&action=index');
            exit();
        }
        
        // Validaciones
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $role = $_POST['role'] ?? 'vendedor';
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'El nombre de usuario es requerido';
        } elseif ($this->userModel->usernameExists($username)) {
            $errors[] = 'El nombre de usuario ya está en uso';
        }
        
        if (empty($email)) {
            $errors[] = 'El email es requerido';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El email no es válido';
        } elseif ($this->userModel->emailExists($email)) {
            $errors[] = 'El email ya está registrado';
        }
        
        if (empty($password)) {
            $errors[] = 'La contraseña es requerida';
        } elseif (strlen($password) < 3) {
            $errors[] = 'La contraseña debe tener al menos 3 caracteres';
        } elseif ($password !== $password_confirm) {
            $errors[] = 'Las contraseñas no coinciden';
        }
        
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            header('Location: /chile_chilito/public/index.php?controller=auth&action=create');
            exit();
        }
        
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'is_active' => $is_active
        ];
        
        if ($this->userModel->create($data)) {
            $_SESSION['success'] = 'Usuario creado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al crear el usuario';
        }
        
        header('Location: /chile_chilito/public/index.php?controller=auth&action=index');
        exit();
    }
    
    /**
     * Mostrar formulario de edición
     */
    public function edit() {
        self::checkRole('admin');
        
        $id = $_GET['id'] ?? 0;
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            header('Location: /chile_chilito/public/index.php?controller=auth&action=index');
            exit();
        }
        
        include __DIR__ . '/../views/users/edit.php';
    }
    
    /**
     * Actualizar usuario
     */
    public function update() {
        self::checkRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /chile_chilito/public/index.php?controller=auth&action=index');
            exit();
        }
        
        $id = $_POST['id'] ?? 0;
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $role = $_POST['role'] ?? 'vendedor';
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'El nombre de usuario es requerido';
        } elseif ($this->userModel->usernameExists($username, $id)) {
            $errors[] = 'El nombre de usuario ya está en uso';
        }
        
        if (empty($email)) {
            $errors[] = 'El email es requerido';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El email no es válido';
        } elseif ($this->userModel->emailExists($email, $id)) {
            $errors[] = 'El email ya está registrado';
        }
        
        if (!empty($password)) {
            if (strlen($password) < 3) {
                $errors[] = 'La contraseña debe tener al menos 3 caracteres';
            } elseif ($password !== $password_confirm) {
                $errors[] = 'Las contraseñas no coinciden';
            }
        }
        
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            header('Location: /chile_chilito/public/index.php?controller=auth&action=edit&id=' . $id);
            exit();
        }
        
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'is_active' => $is_active
        ];
        
        if ($this->userModel->update($id, $data)) {
            $_SESSION['success'] = 'Usuario actualizado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar el usuario';
        }
        
        header('Location: /chile_chilito/public/index.php?controller=auth&action=index');
        exit();
    }
    
    /**
     * Eliminar usuario
     */
    public function delete() {
        self::checkRole('admin');
        
        $id = $_GET['id'] ?? 0;
        
        // No permitir eliminar al usuario autenticado
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'No puedes eliminarte a ti mismo';
            header('Location: /chile_chilito/public/index.php?controller=auth&action=index');
            exit();
        }
        
        if ($this->userModel->delete($id)) {
            $_SESSION['success'] = 'Usuario eliminado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el usuario';
        }
        
        header('Location: /chile_chilito/public/index.php?controller=auth&action=index');
        exit();
    }
}
