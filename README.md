BreakRoll

Plataforma web de streaming de animes e mangás desenvolvida como projeto acadêmico para o SENAI.

Tecnologias Utilizadas

PHP (Desenvolvido sem frameworks, utilizando arquitetura modular)

MySQL com PDO (Com uso de Prepared Statements e tratamento de erros via logs)

Resend API (Integração para envio de notificações automatizadas por e-mail)

HTML5 e CSS3

Funcionalidades

Autenticação Completa: Sistema de cadastro com login automático imediato, login seguro com validação de hash de senha (password_verify) e controle de sessões restritas.

Notificações Automatizadas: Disparo de e-mail via API do Resend para o administrador a cada novo usuário cadastrado.

Catálogo Protegido: Área restrita para visualização do acervo de animes e mangás acessível apenas para usuários autenticados.

Landing Page Institucional: Página inicial de apresentação com chamadas para ação.

Como Executar o Projeto Localmente

Clone o repositório no diretório do seu servidor local (exemplo: htdocs do XAMPP):

git clone https://github.com/Rafael010301/BreakRoll.git


Importe o banco de dados MySQL com o nome break_db.

Crie um arquivo chamado config.php na raiz do projeto contendo as credenciais de configuração:

<?php
define('RESEND_API_KEY', 'sua_chave_aqui');
define('DONO_EMAIL', 'seu_email@gmail.com');
?>


Inicie o Apache e o MySQL no XAMPP e acesse o projeto através do navegador (http://localhost/BreakRoll/).

Equipe de Desenvolvimento

Projeto desenvolvido pelos integrantes:

Rafael Pereira

Matheus Oliveira

Miguel Muniz

Pedro Viggato
