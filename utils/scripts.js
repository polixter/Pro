// Tailwind CSS Configuration
tailwind.config = {
  content: ["/**/*.html", "/**/*.php"],
  darkMode: "class",
  theme: {
    extend: {
      aspectRatio: {
        '4/3': '4 / 3',
      },
    },
  },
};

// Dark Mode Initialization
(function() {
  const isDarkMode = localStorage.getItem("color-theme") === "dark" ||
    (!localStorage.getItem("color-theme") && window.matchMedia("(prefers-color-scheme: dark)").matches);

  if (isDarkMode) {
    document.documentElement.classList.add("dark");
  } else {
    document.documentElement.classList.remove("dark");
  }
})();

// Plant Search and Load Script
window.addEventListener("load", function() {
  const categoryCheckboxes = document.querySelectorAll(".category-checkbox");
  
  categoryCheckboxes.forEach(checkbox => {
    checkbox.addEventListener("change", searchPlants);
  });

  searchPlants();
});

function searchPlants() {
  const search = document.getElementById("search").value;
  const sunRequirement = document.getElementById("sun-requirements").value;
  const toxicity = document.getElementById("toxicity").value;
  const categories = Array.from(document.querySelectorAll(".category-checkbox:checked"))
                          .map(checkbox => checkbox.value)
                          .join(",");

  const params = new URLSearchParams({
    search,
    sun_requirements: sunRequirement,
    toxicity
  });

  if (categories) {
    params.append("categories", categories);
  }

  fetch(`../search.php?${params}`)
    .then(response => response.text())
    .then(data => {
      const resultsElement = document.getElementById("results");
      if (resultsElement) {
        resultsElement.innerHTML = data;
      } else {
        console.error("Element with ID 'results' not found.");
      }
    })
    .catch(error => console.error('Error:', error));
}

function loadAllPlants() {
  fetch("../search.php?search=&sun_requirements=&toxicity=")
    .then(response => response.text())
    .then(data => {
      const resultsElement = document.getElementById("results");
      if (resultsElement) {
        resultsElement.innerHTML = data;
      } else {
        console.error("Element with ID 'results' not found.");
      }
    })
    .catch(error => console.error('Error:', error));
}

// Theme Toggle Script
document.addEventListener("DOMContentLoaded", function() {
  const themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
  const themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");
  const themeToggleBtn = document.getElementById("theme-toggle");

  const isDarkMode = localStorage.getItem("color-theme") === "dark" ||
    (!localStorage.getItem("color-theme") && window.matchMedia("(prefers-color-scheme: dark)").matches);

  if (isDarkMode) {
    themeToggleLightIcon.classList.remove("hidden");
  } else {
    themeToggleDarkIcon.classList.remove("hidden");
  }

  themeToggleBtn.addEventListener("click", () => {
    themeToggleDarkIcon.classList.toggle("hidden");
    themeToggleLightIcon.classList.toggle("hidden");

    const newTheme = document.documentElement.classList.toggle("dark") ? "dark" : "light";
    localStorage.setItem("color-theme", newTheme);
  });
});
