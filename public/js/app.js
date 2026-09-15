/**
 * Aplicação Client-side Escola Nova Esperança (Kifangondo, Luanda)
 * Gerencia o fluxo do modal de apadrinhamento em 2 etapas e integração WhatsApp
 */

let cotaAtual = {
  tipo: 'nutricional',
  valor: 12500,
  nome: 'Cota Nutricional',
  frequencia: 'mensal'
};

function abrirModalApadrinhamento(tipo, valor, nome, freq = 'mensal') {
  cotaAtual.tipo = tipo;
  cotaAtual.valor = valor;
  cotaAtual.nome = nome;
  cotaAtual.frequencia = freq;

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

function avancarParaEtapa2() {
  const inputValor = document.getElementById('input-valor');
  const inputFreq = document.getElementById('input-frequencia');

  if (inputValor) cotaAtual.valor = parseFloat(inputValor.value) || 1000;
  if (inputFreq) cotaAtual.frequencia = inputFreq.value;

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
  if (btnSubmit) {
    btnSubmit.disabled = true;
    btnSubmit.textContent = 'Processando...';
  }

  const payload = {
    cota_tipo: cotaAtual.tipo,
    frequencia: cotaAtual.frequencia,
    valor_aoa: cotaAtual.valor,
    nome_padrinho: document.getElementById('input-nome')?.value || '',
    contato: document.getElementById('input-contato')?.value || '',
    email: document.getElementById('input-email')?.value || '',
    anonimo: document.getElementById('input-anonimo')?.checked || false,
    mensagem: document.getElementById('input-mensagem')?.value || ''
  };

  try {
    const response = await fetch('/api/apadrinhar', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(payload)
    });

    const data = await response.json();

    if (response.ok && data.success) {
      exibirSucesso(data.codigo_referencia, payload.nome_padrinho, payload.valor_aoa);
    } else {
      alert(data.mensagem || 'Ocorreu um erro ao registrar a intenção. Verifique os dados e tente novamente.');
    }
  } catch (err) {
    // Fallback de envio direto caso a API fetch falhe
    alert('Erro de conexão. Por favor, tente novamente ou contacte diretamente o WhatsApp da coordenação.');
  } finally {
    if (btnSubmit) {
      btnSubmit.disabled = false;
      btnSubmit.textContent = 'Confirmar Apadrinhamento';
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
    `Olá, Escola Nova Esperança! Registrei uma intenção de apadrinhamento no portal.\n\n` +
    `Código de Referência: ${codigoRef}\n` +
    `Nome: ${nomePadrinho}\n` +
    `Valor: ${Number(valorAoa).toLocaleString('pt-AO')} AOA\n\n` +
    `Segue o meu comprovativo de transferência bancária em anexo.`
  );

  if (btnWa) {
    btnWa.href = `https://wa.me/244923000000?text=${textoWhatsApp}`;
  }

  if (etapaSucesso) {
    etapaSucesso.classList.remove('hidden');
  }
}
