/**
 * ERROR PAGES BASE SCRIPT
 * Parallax and Click Particles (shared)
 */

document.addEventListener('DOMContentLoaded', () => {
  const container = document.querySelector('[data-error]');
  if (!container) return;

  const decorVegs = document.querySelectorAll('.veg');
  const particleBox = document.querySelector('[data-error-particles]');

  // Parallax for floating vegetables
  let mouseX = window.innerWidth / 2;
  let mouseY = window.innerHeight / 2;

  window.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;

    const moveX = (mouseX / window.innerWidth - 0.5) * 40;
    const moveY = (mouseY / window.innerHeight - 0.5) * 40;

    decorVegs.forEach((veg) => {
      const depth = parseFloat(veg.dataset.depth || '0.5');
      veg.style.transform = `translate(${moveX * depth}px, ${moveY * depth}px)`;
    });
  });

  // Click to spawn particles
  const vegSymbols = ['#vg-leaf', '#vg-carrot', '#vg-broc', '#vg-bean', '#vg-pepper', '#vg-tomato'];

  document.addEventListener('click', (e) => {
    if (e.target.closest('a, button, input, [contenteditable="true"]')) {
      return;
    }

    if (!particleBox) return;

    const count = 5 + Math.floor(Math.random() * 4);
    for (let i = 0; i < count; i++) {
      createParticle(e.clientX, e.clientY);
    }
  });

  function createParticle(x, y) {
    const el = document.createElement('div');
    el.className = 'particle';

    const symbol = vegSymbols[Math.floor(Math.random() * vegSymbols.length)];
    const size = 20 + Math.random() * 24;
    const angle = Math.random() * Math.PI * 2;
    const distance = 40 + Math.random() * 80;
    const dx = Math.cos(angle) * distance;
    const dy = Math.sin(angle) * distance - 20;
    const rot = (Math.random() - 0.5) * 360;

    el.style.left = `${x}px`;
    el.style.top = `${y}px`;
    el.style.width = `${size}px`;
    el.style.height = `${size}px`;
    el.style.setProperty('--dx', `${dx}px`);
    el.style.setProperty('--dy', `${dy}px`);
    el.style.setProperty('--rot', `${rot}deg`);

    el.innerHTML = `<svg viewBox="0 0 40 40" width="100%" height="100%"><use href="${symbol}"/></svg>`;

    particleBox.appendChild(el);

    setTimeout(() => {
      el.remove();
    }, 950);
  }
});
