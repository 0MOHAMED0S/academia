document.addEventListener('DOMContentLoaded', function() {
  // تشغيل AOS
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      once: true
    });
  }

  // ==========================
  // تخزين البيانات
  // ==========================
  var courses = JSON.parse(localStorage.getItem("courses")) || [];
  var instructors = JSON.parse(localStorage.getItem("instructors")) || [];

  //exam
  var cards = document.querySelectorAll(".track-card");
  var examBtn = document.getElementById("examBtn");

  var selectedTrack = null;

  if (cards.length && examBtn) {
    cards.forEach(function(card) {
      card.addEventListener("click", function() {
        cards.forEach(function(c) { c.classList.remove("active"); });
        card.classList.add("active");
        selectedTrack = card.dataset.track;
        examBtn.disabled = false;
      });
    });

    examBtn.addEventListener("click", function() {
      if (selectedTrack) {
        window.location.href = 'exam.html?track=' + selectedTrack;
      }
    });
  }

  // ==========================
  // البحث
  // ==========================
  var searchForm = document.getElementById("searchForm");
  if (searchForm) {
    searchForm.addEventListener("submit", function(e) {
      e.preventDefault();
      var value = document.getElementById("searchInput").value.toLowerCase();
      document.querySelectorAll(".course-card").forEach(function(card) {
        var titleEl = card.querySelector(".card-title");
        if (titleEl) {
          var title = titleEl.innerText.toLowerCase();
          card.parentElement.style.display = title.includes(value) ? "block" : "none";
        }
      });
    });
  }
});
