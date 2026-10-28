/**
 * UDGAM 2K26 — About Us Interactive Campus & 3D Tilt Script
 */
document.addEventListener('DOMContentLoaded', () => {
  const box = document.getElementById('campus3DBox');
  const card = document.getElementById('campus3DCard');
  const glare = document.getElementById('campusGlare');
  const btnSketch = document.getElementById('btnSketch');
  const btnPhoto = document.getElementById('btnPhoto');
  const paneSketch = document.getElementById('paneSketch');
  const panePhoto = document.getElementById('panePhoto');

  // 1. Campus View Switcher Toggle
  if (btnSketch && btnPhoto && paneSketch && panePhoto) {
    btnSketch.addEventListener('click', () => {
      btnSketch.classList.add('active');
      btnPhoto.classList.remove('active');
      paneSketch.classList.add('active');
      panePhoto.classList.remove('active');
    });

    btnPhoto.addEventListener('click', () => {
      btnPhoto.classList.add('active');
      btnSketch.classList.remove('active');
      panePhoto.classList.add('active');
      paneSketch.classList.remove('active');
    });
  }

  // 2. Interactive 3D Parallax & Glare on Hover / Pointer
  if (box && card && glare) {
    let bounds = null;
    let targetRotX = 0;
    let targetRotY = 0;
    let currentRotX = 0;
    let currentRotY = 0;
    let rafId = null;
    let isHovering = false;

    function updateBounds() {
      bounds = box.getBoundingClientRect();
    }

    const invalidateBounds = () => { bounds = null; };
    window.addEventListener('resize', invalidateBounds, { passive: true });
    window.addEventListener('scroll', invalidateBounds, { passive: true });

    function lerp(start, end, amt) {
      return (1 - amt) * start + amt * end;
    }

    function animate() {
      currentRotX = lerp(currentRotX, targetRotX, 0.14);
      currentRotY = lerp(currentRotY, targetRotY, 0.14);

      card.style.transform = `rotateX(${currentRotX.toFixed(2)}deg) rotateY(${currentRotY.toFixed(2)}deg)`;

      if (isHovering || Math.abs(targetRotX - currentRotX) > 0.05 || Math.abs(targetRotY - currentRotY) > 0.05) {
        rafId = requestAnimationFrame(animate);
      } else {
        card.style.transform = 'rotateX(0deg) rotateY(0deg)';
        rafId = null;
      }
    }

    function handlePointerMove(e) {
      if (!bounds) updateBounds();
      const clientX = e.clientX || (e.touches && e.touches[0].clientX);
      const clientY = e.clientY || (e.touches && e.touches[0].clientY);
      if (!clientX || !clientY) return;

      const normX = (clientX - bounds.left) / bounds.width - 0.5;
      const normY = (clientY - bounds.top) / bounds.height - 0.5;

      // Clamped range: [-0.5, 0.5]
      const clampedX = Math.max(-0.5, Math.min(0.5, normX));
      const clampedY = Math.max(-0.5, Math.min(0.5, normY));

      targetRotX = -clampedY * 20; // Tilt angle X
      targetRotY = clampedX * 24;  // Tilt angle Y

      // Update Glare sheen coordinates
      const gx = ((clampedX + 0.5) * 100).toFixed(1) + '%';
      const gy = ((clampedY + 0.5) * 100).toFixed(1) + '%';
      card.style.setProperty('--gx', gx);
      card.style.setProperty('--gy', gy);

      if (!rafId) {
        isHovering = true;
        rafId = requestAnimationFrame(animate);
      }
    }

    function handlePointerLeave() {
      isHovering = false;
      targetRotX = 0;
      targetRotY = 0;
      card.style.setProperty('--gx', '50%');
      card.style.setProperty('--gy', '50%');
      if (!rafId) {
        rafId = requestAnimationFrame(animate);
      }
    }

    box.addEventListener('mouseenter', updateBounds);
    box.addEventListener('mousemove', handlePointerMove);
    box.addEventListener('mouseleave', handlePointerLeave);

    // Touch support for mobile devices
    box.addEventListener('touchstart', (e) => {
      updateBounds();
      handlePointerMove(e);
    }, { passive: true });
    box.addEventListener('touchmove', handlePointerMove, { passive: true });
    box.addEventListener('touchend', handlePointerLeave, { passive: true });
  }
});
