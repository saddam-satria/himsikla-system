<div class="form-group">
    <label for="{{$field}}">{{isset($label) ? $label : "HTM"}}</label><span class="text-danger">*</span>
    <input value="{{isset($updated) ? $updated : old($field)}}"  type="text" name="{{$field}}" id="{{$field}}"  class="form-control field-number" placeholder="{{isset($placeholder) ? $placeholder: ""}}">
  </div>
  @include('components.form_validation', ["field" =>$field])


  @push('scripts')

    <script>
      const fieldNumbers = document.querySelectorAll(".field-number");
      for (let index = 0; index < fieldNumbers.length; index++) {
        const element = fieldNumbers[index];
        element.addEventListener("input", (e) => {
          const {value} = e.target;

          if(!value.match(/^[\d]+$/)){
            e.target.value = "";
            return;
          }
      })
        
      }
    </script>
  @endpush