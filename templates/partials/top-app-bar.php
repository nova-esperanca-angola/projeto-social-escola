<?php
$currentRoute = $currentRoute ?? '/';

$navLinks = [
    ['href' => '/', 'label' => 'Início'],
    ['href' => '/sobre', 'label' => 'Sobre Nós'],
    ['href' => '/apadrinhe', 'label' => 'Apadrinhe'],
    ['href' => '/transparencia', 'label' => 'Transparência'],
    ['href' => '/galeria', 'label' => 'Galeria'],
    ['href' => '/voluntariado', 'label' => 'Voluntariado'],
];
?>
<!-- TOP APP BAR (Fiel ao Mockup Stitch · Mobile-First + Menu Desktop) -->
<header class="sticky top-0 z-40 bg-surface-container-low shadow-sm backdrop-blur-md bg-opacity-95 border-b border-outline-variant/30">
  <div class="flex justify-between items-center w-full px-3 sm:px-4 lg:px-6 h-16 max-w-screen-md md:max-w-5xl lg:max-w-7xl mx-auto gap-2 lg:gap-4">
    <a href="/" class="flex items-center gap-2.5 hover:opacity-90 transition-opacity min-w-[100px] sm:min-w-[110px] lg:min-w-[130px]">
      <img src="/assets/images/logo.jpeg" alt="Logotipo Escola Cristã Nova Esperança" class="h-9 sm:h-10 w-auto max-w-[100px] sm:max-w-[110px] lg:max-w-[130px] object-contain rounded-md shadow-sm border border-primary/20 bg-white p-0.5 shrink-0">
      <div class="flex md:hidden xl:flex flex-col min-w-0 justify-center">
        <span class="font-headline-sm text-headline-sm text-primary font-bold tracking-tight text-xs sm:text-base xl:text-sm truncate leading-snug">Escola Cristã Nova Esperança</span>
        <span class="flex xl:hidden font-label-sm text-label-sm text-on-surface-variant items-center gap-0.5 text-[10px] sm:text-xs truncate leading-snug mt-0.5">
          <span class="material-symbols-outlined text-[12px] sm:text-xs text-primary shrink-0" data-icon="location_on">location_on</span>
          <span class="truncate">Kifangondo, Sequele<span class="hidden sm:inline"> · Ícolo e Bengo, Angola</span></span>
        </span>
      </div>
    </a>

    <!-- MENU DE NAVEGAÇÃO HORIZONTAL DESKTOP (>= 768px) -->
    <nav aria-label="Navegação principal" class="hidden md:flex items-center gap-1 lg:gap-3 shrink-0">
      <?php foreach ($navLinks as $link): ?>
        <a href="<?= htmlspecialchars($link['href']) ?>"
           class="shrink-0 text-xs lg:text-sm px-1.5 lg:px-2 py-2 rounded-t-md whitespace-nowrap <?= $currentRoute === $link['href'] ? 'text-primary font-bold border-b-2 border-primary bg-primary/5' : 'text-on-surface-variant hover:text-primary transition-colors font-medium' ?>"
           <?= $currentRoute === $link['href'] ? 'aria-current="page"' : '' ?>><?= htmlspecialchars($link['label']) ?></a>
      <?php endforeach; ?>
    </nav>

    <div class="hidden sm:flex md:hidden xl:flex items-center shrink-0 ml-2 xl:ml-0">
      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-nutrition-green/10 text-nutrition-green-dark font-label-sm text-[11px] font-semibold whitespace-nowrap">
        <span class="material-symbols-outlined text-[13px]" data-icon="verified" style="font-variation-settings: 'FILL' 1;">verified</span>
        Impacto Verificado
      </span>
    </div>

    <!-- CTA DE AÇÃO PRIMÁRIA DESKTOP (>= 768px) -->
    <button type="button"
            onclick="abrirModalApadrinhamento('integral', 40000, 'Apadrinhamento Integral')"
            aria-label="Apadrinhar Agora"
            class="hidden md:inline-flex items-center justify-center gap-1.5 shrink-0 bg-primary hover:bg-primary-dark text-white font-bold px-3 py-2 rounded-lg shadow-sm active:scale-95 transition-all text-xs lg:text-sm whitespace-nowrap">
      <span class="material-symbols-outlined text-sm" data-icon="favorite" style="font-variation-settings: 'FILL' 1;">favorite</span>
      Apadrinhar Agora
    </button>
  </div>
</header>
