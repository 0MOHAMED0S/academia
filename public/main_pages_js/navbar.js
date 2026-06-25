// ─── Notifications System ─────────────────────────────────────────────────
(function() {
  var POLL_INTERVAL = 30000;
  var notifBadge = document.getElementById('notifBadge');
  var notifDropdown = document.getElementById('notifDropdown');
  var notifList = document.getElementById('notifList');
  var notifEmpty = document.getElementById('notifEmpty');
  var notifFooter = document.getElementById('notifFooter');

  if (!notifBadge || !notifDropdown || !notifList) return;

  function loadNotifications() {
    fetch('/notifications/api')
      .then(function(r) { return r.json(); })
      .then(function(data) {
        updateNotificationUI(data.notifications, data.unread_count);
      })
      .catch(function() {});
  }

  function updateNotificationUI(notifications, unreadCount) {
    if (unreadCount > 0) {
      notifBadge.style.display = 'flex';
      notifBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
    } else {
      notifBadge.style.display = 'none';
    }

    if (!notifications || notifications.length === 0) {
      notifList.innerHTML = '';
      if (notifEmpty) notifEmpty.style.display = 'block';
      if (notifFooter) notifFooter.style.display = 'none';
      return;
    }

    if (notifEmpty) notifEmpty.style.display = 'none';
    if (notifFooter) notifFooter.style.display = 'block';

    notifList.innerHTML = notifications.map(function(n) {
      return '<div class="notif-item ' + (n.is_read ? '' : 'unread') + '" data-id="' + n.id + '" onclick="markNotifRead(' + n.id + ')">' +
        '<div class="d-flex justify-content-between">' +
          '<strong>' + (n.type === 'video_deleted' ? 'حذف فيديو' : 'إشعار') + '</strong>' +
          '<small class="notif-time">' + escapeHtml(n.created_at) + '</small>' +
        '</div>' +
        '<p class="mb-0 small">' + escapeHtml(n.message) + '</p>' +
      '</div>';
    }).join('');
  }

  window.toggleNotifDropdown = function(e) {
    e.stopPropagation();
    var isOpen = notifDropdown.style.display === 'block';
    closeAllNotifDropdowns();
    if (!isOpen) {
      notifDropdown.style.display = 'block';
      loadNotifications();
    }
  };

  function closeAllNotifDropdowns() {
    document.querySelectorAll('.notif-dropdown').forEach(function(el) {
      el.style.display = 'none';
    });
  }

  window.markNotifRead = function(id) {
    fetch('/notifications/api/' + id + '/read', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': getCsrfToken() }
    })
    .then(function(r) { return r.json(); })
    .then(function() { loadNotifications(); })
    .catch(function() {});
  };

  window.markAllNotifRead = function() {
    fetch('/notifications/api/read-all', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': getCsrfToken() }
    })
    .then(function(r) { return r.json(); })
    .then(function() { loadNotifications(); })
    .catch(function() {});
  };

  function escapeHtml(text) {
    if (!text) return '';
    var div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  function getCsrfToken() {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }

  // Close dropdown on outside click
  document.addEventListener('click', function(e) {
    var container = document.getElementById('notifContainer');
    if (container && !container.contains(e.target)) {
      closeAllNotifDropdowns();
    }
  });

  // Initial load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(loadNotifications, 500);
    });
  } else {
    setTimeout(loadNotifications, 500);
  }
  setInterval(loadNotifications, POLL_INTERVAL);
})();
