function validateForm() {
    console.log('chamou as validações')
    const idCidade = document.getElementById('id_cidade').value;
    const placa = document.getElementById('placa').value;
    const km = document.getElementById('km').value;
    const preco = document.getElementById('preco').value;
    const telefone = document.getElementById('telefone').value;
    const foto = document.getElementById('foto').value;
    const descricao = document.getElementById('descricao').value;
    const idModelo = document.getElementById('modelo').value;

    if (idCidade === "" || isNaN(idCidade)) {
        alert("Por favor, selecione uma cidade válida.");
        return false;
    }

    if (idModelo === "") {
        alert("Por favor, selecione um modelo.");
        return false;
    }

    if (placa === "") {
        alert("Por favor, informe a placa do veículo.");
        return false;
    }

    if (km === "") {
        alert("Por favor, informe o KM atual do veículo.");
        return false;
    }

    if (preco === "") {
        alert("Por favor, informe o preço do veículo.");
        return false;
    }

    if (telefone === "") {
        alert("Por favor, informe o telefone.");
        return false;
    }

    if (foto === "") {
        alert("Por favor, informe a URL da foto do veículo.");
        return false;
    }

    if (descricao === "") {
        alert("Por favor, forneça uma descrição para o anúncio.");
        return false;
    }

    return true;
}

document.querySelector("form").onsubmit = function(event) {
    if (!validateForm()) {
        event.preventDefault();
    }
};