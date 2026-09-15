<!-- PÁGINA SOBRE: HISTÓRIA, DIAGNÓSTICO & EQUIPE (ESTILO STITCH) -->
<section class="rounded-2xl bg-surface-container-lowest p-5 border border-outline-variant/40 shadow-sm space-y-4">
  <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-xs font-semibold">
    <span class="material-symbols-outlined text-sm" data-icon="history_edu">history_edu</span>
    Nossa História & Missão
  </div>

  <h1 class="font-headline-lg-mobile text-on-background font-extrabold text-2xl tracking-tight">
    O Florescer da Educação Comunitária em Kifangondo
  </h1>

  <div class="space-y-3 font-body-sm text-on-surface-variant text-sm leading-relaxed">
    <p>
      A cerca de 30 km do centro de Luanda, no município de Ícolo e Bengo, o bairro histórico de <strong>Kifangondo</strong> abriga milhares de famílias trabalhadoras que enfrentam diariamente uma escassez severa de serviços públicos básicos.
    </p>
    <p>
      Fundada pela <strong>Igreja Missionária Nova Esperança (IMNE)</strong> como um ministério de acolhimento e resgate social, a <strong>Escola Nova Esperança</strong> nasceu da determinação de não permitir que centenas de crianças crescessem à margem das salas de aula. O que começou com um barracão provisório é hoje um complexo escolar acolhedor com <strong>5 salas de aula ativas</strong> atendendo <strong>93 alunos matriculados</strong> da Iniciação à 4ª classe.
    </p>
  </div>
</section>

<!-- Widget Diagnóstico Luanda & World Bank -->
<?= \NovaEsperanca\Core\View::partial('widget-diagnostico', $diagnostico ?? []) ?>

<!-- Apresentação da Equipe de 10 Colaboradores -->
<section class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-5 shadow-sm space-y-4">
  <div class="flex items-center gap-2">
    <span class="material-symbols-outlined text-primary text-2xl" data-icon="badge">badge</span>
    <div>
      <h2 class="font-headline-sm font-bold text-on-background text-lg">Nossa Equipe Operacional</h2>
      <p class="font-body-sm text-xs text-on-surface-variant">10 colaboradores locais dedicados diariamente às 93 crianças</p>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
    <div class="p-3 rounded-xl bg-surface-container/60 border border-outline-variant/20">
      <div class="font-label-md font-bold text-on-background text-sm">Coordenação Geral</div>
      <div class="text-xs text-primary font-semibold">1 Coordenador Institucional</div>
      <div class="text-[11px] text-on-surface-variant mt-1">Gestão com a mantenedora IMNE, Ministério da Educação e relação comunitária.</div>
    </div>

    <div class="p-3 rounded-xl bg-surface-container/60 border border-outline-variant/20">
      <div class="font-label-md font-bold text-on-background text-sm">Direção Pedagógica</div>
      <div class="text-xs text-secondary font-semibold">1 Subdiretor Pedagógico</div>
      <div class="text-[11px] text-on-surface-variant mt-1">Coordenação curricular, formação docente e acompanhamento da aprendizagem.</div>
    </div>

    <div class="p-3 rounded-xl bg-surface-container/60 border border-outline-variant/20">
      <div class="font-label-md font-bold text-on-background text-sm">Corpo Docente</div>
      <div class="text-xs text-hope-amber-dark font-semibold">5 Educadoras Titulares</div>
      <div class="text-[11px] text-on-surface-variant mt-1">Regência de classe nas 5 salas (Iniciação e 1ª à 4ª classe com alfabetização fônica).</div>
    </div>

    <div class="p-3 rounded-xl bg-surface-container/60 border border-outline-variant/20">
      <div class="font-label-md font-bold text-on-background text-sm">Nutrição & Higiene</div>
      <div class="text-xs text-nutrition-green-dark font-semibold">1 Merendeira e 2 Auxiliares</div>
      <div class="text-[11px] text-on-surface-variant mt-1">Preparo da merenda escolar balanceada e sanitização diária rigorosa das dependências.</div>
    </div>
  </div>

  <div class="pt-2 text-center">
    <a href="/apadrinhe" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white rounded-lg font-label-md font-bold text-sm shadow-md hover:bg-primary/90 transition-all">
      <span class="material-symbols-outlined" data-icon="favorite">favorite</span>
      Apoiar a Escola e os Educadores
    </a>
  </div>
</section>

<?= \NovaEsperanca\Core\View::partial('canais-apoio') ?>
