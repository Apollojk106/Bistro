<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pagamento
        DB::table('Formas_de_pagamento')->insert([
            ['nome' => 'cartao', 'taxa' => 3.00, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'dinheiro', 'taxa' => 0.00, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'pix', 'taxa' => 2.50, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Categoria
        DB::table('Categorias')->insert([
            ['nome' => 'Almoço', 'nivel' => 'Primaria', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Complemento', 'nivel' => 'Secundaria', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Bebida', 'nivel' => 'Terciaria', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Cardapio
        DB::table('Cardapios')->insert([
            [
                'imagem' => null,
                'nome' => 'Feijoada Completa',
                'descricao' => 'Feijão preto, carne de porco, arroz branco, farofa e couve',
                'valor' => 29.99,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Feijão preto, carne de porco, arroz, couve, farofa',
                'id_categoria' => 1, // Categoria "Almoço"
                'created_at' => "2025-03-11 00:46:14",
                'updated_at' => now()
            ],
            [
                'imagem' => null,
                'nome' => 'Bife à Parmegiana',
                'descricao' => 'Bife empanado com queijo e molho de tomate, acompanhado de arroz e batata frita',
                'valor' => 24.50,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Carne bovina, queijo, molho de tomate, arroz, batata frita',
                'id_categoria' => 1, // Categoria "Almoço"
                'created_at' => "2025-03-11 00:46:14",
                'updated_at' => now()
            ],
            [
                'imagem' => null,
                'nome' => 'Arroz de Brócolis',
                'descricao' => 'Arroz temperado com brócolis e alho',
                'valor' => 10.00,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Arroz, brócolis, alho, óleo',
                'id_categoria' => 2, // Categoria "Complemento"
                'created_at' => "2025-03-10 00:46:14",
                'updated_at' => now()
            ],
            [
                'imagem' => null,
                'nome' => 'Batata Frita',
                'descricao' => 'Porção de batatas fritas crocantes',
                'valor' => 8.50,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Batata, óleo, sal',
                'id_categoria' => 2, // Categoria "Complemento"
                'created_at' => "2025-03-10 00:46:14",
                'updated_at' => now()
            ],
            [
                'imagem' => null,
                'nome' => 'Suco de Laranja',
                'descricao' => 'Suco natural de laranja, fresco e sem aditivos',
                'valor' => 7.50,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Laranja',
                'id_categoria' => 3, // Categoria "Bebida"
                'created_at' => "2025-03-9 00:46:14",
                'updated_at' => now()
            ]
        ]);

        // Pedidos
        DB::table('Pedidos')->insert([
            [
                'nome' => 'Maria Oliveira',
                'email' => 'maria@email.com',
                'telefone' => '11988888888',
                'rua' => 'Avenida Paulista, 500',
                'bairro' => 'Bela Vista',
                'numero_residencia' => '500',
                'complemento' => 'Sala 12',
                'categoria_pedido' => 'Entrega',
                'status_pedido' => 'Pago',
                'opcao_entrega' => 'Agora',
                'status' => 'Concluído',
                'horario' => now(),
                'id_forma_pagamento' => 2,
                'descricao' => 'Pedido especial',
                'frete' => 7.00,
                'valor_total' => 80.00,
                'created_at' => "2025-03-10 00:46:14",
                'updated_at' => now()
            ],
            [
                'nome' => 'Carlos Souza',
                'email' => 'carlos@email.com',
                'telefone' => '11977777777',
                'rua' => 'Rua da Paz, 200',
                'bairro' => 'Jardins',
                'numero_residencia' => '200',
                'complemento' => 'Casa',
                'categoria_pedido' => 'Local',
                'status_pedido' => 'Pago',
                'opcao_entrega' => 'Agora',
                'status' => 'Concluído',
                'horario' => now(),
                'id_forma_pagamento' => 1,
                'descricao' => 'Pedido rápido',
                'frete' => 5.00,
                'valor_total' => 60.00,
                'created_at' => "2025-03-10 00:46:14",
                'updated_at' => now()
            ],
            [
                'nome' => 'Fernanda Lima',
                'email' => 'fernanda@email.com',
                'telefone' => '11966666666',
                'rua' => 'Rua do Sol, 15',
                'bairro' => 'Vila Mariana',
                'numero_residencia' => '15',
                'complemento' => 'Sobrado',
                'categoria_pedido' => 'Local',
                'status_pedido' => 'Pago',
                'opcao_entrega' => 'Agora',
                'status' => 'Concluído',
                'horario' => now(),
                'id_forma_pagamento' => 3,
                'descricao' => 'Pedido agendado',
                'frete' => 6.00,
                'valor_total' => 75.00,
                'created_at' => "2025-03-11 00:46:14",
                'updated_at' => now()
            ],
            [
                'nome' => 'Ricardo Mendes',
                'email' => 'ricardo@email.com',
                'telefone' => '11955555555',
                'rua' => 'Alameda Santos, 900',
                'bairro' => 'Paraíso',
                'numero_residencia' => '900',
                'complemento' => 'Bloco B',
                'categoria_pedido' => 'Entrega',
                'status_pedido' => 'Pago',
                'opcao_entrega' => 'Agora',
                'status' => 'Concluído',
                'horario' => now(),
                'id_forma_pagamento' => 2,
                'descricao' => 'Pedido premium',
                'frete' => 10.00,
                'valor_total' => 120.00,
                'created_at' => "2025-03-9 00:46:14",
                'updated_at' => now()
            ],
            [
                'nome' => 'Ana Clara',
                'email' => 'ana@email.com',
                'telefone' => '11944444444',
                'rua' => 'Rua das Palmeiras, 50',
                'bairro' => 'Moema',
                'numero_residencia' => '50',
                'complemento' => 'Apto 302',
                'categoria_pedido' => 'Local',
                'status_pedido' => 'Pago',
                'opcao_entrega' => 'Agora',
                'status' => 'Concluído',
                'horario' => now(),
                'id_forma_pagamento' => 1,
                'descricao' => 'Pedido gourmet',
                'frete' => 8.00,
                'valor_total' => 95.00,
                'created_at' => "2025-03-8 00:46:14",
                'updated_at' => now()
            ],
            [
                'nome' => 'João Silva',
                'email' => 'joao@email.com',
                'telefone' => '11999999999',
                'rua' => 'Rua das Flores, 123',
                'bairro' => 'Centro',
                'numero_residencia' => '123',
                'complemento' => 'Apto 101',
                'categoria_pedido' => 'Local',
                'status_pedido' => 'Pago',
                'opcao_entrega' => 'Agora',
                'status' => 'EmAndamento',
                'horario' => now(),
                'id_forma_pagamento' => 1, // Assumindo que já existe a forma de pagamento
                'descricao' => 'Pedido simples',
                'frete' => 5.00,
                'valor_total' => 50.00,
                'created_at' => "2025-02-10 00:46:14",
                'updated_at' => now()
            ],
            [
                'nome' => 'Maria Oliveira',
                'email' => 'maria@email.com',
                'telefone' => '11988888888',
                'rua' => 'Avenida Brasil, 456',
                'bairro' => 'Jardim das Pedras',
                'numero_residencia' => '456',
                'complemento' => 'Casa',
                'categoria_pedido' => 'Entrega',
                'status_pedido' => 'Pendente',
                'opcao_entrega' => 'Agendamento',
                'status' => 'Pendente',
                'horario' => now()->addHours(2),
                'id_forma_pagamento' => 2,
                'descricao' => 'Pedido com entrega programada',
                'frete' => 10.00,
                'valor_total' => 80.00,
                'created_at' => "2025-02-11 00:46:14",
                'updated_at' => now()
            ],
            [
                'nome' => 'Carlos Souza',
                'email' => 'carlos@email.com',
                'telefone' => '11977777777',
                'rua' => 'Rua dos Girassóis, 789',
                'bairro' => 'Vila Nova',
                'numero_residencia' => '789',
                'complemento' => 'Bloco B',
                'categoria_pedido' => 'Local',
                'status_pedido' => 'Pago',
                'opcao_entrega' => 'Agora',
                'status' => 'Pendente',
                'horario' => now(),
                'id_forma_pagamento' => 1,
                'descricao' => 'Pedido de almoço para consumo local',
                'frete' => 0.00,
                'valor_total' => 45.00,
                'created_at' => "2025-03-11 00:46:14",
                'updated_at' => now()
            ],
            [
                'nome' => 'Fernanda Costa',
                'email' => 'fernanda@email.com',
                'telefone' => '11966666666',
                'rua' => 'Rua das Acácias, 321',
                'bairro' => 'Centro Comercial',
                'numero_residencia' => '321',
                'complemento' => 'Loja 12',
                'categoria_pedido' => 'Local',
                'status_pedido' => 'Pendente',
                'opcao_entrega' => 'Viagem',
                'status' => 'Pendente',
                'horario' => now(),
                'id_forma_pagamento' => 3, // Pagamento via cartão
                'descricao' => 'Pedido de café e sobremesa',
                'frete' => 5.50,
                'valor_total' => 35.00,
                'created_at' => "2026-03-10 00:46:14",
                'updated_at' => now()
            ],
            [
                'nome' => 'Ricardo Almeida',
                'email' => 'ricardo@email.com',
                'telefone' => '11955555555',
                'rua' => 'Rua do Sol, 101',
                'bairro' => 'Zona Leste',
                'numero_residencia' => '101',
                'complemento' => 'Casa 15',
                'categoria_pedido' => 'Entrega',
                'status_pedido' => 'Pago',
                'opcao_entrega' => 'Agora',
                'status' => 'Pendente',
                'horario' => now(),
                'id_forma_pagamento' => 1,
                'descricao' => 'Pedido de jantar com entrega imediata',
                'frete' => 7.00,
                'valor_total' => 100.00,
                'created_at' => "2026-02-10 00:46:14",
                'updated_at' => now()
            ]
        ]);

        // Itens dos Pedidos
        DB::table('Itens_pedidos')->insert([
            // Pedido 1: João Silva (1 item)
            [
                'id_pedido' => 1,
                'id_cardapio' => 1, // Feijoada Completa
                'quantidade' => 1,
                'valor_unitario' => 29.99,
                'subtotal' => 29.99,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pedido 2: Maria Oliveira (2 itens)
            [
                'id_pedido' => 2,
                'id_cardapio' => 2, // Bife à Parmegiana
                'quantidade' => 1,
                'valor_unitario' => 24.50,
                'subtotal' => 24.50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 2,
                'id_cardapio' => 5, // Suco de Laranja
                'quantidade' => 2,
                'valor_unitario' => 7.50,
                'subtotal' => 15.00,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pedido 3: Carlos Souza (1 item)
            [
                'id_pedido' => 3,
                'id_cardapio' => 3, // Arroz de Brócolis
                'quantidade' => 1,
                'valor_unitario' => 10.00,
                'subtotal' => 10.00,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pedido 4: Fernanda Lima (2 itens)
            [
                'id_pedido' => 4,
                'id_cardapio' => 4, // Batata Frita
                'quantidade' => 1,
                'valor_unitario' => 8.50,
                'subtotal' => 8.50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 4,
                'id_cardapio' => 5, // Suco de Laranja
                'quantidade' => 1,
                'valor_unitario' => 7.50,
                'subtotal' => 7.50,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pedido 5: Ricardo Mendes (1 item)
            [
                'id_pedido' => 5,
                'id_cardapio' => 1, // Feijoada Completa
                'quantidade' => 1,
                'valor_unitario' => 29.99,
                'subtotal' => 29.99,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pedido 6: Ana Clara (2 itens)
            [
                'id_pedido' => 6,
                'id_cardapio' => 2, // Bife à Parmegiana
                'quantidade' => 1,
                'valor_unitario' => 24.50,
                'subtotal' => 24.50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 6,
                'id_cardapio' => 3, // Arroz de Brócolis
                'quantidade' => 1,
                'valor_unitario' => 10.00,
                'subtotal' => 10.00,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pedido 7: Maria Oliveira (1 item)
            [
                'id_pedido' => 7,
                'id_cardapio' => 4, // Batata Frita
                'quantidade' => 1,
                'valor_unitario' => 8.50,
                'subtotal' => 8.50,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pedido 8: Carlos Souza (2 itens)
            [
                'id_pedido' => 8,
                'id_cardapio' => 1, // Feijoada Completa
                'quantidade' => 1,
                'valor_unitario' => 29.99,
                'subtotal' => 29.99,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 8,
                'id_cardapio' => 5, // Suco de Laranja
                'quantidade' => 1,
                'valor_unitario' => 7.50,
                'subtotal' => 7.50,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pedido 9: Fernanda Costa (1 item)
            [
                'id_pedido' => 9,
                'id_cardapio' => 2, // Bife à Parmegiana
                'quantidade' => 1,
                'valor_unitario' => 24.50,
                'subtotal' => 24.50,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pedido 10: Ricardo Almeida (2 itens)
            [
                'id_pedido' => 10,
                'id_cardapio' => 3, // Arroz de Brócolis
                'quantidade' => 1,
                'valor_unitario' => 10.00,
                'subtotal' => 10.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 10,
                'id_cardapio' => 4, // Batata Frita
                'quantidade' => 1,
                'valor_unitario' => 8.50,
                'subtotal' => 8.50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 10,
                'id_cardapio' => 5, // Suco de Laranja
                'quantidade' => 1,
                'valor_unitario' => 7.50,
                'subtotal' => 7.50,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        DB::table('Configuracoes')->insert([
            [
                'nome' => 'Pedido',
                'status' => true,
                'valores1' => 'Ligado',
                'conector' => null,
                'valores2' => null,
                'type' => '1',
            ],
            [
                'nome' => 'Agendamento',
                'status' => true,
                'valores1' => 'Ligado',
                'conector' => null,
                'valores2' => null,
                'type' => '1',
            ],
            [
                'nome' => 'Tempo minimo de Agendamento',
                'status' => true,
                'valores1' => '0:30',
                'conector' => 'horas',
                'valores2' => null,
                'type' => '2',
            ],
            [
                'nome' => 'Delivery',
                'status' => true,
                'valores1' => 'Ligado',
                'conector' => null,
                'valores2' => null,
                'type' => '1',
            ],
            [
                'nome' => 'Distancia Máxima',
                'status' => true,
                'valores1' => '10',
                'conector' => 'Km',
                'valores2' => null,
                'type' => '2',
            ],
            [
                'nome' => 'Horario de Funcionamento ',
                'status' => true,
                'valores1' => '9:00',
                'conector' => 'Horas',
                'valores2' => '21:00',
                'type' => '3',
            ]
        ]);

        DB::table('Users')->insert([
            [
                'nome' => 'Fabio',
                'email' => 'Fabio@email.com',
                'telefone' => '11911112222',
                'senha' => bcrypt('senha123.abc123'), 
                'salt' => 'abc123',
                'cep' => '01001000',
                'rua' => 'Rua do Calote',
                'bairro' => 'Centro',
                'numero_residencia' => '100',
                'complemento' => 'Apto 101',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // Criar usuários caloteiros
        DB::table('Users')->insert([
            [
                'nome' => 'João Caloteiro',
                'apelido' => 'João',
                'email' => 'joao.caloteiro@email.com',
                'telefone' => '11911112222',
                'senha' => 'senha123',
                'salt' => 'abc123',
                'cep' => '01001000',
                'rua' => 'Rua do Calote',
                'bairro' => 'Centro',
                'numero_residencia' => '100',
                'complemento' => 'Apto 101',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Maria Devedora',
                'apelido' => 'Maria',
                'email' => 'maria.devedora@email.com',
                'telefone' => '11922223333',
                'senha' => 'senha123',
                'salt' => 'def456',
                'cep' => '02002000',
                'rua' => 'Avenida do Débito',
                'bairro' => 'Vila Madalena',
                'numero_residencia' => '200',
                'complemento' => 'Casa 2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nome' => 'Carlos Negativado',
                'apelido' => 'Carlos',
                'email' => 'carlos.negativado@email.com',
                'telefone' => '11933334444',
                'senha' => 'senha123',
                'salt' => 'ghi789',
                'cep' => '03003000',
                'rua' => 'Travessa da Inadimplência',
                'bairro' => 'Jardins',
                'numero_residencia' => '300',
                'complemento' => 'Sala 3',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        DB::table('Pedidos')->insert([
            [
                'nome' => 'João Caloteiro',
                'email' => 'joao.caloteiro@email.com',
                'telefone' => '11911112222',
                'rua' => 'Rua do Calote',
                'bairro' => 'Centro',
                'numero_residencia' => '100',
                'complemento' => 'Apto 101',
                'categoria_pedido' => 'Entrega',
                'status_pedido' => 'Pendente',
                'opcao_entrega' => 'Agora',
                'status' => 'Pendente',
                'horario' => now()->subDays(10),
                'id_forma_pagamento' => 1, // Cartão
                'descricao' => 'Pedido grande não pago',
                'frete' => 15.00,
                'valor_total' => 350.00,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'nome' => 'João Caloteiro',
                'email' => 'joao.caloteiro@email.com',
                'telefone' => '11911112222',
                'rua' => 'Rua do Calote',
                'bairro' => 'Centro',
                'numero_residencia' => '100',
                'complemento' => 'Apto 101',
                'categoria_pedido' => 'Local',
                'status_pedido' => 'Pendente',
                'opcao_entrega' => 'Viagem',
                'status' => 'Pendente',
                'horario' => now()->subDays(5),
                'id_forma_pagamento' => 1, // Cartão
                'descricao' => 'Outro pedido não pago',
                'frete' => 0.00,
                'valor_total' => 120.00,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],

            // Pedidos para Maria Devedora (saldo negativo moderado)
            [
                'nome' => 'Maria Devedora',
                'email' => 'maria.devedora@email.com',
                'telefone' => '11922223333',
                'rua' => 'Avenida do Débito',
                'bairro' => 'Vila Madalena',
                'numero_residencia' => '200',
                'complemento' => 'Casa 2',
                'categoria_pedido' => 'Entrega',
                'status_pedido' => 'Pendente',
                'opcao_entrega' => 'Agora',
                'status' => 'Pendente',
                'horario' => now()->subDays(7),
                'id_forma_pagamento' => 2, // Dinheiro
                'descricao' => 'Pedido em atraso',
                'frete' => 10.00,
                'valor_total' => 180.00,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7)
            ],

            // Pedidos para Carlos Negativado (saldo levemente negativo)
            [
                'nome' => 'Carlos Negativado',
                'email' => 'carlos.negativado@email.com',
                'telefone' => '11933334444',
                'rua' => 'Travessa da Inadimplência',
                'bairro' => 'Jardins',
                'numero_residencia' => '300',
                'complemento' => 'Sala 3',
                'categoria_pedido' => 'Local',
                'status_pedido' => 'Pendente',
                'opcao_entrega' => 'Agora',
                'status' => 'Pendente',
                'horario' => now()->subDays(3),
                'id_forma_pagamento' => 3, // Pix
                'descricao' => 'Pedido pequeno não pago',
                'frete' => 0.00,
                'valor_total' => 85.50,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3)
            ]
        ]);

        DB::table('Itens_pedidos')->insert([
            [
                'id_pedido' => DB::table('Pedidos')->where('email', 'joao.caloteiro@email.com')->first()->id,
                'id_cardapio' => 1, // Feijoada Completa
                'quantidade' => 5,
                'valor_unitario' => 29.99,
                'subtotal' => 149.95,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'id_pedido' => DB::table('Pedidos')->where('email', 'joao.caloteiro@email.com')->first()->id,
                'id_cardapio' => 5, // Suco de Laranja
                'quantidade' => 5,
                'valor_unitario' => 7.50,
                'subtotal' => 37.50,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'id_pedido' => DB::table('Pedidos')->where('email', 'joao.caloteiro@email.com')->skip(1)->first()->id,
                'id_cardapio' => 2, // Bife à Parmegiana
                'quantidade' => 3,
                'valor_unitario' => 24.50,
                'subtotal' => 73.50,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],
            [
                'id_pedido' => DB::table('Pedidos')->where('email', 'maria.devedora@email.com')->first()->id,
                'id_cardapio' => 1, // Feijoada Completa
                'quantidade' => 2,
                'valor_unitario' => 29.99,
                'subtotal' => 59.98,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7)
            ],
            [
                'id_pedido' => DB::table('Pedidos')->where('email', 'maria.devedora@email.com')->first()->id,
                'id_cardapio' => 3, // Arroz de Brócolis
                'quantidade' => 2,
                'valor_unitario' => 10.00,
                'subtotal' => 20.00,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7)
            ],
            [
                'id_pedido' => DB::table('Pedidos')->where('email', 'carlos.negativado@email.com')->first()->id,
                'id_cardapio' => 2, // Bife à Parmegiana
                'quantidade' => 1,
                'valor_unitario' => 24.50,
                'subtotal' => 24.50,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3)
            ],
            [
                'id_pedido' => DB::table('Pedidos')->where('email', 'carlos.negativado@email.com')->first()->id,
                'id_cardapio' => 4, // Batata Frita
                'quantidade' => 1,
                'valor_unitario' => 8.50,
                'subtotal' => 8.50,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3)
            ]
        ]);
    }
}
