<?php
/**
 * HERO INSTITUCIONAL — Layout bi-colunar desktop (Issue #10)
 * Coluna esquerda: contexto, proposta de valor e CTAs de conversao.
 * Coluna direita: fotografia oficial da comunidade escolar com resumo numerico.
 */
$dados = $dados ?? [];
?>
<section class="rounded-2xl bg-surface-container-lowest p-6 md:p-8 lg:p-10 border border-outline-variant/40 shadow-sm relative overflow-hidden">
  <div class="absolute -right-10 -top-10 w-36 h-36 rounded-full bg-tertiary-fixed/30 blur-2xl pointer-events-none"></div>

  <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">
    <!-- COLUNA ESQUERDA: Conteudo e Conversao -->
    <div class="lg:col-span-7 space-y-4">
      <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-xs font-semibold">
        <span class="material-symbols-outlined text-sm" data-icon="local_fire_department" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
        Educação e Dignidade Comunitária
      </div>

      <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-2xl sm:text-3xl lg:text-4xl leading-tight font-extrabold tracking-tight text-on-background">
        Juntos pela infância e pelo futuro em Kifangondo.
      </h1>

      <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed text-sm sm:text-base">
        Uma iniciativa comunitária mantida pela Igreja Missionária Nova Esperança com gestão transparente e auditoria aberta. Transformamos o apoio solidário em refeições diárias, salas de aula seguras e alfabetização viva para as crianças de Kifangondo.
      </p>

      <!-- Botoes de Acao (flex-wrap evita esmagamento entre 768px e 1024px) -->
      <div class="flex flex-wrap items-center gap-3 pt-2">
        <button type="button" onclick="abrirModalApadrinhamento('integral', 40000, 'Apadrinhamento Integral')" aria-label="Apadrinhar uma criança por 40.000 Kz" class="inline-flex items-center justify-center min-h-[48px] px-5 py-2.5 rounded-lg bg-primary hover:bg-primary-dark text-white font-label-md font-bold transition-all shadow-sm active:scale-95">
          <span class="material-symbols-outlined text-lg mr-1.5" data-icon="volunteer_activism">volunteer_activism</span>
          Apadrinhe uma Criança
        </button>
        <a href="/transparencia" class="inline-flex items-center justify-center min-h-[48px] px-5 py-2.5 rounded-lg border border-outline-variant bg-surface-container/60 hover:bg-surface-container text-on-surface font-label-md font-bold transition-all">
          <span class="material-symbols-outlined text-lg mr-1.5" data-icon="fact_check">fact_check</span>
          Transparência Financeira
        </a>
      </div>

      <!-- Quick Proof Highlights do Stitch -->
      <div class="flex flex-wrap gap-2 text-on-surface-variant font-label-sm text-xs">
        <span class="flex items-center gap-1 bg-surface-container px-2.5 py-1 rounded-lg">
          <span class="material-symbols-outlined text-sm text-primary" data-icon="shield">shield</span>
          Prestação pública
        </span>
        <span class="flex items-center gap-1 bg-surface-container px-2.5 py-1 rounded-lg">
          <span class="material-symbols-outlined text-sm text-hope-amber-dark" data-icon="payments">payments</span>
          Kz &amp; USD
        </span>
        <span class="flex items-center gap-1 bg-surface-container px-2.5 py-1 rounded-lg">
          <span class="material-symbols-outlined text-sm text-nutrition-green-dark" data-icon="handshake">handshake</span>
          Impacto direto
        </span>
      </div>
    </div>

    <!-- COLUNA DIREITA: Fotografia Oficial e Destaque Numerico -->
    <div class="lg:col-span-5 relative">
      <div class="relative aspect-[4/3] rounded-2xl overflow-hidden shadow-md border border-outline-variant/40 bg-surface-container">
        <img src="/assets/images/parada-civica.jpeg" alt="Alunos e equipe da Escola Cristã Nova Esperança reunidos na Parada Cívica Matinal em Kifangondo" class="w-full h-full object-cover object-center" loading="lazy">

        <!-- Barra de contexto com protecao de imagem (scrim) para alto contraste -->
        <div class="absolute inset-x-0 bottom-0 p-3 sm:p-4 bg-gradient-to-t from-on-background/95 via-on-background/70 to-transparent">
          <div class="grid grid-cols-2 gap-2">
            <div class="rounded-xl bg-white/10 border border-white/20 backdrop-blur-sm px-3 py-2">
              <div class="font-metric-stat text-metric-stat text-white font-extrabold leading-none text-base sm:text-lg">93 Alunos</div>
              <div class="text-white/80 text-[10px] sm:text-[11px] font-body-sm mt-1">Matriculados</div>
            </div>
            <div class="rounded-xl bg-white/10 border border-white/20 backdrop-blur-sm px-3 py-2">
              <div class="font-metric-stat text-metric-stat text-white font-extrabold leading-none text-base sm:text-lg">5 Salas Ativas</div>
              <div class="text-white/80 text-[10px] sm:text-[11px] font-body-sm mt-1">Turno matutino</div>
            </div>
          </div>
          <div class="flex items-center gap-1 mt-2 text-white/90 text-xs font-label-sm">
            <span class="material-symbols-outlined text-sm" data-icon="location_on">location_on</span>
            Kifangondo, Sequele
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
