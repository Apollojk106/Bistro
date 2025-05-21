<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Seleção de Entrega</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">
  <script>
    // Configurações do estabelecimento vindo do banco de dados
    const configuracoes = {
      pedidoAtivo: {{ $configuracoes['Pedido'] ?? 0 }},
      agendamentoAtivo: {{ $configuracoes['Agendamento'] ?? 0 }},
      tempoMinimo: '{{ $configuracoes["Tempo mínimo de Agendamento"] ?? "00:30" }}',
      deliveryAtivo: {{ $configuracoes['Delivery'] ?? 0 }},
      distanciaMaxima: {{ $configuracoes['Distancia Máxima'] ?? 10 }},
      horarioInicio: '{{ $configuracoes["Horario de Funcionamento"]["valores1"] ?? "09:00" }}',
      horarioFim: '{{ $configuracoes["Horario de Funcionamento"]["valores2"] ?? "21:00" }}'
    };

    // Função auxiliar para adicionar minutos a um horário
    function adicionarMinutos(horario, minutos) {
      const [h, m] = horario.split(':').map(Number);
      const date = new Date();
      date.setHours(h, m + minutos, 0);
      return date.toTimeString().slice(0, 5);
    }

    // Função para formatar hora como HH:MM
    function formatarHora(date) {
      return date.toTimeString().slice(0, 5);
    }
  </script>

  <x-hotbar-user />

  <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
    <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
      <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
    </a>
  </nav>

  <main class="flex justify-center flex-1 items-start mt-8 w-full">
    <section class="w-full max-w-4xl px-4">
      <h2 class="text-center font-semibold text-2xl mb-6 transition-all duration-300 ease-in-out transform hover:scale-105">Opções de entrega</h2>

      <div class="flex justify-between mb-10 space-x-6">
        <button id="localBtn" class="flex-1 py-3 rounded-2xl border border-orange-400 text-orange-600 text-lg font-semibold bg-gray-200 hover:bg-orange-100 focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95">
          Local
        </button>
        <button id="entregaBtn" class="flex-1 py-3 rounded-2xl border border-orange-400 text-gray-600 text-lg font-semibold bg-gray-300 hover:bg-orange-100 focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95" {{ $configuracoes['Delivery'] ? '' : 'disabled' }}>
          Entrega
        </button>
      </div>

      <!-- Conteúdo do Local (inicialmente visível) -->
      <div id="localContent">
        <div class="space-y-6">
          <!-- Bloco: No terraço -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="selectLocalOption('Viagem')">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">No terraço</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="terracoCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
          </div>

          <!-- Bloco: Retirada -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="selectLocalOption('Agora')">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Retirada</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="retiradaCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
          </div>

          <!-- Bloco: Agendamento -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="configuracoes.agendamentoAtivo ? toggleAgendamento() : alert('Agendamento está desativado no momento');">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Agendamento</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="agendamentoCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
            @if(!$configuracoes['Agendamento'])
              <div class="text-center text-sm text-red-600 mt-2">Agendamento desativado no momento</div>
            @endif

            <!-- Seção de Agendamento (inicialmente oculta) -->
            <div id="agendamentoSection" class="hidden mt-4 space-y-4 border border-orange-400 rounded-xl p-4">
              <div class="flex items-center justify-between">
                <span class="text-lg font-medium">Horário</span>
                <input type="time" id="horarioLocalInput" class="bg-gray-300 text-gray-700 rounded-lg px-3 py-1 text-sm font-semibold focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Conteúdo da Entrega (inicialmente oculto) -->
      <div id="entregaContent" class="hidden">
        <div class="space-y-6">
          <!-- Bloco: Peça agora -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="selecionarOpcao('Agora')">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Peça agora</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="agoraCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
          </div>

          <!-- Bloco: Agendamento -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="configuracoes.agendamentoAtivo ? selecionarOpcao('Agendamento') : alert('Agendamento está desativado no momento');">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Agendamento</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="agendamentoEntregaCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
            @if(!$configuracoes['Agendamento'])
              <div class="text-center text-sm text-red-600 mt-2">Agendamento desativado no momento</div>
            @endif

            <!-- Aviso e horário (inicialmente oculto) -->
            <div id="aviso" class="text-center text-sm text-gray-600 mt-4 hidden">
              A comida terá que ser agendada com pelo menos {{ $configuracoes["Tempo mínimo de Agendamento"] ?? "30" }} minutos de antecedência
            </div>
            <div id="horarioContainer" class="mt-4">
              <label class="block text-center font-semibold text-gray-700">Horário</label>
              <input
                type="time"
                id="horarioEntregaInput"
                class="bg-gray-300 text-gray-700 rounded-lg px-3 py-1 text-sm font-semibold focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out"
                min="{{ $configuracoes["Horario de Funcionamento"]["valores1"] ?? "09:00" }}"
                max="{{ $configuracoes["Horario de Funcionamento"]["valores2"] ?? "21:00" }}">
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer com o botão "Continuar" -->
  <footer class="w-full mt-10">
    <div class="flex justify-between items-center bg-gray-300 rounded-t-xl py-4 px-6 mx-auto max-w-md transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg">
      <div>
        <span class="font-semibold text-lg">R$ {{ $Pedido['valor'] ?? '0,00' }}</span>
        <span class="text-sm text-gray-600 ml-2">{{ $Pedido['quantidade'] ?? '0' }} itens</span>
      </div>
      <button id="continuarBtn" type="button" class="bg-orange-800 text-white text-base font-medium px-6 py-3 rounded-2xl hover:bg-orange-700 transition-all duration-300 ease-in-out transform hover:scale-105" onclick="enviarPedido()">
        Continuar
      </button>
    </div>
  </footer>

  <script>
    // Variáveis globais
    const btnContinuar = document.getElementById('continuarBtn');
    let opcaoSelecionada = 'Agora'; // Valor padrão
    let tipoOpcao = 'Local'; // Valor padrão
    let opcaoLocalSelecionada = 'Agora'; // Armazena a opção de local selecionada (Viagem ou Agora)
    let agendamentoAtivoLocal = false; // Controla se o agendamento está ativo para local

    // Inicialização
    document.addEventListener('DOMContentLoaded', function() {
      selectLocalOption('Agora'); // Definir retirada como padrão
      
      // Desativa o botão de entrega se delivery estiver desligado
      if (!configuracoes.deliveryAtivo) {
        document.getElementById('entregaBtn').classList.add('opacity-50', 'cursor-not-allowed');
      }
    });

    // Funções para alternar entre Local e Entrega
    document.getElementById('localBtn').addEventListener('click', () => {
      if (!configuracoes.pedidoAtivo) {
        alert('Pedidos estão desativados no momento');
        return;
      }
      
      document.getElementById('localBtn').classList.add('bg-gray-200', 'text-orange-600');
      document.getElementById('entregaBtn').classList.remove('bg-gray-200', 'text-orange-600');
      document.getElementById('entregaBtn').classList.add('bg-gray-300', 'text-gray-600');
      document.getElementById('localContent').classList.remove('hidden');
      document.getElementById('entregaContent').classList.add('hidden');
      tipoOpcao = 'Local';
    });

    document.getElementById('entregaBtn').addEventListener('click', () => {
      if (!configuracoes.deliveryAtivo) {
        alert('Delivery está desativado no momento');
        return;
      }
      
      document.getElementById('entregaBtn').classList.add('bg-gray-200', 'text-orange-600');
      document.getElementById('localBtn').classList.remove('bg-gray-200', 'text-orange-600');
      document.getElementById('localBtn').classList.add('bg-gray-300', 'text-gray-600');
      document.getElementById('localContent').classList.add('hidden');
      document.getElementById('entregaContent').classList.remove('hidden');
      tipoOpcao = 'Entrega';
    });

    // Funções para seleção de opções de entrega
    function selecionarOpcao(opcao) {
      if (opcao === 'Agendamento' && !configuracoes.agendamentoAtivo) {
        alert('Agendamento está desativado no momento');
        return;
      }
      
      opcaoSelecionada = opcao;
      if (opcao === 'Agora') {
        document.getElementById('agoraCheck').classList.remove('hidden');
        document.getElementById('agendamentoEntregaCheck').classList.add('hidden');
        document.getElementById('aviso').classList.add('hidden');
        document.getElementById('horarioContainer').classList.add('hidden');
      } else {
        document.getElementById('agoraCheck').classList.add('hidden');
        document.getElementById('agendamentoEntregaCheck').classList.remove('hidden');
        document.getElementById('aviso').classList.remove('hidden');
        document.getElementById('horarioContainer').classList.remove('hidden');
        atualizarHorarioMinimo('horarioEntregaInput');
      }
    }

    // Funções para seleção de opções de local
    function selectLocalOption(option) {
      opcaoLocalSelecionada = option;
      agendamentoAtivoLocal = false;

      // Esconde a seção de agendamento se estiver visível
      document.getElementById('agendamentoSection').classList.add('hidden');
      document.getElementById('agendamentoCheck').classList.add('hidden');

      // Mostra o check correspondente
      ['terraco', 'retirada'].forEach(opt => document.getElementById(`${opt}Check`).classList.add('hidden'));

      if (option === 'Viagem') {
        document.getElementById('terracoCheck').classList.remove('hidden');
      } else if (option === 'Agora') {
        document.getElementById('retiradaCheck').classList.remove('hidden');
      }

      // Define a opção selecionada para envio
      opcaoSelecionada = option;
    }

    // Funções para agendamento no local
    function toggleAgendamento() {
      if (!configuracoes.agendamentoAtivo) {
        alert('Agendamento está desativado no momento');
        return;
      }
      
      const agendamentoSection = document.getElementById('agendamentoSection');
      const agendamentoCheck = document.getElementById('agendamentoCheck');

      if (agendamentoSection.classList.contains('hidden')) {
        // Ativar agendamento
        agendamentoSection.classList.remove('hidden');
        agendamentoCheck.classList.remove('hidden');
        agendamentoAtivoLocal = true;

        // Mantém a opção de local selecionada (Viagem ou Agora) visível
        if (opcaoLocalSelecionada === 'Viagem') {
          document.getElementById('terracoCheck').classList.remove('hidden');
        } else {
          document.getElementById('retiradaCheck').classList.remove('hidden');
        }

        atualizarHorarioMinimo('horarioLocalInput');
      } else {
        // Desativar agendamento
        agendamentoSection.classList.add('hidden');
        agendamentoCheck.classList.add('hidden');
        agendamentoAtivoLocal = false;

        // Volta para a opção de local selecionada
        selectLocalOption(opcaoLocalSelecionada);
      }
    }

    function atualizarHorarioMinimo(inputId) {
      const input = document.getElementById(inputId);
      const agora = new Date();
      
      // Converte o tempo mínimo (ex: "0:30") para minutos
      const [minH, minM] = configuracoes.tempoMinimo.split(':').map(Number);
      const tempoMinimoMinutos = minH * 60 + minM;
      
      agora.setMinutes(agora.getMinutes() + tempoMinimoMinutos);
      
      const horarioMinimo = formatarHora(agora);
      const horarioAbertura = configuracoes.horarioInicio;
      const horarioFechamento = configuracoes.horarioFim;

      // Verifica se o estabelecimento já fechou hoje
      if (horarioMinimo > horarioFechamento) {
        input.disabled = true;
        alert('Não é possível agendar para hoje, o estabelecimento já fechou.');
        return;
      }

      // Define o mínimo como o maior entre horário atual + tempo mínimo e horário de abertura
      const min = horarioMinimo < horarioAbertura ? horarioAbertura : horarioMinimo;
      
      input.min = min;
      input.max = horarioFechamento;
      input.value = min;
      input.disabled = false;
    }

    function validarHorarioAgendamento() {
      let inputHorario;
      
      if (tipoOpcao === 'Local' && agendamentoAtivoLocal) {
        inputHorario = document.getElementById('horarioLocalInput');
      } else if (tipoOpcao === 'Entrega' && opcaoSelecionada === 'Agendamento') {
        inputHorario = document.getElementById('horarioEntregaInput');
      } else {
        return true; // Não há agendamento para validar
      }

      if (inputHorario && inputHorario.disabled) {
        alert('Não é possível agendar para o horário selecionado. O estabelecimento está fechado.');
        return false;
      }

      if (inputHorario && !inputHorario.value) {
        alert('Por favor, selecione um horário para o agendamento');
        return false;
      }

      const horarioSelecionado = inputHorario.value;
      const horarioMinimo = inputHorario.min;
      const horarioMaximo = inputHorario.max;

      if (horarioSelecionado < horarioMinimo) {
        alert('O horário selecionado é muito cedo. Por favor, escolha um horário após ' + horarioMinimo);
        return false;
      }

      if (horarioSelecionado > horarioMaximo) {
        alert('O horário selecionado é após o fechamento. Por favor, escolha um horário antes de ' + horarioMaximo);
        return false;
      }

      return true;
    }

    function validarSelecao() {
      if (!configuracoes.pedidoAtivo) {
        alert('Pedidos estão desativados no momento');
        return false;
      }

      if (tipoOpcao === 'Entrega' && !configuracoes.deliveryAtivo) {
        alert('Delivery está desativado no momento');
        return false;
      }

      if (!tipoOpcao) {
        alert('Por favor, selecione Local ou Entrega');
        return false;
      }

      if (tipoOpcao === 'Local') {
        if (!opcaoLocalSelecionada && !agendamentoAtivoLocal) {
          alert('Por favor, selecione uma opção de Local');
          return false;
        }

        if (agendamentoAtivoLocal && !validarHorarioAgendamento()) {
          return false;
        }
      } else if (tipoOpcao === 'Entrega') {
        if (!opcaoSelecionada) {
          alert('Por favor, selecione uma opção de Entrega');
          return false;
        }

        if (opcaoSelecionada === 'Agendamento' && !validarHorarioAgendamento()) {
          return false;
        }
      }

      return true;
    }

    function enviarPedido() {
      if (!validarSelecao()) {
        return;
      }

      btnContinuar.disabled = true;
      btnContinuar.textContent = 'Processando...';

      let horario = '';
      let opcaoParaEnvio = opcaoSelecionada;

      // Se for Local e agendamento estiver ativo, mantemos a opção de local (Viagem/Agora) mas enviamos o horário
      if (tipoOpcao === 'Local' && agendamentoAtivoLocal) {
        opcaoParaEnvio = opcaoLocalSelecionada;
        horario = document.getElementById('horarioLocalInput').value;
      }
      // Se for Entrega e agendamento selecionado
      else if (tipoOpcao === 'Entrega' && opcaoSelecionada === 'Agendamento') {
        horario = document.getElementById('horarioEntregaInput').value;
      }

      let url = `/Salvar/Selecao/${opcaoParaEnvio}/${tipoOpcao}`;

      if (horario) {
        url += `/${encodeURIComponent(horario)}`;
      }

      window.location.href = url;
    }
  </script>
</body>

</html>