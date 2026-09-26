<?php
$custos       = $custos ?? [];
$transparencia = $transparencia ?? [];

$execucao   = $custos['execucao_semestral'] ?? [];
$merenda    = $custos['detalhamento_merenda'] ?? [];
$obras      = $custos['fundo_obras_detalhado'] ?? [];
$composicao = $custos['fundo_obras_detalhado']['composicao_custos'] ?? [];
$itensMerenda = $merenda['itens_principais'] ?? [];

$formatarAoa = static function ($valor, int $decimais = 0): string {
    return number_format((float)$valor, $decimais, ',', '.');
};
?>
<!-- PAGINA TRANSPARENCIA: PAINEL EXECUTIVO E TABELA ORCAMENTARIA (ISSUE #11) -->
<section id="prestacao-contas" class="scroll-mt-20 space-y-6">
  <div class="rounded-2xl bg-surface-container-lowest p-5 md:p-6 border border-outline-variant/40 shadow-sm space-y-3">
    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-nutrition-green/15 text-nutrition-green-dark font-label-sm text-xs font-semibold">
      <span class="material-symbols-outlined text-sm" data-icon="account_balance_wallet" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
      Prestação de Contas Aberta · <?= htmlspecialchars((string)($custos['ano_exercicio'] ?? '2026'), ENT_QUOTES, 'UTF-8') ?>
    </div>

    <h1 class="font-headline-lg-mobile text-on-background font-extrabold text-2xl tracking-tight">
      Transparência Financeira e Aplicação de Recursos
    </h1>

    <p class="font-body-sm text-on-surface-variant text-sm leading-relaxed">
      Cada Kwanza doado à Escola Cristã Nova Esperança é gerido com integridade cristã e responsabilidade técnica
      pela Igreja Missionária Nova Esperança, em consonância com a Lei nº 25/12 da República de Angola.
      Abaixo apresentamos o balancete analítico do <?= htmlspecialchars((string)($custos['periodo'] ?? '1º Semestre de 2026'), ENT_QUOTES, 'UTF-8') ?>:
    </p>
  </div>

  <!-- PAINEL EXECUTIVO BI-COLUNAR -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
    <!-- COLUNA 7: Balanco Anual Operacional -->
    <div class="lg:col-span-7 rounded-2xl bg-surface-container-lowest border border-outline-variant/40 p-5 md:p-6 shadow-sm space-y-4">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-primary text-2xl" data-icon="query_stats">query_stats</span>
        <div>
          <h2 class="font-headline-sm font-bold text-on-background text-lg">Balanço Anual Operacional</h2>
          <p class="font-body-sm text-xs text-on-surface-variant">Receitas, despesas e reservas do exercício</p>
        </div>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-surface-container/60 p-3 rounded-xl border border-outline-variant/20">
          <div class="text-[11px] text-on-surface-variant uppercase font-semibold">Receitas Totais</div>
          <div class="font-headline-sm text-primary font-extrabold text-base sm:text-lg mt-0.5">
            <?= $formatarAoa($execucao['receita_total_aoa'] ?? 0) ?> Kz
          </div>
          <div class="text-[10px] text-nutrition-green-dark font-semibold mt-0.5">100% captado</div>
        </div>

        <div class="bg-surface-container/60 p-3 rounded-xl border border-outline-variant/20">
          <div class="text-[11px] text-on-surface-variant uppercase font-semibold">Despesas Executadas</div>
          <div class="font-headline-sm text-secondary font-extrabold text-base sm:text-lg mt-0.5">
            <?= $formatarAoa($execucao['despesa_total_aoa'] ?? 0) ?> Kz
          </div>
          <div class="text-[10px] text-on-surface-variant mt-0.5">Operação semestral</div>
        </div>

        <div class="bg-surface-container/60 p-3 rounded-xl border border-outline-variant/20">
          <div class="text-[11px] text-on-surface-variant uppercase font-semibold">Reserva Técnica</div>
          <div class="font-headline-sm text-hope-amber-dark font-extrabold text-base sm:text-lg mt-0.5">
            <?= $formatarAoa($execucao['reserva_tecnica_aoa'] ?? 0) ?> Kz
          </div>
          <div class="text-[10px] text-on-surface-variant mt-0.5">10% salvaguarda</div>
        </div>

        <div class="bg-surface-container/60 p-3 rounded-xl border border-outline-variant/20">
          <div class="text-[11px] text-on-surface-variant uppercase font-semibold">Saldo em Conta</div>
          <div class="font-headline-sm text-nutrition-green font-extrabold text-base sm:text-lg mt-0.5">
            <?= $formatarAoa($execucao['saldo_operacional_aoa'] ?? 0) ?> Kz
          </div>
          <div class="text-[10px] text-on-surface-variant mt-0.5">Conta BAI ativa</div>
        </div>
      </div>
    </div>

    <!-- COLUNA 5: Decomposicao da Merenda Escolar Diaria -->
    <div class="lg:col-span-5 rounded-2xl bg-surface-container-lowest border border-outline-variant/40 p-5 md:p-6 shadow-sm space-y-3">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-nutrition-green-dark text-2xl" data-icon="restaurant">restaurant</span>
        <div>
          <h2 class="font-headline-sm font-bold text-on-background text-lg">Custo Unitário da Merenda</h2>
          <p class="font-body-sm text-xs text-on-surface-variant">
            <?= $formatarAoa($merenda['refeicoes_servidas_mes'] ?? 0) ?> refeições servidas por mês para os 93 alunos matriculados
          </p>
        </div>
      </div>

      <div class="p-4 rounded-xl bg-nutrition-green/10 border border-nutrition-green/20 space-y-1">
        <div class="text-xs text-nutrition-green-dark font-bold uppercase tracking-wider">Custo Diário por Criança</div>
        <div class="text-2xl font-black text-nutrition-green-dark font-headline-md">
          <?= $formatarAoa($merenda['custo_refeicao_diaria_aluno_aoa'] ?? 0, 2) ?> AOA
          <span class="text-xs font-normal text-on-surface-variant">/ refeição diária</span>
        </div>
        <div class="text-xs text-on-surface-variant">
          <strong><?= $formatarAoa($merenda['custo_mensal_total_aoa'] ?? 0, 2) ?> AOA</strong> / mês consolidado
        </div>
      </div>

      <ul class="space-y-1.5">
        <?php foreach ($itensMerenda as $item) { ?>
          <li class="flex items-start justify-between gap-2 text-[11px] text-on-surface-variant border-b border-outline-variant/20 pb-1.5 last:border-0">
            <span>
              <strong class="text-on-background"><?= htmlspecialchars((string)($item['categoria'] ?? ''), ENT_QUOTES, 'UTF-8') ?>:</strong>
              <?= htmlspecialchars((string)($item['item'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
            </span>
            <span class="shrink-0 font-semibold text-nutrition-green-dark"><?= $formatarAoa($item['custo_aoa'] ?? 0) ?></span>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <!-- ORCAMENTO DETALHADO DAS 8 NOVAS SALAS -->
  <div class="space-y-3">
    <div class="flex items-center gap-2 px-1">
      <span class="material-symbols-outlined text-secondary text-2xl" data-icon="foundation">foundation</span>
      <div>
        <h2 class="font-headline-sm font-bold text-on-background text-lg">Orçamento Detalhado das 8 Novas Salas</h2>
        <p class="font-body-sm text-xs text-on-surface-variant">
          Composição de custos por etapa construtiva · total orçado de
          <?= $formatarAoa($obras['orcamento_total_aoa'] ?? 0) ?> AOA
        </p>
      </div>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-outline-variant/40 bg-surface-container-lowest p-5 md:p-6 shadow-sm">
    <table class="min-w-[550px] w-full border-collapse text-left text-xs">
      <caption class="sr-only">Composição do orçamento de construção das 8 novas salas por etapa construtiva</caption>
      <thead>
        <tr class="border-b-2 border-outline-variant/60">
          <th scope="col" class="py-2.5 pr-3 font-label-md text-[11px] uppercase tracking-wider text-on-surface-variant">Etapa Construtiva</th>
          <th scope="col" class="py-2.5 pr-3 font-label-md text-[11px] uppercase tracking-wider text-on-surface-variant">Descrição Técnica</th>
          <th scope="col" class="py-2.5 text-right font-label-md text-[11px] uppercase tracking-wider text-on-surface-variant">Valor Orçado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($composicao as $etapa) { ?>
          <tr class="border-b border-outline-variant/20 align-top">
            <td class="py-3 pr-3 font-semibold text-on-background"><?= htmlspecialchars((string)($etapa['etapa'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td class="py-3 pr-3 text-on-surface-variant"><?= htmlspecialchars((string)($etapa['descricao'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td class="py-3 text-right font-semibold text-primary"><?= $formatarAoa($etapa['valor_estimado_aoa'] ?? 0) ?> AOA</td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="border-t-2 border-outline-variant/60 bg-surface-container/50">
          <td colspan="2" class="py-3 pr-3 font-bold text-on-background">Total Orçado</td>
          <td class="py-3 text-right font-extrabold text-primary"><?= $formatarAoa($obras['orcamento_total_aoa'] ?? 0) ?> AOA</td>
        </tr>
      </tfoot>
    </table>
    </div>
  </div>
  <!-- TERMOMETRO DE OBRAS DAS 8 SALAS -->
  <?= \NovaEsperanca\Core\View::partial('termometro-obras', $transparencia['fundo_obras_salas'] ?? []) ?>

  <!-- CANAIS OFICIAIS E DOWNLOAD DE BALANCETES -->
  <?= \NovaEsperanca\Core\View::partial('canais-apoio') ?>
</section>
