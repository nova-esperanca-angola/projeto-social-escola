<!-- SECTION 3: PLANOS DE APADRINHAMENTO COMUNITÁRIO (5 Tiers Fiel ao Stitch) -->
<section class="space-y-4" id="apadrinhar">
  <div class="flex flex-col">
    <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-on-background font-bold tracking-tight text-xl sm:text-2xl">
      Planos de Apadrinhamento
    </h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm">
      Adote uma cota mensal ou pontual. Relatórios regulares e impacto 100% canalizado para as crianças.
    </p>
  </div>

  <div class="space-y-3.5">
    <!-- TIER 1: Cota Nutricional -->
    <div class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-4 shadow-sm relative space-y-3">
      <div class="flex justify-between items-start">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-nutrition-green/15 text-nutrition-green-dark font-label-sm text-xs font-bold">
          <span class="material-symbols-outlined text-xs" data-icon="nutrition" style="font-variation-settings: 'FILL' 1;">nutrition</span>
          Alimentação Diária
        </span>
        <div class="text-right">
          <div class="font-headline-md text-headline-md font-extrabold text-on-background leading-none text-xl">12.500 Kz <span class="text-xs font-normal text-on-surface-variant">/ mês</span></div>
          <div class="font-body-sm text-xs text-on-surface-variant mt-0.5">Aprox. $15 USD</div>
        </div>
      </div>
      <h3 class="font-headline-sm text-headline-sm text-on-background font-bold text-base">Cota Nutricional</h3>
      <ul class="space-y-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm">
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-nutrition-green text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Merenda completa diária para 1 aluno</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-nutrition-green text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Sopa rica e pão fresco matinal</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-nutrition-green text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Acompanhamento nutricional periódico</span>
        </li>
      </ul>
      <button onclick="abrirModalApadrinhamento('nutricional', 12500, 'Cota Nutricional', 'mensal')" class="w-full min-h-[48px] bg-surface-container-lowest border-2 border-primary text-primary hover:bg-primary/5 active:scale-[0.98] transition-all rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 font-bold">
        <span class="material-symbols-outlined text-lg" data-icon="favorite">favorite</span>
        Apadrinhar Nutrição
      </button>
    </div>

    <!-- TIER 2: Cota Didática -->
    <div class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-4 shadow-sm relative space-y-3">
      <div class="flex justify-between items-start">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container text-primary font-label-sm text-xs font-bold">
          <span class="material-symbols-outlined text-xs" data-icon="menu_book">menu_book</span>
          Material Escolar
        </span>
        <div class="text-right">
          <div class="font-headline-md text-headline-md font-extrabold text-on-background leading-none text-xl">8.500 Kz <span class="text-xs font-normal text-on-surface-variant">/ mês</span></div>
          <div class="font-body-sm text-xs text-on-surface-variant mt-0.5">Aprox. $10 USD</div>
        </div>
      </div>
      <h3 class="font-headline-sm text-headline-sm text-on-background font-bold text-base">Cota Didática</h3>
      <ul class="space-y-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm">
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-primary text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Cadernos, manuais e estojo completo</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-primary text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Apoio pedagógico e fichas de exercícios</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-primary text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Livros para a biblioteca comunitária</span>
        </li>
      </ul>
      <button onclick="abrirModalApadrinhamento('didatica', 8500, 'Cota Didática', 'mensal')" class="w-full min-h-[48px] bg-surface-container-lowest border-2 border-primary text-primary hover:bg-primary/5 active:scale-[0.98] transition-all rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 font-bold">
        <span class="material-symbols-outlined text-lg" data-icon="auto_stories">auto_stories</span>
        Apadrinhar Educação
      </button>
    </div>

    <!-- TIER 3: Apoio Educador -->
    <div class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-4 shadow-sm relative space-y-3">
      <div class="flex justify-between items-start">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed/50 text-secondary font-label-sm text-xs font-bold">
          <span class="material-symbols-outlined text-xs" data-icon="badge">badge</span>
          Valorização Docente
        </span>
        <div class="text-right">
          <div class="font-headline-md text-headline-md font-extrabold text-on-background leading-none text-xl">25.000 Kz <span class="text-xs font-normal text-on-surface-variant">/ mês</span></div>
          <div class="font-body-sm text-xs text-on-surface-variant mt-0.5">Aprox. $30 USD</div>
        </div>
      </div>
      <h3 class="font-headline-sm text-headline-sm text-on-background font-bold text-base">Apoio Educador</h3>
      <ul class="space-y-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm">
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-secondary text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Subsídio pedagógico para educadoras locais</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-secondary text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Oficinas de capacitação continuada</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-secondary text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Material didático de suporte em sala</span>
        </li>
      </ul>
      <button onclick="abrirModalApadrinhamento('educador', 25000, 'Apoio Educador', 'mensal')" class="w-full min-h-[48px] bg-surface-container-lowest border-2 border-secondary text-secondary hover:bg-secondary/5 active:scale-[0.98] transition-all rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 font-bold">
        <span class="material-symbols-outlined text-lg" data-icon="co_present">co_present</span>
        Apoiar Educadores
      </button>
    </div>

    <!-- TIER 4: Apadrinhamento Integral (DESTAQUE COMUNITÁRIO DO STITCH) -->
    <div class="bg-surface-container-lowest border-2 border-hope-amber-dark/80 rounded-2xl p-5 shadow-md relative space-y-4 bg-gradient-to-b from-surface-container-lowest to-tertiary-fixed/10">
      <div class="flex justify-between items-start">
        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant font-label-sm text-xs font-extrabold shadow-sm">
          <span class="material-symbols-outlined text-sm" data-icon="stars" style="font-variation-settings: 'FILL' 1;">stars</span>
          Mais Escolhido / Destaque
        </span>
        <div class="text-right">
          <div class="font-headline-md text-headline-md font-extrabold text-primary leading-none text-xl sm:text-2xl">40.000 Kz <span class="text-xs font-normal text-on-surface-variant">/ mês</span></div>
          <div class="font-body-sm text-xs text-on-surface-variant font-semibold mt-0.5">Aprox. $48 USD</div>
        </div>
      </div>
      <div>
        <h3 class="font-headline-md text-headline-md text-on-background font-extrabold text-lg">Apadrinhamento Integral</h3>
        <p class="text-xs text-on-surface-variant font-body-sm mt-0.5">O maior impacto individual na trajetória de uma criança de Kifangondo.</p>
      </div>
      <ul class="space-y-2 font-body-sm text-body-sm text-on-background text-xs sm:text-sm">
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-hope-amber-dark text-lg shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span><strong>Cobertura total:</strong> Alimentação + Didática + Saúde básica</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-hope-amber-dark text-lg shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Relatório semestral com evolução escolar e fotos coletivas</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-hope-amber-dark text-lg shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Mensagem personalizada e certificado de mantenedor</span>
        </li>
      </ul>
      <button onclick="abrirModalApadrinhamento('integral', 40000, 'Apadrinhamento Integral', 'mensal')" class="w-full min-h-[48px] bg-primary text-white hover:bg-primary/90 active:scale-[0.98] transition-all rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 shadow-md font-bold">
        <span class="material-symbols-outlined text-lg" data-icon="volunteer_activism" style="font-variation-settings: 'FILL' 1;">volunteer_activism</span>
        Apadrinhamento Integral
      </button>
    </div>

    <!-- TIER 5: Fundo de Obras para 8 Novas Salas -->
    <div class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-4 shadow-sm relative space-y-3">
      <div class="flex justify-between items-start">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-xs font-bold">
          <span class="material-symbols-outlined text-xs" data-icon="apartment">apartment</span>
          Expansão Física
        </span>
        <div class="text-right">
          <div class="font-headline-md text-headline-md font-extrabold text-secondary leading-none text-xl">50.000 Kz <span class="text-xs font-normal text-on-surface-variant">cota única</span></div>
          <div class="font-body-sm text-xs text-on-surface-variant mt-0.5">Aprox. $60 USD</div>
        </div>
      </div>
      <h3 class="font-headline-sm text-headline-sm text-on-background font-bold text-base">Fundo de Obras para 8 Novas Salas</h3>
      <ul class="space-y-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm">
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-secondary text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Compra de blocos estruturais e cimento Portland</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-secondary text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Prestação pública do uso com relatório fotográfico da obra</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-secondary text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Permite construir as 8 salas necessárias para a volta do turno vespertino</span>
        </li>
      </ul>
      <button onclick="abrirModalApadrinhamento('obras', 50000, 'Fundo de Obras para 8 Novas Salas', 'pontual')" class="w-full min-h-[48px] bg-secondary text-white hover:bg-secondary/90 active:scale-[0.98] transition-all rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 font-bold">
        <span class="material-symbols-outlined text-lg" data-icon="handyman">handyman</span>
        Doar para a Obra
      </button>
    </div>
  </div>
</section>
