<!-- SECTION 2: TERMÔMETRO DE OBRAS (Fiel ao Mockup Stitch) -->
<section class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-5 shadow-sm space-y-4">
  <div class="flex items-start justify-between gap-3">
    <div>
      <span class="inline-block px-2.5 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-xs font-semibold uppercase tracking-wider mb-1">
        Fundo de Infraestrutura
      </span>
      <h2 class="font-headline-md text-headline-md text-on-background font-bold text-xl">
        Expansão de 8 Novas Salas Necessárias
      </h2>
      <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 text-xs sm:text-sm">
        Meta vital para restaurar o turno da tarde e acolher <strong>+120 crianças</strong> atualmente fora do sistema escolar em Kifangondo.
      </p>
    </div>
    <div class="p-2.5 rounded-xl bg-secondary-fixed/50 text-secondary shrink-0">
      <span class="material-symbols-outlined text-2xl" data-icon="architecture">architecture</span>
    </div>
  </div>

  <!-- Linear Thermometer -->
  <div class="space-y-2 pt-1">
    <div class="flex justify-between items-baseline font-label-md">
      <span class="text-secondary font-bold text-base sm:text-lg">0% Arrecadado</span>
      <span class="text-on-surface-variant text-xs">Faltam 55.359.800 Kz</span>
    </div>
    <div class="w-full bg-surface-container h-3.5 rounded-full overflow-hidden p-0.5 border border-outline-variant/20">
      <div class="h-full rounded-full bg-gradient-to-r from-hope-amber-dark to-secondary transition-all duration-500" style="width: 0%;"></div>
    </div>
    <div class="flex justify-between items-center text-xs font-label-sm pt-1 text-on-surface-variant">
      <span class="font-bold text-on-background">0 Kz angariados</span>
      <span>Meta: 55.359.800 Kz</span>
    </div>
  </div>

  <!-- Milestone Steps Horizontal Flow -->
  <div class="pt-2 border-t border-outline-variant/30 space-y-2">
    <div class="font-label-sm text-xs text-on-surface-variant uppercase tracking-wider font-bold">Fases da Construção:</div>
    <div class="grid grid-cols-3 gap-2 text-center text-xs">
      <!-- Step 1 Done -->
      <div class="bg-nutrition-green/10 border border-nutrition-green/20 rounded-xl p-2 flex flex-col items-center justify-center">
        <span class="material-symbols-outlined text-nutrition-green text-lg mb-1" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        <span class="font-bold text-on-background leading-tight text-xs">Terraplanagem</span>
        <span class="text-nutrition-green-dark text-[10px] font-semibold mt-0.5">Concluído</span>
      </div>

      <!-- Step 2 In Progress -->
      <div class="bg-secondary-fixed/40 border border-secondary/30 rounded-xl p-2 flex flex-col items-center justify-center">
        <span class="material-symbols-outlined text-secondary text-lg mb-1" data-icon="engineering">engineering</span>
        <span class="font-bold text-on-background leading-tight text-xs">Alvenaria/Sapatas</span>
        <span class="text-secondary font-semibold text-[10px] mt-0.5">Em andamento</span>
      </div>

      <!-- Step 3 Upcoming -->
      <div class="bg-surface-container border border-outline-variant/30 rounded-xl p-2 flex flex-col items-center justify-center opacity-70">
        <span class="material-symbols-outlined text-outline text-lg mb-1" data-icon="roofing">roofing</span>
        <span class="font-bold text-on-background leading-tight text-xs">Cobertura/Acab.</span>
        <span class="text-on-surface-variant text-[10px] font-semibold mt-0.5">Próxima fase</span>
      </div>
    </div>
  </div>

  <!-- Construction Action CTA -->
  <button onclick="abrirModalApadrinhamento('obras', 50000, 'Fundo de Obras (8 Novas Salas)', 'pontual')" class="w-full min-h-[48px] bg-secondary text-on-secondary hover:bg-secondary/90 active:scale-[0.98] transition-all rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 shadow-sm font-bold text-white">
    <span class="material-symbols-outlined text-lg" data-icon="handyman">handyman</span>
    Contribuir com Materiais ou Cota de Obra
  </button>
</section>
