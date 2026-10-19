/**
 * 404 Interactive Script - Detektif Brokoli
 * Parallax, Eye Tracking, Draggable Glass, Click Seeds Burst
 */

document.addEventListener('DOMContentLoaded', () => {
  const container = document.querySelector('[data-404]');
  if (!container) return;

  const actor = document.querySelector('.e404-actor');
  const pupils = document.querySelectorAll('.bd-pupil');
  const glass = document.querySelector('[data-404-glass]');
  const digits = document.querySelector('[data-404-digits]');
  const decorVegs = document.querySelectorAll('.veg');
  const particleBox = document.querySelector('[data-404-particles]');
  const smile = document.querySelector('.bd-smile');
  const brows = document.querySelector('.bd-brows');

  // Center coordinates of eyes for tracking
  let eyeCenter = { x: window.innerWidth / 2, y: window.innerHeight / 2 };

  function updateEyeCenter() {
    if (actor) {
      const rect = actor.getBoundingClientRect();
      eyeCenter = {
        x: rect.left + rect.width * 0.5,
        y: rect.top + rect.height * 0.45
      };
    }
  }

  updateEyeCenter();
  window.addEventListener('resize', updateEyeCenter);

  // 1. MOUSE MOVE — Eye Tracking & Ambient Parallax
  let mouseX = window.innerWidth / 2;
  let mouseY = window.innerHeight / 2;
  let targetPupilX = 0;
  let targetPupilY = 0;
  let currentPupilX = 0;
  let currentPupilY = 0;

  window.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;

    // Eye direction calculation
    const dx = mouseX - eyeCenter.x;
    const dy = mouseY - eyeCenter.y;
    const distance = Math.hypot(dx, dy);
    const maxPupilMove = 8; // maximum pixel movement within socket

    if (distance > 0) {
      const angle = Math.atan2(dy, dx);
      const intensity = Math.min(distance / 200, 1) * maxPupilMove;
      targetPupilX = Math.cos(angle) * intensity;
      targetPupilY = Math.sin(angle) * intensity;
    }

    // Vegetable Parallax
    const moveX = (mouseX / window.innerWidth - 0.5) * 40;
    const moveY = (mouseY / window.innerHeight - 0.5) * 40;

    decorVegs.forEach((veg) => {
      const depth = parseFloat(veg.dataset.depth || '0.5');
      veg.style.transform = `translate(${moveX * depth}px, ${moveY * depth}px)`;
    });
  });

  // Smooth animation loop for pupils
  function animatePupils() {
    currentPupilX += (targetPupilX - currentPupilX) * 0.15;
    currentPupilY += (targetPupilY - currentPupilY) * 0.15;

    pupils.forEach((pupil) => {
      pupil.style.transform = `translate(${currentPupilX}px, ${currentPupilY}px)`;
    });

    requestAnimationFrame(animatePupils);
  }
  requestAnimationFrame(animatePupils);

  // 2. DRAGGABLE / INTERACTIVE MAGNIFYING GLASS
  let isDraggingGlass = false;
  let glassStart = { x: 0, y: 0 };
  let glassOffset = { x: 0, y: 0 };

  if (glass) {
    glass.addEventListener('mousedown', (e) => {
      isDraggingGlass = true;
      glassStart = { x: e.clientX - glassOffset.x, y: e.clientY - glassOffset.y };
      glass.style.transition = 'none';
      e.stopPropagation();
    });

    window.addEventListener('mousemove', (e) => {
      if (!isDraggingGlass) return;
      glassOffset.x = Math.max(-100, Math.min(100, e.clientX - glassStart.x));
      glassOffset.y = Math.max(-80, Math.min(80, e.clientY - glassStart.y));
      glass.style.transform = `translate(${glassOffset.x}px, ${glassOffset.y}px) scale(1.15)`;
    });

    window.addEventListener('mouseup', () => {
      if (!isDraggingGlass) return;
      isDraggingGlass = false;
      glass.style.transition = 'transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
      glassOffset = { x: 0, y: 0 };
      glass.style.transform = '';
    });
  }

  // 3. CLICK TO SPAWN SPROUTS / VEGGIES
  const vegSymbols = ['#vg-leaf', '#vg-carrot', '#vg-broc', '#vg-bean', '#vg-pepper', '#vg-tomato'];

  document.addEventListener('click', (e) => {
    // Avoid triggering burst when clicking interactive buttons/links
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
    const dy = Math.sin(angle) * distance - 20; // slight lift
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

  // 4. INTERACTIVE 404 DIGITS (Surprise reaction if user edits the number)
  if (digits) {
    digits.addEventListener('input', () => {
      const val = digits.textContent.trim();
      if (val !== '404' && val.length > 0) {
        // Puzzled detective reaction
        if (smile) smile.setAttribute('d', 'M136 250 Q160 236 184 250'); // frowning
        if (brows) brows.style.transform = 'translateY(-8px) rotate(-4deg)';
      } else {
        // Back to normal
        if (smile) smile.setAttribute('d', 'M136 242 Q160 261 184 242'); // smiling
        if (brows) brows.style.transform = '';
      }
    });

    digits.addEventListener('blur', () => {
      if (!digits.textContent.trim()) {
        digits.textContent = '404';
        if (smile) smile.setAttribute('d', 'M136 242 Q160 261 184 242');
        if (brows) brows.style.transform = '';
      }
    });
  }
});
