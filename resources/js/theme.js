(function(){
  const KEY = 'ikiam:theme';
  const root = document.documentElement;

  // Restaurar
  const saved = localStorage.getItem(KEY);
  if (saved && saved !== 'custom') {
    root.setAttribute('data-theme', saved);
  }

  function init(){
    const sel = document.getElementById('theme-select');
    if (!sel) return;
    sel.value = saved || 'custom';
    sel.addEventListener('change', () => {
      const val = sel.value;
      if (val === 'custom'){
        root.removeAttribute('data-theme');
        localStorage.removeItem(KEY);
      } else {
        root.setAttribute('data-theme', val);
        localStorage.setItem(KEY, val);
      }
    });
  }

  if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }


  /* document.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById("theme-select");

    // Pinta cada option según su data-color
    Array.from(select.options).forEach(opt => {
        const color = opt.getAttribute("data-color");
        opt.style.background = color;   // afecta el cuadrito (con currentColor)
    });

    // inicializar al cargar
    const initial = select.options[select.selectedIndex];
    select.style.background = initial.getAttribute("data-color");
  });
 */

})();



