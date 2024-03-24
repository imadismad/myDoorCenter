window.addEventListener('scroll', function() {
  var header = document.getElementById('mainHeader');
  var scrollPosition = window.scrollY || document.documentElement.scrollTop;

  if (scrollPosition > 100) {
    header.classList.add('header-reduced');
  } else {
    header.classList.remove('header-reduced');
  }
});