document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 50) {
            navbar.classList.add('scrolled');
            if (currentScroll > lastScroll) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
        } else {
            navbar.classList.remove('scrolled');
        }
        lastScroll = currentScroll;











        let dotCount = 0;
        setInterval(() => {
            const dot = document.querySelector('.dot');
            if (dot) {
                dotCount = (dotCount + 1) % 4;
                dot.textContent = '.'.repeat(dotCount);
            }
        }, 500);
    });









    
    // function filterGames() {
    //     const category = document.getElementById('categoryFilter').value;
    //     const price = document.getElementById('priceFilter').value;
    //     const gameCards = document.getElementsByClassName('game-card');
    
    //     const loading = document.createElement('div');
    //     loading.className = 'loading';
    //     loading.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 2rem; color: #00d4ff; z-index: 1001;';
    //     loading.innerHTML = 'Loading <span class="dot">...</span>';
    //     document.body.appendChild(loading);
    
    //     setTimeout(() => {
    //         Array.from(gameCards).forEach(card => {
    //             const cardCategory = card.getAttribute('data-category');
    //             const cardPrice = parseFloat(card.getAttribute('data-price'));
    
    //             let show = true;
    
    //             // Category filtering
    //             if (category !== '' && cardCategory !== category) {
    //                 show = false;
    //             }
    
    //             // Price filtering
    //             if (price !== '') {
    //                 if (price === 'low-high' || price === 'high-low') {
    //                     // Sorting will be handled separately (not filtering here)
    //                 } else {
    //                     const [min, max] = price.split('-').map(Number);
    //                     if (cardPrice < min || cardPrice > max) {
    //                         show = false;
    //                     }
    //                 }
    //             }
    
    //             if (show) {
    //                 card.style.display = 'block';
    //                 card.style.opacity = '0';
    //                 setTimeout(() => {
    //                     card.style.transition = 'opacity 0.5s ease';
    //                     card.style.opacity = '1';
    //                 }, 50);
    //             } else {
    //                 card.style.transition = 'opacity 0.5s ease';
    //                 card.style.opacity = '0';
    //                 setTimeout(() => {
    //                     card.style.display = 'none';
    //                 }, 500);
    //             }
    //         });
    
    //         // Optional: Implement sorting after filtering
    //         if (price === 'low-high' || price === 'high-low') {
    //             sortGamesByPrice(price === 'low-high');
    //         }
    
    //         document.body.removeChild(loading);
    //     }, 500);
    // }
    




    function filterGames() {
        const category = document.getElementById('categoryFilter').value;
        const price = document.getElementById('priceFilter').value;
    
        // Build new URL with query parameters
        const url = new URL(window.location.href);
        url.searchParams.set('category', category);
        url.searchParams.set('price', price);
    
        window.location.href = url.toString(); // Reload page with filters
    }
    

    





    

    function sortGamesByPrice(ascending = true) {
        const gameList = document.getElementById('gameList');
        const cards = Array.from(gameList.getElementsByClassName('game-card'));
    
        cards.sort((a, b) => {
            const priceA = parseFloat(a.getAttribute('data-price'));
            const priceB = parseFloat(b.getAttribute('data-price'));
            return ascending ? priceA - priceB : priceB - priceA;
        });
    
        cards.forEach(card => gameList.appendChild(card)); // Reorder cards in DOM
    }
    










    // Add event listener to category filter
    document.getElementById('categoryFilter').addEventListener('change', filterGames);

    // Animate cards on load
    const cards = document.querySelectorAll('.game-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease';
            card.style.opacity = '1';
        }, index * 150);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});

