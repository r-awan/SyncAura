(function () {
	const socket = io("http://localhost:3100"); // Connect to server on port 3100
	let sender_uid;

	function generateID() {
		return `${Math.trunc(Math.random() * 999)}-${Math.trunc(Math.random() * 999)}-${Math.trunc(Math.random() * 999)}`;
	}

	document.querySelector("#receiver-start-con-btn").addEventListener("click", function () {
		sender_uid = document.querySelector("#join-id").value;
		if (sender_uid.length === 0) {
			alert("Please enter a valid sender ID");
			return;
		}

		let joinID = generateID();
		socket.emit("receiver-join", {
			sender_uid: sender_uid,
			uid: joinID
		});

		document.querySelector(".join-screen").classList.remove("active");
		document.querySelector(".fs-screen").classList.add("active");
	});

	let fileShare = {};

	socket.on("fs-meta", function (metadata) {
		fileShare.metadata = metadata;
		fileShare.transmitted = 0;
		fileShare.buffer = [];

		let el = document.createElement("div");
		el.classList.add("item");
		el.innerHTML = `
			<div class="progress">0%</div>
			<div class="filename">${metadata.filename}</div>
		`;
		document.querySelector(".files-list").appendChild(el);

		fileShare.progress_node = el.querySelector(".progress");

		socket.emit("fs-start", {
			uid: sender_uid
		});
	});

	socket.on("fs-share", function (buffer) {
		console.log("Buffer received", buffer);
		fileShare.buffer.push(buffer);
		fileShare.transmitted += buffer.byteLength;
		fileShare.progress_node.innerText = `${Math.trunc(fileShare.transmitted / fileShare.metadata.total_buffer_size * 100)}%`;

		if (fileShare.transmitted === fileShare.metadata.total_buffer_size) {
			console.log("Download complete: ", fileShare);
			download(new Blob(fileShare.buffer), fileShare.metadata.filename);
			fileShare = {};
		} else {
			socket.emit("fs-start", {
				uid: sender_uid
			});
		}
	});

	function download(blob, filename) {
		let link = document.createElement("a");
		link.href = URL.createObjectURL(blob);
		link.download = filename;
		link.click();
	}
})();