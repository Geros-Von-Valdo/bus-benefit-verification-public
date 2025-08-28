# Sistema de Validação de Cadastros — Migração de Bilhetagem

Solução desenvolvida para validar registros de usuários durante a troca do sistema de bilhetagem. Recebe dados e fotos via formulário, valida com regras de negócio e segurança, sincroniza registros aprovados com o sistema da nova operadora e envia notificações por e-mail (aprovado / erro).

Além da validação de dados, o sistema oferece **ferramentas de filtragem, comunicação por e-mail e facilidades administrativas** que otimizam o trabalho dos responsáveis pelo cadastro.

---

## Recursos principais

- 🧾 **Interface administrativa** para validação com ações rápidas (copiar dados, baixar imagem comprimida, enviar e-mail ok/erro).  
- 🔍 **Filtros avançados** para facilitar a visualização e organização das respostas.  
- 📧 **Envio de e-mails** com template para aprovação e template com texto editável para erro/rejeição.  
- ✔️ **Log de auditoria** para cada ação (quem validou, quando).  
- 📊 **Organização de status** (pendente, aprovado, irregular, bloqueado, etc.).  
- 📁 **Integração com informações provenientes de .xlsx e do banco de dados**.

---

## Demonstração (imagens)

1) **Visão geral da tabela**  
Tabela com opções de filtragem e separação por cor (cor do fundo do campo `id`) para otimização do processo administrativo.  
![Visão Geral](assets/Screenshot1.png)

2) **Visão detalhada do registro**  
Página do registro: copiar dados para área de transferência, baixar imagem comprimida, enviar e-mail ok/erro.  
![Visão Detalhada](assets/Screenshot2.png)

3) **Exemplos de e-mail (Aprovado / Erro) — lado a lado**  
<p>
  <img src="assets/Screenshot3.png" alt="E-mail aprovado" style="width:48%; margin-right:2%">
  <img src="assets/Screenshot4.png" alt="E-mail de erro" style="width:48%">
</p>

---

## Autoria

- [Gabriel Novotni](https://github.com/Geros-Von-Valdo) — Desenvolvedor principal  
- [João Kinkoski](https://github.com/kinkoskisDev) — Back-end / Integração

---
