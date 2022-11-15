<div class="py-3">
    <img src="{{isset($defaultImage) && !is_null($defaultImage) ? $defaultImage : "https://ui-avatars.com/api/?name=img&size=280"}}" alt="" id="{{$field . "-" . "preview"}}" class="image-preview  img-thumbnail" width="320"/>
  </div>
  <div class="input-group py-2">
    <div class="custom-file">
      <input
        type="file"
        class="custom-file-input image-input"
        id="{{$field}}"
        name="{{$field}}"
      />
      <label
        class="custom-file-label  label-input-file""
        for="{{$field}}"
        id="${{$field ."-". "label"}}"
        >{{isset($label) ? $label : "Pilih File"}}</label
      >
    </div>
  </div>
  @include('components.form_validation', ["field" => $field])
  
  @push('scripts')
      <script>
        const customImage= document.querySelector('.image-input');
        const imagePreview = document.querySelector(".image-preview")
        const labelInputImage = document.querySelector(".label-input-file");
        const defaultImage = imagePreview.src;


        customImage.addEventListener("input", (e) => {
            customImage.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if(!file) {
              labelInputImage.innerText= "Pilih File"
              imagePreview.src = defaultImage;
              return;
            };
            imagePreview.src = URL.createObjectURL(file);
            labelInputImage.innerText = file.name;
            })
        })
      </script>

  @endpush