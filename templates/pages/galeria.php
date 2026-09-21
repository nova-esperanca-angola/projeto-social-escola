<!-- PÁGINA GALERIA & ROTINA ESCOLAR (ESTILO STITCH & SALVAGUARDA INFANTIL) -->
<section class="rounded-2xl bg-surface-container-lowest p-5 border border-outline-variant/40 shadow-sm space-y-3">
  <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed font-label-sm text-xs font-semibold">
    <span class="material-symbols-outlined text-sm" data-icon="photo_library">photo_library</span>
    Vida Escolar em Kifangondo
  </div>

  <h1 class="font-headline-lg-mobile text-on-background font-extrabold text-2xl tracking-tight">
    Momentos Pedagógicos & Convivência
  </h1>

  <p class="font-body-sm text-on-surface-variant text-sm leading-relaxed">
    Registros das rotinas diárias dos <strong>93 alunos</strong> nas 5 salas de aula, no pátio da Parada matinal e durante a merenda diária balanceada:
  </p>

  <div class="p-3 rounded-xl bg-surface-container/60 border border-outline-variant/20 text-xs text-on-surface-variant flex items-center gap-2">
    <span class="material-symbols-outlined text-primary text-base shrink-0" data-icon="shield">shield</span>
    <span>
      <strong>Salvaguarda Infantil Ativa:</strong> Todas as fotografias institucionais respeitam a Lei nº 25/12 de Angola e a Política de Proteção de Menores, priorizando planos coletivos e pedagógicos.
    </span>
  </div>
</section>

<!-- Momentos da Rotina -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
  <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/30 shadow-sm space-y-3 overflow-hidden">
    <div class="overflow-hidden rounded-xl aspect-[16/10] bg-surface-container shadow-inner">
      <img src="/assets/images/parada-civica.jpeg" alt="Parada Cívica Matinal na Escola Cristã Nova Esperança" class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-500" loading="lazy">
    </div>
    <div class="flex items-center gap-2 text-primary font-bold text-sm">
      <span class="material-symbols-outlined text-xl" data-icon="campaign">campaign</span>
      A Parada Matinal Cívica (07:30 - 08:00)
    </div>
    <p class="text-xs text-on-surface-variant leading-relaxed">
      Reunião cívico-pedagógica no pátio central para entoação do hino nacional, devocional de gratidão e acolhimento dos alunos uniformizados.
    </p>
  </div>

  <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/30 shadow-sm space-y-3 overflow-hidden">
    <div class="overflow-hidden rounded-xl aspect-[16/10] bg-surface-container shadow-inner">
      <img src="/assets/images/predio-salas-atual.jpeg" alt="Prédio Atual das 5 Salas de Aula da Escola Cristã Nova Esperança" class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-500" loading="lazy">
    </div>
    <div class="flex items-center gap-2 text-secondary font-bold text-sm">
      <span class="material-symbols-outlined text-xl" data-icon="auto_stories">auto_stories</span>
      As 5 Salas de Aula em Ação
    </div>
    <p class="text-xs text-on-surface-variant leading-relaxed">
      Fachada do prédio atual onde funcionam as 5 salas de aula (Iniciação à 4ª classe), com alfabetização e acolhimento diário às 93 crianças.
    </p>
  </div>

  <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/30 shadow-sm space-y-3 overflow-hidden">
    <div class="overflow-hidden rounded-xl aspect-[16/10] bg-surface-container shadow-inner">
      <img src="/assets/images/merenda-escolar.jpeg" alt="Distribuição da Merenda Escolar Diária na Escola Cristã Nova Esperança" class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-500" loading="lazy">
    </div>
    <div class="flex items-center gap-2 text-nutrition-green-dark font-bold text-sm">
      <span class="material-symbols-outlined text-xl" data-icon="restaurant">restaurant</span>
      A Merenda Escolar Diária (10:00 - 10:45)
    </div>
    <p class="text-xs text-on-surface-variant leading-relaxed">
      Distribuição da refeição nutritiva e pratos quentes servidos com carinho às crianças uniformizadas, garantindo energia e foco cognitivo para o aprendizado.
    </p>
  </div>
</div>

<?= \NovaEsperanca\Core\View::partial('canais-apoio') ?>
