<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h1><i class="fas fa-user-plus"></i> Crear Usuario</h1>
    <div class="actions">
        <a href="/chile_chilito/public/index.php?controller=auth&action=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Nuevo Usuario</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="/chile_chilito/public/index.php?controller=auth&action=store">
            <div class="form-grid">
                <div class="form-group">
                    <label for="username">Nombre de Usuario *</label>
                    <input type="text" id="username" name="username" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required class="form-control">
                </div>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="password">Contraseña *</label>
                    <input type="password" id="password" name="password" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="password_confirm">Confirmar Contraseña *</label>
                    <input type="password" id="password_confirm" name="password_confirm" required class="form-control">
                </div>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="role">Rol *</label>
                    <select id="role" name="role" required class="form-control">
                        <option value="vendedor">Vendedor</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" checked> Usuario Activo
                    </label>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
