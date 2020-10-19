    <div id="scanner">
        <div class="row">
            <div class="col">
                <button class="btn btn-danger" id="camera_start">Open Camera</button>
            </div>
        </div>
        <div class="row mt-2 text-center">
            <div class="col">
                <div id="camera_closed">
                    <strong>Camera Closed</strong>
                </div>
                <div id="camera_preview">
                    <video src="" id="preview" width="100%"></video>
                </div>
            </div>
        </div>
    </div>
    
@push('after-scripts')
<script type="text/javascript" src="{{ asset('/js/vendor/instascan.min.js') }}" ></script>
<script>
    var scan_active = false;
    var scan_result = '';

    var scanner = new Instascan.Scanner(
        {
            video: document.getElementById('preview'),
            mirror: false,
        }
    );

    scanner.addListener('scan', function(content) {
        if (content) {
            $('#camera_preview').hide();
            $('#camera_closed').show();
            scan_result = content
            scanner.stop();
            $('#camera_start').removeAttr('disabled')
            let _token = $('meta[name="csrf-token"]').attr('content')
            let code = scan_result
            if (scan_result) {
                $.ajax({
                    url: window.location.origin + '/scan',
                    method: 'post',
                    data: {_token, code},
                    success: function(response) {
                        Swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Scan Berhasil',
                            showConfirmButton: false,
                            timer: 2000,
                            text: 'Absensi sudah di input',
                            width: 300
                        })
                        // console.log(response)
                    }
                })
            }
        }
    });

    scanner.addListener('active', function(){
        scan_active = true;
    })

    scanner.addListener('inactive', function(){
        scan_active = false;
    })

    function startCamera() {
        Instascan.Camera.getCameras().then(cameras => {
            if(cameras.length > 0){
                if (!scan_active) {
                    if(cameras[1]){ 
                        scanner.start(cameras[1]); 
                    } else { 
                        scanner.start(cameras[0]); 
                    }
                }
            } else {
                console.error("Please enable Camera!");
            }
        });
    }
    

    if (scanner) {
        $('#camera_start').click(function(){
            $(this).attr('disabled', true)
            $('#camera_preview').show();
            $('#camera_closed').hide();
            startCamera()
        });
    }
</script>
@endpush
