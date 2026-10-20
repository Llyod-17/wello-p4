/**
 * 5xx ERROR - BURNING APPLE INTERACTIONS
 * Click to douse fire with water splash effect
 */

document.addEventListener('DOMContentLoaded', () => {
  const actor = document.querySelector('[data-character="apple"]');
  if (!actor) return;

  const fire = document.querySelector('.apple-fire');
  const smoke = document.querySelectorAll('.apple-smoke');
  const face = document.querySelector('.apple-face');

  let isDousedRecently = false;

  actor.addEventListener('click', (e) => {
    if (isDousedRecently) return;

    isDousedRecently = true;

    // Water splash effect
    createWaterSplash(e.clientX, e.clientY);

    // Temporarily douse fire
    if (fire) {
      fire.style.opacity = '0';
      fire.style.transform = 'scale(0.5)';
    }

    smoke.forEach(s => {
      s.style.opacity = '0.9';
      s.style.animation = 'smokeExplosion 0.6s ease-out forwards';
    });

    // Relief expression
    if (face) {
      face.style.transform = 'scale(1.05)';
    }

    // Fire comes back after 1.5s
    setTimeout(() => {
      if (fire) {
        fire.style.opacity = '';
        fire.style.transform = '';
      }
      smoke.forEach(s => {
        s.style.opacity = '';
        s.style.animation = '';
      });
      if (face) {
        face.style.transform = '';
      }
      isDousedRecently = false;
    }, 1500);
  });

  function createWaterSplash(x, y) {
    const splash = document.createElement('div');
    splash.style.position = 'absolute';
    splash.style.left = `${x}px`;
    splash.style.top = `${y}px`;
    splash.style.width = '80px';
    splash.style.height = '80px';
    splash.style.borderRadius = '50%';
    splash.style.background = 'radial-gradient(circle, rgba(100, 180, 255, 0.6) 0%, transparent 70%)';
    splash.style.pointerEvents = 'none';
    splash.style.transform = 'translate(-50%, -50%) scale(0.3)';
    splash.style.animation = 'waterSplash 0.5s ease-out forwards';
    splash.style.zIndex = '25';

    document.body.appendChild(splash);

    setTimeout(() => splash.remove(), 550);
  }

  // Add water splash animation dynamically
  const style = document.createElement('style');
  style.textContent = `
    @keyframes waterSplash {
      0% {
        transform: translate(-50%, -50%) scale(0.3);
        opacity: 1;
      }
      50% {
        transform: translate(-50%, -50%) scale(1.5);
        opacity: 0.8;
      }
      100% {
        transform: translate(-50%, -50%) scale(2.5);
        opacity: 0;
      }
    }
  `;
  document.head.appendChild(style);
});
