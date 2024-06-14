const toggleSidebar = document.getElementById('toggle-sidebar');
const sidebar = document.getElementById('sidebar');

// Add an event listener for the window resize event
window.addEventListener('resize', function() {
  if (window.innerWidth <= 768) {
    document.body.classList.add('sidebar-collapsed');
    sidebar.classList.add('hidden');
  } else {
    document.body.classList.remove('sidebar-collapsed');
    sidebar.classList.remove('hidden');
  }
});

// Add an event listener for the toggle-sidebar button click event
toggleSidebar.addEventListener('click', () => {
  sidebar.classList.toggle('hidden');
});

// Collapse the sidebar if the window width is less than or equal to 768 pixels on load
window.addEventListener('load', function() {
  if (window.innerWidth <= 768) {
    document.body.classList.add('sidebar-collapsed');
    sidebar.classList.add('hidden');
  }
});
