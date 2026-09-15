# Guia Operacional de Publicação, Deploy Contínuo e Backups na Hostinger

**Projeto:** Escola Comunitária Nova Esperança  
**Localização:** Kifangondo, Luanda, Angola  
**Repositório:** `nova-esperanca-angola/projeto-social-escola`  
**Ambiente de Produção:** `https://orange-dogfish-319640.hostingersite.com/`

---

## 1. Visão Geral da Infraestrutura

O portal do Projeto Social Escola é construído em PHP 8.2+ nativo, sem frameworks pesados, garantindo carregamento instantâneo (< 2 segundos) mesmo em redes móveis 3G de Angola.

A infraestrutura na Hostinger é composta por:
- **Servidor Web:** LiteSpeed / Apache com suporte a `mod_rewrite`, `mod_headers`, `mod_deflate` e `mod_expires`.
- **Roteamento Seguro:**
  - O arquivo `.htaccess` na raiz direciona transparentemente todas as requisições de usuários para a pasta `/public/` e bloqueia sumariamente qualquer tentativa de acesso direto a diretórios de dados e código (`src/`, `templates/`, `data/`, `storage/`, `schemas/`, `scripts/`).
  - O arquivo `index.php` na raiz atua como fallback adicional de segurança e despacho.
  - O arquivo `public/.htaccess` gerencia o roteamento limpo de URLs amigáveis, cabeçalhos de segurança e compressão Gzip.
- **Deploy Contínuo:** Integrado exclusivamente via **GitHub** (branch `main`). Qualquer atualização enviada ao GitHub é testada pela esteira de CI (`.github/workflows/ci-deploy.yml`) e sincronizada automaticamente na Hostinger.

---

## 2. Configuração do Deploy Automático via Git na Hostinger (hPanel)

Como o processo de implantação foi estabelecido para ser realizado exclusivamente via **GitHub** (sem SSH manual), o hPanel da Hostinger fornece o recurso nativo **Git Deployment**:

### Passo a Passo no hPanel:
1. Acesse o **hPanel** da Hostinger (`https://hpanel.hostinger.com`) e selecione o site `orange-dogfish-319640.hostingersite.com`.
2. No menu lateral esquerdo, navegue até **Avançado > Git**.
3. Na seção **Criar um Repositório Git**:
   - **Repositório:** `https://github.com/nova-esperanca-angola/projeto-social-escola.git`
   - **Branch:** `main`
   - **Instalar no diretório:** Deixe em branco para instalar na raiz do site (`public_html`).
4. Clique em **Criar**. A Hostinger fará o clone inicial do repositório.
5. **Ativação do Auto-Deployment (Webhook do GitHub):**
   - Após a criação, o hPanel exibirá uma **URL de Webhook de Implantação Automática** (ex: `https://hpanel.hostinger.com/api/git/deploy/...`).
   - Copie esta URL.
   - Acesse o repositório no GitHub: `https://github.com/nova-esperanca-angola/projeto-social-escola/settings/hooks`.
   - Clique em **Add webhook**.
   - Cole a URL no campo **Payload URL**, selecione **Content type: application/json**, marque o evento **Just the push event** e clique em **Add webhook**.
   - A partir deste momento, qualquer `git push` aprovado na branch `main` atualizará automaticamente o site em produção em poucos segundos.

---

## 3. Certificado SSL e Cabeçalhos de Segurança HTTP

### 3.1 Ativação do SSL no hPanel
1. No painel do site na Hostinger, acesse a seção **Segurança > SSL**.
2. O certificado gratuito Let's Encrypt é instalado automaticamente para subdomínios da Hostinger (`orange-dogfish-319640.hostingersite.com`).
3. Certifique-se de que a opção **Forçar HTTPS** está ativada.

### 3.2 Cabeçalhos de Proteção Ativos
A aplicação implementa dupla camada de proteção para cabeçalhos HTTP (tanto via `public/.htaccess` quanto nativamente em `src/Core/Response.php`):
- `X-Content-Type-Options: nosniff`: Previne sniffing de tipos MIME.
- `X-Frame-Options: SAMEORIGIN`: Impede ataques de clickjacking em iframes maliciosos.
- `X-XSS-Protection: 1; mode=block`: Ativa proteção ativa contra scripts cross-site.
- `Referrer-Policy: strict-origin-when-cross-origin`: Resguarda URLs de origem em requisições externas.
- `Permissions-Policy: camera=(), microphone=(), geolocation=()`: Desativa recursos sensíveis de hardware do dispositivo.

---

## 4. Rotina de Backup Automatizado e Snapshots

Para garantir a salvaguarda de dados de apadrinhamento e registros operacionais da escola, são adotadas duas camadas complementares de backup:

### 4.1 Backups Nativos do hPanel (Semanais / Diários)
1. No hPanel, acesse **Arquivos > Backups**.
2. A Hostinger realiza backups automáticos semanais de todos os arquivos e bancos de dados da conta.
3. Em caso de necessidade de restauração emergencial, basta selecionar a data desejada e clicar em **Restaurar arquivos**.

### 4.2 Script de Snapshots Automatizados (`scripts/backup-snapshots.php`)
O repositório inclui um utilitário CLI próprio para compactação e rotação de snapshots dos dados (`storage/` e `data/`):
- Gera um arquivo compactado `.zip` com hash SHA-256 para auditoria de integridade.
- Realiza rotação automática, excluindo arquivos de backup mais antigos que a retenção configurada (padrão: 30 dias).

#### Como Executar Localmente ou via SSH/Terminal:
```bash
php scripts/backup-snapshots.php --destination=storage/backups --retention-days=30
```

Saída JSON gerada:
```json
{
  "status": "success",
  "timestamp": "2026-09-15T19:50:00Z",
  "archive": "storage/backups/snapshot-20260915-195000.zip",
  "size_bytes": 1048576,
  "sha256": "3a8b...c91d",
  "files_count": 14,
  "pruned_archives_count": 0
}
```

#### Agendamento de Cron Job no hPanel:
1. No hPanel, navegue até **Avançado > Tarefas Cron**.
2. Selecione o tipo **Personalizado**.
3. No campo de comando, informe:
   ```bash
   /usr/bin/php /home/uXXXXXX/public_html/scripts/backup-snapshots.php --retention-days=30
   ```
4. Configure a frequência para **Uma vez por semana** (ex: todo domingo às 02:00 da manhã).
5. Clique em **Salvar**.

---

## 5. Auditoria de Performance e Resiliência em Angola

O site em `https://orange-dogfish-319640.hostingersite.com/` foi auditado e configurado para:
1. **Compressão Deflate/Gzip:** Redução drástica de transferência de dados em CSS, JS e HTML.
2. **Cache HTTP Agressivo:** Arquivos estáticos (fontes, estilos, imagens) armazenados em cache por até 30 dias no navegador do usuário.
3. **TTFB Otimizado:** Resposta inicial do servidor inferior a 800ms, assegurando que o tempo total de carregamento da página permaneça abaixo de 2 segundos.
