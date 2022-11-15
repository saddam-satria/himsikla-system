<div class="py-3"> 
    <img id="avatar" class="rounded" src="{{asset("assets/img/user2-160x160.jpg")}}" alt="" width="120">
</div>

<div class="form-group"> 
    <div class="custom-file">
        <input
        type="file"
        class="custom-file-input"
        id="customFile"
        />
        <label id="image-name" class="custom-file-label" for="customFile"
        >Pilih Avatar Profile</label
        >
    </div>
</div>


@push('scripts')

<script>
const imageInput = document.querySelector('input[type=file]');
const avatar = document.querySelector("#avatar");
const defaultImage = avatar.src;
const imageNameLabel = document.querySelector('#image-name');

imageInput.addEventListener("click", (e) => {
    imageInput.addEventListener('change', (e) => {
    const file = e.target.files[0];

    let message = "Pilih Avatar Profile" 
    if(!file || !file.type.includes("image")) {
        avatar.src = defaultImage;
        imageNameLabel.innerText =  message; 
        imageInput.value = "";
        return 
    };
    
    if(file.type === "image/png" || file.type === "image/jpg" || file.type === "image/jpeg" || file.type === "image/svg") {
        imageNameLabel.innerText = file.name;
        avatar.src = URL.createObjectURL(file)
    }
    })
})

</script>

@endpush