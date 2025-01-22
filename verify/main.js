window.onload = function() {
  const panelImgs = document.querySelectorAll(".panel-img");
  panelImgs.forEach(function(panelImg) {
    panelImg.addEventListener("click", function() {
      const checkMark = this.nextElementSibling;
      checkMark.classList.toggle("hidden");
    });
  });
};

function clickConfirm() {
  let elem = document.getElementById("dark-layer");
  elem.classList.remove("hidden");
  elem = document.getElementById("popup-window");
  elem.classList.remove("hidden");
  elem = document.getElementById("txt-big");
  elem.textContent = "答え";
  elem = document.getElementById("txt-small");
  elem.textContent = "パネルをクリックして全体写真を見てみよう。";
  /*
  let ans = 0;
  if (ans==9) {
    txtSmall.textContent = "全問正解！！";
  } else {
    txtSmall.textContent = "9問中" + ans + "問正解！";
  }
  */
  let ans = 0;
  const shauns = document.getElementsByClassName("shaun");
  for (let i = 0; i < shauns.length; i++) {
    shauns[i].style.border = "4px solid rgba(55, 135, 255, 1)";
    if (shauns[i].children[1].classList.contains('hidden') == false) {
      ans++;
    }
  }
  const others = document.getElementsByClassName("other");
  for (let i = 0; i < others.length; i++) {
    if (others[i].children[1].classList.contains('hidden') == true) {
      ans++;
    }
  }
  elem = document.getElementById("answer");
  elem.textContent = ans;
  const panels = document.getElementsByClassName("overlay");
  for (let i = 0; i < panels.length; i++) {
    panels[i].classList.remove("hidden");
  }
}
function closePopup() {
  let elem = document.getElementById("dark-layer");
  elem.classList.add("hidden");
  elem = document.getElementById("popup-window");
  elem.classList.add("hidden");
}
function showImg(name) {
  const div = document.getElementById('div-' + name);
  div.classList.remove("hidden");
  const layer = document.getElementById("dark-layer");
  layer.classList.remove("hidden");
}
function closeImg(name) {
  const div = document.getElementById('div-' + name);
  div.classList.add("hidden");
  const layer = document.getElementById("dark-layer");
  layer.classList.add("hidden");
}