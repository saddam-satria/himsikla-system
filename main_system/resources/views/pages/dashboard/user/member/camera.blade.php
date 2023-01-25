@extends('layouts.main')

<div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center py-5 px-5">
            <div id="reader" style="width: 360px" class="border border-primary rounded shadow">
            </div>
            <span class="info-message my-3 text-capitalize"></span>
        </div>
        
</div>



@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.2.1/html5-qrcode.min.js" integrity="sha512-cuVnjPNH3GyigomLiyATgpCoCmR9T3kwjf94p0BnSfdtHClzr1kyaMHhUmadydjxzi1pwlXjM5sEWy4Cd4WScA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    const infoMessage = document.querySelector(".info-message");
    
    const scanning = (cameraId) => {
        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
        {facingMode: { exact: "environment"}},
        {
            fps: 10,    
            qrbox: { width: 180, height: 180 },
            
        },
        (decodedText, decodedResult) => {
            infoMessage.innerText = "berhasil scan"
            window.location.href = decodedResult;
        },
        (errorMessage) => {
           infoMessage.innerText = "Kode QR tidak terdeteksi";
        })
        .catch((err) => {
            infoMessage.innerText = err;
        });
    }

   
    (() => {
        infoMessage.innerText = "Tunggu Sebentar"
        Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            cameraId = devices[0].id;
            
            scanning(cameraId && cameraId);
            infoMessage.innerText = "Mulai Scan Kode Qr"
        }
        }).catch(err => {
            infoMessage.innerText = "terjadi kesalahan pada kamera";
        }); 
    })()


</script>
    
@endpush