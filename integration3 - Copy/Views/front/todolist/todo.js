const socket = io("http://localhost:3000");

let completedTasksCount = 0; // Counter for tasks in the "Done" column
let mood = ""; // Default mood

const taskInput = document.getElementById("taskInput");
const taskList = document.getElementById("taskList");
const addTaskButton = document.getElementById("addTaskButton");
const inProgressList = document.getElementById("inProgressList");
const doneList = document.getElementById("doneList");
// Get plan_name from URL
const urlParams = new URLSearchParams(window.location.search);
const planName = urlParams.get('planName');  // This will give you the 'planName' from the URL query string
if (planName) {
    planNameDisplay.textContent = planName; // Set plan name
    planNameDisplay.style.fontWeight = "bold";
} else {
    planNameDisplay.textContent = "No Plan Selected"; // Fallback if no plan name is passed
}

// Initialize task list when connected
socket.on("initialize", () => {
    // Get tasks from the server
    socket.emit("get tasks");
});

// Listen for new tasks from the server
    socket.on("add task", (task) => {
        document.getElementById("error-message").textContent = "";
        addTaskToDOM(task);
    });
    document.getElementById("taskInput").addEventListener("input", () => {
    document.getElementById("error-message").textContent = ""; // Clear error message
    });

    // Listen for task deletions
    socket.on("delete task", (taskId) => {
        deleteTaskFromDOM(taskId);
    });
// Listen for task updates
socket.on("update task", (updatedTask) => {
    const taskElement = document.getElementById(updatedTask.id);
    if (taskElement) {
        const taskText = taskElement.querySelector(".task-text");
        taskText.textContent = updatedTask.text;
        if (updatedTask.completed) {
            taskElement.classList.add("completed");
            doneList.appendChild(taskElement);
        } else {
            taskElement.classList.remove("completed");
            inProgressList.appendChild(taskElement);
        }
    }
});
socket.on("task error", (error) => {
// Display the error message to the user
const errorContainer = document.getElementById("error-message");
if (errorContainer) {
    errorContainer.textContent = error.message;
    errorContainer.style.color = "red";
    }
});

// Add a new task
addTaskButton.addEventListener("click", () => {
const taskText = taskInput.value.trim();
if (taskText && planName) { // Ensure planName exists
const task = {
    id: Date.now().toString(),
    text: taskText,
    completed: false,
    plan_name: planName // Pass plan_name from URL
};
socket.emit("add task", task); // Emit task to the server with plan_name
taskInput.value = ""; // Clear input
}
});


// Function to add task to the DOM
function addTaskToDOM(task) {
    const taskElement = document.createElement("div");
    taskElement.id = task.id;
    taskElement.classList.add("task");
    taskElement.setAttribute("draggable", true);
    taskElement.ondragstart = (event) => {
        event.dataTransfer.setData("text/plain", task.id);
    };

    taskElement.innerHTML = `
        <span class="task-text">${task.text}</span>
        <button onclick="deleteTask('${task.id}')">Delete</button> <br>
        <button class="edit-task-button">Edit</button>

    `;
    taskList.appendChild(taskElement);
}

// Function to delete a task
function deleteTask(taskId) {
    socket.emit("delete task", taskId);
}

// Function to remove task from DOM
function deleteTaskFromDOM(taskId) {
    const taskElement = document.getElementById(taskId);
    if (taskElement) {
        taskElement.remove();
    }
}

// Allow dropping tasks into columns
function allowDrop(event) {
    event.preventDefault();
}

