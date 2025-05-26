// reportes.js
document.addEventListener('DOMContentLoaded', function () {
  // Ventas por día
  const ctxDia = document.getElementById('ventasDiaChart').getContext('2d');
  new Chart(ctxDia, {
    type: 'line',
    data: {
      labels: ventasDiaLabels,
      datasets: [{
        label: `Ventas por Día (${mesTexto} ${añoTexto})`,
        data: ventasDiaData,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 2,
        fill: true,
        tension: 0.3,
        pointRadius: 4,
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          stepSize: 1
        }
      }
    }
  });

  // Ventas por plan
  const ctxPlan = document.getElementById('ventasPlanChart').getContext('2d');
  new Chart(ctxPlan, {
    type: 'bar',
    data: {
      labels: ventasPlanLabels,
      datasets: [{
        label: `Ventas por Plan (${mesTexto} ${añoTexto})`,
        data: ventasPlanData,
        backgroundColor: 'rgba(255, 159, 64, 0.7)',
        borderColor: 'rgba(255, 159, 64, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Ventas por auto
  const ctxAuto = document.getElementById('ventasAutoChart').getContext('2d');
  new Chart(ctxAuto, {
    type: 'pie',
    data: {
      labels: ventasAutoLabels,
      datasets: [{
        label: `Ventas por Auto (${mesTexto} ${añoTexto})`,
        data: ventasAutoData,
        backgroundColor: [
          '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
          '#9966FF', '#FF9F40', '#C9CBCF', '#8DD7BF'
        ]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });
});
