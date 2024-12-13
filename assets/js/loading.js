let loading = document.getElementById("loading");

setTimeout(() => {
    loading.classList.add("opacity-0");    
    loading.classList.remove("opacity-100");
    setTimeout(() => {
        document.body.classList.remove("overflow-hidden");
        loading.style.display = "none";
    }, 500);
}, 300);