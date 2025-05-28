<?php
// Buat array [pertanyaan_id => jawaban]
$jawaban_terisi_map = [];
if (!empty($jawaban_terisi)) {
    foreach ($jawaban_terisi as $j) {
        $jawaban_terisi_map[$j->pertanyaan_id] = $j->jawaban;
    }
}
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3">
      <i class="bx bx-list-check me-2"></i> Survey Tracer Study
    </h4>

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('tracerSurvey/submit') ?>">
      <div id="question-pages">
        <?php foreach (array_chunk($pertanyaan, 5) as $pageIndex => $chunk): ?>
          <div class="question-page" style="<?= $pageIndex > 0 ? 'display:none;' : '' ?>">
            <?php foreach ($chunk as $q): ?>
              <?php $value = isset($jawaban_terisi_map[$q->id]) ? $jawaban_terisi_map[$q->id] : ''; ?>
              <div class="mb-4">
                <label class="form-label fw-semibold"><?= $q->pertanyaan ?></label>

                <?php if ($q->tipe == 'isian'): ?>
                  <input type="text" name="pertanyaan[<?= $q->id ?>]" class="form-control"
                         value="<?= htmlspecialchars($value) ?>"
                         <?= $q->is_required ? 'required' : '' ?>>

                <?php elseif ($q->tipe == 'pilihan_ganda'): ?>
                  <?php foreach (explode(',', $q->pilihan) as $opt): $opt = trim($opt); ?>
                    <div class="form-check">
                      <input type="radio" class="form-check-input"
                             name="pertanyaan[<?= $q->id ?>]" value="<?= $opt ?>"
                             <?= ($value === $opt) ? 'checked' : '' ?>
                             <?= $q->is_required ? 'required' : '' ?>>
                      <label class="form-check-label"><?= $opt ?></label>
                    </div>
                  <?php endforeach; ?>

                <?php elseif ($q->tipe == 'skala'): ?>
                  <select name="pertanyaan[<?= $q->id ?>]" class="form-select" <?= $q->is_required ? 'required' : '' ?>>
                    <option value="">-- Pilih --</option>
                    <?php foreach (explode(',', $q->pilihan) as $opt): $opt = trim($opt); ?>
                      <option value="<?= $opt ?>" <?= ($value === $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                    <?php endforeach; ?>
                  </select>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary" id="prevBtn" disabled><i class="bx bx-left-arrow-alt"></i> Sebelumnya</button>
        <button type="button" class="btn btn-primary" id="nextBtn">Selanjutnya <i class="bx bx-right-arrow-alt"></i></button>
        <button type="submit" class="btn btn-success d-none" id="submitBtn"><i class="bx bx-send"></i> Kirim</button>
      </div>
    </form>
  </div>
</div>

<script>
  const pages = document.querySelectorAll('.question-page');
  let currentPage = 0;

  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const submitBtn = document.getElementById('submitBtn');

  function updatePage() {
    pages.forEach((page, i) => {
      page.style.display = i === currentPage ? 'block' : 'none';
    });

    prevBtn.disabled = currentPage === 0;
    nextBtn.classList.toggle('d-none', currentPage === pages.length - 1);
    submitBtn.classList.toggle('d-none', currentPage !== pages.length - 1);
  }

  prevBtn.addEventListener('click', () => {
    if (currentPage > 0) {
      currentPage--;
      updatePage();
    }
  });

  nextBtn.addEventListener('click', () => {
    if (currentPage < pages.length - 1) {
      currentPage++;
      updatePage();
    }
  });

  updatePage();
</script>
