<div>
    <button class='ad-container'>
        <a href="pages/ad-view.php?ad_id=<?php echo htmlspecialchars($ad['id']); ?>" class="ad-link">
            <div class='ad'>
                <img src="<?php echo htmlspecialchars($ad['foto']); ?>"
                    alt="Imagem do anúncio de <?php echo htmlspecialchars($ad['nome']); ?>" class='ad-img' width='180px'
                    height='140px' crossorigin='anonymous' />
                <p class='car-model'><?php echo htmlspecialchars($ad['nome']); ?></p>
                <p class='car-brand'><?php echo htmlspecialchars($ad['id_marca']); ?></p>
                <div class='car-year-km'>
                    <p><?php echo htmlspecialchars($ad['ano']); ?></p>
                    <p><?php echo number_format($ad['km'], 0, ',', '.'); ?> km</p>
                </div>
                <p class='price'>R$ <?php echo number_format($ad['preco'], 2, ',', '.'); ?></p>
            </div>
        </a>
    </button>

    <form action="/concessionaria/includes/approve_ad.php" method="POST">
        <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
        <button type="submit" class="approve-button">Aprovar Anúncio</button>
    </form>
</div>