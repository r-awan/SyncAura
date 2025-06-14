function startFaceRecognition() {
  document
    .getElementById("face-login-btn")
    .addEventListener("click", function () {
      console.log("Facial recognition started");

      const video = document.getElementById("video");
      const canvas = document.getElementById("canvas");
      const context = canvas.getContext("2d");
      const container = document.getElementsByClassName("video-canvas-container");
      container.hidden=false;

      // Start camera stream
      navigator.mediaDevices
        .getUserMedia({ video: true })
        .then(function (stream) {
          video.srcObject = stream;
          video.hidden = false; // Show the video element
          video.play();

          // Allow video feed to stabilize
          setTimeout(() => {
            playVideo();
          }, 2000);
        })
        .catch(function (error) {
          console.error("Error accessing the camera: ", error);
          setErrorMessage(
            "Unable to access the camera. Please check permissions."
          );
        });

      function playVideo() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
        video.hidden = true; // Hide video after capturing
        const imageData = canvas.toDataURL("image/png");
        console.log("image data js: ", imageData);
        canvas.hidden = true;
        document.body.style.cursor = "wait";
        console.log("Sending image to server...");
        setInfoMessage("Verifying Face ID...");

        // Send captured image data to the server
        fetch("../faceid/login_with_face.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `image_data=${encodeURIComponent(imageData)}`,
        })
          .then((response) => response.json())
          .then((data) => {
            console.log("Server response:", data);
            if (data.success) {
              console.log("Face ID detected:", data.face_id); // Log face ID
              setInfoMessage(data.message);
              setTimeout(()=>{window.location.href = data.redirect}, 2000); // Redirect to profile page
              document.body.style.cursor = "pointer";
              stopVideoStream(video);
            } else {
              console.error("Error from server:", data.message);
              setErrorMessage(data.message);
              stopVideoStream(video);
            }
          })
          .catch(function (error) {
            console.error("Error in fetch request:", error);
            setErrorMessage("An error occurred while processing the request.");
            stopVideoStream(video);
          });
      }
    });
}

function stopVideoStream(video) {
  const stream = video.srcObject;
  if (stream) {
    const tracks = stream.getTracks();
    tracks.forEach(function (track) {
      track.stop();
    });
    video.srcObject = null; // Clear the source after stopping
  }
  video.hidden = true; // Hide video element
}

function setErrorMessage(message) {
  const form = document.querySelector("form"); // Ensure the form exists
  if (!form) {
    console.error("Form element not found.");
    return;
  }

  // Remove existing messages
  const existingMessages = form.querySelectorAll(".info-message");
  existingMessages.forEach((msg) => msg.remove());

  const messageElement = document.createElement("small");
  messageElement.className = "info-message";
  messageElement.textContent = message;
  messageElement.style.color = "red"; // Customize the color as needed
  messageElement.style.backgroundColor = "#ffd0d0";
  messageElement.style.borderLeftColor = "lightcoral";
  form.prepend(messageElement);
}
function setInfoMessage(message) {
  const form = document.querySelector("form"); // Ensure the form exists
  if (!form) {
    console.error("Form element not found.");
    return;
  }

  // Remove existing messages
  const existingMessages = form.querySelectorAll(".info-message");
  existingMessages.forEach((msg) => msg.remove());

  const messageElement = document.createElement("small");
  messageElement.className = "info-message";
  messageElement.textContent = message;
  messageElement.style.color = "green"; // Customize the color as needed
  form.prepend(messageElement);
}
