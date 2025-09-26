/* import './bootstrap';
import '../css/app.css';
import '../css/custom.css'; */

/* import '../css/app.css'; */

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../css/custom.css'; 
import './theme.js';
import '@fortawesome/fontawesome-free/css/all.min.css';


document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.group.collapsible').forEach(group => {
    const key = group.dataset.key; // e.g., "record-level"
    const header = group.querySelector('.group-header');

    // Restaura estado desde localStorage (si existe)
    if (key) {
      const saved = localStorage.getItem('group:' + key);
      if (saved === 'open') group.classList.add('open');
      if (saved === 'closed') group.classList.remove('open');
    }

    header?.addEventListener('click', () => {
      group.classList.toggle('open');
      if (key) {
        localStorage.setItem('group:' + key, group.classList.contains('open') ? 'open' : 'closed');
      }
    });
  });
});

