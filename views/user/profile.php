<?php
// Tela de edição do perfil do usuário
// Supondo que $user seja passado pelo controller
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="/public/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height:70vh;">
        <div class="card shadow-lg p-4" style="max-width:500px;width:100%;border-radius:18px;">
            <div class="text-center mb-4">
                <div class="logo-circle mx-auto mb-2" style="width:56px;height:56px;"><i class="fas fa-user fa-2x"></i></div>
                <h2 class="fw-bold">Editar Perfil</h2>
                <p class="text-muted mb-0">Atualize suas informações pessoais</p>
            </div>
            <form action="index.php?page=update_profile" method="POST" class="row g-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                <div class="col-12 mb-2">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="col-12 mb-2">
                    <label for="logradouro" class="form-label">Logradouro</label>
                    <input type="text" class="form-control" id="logradouro" name="logradouro" value="<?= htmlspecialchars($user['logradouro']) ?>">
                </div>
                <div class="row g-2">
                    <div class="col-md-4">
                        <label for="numero_casa" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero_casa" name="numero_casa" value="<?= htmlspecialchars($user['numero_casa']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" value="<?= htmlspecialchars($user['cep']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="state" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="state" name="state" value="<?= htmlspecialchars($user['state']) ?>">
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <label for="city" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($user['city']) ?>">
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
