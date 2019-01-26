<div class="modal fade" id="selectslotmodal" tabindex="-1" role="dialog" aria-labelledby="selectslotmodallabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="selectslotmodallabel">Apply for this slot?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['route' => ['application.store',$booking->id], 'id' => 'select_slot_form']) !!}
      <div class="modal-body">
        <div class="form-group">
          <label for="day" class="col-form-label">Day:</label>
          <input type="text" class="form-control" id="select_slot_day" name="select_slot_day" disabled>
        </div>
        <div class="form-group">
          <label for="select_slot_date" class="col-form-label">Date:</label>
          <input type="text" class="form-control" id="select_slot_date" name="select_slot_date" disabled>
        </div>
        <div class="form-group">
          <label for="select_slot_slot" class="col-form-label">Slot:</label>
          <input type="text" class="form-control" id="select_slot_slot" name="select_slot_slot" disabled>
        </div>
        <input type="hidden" class="form-control" id="select_slot_slot_id" name="select_slot_slot_id" required>
        <input type="hidden" class="form-control" id="select_slot_date_hidden" name="select_slot_date_hidden" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chose different slot</button>
        <button type="submit" class="btn btn-primary" id="select_slot_form_button">Confirm</button>
      </div>
      </form>
    </div>
  </div>
</div>