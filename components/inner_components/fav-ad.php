<button class='container'>
    <a href="ad-view.php?ad_id=<?php echo $fav['id'] ?>">
    <div class='ad'>
        <img src="<?php echo $fav['foto']?>" class='ad-img' width='180px' height='140px' crossorigin='anonymous' />
        <p class='car-model'><?php echo htmlspecialchars($fav['nome']) ?></p>
        <p class='car-brand'><?php echo htmlspecialchars($fav['id_marca']) ?></p>
        <div class='car-year-km'>
            <p><?php echo htmlspecialchars($fav['ano']) ?></p>
            <p><?php echo number_format($fav['km'], 0, ',', '.') . "km" ?></p>
        </div>
        <p class='price'><?php echo number_format($fav['preco'], 2, ',', '.'); ?></p>
    </div>
    </a>
</button>