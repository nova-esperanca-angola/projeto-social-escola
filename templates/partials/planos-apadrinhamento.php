<!-- SECTION 3: PLANOS DE APADRINHAMENTO COMUNITÁRIO (5 Tiers Fiel ao Stitch) -->
<!-- Issue #12: grade comparativa multi-coluna para telas grandes + referencias cambiais EUR/USD/BRL -->
<section class="space-y-4" id="apadrinhar">
  <div class="flex flex-col">
    <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-on-background font-bold tracking-tight text-xl sm:text-2xl">
      Planos de Apadrinhamento
    </h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm">
      Adote uma cota mensal ou pontual. Relatórios regulares e impacto 100% canalizado para as crianças.
    </p>
  </div>

  <!-- GRADE COMPARATIVA DESKTOP: 3 planos de apadrinhamento estudantil (Nutricional · Integral · Didática) -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6 items-stretch">
    <!-- COLUNA 1: Cota Nutricional (12.500 Kz/mês) -->
    <div data-plano="nutricional" class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-4 shadow-sm relative space-y-3 flex flex-col">
      <div class="flex justify-between items-start gap-2">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-nutrition-green/15 text-nutrition-green-dark font-label-sm text-xs font-bold">
          <span class="material-symbols-outlined text-xs" data-icon="nutrition" style="font-variation-settings: 'FILL' 1;">nutrition</span>
          Alimentação Diária
        </span>
        <div class="text-right">
          <div class="font-headline-md text-headline-md font-extrabold text-on-background leading-none text-xl">12.500 Kz <span class="text-xs font-normal text-on-surface-variant">/ mês</span></div>
          <div class="font-body-sm text-[11px] text-on-surface-variant mt-0.5" data-plano-moedas="nutricional">≈ $15 USD • €14 EUR • R$ 80 BRL</div>
        </div>
      </div>
      <h3 class="font-headline-sm text-headline-sm text-on-background font-bold text-base">Cota Nutricional</h3>
      <ul class="space-y-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm flex-1">
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-nutrition-green text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Merenda completa diária para 1 aluno</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-nutrition-green text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Soupa rica e pão fresco matinal</span>
        </li>
        <li class="flex items-start gap-2">
          <span class="material-symbols-outlined text-nutrition-green text-base shrink-0 mt-0.5" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <span>Acompanhamento nutricional periódico</span>
        </li>
      </ul>
      <button onclick="abrirModalApadrinhamento('nutricional', 12500, 'Cota Nutricional', 'mensal')" class="w-full min-h-[48px] bg-surface-container-lowest border-2 border-primary text-primary hover:bg-primary/5 active:scale-[0.98] transition-all rounded-lg font-bold flex items-center justify-center gap-2">
        <span class="material-symbols-outlined text-lg" data-icon="favorite">favorite</span>
        Apadrinhar Nutrição
      </button>
    </div>

    <!-- COLUNA 2 · DESTAQUE CENTRAL: Apadrinhamento Integral (40.000 Kz/mês) -->
    <div data-plano="integral" class="border-2 border-hope-amber-dark/80 bg-gradient-to-b from-surface-container-lowest to-tertiary-fixed/10 lg:scale-[1.03] lg:shadow-xl rounded-2xl p-5 relative space-y-4 flex flex-col">
      <div class="flex justify-between items-start gap-2">
        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant font-label-sm text-xs font-extrabold shadow-sm">
          <span class="material-symbols-outlined text-sm" data-icon="stars" style="font-variation-settings: 'FILL' 1;">stars</span>
          Mais Escolhido / Destaque
        </span>
        <div class="text-right">
          <div class="font-headline-md text-headline-md font-extrabold text-primary leading-none text-xl sm:text-2xl">40.000 Kz <span class="text-xs font-normal text-on-surface-variant">/ mês</span></div>
          <div class="font-body-sm text-[11px] text-on-surface-variant font-semibold mt-0.5" data-plano-moedas="integral">≈ $48 USD • €44 EUR • R$ 260 BRL</div>
        </div>
      </div>
      <div>
        <h3 class="font-headline-md text-headline-md text-on-background font-extrabold text-lg">Apadrinhamento Integral</h3>
        <p class="text-xs text-on-surface-variant font-body-sm mt-0.5">O maior impacto individual na trajetória de uma criança de Kifangondo.</p>
      </div>
      <ul class="space-y-2 font-body-sm text-body-sm text-on-background text-xs sm:text-sm flex-1">
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
      <button onclick="abrirModalApadrinhamento('integral', 40000, 'Apadrinhamento Integral', 'mensal')" class="w-full min-h-[48px] bg-primary text-white hover:bg-primary/90 active:scale-[0.98] transition-all rounded-lg font-bold flex items-center justify-center gap-2 shadow-md">
        <span class="material-symbols-outlined text-lg" data-icon="volunteer_activism" style="font-variation-settings: 'FILL' 1;">volunteer_activism</span>
        Apadrinhamento Integral
      </button>
    </div>

    <!-- COLUNA 3: Cota Didática (8.500 Kz/mês) -->
    <div data-plano="didatica" class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-4 shadow-sm relative space-y-3 flex flex-col">
      <div class="flex justify-between items-start gap-2">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container text-primary font-label-sm text-xs font-bold">
          <span class="material-symbols-outlined text-xs" data-icon="menu_book">menu_book</span>
          Material Escolar
        </span>
        <div class="text-right">
          <div class="font-headline-md text-headline-md font-extrabold text-on-background leading-none text-xl">8.500 Kz <span class="text-xs font-normal text-on-surface-variant">/ mês</span></div>
          <div class="font-body-sm text-[11px] text-on-surface-variant mt-0.5" data-plano-moedas="didatica">≈ $10 USD • €9 EUR • R$ 55 BRL</div>
        </div>
      </div>
      <h3 class="font-headline-sm text-headline-sm text-on-background font-bold text-base">Cota Didática</h3>
      <ul class="space-y-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm flex-1">
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
      <button onclick="abrirModalApadrinhamento('didatica', 8500, 'Cota Didática', 'mensal')" class="w-full min-h-[48px] bg-surface-container-lowest border-2 border-primary text-primary hover:bg-primary/5 active:scale-[0.98] transition-all rounded-lg font-bold flex items-center justify-center gap-2">
        <span class="material-symbols-outlined text-lg" data-icon="auto_stories">auto_stories</span>
        Apadrinhar Educação
      </button>
    </div>
  </div>

  <!-- BLOCO COMPLEMENTAR: apoio institucional e expansão predial -->
  <div class="space-y-2">
    <h3 class="font-label-md text-label-md text-on-background font-bold text-sm sm:text-base flex items-center gap-2">
      <span class="material-symbols-outlined text-secondary text-lg" data-icon="domain">domain</span>
      Apoio Institucional & Expansão Predial
    </h3>
    <p class="font-body-sm text-xs text-on-surface-variant">
      Cotas que sustentam a equipa docente e a construção das 8 novas salas para a volta do turno vespertino.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 pt-3">
      <!-- Apoio Educador (25.000 Kz/mês) -->
      <div data-plano="educador" class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-4 shadow-sm relative space-y-3 flex flex-col">
        <div class="flex justify-between items-start gap-2">
          <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed/50 text-secondary font-label-sm text-xs font-bold">
            <span class="material-symbols-outlined text-xs" data-icon="badge">badge</span>
            Valorização Docente
          </span>
          <div class="text-right">
            <div class="font-headline-md text-headline-md font-extrabold text-on-background leading-none text-xl">25.000 Kz <span class="text-xs font-normal text-on-surface-variant">/ mês</span></div>
            <div class="font-body-sm text-[11px] text-on-surface-variant mt-0.5" data-plano-moedas="educador">≈ $30 USD • €28 EUR • R$ 160 BRL</div>
          </div>
        </div>
        <h4 class="font-headline-sm text-headline-sm text-on-background font-bold text-base">Apoio Educador</h4>
        <ul class="space-y-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm flex-1">
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
        <button onclick="abrirModalApadrinhamento('educador', 25000, 'Apoio Educador', 'mensal')" class="w-full min-h-[48px] bg-surface-container-lowest border-2 border-secondary text-secondary hover:bg-secondary/5 active:scale-[0.98] transition-all rounded-lg font-bold flex items-center justify-center gap-2">
          <span class="material-symbols-outlined text-lg" data-icon="co_present">co_present</span>
          Apoiar Educadores
        </button>
      </div>

      <!-- Fundo de Obras para 8 Novas Salas (50.000 Kz cota única) -->
      <div data-plano="obras" class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-4 shadow-sm relative space-y-3 flex flex-col">
        <div class="flex justify-between items-start gap-2">
          <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-xs font-bold">
            <span class="material-symbols-outlined text-xs" data-icon="apartment">apartment</span>
            Expansão Física
          </span>
          <div class="text-right">
            <div class="font-headline-md text-headline-md font-extrabold text-secondary leading-none text-xl">50.000 Kz <span class="text-xs font-normal text-on-surface-variant">cota única</span></div>
            <div class="font-body-sm text-[11px] text-on-surface-variant mt-0.5" data-plano-moedas="obras">≈ $60 USD • €55 EUR • R$ 325 BRL</div>
          </div>
        </div>
        <h4 class="font-headline-sm text-headline-sm text-on-background font-bold text-base">Fundo de Obras para 8 Novas Salas</h4>
        <ul class="space-y-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs sm:text-sm flex-1">
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
        <button onclick="abrirModalApadrinhamento('obras', 50000, 'Fundo de Obras para 8 Novas Salas', 'pontual')" class="w-full min-h-[48px] bg-secondary text-white hover:bg-secondary/90 active:scale-[0.98] transition-all rounded-lg font-bold flex items-center justify-center gap-2">
          <span class="material-symbols-outlined text-lg" data-icon="handyman">handyman</span>
          Doar para a Obra
        </button>
      </div>
    </div>
  </div>

  <!-- NOTA MULTIMOEDA: referências cambiais informativas para doadores internacionais -->
  <div class="rounded-2xl bg-surface-container border border-outline-variant/30 p-3.5 flex items-start gap-3">
    <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5" data-icon="currency_exchange">currency_exchange</span>
    <div class="space-y-1">
      <p class="font-label-md text-xs font-bold text-on-background">Equivalência Internacional aproximada por plano</p>
      <p class="font-body-sm text-[11px] text-on-surface-variant leading-snug">
        Referências cambiais informativas por mês: <strong>1 USD ≈ 830 Kz</strong> · <strong>1 EUR ≈ 900 Kz</strong> · <strong>1 BRL ≈ 150 Kz</strong>.
        O <strong>Kwanza (AOA/Kz) é a moeda oficial de liquidação</strong> e o valor real é convertido pelo banco emissor no momento do pagamento.
      </p>
    </div>
  </div>
</section>
