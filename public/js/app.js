/**
 * Aplicação Client-side Escola Nova Esperança (Kifangondo, Luanda)
 * Gerencia o modal de apadrinhamento, proteção Anti-Spam (Time-Trap/Honeypot) e acessibilidade (Escape key)
 */

let cotaAtual = {
  tipo: 'nutricional',
  valor: 12500,
  nome: 'Cota Nutricional',
  frequencia: 'mensal'
};

let modalSessionStartTime = 0;

/**
 * Taxas cambiais informativas de referência (Issue #12):
 * 1 USD ≈ 830 AOA | 1 EUR ≈ 900 AOA | 1 BRL ≈ 150 AOA
 * O Kwanza (AOA/Kz) é a moeda oficial de liquidação; a conversão é apenas
 * uma estimativa exibida para doadores internacionais.
 */
const TAXAS_CAMBIAIS_REFERENCIA = {
  USD: 830,
  EUR: 900,
  BRL: 150
};

const SIMBOLOS_CAMBIAIS = {
  USD: '$',
  EUR: '€',
  BRL: 'R$'
};

/** Atualiza as equivalências EUR/USD/BRL da Etapa 1 a partir do valor em Kwanzas. */
function atualizarConversaoCambial(valorAoa) {
  const valor = Number(valorAoa) || 0;

  const campoUsd = document.getElementById('cota-valor-usd');
  const campoEur = document.getElementById('cota-valor-eur');
  const campoBrl = document.getElementById('cota-valor-brl');

  if (campoUsd) {
    campoUsd.textContent = SIMBOLOS_CAMBIAIS.USD + ' ' + Math.round(valor / TAXAS_CAMBIAIS_REFERENCIA.USD).toLocaleString('pt-AO');
  }
  if (campoEur) {
    campoEur.textContent = SIMBOLOS_CAMBIAIS.EUR + ' ' + Math.round(valor / TAXAS_CAMBIAIS_REFERENCIA.EUR).toLocaleString('pt-AO');
  }
  if (campoBrl) {
    campoBrl.textContent = SIMBOLOS_CAMBIAIS.BRL + ' ' + Math.round(valor / TAXAS_CAMBIAIS_REFERENCIA.BRL).toLocaleString('pt-AO');
  }
}

// Recalcula as equivalências cambiais sempre que o doador ajusta o valor da cota
document.addEventListener('DOMContentLoaded', function() {
  const inputValor = document.getElementById('input-valor');
  if (inputValor) {
    inputValor.addEventListener('input', function() {
      atualizarConversaoCambial(inputValor.value);
    });
  }
});

function abrirModalApadrinhamento(tipo, valor, nome, freq = 'mensal') {
  cotaAtual.tipo = tipo;
  cotaAtual.valor = valor;
  cotaAtual.nome = nome;
  cotaAtual.frequencia = freq;

  // Marcação do timestamp para validação do time-trap anti-spam (em segundos)
  modalSessionStartTime = Math.floor(Date.now() / 1000);
  const timeTrapEl = document.getElementById('form_start_time');
  if (timeTrapEl) {
    timeTrapEl.value = modalSessionStartTime;
  }

  const modal = document.getElementById('modal-apadrinhar');
  const nomeEl = document.getElementById('cota-nome');
  const valorDisplayEl = document.getElementById('cota-valor-display');
  const valorInputEl = document.getElementById('input-valor');
  const freqInputEl = document.getElementById('input-frequencia');
  const freqDisplayEl = document.getElementById('cota-freq-display');

  if (nomeEl) nomeEl.textContent = nome;
  if (valorDisplayEl) valorDisplayEl.textContent = Number(valor).toLocaleString('pt-AO') + ' Kz';
  if (valorInputEl) valorInputEl.value = valor;
  if (freqInputEl) freqInputEl.value = freq;
  if (freqDisplayEl) freqDisplayEl.textContent = freq === 'pontual' ? 'cota única' : '/ ' + freq;

  // Equivalência internacional estimada para a cota recém-selecionada
  atualizarConversaoCambial(valor);

  // Limpar campo honeypot
  const hpField = document.getElementById('hp_confirm_field');
  if (hpField) hpField.value = '';

  // Restaurar etapa 1
  document.getElementById('etapa-1')?.classList.remove('hidden');
  document.getElementById('form-apadrinhamento')?.classList.add('hidden');
  document.getElementById('etapa-sucesso')?.classList.add('hidden');

  if (modal) {
    modal.classList.remove('hidden');
  }
}

