@if(!empty($candidates))
    @foreach($candidates as $candidate)
    <div class="SiLKscore">
        <div class="SiLKscore-label">
            {{$candidate["label"]}}
        </div>
        <div class="SiLKscore-button">
            <button title="@lang('alignment/createlinks.pick-button-title')" class="btn-xs btn-primary"onclick="click_button('{{$candidate["target"]}}')">@lang('alignment/createlinks.pick-button-label')</button>
        </div>
        <div class="SiLKscore-progress progress">
            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{{round((float)$candidate["score"]*100, 2)}}" aria-valuemin="0" aria-valuemax="100" style="width:{{round((float)$candidate["score"]*100,2)}}%"></div>
            {{round((float)$candidate["score"]*100,2)}}%
        </div>
    </div>
    @endforeach
@else
    @lang('alignment/createlinks.no-scores')
@endif    