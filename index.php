<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style.css">
    <title>Login</title>

</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Login</h1>
            <form action="/login" method="POST" class="label-float">
                <div class="label-float">
                    <input type="text" id="username" name="username" required>
                    <label for="username">Usuário</label>
                </div>
                <div class="label-float">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Senha</label>
                </div>
                <button type="submit">Entrar</button>
            </form>
            <hr>
            <p>Não tem uma conta? <a href="#">Cadastre-se</a></p>
        </div>
    </div>
</body>
</html>
