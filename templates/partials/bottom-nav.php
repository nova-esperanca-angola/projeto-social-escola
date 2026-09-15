<?php
$current = $currentRoute ?? '/';
?>
<!-- BOTTOM NAVIGATION BAR (Fiel ao Mockup Stitch) -->
<nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-2 bg-surface-container-lowest shadow-lg border-t border-outline-variant/30 md:hidden">
  <!-- Início -->
  <a class="flex flex-col items-center justify-center <?= $current === '/' ? 'text-primary font-bold' : 'text-on-surface-variant' ?> px-3 py-1.5 active:scale-95 transition-all duration-150" href="/">
    <span class="material-symbols-outlined text-2xl" data-icon="home">home</span>
    <span class="font-label-sm text-label-sm mt-0.5 text-xs">Início</span>
  </a>

  <!-- Impacto -->
  <a class="flex flex-col items-center justify-center <?= $current === '/sobre' ? 'text-primary font-bold' : 'text-on-surface-variant' ?> px-3 py-1.5 active:scale-95 transition-all duration-150" href="/sobre">
    <span class="material-symbols-outlined text-2xl" data-icon="volunteer_activism">volunteer_activism</span>
    <span class="font-label-sm text-label-sm mt-0.5 text-xs">Impacto</span>
  </a>

  <!-- Apadrinhar (Destino Ativo com Pill de Destaque) -->
  <a class="flex flex-col items-center justify-center <?= $current === '/apadrinhe' ? 'bg-primary text-white shadow-md' : 'bg-primary-fixed text-on-primary-fixed' ?> rounded-full px-4 py-1.5 active:scale-95 transition-all duration-150 font-bold" href="/apadrinhe">
    <span class="material-symbols-outlined text-2xl" data-icon="favorite" style="font-variation-settings: 'FILL' 1;">favorite</span>
    <span class="font-label-sm text-label-sm mt-0.5 text-xs">Apadrinhar</span>
  </a>

  <!-- Obras / Transparência -->
  <a class="flex flex-col items-center justify-center <?= $current === '/transparencia' ? 'text-primary font-bold' : 'text-on-surface-variant' ?> px-3 py-1.5 active:scale-95 transition-all duration-150" href="/transparencia">
    <span class="material-symbols-outlined text-2xl" data-icon="foundation">foundation</span>
    <span class="font-label-sm text-label-sm mt-0.5 text-xs">Obras</span>
  </a>
</nav>
