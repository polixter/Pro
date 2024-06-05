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
window.onload = function () {
  // Adiciona eventos de mudança aos checkboxes
  var categoryCheckboxes = document.querySelectorAll(".category-checkbox");
  categoryCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener("change", function() {
      searchPlants();
    });
  });

  // Chama a função searchPlants para carregar os resultados iniciais
  searchPlants();
};

function searchPlants() {
  var search = document.getElementById("search").value;
  var sunRequirement = document.getElementById("sun-requirements").value;
  var categoryCheckboxes = document.querySelectorAll(".category-checkbox:checked");
  var toxicity = document.getElementById("toxicity").value;

  var categories = Array.from(categoryCheckboxes).map(checkbox => checkbox.value).join(",");

  // Construir a URL de requisição corretamente
  var url = "../search.php?search=" + encodeURIComponent(search) + "&sun_requirements=" + encodeURIComponent(sunRequirement) +
            "&toxicity=" + encodeURIComponent(toxicity);

  // Adiciona o parâmetro de categorias apenas se houver categorias selecionadas
  if (categories) {
    url += "&categories=" + encodeURIComponent(categories);
  }

  var xhr = new XMLHttpRequest();
  xhr.open("GET", url, true);
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

function loadAllPlants() {
  var xhr = new XMLHttpRequest();
  var url = "../search.php?search=&sun_requirements=&toxicity=";
  
  xhr.open("GET", url, true);
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
