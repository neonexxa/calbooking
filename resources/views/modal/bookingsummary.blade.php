<div class="modal fade" id="bookingsummary" tabindex="-1" role="dialog" aria-labelledby="bookingsummaryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingsummaryLabel">Summary</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table>
          
            <tr>
              <td><strong>Applicant Name</strong></td>
              <td id="summary_user_name"></td>
            </tr>
            <tr>
              <td><strong>Contact       </strong></td>
              <td id="summary_user_contact"></td>
            </tr>
            <tr>
              <td><strong>Status        </strong></td>
              <td id="summary_user_status"></td>
            </tr>
            <tr>
              <td><strong>Department    </strong></td>
              <td id="summary_dept">X</td>
            </tr>
            <tr>
              <td><strong>Project       </strong></td>
              <td id="summary_title"></td>
            </tr>
            <tr>
              <td><strong>Cost Center    </strong></td>
              <td id="summary_cost">X</td>
            </tr>
            <tr>
              <td><strong>Supervisor    </strong></td>
              <td id="summary_supervisor_name"></td>
            </tr>
            <tr>
              <td><strong>Equipment    </strong></td>
              <td id="summary_service_equipment_name"></td>
            </tr>
            <tr>
              <td><strong>Requirement Analysis    </strong></td>
              <td id="summary_service_name"></td>
            </tr>
        </table>
        <p>Sample:</p>
        <hr>
        <div id="summary_sample">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="booking_confirm_button">Confirm</button>
      </div>
    </div>
  </div>
</div>