// Handle task drop into a column (mark as completed or not)
function drop(event) {
    event.preventDefault();
    const taskId = event.dataTransfer.getData("text/plain");
    const taskElement = document.getElementById(taskId);
    const taskText = taskElement.querySelector('.task-text').textContent;

    if (taskElement) {
        const columnId = event.target.id;
        let completed = false;
        let inProgress = false;
        let newEtat = 'To Do'; // Default state

        if (columnId === "doneColumn") {
            taskElement.classList.add("completed");
            completed = true;
            newEtat = 'Done';
            doneList.appendChild(taskElement);
        } else if (columnId === "inProgressColumn") {
            taskElement.classList.remove("completed");
            inProgress = true;
            newEtat = 'In Progress';
            inProgressList.appendChild(taskElement);
        } else {
            taskElement.classList.remove("completed");
            newEtat = 'To Do';
            taskList.appendChild(taskElement);
        }

        // Emit the updated task with the correct 'etat' value
        socket.emit("update task", {
            id: taskId,
            completed,
            inProgress,
            text: taskText,
            etat: newEtat
        });
    }
}
/////mood badge //
document.getElementById("doneColumn").addEventListener("drop", (event) => {
    event.preventDefault();

    // Increment completed tasks counter
    completedTasksCount++;

    // Check if user qualifies for a badge
    if (completedTasksCount === 3) {
        const badgeName = badges[mood]; // Use currentMood for checking the badge
        if (badgeName) {
            showBadgePopup(badgeName);
        }
        completedTasksCount = 0; // Reset the counter
    }
});


////////////////////edit task name////////////////////////////

// Add event listener for the edit buttons after the DOM loads
document.addEventListener("click", (event) => {
    if (event.target.classList.contains("edit-task-button")) {
        const taskElement = event.target.closest(".task");
        const taskId = taskElement.id;
        const taskTextSpan = taskElement.querySelector(".task-text");

        const newTaskName = prompt("Enter the new task name:", taskTextSpan.textContent);

        if (newTaskName && newTaskName.trim() !== "") {
            socket.emit("modify task name", {
                id: taskId,
                text: newTaskName.trim(),
            });
        }
    }
});

// Listen for the updated task from the server
socket.on("modify task name", (updatedTask) => {
    const taskElement = document.getElementById(updatedTask.id);
    if (taskElement) {
        const taskTextSpan = taskElement.querySelector(".task-text");
        taskTextSpan.textContent = updatedTask.text;
    }
});


// Listen for task name errors from the server
socket.on("task error", (error) => {
    alert(error.message); // Display error to the user
});

////////////////mood suggestions 
const moodSelector = document.getElementById('mood');
const suggestionText = document.getElementById('suggestion-text');
const suggestionsContainer = document.getElementById('suggestions-container'); // Add this container in HTML

const suggestions = {
neutral: [
"Take a moment to review your tasks and organize your day. 📝",
"A good time to reflect on your progress so far. 🤔",
"Start by tackling the easiest task on your list to gain momentum. 💪",
"Write down three things you're grateful for today. 🙏",
"Set a timer for 15 minutes to focus on one task. ⏳",
"Rearrange your workspace to feel more productive. 🖥️"
],
stressed: [
"Try a short breathing exercise before tackling your to-do list. 🌬️",
"Take a break and step outside for a few minutes. ☀️",
"Focus on one task at a time, take it slow. 🧘",
"Drink some water to refresh your mind and body. 💧",
"Take a 5-minute stretch break to relieve tension. 🤸‍♀️",
"Close your eyes for a few seconds and breathe deeply. 😌",
"Set a small, achievable goal to get started. 🎯",
"Try listening to calming music for a few minutes. 🎶"
],
motivated: [
"Challenge yourself to finish an extra task today! 🚀",
"Set a personal goal to accomplish two tasks before the end of the day. 🎯",
"Push yourself to start a new task and complete it today! 💥",
"Visualize the satisfaction of completing your tasks. 🌟",
"Give yourself a reward for completing a task, even a small one. 🎉",
"Take a moment to celebrate your progress so far. 🏅",
"Break your tasks into steps and conquer them one by one. 🧗‍♀️",
"Try to exceed your expectations and surprise yourself today! 💪"
]
};

