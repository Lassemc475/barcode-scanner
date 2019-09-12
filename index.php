<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Capturing every 300 milliseconds</h1>
    <h2>grabFrame()</h2>
    <p><canvas id="canvas" width="640" height="480"></canvas></p>
    <p><canvas id="photo" width="640" height="480"></canvas></p>

    <div id="log"></div>
  </body>
  <script>
  let videoDevice;
let canvas = document.getElementById('canvas');
let photo = document.getElementById('photo');
let failedToGetMedia = "pls";

// navigator.mediaDevices.getUserMedia({video: true}).then(gotMedia).catch(failedToGetMedia);

async function gotMedia(mediaStream) {
  // Extract video track.
  videoDevice = await mediaStream.getVideoTracks()[0];
  console.log(videoDevice)
  // Check if this device supports a picture mode...
  let captureDevice = await new ImageCapture(videoDevice);
  if (captureDevice) {
  await  captureDevice.takePhoto().then(processPhoto).catch(console.log("no1"));
    await captureDevice.grabFrame().then(processFrame).catch(console.log("no"));
    // console.log(stopCamera);
  }
}

async function processPhoto(blob) {
  photo.src = await window.URL.createObjectURL(blob);
}

async function processFrame(imageBitmap) {
  let canvas = await document.getElementById('canvas');
  canvas.width = await imageBitmap.width;
  canvas.height = await imageBitmap.height;
  console.log(imageBitmap);
  await canvas.getContext('2d').drawImage(imageBitmap, 0, 0);
}

function stopCamera(error) {
  // console.error(error);
  // if (videoDevice) videoDevice.stop();  // turn off the camera
}

navigator.mediaDevices.getUserMedia({video: true}).then(gotMedia).catch(failedToGetMedia);
photo.addEventListener('click', async function () {
  // After the image loads, discard the image object to release the memory
  console.log("test");
  await navigator.mediaDevices.getUserMedia({video: true}).then(gotMedia);

  await window.URL.revokeObjectURL(this.src);
});

  </script>
</html>
