<!-- MODAL / DRAWER INTERATIVO DE APADRINHAMENTO EM 2 ETAPAS (WCAG 2.1 AA & ANTI-SPAM) -->
<div id="modal-apadrinhar" role="dialog" aria-modal="true" aria-labelledby="modal-titulo" aria-describedby="cota-desc" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/60 backdrop-blur-sm hidden transition-opacity">
  <div class="bg-surface-container-lowest w-full max-w-lg sm:max-w-xl rounded-t-3xl sm:rounded-2xl p-6 sm:p-8 shadow-2xl border border-outline-variant/30 space-y-4 max-h-[90vh] overflow-y-auto">
    
    <!-- Cabeçalho do Modal -->
    <div class="flex justify-between items-center border-b border-outline-variant/20 pb-3">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-primary text-2xl" data-icon="volunteer_activism">volunteer_activism</span>
        <h3 class="font-headline-sm font-bold text-on-background text-lg" id="modal-titulo">Apadrinhar Alunos</h3>
      </div>
      <button onclick="fecharModalApadrinhamento()" aria-label="Fechar janela de apadrinhamento" class="min-h-[48px] min-w-[48px] rounded-full flex items-center justify-center text-on-surface-variant hover:text-on-background hover:bg-surface-container transition-colors">
        <span class="material-symbols-outlined" data-icon="close">close</span>
      </button>
    </div>

    <!-- Etapa 1: Resumo do Plano Escolhido -->
    <div id="etapa-1" class="space-y-4">
      <div class="p-4 rounded-xl bg-surface-container/60 border border-outline-variant/20 flex justify-between items-center">
        <div>
          <span class="text-xs font-semibold text-primary font-label-sm uppercase tracking-wider" id="cota-badge">Cota Selecionada</span>
          <h4 class="font-bold text-on-background text-base" id="cota-nome">Cota Nutricional</h4>
          <p class="text-xs text-on-surface-variant" id="cota-desc">Merenda escolar diária balanceada para 1 aluno</p>
        </div>
        <div class="text-right">
          <div class="text-xl font-extrabold text-primary font-headline-md" id="cota-valor-display">12.500 Kz</div>
          <span class="text-xs text-on-surface-variant" id="cota-freq-display">/ mês</span>
        </div>
      </div>

      <!-- Frequência e Ajuste de Valor -->
      <div class="grid grid-cols-2 gap-2 text-xs font-semibold">
        <label for="input-frequencia" class="block space-y-1">
          <span class="text-on-surface-variant">Periodicidade:</span>
          <select id="input-frequencia" name="frequencia" class="w-full rounded-lg border border-outline-variant/50 p-2 bg-surface-container-lowest text-on-background text-xs min-h-[48px]">
            <option value="mensal">Mensal regular</option>
            <option value="trimestral">Trimestral</option>
            <option value="anual">Anual</option>
            <option value="pontual">Doação pontual</option>
          </select>
        </label>
        <label for="input-valor" class="block space-y-1">
          <span class="text-on-surface-variant">Valor em Kwanzas (AOA):</span>
          <input type="number" id="input-valor" name="valor_aoa" min="1000" step="500" value="12500" class="w-full rounded-lg border border-outline-variant/50 p-2 bg-surface-container-lowest text-on-background text-xs font-bold min-h-[48px]">
        </label>
      </div>

      <!-- Equivalência Internacional dinâmica (doadores de Portugal, Brasil, EUA e Europa) -->
      <div id="painel-conversao-cambial" class="rounded-xl bg-surface-container/60 border border-outline-variant/25 p-3 space-y-2">
        <div class="flex items-center justify-between gap-2 flex-wrap">
          <span class="text-[11px] font-bold text-on-background uppercase tracking-wider">Equivalência Internacional (informativa)</span>
          <span class="text-[10px] text-on-surface-variant font-semibold">1 USD ≈ 830 Kz · 1 EUR ≈ 900 Kz · 1 BRL ≈ 150 Kz</span>
        </div>
        <div class="grid grid-cols-3 gap-2 text-center">
          <div class="rounded-lg bg-surface-container-lowest border border-outline-variant/25 px-2 py-1.5">
            <div class="text-[10px] font-semibold text-on-surface-variant uppercase">USD</div>
            <div class="text-sm font-extrabold text-on-background font-mono" id="cota-valor-usd">$15</div>
          </div>
          <div class="rounded-lg bg-surface-container-lowest border border-outline-variant/25 px-2 py-1.5">
            <div class="text-[10px] font-semibold text-on-surface-variant uppercase">EUR</div>
            <div class="text-sm font-extrabold text-on-background font-mono" id="cota-valor-eur">€14</div>
          </div>
          <div class="rounded-lg bg-surface-container-lowest border border-outline-variant/25 px-2 py-1.5">
            <div class="text-[10px] font-semibold text-on-surface-variant uppercase">BRL</div>
            <div class="text-sm font-extrabold text-on-background font-mono" id="cota-valor-brl">R$ 80</div>
          </div>
        </div>
        <p class="text-[10px] text-on-surface-variant leading-snug">
          Referências aproximadas, sem garantia de câmbio. O Kwanza (AOA/Kz) é a moeda oficial de liquidação: o débito em moeda estrangeira é convertido pelo banco emissor do doador no momento do pagamento e pode variar face à referência acima.
        </p>
      </div>

      <button onclick="avancarParaEtapa2()" class="w-full min-h-[48px] bg-primary text-white rounded-lg font-label-md font-bold flex items-center justify-center gap-2 hover:bg-primary/90 transition-all shadow-md">
        Continuar para Identificação
        <span class="material-symbols-outlined text-lg" data-icon="arrow_forward">arrow_forward</span>
      </button>
    </div>

    <!-- Etapa 2: Dados do Padrinho & Conclusão com Proteção Anti-Spam -->
    <form id="form-apadrinhamento" onsubmit="submeterApadrinhamento(event)" class="space-y-3 hidden">
      
      <!-- CAMPO HONEYPOT INVISÍVEL (Armadilha para Robôs / WCAG aria-hidden) -->
      <div style="display:none !important; visibility:hidden !important; opacity:0 !important; position:absolute !important; left:-9999px !important;" aria-hidden="true">
        <label for="hp_confirm_field">Não preencha este campo de segurança:</label>
        <input type="text" id="hp_confirm_field" name="hp_confirm_field" tabindex="-1" autocomplete="off" value="">
      </div>

      <!-- CAMPO TIME-TRAP (Timestamp de Início do Formulário) -->
      <input type="hidden" id="form_start_time" name="form_start_time" value="">

      <div class="space-y-2.5 text-xs">
        <label for="input-nome" class="block space-y-1">
          <span class="text-on-surface font-semibold">Nome Completo do Padrinho / Mantenedor: *</span>
          <input type="text" id="input-nome" name="nome_padrinho" required placeholder="Ex: Manuel António Domingos" class="w-full rounded-lg border border-outline-variant/50 p-2.5 bg-surface-container-lowest text-on-background text-xs min-h-[48px]">
        </label>

        <label for="input-contato" class="block space-y-1">
          <span class="text-on-surface font-semibold">Telefone / WhatsApp para Confirmação: *</span>
          <input type="tel" id="input-contato" name="contato" required placeholder="Ex: +244 923 000 000" class="w-full rounded-lg border border-outline-variant/50 p-2.5 bg-surface-container-lowest text-on-background text-xs min-h-[48px]">
        </label>

        <label for="input-email" class="block space-y-1">
          <span class="text-on-surface font-semibold">E-mail (opcional, para envio de relatório):</span>
          <input type="email" id="input-email" name="email" placeholder="seuemail@exemplo.com" class="w-full rounded-lg border border-outline-variant/50 p-2.5 bg-surface-container-lowest text-on-background text-xs min-h-[48px]">
        </label>

        <label class="flex items-center gap-2 pt-1 text-on-surface-variant cursor-pointer min-h-[48px]">
          <input type="checkbox" id="input-anonimo" name="anonimo" class="rounded border-outline-variant text-primary focus:ring-primary h-5 w-5">
          <span class="text-xs">Desejo manter meu nome anônimo nos murais de gratidão</span>
        </label>

        <label for="input-mensagem" class="block space-y-1 pt-1">
          <span class="text-on-surface font-semibold">Mensagem de Encorajamento aos Alunos (opcional):</span>
          <textarea id="input-mensagem" name="mensagem" rows="2" placeholder="Deixe uma palavra para as crianças e educadoras de Kifangondo..." class="w-full rounded-lg border border-outline-variant/50 p-2 bg-surface-container-lowest text-on-background text-xs"></textarea>
        </label>
      </div>

      <div class="flex gap-2 pt-2">
        <button type="button" onclick="voltarParaEtapa1()" class="w-1/3 min-h-[48px] border border-outline-variant text-on-surface-variant rounded-lg font-label-md font-semibold text-xs hover:bg-surface-container transition-colors">
          Voltar
        </button>
        <button type="submit" id="btn-submit-doacao" class="w-2/3 min-h-[48px] bg-nutrition-green text-white rounded-lg font-label-md font-bold flex items-center justify-center gap-1.5 hover:bg-nutrition-green-dark transition-all text-xs shadow-md">
          <span class="material-symbols-outlined text-base" data-icon="check_circle">check_circle</span>
          Confirmar Apadrinhamento
        </button>
      </div>
    </form>

    <!-- Etapa 3 / Sucesso: Código Único e Dados Bancários -->
    <div id="etapa-sucesso" class="space-y-4 hidden text-center py-2">
      <div class="w-14 h-14 bg-nutrition-green/15 text-nutrition-green-dark rounded-full flex items-center justify-center mx-auto">
        <span class="material-symbols-outlined text-3xl" data-icon="done_all">done_all</span>
      </div>

      <div>
        <h4 class="font-headline-sm font-bold text-on-background text-lg">Intenção Registrada com Sucesso!</h4>
        <p class="text-xs text-on-surface-variant mt-1">
          Guarde seu código exclusivo de identificação e utilize-o na transferência:
        </p>
      </div>

      <div class="p-3 bg-surface-container rounded-xl border border-primary/30 inline-block px-6">
        <div class="text-xs text-on-surface-variant uppercase tracking-wider font-semibold">Código de Referência</div>
        <div class="text-2xl font-black text-primary font-mono tracking-wider mt-0.5" id="codigo-sucesso">NE-2026-XXXX</div>
      </div>

      <!-- Dados de Transferência Oficiais: canal local + canal internacional SWIFT/BIC -->
      <div class="text-left bg-surface-container-lowest p-3.5 rounded-xl border border-outline-variant/30 space-y-2.5 text-xs">
        <div class="font-bold text-on-background">Coordenadas Oficiais para Transferência:</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <!-- PAINEL 1: Canal Local (Angola) -->
          <div class="p-3 rounded-xl bg-surface-container/60 border border-primary/30 space-y-1.5">
            <div class="flex items-center gap-1.5 font-bold text-primary">
              <span class="material-symbols-outlined text-base" data-icon="smartphone">smartphone</span>
              Canal Local (Angola)
            </div>
            <div class="text-on-surface-variant"><strong class="text-on-background">Multicaixa Express:</strong> <span class="font-mono font-bold text-primary select-all">9305-61688</span></div>
            <div class="text-on-surface-variant"><strong class="text-on-background">Atlântico (IBAN):</strong> <span class="font-mono font-bold text-on-background select-all">0005-0000-5089-22202-1014-6</span></div>
            <div class="text-on-surface-variant"><strong class="text-on-background">BCI (IBAN):</strong> <span class="font-mono font-bold text-on-background select-all">0005-0000-6972-1564-1019-7</span></div>
            <div class="text-on-surface-variant"><strong class="text-on-background">Titular:</strong> Igreja Missionária Nova Esperança - Escola</div>
          </div>

          <!-- PAINEL 2: Canal Internacional (SWIFT / Remessa Exterior) -->
          <div class="p-3 rounded-xl bg-surface-container/60 border border-secondary/30 space-y-1.5">
            <div class="flex items-center gap-1.5 font-bold text-secondary">
              <span class="material-symbols-outlined text-base" data-icon="public">public</span>
              Canal Internacional (SWIFT / Remessa Exterior)
            </div>
            <div class="text-on-surface-variant"><strong class="text-on-background">Banco Atlântico:</strong> <span class="font-mono font-bold text-on-background select-all">BMAOAOLU</span></div>
            <div class="text-on-surface-variant pl-3"><strong>IBAN:</strong> <span class="font-mono font-bold text-on-background select-all">AO06 0005 0000 5089 2220 2101 4</span></div>
            <div class="text-on-surface-variant"><strong class="text-on-background">Banco BCI:</strong> <span class="font-mono font-bold text-on-background select-all">BCIDAOLU</span></div>
            <div class="text-on-surface-variant pl-3"><strong>IBAN:</strong> <span class="font-mono font-bold text-on-background select-all">AO06 0005 0000 6972 1564 1019 7</span></div>
            <div class="text-on-surface-variant"><strong class="text-on-background">Titular:</strong> Igreja Missionária Nova Esperança - Escola</div>
            <div class="text-on-surface-variant"><strong class="text-on-background">Descritivo:</strong> informe o código <span class="font-mono font-bold text-primary select-all">NE-2026-XXXX</span> da sua intenção.</div>
          </div>
        </div>
      </div>

      <div class="pt-2 flex flex-col gap-2">
        <a id="btn-whatsapp-comprovativo" href="#" target="_blank" class="w-full min-h-[48px] bg-nutrition-green text-white rounded-lg font-label-md font-bold text-xs flex items-center justify-center gap-1.5 shadow-md hover:bg-nutrition-green-dark transition-all">
          <span class="material-symbols-outlined text-base" data-icon="send">send</span>
          Enviar Comprovativo pelo WhatsApp
        </a>
        <button onclick="fecharModalApadrinhamento()" class="w-full min-h-[48px] text-on-surface-variant text-xs font-semibold hover:text-on-background">
          Fechar Janela
        </button>
      </div>
    </div>

  </div>
</div>
