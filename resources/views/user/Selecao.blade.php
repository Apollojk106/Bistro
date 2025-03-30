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
    <section class="w-full max-w-4xl px-4"> <!-- Aumentei o max-width para telas maiores -->
      <h2 class="text-center font-semibold text-2xl mb-6 transition-all duration-300 ease-in-out transform hover:scale-105">Opções de entrega</h2>

      <div class="flex justify-between mb-10 space-x-6">
        <button id="localBtn" class="flex-1 py-3 rounded-2xl border border-orange-400 text-orange-600 text-lg font-semibold bg-gray-200 hover:bg-orange-100 focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95">
          Local
        </button>
        <button id="entregaBtn" class="flex-1 py-3 rounded-2xl border border-orange-400 text-gray-600 text-lg font-semibold bg-gray-300 hover:bg-orange-100 focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105 active:scale-95">
          Entrega
        </button>
      </div>

      <!-- Conteúdo do Local (inicialmente visível) -->
      <div id="localContent">
        <div class="space-y-6">
          <!-- Bloco: No terraço -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="selectLocalOption('terraco')">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">No terraço</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="terracoCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
          </div>

          <!-- Bloco: Retirada -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="selectLocalOption('retirada')">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Retirada</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="retiradaCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
          </div>

          <!-- Bloco: Agendamento -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="toggleAgendamento()">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Agendamento</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="agendamentoCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>

            <!-- Seção de Agendamento (inicialmente oculta) -->
            <div id="agendamentoSection" class="hidden mt-4 space-y-4 border border-orange-400 rounded-xl p-4">
              <div class="flex items-center justify-between">
                <span class="text-lg font-medium">Horário</span>
                <input type="time" id="horarioInput" class="bg-gray-300 text-gray-700 rounded-lg px-3 py-1 text-sm font-semibold focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out">
              </div>
              <div class="space-y-4">
                <div class="flex justify-between items-center cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg" onclick="selectAgendamentoOption('terraco')">
                  <span class="text-lg font-medium">No terraço</span>
                  <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                    <img id="agendamentoTerracoCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
                  </div>
                </div>

                <div class="flex justify-between items-center cursor-pointer transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg" onclick="selectAgendamentoOption('retirada')">
                  <span class="text-lg font-medium">Retirada</span>
                  <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                    <img id="agendamentoRetiradaCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Conteúdo da Entrega (inicialmente oculto) -->
      <div id="entregaContent" class="hidden">
        <div class="space-y-6">
          <!-- Bloco: Peça agora -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="selecionarOpcao('agora')">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Peça agora</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="agoraCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>
          </div>

          <!-- Bloco: Agendamento -->
          <div class="border border-orange-400 rounded-2xl p-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="selecionarOpcao('agendamento')">
            <div class="flex justify-between items-center">
              <span class="text-lg font-medium">Agendamento</span>
              <div class="w-7 h-7 rounded-full border border-gray-500 flex items-center justify-center transition-colors duration-300 hover:bg-gray-200">
                <img id="agendamentoEntregaCheck" src="{{ asset('Icons/check-green.png') }}" alt="Selecionado" class="hidden w-5 h-5" />
              </div>
            </div>

            <!-- Aviso e horário (inicialmente oculto) -->
            <div id="aviso" class="text-center text-sm text-gray-600 mt-4 hidden">
              A comida terá que ser agendada com até 1 hora antes
            </div>
            <div id="horarioContainer" class="mt-4 hidden">
              <label class="block text-center font-semibold text-gray-700">Horário</label>
              <input type="time" id="horario" class="block mx-auto mt-2 border rounded-md px-3 py-1 text-gray-700 focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all duration-300 ease-in-out">
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
    // Funções para alternar entre Local e Entrega
    document.getElementById('localBtn').addEventListener('click', () => {
      document.getElementById('localBtn').classList.add('bg-gray-200', 'text-orange-600');
      document.getElementById('entregaBtn').classList.remove('bg-gray-200', 'text-orange-600');
      document.getElementById('entregaBtn').classList.add('bg-gray-300', 'text-gray-600');
      document.getElementById('localContent').classList.remove('hidden');
      document.getElementById('entregaContent').classList.add('hidden');
      tipoOpcao = 'local';
    });

    document.getElementById('entregaBtn').addEventListener('click', () => {
      document.getElementById('entregaBtn').classList.add('bg-gray-200', 'text-orange-600');
      document.getElementById('localBtn').classList.remove('bg-gray-200', 'text-orange-600');
      document.getElementById('localBtn').classList.add('bg-gray-300', 'text-gray-600');
      document.getElementById('localContent').classList.add('hidden');
      document.getElementById('entregaContent').classList.remove('hidden');
      tipoOpcao = 'entrega';
    });

    // Funções para seleção de opções de entrega
    function selecionarOpcao(opcao) {
      opcaoSelecionada = opcao;
      if (opcao === 'agora') {
        document.getElementById('agoraCheck').classList.remove('hidden');
        document.getElementById('agendamentoEntregaCheck').classList.add('hidden');
        document.getElementById('aviso').classList.add('hidden');
        document.getElementById('horarioContainer').classList.add('hidden');
      } else {
        document.getElementById('agoraCheck').classList.add('hidden');
        document.getElementById('agendamentoEntregaCheck').classList.remove('hidden');
        document.getElementById('aviso').classList.remove('hidden');
        document.getElementById('horarioContainer').classList.remove('hidden');
      }
    }

    // Funções para seleção de opções de local
    function selectLocalOption(option) {
      opcaoSelecionada = option;
      ['terraco', 'retirada'].forEach(opt => document.getElementById(`${opt}Check`).classList.add('hidden'));
      document.getElementById(`${option}Check`).classList.remove('hidden');
    }

    // Funções para agendamento no local
    function toggleAgendamento() {
      const agendamentoSection = document.getElementById('agendamentoSection');
      const agendamentoCheck = document.getElementById('agendamentoCheck');
      if (agendamentoCheck.classList.contains('hidden')) {
        agendamentoCheck.classList.remove('hidden');
        agendamentoSection.classList.remove('hidden');
        setMinHorario();
      } else {
        agendamentoCheck.classList.add('hidden');
        agendamentoSection.classList.add('hidden');
        ['agendamentoTerracoCheck', 'agendamentoRetiradaCheck'].forEach(opt => document.getElementById(opt).classList.add('hidden'));
      }
    }

    function selectAgendamentoOption(option) {
      ['agendamentoTerracoCheck', 'agendamentoRetiradaCheck'].forEach(opt => document.getElementById(opt).classList.add('hidden'));
      document.getElementById(`agendamento${option.charAt(0).toUpperCase() + option.slice(1)}Check`).classList.remove('hidden');
    }

    function setMinHorario() {
      const now = new Date();
      const hours = now.getHours();
      const minutes = now.getMinutes();

      if (hours >= 22) {
        horarioInput.disabled = true;
        horarioInput.value = '';
        alert('Agendamento não disponível após as 22:00.');
      } else {
        const minHours = hours.toString().padStart(2, '0');
        const minMinutes = minutes.toString().padStart(2, '0');
        horarioInput.min = `${minHours}:${minMinutes}`;
        horarioInput.value = `${minHours}:${minMinutes}`;
        horarioInput.max = "22:00";
        horarioInput.disabled = false;
      }
    }

    // Variáveis globais
    const btnContinuar = document.getElementById('continuarBtn');
    let opcaoSelecionada = '';
    let tipoOpcao = '';

    document.getElementById('continuarBtn').addEventListener('click', function handleClick() {
      if (validarSelecao()) {
        enviarPedido();
        // Remover o evento após o primeiro clique para evitar cliques múltiplos
        this.removeEventListener('click', handleClick);
      }
    });

    function enviarPedido() {
      btnContinuar.disabled = true;
      btnContinuar.textContent = 'Processando...';

      
     

      // Definindo a variável de horário, dependendo do tipo de opção e se é agendamento
      let horario = '';
      if (opcaoSelecionada === 'agendamento') {
        if (tipoOpcao === 'local') {
          horario = document.getElementById('horarioInput').value;
        } else if (tipoOpcao === 'entrega') {
          horario = document.getElementById('horario').value;
        }
      }


      // Exibindo o alerta com as informações, incluindo o horário, se for agendamento
      if (horario) {
        alert(`Opção Selecionada: ${opcaoSelecionada}\nTipo de Opção: ${tipoOpcao}\nHorário Agendado: ${horario}`);
      } else {
        window.location.href = `/${opcaoSelecionada}/${tipoOpcao}/Salvar/Selecao`;
      }
    }

    function validarSelecao() {
      console.log('validarSelecao chamada');
      if (!tipoOpcao) {
        alert('Por favor, selecione Local ou Entrega');
        return false;
      }

      if (!opcaoSelecionada) {
        alert('Por favor, selecione uma opção de ' + tipoOpcao);
        return false;
      }

      if (opcaoSelecionada === 'agendamento') {
        const horario = tipoOpcao === 'local' ?
          document.getElementById('horarioInput').value :
          document.getElementById('horario').value;

        if (!horario) {
          alert('Por favor, selecione um horário');
          return false;
        }
      }

      return true;
    }

    // Inicialização
    selectLocalOption('retirada');
  </script>
</body>

</html>