moodSelector.addEventListener('change', function () {
mood = moodSelector.value;
const moodSuggestions = suggestions[mood];
// Clear previous content
suggestionText.textContent = '';
if (moodSuggestions && moodSuggestions.length > 0) {
// Generate a random suggestion
const randomSuggestion = moodSuggestions[Math.floor(Math.random() * moodSuggestions.length)];
suggestionText.textContent = randomSuggestion;
 // Debugging: Output the current mood for verification
 console.log("Current mood:",mood);
} else {
suggestionText.textContent = "Select a mood to see suggestions! 😊";
}
} );


// Badge details
const badges = {
    stressed: "Pressure Pro",
    motivated: "Motivation King",
    neutral: "Calm Achiever"
};

// Function to show badge popup
function showBadgePopup(badgeName) {
    // Create a popup container
    const badgePopup = document.createElement("div");
    badgePopup.className = "badge-popup";

    // Add animation and sound
    const twinkleSound = new Audio("twinkle.mp3");
    twinkleSound.play();

    // Check badge name and set the corresponding image and message
    if (badgeName === "Pressure Pro") {
        badgePopup.innerHTML = `
           <div id="badge-popup" class="badge-popup">
                <img id="badge-image" src="images/Pressure Pro.png" alt="Badge" class="badge-image">
                <div class="badge-text">Congratulations! Pressure Pro Unlocked!</div>
            </div>
        `;
    } else if (badgeName === "Motivation King") {
        badgePopup.innerHTML = `
           <div id="badge-popup" class="badge-popup">
                <img id="badge-image" src="images/Motivation King.png" alt="Badge" class="badge-image">
                <div class="badge-text">Congratulations! Motivation King Unlocked!</div>
            </div>
        `;
    } else if (badgeName === "Calm Achiever") {
        badgePopup.innerHTML = `
           <div id="badge-popup" class="badge-popup">
                <img id="badge-image" src="images/Calm Achiever.png" alt="Badge" class="badge-image">
                <div class="badge-text">Congratulations! Calm Achiever Unlocked!</div>
            </div>
        `;
    }
   // Show the badge popup by setting display to block
   badgePopup.style.display = 'block';

   // Append the badge popup to the body
    document.body.appendChild(badgePopup);
    // Remove popup after 5 seconds
    setTimeout(() => {
        badgePopup.remove();
    }, 5000);
     // Generate and download PDF certificate, passing the badgePopup element
     generateCertificate(badgeName, planName, badgePopup);
}

