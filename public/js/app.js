const toggleButton = document.getElementById("toggle-btn");
const sidebar = document.getElementById("sidebar");
const icon = toggleButton.querySelector("i");

function toggleSidebar() {
  sidebar.classList.toggle("close");
  toggleButton.classList.toggle("rotate");

  console.log("Sidebar toggled:", sidebar.classList.contains("close")); // Debugging

  if (sidebar.classList.contains("close")) {
    console.log("Changing to fa-bars"); // Debugging
    icon.classList.remove("fa-bars-staggered");
    icon.classList.add("fa-bars");
  } else {
    console.log("Changing to fa-bars-staggered"); // Debugging
    icon.classList.remove("fa-bars");
    icon.classList.add("fa-bars-staggered");
  }
}

// Modal Functions
function showModal() {
  document.getElementById("subjectSectionModal").style.display = "block";
}

function hideModal() {
  document.getElementById("subjectSectionModal").style.display = "none";
}

// Close modal when clicking outside content
window.onclick = function (event) {
  const modal = document.getElementById("subjectSectionModal");
  if (event.target === modal) {
    hideModal();
  }
};

// Initialize Sidebar Toggle Event Listener
document.addEventListener("DOMContentLoaded", () => {
  toggleButton.addEventListener("click", toggleSidebar);
});
