<div class="modal fade" id="editsample" tabindex="-1" role="dialog" aria-labelledby="editsample" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editsample">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="edit_sample_form">
      <div class="modal-body">
        <div class="form-group">
          <label for="edit_sample_type" class="col-form-label">Type:</label>
          <input type="text" class="form-control" id="edit_sample_type" name="edit_sample_type" required>
        </div>
        <div class="form-group">
          <label for="edit_sample_name" class="col-form-label">Name:</label>
          <input type="text" class="form-control" id="edit_sample_name" name="edit_sample_name" required>
        </div>
        <div class="form-group">
          <label for="edit_sample_method" class="col-form-label">Method:</label>
          <input type="text" class="form-control" id="edit_sample_method" name="edit_sample_method" required>
        </div>
        <div class="form-group">
          <label for="edit_sample_remark" class="col-form-label">Remark:</label>
          <textarea class="form-control" id="edit_sample_remark" name="edit_sample_remark" required></textarea>
        </div>
        <input type="hidden" class="form-control" id="edit_sample_id" name="edit_sample_id" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit_sample_form_button">Update Sample</button>
      </div>
      </form>
    </div>
  </div>
</div>