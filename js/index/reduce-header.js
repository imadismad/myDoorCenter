window.addEventListener('scroll', function() {
    var header = document.getElementById('mainHeader');
    var scrollPosition = window.scrollY || document.documentElement.scrollTop;
  
    if (scrollPosition > 100) { // Ajustez cette valeur si nécessaire
      header.classList.add('header-reduced');
    } else {
      header.classList.remove('header-reduced');
    }
  });