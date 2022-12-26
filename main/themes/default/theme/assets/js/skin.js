var $username = $('[data-toggle="3dskin"]').attr("skin-username");
let skinViewer = new skinview3d.SkinViewer({
  canvas: document.getElementById("skin_container"),
  width: 200,
  height: 266,
  skin: "https://minotar.net/skin/" + $username
});
let control = skinview3d.createOrbitControls(skinViewer);
control.enableRotate = true;
control.enableZoom = false;
control.enablePan = false;
let walk = skinViewer.animations.add(skinview3d.WalkingAnimation);
let idle;
skinViewer.animations.paused = false;

function skinPause() {
  document.getElementById("skinUnPause").classList.remove("!hidden");
  document.getElementById("skinPause").classList.add("!hidden");
  skinViewer.animations.paused = true;
}

function skinUnPause() {
  document.getElementById("skinPause").classList.remove("!hidden");
  document.getElementById("skinUnPause").classList.add("!hidden");
  skinViewer.animations.paused = false;
}

function skinWalk() {
  document.getElementById("skinWalk").classList.remove("!hidden");
  document.getElementById("skinIdle").classList.add("!hidden");
  if (idle !== undefined) idle.resetAndRemove();
  walk = skinViewer.animations.add(skinview3d.WalkingAnimation);
}

function skinIdle() {
  document.getElementById("skinIdle").classList.remove("!hidden");
  document.getElementById("skinWalk").classList.add("!hidden");
  if (walk !== undefined) walk.resetAndRemove();
  skinViewer.fov = 70;
  idle = skinViewer.animations.add(skinview3d.IdleAnimation);
}