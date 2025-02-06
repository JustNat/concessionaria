<div class='display-form'>
    <form method="POST" id='marca-form'>
        <label for="marca">Selecione a Marca:</label>
        <select name="id_marca" id="marca" onchange="this.form.submit()" required>
            <option value="">Selecione uma marca</option>
            <?php foreach ($marcas as $marca): ?>
                <option value="<?= htmlspecialchars($marca['id']); ?>" <?= ($marca['id'] == $id_marca_selecionada) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($marca['id']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <form action="" method="POST" id="cadastro-form">
        <input type="hidden" name="id_marca" value="<?= htmlspecialchars($id_marca_selecionada); ?>">
        <label for="modelo">Selecione o Modelo:</label>
        <select name="id_modelo" id="modelo" required>
            <option value="<?= htmlspecialchars($modelo['id']); ?>">Selecione um modelo</option>
            <?php foreach ($modelos as $modelo): ?>
                <option value="<? $modelo['id']; ?>">
                    <?= $modelo['nome'] . " " . $modelo['versao'] . " " . $modelo['ano']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="veicle-element">
            <div class="half-width">
                <label for="placa">Placa:</label>
                <input type="text" name="placa" id="placa" required>
            </div>
            <div class="half-width">
                <label for="km">Km Atual:</label>
                <input type="number" name="km" id="km" required>
            </div>
            <div class="checkbox-option">
                <label for="gnv">Possui GNV:</label>
                <input type="checkbox" name="gnv" id="gnv" value="1">
            </div>
        </div>

        <div class="veicle-element">
            <div class="half-width">
                <label for="cor">Cor:</label>
                <input type="text" name="cor" id="cor" placeholder="Digite a cor do veículo" required>
            </div>
            <div class="half-width">
                <label for="id_cidade">Cidade:</label>
                <select name="id_cidade" id="id_cidade" required>
                    <option value="">Selecione a cidade</option>
                    <?php foreach ($cidades as $cidade): ?>
                        <option value="<?= htmlspecialchars($cidade['id']); ?>"><?= htmlspecialchars($cidade['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="city-element">
            <div class="full-width">
                <label for="preco">Preço do veículo:</label>
                <input type="number" name="preco" id="preco" required>
            </div><br><br>
            <div class="full-width">
                <label for="telefone">Telefone (com DDD):</label>
                <input type="text" name="telefone" id="telefone" required>
            </div><br><br>
            <div class="full-width">
                <label for="foto">Foto do veículo (URL):</label>
                <input type="text" name="foto" id="foto" required>
            </div><br><br>
        </div>

        <div class="description-element">
            <div class="full-width">
                <label for="descricao">Descrição do Anúncio:</label><br>
                <textarea name="descricao" id="descricao" rows="4" cols="50" required></textarea>
            </div>
        </div><br><br>
        <button class="button-sellscars" type="submit">Cadastrar Anúncio</button>
    </form>
</div>