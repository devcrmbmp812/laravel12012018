<div class="form-group">
    <label>Job Position
        <select id="position_id" class="form-control input-sm" name="position_id">
            <option value="">None Assigned</option>
            @foreach($positions as $position)
            <option value="{{ $position->id }}">{{ $position->position_title}}</option>
            @endforeach
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


