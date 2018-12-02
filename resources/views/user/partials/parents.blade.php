<div class="form-group">
    <label>Assigned Teacher
        <select id="teacher_id" class="form-control input-sm" name="teacher_id">
            <option value="">None Assigned</option>
       </select>
    </label>
</div>

    @if ($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                @lang('app.update_details')
            </button>
        </div>
    @endif


