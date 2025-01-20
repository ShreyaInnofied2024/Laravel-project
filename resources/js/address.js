// JavaScript for edit and delete address modals

// Open the modal and populate fields for editing
// Function to open the Edit Address modal and prefill data
function openEditAddressModal(addressId) {
    // Fetch the address data via AJAX (or you can fetch it from DOM if available)
    $.ajax({
        url: '/addresses/' + addressId + '/edit', // Assuming this route is for editing address
        method: 'GET',
        success: function(data) {
            // Prefill the modal with the current address data
            $('#edit_address_id').val(data.address.id); // Set the address ID
            $('#edit_line1').val(data.address.line1); // Prefill Address Line 1
            $('#edit_city').val(data.address.city); // Prefill City
            $('#edit_state').val(data.address.state); // Prefill State
            $('#edit_zip').val(data.address.zip); // Prefill ZIP
            $('#edit_country').val(data.address.country); // Prefill Country

            // Show the modal
            $('#editAddressModal').modal('show');
        },
        error: function() {
            alert("Error fetching address data.");
        }
    });
}


// Open the delete modal and set the address ID
function deleteAddress(id) {
    $('#deleteAddressModal').modal('show');
    $('#deleteAddressBtn').data('id', id);  // Store the address ID on the button
}

// Handle the delete address
$('#deleteAddressBtn').click(function() {
    let addressId = $(this).data('id');
    
    $.ajax({
        url: '/addresses/' + addressId,  // Delete URL with the appropriate route
        type: 'DELETE',
        success: function(response) {
            alert('Address deleted successfully!');
            location.reload();  // Refresh the page to reflect changes
        },
        error: function(response) {
            alert('Error deleting address!');
        }
    });
});
