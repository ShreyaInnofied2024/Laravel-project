<div class="modal fade" id="deleteAddressModal" tabindex="-1" aria-labelledby="deleteAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAddressModalLabel">Delete Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this address?
            </div>
            <div class="modal-footer">
                <form id="deleteAddressForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteAddressModal');

    // Listen for the modal's hide event (when it is closed)
    deleteModal.addEventListener('hide.bs.modal', function () {
        // Refresh the page when the modal is closed
        location.reload();
    });
});

function deleteAddress(id) {
    // Set the form action with the correct ID
    const deleteForm = document.getElementById('deleteAddressForm');
    deleteForm.action = `/addresses/delete/${id}`; // Ensure this matches your route

    // Open the modal
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteAddressModal'));
    deleteModal.show();
}
</script>
