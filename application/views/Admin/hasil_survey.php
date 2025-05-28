<!-- Content wrapper -->
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><i class="bx bx-list-check me-2"></i> Hasil Survey Alumni</h4>

    <?php if (empty($alumni_list)): ?>
      <div class="alert alert-warning">Belum ada alumni yang mengisi survey.</div>
    <?php else: ?>
      <!-- Search bar -->
      <div class="mb-3">
        <input type="text" class="form-control" id="searchAlumni" placeholder="Cari nama alumni...">
      </div>

      <!-- Accordion Container -->
      <div id="surveyAccordionContainer">
        <div class="accordion" id="surveyAccordion">
          <?php foreach ($alumni_list as $index => $alumni): ?>
            <div class="accordion-item mb-3 alumni-item" data-name="<?= strtolower($alumni->nama) ?>">
              <h2 class="accordion-header" id="heading<?= $alumni->id_alumni ?>">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $alumni->id_alumni ?>"
                        aria-expanded="false"
                        aria-controls="collapse<?= $alumni->id_alumni ?>">
                  <?= htmlspecialchars($alumni->nama) ?> - <?= htmlspecialchars($alumni->angkatan ?? '-') ?>
                </button>
              </h2>
              <div id="collapse<?= $alumni->id_alumni ?>"
                   class="accordion-collapse collapse"
                   aria-labelledby="heading<?= $alumni->id_alumni ?>"
                   data-bs-parent="#surveyAccordion">
                <div class="accordion-body">
                  <?php if (!empty($jawaban[$alumni->id_alumni])): ?>
                    <table class="table table-bordered table-sm">
                      <thead class="table-light">
                        <tr>
                          <th style="width: 5%;">#</th>
                          <th>Pertanyaan</th>
                          <th>Jawaban</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1; foreach ($jawaban[$alumni->id_alumni] as $j): ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($j->pertanyaan) ?></td>
                            <td><?= nl2br(htmlspecialchars($j->jawaban)) ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  <?php else: ?>
                    <p class="text-muted">Belum ada jawaban dari alumni ini.</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <nav class="mt-4">
          <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- JavaScript for Search and Pagination -->
<script>
  const itemsPerPage = 10;
  let currentPage = 1;

  function updatePagination() {
    const allItems = document.querySelectorAll(".alumni-item");
    const searchVal = document.getElementById("searchAlumni").value.toLowerCase();

    const filtered = Array.from(allItems).filter(item => {
      return item.getAttribute("data-name").includes(searchVal);
    });

    // Hide all
    allItems.forEach(item => item.style.display = "none");

    // Show only filtered for current page
    filtered.forEach((item, index) => {
      if (index >= (currentPage - 1) * itemsPerPage && index < currentPage * itemsPerPage) {
        item.style.display = "";
      }
    });

    // Update pagination buttons
    const totalPages = Math.ceil(filtered.length / itemsPerPage);
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    if (totalPages > 1) {
      for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement("li");
        li.className = "page-item" + (i === currentPage ? " active" : "");
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener("click", function(e) {
          e.preventDefault();
          currentPage = i;
          updatePagination();
        });
        pagination.appendChild(li);
      }
    }
  }

  document.getElementById("searchAlumni").addEventListener("input", () => {
    currentPage = 1;
    updatePagination();
  });

  document.addEventListener("DOMContentLoaded", () => {
    updatePagination();
  });
</script>
