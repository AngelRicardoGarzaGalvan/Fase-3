function toggleInfo(id) {
  // Oculta todos
  document.querySelectorAll('.car-info').forEach(info => {
    if (info.id !== id) {
      info.style.display = 'none';
    }
  });

  // Referencia al div que quieres mostrar
  const currentInfo = document.getElementById(id);

  // Alternar visibilidad solo para ese
  if (currentInfo.style.display === 'block') {
    currentInfo.style.display = 'none';
  } else {
    currentInfo.style.display = 'block';
    currentInfo.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
}