function fecharModalApadrinhamento() {
  const modal = document.getElementById('modal-apadrinhar');
  if (modal) {
    modal.classList.add('hidden');
  }
}

// Acessibilidade: Fechar modal ao pressionar a tecla Escape
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape' || event.keyCode === 27) {
    fecharModalApadrinhamento();
  }
});

function avancarParaEtapa2() {
  const inputValor = document.getElementById('input-valor');
  const inputFreq = document.getElementById('input-frequencia');

  if (inputValor) cotaAtual.valor = parseFloat(inputValor.value) || 1000;
  if (inputFreq) cotaAtual.frequencia = inputFreq.value;

  // Garante que as equivalências exibidas correspondem ao valor confirmado
  atualizarConversaoCambial(cotaAtual.valor);

  document.getElementById('etapa-1')?.classList.add('hidden');
  document.getElementById('form-apadrinhamento')?.classList.remove('hidden');
  document.getElementById('input-nome')?.focus();
}

function voltarParaEtapa1() {
  document.getElementById('form-apadrinhamento')?.classList.add('hidden');
  document.getElementById('etapa-1')?.classList.remove('hidden');
}

async function submeterApadrinhamento(event) {
  event.preventDefault();
  const btnSubmit = document.getElementById('btn-submit-doacao');
  const textoOriginal = btnSubmit ? btnSubmit.innerHTML : 'Confirmar Apadrinhamento';

  if (btnSubmit) {
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = `
      <span class="inline-block animate-spin mr-1">⌛</span>
      Processando apadrinhamento...
    `;
  }

  const payload = {
    cota_tipo: cotaAtual.tipo,
    frequencia: cotaAtual.frequencia,
    valor_aoa: cotaAtual.valor,
    nome_padrinho: document.getElementById('input-nome')?.value || '',
    contato: document.getElementById('input-contato')?.value || '',
    email: document.getElementById('input-email')?.value || '',
    anonimo: document.getElementById('input-anonimo')?.checked || false,
    mensagem: document.getElementById('input-mensagem')?.value || '',
    hp_confirm_field: document.getElementById('hp_confirm_field')?.value || '',
    form_start_time: modalSessionStartTime || Math.floor(Date.now() / 1000)
  };

  try {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 12000); // 12s timeout para redes 3G lentas

    const response = await fetch('/api/apadrinhar', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(payload),
      signal: controller.signal
    });

    clearTimeout(timeoutId);
    const data = await response.json();

    if (response.ok && data.success) {
      exibirSucesso(data.codigo_referencia, payload.nome_padrinho, payload.valor_aoa);
    } else {
      alert(data.mensagem || 'Ocorreu um erro ao registrar a intenção. Verifique os dados e tente novamente.');
    }
  } catch (err) {
    if (err.name === 'AbortError') {
      alert('A conexão demorou mais que o esperado devido à lentidão da rede móvel. Por favor, tente novamente ou envie o comprovativo direto pelo WhatsApp.');
    } else {
      alert('Erro de conexão. Por favor, tente novamente ou contacte diretamente o WhatsApp da coordenação.');
    }
  } finally {
    if (btnSubmit) {
      btnSubmit.disabled = false;
      btnSubmit.innerHTML = textoOriginal;
    }
  }
}

function exibirSucesso(codigoRef, nomePadrinho, valorAoa) {
  document.getElementById('form-apadrinhamento')?.classList.add('hidden');
  const etapaSucesso = document.getElementById('etapa-sucesso');
  const codigoEl = document.getElementById('codigo-sucesso');
  const btnWa = document.getElementById('btn-whatsapp-comprovativo');

  if (codigoEl) codigoEl.textContent = codigoRef;

  const textoWhatsApp = encodeURIComponent(
    `Olá, Escola Cristã Nova Esperança! Registrei uma intenção de apadrinhamento no portal.\n\n` +
    `Código de Referência: ${codigoRef}\n` +
    `Nome: ${nomePadrinho}\n` +
    `Valor: ${Number(valorAoa).toLocaleString('pt-AO')} AOA\n\n` +
    `Segue o meu comprovativo de transferência bancária em anexo.`
  );

  if (btnWa) {
    btnWa.href = `https://wa.me/244930561688?text=${textoWhatsApp}`;
  }

  if (etapaSucesso) {
    etapaSucesso.classList.remove('hidden');
  }
}
