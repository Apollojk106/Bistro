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
  <x-hotbar-user />

  <nav class="flex justify-center relative bg-[#2E2E2E] py-6">
    <a href="javascript:history.back()" class="absolute top-2 left-4 transition-transform transform hover:scale-110">
      <img src="{{ asset('Icons/btn-back.png') }}" alt="Voltar" class="w-8 h-8">
    </a>
  </nav>

  <main class="flex justify-center flex-1 items-start mt-8 w-full">
    <section class="w-full max-w-4xl px-4">

      @php
      // Garantir que os horários estão no formato HH:MM
      $horarioAbertura = \Carbon\Carbon::createFromFormat('H:i', $configuracoes['Horario de Funcionamento']['valores1'] ?? '09:00')->format('H:i');
      $horarioFechamento = \Carbon\Carbon::createFromFormat('H:i', $configuracoes['Horario de Funcionamento']['valores2'] ?? '21:00')->format('H:i');
      @endphp

      @if($configuracoes['Pedido'] === 'Desligado')
      <div class="text-center mt-10">
        <p class="text-lg font-semibold text-red-600">Pedidos estão desativados no momento.</p>
        <p class="text-sm text-gray-700">Por favor, volte mais tarde.</p>
        <p class="text-sm text-gray-700">Horário de atendimento: {{ $horarioAbertura }} - {{ $horarioFechamento }}</p>
      </div>
      @else
      <h2 class="text-center font-semibold text-2xl mb-6 transition-all duration-300 ease-in-out transform hover:scale-105">Opções de entrega</h2>

      <div class="flex justify-between mb-10 space-x-6">
        <button id="localBtn" class="flex-1 py-3 rounded-2xl border border-orange-400 text-orange-600 text-lg font-semibold bg-gray-200 hover:bg-orange-100 focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95">
          Local
        </button>
        @if($configuracoes['Delivery'] === 'Ligado')
        <button id="entregaBtn" class="flex-1 py-3 rounded-2xl border border-orange-400 text-gray-600 text-lg font-semibold bg-gray-300 hover:bg-orange-100 focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95" {{ $configuracoes['Delivery'] ? '' : 'disabled' }}>
          Entrega
        </button>
        @endif
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

          @if($configuracoes['Agendamento'] === 'Ligado')
          <!-- Bloco: Agendamento Local -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="toggleAgendamento()">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Agendamento</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="agendamentoCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
            <!-- Aviso (inicialmente oculto) -->
            <div id="avisoLocal" class="text-center text-sm text-gray-600 mt-4 hidden">
              A comida terá que ser agendada com pelo menos {{ $configuracoes["Tempo mínimo de Agendamento"] ?? "30" }} minutos de antecedência
            </div>
            <!-- Container do horário (inicialmente oculto) -->
            <div id="horarioLocalContainer" class="hidden mt-4">
              <label class="block text-center font-semibold text-gray-700">Horário</label>
              <input
                type="time"
                id="horarioLocalInput"
                class="w-full bg-gray-300 text-gray-700 rounded-lg px-3 py-2 text-sm font-semibold focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out"
                min="{{ $horarioAbertura }}"
                max="{{ $horarioFechamento }}"
                value="{{ $horarioAbertura }}">
            </div>
          </div>
          @endif
        </div>
      </div>

      @if($configuracoes['Delivery'] === 'Ligado')
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
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="selecionarOpcao('Agendamento')">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Agendamento</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="agendamentoEntregaCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
            <!-- Aviso (inicialmente oculto) -->
            <div id="avisoEntrega" class="text-center text-sm text-gray-600 mt-4 hidden">
              A comida terá que ser agendada com pelo menos {{ $configuracoes["Tempo mínimo de Agendamento"] ?? "30" }} minutos de antecedência
            </div>
            <!-- Container do horário (inicialmente oculto) -->
            <div id="horarioEntregaContainer" class="hidden mt-4">
              <label class="block text-center font-semibold text-gray-700">Horário</label>
              <input
                type="time"
                id="horarioEntregaInput"
                class="w-full bg-gray-300 text-gray-700 rounded-lg px-3 py-2 text-sm font-semibold focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out"
                min="{{ $horarioAbertura }}"
                max="{{ $horarioFechamento }}"
                value="{{ $horarioAbertura }}">
            </div>
          </div>
        </div>
      </div>
      @endif
      @endif
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
    });

    // Funções para alternar entre Local e Entrega
    document.getElementById('localBtn').addEventListener('click', () => {
      document.getElementById('localBtn').classList.add('bg-gray-200', 'text-orange-600');
      document.getElementById('localBtn').classList.remove('bg-gray-300', 'text-gray-600');
      document.getElementById('entregaBtn').classList.remove('bg-gray-200', 'text-orange-600');
      document.getElementById('entregaBtn').classList.add('bg-gray-300', 'text-gray-600');
      document.getElementById('localContent').classList.remove('hidden');
      document.getElementById('entregaContent').classList.add('hidden');
      tipoOpcao = 'Local';
    });

    document.getElementById('entregaBtn').addEventListener('click', () => {
      document.getElementById('entregaBtn').classList.add('bg-gray-200', 'text-orange-600');
      document.getElementById('entregaBtn').classList.remove('bg-gray-300', 'text-gray-600');
      document.getElementById('localBtn').classList.remove('bg-gray-200', 'text-orange-600');
      document.getElementById('localBtn').classList.add('bg-gray-300', 'text-gray-600');
      document.getElementById('localContent').classList.add('hidden');
      document.getElementById('entregaContent').classList.remove('hidden');
      tipoOpcao = 'Entrega';
    });

    // Funções para seleção de opções de entrega
    function selecionarOpcao(opcao) {
      opcaoSelecionada = opcao;
      const aviso = document.getElementById('avisoEntrega');
      const container = document.getElementById('horarioEntregaContainer');
      const agoraCheck = document.getElementById('agoraCheck');
      const agendamentoCheck = document.getElementById('agendamentoEntregaCheck');

      if (opcao === 'Agora') {
        agoraCheck.classList.remove('hidden');
        agendamentoCheck.classList.add('hidden');
        aviso.classList.add('hidden');
        container.classList.add('hidden');
      } else {
        agoraCheck.classList.add('hidden');
        agendamentoCheck.classList.remove('hidden');
        aviso.classList.remove('hidden');
        container.classList.remove('hidden');
      }
    }

    // Funções para seleção de opções de local
    function selectLocalOption(option) {
      opcaoLocalSelecionada = option;

      // Não esconder o agendamento se estiver ativo
      if (!agendamentoAtivoLocal) {
        document.getElementById('avisoLocal').classList.add('hidden');
        document.getElementById('horarioLocalContainer').classList.add('hidden');
        document.getElementById('agendamentoCheck').classList.add('hidden');
      }

      // Mostra o check correspondente
      ['terraco', 'retirada'].forEach(opt => document.getElementById(`${opt}Check`).classList.add('hidden'));

      if (option === 'Viagem') {
        document.getElementById('terracoCheck').classList.remove('hidden');
        // Se agendamento estiver ativo, mantém visível
        if (agendamentoAtivoLocal) {
          document.getElementById('agendamentoCheck').classList.remove('hidden');
        }
      } else if (option === 'Agora') {
        document.getElementById('retiradaCheck').classList.remove('hidden');
        // Se agendamento estiver ativo, mantém visível
        if (agendamentoAtivoLocal) {
          document.getElementById('agendamentoCheck').classList.remove('hidden');
        }
      }

      // Define a opção selecionada para envio
      opcaoSelecionada = option;
    }

    // Funções para agendamento no local
    function toggleAgendamento() {
      const aviso = document.getElementById('avisoLocal');
      const container = document.getElementById('horarioLocalContainer');
      const check = document.getElementById('agendamentoCheck');

      if (container.classList.contains('hidden')) {
        container.classList.remove('hidden');
        aviso.classList.remove('hidden');
        check.classList.remove('hidden');
        agendamentoAtivoLocal = true;

        // Desmarca outras opções locais
        document.getElementById('terracoCheck').classList.add('hidden');
        document.getElementById('retiradaCheck').classList.add('hidden');

        // Força a atualização da opção selecionada
        opcaoLocalSelecionada = 'Agendamento';
      } else {
        container.classList.add('hidden');
        aviso.classList.add('hidden');
        check.classList.add('hidden');
        agendamentoAtivoLocal = false;

        // Restaura a seleção padrão quando desativa o agendamento
        selectLocalOption('Agora');
      }
    }

    function validarSelecao() {
      // Validação básica - verifica se alguma opção foi selecionada
      if (tipoOpcao === 'Local') {
        if (!opcaoLocalSelecionada && !agendamentoAtivoLocal) {
          alert('Por favor, selecione uma opção de Local');
          return false;
        }
      } else if (tipoOpcao === 'Entrega' && !opcaoSelecionada) {
        alert('Por favor, selecione uma opção de Entrega');
        return false;
      }
      return true;
    }

    function enviarPedido() {
      if (!validarSelecao()) {
        return;
      }

      // Validar horário se for agendamento
      if ((tipoOpcao === 'Local' && agendamentoAtivoLocal) ||
        (tipoOpcao === 'Entrega' && opcaoSelecionada === 'Agendamento')) {

        let horarioInput = tipoOpcao === 'Local' ?
          document.getElementById('horarioLocalInput') :
          document.getElementById('horarioEntregaInput');

        let horarioSelecionado = horarioInput.value;
        const horarioAbertura = "{{ $configuracoes['Horario de Funcionamento']['valores1'] ?? '09:00' }}";
        const horarioFechamento = "{{ $configuracoes['Horario de Funcionamento']['valores2'] ?? '21:00' }}";
        const tempoMinimo = "{{ $configuracoes['Tempo mínimo de Agendamento'] ?? '00:45' }}";

        if (!horarioSelecionado) {
          alert('Por favor, selecione um horário para o agendamento');
          return;
        }

        // Função para converter HH:MM para minutos
        function timeToMinutes(time) {
          const [hours, minutes] = time.split(':').map(Number);
          return hours * 60 + minutes;
        }

        // Obter horário atual
        const agora = new Date();
        const horasAtual = agora.getHours().toString().padStart(2, '0');
        const minutosAtual = agora.getMinutes().toString().padStart(2, '0');
        const horarioAtual = `${horasAtual}:${minutosAtual}`;

        // Calcular horário mínimo permitido (atual + tempo mínimo)
        const minutosAtuais = timeToMinutes(horarioAtual);
        const [minH, minM] = tempoMinimo.split(':').map(Number);
        const tempoMinimoMinutos = minH * 60 + minM;
        const horarioMinimoMinutos = minutosAtuais + tempoMinimoMinutos;

        // Converter para HH:MM
        const horasMin = Math.floor(horarioMinimoMinutos / 60);
        const minutosMin = horarioMinimoMinutos % 60;
        const horarioMinimo = `${horasMin.toString().padStart(2, '0')}:${minutosMin.toString().padStart(2, '0')}`;

        // Verificar se o horário selecionado é válido
        const horarioSelecionadoMinutos = timeToMinutes(horarioSelecionado);
        const horarioAberturaMinutos = timeToMinutes(horarioAbertura);
        const horarioFechamentoMinutos = timeToMinutes(horarioFechamento);

        // 1. Verificar se está dentro do horário de funcionamento
        if (horarioSelecionadoMinutos < horarioAberturaMinutos ||
          horarioSelecionadoMinutos > horarioFechamentoMinutos) {
          alert(`O horário deve estar entre ${horarioAbertura} e ${horarioFechamento}`);
          return;
        }

        // 2. Verificar se não está no passado (considerando tempo mínimo)
        if (horarioSelecionadoMinutos < horarioMinimoMinutos) {
          alert(`O horário deve ser no mínimo ${horarioMinimo} (${tempoMinimo} após o horário atual)`);
          return;
        }

        // 3. Verificar se não é um horário já passado (redudante, mas segura)
        if (horarioSelecionadoMinutos < minutosAtuais) {
          alert('Não é possível agendar para um horário que já passou');
          return;
        }
      }

      // Restante do código para enviar o pedido...
      let opcaoParaEnvio = opcaoSelecionada;
      let horario = '';

      if (tipoOpcao === 'Local' && agendamentoAtivoLocal) {
        opcaoParaEnvio = opcaoLocalSelecionada;
        horario = document.getElementById('horarioLocalInput').value;
      } else if (tipoOpcao === 'Entrega' && opcaoSelecionada === 'Agendamento') {
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