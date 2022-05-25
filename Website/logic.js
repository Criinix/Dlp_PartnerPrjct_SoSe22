function machWas() {
    let text = "Hallo";
    for (let i = 0; i < 100; i++) {
        text = text + i;
    }
    document.getElementById("out").innerHTML = text;
}

function callWebpage(urlI) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", urlI, true);
    xhr.send();

    // Callback-funktion - Anfang ------------------
    // (wird aufgerufen sobald Antwort vom Server da)
    xhr.onreadystatechange = function() {
        console.log('ready');
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText !== '') {
                if (this.responseText < 0) {
                    testState = -1;
                    console.log("Error: " + this.responseText);
                    document.getElementById('state').innerHTML = "Error: " + this.responseText;
                } else
                    document.getElementById('state').innerHTML = this.responseText;
            }
        } else {
            console.log('timeout');
        }
    };
}
// Callback-funktion - Ende ---------------------