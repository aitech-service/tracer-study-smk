<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (empty($alumni_list)): ?>
  <div class="alert alert-warning">Belum ada alumni yang mengisi survey.</div>
<?php else: ?>
  <div class="accordion" id="surveyAccordion">
    <?php foreach ($alumni_list as $index => $alumni): ?>
      <div class="accordion-item mb-3">
        <h2 class="accordion-header" id="heading<?= $alumni->id_alumni ?>">
          <button class="accordion-button collapsed" type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapse<?= $alumni->id_alumni ?>"
                  aria-expanded="false"
                  aria-controls="collapse<?= $alumni->id_alumni ?>">
            <?= htmlspecialchars($alumni->nama) ?> - <?= htmlspecialchars($alumni->angkatan ?? '-') ?>
          </button>
        </h2>
        <div id="collapse<?= $alumni->id_alumni ?>" class="accordion-collapse collapse"
             aria-labelledby="heading<?= $alumni->id_alumni ?>"
             data-bs-parent="#surveyAccordion">
          <div class="accordion-body">
            <?php if (!empty($jawaban[$alumni->id_alumni])): ?>
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr><th>#</th><th>Pertanyaan</th><th>Jawaban</th></tr>
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
  <?php
    $totalPages = ceil($total / $limit);
    if ($totalPages > 1):
  ?>
    <nav class="mt-4">
      <ul class="pagination justify-content-center">
        <?php for ($i = 0; $i < $totalPages; $i++): ?>
          <li class="page-item <?= $i == floor($offset / $limit) ? 'active' : '' ?>">
            <a class="page-link" href="#" onclick="goToPage(<?= $i ?>); return false;"><?= $i + 1 ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  <?php endif; ?>
<?php endif; ?>
