<style>
    /* Preloader styles */
    #preloaderMain {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .spinnerMain {
        width: 40px;
        height: 40px;
        border: 4px solid #ddd;
        border-top: 4px solid #007bff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<link rel="icon" href="/images/amazingstakeslogo.ico" type="image/x-icon">

<!-- Preloader -->
<div id="preloaderMain">
    <div class="spinnerMain"></div>
</div>

<script>
    // Hide the preloader after the page loads
    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('preloaderMain').style.display = 'none';
    });
</script>