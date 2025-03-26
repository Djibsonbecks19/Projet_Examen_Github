<?php
$sql_products = "SELECT p.id, p.libelle, SUM(c.quantite) as total_vendu 
                FROM produits p
                JOIN commandes c ON p.id = c.produit_id
                WHERE c.statut = 'payée'
                GROUP BY p.id
                ORDER BY total_vendu DESC
                LIMIT 10";
$result_products = mysqli_query($conn, $sql_products);

if (!$result_products) {
    die("Erreur de requête: " . mysqli_error($conn));
}

$product_names = [];
$sales_data = [];
$background_colors = [];
$border_colors = [];

while ($row = mysqli_fetch_assoc($result_products)) {
    $product_names[] = $row['libelle'];
    $sales_data[] = $row['total_vendu'];
    $r = rand(0, 255);
    $g = rand(0, 255);
    $b = rand(0, 255);
    $background_colors[] = "rgba($r, $g, $b, 0.7)";
    $border_colors[] = "rgba($r, $g, $b, 1)";
}

$sql_monthly = "SELECT 
                DATE_FORMAT(date_commande, '%Y-%m') as month,
                COUNT(*) as command_count
                FROM commandes
                WHERE statut = 'payée'
                GROUP BY DATE_FORMAT(date_commande, '%Y-%m')
                ORDER BY month ASC";
$result_monthly = mysqli_query($conn, $sql_monthly);

if (!$result_monthly) {
    die("Erreur de requête: " . mysqli_error($conn));
}

$month_labels = [];
$command_counts = [];

while ($row = mysqli_fetch_assoc($result_monthly)) {
    $month_labels[] = date('M Y', strtotime($row['month']));
    $command_counts[] = $row['command_count'];
}
?>

<div class="container mt-5">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Répartition des 10 Produits les Plus Vendus</h5>
        </div>
        <div class="card-body">
            <div style="height: 400px;">
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Commandes par Mois</h5>
        </div>
        <div class="card-body">
            <div style="height: 400px;">
                <canvas id="monthlyCommandsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const productsCtx = document.getElementById('topProductsChart');
    new Chart(productsCtx, {
      type: 'pie',
      data: {
        labels: <?php echo json_encode($product_names); ?>,
        datasets: [{
          label: 'Quantité vendue',
          data: <?php echo json_encode($sales_data); ?>,
          backgroundColor: <?php echo json_encode($background_colors); ?>,
          borderColor: <?php echo json_encode($border_colors); ?>,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const label = context.label || '';
                const value = context.raw || 0;
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = Math.round((value / total) * 100);
                return `${label}: ${value} unités (${percentage}%)`;
              }
            }
          }
        }
      }
    });

    const monthlyCtx = document.getElementById('monthlyCommandsChart');
    new Chart(monthlyCtx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($month_labels); ?>,
        datasets: [{
          label: 'Nombre de commandes',
          data: <?php echo json_encode($command_counts); ?>,
          backgroundColor: 'rgba(75, 192, 192, 0.7)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.parsed.y + ' commandes';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Nombre de commandes' },
            ticks: { stepSize: 1, precision: 0 }
          },
          x: {
            title: { display: true, text: 'Mois' },
            ticks: {
              autoSkip: false,
              maxRotation: 45,
              minRotation: 45
            }
          }
        }
      }
    });
  });
</script>