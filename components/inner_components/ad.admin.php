<div class='admin-container'>
    <button class='ad-container'>
        <a href="pages/ad-view.php?ad_id=<?php echo $ad['id_veiculo'] ?>">
            <div class='ad'>
                <img src="<?php echo $ad['foto'] ?>" class='ad-img' width='180px' height='140px' crossorigin='anonymous' />
                <p class='car-model'><?php echo htmlspecialchars($ad['nome']) ?></p>
                <p class='car-brand'><?php echo htmlspecialchars($ad['id_marca']) ?></p>
                <div class='car-year-km'>
                    <p><?php echo htmlspecialchars($ad['ano']) ?></p>
                    <p><?php echo number_format($ad['km'], 0, ',', '.') ?></p>
                </div>
                <p class='price'><?php echo number_format($ad['preco'], 2, ',', '.'); ?></p>
                <p class='cidade'><?php echo htmlspecialchars($ad['cidade_nome']); ?></p>
            </div>
        </a>
    </button>

    <form action="/concessionaria/includes/approve_ad.php" method="POST">
        <input type="hidden" name="ad_id" value="<?php echo $ad['id_veiculo']; ?>">
        <button type="submit" class="approve-button">Aprovar Anúncio</button>
    </form>
</div>