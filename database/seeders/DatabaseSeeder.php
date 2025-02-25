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
            ['nome' => 'Cartão de Crédito', 'taxa' => 3.00, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Dinheiro', 'taxa' => 0.00, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'PIX', 'taxa' => 2.50, 'created_at' => now(), 'updated_at' => now()],
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
                'imagem' => 'almoco1.jpg',
                'nome' => 'Feijoada Completa',
                'descricao' => 'Feijão preto, carne de porco, arroz branco, farofa e couve',
                'valor' => 29.99,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Feijão preto, carne de porco, arroz, couve, farofa',
                'id_categoria' => 1, // Categoria "Almoço"
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'imagem' => 'almoco2.jpg',
                'nome' => 'Bife à Parmegiana',
                'descricao' => 'Bife empanado com queijo e molho de tomate, acompanhado de arroz e batata frita',
                'valor' => 24.50,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Carne bovina, queijo, molho de tomate, arroz, batata frita',
                'id_categoria' => 1, // Categoria "Almoço"
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'imagem' => 'complemento1.jpg',
                'nome' => 'Arroz de Brócolis',
                'descricao' => 'Arroz temperado com brócolis e alho',
                'valor' => 10.00,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Arroz, brócolis, alho, óleo',
                'id_categoria' => 2, // Categoria "Complemento"
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'imagem' => 'complemento2.jpg',
                'nome' => 'Batata Frita',
                'descricao' => 'Porção de batatas fritas crocantes',
                'valor' => 8.50,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Batata, óleo, sal',
                'id_categoria' => 2, // Categoria "Complemento"
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'imagem' => 'bebida1.jpg',
                'nome' => 'Suco de Laranja',
                'descricao' => 'Suco natural de laranja, fresco e sem aditivos',
                'valor' => 7.50,
                'desconto' => 0,
                'disponibilidade' => 'Todo dia',
                'ingredientes' => 'Laranja',
                'id_categoria' => 3, // Categoria "Bebida"
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Pedidos
        DB::table('Pedidos')->insert([
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
                'horario' => now(),
                'id_forma_pagamento' => 1, // Assumindo que já existe a forma de pagamento
                'descricao' => 'Pedido simples',
                'frete' => 5.00,
                'valor_total' => 50.00,
                'valor_taxa' => 5.00,
                'created_at' => now(),
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
                'horario' => now()->addHours(2), // Agendamento para 2 horas depois
                'id_forma_pagamento' => 2,
                'descricao' => 'Pedido com entrega programada',
                'frete' => 10.00,
                'valor_total' => 80.00,
                'valor_taxa' => 8.00,
                'created_at' => now(),
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
                'horario' => now(),
                'id_forma_pagamento' => 1,
                'descricao' => 'Pedido de almoço para consumo local',
                'frete' => 0.00,
                'valor_total' => 45.00,
                'valor_taxa' => 5.00,
                'created_at' => now(),
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
                'horario' => now(),
                'id_forma_pagamento' => 3, // Pagamento via cartão
                'descricao' => 'Pedido de café e sobremesa',
                'frete' => 5.50,
                'valor_total' => 35.00,
                'valor_taxa' => 3.50,
                'created_at' => now(),
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
                'horario' => now(),
                'id_forma_pagamento' => 1,
                'descricao' => 'Pedido de jantar com entrega imediata',
                'frete' => 7.00,
                'valor_total' => 100.00,
                'valor_taxa' => 10.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Itens dos Pedidos
        DB::table('Itens_pedidos')->insert([
            [
                'id_pedido' => 1, // Pedido de João Silva
                'id_cardapio' => 1, // Feijoada Completa
                'quantidade' => 1,
                'valor_unitario' => 29.99,
                'subtotal' => 29.99,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 2, // Pedido de Maria Oliveira
                'id_cardapio' => 2, // Pizza Margherita
                'quantidade' => 2,
                'valor_unitario' => 35.00,
                'subtotal' => 70.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 3, // Pedido de Carlos Souza
                'id_cardapio' => 3, // Prato Executivo
                'quantidade' => 1,
                'valor_unitario' => 45.00,
                'subtotal' => 45.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 4, // Pedido de Fernanda Costa
                'id_cardapio' => 4, // Café com Bolo
                'quantidade' => 1,
                'valor_unitario' => 20.00,
                'subtotal' => 20.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_pedido' => 5, // Pedido de Ricardo Almeida
                'id_cardapio' => 5, // Jantar Completo
                'quantidade' => 1,
                'valor_unitario' => 100.00,
                'subtotal' => 100.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}