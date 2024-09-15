<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;
use App\Models\Categoria;

class ProdutoSeeder extends Seeder
{
    /**
     * Seed the application's database with products.
     */
    public function run(): void
    {
        // Verificando se as categorias existem, se não, cria elas
        $categoriaGeral = Categoria::firstOrCreate(['categoria' => 'Geral']);
        $categoriaEletronicos = Categoria::firstOrCreate(['categoria' => 'Eletrônicos']);
        $categoriaMoveis = Categoria::firstOrCreate(['categoria' => 'Móveis']);
        $categoriaEsportes = Categoria::firstOrCreate(['categoria' => 'Esportes']);
        $categoriaAutomotivo = Categoria::firstOrCreate(['categoria' => 'Automotivo']);

        // Definindo os produtos com nomes, valores e descrições diferentes
        $produtos = [
            // Produtos da categoria "Geral"
            ['nome' => 'Smartphone X', 'valor' => 1200, 'foto' => 'images/smartphone_x.jpg', 'descricao' => 'Smartphone de última geração com câmera de 48MP.', 'categoria_id' => $categoriaGeral->id],
            ['nome' => 'Laptop Pro', 'valor' => 2500, 'foto' => 'images/laptop_pro.jpg', 'descricao' => 'Laptop de alto desempenho para profissionais.', 'categoria_id' => $categoriaGeral->id],
            ['nome' => 'TV 4K', 'valor' => 1800, 'foto' => 'images/tv_4k.jpg', 'descricao' => 'Televisão 4K Ultra HD de 55 polegadas.', 'categoria_id' => $categoriaGeral->id],

            // Produtos da categoria "Eletrônicos"
            ['nome' => 'Fone de Ouvido', 'valor' => 200, 'foto' => 'images/fone_ouvido.jpg', 'descricao' => 'Fone de ouvido com cancelamento de ruído.', 'categoria_id' => $categoriaEletronicos->id],
            ['nome' => 'Relógio Inteligente', 'valor' => 350, 'foto' => 'images/relogio_inteligente.jpg', 'descricao' => 'Relógio inteligente com monitoramento de saúde.', 'categoria_id' => $categoriaEletronicos->id],
            ['nome' => 'Mouse Gamer', 'valor' => 150, 'foto' => 'images/mouse_gamer.jpg', 'descricao' => 'Mouse gamer com 6 botões programáveis.', 'categoria_id' => $categoriaEletronicos->id],

            // Produtos da categoria "Móveis"
            ['nome' => 'Cadeira de Escritório', 'valor' => 600, 'foto' => 'images/cadeira_escritorio.jpg', 'descricao' => 'Cadeira de escritório ergonômica.', 'categoria_id' => $categoriaMoveis->id],
            ['nome' => 'Mesa de Jantar', 'valor' => 1200, 'foto' => 'images/mesa_jantar.jpg', 'descricao' => 'Mesa de jantar de madeira para 6 pessoas.', 'categoria_id' => $categoriaMoveis->id],
            ['nome' => 'Sofá 3 Lugares', 'valor' => 2500, 'foto' => 'images/sofa_3_lugares.jpg', 'descricao' => 'Sofá de couro para sala de estar.', 'categoria_id' => $categoriaMoveis->id],

            // Produtos da categoria "Esportes"
            ['nome' => 'Bola de Futebol', 'valor' => 100, 'foto' => 'images/bola_futebol.jpg', 'descricao' => 'Bola de futebol oficial.', 'categoria_id' => $categoriaEsportes->id],
            ['nome' => 'Bicicleta Mountain Bike', 'valor' => 2200, 'foto' => 'images/bicicleta_mt.jpg', 'descricao' => 'Bicicleta para trilhas de mountain bike.', 'categoria_id' => $categoriaEsportes->id],
            ['nome' => 'Halteres', 'valor' => 300, 'foto' => 'images/halteres.jpg', 'descricao' => 'Par de halteres ajustáveis para musculação.', 'categoria_id' => $categoriaEsportes->id],

            // Produtos da categoria "Automotivo"
            ['nome' => 'Pneu para Carro', 'valor' => 400, 'foto' => 'images/pneu_carro.jpg', 'descricao' => 'Pneu radial para carros de passeio.', 'categoria_id' => $categoriaAutomotivo->id],
            ['nome' => 'Kit de Ferramentas Automotivas', 'valor' => 800, 'foto' => 'images/kit_ferramentas_auto.jpg', 'descricao' => 'Kit completo de ferramentas para manutenção automotiva.', 'categoria_id' => $categoriaAutomotivo->id],
            ['nome' => 'Câmera de Ré', 'valor' => 500, 'foto' => 'images/camera_re.jpg', 'descricao' => 'Câmera de ré para instalação em veículos.', 'categoria_id' => $categoriaAutomotivo->id],
        ];

        // Criando os produtos
        foreach ($produtos as $produto) {
            Produto::create([
                'nome' => $produto['nome'],
                'valor' => $produto['valor'],
                'foto' => $produto['foto'],
                'descricao' => $produto['descricao'],
                'categoria_id' => $produto['categoria_id'],
            ]);
        }
    }
}
