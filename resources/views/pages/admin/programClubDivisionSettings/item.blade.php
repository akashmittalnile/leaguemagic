@if (count($programClubDivisions))

    @foreach ($programClubDivisions as $i => $item)
        <div class="col-md-12 pt-3">
            <div class="form-group">

                <label for="" class="bg-light rounded-pill border p-2">{{ $item->combinedDivision() }}</label>
                <input type="hidden" name="program_club_division_id{{ $i }}" value="{{ $item->id }}">

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Division Age Group</label>
                <select name="age_group{{ $i }}[]" class="form-control" multiple multiselect-search="true"
                    required>

                    @foreach ([4, 5, 6, 7, 8, 9, 10, 11, 12, 13] as $age)
                        <option value="{{ $age }}" @if (in_array($age, explode(',', $item->programClubDivisionSetting->age_group))) selected @endif>
                            {{ $age }}</option>
                    @endforeach


                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Playdown Age Group</label>
                <select name="playdown_age_group{{ $i }}[]" class="form-control" multiple
                    multiselect-search="true" required>

                    @foreach ([4, 5, 6, 7, 8, 9, 10, 11, 12, 13] as $age)
                        <option value="{{ $age }}" @if (in_array($age, explode(',', $item->programClubDivisionSetting->playdown_age_group))) selected @endif>
                            {{ $age }}</option>
                    @endforeach


                </select>
            </div>
        </div>
        <hr>
    @endforeach
@endif
