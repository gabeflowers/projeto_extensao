
<body>
    <div class="container">
        <h1>Sistema de Fluxo de Caixa</h1>
        <p>Este projeto é parte de um projeto de extensão da faculdade e consiste em um sistema de fluxo de caixa desenvolvido em PHP. O sistema permite o gerenciamento de despesas e receitas, ajudando os usuários a manter o controle financeiro.</p>
        <h2>Funcionalidades</h2>
        <ul>
            <li>Cadastro de despesas e receitas</li>
            <li>Listagem de despesas e receitas</li>
            <li>Filtragem de despesas e receitas por nome</li>
            <li>Edição e exclusão de registros</li>
            <li>Modal para cadastro de novos itens</li>
        </ul>
        <h2>Tecnologias Utilizadas</h2>
        <ul>
            <li>PHP 7.4+</li>
            <li>MySQL 5.7+</li>
            <li>HTML5</li>
            <li>CSS3</li>
            <li>Bootstrap 4.5</li>
            <li>JavaScript (opcional)</li>
        </ul>
        <h2>Pré-requisitos</h2>
        <p>Antes de começar, você precisará ter o seguinte instalado em sua máquina:</p>
        <ul>
            <li><a href="https://www.apachefriends.org/index.html" target="_blank">XAMPP</a> ou similar (Apache, MySQL, PHP)</li>
            <li><a href="https://git-scm.com/" target="_blank">Git</a></li>
        </ul>
        <h2>Instalação</h2>
        <ol>
            <li>Clone o repositório:
                <pre><code>git clone https://github.com/gabeflowers/projeto_extensao.git</code></pre>
            </li>
            <li>Navegue até o diretório do projeto:
                <pre><code>cd projeto_extensao</code></pre>
            </li>
            <li>Configure o banco de dados:
                <ul>
                    <li>Crie um banco de dados no MySQL com o nome <code>projeto_a3</code>.</li>
                    <li>Importe o arquivo <code>projeto_a3.sql</code> para o banco de dados.</li>
                    <li>Atualize as configurações de conexão com o banco de dados no arquivo <code>config/db_config.php</code>:
                        <pre><code>
&lt;?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "projeto_a3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?&gt;
</code></pre>
                    </li>
                </ul>
            </li>
            <li>Inicie o servidor Apache e MySQL através do XAMPP.</li>
            <li>Acesse o sistema no navegador:
                <pre><code>http://localhost/projeto_extensao/templates/</code></pre>
            </li>
        </ol>
        <h2>Contribuição</h2>
        <p>Contribuições são bem-vindas! Para contribuir, siga os passos abaixo:</p>
        <ol>
            <li>Faça um fork do projeto.</li>
            <li>Crie um branch para sua feature:
                <pre><code>git checkout -b minha-feature</code></pre>
            </li>
            <li>Commit suas alterações:
                <pre><code>git commit -m "Minha nova feature"</code></pre>
            </li>
            <li>Envie para o branch original:
                <pre><code>git push origin minha-feature</code></pre>
            </li>
            <li>Abra um pull request.</li>
        </ol>
        <h2>Licença</h2>
        <p>Este projeto está licenciado sob a <a href="LICENSE">MIT License</a>.</p>
        <h2>Contato</h2>
        <p>Para mais informações, entre em contato com <a href="https://github.com/gabeflowers">gabeflowers</a>.</p>
    </div>
</body>
