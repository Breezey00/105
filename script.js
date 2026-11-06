// ===== Data: my projects =====

/*objects named "projects" with their sets of values.
 In this case, projects with a set of their titles and notes.
 Title and notes are fields of the object "project"*/

const projects = [
    { title: "Profile Page", note: "My first HTML page", difficulty: "no" },
    { title: "Contact Page", note: "A form and a schedule table", difficulty: "maybe"  },
    { title: "Responsive Site", note: "Works on phone and desktop", difficulty: "kinda" }
    //added another property called "difficulty"
];

// ===== Functions: build and show the cards =====
    /* CardHTML recieves the Array and its index, 
    it then returns the title and note values in a card format
    as extracted by the CardHTML function*/

function cardHTML(p) {
    return "<div class='card'>" +
    "<h3>" + p.title + "</h3>" +
    "<p>" + p.note + "</p>" +
     "<p>" + p.difficulty + "</p>" + // added the property "difficulty" to appear in the card 
    "</div>";
}

    /* it gets the values of "projects" and "count" from html page
    and "familiarizes" with it so it knows where to return values.
    Then whatever projects or count values it gets in lists
    it  returns in cards and which count is it among the total */

function renderItems(list) {
    const box = document.getElementById("projects");
    const count = document.getElementById("count");

     /*when there are no matching values assigned
      on the list parameter it returns the text 
      "No matching Projects", while if there are values 
      matching the parameters, it returns in the html box 
      what matches it that is inside the provided list.
      according to the format set by cardHTML*/
    if (list.length === 0) {
        box.innerHTML = "<p>No matching projects.</p>";
    } else {
        box.innerHTML = list.map(cardHTML).join("");
    }

    // the number of the project among the total list of projects
    count.textContent = "Showing " + list.length +
    " of " + projects.length + " projects";
}

// ===== Page load =====
// to activate the function and assign the projects const as its parameter.
//feeding it basically
renderItems(projects);

    // ===== Live search filter =====
    const search = document.getElementById("search");

        /* it "listens" for an "input" to happen on the element with the
        id named "search" then */
    search.addEventListener("input", function () {

        const term = search.value.toLowerCase();

       
            // the projects that have matching characters to "term" 
         const matches = projects.filter(function (p) {

            return p.title.toLowerCase().includes(term);
         });

        renderItems(matches);
    });
