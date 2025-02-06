function filterAds() {
    const kmMax = parseInt(document.querySelector('[name="km"]').value) || 100000; // KM padrão como 100000
    const minPrice = parseFloat(document.querySelector('[name="min-price"]').value) || 0;
    const maxPrice = parseFloat(document.querySelector('[name="max-price"]').value) || Infinity;
    const fuelFilter = document.querySelector('[name="fuel"]').value;
    const gearFilter = document.querySelector('[name="gear"]').value;
    const gnvFilter = document.querySelector('[name="gnv"]').checked ? '1' : '';
    console.log('Filtro de preço:', minPrice, maxPrice);
    console.log('Filtro de km:', kmMax);
    console.log('Filtro de combustível:', fuelFilter);
    console.log('Filtro de câmbio:', gearFilter);
    console.log('Filtro de GNV:', gnvFilter);
    const ads = document.querySelectorAll('.ad-container');
    ads.forEach(ad => {
        const preco = parseFloat(ad.getAttribute('data-preco')) || 0;
        const km = parseInt(ad.getAttribute('data-km')) || 0;
        const combustivel = ad.getAttribute('data-combustivel');
        const cambio = ad.getAttribute('data-cambio');
        const gnv = ad.getAttribute('data-gnv');
        const matchesPrice = preco >= minPrice && preco <= maxPrice;
        const matchesKm = km <= kmMax;
        const matchesFuel = fuelFilter === 'all-fuel' || combustivel === fuelFilter;
        const matchesGear = gearFilter === 'all-gear' || cambio === gearFilter;
        const matchesGnv = gnvFilter === '' || gnv === gnvFilter;

        if (matchesPrice && matchesKm && matchesFuel && matchesGear && matchesGnv) {
            ad.style.display = 'block';
        } else {
            ad.style.display = 'none';
        }
    });
}

document.getElementById('apply-filters').addEventListener('click', function(event) {
    event.preventDefault();
    filterAds();
});
