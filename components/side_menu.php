<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <h2>Filtros</h2>
    </div>

    <!-- Barra de pesquisa -->
    <div class="search-bar">
        <input type="text" placeholder="Pesquisar por modelo/marca...">
    </div>

    <!-- Filtro de KM -->
    <div class="km-filter">
        <label for="km-range">Km: <span id="km-label">0</span> km</label>
        <input type="range" id="km-range-bar" min="0" max="100000" step="1000" value="0">
        <div class="bottomText">
            <span id="km-value">0 km</span>
            <span id="km-value">100k km</span>
        </div>
    </div>

    <!-- Filtro de Ano -->
    <div class="year-filter">
        <label for="year-range">Ano: </label>
        <span id="year-value">1970</span>
        <input type="range" id="year-range" min="1970" max="2025" value="1970" step="1">
        <span id="year-end-value">1970 até 2025</span>
    </div>

    <!-- Pesquisar preço mínimo e máximo -->
    <div class="search-bar">
        <label for="price-search">Preço</label>
        <div>
            <input type="text" id="min-price-search" placeholder="Menor Preço...">
            <input type="text" id="max-price-search" placeholder="Maior Preço...">
        </div>

    </div>

    <!-- Filtro de Combustível -->
    <div class="fuel-filter">
        <label id='fuel-text' for="fuel-type">Combustível:</label>
        <select id="fuel-type">
            <option value="all-fuel">Todos</option>
            <option value="g">Gasolina</option>
            <option value="a">Alcool</option>
            <option value="d">Diesel</option>
            <option value="e">Elétrico</option>
            <option value="h">Hibrido</option>
            <option value="f">Flex</option>
        </select>
    </div>


    <!-- Filtro de Câmbio -->
    <div class="fuel-filter">
        <label class='gear-text' for="fuel-type">Câmbio:</label>
        <select id="gear-type">
            <option value="all-gear">Todos</option>
            <option value="g">Manual</option>
            <option value="a">Automático</option>
            <option value="d">Elétrico</option>
        </select>
    </div>


    <!-- Filtro de Quantidade de Lugares -->
    <div class="seats-filter">
        <label for="seats">Quantidade de Lugares:</label>
        <div class="seats-options">
            <label>
                <input type="radio" name="seats" value="1" checked> 1
            </label>
            <label>
                <input type="radio" name="seats" value="2"> 2
            </label>
            <label>
                <input type="radio" name="seats" value="3"> 3
            </label>
            <label>
                <input type="radio" name="seats" value="4"> 4
            </label>
            <label>
                <input type="radio" name="seats" value="5orMore"> 5 ou mais
            </label>
        </div>
    </div>

    <!-- Filtro de Quantidade de Portas -->
    <div class="doors-filter">
        <label for="doors">Quantidade de Portas:</label>
        <div class="doors-options">
            <label>
                <input type="radio" name="doors" value="1" checked> 1
            </label>
            <label>
                <input type="radio" name="doors" value="2"> 2
            </label>
            <label>
                <input type="radio" name="doors" value="3"> 3
            </label>
            <label>
                <input type="radio" name="doors" value="4"> 4
            </label>
            <label>
                <input type="radio" name="doors" value="5orMore"> 5 ou mais
            </label>
        </div>
    </div>

    <!-- Filtro de GNV -->
    <div class="gnv-filter">
        <label for="gnv">Possui GNV:</label>
        <input type="checkbox" id="gnv">
    </div>
    <script src="/js/sideMenu.js"></script>
</div>