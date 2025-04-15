const frontGroups = { 
 
};
const backGroups = {

};
let hoveredGroup = null;
let selectedGroups = []; // Több kijelölés támogatása
/*const ORIGINAL_WIDTH = 600;
const ORIGINAL_HEIGHT = 1280;*/


function drawOverlayForCanvas(canvas, ctx) {
ctx.clearRect(0, 0, canvas.width, canvas.height);

const isBack = canvas.id === "overlay1";
const groupsToUse = isBack ? backGroups : frontGroups;

const scaleX = canvas.width / 600;
const scaleY = canvas.height / 1280;

Object.entries(groupsToUse).forEach(([group, data]) => {
  const isHovered = hoveredGroup === group;
  const isSelected = selectedGroups.includes(group);

  const color = isSelected
    ? data.selectedColor
    : (isHovered ? data.color : null);

  if (color) {
    data.areas.forEach(coords => {
      if (coords.length < 6 || coords.length % 2 !== 0) return;
      ctx.beginPath();
      ctx.moveTo(coords[0] * scaleX, coords[1] * scaleY);
      for (let i = 2; i < coords.length; i += 2) {
        ctx.lineTo(coords[i] * scaleX, coords[i + 1] * scaleY);
      }
      ctx.closePath();
      ctx.fillStyle = color;
      ctx.fill();
    });
  }
});
}

function drawAllOverlays() {
const canvases = ['overlay1', 'overlay2'];
canvases.forEach(id => {
  const canvas = document.getElementById(id);
  const ctx = canvas.getContext('2d');
  drawOverlayForCanvas(canvas, ctx);
});
}

function highlightGroup(group, active) {
hoveredGroup = active ? group : null;
drawAllOverlays();
}

function selectGroup(group) {
// Ha már kijelölt, vegyük ki. Ha nem, adjuk hozzá.
if (selectedGroups.includes(group)) {
  selectedGroups = selectedGroups.filter(g => g !== group);
} else {
  selectedGroups.push(group);
}
drawAllOverlays();
}

function resizeCanvasToMatchImage(imgId, canvasId) {
const img = document.getElementById(imgId);
const canvas = document.getElementById(canvasId);
const rect = img.getBoundingClientRect();

canvas.width = rect.width;
canvas.height = rect.height;
}

function resizeAll() {
resizeCanvasToMatchImage("imgFront", "overlay2");
resizeCanvasToMatchImage("imgBack", "overlay1");
drawAllOverlays(); // <- ezt most már mindig hívd meg, hogy újrarajzolja
}

window.addEventListener("resize", resizeAll);
window.addEventListener("load", resizeAll);const imgFront = document.getElementById("imgFront");
const imgBack = document.getElementById("imgBack");

imgFront.addEventListener("load", resizeAll);
imgBack.addEventListener("load", resizeAll);

// Plusz fallback ha mégis üres maradna:
window.addEventListener("resize", resizeAll);

if (imgFront.complete) resizeCanvasToMatchImage("imgFront", "overlay2");
if (imgBack.complete) resizeCanvasToMatchImage("imgBack", "overlay1");
drawAllOverlays();

/*function resizeCanvasToMatchImage(img, canvas) {
const rect = img.getBoundingClientRect();
canvas.width = rect.width;
canvas.height = rect.height;
}

// Példa használat:
const imgFront = document.getElementById("imgFront");
const canvasOverlay2 = document.getElementById("overlay2");

window.addEventListener("resize", () => {
resizeCanvasToMatchImage(imgFront, canvasOverlay2);
});

// Első betöltéskor is hívd meg:
resizeCanvasToMatchImage(imgFront, canvasOverlay2);


function resizeCanvasToMatchImage(imgId, canvasId) {
const img = document.getElementById(imgId);
const canvas = document.getElementById(canvasId);
const rect = img.getBoundingClientRect();

canvas.width = rect.width;
canvas.height = rect.height;
}

// Meghívás resize-nál és betöltéskor:
function resizeAll() {
resizeCanvasToMatchImage("imgFront", "overlay2");
resizeCanvasToMatchImage("imgBack", "overlay1");
}

window.addEventListener("resize", resizeAll);
window.addEventListener("load", resizeAll);*/
