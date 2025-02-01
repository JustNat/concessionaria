
function closealert() {
    document.getElementById('error-alert').style.display = 'none';
}

// Exibe a alert se a mensagem de erro existir
window.onload = function() {
    var errorMessage = "<?php echo $errorMessage; ?>";
    if (errorMessage) {
        document.getElementById('error-alert').style.display = 'flex';
    }
}
