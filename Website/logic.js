function machWas() {
    let text = "Hallo";
    for (let i = 0; i < 100; i++) {
        text = text + i;
    }
    document.getElementById("out").innerHTML = text;
}