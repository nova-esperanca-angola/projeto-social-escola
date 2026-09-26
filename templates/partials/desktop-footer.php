<?php
$currentRoute = $currentRoute ?? '/';

$footerNavLinks = [
    ['href' => '/',             'label' => 'Início'],
    ['href' => '/sobre',        'label' => 'Sobre Nós'],
    ['href' => '/apadrinhe',    'label' => 'Apadrinhe'],
    ['href' => '/transparencia', 'label' => 'Transparência'],
    ['href' => '/galeria',      'label' => 'Galeria'],
    ['href' => '/voluntariado', 'label' => 'Voluntariado'],
];
?>
<!-- RODAPÉ INSTITUCIONAL DESKTOP (Visível apenas em >= 768px · Issue #9) -->
<footer class="hidden md:block bg-surface-container border-t border-outline-variant/40 mt-16 text-on-surface">
  <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

    <!-- COLUNA 1: IDENTIDADE & MISSÃO -->
    <div class="space-y-3">
      <div class="flex items-center gap-2.5">
        <img src="/assets/images/logo.jpeg" alt="Logotipo Escola Cristã Nova Esperança" class="h-10 w-auto max-w-[110px] object-contain rounded-md shadow-sm border border-primary/20 bg-white p-0.5 shrink-0">
        <div class="min-w-0">
          <div class="font-headline-sm text-headline-sm text-primary font-bold tracking-tight text-sm leading-snug">Escola Cristã Nova Esperança</div>
          <div class="font-label-sm text-label-sm text-on-surface-variant text-[11px] leading-snug mt-0.5">Kifangondo, Sequele · Ícolo e Bengo</div>
        </div>
      </div>

      <p class="font-body-sm text-body-sm text-on-surface-variant text-xs leading-relaxed">
        Escola cristã comunitária do Bairro Kifangondo, no Sequele (Ícolo e Bengo), mantida pela
        <strong class="text-on-surface">Igreja Missionária Nova Esperança (IMNE)</strong>.
        Acolhemos <strong class="text-on-surface">93 alunos</strong> da iniciação à 4ª classe com
        5 salas ativas, 10 colaboradores e merenda escolar garantida 100% dos dias letivos.
      </p>

      <div class="flex flex-wrap items-center gap-1.5 pt-1">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-nutrition-green/10 text-nutrition-green-dark font-label-sm text-label-sm text-[11px] font-semibold">
          <span class="material-symbols-outlined text-sm" data-icon="verified" style="font-variation-settings: 'FILL' 1;">verified</span>
          Impacto Verificado
        </span>
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary/10 text-primary font-label-sm text-label-sm text-[11px] font-semibold">
          <span class="material-symbols-outlined text-sm" data-icon="diversity_3">diversity_3</span>
          Selo Comunitário IMNE
        </span>
      </div>
    </div>

    <!-- COLUNA 2: MAPA DE NAVEGAÇÃO INSTITUCIONAL -->
    <div>
      <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold text-sm uppercase tracking-wider">Navegação</h3>
      <ul class="mt-3 space-y-1.5">
        <?php foreach ($footerNavLinks as $link): ?>
          <li>
            <a href="<?= htmlspecialchars($link['href']) ?>"
               class="inline-flex items-center gap-1.5 font-body-sm text-body-sm text-xs text-on-surface-variant hover:text-primary transition-colors font-medium rounded focus-visible:ring-2 focus-visible:ring-primary focus-visible:outline-none focus:outline-none">
              <span class="material-symbols-outlined text-sm text-primary/60" data-icon="chevron_right">chevron_right</span>
              <?= htmlspecialchars($link['label']) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>

      <h4 class="font-label-md text-label-md text-on-surface font-bold text-xs uppercase tracking-wider mt-4">Saltos Diretos</h4>
      <ul class="mt-2 space-y-1">
        <li>
          <a href="/#bento-impacto" class="font-body-sm text-body-sm text-[11px] text-on-surface-variant hover:text-primary transition-colors rounded focus-visible:ring-2 focus-visible:ring-primary focus-visible:outline-none focus:outline-none">
            Indicadores de Impacto (Bento Grid)
          </a>
        </li>
        <li>
          <a href="/#termometro-obras" class="font-body-sm text-body-sm text-[11px] text-on-surface-variant hover:text-primary transition-colors rounded focus-visible:ring-2 focus-visible:ring-primary focus-visible:outline-none focus:outline-none">
            Termômetro de Obras (8 salas)
          </a>
        </li>
        <li>
          <a href="/transparencia#prestacao-contas" class="font-body-sm text-body-sm text-[11px] text-on-surface-variant hover:text-primary transition-colors rounded focus-visible:ring-2 focus-visible:ring-primary focus-visible:outline-none focus:outline-none">
            Prestação de Contas do Semestre
          </a>
        </li>
      </ul>
    </div>

    <!-- COLUNA 3: CANAIS BANCÁRIOS & DOADORES INTERNACIONAIS -->
    <div>
      <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold text-sm uppercase tracking-wider">Canais Bancários</h3>
      <p class="font-body-sm text-body-sm text-on-surface-variant text-xs leading-relaxed mt-2">
        <strong class="text-on-surface">Titular:</strong> Igreja Missionária Nova Esperança - Escola
      </p>

      <ul class="mt-3 space-y-2">
        <li class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-2.5 flex items-start gap-2.5">
          <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-lg" data-icon="smartphone">smartphone</span>
          </span>
          <div class="min-w-0">
            <div class="font-label-md text-label-md text-on-surface font-bold text-[11px]">Multicaixa Express (Expresso)</div>
            <div class="font-mono font-bold text-primary text-xs select-all">9305-61688</div>
          </div>
        </li>
        <li class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-2.5 flex items-start gap-2.5">
          <span class="w-8 h-8 rounded-lg bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-lg" data-icon="account_balance">account_balance</span>
          </span>
          <div class="min-w-0">
            <div class="font-label-md text-label-md text-on-surface font-bold text-[11px]">Banco Atlântico</div>
            <div class="font-mono text-on-surface-variant text-[10px] select-all font-semibold">0005-0000-5089-22202-1014-6</div>
          </div>
        </li>
        <li class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-2.5 flex items-start gap-2.5">
          <span class="w-8 h-8 rounded-lg bg-hope-amber-dark/10 text-hope-amber-dark flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-lg" data-icon="account_balance">account_balance</span>
          </span>
          <div class="min-w-0">
            <div class="font-label-md text-label-md text-on-surface font-bold text-[11px]">Banco BCI</div>
            <div class="font-mono text-on-surface-variant text-[10px] select-all font-semibold">0005-0000-6972-1564-1019-7</div>
          </div>
        </li>
      </ul>

      <div class="mt-3 bg-primary-container border border-primary/20 rounded-xl p-2.5">
        <div class="font-label-md text-label-md text-on-primary-container font-bold text-[11px]">Doadores Internacionais (Kz / USD)</div>
        <p class="font-body-sm text-body-sm text-on-surface-variant text-[11px] leading-relaxed mt-1">
          Transferências em Kwanzas (Kz) a partir dos IBAN acima. Doadores em USD podem converter
          pelo câmbio do dia junto à Tesouraria da IMNE e indicar o código de referência
          <code class="font-mono font-bold text-on-primary-container">NE-2026-XXXX</code> no descritivo.
          Relatórios semestrais e balancetes são publicados abertamente na página de Transparência.
        </p>
      </div>
    </div>

    <!-- COLUNA 4: SALVAGUARDA INFANTIL & MARCO LEGAL -->
    <div>
      <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold text-sm uppercase tracking-wider">Salvaguarda Infantil</h3>

      <div class="mt-3 bg-surface-container-lowest border-2 border-nutrition-green/40 rounded-xl p-3">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-nutrition-green-dark text-xl" data-icon="shield" style="font-variation-settings: 'FILL' 1;">shield</span>
          <div class="font-label-md text-label-md text-on-surface font-bold text-xs leading-snug">
            Lei nº 25/12 — República de Angola
          </div>
        </div>
        <p class="font-body-sm text-body-sm text-on-surface-variant text-[11px] leading-relaxed mt-2">
          A Escola Cristã Nova Esperança cumpre integralmente a
          <strong class="text-on-surface">Lei nº 25/12 de 12 de Setembro, Lei de Protecção e Salvaguarda da Imagem de Menores</strong>,
          que proíbe a divulgação, captação ou divulgação indevida da imagem de menores.
        </p>
        <ul class="mt-2 space-y-1">
          <li class="flex items-start gap-1.5">
            <span class="material-symbols-outlined text-sm text-nutrition-green-dark mt-px shrink-0" data-icon="block">block</span>
            <span class="font-body-sm text-body-sm text-on-surface-variant text-[11px] leading-relaxed">
              Proibida a publicação de <strong class="text-on-surface">nomes completos</strong>, imagens identificáveis ou qualquer exposição degradante dos 93 alunos.
            </span>
          </li>
          <li class="flex items-start gap-1.5">
            <span class="material-symbols-outlined text-sm text-nutrition-green-dark mt-px shrink-0" data-icon="visibility_off">visibility_off</span>
            <span class="font-body-sm text-body-sm text-on-surface-variant text-[11px] leading-relaxed">
              Autorização de imagem é sempre <strong class="text-on-surface">informada e revogável</strong> pelo responsável legal.
            </span>
          </li>
          <li class="flex items-start gap-1.5">
            <span class="material-symbols-outlined text-sm text-nutrition-green-dark mt-px shrink-0" data-icon="policy">policy</span>
            <span class="font-body-sm text-body-sm text-on-surface-variant text-[11px] leading-relaxed">
              Canal de denúncia e proteção da infância disponível na Coordinação da IMNE.
            </span>
          </li>
        </ul>
        <p class="font-body-sm text-body-sm text-on-surface-variant text-[11px] leading-relaxed mt-2">
          <a href="/transparencia" class="text-primary font-semibold hover:underline">Política de Proteção Infantil completa</a>
        </p>
      </div>
    </div>
  </div>

  <!-- BARRA INFERIOR DO RODAPÉ -->
  <div class="border-t border-outline-variant/30">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
      <p class="font-body-sm text-body-sm text-on-surface-variant text-xs text-center sm:text-left">
        &copy; <?= date('Y') ?> Escola Cristã Nova Esperança · Kifangondo, Sequele · Ícolo e Bengo, Angola.
        Todos os direitos reservados à Igreja Missionária Nova Esperança (IMNE).
      </p>
      <a href="https://wa.me/244930561688?text=Ol%C3%A1,%20gostaria%20de%20falar%20com%20a%20Coordena%C3%A7%C3%A3o%20da%20Escola%20Nova%20Esperan%C3%A7a"
         target="_blank" rel="noopener"
         class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-nutrition-green text-white font-label-md text-label-md text-xs font-bold hover:bg-nutrition-green-dark active:scale-95 transition-all focus-visible:ring-2 focus-visible:ring-nutrition-green-dark focus-visible:outline-none focus:outline-none">
        <span class="material-symbols-outlined text-sm" data-icon="chat">chat</span>
        Coordenação no WhatsApp · +244 930 561 688
      </a>
    </div>
  </div>
</footer>
