<!-- PÁGINA TRANSPARÊNCIA: AUDITORIA E CUSTOS (ESTILO STITCH) -->
<section class="rounded-2xl bg-surface-container-lowest p-5 border border-outline-variant/40 shadow-sm space-y-4">
  <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-nutrition-green/15 text-nutrition-green-dark font-label-sm text-xs font-semibold">
    <span class="material-symbols-outlined text-sm" data-icon="account_balance_wallet" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
    Prestação de Contas Aberta · 2026
  </div>

  <h1 class="font-headline-lg-mobile text-on-background font-extrabold text-2xl tracking-tight">
    Transparência Financeira e Aplicação de Recursos
  </h1>

  <p class="font-body-sm text-on-surface-variant text-sm leading-relaxed">
    Cada Kwanza doado à Escola Cristã Nova Esperança é gerido com integridade cristã e responsabilidade técnica pela Igreja Missionária Nova Esperança. Abaixo apresentamos o balancete analítico do 1º Semestre de 2026:
  </p>

  <!-- Indicadores Orçamentários Globais -->
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
    <div class="bg-surface-container/60 p-3 rounded-xl border border-outline-variant/20">
      <div class="text-[11px] text-on-surface-variant uppercase font-semibold">Receitas Totais</div>
      <div class="font-headline-sm text-primary font-extrabold text-base sm:text-lg mt-0.5">18.500.000 Kz</div>
      <div class="text-[10px] text-nutrition-green-dark font-semibold mt-0.5">100% captado</div>
    </div>

    <div class="bg-surface-container/60 p-3 rounded-xl border border-outline-variant/20">
      <div class="text-[11px] text-on-surface-variant uppercase font-semibold">Despesas Executadas</div>
      <div class="font-headline-sm text-secondary font-extrabold text-base sm:text-lg mt-0.5">15.850.000 Kz</div>
      <div class="text-[10px] text-on-surface-variant mt-0.5">Operação semestral</div>
    </div>

    <div class="bg-surface-container/60 p-3 rounded-xl border border-outline-variant/20">
      <div class="text-[11px] text-on-surface-variant uppercase font-semibold">Reserva Técnica</div>
      <div class="font-headline-sm text-hope-amber-dark font-extrabold text-base sm:text-lg mt-0.5">1.850.000 Kz</div>
      <div class="text-[10px] text-on-surface-variant mt-0.5">10% salvaguarda</div>
    </div>

    <div class="bg-surface-container/60 p-3 rounded-xl border border-outline-variant/20">
      <div class="text-[11px] text-on-surface-variant uppercase font-semibold">Saldo em Conta</div>
      <div class="font-headline-sm text-nutrition-green font-extrabold text-base sm:text-lg mt-0.5">800.000 Kz</div>
      <div class="text-[10px] text-on-surface-variant mt-0.5">Conta BAI ativa</div>
    </div>
  </div>
</section>

<!-- Decomposição da Merenda Escolar Diária -->
<section class="bg-surface-container-lowest border border-outline-variant/40 rounded-2xl p-5 shadow-sm space-y-4">
  <div class="flex items-center gap-2">
    <span class="material-symbols-outlined text-nutrition-green-dark text-2xl" data-icon="restaurant">restaurant</span>
    <div>
      <h2 class="font-headline-sm font-bold text-on-background text-lg">Custo Unitário da Merenda</h2>
      <p class="font-body-sm text-xs text-on-surface-variant">2.046 refeições servidas por mês para os 93 alunos matriculados</p>
    </div>
  </div>

  <div class="p-4 rounded-xl bg-nutrition-green/10 border border-nutrition-green/20 flex flex-col sm:flex-row justify-between sm:items-center gap-3">
    <div>
      <div class="text-xs text-nutrition-green-dark font-bold uppercase tracking-wider">Custo Diário por Criança</div>
      <div class="text-2xl font-black text-nutrition-green-dark font-headline-md mt-0.5">350,00 AOA <span class="text-xs font-normal text-on-surface-variant">/ refeição diária</span></div>
      <div class="text-xs text-on-surface-variant mt-0.5">Aproximadamente $0,42 USD por prato nutritivo completo.</div>
    </div>
    <div class="text-left sm:text-right text-xs text-on-surface-variant">
      <div><strong>716.100,00 AOA</strong> / mês consolidado</div>
      <div>Pão fresco matinal, sopa rica, arroz e feijão</div>
    </div>
  </div>
</section>

<!-- Termômetro de Obras das 6 Salas -->
<?= \NovaEsperanca\Core\View::partial('termometro-obras', $transparencia['fundo_obras_salas'] ?? []) ?>

<!-- Canais Oficiais e Download de Balancetes -->
<?= \NovaEsperanca\Core\View::partial('canais-apoio') ?>
