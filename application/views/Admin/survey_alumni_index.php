<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><i class="bx bx-list-check me-2"></i> Hasil Survey Alumni</h4>

    <div class="mb-3">
      <input type="text" id="searchInput" class="form-control" placeholder="Cari nama alumni...">
    </div>

    <div id="surveyContent"></div>
  </div>
</div>

<script>
  let currentPage = 0;

  function loadSurveyData(page = 0) {
    const search = document.getElementById('searchInput').value;
    fetch("<?= base_url('surveyalumni/load_data') ?>?page=" + page + "&search=" + encodeURIComponent(search))
      .then(res => res.text())
      .then(html => {
        document.getElementById('surveyContent').innerHTML = html;
        currentPage = page;
      });
  }

  document.getElementById('searchInput').addEventListener('input', () => {
    loadSurveyData(0);
  });

  document.addEventListener('DOMContentLoaded', () => {
    loadSurveyData();
  });

  function goToPage(page) {
    loadSurveyData(page);
  }
</script>
