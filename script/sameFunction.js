
// Function grabs shipping address and uses it as billing address if checkbox is checked
// Also, billing form is hidden if checkbox is checked
function sameFunction() {
    
    //Grab all relevant elements
    var checkBox = document.getElementById("SameAdd");
    // var shipping = document.getElementById('shipping')
    //     .querySelectorAll("input");
    // var billing = document.getElementById('billing')
    //     .querySelectorAll("input");
    var bill = document.getElementById('billing');

    // Check status of checkbox
    if (checkBox.checked) {
        // for (let i = 0; i < shipping.length; i++) {
        //     billing[i].value = shipping[i].value;
        // }
        bill.style.display = "none";

    // Show form
    } else {
        bill.style.display = "block";
    }

}