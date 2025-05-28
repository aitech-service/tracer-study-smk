<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex row">
            <div class="col-sm-7">
              <div class="card-body">
                <h2 class="card-title text-primary">Selamat Datang Administrator</h2>

              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="<?php echo base_url('assets')?>/assets/img/illustrations/man-with-laptop-light.png"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png"
                />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Chart Status Aktivitas Alumni dengan Filter Angkatan -->
      <div class="col-lg-6 col-12 mt-4">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Chart Status Aktivitas Alumni</h5>
            
            <!-- Dropdown filter angkatan dengan label di sebelahnya -->
            <form method="GET" id="angkatanFilterForm" class="d-flex align-items-center ms-3">
              <label for="angkatanSelect" class="me-2 mb-0 fw-bold">Angkatan:</label>
              <select name="angkatan" id="angkatanSelect" class="form-select form-select-sm" onchange="document.getElementById('angkatanFilterForm').submit();">
                <option value="">Semua Angkatan</option>
                <?php foreach ($angkatan_list as $angkatan): ?>
                  <option value="<?= $angkatan->angkatan ?>" <?= ($selected_angkatan == $angkatan->angkatan) ? 'selected' : '' ?>>
                    <?= $angkatan->angkatan ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </form>
          </div>
          <div class="card-body">
            <canvas id="statusChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Chart Pie Alumni Per Jurusan -->
      <div class="col-lg-6 col-12 mt-4">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Distribusi Alumni per Jurusan</h5>

            <!-- Filter angkatan -->
            <form method="GET" id="angkatanJurusanForm" class="d-flex align-items-center ms-3">
              <label for="angkatanJurusanSelect" class="me-2 mb-0 fw-bold">Angkatan:</label>
              <select name="angkatan_jurusan" id="angkatanJurusanSelect" class="form-select form-select-sm"
                      onchange="document.getElementById('angkatanJurusanForm').submit();">
                <option value="">Semua Angkatan</option>
                <?php foreach ($angkatan_list as $angkatan): ?>
                  <option value="<?= $angkatan->angkatan ?>" <?= ($selected_angkatan_jurusan == $angkatan->angkatan) ? 'selected' : '' ?>>
                    <?= $angkatan->angkatan ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </form>
          </div>
          <div class="card-body">
            <canvas id="jurusanPieChart" style="max-height: 270px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- / Content -->
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<div class="w-full h-[500px]">
  <canvas id="statusChart"></canvas>
</div>
<script>
    const labelsStatus = <?= $chart_labels_status ?? '["Bekerja", "Kuliah", "Wirausaha", "Belum Bekerja"]' ?>;
  const dataStatus = <?= $chart_data_status ?? '[0, 0, 0, 0]' ?>;

  const totalAlumni = dataStatus.reduce((a, b) => a + b, 0);

  const ctxStatus = document.getElementById('statusChart').getContext('2d');

  new Chart(ctxStatus, {
    type: 'bar',
    data: {
      labels: labelsStatus,
      datasets: [{
        label: 'Jumlah Alumni',
        data: dataStatus,
        backgroundColor: [
          'rgba(54, 162, 235, 0.8)',
          'rgba(75, 192, 192, 0.8)',
          'rgba(255, 206, 86, 0.8)',
          'rgba(255, 99, 132, 0.8)'
        ],
        borderRadius: 10,
        barThickness: 60
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function (context) {
              const value = context.raw;
              const percentage = totalAlumni > 0 ? ((value / totalAlumni) * 100).toFixed(1) : 0;
              return `${value} Alumni (${percentage}%)`;
            }
          }
        },
        datalabels: {
          anchor: 'center',
          align: 'center',
          color: '#fff',
          font: {
            weight: 'bold',
            size: 14
          },
          formatter: function (value) {
            const percentage = totalAlumni > 0 ? ((value / totalAlumni) * 100).toFixed(1) : 0;
            return `${percentage}%`;
          }
        }
      },
      scales: {
        x: {
          ticks: {
            font: { weight: 'bold' }
          },
          grid: {
            display: false
          }
        },
        y: {
          beginAtZero: true,
          precision: 0,
          ticks: {
            stepSize: 1
          },
          grid: {
            color: '#e5e7eb'
          }
        }
      }
    },
    plugins: [ChartDataLabels]
  });

 // Chart Pie Alumni Per Jurusan (modern)
const labelsJurusan = <?= $chart_labels_jurusan ?? '["Jurusan A", "Jurusan B", "Jurusan C"]' ?>;
const dataJurusan = <?= $chart_data_jurusan ?? '[10, 20, 30]' ?>;

const ctxJurusan = document.getElementById('jurusanPieChart').getContext('2d');
new Chart(ctxJurusan, {
  type: 'pie',
  data: {
    labels: labelsJurusan,
    datasets: [{
      data: dataJurusan,
      backgroundColor: [
        '#4e79a7',
        '#f28e2b',
        '#e15759',
        '#76b7b2',
        '#59a14f',
        '#edc949',
        '#af7aa1',
        '#ff9da7'
      ],
      borderColor: '#fff',
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    animation: {
      animateScale: true,
      animateRotate: true
    },
    plugins: {
      legend: {
        position: 'bottom',
        labels: {
          usePointStyle: true,
          padding: 20
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            let label = context.label || '';
            let value = context.raw || 0;
            let total = context.chart._metasets[0].total || 1;
            let percentage = ((value / total) * 100).toFixed(1);
            return `${label}: ${value} (${percentage}%)`;
          }
        }
      },
      datalabels: {
        color: '#fff',
        font: {
          weight: 'bold',
          size: 14
        },
        formatter: (value, context) => {
          let total = context.chart._metasets[0].total || 1;
          let percentage = ((value / total) * 100).toFixed(1);
          return `${percentage}%`;
        }
      }
    }
  },
  plugins: [ChartDataLabels]
});

  // Auto submit filter angkatan
  document.getElementById('angkatanSelect').addEventListener('change', function () {
    document.getElementById('angkatanFilterForm').submit();
  });
</script>
