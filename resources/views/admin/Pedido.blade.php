<div>
    <x-hotbar-admin />

    <div class="flex h-auto text-center">

        <div class="flex flex-1 flex-col p-4">
            <div class="bg-[#A7C7E7] p-4 w-full h-min mt-1">
                Agendados
            </div>

            <div class="bg-[#A7C7E7] p-4 w-full mt-1">
                <p>Nome: Apollo</p> <!-- Mudei para <p> para garantir que o texto fique em uma linha nova -->


                <div class="flex space-x-4 justify-center">
                    <button class="bg-blue-500 text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                        <span>Imprimir</span> <img src="{{ asset('Icons/box.png') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                    </button>

                    <button class="bg-blue-500 text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                        <span>Avançar</span> <img src="{{ asset('Icons/arrow-left.png') }}" alt="Imagem Centralizada" class="h-5 w-5 object-contain" />
                    </button>
                </div>
            </div>
        </div>

        <div class="flex flex-1 flex-col p-4">
            <div class="p-4 w-full h-min bg-[#F2A97E]">
                Pedidos
            </div>
        </div>

        <div class="flex flex-1 flex-col  p-4">
            <div class="p-4 w-full h-min bg-[#F9E3A1]">
                Em andamento
            </div>
        </div>

    </div>

</div>