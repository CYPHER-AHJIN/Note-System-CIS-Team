function toggleNotes() {

    const section = document.getElementById("notesSection");
    const button = document.querySelector(".toggle-btn");

    const isHidden = window.getComputedStyle(section).display === "none";

    if (isHidden) {

        section.style.display = "block";
        button.innerText = "Hide Saved Notes";

        const notes = document.querySelectorAll(".note-box");

        notes.forEach((note, index) => {
            note.classList.remove("show"); 
            setTimeout(() => {
                note.classList.add("show");
            }, index * 150);
        });

    } else {

        section.style.display = "none";
        button.innerText = "Show Saved Notes";
    }
}
