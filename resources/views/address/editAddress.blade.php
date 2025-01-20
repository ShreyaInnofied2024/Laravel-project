<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editAddressForm" action="{{ route('addresses.update', '') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="editAddressId" name="address_id">
                <div class="modal-body">
                    <!-- Address form fields -->
                    <div class="mb-3">
                        <label for="editLine1" class="form-label">Address Line 1</label>
                        <input type="text" class="form-control" id="editLine1" name="line1" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCity" class="form-label">City</label>
                        <input type="text" class="form-control" id="editCity" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label for="editState" class="form-label">State</label>
                        <input type="text" class="form-control" id="editState" name="state" required>
                    </div>
                    <div class="mb-3">
                        <label for="editZip" class="form-label">ZIP Code</label>
                        <input type="text" class="form-control" id="editZip" name="zip" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCountry" class="form-label">Country</label>
                        <input type="text" class="form-control" id="editCountry" name="country" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
