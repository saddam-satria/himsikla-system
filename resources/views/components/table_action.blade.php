<div class="d-flex">
    <div>
        <a href="{{route("dashboard" . ".admin." . $field . "." . "edit", [$field => $id] )}}" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-pen"></i>
        </a>
    </div>
    <div class="px-2">
        <a href="{{route("dashboard" . ".admin." . $field . "." . "show", [$field => $id] )}}" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-eye"></i>        
        </a>
    </div>
    <form action="{{route("dashboard" . ".admin." . $field . "." . "destroy", [$field => $id] )}}" method="POST">
        @csrf
        @method("DELETE")
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
</div>