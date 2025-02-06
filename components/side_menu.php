<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <h2>Filtros</h2>
    </div>

    <!-- Filtro de KM -->
    <div class="km-filter">
        <label for="km-range">Km: <span id="km-label">0</span> km</label>
        <input type="range" id="km-range-bar" name="km" min="0" max="100000" step="1000" value="<?php echo isset($_GET['km']) ? $_GET['km'] : '100000'; ?>">
        <div class="bottomText">
            <span id="km-value"><?php echo isset($_GET['km']) ? $_GET['km'] : '0'; ?> km</span>
            <span id="km-value">100k km</span>
        </div>
    </div>

    <!-- Pesquisar preço mínimo e máximo -->
    <div class="search-bar">
        <label for="price-search">Preço</label>
        <div>
            <input type="text" name="min-price" id="min-price-search" placeholder="Menor Preço..." value="<?php echo isset($_GET['min-price']) ? $_GET['min-price'] : ''; ?>">
            <input type="text" name="max-price" id="max-price-search" placeholder="Maior Preço..." value="<?php echo isset($_GET['max-price']) ? $_GET['max-price'] : ''; ?>">
        </div>
    </div>

    <!-- Filtro de Combustível -->
    <div class="fuel-filter">
        <label for="fuel-type">Combustível:</label>
        <select name="fuel" id="fuel-type">
            <option value="all-fuel" <?php echo isset($_GET['fuel']) && $_GET['fuel'] == 'all-fuel' ? 'selected' : ''; ?>>Todos</option>
            <option value="g" <?php echo isset($_GET['fuel']) && $_GET['fuel'] == 'g' ? 'selected' : ''; ?>>Gasolina</option>
            <option value="a" <?php echo isset($_GET['fuel']) && $_GET['fuel'] == 'a' ? 'selected' : ''; ?>>Álcool</option>
            <option value="d" <?php echo isset($_GET['fuel']) && $_GET['fuel'] == 'd' ? 'selected' : ''; ?>>Diesel</option>
            <option value="e" <?php echo isset($_GET['fuel']) && $_GET['fuel'] == 'e' ? 'selected' : ''; ?>>Elétrico</option>
            <option value="h" <?php echo isset($_GET['fuel']) && $_GET['fuel'] == 'h' ? 'selected' : ''; ?>>Híbrido</option>
            <option value="f" <?php echo isset($_GET['fuel']) && $_GET['fuel'] == 'f' ? 'selected' : ''; ?>>Flex</option>
        </select>
    </div>

    <!-- Filtro de Câmbio -->
    <div class="fuel-filter">
        <label for="gear-type">Câmbio:</label>
        <select name="gear" id="gear-type">
            <option value="all-gear" <?php echo isset($_GET['gear']) && $_GET['gear'] == 'all-gear' ? 'selected' : ''; ?>>Todos</option>
            <option value="g" <?php echo isset($_GET['gear']) && $_GET['gear'] == 'g' ? 'selected' : ''; ?>>Manual</option>
            <option value="a" <?php echo isset($_GET['gear']) && $_GET['gear'] == 'a' ? 'selected' : ''; ?>>Automático</option>
            <option value="d" <?php echo isset($_GET['gear']) && $_GET['gear'] == 'd' ? 'selected' : ''; ?>>Elétrico</option>
        </select>
    </div>

    <!-- Filtro de GNV -->
    <div class="gnv-filter">
        <label for="gnv">Possui GNV:</label>
        <input type="checkbox" name="gnv" id="gnv" value="1" <?php echo isset($_GET['gnv']) && $_GET['gnv'] == '1' ? 'checked' : '0'; ?>>
    </div>

    <!-- Botão de Aplicar Filtros (Aqui está o botão) -->
    <div class="apply-filters">
        <button id="apply-filters" class="btn-apply-filters">Aplicar Filtros</button>
    </div>

  
</div>