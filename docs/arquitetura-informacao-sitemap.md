# Arquitetura de Informação, Sitemap & Especificação UX (WDLC Fase 2)

> **Projeto:** Portal Escola Nova Esperança (Kifangondo, Luanda)  
> **Issue de Referência:** [#2 - Modelagem do Painel de Transparência e Prestação de Contas](https://github.com/nova-esperanca-angola/projeto-social-escola/issues/2)  
> **Metodologia:** Spec-Driven Development (SDD)  
> **Status:** Especificado e Validado

---

## 1. Visão Geral da Arquitetura de Informação

A arquitetura do portal foi concebida para converter visitantes e doadores (nacionais e da diáspora) em padrinhos regulares da Escola Nova Esperança, demonstrando a seriedade do projeto social em Kifangondo com total transparência financeira.

```
                         [ Portal Escola Nova Esperança ]
                                        │
      ┌───────────┬──────────────┬──────┴───────┬───────────────┬──────────────┐
      │           │              │              │               │              │
    [`/`]     [`/sobre`]   [`/apadrinhe`] [`/transparencia`] [`/galeria`] [`/voluntariado`]
    Início     História e      Fluxo de      Prestação de      Momentos e     Adesão e
               Diagnóstico     2 Etapas         Contas          Rotinas      Parcerias
```

---

## 2. Mapa do Site (Sitemap Detalhado)

### 2.1 [`/`] — Início / Apresentação da Escola Infantil
- **Hero Principal:** Destaque de acolhimento aos **93 alunos matriculados**, operando da Iniciação à 4ª classe com 5 salas de aula.
- **Destaque da Rotina:** Breve síntese da Parada matinal (07:30-08:00), Merenda balanceada e horários de saída (11:30 para creche e 12:00 para primário).
- **Termômetro de Obras:** Indicador visual de arrecadação do **Fundo de Ampliação Predial** (meta de 8 novas salas necessárias para viabilizar a volta do turno da tarde até 18:00).
- **Chamada Principal (CTA):** Botão direto para o fluxo de apadrinhamento em [`/apadrinhe`].

### 2.2 [`/sobre`] — Nossa História & Desafios da Educação em Luanda
- **Origem Institucional:** A fundação da Escola como ministério de ação social da Igreja Missionária Nova Esperança (IMNE) em Kifangondo.
- **Diagnóstico Educacional de Luanda:**
  - Apenas **13,8%** de cobertura pré-escolar na região metropolitana de Luanda.
  - Déficit estimado de mais de **1.200 vagas** na faixa infantil na comunidade de Kifangondo.
  - Taxa de abandono escolar na periferia superior a **21%** por falta de continuidade no ciclo secundário.
- **Nossa Equipe (10 colaboradores):** Apresentação do Coordenador, Subdiretor Pedagógico, 5 Educadoras, Merendeira e 2 profissionais de apoio.

### 2.3 [`/apadrinhe`] — Como Apoiar & Fluxo em 2 Etapas
- Apresentação das modalidades de apoio: Cota Nutricional, Didática, Apoio aos Educadores, Apadrinhamento Integral e Fundo de Salas.
- **Formulário Otimizado em 2 Etapas** (conforme especificado na Seção 3).

### 2.4 [`/transparencia`] — Prestação de Contas & Aplicação de Recursos
- **Resumo Financeiro Semestral (em AOA):** Total de receitas, despesas executadas e saldo operacional.
- **Gráfico de Destinação:** 42,5% em alimentação, 28% em equipe, 12,5% em materiais, 7% em manutenção e **10% em reserva técnica de contingência**.
- **Painel do Fundo de Salas:** Status da arrecadação para compra de materiais (cimento, blocos, coberturas e carteiras).
- **Downloads Oficiais:** Acesso aos balancetes e relatórios semestrais em PDF.

### 2.5 [`/galeria`] — Atividades Pedagógicas & Vida Escolar
- Registros fotográficos da Parada e devocional no pátio.
- Atividades pedagógicas dentro das 5 salas de aula.
- Distribuição e consumo da merenda comunitária diária (pão com manteiga, sopa e arroz com feijão).

### 2.6 [`/voluntariado`] — Cadastro de Voluntários & Parceiros
- Eixos de voluntariado: Apoio pedagógico/reforço, saúde/nutrição, mutirões de construção civil e doações de gêneros alimentícios.
- Formulário simples de cadastro e contato direto com a coordenação escolar.

---

## 3. Especificação do Fluxo de Apadrinhamento em 2 Etapas

Para garantir máxima conversão sem atrito e respeitar o critério de aceitação da Issue #2 (máximo de 2 etapas):

```
[ Visitante em /apadrinhe ]
            │
            ▼
┌────────────────────────────────────────────────────────┐
│ Etapa 1: Intenção & Seleção da Cota                   │
│ - Escolha da Cota (Nutricional, Didática, etc.)       │
│ - Escolha da Periodicidade (Mensal, Trimestral, Única)│
│ - Valor sugerido ou personalizado (Mínimo: 1.000 AOA) │
└────────────────────────────────────────────────────────┘
            │
            ▼  (Avançar sem recarregar tela)
┌────────────────────────────────────────────────────────┐
│ Etapa 2: Identificação & Dados de Pagamento           │
│ - Nome completo do Mantenedor                          │
│ - Contato (WhatsApp ou E-mail)                         │
│ - Preferência de Privacidade (Exibir ou Anônimo)       │
│ - Geração de Código Único: [ NE-2026-XXXX ]           │
│ - Exibição dos Dados Bancários (IBAN BAI/BFA / MCX)   │
│ - Botão Inteligente: "Enviar Comprovativo via WhatsApp"│
└────────────────────────────────────────────────────────┘
            │
            ▼
   [ Conclusão Imediata ]
```

### Detalhamento das Etapas:

1. **Etapa 1 (Seleção da Contribuição):**
   - O visitante seleciona o cartão da cota desejada ou o Fundo de Obras.
   - Define a frequência (`Mensal`, `Trimestral`, `Anual` ou `Pontual`).
   - O formulário calcula o valor correspondente e avança dinamicamente para o passo final.

2. **Etapa 2 (Dados e Pagamento Direto):**
   - O usuário informa nome, telefone/WhatsApp ou e-mail, e assinala se deseja aparecer no mural de gratidão ou manter anonimato.
   - Ao confirmar, o sistema gera o identificador amigável (ex: `NE-2026-A8K2`).
   - São exibidos na mesma tela os dados para transferência nacional (IBAN BAI/BFA e entidade Multicaixa Express) e dados SWIFT para padrinhos internacionais.
   - É disponibilizado o botão *"Enviar Comprovativo pelo WhatsApp"*, que abre uma mensagem pronta com o código de referência e nome do doador diretamente no canal oficial da escola.

---

## 4. Arquitetura de Persistência Híbrida (PHP 8.2+ / Hostinger)

A modelagem de dados adota o padrão **Repository Pattern**, permitindo que o portal funcione perfeitamente tanto em ambiente simples sem banco configurado quanto em banco de dados relacional MySQL na Hostinger:

- **Interface:** [`NovaEsperanca\Repositories\DonationRepositoryInterface`](file:///c:/Users/fboli/Projetos/nova-esperanca-angola/projeto-social-escola/src/Repositories/DonationRepositoryInterface.php)
- **Implementação Padrão:** [`NovaEsperanca\Repositories\JsonDonationRepository`](file:///c:/Users/fboli/Projetos/nova-esperanca-angola/projeto-social-escola/src/Repositories/JsonDonationRepository.php)
  - Persiste as intenções em `storage/app/donations.json`.
  - Utiliza travas de concorrência no sistema de arquivos (`flock($fp, LOCK_EX)`).
  - Isolado contra acesso público externo.
- **Transição para MySQL:** Para migrar para MySQL na Hostinger, basta implementar a classe `MySqlDonationRepository` utilizando PDO, sem alterar nenhum controller ou tela.