// Function to generate and download PDF certificate
function generateCertificate(badgeName, planName, badgePopupElement) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape'); // Set orientation to landscape

    // Create a temporary container for the certificate content and frame
    const certificateContainer = document.createElement('div');
    certificateContainer.style.width = `${doc.internal.pageSize.getWidth()}mm`; // Set width based on PDF page width
    certificateContainer.style.height = `${doc.internal.pageSize.getHeight()}mm`; // Set height based on PDF page height
    certificateContainer.style.position = 'relative'; // Needed for absolute positioning of children
    certificateContainer.style.background = '#ffffff'; // Set a background color
    certificateContainer.style.padding = '20mm'; // Add padding for content inside the frame
    certificateContainer.style.boxSizing = 'border-box'; // Include padding in width/height
    certificateContainer.style.textAlign = 'center'; // Center text content
    certificateContainer.style.fontFamily = 'Arial, sans-serif'; // Set a default font

    // Add the frame image as a background or positioned element
    const frameImg = document.createElement('img');
    frameImg.src = 'images/frame.png'; // Path to your frame image
    frameImg.style.position = 'absolute';
    frameImg.style.top = '0';
    frameImg.style.left = '0';
    frameImg.style.width = '100%';
    frameImg.style.height = '100%';
    frameImg.style.zIndex = '1'; // Ensure frame is behind content
    certificateContainer.appendChild(frameImg);

    // Create a content container to layer above the frame
    const contentContainer = document.createElement('div');
    contentContainer.style.position = 'relative';
    contentContainer.style.zIndex = '2'; // Ensure content is above the frame
    contentContainer.style.display = 'flex';
    contentContainer.style.flexDirection = 'column';
    contentContainer.style.alignItems = 'center';
    contentContainer.style.justifyContent = 'center';
    contentContainer.style.height = '100%'; // Take full height of parent

    // Add Header
    const header = document.createElement('h1');
    header.textContent = 'Achievement Certificate';
    header.style.fontSize = '48px'; // Adjusted font size
    header.style.marginBottom = '25px'; // Adjusted margin
    header.style.color = 'darkred';
    header.style.fontWeight = 'bold';
    contentContainer.appendChild(header);

    // Add Congratulatory Message
    const message = document.createElement('p');
    message.textContent = `This certificate is proudly presented to ${username} !`;
    message.style.fontSize = '20px'; // Adjusted font size
    message.style.marginBottom = '25px'; // Adjusted margin
    message.style.color = '#333';
    contentContainer.appendChild(message);

    // Add the badge image (clone from the badgePopupElement)
    const badgeImageElement = badgePopupElement.querySelector('.badge-image').cloneNode(true);
    badgeImageElement.style.width = '150px'; // Adjusted size slightly
    badgeImageElement.style.height = 'auto';
    badgeImageElement.style.marginBottom = '20px'; // Adjusted margin

    contentContainer.appendChild(badgeImageElement);

    // Add Details about the achievement
    const achievementDetails = document.createElement('p');
    achievementDetails.textContent = `For successfully earning the '${badgeName}' badge.`;
    achievementDetails.style.fontSize = '18px'; // Adjusted font size
    achievementDetails.style.marginBottom = '20px'; // Adjusted margin
    achievementDetails.style.color = '#555';
    contentContainer.appendChild(achievementDetails);

    // Add Plan Name if available
    if (planName) {
        const planDetail = document.createElement('p');
        planDetail.textContent = `In recognition of your efforts in the plan: ${planName}`;
        planDetail.style.fontSize = '16px'; // Adjusted font size
        planDetail.style.marginBottom = '20px'; // Adjusted margin
        planDetail.style.fontStyle = 'italic';
        planDetail.style.color = '#666';
        contentContainer.appendChild(planDetail);
    }

    // Add Date Awarded
    const dateAwarded = document.createElement('p');
    const today = new Date();
    const dateString = today.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    dateAwarded.textContent = `Date Awarded: ${dateString}`;
    dateAwarded.style.fontSize = '16px'; // Adjusted font size
    dateAwarded.style.color = '#777';
    contentContainer.appendChild(dateAwarded);

    // Append the content container to the main certificate container
    certificateContainer.appendChild(contentContainer);

    // Temporarily add the container to the body for html2canvas to capture
    document.body.appendChild(certificateContainer);

    // Use html2canvas to capture the temporary container element

    html2canvas(certificateContainer, {
        scale: 2 // Improve resolution
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = doc.internal.pageSize.getWidth();
        const imgHeight = doc.internal.pageSize.getHeight();

        // Add the captured image of the container (with frame and content) to the PDF
        doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

        doc.save(`${badgeName}_certificate.pdf`);

        // Remove the temporary container from the DOM
        certificateContainer.remove();
    });
}

///////////////////////////////////////////////////////////////////////////////////////
window.onload = function() {
    const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
    if (shadowRoot) {
        const logo = shadowRoot.querySelector('#logo');
        if (logo) logo.remove();
    }
    
    // Initialize draggable tasks and attach delete button listeners
    const tasks = document.querySelectorAll('.task');
    tasks.forEach(task => {
        task.setAttribute('draggable', 'true');
        
        // Add event listener for the delete button
        const deleteButton = task.querySelector('button');
        deleteButton.addEventListener('click', () => {
            const taskId = task.id;
            deleteTask(taskId); // Emit task deletion via socket
        });

        // Ensure the task is draggable
        task.ondragstart = (event) => {
            event.dataTransfer.setData("text/plain", task.id);
        };
    });

    // Reinitialize drop events after page refresh
    const columns = document.querySelectorAll('.column');
    columns.forEach(column => {
        column.ondrop = drop;
        column.ondragover = allowDrop;
    });
};
