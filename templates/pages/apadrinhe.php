<!-- PÁGINA APADRINHE (ESTILO STITCH) -->
<section class="rounded-2xl bg-surface-container-lowest p-5 border border-outline-variant/40 shadow-sm space-y-3">
  <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed font-label-sm text-xs font-semibold">
    <span class="material-symbols-outlined text-sm" data-icon="handshake">handshake</span>
    Programa de Apadrinhamento Comunitário
  </div>

  <h1 class="font-headline-lg-mobile text-on-background font-extrabold text-2xl tracking-tight">
    Como Funciona o Apadrinhamento
  </h1>

  <p class="font-body-sm text-on-surface-variant text-sm leading-relaxed">
    O apadrinhamento da Escola Cristã Nova Esperança é estruturado em <strong>2 etapas transparentes e seguras</strong>, sem intermediários ou taxas administrativas ocultas:
  </p>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-xs">
    <div class="p-3.5 rounded-xl bg-surface-container/60 border border-outline-variant/30 flex gap-3">
      <div class="w-8 h-8 rounded-full bg-primary text-white font-bold flex items-center justify-center shrink-0">1</div>
      <div>
        <div class="font-bold text-on-background">Escolha da Cota & Valor</div>
        <div class="text-on-surface-variant mt-0.5">Selecione entre Nutricional, Didática, Apoio aos Educadores ou Apadrinhamento Integral.</div>
      </div>
    </div>

    <div class="p-3.5 rounded-xl bg-surface-container/60 border border-outline-variant/30 flex gap-3">
      <div class="w-8 h-8 rounded-full bg-nutrition-green text-white font-bold flex items-center justify-center shrink-0">2</div>
      <div>
        <div class="font-bold text-on-background">Identificação & Pagamento</div>
        <div class="text-on-surface-variant mt-0.5">Receba seu código exclusivo <span class="font-mono text-primary font-bold">NE-2026-XXXX</span> e envie o comprovativo direto via WhatsApp.</div>
      </div>
    </div>
  </div>
</section>

<!-- Planos de Apadrinhamento do Mockup Stitch -->
<?= \NovaEsperanca\Core\View::partial('planos-apadrinhamento') ?>

<!-- Canais Oficiais de Apoio -->
<?= \NovaEsperanca\Core\View::partial('canais-apoio') ?>
