<div class="modal fade zoom" tabindex="-1" id="qr-scanner">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <center>
                <div id="qr-reader" style="width: auto"></div>
                <div id="qr-reader-results"></div>
            </center>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        search(decodedText);
        html5QrCode.stop().then(() => { // Stop the scanning
            console.log("QR Code scanning stopped.");
        }).catch(err => {
            console.error("Error stopping QR Code scanning: ", err);
        });
        closeModal(); 
    }

    let html5QrCode = new Html5Qrcode("qr-reader");

    function qr_scan() {
        html5QrCode.start({
                facingMode: "environment"
            }, {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            onScanSuccess
        ).catch(err => {

        });
    }

    function closeModal() {
        var modalElement = document.getElementById('qr-scanner');
        var modalInstance = bootstrap.Modal.getInstance(modalElement); // Get the Bootstrap modal instance

        if (!modalInstance) {
            modalInstance = new bootstrap.Modal(modalElement); // Initialize modal if it's not already initialized
        }

        modalInstance.hide(); // Close the modal
    }
</script>
