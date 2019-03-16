<div class="modal fade" id="addsample" tabindex="-1" role="dialog" aria-labelledby="addsampleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addsampleLabel">New sample</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['route' => ['sample.store',$booking->id]]) !!}
      <div class="modal-body">
        <div class="form-group">
          <label for="add_sample_type" class="col-form-label">Type:</label>
          <input type="text" class="form-control" id="add_sample_type" name="add_sample_type" required>
        </div>
        <div class="form-group">
          <label for="add_sample_name" class="col-form-label">Name:</label>
          <input type="text" class="form-control" id="add_sample_name" name="add_sample_name" required>
        </div>
        <div class="form-group">
          <label for="add_sample_method" class="col-form-label">Method:</label>
          <input type="text" class="form-control" id="add_sample_method" name="add_sample_method" required>
        </div>
        <div class="form-group">
          <label for="add_sample_remark" class="col-form-label">Remark:</label>
          <textarea class="form-control" id="add_sample_remark" name="add_sample_remark" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="add_sample_form_button">Add Sample</button>
      </div>
      </form>
    </div>
  </div>
</div>