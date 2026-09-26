<?php
/**
 * BENTO GRID DE IMPACTO — 2 colunas no mobile, 4 colunas no desktop (Issue #10)
 * Os 4 pilares usam exclusivamente os dados oficiais auditados.
 */
$metricas = $metricas ?? [];
$alunos = (string)($metricas['alunos'] ?? 93);
$salas = str_pad((string)(int)($metricas['salas'] ?? 5), 2, '0', STR_PAD_LEFT);
$colaboradores = (string)(int)($metricas['colaboradores'] ?? 10);
$merenda = (string)($metricas['merenda'] ?? '100%');
?>
<!-- SECTION 1: INDICADORES DE IMPACTO REAL (Bento 2x2 Mobile / 1x4 Desktop) -->
<section id="bento-impacto" class="space-y-3 scroll-mt-20">
  <div class="flex items-center justify-between">
    <h2 class="font-headline-sm text-headline-sm text-on-background font-bold tracking-tight text-lg">
      Indicadores de Impacto Real
    </h2>
    <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1 text-xs">
      <span class="w-2 h-2 rounded-full bg-nutrition-green animate-pulse"></span> Atualizado 2026
    </span>
  </div>

  <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
    <!-- Pilar 1: Alunos Matriculados -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-4 md:p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow">
      <div class="w-10 h-10 rounded-xl bg-primary-fixed flex items-center justify-center text-primary mb-3">
        <span class="material-symbols-outlined text-2xl" data-icon="school">school</span>
      </div>
      <div>
        <div class="font-metric-stat text-metric-stat text-primary leading-none text-2xl sm:text-3xl font-extrabold"><?= htmlspecialchars($alunos, ENT_QUOTES, 'UTF-8') ?></div>
        <div class="font-label-md text-label-md text-on-background font-bold mt-1 text-sm">Alunos Matriculados</div>
        <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5 text-xs">Da iniciação à 4ª classe</div>
      </div>
    </div>

    <!-- Pilar 2: Salas de Aula Ativas -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-4 md:p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow">
      <div class="w-10 h-10 rounded-xl bg-tertiary-fixed flex items-center justify-center text-tertiary mb-3">
        <span class="material-symbols-outlined text-2xl" data-icon="foundation">foundation</span>
      </div>
      <div>
        <div class="font-metric-stat text-metric-stat text-hope-amber-dark leading-none text-2xl sm:text-3xl font-extrabold"><?= htmlspecialchars($salas, ENT_QUOTES, 'UTF-8') ?></div>
        <div class="font-label-md text-label-md text-on-background font-bold mt-1 text-sm">Salas de Aula Ativas</div>
        <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5 text-xs">Turno matutino estruturado (Meta: +8)</div>
      </div>
    </div>

    <!-- Pilar 3: Colaboradores Locais -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-4 md:p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow">
      <div class="w-10 h-10 rounded-xl bg-secondary-fixed flex items-center justify-center text-secondary mb-3">
        <span class="material-symbols-outlined text-2xl" data-icon="diversity_3">diversity_3</span>
      </div>
      <div>
        <div class="font-metric-stat text-metric-stat text-secondary leading-none text-2xl sm:text-3xl font-extrabold"><?= htmlspecialchars($colaboradores, ENT_QUOTES, 'UTF-8') ?></div>
        <div class="font-label-md text-label-md text-on-background font-bold mt-1 text-sm">Colaboradores Locais</div>
        <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5 text-xs">5 educadoras e equipe de apoio</div>
      </div>
    </div>

    <!-- Pilar 4: Merenda Garantida -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-4 md:p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow">
      <div class="w-10 h-10 rounded-xl bg-nutrition-green/15 flex items-center justify-center text-nutrition-green-dark mb-3">
        <span class="material-symbols-outlined text-2xl" data-icon="restaurant" style="font-variation-settings: 'FILL' 1;">restaurant</span>
      </div>
      <div>
        <div class="font-metric-stat text-metric-stat text-nutrition-green leading-none text-2xl sm:text-3xl font-extrabold"><?= htmlspecialchars($merenda, ENT_QUOTES, 'UTF-8') ?></div>
        <div class="font-label-md text-label-md text-on-background font-bold mt-1 text-sm">Merenda Garantida</div>
        <div class="font-body-sm text-body-sm text-on-surface-variant mt-0.5 text-xs">Pão fresco, sopa e feijão diário</div>
      </div>
    </div>
  </div>
</section>
