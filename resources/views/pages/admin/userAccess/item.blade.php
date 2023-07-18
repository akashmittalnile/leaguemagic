<div class="row">
    <div class="col-md-6 p-1">
        <div class="input_radio_box active" id="league_authority_box">
            <input type="radio" class="authority" name="selected" onchange="switchTab('league')" checked
                id="league_authority_text">
            <label class="d-inline" for="league_authority_text">league Authority Options</label>
        </div>
    </div>
    <div class="col-md-6 p-1">
        <div class="input_radio_box" id="club_authority_box">
            <input type="radio" class="authority" name="selected" onchange="switchTab('club')"
                id="club_authority_text">
            <label class="d-inline" for="club_authority_text">club Authority Options</label>
        </div>
    </div>
    <div class="col-md-6 p-1">
        <div class="input_radio_box" id="program_authority_box">
            <input type="radio" class="authority" name="selected" onchange="switchTab('program')"
                id="program_authority_text">
            <label class="d-inline" for="program_authority_text">program Authority Options</label>
        </div>
    </div>
    <div class="col-md-6 p-1">
        <div class="input_radio_box" id="division_authority_box">
            <input type="radio" class="authority" name="selected" onchange="switchTab('division')"
                id="division_authority_text">
            <label class="d-inline" for="division_authority_text">division Authority Options</label>
        </div>
    </div>
    <!-- tabs -->
    <hr>
    <br>
    <div class="col-md-12 containers" id="club_container">
        <div class="form-group">
            <label>Club Administration</label>
            @php
                $club_administrator = array_key_exists('club_administrator', $userAccess) ? $userAccess['club_administrator'] : false;
            @endphp
            <small class="text-secondary font-bold">Is User a Club Administrator</small>
            <ul class="lm-Status-list">
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" @if ($club_administrator) checked @endif
                            id="Club-Yes" name="club_administrator">
                        <label for="Club-Yes">
                            Yes
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" @if (!$club_administrator) checked @endif
                            id="Club-No" name="club_administrator">
                        <label for="Club-No">
                            No
                        </label>
                    </div>
                </li>
            </ul>
        </div>
        <hr>
        <div class="form-group">
            <label>Which Clubs access is required</label>
            <!-- <input type="text" class="form-control" placeholder="Search Club By Name">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         </div> -->
            <div class="w-100">
                <select name="clubs[]" id="clubs" class="form-control" multiple multiselect-search="true">
                    @php
                        $clubs_ = array_key_exists('clubs', $userAccess) ? explode(',', $userAccess['clubs']) : [];
                    @endphp
                    @foreach ($clubs as $item)
                        <option value="{{ $item->id }}" @if (in_array($item->id, $clubs_)) selected @endif>
                            {{ $item->title }}
                        </option>
                    @endforeach

                </select>
            </div>
            <div class="px-2 d-inline"><input type="checkbox" name="clubs[]" value="no" id="clubs_no"
                    @if (in_array('no', $clubs_) || count($clubs_) == 0) selected @endif>
                <label for="clubs_no"> No
                    Clubs</label>
            </div>
            <div class="px-2 d-inline"><input type="checkbox" name="clubs[]" value="all" id="clubs_all"
                    @if (in_array('all', $clubs_)) checked @endif>
                <label for="clubs_all">All
                    Clubs</label>
            </div>

        </div>
    </div>
    <!-- League Container  -->
    <div class="col-md-12 containers" id="league_container">
        <div class="form-group">
            <label>League Administration</label>
            <small class="text-secondary font-bold">Is User a League Administrator</small>
            <ul class="lm-Status-list">
                @php
                    $league_administrator = array_key_exists('league_administrator', $userAccess) ? $userAccess['league_administrator'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="League-administrator-No"
                            @if (!$league_administrator) checked @endif name="league_administrator">
                        <label for="League-administrator-No">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="League-administrator-Yes"
                            @if ($league_administrator) checked @endif name="league_administrator">
                        <label for="League-administrator-Yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>League Certification Agent</label>
            <small class="text-secondary font-bold">Is User a League Certification Agent</small>
            <ul class="lm-Status-list">
                @php
                    $league_certification_agent = array_key_exists('league_certification_agent', $userAccess) ? $userAccess['league_certification_agent'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="league_certification_agent-No"
                            name="league_certification_agent" @if (!$league_certification_agent) checked @endif>
                        <label for="league_certification_agent-No">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="league_certification_agent-Yes"
                            name="league_certification_agent" @if ($league_certification_agent) checked @endif>
                        <label for="league_certification_agent-Yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Player check In</label>
            <small class="text-secondary font-bold">Can User check-in clubs player </small>
            <ul class="lm-Status-list">
                @php
                    $player_check_in = array_key_exists('player_check_in', $userAccess) ? $userAccess['player_check_in'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="player_check_in-no" name="player_check_in"
                            @if ($player_check_in == 1) checked @endif>
                        <label for="player_check_in-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="player_check_in-oher" name="player_check_in"
                            @if (!$player_check_in) checked @endif>
                        <label for="player_check_in-oher">
                            Other Clubs
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="2" id="player_check_in-all" name="player_check_in"
                            @if ($player_check_in == 2) checked @endif>
                        <label for="player_check_in-all">
                            All clubs
                        </label>
                    </div>
                </li>
            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>View Roaster</label>
            <small class="text-secondary font-bold">Can User view All clubs certified Roasters</small>
            <ul class="lm-Status-list">
                @php
                    $view_roster = array_key_exists('view_roster', $userAccess) ? $userAccess['view_roster'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="view_roster-no" name="view_roster"
                            @if (!$view_roster) checked @endif>
                        <label for="view_roster-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="view_roster-yes" name="view_roster"
                            @if ($view_roster) checked @endif>
                        <label for="view_roster-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>League Management</label>
            <small class="text-secondary font-bold">Access Setting Panel</small>
            <ul class="lm-Status-list">
                @php
                    $league_setting_panel = array_key_exists('league_setting_panel', $userAccess) ? $userAccess['league_setting_panel'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="league_setting_panel-no"
                            name="league_setting_panel" @if (!$league_setting_panel) checked @endif>
                        <label for="league_setting_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="league_setting_panel-yes"
                            name="league_setting_panel" @if ($league_setting_panel) checked @endif>
                        <label for="league_setting_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Program Panel</label>
            <ul class="lm-Status-list">
                @php
                    $program_panel = array_key_exists('program_panel', $userAccess) ? $userAccess['program_panel'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="program_panel-no" name="program_panel"
                            @if (!$program_panel) checked @endif>
                        <label for="program_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="program_panel-yes" name="program_panel"
                            @if ($program_panel) checked @endif>
                        <label for="program_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Users Panel</label>
            <ul class="lm-Status-list">
                @php
                    $users_panel = array_key_exists('users_panel', $userAccess) ? $userAccess['users_panel'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="users_panel-no" name="users_panel"
                            @if (!$users_panel) checked @endif>
                        <label for="users_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="users_panel-yes" name="users_panel"
                            @if ($users_panel) checked @endif>
                        <label for="users_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Access Schedule Panel</label>
            <ul class="lm-Status-list">
                @php
                    $schedule_panel = array_key_exists('schedule_panel', $userAccess) ? $userAccess['schedule_panel'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="schedule_panel-no" name="schedule_panel"
                            @if (!$schedule_panel) checked @endif>
                        <label for="schedule_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="schedule_panel-yes" name="schedule_panel"
                            @if ($schedule_panel) checked @endif>
                        <label for="schedule_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Access Score Panel</label>
            <ul class="lm-Status-list">
                @php
                    $score_panel = array_key_exists('score_panel', $userAccess) ? $userAccess['score_panel'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="score_panel-no" name="score_panel"
                            @if (!$score_panel) checked @endif>
                        <label for="score_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="score_panel-yes" name="score_panel"
                            @if ($score_panel) checked @endif>
                        <label for="score_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Access Standings Panel</label>
            <ul class="lm-Status-list">
                @php
                    $standings_panel = array_key_exists('standings_panel', $userAccess) ? $userAccess['standings_panel'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="standings_panel-no" name="standings_panel"
                            @if (!$standings_panel) checked @endif>
                        <label for="standings_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="standings_panel-yes" name="standings_panel"
                            @if ($standings_panel) checked @endif>
                        <label for="standings_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Access Playoff Panel</label>
            <ul class="lm-Status-list">
                @php
                    $playoff_panel = array_key_exists('playoff_panel', $userAccess) ? $userAccess['playoff_panel'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="playoff_panel-no" name="playoff_panel"
                            @if (!$playoff_panel) checked @endif>
                        <label for="playoff_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="playoff_panel-yes" name="playoff_panel"
                            @if ($playoff_panel) checked @endif>
                        <label for="playoff_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Access teams Panel</label>
            <ul class="lm-Status-list">
                @php
                    $teams_panel = array_key_exists('teams_panel', $userAccess) ? $userAccess['teams_panel'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="teams_panel-no" name="teams_panel"
                            @if (!$teams_panel) checked @endif>
                        <label for="teams_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="teams_panel-yes" name="teams_panel"
                            @if ($teams_panel) checked @endif>
                        <label for="teams_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Access players Panel</label>
            <ul class="lm-Status-list">
                <li>
                    @php
                        $players_panel = array_key_exists('players_panel', $userAccess) ? $userAccess['players_panel'] : 0;
                    @endphp
                    <div class="lm-radio">
                        <input type="radio" value="0" id="players_panel-no"
                            @if (!$players_panel) checked @endif name="players_panel">
                        <label for="players_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="players_panel-yes"
                            @if ($players_panel) checked @endif name="players_panel">
                        <label for="players_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Access reports Panel</label>
            <ul class="lm-Status-list">
                <li> @php
                    $reports_panel = array_key_exists('reports_panel', $userAccess) ? $userAccess['reports_panel'] : 0;
                @endphp
                    <div class="lm-radio">
                        <input type="radio" value="0" id="reports_panel-no" name="reports_panel"
                            @if (!$reports_panel) checked @endif>
                        <label for="reports_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="reports_panel-yes" name="reports_panel">
                        <label for="reports_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
        <div class="form-group">
            <label>Access referees Panel</label>
            <ul class="lm-Status-list">
                @php
                    $referees_panel = array_key_exists('referees_panel', $userAccess) ? $userAccess['referees_panel'] : 0;
                @endphp
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="0" id="referees_panel-no" name="referees_panel"
                            @if (!$referees_panel) checked @endif>
                        <label for="referees_panel-no">
                            No
                        </label>
                    </div>
                </li>
                <li>
                    <div class="lm-radio">
                        <input type="radio" value="1" id="referees_panel-yes" name="referees_panel"
                            @if ($referees_panel) checked @endif>
                        <label for="referees_panel-yes">
                            Yes
                        </label>
                    </div>
                </li>

            </ul>
        </div>
        <br>
    </div>
    <!-- Program Container  -->
    <div class="col-md-12 containers" id="program_container">
        <div class="form-group">
            <label>What Sports are you associated with ?</label>

            @php
                $sports_ = array_key_exists('sports', $userAccess) ? explode(',', $userAccess['sports']) : [];
            @endphp
            <div class="p-1">
                <input type="checkbox" value="no" id="program-No" name="sports[]"
                    @if (in_array('no', $sports_) || count($sports_) == 0) checked @endif>
                <label for="program-No">
                    None
                </label>
            </div>

            <div class="p-1">
                <input type="checkbox" value="all" id="program-All" name="sports[]"
                    @if (in_array('all', $sports_)) checked @endif>
                <label for="program-All">
                    All
                </label>
            </div>

            @foreach ($sports as $item)
                <div class="p-1">
                    <input type="checkbox" value="{{ $item->id }}" id="program-{{ $item->id }}"
                        name="sports[]"@if (in_array($item->id, $sports_)) checked @endif>
                    <label for="program-{{ $item->id }}">
                        {{ $item->name }}
                    </label>
                </div>
            @endforeach


        </div>
        <hr>

    </div>
    <!-- division Container  -->
    <div class="col-md-12 containers" id="division_container">
        @php
            $divisions_ = array_key_exists('divisions', $userAccess) ? explode(',', $userAccess['divisions']) : [];
        @endphp
        <div class="form-group">
            <label>Youth Spring Football</label>
            <div class="p-1">
                <input type="checkbox" value="no" id="division-No" name="divisions[]"
                    @if (in_array('no', $divisions_) || count($divisions_) == 0) checked @endif>
                <label for="division-No">
                    None
                </label>
            </div>
            <div class="p-1">
                <input type="checkbox" value="all" id="division-All" name="divisions[]"
                    @if (in_array('all', $divisions_)) checked @endif>
                <label for="division-All">
                    All
                </label>
            </div>

        </div>
        <div class="form-group" id="associated_divisions">
            <label>What Teams are you associated with ?</label>

            <div class="w-100">
                <select name="divisions[]" id="edit-club_divisions" class="form-control" multiple
                    multiselect-search="true">

                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}" @if (in_array($division->id, $divisions_)) selected @endif>
                            {{ $division->name }} </option>

                        @foreach ($levels as $level)
                            <option value="{{ $division->id }}-{{ $level->id }}"
                                @if (in_array($division->id . '-' . $level->id, $divisions_)) selected @endif>{{ $division->name }}
                                {{ $level->name }}</option>

                            @foreach ($groups as $group)
                                <option value="{{ $division->id }}-{{ $level->id }}-{{ $group->id }}"
                                    @if (in_array($division->id . '-' . $level->id . '-' . $group->id, $divisions_)) selected @endif>
                                    {{ $division->name }} {{ $level->name }} {{ $group->name }}</option>
                            @endforeach
                        @endforeach
                    @endforeach



                </select>
            </div>



            </select>
        </div>
        <hr>
        <hr>

    </div>
    <div class="col-md-12">
        <div class="form-group">
            <button class="cancel-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            <button class="save-btn" type="submit">Save & Update</button>
        </div>
    </div>
</div>
