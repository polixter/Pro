// Tailwind CSS Configuration
tailwind.config = {
  content: ["/**/*.html", "/**/*.php"],
  darkMode: "class"
};

// Dark Mode Toggle Script
if (
  localStorage.getItem("color-theme") === "dark" ||
  (!("color-theme" in localStorage) &&
    window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
  document.documentElement.classList.add("dark");
} else {
  document.documentElement.classList.remove("dark");
}

// Plant Search and Load Script
function searchPlants() {
  var search = document.getElementById("search").value;
  var sunRequirement = document.getElementById("sun-requirements").value;
  var category = document.getElementById("category").value;
  var toxicity = document.getElementById("toxicity").value;

  if (search.length >= 2 || sunRequirement || category || toxicity) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../search.php?search=" + search + "&sun_requirements=" + sunRequirement + "&category=" + category +
      "&toxicity=" + toxicity, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        var resultsElement = document.getElementById("results");
        if (resultsElement) {
          resultsElement.innerHTML = xhr.responseText;
        } else {
          console.error("Element with ID 'results' not found.");
        }
      }
    };
    xhr.send();
  } else {
    loadAllPlants();
  }
}

function loadAllPlants() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../search.php?search=&sun_requirements=&category=&toxicity=", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var resultsElement = document.getElementById("results");
      if (resultsElement) {
        resultsElement.innerHTML = xhr.responseText;
      } else {
        console.error("Element with ID 'results' not found.");
      }
    }
  };
  xhr.send();
}

window.onload = function () {
  loadAllPlants();
};

// Theme Toggle Script
var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

if (
  localStorage.getItem("color-theme") === "dark" ||
  (!("color-theme" in localStorage) &&
    window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
  themeToggleLightIcon.classList.remove("hidden");
} else {
  themeToggleDarkIcon.classList.remove("hidden");
}

var themeToggleBtn = document.getElementById("theme-toggle");

themeToggleBtn.addEventListener("click", function () {
  themeToggleDarkIcon.classList.toggle("hidden");
  themeToggleLightIcon.classList.toggle("hidden");

  if (localStorage.getItem("color-theme")) {
    if (localStorage.getItem("color-theme") === "light") {
      document.documentElement.classList.add("dark");
      localStorage.setItem("color-theme", "dark");
    } else {
      document.documentElement.classList.remove("dark");
      localStorage.setItem("color-theme", "light");
    }
  } else {
    if (document.documentElement.classList.contains("dark")) {
      document.documentElement.classList.remove("dark");
      localStorage.setItem("color-theme", "light");
    } else {
      document.documentElement.classList.add("dark");
      localStorage.setItem("color-theme", "dark");
    }
  }
});
