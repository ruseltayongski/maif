
 <!-- Success message container -->

<form id="contractForm" method="POST" action="{{ route('facility.update') }}">
<input type="hidden" name="main_id" value="{{ $main_id }}">
    <div class="modal-body">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="social_worker">Social Worker</label>
                    <input type="text" class="form-control" id="social_worker" name="social_worker" value="{{ $facility->social_worker }}" placeholder="Social Worker" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="social_worker_email">Social Worker Email</label>
                    <input type="email" class="form-control" id="social_worker_email" name="social_worker_email" value="{{ $facility->social_worker_email }}" placeholder="Social Worker Email" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="social_worker_contact">Social Worker Contact</label>
                    <input type="text" class="form-control" id="social_worker_contact" name="social_worker_contact" value="{{ $facility->social_worker_contact }}" placeholder="Social Worker Contact" required pattern="63\+\d{10}|\d{11}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="finance_officer">Finance Officer</label>
                    <input type="text" class="form-control" id="finance_officer" name="finance_officer" value="{{ $facility->finance_officer }}" placeholder="Finance Officer" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="finance_officer_email">Finance Officer Email</label>
                    <input type="email" class="form-control" id="finance_officer_email" name="finance_officer_email" value="{{ $facility->finance_officer_email }}" placeholder="Finance Officer Email" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="finance_officer_contact">Finance Officer Contact</label>
                    <input type="text" class="form-control" id="finance_officer_contact" name="finance_officer_contact" value="{{ $facility->finance_officer_contact }}"  placeholder="Finance Officer Contact" required pattern="((63\+)?\d{10}|\d{11})">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="vat">Vat</label>
                    <input type="number" class="form-control" id="vat" name="vat" value="{{ floor($facility->vat) }}" placeholder="Vat" required step="any">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Ewt">Ewt</label>
                    <input type="number" class="form-control" id="Ewt" name="Ewt" value="{{ floor($facility->Ewt) }}" placeholder="Ewt" required step="any">
                </div>
            </div>
      </div>       

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="updateButton" class="btn btn-primary">Update Facility</button>
        </div>
</form>




<script>

document.addEventListener("DOMContentLoaded", function() {
  var cintractForm = document.getElementById("contractForm")
    var updateButton = document.getElementById("updateButton");

    updateButton.addEventListener("click", function(){
       updateButton.disabled = true;

     
        var delay = 3000;
        updateButton.innerText = "Submitting in 3 seconds...";

      setTimeout(function () {
        // Re-enable the button
        updateButton.disabled = false;

        // Reset the button text
        updateButton.innerText = "Update Facility";

        // Submit the form
        contractForm.submit();
      }, delay);
    });
});

// $(document).ready(function() {
//         $('#contractForm').submit(function(e) {
//             e.preventDefault(); // Prevent the default form submission

//             // Simulate form submission delay (e.g., using setTimeout)
//             setTimeout(function() {
//                 // Display the success message
//                 $('#successMessage').show();

//                 // You can also hide the form or close the modal
//                 // $('#registrationModal').hide();
//             }, 2000); // Delay for 2 seconds (adjust as needed)
//         });
//     });

    // document.addEventListener("DOMContentLoaded", function () {
    //     var contractForm = document.getElementById("contractForm");
    //     var submitFormButton = document.getElementById("submitFormButton");

    //     submitFormButton.addEventListener("click", function () {
    //         if (contractForm.checkValidity()) {
    //             // Form is valid
    //             // Display a success message inside the modal
    //             var successMessage = document.createElement("div");
    //             successMessage.classList.add("alert", "alert-success");
    //             successMessage.textContent = "ID {{ $facility->id }} Of Facility updated successfully!";
    //             var modalBody = document.querySelector(".modal-body");
    //             modalBody.appendChild(successMessage);

    //             // Close the modal
    //             $("#yourModalId").modal("hide");
    //         } else {
    //             // Form is not valid, trigger Bootstrap's validation styles
    //             contractForm.classList.add("was-validated");
    //         }
    //     });
    // });





    $(document).ready(function() {
    $('#social_worker_contact, #finance_officer_contact').on('input', function() {
        var input = $(this).val();
        var digits = input.replace(/[^0-9]/g, ''); // Remove non-digits

        if (digits.length < 10 || (input.startsWith('63+') && digits.length !== 12) || (!input.startsWith('63+') && digits.length !== 11)) {
            // Display an error message or add a CSS class to indicate an error
            $(this).addClass('is-invalid');
        } else {
            // Remove the error message or CSS class if it's in the correct format
            $(this).removeClass('is-invalid');
        }
    });
});
</script>
