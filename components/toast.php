<style>
    .toast {
        position: fixed;
        bottom: 1rem;
        left: 50%;
        transform: translate(-50%, 0) scale(90%);
        background: #252535;
        padding: 0.8rem 2rem;
        height: fit-content;
        width: fit-content;
        border-radius: 20px;
        opacity: 0;
        color: white;
        transition: 200ms ease-in;
        font-family: "ProductSans", "Product Sans", "Arial";
        z-index: 20;
    }
    .toast.show {
        transition: 200ms ease-out;
        opacity: 0.9;
        transform: translate(-50%, -2rem) scale(100%);
    }

</style>
<div class="toast" id="toast">
    Empty Message
</div>
<div onClick="showToast('Helloo', 1.5)">Hello</div>
<script>
    const toast = document.querySelector("#toast")
    function showToast(toastMessage, duration){
        let showDuration = duration * 1000
        toast.textContent = toastMessage
        toast.classList.add("show")
        setTimeout(function(){ toast.classList.remove("show"); }, showDuration);
    }

</script>