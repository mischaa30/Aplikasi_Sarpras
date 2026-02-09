@extends(
    auth()->user()->role->nama_role === 'admin'
        ? 'layouts.admin'
        : 'layouts.petugas'
)

@section('title','Scanner QR Pengembalian')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid mt-3">
<h3 class="mb-4 text-primary fw-semibold">📱 Scanner QR Pengembalian</h3>

<div class="row justify-content-center">
<div class="col-md-6">

<div class="card shadow-sm">
<div class="card-body text-center">

<div style="position:relative;background:#000;border-radius:8px;overflow:hidden">
<video id="video" autoplay playsinline style="width:100%"></video>
<canvas id="canvas" style="display:none"></canvas>

<div style="
position:absolute;
top:50%;
left:50%;
transform:translate(-50%,-50%);
width:220px;
height:220px;
border:3px solid #4CAF50;
border-radius:10px;">
</div>
</div>

<p class="mt-3 text-muted">
Arahkan kamera ke QR bukti peminjaman
</p>

<button onclick="startCamera()" class="btn btn-primary btn-sm">
Start Kamera
</button>

<div id="status" class="mt-3"></div>

<div id="result" class="alert alert-info mt-3" style="display:none">
QR terdeteksi — membuka data...
</div>

</div>
</div>

<div class="mt-3 text-center">

@if(auth()->user()->role->nama_role === 'admin')
<a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">
Back
</a>
@else
<a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-outline-secondary">
Back
</a>
@endif

</div>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

<script>

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
const statusBox = document.getElementById('status');
const resultBox = document.getElementById('result');

let streamRef = null;
let scanning = false;

async function startCamera() {

stopCamera();
statusBox.innerHTML = "Memulai kamera...";

try {

streamRef = await navigator.mediaDevices.getUserMedia({
video: { facingMode: "environment" }
});

} catch {

streamRef = await navigator.mediaDevices.getUserMedia({
video: true
});

}

video.srcObject = streamRef;

video.onloadedmetadata = () => {

video.play();
canvas.width = video.videoWidth;
canvas.height = video.videoHeight;

scanning = true;

statusBox.innerHTML =
'<div class="text-success">✓ Kamera aktif — scanning...</div>';

scanLoop();
};
}

function scanLoop() {

if(!scanning) return;

if(video.readyState === video.HAVE_ENOUGH_DATA) {

ctx.drawImage(video,0,0);

const img = ctx.getImageData(0,0,canvas.width,canvas.height);

const code = jsQR(img.data,img.width,img.height);

if(code){
scanning = false;
handleQR(code.data);
return;
}

}

requestAnimationFrame(scanLoop);
}

function handleQR(text){

resultBox.style.display = 'block';

let payload;

try {
payload = JSON.parse(text);
} catch {
payload = { raw: text };
}

fetch("{{ request()->is('admin/*')
        ? route('admin.pengembalian.scan')
        : route('petugas.pengembalian.scan') }}", {
method:"POST",
headers:{
"Content-Type":"application/json",
"X-CSRF-TOKEN":
document.querySelector('meta[name="csrf-token"]').content
},
body: JSON.stringify(payload)
})
.then(r=>r.json())
.then(res=>{

if(!res.success)
throw new Error(res.message);

window.location.href =
"{{ request()->is('admin/*')
    ? url('/admin/pengembalian')
    : url('/petugas/pengembalian') }}/" + res.peminjaman_id;

})
.catch(err=>{

statusBox.innerHTML =
'<div class="alert alert-danger">'+err.message+'</div>';

resultBox.style.display = 'none';
scanning = true;
scanLoop();

});
}

function stopCamera(){
if(streamRef){
streamRef.getTracks().forEach(t=>t.stop());
streamRef = null;
}
}

window.addEventListener('beforeunload',stopCamera);

startCamera();

</script>

@endsection
