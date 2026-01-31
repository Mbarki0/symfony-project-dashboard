// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
let all = document.getElementsByClassName("zoomD");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
if (all.length > 0) {
    for (let i of all) {
        i.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
        };
    }
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
