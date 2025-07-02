<header class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">
        {{ __('Update Profile') }}
    </h2>
    <p class="text-sm text-gray-500">Upload a new profile picture</p>
</header>

<form action="{{ route('profile.profilepic') }}" method="POST" id="form" enctype="multipart/form-data" class="bg-white shadow-sm rounded-xl p-6 space-y-4">
    @csrf
    <div>
        <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">
            Profile Picture
        </label>
        <input
            type="file"
            name="profile_picture"
            id="profile_picture"
            accept="image/*"
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        @error('profile_picture')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="my-4">
        <img id="cropper-preview" style="max-width: 100%; max-height: 300px; display: none; border-radius: 1rem;">
    </div>
    <div>
        <button type="submit" name="saveimage" class="btn btn-secondary">Upload</button>
    </div>
    @if(auth()->check() && auth()->user()->profile_picture)
        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover mt-4">
    @else
        <p>No profile picture</p>
    @endif
</form>

@push('scripts')
<script>
$(document).ready(function() {
    // Validate the profile picture form
    $('form').validate({
        rules: {
            profile_picture: {
                required: true,
                extension: "jpg|jpeg|png|gif|svg|webp"
            }
        },
        messages: {
            profile_picture: {
                required: "Please select a profile picture.",
                extension: "Please upload a valid image file (jpg, jpeg, png, gif, svg, webp)."
            }
        },
        errorClass: 'text-danger',
        errorElement: 'div',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }
    });
});

let cropper;
const input = document.getElementById('profile_picture');
const preview = document.getElementById('cropper-preview');

input.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(event) {
        preview.src = event.target.result;
        preview.style.display = 'block';
        if (cropper) cropper.destroy();
        cropper = new Cropper(preview, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
        });
    };
    reader.readAsDataURL(file);
});

// Add a preview image for cropped result if not present
if (!document.getElementById('photo-preview')) {
    const photoPreview = document.createElement('img');
    photoPreview.id = 'photo-preview';
    photoPreview.style = 'max-width: 100%; max-height: 300px; display: none; border-radius: 1rem; margin-top: 1rem;';
    preview.parentNode.appendChild(photoPreview);
}

function cropImageAndSetInput() {
    if (cropper) {
        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
        });
        // Update preview
        const photoPreview = document.getElementById('photo-preview');
        photoPreview.src = canvas.toDataURL();
        photoPreview.style.display = 'block';
        // Convert to Blob and assign to file input
        canvas.toBlob(function (blob) {
            const fileInput = document.getElementById('profile_picture');
            const newFile = new File([blob], "profile.png", { type: "image/png" });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(newFile);
            fileInput.files = dataTransfer.files;
        }, 'image/png');
    }
}

// On form submit, replace file with cropped image
const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
    if (cropper) {
        e.preventDefault();
        cropper.getCroppedCanvas({
            width: 300,
            height: 300,
            imageSmoothingQuality: 'high'
        }).toBlob(function(blob) {
            const formData = new FormData(form);
            formData.set('profile_picture', blob, 'profile_picture.png');
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            }).then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    window.location.reload();
                }
            });
        }, 'image/png');
    }
});

// Remove Crop & Set button logic if present
// Add onclick event to the Upload button to handle cropping and uploading
const uploadBtn = document.querySelector('button[type="submit"][name="saveimage"]');
if (uploadBtn) {
    uploadBtn.addEventListener('click', function(e) {
        if (cropper) {
            e.preventDefault();
            cropper.getCroppedCanvas({
                width: 300,
                height: 300,
                imageSmoothingQuality: 'high'
            }).toBlob(function(blob) {
                const fileInput = document.getElementById('profile_picture');
                const newFile = new File([blob], "profile.png", { type: "image/png" });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(newFile);
                fileInput.files = dataTransfer.files;
                // Now submit the form
                fileInput.form.submit();
            }, 'image/png');
        }
    });
}
</script>
@endpush
